<?php
require_once __DIR__ . '/../../app/controllers/AirportController.php';

$controller = new AirportController();

$airports = $controller->model->getAll();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_airport') {
    $name = trim($_POST['name']);
    $code = trim($_POST['code']);
    $city = trim($_POST['city']);
    $country = trim($_POST['country']);

    if ($controller->model->create($name, $code, $city, $country)) {
        $success = "Airport added successfully!";
        $airports = $controller->model->getAll();
    } else {
        $error = "Failed to add airport.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - Airports</title>
<link rel="stylesheet" href="../../public/assets/css/dashboard.css">

<style>
#addAirportForm {
    display: none;
    background: white;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}
.add-btn {
    background-color: #0073e6;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
}
.add-btn:hover { background-color: #005bbb; }

.edit-btn {
    background-color: #ffc107;
    color: white;
    padding: 6px 12px;
    border-radius: 5px;
    text-decoration: none;
}
.edit-btn:hover { background-color: #e0a800; }

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
.success { background: #d4edda; padding: 10px; }
.error { background: #f8d7da; padding: 10px; }
</style>
</head>

<body>

<header>
    <h1>Admin Dashboard - Airports</h1>
    <nav>
        <a href="users.php">Users</a>
        <a href="flights.php">Flights</a>
        <a href="messages.php">Messages</a>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

<main>
<h2>Manage Airports</h2>

<?php if ($success): ?><div class="success"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>

<button onclick="toggleForm()" class="add-btn">Add New Airport</button>

<div id="addAirportForm">
    <form method="POST">
        <input type="hidden" name="action" value="add_airport">
        <input type="text" name="name" placeholder="Airport Name" required>
        <input type="text" name="code" placeholder="Code (e.g. JFK)" required>
        <input type="text" name="city" placeholder="City" required>
        <input type="text" name="country" placeholder="Country" required>
        <button type="submit" class="add-btn">Add Airport</button>
    </form>
</div>

<table>
<thead>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Code</th>
    <th>City</th>
    <th>Country</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>

<?php foreach ($airports as $airport): ?>
<tr>
    <td><?= $airport['id'] ?></td>
    <td><?= htmlspecialchars($airport['name']) ?></td>
    <td><?= htmlspecialchars($airport['code']) ?></td>
    <td><?= htmlspecialchars($airport['city']) ?></td>
    <td><?= htmlspecialchars($airport['country']) ?></td>
    <td>
        <a href="edit_airport.php?id=<?= $airport['id'] ?>" class="edit-btn">
            Edit
        </a>
    </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

</main>

<script>
function toggleForm() {
    const form = document.getElementById('addAirportForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>

</body>
</html>
