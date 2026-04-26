<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <img src="../assets/images/logo.png" alt="Rex's Rents Logo" class="logo-image">
            <span class="logo-text">REX'S RENTS</span>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">
            <i class="ti ti-layout-dashboard nav-icon"></i>
            <span>[ DASHBOARD ]</span>
        </a>
        <a href="cars.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'cars.php' ? 'active' : ''; ?>">
            <i class="ti ti-car nav-icon"></i>
            <span>[ CARS ]</span>
        </a>
        <a href="customers.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'customers.php' ? 'active' : ''; ?>">
            <i class="ti ti-users nav-icon"></i>
            <span>[ CUSTOMERS ]</span>
        </a>
        <a href="transactions.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'transactions.php' ? 'active' : ''; ?>">
            <i class="ti ti-clipboard-list nav-icon"></i>
            <span>[ TRANSACTIONS ]</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="../logout.php" class="nav-item logout">
            <i class="ti ti-logout nav-icon"></i>
            <span>[ LOGOUT ]</span>
        </a>
    </div>
</aside>
