<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * Home Controller
 * 
 * Anasayfa işlemlerini yönetir. Ürünlerin listelenmesi burada yapılır.
 */
class HomeController extends Controller {

    /**
     * Anasayfayı görüntüler.
     * Tüm ürünleri çeker ve view'a gönderir.
     */
    public function index() {
        // Product modelini yükle
        $productModel = $this->model('Product');
        
        // Tüm ürünleri veritabanından getir
        $products = $productModel->getAll();

        // View'ı yükle ve ürünleri gönder
        $this->view('home/index', ['products' => $products]);
    }

    /**
     * Ürün detay sayfasını görüntüler.
     * @param int $id Ürün ID
     */
    public function product($id) {
        $productModel = $this->model('Product');
        $product = $productModel->getById($id);

        if (!$product) {
            die("Ürün bulunamadı.");
        }

        $this->view('home/product_detail', ['product' => $product]);
    }
}
