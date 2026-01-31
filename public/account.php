<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/TicketController.php';

$auth = new AuthController();
$auth->checkLogin(); // Only logged-in users

$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];
$userName = $auth->currentUserName(); // Assumes you have a method to get full name
$userEmail = $auth->currentUserEmail(); // Assumes you have a method to get email

$ticketController = new TicketController();
$tickets = $ticketController->userTickets($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Account - MJ Airlines</title>
<link rel="stylesheet" href="assets/css/Home.css">
<style>
.account-container {
    max-width: 800px;
    margin: 20px auto;
    background: #f9f9f9;
    padding: 20px;
    border-radius: 12px;
}
h2 { color: #003366; }
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
.status-cancelled { color: red; font-weight: bold; }
.status-active { color: green; font-weight: bold; }
</style>
</head>
<body>

<header style="background: linear-gradient(90deg, #005bbb, #0073e6); color: white; padding: 20px; border-radius: 0 0 20px 20px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;">
        <h1 style="margin: 0; font-size: 2rem; font-family: 'Arial', sans-serif; letter-spacing: 1px;">MJ Airlines - My Account</h1>
        <nav style="margin-top: 10px;">
            <a href="home.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold; transition: color 0.3s;">Home</a>
            <a href="account.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold; transition: color 0.3s;">My Account</a>
            <a href="logout.php" style="color: #ffeb3b; text-decoration: none; margin: 0 15px; font-weight: bold; transition: color 0.3s;">Logout</a>
        </nav>
    </div>
</header>

<div class="account-container">
    <h2>Personal Information</h2>
    <p><strong>Name:</strong> <?= htmlspecialchars($userName) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($userEmail) ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars($userRole) ?></p>

    <h2>My Tickets</h2>
    <?php if(empty($tickets)): ?>
        <p>You have not booked any tickets yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Flight Number</th>
                    <th>Seat Number</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tickets as $ticket): ?>
                    <tr>
                        <td><?= htmlspecialchars($ticket['flight_number']) ?></td>
                        <td><?= htmlspecialchars($ticket['seat_number']) ?></td>
                        <td><?= $ticket['departure_time'] ?></td>
                        <td><?= $ticket['arrival_time'] ?></td>
                        <td class="<?= $ticket['status'] === 'cancelled' ? 'status-cancelled' : 'status-active' ?>">
                            <?= ucfirst($ticket['status']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
