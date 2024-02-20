<?php
session_start();
include '../../backend/db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_pwd = md5($_POST['password']);
    $sql = "SELECT * FROM user WHERE email='$email' AND password='$hashed_pwd'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if ($row['role'] == 'applicant') {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
            header("Location: ../../frontend/homepage/index.php");
            exit();
        } elseif ($row['role'] == 'advertiser') {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
            header("Location: ../../frontend/homepage/index.php");
            exit();
        }elseif ($row['role'] == 'administrator') {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
            header("Location: ../../frontend/admin/admin.php");
            exit();
        }
    } else {
        $error_message = "Invalid email or password. Please try again.";
        header("Location: ../../frontend/auth/login.php?error=" . urlencode($error_message));
    }
}
?>