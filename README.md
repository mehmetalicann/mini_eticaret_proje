# 🛒 Mini E-Ticaret Sistemi (Mini E-Commerce System)

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap 5](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![MVC](https://img.shields.io/badge/Architecture-MVC-green?style=for-the-badge)
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

## 📄 Lisans

Bu proje eğitim amaçlı geliştirilmiştir ve tamamen açık kaynaktır.

---  
**Teknolojiler**: PHP, MySQL, Bootstrap 5
