<?php
// Deal Model
class Deal {
    private $conn;
    private $table_name = "deal";

    public $DealID;
    public $DealName;
    public $Description;
    public $DiscountPercentage;
    public $ValidFrom;
    public $ValidTo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Read all deals
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read one deal
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE DealID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->DealID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->DealName = $row['DealName'];
        $this->Description = $row['Description'];
        $this->DiscountPercentage = $row['DiscountPercentage'];
        $this->ValidFrom = $row['ValidFrom'];
        $this->ValidTo = $row['ValidTo'];
    }

    // Read current deals
    public function readCurrent() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ValidFrom <= CURDATE() AND ValidTo >= CURDATE()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Create deal
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET DealName=:name, Description=:desc, DiscountPercentage=:discount, 
                      ValidFrom=:from, ValidTo=:to";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind values
        $this->DealName = htmlspecialchars(strip_tags($this->DealName));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->DiscountPercentage = htmlspecialchars(strip_tags($this->DiscountPercentage));
        $this->ValidFrom = htmlspecialchars(strip_tags($this->ValidFrom));
        $this->ValidTo = htmlspecialchars(strip_tags($this->ValidTo));
        
        $stmt->bindParam(":name", $this->DealName);
        $stmt->bindParam(":desc", $this->Description);
        $stmt->bindParam(":discount", $this->DiscountPercentage);
        $stmt->bindParam(":from", $this->ValidFrom);
        $stmt->bindParam(":to", $this->ValidTo);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update deal
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET DealName=:name, Description=:desc, DiscountPercentage=:discount, 
                    ValidFrom=:from, ValidTo=:to
                WHERE DealID=:id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind values
        $this->DealName = htmlspecialchars(strip_tags($this->DealName));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->DiscountPercentage = htmlspecialchars(strip_tags($this->DiscountPercentage));
        $this->ValidFrom = htmlspecialchars(strip_tags($this->ValidFrom));
        $this->ValidTo = htmlspecialchars(strip_tags($this->ValidTo));
        $this->DealID = htmlspecialchars(strip_tags($this->DealID));
        
        $stmt->bindParam(":name", $this->DealName);
        $stmt->bindParam(":desc", $this->Description);
        $stmt->bindParam(":discount", $this->DiscountPercentage);
        $stmt->bindParam(":from", $this->ValidFrom);
        $stmt->bindParam(":to", $this->ValidTo);
        $stmt->bindParam(":id", $this->DealID);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete deal
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE DealID = ?";
        $stmt = $this->conn->prepare($query);
        $this->DealID = htmlspecialchars(strip_tags($this->DealID));
        $stmt->bindParam(1, $this->DealID);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get all packages for a specific deal
    public function getDealPackages() {
        $query = "SELECT p.* 
                 FROM package p 
                 INNER JOIN deal_package dp ON p.PackageID = dp.PackageID 
                 WHERE dp.DealID = ?";
        
        $stmt = $this->conn->prepare($query);
        $this->DealID = htmlspecialchars(strip_tags($this->DealID));
        $stmt->bindParam(1, $this->DealID);
        $stmt->execute();
        
        return $stmt;
    }

    // Get all packages for all deals
    public function getAllDealsPackages() {
        $query = "SELECT d.DealID, d.DealName, p.* 
                 FROM " . $this->table_name . " d 
                 LEFT JOIN deal_package dp ON d.DealID = dp.DealID 
                 LEFT JOIN package p ON dp.PackageID = p.PackageID 
                 ORDER BY d.DealID";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

}
?>