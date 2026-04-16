<?php
session_start();

// Destroy all session data
$_SESSION = array();
session_destroy();

// Redirect to login with success message
header('Location: index.php?logout=success');
exit;
?>
