<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
?>
<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>

<!-- Topbar -->
<nav class="topbar">
    <div class="container-fluid">
        <div class="d-flex align-items-center w-100">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sm mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home me-1"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            
            <!-- Spacer -->
            <div class="flex-grow-1"></div>
            
            <!-- Search -->
            <div class="input-group input-group-sm me-3" style="max-width: 300px;">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control bg-transparent border-start-0 ps-0" placeholder="Search...">
            </div>
            
            <!-- Right dropdowns -->
            <div class="d-flex align-items-center gap-2">
                <!-- Notifications -->
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-secondary" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger rounded-pill ms-1">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <li><a class="dropdown-item" href="#">New order received</a></li>
                        <li><a class="dropdown-item" href="#">Server maintenance</a></li>
                        <li><a class="dropdown-item" href="#">Database backup completed</a></li>
                    </ul>
                </div>
                
                <!-- Dark mode toggle -->
                <button class="theme-toggle btn btn-sm btn-outline-secondary" id="themeToggle" data-bs-toggle="tooltip" title="Toggle dark mode">
                    <i class="fas fa-sun fs-6"></i>
                </button>
                
                <!-- Profile -->
                <div class="dropdown">
                    <a class="dropdown-toggle d-flex align-items-center btn btn-sm btn-outline-secondary" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['admin_username']; ?>&background=667eea&color=fff&size=32&rounded=true" class="rounded-circle" width="32" alt="Admin">
                        <span class="d-none d-md-inline ms-2"><?php echo $_SESSION['admin_username']; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h2 mb-1">Welcome back, <?php echo ucfirst($_SESSION['admin_username']); ?>!</h1>
                <p class="text-muted mb-0">Here's what's happening with your admin panel today.</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-download me-1"></i>Export Report
                </button>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon stat-users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number" data-target="1234">0</div>
                <div class="text-muted">Total Users</div>
                <div class="badge bg-success mt-2">+12.5%</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon stat-orders">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-number" data-target="567">0</div>
                <div class="text-muted">Total Orders</div>
                <div class="badge bg-warning mt-2">+8.2%</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon stat-revenue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-number" data-target="23456">$0</div>
                <div class="text-muted">Revenue</div>
                <div class="badge bg-info mt-2">+15.1%</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon stat-growth">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number" data-target="128">0</div>
                <div class="text-muted">Today Sales</div>
                <div class="badge bg-success mt-2">+23%</div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Activity -->
            <div class="col-xl-8">
                <div class="chart-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Sales Overview</h5>
                        <select class="form-select form-select-sm" style="max-width: 150px;">
                            <option>Last 6 Months</option>
                            <option>Last Year</option>
                            <option>Last 30 Days</option>
                        </select>
                    </div>
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>
            
            <!-- Orders Chart -->
            <div class="col-xl-4">
                <div class="chart-container h-100">
                    <h5 class="mb-3"><i class="fas fa-chart-pie me-2 text-info"></i>Order Status</h5>
                    <canvas id="ordersChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0"><i class="fas fa-list me-2 text-success"></i>Recent Activity</h5>
                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Activity</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=John+Doe&background=4facfe&color=fff&size=32" class="rounded-circle me-2" width="32">
                                    <span>John Doe</span>
                                </div>
                            </td>
                            <td>New order #12345</td>
                            <td>2 min ago</td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Jane+Smith&background=f093fb&color=fff&size=32" class="rounded-circle me-2" width="32">
                                    <span>Jane Smith</span>
                                </div>
                            </td>
                            <td>Product updated</td>
                            <td>1 hour ago</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Bob+Johnson&background=43e97b&color=fff&size=32" class="rounded-circle me-2" width="32">
                                    <span>Bob Johnson</span>
                                </div>
                            </td>
                            <td>User registered</td>
                            <td>3 hours ago</td>
                            <td><span class="badge bg-info">Active</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Alice+Brown&background=ff6b6b&color=fff&size=32" class="rounded-circle me-2" width="32">
                                    <span>Alice Brown</span>
                                </div>
                            </td>
                            <td>Payment received</td>
                            <td>5 hours ago</td>
                            <td><span class="badge bg-success">Confirmed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
