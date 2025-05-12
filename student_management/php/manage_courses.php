<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.html");
    exit();
}
include 'db_connect.php';

// Add Course
if (isset($_POST['add_course'])) {
    $name = $_POST['name'];
    $department_id = $_POST['department_id'];
    $stmt = $conn->prepare("INSERT INTO courses (name, department_id) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $department_id);
    $stmt->execute();
    header("Location: manage_courses.php");
}

// Delete Course
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_courses.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Manage Courses</h1>
            <a href="admin_dashboard.php" class="back-btn">Back</a>
        </header>
        
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Course Name" required>
            <select name="department_id" required>
                <option value="">Select Department</option>
                <?php
                $result = $conn->query("SELECT * FROM departments");
                while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="add_course">Add Course</button>
        </form>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Action</th>
            </tr>
            <?php
            $result = $conn->query("SELECT courses.id, courses.name, departments.name AS department FROM courses JOIN departments ON courses.department_id = departments.id");
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['department'] ?></td>
                    <td>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
