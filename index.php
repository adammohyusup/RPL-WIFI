<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>WiFi Subscription Login</title>
    <link rel="stylesheet" href="test/style.css">
</head>
<body>
    <div class="container">
        <div>
        <h2>Login</h2>
        <form action="php/login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="radio" id="pelanggan" name="role" value="pelanggan" required>
            <label for="pelanggan">Pelanggan</label>
            
            <input type="radio" id="petugas" name="role" value="petugas" required>
            <label for="petugas">Petugas</label>
            
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Buat Akun Baru</a>
        </div>
    </div>
</body>
</html>
