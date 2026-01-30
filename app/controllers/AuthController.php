<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../helpers/validation.php';

class AuthController {
    public function __construct() {
        session_start();
        $this->userModel = new UserModel();
    }

    public function login($email, $password) {
        $email = sanitize($email);
        $password = sanitize($password);

        if (!isRequired($email) || !isEmail($email) || !isRequired($password)) {
            $_SESSION['error'] = "Invalid email or password";
            header("Location: ../public/login.php");
            exit();
        }

        $user = $this->userModel->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: ../public/dashboard/admin.php");
            } else {
                header("Location: ../public/dashboard/user.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Incorrect email or password";
            header("Location: ../public/login.php");
            exit();
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../public/login.php");
        exit();
    }

    public function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../public/login.php");
            exit();
        }
    }

    public function checkAdmin() {
        $this->checkLogin();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            die("Access denied. Admins only.");
        }
    }

    public function currentUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    public function currentUserRole() {
        return $_SESSION['role'] ?? null;
    }
}
