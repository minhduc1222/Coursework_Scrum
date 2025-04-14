<?php
// mobile.php

// Include database configuration
include './Include/database.php';

// Include model files
include './models/Package.php';
include './models/MobileFeature.php';

// Get mobile packages
$package = new Package($pdo);
$mobilePackages = $package->readByType('Mobile');

// Get features by package ID
$mobileFeature = new MobileFeature($pdo);

ob_start();
include './templates/mobile.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include './layout-mobile.html.php';