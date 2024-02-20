<?php
session_start();
include '../../db/db.php';

if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    // Mise à jour des informations de l'utilisateur
    $sql_update = "UPDATE user SET first_name='$first_name', last_name='$last_name', email='$email' WHERE user_id=$user_id";
    if ($conn->query($sql_update) === TRUE) {
        // echo "Profile updated successfully";
        header("Location: ../../../frontend/advertiser/advertiser_profile.php?profile_updated=true");
    } else {
        // echo "Error updating profile: " . $conn->error;
        header("Location: ../../../frontend/advertiser/advertiser_profile.php?profile_updated=false");
    }

    // Mise à jour des informations de la société
    $company_name = $_POST['company_name'];
    $company_address = $_POST['company_address'];

    $sql_update_company = "UPDATE companies SET name='$company_name', address='$company_address' WHERE user_id=$user_id";
    if ($conn->query($sql_update_company) === TRUE) {
        // echo "Company information updated successfully";
        header("Location: ../../../frontend/advertiser/advertiser_profile.php?company_updated=true");
    } else {
        // echo "Error updating company information: " . $conn->error;
        header("Location: ../../../frontend/advertiser/advertiser_profile.php?company_updated=false");
    }

    if(isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['profile_img']['name'];
        $file_tmp = $_FILES['profile_img']['tmp_name'];
        $file_type = $_FILES['profile_img']['type'];

        $upload_dir = "../../backend/uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            $sql_update_img = "UPDATE user SET profile_img='$upload_dir$file_name' WHERE user_id=$user_id";
            if ($conn->query($sql_update_img) === TRUE) {
                // echo "Profile image updated successfully";
                header("Location: ../../../frontend/advertiser/advertiser_profile.php?profile_img_updated=true");
            } else {
                // echo "Error updating profile image: " . $conn->error;
                header("Location: ../../../frontend/advertiser/advertiser_profile.php?profile_img_updated=false");
            }
        } else {
            // echo "Error uploading file";
            header("Location: ../../../frontend/advertiser/advertiser_profile.php?upload_error=true");
        }
    }
}
?>
