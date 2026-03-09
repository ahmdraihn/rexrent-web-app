<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <div class="logo-icon">R</div>
            <span class="logo-text">REX RENTS</span>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📊</span>
            <span>[ DASHBOARD ]</span>
        </a>
        <a href="cars.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'cars.php' ? 'active' : ''; ?>">
            <span class="nav-icon">🚗</span>
            <span>[ CARS ]</span>
        </a>
        <a href="customers.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'customers.php' ? 'active' : ''; ?>">
            <span class="nav-icon">👥</span>
            <span>[ CUSTOMERS ]</span>
        </a>
        <a href="transactions.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'transactions.php' ? 'active' : ''; ?>">
            <span class="nav-icon">📋</span>
            <span>[ TRANSACTIONS ]</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="../logout.php" class="nav-item logout">
            <span class="nav-icon">🚪</span>
            <span>[ LOGOUT ]</span>
        </a>
    </div>
</aside>
