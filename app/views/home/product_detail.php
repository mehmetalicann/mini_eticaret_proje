<?php require_once '../app/views/layout/header.php'; ?>

<div class="container mt-5">
    <!-- Breadcrumb Navigasyon -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/eticaret_proje/public/home">Anasayfa</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sol Taraf: Ürün Resmi -->
        <div class="col-md-6 mb-4">
            <?php 
                 $imagePath = $product['image_url'] ? '/eticaret_proje/public/' . $product['image_url'] : 'https://dummyimage.com/600x400/dee2e6/6c757d.jpg'; 
            ?>
            <img src="<?php echo $imagePath; ?>" class="img-fluid rounded shadow-sm w-100" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>

        <!-- Sağ Taraf: Ürün Bilgileri -->
        <div class="col-md-6">
            <h1 class="display-5 fw-bold"><?php echo htmlspecialchars($product['name']); ?></h1>
            
            <div class="mb-3">
                <span class="fs-2 fw-bold text-primary"><?php echo number_format($product['price'], 2); ?> ₺</span>
            </div>

            <div class="mb-4">
                <?php if ($product['stock'] > 0): ?>
                    <span class="badge bg-success fs-6"><i class="fas fa-check-circle"></i> Stokta Var (<?php echo $product['stock']; ?> Adet)</span>
                <?php else: ?>
                    <span class="badge bg-secondary fs-6"><i class="fas fa-times-circle"></i> Stokta Yok</span>
                <?php endif; ?>
            </div>

            <p class="lead text-muted mb-4">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </p>
            
            <hr>

            <?php if ($product['stock'] > 0): ?>
                <form action="/eticaret_proje/public/cart/add" method="POST" class="row g-3 align-items-center">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    
                    <div class="col-auto">
                        <label for="quantity" class="col-form-label fw-bold">Adet:</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="<?php echo $product['stock']; ?>" style="width: 80px;">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-cart-plus me-2"></i> Sepete Ekle
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-warning">
                    Bu ürün şu anda temin edilememektedir.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
