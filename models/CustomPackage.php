<?php
// CustomPackage Model
class CustomPackage {
    private $conn;
    private $table_name = "custom_package";

    public $PackageID;
    public $CustomerID;
    public $PackageName;
    public $Description;
    public $Type;
    public $Price;
    public $FreeMinutes;
    public $FreeSMS;
    public $FreeGB;
    public $old_price;
    public $Contract;
    public $IsPopular;
    public $DownloadSpeed;
    public $UploadSpeed;
    public $SetupFee;
    public $Brand;
    public $Rating;
    public $UpfrontCost;

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
        $query = "SELECT * FROM " . $this->table_name . " WHERE PackageID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->PackageID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->CustomerID = $row['CustomerID'];
            $this->PackageName = $row['PackageName'];
            $this->Description = $row['Description'];
            $this->Type = $row['Type'];
            $this->Price = $row['Price'];
            $this->FreeMinutes = $row['FreeMinutes'];
            $this->FreeSMS = $row['FreeSMS'];
            $this->FreeGB = $row['FreeGB'];
            $this->old_price = $row['old_price'];
            $this->Contract = $row['Contract'];
            $this->IsPopular = $row['IsPopular'];
            $this->DownloadSpeed = $row['DownloadSpeed'];
            $this->UploadSpeed = $row['UploadSpeed'];
            $this->SetupFee = $row['SetupFee'];
            $this->Brand = $row['Brand'];
            $this->Rating = $row['Rating'];
            $this->UpfrontCost = $row['UpfrontCost'];
        }
    }

    public function readByType($type) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Type = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $type);
        $stmt->execute();
        return $stmt;
    }

    public function isPackageNameTaken($packageName, $customerID) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE PackageName = ? AND CustomerID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $packageName);
        $stmt->bindParam(2, $customerID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    public function create() {
        // Validate attributes before creating
        // if (!$this->validateAttributes()) {
        //     throw new Exception("Invalid package attributes: Required fields must be non-zero.");
        // }

        $query = "INSERT INTO " . $this->table_name . " 
                  SET CustomerID=:customer_id, PackageName=:name, Description=:desc, Type=:type, 
                      Price=:price, FreeMinutes=:minutes, FreeSMS=:sms, FreeGB=:gb, 
                      old_price=:old_price, Contract=:contract, IsPopular=:is_popular, 
                      DownloadSpeed=:download_speed, UploadSpeed=:upload_speed, 
                      SetupFee=:setup_fee, Brand=:brand, Rating=:rating, UpfrontCost=:upfront_cost";
    
        $stmt = $this->conn->prepare($query);
    
        $this->sanitize();
    
        $stmt->bindParam(":customer_id", $this->CustomerID);
        $stmt->bindParam(":name", $this->PackageName);
        $stmt->bindParam(":desc", $this->Description);
        $stmt->bindParam(":type", $this->Type);
        $stmt->bindParam(":price", $this->Price);
        $stmt->bindParam(":minutes", $this->FreeMinutes);
        $stmt->bindParam(":sms", $this->FreeSMS);
        $stmt->bindParam(":gb", $this->FreeGB);
        $stmt->bindParam(":old_price", $this->old_price);
        $stmt->bindParam(":contract", $this->Contract);
        $stmt->bindParam(":is_popular", $this->IsPopular);
        $stmt->bindParam(":download_speed", $this->DownloadSpeed);
        $stmt->bindParam(":upload_speed", $this->UploadSpeed);
        $stmt->bindParam(":setup_fee", $this->SetupFee);
        $stmt->bindParam(":brand", $this->Brand);
        $stmt->bindParam(":rating", $this->Rating);
        $stmt->bindParam(":upfront_cost", $this->UpfrontCost);
    
        if ($stmt->execute()) {
            return true;
        } else {
            // Log the error for debugging
            $errorInfo = $stmt->errorInfo();
            error_log("Database error: " . implode(", ", $errorInfo));
            return false;
        }
    }

    public function update() {
        // if (!$this->validateAttributes()) {
        //     throw new Exception("Invalid package attributes: Required fields must be non-zero.");
        // }

        $query = "UPDATE " . $this->table_name . "
                  SET CustomerID=:customer_id, PackageName=:name, Description=:desc, Type=:type, 
                      Price=:price, FreeMinutes=:minutes, FreeSMS=:sms, FreeGB=:gb, 
                      old_price=:old_price, Contract=:contract, IsPopular=:is_popular, 
                      DownloadSpeed=:download_speed, UploadSpeed=:upload_speed, 
                      SetupFee=:setup_fee, Brand=:brand, Rating=:rating, UpfrontCost=:upfront_cost
                  WHERE PackageID=:id";

        $stmt = $this->conn->prepare($query);

        $this->sanitize();
        $this->PackageID = htmlspecialchars(strip_tags($this->PackageID));

        $stmt->bindParam(":customer_id", $this->CustomerID);
        $stmt->bindParam(":name", $this->PackageName);
        $stmt->bindParam(":desc", $this->Description);
        $stmt->bindParam(":type", $this->Type);
        $stmt->bindParam(":price", $this->Price);
        $stmt->bindParam(":minutes", $this->FreeMinutes);
        $stmt->bindParam(":sms", $this->FreeSMS);
        $stmt->bindParam(":gb", $this->FreeGB);
        $stmt->bindParam(":old_price", $this->old_price);
        $stmt->bindParam(":contract", $this->Contract);
        $stmt->bindParam(":is_popular", $this->IsPopular);
        $stmt->bindParam(":download_speed", $this->DownloadSpeed);
        $stmt->bindParam(":upload_speed", $this->UploadSpeed);
        $stmt->bindParam(":setup_fee", $this->SetupFee);
        $stmt->bindParam(":brand", $this->Brand);
        $stmt->bindParam(":rating", $this->Rating);
        $stmt->bindParam(":upfront_cost", $this->UpfrontCost);
        $stmt->bindParam(":id", $this->PackageID);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE PackageID = ?";
        $stmt = $this->conn->prepare($query);
        $this->PackageID = htmlspecialchars(strip_tags($this->PackageID));
        $stmt->bindParam(1, $this->PackageID);
        return $stmt->execute();
    }

    private function sanitize() {
        $this->CustomerID = htmlspecialchars(strip_tags($this->CustomerID));
        $this->PackageName = htmlspecialchars(strip_tags($this->PackageName));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->Type = htmlspecialchars(strip_tags($this->Type));
        $this->Price = htmlspecialchars(strip_tags($this->Price));
        $this->FreeMinutes = htmlspecialchars(strip_tags($this->FreeMinutes));
        $this->FreeSMS = htmlspecialchars(strip_tags($this->FreeSMS));
        $this->FreeGB = htmlspecialchars(strip_tags($this->FreeGB));
        $this->old_price = htmlspecialchars(strip_tags($this->old_price));
        $this->Contract = htmlspecialchars(strip_tags($this->Contract));
        $this->IsPopular = htmlspecialchars(strip_tags($this->IsPopular));
        $this->DownloadSpeed = htmlspecialchars(strip_tags($this->DownloadSpeed));
        $this->UploadSpeed = htmlspecialchars(strip_tags($this->UploadSpeed));
        $this->SetupFee = htmlspecialchars(strip_tags($this->SetupFee));
        $this->Brand = htmlspecialchars(strip_tags($this->Brand));
        $this->Rating = htmlspecialchars(strip_tags($this->Rating));
        $this->UpfrontCost = htmlspecialchars(strip_tags($this->UpfrontCost));
    }

    public function readByCustomer($customerID) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE CustomerID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $customerID);
        $stmt->execute();
        return $stmt;
    }

    // public function validateAttributes() {
    //     if (empty($this->Type)) {
    //         return false;
    //     }

    //     if ($this->Type === 'Mobile') {
    //         return $this->FreeMinutes > 0 && $this->FreeSMS > 0 && $this->FreeGB > 0;
    //     } elseif ($this->Type === 'Broadband') {
    //         return $this->DownloadSpeed > 0 && $this->UploadSpeed > 0;
    //     } elseif ($this->Type === 'Tablet') {
    //         return $this->FreeGB > 0;
    //     }

    //     return false;
    // }
}
?>