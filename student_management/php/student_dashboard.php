<?php
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: ../index.html");
    exit();
}
include 'db_connect.php';

$email = $_SESSION['student'];
$stmt = $conn->prepare("SELECT students.name, students.attendance_percentage, students.marks, departments.name AS department FROM students JOIN departments ON students.department_id = departments.id WHERE students.email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

$courses = $conn->prepare("SELECT courses.name FROM courses JOIN departments ON courses.department_id = departments.id WHERE departments.name = ?");
$courses->bind_param("s", $student['department']);
$courses->execute();
$courses_result = $courses->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Welcome, <?= $student['name'] ?></h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </header>
        
        <div class="student-info">
            <p><strong>Department:</strong> <?= $student['department'] ?></p>
            <p><strong>Attendance:</strong> <?= $student['attendance_percentage'] ?>%</p>
            <p><strong>Marks:</strong> <?= $student['marks'] ?></p>
        </div>
        
        <div class="course-list">
            <h2>Your Courses</h2>
            <ul>
                <?php while ($row = $courses_result->fetch_assoc()): ?>
                    <li><?= $row['name'] ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</body>
</html>