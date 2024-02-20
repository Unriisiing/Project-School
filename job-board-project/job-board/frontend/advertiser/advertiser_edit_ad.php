<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'advertiser') {
    header("Location: ../../frontend/pages/index.php");
    exit();
}

include '../../backend/db/db.php';

if (isset($_GET['ad_id'])) {
    $adId = $_GET['ad_id'];
    $sql = "SELECT * FROM advertisements WHERE ad_id = $adId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $companyId = $row['company_id'];

        $companySql = "SELECT * FROM companies WHERE company_id = $companyId";
        $companyResult = $conn->query($companySql);

        if ($companyResult->num_rows == 1) {
            $companyRow = $companyResult->fetch_assoc();

            if ($_SESSION['user_id'] != $companyRow['user_id']) {
                header("Location: ../../frontend/homepage/index.php");
                exit();
            }
        } else {
            echo "Company not found for ID: $companyId";
            exit();
        }

        $title = $row['title'];
        $description = $row['description'];
        $content = $row['content'];
        $start_of_contract = $row['start_of_contract'];
        $salary = $row['salary'];
        $domain = $row['domain'];
        $job_type = $row['job_type'];

    } else {
        echo "Advertisement not found for ID: $adId";
        exit();
    }
} else {
    echo "No ad_id parameter provided in the URL.";
    exit();
}

// Reste du code inchangé


// Reste du code inchangé


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Update the advertisement in the database
    $sql = "UPDATE advertisements SET title='$title', description='$description', content='$content', start_date='$start_date', end_date='$end_date' WHERE ad_id=$adId";
    if ($conn->query($sql) === TRUE) {
        echo "Advertisement updated successfully.";
    } else {
        echo "Error updating advertisement: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Add</title>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    h1 {
        margin: 20px 0;
        color: purple;
    }

    form {
        width: 300px;
        margin: 20px 0;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    label,
    input {
        display: block;
        margin-bottom: 10px;
    }

    input {
        width: calc(100% - 20px);
        padding: 5px 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        width: 100%;
        background-color: purple;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 10px;
        font-size: 16px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: purple;
    }

    select {
        font-family: 'Poppins', sans-serif; /* Use the Poppins font */
        font-size: 16px; /* Adjust the font size */
        padding: 8px; /* Add some padding for better appearance */
        border: 1px solid #ccc; /* Add a border */
        border-radius: 5px; /* Add rounded corners */
        width: 100%; /* Make it full-width */
        box-sizing: border-box; /* Ensure padding and border are included in the width */
        margin-bottom: 10px;
    }

    /* CSS for the options within the select element */
    select option {
        font-family: 'Poppins', sans-serif; /* Use the Poppins font */
        font-size: 16px; /* Adjust the font size */
    }

    a.back-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: purple;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 10px;
        font-family: 'Poppins', sans-serif;
        font-weight: bold;
    }

    a.back-button:hover {
        background-color: #800080;
    }

    .update-message {
        color: green;
        font-weight: bold;
    }

    </style>
</head>

<body>
    <?php include '../default/header.php' ?>

    <h1>Edit Advertisement</h1>

    <form action="../../../../first-commit/backend/advertiser/crud/editAd.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $description; ?></textarea><br>

        <label for="content">Content:</label>
        <textarea id="content" name="content" required><?php echo $content; ?></textarea><br>

        <label for="start_of_contract">Start of Contract:</label>
        <input type="date" id="start_of_contract" name="start_of_contract" value="<?php echo $start_of_contract; ?>" required><br>

        <label for="salary">Salary:</label>
        <input type="text" id="salary" name="salary" value="<?php echo $salary; ?>" required><br>

        <label for="domain">Domain:</label>
        <input type="text" id="domain" name="domain" value="<?php echo $domain; ?>" required><br>

        <label for="job_type">Job Type:</label>
        <select id="job_type" name="job_type" required>
            <option value="CDD">CDD</option>
            <option value="CDI">CDI</option>
            <option value="Alternance">Alternance</option>
            <option value="Stage">Stage</option>
        </select><br>

        <input type="submit" value="Save Changes">
    </form>
    <?php include '../../../../first-commit/frontend/default/footer.php' ?>

</body>

</html>
