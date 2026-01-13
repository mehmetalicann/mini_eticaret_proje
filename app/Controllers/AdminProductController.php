<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;

/**
 * Admin Product Controller
 * 
 * Ürün yönetim işlemlerini (Admin Paneli) yönetir.
 */
class AdminProductController extends Controller {

    public function __construct() {
        // Sadece adminlerin erişebilmesi için middleware kontrolü
        // Constructor içinde çağrıldığında, bu class'ın her metodundan önce çalışır.
        AuthMiddleware::adminCheck();
    }

    /**
     * Tüm ürünleri listeler (Admin Dashboard veya Ürün Listesi Sayfası).
     */
    public function index() {
        $productModel = $this->model('Product');
        $products = $productModel->getAll();

        $this->view('admin/products/index', ['products' => $products]);
    }

    /**
     * Yeni ürün ekleme formunu gösterir.
     */
    public function create() {
        $this->view('admin/products/create');
    }

    /**
     * Ürün ekleme işlemini gerçekleştirir (POST).
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // Verileri al
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'image_url' => null // Varsayılan boş
            ];

            // Görsel Yükleme İşlemi
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadDir = '../public/uploads/';
                
                // Klasör yoksa oluştur (Garanti olsun)
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = $_FILES['image']['name'];
                $fileTmp = $_FILES['image']['tmp_name'];
                $fileType = $_FILES['image']['type']; // image/jpeg, image/png
                
                // Uzantıyı al
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // İzin verilen uzantılar
                $allowed = ['jpg', 'jpeg', 'png'];

                if (in_array($fileExt, $allowed)) {
                    // Benzersiz isim oluştur: uniqid() + zaman damgası
                    $newFileName = uniqid('prod_', true) . '.' . $fileExt;
                    $destination = $uploadDir . $newFileName;

                    if (move_uploaded_file($fileTmp, $destination)) {
                        // Veritabanına kaydedilecek yol (public klasörü web root olduğu için 'uploads/...' yeterli olabilir ama
                        // view tarafında nasıl kullanacağımıza bağlı. Genelde 'uploads/dosya.jpg' yazarız.)
                        $data['image_url'] = 'uploads/' . $newFileName;
                    } else {
                        die("Dosya yüklenirken bir hata oluştu.");
                    }
                } else {
                    die("Sadece JPG ve PNG dosyalarına izin verilir.");
                }
            }

            // Modeli çağır ve kaydet
            $productModel = $this->model('Product');
            if ($productModel->create($data)) {
                $this->redirect('/eticaret_proje/public/admin/products');
            } else {
                die("Ürün eklenirken veritabanı hatası oluştu.");
            }
        }
    }

    /**
     * Düzenleme formunu gösterir.
     * @param int $id
     */
    public function edit($id) {
        $productModel = $this->model('Product');
        $product = $productModel->getById($id);

        if (!$product) {
            die("Ürün bulunamadı.");
        }

        $this->view('admin/products/edit', ['product' => $product]);
    }

    /**
     * Güncelleme işlemini yapar (POST).
     * @param int $id
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productModel = $this->model('Product');
            
            // Mevcut ürün bilgisini al (Eski resim url'i için)
            $currentProduct = $productModel->getById($id);

            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'image_url' => $currentProduct['image_url'] // Varsayılan eski resim
            ];

            // Yeni resim yüklendi mi?
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                // ... (Yukarıdaki upload kodunun aynısı - normalde bir UploadHelper sınıfına taşınmalı)
                $uploadDir = '../public/uploads/';
                $fileName = $_FILES['image']['name'];
                $fileTmp = $_FILES['image']['tmp_name'];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png'];

                if (in_array($fileExt, $allowed)) {
                    $newFileName = uniqid('prod_', true) . '.' . $fileExt;
                    if (move_uploaded_file($fileTmp, $uploadDir . $newFileName)) {
                        
                        // Eski resmi sil (Opsiyonel temizlik)
                        if ($currentProduct['image_url'] && file_exists('../public/' . $currentProduct['image_url'])) {
                            unlink('../public/' . $currentProduct['image_url']);
                        }

                        $data['image_url'] = 'uploads/' . $newFileName;
                    }
                }
            }

            if ($productModel->update($id, $data)) {
                $this->redirect('/eticaret_proje/public/admin/products');
            } else {
                die("Güncelleme başarısız.");
            }
        }
    }

    /**
     * Ürünü siler.
     * @param int $id
     */
    public function delete($id) {
        $productModel = $this->model('Product');
        
        // Önce resmi silebiliriz
        $product = $productModel->getById($id);
        if ($product['image_url'] && file_exists('../public/' . $product['image_url'])) {
            unlink('../public/' . $product['image_url']);
        }

        $productModel->delete($id);
        $this->redirect('/eticaret_proje/public/admin/products');
    }
}
