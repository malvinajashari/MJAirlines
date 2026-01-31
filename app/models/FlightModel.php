<?php
require_once __DIR__ . '/../config/Database.php';

class FlightModel {
    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $stmt = $this->conn->query("
            SELECT flights.*, 
                a1.name AS departure_airport,
                a2.name AS arrival_airport
            FROM flights
            JOIN airports a1 ON flights.departure_airport = a1.id
            JOIN airports a2 ON flights.arrival_airport = a2.id
            ORDER BY departure_time ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("
            SELECT flights.*, 
                a1.name AS departure_airport,
                a2.name AS arrival_airport
            FROM flights
            JOIN airports a1 ON flights.departure_airport = a1.id
            JOIN airports a2 ON flights.arrival_airport = a2.id
            WHERE flights.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function search($departure, $arrival, $date) {
        $stmt = $this->conn->prepare("
            SELECT * FROM flights
            WHERE departure_airport = ?
              AND arrival_airport = ?
              AND DATE(departure_time) = ?
        ");
        $stmt->execute([$departure, $arrival, $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($number, $dep, $arr, $depTime, $arrTime, $price, $seats) {
        $stmt = $this->conn->prepare("
            INSERT INTO flights 
            (flight_number, departure_airport, arrival_airport, departure_time, arrival_time, price, seats_available)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$number, $dep, $arr, $depTime, $arrTime, $price, $seats]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM flights WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
