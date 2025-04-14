<?php
require_once '../Include/database.php';
require_once '../models/CustomPackage.php';

// Create instance
$custom = new CustomPackage($pdo);

// TEST: Create a new CustomPackage
$custom->PackageName = "Premium Mobile Plan";
$custom->Description = "Unlimited calls, texts, and 50GB data.";
$custom->Type = "Mobile"; // ENUM: MobileOnly, BroadBandOnly, TabletOnly
$custom->Price = 49.99;
$custom->FreeMinutes = 9999;
$custom->FreeSMS = 9999;
$custom->FreeGB = 50;
$custom->old_price = 59.99;
$custom->Contract = "24 months";
$custom->IsPopular = true;
$custom->DownloadSpeed = "N/A";
$custom->UploadSpeed = "N/A";
$custom->SetupFee = 0;
$custom->Brand = "MobileMax";
$custom->Rating = 4.8;
$custom->UpfrontCost = 0;
$custom->CustomerID = 1; 

if ($custom->create()) {
    echo "✅ Custom package created successfully.<br>";
} else {
    echo "❌ Failed to create custom package.<br>";
}