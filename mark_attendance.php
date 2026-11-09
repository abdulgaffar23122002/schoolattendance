<?php
session_start();
include 'db.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if(isset($_POST['submit_attendance'])) {
    $date = $_POST['date'];
    $attendance = $_POST['attendance'];
    
    foreach($attendance as $student_id => $status) {
        $check = $conn->prepare("SELECT id FROM attendance WHERE student_id = ? AND date = ?");
        $check->execute([$student_id, $date]);
        if($check->rowCount() > 0) {
            $update = $conn->prepare("UPDATE attendance SET status = ? WHERE student_id = ? AND date = ?");
            $update->execute([$status, $student_id, $date]);
        } else {
            $insert = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
            $insert->execute([$student_id, $date, $status]);
        }
    }
    $msg = "Attendance saved successfully!";
}

$students = $conn->query("SELECT * FROM students ORDER BY roll_no")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar shadow">
        <div class="nav-brand">Attendance System</div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="mark_attendance.php" class="active">Mark Attendance</a>
            <a href="view_attendance.php">View Reports</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>
    <div class="container mt-5 card">
        <h2>Mark Attendance</h2>
        <?php if(isset($msg)) { echo "<div class='alert success'>$msg</div>"; } ?>
        <form method="POST">
            <div class="form-group" style="max-width: 250px;">
                <label>Date</label>
                <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($students as $s): ?>
                    <tr>
                        <td><?= $s['roll_no'] ?></td>
                        <td><?= htmlspecialchars($s['name']) ?></td>
                        <td>
                            <label class="radio-inline"><input type="radio" name="attendance[<?= $s['id'] ?>]" value="Present" required> Present</label>
                            <label class="radio-inline"><input type="radio" name="attendance[<?= $s['id'] ?>]" value="Absent" required> Absent</label>
                            <label class="radio-inline"><input type="radio" name="attendance[<?= $s['id'] ?>]" value="Leave" required> Leave</label>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" name="submit_attendance" class="btn btn-primary mt-3">Save Attendance</button>
        </form>
    </div>
</body>
</html>
