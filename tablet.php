<?php
// Include database configuration
include 'include/database.php';

// Include model files
include 'models/Package.php';
include 'models/TabletFeature.php';

// Get tablet packages
$package = new Package($pdo);
$tabletPackages = $package->readByType('TabletOnly');

// Get tablet specifications
$tabletFeature = new TabletFeature($pdo);

ob_start();
include './template/tablet.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include './layout-mobile.html.php';