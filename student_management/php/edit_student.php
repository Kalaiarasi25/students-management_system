<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.html");
    exit();
}
include 'db_connect.php';

// Update Student Details
if (isset($_POST['update_student'])) {
    $id = $_POST['id'];
    $attendance = $_POST['attendance'];
    $marks = $_POST['marks'];
    
    $stmt = $conn->prepare("UPDATE students SET attendance_percentage = ?, marks = ? WHERE id = ?");
    $stmt->bind_param("dii", $attendance, $marks, $id);
    $stmt->execute();
    header("Location: manage_students.php");
}

// Get Student Info
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
} else {
    header("Location: manage_students.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Edit Student</h1>
            <a href="manage_students.php" class="back-btn">Back</a>
        </header>
        
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $student['id'] ?>">
            <p><strong>Name:</strong> <?= $student['name'] ?></p>
            <p><strong>Email:</strong> <?= $student['email'] ?></p>
            <label>Attendance Percentage:</label>
            <input type="number" name="attendance" value="<?= $student['attendance_percentage'] ?>" required>
            <label>Marks:</label>
            <input type="number" name="marks" value="<?= $student['marks'] ?>" required>
            <button type="submit" name="update_student">Update Student</button>
        </form>
    </div>
</body>
</html>