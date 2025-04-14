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
    public $avt_img;
    public $csv;
    public $Balance;              // ✅ New
    public $PaymentMethod;        // ✅ New

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

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
        $this->avt_img = $row['avt_img'];
        $this->csv = $row['csv'];
        $this->Balance = $row['Balance'];                  // ✅
        $this->PaymentMethod = $row['PaymentMethod'];      // ✅
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET Name=:Name, Email=:email, Password=:Password, Address=:address, 
                      PhoneNumber=:phone, CreditCardInfo=:card, avt_img=:avt_img, 
                      csv=:csv, Balance=:balance, PaymentMethod=:payment_method";

        $stmt = $this->conn->prepare($query);

        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->Password = htmlspecialchars(strip_tags($this->Password));
        $this->Address = htmlspecialchars(strip_tags($this->Address));
        $this->PhoneNumber = htmlspecialchars(strip_tags($this->PhoneNumber));
        $this->CreditCardInfo = htmlspecialchars(strip_tags($this->CreditCardInfo));
        $this->avt_img = htmlspecialchars(strip_tags($this->avt_img));
        $this->csv = htmlspecialchars(strip_tags($this->csv));
        $this->Balance = htmlspecialchars(strip_tags($this->Balance)); // or just floatval
        $this->PaymentMethod = htmlspecialchars(strip_tags($this->PaymentMethod));

        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":email", $this->Email);
        $hashedPassword = password_hash($this->Password, PASSWORD_DEFAULT);
        $stmt->bindParam(":Password", $hashedPassword);
        $stmt->bindParam(":address", $this->Address);
        $stmt->bindParam(":phone", $this->PhoneNumber);
        $stmt->bindParam(":card", $this->CreditCardInfo);
        $stmt->bindParam(":avt_img", $this->avt_img);
        $stmt->bindParam(":csv", $this->csv);
        $stmt->bindParam(":balance", $this->Balance);
        $stmt->bindParam(":payment_method", $this->PaymentMethod);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET Name=:Name, Email=:email, Address=:address, 
                      PhoneNumber=:phone, CreditCardInfo=:card, 
                      avt_img=:avt_img, csv=:csv, Balance=:balance, PaymentMethod=:payment_method 
                  WHERE CustomerID=:id";

        $stmt = $this->conn->prepare($query);

        $this->Name = htmlspecialchars(strip_tags($this->Name));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->Address = htmlspecialchars(strip_tags($this->Address));
        $this->PhoneNumber = htmlspecialchars(strip_tags($this->PhoneNumber));
        $this->CreditCardInfo = htmlspecialchars(strip_tags($this->CreditCardInfo));
        $this->avt_img = htmlspecialchars(strip_tags($this->avt_img));
        $this->csv = htmlspecialchars(strip_tags($this->csv));
        $this->Balance = htmlspecialchars(strip_tags($this->Balance));
        $this->PaymentMethod = htmlspecialchars(strip_tags($this->PaymentMethod));
        $this->CustomerID = htmlspecialchars(strip_tags($this->CustomerID));

        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":email", $this->Email);
        $stmt->bindParam(":address", $this->Address);
        $stmt->bindParam(":phone", $this->PhoneNumber);
        $stmt->bindParam(":card", $this->CreditCardInfo);
        $stmt->bindParam(":avt_img", $this->avt_img);
        $stmt->bindParam(":csv", $this->csv);
        $stmt->bindParam(":balance", $this->Balance);
        $stmt->bindParam(":payment_method", $this->PaymentMethod);
        $stmt->bindParam(":id", $this->CustomerID);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE CustomerID = ?";
        $stmt = $this->conn->prepare($query);
        $this->CustomerID = htmlspecialchars(strip_tags($this->CustomerID));
        $stmt->bindParam(1, $this->CustomerID);
        return $stmt->execute();
    }

    public function login() {
        $query = "SELECT CustomerID, Name, Password, avt_img, csv, Balance, PaymentMethod 
                  FROM " . $this->table_name . " WHERE Email = ?";
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

    public function emailExists() {
        $query = "SELECT CustomerID FROM " . $this->table_name . " WHERE Email = :email";
        $stmt = $this->conn->prepare($query);

        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $stmt->bindParam(":email", $this->Email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}

?>