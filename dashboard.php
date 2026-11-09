<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - School Attendance</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar shadow">
        <div class="nav-brand">Attendance System</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="mark_attendance.php">Mark Attendance</a>
            <a href="view_attendance.php">View Reports</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Welcome to Dashboard</h2>
        <div class="grid-cards">
            <div class="card stat-card">
                <h3>Mark Attendance</h3>
                <p>Record daily presence of students.</p>
                <a href="mark_attendance.php" class="btn btn-primary">Go</a>
            </div>
            <div class="card stat-card">
                <h3>View Records</h3>
                <p>Check past attendance history.</p>
                <a href="view_attendance.php" class="btn btn-primary">Go</a>
            </div>
        </div>
    </div>
</body>
</html>
