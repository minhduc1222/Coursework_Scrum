<?php
require_once '../config/database.php';
require_once '../models/TabletSpec.php';

$tabletSpec = new TabletSpec($pdo);

// === READ ALL tablet specs ===
echo "<h3>📋 All Tablet Specs</h3>";
$stmt = $tabletSpec->readAll();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• SpecID: $SpecID - PackageID: $PackageID - $SpecName: $SpecValue<br>";
}

// === READ specs by Package ID ===
echo "<h3>🔍 Specs by Package ID</h3>";
$testPackageID = 3; // Replace with a valid PackageID from your DB
$specs = $tabletSpec->getSpecsByPackageId($testPackageID);
echo "Specs for Package ID $testPackageID:<br>";
foreach ($specs as $spec) {
    echo "• {$spec['SpecName']}: {$spec['SpecValue']}<br>";
}
?>
