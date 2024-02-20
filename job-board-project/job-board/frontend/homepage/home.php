<?php
session_start();

echo (var_dump($_SESSION));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../css/index.css">
    <script src="../script/script.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYVVCOPaADxxzmr_uBNiebhHVLDzA3RuA&callback=initMap" async defer></script>

</head>
<body>
    <?php include '../default/header.php' ?>

    <button onclick="window.location.href='../../frontend/auth/register.php'">Register</button>

    <div id="apply-popup" class="popup" style="display:none;">
        <div class="popup-tout">
            <div class="popup-content" id="applyFormContainer"></div>
        </div>
    </div>
    
<?php
    include '../../backend/db/db.php';

    $sql = "SELECT u.profile_img, a.*, c.address    
            FROM advertisements a
            JOIN companies c ON a.company_id = c.company_id
            JOIN user u ON c.user_id = u.user_id;";
    $result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { 

        $advertisement_id = $row['ad_id'];

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

        // Vérifier si l'utilisateur est connecté en tant qu'advertiser et si la company ID correspond
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'advertiser' && isset($_SESSION['company_id']) && $row['company_id'] == $_SESSION['company_id']) {
            echo "<a href='editAd.php?ad_id=" . $row["ad_id"] . "'>Edit</a>";
        }

        //check si user est co pour bouton apply et si il a déja postulé
        if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != "") {
            $user_id = $_SESSION['user_id'];

            $check_sql = "SELECT * FROM job_applications WHERE ad_id = '$advertisement_id' AND user_id = '$user_id'";
            $check_result = $conn->query($check_sql);
            if ($check_result->num_rows > 0) {
                echo "<p>You have already applied to this ad.</p>";} 
                else {
                    echo "<form action='../BackEnd/candidate/applyLog.php' method='post' onsubmit='return confirmApply()'>";
                    echo "<input type='hidden' name='ad_id' value='" . $row['ad_id'] . "'>";
                    echo "<input type='submit' name='apply' value='Apply'>";
                    echo "</form>";
                }

                }   
            else {
                $buttonText = "Postulez(déco)";
                echo "<button class='apply-button' data-adid='" . $row['ad_id'] . "' onclick='displayApplyPopup(" . $row['ad_id'] . ")'>" . $buttonText . "</button>";
        }

        echo "</div>";
    }
} else {
    echo "0 results";
}
?>

<script src="../script/script.js"></script>

