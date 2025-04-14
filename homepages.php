<?php
// homepages.php

session_start(); // Start the session

// Include database configuration
include './Include/database.php';

// Include model files
include './models/Package.php';
include './models/Deal.php';
include './models/SpecialOffer.php';
include './models/Customer.php';

// Get all deals
$deal = new Deal($pdo);
$deal_stmt = $deal->readAll();

// Get all packages
$package = new Package($pdo);
$package_stmt = $package->readAll();

// Instantiate Customer model
$customer = new Customer($pdo);

// Check if user is logged in and fetch avatar
if (isset($_SESSION['customer_id'])) {
    $customer->CustomerID = $_SESSION['customer_id'];
    $customer->readOne(); // Fetch customer data
    $avatar_url = $customer->avt_img ? htmlspecialchars($customer->avt_img) : './assets/default-avatar.png'; // Fallback to default avatar
} else {
    $avatar_url = './assets/default-avatar.png'; // Default avatar for non-logged-in users
}

ob_start();
include './templates/homepages.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include './layout-mobile.html.php';