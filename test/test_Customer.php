<?php
require_once '../config/db.php';
require_once '../models/Customer.php';

$customer = new Customer($pdo);

// // === CREATE Customer ===
// echo "<h3>🆕 Create Customer</h3>";
// $customer->Name = "John Doe";
// $customer->Email = "john@example.com";
// $customer->Password = "secure123";
// $customer->Address = "123 Main St";
// $customer->PhoneNumber = "0123456789";
// $customer->CreditCardInfo = "4111111111111111";

// if ($customer->create()) {
//     echo "✅ Customer created successfully.<br>";
// } else {
//     echo "❌ Failed to create customer.<br>";
// }

// === READ ALL Customers ===
echo "<h3>📋 All Customers</h3>";
$stmt = $customer->readAll();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    echo "• ID: $CustomerID - Name: $Name - Email: $Email<br>";
}

// === READ ONE Customer ===
echo "<h3>🔍 Read Single Customer</h3>";
$customer->CustomerID = 1; // Change based on existing ID
$customer->readOne();
echo "Name: $customer->Name<br>";
echo "Email: $customer->Email<br>";
echo "Address: $customer->Address<br>";
echo "Phone: $customer->PhoneNumber<br>";
echo "Card: $customer->CreditCardInfo<br>";
echo "Date: $customer->RegistrationDate<br>";

// === UPDATE Customer ===
echo "<h3>✏️ Update Customer</h3>";
$customer->CustomerID = 1;
$customer->Name = "John Updated";
$customer->Email = "updated@example.com";
$customer->Address = "456 New Road";
$customer->PhoneNumber = "0987654321";
$customer->CreditCardInfo = "5555555555554444";

if ($customer->update()) {
    echo "✅ Customer updated successfully.<br>";
} else {
    echo "❌ Failed to update customer.<br>";
}

// === LOGIN Customer ===
echo "<h3>🔐 Login Test</h3>";
$customer->Email = "bob.smith@example.com";
$customer->Password = "bobsecure!"; // Use original password

$loginResult = $customer->login();
if ($loginResult) {
    echo "✅ Login successful. Welcome, {$loginResult['Name']} (ID: {$loginResult['CustomerID']})<br>";
} else {
    echo "❌ Login failed. Invalid credentials.<br>";
}

// === DELETE Customer === Cant delete when it's linked to order
// echo "<h3>🗑️ Delete Customer</h3>";
// $customer->CustomerID = 1; // Change this ID to test deletion safely
// if ($customer->delete()) {
//     echo "✅ Customer deleted successfully.<br>";
// } else {
//     echo "❌ Failed to delete customer.<br>";
// }
?>
