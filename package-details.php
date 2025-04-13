<?php
// package-details.php

// Include database configuration
include './includes/database.php';

// Include model files
include './models/Package.php';
include './models/MobileFeature.php';
include './models/BroadbandFeature.php';
include './models/TabletFeature.php';

// Get the PackageID from the URL
$packageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the package details
$package = new Package($pdo);
$package->PackageID = $packageId;
$package->readOne();

// Check if same type already exists in cart
// Ensure the session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$alreadyInCart = false;
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (isset($item['package']['Type']) && $item['package']['Type'] === $package->Type) {
            $alreadyInCart = true;
            break;
        }
    }
}

// Fetch features based on package type
$features = [];
if ($package->Type === 'MobileOnly') {
    $mobileFeature = new MobileFeature($pdo);
    $features = $mobileFeature->getFeaturesByPackageId($packageId);
} elseif ($package->Type === 'BroadbandOnly') {
    $broadbandFeature = new BroadbandFeature($pdo);
    $features = $broadbandFeature->getFeaturesByPackageId($packageId);
} elseif ($package->Type === 'TabletOnly') {
    $tabletFeature = new TabletFeature($pdo);
    $features = $tabletFeature->getFeaturesByPackageId($packageId);
}

// Start output buffering and include the template
ob_start();
include './templates/package-details.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include './layout-mobile.html.php';