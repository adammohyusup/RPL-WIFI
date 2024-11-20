<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$payment_id = $_POST['payment_id'];
$payment_method = $_POST['payment_method'];
$proof_of_payment = $_FILES['proof_of_payment'];

// Handle file upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($proof_of_payment["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file is an actual image or fake image
$check = getimagesize($proof_of_payment["tmp_name"]);
if($check !== false) {
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($proof_of_payment["size"] > 5000000) { // 5MB limit
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($proof_of_payment["tmp_name"], $target_file)) {
        // Update payment record with proof of payment
        $sql = "UPDATE payments SET proof_of_payment = '$target_file', status = 'paid', paid_date = CURRENT_DATE() WHERE id = $payment_id";

        if ($conn->query($sql) === TRUE) {
            echo "The file ". basename($proof_of_payment["name"]). " has been uploaded.";
            header("Location: ../pembayaran.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>
