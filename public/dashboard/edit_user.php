<?php
require_once __DIR__ . '/../../app/controllers/UserController.php';

$controller = new UserController();
$controller->auth->checkAdmin(); // Admin-only access

// Check if ID is provided
if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit();
}

$userId = intval($_GET['id']);
$user = $controller->userModel->findById($userId);

if (!$user) {
    header("Location: users.php");
    exit();
}

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'] ?? 'user';

    $updated = $controller->userModel->update($userId, $fullName, $email, $role);

    if ($updated) {
        $success = "User updated successfully!";
        // Refresh user info
        $user = $controller->userModel->findById($userId);
    } else {
        $error = "Failed to update user. Email might already exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit User - Admin Dashboard</title>
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
    <h1>Edit User</h1>
    <nav>
        <a href="users.php">Back to Users</a>
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
        <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" placeholder="Full Name" required>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Email" required>
        <select name="role">
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <button type="submit">Update User</button>
    </form>
</main>

</body>
</html>
