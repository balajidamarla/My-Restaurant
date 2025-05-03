<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>✏️ Edit Menu Item</h2>

    <form action="<?= base_url('menu/update/' . $item['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= esc($item['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?= esc($item['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= esc($item['price']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Current Image:</label><br>
            <?php if ($item['image']) : ?>
                <img src="<?= base_url('public/uploads/' . $item['image']) ?>" width="150" height="100" style="object-fit: cover;">
            <?php else : ?>
                <span class="text-muted">No image</span>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label>Change Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">💾 Update</button>
        <a href="<?= base_url('/menu') ?>" class="btn btn-secondary">🔙 Back</a>
    </form>
</div>

<?= $this->endSection() ?>
