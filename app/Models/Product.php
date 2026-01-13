<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/**
 * Product Model
 * 
 * Products tablosu ile ilgili CRUD (Create, Read, Update, Delete) işlemlerini bu sınıfta toplayacağız.
 */
class Product extends Model {

    /**
     * Tüm ürünleri getirir.
     * 
     * @return array Ürün listesi
     */
    public function getAll() {
        // En yeniden en eskiye sıralayarak getir
        $sql = "SELECT * FROM products ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ID'ye göre tek bir ürünü getirir (Düzenleme sayfası için gerekli).
     * 
     * @param int $id Ürün ID
     * @return mixed Ürün verisi veya false
     */
    public function getById($id) {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Yeni ürün ekler.
     * 
     * @param array $data Form verileri
     * @return bool Başarılı mı?
     */
    public function create($data) {
        $sql = "INSERT INTO products (name, description, price, stock, image_url) VALUES (:name, :description, :price, :stock, :image_url)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':stock' => $data['stock'],
            ':image_url' => $data['image_url']
        ]);
    }

    /**
     * Ürünü günceller.
     * 
     * @param int $id Ürün ID
     * @param array $data Güncellenecek veriler
     * @return bool
     */
    public function update($id, $data) {
        // Eğer yeni resim yüklenmediyse, eski resim yolunu korumak için kontrol yapılmalı 
        // ama Controller tarafında halledip buraya tam veri göndereceğiz.
        
        $sql = "UPDATE products SET name = :name, description = :description, price = :price, stock = :stock, image_url = :image_url WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':stock' => $data['stock'],
            ':image_url' => $data['image_url']
        ]);
    }

    /**
     * Ürünü siler.
     * 
     * @param int $id Ürün ID
     * @return bool
     */
    public function delete($id) {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
