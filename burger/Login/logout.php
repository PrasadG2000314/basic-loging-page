<?php
session_start();

// Clear session variables
session_unset();

// Destroy the session
session_destroy();

// Clear cookies
setcookie("customer_id", "", time() - 3600);
setcookie("name", "", time() - 3600);
setcookie("email", "", time() - 3600);

// Redirect to home page (index.php)
header("Location: index.php");
exit;
?>