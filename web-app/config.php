<?php
// Database configuration for Rex's Rents
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_rexrents');

// Create database connection
function connectDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

// Format number to Indonesian Rupiah
function formatRupiah($number) {
    return "Rp " . number_format($number, 0, ',', '.');
}

// Format date to Indonesian format
function formatDateIndo($date) {
    $months = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
        '04' => 'April', '05' => 'Mei', '06' => 'Juni',
        '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];
    
    $d = substr($date, 8, 2);
    $m = $months[substr($date, 5, 2)];
    $y = substr($date, 0, 4);
    
    return "$d $m $y";
}

// Generate next ID for Mobil
function generateNextIdMobil($conn) {
    $query = "SELECT MAX(CAST(SUBSTRING(id_mobil, 2) AS UNSIGNED)) AS max_id FROM tb_mobil";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $maxId = $row['max_id'] ?? 0;
    return 'M' . str_pad($maxId + 1, 2, '0', STR_PAD_LEFT);
}

// Generate next ID for Pelanggan
function generateNextIdPelanggan($conn) {
    $query = "SELECT MAX(CAST(SUBSTRING(id_pelanggan, 2) AS UNSIGNED)) AS max_id FROM tb_pelanggan";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $maxId = $row['max_id'] ?? 0;
    return 'P' . str_pad($maxId + 1, 3, '0', STR_PAD_LEFT);
}

// Generate next ID for Transaksi
function generateNextIdTransaksi($conn) {
    $query = "SELECT MAX(CAST(SUBSTRING(id_transaksi, 4) AS UNSIGNED)) AS max_id FROM tb_transaksi";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $maxId = $row['max_id'] ?? 0;
    return 'TRX' . str_pad($maxId + 1, 4, '0', STR_PAD_LEFT);
}

// Redirect helper
function redirect($url) {
    header("Location: $url");
    exit();
}

// Check if user is logged in
function isLoggedIn() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['role']);
}

// Require login
function requireLogin() {
    if (!isLoggedIn()) {
        redirect('../login.php');
    }
}

// Require admin role
function requireAdmin() {
    if (!isLoggedIn() || $_SESSION['role'] !== 'Admin') {
        redirect('../login.php');
    }
}

// Require employee role
function requireEmployee() {
    if (!isLoggedIn() || $_SESSION['role'] !== 'Employee') {
        redirect('../login.php');
    }
}
?>
