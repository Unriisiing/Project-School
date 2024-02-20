<?php
include '../../../backend/db/db.php';

$user_id = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name']; 
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $profile_picture = $_POST['profile_img'];

    $sql_update = "UPDATE user SET 
        first_name = '$first_name', 
        last_name = '$last_name', 
        email = '$email', 
        role = '$role', 
        profile_img = '$profile_img' 
        WHERE user_id = $user_id";

    if ($conn->query($sql_update) === TRUE) {
        // Record updated successfully, redirect to the edit page with user_id
        echo "<script>
            window.location.href = 'http://localhost/first-commit/backend/admin/edit/edit_advertiser.php?user_id=$user_id';
        </script>";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Check if user_id is set
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Query the database to get advertiser information
    $sql = "SELECT * FROM user WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "User not found";
        // You may want to handle this case differently
    }
} else {
    echo "User ID not provided";
    // You may want to handle this case differently
}

?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="edit.css">
    <title>Edit Advertiser</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<h1>Edit Advertiser</h1>
<a class="back-button" href="../admin.php">Back to Admin Page</a>

<form action="http://localhost/first-commit/backend/admin/edit/edit_advertiser.php" method="post">
    <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
    <label for="first_name">First Name :</label>
    <input type="text" id="first_name" name="first_name" value="<?= $row['first_name'] ?>"><br>
    <label for="last_name">Last Name :</label>
    <input type="text" id="last_name" name="last_name" value="<?= $row['last_name'] ?>"><br>
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" value="<?= $row['email'] ?>"><br>
    <label for="role">Role:</label>
    <select id="role" name="role">
        <option value="applicant" <?php if ($row['role'] === 'applicant') echo 'selected'; ?>>Applicant</option>
        <option value="advertiser" <?php if ($row['role'] === 'advertiser') echo 'selected'; ?>>Advertiser</option>
    </select><br>
    <label for="profile_picture">Profile Picture URL:</label>
    <input type="text" id="profile_picture" name="profile_picture" value="<?= $row['profile_img'] ?>"><br>

    <input type="submit" value="Save Changes">
</form>


</body>
</html>
