<?php
require "../config/databasefunction.php";
require_once "utils.php";

// Check if this is an API request (JSON data)
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

// More flexible content type checking
if (strpos($contentType, 'application/json') !== false) {
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->name, $data->email, $data->password, $data->phone)) {
        respond(false, "Required fields missing");
    }

    $name = $conn->real_escape_string($data->name);
    $email = $conn->real_escape_string($data->email);
    $password = $data->password;
    $phone = $conn->real_escape_string($data->phone);
    $address = $conn->real_escape_string($data->address);
    $dob = $conn->real_escape_string($data->dob);

    $result = registerUser($name, $email, $password, $phone, $address, $dob);
    respond($result['success'], $result['message']);
} else {
    // If it's not a JSON request, include the template
    include "../template/register.html.php";
}