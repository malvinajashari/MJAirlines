<?php
require_once __DIR__ . '/../../app/controllers/MessageController.php';

$controller = new MessageController();
$controller->auth->checkAdmin();

if (!isset($_GET['id'])) {
    header("Location: messages.php");
    exit();
}

$messageId = intval($_GET['id']);
$message = $controller->model->findById($messageId);

if (!$message) {
    header("Location: messages.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Message</title>
<link rel="stylesheet" href="../../public/assets/css/dashboard.css">
<style>
.message-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    max-width: 600px;
    margin-top: 20px;
}
.message-card h3 { margin-top: 0; }
</style>
</head>
<body>

<header>
    <h1>View Message</h1>
    <nav>
        <a href="messages.php">Back to Messages</a>
    </nav>
</header>

<main>
<div class="message-card">
    <h3><?= htmlspecialchars($message['subject']) ?></h3>
    <p><strong>From:</strong> <?= htmlspecialchars($message['name']) ?> (<?= htmlspecialchars($message['email']) ?>)</p>
    <p><strong>Received at:</strong> <?= $message['created_at'] ?></p>
    <hr>
    <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
</div>
</main>

</body>
</html>
