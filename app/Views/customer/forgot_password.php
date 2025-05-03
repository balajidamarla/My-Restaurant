<?= $this->include('layout/header') ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>📧 Email Verification</h2>
        <a href="<?= base_url('/login') ?>" class="btn btn-outline-primary">Back to Login</a>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php $enteredEmail = $email ?? ''; ?>

    <form action="<?= base_url('customer/send') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="email" class="form-label">📨 Enter your email ID</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="<?= esc($enteredEmail) ?>" placeholder="example@mail.com"
                   required autofocus autocomplete="email">
        </div>

        <button type="submit" class="btn btn-success">Verify</button>
    </form>
</div>
