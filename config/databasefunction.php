<?php
require_once "database.php";
require_once "../api/utils.php";

function loginUser($email, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM customer WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
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

function registerUser($name, $email, $password, $phone, $address, $credit_card) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT CustomerID FROM customer WHERE Email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Email already exists"];
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $now = date('Y-m-d H:i:s');

        $stmt = $pdo->prepare("INSERT INTO customer (Name, Email, Password, PhoneNumber, Address, CreditCardInfo, RegistrationDate) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $result = $stmt->execute([$name, $email, $hashed_password, $phone, $address, $credit_card, $now]);

        return $result
            ? ["success" => true, "message" => "Registration successful"]
            : ["success" => false, "message" => "Registration failed"];
    } catch (PDOException $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}

function generateResetToken($email) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT CustomerID FROM customer WHERE Email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() === 1) {
        $token = generateToken(10);
        $update = $pdo->prepare("UPDATE customer SET reset_token = ? WHERE Email = ?");
        $update->execute([$token, $email]);
        return ["success" => true, "message" => "Reset token generated", "reset_token" => $token];
    } else {
        return ["success" => false, "message" => "Email not found"];
    }
}

function generatePasswordReset($email) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM customer WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $code = rand(100000, 999999);
        $token = generateToken(10);

        $update = $pdo->prepare("UPDATE customer SET reset_token = ?, verification_code = ? WHERE Email = ?");
        $update->execute([$token, $code, $email]);

        return ["success" => true, "message" => "Verification code sent", "reset_token" => $token, "verification_code" => $code];
    } else {
        return ["success" => false, "message" => "Email not found"];
    }
}
