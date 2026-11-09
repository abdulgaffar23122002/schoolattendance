<?php
session_start();
include 'db.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$stmt = $conn->prepare("SELECT s.roll_no, s.name, a.status FROM students s LEFT JOIN attendance a ON s.id = a.student_id AND a.date = ? ORDER BY s.roll_no");
$stmt->execute([$date]);
$records = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Attendance</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar shadow">
        <div class="nav-brand">Attendance System</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="mark_attendance.php">Mark Attendance</a>
            <a href="view_attendance.php" class="active">View Reports</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>
    <div class="container mt-5 card">
        <h2>View Attendance</h2>
        <form method="GET" class="filter-form mb-4">
            <div class="form-group mb-0" style="display:inline-block; width:auto; margin-right:10px;">
                <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($date) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Roll No</th>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($records as $r): ?>
                <tr>
                    <td><?= $r['roll_no'] ?></td>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td>
                        <?php 
                        if($r['status'] == 'Present') echo "<span class='badge present'>Present</span>";
                        elseif($r['status'] == 'Absent') echo "<span class='badge absent'>Absent</span>";
                        elseif($r['status'] == 'Leave') echo "<span class='badge leave'>Leave</span>";
                        else echo "<span class='badge text-muted'>Not Marked</span>";
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
