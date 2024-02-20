<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'advertiser') {
    header("Location: ../../frontend/pages/home.php");
    exit();
}

include '../../db/db.php';

$advertiser_id = $_SESSION['user_id'];
$ad_id = $_GET['ad_id']; // L'ID de l'annonce doit être passé via l'URL

$sql = "SELECT u.first_name, u.last_name, u.email, ja.notes, u.CV
        FROM job_applications ja
        JOIN advertisements a ON ja.ad_id = a.ad_id
        JOIN companies c ON a.company_id = c.company_id
        JOIN user u ON ja.user_id = u.user_id
        WHERE c.user_id = '$advertiser_id' AND a.ad_id = '$ad_id';";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="view.css">
    <title>View Applicants</title>
</head>
<body>
<?php include '../../../frontend/default/header.php' ?>

<h1>Applicants for Your Job Advertisements</h1>

<div class='applicant-container'>
    <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='applicant'>";
                echo "<p>Name: " . $row["first_name"]. " " . $row["last_name"]. "</p>";
                echo "<p>Email: " . $row["email"]. "</p>";
                echo "<p>Notes: " . $row['notes']. "</p>";
                echo "<p><a href='../uploads/" . $row['CV'] . "' download>Télécharger CV</a></p>";
                echo "</div>";
            }
        } else {
            echo "No logged in applicant found.";
        }

        // Récupérer les candidats non connectés
        $nonLoggedInApplicantsSql = "SELECT * FROM non_logged_in_applicants WHERE ad_id = '$ad_id'";
        $nonLoggedInApplicantsResult = $conn->query($nonLoggedInApplicantsSql);

        if ($nonLoggedInApplicantsResult->num_rows > 0) {
            while ($row = $nonLoggedInApplicantsResult->fetch_assoc()) {
                echo "<div class='applicant'>";
                echo "<p>Name: " . $row["first_name"] . " " . $row["last_name"] . "</p>";
                echo "<p>Email: " . $row["email"] . "</p>";
                echo "<p>Message: " . $row['message'] . "</p>";
                echo "<p><a href='../uploads/" . $row['CV'] . "' download>Télécharger CV</a></p>";
                echo "</div>";
            }
        } else {
            echo "No non-logged-in applicants found.";
        }
    ?>
</div>
    <?php include '../../../../first-commit/frontend/default/footer.php' ?>

</body>
</html>
