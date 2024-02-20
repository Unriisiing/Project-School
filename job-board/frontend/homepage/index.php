<?php
include '../../backend/db/db.php';
session_start();


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql_user = "SELECT * FROM user WHERE user_id = $user_id";
    $result_user = $conn->query($sql_user);

    if ($result_user->num_rows > 0) {
        $user = $result_user->fetch_assoc();
    }

    // Vérifier si les informations de l'entreprise sont disponibles dans la session
    if (isset($_SESSION['companyData']) && !empty($_SESSION['companyData'])) {
        $companyData = $_SESSION['companyData'];
    } else {
        // Récupérer les informations de l'entreprise à partir de la base de données
        $sql_company = "SELECT * FROM companies WHERE user_id = $user_id";
        $result_company = $conn->query($sql_company);

        if ($result_company->num_rows > 0) {
            $companyData = $result_company->fetch_assoc();
            $_SESSION['companyData'] = $companyData; // Stocker les données de l'entreprise dans la session
        }
    }
}


$sql = "SELECT * ,c.address , c.name
        FROM advertisements a
        JOIN companies c ON a.company_id = c.company_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYVVCOPaADxxzmr_uBNiebhHVLDzA3RuA&callback=initMap" async defer></script>
    <link rel="stylesheet" href="../css/index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">   
    <title>Job Hunt</title>
</head>

<body>
    <?php include '../default/header.php' ?>

    <div id="apply-popup" class="popup" style="display:none;">
        <div class="popup-tout">
            <div class="popup-content" id="applyFormContainer"></div>
        </div>
    </div>

    <div class="content-container">
        <div class="filter-section">
            <?php
                $totalAdsSql = "SELECT COUNT(*) as total_ads FROM advertisements";
                $totalAdsResult = $conn->query($totalAdsSql);
                $totalAdsCount = 0;
                if ($totalAdsResult && $totalAdsResult->num_rows > 0) {
                    $totalAdsCount = $totalAdsResult->fetch_assoc()['total_ads'];
                }
            ?>
            <h2>Filtrez parmi nos <?php echo $totalAdsCount; ?> annonces</h2>
            <form action="" method="get">
                <input type="text" name="search" placeholder="Rechercher...">
                <button type="submit">Rechercher</button>
            </form>
        </div>


        <div class="ads-section">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="card" style="position: relative;">
                        <div class="info-box">
                            <h3>Entreprise : <?php echo $row["name"]; ?></h3>
                            <h2>Titre : <?php echo $row["title"]; ?></h2>
                            <p>Description : <?php echo $row["description"]; ?></p>

                            <button class="learn-more" style='bottom: -10px; right: -10px;'>Learn More</button>
                        </div>

                        <div class="additional-info" style="display: none; position: relative;">
                            <div class="info">
                                <h3>Titre : <?php echo $row["title"]; ?></h3>
                                <p>Description : <?php echo $row["description"]; ?></p>
                                <p>Adresse : <?php echo $row["address"]; ?></p>
                                <p>Domaine : <?php echo $row["domain"]; ?></p>
                                <p>Salaire : <?php echo $row["salary"]; ?> euros</p>
                                <p>Contenus : <?php echo $row["content"]; ?></p>
                                <p>Type de contrat : <?php echo $row["job_type"]; ?></p>
                                <p>Date de publication : <?php echo $row["publication_date"]; ?></p>
                            </div>

                            <div class="map-box">
                                <div id='map' class="company-map" data-address="<?php echo $row["address"]; ?>" style="height: 400px;"></div>
                            </div>
                            
                            <?php
                                if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != "") {
                                    $user_id = $_SESSION['user_id'];
                                    $advertisement_id = $row['ad_id'];

                                    $check_sql = "SELECT * FROM job_applications WHERE ad_id = '$advertisement_id' AND user_id = '$user_id'";
                                    $check_result = $conn->query($check_sql);

                                    if ($check_result->num_rows > 0) {
                                        echo "<p style='color:#ab00ff; position: absolute; bottom: -10px; right: -10px;'>You have already applied to this ad.</p>";
                                    } else {
                                        echo "<form action='../../backend/applicant/apply/apply.php' method='post' onsubmit='return confirmApply()'>";
                                        echo "<input type='hidden' name='ad_id' value='" . $row['ad_id'] . "'>";
                                        echo "<button class='apply-button' type='submit' >";
                                        echo "<i class='bx bx-crosshair'style='color:#ab00ff; position: absolute; bottom: -10px; right: -10px;'></i>";
                                        echo "</button>";
                                        echo "</form>";

                                    }
                                } else {
                                    echo "<button class='apply-button' onclick='displayApplyPopup(" . $row['ad_id'] . ")'><i class='bx bx-crosshair' style='color:#ab00ff; position: absolute; bottom: -10px; right: -10px;'></i></button>";
                                }
                            ?>

                            <i class='bx bx-exit' style='color:#ab00ff; position: absolute; top: -10px; right: -10px;'></i>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "0 results";
            }
            ?>
        </div>
    </div>
    <?php include '../default/footer.php' ?>

    <script src="../script/index.js"></script>
    <script src="../script/script.js"></script>
</body>

</html>