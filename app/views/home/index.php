<?php require_once '../app/views/layout/header.php'; ?>

<!-- Hero Section / Tanıtım Alanı -->
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm text-center">
    <div class="container-fluid py-2">
        <h1 class="display-5 fw-bold text-primary">Hoş Geldiniz!</h1>
        <p class="col-md-8 fs-4 mx-auto">En yeni ve en kaliteli ürünler, en uygun fiyatlarla kapınızda.</p>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="/eticaret_proje/public/register" class="btn btn-primary btn-lg px-4 gap-3">Hemen Üye Ol</a>
        <?php else: ?>
            <p class="text-success fw-bold">Keyifli alışverişler dileriz, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
        <?php endif; ?>
    </div>
</div>

<h2 class="mb-4 text-center border-bottom pb-2">Ürünlerimiz</h2>

<!-- Ürün Listeleme -->
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php if (empty($products)): ?>
        <div class="col-12">
            <div class="alert alert-warning text-center">
                Henüz hiç ürün eklenmemiş.
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <!-- Ürün Resmi -->
                    <?php 
                        $imagePath = $product['image_url'] ? '/eticaret_proje/public/' . $product['image_url'] : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg'; 
                    ?>
                    <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>" style="height: 250px; object-fit: cover;">
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-truncate"><?php echo htmlspecialchars($product['name']); ?></h5>
                        <p class="card-text text-muted small flex-grow-1">
                            <?php echo htmlspecialchars(substr($product['description'] ?? '', 0, 100)) . '...'; ?>
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="h5 mb-0 text-primary fw-bold"><?php echo number_format($product['price'], 2); ?> ₺</span>
                            <?php if ($product['stock'] > 0): ?>
                                <span class="badge bg-success">Stok: <?php echo $product['stock']; ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Tükendi</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent border-top-0 pb-3 pt-0">
                        <div class="d-grid gap-2">
                             <a href="/eticaret_proje/public/home/product/<?php echo $product['id']; ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-search"></i> İncele
                            </a>

                            <?php if ($product['stock'] > 0): ?>
                                <form action="/eticaret_proje/public/cart/add" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-cart-plus"></i> Sepete Ekle
                                    </button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary w-100" disabled>Tükendi</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
