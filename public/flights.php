<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/FlightController.php';
require_once __DIR__ . '/../app/controllers/TicketController.php';

$auth = new AuthController();
$auth->checkLogin(); // only logged-in users can book

$userId = $auth->currentUserId();

$flightController = new FlightController();
$flights = $flightController->listFlights();

$ticketController = new TicketController();
$successMsg = '';
$errorMsg = '';

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['flight_id'], $_POST['seat_number'])) {
    $flightId = $_POST['flight_id'];
    $seatNumber = $_POST['seat_number'];

    if ($ticketController->bookTicket($userId, $flightId, $seatNumber)) {
        $successMsg = "Ticket successfully booked!";
    } else {
        $errorMsg = "Failed to book ticket. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Available Flights - MJ Airlines</title>
<link rel="stylesheet" href="assets/css/Home.css">
<style>
.flight-container {
    max-width: 1000px;
    margin: 20px auto;
    background: #f9f9f9;
    padding: 20px;
    border-radius: 12px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
table th, table td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}
.book-btn {
    background-color: #005bbb;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s;
}
.book-btn:hover {
    background-color: #0073e6;
}
.success { color: green; font-weight: bold; }
.error { color: red; font-weight: bold; }
</style>
</head>
<body>

<header style="background: linear-gradient(90deg, #005bbb, #0073e6); color: white; padding: 20px; border-radius: 0 0 20px 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;">
        <h1 style="margin: 0; font-size: 2rem; font-family: 'Arial', sans-serif; letter-spacing: 1px;">MJ Airlines</h1>
        <nav style="margin-top: 10px;">
            <a href="home.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold;">Home</a>
            <a href="flights.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold;">Flights</a>
            <a href="aboutus.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold;">About Us</a>
            <a href="contactus.php" style="color: white; text-decoration: none; margin: 0 15px; font-weight: bold;">Contact Us</a>
            <a href="account.php" style="color: #ffeb3b; text-decoration: none; margin: 0 15px; font-weight: bold;">My Account</a>
            <a href="logout.php" style="color: #ffeb3b; text-decoration: none; margin: 0 15px; font-weight: bold;">Logout</a>
        </nav>
    </div>
</header>

<div class="flight-container">
    <h2>Available Flights</h2>

    <?php if ($successMsg): ?>
        <p class="success"><?= $successMsg ?></p>
    <?php endif; ?>
    <?php if ($errorMsg): ?>
        <p class="error"><?= $errorMsg ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Flight Number</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Price</th>
                <th>Seats Available</th>
                <th>Book</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($flights as $flight): ?>
            <tr>
                <td><?= htmlspecialchars($flight['flight_number']) ?></td>
                <td><?= htmlspecialchars($flight['departure_airport']) ?></td>
                <td><?= htmlspecialchars($flight['arrival_airport']) ?></td>
                <td><?= $flight['departure_time'] ?></td>
                <td><?= $flight['arrival_time'] ?></td>
                <td>$<?= $flight['price'] ?></td>
                <td><?= $flight['seats_available'] ?></td>
                <td>
                    <?php if($flight['seats_available'] > 0): ?>
                    <form method="POST" style="display:flex; gap:5px;">
                        <input type="hidden" name="flight_id" value="<?= $flight['id'] ?>">
                        <input type="text" name="seat_number" placeholder="Seat #" required style="width:70px; padding:3px;">
                        <button type="submit" class="book-btn">Book</button>
                    </form>
                    <?php else: ?>
                        Full
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
