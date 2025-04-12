<?php
// Customer Model
class Customer {
    private $conn;
    private $table_name = "customer";

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

    // Read all customers
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read one customer
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE CustomerID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->CustomerID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->Name = $row['Name'];
        $this->Email = $row['Email'];
        $this->Password = $row['Password'];
        $this->Address = $row['Address'];
        $this->PhoneNumber = $row['PhoneNumber'];
        $this->CreditCardInfo = $row['CreditCardInfo'];
        $this->RegistrationDate = $row['RegistrationDate'];
    }

    // Create customer
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET Name=:name, Email=:email, Password=:Password, Address=:address, 
                      PhoneNumber=:phone, CreditCardInfo=:card";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind values
        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->Password = htmlspecialchars(strip_tags($this->Password));
        $this->Address = htmlspecialchars(strip_tags($this->Address));
        $this->PhoneNumber = htmlspecialchars(strip_tags($this->PhoneNumber));
        $this->CreditCardInfo = htmlspecialchars(strip_tags($this->CreditCardInfo));
        
        $stmt->bindParam(":name", $this->Name);
        $stmt->bindParam(":email", $this->Email);
        $hashedPassword = password_hash($this->Password, PASSWORD_DEFAULT);
        $stmt->bindParam(":Password", $hashedPassword);
        $stmt->bindParam(":address", $this->Address);
        $stmt->bindParam(":phone", $this->PhoneNumber);
        $stmt->bindParam(":card", $this->CreditCardInfo);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update customer
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET Name=:name, Email=:email, Address=:address, 
                    PhoneNumber=:phone, CreditCardInfo=:card
                WHERE CustomerID=:id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind values
        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->Address = htmlspecialchars(strip_tags($this->Address));
        $this->PhoneNumber = htmlspecialchars(strip_tags($this->PhoneNumber));
        $this->CreditCardInfo = htmlspecialchars(strip_tags($this->CreditCardInfo));
        $this->CustomerID = htmlspecialchars(strip_tags($this->CustomerID));
        
        $stmt->bindParam(":name", $this->Name);
        $stmt->bindParam(":email", $this->Email);
        $stmt->bindParam(":address", $this->Address);
        $stmt->bindParam(":phone", $this->PhoneNumber);
        $stmt->bindParam(":card", $this->CreditCardInfo);
        $stmt->bindParam(":id", $this->CustomerID);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete customer
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE CustomerID = ?";
        $stmt = $this->conn->prepare($query);
        $this->CustomerID = htmlspecialchars(strip_tags($this->CustomerID));
        $stmt->bindParam(1, $this->CustomerID);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Login customer
    public function login() {
        $query = "SELECT CustomerID, Name, Password FROM " . $this->table_name . " WHERE Email = ?";
        $stmt = $this->conn->prepare($query);
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $stmt->bindParam(1, $this->Email);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($this->Password, $row['Password'])) {
                return $row;
            }
        }
        return false;
    }
}
?>