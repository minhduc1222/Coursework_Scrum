<?php
class MobileFeature {
    private $conn;
    private $table_name = "mobile_features";

    public $FeatureID;
    public $PackageID;
    public $Feature;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all features for a specific package
    public function getFeaturesByPackageId($packageId) {
        $query = "SELECT Feature FROM " . $this->table_name . " WHERE PackageID = :packageId";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['packageId' => $packageId]);
        return $stmt->FetchAll(PDO::FETCH_COLUMN);
    }

    // Read all mobile features
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>