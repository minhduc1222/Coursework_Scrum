<?php
session_start(); // Start the session to store cart data

// Include database and model
include '../config/database.php';
include '../models/Package.php';

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$package = new Package($pdo);

// Handle cart actions
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'add':
        $package_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

        if ($package_id > 0) {
            // Fetch package details
            $package->PackageID = $package_id;
            $package->readOne();

            if ($package->PackageName) { // Ensure package exists
                if (isset($_SESSION['cart'][$package_id])) {
                    // Update quantity if package already in cart
                    $_SESSION['cart'][$package_id]['quantity'] += $quantity;
                } else {
                    // Add new package to cart
                    $_SESSION['cart'][$package_id] = [
                        'quantity' => $quantity,
                        'package' => [
                            'PackageID' => $package->PackageID,
                            'PackageName' => $package->PackageName,
                            'Price' => $package->Price,
                            'Type' => $package->Type,
                            'ImageURL' => $package->ImageURL
                        ]
                    ];
                }
                header("Location: cart.php?status=added");
                exit;
            } else {
                header("Location: cart.php?status=error");
                exit;
            }
        }
        break;

    case 'update':
        $package_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 0;

        if ($package_id > 0 && $quantity >= 0) {
            if ($quantity == 0) {
                // Remove item if quantity is 0
                unset($_SESSION['cart'][$package_id]);
            } elseif (isset($_SESSION['cart'][$package_id])) {
                // Update quantity
                $_SESSION['cart'][$package_id]['quantity'] = $quantity;
            }
            header("Location: cart.php?status=updated");
            exit;
        }
        break;

    case 'remove':
        $package_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($package_id > 0 && isset($_SESSION['cart'][$package_id])) {
            unset($_SESSION['cart'][$package_id]);
            header("Location: cart.php?status=removed");
            exit;
        }
        break;

    case 'clear':
        $_SESSION['cart'] = [];
        header("Location: cart.php?status=cleared");
        exit;
        break;
}

// Load the cart template
ob_start();
include '../templates/cart.html.php';
$page_content = ob_get_clean();

// Render it inside the layout (adjust path if needed)
include '../layout-mobile.html.php';