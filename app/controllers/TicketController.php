<?php
require_once __DIR__ . '/../models/TicketModel.php';

class TicketController {
    private $ticketModel;

    public function __construct() {
        $this->ticketModel = new TicketModel();
        session_start();
    }

    public function bookTicket($userId, $flightId, $seatNumber) {
        return $this->ticketModel->book($userId, $flightId, $seatNumber);
    }

    public function userTickets($userId) {
        return $this->ticketModel->getByUser($userId);
    }

    public function allTickets() {
        return $this->ticketModel->getAll();
    }

    public function cancelTicket($ticketId) {
        return $this->ticketModel->cancel($ticketId);
    }
}
?>
