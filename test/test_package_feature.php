<?php
require_once '../config/db.php';
require_once '../models/Package_feature.php';

$packageFeature = new PackageFeature($pdo);

// === READ ALL package features ===
echo "<h3>📦 All Package Features</h3>";
$stmt = $packageFeature->readAll();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• PackageID: $PackageID - FeatureID: $FeatureID - Feature: $Feature<br>";
}

// === READ features by Package ID ===
echo "<h3>🔍 Features by Package ID</h3>";
$testPackageID = 1; // Replace with a valid PackageID
$stmt = $packageFeature->getFeaturesByPackageId($testPackageID);
echo "Features for Package ID $testPackageID:<br>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $Feature<br>";
}
?>
