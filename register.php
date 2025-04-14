<?php
// Include database configuration
include './Include/database.php';

// Include model files
include './models/Customer.php';

// Instantiate customer model
$customer = new Customer($pdo);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    ob_start();
    include './templates/register.html.php';
    $page_content = ob_get_clean();
    include './layout-mobile.html.php';
    exit;
}

$required = ['Name', 'email', 'password', 'confirm_password', 'phone', 'address'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        $error = "All fields are required.";
        ob_start();
        include './templates/register.html.php';
        $page_content = ob_get_clean();
        include './layout-mobile.html.php';
        exit;
    }
}

$customer->Name = filter_var(trim($_POST['Name']), FILTER_SANITIZE_STRING);
$customer->Email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$customer->PhoneNumber = filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING);
$customer->Address = filter_var(trim($_POST['address']), FILTER_SANITIZE_STRING);

if ($password !== $confirm_password) {
    $error = "Passwords do not match.";
    ob_start();
    include './templates/register.html.php';
    $page_content = ob_get_clean();
    include './layout-mobile.html.php';
    exit;
}

if (strlen($password) < 8) {
    $error = "Password must be at least 8 characters.";
    ob_start();
    include './templates/register.html.php';
    $page_content = ob_get_clean();
    include './layout-mobile.html.php';
    exit;
}

if ($customer->emailExists()) {
    $error = "Email already registered.";
    ob_start();
    include './templates/register.html.php';
    $page_content = ob_get_clean();
    include './layout-mobile.html.php';
    exit;
}

$customer->Password = $password;

if ($customer->create()) {
    header("Location: login.php?success=Registration successful");
    exit;
}

$error = "Registration failed. Please try again.";
ob_start();
include './templates/register.html.php';
$page_content = ob_get_clean();
include './layout-mobile.html.php';
exit;
?>