<?php
require "../config/database.php";
require "../config/databasefunction.php";
require_once "utils.php";

$contentType = $_SERVER["CONTENT_TYPE"] ?? '';

// Handle JSON login request
if (strpos($contentType, 'application/json') !== false) {
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->email, $data->password)) {
        respond(false, "Email and password required");
    }

    $email = trim($data->email);
    $password = $data->password;

    $result = loginUser($email, $password);

    respond($result['success'], $result['message'], [
        "redirect" => $result['redirect'] ?? ''
    ]);
} else {
    // Load the login page
    include "../template/login.html.php";
}
