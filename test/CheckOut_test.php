<?php
require_once '../Include/database.php';
require_once '../models/Customer.php';
require_once '../models/Package.php';
require_once '../models/CustomPackage.php';
require_once '../models/Order.php';
require_once '../models/Payment.php';

// Create instances
$customer = new Customer($pdo);
$package = new Package($pdo);
$customPackage = new CustomPackage($pdo);
$order = new Order($pdo);
$payment = new Payment($pdo);

// TEST: Checkout Flow
echo "<h3>🛒 Checkout Flow Test</h3>";

// Step 1: Get Customer Info
$customer->CustomerID = 12; // Example CustomerID
$customer->readOne();

if ($customer->Name) {
    echo "✅ Customer found: {$customer->Name}, Balance: {$customer->Balance}<br>";
    echo "Email: {$customer->Email}, Payment Method: {$customer->PaymentMethod}<br>";
} else {
    echo "❌ Customer not found for ID: {$customer->CustomerID}<br>";
    exit;
}

// Step 2: Get All Packages
echo "<h4>📦 All Available Packages</h4>";
$stmt = $package->readAll();
$packageCount = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $PackageID - $PackageName ($Type) - $Price USD<br>";
    $packageCount++;
}
echo "✅ Retrieved $packageCount packages.<br>";

// Step 3: Get Customer's Custom Packages
echo "<h4>📦 Custom Packages for Customer #{$customer->CustomerID}</h4>";
$stmt = $customPackage->readByCustomer($customer->CustomerID);
$customPackageCount = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• $PackageID - $PackageName ($Type) - $Price USD<br>";
    $customPackageCount++;
}
echo "✅ Retrieved $customPackageCount custom packages.<br>";

// Step 4: Simulate Cart and Calculate Total
echo "<h4>🛍️ Cart Contents</h4>";
$selectedPackageIDs = [1, 2]; // Example: Selected package IDs
$selectedCustomPackageIDs = [25, 26]; // Example: Selected custom package IDs
$cartPackages = [];
$cartCustomPackages = [];
$totalCost = 0;

// Fetch selected packages
foreach ($selectedPackageIDs as $packageID) {
    $package->PackageID = $packageID;
    $package->readOne();
    if ($package->PackageName) {
        $cartPackages[] = [
            'PackageID' => $package->PackageID,
            'Name' => $package->PackageName,
            'Price' => $package->Price,
            'UpfrontCost' => $package->UpfrontCost
        ];
        $cost = $package->Price + ($package->UpfrontCost ?? 0);
        $totalCost += $cost;
        echo "• Package: {$package->PackageName} - $cost USD<br>";
    } else {
        echo "⚠️ Package ID $packageID not found.<br>";
    }
}

// Fetch selected custom packages
foreach ($selectedCustomPackageIDs as $customPackageID) {
    $customPackage->PackageID = $customPackageID;
    $customPackage->readOne();
    if ($customPackage->PackageName) {
        $cartCustomPackages[] = [
            'CustomPackageID' => $customPackage->PackageID,
            'Name' => $customPackage->PackageName,
            'Price' => $customPackage->Price,
            'UpfrontCost' => $customPackage->UpfrontCost
        ];
        $cost = $customPackage->Price + ($customPackage->UpfrontCost ?? 0);
        $totalCost += $cost;
        echo "• Custom Package: {$customPackage->PackageName} - $cost USD<br>";
    } else {
        echo "⚠️ Custom Package ID $customPackageID not found.<br>";
    }
}

echo "✅ Cart total: $totalCost USD<br>";

// Step 5: Verify Customer Balance
echo "<h4>💰 Balance Check</h4>";
if ($customer->Balance >= $totalCost) {
    echo "✅ Sufficient balance: {$customer->Balance} USD<br>";
} else {
    echo "❌ Insufficient balance: {$customer->Balance} < $totalCost USD<br>";
    exit;
}

// Step 6: Create Order
echo "<h4>📝 Creating Order</h4>";
$order->CustomerID = $customer->CustomerID;
$order->DealID = null;
$order->SpecialOfferID = null;
$order->TotalAmount = $totalCost;
$order->DiscountApplied = 0;
$order->OrderType = 'Package Purchase';
$order->OrderDate = date('Y-m-d H:i:s');
$order->Status = 'Pending';
$order->PaymentID = null;

$orderID = $order->create();
if ($orderID) {
    echo "✅ Order created successfully: OrderID $orderID<br>";
} else {
    echo "❌ Failed to create order.<br>";
    exit;
}

// Step 7: Save to order_package
echo "<h4>🔗 Linking Packages to Order</h4>";
foreach ($cartPackages as $cartPackage) {
    if ($order->addOrderPackage($orderID, $cartPackage['PackageID'])) {
        echo "✅ Added package: {$cartPackage['Name']} to order<br>";
    } else {
        echo "❌ Failed to add package ID {$cartPackage['PackageID']} to order<br>";
    }
}

// Step 8: Save to order_custom_package
foreach ($cartCustomPackages as $cartCustomPackage) {
    if ($order->addOrderCustomPackage($orderID, $cartCustomPackage['CustomPackageID'])) {
        echo "✅ Added custom package: {$cartCustomPackage['Name']} to order<br>";
    } else {
        echo "❌ Failed to add custom package ID {$cartCustomPackage['CustomPackageID']} to order<br>";
    }
}

// Step 9: Create Payment
echo "<h4>💳 Creating Payment</h4>";
$payment->CustomerID = $customer->CustomerID;
$payment->PaymentDate = date('Y-m-d H:i:s');
$payment->Status = 'Completed';

$paymentID = $payment->create();
if ($paymentID) {
    echo "✅ Payment created successfully: PaymentID $paymentID<br>";
} else {
    echo "❌ Failed to create payment.<br>";
    exit;
}

// Step 10: Update Order with PaymentID and Status
echo "<h4>🔄 Updating Order</h4>";
$order->OrderID = $orderID;
$order->PaymentID = $paymentID;
$order->Status = 'Completed';

// Update PaymentID separately since updateStatus only updates Status
$query = "UPDATE orders SET PaymentID = :paymentID, Status = :status WHERE OrderID = :orderID";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':paymentID', $order->PaymentID);
$stmt->bindParam(':status', $order->Status);
$stmt->bindParam(':orderID', $order->OrderID);

if ($stmt->execute()) {
    echo "✅ Order updated with PaymentID and status 'Completed'<br>";
} else {
    echo "❌ Failed to update order.<br>";
    exit;
}

// Step 11: Update Customer Balance
echo "<h4>💸 Updating Customer Balance</h4>";
$customer->Balance -= $totalCost;
if ($customer->update()) {
    echo "✅ Customer balance updated: New balance = {$customer->Balance} USD<br>";
} else {
    echo "❌ Failed to update customer balance.<br>";
    exit;
}

echo "<h3>🎉 Checkout Flow Completed Successfully!</h3>";
?>