<?php
include '../../../backend/db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['company_id'])) {
    $company_id = $_POST['company_id'];
    $name = $_POST['name']; 
    $address = $_POST['address'];
    $image = $_POST['image'];
    $contact_email = $_POST['contact_email'];
    // Add more fields if needed
    
    $sql_update = "UPDATE companies 
                   SET name = '$name', address = '$address', image = '$image', contact_email = '$contact_email' 
                   WHERE company_id = $company_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>
            window.location.href = 'http://localhost/first-commit/backend/admin/edit/edit_company.php?company_id=$company_id';
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['company_id'])) {
    $company_id = $_GET['company_id'];

    $sql = "SELECT * FROM companies WHERE company_id = $company_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Company not found";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="edit.css">
    <title>Edit Company</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<h1>Edit Company</h1>
<a class="back-button" href="../admin.php">Back to Admin Page</a>
<form action="http://localhost/first-commit/backend/admin/edit/edit_company.php" method="post">
    <input type="hidden" name="company_id" value="<?= $row['company_id'] ?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= $row['name'] ?>"><br>
    <label for="address">Address:</label>
    <input type="text" id="address" name="address" value="<?= $row['address'] ?>"><br>
    <label for="image">Image:</label>
    <input type="text" id="image" name="image" value="<?= $row['image'] ?>"><br>
    <label for="contact_email">Contact Email:</label>
    <input type="text" id="contact_email" name="contact_email" value="<?= $row['contact_email'] ?>"><br>

    <input type="submit" value="Save Changes">
</form>

</body>
</html>
