<?php
session_start();
require_once('connect.php');

if (isset($_POST['id'])) {
    $_SESSION['id'] = $_POST['id'];
}

if (isset($_POST['complete']) || isset($_POST['active']) || isset($_POST['cancelled'])) {
    $status = isset($_POST['complete']) ? 1 : (isset($_POST['cancelled']) ? 2 : 0);
    $up = $mysqli->prepare("UPDATE appointment SET completion = ? WHERE appointmentID = ?");
    $up->bind_param("ii", $status, $_SESSION['id']);
    if ($up->execute()) {
        header('Location: adminappointment.php');
        exit();
    } else {
        echo $mysqli->error;
    }
    $up->close();
}
elseif (isset($_POST['delete']))
{
    $del = $mysqli->prepare("DELETE FROM appointment WHERE appointmentID = ?");
    $del -> bind_param("i", $_SESSION['id']);
    if($del->execute())
    {
        header('Location: adminappointment.php');
        exit();
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title> Dentiste </title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .centered-content {
            display: flex;
            justify-content: center; 
            align-items: flex-start;
            text-align: center; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-containermyapp"></div>
        <div class="centered-content">
        <h1> Set Status </h1>
        
        </div>
        <div>
            <form action = 'updateapp.php' method = 'post'>
                <input type = "submit" value = "Set as complete" name = "complete">
                <input type = "submit" value = "Set as active" name = "active">
                <input type = "submit" value = "Set as cancelled" name = "cancelled">
                <input type = "submit" value = "Delete" name = "delete">
            </form>
            
        </div>
        <br></br>
        <div>
            <form action = "adminappointment.php" method = "post">
                <input type = "submit" value = "Return">
        </form>
        </div>
    </div>
    
</body>
</html>

