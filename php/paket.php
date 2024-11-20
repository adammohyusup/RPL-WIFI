<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$package_id = $_POST['package_id'];

// Check if the user has any unpaid bills
$sql = "SELECT * FROM payments WHERE user_id = $user_id AND status = 'pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "You have unpaid bills. Please pay them before selecting a new package.";
    exit();
}

// Proceed with the package selection
$sql = "INSERT INTO payments (user_id, package_id, amount, due_date, status) VALUES ($user_id, $package_id, (SELECT price FROM packages WHERE id = $package_id), DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH), 'pending')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../pembayaran.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
