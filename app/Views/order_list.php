<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Pagination container styling */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        /* Pagination link styling */
        .pagination li {
            margin: 0 8px;
            position: relative;
        }

        /* Base pagination link */
        .pagination li a {
            display: block;
            padding: 10px 16px;
            text-decoration: none;
            color: #333;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        /* Hover effect for pagination link */
        .pagination li a:hover {
            background-color: #c0392b;
            color: #fff;
            border-color: #c0392b;
            transform: translateY(-3px);
        }

        /* Disabled state for pagination links */
        .pagination li.disabled a {
            color: #ccc;
            background-color: #f1f1f1;
            pointer-events: none;
            border-color: #ddd;
            transform: none;
        }

        /* Active page styling */
        .pagination li.active a {
            background-color: #c0392b;
            color: #fff;
            border-color: #c0392b;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
            font-weight: 700;
        }

        /* Arrow styling for "previous" and "next" */
        .pagination li a::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Add arrow icon to "previous" and "next" links */
        .pagination li a.prev::before {
            content: "←";
            font-size: 18px;
            margin-right: 5px;
        }

        .pagination li a.next::before {
            content: "→";
            font-size: 18px;
            margin-left: 5px;
        }

        /* Add rounded corners for the first and last page */
        .pagination li:first-child a {
            border-top-left-radius: 50%;
            border-bottom-left-radius: 50%;
        }

        .pagination li:last-child a {
            border-top-right-radius: 50%;
            border-bottom-right-radius: 50%;
        }

        /* Add spacing between pagination items */
        .pagination li {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2>📦 Order List</h2>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <!-- <th>👤 Customer</th>
                <th>📞 Phone</th> -->
                    <th>🍽️ Food Item</th>
                    <th>🔢 Quantity</th>
                    <th>💰 Total Price</th>
                    <th>📦 Status</th>
                    <th>📅 Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $index => $order): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <!-- <td><? //= esc($order['customer_name']) 
                                    ?></td>
                    <td><? //= esc($order['phone']) 
                        ?></td> -->
                        <td><?= esc($order['food_item']) ?></td>
                        <td><?= esc($order['quantity']) ?></td>
                        <td>₹ <?= esc($order['total_price']) ?></td>
                        <td>
                            <form action="<?= base_url('/orders/update-status/' . $order['id']) ?>" method="post" class="d-flex">
                                <?= csrf_field() ?>
                                <select name="status" class="form-select form-select-sm me-2">
                                    <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Preparing" <?= $order['status'] == 'Preparing' ? 'selected' : '' ?>>Preparing</option>
                                    <option value="Delivered" <?= $order['status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                        <td><?= esc($order['created_at'] ?? 'N/A') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="container mt-4">
            <div class="d-flex justify-content-center">
                <ul class="pagination">
                    <?= $pager->links('default') ?>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>


<?= $this->endSection() ?>