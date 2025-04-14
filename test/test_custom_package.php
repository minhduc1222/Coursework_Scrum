<?php
require_once '../Include/database.php';
require_once '../models/CustomPackage.php';

// Create instance
$custom = new CustomPackage($pdo);

// // TEST: Create new CustomPackage
// $custom->PackageName = "Pro Broadband Plan";
// $custom->Description = "Fast and reliable broadband connection.";
// $custom->Type = "BroadBandOnly"; // ENUM: MobileOnly, BroadBandOnly, TabletOnly
// $custom->Price = 29.99;
// $custom->FreeMinutes = 0;
// $custom->FreeSMS = 0;
// $custom->FreeGB = 200;
// $custom->old_price = 39.99;
// $custom->Contract = "12 months";
// $custom->IsPopular = true;
// $custom->DownloadSpeed = "150 Mbps";
// $custom->UploadSpeed = "20 Mbps";
// $custom->SetupFee = 0;
// $custom->Brand = "SuperNet";
// $custom->Rating = 4.5;
// $custom->UpfrontCost = 0;

// if ($custom->create()) {
//     echo "✅ Custom package created successfully.<br>";
// } else {
//     echo "❌ Failed to create custom package.<br>";
// }

// TEST: Read all custom packages
echo "<h3>📦 All Custom Packages</h3>";
$stmt = $custom->readAll();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $PackageID - $PackageName ($Type) - $Price USD<br>";
}

// TEST: Read custom package by ID
$custom->PackageID = 1; // Change this to match your DB
$custom->readOne();

echo "<h3>📄 Custom Package Details</h3>";
echo "PackageID: $custom->PackageID<br>";
echo "Name: $custom->PackageName<br>";
echo "Description: $custom->Description<br>";
echo "Type: $custom->Type<br>";
echo "Price: $custom->Price<br>";
echo "FreeMinutes: $custom->FreeMinutes<br>";
echo "FreeSMS: $custom->FreeSMS<br>";
echo "FreeGB: $custom->FreeGB<br>";
echo "Old Price: $custom->old_price<br>";
echo "Contract: $custom->Contract<br>";
echo "Is Popular: $custom->IsPopular<br>";
echo "Download Speed: $custom->DownloadSpeed<br>";
echo "Upload Speed: $custom->UploadSpeed<br>";
echo "Setup Fee: $custom->SetupFee<br>";
echo "Brand: $custom->Brand<br>";
echo "Rating: $custom->Rating<br>";
echo "Upfront Cost: $custom->UpfrontCost<br>";

// // TEST: Update custom package
// $custom->PackageName = "Updated Custom Package";
// if ($custom->update()) {
//     echo "✏️ Custom package updated successfully.<br>";
// } else {
//     echo "❌ Failed to update custom package.<br>";
// }

// // TEST: Delete custom package
// $custom->PackageID = 201; // Change to real ID to delete
// if ($custom->delete()) {
//     echo "🗑️ Custom package deleted successfully.<br>";
// } else {
//     echo "❌ Failed to delete custom package.<br>";
// }

// TEST: Read by Type (ENUM)
echo "<h3>📦 MobileOnly Custom Packages</h3>";
$stmt = $custom->readByType("Mobile");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $PackageID - $PackageName<br>";
}

// Dynamic filter test
$filter_type = "Mobile"; // or TabletOnly, BroadBandOnly

echo "<h3>📦 Filtered Custom Packages ($filter_type)</h3>";
if ($filter_type === 'All') {
    $stmt = $custom->readAll();
} else {
    $stmt = $custom->readByType($filter_type);
}
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $PackageID - $PackageName ($Type) - $Price USD<br>";
}

// Custom packages by customer
$customerID = 1; // Example customer ID
$custom = new CustomPackage($pdo);
$stmt = $custom->readByCustomer($customerID);

echo "<h3>📦 Packages created by Customer #$customerID</h3>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $PackageID - $PackageName - $Type<br>";
}


?>
