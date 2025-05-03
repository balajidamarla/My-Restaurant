<?php

// use CodeIgniter\CLI\CLI;

// CLI::error('ERROR: ' . $code);
// CLI::write($message);
// CLI::newLine();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Page Not Found</title>
    <style>
        body { text-align: center; padding: 100px; font-family: Arial; }
        h1 { font-size: 50px; }
        p { font-size: 20px; }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>Oops! The page you're looking for doesn't exist.</p>
    <a href="<?= base_url() ?>">Return Home</a>
</body>
</html>
