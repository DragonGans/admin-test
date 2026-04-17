<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
?>
<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>

<!-- Topbar same as others -->
<nav class="topbar">
    <!-- Copy topbar structure from dashboard/users -->
</nav>

<div class="main-content">
    <div class="page-header">
        <h1>Orders</h1>
        <p>Manage customer orders (345 active).</p>
    </div>
    <div class="container-fluid">
        <!-- Orders table with dummy data, filters, export, actions -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 10 dummy orders -->
                    <tr>
                        <td>#001</td>
                        <td>John Doe</td>
                        <td>3 items</td>
                        <td>$299</td>
                        <td><span class="badge bg-success">Delivered</span></td>
                        <td>2024-02-20</td>
                        <td><button class="btn btn-sm btn-primary">View</button></td>
                    </tr>
                    <!-- More rows -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
