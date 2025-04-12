<?php
// Include database configuration
include '../config/database.php';

// Include model files
include '../models/Package.php';
include '../models/PackageFeature.php';

// Get broadband packages
$package = new Package($pdo);
$broadbandPackages = $package->readByType('BroadbandOnly');

// Get features by package ID
$packageFeature = new PackageFeature($pdo);

ob_start();
include '../templates/broadband.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include '../layout-mobile.html.php';