<h2>Order: <?= esc($menuItem['name']) ?></h2>

<form method="post" action="<?= base_url('order/store') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="menu_item_id" value="<?= $menuItem['id'] ?>">

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="customer_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" class="form-control" min="1" required>
    </div>

    <button type="submit" class="btn btn-primary">Place Order</button>
</form>