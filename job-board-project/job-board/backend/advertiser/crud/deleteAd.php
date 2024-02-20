<?php
include '../../../backend/db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ad_id'])) {
    $adId = $_GET['ad_id'];


    $sql = "DELETE FROM advertisements WHERE ad_id = $adId";

    if ($conn->query($sql) === TRUE) {
   
        echo "Advertisement deleted successfully";
        header("Location: ../../frontend/advertiser/advertiser.php");

    } else {
       
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
  
    echo "Invalid request";
}

$conn->close();
?>