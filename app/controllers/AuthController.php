<?php
class AuthController {
    public function __construct() {
        session_start();
    }

    public function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }
    }

    public function checkAdmin() {
        $this->checkLogin();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            die("Access denied. Admins only.");
        }
    }

    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit();
    }

    public function currentUserId() {
        return $_SESSION['user_id'] ?? null;
    }

