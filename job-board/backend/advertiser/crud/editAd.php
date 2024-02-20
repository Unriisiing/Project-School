<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'advertiser' || $_SESSION['role'] !== 'administrator') {
    header("Location: ../../../frontend/advertiser/advertiser_profile.php");
    exit();
}

include '../../../backend/db/db.php';

if (isset($_GET['ad_id'])) {
    $adId = $_GET['ad_id'];
    $sql = "SELECT * FROM advertisements WHERE ad_id = $adId";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $description = $row['description'];
        $content = $row['content'];
        $start_of_contract = $row['start_of_contract'];
        $salary = $row['salary'];
        $domain = $row['domain'];
        $job_type = $row['job_type'];
    } else {
        echo "Advertisement not found for ID: $adId";
        exit();
    }
} else {
    echo "No ad_id parameter provided in the URL.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $start_of_contract = $_POST['start_of_contract'];
    $salary = $_POST['salary'];
    $domain = $_POST['domain'];
    $job_type = $_POST['job_type'];

    // Update the advertisement in the database
    $sql = "UPDATE advertisements SET title='$title', description='$description', content='$content', start_of_contract='$start_of_contract', salary='$salary', domain='$domain', job_type='$job_type' WHERE ad_id=$adId";
    if ($conn->query($sql) === TRUE) {
        echo "Advertisement updated successfully.";
    } else {
        echo "Error updating advertisement: " . $conn->error;
    }

    $conn->close();
}
?>
