<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h3 class="mb-3">📄 Invoice #<?= esc($orderGroupId) ?></h3>

        <?php if (isset($orders) && !empty($orders)): ?>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>🍽️ Food Item</th>
                        <th>🔢 Quantity</th>
                        <th>💰 Price</th>
                        <th>💰 Total</th>
                        <th>📦 Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grandTotal = 0;
                    foreach ($orders as $order):
                        $itemTotal = $order['total_price'];
                        $grandTotal += $itemTotal;
                    ?>
                        <tr>
                            <td><?= esc($order['food_item']) ?></td>
                            <td><?= esc($order['quantity']) ?></td>
                            <td>₹ <?= number_format($order['total_price'] / $order['quantity'], 2) ?></td>
                            <td>₹ <?= number_format($itemTotal, 2) ?></td>
                            <td><?= esc($order['status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-warning">
                        <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                        <td colspan="2"><strong>₹ <?= number_format($grandTotal, 2) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p>No invoices found.</p>
        <?php endif; ?>
    </div>
</div>






<a href="<?= base_url('/customer/dashboard') ?>" class="btn btn-primary mt-3">⬅️ Back to Dashboard</a>
</div>
</div>


<?= $this->endSection() ?>