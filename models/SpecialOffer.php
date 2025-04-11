<?php
// Special Offer Model
class SpecialOffer {
    private $conn;
    private $table_name = "specialoffer";

    public $SpecialOfferID;
    public $Description;
    public $DiscountPercentage;
    public $ExpiryDate;
    public $Conditions;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Read all special offers
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read active special offers
    public function readActive() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ExpiryDate >= CURDATE()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Read one special offer
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE SpecialOfferID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->SpecialOfferID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->Description = $row['Description'];
        $this->DiscountPercentage = $row['DiscountPercentage'];
        $this->ExpiryDate = $row['ExpiryDate'];
        $this->Conditions = $row['Conditions'];
    }

    // Create special offer
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET Description=:desc, DiscountPercentage=:discount, 
                      ExpiryDate=:expiry, Conditions=:conditions";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind values
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->DiscountPercentage = htmlspecialchars(strip_tags($this->DiscountPercentage));
        $this->ExpiryDate = htmlspecialchars(strip_tags($this->ExpiryDate));
        $this->Conditions = htmlspecialchars(strip_tags($this->Conditions));
        
        $stmt->bindParam(":desc", $this->Description);
        $stmt->bindParam(":discount", $this->DiscountPercentage);
        $stmt->bindParam(":expiry", $this->ExpiryDate);
        $stmt->bindParam(":conditions", $this->Conditions);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update special offer
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                SET Description=:desc, DiscountPercentage=:discount, 
                    ExpiryDate=:expiry, Conditions=:conditions
                WHERE SpecialOfferID=:id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind values
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->DiscountPercentage = htmlspecialchars(strip_tags($this->DiscountPercentage));
        $this->ExpiryDate = htmlspecialchars(strip_tags($this->ExpiryDate));
        $this->Conditions = htmlspecialchars(strip_tags($this->Conditions));
        $this->SpecialOfferID = htmlspecialchars(strip_tags($this->SpecialOfferID));
        
        $stmt->bindParam(":desc", $this->Description);
        $stmt->bindParam(":discount", $this->DiscountPercentage);
        $stmt->bindParam(":expiry", $this->ExpiryDate);
        $stmt->bindParam(":conditions", $this->Conditions);
        $stmt->bindParam(":id", $this->SpecialOfferID);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete special offer
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE SpecialOfferID = ?";
        $stmt = $this->conn->prepare($query);
        $this->SpecialOfferID = htmlspecialchars(strip_tags($this->SpecialOfferID));
        $stmt->bindParam(1, $this->SpecialOfferID);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>