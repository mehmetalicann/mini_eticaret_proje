<?php require_once '../app/views/layout/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4"><i class="fas fa-shopping-cart me-2"></i>Alışveriş Sepetim</h2>

    <?php if (empty($cartItems)): ?>
        <div class="alert alert-info py-5 text-center">
            <h4><i class="fas fa-box-open fa-2x mb-3 d-block"></i>Sepetiniz boş.</h4>
            <p>Hemen alışverişe başlayıp harika ürünlerimizi keşfedin!</p>
            <a href="/eticaret_proje/public/home" class="btn btn-primary mt-2">Alışverişe Başla</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 100px;">Ürün</th>
                                        <th>Adı</th>
                                        <th>Fiyat</th>
                                        <th style="width: 150px;">Adet</th>
                                        <th>Toplam</th>
                                        <th style="width: 50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $productId => $item): ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                    $imgUrl = isset($item['image_url']) && $item['image_url'] ? '/eticaret_proje/public/' . $item['image_url'] : 'https://dummyimage.com/100x100/dee2e6/6c757d.jpg';
                                                ?>
                                                <img src="<?php echo $imgUrl; ?>" alt="Ürün" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <a href="/eticaret_proje/public/home/product/<?php echo $productId; ?>" class="text-decoration-none text-dark fw-bold">
                                                    <?php echo htmlspecialchars($item['name']); ?>
                                                </a>
                                            </td>
                                            <td><?php echo number_format($item['price'], 2); ?> ₺</td>
                                            <td>
                                                <!-- Miktar Güncelleme Butonları -->
                                                <div class="input-group input-group-sm" style="max-width: 120px;">
                                                    <form action="/eticaret_proje/public/cart/update" method="POST" class="d-inline">
                                                        <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                                        <input type="hidden" name="action" value="decrease">
                                                        <button type="submit" class="btn btn-outline-secondary">-</button>
                                                    </form>
                                                    
                                                    <input type="text" class="form-control text-center bg-white" value="<?php echo $item['quantity']; ?>" readonly>
                                                    
                                                    <form action="/eticaret_proje/public/cart/update" method="POST" class="d-inline">
                                                        <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                                        <input type="hidden" name="action" value="increase">
                                                        <button type="submit" class="btn btn-outline-secondary">+</button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="fw-bold"><?php echo number_format($item['price'] * $item['quantity'], 2); ?> ₺</td>
                                            <td>
                                                <form action="/eticaret_proje/public/cart/remove" method="POST" onsubmit="return confirm('Bu ürünü sepetten silmek istediğinize emin misiniz?');">
                                                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Kaldır">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="/eticaret_proje/public/cart/clear" class="btn btn-outline-danger btn-sm" onclick="return confirm('Sepeti tamamen boşaltmak istediğinize emin misiniz?');">
                        <i class="fas fa-trash"></i> Sepeti Temizle
                    </a>
                    <a href="/eticaret_proje/public/home" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-arrow-left"></i> Alışverişe Devam Et
                    </a>
                </div>
            </div>

            <!-- Sağ Taraf: Özet ve Checkout -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0">Sipariş Özeti</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ara Toplam</span>
                            <span><?php echo number_format($totalPrice, 2); ?> ₺</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Kargo</span>
                            <span>Ücretsiz</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">Genel Toplam</span>
                            <span class="h5 fw-bold text-primary"><?php echo number_format($totalPrice, 2); ?> ₺</span>
                        </div>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="/eticaret_proje/public/order/checkout" method="POST">
                                <button type="submit" class="btn btn-success w-100 py-2 fs-5">
                                    <i class="fas fa-credit-card me-2"></i> Siparişi Tamamla
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-warning small mb-3">
                                Sipariş verebilmek için giriş yapmalısınız.
                            </div>
                            <a href="/eticaret_proje/public/login" class="btn btn-primary w-100">Giriş Yap ve Öde</a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="alert alert-secondary mt-3 small text-center">
                    <i class="fas fa-shield-alt"></i> Güvenli Ödeme Altyapısı
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
