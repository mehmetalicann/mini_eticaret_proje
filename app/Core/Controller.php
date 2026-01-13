<?php

namespace App\Core;

/**
 * Base Controller Class
 * 
 * Tüm controller sınıflarının türetileceği ana sınıf.
 * Model ve View yükleme işlemlerini kolaylaştırır.
 */
class Controller {

    /**
     * İstenilen modeli yükler ve bir örneğini döndürür.
     * 
     * @param string $model Model sınıfının adı (Örn: 'User')
     * @return object Model nesnesi
     */
    public function model($model) {
        // Namespace ile tam sınıf adını oluştur
        $modelClass = 'App\\Models\\' . $model;
        
        // Model dosyasının varlığını kontrol et (Opsiyonel ama iyi bir pratiktir)
        // Autoloader kullanacağımız için direkt new diyebiliriz
        return new $modelClass();
    }

    /**
     * İstenilen view dosyasını yükler ve verileri aktarır.
     * 
     * @param string $view View dosyasının yolu (Örn: 'auth/login')
     * @param array $data View'a gönderilecek veriler
     */
    public function view($view, $data = []) {
        // Verileri değişkenlere dönüştür (extract)
        // Örn: ['title' => 'Giriş'] -> $title = 'Giriş';
        extract($data);

        // View dosyasının tam yolu
        $viewFile = '../app/views/' . $view . '.php';

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View dosyası bulunamadı: " . $viewFile);
        }
    }
    
    /**
     * Kullanıcıyı başka bir sayfaya yönlendirir.
     */
    public function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
}
