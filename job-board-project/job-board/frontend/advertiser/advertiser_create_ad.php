<?php 
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'advertiser') {
    header("Location: ../homepage/home.php");
    exit();
}

if (isset($_SESSION['companyData']['company_id'])) {
    $_SESSION['company_id'] = $_SESSION['companyData']['company_id'];
} else {
    echo "La clé 'company_id' n'est pas définie dans la session.";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Add</title>
    <link rel="stylesheet" href="create.css">
</head>

<body>
    <?php include '../default/header.php' ?>
    <h2>Add Advertisement</h2>

    <form action="../../backend/advertiser/crud/createAd.php" method="post">

        <input type="hidden" name="company_id" value="<?php echo $_SESSION['company_id']; ?>">

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea><br>

        <label for="start_of_contract">Start of Contract:</label>
        <input type="date" id="start_of_contract" name="start_of_contract" required><br>

        <label for="salary">Salary:</label>
        <input type="text" id="salary" name="salary" required><br>

        <label for="domain">Domain:</label>
        <input type="text" id="domain" name="domain" required><br>

        <label for="job_type">Job Type:</label>
        <select id="job_type" name="job_type" required>
            <option value="CDD">CDD</option>
            <option value="CDI">CDI</option>
            <option value="Alternance">Alternance</option>
            <option value="Stage">Stage</option>
        </select><br>

        <input type="submit" value="Add Advertisement">
    </form>
    <?php include '../../../../first-commit/frontend/default/footer.php' ?>

</body>

</html>
