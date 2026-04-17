<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
?>
<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>

<!-- Topbar (same structure) -->
<nav class="topbar">
    <div class="container-fluid">
        <div class="d-flex align-items-center w-100">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-sm mb-0">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home me-1"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Products</a></li>
                    <li class="breadcrumb-item active">All Products</li>
                </ol>
            </nav>
            <div class="flex-grow-1"></div>
            <div class="input-group input-group-sm me-3" style="max-width: 300px;">
                <span class="input-group-text">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" class="form-control" id="productsSearch" placeholder="Search products...">
            </div>
            <div class="d-flex gap-2">
                <!-- Notifications, theme toggle, profile - same as dashboard -->
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-secondary" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i> <span class="badge bg-danger ms-1">2</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><h6>Notifications</h6></li>
                        <li><a class="dropdown-item" href="#">Low stock alert</a></li>
                        <li><a class="dropdown-item" href="#">New product approved</a></li>
                    </ul>
                </div>
                <button class="theme-toggle btn btn-sm btn-outline-secondary" id="themeToggle" title="Dark mode">
                    <i class="fas fa-sun"></i>
                </button>
                <div class="dropdown">
                    <a class="dropdown-toggle d-flex align-items-center btn btn-sm btn-outline-secondary" href="#" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['admin_username']; ?>&size=32" class="rounded-circle me-2" width="32">
                        <span class="d-none d-md-inline"><?php echo $_SESSION['admin_username']; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="settings.php">Settings</a></li>
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
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h2 mb-1">Products</h1>
                <p class="text-muted">Manage your product catalog (567 products).</p>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm" id="exportProductsBtn">
                    <i class="fas fa-download"></i> Export
                </button>
                <button class="btn btn-success btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover" id="productsTable">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dummy products -->
                                <tr>
                                    <td><img src="https://via.placeholder.com/50x50/667eea/fff?text=iPhone" class="rounded" width="50"></td>
                                    <td>iPhone 15 Pro</td>
                                    <td>Electronics</td>
                                    <td>$999</td>
                                    <td>25</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary view-product" data-id="1">View</button>
                                            <button class="btn btn-outline-warning edit-product" data-id="1">Edit</button>
                                            <button class="btn btn-outline-danger delete-product" data-id="1">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50x50/f093fb/fff?text=MacBook" class="rounded" width="50"></td>
                                    <td>MacBook Air M2</td>
                                    <td>Electronics</td>
                                    <td>$1,299</td>
                                    <td>12</td>
                                    <td><span class="badge bg-warning">Low Stock</span></td>
                                    <td><!-- buttons --></td>
                                </tr>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50x50/43e97b/fff?text=Watch" class="rounded" width="50"></td>
                                    <td>Apple Watch Ultra</td>
                                    <td>Wearables</td>
                                    <td>$799</td>
                                    <td>45</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                    <td><!-- buttons --></td>
                                </tr>
                                <!-- Add 7 more dummy product rows -->
                                <tr>
                                    <td><img src="https://via.placeholder.com/50x50/4facfe/fff?text=AirPods" class="rounded" width="50"></td>
                                    <td>AirPods Pro 2</td>
                                    <td>Audio</td>
                                    <td>$249</td>
                                    <td>89</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                    <td><!-- buttons --></td>
                                </tr>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50x50/ff6b6b/fff?text=iPad" class="rounded" width="50"></td>
                                    <td>iPad Air 5</td>
                                    <td>Tablets</td>
                                    <td>$599</td>
                                    <td>33</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                    <td><!-- buttons --></td>
                                </tr>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50x50/667eea/fff?text=Case" class="rounded" width="50"></td>
                                    <td>Phone Case</td>
                                    <td>Accessories</td>
                                    <td>$19</td>
                                    <td>150</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                    <td><!-- buttons --></td>
                                </tr>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50x50/f093fb/fff?text=Charger" class="rounded" width="50"></td>
                                    <td>Fast Charger</td>
                                    <td>Accessories</td>
                                    <td>$29</td>
                                    <td>76</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                    <td><!-- buttons --></td>
                                </tr>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50x50/43e97b/fff?text=Headphones" class="rounded" width="50"></td>
                                    <td>Wireless Headphones</td>
                                    <td>Audio</td>
                                    <td>$199</td>
                                    <td>8</td>
                                    <td><span class="badge bg-danger">Out of Stock</span></td>
                                    <td><!-- buttons --></td>
                                </tr>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50x50/4facfe/fff?text=Laptop" class="rounded" width="50"></td>
                                    <td>Gaming Laptop</td>
                                    <td>Electronics</td>
                                    <td>$1,899</td>
                                    <td>5</td>
                                    <td><span class="badge bg-warning">Low Stock</span></td>
                                    <td><!-- buttons --></td>
                                </tr>
                                <tr>
                                    <td><img src="https://via.placeholder.com/50x50/ff6b6b/fff?text=Mouse" class="rounded" width="50"></td>
                                    <td>Wireless Mouse</td>
                                    <td>Accessories</td>
                                    <td>$39</td>
                                    <td>120</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                    <td><!-- buttons --></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal (dummy) -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select">
                            <option>Electronics</option>
                            <option>Accessories</option>
                            <option>Wearables</option>
                            <option>Audio</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="alert('Product added! (dummy)')">Add Product</button>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
