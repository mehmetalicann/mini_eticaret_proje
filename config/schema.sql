-- Mini E-Ticaret Sistemi Veritabanı Şeması

-- Veritabanı oluşturma (Eğer yoksa)
CREATE DATABASE IF NOT EXISTS eticaret CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eticaret;

-- --------------------------------------------------------

-- Users Tablosu
-- Kullanıcı bilgilerini saklar. 'role' sütunu yetkilendirme için kullanılır (admin veya user).
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ad VARCHAR(50) NOT NULL COMMENT 'Kullanıcının adı',
    soyad VARCHAR(50) NOT NULL COMMENT 'Kullanıcının soyadı',
    email VARCHAR(100) NOT NULL UNIQUE COMMENT 'Kullanıcının E-posta adresi (Benzersiz)',
    password VARCHAR(255) NOT NULL COMMENT 'Hashlenmiş şifre (Argon2id veya Bcrypt)',
    role ENUM('admin', 'user') DEFAULT 'user' COMMENT 'Kullanıcı rolü: admin veya user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Hesap oluşturulma tarihi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Products Tablosu
-- Satılabilecek ürünlerin bilgilerini tutar.
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL COMMENT 'Ürün adı',
    description TEXT COMMENT 'Ürün açıklaması',
    price DECIMAL(10, 2) NOT NULL COMMENT 'Ürün fiyatı (Örn: 100.00)',
    stock INT NOT NULL DEFAULT 0 COMMENT 'Stok adedi',
    image_url VARCHAR(255) COMMENT 'Ürün resminin yolu',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Ürün eklenme tarihi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Orders Tablosu
-- Kullanıcıların siparişlerini tutar.
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL COMMENT 'Siparişi veren kullanıcı ID',
    total_price DECIMAL(10, 2) NOT NULL COMMENT 'Siparişin toplam tutarı',
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending' COMMENT 'Sipariş durumu',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Sipariş tarihi',
    
    -- Foreign Key: user_id -> users(id)
    -- Kullanıcı silinirse siparişleri silinmemeli, null olabilir veya restrict ile engellenebilir.
    -- Burada veri bütünlüğü için RESTRICT kullanıyoruz (Siparişi olan kullanıcı silinemez).
    CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Order Items Tablosu
-- Sipariş detaylarını (hangi üründen kaç tane alındığı) tutar.
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL COMMENT 'Bağlı olduğu sipariş ID',
    product_id INT NOT NULL COMMENT 'Satın alınan ürün ID',
    quantity INT NOT NULL DEFAULT 1 COMMENT 'Satın alınan adet',
    price_at_purchase DECIMAL(10, 2) NOT NULL COMMENT 'Satın alma anındaki birim fiyat',
    
    -- Foreign Key: order_id -> orders(id)
    -- Sipariş silinirse detayları da silinsin (CASCADE).
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE ON UPDATE CASCADE,
    
    -- Foreign Key: product_id -> products(id)
    -- Ürün silinirse sipariş geçmişi bozulmaması için null yapılabilir veya silme engellenebilir.
    -- RESTRICT: Ürün sipariş edilmişse silinemesin.
    CONSTRAINT fk_order_items_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
