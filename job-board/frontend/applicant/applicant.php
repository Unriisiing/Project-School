<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'applicant') {
    header("Location: ../../frontend/home.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Applicant Page</title>
        <script src="../../frontend/script/script.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYVVCOPaADxxzmr_uBNiebhHVLDzA3RuA&callback=initMap" async defer></script>
    </head>
<body>

<form action="../applicant/applicant_profile.php" method="post">
    <input type="submit" value="Go to Applicant Profile">
</form>

<?php
include '../../backend/db/db.php';

$sql = "SELECT u.profile_img, a.*, c.address    
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

            $advertisement_id = $row['ad_id'];
            $user_id = $_SESSION['user_id'];

            $check_sql = "SELECT * FROM job_applications WHERE ad_id = '$advertisement_id' AND user_id = '$user_id'";
            $check_result = $conn->query($check_sql);

            //seulement si connecté
            if ($check_result->num_rows > 0) {
                echo "<p>You have already applied to this ad.</p>";
            } else {

                echo "<form action='../../backend/applicant/apply/apply.php' method='post' onsubmit='return confirmApply()'>";
                echo "<input type='hidden' name='ad_id' value='" . $row['ad_id'] . "'>";
                echo "<input type='submit' name='apply' value='Apply'>";
                echo "</form>";
                
            }
            echo "</div>";
        }
    } else {
        echo "0 results";
    }

    ?>
  <?php include '../../../../first-commit/frontend/default/footer.php' ?>

</body>
</html>

<form action="../../backend/auth/logout.php" method="post">
        <input type="submit" name="logout" value="Logout">
</form>