<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * Cart Controller
 * 
 * Sepet işlemlerini Session kullanarak yönetir.
 * Veritabanı yerine $_SESSION['cart'] kullanılır.
 */
class CartController extends Controller {

    public function __construct() {
        // Session başlatılmış mı kontrol et
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Sepet dizisi yoksa oluştur
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Sepet sayfasını gösterir.
     */
    public function index() {
        // Sepetteki ürünlerin detaylarını ve toplam tutarı hesapla
        $cartItems = $_SESSION['cart'];
        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        $this->view('cart/index', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice
        ]);
    }

    /**
     * Sepete ürün ekler.
     * Formdan POST ile gelen product_id'yi kullanır.
     */
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['product_id'];
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            // Ürün bilgilerini veritabanından çek (Güvenlik ve güncel fiyat için)
            $productModel = $this->model('Product');
            $product = $productModel->getById($productId);

            if ($product) {
                // Eğer ürün zaten sepetteyse, sadece miktarını artır
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    // Sepette yoksa yeni ekle
                    $_SESSION['cart'][$productId] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'image_url' => $product['image_url'],
                        'quantity' => $quantity
                    ];
                }
            }

            // Sepet sayfasına veya geldiği sayfaya yönlendir
            $this->redirect('/eticaret_proje/public/cart');
        }
    }

    /**
     * Sepetteki ürün miktarını günceller.
     * Artırma ve azaltma işlemleri için kullanılır.
     */
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['product_id'];
            $action = $_POST['action']; // 'increase' veya 'decrease'

            if (isset($_SESSION['cart'][$productId])) {
                if ($action === 'increase') {
                    $_SESSION['cart'][$productId]['quantity']++;
                } elseif ($action === 'decrease') {
                    $_SESSION['cart'][$productId]['quantity']--;
                    
                    // Miktar 0 veya altına düşerse ürünü sepetten çıkar
                    if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
                        unset($_SESSION['cart'][$productId]);
                    }
                }
            }

            $this->redirect('/eticaret_proje/public/cart');
        }
    }

    /**
     * Ürünü sepetten tamamen siler.
     * @param int $id Ürün ID (Url parametresi olarak gelebilir veya POST ile)
     * Burada basitlik adına POST/GET karışık kullanıyoruz, route yapısına göre değişir.
     * Biz POST ile remove action'ı üzerinden gidelim.
     */
    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $productId = $_POST['product_id'];
             if (isset($_SESSION['cart'][$productId])) {
                 unset($_SESSION['cart'][$productId]);
             }
             $this->redirect('/eticaret_proje/public/cart');
        }
    }

    /**
     * Sepeti tamamen temizler.
     */
    public function clear() {
        $_SESSION['cart'] = [];
        $this->redirect('/eticaret_proje/public/cart');
    }
}
