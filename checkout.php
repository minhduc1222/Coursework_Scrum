<?php
session_start();

include './Include/database.php';
include './models/Package.php';
include './models/CustomPackage.php';
include './models/Order.php';
include './models/Deal.php';
include './models/SpecialOffer.php';
include './models/Customer.php'; // ✅ Add Customer model

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php?redirect=checkout");
    exit;
}

// Initialize models
$packageModel = new Package($pdo);
$customPackageModel = new CustomPackage($pdo);
$orderModel = new Order($pdo);
$dealModel = new Deal($pdo);
$specialOfferModel = new SpecialOffer($pdo);
$customerModel = new Customer($pdo); // ✅ Initialize Customer model

// Fetch customer details
$customerModel->CustomerID = $_SESSION['customer_id'];
$customerModel->readOne();
$customer = [
    'Name' => $customerModel->Name,
    'Email' => $customerModel->Email,
    'Address' => $customerModel->Address,
    'PhoneNumber' => $customerModel->PhoneNumber,
    'PaymentMethod' => $customerModel->PaymentMethod // ✅ Include PaymentMethod
];

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
    // Calculate subtotal
    $subtotal = 0;
    foreach ($deal_packages as $package) {
        $subtotal += $package['Price'];
    }
    $deal_discount_percentage = $dealModel->DiscountPercentage;
    $deal_discounted_total = $subtotal * (1 - $deal_discount_percentage / 100);
    $total = $deal_discounted_total; // Total after deal discount
} else {
    // Cart-based checkout
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        header("Location: cart.php?status=empty");
        exit;
    }
    // Calculate cart subtotal
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $packageID => $item) {
        $itemType = $item['type'];
        $packageData = $item['package'];

        if ($itemType === 'Package') {
            $packageModel->PackageID = $packageID;
            $packageModel->readOne();
            $subtotal += $packageModel->Price;
            $cart_items[$packageID] = [
                'type' => 'Package',
                'PackageID' => $packageModel->PackageID,
                'PackageName' => $packageModel->PackageName,
                'Type' => $packageModel->Type,
                'Price' => $packageModel->Price,
                'Description' => $packageModel->Description,
                'FreeMinutes' => $packageModel->FreeMinutes,
                'FreeSMS' => $packageModel->FreeSMS,
                'FreeGB' => $packageModel->FreeGB,
                'img' => $packageModel->img
            ];
        } elseif ($itemType === 'CustomPackage') {
            $customPackageModel->PackageID = $packageID;
            $customPackageModel->readOne();
            $subtotal += $customPackageModel->Price;
            $cart_items[$packageID] = [
                'type' => 'CustomPackage',
                'PackageID' => $customPackageModel->PackageID,
                'PackageName' => $customPackageModel->PackageName,
                'Type' => $customPackageModel->Type,
                'Price' => $customPackageModel->Price,
                'Description' => $customPackageModel->Description
            ];
        }
    }
    $total = $subtotal; // Total before discounts for cart
    $deal_discount_percentage = 0; // Initialize for cart
}

// Handle checkout submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $customerID = $_SESSION['customer_id'];
    $orderType = 'App';
    $status = 'Pending';
    $special_offer_id = isset($_POST['special_offer_id']) ? (int)$_POST['special_offer_id'] : null;
    $payment_method = isset($_POST['payment_method']) ? htmlspecialchars($_POST['payment_method']) : $customerModel->PaymentMethod; // ✅ Capture payment method
    $special_offer_discount = 0;

    // Fetch special offer discount if applicable
    if ($special_offer_id) {
        $specialOfferModel->SpecialOfferID = $special_offer_id;
        $specialOfferModel->readOne();
        if ($specialOfferModel->ExpiryDate >= date('Y-m-d')) {
            $special_offer_discount = $specialOfferModel->DiscountPercentage;
        }
    }

    if ($is_deal_checkout) {
        // Process deal-based checkout
        $dealDiscount = $dealModel->DiscountPercentage;

        // Calculate total with discounts
        $final_total = $orderModel->calculateTotal($subtotal, $dealDiscount, $special_offer_discount);

        // Create an order for each package in the deal
        $orderIDs = [];
        foreach ($deal_packages as $package) {
            $orderModel->CustomerID = $customerID;
            $orderModel->PackageID = $package['PackageID'];
            $orderModel->DealID = $deal_id;
            $orderModel->SpecialOfferID = $special_offer_id;
            $orderModel->OrderType = $orderType;
            $orderModel->Status = $status;
            $orderModel->OrderDate = date('Y-m-d H:i:s');
            $orderModel->PackageType = 'Package'; // Deal packages are standard packages
            $orderModel->TotalAmount = $package['Price'] * (1 - $dealDiscount / 100) * (1 - $special_offer_discount / 100); // Per-package total

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
        $dealDiscount = 0;

        // Fetch deal discount if applicable
        if ($dealID) {
            $dealModel->DealID = $dealID;
            $dealModel->readOne();
            if ($dealModel->ValidFrom <= date('Y-m-d') && $dealModel->ValidTo >= date('Y-m-d')) {
                $dealDiscount = $dealModel->DiscountPercentage;
            }
        }

        // Calculate total with discounts
        $final_total = $orderModel->calculateTotal($subtotal, $dealDiscount, $special_offer_discount);

        // Create an order for each item in the cart
        $orderIDs = [];
        foreach ($_SESSION['cart'] as $packageID => $item) {
            $itemType = $item['type'];
            $orderModel->CustomerID = $customerID;
            $orderModel->PackageID = $packageID;
            $orderModel->DealID = $dealID;
            $orderModel->SpecialOfferID = $special_offer_id;
            $orderModel->OrderType = $orderType;
            $orderModel->Status = $status;
            $orderModel->OrderDate = date('Y-m-d H:i:s');
            $orderModel->PackageType = $itemType;
            $orderModel->TotalAmount = $item['package']['Price'] * (1 - $dealDiscount / 100) * (1 - $special_offer_discount / 100); // Per-item total

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

// Calculate display totals for the template
$special_offer_discount = 0;
if (isset($_POST['special_offer_id']) && $_POST['special_offer_id']) {
    $specialOfferModel->SpecialOfferID = (int)$_POST['special_offer_id'];
    $specialOfferModel->readOne();
    if ($specialOfferModel->ExpiryDate >= date('Y-m-d')) {
        $special_offer_discount = $specialOfferModel->DiscountPercentage;
    }
}
$final_total = $total * (1 - $special_offer_discount / 100);
$special_offer_discount_amount = $total - $final_total;

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