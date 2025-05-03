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
    <div class="container py-4">
        <h2 class="text-center mb-4"><?= ucfirst($type) ?> Menu</h2>

        <div class="row menu-items">
            <?php if (!empty($menuItems)): ?>
                <?php foreach ($menuItems as $item): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4 menu-col">
                        <div class="menu-card text-center bg-white p-3 shadow-sm rounded h-100 d-flex flex-column justify-content-between">
                            <div class="image-parent mb-3">
                                <img src="<?= base_url('public/uploads/' . esc($item['image'])) ?>" alt="<?= esc($item['name']) ?>" class="img-fluid rounded">
                            </div>
                            <div>
                                <h5>
                                    <?= esc($item['name']) ?>
                                    <?php if ($item['type'] === 'veg'): ?>
                                        <span class="badge bg-success">Veg</span>
                                    <?php elseif ($item['type'] === 'non-veg'): ?>
                                        <span class="badge bg-danger">Non-Veg</span>
                                    <?php endif; ?>
                                </h5>
                                <p class="text-muted small"><?= esc($item['description']) ?></p>
                                <p class="fw-bold text-danger">₹<?= esc($item['price']) ?></p>
                            </div>

                            <form action="<?= base_url('cart/add') ?>" method="post" class="mt-2">
                                <?= csrf_field() ?>
                                <input type="hidden" name="food_id" value="<?= $item['id'] ?>">

                                <div class="row g-2 justify-content-center">
                                    <div class="col-md-5">
                                        <div class="input-group justify-content-center flex-wrap gap-2">
                                            <button type="button" class="btn btn-outline-secondary decrease-btn" data-id="<?= $item['id'] ?>">-</button>

                                            <!-- Corrected quantity input -->
                                            <input type="number" name="quantity" class="form-control text-center quantity-input"
                                                id="quantity-<?= $item['id'] ?>" value="1" min="1" readonly style="max-width: 80px;">

                                            <button type="button" class="btn btn-outline-secondary increase-btn" data-id="<?= $item['id'] ?>">+</button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">No <?= esc($type) ?> items found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        <?= $pager->links('default') ?>
    </div>
    </div>
</body>

</html>

</body>

</html>


<!-- JavaScript to handle the increment and decrement functionality for each item -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event delegation for the entire document to handle button clicks
        document.body.addEventListener('click', function(e) {
            // Check if the target is a decrease button
            if (e.target && e.target.classList.contains('decrease-btn')) {
                const quantityInput = e.target.closest('.input-group').querySelector('.quantity-input');
                let currentValue = parseInt(quantityInput.value, 10);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1; // Decrease the quantity
                }
            }

            // Check if the target is an increase button
            if (e.target && e.target.classList.contains('increase-btn')) {
                const quantityInput = e.target.closest('.input-group').querySelector('.quantity-input');
                let currentValue = parseInt(quantityInput.value, 10);
                quantityInput.value = currentValue + 1; // Increase the quantity
            }
        });
    });
</script>
<?= $this->endSection('content') ?>