<?php
session_start();
include '../../backend/db/db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Récupérer les informations de l'utilisateur à partir de la base de données
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT * FROM user WHERE user_id = $user_id";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
}

// Récupérer les publicités auxquelles l'utilisateur a postulé
$sql_applications = "SELECT advertisements.title, advertisements.description, companies.address 
                    FROM advertisements 
                    JOIN job_applications ON advertisements.ad_id = job_applications.ad_id 
                    JOIN companies ON advertisements.company_id = companies.company_id 
                    WHERE job_applications.user_id = $user_id";
$result_applications = $conn->query($sql_applications);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYVVCOPaADxxzmr_uBNiebhHVLDzA3RuA&callback=initMap" async defer></script>
    <link rel="stylesheet" href="../css/profile.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">  
    <title>User Profile</title>
    <style>
        .popup {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px;
            border-radius: 5px;
            color: white;
            display: block;
            z-index: 9999;
            opacity: 0.8;
            background-color: rgba(0, 255, 0, 0.8); /* Vert */
        }
    </style>
</head>

<body>
    <?php include '../default/header.php';

    $sql = "SELECT * ,c.address , c.name
    FROM advertisements a
    JOIN companies c ON a.company_id = c.company_id";
    $result = $conn->query($sql);
    ?>
    

    <div class="content-container">
        <div class="filter-section">
            <!-- Ajoutez vos options de filtre ici -->
            <h2>Vos infos</h2>
            <form method="post" action="../../backend/applicant/profil/applicant_profil_update.php">
                <label for="first_name">First Name:</label><br>
                <input type="text" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required><br>
                <label for="last_name">Last Name:</label><br>
                <input type="text" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>
                <label for="cv">Curriculum Vitae:</label><br>
                <?php
                if (!empty($user['cv'])) {
                    echo "<a href='" . $user['cv'] . "' target='_blank'>Voir</a><br>";
                } else {
                    echo "Vous n'avez pas de CV! <br>";
                }
                ?>
                <label for="cv_file">Upload New CV:</label><br>
                <input type="file" id="cv_file" name="cv_file"><br><br>

                <label for="profile_img">Profile Image:</label><br>
                <img src="<?php echo $user['profile_img']; ?>" alt="Profile Image"><br>
                <input type="file" id="profile_img" name="profile_img"><br><br>
                <input type="submit" value="Update Profile">
            </form>
        </div>

        <div class="ads-section">
        <h2 style='width: 100%; top: -10px; right: -10px;'> Vous avez postulé à: </h2>   
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="card">
                        <div class="info-box">
                            <h3>Entreprise : <?php echo $row["name"]; ?></h3>
                            <h2>Titre : <?php echo $row["title"]; ?></h2>
                            <p>Description : <?php echo $row["description"]; ?></p>

                            <button class="learn-more">Learn More</button>
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

    <script src="../script/script.js"></script>
    <script src="../script/index.js"></script>
    <?php include '../../../../first-commit/frontend/default/footer.php' ?>

</body>

</html>
