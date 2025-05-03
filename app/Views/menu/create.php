<?= view('layout/header') ?>

<div class="container mt-5">
    <h2>Add New Menu Items</h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $itemErrors): ?>
                    <?php foreach ((array)$itemErrors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('/menu/store') ?>" method="post" enctype="multipart/form-data" id="menuForm">
        <?= csrf_field() ?>

        <div id="itemContainer">
            <div class="item border p-3 mb-4">
                <h5>Item #1</h5>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="items[0][name]" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="items[0][description]" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="items[0][price]" class="form-control" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="items[0][image]" class="form-control" accept="image/*" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="items[0][type]" class="form-select" required>
                        <option value="veg">🥗 Veg</option>
                        <option value="non-veg">🍗 Non-Veg</option>
                    </select>
                </div>
                <button type="button" class="btn btn-danger remove-item d-none">Remove</button>
            </div>
        </div>

        <button type="button" class="btn btn-secondary" id="addMore">Add One More Item</button>
        <button type="submit" class="btn btn-primary">Submit All Items</button>
    </form>
</div>

<script>
    let itemIndex = 1;

    document.getElementById('addMore').addEventListener('click', function() {
        const container = document.getElementById('itemContainer');
        const newItem = document.querySelector('.item').cloneNode(true);

        newItem.querySelector('h5').innerText = `Item #${itemIndex + 1}`;
        newItem.querySelectorAll('input, textarea, select').forEach(input => {
            const name = input.getAttribute('name');
            const newName = name.replace(/items\[\d+]/, `items[${itemIndex}]`);
            input.setAttribute('name', newName);
            if (input.type !== 'file') input.value = '';
        });

        newItem.querySelector('.remove-item').classList.remove('d-none');
        container.appendChild(newItem);
        itemIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item').remove();
        }
    });
</script>

<?= view('layout/footer') ?>