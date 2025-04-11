<?php
    class PackageFeature {
        private $conn;
        private $table_name = "package_feature";

        public $PackageID;
        public $FeatureID;

        public function __construct($db) {
            $this->conn = $db;
        }
            
        public function getFeaturesByPackageId($packageId) {
            $query = "SELECT Feature FROM " . $this->table_name . " WHERE PackageID = :packageId";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['packageId' => $packageId]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        // Read all package features
        public function readAll() {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }
?>