<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDOException;

/**
 * Order Controller
 * 
 * Sipariş işlemlerini yönetir.
 * Checkout ve Sipariş kaydı işlemlerini içerir.
 */
class OrderController extends Controller {

    public function __construct() {
        // Sipariş verebilmek için giriş yapmış olmak zorunlu
        AuthMiddleware::authCheck();
    }

    /**
     * Checkout işlemini gerçekleştirir.
     * Transaction kullanarak bütünlüğü sağlar.
     */
    public function checkout() {
        // Sepet boşsa işlem yapma
        if (empty($_SESSION['cart'])) {
            $this->redirect('/eticaret_proje/public/cart');
        }

        // Veritabanı bağlantısını al (Model üzerinden veya direkt Database sınıfından)
        // Transaction işlemleri için bağlantı nesnesine ihtiyacımız var.
        $db = Database::getInstance()->getConnection();

        try {
            // 1. Transaction Başlat
            $db->beginTransaction();

            // Toplam tutarı hesapla
            $totalPrice = 0;
            foreach ($_SESSION['cart'] as $item) {
                // Fiyatı çarparken ürünün o anki fiyatını kullanıyoruz.
                // İdealde tekrar DB'den fiyat kontrolü yapılmalı ama 
                // CartController'da eklerken güncel fiyatı aldığımızı varsayıyoruz.
                $totalPrice += $item['price'] * $item['quantity'];
            }

            // 2. Orders tablosuna ekle
            $sqlOrder = "INSERT INTO orders (user_id, total_price, status) VALUES (:user_id, :total_price, 'pending')";
            $stmtOrder = $db->prepare($sqlOrder);
            $stmtOrder->execute([
                ':user_id' => $_SESSION['user_id'],
                ':total_price' => $totalPrice
            ]);

            // Oluşan Sipariş ID'sini al
            $orderId = $db->lastInsertId();

            if (!$orderId) {
                throw new PDOException("Sipariş oluşturulamadı.");
            }

            // 3. Order Items tablosuna ekle
            $sqlItem = "INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (:order_id, :product_id, :quantity, :price)";
            $stmtItem = $db->prepare($sqlItem);

            foreach ($_SESSION['cart'] as $item) {
                $stmtItem->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['id'],
                    ':quantity' => $item['quantity'],
                    ':price' => $item['price']
                ]);
                
                // Opsiyonel: Stoktan düşme işlemi de burada yapılabilir.
                // $db->exec("UPDATE products SET stock = stock - {$item['quantity']} WHERE id = {$item['id']}");
            }

            // 4. Commit - İşlemleri onayla ve veritabanına yaz
            $db->commit();

            // 5. Sepeti Temizle
            unset($_SESSION['cart']);

            // 6. Başarı Sayfasına Yönlendir
            // Sipariş ID'sini parametre veya session ile başarı sayfasına taşıyabiliriz.
            $this->view('orders/success', ['order_id' => $orderId]);

        } catch (PDOException $e) {
            // Hata Durumu: Rollback 
            // Yapılan tüm değişiklikleri geri al
            $db->rollBack();
            
            // Kullanıcıya hatayı göster
            die("Sipariş oluşturulurken bir hata meydana geldi: " . $e->getMessage());
        }
    }
    
    /**
     * Kullanıcının geçmiş siparişlerini listeler.
     */
    public function myOrders() {
        $db = Database::getInstance()->getConnection();
        
        $sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute([':user_id' => $_SESSION['user_id']]);
        $orders = $stmt->fetchAll();
        
        $this->view('orders/my_orders', ['orders' => $orders]);
    }
}
