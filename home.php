<?php

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Home</h2>
        <?php if ($role == 'pelanggan') { ?>
            <h3>Paket WiFi yang Tersedia</h3>
            <?php
            $sql = "SELECT * FROM packages";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div>";
                    echo "<h4>" . $row['name'] . "</h4>";
                    echo "<p>" . $row['description'] . "</p>";
                    echo "<p>Harga: " . $row['price'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "No packages found";
            }
            ?>
        <?php } else if ($role == 'petugas') { ?>
            <h3>Dashboard Petugas</h3>
            <?php
            $sql1 = "SELECT COUNT(*) AS total_customers FROM users WHERE role = 'pelanggan'";
            $sql2 = "SELECT COUNT(*) AS paid_customers FROM payments WHERE status = 'paid' AND MONTH(paid_date) = MONTH(CURRENT_DATE())";
            $result1 = $conn->query($sql1);
            $result2 = $conn->query($sql2);

            if ($result1->num_rows > 0) {
                $row1 = $result1->fetch_assoc();
                echo "<p>Jumlah Pelanggan: " . $row1['total_customers'] . "</p>";
            }

            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                echo "<p>Jumlah Pelanggan yang Sudah Membayar: " . $row2['paid_customers'] . "</p>";
            }
            ?>
        <?php } ?>
    </div>
</body>
</html>

