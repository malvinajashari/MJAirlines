<?php
require_once __DIR__ . '/../../app/controllers/TicketController.php';
require_once __DIR__ . '/../../app/controllers/AuthController.php';

$auth = new AuthController();
$auth->checkAdmin(); // Admin-only access

$ticketController = new TicketController();
$tickets = $ticketController->allTickets();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - Tickets</title>
<link rel="stylesheet" href="../../public/assets/css/dashboard.css">
<style>
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    margin-top: 15px;
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

<header>
    <h1>Tickets Dashboard</h1>
    <nav>
        <a href="users.php">Users</a>
        <a href="flights.php">Flights</a>
        <a href="messages.php" class="active">Messages</a>
        <a href="../../public/logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

<main>
    <h2>All Booked Tickets</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Flight Number</th>
                <th>Seat Number</th>
                <th>Status</th>
                <th>Booking Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($tickets)): ?>
                <tr><td colspan="6" style="text-align:center;">No tickets found</td></tr>
            <?php else: ?>
                <?php foreach($tickets as $ticket): ?>
                    <tr>
                        <td><?= $ticket['id'] ?></td>
                        <td><?= htmlspecialchars($ticket['full_name']) ?></td>
                        <td><?= htmlspecialchars($ticket['flight_number']) ?></td>
                        <td><?= htmlspecialchars($ticket['seat_number']) ?></td>
                        <td class="<?= $ticket['status'] === 'cancelled' ? 'status-cancelled' : 'status-active' ?>">
                            <?= ucfirst($ticket['status']) ?>
                        </td>
                        <td><?= $ticket['booking_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

</body>
</html>
