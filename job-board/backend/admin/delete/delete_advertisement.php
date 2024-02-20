<?php
session_start();
include '../../../backend/db/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrator') {
    header("Location: ../../frontend/pages/home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ad_id'])) {
    $ad_id = $_GET['ad_id'];

    $sql_delete_applications = "DELETE FROM job_applications WHERE ad_id = $ad_id";
    $conn->query($sql_delete_applications);

    $sql_delete_advertisement = "DELETE FROM advertisements WHERE ad_id = $ad_id";
    if ($conn->query($sql_delete_advertisement) === TRUE) {
        header("Location: ../../../frontend/test/admin/admin.php");
    } else {
        echo "Error deleting advertisement: " . $conn->error;
    }
}

$conn->close();
