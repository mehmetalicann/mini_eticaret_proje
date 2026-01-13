<?php

/**
 * Database Class
 * 
 * Singleton tasarım deseni kullanılarak oluşturulmuş veritabanı sınıfı.
 * Sadece bir kez bağlantı oluşturur ve bu bağlantıyı döndürür.
 * Config dizinindeki config.php dosyasından ayarları çeker.
 */

namespace App\Core;

use PDO;
use PDOException;

class Database {
    // Singleton instance
    private static $instance = null;
    
    // PDO Connection
    private $connection;

    /**
     * Private constructor - Dışarıdan 'new' ile nesne oluşturulmasını engeller.
     */
    private function __construct() {
        // Config dosyasını dahil et
        $config = require __DIR__ . '/../../config/config.php';
        
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";
        
        try {
            // PDO Bağlantısını oluştur
            $this->connection = new PDO($dsn, $config['db_user'], $config['db_pass']);
            
            // Hata modunu Exception olarak ayarla (Try-Catch ile yakalayabilmek için)
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Varsayılan fetch modunu Associative Array yap
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Türkçe karakter sorunları için charset ayarı (DSN'de de var ama garanti olsun)
            $this->connection->exec("SET NAMES 'utf8mb4'");

            
        } catch (PDOException $e) {
            // Bağlantı hatası durumunda işlemi durdur ve hatayı göster
            die("Veritabanı bağlantı hatası: " . $e->getMessage());
        }
    }

    /**
     * Singleton örneğini döndürür.
     * Eğer örnek yoksa oluşturur, varsa mevcut olanı döndürür.
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * PDO bağlantı nesnesini döndürür.
     */
    public function getConnection() {
        return $this->connection;
    }
    
    // Singleton prensibi gereği kopyalamayı ve unserialize etmeyi engelle
    private function __clone() {}
    public function __wakeup() {}
}
