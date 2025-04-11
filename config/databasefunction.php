<?php
require_once "database.php";
require_once "../api/utils.php";

function loginUser($email, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM customer WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            session_start();
            $_SESSION['customer_id'] = $user['CustomerID'];
            $_SESSION['name'] = $user['Name'];
            return ["success" => true, "message" => "Login successful", "redirect" => "../dashboard.php"];
        } else {
            return ["success" => false, "message" => "Incorrect password"];
        }
    } else {
        return ["success" => false, "message" => "User not found"];
    }
}

function registerUser($name, $email, $password, $phone, $address, $dob) {
    global $conn;

    $stmt = $conn->prepare("SELECT CustomerID FROM customer WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        return ["success" => false, "message" => "Email already exists"];
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("
        INSERT INTO customer (Name, Email, Password, PhoneNumber, Address, DOB)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssssss", $name, $email, $hashed_password, $phone, $address, $dob);

    if ($stmt->execute()) {
        return ["success" => true, "message" => "Registration successful"];
    } else {
        return ["success" => false, "message" => "Registration failed"];
    }
}

function generateResetToken($email) {
    global $conn;

    $stmt = $conn->prepare("SELECT CustomerID FROM customer WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $token = generateToken(10);
        $update = $conn->prepare("UPDATE customer SET reset_token = ? WHERE Email = ?");
        $update->bind_param("ss", $token, $email);
        $update->execute();
        return ["success" => true, "message" => "Reset token generated", "reset_token" => $token];
    } else {
        return ["success" => false, "message" => "Email not found"];
    }
}

function generatePasswordReset($email) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM customer WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $code = rand(100000, 999999);
        $token = generateToken(10);

        $update = $conn->prepare("UPDATE customer SET reset_token = ?, verification_code = ? WHERE Email = ?");
        $update->bind_param("sss", $token, $code, $email);
        $update->execute();

        return ["success" => true, "message" => "Verification code sent", "reset_token" => $token, "verification_code" => $code];
    } else {
        return ["success" => false, "message" => "Email not found"];
    }
}
