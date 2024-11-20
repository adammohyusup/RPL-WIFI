<?php
session_start();
include 'php/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Pembayaran</h2>
        <?php if ($role == 'pelanggan') { ?>
            <?php
            $sql = "SELECT p.id, p.amount, p.due_date, p.status, pk.name, pk.price, IF(CURRENT_DATE() > p.due_date, 50, 0) AS denda
                    FROM payments p
                    JOIN packages pk ON p.package_id = pk.id
                    WHERE p.user_id = $user_id AND p.status = 'pending' LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $total = $row['amount'] + $row['denda'];
                ?>
                <p>Paket: <?php echo $row['name']; ?></p>
                <p>Tagihan: <?php echo $row['amount']; ?></p>
                <p>Denda: <?php echo $row['denda']; ?></p>
                <p>Total: <?php echo $total; ?></p>
                <form action="php/pembayaran.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                    <label for="payment_method">Metode Pembayaran:</label>
                    <select id="payment_method" name="payment_method" required>
                        <option value="transfer">Transfer</option>
                    </select>
                    <label for="proof_of_payment">Bukti Pembayaran:</label>
                    <input type="file" id="proof_of_payment" name="proof_of_payment" required>
                    <button type="submit">Kirim</button>
                </form>
                <?php
            } else {
                echo "<p>Anda sudah melakukan pembayaran pada bulan ini</p>";
            }
            ?>
        <?php } else if ($role == 'petugas') { ?>
            <h3>Informasi Pembayaran Pelanggan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Username</th>
                        <th>Bukti Transfer</th>
                        <th>Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT u.username, u.address, u.phone, p.proof_of_payment, p.status
                            FROM users u
                            JOIN payments p ON u.id = p.user_id
                            WHERE u.role = 'pelanggan'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";
                            echo "<td>" . $row['proof_of_payment'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No payments found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</body>
</html>
