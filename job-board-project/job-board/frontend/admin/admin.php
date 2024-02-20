<?php
session_start();
include '../../backend/db/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'administrator') {
    header("Location: ../../frontend/home.php");
    exit();
}

$sql_applicants = "SELECT * FROM user WHERE role='applicant'";
$result_applicants = $conn->query($sql_applicants);

$sql_advertisers = "SELECT * FROM user WHERE role='advertiser'";
$result_advertisers = $conn->query($sql_advertisers);


$sql_companies = "SELECT * FROM companies";
$result_companies = $conn->query($sql_companies);

$sql_applications = "SELECT application_date,j.application_id, j.user_id, j.ad_id, a.title AS ad_title, u.first_name, u.last_name
                    FROM job_applications j
                    JOIN advertisements a ON j.ad_id = a.ad_id
                    JOIN user u ON j.user_id = u.user_id";
$result_job_applications = $conn->query($sql_applications);

$sql_advertisements = "SELECT * FROM advertisements";
$result_advertisements = $conn->query($sql_advertisements);
?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <title>Admin Page</title>
    <link rel="stylesheet" href="admin.css">

    <script src="../admin.js"></script>
</head>

<body>
    <?php include '../../frontend/default/header.php' ?>


    <h1>Welcome, Admin!</h1>

    <div class="container">
        <div class="box">
            <h2>Applicants</h2>
            <?php while ($row = $result_applicants->fetch_assoc()) : ?>
                <div class='user'>
                    <p>Name: <?= $row["first_name"] . " " . $row["last_name"] ?></p>
                    <p>Email: <?= $row["email"] ?></p>
                    <div class="button-container">
                        <?php echo "<a href='#' onclick='confirmDeleteApplicant(" . $row["user_id"] . ")'>Delete</a>";?>
                        <a href="../../backend/admin/edit/edit_applicant.php?user_id=<?= $row["user_id"] ?>">Edit User</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="box">
            <h2>Advertisers</h2>
            <?php while ($row = $result_advertisers->fetch_assoc()) : ?>
                <div class='user'>
                    <p>Name: <?= $row["first_name"] . " " . $row["last_name"] ?></p>
                    <p>Email: <?= $row["email"] ?></p>
                    <div class="button-container">
                    <?php echo "<a href='#' onclick='confirmDeleteAdvertiser(" . $row["user_id"] . ")'>Delete</a>";?>
                        <a href='../../backend/admin/edit/edit_advertiser.php?user_id=<?= $row["user_id"] ?>'>Edit Advertiser</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="box">
            <h2>Companies</h2>
            <?php while ($row = $result_companies->fetch_assoc()) : ?>
                <div class='company'>
                    <p>Name: <?= $row["name"] ?></p>
                    <p>Address: <?= $row["address"] ?></p>
                    <!-- Add more details as needed -->
                    <div class="button-container">
                    <?php echo "<a href='#' onclick='confirmDeleteCompany(" . $row["company_id"] . ")'>Delete</a>";?>
                        <a href="../../backend/admin/edit/edit_company.php?company_id=<?= $row["company_id"] ?>">Edit Company</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="box">
            <h2>Advertisements</h2>
            <?php while ($row = $result_advertisements->fetch_assoc()) : ?>
                <div class='advertisement'>
                    <p>Title: <?= $row["title"] ?></p>
                    <p>Description: <?= $row["description"] ?></p>
                    <div class="button-container">
                        <?php echo "<a href='#' onclick='confirmDeleteAdvertisement(" . $row["ad_id"] . ")'>Delete</a>";?>
                        <a href='../../backend/admin/edit/edit_advertisement.php?ad_id=<?= $row["ad_id"] ?>'>Edit Advertisement</a>
                    </div>
                </div>
            <?php endwhile; ?>  
        </div>
    </div>
    <?php include '../../../../first-commit/frontend/default/footer.php' ?>

</body>

</html>