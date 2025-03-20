<?php
// functions.php - Contains helper functions

// Sanitize a string input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function checkAdmin() {
    session_start();
    if (!isset($_SESSION['admin_logged_in'])) {
        header('Location: login.php');
        exit;
    }
}
?>
