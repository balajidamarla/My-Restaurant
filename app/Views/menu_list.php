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
    <div id="filteredMenu" class="row menu-items">
        <?php if (!empty($menuItems)): ?>
            <?php foreach ($menuItems as $item): ?>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4 menu-col">
                    <div class="menu-card text-center bg-white p-3 shadow-sm rounded h-100 d-flex flex-column justify-content-between">
                        <div class="image-parent mb-3">
                            <img src="<?= base_url('public/uploads/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>" class="img-fluid rounded">
                        </div>
                        <div>
                            <h5><?= esc($item['name']) ?></h5>
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

                                        <!-- Important: Name attribute is missing below -->
                                        <input type="number" name="quantity" class="form-control text-center quantity-input" id="quantity-<?= $item['id'] ?>" value="1" min="1" readonly style="max-width: 80px;">

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
            <p class="text-center">No menu items found.</p>
        <?php endif; ?>
    </div>

    </div>
    <?php if (isset($pager)) : ?>
        <div class="d-flex justify-content-center mt-4">
            <?= $pager->links() ?>
        </div>
    <?php endif; ?>

</body>

</html>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event delegation for increment and decrement buttons
        document.body.addEventListener('click', function(e) {
            // Decrease button functionality
            if (e.target && e.target.classList.contains('decrease-btn')) {
                const quantityInput = e.target.closest('.input-group').querySelector('.quantity-input');
                let currentValue = parseInt(quantityInput.value, 10);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1; // Decrease the number by 1
                }
            }

            // Increase button functionality
            if (e.target && e.target.classList.contains('increase-btn')) {
                const quantityInput = e.target.closest('.input-group').querySelector('.quantity-input');
                let currentValue = parseInt(quantityInput.value, 10);
                quantityInput.value = currentValue + 1; // Increase the number by 1
            }
        });
    });
</script>