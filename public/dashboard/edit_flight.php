<?php
require_once __DIR__ . '/../../app/controllers/FlightController.php';
require_once __DIR__ . '/../../app/models/AirportModel.php';

$controller = new FlightController();
$controller->auth->checkAdmin(); // Admin-only access

$airportModel = new AirportModel();
$airports = $airportModel->getAll(); // fetch all airports for dropdowns

// Check if flight ID is provided
if (!isset($_GET['id'])) {
    header("Location: flights.php");
    exit();
}

$flightId = intval($_GET['id']);
$flight = $controller->getFlight($flightId);

if (!$flight) {
    header("Location: flights.php");
    exit();
}

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $number = trim($_POST['flight_number']);
    $dep = intval($_POST['departure_airport']);
    $arr = intval($_POST['arrival_airport']);
    $depTime = $_POST['departure_time'];
    $arrTime = $_POST['arrival_time'];
    $price = $_POST['price'];
    $seats = $_POST['seats_available'];

    // Validate that departure and arrival airports exist
    $depAirport = $airportModel->findById($dep);
    $arrAirport = $airportModel->findById($arr);

    if (!$depAirport || !$arrAirport) {
        $error = "Invalid departure or arrival airport.";
    } else {
        // Proceed with update
        $stmt = $controller->flightModel->conn->prepare("
            UPDATE flights
            SET flight_number = ?, departure_airport = ?, arrival_airport = ?, 
                departure_time = ?, arrival_time = ?, price = ?, seats_available = ?
            WHERE id = ?
        ");
        $updated = $stmt->execute([$number, $dep, $arr, $depTime, $arrTime, $price, $seats, $flightId]);

        if ($updated) {
            $success = "Flight updated successfully!";
            $flight = $controller->getFlight($flightId); // refresh
        } else {
            $error = "Failed to update flight.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Flight - Admin Dashboard</title>
<link rel="stylesheet" href="../../public/assets/css/dashboard.css">
<style>
form {
    background: white;
    padding: 15px;
    border-radius: 8px;
    max-width: 500px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    margin-top: 20px;
}
form input, form select, form button {
    display: block;
    margin-bottom: 10px;
    padding: 8px;
    width: 100%;
}
form button {
    background-color: #0073e6;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 6px;
}
form button:hover { background-color: #005bbb; }
.msg { margin-bottom: 10px; padding: 8px; border-radius: 6px; }
.success { background: #d4edda; color: #155724; }
.error { background: #f8d7da; color: #721c24; }
</style>
</head>
<body>

<header>
    <h1>Edit Flight</h1>
    <nav>
        <a href="flights.php">Back to Flights</a>
    </nav>
</header>

<main>
    <?php if($success): ?>
        <div class="msg success"><?= $success ?></div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="msg error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="flight_number" value="<?= htmlspecialchars($flight['flight_number']) ?>" placeholder="Flight Number" required>

        <label>Departure Airport</label>
        <select name="departure_airport" required>
            <?php foreach($airports as $a): ?>
                <option value="<?= $a['id'] ?>" <?= $flight['departure_airport'] == $a['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Arrival Airport</label>
        <select name="arrival_airport" required>
            <?php foreach($airports as $a): ?>
                <option value="<?= $a['id'] ?>" <?= $flight['arrival_airport'] == $a['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="datetime-local" name="departure_time" value="<?= date('Y-m-d\TH:i', strtotime($flight['departure_time'])) ?>" required>
        <input type="datetime-local" name="arrival_time" value="<?= date('Y-m-d\TH:i', strtotime($flight['arrival_time'])) ?>" required>
        <input type="number" step="0.01" name="price" value="<?= $flight['price'] ?>" placeholder="Price" required>
        <input type="number" name="seats_available" value="<?= $flight['seats_available'] ?>" placeholder="Seats Available" required>

        <button type="submit">Update Flight</button>
    </form>
</main>

</body>
</html>
                