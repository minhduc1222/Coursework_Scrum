<?php
require_once '../config/database.php';
require_once '../models/MobileFeature.php';

$mobileFeature = new MobileFeature($pdo);

// === READ ALL mobile features ===
echo "<h3>📱 All Mobile Features</h3>";
$stmt = $mobileFeature->readAll();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• PackageID: $PackageID - FeatureID: $FeatureID - Feature: $Feature<br>";
}

// === READ mobile features by Package ID ===
echo "<h3>🔍 Mobile Features by Package ID</h3>";
$testPackageID = 1; // Replace with a valid Mobile PackageID
$stmt = $mobileFeature->getFeaturesByPackageId($testPackageID);
echo "Mobile Features for Package ID $testPackageID:<br>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $Feature<br>";
}
?>
