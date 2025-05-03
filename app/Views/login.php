<?= $this->include('layout/header') ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>🔐 Login</h2>
        <a href="<?= base_url('customer/register') ?>" class="btn btn-outline-primary">Register</a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('/login') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label>Email</label>
            <input type="text" name="email" id="emailInput" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="customer" selected>Customer</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="#" class="text-decoration-none" id="forgotPasswordLink">Forgot Password?</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('forgotPasswordLink').addEventListener('click', function(event) {
        event.preventDefault();
        const email = document.getElementById('emailInput').value;
        if (email.trim() !== '') {
            // Redirect to forgot password with email as a query parameter
            window.location.href = "<?= base_url('customer/forgot_password') ?>?email=" + encodeURIComponent(email);
        } else {
            // If email is empty, just go to forgot password normally
            window.location.href = "<?= base_url('customer/forgot_password') ?>";
        }
    });
</script>