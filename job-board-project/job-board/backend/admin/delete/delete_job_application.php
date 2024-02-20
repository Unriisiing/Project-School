<?php
session_start();
include '../../../backend/db/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrator') {
    header("Location: ../../frontend/pages/home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['application_id'])) {
    $application_id = $_GET['application_id'];

    // Step 1: Delete the job application
    $sql_delete_application = "DELETE FROM job_applications WHERE application_id = $application_id";
    if ($conn->query($sql_delete_application) === TRUE) {
        echo "Job application deleted successfully";
    } else {
        echo "Error deleting job application: " . $conn->error;
    }
}

$conn->close();
?>
