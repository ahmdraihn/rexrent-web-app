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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $uploadDir = '../assets/images/mobil/';
    
    // Ensure upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    switch ($_POST['action']) {
        case 'add':
            $id_mobil = $_POST['id_mobil'];
            $model = $_POST['model'];
            $merk = $_POST['merk'];
            $hargasewa = $_POST['hargasewa'];
            $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;
            $biaya_maintenance = $hargasewa * 0.10;
            
            // Handle Photo Upload
            $foto = '';
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $foto = $id_mobil . '_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $foto);
            }
            
            $stmt = $conn->prepare("INSERT INTO tb_mobil (id_mobil, model, merk, hargasewa, status, foto, biaya_maintenance) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdiss", $id_mobil, $model, $merk, $hargasewa, $status, $foto, $biaya_maintenance);
            
            if ($stmt->execute()) {
                $message = 'CAR ADDED SUCCESSFULLY';
                $messageType = 'success';
            } else {
                $message = 'FAILED TO ADD CAR: ' . $conn->error;
                $messageType = 'error';
            }
            $stmt->close();
            break;
            
        case 'update':
            $id_mobil = $_POST['id_mobil'];
            $model = $_POST['model'];
            $merk = $_POST['merk'];
            $hargasewa = $_POST['hargasewa'];
            $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;
            $biaya_maintenance = $hargasewa * 0.10;
            
            // Handle Photo Upload
            $foto = $_POST['old_foto'] ?? '';
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                // Delete old photo if exists
                if ($foto && file_exists($uploadDir . $foto)) {
                    unlink($uploadDir . $foto);
                }
                
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $foto = $id_mobil . '_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], $uploadDir . $foto);
            }
            
            $stmt = $conn->prepare("UPDATE tb_mobil SET model=?, merk=?, hargasewa=?, status=?, foto=?, biaya_maintenance=? WHERE id_mobil=?");
            $stmt->bind_param("ssdisss", $model, $merk, $hargasewa, $status, $foto, $biaya_maintenance, $id_mobil);
            
            if ($stmt->execute()) {
                $message = 'CAR UPDATED SUCCESSFULLY';
                $messageType = 'success';
            } else {
                $message = 'FAILED TO UPDATE CAR: ' . $conn->error;
                $messageType = 'error';
            }
            $stmt->close();
            break;
            
        case 'delete':
            $id_mobil = $_POST['id_mobil'];
            $conn->query("DELETE FROM tb_transaksi WHERE id_mobil = '$id_mobil'");
            $stmt = $conn->prepare("DELETE FROM tb_mobil WHERE id_mobil = ?");
            $stmt->bind_param("s", $id_mobil);
            
            if ($stmt->execute()) {
                $message = 'CAR DELETED SUCCESSFULLY';
                $messageType = 'success';
            }
            $stmt->close();
            break;
    }
}

$cars = $conn->query("SELECT * FROM tb_mobil ORDER BY id_mobil ASC");
$nextId = generateNextIdMobil($conn);

$editCar = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $editCar = $conn->query("SELECT * FROM tb_mobil WHERE id_mobil = '$editId'")->fetch_assoc();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARS | REX RENTS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>
<body class="dashboard-page">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <h1 class="page-title">[ MANAGE CARS ]</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">[ <?php echo $messageType === 'success' ? 'SUCCESS' : 'ERROR'; ?> ] <?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <div class="form-container">
                <form method="POST" class="data-form" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?php echo $editCar ? 'update' : 'add'; ?>">
                    <?php if ($editCar): ?>
                        <input type="hidden" name="old_foto" value="<?php echo htmlspecialchars($editCar['foto']); ?>">
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="id_mobil">[ CAR ID ]</label>
                        <input type="text" id="id_mobil" name="id_mobil" value="<?php echo $editCar ? $editCar['id_mobil'] : $nextId; ?>" readonly required>
                    </div>
                    
                    <div class="form-group">
                        <label for="model">[ MODEL ]</label>
                        <input type="text" id="model" name="model" value="<?php echo $editCar ? htmlspecialchars($editCar['model']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="merk">[ BRAND ]</label>
                        <input type="text" id="merk" name="merk" value="<?php echo $editCar ? htmlspecialchars($editCar['merk']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="hargasewa">[ DAILY RATE (RP) ]</label>
                        <input type="number" id="hargasewa" name="hargasewa" value="<?php echo $editCar ? $editCar['hargasewa'] : ''; ?>" required min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="foto">[ PHOTO FILE ]</label>
                        <?php if ($editCar && $editCar['foto']): ?>
                            <div style="margin-bottom: 10px;">
                                <img src="../assets/images/mobil/<?php echo htmlspecialchars($editCar['foto']); ?>" style="width: 150px; border: 2px solid #000;">
                                <p style="font-size: 10px; color: #888;">Current: <?php echo htmlspecialchars($editCar['foto']); ?></p>
                            </div>
                        <?php endif; ?>
                        <input type="file" id="foto" name="foto" accept="image/*">
                        <p style="font-size: 11px; color: #888; margin-top: 5px;">Leave empty to keep existing photo.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">[ STATUS ]</label>
                        <select id="status" name="status">
                            <option value="1" <?php echo (!$editCar || $editCar['status']) ? 'selected' : ''; ?>>[ AVAILABLE ]</option>
                            <option value="0" <?php echo ($editCar && !$editCar['status']) ? 'selected' : ''; ?>>[ UNAVAILABLE ]</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <?php if ($editCar): ?>
                            <a href="cars.php" class="btn btn-outline">← CANCEL</a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary"><?php echo $editCar ? 'UPDATE →' : 'ADD CAR →'; ?></button>
                    </div>
                </form>
            </div>
            
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>IMAGE</th>
                            <th>MODEL</th>
                            <th>BRAND</th>
                            <th>DAILY RATE</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $cars->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_mobil']); ?></td>
                            <td>
                                <?php if ($row['foto']): ?>
                                    <img src="../assets/images/mobil/<?php echo htmlspecialchars($row['foto']); ?>" 
                                         alt="<?php echo htmlspecialchars($row['merk'] . ' ' . $row['model']); ?>"
                                         style="width: 80px; height: 60px; object-fit: cover; border: 2px solid var(--brutal-black);">
                                <?php else: ?>
                                    <span style="color: var(--brutal-gray);">[ NO IMAGE ]</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['model']); ?></td>
                            <td><?php echo htmlspecialchars($row['merk']); ?></td>
                            <td><?php echo formatRupiah($row['hargasewa']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $row['status'] ? 'success' : 'danger'; ?>">
                                    <?php echo $row['status'] ? 'AVAILABLE' : 'UNAVAILABLE'; ?>
                                </span>
                            </td>
                            <td class="actions">
                                <a href="?edit=<?php echo htmlspecialchars($row['id_mobil']); ?>" class="btn btn-sm btn-primary">EDIT</a>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('CONFIRM DELETE?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id_mobil" value="<?php echo htmlspecialchars($row['id_mobil']); ?>">
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
</body>
</html>
