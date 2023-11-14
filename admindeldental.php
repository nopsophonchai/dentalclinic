<?php
session_start();
require_once('connect.php');

if (!isset($_SESSION['patientID'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['recordid'])) {
    $recordID = $_GET['recordid'];

    $q = $mysqli->prepare("DELETE FROM records WHERE recordID = ?");
    $q->bind_param("i", $recordID);

    if ($q->execute()) {
        header('Location: admindental.php');
    } else {
        echo "Delete failed. Error: " . $mysqli->error;
    }
    $q->close();
} else {
    echo "No billing ID provided for deletion.";
}
?>
