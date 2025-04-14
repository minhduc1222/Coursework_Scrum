<?php
session_start();

include './Include/database.php';
include './models/CustomPackage.php';
include './models/Customer.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php?redirect=custom_package");
    exit;
}

$custom_package = new CustomPackage($pdo);
$customer = new Customer($pdo);
$success = $error = '';

$customer->CustomerID = $_SESSION['customer_id'];
$customer->readOne();

if (!$customer->Name) {
    $error = "Invalid customer ID. Please log in again.";
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_package'])) {
        try {
            $custom_package->PackageID = $_POST['package_id'];
            if ($custom_package->delete()) {
                $success = "Custom package deleted successfully!";
            } else {
                $error = "Failed to delete the custom package.";
            }
        } catch (Exception $e) {
            $error = "Error deleting package: " . $e->getMessage();
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_package'])) {
        try {
            // Check for unique package name
            if ($custom_package->isPackageNameTaken($_POST['package_name'], $_SESSION['customer_id'])) {
                throw new Exception("Package name already exists. Please choose a unique name.");
            }

            $custom_package->PackageName = $_POST['package_name'] ?? 'Custom Package';
            $custom_package->Description = $_POST['description'] ?? 'Custom package created by user';
            $custom_package->Type = $_POST['type'] ?? '';
            $custom_package->FreeMinutes = $_POST['free_minutes'] ?? 0;
            $custom_package->FreeSMS = $_POST['free_sms'] ?? 0;
            $custom_package->FreeGB = 0; // Default to 0
            if ($custom_package->Type === 'Mobile') {
                $custom_package->FreeGB = $_POST['free_gb_mobile'] ?? 0;
            } elseif ($custom_package->Type === 'Tablet') {
                $custom_package->FreeGB = $_POST['free_gb_tablet'] ?? 0;
            }
            $custom_package->Contract = $_POST['contract'] ?? 0;
            $custom_package->DownloadSpeed = $_POST['download_speed'] ?? 0;
            $custom_package->UploadSpeed = $_POST['upload_speed'] ?? 0;
            $custom_package->SetupFee = 0; // System-controlled
            $custom_package->UpfrontCost = 0; // System-controlled
            $custom_package->Brand = 'TabNet';
            $custom_package->Rating = 0;
            $custom_package->IsPopular = 0;
            $custom_package->old_price = 0;
            $custom_package->CustomerID = $_SESSION['customer_id'];

            // Debug: Log the FreeGB value before validation
            error_log("FreeGB before create: " . $custom_package->FreeGB);

            // Calculate price
            $base_price = 10.00;
            $price = $base_price;

            if ($custom_package->Type === 'Mobile') {
                $price += $custom_package->FreeMinutes * 0.05;
                $price += $custom_package->FreeSMS * 0.03;
                $price += $custom_package->FreeGB * 2.00;
            } elseif ($custom_package->Type === 'Broadband') {
                $price += $custom_package->DownloadSpeed * 0.30;
                $price += $custom_package->UploadSpeed * 0.20;
            } elseif ($custom_package->Type === 'Tablet') {
                $price += $custom_package->FreeGB * 3.00;
            }

            if ($custom_package->Contract == 24) {
                $price *= 0.9;
            } elseif ($custom_package->Contract == 12) {
                $price *= 0.95;
            }

            $custom_package->Price = round($price, 2);

            if ($custom_package->create()) {
                $success = "Custom package created successfully!";
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

// Check cart for existing package types
$cart_types = [];
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (isset($item['package']['Type'])) {
            $cart_types[] = $item['package']['Type'];
        }
    }
}

$custom_packages = $custom_package->readByCustomer($_SESSION['customer_id'])->fetchAll(PDO::FETCH_ASSOC);

ob_start();
include './templates/custom_package.html.php';
$page_content = ob_get_clean();
include './layout-mobile.html.php';
?>