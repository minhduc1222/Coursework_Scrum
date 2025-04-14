<?php
require_once "../include/database.php";
require_once "../include/databasefunction.php";

$error = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = registerUser($_POST);

    if ($result['success']) {
        $success = true;
        header("Location: login.php");
        exit;
    } else {
        $error = $result['message'];
        include "../template/register.html.php";
    }
} else {
    include "../template/register.html.php";
}