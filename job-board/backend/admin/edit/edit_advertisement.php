<?php
include '../../../backend/db/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ad_id'])) {
    $ad_id = $_POST['ad_id'];
    $title = $_POST['title']; 
    $description = $_POST['description']; 
    $publication_date = $_POST['publication_date']; 
    $start_of_contract = $_POST['start_of_contract']; 
    $content = $_POST['content']; 
    $name = $_POST['name']; 
    $salary = $_POST['salary']; 
    $job_type = $_POST['job_type']; 
    $domain = $_POST['domain']; 

    $sql_update = "UPDATE advertisements SET 
                    title = '$title', 
                    publication_date = '$publication_date', 
                    start_of_contract = '$start_of_contract', 
                    content = '$content', 
                    salary = '$salary', 
                    description = '$description',
                    job_type = '$job_type',
                    domain = '$domain' 
                    WHERE ad_id = $ad_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>
            window.location.href = 'http://localhost/first-commit/backend/admin/edit/edit_advertisement.php?ad_id=$ad_id';
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ad_id'])) {
    $ad_id = $_GET['ad_id'];

    $sql = "SELECT * FROM advertisements WHERE ad_id = $ad_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
    } else {
        echo "Advertisement not found";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="edit.css">
    <title>Edit Advertisement</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<h1>Edit Advertisement</h1>
<a class="back-button" href="../admin.php">Back to Admin Page</a>

<form action="http://localhost/first-commit/backend/admin/edit/edit_advertisement.php" method="post">
    <input type="hidden" name="ad_id" value="<?= $row['ad_id'] ?>">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?= $row['title'] ?>"><br>
    <label for="description">Description:</label>
    <input type="text" id="description" name="description" value="<?= $row['description'] ?>"><br>
    <label for="job_type">Job Type:</label>
    <input type="text" id="job_type" name="job_type" value="<?= $row['job_type'] ?>"><br>
    <label for="publication_date">Publication Date:</label>
    <input type="date" id="publication_date" name="publication_date" value="<?= $row['publication_date'] ?>"><br>
    <label for="start_of_contract">Start of Contract:</label>
    <input type="date" id="start_of_contract" name="start_of_contract" value="<?= $row['start_of_contract'] ?>"><br>
    <label for="content">Content:</label>
    <textarea id="content" name="content"><?= $row['content'] ?></textarea><br>
    <label for="salary">Salary:</label>
    <input type="text" id="salary" name="salary" value="<?= $row['salary'] ?>"><br>
    <label for="domain">Domain:</label>
    <input type="text" id="domain" name="domain" value="<?= $row['domain'] ?>"><br><br>
    <input type="submit" value="Save Changes">
</form>


</body>
</html>