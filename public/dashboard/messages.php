<?php
require_once __DIR__ . '/../../app/controllers/MessageController.php';

$controller = new MessageController();
$controller->auth->checkAdmin();

$messages = $controller->model->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - Messages</title>
<link rel="stylesheet" href="../../public/assets/css/dashboard.css">
<style>
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background: white;
    border-radius: 6px;
    overflow: hidden;
}
table th, table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}
.view-btn {
    background-color: #17a2b8;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
}
.view-btn:hover {
    background-color: #117a8b;
}
.delete-btn {
    background-color: #ff4d4d;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
}
.delete-btn:hover {
    background-color: #e60000;
}
.add-btn {
    display: none; /* No add messages from admin dashboard */
}
</style>
</head>
<body>

<header>
    <h1>Admin Dashboard - Messages</h1>
    <nav>
        <a href="users.php">Users</a>
        <a href="airport.php">Airports</a>
        <a href="flights.php">Flights</a>
        <a href="../../public/logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

<main>
    <h2>Messages</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Received At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($messages as $msg): ?>
            <tr>
                <td><?= $msg['id'] ?></td>
                <td><?= htmlspecialchars($msg['name']) ?></td>
                <td><?= htmlspecialchars($msg['email']) ?></td>
                <td><?= htmlspecialchars($msg['subject']) ?></td>
                <td><?= $msg['created_at'] ?></td>
                <td>
                    <a href="view_message.php?id=<?= $msg['id'] ?>" class="view-btn">View</a>
                    <a href="?delete_id=<?= $msg['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>

</body>
</html>

<?php
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $controller->delete($id);
    header("Location: messages.php");
    exit();
}
?>
