<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$complaint = $_POST['complaint'];

$sql = "INSERT INTO complaints (user_id, complaint) VALUES ($user_id, '$complaint')";

if ($conn->query($sql) === TRUE) {
    echo "Complaint submitted successfully";
    header("Location: ../pengaduan.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
