<?php
require_once '../config/db.php';
require_once '../models/SpecialOffer.php';

// Create model instance
$offer = new SpecialOffer($pdo);

// === CREATE new special offer ===
echo "<h3>🆕 Create Special Offer</h3>";
$offer->Description = "5% off broadband + mobile combo";
$offer->DiscountPercentage = 5.00;
$offer->ExpiryDate = "2025-06-01";
$offer->Conditions = "Valid for new customers only.";

if ($offer->create()) {
    echo "✅ Special offer created successfully.<br>";
} else {
    echo "❌ Failed to create special offer.<br>";
}

// === READ ALL special offers ===
echo "<h3>📋 All Special Offers</h3>";
$stmt = $offer->readAll();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $SpecialOfferID - $Description ($DiscountPercentage%) - Expires: $ExpiryDate<br>";
}

// === READ ACTIVE offers ===
echo "<h3>✅ Active Offers</h3>";
$stmt = $offer->readActive();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $SpecialOfferID - $Description (Expires: $ExpiryDate)<br>";
}

// === READ ONE by ID ===
$offer->SpecialOfferID = 1; // Change to existing ID
$offer->readOne();
echo "<h3>🔍 Offer ID 1 Details</h3>";
echo "Description: $offer->Description<br>";
echo "Discount: $offer->DiscountPercentage%<br>";
echo "Expiry: $offer->ExpiryDate<br>";
echo "Conditions: " . ($offer->Conditions ?? "None") . "<br>";

// === UPDATE an offer ===
echo "<h3>✏️ Update Offer</h3>";
$offer->SpecialOfferID = 2; // Update existing ID
$offer->Description = "Updated offer: 18% off broadband";
$offer->DiscountPercentage = 18.00;
$offer->ExpiryDate = "2025-05-20";
$offer->Conditions = "Applies to premium plans only";

if ($offer->update()) {
    echo "✅ Offer updated successfully.<br>";
} else {
    echo "❌ Failed to update offer.<br>";
}

// === DELETE an offer ===
echo "<h3>🗑️ Delete Offer</h3>";
$offer->SpecialOfferID = 3; // Change to a real ID you want to delete

if ($offer->delete()) {
    echo "✅ Offer deleted successfully.<br>";
} else {
    echo "❌ Failed to delete offer.<br>";
}
?>
