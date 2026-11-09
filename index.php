<?php
session_start();
include 'db.php';

if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->execute(['username' => $username, 'password' => md5($password)]);
    $user = $stmt->fetch();
    
    if($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>School Attendance - Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient">
    <div class="login-container card">
        <h2 class="text-center">Admin Login</h2>
        <p class="text-center text-muted">School Attendance System</p>
        <?php if(isset($error)) { echo "<div class='alert error'>$error</div>"; } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required placeholder="Enter username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Enter password">
            </div>
            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
        </form>
        <div class="demo-info">
            <small>Demo Admin: admin / admin123</small>
        </div>
    </div>
</body>
</html>
