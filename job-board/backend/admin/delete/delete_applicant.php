<?php
session_start();
include '../../../backend/db/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrator') {
    header("Location: ../../frontend/pages/home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $sql_delete_applications = "DELETE FROM job_applications WHERE user_id = $user_id";
    $conn->query($sql_delete_applications);

    $sql_delete_user = "DELETE FROM user WHERE user_id = $user_id";
    if ($conn->query($sql_delete_user) === TRUE) {
        header("Location: ../../../frontend/test/admin/admin.php");
    } else {
        echo "Error deleting applicant: " . $conn->error;
    }
}

$conn->close();
?>
