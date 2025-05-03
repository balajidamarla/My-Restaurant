<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSRF Error</title>
    <style>
        body {
            background-color: #f8d7da;
            color: #721c24;
            font-family: Arial, sans-serif;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border: 1px solid #f5c6cb;
            border-radius: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>403 - Forbidden</h1>
        <p>Invalid or missing CSRF token. Please go back and try again.</p>
        <a href="<?= base_url() ?>" style="color: #721c24; font-weight: bold;">Return to Homepage</a>
    </div>
</body>
</html>
