<?php require_once '../app/views/layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sipariş Detayı #<?php echo $order['id']; ?></h2>
        <a href="/eticaret_proje/public/admin/orders" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Listeye Dön</a>
    </div>

    <div class="row">
        <!-- Müşteri ve Sipariş Bilgileri Sol Kolon -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light fw-bold">Müşteri Bilgileri</div>
                <div class="card-body">
                    <p class="mb-1"><strong>Ad Soyad:</strong> <?php echo htmlspecialchars($order['ad'] . ' ' . $order['soyad']); ?></p>
                    <p class="mb-1"><strong>E-Posta:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                    <p class="mb-0"><strong>Tarih:</strong> <?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?></p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">Sipariş Durumu</div>
                <div class="card-body">
                    <form action="/eticaret_proje/public/admin/orders/updateStatus/<?php echo $order['id']; ?>" method="POST">
                        <div class="mb-3">
                            <label for="status" class="form-label">Durum</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Bekliyor</option>
                                <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Tamamlandı</option>
                                <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>İptal Edildi</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Durumu Güncelle</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ürünler Tablosu Sağ Kolon -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light fw-bold">Satın Alınan Ürünler</div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">Görsel</th>
                                <th>Ürün Adı</th>
                                <th>Adet</th>
                                <th>Birim Fiyat</th>
                                <th>Toplam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <?php 
                                            $imgUrl = $item['image_url'] ? '/eticaret_proje/public/' . $item['image_url'] : 'https://dummyimage.com/50x50/dee2e6/6c757d.jpg';
                                        ?>
                                        <img src="<?php echo $imgUrl; ?>" alt="img" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($item['price_at_purchase'], 2); ?> ₺</td>
                                    <td class="fw-bold"><?php echo number_format($item['price_at_purchase'] * $item['quantity'], 2); ?> ₺</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end fw-bold">GENEL TOPLAM:</td>
                                <td class="fw-bold text-primary fs-5"><?php echo number_format($order['total_price'], 2); ?> ₺</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
