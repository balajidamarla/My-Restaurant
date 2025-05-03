<?= $this->include('layout/header') ?>

<div class="container mt-5 text-center">
    <h2 class="mb-4 text-success">✅ Order Confirmed!</h2>

    <p class="lead">Thank you for your order. Your delicious meal is being prepared and will be delivered soon! 🍽️</p>

    <div class="mt-4">
        <a href="<?= base_url('/customer/orders') ?>" class="btn btn-primary me-2">📦 View My Orders</a>
        <a href="<?= base_url('/menu/index') ?>" class="btn btn-outline-secondary">🍔 Continue Shopping</a>
    </div>
</div>

<?= $this->include('layout/footer') ?>
