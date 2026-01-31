<?php
require_once __DIR__ . '/../models/TicketModel.php';
require_once __DIR__ . '/../helpers/validation.php';

class TicketController {
    public $ticketModel;

    public function __construct() {
        $this->ticketModel = new TicketModel();
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
