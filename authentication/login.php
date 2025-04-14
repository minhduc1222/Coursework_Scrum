<?php
require_once "../include/database.php";
require_once "../include/databasefunction.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';
    $redirect = $_POST['redirect'] ?? '../homepages.php'; // Added parent directory path
 
    if (empty($identifier) || empty($password)) {
        $_SESSION['error'] = 'Please provide all required fields';
        header('Location: ../template/login.html.php');
        exit;
    }

    $result = loginUser($identifier, $password);

    if ($result['success']) {
        if ($result['role'] == 2) {
            header('Location: ../csr_management.php');
            exit;
        } else {
            header('Location: ../homepages.php'); //
            exit;
        }
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: ../login.html.php');
        exit;
    }
} else {
    include "../template/login.html.php";
}