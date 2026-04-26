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
        <a href="rental.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'rental.php' ? 'active' : ''; ?>">
            <i class="ti ti-circle-plus nav-icon"></i>
            <span>[ NEW RENTAL ]</span>
        </a>
        <a href="return.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'return.php' ? 'active' : ''; ?>">
            <i class="ti ti-arrow-back-up nav-icon"></i>
            <span>[ RETURNS ]</span>
        </a>
        <a href="customers.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'customers.php' ? 'active' : ''; ?>">
            <i class="ti ti-users nav-icon"></i>
            <span>[ CUSTOMERS ]</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="../logout.php" class="nav-item logout">
            <i class="ti ti-logout nav-icon"></i>
            <span>[ LOGOUT ]</span>
        </a>
    </div>
</aside>
