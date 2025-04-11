<?php
// package-details.php

// Include database configuration
include '../config/database.php';

// Include model files
include '../models/Package.php';
include '../models/MobileFeature.php';
include '../models/PackageFeature.php';
include '../models/TabletSpec.php';

// Get the PackageID from the URL
$packageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the package details
$package = new Package($pdo);
$package->PackageID = $packageId;
$package->readOne();

// Fetch features based on package type
$features = [];
if ($package->Type === 'MobileOnly') {
    $mobileFeature = new MobileFeature($pdo);
    $features = $mobileFeature->getFeaturesByPackageId($packageId);
} else {
    $packageFeature = new PackageFeature($pdo);
    $features = $packageFeature->getFeaturesByPackageId($packageId);
}

// Fetch tablet specs if the package is a tablet plan
$specs = [];
if ($package->Type === 'TabletOnly') {
    $tabletSpec = new TabletSpec($pdo);
    $specs = $tabletSpec->getSpecsByPackageId($packageId);
}

// Start output buffering and include the template
ob_start();
include '../templates/package-details.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include '../layout-mobile.html.php';