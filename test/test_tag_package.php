
<?php
// test_tag_package.php

// Include required files
require_once '../config/database.php';
require_once '../models/Package.php';
require_once '../models/PackageFeature.php';
require_once '../models/MobileFeature.php';
require_once '../models/TabletSpec.php';

// Initialize the classes
try {
    // Ensure $pdo is available from database.php
    if (!isset($pdo)) {
        throw new Exception("Database connection (pdo) is not initialized.");
    }

    $packages = new Package($pdo);
    $packageFeature = new PackageFeature($pdo);
    $mobileFeature = new MobileFeature($pdo);
    $tabletSpec = new TabletSpec($pdo);

    // Fetch all packages
    $package_stmt = $packages->readAll();
    $packages_data = $package_stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$packages_data) {
        throw new Exception("Failed to fetch packages from the database.");
    }

    // Array to store the final output
    $output = [];

    // Loop through each package
    foreach ($packages_data as $package) {
        $package_id = $package['PackageID'];
        $package_type = $package['Type'];
        // echo $package_type;
        // Initialize tags array for features or specs
        $tags = [];

        // Fetch features or specs based on package type
        if ($package_type === 'BroadbandOnly') {
            // Get broadband features
            $feature_stmt = $packageFeature->getFeaturesByPackageId($package_id);
            while ($feature = $feature_stmt->fetch(PDO::FETCH_ASSOC)) {
                $tags[] = $feature['Feature'];
            }
        } elseif ($package_type === 'MobileOnly') {
            // Get mobile features
            $mobile_stmt = $mobileFeature->getFeaturesByPackageId($package_id);
            while ($feature = $mobile_stmt->fetch(PDO::FETCH_ASSOC)) {
                $tags[] = $feature['Feature'];
            }
        } elseif ($package_type === 'TabletOnly') {
            // Get tablet specs
            $tablet_specs = $tabletSpec->getSpecsByPackageId($package_id);
            foreach ($tablet_specs as $spec) {
                $tags[] = "{$spec['SpecName']}: {$spec['SpecValue']}";
            }
        }

        // Add package data and tags to output
        $output[] = [
            'PackageID' => $package['PackageID'],
            'PackageName' => $package['PackageName'],
            'Type' => $package['Type'],
            'Tags' => $tags
        ];
    }

    // Output as JSON
    echo json_encode($output, JSON_PRETTY_PRINT);

} catch (Exception $e) {
    // Output error as JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>
