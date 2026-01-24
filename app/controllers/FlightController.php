<?php
require_once __DIR__ . '/../models/FlightModel.php';
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../helpers/validation.php';

class FlightController {
    private $flightModel;
    private $auth;

    public function __construct() {
        $this->flightModel = new FlightModel();
        $this->auth = new AuthController();
    }

    public function listFlights() {
        return $this->flightModel->getAll();
    }

    public function searchFlights($departure, $arrival, $date) {
        return $this->flightModel->search($departure, $arrival, $date);
    }

    public function getFlight($id) {
        return $this->flightModel->findById($id);
    }

    public function addFlight($number, $dep, $arr, $depTime, $arrTime, $price, $seats) {
        $this->auth->checkAdmin();
        return $this->flightModel->create($number, $dep, $arr, $depTime, $arrTime, $price, $seats);
    }

    public function deleteFlight($id) {
        $this->auth->checkAdmin();
        return $this->flightModel->delete($id);
    }
}
?>
