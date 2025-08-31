<?php
include '../db_config.php';

session_start();

// If admin is already logged in, redirect to dashboard
if (isset($_SESSION['yadmin'])) {
    header('Location: index.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); // Trim to remove extra spaces
    $password = trim($_POST['password']); // Trim to remove extra spaces

    // Use prepared statements to prevent SQL injection
    $query = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $query->bind_param('ss', $username, $password);
    $query->execute();
    $result = $query->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $_SESSION['yadmin'] = $username;
        header('Location: index.php');
        exit();
    } else {
        $error_message = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="./css/login.css?v=1.0">
</head>
<body>
    <div class="login-form">
        <form action="login.php" method="post">
            <h2 class="text-center">Login Admin</h2>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?= $error_message ?></div>
            <?php endif; ?>
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
