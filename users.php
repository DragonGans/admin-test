<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
?>
<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>

<nav class="topbar">
    <!-- Same topbar as dashboard.php to copy structure -->
    <div class="container-fluid">
        <div class="d-flex align-items-center w-100">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sm mb-0">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home me-1"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
            <div class="flex-grow-1"></div>
            <div class="input-group input-group-sm me-3" style="max-width: 300px;">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control bg-transparent border-start-0 ps-0" id="usersSearch" placeholder="Search users...">
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-secondary" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger rounded-pill ms-1" id="notifBadge">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" id="notificationsList">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <li><a class="dropdown-item" href="#" data-notif-id="1">New user registered</a></li>
                        <li><a class="dropdown-item" href="#" data-notif-id="2">User account suspended</a></li>
                        <li><a class="dropdown-item" href="#" data-notif-id="3">Email verification pending</a></li>
                    </ul>
                </div>
                <button class="theme-toggle btn btn-sm btn-outline-secondary" id="themeToggle" data-bs-toggle="tooltip" title="Toggle dark mode">
                    <i class="fas fa-sun fs-6"></i>
                </button>
                <div class="dropdown">
                    <a class="dropdown-toggle d-flex align-items-center btn btn-sm btn-outline-secondary" href="#" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['admin_username']; ?>&background=667eea&color=fff&size=32&rounded=true" class="rounded-circle" width="32">
                        <span class="d-none d-md-inline ms-2"><?php echo $_SESSION['admin_username']; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="main-content">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h2 mb-1">Users Management</h1>
                <p class="text-muted mb-0">Manage all registered users (1,234 total).</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm" id="exportUsers">
                    <i class="fas fa-download me-1"></i>Export CSV
                </button>
                <button class="btn btn-success btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus me-1"></i>Add User
                </button>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover" id="usersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><img src="https://ui-avatars.com/api/?name=John+Doe&size=32" class="rounded-circle" width="32"></td>
                            <td>John Doe</td>
                            <td>john@example.com</td>
                            <td><span class="badge bg-primary">Admin</span></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>2024-01-15</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-detail" data-id="1">View</button>
                                <button class="btn btn-sm btn-outline-warning edit-user" data-id="1">Edit</button>
                                <button class="btn btn-sm btn-outline-danger delete-user" data-id="1">Delete</button>
                            </td>
                        </tr>
                        <!-- More dummy rows... 9 more for demo -->
                        <tr>
                            <td>2</td>
                            <td><img src="https://ui-avatars.com/api/?name=Jane+Smith&size=32" class="rounded-circle" width="32"></td>
                            <td>Jane Smith</td>
                            <td>jane@example.com</td>
                            <td><span class="badge bg-info">Editor</span></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>2024-02-01</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-detail" data-id="2">View</button>
                                <button class="btn btn-sm btn-outline-warning edit-user" data-id="2">Edit</button>
                                <button class="btn btn-sm btn-outline-danger delete-user" data-id="2">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><img src="https://ui-avatars.com/api/?name=Mike+Wilson&size=32" class="rounded-circle" width="32"></td>
                            <td>Mike Wilson</td>
                            <td>mike@example.com</td>
                            <td><span class="badge bg-secondary">User</span></td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>2024-02-10</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-detail" data-id="3">View</button>
                                <button class="btn btn-sm btn-outline-warning edit-user" data-id="3">Edit</button>
                                <button class="btn btn-sm btn-outline-danger delete-user" data-id="3">Delete</button>
                            </td>
                        </tr>
                        <!-- Add 7 more similar dummy rows for full table demo -->
                        <tr>
                            <td>4</td>
                            <td><img src="https://ui-avatars.com/api/?name=Sarah+Davis&size=32" class="rounded-circle" width="32"></td>
                            <td>Sarah Davis</td>
                            <td>sarah@example.com</td>
                            <td><span class="badge bg-info">Editor</span></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>2024-01-20</td>
                            <td><!-- buttons --></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><img src="https://ui-avatars.com/api/?name=Tom+Brown&size=32" class="rounded-circle" width="32"></td>
                            <td>Tom Brown</td>
                            <td>tom@example.com</td>
                            <td><span class="badge bg-primary">Admin</span></td>
                            <td><span class="badge bg-danger">Suspended</span></td>
                            <td>2023-12-01</td>
                            <td><!-- buttons --></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><img src="https://ui-avatars.com/api/?name=Lisa+Garcia&size=32" class="rounded-circle" width="32"></td>
                            <td>Lisa Garcia</td>
                            <td>lisa@example.com</td>
                            <td><span class="badge bg-secondary">User</span></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>2024-02-05</td>
                            <td><!-- buttons --></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><img src="https://ui-avatars.com/api/?name=David+Lee&size=32" class="rounded-circle" width="32"></td>
                            <td>David Lee</td>
                            <td>david@example.com</td>
                            <td><span class="badge bg-secondary">User</span></td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>2024-02-15</td>
                            <td><!-- buttons --></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td><img src="https://ui-avatars.com/api/?name=Emma+Martinez&size=32" class="rounded-circle" width="32"></td>
                            <td>Emma Martinez</td>
                            <td>emma@example.com</td>
                            <td><span class="badge bg-info">Editor</span></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>2024-01-10</td>
                            <td><!-- buttons --></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td><img src="https://ui-avatars.com/api/?name=Chris+Taylor&size=32" class="rounded-circle" width="32"></td>
                            <td>Chris Taylor</td>
                            <td>chris@example.com</td>
                            <td><span class="badge bg-secondary">User</span></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>2024-02-08</td>
                            <td><!-- buttons --></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td><img src="https://ui-avatars.com/api/?name=Anna+Anderson&size=32" class="rounded-circle" width="32"></td>
                            <td>Anna Anderson</td>
                            <td>anna@example.com</td>
                            <td><span class="badge bg-secondary">User</span></td>
                            <td><span class="badge bg-danger">Banned</span></td>
                            <td>2024-01-25</td>
                            <td><!-- buttons --></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals (dummy) -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select">
                            <option>User</option>
                            <option>Editor</option>
                            <option>Admin</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveUser()">Save User</button>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
