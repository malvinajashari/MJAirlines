<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../helpers/validation.php';

class UserController {
    private $userModel;
    private $auth;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->auth = new AuthController();
    }

    public function register($fullName, $email, $password, $role = 'user') {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        return $this->userModel->create($fullName, $email, $hashed, $role);
    }

    public function login($email, $password) {
        $user = $this->userModel->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }

    public function getAllUsers() {
        $this->auth->checkAdmin();
        return $this->userModel->getAll();
    }
}
?>
