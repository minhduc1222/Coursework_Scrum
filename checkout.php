<?php
session_start();

include './includes/database.php';
include './models/Package.php';
include './models/Order.php';
include './models/Deal.php';
include './models/SpecialOffer.php';

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php?redirect=checkout");
    exit;
}

// Initialize models
$packageModel = new Package($pdo);
$orderModel = new Order($pdo);
$dealModel = new Deal($pdo);
$specialOfferModel = new SpecialOffer($pdo);

// Initialize cart_items to prevent undefined variable
$cart_items = [];

// Determine checkout mode
$deal_id = isset($_GET['deal_id']) ? (int)$_GET['deal_id'] : 0;
$is_deal_checkout = $deal_id > 0;

if ($is_deal_checkout) {
    // Deal-based checkout
    $dealModel->DealID = $deal_id;
    $dealModel->readOne();
    if (!$dealModel->DealName) {
        header("Location: offers.php?status=deal_not_found");
        exit;
    }
    $deal_packages_stmt = $dealModel->getDealPackages();
    $deal_packages = $deal_packages_stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($deal_packages)) {
        header("Location: offers.php?status=no_packages");
        exit;
    }
    // Calculate total
    $total = 0;
    foreach ($deal_packages as $package) {
        $total += $package['Price'];
    }
    $discount_percentage = $dealModel->DiscountPercentage;
    $discounted_total = $total * (1 - $discount_percentage / 100);
} else {
    // Cart-based checkout
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        header("Location: cart.php?status=empty");
        exit;
    }
    // Calculate cart total
    $cart_total = 0;
    foreach ($_SESSION['cart'] as $packageID => $item) {
        $packageModel->PackageID = $packageID;
        $packageModel->readOne();
        $cart_total += $packageModel->Price;
        $cart_items[$packageID] = [
            'PackageID' => $packageModel->PackageID,
            'PackageName' => $packageModel->PackageName,
            'Type' => $packageModel->Type,
            'Price' => $packageModel->Price,
            'Description' => $packageModel->Description,
            'FreeMinutes' => $packageModel->FreeMinutes,
            'FreeSMS' => $packageModel->FreeSMS,
            'FreeGB' => $packageModel->FreeGB
        ];
    }
}

// Handle checkout submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $customerID = $_SESSION['customer_id'];
    $orderType = 'App';
    $status = 'Pending';
    $specialOfferID = isset($_POST['special_offer_id']) ? (int)$_POST['special_offer_id'] : null;

    if ($is_deal_checkout) {
        // Process deal-based checkout
        $totalAmount = $total;
        $dealDiscount = $dealModel->DiscountPercentage;
        $specialOfferDiscount = 0;

        // Fetch special offer discount if applicable
        if ($specialOfferID) {
            $specialOfferModel->SpecialOfferID = $specialOfferID;
            $specialOfferModel->readOne();
            if ($specialOfferModel->ExpiryDate >= date('Y-m-d')) {
                $specialOfferDiscount = $specialOfferModel->DiscountPercentage;
            }
        }

        // Calculate total with discounts
        $orderModel->calculateTotal($totalAmount, $dealDiscount, $specialOfferDiscount);

        // Create an order for each package in the deal
        $orderIDs = [];
        foreach ($deal_packages as $package) {
            $orderModel->CustomerID = $customerID;
            $orderModel->PackageID = $package['PackageID'];
            $orderModel->DealID = $deal_id;
            $orderModel->SpecialOfferID = $specialOfferID;
            $orderModel->OrderType = $orderType;
            $orderModel->Status = $status;
            $orderModel->OrderDate = date('Y-m-d H:i:s');

            $orderID = $orderModel->create();
            if ($orderID) {
                $orderIDs[] = $orderID;
            }
        }

        if (!empty($orderIDs)) {
            $firstOrderID = $orderIDs[0];
            header("Location: order-confirmation.php?order_id=$firstOrderID");
            exit;
        } else {
            $error = "Failed to place the order. Please try again.";
        }
    } else {
        // Process cart-based checkout
        $dealID = isset($_POST['deal_id']) ? (int)$_POST['deal_id'] : null;
        $totalAmount = $cart_total;
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

        // Calculate total with discounts
        $orderModel->calculateTotal($totalAmount, $dealDiscount, $specialOfferDiscount);

        // Create an order for each package in the cart
        $orderIDs = [];
        foreach ($_SESSION['cart'] as $packageID => $item) {
            $orderModel->CustomerID = $customerID;
            $orderModel->PackageID = $packageID;
            $orderModel->DealID = $dealID;
            $orderModel->SpecialOfferID = $specialOfferID;
            $orderModel->OrderType = $orderType;
            $orderModel->Status = $status;
            $orderModel->OrderDate = date('Y-m-d H:i:s');

            $orderID = $orderModel->create();
            if ($orderID) {
                $orderIDs[] = $orderID;
            }
        }

        if (!empty($orderIDs)) {
            $_SESSION['cart'] = [];
            $firstOrderID = $orderIDs[0];
            header("Location: order-confirmation.php?order_id=$firstOrderID");
            exit;
        } else {
            $error = "Failed to place the order. Please try again.";
        }
    }
}

// Fetch available deals and special offers
if (!$is_deal_checkout) {
    $deals = $dealModel->readCurrent()->fetchAll(PDO::FETCH_ASSOC);
    $specialOffers = $specialOfferModel->readActive()->fetchAll(PDO::FETCH_ASSOC);
} else {
    $specialOffers = $specialOfferModel->readActive()->fetchAll(PDO::FETCH_ASSOC);
}

// Load the checkout template
ob_start();
include './templates/checkout.html.php';
$page_content = ob_get_clean();
include './layout-mobile.html.php';
?>