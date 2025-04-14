<?php
// Payment Model
class Payment {
    private $conn;
    private $table_name = "payment";

    public $PaymentID;
    public $PaymentDate;
    public $Status;
    public $CustomerID;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET PaymentDate=:paymentDate, Status=:status, CustomerID=:customerID";
        $stmt = $this->conn->prepare($query);

        $this->PaymentDate = htmlspecialchars(strip_tags($this->PaymentDate));
        $this->Status = htmlspecialchars(strip_tags($this->Status));
        $this->CustomerID = htmlspecialchars(strip_tags($this->CustomerID));

        $stmt->bindParam(":paymentDate", $this->PaymentDate);
        $stmt->bindParam(":status", $this->Status);
        $stmt->bindParam(":customerID", $this->CustomerID);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
}
?>