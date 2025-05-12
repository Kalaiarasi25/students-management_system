<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        if ($password === $admin['password']) { // You should hash passwords for security
            $_SESSION['admin'] = $admin['email'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid Password!'); window.location.href='../index.html';</script>";
        }
    } else {
        echo "<script>alert('Admin not found!'); window.location.href='../index.html';</script>";
    }
    
    $stmt->close();
}
?>