<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
</head>
<body>

<h2>Contact Form</h2>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<?php if (isset($validation)): ?>
    <div style="color: red;">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('contact/submit') ?>" method="post">
    <?= csrf_field() ?>
    <label>Name:</label>
    <input type="text" name="name"><br><br>

    <label>Email:</label>
    <input type="email" name="email"><br><br>

    <label>Phone:</label>
    <input type="text" name="phone"><br><br>

    <label>Message:</label><br>
    <textarea name="message" cols="27"></textarea><br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>
