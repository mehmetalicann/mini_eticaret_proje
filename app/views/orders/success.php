<?php require_once '../app/views/layout/header.php'; ?>

<div class="container mt-5 text-center">
    <div class="py-5">
        <div class="mb-4">
            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
        </div>
        <h1 class="display-5 fw-bold text-success mb-3">Siparişiniz Alındı!</h1>
        <p class="lead mb-4">
            Teşekkür ederiz. Siparişiniz başarıyla oluşturuldu ve işleme alındı.<br>
            Sipariş Numaranız: <strong>#<?php echo isset($order_id) ? $order_id : '---'; ?></strong>
        </p>

        <div class="d-flex justify-content-center gap-3">
            <a href="/eticaret_proje/public/orders/my-orders" class="btn btn-outline-primary">Siparişlerimi Görüntüle</a>
            <a href="/eticaret_proje/public/home" class="btn btn-primary">Alışverişe Devam Et</a>
        </div>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
