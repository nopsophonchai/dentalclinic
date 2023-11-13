<?php
session_start();
require_once('connect.php');

if (!isset($_SESSION['patientID'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['billingid'])) {
    $billingID = $_GET['billingid'];

    $q = $mysqli->prepare("DELETE FROM billing WHERE billingID = ?");
    $q->bind_param("i", $billingID);

    if ($q->execute()) {
        header('Location: adminbilling.php');
    } else {
        echo "Delete failed. Error: " . $mysqli->error;
    }
    $q->close();
} else {
    echo "No billing ID provided for deletion.";
}
?>
