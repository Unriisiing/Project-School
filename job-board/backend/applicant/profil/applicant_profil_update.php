<?php
session_start();
include '../../../backend/db/db.php';

if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: ../../frontend/homepage/home.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $cv = $_POST['cv'];

    $sql_update = "UPDATE user SET first_name='$first_name', last_name='$last_name', email='$email', cv='$cv' WHERE user_id=$user_id";
    if ($conn->query($sql_update) === TRUE) {
        echo "Profile updated successfully";
        header("Location: ../../../frontend/applicant/applicant_profile.php");
    } else {
        echo "Error updating profile: " . $conn->error;
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
                echo "Profile image updated successfully";
            } else {
                echo "Error updating profile image: " . $conn->error;
            }
        } else {
            echo "Error uploading file";
        }
    }
}
?>
