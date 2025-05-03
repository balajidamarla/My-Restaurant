<?= $this->include('layout/header') ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>📝 Customer Registration</h2>
        <a href="<?= base_url('/login') ?>" class="btn btn-outline-primary">Back to Login</a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('customer/store') ?>" method="post">
    <?= csrf_field() ?>
        <div class="mb-3">
            <label for="name" class="form-label">👤 Name</label>
            <input name="name" id="name" class="form-control" placeholder="Enter your name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">📧 Email</label>
            <input name="email" type="email" id="email" class="form-control" placeholder="Enter your email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">🔒 Password</label>
            <input name="password" type="password" id="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <button type="submit" class="btn btn-success">✅ Register</button>
    </form>
</div>


