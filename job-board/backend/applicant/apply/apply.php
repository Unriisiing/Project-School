<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['apply'])) {
    
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'applicant') {
        header("Location: ../../frontend/homepage/home.php");
        exit();
    }

    
    $ad_id = $_POST['ad_id'];
    $user_id = $_SESSION['user_id']; 

    
    include '../../../backend/db/db.php';

    $sql = "INSERT INTO job_applications (ad_id, user_id, application_date) VALUES ('$ad_id', '$user_id', NOW())";

    if ($conn->query($sql) === TRUE) {
      
        header("Location:../../frontend/applicant/applicant.php");
        exit();
    } else {
       
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: ../../frontend/homepage/home.php");
    exit();
}
?>