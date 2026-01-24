<?php
require_once __DIR__ . '/../config/Database.php';

class TicketModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function book($userId, $flightId, $seatNumber) {
        $stmt = $this->conn->prepare("
            INSERT INTO tickets (user_id, flight_id, seat_number)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$userId, $flightId, $seatNumber]);
    }

    public function getByUser($userId) {
        $stmt = $this->conn->prepare("
            SELECT tickets.*, flights.flight_number, flights.departure_time, flights.arrival_time
            FROM tickets
            JOIN flights ON tickets.flight_id = flights.id
            WHERE tickets.user_id = ?
            ORDER BY booking_date DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->conn->query("
            SELECT tickets.*, users.full_name, flights.flight_number
            FROM tickets
            JOIN users ON tickets.user_id = users.id
            JOIN flights ON tickets.flight_id = flights.id
            ORDER BY booking_date DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancel($ticketId) {
        $stmt = $this->conn->prepare("
            UPDATE tickets SET status = 'cancelled' WHERE id = ?
        ");
        return $stmt->execute([$ticketId]);
    }
}
?>
