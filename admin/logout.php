<?php
// admin/logout.php - Admin logout script
session_start();
unset($_SESSION['admin_logged_in']);
session_destroy();
header('Location: login.php');
exit;
?>