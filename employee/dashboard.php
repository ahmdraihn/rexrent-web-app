<?php
session_start();
require_once '../config.php';
requireLogin();

if ($_SESSION['role'] !== 'Employee') {
    redirect('../login.php');
}

$conn = connectDB();

$totalTransaksi = $conn->query("SELECT COUNT(*) as total FROM tb_transaksi")->fetch_assoc()['total'];
$mobilTersedia = $conn->query("SELECT COUNT(*) as total FROM tb_mobil WHERE status = TRUE")->fetch_assoc()['total'];
$mobilDisewa = $conn->query("SELECT COUNT(*) as total FROM tb_mobil WHERE status = FALSE")->fetch_assoc()['total'];

$activeRentals = $conn->query("
    SELECT t.*, p.nama as nama_pelanggan, m.merk, m.model 
    FROM tb_transaksi t 
    JOIN tb_pelanggan p ON t.id_pelanggan = p.id_pelanggan 
    JOIN tb_mobil m ON t.id_mobil = m.id_mobil 
    WHERE t.status_kembali = FALSE
    ORDER BY t.tanggal DESC 
    LIMIT 10
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD | REX RENTS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dashboard-page">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <h1 class="page-title">[ PEGAWAI DASHBOARD ]</h1>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📋</div>
                    <div class="stat-info">
                        <h3><?php echo $totalTransaksi; ?></h3>
                        <p>TOTAL TRANSACTIONS</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-info">
                        <h3><?php echo $mobilTersedia; ?></h3>
                        <p>CARS AVAILABLE</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🚗</div>
                    <div class="stat-info">
                        <h3><?php echo $mobilDisewa; ?></h3>
                        <p>CARS RENTED</p>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">[ ACTIVE RENTALS ]</div>
                <div class="card-body">
                    <?php if ($activeRentals->num_rows > 0): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>DATE</th>
                                <th>CUSTOMER</th>
                                <th>CAR</th>
                                <th>DURATION</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            while ($row = $activeRentals->fetch_assoc()): 
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_transaksi']); ?></td>
                                <td><?php echo formatDateIndo($row['tanggal']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                                <td><?php echo htmlspecialchars($row['merk'] . ' ' . $row['model']); ?></td>
                                <td><?php echo $row['durasi']; ?> days</td>
                                <td><?php echo formatRupiah($row['total_harga']); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p style="text-align:center;color:var(--brutal-gray);padding:40px 20px;font-family:'JetBrains Mono',monospace;">[ NO ACTIVE RENTALS ]</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="quick-actions">
                <a href="rental.php" class="quick-action-card">
                    <div class="quick-action-icon">➕</div>
                    <h3>[ NEW RENTAL ]</h3>
                    <p>Create a new rental transaction</p>
                </a>
                
                <a href="return.php" class="quick-action-card">
                    <div class="quick-action-icon">↩️</div>
                    <h3>[ RETURN CAR ]</h3>
                    <p>Process car return</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
