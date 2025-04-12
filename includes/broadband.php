<?php
// Include database configuration
include '../config/database.php';

// Include model files
include '../models/Package.php';
include '../models/BroadbandFeature.php';

// Get broadband packages
$package = new Package($pdo);
$broadbandPackages = $package->readByType('BroadbandOnly');

// Get features by package ID
$BroadbandFeature = new BroadbandFeature($pdo);

ob_start();
include '../templates/broadband.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include '../layout-mobile.html.php';