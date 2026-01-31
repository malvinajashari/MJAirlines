<?php
require_once __DIR__ . '/../../app/controllers/AirportController.php';

$controller = new AirportController();
$controller->auth->checkAdmin();

if (!isset($_GET['id'])) {
    header("Location: airport.php");
    exit();
}

$airportId = intval($_GET['id']);
$airport = $controller->model->findById($airportId);

if (!$airport) {
    header("Location: airport.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $code = trim($_POST['code']);
    $city = trim($_POST['city']);
    $country = trim($_POST['country']);

    $updated = $controller->model->update(
        $airportId,
        $name,
        $code,
        $city,
        $country
    );

    if ($updated) {
        $success = "Airport updated successfully!";
        $airport = $controller->model->findById($airportId);
    } else {
        $error = "Failed to update airport.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Airport - Admin Dashboard</title>
<link rel="stylesheet" href="../../public/assets/css/dashboard.css">

<style>
form {
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    max-width: 400px;
    margin-top: 20px;
}
form input, form button {
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
form button:hover {
    background-color: #005bbb;
}
.msg {
    margin-bottom: 10px;
    padding: 8px;
    border-radius: 6px;
}
.success { background: #d4edda; color: #155724; }
.error { background: #f8d7da; color: #721c24; }
</style>
</head>

<body>

<header>
    <h1>Edit Airport</h1>
    <nav>
        <a href="airport.php">Back to Airports</a>
        <a href="../../public/home.php">Home</a>
        <a href="../../public/logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

<main>

<?php if ($success): ?>
    <div class="msg success"><?= $success ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="msg error"><?= $error ?></div>
<?php endif; ?>

<form method="POST">
    <input type="text" name="name"
           value="<?= htmlspecialchars($airport['name']) ?>"
           placeholder="Airport Name" required>

    <input type="text" name="code"
           value="<?= htmlspecialchars($airport['code']) ?>"
           placeholder="Airport Code" required>

    <input type="text" name="city"
           value="<?= htmlspecialchars($airport['city']) ?>"
           placeholder="City" required>

    <input type="text" name="country"
           value="<?= htmlspecialchars($airport['country']) ?>"
           placeholder="Country" required>

    <button type="submit">Update Airport</button>
</form>

</main>

</body>
</html>
