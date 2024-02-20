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


// Récupérer les annonces de l'annonceur à partir de la base de données
$sql_advertisements = "SELECT u.profile_img, c.name, a.* FROM advertisements a
JOIN companies c ON a.company_id = c.company_id
JOIN user u ON c.user_id = u.user_id
WHERE c.user_id = $user_id";
$result_advertisements = $conn->query($sql_advertisements);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYVVCOPaADxxzmr_uBNiebhHVLDzA3RuA&callback=initMap" async defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">   
    <title>Job Hunt</title>
    <link rel="stylesheet" href="../css/advertiserProfile.css">
    <style>

        .popup {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            z-index: 9999;
            opacity: 0.8; /* Ajouter une opacité pour le rendre un peu transparent */
        }
    </style>
</head>


<body>
    
    <?php include '../default/header.php' ?>

    <div class="content-container">
        <div class="filter-section">
            <h2>Vos infos</h2>
            <form method="post" action="../../backend/advertiser/profile/advertiser_profile_update.php">
                <!-- Champs pour les informations de l'utilisateur -->
                <label for="first_name">Prénom:</label><br>
                <input type="text" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>"
                    required><br>
                <label for="last_name">Nom de famille:</label><br>
                <input type="text" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>"
                    required><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>

                <label for="profile_img">Image de profil:</label><br>
                <img src="<?php echo $user['profile_img']; ?>" alt="Profile Image"><br>
                <input type="file" id="profile_img" name="profile_img"><br><br>

                <!-- Champs pour les informations de la société -->
                <label for="company_name">Nom de la société:</label><br>
                <input type="text" id="company_name" name="company_name" value="<?php echo $companyData['name']; ?>" required><br>
                <label for="company_address">Adresse de la société:</label><br>
                <input type="text" id="company_address" name="company_address" value="<?php echo $companyData['address']; ?>" required><br>

                <input type="submit" value="Mettre à jour le profil">
            </form>
        </div>

        <div class="ads-section">
        <h2 style='width: 100%; height:auto; top: -10px; right: -10px;'> Vos annonces! </h2>   
            <?php
             if ($result_advertisements->num_rows > 0) {
                while ($row = $result_advertisements->fetch_assoc()) {
            ?>
                    <div class="card">
                        <div class="info-box">
                            <h3>Entreprise : <?php echo $row["name"]; ?></h3>
                            <h2>Titre : <?php echo $row["title"]; ?></h2>
                            <p>Description : <?php echo $row["description"]; ?></p>
                            <div class="button-container">
                                <a href='../../backend/advertiser/view/view_applicants.php?ad_id=<?php echo $row["ad_id"]; ?>'
                                    class='view-button'>View</a>
                                <a href='../advertiser/advertiser_edit_ad.php?ad_id=<?php echo $row["ad_id"]; ?>' class='edit-button'>Edit</a>
                            </div>

                            <button class="learn-more">Learn More</button>
                        </div>

                        <div class="additional-info" style="display: none; position: relative;">
                            <div class="info">
                                <h3>Titre : <?php echo $row["title"]; ?></h3>
                                <p>Description : <?php echo $row["description"]; ?></p>
                                <p>Domaine : <?php echo $row["domain"]; ?></p>
                                <p>Salaire : <?php echo $row["salary"]; ?> euros</p>
                                <p>Contenus : <?php echo $row["content"]; ?></p>
                                <p>Type de contrat : <?php echo $row["job_type"]; ?></p>
                                <p>Date de publication : <?php echo $row["publication_date"]; ?></p>
                                <div class="button-container">
                                    <a href='../../backend/advertiser/view/view_applicants.php?ad_id=<?php echo $row["ad_id"]; ?>'
                                        class='view-button'>View</a>
                                    <a href='advertiser_edit_ad.php?ad_id=<?php echo $row["ad_id"]; ?>' class='edit-button'>Edit</a>
                                </div>


                            </div>

                            <div class="map-box">
                                
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

    <script>
        

    const urlParams = new URLSearchParams(window.location.search);
    const profileUpdated = urlParams.get('profile_updated');
    const companyUpdated = urlParams.get('company_updated');
    const profileImgUpdated = urlParams.get('profile_img_updated');
    const uploadError = urlParams.get('upload_error');

    // Afficher le popup en fonction de l'état de la mise à jour du profil
    if (profileUpdated === 'true') {
        showPopup('Profil mis à jour avec succès', 'green');
    } else if (profileUpdated === 'false') {
        showPopup('Erreur lors de la mise à jour du profil', 'red');
    }

    if (companyUpdated === 'true') {
        showPopup('Informations de l\'entreprise mises à jour avec succès', 'green');
    } else if (companyUpdated === 'false') {
        showPopup('Erreur lors de la mise à jour des informations de l\'entreprise', 'red');
    }

    if (profileImgUpdated === 'true') {
        showPopup('Image de profil mise à jour avec succès', 'green');
    } else if (profileImgUpdated === 'false') {
        showPopup('Erreur lors de la mise à jour de l\'image de profil', 'red');
    }

    if (uploadError === 'true') {
        showPopup('Erreur lors du téléchargement du fichier', 'red');
    }

// Fonction pour afficher le popup
function showPopup(message, color) {
    const popup = document.createElement('div');
    popup.classList.add('popup');
    popup.style.backgroundColor = color;
    popup.textContent = message;
    
    // Ajout de la div popup au body
    document.body.appendChild(popup);

    // Supprimer la div popup après 3 secondes
    setTimeout(() => {
        document.body.removeChild(popup);
    }, 3000);
}


    </script>
    <?php include '../../../../first-commit/frontend/default/footer.php' ?>

</body>

</html>