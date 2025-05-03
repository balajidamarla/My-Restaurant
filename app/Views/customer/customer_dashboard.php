<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Custom media query for 580px and up to behave like 2 columns */
        @media (min-width: 580px) and (max-width: 991.98px) {
            .col-custom-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center text-md-start mb-4" ><b>👋 Welcome, <?= esc(session('user_name')) ?>!</b></h2>

        <div class="row g-4">
            <div class="col-lg-4 col-custom-6 col-12">
                <div class="card text-center p-3 h-100 shadow-sm">
                    <h5>🍔 View Menu</h5>
                    <p>Find Your Flavor & Order</p>
                    <a href="<?= base_url('/menu/index') ?>" class="btn btn-primary mt-auto">Go to Menu</a>
                </div>
            </div>

            <div class="col-lg-4 col-custom-6 col-12">
                <div class="card text-center p-3 h-100 shadow-sm">
                    <h5>📦 My Orders</h5>
                    <p>Check your orders.</p>
                    <a href="<?= base_url('/customer/orders') ?>" class="btn btn-warning mt-auto">View Orders</a>
                </div>
            </div>

            <div class="col-lg-4 col-custom-6 col-12">
                <div class="card text-center p-3 h-100 shadow-sm">
                    <h5>🛒 View Cart</h5>
                    <p>View your cart items.</p>
                    <a href="<?= base_url('/cart/index') ?>" class="btn btn-success mt-auto">View Cart</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>






<?= $this->endSection() ?>