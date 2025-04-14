<?php
// Include database configuration
include './Include/database.php';

// Include model files
include './models/Package.php';
include './models/TabletFeature.php';

// Instantiate models

// Get tablet packages
$package = new Package($pdo);
$tabletPackages = $package->readByType('Tablet');

// Get tablet specifications
$tabletFeature = new TabletFeature($pdo);

ob_start();
include './templates/tablet.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include './layout-mobile.html.php';