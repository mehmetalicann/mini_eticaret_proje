<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Core\Database;
use PDO;

/**
 * Admin Order Controller
 * 
 * Admin paneli sipariş yönetimi işlemlerini içerir.
 */
class AdminOrderController extends Controller {

    public function __construct() {
        // Sadece admin erişebilir
        AuthMiddleware::adminCheck();
    }

    /**
     * Tüm siparişleri listeler.
     */
    public function index() {
        $db = Database::getInstance()->getConnection();

        // Siparişleri kullanıcı bilgileriyle (JOIN) birlikte çek
        $sql = "SELECT orders.*, users.ad, users.soyad 
                FROM orders 
                JOIN users ON orders.user_id = users.id 
                ORDER BY orders.created_at DESC";
        
        $stmt = $db->query($sql);
        $orders = $stmt->fetchAll();

        $this->view('admin/orders/index', ['orders' => $orders]);
    }

    /**
     * Sipariş detaylarını gösterir.
     * @param int $id Sipariş ID
     */
    public function show($id) {
        $db = Database::getInstance()->getConnection();

        // 1. Sipariş genel bilgilerini al
        $sqlOrder = "SELECT orders.*, users.ad, users.soyad, users.email 
                     FROM orders 
                     JOIN users ON orders.user_id = users.id 
                     WHERE orders.id = :id";
        $stmtOrder = $db->prepare($sqlOrder);
        $stmtOrder->execute([':id' => $id]);
        $order = $stmtOrder->fetch();

        if (!$order) {
            die("Sipariş bulunamadı.");
        }

        // 2. Sipariş kalemlerini (ürünleri) al
        $sqlItems = "SELECT order_items.*, products.name, products.image_url 
                     FROM order_items 
                     JOIN products ON order_items.product_id = products.id 
                     WHERE order_items.order_id = :id";
        $stmtItems = $db->prepare($sqlItems);
        $stmtItems->execute([':id' => $id]);
        $items = $stmtItems->fetchAll();

        $this->view('admin/orders/show', [
            'order' => $order,
            'items' => $items
        ]);
    }

    /**
     * Sipariş durumunu günceller.
     * @param int $id Sipariş ID
     */
    public function updateStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $status = $_POST['status']; // 'pending', 'completed', 'cancelled'

            // Geçerli bir durum mu? (Basit enum kontrolü)
            $allowedStatuses = ['pending', 'completed', 'cancelled'];
            if (!in_array($status, $allowedStatuses)) {
                die("Geçersiz durum.");
            }

            $db = Database::getInstance()->getConnection();
            $sql = "UPDATE orders SET status = :status WHERE id = :id";
            $stmt = $db->prepare($sql);
            
            if ($stmt->execute([':status' => $status, ':id' => $id])) {
                // Detay sayfasına geri dön
                $this->redirect("/eticaret_proje/public/admin/orders/show/$id");
            } else {
                die("Durum güncellenemedi.");
            }
        }
    }
}
