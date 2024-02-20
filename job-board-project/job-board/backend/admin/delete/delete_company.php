<?php
include '../../../backend/db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['company_id'])) {
    $company_id = $_GET['company_id'];

    $sql = "DELETE FROM companies WHERE company_id = $company_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../../../frontend/test/admin/admin.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>