<?php
// Include database configuration
include '../config/database.php';

// Include model files
include '../models/Package.php';
include '../models/BroadbandFeature.php'; // For Broadband features
include '../models/TabletSpec.php';     // For Tablet specs
include '../models/MobileFeature.php';  // For Mobile features

// Instantiate the new classes
$broadbandFeature = new BroadbandFeature($pdo);
$tabletSpec = new TabletSpec($pdo);
$mobileFeature = new MobileFeature($pdo);

// Get the filter type from the query parameter
$filter_type = isset($_GET['type']) ? $_GET['type'] : 'All';

// Get packages based on the filter
$package = new Package($pdo);

if ($filter_type === 'All') {
    $package_stmt = $package->readAll();
} else {
    // Assuming the Package model has a method to filter by type
    $package_stmt = $package->readByType($filter_type);
}

ob_start();
include '../templates/packages.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include '../layout-mobile.html.php';