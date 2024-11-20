<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "SELECT `id_petugas`, `nama`, `no.hp`, `password` FROM `petugas` WHERE id_petugas = '$username' and password = '$password'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("location: ../home");
    } else {
        echo "No user found";
    }

    $conn->close();
}
?>
