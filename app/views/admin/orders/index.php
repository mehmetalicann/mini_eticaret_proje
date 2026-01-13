<?php require_once '../app/views/layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-list-alt me-2"></i>Sipariş Listesi</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>Sipariş No</th>
                            <th>Müşteri</th>
                            <th>Tutar</th>
                            <th>Tarih</th>
                            <th>Durum</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($orders)): ?>
                            <tr><td colspan="6" class="text-center py-3">Kayıtlı sipariş bulunmuyor.</td></tr>
                        <?php else: ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($order['ad'] . ' ' . $order['soyad']); ?>
                                        <div class="small text-muted">ID: <?php echo $order['user_id']; ?></div>
                                    </td>
                                    <td class="fw-bold"><?php echo number_format($order['total_price'], 2); ?> ₺</td>
                                    <td><?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?></td>
                                    <td>
                                        <?php 
                                            // Durum renklendirmesi
                                            $statusBadge = 'bg-secondary';
                                            $statusText = 'Bilinmiyor';
                                            switch($order['status']) {
                                                case 'pending': $statusBadge = 'bg-warning text-dark'; $statusText = 'Bekliyor'; break;
                                                case 'completed': $statusBadge = 'bg-success'; $statusText = 'Tamamlandı'; break;
                                                case 'cancelled': $statusBadge = 'bg-danger'; $statusText = 'İptal'; break;
                                            }
                                        ?>
                                        <span class="badge <?php echo $statusBadge; ?>"><?php echo $statusText; ?></span>
                                    </td>
                                    <td>
                                        <a href="/eticaret_proje/public/admin/orders/show/<?php echo $order['id']; ?>" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i> Detay
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
