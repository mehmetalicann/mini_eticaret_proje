<?php require_once '../app/views/layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-box me-2"></i>Ürün Yönetimi</h2>
        <a href="/eticaret_proje/public/admin/products/create" class="btn btn-success">
            <i class="fas fa-plus"></i> Yeni Ürün Ekle
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th style="width: 80px;">Görsel</th>
                            <th>Ürün Adı</th>
                            <th>Fiyat</th>
                            <th>Stok</th>
                            <th style="width: 150px;">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">Henüz kayıtlı ürün bulunmuyor.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['id']; ?></td>
                                    <td>
                                        <?php 
                                            $imgUrl = $product['image_url'] ? '/eticaret_proje/public/' . $product['image_url'] : 'https://dummyimage.com/50x50/dee2e6/6c757d.jpg';
                                        ?>
                                        <img src="<?php echo $imgUrl; ?>" alt="img" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo number_format($product['price'], 2); ?> ₺</td>
                                    <td>
                                        <?php if ($product['stock'] < 5): ?>
                                            <span class="badge bg-danger"><?php echo $product['stock']; ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-success"><?php echo $product['stock']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="/eticaret_proje/public/admin/products/edit/<?php echo $product['id']; ?>" class="btn btn-sm btn-primary me-1" title="Düzenle">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/eticaret_proje/public/admin/products/delete/<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu ürünü silmek istediğinize emin misiniz?')" title="Sil">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
