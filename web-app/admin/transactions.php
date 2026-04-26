<?php
session_start();
require_once '../config.php';
requireLogin();

if ($_SESSION['role'] !== 'Admin') {
    redirect('../login.php');
}

$conn = connectDB();
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id_transaksi = $_POST['id_transaksi'];
    $transaksi = $conn->query("SELECT id_mobil FROM tb_transaksi WHERE id_transaksi = '$id_transaksi'")->fetch_assoc();
    
    $stmt = $conn->prepare("DELETE FROM tb_transaksi WHERE id_transaksi = ?");
    $stmt->bind_param("s", $id_transaksi);
    
    if ($stmt->execute()) {
        if ($transaksi) {
            $conn->query("UPDATE tb_mobil SET status = TRUE WHERE id_mobil = '{$transaksi['id_mobil']}'");
        }
        $message = 'TRANSACTION DELETED SUCCESSFULLY';
        $messageType = 'success';
    }
    $stmt->close();
}

$transactions = $conn->query("
    SELECT t.*, p.nama as nama_pelanggan, m.merk, m.model, m.foto
    FROM tb_transaksi t
    JOIN tb_pelanggan p ON t.id_pelanggan = p.id_pelanggan
    JOIN tb_mobil m ON t.id_mobil = m.id_mobil
    ORDER BY t.tanggal DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANSACTIONS | REX RENTS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>
<body class="dashboard-page">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <h1 class="page-title">[ TRANSACTION HISTORY ]</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">[ <?php echo $messageType === 'success' ? 'SUCCESS' : 'ERROR'; ?> ] <?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>IMAGE</th>
                            <th>DATE</th>
                            <th>CUSTOMER</th>
                            <th>CAR</th>
                            <th>DURATION</th>
                            <th>FINE</th>
                            <th>TOTAL</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $transactions->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_transaksi']); ?></td>
                            <td>
                                <?php if ($row['foto']): ?>
                                    <img src="../assets/images/mobil/<?php echo htmlspecialchars($row['foto']); ?>" 
                                         alt="<?php echo htmlspecialchars($row['merk'] . ' ' . $row['model']); ?>"
                                         style="width: 80px; height: 60px; object-fit: cover; border: 2px solid var(--brutal-black);">
                                <?php else: ?>
                                    <span style="color: var(--brutal-gray);">[ NO IMAGE ]</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo formatDateIndo($row['tanggal']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                            <td><?php echo htmlspecialchars($row['merk'] . ' ' . $row['model']); ?></td>
                            <td><?php echo $row['durasi']; ?> days</td>
                            <td><?php echo formatRupiah($row['denda']); ?></td>
                            <td><?php echo formatRupiah($row['total_harga']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $row['status_kembali'] ? 'success' : 'warning'; ?>">
                                    <?php echo $row['status_kembali'] ? 'RETURNED' : 'RENTED'; ?>
                                </span>
                            </td>
                            <td class="actions">
                                <form method="POST" style="display:inline;" onsubmit="return confirm('CONFIRM DELETE?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id_transaksi" value="<?php echo htmlspecialchars($row['id_transaksi']); ?>">
                                    <button type="submit" class="btn btn-sm" style="background:#ef4444;color:white;">DELETE</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php $conn->close(); ?>
</body>
</html>
