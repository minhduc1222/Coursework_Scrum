<?php
// Include database configuration
include './includes/database.php';

// Include model files
include './models/Customer.php';

// Start session
session_start();

// Redirect if already logged in
if (isset($_SESSION['customer_id']) && $_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ./includes/homepages.php");
    exit;
}

// Instantiate customer model
$customer = new Customer($pdo);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Email and password required.";
    } else {
        $customer->Email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $customer->Password = $_POST['password'];

        $loginResult = $customer->login();
        if ($loginResult) {
            // Store user data in session
            $_SESSION['customer_id'] = $loginResult['CustomerID'];
            $_SESSION['customer_name'] = $loginResult['Name'];

            // Check for redirect after login
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'homepages';
            $redirectUrl = $redirect === 'checkout' ? 'checkout.php' : ($redirect === 'profile' ? 'profile.php' : 'homepages.php');
            header("Location: ./includes/$redirectUrl");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}

// For GET requests or POST errors, render the login page
ob_start();
include './templates/login.html.php';
$page_content = ob_get_clean();

// Render it inside the mobile layout
include './layout-mobile.html.php';
?>