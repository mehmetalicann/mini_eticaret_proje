<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * User Model
 * 
 * Users tablosu ile ilgili veritabanı işlemlerini yürütür.
 */
class User extends Model {

    /**
     * Yeni bir kullanıcı oluşturur.
     * 
     * @param array $data Kullanıcı verileri (ad, soyad, email, password_hash)
     * @return bool İşlem başarılıysa true, değilse false
     */
    public function create($data) {
        $sql = "INSERT INTO users (ad, soyad, email, password, role) VALUES (:ad, :soyad, :email, :password, :role)";
        
        $stmt = $this->db->prepare($sql);
        
        // 'role' varsayılan olarak 'user' olsun, data'da gelmezse
        $role = $data['role'] ?? 'user';

        return $stmt->execute([
            ':ad' => $data['ad'],
            ':soyad' => $data['soyad'],
            ':email' => $data['email'],
            ':password' => $data['password'], // Hashlenmiş şifre gelmeli
            ':role' => $role
        ]);
    }

    /**
     * Email adresine göre kullanıcıyı bulur.
     * 
     * @param string $email
     * @return mixed Kullanıcı objesi veya false
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        // Tek bir satır döndür
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
