<?php require_once '../app/views/layout/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Yeni Ürün Ekle</h4>
            </div>
            <div class="card-body">
                <form action="/eticaret_proje/public/admin/products/store" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Ürün Adı</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Fiyat (₺)</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Stok Adedi</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Ürün Görseli</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="form-text">İzin verilen formatlar: JPG, PNG. Yüklenmezse varsayılan görsel kullanılır.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="/eticaret_proje/public/admin/products" class="btn btn-secondary">İptal</a>
                        <button type="submit" class="btn btn-primary px-4">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
