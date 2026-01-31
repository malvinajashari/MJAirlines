<?php
require_once __DIR__ . '/../app/models/MessageModel.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$auth = new AuthController();
$model = new MessageModel();

$success = '';
$error = '';

$userName = '';
$userEmail = '';
$isLoggedIn = false;

if ($auth->currentUserId()) {
    require_once __DIR__ . '/../app/models/UserModel.php';
    $userModel = new UserModel();
    $user = $userModel->findById($auth->currentUserId());
    if ($user) {
        $userName = $user['full_name'];
        $userEmail = $user['email'];
        $isLoggedIn = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$name || !$email || !$subject || !$message) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        $added = $model->create($name, $email, $subject, $message);
        if ($added) {
            $success = "Your message has been sent successfully!";
            $subject = $message = ''; // clear only editable fields
        } else {
            $error = "Failed to send message. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Contact Us - MJ Airlines</title>
<link rel="stylesheet" href="assets/css/contactus.css">
<style>
    .msg { padding: 10px; border-radius: 6px; margin-bottom: 15px; max-width: 500px; }
    .success { background: #d4edda; color: #155724; }
    .error { background: #f8d7da; color: #721c24; }
    input[readonly] { background: #e9ecef; cursor: not-allowed; }
</style>
</head>
<body>

<header>MJ Airlines</header>

<nav>
    <a href="Home.php">Home</a>
    <a href="Flights.php">Flights</a>
    <a href="contactus.php" class="active">Contact</a>
</nav>

<div class="container">
    <h2>Contact Us</h2>

    <?php if($success): ?>
        <div class="msg success"><?= $success ?></div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="msg error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="contactus.php">
        <input type="text" name="name" placeholder="Full Name" 
            value="<?= htmlspecialchars($_POST['name'] ?? $userName) ?>" 
            <?= $isLoggedIn ? 'readonly' : '' ?> required>

        <input type="email" name="email" placeholder="Email Address" class="full-width" 
            value="<?= htmlspecialchars($_POST['email'] ?? $userEmail) ?>" 
            <?= $isLoggedIn ? 'readonly' : '' ?> required>

        <input type="text" name="subject" placeholder="Subject" class="full-width"
            value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>" required>

        <textarea name="message" placeholder="Your message..." class="full-width" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>

        <button type="submit">Send Message</button>
    </form>
</div>

<footer>
    © 2025 MJ Airlines. All Rights Reserved.
</footer>

</body>
</html>
