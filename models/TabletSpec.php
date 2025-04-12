<?php
class TabletSpec {
    private $conn;
    private $table_name = "tablet_specs";

    public $SpecID;
    public $PackageID;
    public $SpecName;
    public $SpecValue;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all specs for a specific package
    public function getSpecsByPackageId($packageId) {
        $query = "SELECT SpecName, SpecValue FROM " . $this->table_name . " WHERE PackageID = :packageId";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['packageId' => $packageId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read all tablet specs
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
