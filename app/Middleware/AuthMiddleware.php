<?php

namespace App\Middleware;

/**
 * Auth Middleware
 * 
 * Yetkilendirme kontrollerini yapan sınıf.
 * Sayfalara erişim yetkisi olup olmadığını denetler.
 */
class AuthMiddleware {

    /**
     * Kullanıcının giriş yapıp yapmadığını kontrol eder.
     * Giriş yapmamışsa login sayfasına yönlendirir.
     */
    public static function authCheck() {
        // Session başlatılmamışsa başlat (Garanti olsun)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Session'da user_id yoksa giriş yapılmamış demektir
        if (!isset($_SESSION['user_id'])) {
            // Kullanıcıyı login sayfasına yönlendir (Path projenize göre değişebilir)
            header('Location: /eticaret_proje/public/login');
            exit;
        }
    }

    /**
     * Sadece Admin yetkisine sahip kullanıcıların geçişine izin verir.
     */
    public static function adminCheck() {
        self::authCheck(); // Önce giriş yapmış mı bak

        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] !== 'admin') {
            // Yetkisiz erişim sayfası veya ana sayfaya yönlendir
            die("Bu sayfaya erişim yetkiniz yok."); // Daha şık bir hata sayfası yapılabilir
        }
    }
}
