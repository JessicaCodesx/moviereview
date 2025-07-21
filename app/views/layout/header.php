<?php

$config = require CONFIG_PATH . '/app.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['app_name']; ?></title>
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎬 <?php echo $config['app_name']; ?></h1>
            <p>Search, Rate & Review Your Favorite Movies</p>
        </div>
