<?php
require_once __DIR__ . '/../../app/controllers/FlightController.php';

$controller = new FlightController();
$controller->auth->checkAdmin(); // Admin-only access

$flights = $controller->listFlights();

$error = '';
$success = '';

// Handle Add Flight form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_flight') {
    $number = trim($_POST['flight_number']);
    $dep = $_POST['departure_airport'];
    $arr = $_POST['arrival_airport'];
    $depTime = $_POST['departure_time'];
    $arrTime = $_POST['arrival_time'];
    $price = $_POST['price'];
    $seats = $_POST['seats_available'];

    $added = $controller->addFlight($number, $dep, $arr, $depTime, $arrTime, $price, $seats);
    if ($added) {
        $success = "Flight added successfully!";
        $flights = $controller->listFlights(); // refresh table
    } else {
        $error = "Failed to add flight.";
    }
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $controller->deleteFlight($id);
    header("Location: flights.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - Flights</title>
<link rel="stylesheet" href="../../public/assets/css/dashboard.css">
<style>
    #addFlightForm {
        display: none;
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    #addFlightForm input, #addFlightForm select, #addFlightForm button {
        display: block;
        margin-bottom: 10px;
        padding: 8px;
        width: 100%;
        max-width: 400px;
    }
    #addFlightForm button {
        background-color: #0073e6;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 6px;
    }
    #addFlightForm button:hover { background-color: #005bbb; }

    .msg { margin-bottom: 10px; padding: 8px; border-radius: 6px; }
    .success { background: #d4edda; color: #155724; }
    .error { background: #f8d7da; color: #721c24; }

    .add-btn {
        background-color: #0073e6;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        margin-bottom: 15px;
    }
    .add-btn:hover { background-color: #005bbb; }

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
    .edit-btn {
        background-color: #ffc107;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        margin-right: 5px;
    }
    .edit-btn:hover { background-color: #e0a800; }
    .delete-btn {
        background-color: #ff4d4d;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
    }
    .delete-btn:hover { background-color: #e60000; }
</style>
</head>
<body>

<header>
    <h1>Admin Dashboard - Flights</h1>
    <nav>
        <a href="users.php">Users</a>
        <a href="airport.php">Airports</a>
        <a href="../../public/logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

<main>
    <h2>Manage Flights</h2>

    <?php if($success): ?>
        <div class="msg success"><?= $success ?></div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="msg error"><?= $error ?></div>
    <?php endif; ?>

    <button onclick="toggleForm()" class="add-btn">Add New Flight</button>

    <div id="addFlightForm">
        <form method="POST">
            <input type="hidden" name="action" value="add_flight">
            <input type="text" name="flight_number" placeholder="Flight Number" required>
            <input type="text" name="departure_airport" placeholder="Departure Airport ID" required>
            <input type="text" name="arrival_airport" placeholder="Arrival Airport ID" required>
            <input type="datetime-local" name="departure_time" required>
            <input type="datetime-local" name="arrival_time" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <input type="number" name="seats_available" placeholder="Seats Available" required>
            <button type="submit">Add Flight</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Flight Number</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Price</th>
                <th>Seats</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($flights as $flight): ?>
            <tr>
                <td><?= $flight['id'] ?></td>
                <td><?= htmlspecialchars($flight['flight_number']) ?></td>
                <td><?= htmlspecialchars($flight['departure_airport']) ?></td>
                <td><?= htmlspecialchars($flight['arrival_airport']) ?></td>
                <td><?= $flight['departure_time'] ?></td>
                <td><?= $flight['arrival_time'] ?></td>
                <td><?= $flight['price'] ?></td>
                <td><?= $flight['seats_available'] ?></td>
                <td>
                    <a href="edit_flight.php?id=<?= $flight['id'] ?>" class="edit-btn">Edit</a>
                    <a href="?delete_id=<?= $flight['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>

<script>
function toggleForm() {
    const form = document.getElementById('addFlightForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>

</body>
</html>
