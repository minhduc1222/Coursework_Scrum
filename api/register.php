<?php
// Include database connection
require_once "../config/database.php";
require_once "../config/databasefunction.php";

// Default error and success
$error = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate all required fields
    $required = ['name', 'email', 'password', 'confirm_password', 'phone', 'address', 'credit_card'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $error = "All fields are required.";
            include "../template/register.html.php";
            exit;
        }
    }

    // Extract form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $credit_card = $_POST['credit_card'];

    // Validate password match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
        include "../template/register.html.php";
        exit;
    }

    // Validate password length
    if (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
        include "../template/register.html.php";
        exit;
    }

    // Use the separated function
    $result = registerUser($name, $email, $password, $phone, $address, $credit_card);

    if ($result['success']) {
        $success = true;
        include "../template/login.html.php";
        exit;
    } else {
        $error = $result['message'];
        include "../template/register.html.php";
        exit;
    }
} else {
    include "../template/register.html.php";
    exit;
}
