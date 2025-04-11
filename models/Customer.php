<?php
class Customer {
    private $conn;
    private $table = "customer";

    public $CustomerID;
    public $Name;
    public $Email;
    public $Password;
    public $Address;
    public $PhoneNumber;
    public $CreditCardInfo;
    public $RegistrationDate;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register new user
    public function register() {
        $query = "INSERT INTO {$this->table} 
                  (Name, Email, Password, Address, PhoneNumber, CreditCardInfo, RegistrationDate)
                  VALUES(:name, :email, :password, :address, :phone, :credit, NOW())";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->Name);
        $stmt->bindParam(":email", $this->Email);
        $stmt->bindParam(":password", $this->Password); // should be hashed before
        $stmt->bindParam(":address", $this->Address);
        $stmt->bindParam(":phone", $this->PhoneNumber);
        $stmt->bindParam(":credit", $this->CreditCardInfo);

        return $stmt->execute();
    }

    // Login
    public function login() {
        $query = "SELECT * FROM {$this->table} WHERE Email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->Email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Check if email exists
    public function emailExists() {
        $query = "SELECT CustomerID FROM {$this->table} WHERE Email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->Email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
