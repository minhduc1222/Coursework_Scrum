<?php
require_once '../config/database.php';       // Your PDO connection
require_once '../models/Deal.php';     // Your Deal class

// Create Deal instance
$deal = new Deal($pdo);

// Test: Create a new deal
$deal->DealName = "Summer Special";
$deal->Description = "25% off on all mobile packages";
$deal->DiscountPercentage = 25;
$deal->ValidFrom = "2025-04-01";
$deal->ValidTo = "2025-04-30";

echo "<h3>Creating Deal...</h3>";
if ($deal->create()) {
    echo "✅ Deal created successfully.<br>";
} else {
    echo "❌ Failed to create deal.<br>";
}

// Test: Read all deals
echo "<h3>All Deals:</h3>";
$stmt = $deal->readAll();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "ID: $DealID | Name: $DealName | Discount: $DiscountPercentage%<br>";
}

// Test: Read current deals
echo "<h3>Current Deals:</h3>";
$stmt = $deal->readCurrent();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "ID: $DealID | Name: $DealName | Valid: $ValidFrom to $ValidTo<br>";
}

// Test: Read one deal
echo "<h3>Reading Deal with ID 1:</h3>";
$deal->DealID = 101;
$deal->readOne();
echo "Name: $deal->DealName | Discount: $deal->DiscountPercentage%<br>";

// Test: Update a deal
$deal->DealID = 1;
$deal->DealName = "Updated Deal Name";
$deal->Description = "Updated Description";
$deal->DiscountPercentage = 30;
$deal->ValidFrom = "2025-04-10";
$deal->ValidTo = "2025-05-10";

echo "<h3>Updating Deal ID 1...</h3>";
if ($deal->update()) {
    echo "✅ Deal updated successfully.<br>";
} else {
    echo "❌ Failed to update deal.<br>";
}

// Test: Delete a deal
$deal->DealID = 2; // Make sure this ID exists to test deletion
echo "<h3>Deleting Deal ID 2...</h3>";
if ($deal->delete()) {
    echo "✅ Deal deleted successfully.<br>";
} else {
    echo "❌ Failed to delete deal.<br>";
}

echo "<h3>Deal Packages:</h3>";
$deal->DealID = 1;
echo "Deal ID: " . $deal->DealID . "<br>";
$stmt = $deal->getDealPackages();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Package: " . $row['PackageName'] . " - Price: $" . $row['Price'] . "<br>";
}

echo "<h3>All Deals with Packages:</h3>";
$stmt = $deal->getAllDealsPackages();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Deal: " . $row['DealName'] . " - Package: " . ($row['PackageName'] ?: 'None') . "<br>";
}

?>
