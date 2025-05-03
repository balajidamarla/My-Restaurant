<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
</head>

<body>
    <h2>Login</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form method="post" action="<?= site_url('login/submit') ?>">
        <?= csrf_field() ?>

        <label>Email or Username:</label>
        <input type="text" name="email" value="<?= old('email') ?>"><br>
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

        <input type="submit" value="Login">

        <a href="<?= site_url('register') ?>">
            <input type="button" value="register">
        </a>
    </form>

</body>

</html>