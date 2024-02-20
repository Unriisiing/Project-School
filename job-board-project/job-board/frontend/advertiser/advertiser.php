<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'advertiser') {
    header("Location: ../../frontend/home.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>

    <title>Advertiser Page</title>
    <script src="../../frontend/script/script.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYVVCOPaADxxzmr_uBNiebhHVLDzA3RuA&callback=initMap" async defer></script>     
    <link rel="stylesheet" href="../../frontend/css/style.css">

</head>
<body>

<?php include '../default/header.php' ?>

    <h1>Welcome, Advertiser!</h1>

    <h1>Advertisements</h1>

    <button onclick="window.location.href='../../frontend/advertiser/advertiser_create_ad.php'">Add Ad</button>
<?php
include '../../backend/db/db.php';
$sql = "SELECT u.profile_img, a.*
        FROM advertisements a
        JOIN companies c ON a.company_id = c.company_id
        JOIN user u ON c.user_id = u.user_id;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        echo "<div class='ad'>";
        echo "<h2>" . $row["title"] . "</h2>";
        echo "<p>" . $row["description"] . "</p>";
        echo "<p>Start of Contract: " . $row["start_of_contract"] . "</p>";
        echo "<p>Salary: " . $row["salary"] . "</p>";
        echo "<p>Domain: " . $row["domain"] . "</p>";
        echo "<p>Job Type: " . $row["job_type"] . "</p>";
        echo "<p>content: " . $row["content"] . "</p>";
        echo "<img src='" . $row["profile_img"] . "' alt='Profile Image'>";
        echo "<div id='map' class='company-map' data-address='" . $row["address"] . "' style='height: 200px;'></div>";
        echo "<a href='../../backend/advertiser/view/view_applicants.php?ad_id=" . $row["ad_id"] . "'>View</a>";
        echo "<a href='../../backend/advertiser/crud/editAd.php?ad_id=" . $row["ad_id"] . "'>Edit</a>";
        echo "<a href='#' onclick='confirmDelete(" . $row["ad_id"] . ")'>Delete</a>";
        echo "</div>";
   
    }
    } else {

        echo "0 results";

    }
?>
    <form action="../../backend/auth/logout.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>

</body>

</html>
