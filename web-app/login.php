<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'Admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: employee/dashboard.php');
    }
    exit();
}

require_once 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    
    if (empty($username) || empty($password) || empty($role)) {
        $error = 'ALL FIELDS REQUIRED';
    } else {
        $conn = connectDB();
        
        $stmt = $conn->prepare("SELECT id_akun, username, password, role FROM tb_akun WHERE username = ? AND role = ?");
        $stmt->bind_param("ss", $username, $role);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id_akun'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                if ($role === 'Admin') {
                    header('Location: admin/dashboard.php');
                } else {
                    header('Location: employee/dashboard.php');
                }
                exit();
            } else {
                $error = 'INVALID CREDENTIALS';
            }
        } else {
            $error = 'INVALID CREDENTIALS';
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | REX RENTS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <img src="assets/images/logo.png" alt="Rex's Rents Logo" class="logo-icon-large">
                <h1 class="logo-text-large">REX'S RENTS</h1>
                <p>[ LOGIN TO CONTINUE ]</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error">[ ERROR ] <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">[ USERNAME ]</label>
                    <input type="text" id="username" name="username" required autofocus placeholder="Enter username">
                </div>
                
                <div class="form-group">
                    <label for="password">[ PASSWORD ]</label>
                    <input type="password" id="password" name="password" required placeholder="Enter password">
                </div>
                
                <div class="form-group">
                    <label>[ ROLE ]</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="role" value="Admin" required>
                            [ ADMIN ]
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="role" value="Employee" required>
                            [ PEGAWAI ]
                        </label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="index.php" class="btn btn-outline">← BACK</a>
                    <button type="submit" class="btn btn-primary">LOGIN →</button>
                </div>
            </form>
            
            <div class="login-info">
                <p>[ DEFAULT CREDENTIALS ]</p>
                <p>ADMIN: <strong>admin</strong> / <strong>admin123</strong></p>
                <p>PEGAWAI: <strong>pegawai</strong> / <strong>pegawai123</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
