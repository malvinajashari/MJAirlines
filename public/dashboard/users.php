    <?php
    require_once __DIR__ . '/../../app/controllers/UserController.php';

    $controller = new UserController();
    $controller->auth->checkAdmin(); // Admin-only access

    $users = $controller->getAllUsers();

    $error = '';
    $success = '';

    // Handle Add User form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_user') {
        $fullName = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $role = $_POST['role'] ?? 'user';

        $added = $controller->register($fullName, $email, $password, $role);

        if ($added) {
            $success = "User added successfully!";
            $users = $controller->getAllUsers(); // refresh table
        } else {
            $error = "Failed to add user. Email might already exist.";
        }
    }

    // Handle delete action
    if (isset($_GET['delete_id'])) {
        $id = intval($_GET['delete_id']);
        $controller->userModel->delete($id);
        header("Location: users.php");
        exit();
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Users</title>
    <link rel="stylesheet" href="../../public/assets/css/dashboard.css">
    <style>
        /* Add form styling */
        #addUserForm {
            display: none;
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        #addUserForm input, #addUserForm select, #addUserForm button {
            display: block;
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
            max-width: 300px;
        }
        #addUserForm button {
            background-color: #0073e6;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 6px;
        }
        #addUserForm button:hover {
            background-color: #005bbb;
        }
        .msg {
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 6px;
        }
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
        .add-btn:hover {
            background-color: #005bbb;
        }

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
        .edit-btn:hover {
            background-color: #e0a800;
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
    </style>
    </head>
    <body>

    <header>
        <h1>Admin Dashboard - Users</h1>
        <nav>
            <a href="airport.php">Airports</a>
            <a href="flights.php">Flights</a>
            <a href="messages.php">Messages</a>
            <a href="../../public/logout.php" class="logout-btn">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Manage Users</h2>

        <!-- Show messages -->
        <?php if($success): ?>
            <div class="msg success"><?= $success ?></div>
        <?php endif; ?>
        <?php if($error): ?>
            <div class="msg error"><?= $error ?></div>
        <?php endif; ?>

        <!-- Toggle Add User Form -->
        <button onclick="toggleForm()" class="add-btn">Add New User</button>

        <div id="addUserForm">
            <form method="POST">
                <input type="hidden" name="action" value="add_user">
                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit">Add User</button>
            </form>
        </div>

        <!-- Users Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registered At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= $user['role'] ?></td>
                    <td><?= $user['created_at'] ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="edit-btn">Edit</a>
                        <a href="?delete_id=<?= $user['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
    function toggleForm() {
        const form = document.getElementById('addUserForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }   
    </script>

    </body>
    </html>
