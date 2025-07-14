<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db_connect.php';

// Fetch all users for display in admin dashboard
$users = [];
$sql = "SELECT id, username, role, created_at FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .dashboard-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 20px auto;
        }
        .dashboard-container h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        .dashboard-container p {
            text-align: center;
            margin-bottom: 20px;
        }
        .dashboard-container a {
            color: #007bff;
            text-decoration: none;
        }
        .dashboard-container a:hover {
            text-decoration: underline;
        }
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .user-table th,
        .user-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .user-table th {
            background-color: #f2f2f2;
        }
        .logout-btn {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            background-color: #dc3545;
            color: white;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .dashboard-nav {
            text-align: center;
            margin-bottom: 20px;
        }
        .dashboard-nav a {
            margin: 0 15px;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

        <div class="dashboard-nav">
            <a href="admin_prod.php">Manage Products</a>
            <a href="index.php" target="_blank">View Website</a>
        </div>
        
        <h3>All Users</h3>
        <?php if (!empty($users)): ?>
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
