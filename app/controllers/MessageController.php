<?php
require_once __DIR__ . '/../models/MessageModel.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../helpers/validation.php';

class MessageController {
    public $model;
    public $auth;

    public function __construct() {
        $this->model = new MessageModel();
        $this->auth = new AuthController();
    }

    public function index() {
        $messages = $this->model->getAll();
        include __DIR__ . '/../views/messages/index.php';
    }

    public function view($id) {
        $message = $this->model->findById($id);
        include __DIR__ . '/../views/messages/view.php';
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: /admin/messages.php");
    }
}
?>
