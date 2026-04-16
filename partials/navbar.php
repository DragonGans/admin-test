<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar bg-dark bg-gradient text-white p-3" id="sidebar">
        <!-- Brand -->
        <div class="sidebar-brand d-flex align-items-center mb-4 p-3 bg-primary bg-opacity-25 rounded">
            <i class="fas fa-crown fs-3 me-3 text-warning"></i>
            <span class="fs-5 fw-bold">Admin Pro</span>
        </div>
        
        <!-- Nav links -->
        <nav class="nav nav-pills flex-column">
            <a class="nav-link active mb-2" href="dashboard.php">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a class="nav-link mb-2" href="#">
                <i class="fas fa-users me-2"></i> Users
            </a>
            <a class="nav-link mb-2" href="#">
                <i class="fas fa-box me-2"></i> Products
            </a>
            <a class="nav-link mb-2" href="#">
                <i class="fas fa-shopping-cart me-2"></i> Orders
            </a>
            <a class="nav-link mb-3" href="#">
                <i class="fas fa-cog me-2"></i> Settings
            </a>
            <a class="nav-link text-danger" href="logout.php">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </nav>
    </div>
    
    <!-- Toggle button for mobile -->
    <button class="btn btn-primary d-lg-none position-fixed" id="sidebarToggle" style="top: 1rem; left: 1rem; z-index: 1060;">
        <i class="fas fa-bars"></i>
    </button>
</div>

<!-- Offcanvas overlay for mobile -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="sidebarOffcanvas">
    <div class="offcanvas-header border-0 bg-primary bg-opacity-25">
        <h5 class="offcanvas-title text-white">
            <i class="fas fa-crown me-2"></i>Admin Pro
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <nav class="nav nav-pills flex-column p-3">
            <a class="nav-link active" href="dashboard.php">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <a class="nav-link" href="#">
                <i class="fas fa-users me-2"></i>Users
            </a>
            <a class="nav-link" href="#">
                <i class="fas fa-box me-2"></i>Products
            </a>
            <a class="nav-link" href="#">
                <i class="fas fa-shopping-cart me-2"></i>Orders
            </a>
            <a class="nav-link" href="#">
                <i class="fas fa-cog me-2"></i>Settings
            </a>
            <a class="nav-link text-danger" href="logout.php">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
        </nav>
    </div>
</div>
