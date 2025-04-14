<?php
session_start();

include './Include/database.php';
include './models/Package.php';
include './models/CustomPackage.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$package = new Package($pdo);
$custom_package = new CustomPackage($pdo);
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $package_id = (int)($_GET['id'] ?? 0);
    
        if ($package_id > 0) {
            $package->PackageID = $package_id;
            $package->readOne();
    
            if ($package->PackageName) {
                // Check if same type already exists in the cart
                foreach ($_SESSION['cart'] as $item) {
                    if (isset($item['package']['Type']) && $item['package']['Type'] === $package->Type) {
                        header("Location: cart.php?status=type_exists&type=" . urlencode($package->Type));
                        exit;
                    }
                }
    
                // Add package if type is not already in cart
                $_SESSION['cart'][$package_id] = [
                    'type' => 'Package',
                    'package' => [
                        'PackageID' => $package->PackageID,
                        'PackageName' => $package->PackageName,
                        'Price' => $package->Price,
                        'Type' => $package->Type,
                        'Description' => $package->Description,
                        'img' => $package->img
                    ]
                ];
    
                header("Location: cart.php?status=added");
                exit;
            } else {
                header("Location: cart.php?status=error&message=Invalid package ID");
                exit;
            }
        } else {
            header("Location: cart.php?status=error&message=Package ID not provided");
            exit;
        }
        break;

    case 'add_custom':
        $package_id = (int)($_GET['id'] ?? 0);
    
        if ($package_id > 0) {
            $custom_package->PackageID = $package_id;
            $custom_package->readOne();
    
            if ($custom_package->PackageName) {
                // Check if same type already exists in the cart
                foreach ($_SESSION['cart'] as $item) {
                    if (isset($item['package']['Type']) && $item['package']['Type'] === $custom_package->Type) {
                        header("Location: cart.php?status=type_exists&type=" . urlencode($custom_package->Type));
                        exit;
                    }
                }
    
                // Add custom package if type is not already in cart
                $_SESSION['cart'][$package_id] = [
                    'type' => 'CustomPackage',
                    'package' => [
                        'PackageID' => $custom_package->PackageID,
                        'PackageName' => $custom_package->PackageName,
                        'Price' => $custom_package->Price,
                        'Type' => $custom_package->Type,
                        'Description' => $custom_package->Description,
                    ]
                ];
    
                header("Location: cart.php?status=added");
                exit;
            } else {
                header("Location: cart.php?status=error&message=Invalid custom package ID");
                exit;
            }
        } else {
            header("Location: cart.php?status=error&message=Custom package ID not provided");
            exit;
        }
        break;
    
    case 'remove':
        $package_id = (int)($_GET['id'] ?? 0);
        if (isset($_SESSION['cart'][$package_id])) {
            unset($_SESSION['cart'][$package_id]);
            header("Location: cart.php?status=removed");
            exit;
        }
        header("Location: cart.php?status=error&message=Item not found in cart");
        break;

    case 'clear':
        $_SESSION['cart'] = [];
        header("Location: cart.php?status=cleared");
        exit;
        break;

    default:
        // Invalid action
        break;
}

// Load cart display
ob_start();
include './templates/cart.html.php';
$page_content = ob_get_clean();
include './layout-mobile.html.php';
?>