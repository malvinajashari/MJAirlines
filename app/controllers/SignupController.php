<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../helpers/validation.php';

class SignupController {
    private UserModel $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new UserModel();
    }

    public function register($fullName, $email, $password, $confirmPassword) {
        $fullName = sanitize($fullName);
        $email = sanitize($email);

        if (
            !isRequired($fullName) ||
            !isRequired($email) ||
            !isEmail($email) ||
            !isRequired($password)
        ) {
            $_SESSION['error'] = "Invalid input data";
            header("Location: ../../public/signup.php");
            exit();
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match";
            header("Location: ../../public/signup.php");
            exit();
        }

        if ($this->userModel->findByEmail($email)) {
            $_SESSION['error'] = "Email already registered";
            header("Location: ../public/signup.php");
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->create($fullName, $email, $hashedPassword);

        $_SESSION['success'] = "Account created successfully. You can login now.";
        header("Location: ../public/login.php");
        exit();
    }
}
