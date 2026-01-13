<?php

/**
 * Entry Point (Giriş Noktası)
 * 
 * Projenin başlangıç dosyasıdır.
 * Tüm ayarların yüklenmesi, autoloader ve uygulamanın başlatılması burada yapılır.
 */

// Hataları göster (Geliştirme aşamasında)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoloader Fonksiyonu
// Sınıfları otomatik olarak yükler (include/require kullanmadan)
spl_autoload_register(function ($className) {
    // Namespace prefix 'App\' -> 'app/' klasörüne denk gelir
    $prefix = 'App\\';
    
    // Projenin kök dizini (public'in bir üstü)
    $base_dir = __DIR__ . '/../app/';
    
    // Class isminin başındaki prefix'i (App\) kontrol et
    $len = strlen($prefix);
    if (strncmp($prefix, $className, $len) !== 0) {
        // Eğer sınıf 'App\' ile başlamıyorsa işleme
        return;
    }
    
    // Prefix'ten sonraki kısmı al (Örn: Controllers\HomeController)
    $relative_class = substr($className, $len);
    
    // Namespace ayırıcılarını (\) klasör ayırıcılarına (/) çevir ve .php ekle
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    // Dosya varsa dahil et
    if (file_exists($file)) {
        require $file;
    }
});

// Session Başlat (Tüm uygulama için)
session_start();

// Uygulamayı Başlat (Router Çalışsın)
use App\Core\App;

// App sınıfı (app/Core/App.php) URL'i analiz edecek ve ilgili Controller'ı çalıştıracaktır.
$app = new App();
