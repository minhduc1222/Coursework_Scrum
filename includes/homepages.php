<?php
// Include database configuration
include '../config/database.php';

// Include model files
include '../models/Package.php';
include '../models/Deal.php';
include '../models/SpecialOffer.php';

// DB Connection

// Get all deals
$deal = new Deal($pdo);
$deal_stmt = $deal->readAll();

// Get all Package
$package = new Package($pdo);
$package_stmt = $package->readAll();

ob_start();
include '../templates/homepages.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include '../layout-mobile.html.php';