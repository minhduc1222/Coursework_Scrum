<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: authentication/login.php");
    exit;
}

$name = $_SESSION['name'];
include "template/dashboard.html.php";
?>
