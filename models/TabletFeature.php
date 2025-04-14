<?php
class TabletFeature {
    private $conn;
    private $table_name = "tablet_features"; // updated table name

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
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Read all tablet features
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // (Optional) Add a new feature
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (PackageID, Feature) VALUES (:PackageID, :Feature)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'PackageID' => $this->PackageID,
            'Feature' => $this->Feature
        ]);
    }

    // (Optional) Delete feature by FeatureID
    public function delete($featureId) {
        $query = "DELETE FROM " . $this->table_name . " WHERE FeatureID = :featureId";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['featureId' => $featureId]);
    }
}
?>
