<?php
require_once '../includes/database.php';
require_once '../models/Package.php';

// Create Package instance
$package = new Package($pdo);

// // TEST: Create new package
// $package->PackageName = "Starter Mobile Plan";
// $package->Description = "Perfect for light users.";
// $package->Type = "Mobile";
// $package->Price = 9.99;
// $package->FreeMinutes = 100;
// $package->FreeSMS = 50;
// $package->FreeGB = 1;

// if ($package->create()) {
//     echo "✅ Package created successfully.<br>";
// } else {
//     echo "❌ Failed to create package.<br>";
// }

// TEST: Read all packages
echo "<h3>📦 All Packages</h3>";
$stmt = $package->readAll();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $PackageID - $PackageName ($Type) - $Price USD<br>";
}

// TEST: Read package by ID
$package->PackageID = 1; // change ID to an existing one
$package->readOne();
echo "<h3>📄 Package Details</h3>";
echo "PackageID: $package->PackageID<br>";
echo "Name: $package->PackageName<br>";
echo "Description: $package->Description<br>";
echo "Type: $package->Type<br>";
echo "Price: $package->Price<br>";
echo "FreeMinutes: $package->FreeMinutes<br>";
echo "FreeSMS: $package->FreeSMS<br>";
echo "FreeGB: $package->FreeGB<br>";
echo "Old Price: $package->old_price<br>";
echo "Contract: $package->Contract<br>";
echo "Is Popular: $package->IsPopular<br>";
echo "Download Speed: $package->DownloadSpeed<br>";
echo "Upload Speed: $package->UploadSpeed<br>";
echo "Standard Price: $package->StandardPrice<br>";
echo "Setup Fee: $package->SetupFee<br>";
echo "Image URL: $package->ImageURL<br>";
echo "Brand: $package->Brand<br>";
echo "Rating: $package->Rating<br>";
echo "Upfront Cost: $package->UpfrontCost<br>";

// // TEST: Update package
// $package->PackageName = "Updated Plan Name";
// if ($package->update()) {
//     echo "✏️ Package updated successfully.<br>";
// } else {
//     echo "❌ Failed to update package.<br>";
// }

// // TEST: Delete package
// $package->PackageID = 201; // change to valid ID to delete
// if ($package->delete()) {
//     echo "🗑️ Package deleted successfully.<br>";
// } else {
//     echo "❌ Failed to delete package.<br>";
// }

// TEST: Read by type
echo "<h3>📦 Mobile Packages</h3>";
$stmt = $package->readByType("BroadbandOnly");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $PackageID - $PackageName<br>";
}


// Get the filter type from the query parameter
$filter_type = 'MobileOnly';

$package = new Package($pdo);
if ($filter_type === 'All') {
    $package_stmt = $package->readAll();
} else {
    // Assuming the Package model has a method to filter by type
    $package_stmt = $package->readByType($filter_type);
}

// Display the filtered packages
echo "<h3>📦 Filtered Packages ($filter_type)</h3>";
while ($row = $package_stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $PackageID - $PackageName ($Type) - $Price USD<br>";
}



?>

