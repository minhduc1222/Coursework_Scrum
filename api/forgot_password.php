<?php
require "../config/database.php";
require "../config/databasefunction.php";
require_once "utils.php";

$contentType = $_SERVER["CONTENT_TYPE"] ?? '';

if (strpos($contentType, 'application/json') !== false) {
    $data = json_decode(file_get_contents("php://input"));

    if (empty($data->email)) {
        respond(false, "Email is required");
        exit;
    }

    $email = trim($data->email);
    $result = generatePasswordReset($email);

    respond($result['success'], $result['message'], $result);
} else {
    include "../template/forgot_password.html.php";
}
