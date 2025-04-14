<?php
// Start session if needed (e.g., to access customer data)
session_start();
// Include necessary files

ob_start();
include './templates/confirm_checkout.html.php';
$page_content = ob_get_clean();
include './layout-mobile.html.php';
?>