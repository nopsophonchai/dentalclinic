<?php
require_once('connect.php');
$adminPass = 'Admin123';

$hashedPass = password_hash($adminPass, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("UPDATE staffAccounts SET Password = ? WHERE Username = 'Admin'");
$stmt->bind_param("s", $hashedPass);

if ($stmt->execute()) {
    echo "Admin password updated successfully.";
} else {
    echo "Failed to update admin password: " . $mysqli->error;
}

$stmt->close();
$mysqli->close();
?>
