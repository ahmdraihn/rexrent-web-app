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
        <a href="rental.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'rental.php' ? 'active' : ''; ?>">
            <span class="nav-icon">➕</span>
            <span>[ NEW RENTAL ]</span>
        </a>
        <a href="return.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) === 'return.php' ? 'active' : ''; ?>">
            <span class="nav-icon">↩️</span>
            <span>[ RETURNS ]</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <a href="../logout.php" class="nav-item logout">
            <span class="nav-icon">🚪</span>
            <span>[ LOGOUT ]</span>
        </a>
    </div>
</aside>
