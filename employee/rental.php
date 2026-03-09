<?php
session_start();
require_once '../config.php';
requireLogin();

if ($_SESSION['role'] !== 'Employee') {
    redirect('../login.php');
}

$conn = connectDB();

// Get data for form display
$availableCars = $conn->query("SELECT * FROM tb_mobil WHERE status = TRUE ORDER BY id_mobil ASC");
$customers = $conn->query("SELECT * FROM tb_pelanggan ORDER BY nama ASC");

// Get debug info
$dbgCustomers = $conn->query("SELECT GROUP_CONCAT(id_pelanggan) as ids FROM tb_pelanggan")->fetch_assoc();
$dbgCars = $conn->query("SELECT GROUP_CONCAT(id_mobil) as ids FROM tb_mobil WHERE status=TRUE")->fetch_assoc();
$customerIds = $dbgCustomers['ids'] ?? 'NONE';
$carIds = $dbgCars['ids'] ?? 'NONE';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pelanggan = trim($_POST['id_pelanggan'] ?? '');
    $id_mobil = trim($_POST['id_mobil'] ?? '');
    $durasi = intval($_POST['durasi'] ?? 0);

    if (empty($id_pelanggan) || empty($id_mobil) || $durasi <= 0) {
        $message = 'ALL FIELDS REQUIRED';
        $messageType = 'error';
    } else {
        // Verify customer exists
        $customer = $conn->query("SELECT id_pelanggan FROM tb_pelanggan WHERE id_pelanggan = '$id_pelanggan'");
        if (!$customer || $customer->num_rows === 0) {
            $message = 'INVALID CUSTOMER: ' . $id_pelanggan;
            $messageType = 'error';
        } else {
            // Verify car exists and is available
            $mobil = $conn->query("SELECT * FROM tb_mobil WHERE id_mobil = '$id_mobil' AND status = TRUE");

            if (!$mobil || $mobil->num_rows === 0) {
                $checkCar = $conn->query("SELECT id_mobil, status FROM tb_mobil WHERE id_mobil = '$id_mobil'");
                if ($checkCar && $checkCar->num_rows > 0) {
                    $carData = $checkCar->fetch_assoc();
                    if ($carData['status'] == 0) {
                        $message = 'CAR UNAVAILABLE: ' . $id_mobil;
                    } else {
                        $message = 'CAR NOT FOUND: ' . $id_mobil;
                    }
                } else {
                    $message = 'CAR NOT FOUND: ' . $id_mobil;
                }
                $messageType = 'error';
            } else {
                $mobilData = $mobil->fetch_assoc();
                $total_harga = $mobilData['hargasewa'] * $durasi;
                $id_transaksi = generateNextIdTransaksi($conn);
                $tanggal = date('Y-m-d');
                
                // Use direct INSERT
                $sql = "INSERT INTO tb_transaksi (id_transaksi, tanggal, id_pelanggan, id_mobil, durasi, denda, total_harga) 
                        VALUES ('$id_transaksi', '$tanggal', '$id_pelanggan', '$id_mobil', $durasi, 0, $total_harga)";
                
                if ($conn->query($sql)) {
                    $conn->query("UPDATE tb_mobil SET status = FALSE WHERE id_mobil = '$id_mobil'");
                    $message = 'RENTAL CREATED SUCCESSFULLY';
                    $messageType = 'success';
                    // Refresh car list
                    $availableCars = $conn->query("SELECT * FROM tb_mobil WHERE status = TRUE ORDER BY id_mobil ASC");
                } else {
                    $message = 'DATABASE ERROR: ' . $conn->error;
                    $messageType = 'error';
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEW RENTAL | REX RENTS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dashboard-page">
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <?php include 'includes/header.php'; ?>

        <div class="content-wrapper">
            <h1 class="page-title">[ NEW RENTAL ]</h1>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    [ <?php echo $messageType === 'success' ? 'SUCCESS' : 'ERROR'; ?> ] 
                    <?php echo htmlspecialchars($message); ?>
                    <?php if ($messageType === 'error'): ?>
                        <br><br>
                        <strong>Debug Info:</strong><br>
                        Submitted ID Pelanggan: <code><?php echo isset($_POST['id_pelanggan']) ? htmlspecialchars($_POST['id_pelanggan']) : 'not set'; ?></code><br>
                        Submitted ID Mobil: <code><?php echo isset($_POST['id_mobil']) ? htmlspecialchars($_POST['id_mobil']) : 'not set'; ?></code><br>
                        Duration: <code><?php echo isset($_POST['durasi']) ? htmlspecialchars($_POST['durasi']) : 'not set'; ?></code>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-container">
                <!-- Debug: Show what's in database -->
                <div style="background:#f0f0f0;padding:15px;margin-bottom:20px;border:2px solid #000;font-family:monospace;font-size:12px;">
                    <strong>[DEBUG] Available IDs in Database:</strong><br>
                    Customers: <?php echo $customerIds; ?><br>
                    Cars (Available): <?php echo $carIds; ?>
                </div>
                
                <form method="POST" class="data-form">
                    <div class="form-group">
                        <label for="id_pelanggan">[ SELECT CUSTOMER ]</label>
                        <select id="id_pelanggan" name="id_pelanggan" required>
                            <option value="">-- CHOOSE CUSTOMER --</option>
                            <?php while ($p = $customers->fetch_assoc()): ?>
                                <option value="<?php echo $p['id_pelanggan']; ?>">
                                    <?php echo htmlspecialchars($p['nama']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_mobil">[ SELECT CAR ]</label>
                        <select id="id_mobil" name="id_mobil" required onchange="updateCarInfo()">
                            <option value="">-- CHOOSE CAR --</option>
                            <?php while ($m = $availableCars->fetch_assoc()): ?>
                                <option value="<?php echo $m['id_mobil']; ?>"
                                        data-merk="<?php echo htmlspecialchars($m['merk']); ?>"
                                        data-model="<?php echo htmlspecialchars($m['model']); ?>"
                                        data-harga="<?php echo $m['hargasewa']; ?>">
                                    <?php echo htmlspecialchars($m['merk'] . ' ' . $m['model']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mobil_info">[ CAR INFO ]</label>
                        <input type="text" id="mobil_info" readonly placeholder="Select a car to see info">
                    </div>

                    <div class="form-group">
                        <label for="durasi">[ RENTAL DURATION (DAYS) ]</label>
                        <select id="durasi" name="durasi" required onchange="calculateTotal()">
                            <?php for ($i = 1; $i <= 30; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?> DAYS</option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="total_harga">[ TOTAL PRICE ]</label>
                        <input type="text" id="total_harga" readonly placeholder="Rp 0">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">CREATE RENTAL →</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function updateCarInfo() {
        const select = document.getElementById('id_mobil');
        const option = select.options[select.selectedIndex];
        const infoField = document.getElementById('mobil_info');

        if (option.value) {
            const merk = option.getAttribute('data-merk');
            const model = option.getAttribute('data-model');
            const harga = parseInt(option.getAttribute('data-harga'));
            infoField.value = `${merk} ${model} - ${formatRupiah(harga)}/day`;
        } else {
            infoField.value = '';
        }
        calculateTotal();
    }

    function calculateTotal() {
        const select = document.getElementById('id_mobil');
        const option = select.options[select.selectedIndex];
        const durasi = parseInt(document.getElementById('durasi').value) || 0;
        const totalField = document.getElementById('total_harga');

        if (option.value) {
            const harga = parseInt(option.getAttribute('data-harga'));
            const total = harga * durasi;
            totalField.value = formatRupiah(total);
        } else {
            totalField.value = '';
        }
    }

    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }
    </script>
</body>
</html>
<?php $conn->close(); ?>
