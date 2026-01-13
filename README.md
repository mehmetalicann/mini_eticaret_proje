# 🛒 Mini E-Ticaret Sistemi (Mini E-Commerce System)

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap 5](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![MVC](https://img.shields.io/badge/Architecture-MVC-green?style=for-the-badge)

Bu proje, **Native PHP** kullanılarak geliştirilmiş, **MVC (Model-View-Controller)** mimarisine sadık, modern ve güvenli bir E-Ticaret başlangıç projesidir. Frontend tasarımında **Bootstrap 5** kullanılmıştır.

---

## 🚀 Özellikler (Features)

### 🔒 Kimlik Doğrulama & Güvenlik
- **Kullanıcı Kayıt & Giriş**: Güvenli oturum yönetimi.
- **Şifreleme**: `password_hash()` (Bcrypt/Argon2) ile güvenli parola saklama.
- **Güvenlik Önlemleri**: 
  - PDO Prepared Statements (SQL Injection Koruması)
  - XSS Koruması (`htmlspecialchars`)
  - CSRF ve Session güvenliği
  - Middleware tabanlı yetkilendirme (Auth & Admin Check)

### 🛍️ Alışveriş Deneyimi (Frontend)
- **Ürün Listeleme**: Vitrin sayfasında ürünlerin şık kartlarla listelenmesi.
- **Ürün Detay**: Ürün resimleri, açıklamaları ve stok durumu.
- **Sepet Sistemi**: Session tabanlı dinamik sepet yönetimi (Ekle, Sil, Güncelle).
- **Sipariş Oluşturma**: Transaction (İşlem bütünlüğü) kullanılarak güvenli sipariş ve stok yönetimi.
- **Sipariş Takibi**: Kullanıcıların geçmiş siparişlerini görüntüleyebilmesi.

### ⚙️ Yönetim Paneli (Admin)
- **Dashboard**: Sipariş ve ürünlere hızlı erişim.
- **Ürün Yönetimi**:
  - Ürün Ekleme (Görsel Yükleme Özelliği ile)
  - Ürün Düzenleme & Silme
  - Stok Takibi
- **Sipariş Yönetimi**:
  - Gelen siparişleri listeleme
  - Sipariş detaylarını ve satın alınan ürünleri görüntüleme
  - Sipariş durumu güncelleme (Bekliyor -> Tamamlandı / İptal)

---

## 🛠️ Kurulum (Installation)

Projeyi kendi bilgisayarınızda (Localhost) çalıştırmak için aşağıdaki adımları izleyin:

### 1. Gereksinimler
- XAMPP / WAMP / MAMP (PHP 8.2+ ve MySQL içeren herhangi bir sunucu)
- VS Code (veya benzeri bir editör)

### 2. Dosyaları Hazırlama
Projeyi `htdocs` veya `www` klasörüne kopyalayın:
```bash
git clone https://github.com/kullaniciadiniz/mini-eticaret-proje.git
```

### 3. Veritabanı Kurulumu
1. **phpMyAdmin**'e gidin (`http://localhost/phpmyadmin`).
2. **`eticaret`** adında yeni bir veritabanı oluşturun (`utf8mb4_unicode_ci` önerilir).
3. Proje içindeki `config/schema.sql` dosyasını içe aktarın (Import).

### 4. Konfigürasyon
Veritabanı ayarlarınız varsayılan XAMPP ayarlarından farklıysa `config/config.php` dosyasını düzenleyin:
```php
return [
    'db_host' => 'localhost',
    'db_name' => 'eticaret',
    'db_user' => 'root',  // Kullanıcı adınız
    'db_pass' => ''       // Şifreniz
];
```

### 5. Çalıştırma
Tarayıcınızda şu adrese gidin:
```
http://localhost/mini-eticaret-proje/public/
```

---

## 📁 Proje Yapısı (Directory Structure)

```
mini-eticaret-proje/
├── app/
│   ├── Controllers/     # İş mantığını yöneten sınıflar (Auth, Cart, Product...)
│   ├── Core/            # Çekirdek dosyalar (App/Router, Database, Model...)
│   ├── Middleware/      # Yetkilendirme kontrolleri
│   ├── Models/          # Veritabanı işlemleri
│   └── views/           # HTML/PHP arayüz dosyaları (Admin, Auth, Home...)
├── config/              # Veritabanı ayarları ve SQL şeması
├── public/              # Web kök dizini (CSS, JS, Uploads, index.php)
└── ...
```

---

## 📸 Ekran Görüntüleri (Screenshots)

*(Buraya projenizden aldığınız ekran görüntülerini ekleyebilirsiniz)*

| Anasayfa | Sepet |
|:---:|:---:|
| ![Home](https://dummyimage.com/600x400/dee2e6/6c757d.jpg&text=Header+Görseli) | ![Cart](https://dummyimage.com/600x400/dee2e6/6c757d.jpg&text=Sepet+Görseli) |

---

## 📄 Lisans

Bu proje eğitim amaçlı geliştirilmiştir ve tamamen açık kaynaktır.

---
**Geliştirici**: [Senin Adın]  
**Teknolojiler**: PHP, MySQL, Bootstrap 5
