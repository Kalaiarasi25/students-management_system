<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM students WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $student = $result->fetch_assoc();
        if ($password === $student['password']) { // Passwords should be hashed
            $_SESSION['student'] = $student['email'];
            header("Location: student_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid Password!'); window.location.href='../index.html';</script>";
        }
    } else {
        echo "<script>alert('Student not found!'); window.location.href='../index.html';</script>";
    }
    
    $stmt->close();
}
?>