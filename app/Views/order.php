<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>🛒 Place Your Order</h2>

    <?php if (!session()->get('isLoggedIn')) : ?>
        <div class="alert alert-danger">⚠️ Please login to place an order.</div>
        <script>
            setTimeout(() => window.location.href = "<?= base_url('/customer/login') ?>", 2000);
        </script>
    <?php return;
    endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('/order/store') ?>" method="post">
    <?= csrf_field() ?>
        <!-- <div class="mb-3">
            <label for="customer_name" class="form-label">👤 Name</label>
            <input type="text" name="customer_name" class="form-control" required
                value="<?//= esc(session()->get('user_name')) ?>">
        </div> -->

        <!-- <div class="mb-3">
            <label for="phone" class="form-label">📞 Phone</label>
            <input type="text" name="phone" class="form-control" required
                value="<?//= esc(session()->get('user_phone')) ?>">
        </div> -->

        <div class="mb-3">
            <label for="food_item" class="form-label">🍔 Food Item</label>
            <input type="text" name="food_item" class="form-control" value="<?= esc($food_item ?? '') ?>" readonly required>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">🔢 Quantity</label>
            <input type="number" name="quantity" class="form-control" id="quantity" required>
        </div>

        <div class="mb-3">
            <label for="total_price" class="form-label">💰 Total Price</label>
            <input type="number" name="total_price" class="form-control" id="total_price" value="<?= esc($price ?? '') ?>" required>
        </div>

        <!-- Hidden field to set default status -->
        <input type="hidden" name="status" value="Pending">
        <!-- <div class="mb-3">
            <label for="status" class="form-label">📦 Status</label>
            <select name="status" class="form-control">
                <option value="Pending">Pending</option>
                <option value="Preparing">Preparing</option>
                <option value="Delivered">Delivered</option>
            </select>
        </div> -->


        <button type="submit" class="btn btn-success">✅ Place Order</button>
    </form>
</div>

<!-- Auto-calculate total price -->
<script>
    const quantityInput = document.getElementById('quantity');
    const priceInput = document.getElementById('total_price');
    const unitPrice = <?= json_encode($price ?? 0) ?>;

    quantityInput?.addEventListener('input', () => {
        const qty = parseInt(quantityInput.value) || 0;
        priceInput.value = unitPrice * qty;
    });
</script>

<?= $this->endSection() ?>