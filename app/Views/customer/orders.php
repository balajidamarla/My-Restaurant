<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h3 class="mb-3">🛒 My Orders</h3>

        <?php if (!empty($orders)): ?>
            <?php
            // Group orders by order_group_id
            $groupedOrders = [];
            foreach ($orders as $order) {
                $groupedOrders[$order['order_group_id']][] = $order;
            }
            ?>

            <?php foreach ($groupedOrders as $groupId => $orderItems): ?>
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        🧾 Invoice: <?//= esc($groupId) ?>

                        <?php if (strtolower($orderItems[0]['status']) === 'delivered'): ?>
                            <a href="<?= base_url('customer/download_invoice/' . urlencode($groupId)) ?>" class="btn btn-success">
                                ⬇️ Download Invoice
                            </a>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>
                                ⏳ Invoice available after delivery
                            </button>
                        <?php endif; ?>
                    </div>

                    <ul class="list-group list-group-flush">
                        <?php $grandTotal = 0; ?>
                        <?php foreach ($orderItems as $item): ?>
                            <li class="list-group-item">
                                <strong>Food Item:</strong> <?= esc($item['food_item']) ?><br>
                                <strong>Quantity:</strong> <?= esc($item['quantity']) ?><br>
                                <strong>Total Price:</strong> ₹<?= esc($item['total_price']) ?><br>
                            </li>
                            <?php $grandTotal += $item['total_price']; ?>
                        <?php endforeach; ?>
                        <!-- Order Status Row -->
                        <li class="list-group-item">
                            <strong>Status:</strong> <?= esc($orderItems[0]['status']) ?>
                        </li>
                        <!-- Grand Total Row -->
                        <li class="list-group-item fw-bold">
                            💰 Grand Total: ₹<?= $grandTotal ?>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <p class="text-muted">You haven't placed any orders yet.</p>
        <?php endif; ?>

        <hr>
        <a href="<?= base_url('/customer/dashboard') ?>" class="btn btn-primary mt-3">⬅️ Back to Dashboard</a>
    </div>
</div>



<?= $this->endSection() ?>