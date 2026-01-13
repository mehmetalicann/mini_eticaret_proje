<?php

namespace App\Core;

/**
 * App Class (Router)
 * 
 * Uygulamanın ana yönlendirme (Routing) sınıfıdır.
 * URL'i analiz eder ve ilgili Controller'ı ve metodunu çalıştırır.
 */
class App {

    protected $controller = 'HomeController'; // Varsayılan Controller
    protected $method = 'index';             // Varsayılan Method
    protected $params = [];                  // Parametreler

    public function __construct() {
        $url = $this->parseUrl();

        // 1. Controller'ı Bul
        // URL'in ilk parçası Controller adı mı?
        // Örn: url[0] = 'login' ise AuthController'a bakmalı veya routing tablosu yapmalı.
        // Basit MVC yapısında: /controller/method/param şeklinde olur.
        // Ancak /login gibi temiz URL'ler istiyorsak manuel mapping veya akıllı kontrol gerekir.

        // Manuel Mapping (Basit ve etkili)
        $url[0] = isset($url[0]) ? $url[0] : '';
        
        switch ($url[0]) {
            case 'admin':
                // Admin altındaki controllerlar için özel yapı (örn: /admin/products -> AdminProductController)
                if (isset($url[1])) {
                    if ($url[1] == 'products') {
                        $this->controller = 'AdminProductController';
                        unset($url[1]);
                    } elseif ($url[1] == 'orders') {
                        $this->controller = 'AdminOrderController';
                        unset($url[1]);
                    }
                    unset($url[0]); 
                }
                break;
            case 'login':
                $this->controller = 'AuthController';
                $this->method = 'login';
                unset($url[0]);
                break;
            case 'register':
                $this->controller = 'AuthController';
                $this->method = 'register';
                unset($url[0]);
                break;
            case 'logout':
                $this->controller = 'AuthController';
                $this->method = 'logout';
                unset($url[0]);
                break;
            case 'cart':
                $this->controller = 'CartController';
                unset($url[0]);
                break;
            case 'home':
                $this->controller = 'HomeController';
                unset($url[0]);
                break;
            // Eklenebilir diğer route'lar...
        }

        // Eğer manuel map'e girmediyse ve dosya varsa onu kullan (Standart MVC: /Urunler/index gibi)
        // Ancak biz yukarıdaki mapping ile ilerliyoruz, bu kısmı esnek bırakalım.
        // Eğer $this->controller değişmediyse (Hala HomeController) ve URL doluysa, belki ürün detaydır?
        // Basitlik adına varsayılan kontroller üzerinden gidelim.
        
        // Controller dosyasının varlığını kontrol et
        if (file_exists('../app/Controllers/' . $this->controller . '.php')) {
            // Controller sınıfını dahil etmemize gerek yok, Autoloader (index.php'de) halledecek.
        } else {
            // Controller yoksa 404 veya Home
            $this->controller = 'HomeController';
        }

        // Controller sınıfını oluştur
        // Namespace'e dikkat: App\Controllers\ControllerAdi
        $this->controller = 'App\\Controllers\\' . $this->controller;
        $this->controller = new $this->controller;

        // 2. Method'u Bul
        if (isset($url[1]) || (isset($url[0]) && method_exists($this->controller, $url[0]))) {
            // URL dizisindeki indexler kaymış olabilir (unset yüzünden), array_values ile düzeltmek lazım
            // veya direk bakmak lazım.
            
            // Basitçe: Eğer url[1] varsa ve metodsa onu set et
            // Örn: /cart/add -> CartController -> add
            if (isset($url[1])) {
                if (method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                }
            } elseif (isset($url[0]) && method_exists($this->controller, $url[0])) {
                // Mapping dışı standart kullanım için
                 $this->method = $url[0];
                 unset($url[0]);
            }
        }

        // 3. Parametreleri Bul
        // Geriye kalanlar parametredir
        $this->params = $url ? array_values($url) : [];

        // Method'u parametrelerle çağır
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * URL'i parse eder ve dizi olarak döndürür.
     * .htaccess sayesinde $_GET['url'] set edilir.
     */
    public function parseUrl() {
        if (isset($_GET['url'])) {
            // Sağdaki slash'ı sil, filtrele ve patlat
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
