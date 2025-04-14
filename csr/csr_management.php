<?php
require_once "../Include/database.php";
require_once "../models/Package.php";
session_start();

// Initialize variables
$error = "";
$success = "";
$customer = null;
$subscription = [];
$orders = [];
$usage_data = [];
$recommended_packages = [];
$search_performed = false;
$products = [
    'mobile' => [],
    'broadband' => [],
    'tablet' => []
];

if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = 'csr@cheapdeals.com';
}

// Log CSR activity
function logCSRActivity($csr_email, $activity_type, $details) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO csr_activity_log (CSR_Email, ActivityType, Details, Timestamp) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$csr_email, $activity_type, $details]);
    } catch (PDOException $e) {
        error_log("Error logging CSR activity: " . $e->getMessage());
    }
}

// Search for customer
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search_term = trim($_GET['search']);
    $search_performed = true;
    
    if (!empty($search_term)) {
        try {
            $start_time = microtime(true);
            
            $stmt = $pdo->prepare("
                SELECT * FROM customer 
                WHERE CustomerID = ? 
                OR Name LIKE ? 
                OR PhoneNumber LIKE ?
                LIMIT 1
            ");
            $stmt->execute([$search_term, "%$search_term%", "%$search_term%"]);
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $response_time = microtime(true) - $start_time;
            
            if ($customer) {
                logCSRActivity($_SESSION['email'], 'customer_search', "Found customer ID: {$customer['CustomerID']}");
                
                // Fetch subscriptions
                $stmt = $pdo->prepare("
                    SELECT s.*, p.PackageName, p.Type, p.Price, p.img, p.FreeMinutes, p.FreeSMS, p.FreeGB 
                    FROM subscription s
                    JOIN package p ON s.PackageID = p.PackageID
                    WHERE s.CustomerID = ?
                    ORDER BY s.StartDate DESC
                ");
                $stmt->execute([$customer['CustomerID']]);
                $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Fetch orders
                $stmt = $pdo->prepare("
                    SELECT o.*, p.PackageName, p.Price, p.img, p.FreeMinutes, p.FreeSMS, p.FreeGB 
                    FROM orders o
                    JOIN package p ON o.PackageID = p.PackageID
                    WHERE o.CustomerID = ?
                    ORDER BY o.OrderDate DESC
                    LIMIT 5
                ");
                $stmt->execute([$customer['CustomerID']]);
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Fetch usage data
                $stmt = $pdo->prepare("
                    SELECT UsageID, CustomerID, Month, Minutes, SMS, DataGB 
                    FROM usage_data
                    WHERE CustomerID = ?
                    ORDER BY Month DESC
                    LIMIT 3
                ");
                $stmt->execute([$customer['CustomerID']]);
                $usage_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $recommended_packages = [];
                if (!empty($usage_data)) {
                    $avg_minutes = 0;
                    $avg_sms = 0;
                    $avg_data = 0;
                    $count = count($usage_data);
                    
                    foreach ($usage_data as $usage) {
                        $avg_minutes += $usage['Minutes'] ?? 0;
                        $avg_sms += $usage['SMS'] ?? 0;
                        $avg_data += $usage['DataGB'] ?? 0;
                    }
                    
                    if ($count > 0) {
                        $avg_minutes = ceil($avg_minutes / $count);
                        $avg_sms = ceil($avg_sms / $count);
                        $avg_data = ceil($avg_data / $count);
                        
                        // Fetch recommended packages based on usage
                        $stmt = $pdo->prepare("
                            SELECT PackageID, PackageName, Price, FreeMinutes, FreeSMS, FreeGB, img, Type 
                            FROM package
                            WHERE Type = 'MobileOnly'
                            AND FreeMinutes >= ?
                            AND FreeSMS >= ?
                            AND FreeGB >= ?
                            ORDER BY Price ASC
                            LIMIT 3
                        ");
                        // Using 80% of average usage to find suitable packages
                        $stmt->execute([$avg_minutes * 0.8, $avg_sms * 0.8, $avg_data * 0.8]);
                        $recommended_packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                }
                
                if ($response_time > 3) {
                    logCSRActivity($_SESSION['email'], 'performance_issue', "Search response time: {$response_time}s exceeded threshold");
                }
            } else {
                logCSRActivity($_SESSION['email'], 'customer_search', "No customer found for term: $search_term");
            }
        } catch (PDOException $e) {
            $error = "Error searching for customer: " . $e->getMessage();
            logCSRActivity($_SESSION['email'], 'error', "Database error during search: " . $e->getMessage());
        }
    } else {
        $error = "Please enter a search term";
    }
}

// Create new customer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_customer'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    
    if (!empty($name) && !empty($email) && !empty($phone)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO customer (Name, Email, PhoneNumber, Address, RegistrationDate, Role)
                VALUES (?, ?, ?, ?, NOW(), 1)
            ");
            $stmt->execute([$name, $email, $phone, $address]);
            $customer_id = $pdo->lastInsertId();
            
            if ($customer_id) {
                $success = "Customer created successfully with ID: $customer_id";
                logCSRActivity($_SESSION['email'], 'customer_create', "Created new customer ID: $customer_id");
                
                $stmt = $pdo->prepare("SELECT * FROM customer WHERE CustomerID = ?");
                $stmt->execute([$customer_id]);
                $customer = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = "Failed to create customer";
            }
        } catch (PDOException $e) {
            $error = "Error creating customer: " . $e->getMessage();
            logCSRActivity($_SESSION['email'], 'error', "Database error during customer creation: " . $e->getMessage());
        }
    } else {
        $error = "Name, email, and phone are required";
    }
}

// Handle custom package creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['custom_package'])) {
    try {
        $package_ids = explode(',', $_POST['custom_package']);
        $customer_id = $_POST['customer_id'] ?? null;
        
        if ($customer_id && !empty($package_ids)) {
            foreach ($package_ids as $package_id) {
                $stmt = $pdo->prepare("SELECT * FROM package WHERE PackageID = ?");
                $stmt->execute([$package_id]);
                $package = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($package) {
                    $stmt = $pdo->prepare("
                        INSERT INTO orders (CustomerID, PackageID, OrderDate, Status)
                        VALUES (?, ?, NOW(), 'Pending')
                    ");
                    $stmt->execute([$customer_id, $package_id]);
                    $order_id = $pdo->lastInsertId();
                    
                    $stmt = $pdo->prepare("
                        INSERT INTO subscription (CustomerID, PackageID, StartDate)
                        VALUES (?, ?, NOW())
                    ");
                    $stmt->execute([$customer_id, $package_id]);
                }
            }
            
            $success = "Custom package added to customer successfully";
            logCSRActivity($_SESSION['email'], 'package_customize', "Created custom package for customer ID: $customer_id");
            
            $stmt = $pdo->prepare("SELECT * FROM customer WHERE CustomerID = ?");
            $stmt->execute([$customer_id]);
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $stmt = $pdo->prepare("
                SELECT s.*, p.PackageName, p.Type, p.Price, p.img 
                FROM subscription s
                JOIN package p ON s.PackageID = p.PackageID
                WHERE s.CustomerID = ?
                ORDER BY s.StartDate DESC
            ");
            $stmt->execute([$customer_id]);
            $subscription = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $error = "Customer ID and package selection are required";
        }
    } catch (PDOException $e) {
        $error = "Error creating custom package: " . $e->getMessage();
        logCSRActivity($_SESSION['email'], 'error', "Database error during package customization: " . $e->getMessage());
    }
}

// Handle package recommendation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recommend_package'])) {
    $package_id = $_POST['recommend_package'];
    $customer_id = $_POST['customer_id'] ?? null;
    
    if ($package_id && $customer_id) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO package_recommendations (CustomerID, PackageID, CSR_Email, RecommendationDate)
                VALUES (?, ?, ?, NOW())
            ");
            $stmt->execute([$customer_id, $package_id, $_SESSION['email']]);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            logCSRActivity($_SESSION['email'], 'package_recommend', "Recommended package ID: $package_id to customer ID: $customer_id");
            exit;
        } catch (PDOException $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Missing package ID or customer ID']);
        exit;
    }
}

// Fetch all packages for customization
try {
    // Fetch mobile packages
    $stmt = $pdo->query("
        SELECT 
            PackageID as id, 
            PackageName as name, 
            Description as description, 
            Price as price, 
            FreeMinutes, 
            FreeSMS, 
            FreeGB, 
            old_price, 
            Contract, 
            IsPopular, 
            Rating, 
            img
        FROM package 
        WHERE Type = 'MobileOnly'
        ORDER BY Price ASC
    ");
    $products['mobile'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch broadband packages
    $stmt = $pdo->query("
        SELECT 
            PackageID as id, 
            PackageName as name, 
            Description as description, 
            Price as price, 
            DownloadSpeed, 
            UploadSpeed, 
            SetupFee, 
            old_price, 
            Contract, 
            IsPopular, 
            Rating, 
            img
        FROM package 
        WHERE Type = 'BroadbandOnly'
        ORDER BY Price ASC
    ");
    $products['broadband'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch tablet packages
    $stmt = $pdo->query("
        SELECT 
            PackageID as id, 
            PackageName as name, 
            Description as description, 
            Price as price, 
            FreeGB, 
            old_price, 
            Contract, 
            IsPopular, 
            Brand, 
            Rating, 
            UpfrontCost, 
            img
        FROM package 
        WHERE Type = 'TabletOnly'
        ORDER BY Price ASC
    ");
    $products['tablet'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $error = "Error fetching packages: " . $e->getMessage();
}

ob_start();
include "./templates/csr_management.html.php";
$page_content = ob_get_clean();
include '../layout-mobile.html.php';
?>