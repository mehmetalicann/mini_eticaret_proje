<?php require_once '../app/views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-3 mt-5">
            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="card-title mb-0"><i class="fas fa-sign-in-alt me-2"></i>Giriş Yap</h3>
            </div>
            <div class="card-body p-4">
                
                <!-- Hata Mesajı Gösterimi -->
                <?php if (isset($data['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?php echo $data['error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="/eticaret_proje/public/login" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-Posta Adresi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo isset($data['email']) ? htmlspecialchars($data['email']) : ''; ?>" 
                                   required autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Şifre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Giriş Yap</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <p class="mb-0">Hesabınız yok mu? <a href="/eticaret_proje/public/register" class="text-decoration-none fw-bold">Kayıt Ol</a></p>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
