<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../../db/db.php';

    if (isset($_POST['ad_id']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) &&
        !empty($_POST['ad_id']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email'])) {

        $ad_id = $_POST['ad_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $cv = $_POST['cv_file']; // Assurez-vous que le fichier est correctement traité avant l'insertion
        $msg = $_POST['message'];

        $stmt = $conn->prepare("INSERT INTO non_logged_in_applicants (first_name, last_name, email, application_date, ad_id, cv, message) VALUES (?, ?, ?, NOW(), ?, ?, ?)");
        $stmt->bind_param("ssssbs", $first_name, $last_name, $email, $ad_id, $cv, $msg);

        if ($stmt->execute()) {
            $applicant_id = $stmt->insert_id;

            $stmt = $conn->prepare("INSERT INTO job_applications (ad_id, non_logged_in_applicant_id, application_date, notes) VALUES (?, ?, NOW(), 'Notes for application')");
            $stmt->bind_param("ss", $ad_id, $applicant_id);

            if ($stmt->execute()) {
                echo "Candidature soumise avec succès.";
            } else {
                echo "Erreur: " . $stmt->error;
            }
        } else {
            echo "Erreur: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>
