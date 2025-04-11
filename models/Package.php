<?php
// Package Model
class Package {
    private $conn;
    private $table_name = "package";

    public $PackageID;
    public $PackageName;
    public $Description;
    public $Type;
    public $Price;
    public $FreeMinutes;
    public $FreeSMS;
    public $FreeGB;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Read all packages
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE PackageID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->PackageID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->PackageName = $row['PackageName'];
            $this->Description = $row['Description'];
            $this->Type = $row['Type'];
            $this->Price = $row['Price'];
            $this->FreeMinutes = $row['FreeMinutes'];
            $this->FreeSMS = $row['FreeSMS'];
            $this->FreeGB = $row['FreeGB'];
        } else {
            // Optional: Log or throw error
            // echo "⚠️ No package found for ID: {$this->PackageID}<br>";
        }
    }
    

    // Filter packages by type
    public function readByType($type) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Type = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $type);
        $stmt->execute();
        return $stmt;
    }

    // Create package
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET PackageName=:name, Description=:desc, Type=:type, 
                      Price=:price, FreeMinutes=:minutes, FreeSMS=:sms, FreeGB=:gb";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind values
        $this->PackageName = htmlspecialchars(strip_tags($this->PackageName));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->Type = htmlspecialchars(strip_tags($this->Type));
        $this->Price = htmlspecialchars(strip_tags($this->Price));
        $this->FreeMinutes = htmlspecialchars(strip_tags($this->FreeMinutes));
        $this->FreeSMS = htmlspecialchars(strip_tags($this->FreeSMS));
        $this->FreeGB = htmlspecialchars(strip_tags($this->FreeGB));
        
        $stmt->bindParam(":name", $this->PackageName);
        $stmt->bindParam(":desc", $this->Description);
        $stmt->bindParam(":type", $this->Type);
        $stmt->bindParam(":price", $this->Price);
        $stmt->bindParam(":minutes", $this->FreeMinutes);
        $stmt->bindParam(":sms", $this->FreeSMS);
        $stmt->bindParam(":gb", $this->FreeGB);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update package
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET PackageName=:name, Description=:desc, Type=:type, 
                    Price=:price, FreeMinutes=:minutes, FreeSMS=:sms, FreeGB=:gb
                WHERE PackageID=:id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind values
        $this->PackageName = htmlspecialchars(strip_tags($this->PackageName));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->Type = htmlspecialchars(strip_tags($this->Type));
        $this->Price = htmlspecialchars(strip_tags($this->Price));
        $this->FreeMinutes = htmlspecialchars(strip_tags($this->FreeMinutes));
        $this->FreeSMS = htmlspecialchars(strip_tags($this->FreeSMS));
        $this->FreeGB = htmlspecialchars(strip_tags($this->FreeGB));
        $this->PackageID = htmlspecialchars(strip_tags($this->PackageID));
        
        $stmt->bindParam(":name", $this->PackageName);
        $stmt->bindParam(":desc", $this->Description);
        $stmt->bindParam(":type", $this->Type);
        $stmt->bindParam(":price", $this->Price);
        $stmt->bindParam(":minutes", $this->FreeMinutes);
        $stmt->bindParam(":sms", $this->FreeSMS);
        $stmt->bindParam(":gb", $this->FreeGB);
        $stmt->bindParam(":id", $this->PackageID);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete package
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE PackageID = ?";
        $stmt = $this->conn->prepare($query);
        $this->PackageID = htmlspecialchars(strip_tags($this->PackageID));
        $stmt->bindParam(1, $this->PackageID);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>