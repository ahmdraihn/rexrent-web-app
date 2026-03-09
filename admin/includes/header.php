<header class="header">
    <div class="header-content">
        <div class="header-left">
            <button class="menu-toggle" onclick="toggleSidebar()">[ ☰ ]</button>
        </div>
        <div class="header-right">
            <div class="user-info">
                <span class="user-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <span class="user-role">[ ADMINISTRATOR ]</span>
            </div>
        </div>
    </div>
</header>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('collapsed');
    document.querySelector('.main-content').classList.toggle('expanded');
}
</script>
