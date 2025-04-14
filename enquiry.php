<?php
require_once "./Include/database.php";
require_once "./Include/databasefunction.php";
// Start session
session_start();

ob_start();
include "./templates/enquiry.html.php";
$page_content = ob_get_clean();

// Render it inside the layout
include './layout-mobile.html.php';