<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @media (max-width: 991.98px) and (min-width: 576px) {
            .menu-items>.menu-col {
                flex: 0 0 50%;
                max-width: 50%;
                max-height: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4">🛒 Your Cart</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php
        $cart = session()->get('cart');
        $grandTotal = 0;
        ?>

        <?php if (!empty($cart)): ?>
            <!-- DESKTOP VIEW -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Item Name</th>
                            <th>Price (₹)</th>
                            <th>Quantity</th>
                            <th>Total (₹)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                            <?php $total = $item['price'] * $item['quantity']; ?>
                            <?php $grandTotal += $total; ?>
                            <tr>
                                <td><?= esc($item['name']) ?></td>
                                <td>₹<?= esc($item['price']) ?></td>
                                <td>
                                    <div class="input-group justify-content-center">
                                        <button type="button" class="btn btn-outline-secondary decrease-btn" data-id="<?= $item['id'] ?>" data-price="<?= $item['price'] ?>">-</button>
                                        <input type="number" class="form-control text-center quantity-input" id="quantity-<?= $item['id'] ?>" value="<?= $item['quantity'] ?>" min="1" readonly style="width: 60px;">
                                        <button type="button" class="btn btn-outline-secondary increase-btn" data-id="<?= $item['id'] ?>" data-price="<?= $item['price'] ?>">+</button>
                                    </div>
                                </td>
                                <td id="total-<?= $item['id'] ?>">₹<?= $total ?></td>
                                <td>
                                    <a href="<?= base_url('cart/remove/' . $item['id']) ?>" class="btn btn-danger btn-sm">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-secondary">
                            <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                            <td colspan="2" class="fw-bold" id="grand-total">₹<?= $grandTotal ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- MOBILE VIEW -->
            <div class="d-md-none">
                <?php foreach ($cart as $item): ?>
                    <?php $total = $item['price'] * $item['quantity']; ?>
                    <?php $grandTotal += $total; ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($item['name']) ?></h5>
                            <p class="card-text mb-1">Price: ₹<?= esc($item['price']) ?></p>
                            <p class="card-text mb-1">Total: ₹<span id="total-<?= $item['id'] ?>"><?= $total ?></span></p>
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <div class="input-group" style="width: auto;">
                                    <button type="button" class="btn btn-outline-secondary decrease-btn" data-id="<?= $item['id'] ?>" data-price="<?= $item['price'] ?>">-</button>
                                    <input type="number" class="form-control text-center quantity-input" id="quantity-<?= $item['id'] ?>" value="<?= $item['quantity'] ?>" min="1" readonly style="width: 60px;">
                                    <button type="button" class="btn btn-outline-secondary increase-btn" data-id="<?= $item['id'] ?>" data-price="<?= $item['price'] ?>">+</button>
                                </div>

                                <a href="<?= base_url('cart/remove/' . $item['id']) ?>" class="btn btn-danger btn-sm">Remove</a>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="card bg-light mb-3">
                    <div class="card-body text-end">
                        <strong>Grand Total: ₹<span id="grand-total"><?= $grandTotal ?></span></strong>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="<?= base_url('cart/checkout') ?>" class="btn btn-success">✅ Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <p class="text-muted">Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <!-- JavaScript for Quantity Update & Grand Total -->
    <!-- Place this before closing body tag -->
    <script>
        function updateCartQuantity(itemId, quantity, pricePerUnit) {
            fetch("<?= base_url('cart/update') ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        itemId: itemId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const itemTotal = quantity * pricePerUnit;
                        document.getElementById('total-' + itemId).innerText = '₹' + itemTotal;
                        document.getElementById('grand-total').innerText = '₹' + data.grandTotal;
                    } else {
                        alert('Failed to update cart.');
                    }
                });
        }

        document.querySelectorAll('.increase-btn').forEach(button => {
            button.addEventListener('click', () => {
                const itemId = button.getAttribute('data-id');
                const price = parseFloat(button.getAttribute('data-price'));
                const quantityInput = document.getElementById('quantity-' + itemId);
                let currentQuantity = parseInt(quantityInput.value);
                quantityInput.value = currentQuantity + 1;

                updateCartQuantity(itemId, currentQuantity + 1, price);
            });
        });

        document.querySelectorAll('.decrease-btn').forEach(button => {
            button.addEventListener('click', () => {
                const itemId = button.getAttribute('data-id');
                const price = parseFloat(button.getAttribute('data-price'));
                const quantityInput = document.getElementById('quantity-' + itemId);
                let currentQuantity = parseInt(quantityInput.value);

                if (currentQuantity > 1) {
                    quantityInput.value = currentQuantity - 1;
                    updateCartQuantity(itemId, currentQuantity - 1, price);
                }
            });
        });
    </script>

    <?= $this->endSection() ?>