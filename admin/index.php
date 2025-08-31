<?php 
session_start();
// If admin is not logged in, redirect to login page
if (!isset($_SESSION['yadmin'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./css/style.css?v=1.0">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="#" id="dashboard-link">Dashboard</a></li>
                <li><a href="#" id="users-link">Users</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <div id="dashboard-section" class="content-section">
                <h1>Dashboard</h1>
                <p>Welcome to the Admin Dashboard!</p>
            </div>
            <div id="users-section" class="content-section" style="display: none;">
                <h1>Users</h1>
                <table id="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Business Info</th>
                            <th>Services Interest</th>
                            <th>Other Service</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be inserted dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="./js/script.js?v=1.1"></script>
</body>

</html>
