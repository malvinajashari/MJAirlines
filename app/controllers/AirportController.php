<?php
require_once __DIR__ . '/../models/AirportModel.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../helpers/validation.php';

class AirportController {
    public $model;
    public $auth;

    public function __construct() {
        $this->model = new AirportModel();
        $this->auth = new AuthController();
        $this->auth->checkAdmin();
    }

    public function index() {
        $airports = $this->model->getAll();
        include __DIR__ . '/../views/airports/index.php';
    }

    public function createForm() {
        include __DIR__ . '/../views/airports/create.php';
    }

    public function create($data) {
        $this->model->create($data['name'], $data['code'], $data['city'], $data['country']);
        header("Location: /admin/airports.php");
    }

    public function editForm($id) {
        $airport = $this->model->findById($id);
        include __DIR__ . '/../views/airports/edit.php';
    }

    public function update($id, $data) {
        $this->model->update($id, $data['name'], $data['code'], $data['city'], $data['country']);
        header("Location: /admin/airports.php");
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: /admin/airports.php");
    }
}
?>
