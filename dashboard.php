<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: api/login.php");
    exit;
}

$name = $_SESSION['name'];
include "template/dashboard.html.php";
?>
