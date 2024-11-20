<?php
session_start();
include 'php/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pilih Paket</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Pilih Paket</h2>
        <form action="php/paket.php" method="POST">
            <?php
            $sql = "SELECT * FROM packages";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div>";
                    echo "<input type='radio' id='paket_" . $row['id'] . "' name='package_id' value='" . $row['id'] . "' required>";
                    echo "<label for='paket_" . $row['id'] . "'>" . $row['name'] . " - " . $row['price'] . "</label>";
                    echo "</div>";
                }
            } else {
                echo "No packages found";
            }
            ?>
            <button type="submit">Konfirmasi</button>
        </form>
    </div>
</body>
</html>
