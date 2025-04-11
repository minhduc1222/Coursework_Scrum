<?php
require_once '../config/db.php';
require_once '../models/Order.php';

$order = new Order($pdo);

// === CREATE new order ===
echo "<h3>🆕 Create Order</h3>";
$order->CustomerID = 1; // Ensure this exists
$order->PackageID = 201;  // Ensure this exists
$order->DealID = 101;     // Can be null or existing
$order->SpecialOfferID = 1; // Can be null or existing
$order->calculateTotal(100, 10, 20); // example base price and discounts
$order->OrderType = "Online";
$order->Status = "Pending";

$newOrderId = $order->create();
if ($newOrderId) {
    echo "✅ Order created successfully. Order ID: $newOrderId<br>";
} else {
    echo "❌ Failed to create order.<br>";
}

// === READ ALL orders ===
echo "<h3>📋 All Orders</h3>";
$stmt = $order->readAll();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $OrderID - $CustomerName - $PackageName - Total: $TotalAmount - Status: $Status<br>";
}

// === READ ONE order ===
echo "<h3>🔍 Read Single Order</h3>";
$order->OrderID = 301; // Replace with a valid ID
$order->readOne();
echo "CustomerID: $order->CustomerID<br>";
echo "PackageID: $order->PackageID<br>";
echo "SpecialOfferID: $order->SpecialOfferID<br>";
echo "TotalAmount: $order->TotalAmount<br>";
echo "DiscountApplied: $order->DiscountApplied<br>";
echo "Status: $order->Status<br>";

// === READ orders by Customer ===
echo "<h3>👤 Orders by Customer</h3>";
$stmt = $order->readByCustomer(1); // Replace with existing CustomerID
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $OrderID - Package: $PackageName - Total: $TotalAmount - Status: $Status<br>";
}

// === UPDATE order status ===
echo "<h3>✏️ Update Order Status</h3>";
$order->OrderID = 301; // Replace with a valid ID
$order->Status = "Completed";

if ($order->updateStatus()) {
    echo "✅ Order status updated to Completed.<br>";
} else {
    echo "❌ Failed to update order status.<br>";
}

// === DELETE order ===
echo "<h3>🗑️ Delete Order</h3>";
$order->OrderID = $newOrderId; // Just-created order
if ($order->delete()) {
    echo "✅ Order deleted successfully.<br>";
} else {
    echo "❌ Failed to delete order.<br>";
}

// === CALCULATE TOTAL (manual test) ===
echo "<h3>🧮 Calculate Total</h3>";
$finalPrice = $order->calculateTotal(200, 25, 30); // This should cap at 50%
echo "Final Price after discount: $finalPrice<br>";
echo "Discount Applied: $order->DiscountApplied<br>";
?>
