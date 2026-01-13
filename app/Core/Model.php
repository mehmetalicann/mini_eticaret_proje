<?php

namespace App\Core;

/**
 * Base Model Class
 * 
 * Tüm modellerin türetileceği ana sınıf.
 * Veritabanı bağlantı nesnesine erişim sağlar.
 */
class Model {
    protected $db;

    public function __construct() {
        // Singleton Database sınıfından bağlantıyı al
        $this->db = Database::getInstance()->getConnection();
    }
}
