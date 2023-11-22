<?php
session_start();
require_once('connect.php');    require_once('adminconfig.php');
$encryption_key = $key;

if (!isset($_SESSION['patientID'])) {
    header("Location: login.php");
} else {
    $id = $_SESSION['patientID'];
    $info = $mysqli->prepare("SELECT patientID,AES_DECRYPT(firstName, ?) as firstName,AES_DECRYPT(lastName, ?) as lastName,gender,
    AES_DECRYPT(nationalID, ?) as nationalID,AES_DECRYPT(telephone, ?) as telephone,AES_DECRYPT(houseAddress, ?) as houseAddress,
    dateOfBirth FROM patient WHERE patientID = ?");
    $info->bind_param("sssssi", $encryption_key, $encryption_key, $encryption_key, $encryption_key, $encryption_key, $id);
    if ($info->execute()) {
        $result = $info->get_result();
        if ($result->num_rows > 0) {
            $userDetails = $result->fetch_assoc();
        } else {
            echo "No records found.";
        }
    } else {
        echo "Select failed. Error: " . $mysqli->error;
    }
    $info->close();
}

if (isset($_POST['editsubmit'])) {
    // Extract all data from POST
    $id2 = $_SESSION['patientID'];
    $firstname = $_POST['first-name'];
    $lastname = $_POST['last-name'];
    $natid = $_POST['natID'];
    $address = $_POST['address'];
    $tel = $_POST['telephone'];
    $dob = $_POST['date-of-birth'];

    
    $q = $mysqli->prepare("UPDATE patient SET firstName = AES_ENCRYPT(?, ?), lastName = AES_ENCRYPT(?, ?), nationalID = AES_ENCRYPT(?, ?), houseAddress = AES_ENCRYPT(?, ?), telephone = AES_ENCRYPT(?, ?), dateOfBirth =  ? WHERE patientID = ?");
    $q->bind_param("sssssssssssi", $firstname, $encryption_key, $lastname, $encryption_key, $natid, $encryption_key, $address, $encryption_key, $tel, $encryption_key, $dob,  $id2);
    
    if ($q->execute()) {
        if(isset($_SESSION['adminID']))
        {
            header('Location: view_profile.php?type=patient');
            exit;
        }
        elseif(isset($_SESSION['staffID']))
        {
            header('Location: staff/staffview.php?type=patient');
            exit;
        }
    } else {
        echo "Update failed. Error: " . $mysqli->error;
        // Uncomment the line below if you want to see the error on the page
        // header('Location: view_profile.php');
    }
    $q->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title> Dentiste </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="container">
        <div class="logo-containersignup">
        </div>
        <div class="signup-form">
            <h2 class="signup-heading"> Patient Profile </h2>

            <form action="editpatientforadmin.php" method="post">
                <div class="form-group">
                    <label for="first-name">First Name:</label>
                    <?php echo "<input type='text' name='first-name' value='" . $userDetails['firstName'] . "'>"; ?>
                </div>
                <div class="form-group">
                    <label for="last-name">Last Name:</label>
                    <?php echo "<input type='text' name='last-name' value='" . $userDetails['lastName'] . "'>"; ?>
                </div>
                <div class="form-group">
                    <label for="natid">National ID:</label>
                    <?php echo "<input type='text' name='natID' value='" . $userDetails['nationalID'] . "'>"; ?>
                </div>
                <div class="form-group">
                    <label for="date-of-birth">Date of Birth:</label>
                    <?php echo "<input type='text' name='date-of-birth' value='" . $userDetails['dateOfBirth'] . "'>"; ?>
                </div>
                <div class="form-group">
                    <label for="telephone">Telephone:</label>
                    <?php echo "<input type='text' name='telephone' value='" . $userDetails['telephone'] . "'>"; ?>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <?php echo "<input type='text' name='address' value='" . $userDetails['houseAddress'] . "'>"; ?>
                </div>

                <div class="form-groupmy">
                    <button type="submit" name="editsubmit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>