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
    switch ($_POST['action']) {
        case 'add':
            $id = $_POST['id_pelanggan'];
            $nama = $_POST['nama'];
            $noHP = $_POST['noHP'];
            $noKTP = $_POST['noKTP'];
            $alamat = $_POST['alamat'];
            $gender = $_POST['gender'];
            
            $stmt = $conn->prepare("INSERT INTO tb_pelanggan (id_pelanggan, nama, noHP, noKTP, alamat, gender) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $id, $nama, $noHP, $noKTP, $alamat, $gender);
            
            if ($stmt->execute()) {
                $message = 'CUSTOMER ADDED SUCCESSFULLY';
                $messageType = 'success';
            }
            $stmt->close();
            break;
            
        case 'update':
            $id = $_POST['id_pelanggan'];
            $nama = $_POST['nama'];
            $noHP = $_POST['noHP'];
            $noKTP = $_POST['noKTP'];
            $alamat = $_POST['alamat'];
            $gender = $_POST['gender'];
            
            $stmt = $conn->prepare("UPDATE tb_pelanggan SET nama=?, noHP=?, noKTP=?, alamat=?, gender=? WHERE id_pelanggan=?");
            $stmt->bind_param("ssssss", $nama, $noHP, $noKTP, $alamat, $gender, $id);
            
            if ($stmt->execute()) {
                $message = 'CUSTOMER UPDATED SUCCESSFULLY';
                $messageType = 'success';
            }
            $stmt->close();
            break;
            
        case 'delete':
            $id = $_POST['id_pelanggan'];
            $stmt = $conn->prepare("DELETE FROM tb_pelanggan WHERE id_pelanggan = ?");
            $stmt->bind_param("s", $id);
            
            if ($stmt->execute()) {
                $message = 'CUSTOMER DELETED SUCCESSFULLY';
                $messageType = 'success';
            }
            $stmt->close();
            break;
    }
}

$customers = $conn->query("SELECT * FROM tb_pelanggan ORDER BY id_pelanggan ASC");
$nextId = generateNextIdPelanggan($conn);

$editCustomer = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $editCustomer = $conn->query("SELECT * FROM tb_pelanggan WHERE id_pelanggan = '$editId'")->fetch_assoc();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUSTOMERS | REX RENTS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dashboard-page">
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'includes/header.php'; ?>
        
        <div class="content-wrapper">
            <h1 class="page-title">[ MANAGE CUSTOMERS ]</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">[ <?php echo $messageType === 'success' ? 'SUCCESS' : 'ERROR'; ?> ] <?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <div class="form-container">
                <form method="POST" class="data-form">
                    <input type="hidden" name="action" value="<?php echo $editCustomer ? 'update' : 'add'; ?>">
                    
                    <div class="form-group">
                        <label for="id_pelanggan">[ CUSTOMER ID ]</label>
                        <input type="text" id="id_pelanggan" name="id_pelanggan" value="<?php echo $editCustomer ? $editCustomer['id_pelanggan'] : $nextId; ?>" readonly required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama">[ FULL NAME ]</label>
                        <input type="text" id="nama" name="nama" value="<?php echo $editCustomer ? htmlspecialchars($editCustomer['nama']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="noHP">[ PHONE NUMBER ]</label>
                        <input type="text" id="noHP" name="noHP" value="<?php echo $editCustomer ? htmlspecialchars($editCustomer['noHP']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="noKTP">[ ID NUMBER (KTP) ]</label>
                        <input type="text" id="noKTP" name="noKTP" value="<?php echo $editCustomer ? htmlspecialchars($editCustomer['noKTP']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat">[ ADDRESS ]</label>
                        <textarea id="alamat" name="alamat" rows="3" required><?php echo $editCustomer ? htmlspecialchars($editCustomer['alamat']) : ''; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="gender">[ GENDER ]</label>
                        <select id="gender" name="gender" required>
                            <option value="L" <?php echo ($editCustomer && $editCustomer['gender'] === 'L') ? 'selected' : ''; ?>>[ MALE ]</option>
                            <option value="P" <?php echo ($editCustomer && $editCustomer['gender'] === 'P') ? 'selected' : ''; ?>>[ FEMALE ]</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <?php if ($editCustomer): ?>
                            <a href="customers.php" class="btn btn-outline">← CANCEL</a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary"><?php echo $editCustomer ? 'UPDATE →' : 'ADD CUSTOMER →'; ?></button>
                    </div>
                </form>
            </div>
            
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>PHONE</th>
                            <th>ID (KTP)</th>
                            <th>ADDRESS</th>
                            <th>GENDER</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $customers->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_pelanggan']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['noHP']); ?></td>
                            <td><?php echo htmlspecialchars($row['noKTP']); ?></td>
                            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                            <td><?php echo $row['gender'] === 'L' ? 'MALE' : 'FEMALE'; ?></td>
                            <td class="actions">
                                <a href="?edit=<?php echo htmlspecialchars($row['id_pelanggan']); ?>" class="btn btn-sm btn-primary">EDIT</a>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('CONFIRM DELETE?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id_pelanggan" value="<?php echo htmlspecialchars($row['id_pelanggan']); ?>">
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
