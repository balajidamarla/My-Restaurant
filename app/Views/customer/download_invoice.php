<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice - <?= esc($order_group_id) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 40px;
        }

        .invoice-container {
            max-width: 850px;
            margin: auto;
            background: #fff;
            padding: 40px 50px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #c0392b;
            padding-bottom: 20px;
        }

        .header .brand {
            font-size: 30px;
            font-weight: bold;
            color: #ffb703 ;
            
        }

        .header .invoice-title {
            font-size: 20px;
            font-weight: 500;
        }

        .section {
            margin-top: 30px;
        }

        .section h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #444;
        }

        .section p {
            margin: 4px 0;
            font-size: 15px;
        }

        .section p span {
            font-weight: bold;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table thead {
            background-color: #fff3e0;
        }

        table th,
        table td {
            padding: 14px 12px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        table th {
            font-size: 15px;
            color: #c0392b;
        }

        table td {
            font-size: 14px;
        }

        .grand-total {
            background-color: #fffde7;
            font-weight: bold;
        }

        .grand-total td {
            font-size: 15px;
            color: #2e2e2e;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 13px;
            color: #777;
        }

        .footer p {
            margin: 4px 0;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                border-radius: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="invoice-container">
        <div class="header">
            <div class="brand">My Restaurant</div>
            <div class="invoice-title">INVOICE</div>
        </div>

        <div class="section">
            <p><span>Customer Name:</span> <?= esc($customer_name) ?></p>
            <p><span>Invoice ID:</span> <?= esc($order_group_id) ?></p>
            <p><span>Date:</span> <?= date('d-m-Y') ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Food Item</th>
                    <th>Quantity</th>
                    <th>Total Price (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php $grandTotal = 0; ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= esc($order['food_item']) ?></td>
                        <td><?= esc($order['quantity']) ?></td>
                        <td><?= esc($order['total_price']) ?></td>
                    </tr>
                    <?php $grandTotal += $order['total_price']; ?>
                <?php endforeach; ?>
                <tr class="grand-total">
                    <td colspan="2">Grand Total</td>
                    <td>Rs.<?= $grandTotal ?></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Thank you for your order!</p>
            <p>We hope to see you again soon.</p>
            <p>~ My Restaurant Team</p>
        </div>
    </div>

</body>

</html>