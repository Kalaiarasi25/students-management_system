<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.html");
    exit();
}
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Admin Dashboard</h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </header>
        
        <div class="dashboard-menu">
            <a href="manage_departments.php">Manage Departments</a>
            <a href="manage_courses.php">Manage Courses</a>
            <a href="manage_students.php">Manage Students</a>
        </div>
    </div>
</body>
</html>