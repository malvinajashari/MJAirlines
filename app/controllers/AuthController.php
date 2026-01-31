<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../helpers/validation.php';

class AuthController {
    private UserModel $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new UserModel();
    }

    public function login($email, $password) {
        $email = sanitize($email);
        $password = sanitize($password);

        if (!isRequired($email) || !isEmail($email) || !isRequired($password)) {
            $_SESSION['error'] = "Invalid email or password";
            header("Location: http://localhost/MJAirlines/public/login.php");
            exit();
        }

        $user = $this->userModel->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = strtolower($user['role']); // store role as lowercase

            if ($_SESSION['role'] === 'admin') {
                header("Location: http://localhost/MJAirlines/public/dashboard/users.php");
            } else {
                header("Location: http://localhost/MJAirlines/public/home.php"); // normal user goes to home
            }
            exit();
        } else {
            $_SESSION['error'] = "Incorrect email or password";
            header("Location: http://localhost/MJAirlines/public/login.php");
            exit();
        }
    }

    public function logout() {
        session_destroy();
        header("Location: http://localhost/MJAirlines/public/login.php");
        exit();
    }

    public function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: http://localhost/MJAirlines/public/login.php");
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

    public function currentUser() {
        if (!$this->currentUserId()) return null;
        return $this->userModel->findById($this->currentUserId());
    }

    public function currentUserName() {
        $user = $this->currentUser();
        return $user['full_name'] ?? null;
    }

    public function currentUserEmail() {
        $user = $this->currentUser();
        return $user['email'] ?? null;
    }
}
