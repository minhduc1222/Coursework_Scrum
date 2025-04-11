<?php
// Include database configuration
include '../config/database.php';

// Include model files
include '../models/Package.php';
include '../models/TabletSpec.php';

// Instantiate models

// Get tablet packages
$package = new Package($pdo);
$tabletPackages = $package->readByType('TabletOnly');

// Get tablet specifications
$tabletSpec = new TabletSpec($pdo);

ob_start();
include '../templates/tablet.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include '../layout-mobile.html.php';