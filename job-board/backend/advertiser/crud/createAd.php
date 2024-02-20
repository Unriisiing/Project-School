<?php
session_start();
include '../../db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $start_of_contract = $_POST['start_of_contract'];
    $salary = $_POST['salary'];
    $domain = $_POST['domain'];
    $job_type = $_POST['job_type'];
    $company_id = $_POST['company_id'];

    $check_company_query = "SELECT * FROM companies WHERE company_id = $company_id";
    $check_company_result = $conn->query($check_company_query);
    if ($check_company_result->num_rows == 0) {
        echo "La company_id n'existe pas dans la base de données.";
        exit();
    }

    // Get the current date for publication date
    $publication_date = date('Y-m-d');

    $sql = "INSERT INTO advertisements (company_id, title, description, content, start_of_contract, salary, domain, job_type, publication_date)
            VALUES ('$company_id', '$title', '$description', '$content', '$start_of_contract', '$salary', '$domain', '$job_type', '$publication_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Advertisement created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
