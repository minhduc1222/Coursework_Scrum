<?php
// Order Model
class Order {
    private $conn;
    private $table_name = "orders";

    public $OrderID;
    public $CustomerID;
    public $PackageID;
    public $DealID;
    public $SpecialOfferID;
    public $TotalAmount;
    public $DiscountApplied;
    public $OrderType;
    public $OrderDate;
    public $Status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Read all orders
    public function readAll() {
        $query = "SELECT o.*, p.PackageName, c.Name as CustomerName
                 FROM " . $this->table_name . " o
                 JOIN package p ON o.PackageID = p.PackageID
                 JOIN customer c ON o.CustomerID = c.CustomerID
                 ORDER BY o.OrderDate DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read one order
    public function readOne() {
        $query = "SELECT o.*, p.PackageName, c.Name as CustomerName
                 FROM " . $this->table_name . " o
                 JOIN package p ON o.PackageID = p.PackageID
                 JOIN customer c ON o.CustomerID = c.CustomerID
                 WHERE o.OrderID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->OrderID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->CustomerID = $row['CustomerID'];
        $this->PackageID = $row['PackageID'];
        $this->DealID = $row['DealID'];
        $this->SpecialOfferID = $row['SpecialOfferID'];
        $this->TotalAmount = $row['TotalAmount'];
        $this->DiscountApplied = $row['DiscountApplied'];
        $this->OrderType = $row['OrderType'];
        $this->OrderDate = $row['OrderDate'];
        $this->Status = $row['Status'];
    }

    // Read orders by customer
    public function readByCustomer($customerID) {
        $query = "SELECT o.*, p.PackageName
                 FROM " . $this->table_name . " o
                 JOIN package p ON o.PackageID = p.PackageID
                 WHERE o.CustomerID = ?
                 ORDER BY o.OrderDate DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $customerID);
        $stmt->execute();
        return $stmt;
    }

    // Create order
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET CustomerID=:customerID, PackageID=:packageID, DealID=:dealID, 
                      SpecialOfferID=:offerID, TotalAmount=:total, DiscountApplied=:discount,
                      OrderType=:type, Status=:status";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind values
        $this->CustomerID = htmlspecialchars(strip_tags($this->CustomerID));
        $this->PackageID = htmlspecialchars(strip_tags($this->PackageID));
        $this->DealID = htmlspecialchars(strip_tags($this->DealID));
        $this->SpecialOfferID = htmlspecialchars(strip_tags($this->SpecialOfferID));
        $this->TotalAmount = htmlspecialchars(strip_tags($this->TotalAmount));
        $this->DiscountApplied = htmlspecialchars(strip_tags($this->DiscountApplied));
        $this->OrderType = htmlspecialchars(strip_tags($this->OrderType));
        $this->Status = htmlspecialchars(strip_tags($this->Status));
        
        $stmt->bindParam(":customerID", $this->CustomerID);
        $stmt->bindParam(":packageID", $this->PackageID);
        $stmt->bindParam(":dealID", $this->DealID);
        $stmt->bindParam(":offerID", $this->SpecialOfferID);
        $stmt->bindParam(":total", $this->TotalAmount);
        $stmt->bindParam(":discount", $this->DiscountApplied);
        $stmt->bindParam(":type", $this->OrderType);
        $stmt->bindParam(":status", $this->Status);
        
        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Update order status
    public function updateStatus() {
        $query = "UPDATE " . $this->table_name . "
                SET Status=:status
                WHERE OrderID=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->Status = htmlspecialchars(strip_tags($this->Status));
        $this->OrderID = htmlspecialchars(strip_tags($this->OrderID));
        
        $stmt->bindParam(":status", $this->Status);
        $stmt->bindParam(":id", $this->OrderID);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete order
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE OrderID = ?";
        $stmt = $this->conn->prepare($query);
        $this->OrderID = htmlspecialchars(strip_tags($this->OrderID));
        $stmt->bindParam(1, $this->OrderID);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Calculate order total with discounts
    public function calculateTotal($packagePrice, $dealDiscount = 0, $specialOfferDiscount = 0) {
        $totalDiscount = $dealDiscount + $specialOfferDiscount;
        if($totalDiscount > 50) { // Cap discount at 50%
            $totalDiscount = 50;
        }
        
        $discountAmount = ($packagePrice * $totalDiscount) / 100;
        $finalPrice = $packagePrice - $discountAmount;
        
        $this->TotalAmount = $finalPrice;
        $this->DiscountApplied = $discountAmount;
        
        return $finalPrice;
    }
}
?>