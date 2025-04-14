<?php
// Order Model (Updated)
class Order {
    private $conn;
    private $table_name = "orders";

    public $OrderID;
    public $CustomerID;
    public $DealID;
    public $SpecialOfferID;
    public $TotalAmount;
    public $DiscountApplied;
    public $OrderType;
    public $OrderDate;
    public $Status;
    public $PaymentID;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT o.*, c.Name as CustomerName
                 FROM " . $this->table_name . " o
                 JOIN customer c ON o.CustomerID = c.CustomerID
                 ORDER BY o.OrderDate DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT o.*, c.Name as CustomerName
                 FROM " . $this->table_name . " o
                 JOIN customer c ON o.CustomerID = c.CustomerID
                 WHERE o.OrderID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->OrderID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->CustomerID = $row['CustomerID'];
        $this->DealID = $row['DealID'];
        $this->SpecialOfferID = $row['SpecialOfferID'];
        $this->TotalAmount = $row['TotalAmount'];
        $this->DiscountApplied = $row['DiscountApplied'];
        $this->OrderType = $row['OrderType'];
        $this->OrderDate = $row['OrderDate'];
        $this->Status = $row['Status'];
        $this->PaymentID = $row['PaymentID'];
    }

    public function readByCustomer($customerID) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE CustomerID = ?
                 ORDER BY OrderDate DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $customerID);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET CustomerID=:customerID, DealID=:dealID, SpecialOfferID=:offerID,
                      TotalAmount=:total, DiscountApplied=:discount, OrderType=:type,
                      OrderDate=:orderDate, Status=:status, PaymentID=:paymentID";

        $stmt = $this->conn->prepare($query);

        $this->CustomerID = htmlspecialchars(strip_tags($this->CustomerID));
        $this->DealID = htmlspecialchars(strip_tags($this->DealID));
        $this->SpecialOfferID = htmlspecialchars(strip_tags($this->SpecialOfferID));
        $this->TotalAmount = htmlspecialchars(strip_tags($this->TotalAmount));
        $this->DiscountApplied = htmlspecialchars(strip_tags($this->DiscountApplied));
        $this->OrderType = htmlspecialchars(strip_tags($this->OrderType));
        $this->OrderDate = $this->OrderDate ?: date('Y-m-d H:i:s'); // Default to now
        $this->Status = htmlspecialchars(strip_tags($this->Status));
        $this->PaymentID = htmlspecialchars(strip_tags($this->PaymentID));

        $stmt->bindParam(":customerID", $this->CustomerID);
        $stmt->bindValue(":dealID", $this->DealID, PDO::PARAM_INT);
        $stmt->bindValue(":offerID", $this->SpecialOfferID, PDO::PARAM_INT);
        $stmt->bindParam(":total", $this->TotalAmount);
        $stmt->bindParam(":discount", $this->DiscountApplied);
        $stmt->bindParam(":type", $this->OrderType);
        $stmt->bindParam(":orderDate", $this->OrderDate);
        $stmt->bindParam(":status", $this->Status);
        $stmt->bindValue(":paymentID", $this->PaymentID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function updateStatus() {
        $query = "UPDATE " . $this->table_name . "
                SET Status=:status
                WHERE OrderID=:id";

        $stmt = $this->conn->prepare($query);

        $this->Status = htmlspecialchars(strip_tags($this->Status));
        $this->OrderID = htmlspecialchars(strip_tags($this->OrderID));

        $stmt->bindParam(":status", $this->Status);
        $stmt->bindParam(":id", $this->OrderID);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE OrderID = ?";
        $stmt = $this->conn->prepare($query);
        $this->OrderID = htmlspecialchars(strip_tags($this->OrderID));
        $stmt->bindParam(1, $this->OrderID);

        return $stmt->execute();
    }

    public function calculateTotal($packagePrice, $dealDiscount = 0, $specialOfferDiscount = 0) {
        $totalDiscount = $dealDiscount + $specialOfferDiscount;
        if ($totalDiscount > 50) {
            $totalDiscount = 50;
        }

        $discountAmount = ($packagePrice * $totalDiscount) / 100;
        $finalPrice = $packagePrice - $discountAmount;

        $this->TotalAmount = $finalPrice;
        $this->DiscountApplied = $discountAmount;

        return $finalPrice;
    }

    // New method to add packages to order_package
    public function addOrderPackage($orderID, $packageID) {
        $query = "INSERT INTO order_package (OrderID, PackageID) VALUES (:orderID, :packageID)";
        $stmt = $this->conn->prepare($query);

        $orderID = htmlspecialchars(strip_tags($orderID));
        $packageID = htmlspecialchars(strip_tags($packageID));

        $stmt->bindParam(":orderID", $orderID);
        $stmt->bindParam(":packageID", $packageID);

        return $stmt->execute();
    }

    // New method to add custom packages to order_custom_package
    public function addOrderCustomPackage($orderID, $customPackageID) {
        $query = "INSERT INTO order_custom_package (OrderID, CustomPackageID) VALUES (:orderID, :customPackageID)";
        $stmt = $this->conn->prepare($query);

        $orderID = htmlspecialchars(strip_tags($orderID));
        $customPackageID = htmlspecialchars(strip_tags($customPackageID));

        $stmt->bindParam(":orderID", $orderID);
        $stmt->bindParam(":customPackageID", $customPackageID);

        return $stmt->execute();
    }
}
?>