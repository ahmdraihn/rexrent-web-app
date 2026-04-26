<?php
session_start();
require_once '../config.php';
requireLogin();

if ($_SESSION['role'] !== 'Admin') {
    redirect('../login.php');
}

$conn = connectDB();

$totalMobil = $conn->query("SELECT COUNT(*) as total FROM tb_mobil")->fetch_assoc()['total'];
$totalPelanggan = $conn->query("SELECT COUNT(*) as total FROM tb_pelanggan")->fetch_assoc()['total'];
$totalTransaksi = $conn->query("SELECT COUNT(*) as total FROM tb_transaksi")->fetch_assoc()['total'];

$brutoData = $conn->query("SELECT SUM(total_harga) as total FROM tb_transaksi")->fetch_assoc();
$bruto = $brutoData['total'] ?? 0;

$maintenanceData = $conn->query("SELECT SUM(biaya_maintenance) as total FROM tb_mobil")->fetch_assoc();
$maintenance = $maintenanceData['total'] ?? 0;

$netto = $bruto - $maintenance;

$topPelanggan = $conn->query("
    SELECT p.nama, COUNT(t.id_transaksi) as jumlah_sewa 
    FROM tb_transaksi t 
    JOIN tb_pelanggan p ON t.id_pelanggan = p.id_pelanggan 
    GROUP BY p.id_pelanggan, p.nama 
    ORDER BY jumlah_sewa DESC 
    LIMIT 5
");

$recentTransaksi = $conn->query("
    SELECT t.*, p.nama as nama_pelanggan, m.merk, m.model 
    FROM tb_transaksi t 
    JOIN tb_pelanggan p ON t.id_pelanggan = p.id_pelanggan 
    JOIN tb_mobil m ON t.id_mobil = m.id_mobil 
    ORDER BY t.tanggal DESC 
    LIMIT 5
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
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>
<body class="dashboard-page">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <h1 class="page-title">[ ADMIN DASHBOARD ]</h1>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="ti ti-car stat-icon"></i>
                    <div class="stat-info">
                        <h3><?php echo $totalMobil; ?></h3>
                        <p>TOTAL CARS</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="ti ti-users stat-icon"></i>
                    <div class="stat-info">
                        <h3><?php echo $totalPelanggan; ?></h3>
                        <p>TOTAL CUSTOMERS</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="ti ti-clipboard-list stat-icon"></i>
                    <div class="stat-info">
                        <h3><?php echo $totalTransaksi; ?></h3>
                        <p>TOTAL TRANSACTIONS</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="ti ti-cash stat-icon"></i>
                    <div class="stat-info">
                        <h3><?php echo formatRupiah($bruto); ?></h3>
                        <p>GROSS REVENUE</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="ti ti-wrench stat-icon"></i>
                    <div class="stat-info">
                        <h3><?php echo formatRupiah($maintenance); ?></h3>
                        <p>MAINTENANCE COST</p>
                    </div>
                </div>

                <div class="stat-card">
                    <i class="ti ti-chart-line stat-icon"></i>
                    <div class="stat-info">
                        <h3><?php echo formatRupiah($netto); ?></h3>
                        <p>NET REVENUE</p>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-grid">
                <div class="card">
                    <div class="card-header">[ TOP 5 CUSTOMERS ]</div>
                    <div class="card-body">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>RENTALS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                while ($row = $topPelanggan->fetch_assoc()): 
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                    <td><?php echo $row['jumlah_sewa']; ?>x</td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">[ RECENT TRANSACTIONS ]</div>
                    <div class="card-body">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>DATE</th>
                                    <th>CUSTOMER</th>
                                    <th>CAR</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ($row = $recentTransaksi->fetch_assoc()): 
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id_transaksi']); ?></td>
                                    <td><?php echo formatDateIndo($row['tanggal']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                                    <td><?php echo htmlspecialchars($row['merk'] . ' ' . $row['model']); ?></td>
                                    <td><?php echo formatRupiah($row['total_harga']); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
