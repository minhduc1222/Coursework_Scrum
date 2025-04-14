<?php
    require_once "database.php";

    function getCustomerFromSession(): array|null {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['customer_id'])) return null;
    
        return [
            'id' => $_SESSION['customer_id'],
            'name' => $_SESSION['customer_name'] ?? '',
            'email' => $_SESSION['customer_email'] ?? '',
            'phone' => $_SESSION['customer_phone'] ?? '',
            'address' => $_SESSION['customer_address'] ?? '',
            'credit_card' => $_SESSION['customer_credit'] ?? '',
            'registered' => $_SESSION['customer_registered'] ?? '',
            'role' => $_SESSION['role'] ?? 1,
            'loggedIn' => $_SESSION['loggedIn'] ?? false
        ];
    }    

    function initializeUserSession(array $user) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['customer_id'] = $user['CustomerID'];
        $_SESSION['customer_name'] = $user['Name'];
        $_SESSION['customer_email'] = $user['Email'];
        $_SESSION['customer_phone'] = $user['PhoneNumber'];
        $_SESSION['customer_address'] = $user['Address'];
        $_SESSION['customer_credit'] = $user['CreditCardInfo'];
        $_SESSION['customer_registered'] = $user['RegistrationDate'];
        $_SESSION['role'] = $user['Role'];
        $_SESSION['loggedIn'] = true;
    }    
    
    function loginUser($identifier, $password) {
        global $pdo;
    
        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL);
        $query = $isEmail
            ? "SELECT * FROM customer WHERE Email = ?"
            : "SELECT * FROM customer WHERE PhoneNumber = ?";
    
        $stmt = $pdo->prepare($query);
        $stmt->execute([$identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && $password === $user['Password']) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            initializeUserSession($user);
    
            return [
                "success" => true,
                "role" => $user['Role'],
                "message" => "Login successful"
            ];
        }
    
        return [
            "success" => false,
            "message" => "Invalid credentials. Please try again."
        ];
    }
    

    function registerUser($postData) {
        global $pdo;

        $required = ['name', 'email', 'password', 'confirm_password', 'phone', 'address', 'credit_card'];
        foreach ($required as $field) {
            if (empty($postData[$field])) {
                return ["success" => false, "message" => "All fields are required."];
            }
        }

        $name = $postData['name'];
        $email = $postData['email'];
        $password = $postData['password'];
        $confirm_password = $postData['confirm_password'];
        $phone = $postData['phone'];
        $address = $postData['address'];
        $credit_card = $postData['credit_card'];

        if ($password !== $confirm_password) {
            return ["success" => false, "message" => "Passwords do not match."];
        }

        if (strlen($password) < 8) {
            return ["success" => false, "message" => "Password must be at least 8 characters."];
        }

        try {
            $stmt = $pdo->prepare("SELECT CustomerID FROM customer WHERE Email = ?");
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                return ["success" => false, "message" => "Email already exists"];
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $now = date('Y-m-d H:i:s');

            $stmt = $pdo->prepare("
                INSERT INTO customer (Name, Email, Password, PhoneNumber, Address, CreditCardInfo, RegistrationDate)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $result = $stmt->execute([$name, $email, $hashed_password, $phone, $address, $credit_card, $now]);

            if ($result) {
                return ["success" => true, "message" => "Registration successful"];
            } else {
                return ["success" => false, "message" => "Registration failed"];
            }
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
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

    function getRecentSearches() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['recent_searches'] ?? [];
    }

    function addRecentSearch($query) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $recentSearches = $_SESSION['recent_searches'] ?? [];

        if (!in_array($query, $recentSearches)) {
            array_unshift($recentSearches, $query);
            $_SESSION['recent_searches'] = array_slice($recentSearches, 0, 5); // max 5
        }
    }

    function clearRecentSearches() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['recent_searches'] = [];
    }

    function searchContent($query) {
        global $pdo;
    
        try {
            $searchTerm = '%' . $query . '%';
    
            // Search packages
            $packageStmt = $pdo->prepare("
                SELECT PackageID, PackageName, Description, Price 
                FROM package 
                WHERE PackageName LIKE :query 
                OR Description LIKE :query
                LIMIT 10
            ");
            $packageStmt->bindValue(':query', $searchTerm, PDO::PARAM_STR);
            $packageStmt->execute();
            $packages = $packageStmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Search deals
            $dealStmt = $pdo->prepare("
                SELECT DealID, DealName, Description, DiscountPercentage, ValidFrom, ValidTo 
                FROM deal 
                WHERE DealName LIKE :query 
                OR Description LIKE :query
                LIMIT 10
            ");
            $dealStmt->bindValue(':query', $searchTerm, PDO::PARAM_STR);
            $dealStmt->execute();
            $deals = $dealStmt->fetchAll(PDO::FETCH_ASSOC);
    
            return [
                'packages' => $packages,
                'deals' => $deals,
                'total' => count($packages) + count($deals)
            ];
        } catch (PDOException $e) {
            error_log("Search error: " . $e->getMessage());
            return [
                'packages' => [],
                'deals' => [],
                'total' => 0,
                'error' => "An error occurred while searching. Please try again."
            ];
        }
    }
    
    
    function submitEnquiry($message) {
        global $pdo;
    
        $customer = getCustomerFromSession();
        if (!$customer || empty($customer['id'])) {
            return ["success" => false, "message" => "User not logged in"];
        }
    
        try {
            $stmt = $pdo->prepare("
                INSERT INTO enquiry (CustomerID, Description, Status, CreatedAt)
                VALUES (?, ?, 'Pending', NOW())
            ");
            $result = $stmt->execute([$customer['id'], $message]);
    
            return $result
                ? ["success" => true, "message" => "Enquiry submitted successfully"]
                : ["success" => false, "message" => "Failed to submit enquiry"];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Database error: " . $e->getMessage()];
        }
    } 