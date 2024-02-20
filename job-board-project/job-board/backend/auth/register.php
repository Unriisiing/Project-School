<?php
include '../../backend/db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_pwd = md5($_POST['password']);
    $role = $_POST['role'];

    $check_sql = "SELECT * FROM user WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        
        echo "Email address already in use. Please choose a different one.";
    } else {
       
        if(isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
            $file_tmp_name = $_FILES['profile_img']['tmp_name'];
            $file_name = $_FILES['profile_img']['name'];
        
            if (move_uploaded_file($file_tmp_name, "../../backend/uploads/" . $file_name)) {
                $profile_img = "../../backend/uploads/" . $file_name;
                echo "File uploaded successfully.";
            } else {
                echo "Error moving file.";
            }
        } else {
            
            $profile_img = ""; 

        $sql_user = "INSERT INTO user (first_name, last_name, email, password, role, profile_img) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("ssssss", $first_name, $last_name, $email, $hashed_pwd, $role, $profile_img);

        if ($stmt_user->execute()) {
           
            $user_id = $stmt_user->insert_id;

            if ($role == "advertiser") {
                $company_name = $_POST['company_name'];
                $address = $_POST['address'];
                $contact_email = $_POST['contact_email'];

                
                $sql_company = "INSERT INTO companies (name, address, contact_email, user_id) VALUES (?, ?, ?, ?)";
                $stmt_company = $conn->prepare($sql_company);
                $stmt_company->bind_param("sssi", $company_name, $address, $contact_email, $user_id);

                if ($stmt_company->execute()) {
                    echo "User and Company registered successfully";
                } else {
                    echo "Error: " . $sql_company . "<br>" . $conn->error;
                }

            
                $stmt_company->close();
            } else {
                echo "User registered successfully";
            }
        } else {
            echo "Error: " . $sql_user . "<br>" . $conn->error;
        }

        $stmt_user->close();
    }

    $check_stmt->close();
    $conn->close();
}
}
?>
