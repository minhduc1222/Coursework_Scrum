<?php
// profile.php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Include database configuration
include '../config/database.php';

// Include Customer model
include '../models/Customer.php';

// Instantiate Customer model
$customer = new Customer($pdo);
$customer->CustomerID = $_SESSION['customer_id'];
$customer->readOne();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $customer->Name = $_POST['name'];
    $customer->Email = $_POST['email'];
    $customer->Address = $_POST['address'];
    $customer->PhoneNumber = $_POST['phone'];
    $customer->CreditCardInfo = $_POST['credit_card'];
    $customer->csv = $_POST['csv'];

    // Handle profile picture upload
    if (isset($_FILES['avt_img']) && $_FILES['avt_img']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../image/'; // Directory to store uploaded images
        $file_name = basename($_FILES['avt_img']['name']);
        $target_file = $upload_dir . time() . '_' . $file_name;

        // Move the uploaded file
        if (move_uploaded_file($_FILES['avt_img']['tmp_name'], $target_file)) {
            $customer->avt_img = $target_file; // Update the avatar image path
        } else {
            $error = "Failed to upload profile picture.";
        }
    }

    // Update the customer profile
    if (!isset($error) && $customer->update()) {
        $success = "Profile updated successfully!";
        // Refresh customer data after update
        $customer->readOne();
    } else {
        $error = isset($error) ? $error : "Failed to update profile.";
    }
}

// Start output buffering and include the template
ob_start();
include '../templates/profile.html.php';
$page_content = ob_get_clean();

// Render it inside the layout
include '../layout-mobile.html.php';