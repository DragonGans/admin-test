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
    <div class="container-fluid">
        <div class="d-flex align-items-center w-100">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sm mb-0">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home me-1"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                </ol>
            </nav>
            <div class="flex-grow-1"></div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary btn-sm" id="saveSettings">
                    <i class="fas fa-save me-1"></i>Save Changes
                </button>
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-secondary" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">System update available</a></li>
                        <li><a class="dropdown-item" href="#">Backup completed</a></li>
                    </ul>
                </div>
                <button class="theme-toggle btn btn-sm btn-outline-secondary" id="themeToggle">
                    <i class="fas fa-sun"></i>
                </button>
                <div class="dropdown">
                    <a class="dropdown-toggle d-flex btn btn-sm btn-outline-secondary" href="#" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['admin_username']; ?>&&size=32" class="rounded-circle me-2">
                        <?php echo $_SESSION['admin_username']; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#profileEdit">Edit Profile</a></li>
                        <li><hr></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="main-content">
    <div class="page-header">
        <h1 class="h2">Settings</h1>
        <p class="text-muted">Customize your admin panel preferences.</p>
    </div>

    <div class="container-fluid px-4">
        <div class="row">
            <!-- Profile section -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0"><i class="fas fa-user-circle me-2"></i>Profile Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Avatar</label>
                            <div class="text-center mb-3">
                                <img id="profileAvatar" src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['admin_username']; ?>&background=667eea&color=fff&size=120" class="rounded-circle shadow" width="120">
                            </div>
                            <input type="file" class="form-control" id="avatarUpload" accept="image/*">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" value="<?php echo $_SESSION['admin_username']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?php echo $_SESSION['admin_username']; ?>@admin.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" placeholder="Leave blank to keep current">
                        </div>
                    </div>
                </div>
            </div>

            <!-- System settings -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0"><i class="fas fa-cog me-2"></i>System Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Theme</label>
                            <div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                                    <label class="form-check-label" for="darkModeSwitch">Dark Mode</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Language</label>
                            <select class="form-select">
                                <option>English</option>
                                <option>Indonesia</option>
                                <option>Español</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notifications</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                                <label class="form-check-label" for="emailNotif">Email notifications</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="browserNotif">
                                <label class="form-check-label" for="browserNotif">Browser notifications</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0"><i class="fas fa-shield-alt me-2"></i>Security</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Session Timeout</label>
                            <select class="form-select">
                                <option>30 minutes</option>
                                <option>1 hour</option>
                                <option>Never (not recommended)</option>
                            </select>
                        </div>
                        <button class="btn btn-warning w-100 mb-2" id="changePasswordBtn">
                            Change Password
                        </button>
                        <button class="btn btn-outline-danger w-100" id="logoutAllBtn">
                            Logout All Sessions
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="profileEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="profileForm">
                <div class="modal-body">
                    <!-- Form fields -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Dummy JS for settings page interactivity
document.getElementById('saveSettings')?.addEventListener('click', function() {
    showAlert('Settings saved successfully!');
});

document.getElementById('changePasswordBtn')?.addEventListener('click', function() {
    showAlert('Password change initiated (dummy)');
});

document.getElementById('darkModeSwitch')?.addEventListener('change', function() {
    document.documentElement.setAttribute('data-bs-theme', this.checked ? 'dark' : 'light');
});
</script>
