<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.html");
    exit();
}
include 'db_connect.php';

// Update Department
if (isset($_POST['update_department'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $stmt = $conn->prepare("UPDATE departments SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    header("Location: manage_departments.php");
}

// Update Course
if (isset($_POST['update_course'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $department_id = $_POST['department_id'];
    $stmt = $conn->prepare("UPDATE courses SET name = ?, department_id = ? WHERE id = ?");
    $stmt->bind_param("sii", $name, $department_id, $id);
    $stmt->execute();
    header("Location: manage_courses.php");
}

// Get Department Details
if (isset($_GET['dept_id'])) {
    $id = $_GET['dept_id'];
    $stmt = $conn->prepare("SELECT * FROM departments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $department = $result->fetch_assoc();
}

// Get Course Details
if (isset($_GET['course_id'])) {
    $id = $_GET['course_id'];
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course/Department</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Edit Details</h1>
            <a href="admin_dashboard.php" class="back-btn">Back</a>
        </header>
        
        <?php if (isset($department)): ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $department['id'] ?>">
            <label>Department Name:</label>
            <input type="text" name="name" value="<?= $department['name'] ?>" required>
            <button type="submit" name="update_department">Update Department</button>
        </form>
        <?php endif; ?>
        
        <?php if (isset($course)): ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $course['id'] ?>">
            <label>Course Name:</label>
            <input type="text" name="name" value="<?= $course['name'] ?>" required>
            <label>Department:</label>
            <select name="department_id" required>
                <?php
                $result = $conn->query("SELECT * FROM departments");
                while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" <?= ($row['id'] == $course['department_id']) ? 'selected' : '' ?>>
                        <?= $row['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="update_course">Update Course</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>