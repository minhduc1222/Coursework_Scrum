<?php
session_start();

include '../config/database.php';
include '../models/Package.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$package = new Package($pdo);
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $package_id = (int)($_GET['id'] ?? 0);
    
        if ($package_id > 0) {
            $package->PackageID = $package_id;
            $package->readOne();
    
            if ($package->PackageName) {
                // Check if same type already exists in the cart
                foreach ($_SESSION['cart'] ?? [] as $item) {
                    if ($item['package']['Type'] === $package->Type) {
                        header("Location: cart.php?status=type_exists&type=" . urlencode($package->Type));
                        exit;
                    }
                }
    
                // Add package if type is not already in cart
                $_SESSION['cart'][$package_id] = [
                    'package' => [
                        'PackageID' => $package->PackageID,
                        'PackageName' => $package->PackageName,
                        'Price' => $package->Price,
                        'Type' => $package->Type,
                    ]
                ];
    
                header("Location: cart.php?status=added");
                exit;
            } else {
                header("Location: cart.php?status=error");
                exit;
            }
        }
        break;
    
    case 'remove':
        $package_id = (int)($_GET['id'] ?? 0);
        if (isset($_SESSION['cart'][$package_id])) {
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

// Load cart display
ob_start();
include '../templates/cart.html.php';
$page_content = ob_get_clean();
include '../layout-mobile.html.php';
