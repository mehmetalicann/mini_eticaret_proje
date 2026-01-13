<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * Auth Controller
 * 
 * Kayıt, Giriş ve Çıkış işlemlerini yönetir.
 */
class AuthController extends Controller {

    /**
     * Kayıt sayfasını gösterir veya kayıt işlemini yapar.
     */
    public function register() {
        // Eğer form gönderildiyse (POST isteği)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Verileri al ve temizle
            // htmlspecialchars XSS koruması için çıktı verirken kullanılır ama 
            // veritabanına kaydederken ham halini almak bazen tercih edilir (sonra çıktı alırken escape edilir).
            // Ancak basit güvenlik için trim yapalım.
            $data = [
                'ad' => trim($_POST['ad']),
                'soyad' => trim($_POST['soyad']),
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'password_confirm' => $_POST['password_confirm']
            ];

            // 2. Basit Validation (Doğrulama)
            if (empty($data['ad']) || empty($data['soyad']) || empty($data['email']) || empty($data['password'])) {
                die("Lütfen tüm alanları doldurun.");
            }

            if ($data['password'] !== $data['password_confirm']) {
                die("Şifreler uyuşmuyor.");
            }
            
            // Email format kontrolü
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                die("Geçersiz email formatı.");
            }

            // User modelini yükle
            $userModel = $this->model('User');

            // Email daha önce alınmış mı kontrol et
            if ($userModel->findByEmail($data['email'])) {
                die("Bu email adresi zaten kayıtlı.");
            }

            // 3. Şifreleme (Hashing)
            // PASSWORD_DEFAULT şu anda Bcrypt kullanır, gelecekte daha güçlüsü gelirse PHP günceller.
            // Argon2id için PASSWORD_ARGON2ID sabiti kullanılabilir (PHP sunucu desteği varsa).
            // Biz güvenli ve standart olan PASSWORD_DEFAULT kullanalım.
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // 4. Kullanıcıyı oluştur
            if ($userModel->create($data)) {
                // Başarılı ise login sayfasına yönlendir
                // Header fonksiyonu ile yönlendirme yapmadan önce çıktı verilmemeli.
                $this->redirect('/eticaret_proje/public/login'); 
            } else {
                die("Bir hata oluştu.");
            }

        } else {
            // GET isteği ise kayıt formunu göster
            $this->view('auth/register');
        }
    }

    /**
     * Giriş sayfasını gösterir veya giriş işlemini yapar.
     */
    public function login() {
        // Eğer kullanıcı zaten giriş yapmışsa ana sayfaya at
        // Middleware kullanımı burada da olabilir ama basit kontrol:
        if (isset($_SESSION['user_id'])) {
             $this->redirect('/eticaret_proje/public/home');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verileri al
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // Validation
            if (empty($email) || empty($password)) {
                 $data['error'] = 'Tüm alanları doldurun';
                 $this->view('auth/login', $data);
                 return;
            }

            // Modeli yükle
            $userModel = $this->model('User');
            
            // Kullanıcıyı bul
            $user = $userModel->findByEmail($email);

            // Kullanıcı var mı ve Şifre doğru mu?
            if ($user && password_verify($password, $user['password'])) {
                // Giriş Başarılı - Session Başlat
                // index.php'de session_start() en tepede olmalı, burada $_SESSION'a atama yapıyoruz.
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['ad'] . ' ' . $user['soyad'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_email'] = $user['email'];

                // Ana sayfaya veya profile yönlendir
                $this->redirect('/eticaret_proje/public/home');

            } else {
                // Hatalı giriş
                $data['error'] = 'Email veya şifre hatalı.';
                // Geriye email'i de gönder ki kullanıcı tekrar yazmak zorunda kalmasın
                $data['email'] = $email;
                $this->view('auth/login', $data);
            }

        } else {
            // Login formunu göster
            $this->view('auth/login');
        }
    }

    /**
     * Çıkış işlemini yapar.
     */
    public function logout() {
        // Oturumu sonlandır
        session_unset();
        session_destroy();
        
        // Login sayfasına yönlendir
        $this->redirect('/eticaret_proje/public/login');
    }
}
