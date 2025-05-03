<?= $this->include('layout/header') ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>🔐 Customer Login</h2>
        <a href="<?= base_url('/customer/register') ?>" class="btn btn-outline-primary">Register</a>
    </div>



    <form action="<?= base_url('/customer/authenticate') ?>" method="post">
        <?= csrf_field() ?>
        <?= session()->getFlashdata('error') ? '<div class="alert alert-danger">' . session()->getFlashdata('error') . '</div>' : '' ?>

        <div class="mb-3">
            <label>Email</label>
            <input type="text" name="email" class="form-control" required>
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
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

</div>

<?= $this->include('layout/footer') ?>