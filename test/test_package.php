<?php
require_once '../config/db.php';
require_once '../models/Package.php';

// Create Package instance
$package = new Package($pdo);

// TEST: Create new package
$package->PackageName = "Starter Mobile Plan";
$package->Description = "Perfect for light users.";
$package->Type = "Mobile";
$package->Price = 9.99;
$package->FreeMinutes = 100;
$package->FreeSMS = 50;
$package->FreeGB = 1;

if ($package->create()) {
    echo "✅ Package created successfully.<br>";
} else {
    echo "❌ Failed to create package.<br>";
}

// TEST: Read all packages
echo "<h3>📦 All Packages</h3>";
$stmt = $package->readAll();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $PackageID - $PackageName ($Type) - $Price USD<br>";
}

// TEST: Read package by ID
$package->PackageID = 201; // change ID to an existing one
$package->readOne();
echo "<h3>📄 Package Details</h3>";
echo "Name: $package->PackageName<br>";
echo "Description: $package->Description<br>";
echo "Type: $package->Type<br>";

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
?>
