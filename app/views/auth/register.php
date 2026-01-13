<?php require_once '../app/views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0 rounded-3 mt-4">
            <div class="card-header bg-success text-white text-center py-3">
                <h3 class="card-title mb-0"><i class="fas fa-user-plus me-2"></i>Kayıt Ol</h3>
            </div>
            <div class="card-body p-4">
                
                <form action="/eticaret_proje/public/register" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ad" class="form-label">Ad</label>
                            <input type="text" class="form-control" id="ad" name="ad" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="soyad" class="form-label">Soyad</label>
                            <input type="text" class="form-control" id="soyad" name="soyad" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-Posta Adresi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-text">Asla e-postanızı başkalarıyla paylaşmayacağız.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Şifre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Şifre Tekrar</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">Kayıt Ol</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <p class="mb-0">Zaten hesabınız var mı? <a href="/eticaret_proje/public/login" class="text-decoration-none fw-bold">Giriş Yap</a></p>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
