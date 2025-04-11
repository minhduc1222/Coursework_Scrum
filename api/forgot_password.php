<?php
require "../config/database.php";
require "../config/databasefunction.php";
require_once "utils.php";

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ($contentType === 'application/json') {
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->email)) {
        respond(false, "Email is required");
        exit;
    }

    $email = $data->email;
    $result = generatePasswordReset($email);
    respond($result['success'], $result['message'], $result);

} else {
    include "../template/forgot_password.html.php";
}
