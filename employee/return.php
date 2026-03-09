<?php
session_start();
require_once '../config.php';
requireLogin();

if ($_SESSION['role'] !== 'Employee') {
    redirect('../login.php');
}

$conn = connectDB();
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'return') {
    $id_transaksi = $_POST['id_transaksi'];
    $denda = floatval($_POST['denda']);
    
    $transaksi = $conn->query("SELECT * FROM tb_transaksi WHERE id_transaksi = '$id_transaksi'")->fetch_assoc();
    
    if ($transaksi) {
        $total_baru = $transaksi['total_harga'] + $denda;
        
        $stmt = $conn->prepare("UPDATE tb_transaksi SET denda = ?, total_harga = ?, status_kembali = TRUE, tanggal_kembali = CURDATE() WHERE id_transaksi = ?");
        $stmt->bind_param("dds", $denda, $total_baru, $id_transaksi);
        
        if ($stmt->execute()) {
            $conn->query("UPDATE tb_mobil SET status = TRUE WHERE id_mobil = '{$transaksi['id_mobil']}'");
            $message = 'RETURN PROCESSED SUCCESSFULLY';
            $messageType = 'success';
        } else {
            $message = 'FAILED TO PROCESS RETURN';
            $messageType = 'error';
        }
        $stmt->close();
    }
}

$activeRentals = $conn->query("
    SELECT t.*, p.nama as nama_pelanggan, p.noHP, m.merk, m.model, m.hargasewa
    FROM tb_transaksi t 
    JOIN tb_pelanggan p ON t.id_pelanggan = p.id_pelanggan 
    JOIN tb_mobil m ON t.id_mobil = m.id_mobil 
    WHERE t.status_kembali = FALSE
    ORDER BY t.tanggal ASC
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RETURN CAR | REX RENTS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dashboard-page">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <h1 class="page-title">[ RETURN CAR ]</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">[ <?php echo $messageType === 'success' ? 'SUCCESS' : 'ERROR'; ?> ] <?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>RENTAL DATE</th>
                            <th>CUSTOMER</th>
                            <th>CAR</th>
                            <th>DURATION</th>
                            <th>TOTAL</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($activeRentals->num_rows > 0): ?>
                            <?php while ($row = $activeRentals->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_transaksi']); ?></td>
                                <td><?php echo formatDateIndo($row['tanggal']); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($row['nama_pelanggan']); ?><br>
                                    <small style="color:var(--brutal-gray);"><?php echo htmlspecialchars($row['noHP']); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($row['merk'] . ' ' . $row['model']); ?></td>
                                <td><?php echo $row['durasi']; ?> days</td>
                                <td><?php echo formatRupiah($row['total_harga']); ?></td>
                                <td class="actions">
                                    <button type="button" class="btn btn-sm btn-primary" 
                                            onclick="openReturnModal('<?php echo htmlspecialchars($row['id_transaksi']); ?>', 
                                                                       '<?php echo htmlspecialchars($row['nama_pelanggan']); ?>', 
                                                                       '<?php echo htmlspecialchars($row['merk'] . ' ' . $row['model']); ?>', 
                                                                       <?php echo $row['hargasewa']; ?>)">
                                        PROCESS RETURN
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align:center;color:var(--brutal-gray);padding:40px 20px;">[ NO ACTIVE RENTALS ]</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Return Modal -->
    <div id="returnModal" class="modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>[ PROCESS RETURN ]</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="return">
                <input type="hidden" name="id_transaksi" id="modal_id_transaksi">
                
                <div class="form-group">
                    <label>TRANSACTION ID</label>
                    <input type="text" id="modal_transaksi_id" readonly>
                </div>
                
                <div class="form-group">
                    <label>CUSTOMER</label>
                    <input type="text" id="modal_pelanggan" readonly>
                </div>
                
                <div class="form-group">
                    <label>CAR</label>
                    <input type="text" id="modal_mobil" readonly>
                </div>
                
                <div class="form-group">
                    <label for="keterlambatan">[ LATE DAYS ]</label>
                    <input type="number" id="keterlambatan" name="keterlambatan" value="0" min="0" onchange="calculateDenda()">
                </div>
                
                <div class="form-group">
                    <label for="denda">[ FINE AMOUNT ]</label>
                    <input type="text" id="denda" name="denda" readonly value="Rp 0">
                    <input type="hidden" id="denda_value" name="denda_value" value="0">
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal()">CANCEL</button>
                    <button type="submit" class="btn btn-primary">CONFIRM RETURN →</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
    let hargaSewaPerHari = 0;
    
    function openReturnModal(idTransaksi, pelanggan, mobil, hargaSewa) {
        document.getElementById('modal_id_transaksi').value = idTransaksi;
        document.getElementById('modal_transaksi_id').value = idTransaksi;
        document.getElementById('modal_pelanggan').value = pelanggan;
        document.getElementById('modal_mobil').value = mobil;
        document.getElementById('keterlambatan').value = 0;
        document.getElementById('denda').value = 'Rp 0';
        document.getElementById('denda_value').value = 0;
        
        hargaSewaPerHari = hargaSewa;
        
        document.getElementById('returnModal').style.display = 'block';
    }
    
    function closeModal() {
        document.getElementById('returnModal').style.display = 'none';
    }
    
    function calculateDenda() {
        const keterlambatan = parseInt(document.getElementById('keterlambatan').value) || 0;
        const denda = keterlambatan * hargaSewaPerHari * 0.1;
        document.getElementById('denda').value = formatRupiah(denda);
        document.getElementById('denda_value').value = denda;
    }
    
    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }
    
    window.onclick = function(event) {
        const modal = document.getElementById('returnModal');
        if (event.target === modal) {
            closeModal();
        }
    }
    </script>
</body>
</html>
