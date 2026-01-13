<?php require_once '../app/views/layout/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Geçmiş Siparişlerim</h2>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">Henüz vermiş olduğunuz bir sipariş bulunmamaktadır.</div>
    <?php else: ?>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Sipariş No</th>
                        <th>Tarih</th>
                        <th>Tutar</th>
                        <th>Durum</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?></td>
                            <td class="fw-bold"><?php echo number_format($order['total_price'], 2); ?> ₺</td>
                            <td>
                                <?php 
                                    $badgeClass = 'bg-secondary';
                                    $statusText = 'Bilinmiyor';
                                    
                                    switch($order['status']) {
                                        case 'pending': $badgeClass = 'bg-warning text-dark'; $statusText = 'Bekliyor'; break;
                                        case 'completed': $badgeClass = 'bg-success'; $statusText = 'Tamamlandı'; break;
                                        case 'cancelled': $badgeClass = 'bg-danger'; $statusText = 'İptal Edildi'; break;
                                    }
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusText; ?></span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-info" disabled>Detay (Yakında)</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
