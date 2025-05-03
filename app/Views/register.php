<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

    <h2>User Registration</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <form method="post" action="<?= site_url('register/submit') ?>">
        <?= csrf_field() ?>

        <label>Name:</label>
        <input type="text" name="name" value="<?= old('name') ?>"><br>
        <?php if (isset($validation) && $validation->hasError('name')): ?>
            <small style="color: red;"><?= $validation->getError('name') ?></small><br>
        <?php endif; ?>
        <br>

        <label>Email:</label>
        <input type="email" name="email" value="<?= old('email') ?>"><br>
        <?php if (isset($validation) && $validation->hasError('email')): ?>
            <small style="color: red;"><?= $validation->getError('email') ?></small><br>
        <?php endif; ?>
        <br>

        <label>Password:</label>
        <input type="password" name="password"><br>
        <?php if (isset($validation) && $validation->hasError('password')): ?>
            <small style="color: red;"><?= $validation->getError('password') ?></small><br>
        <?php endif; ?>
        <br>

        <input type="submit" value="Register">
        <a href="<?= site_url('login') ?>">
            <input type="button" value="Login">
        </a>
    </form>

</body>
</html>
