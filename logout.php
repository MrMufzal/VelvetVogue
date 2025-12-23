<?php
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to home page with absolute path
header("Location: /VelvetVogue/index.php");
exit;
?>