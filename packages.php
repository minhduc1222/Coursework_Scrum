<?php
// Include database configuration
include './includes/database.php';

// Include model files
include './models/Package.php';
include './models/BroadbandFeature.php';
include './models/TabletFeature.php'; // Corrected name
include './models/MobileFeature.php';

// Instantiate feature classes
$broadbandFeature = new BroadbandFeature($pdo);
$tabletFeature = new TabletFeature($pdo);  // corrected from TabletSpec
$mobileFeature = new MobileFeature($pdo);

// Get the filter type from the query parameter
$filter_type = isset($_GET['type']) ? $_GET['type'] : 'All';

// Get packages based on the filter
$package = new Package($pdo);

if ($filter_type === 'All') {
    $package_stmt = $package->readAll();
} else {
    $package_stmt = $package->readByType($filter_type);
}

// Collect all packages with associated features
$packages = [];
while ($row = $package_stmt->fetch(PDO::FETCH_ASSOC)) {
    $pkg = $row;

    // Fetch features based on Type
    if ($pkg['Type'] === 'MobileOnly') {
        $pkg['Features'] = $mobileFeature->getFeaturesByPackageId($pkg['PackageID']);
    } elseif ($pkg['Type'] === 'BroadbandOnly') {
        $pkg['Features'] = $broadbandFeature->getFeaturesByPackageId($pkg['PackageID']);
    } elseif ($pkg['Type'] === 'TabletOnly') {
        $pkg['Features'] = $tabletFeature->getFeaturesByPackageId($pkg['PackageID']); // corrected
    } else {
        $pkg['Features'] = [];
    }

    $packages[] = $pkg;
}

ob_start();
include './templates/packages.html.php';
$page_content = ob_get_clean();

include './layout-mobile.html.php';
