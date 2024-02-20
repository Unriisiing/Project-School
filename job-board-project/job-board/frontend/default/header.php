<header>
    <div class="headerContainer">
        <div class="mainTitle">
            <a href="../../../../first-commit/frontend/homepage/index.php" style="text-decoration: none; color: blueviolet;" >
                <h1>Job Hunt</h1>
            </a>
        </div>

        <nav class="navbarContainer">
            <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == "advertiser"){?>
                <a href="../advertiser/advertiser_create_ad.php">Créer une annonce</a>
            <?php }?>
            <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == "applicant"){?>
                <a href="../applicant/applicant_profile.php">
                <img src="<?php echo $profile_img; ?>" alt="Profile Image" style="width: 30px; height: 30px; border-radius: 50%;">
            </a>
            <?php }?>
            <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == "advertiser"){?>
                <a href="../../../../first-commit/frontend/advertiser/advertiser_profile.php">
                <img src="<?php echo $profile_img; ?>" alt="Profile Image" style="width: 30px; height: 30px; border-radius: 50%;">
            </a>
            <?php }?>
            <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == "administrator"){?>
                <a href="../admin/admin.php">Panel Admin</a>
            <?php }?>

        

            <?php
                $buttonText = (isset($_SESSION['user_id']) && $_SESSION['user_id'] != "") ? "Déconnexion" : "Connexion";
                $buttonAction = (isset($_SESSION['user_id']) && $_SESSION['user_id'] != "") ? "../../../../first-commit/backend/auth/logout.php" : "../auth/logreg/logreg.php";
            ?>
            <a href="<?php echo $buttonAction; ?>">
                <?php echo $buttonText; ?>
            </a>
        </nav>
    </div>
</header>

<style>
    header {
        font-family: Arial, sans-serif;
        background-color: white;
        color: blueviolet;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        width: 100%;
        box-sizing: border-box;
    }

    header h1 {
        margin: 0;
        font-size: 24px;
    }

    .headerContainer {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .mainTitle {
        flex: 1;
    }

    .navbarContainer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .navbarContainer a {
        color: blueviolet;
        text-decoration: none;
        font-size: 18px;
        margin-left: 20px;
    }
</style>
