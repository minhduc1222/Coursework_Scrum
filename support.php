<?php
require_once "include/database.php";
require_once "include/databasefunction.php";
session_start();
$success = false;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['message'])) {
        $error = "Please enter a message";
    } else {
        $result = submitEnquiry($_POST['message']);
        $success = $result['success'];
        $error = $result['success'] ? "" : $result['message'];
    }
}

include "template/support.html.php";
