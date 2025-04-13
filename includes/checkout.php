<?php
session_start(); // Start the session to access cart data

// Include database and models
include '../config/database.php';
include '../models/Package.php';
include '../models/Order.php';
include '../models/Deal.php';
include '../models/SpecialOffer.php';

// Check if user is logged in (you might have a user session variable)
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php?redirect=checkout");
    exit;
}

// Initialize models
$packageModel = new Package($pdo);
$orderModel = new Order($pdo);
$dealModel = new Deal($pdo);
$specialOfferModel = new SpecialOffer($pdo);

// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php?status=empty");
    exit;
}

// Handle checkout submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $customerID = $_SESSION['customer_id'];
    $orderType = 'App'; // Since this is through the app
    $status = 'Pending';
    $dealID = isset($_POST['deal_id']) ? (int)$_POST['deal_id'] : null;
    $specialOfferID = isset($_POST['special_offer_id']) ? (int)$_POST['special_offer_id'] : null;

    // Calculate total with discounts
    $totalAmount = 0;
    $dealDiscount = 0;
    $specialOfferDiscount = 0;

    // Fetch deal discount if applicable
    if ($dealID) {
        $dealModel->DealID = $dealID;
        $dealModel->readOne();
        if ($dealModel->ValidFrom <= date('Y-m-d') && $dealModel->ValidTo >= date('Y-m-d')) {
            $dealDiscount = $dealModel->DiscountPercentage;
        }
    }

    // Fetch special offer discount if applicable
    if ($specialOfferID) {
        $specialOfferModel->SpecialOfferID = $specialOfferID;
        $specialOfferModel->readOne();
        if ($specialOfferModel->ExpiryDate >= date('Y-m-d')) {
            $specialOfferDiscount = $specialOfferModel->DiscountPercentage;
        }
    }

    // Calculate total for each item in the cart
    foreach ($_SESSION['cart'] as $packageID => $item) {
        $packageModel->PackageID = $packageID;
        $packageModel->readOne();
        $subtotal = $packageModel->Price * $item['quantity'];
        $totalAmount += $subtotal;
    }

    // Apply discounts
    $orderModel->calculateTotal($totalAmount, $dealDiscount, $specialOfferDiscount);

    // Create the order
    $orderModel->CustomerID = $customerID;
    $orderModel->PackageID = array_key_first($_SESSION['cart']); // For simplicity, using the first package; adjust if multiple packages need separate orders
    $orderModel->DealID = $dealID;
    $orderModel->SpecialOfferID = $specialOfferID;
    $orderModel->OrderType = $orderType;
    $orderModel->Status = $status;
    $orderModel->OrderDate = date('Y-m-d H:i:s');

    $orderID = $orderModel->create();
    if ($orderID) {
        // Clear the cart after successful order
        $_SESSION['cart'] = [];
        header("Location: order-confirmation.php?order_id=$orderID");
        exit;
    } else {
        $error = "Failed to place the order. Please try again.";
    }
}

// Fetch available deals and special offers
$deals = $dealModel->readCurrent()->fetchAll(PDO::FETCH_ASSOC);
$specialOffers = $specialOfferModel->readActive()->fetchAll(PDO::FETCH_ASSOC);

// Calculate cart total for display
$cartTotal = 0;
foreach ($_SESSION['cart'] as $packageID => $item) {
    $packageModel->PackageID = $packageID;
    $packageModel->readOne();
    $cartTotal += $packageModel->Price * $item['quantity'];
}

// Load the checkout template
ob_start();
include '../templates/checkout.html.php';
$page_content = ob_get_clean();

// Render inside the layout
include '../layout-mobile.html.php';
?>