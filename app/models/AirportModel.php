<?php
require_once __DIR__ . '/../config/Database.php';

class AirportModel {
    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $stmt = $this->conn->query("
            SELECT * FROM airports ORDER BY name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("
            SELECT * FROM airports WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $code, $city, $country) {
        $stmt = $this->conn->prepare("
            INSERT INTO airports (name, code, city, country)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$name, $code, $city, $country]);
    }

    public function update($id, $name, $code, $city, $country) {
        $stmt = $this->conn->prepare("
            UPDATE airports
            SET name = ?, code = ?, city = ?, country = ?
            WHERE id = ?
        ");
        return $stmt->execute([$name, $code, $city, $country, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("
            DELETE FROM airports WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }
}
?>
