<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}
include 'partials/header.php';
?>
<!-- Dashboard content -->
<h1>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h1>
<a href="logout.php" class="btn btn-danger">Logout</a>