<?php 
    session_start();
    require_once('connect.php');
    
    if(!isset($_SESSION['patientID']))
    {
        header("Location: login.php");
    }
    else
    {
        $id = $_SESSION['patientID'];
        $info = $mysqli -> prepare("SELECT AES_DECRYPT(firstName,?) as firstName,AES_DECRYPT(lastName,?) as lastName,AES_DECRYPT(nationalID,?) as nationalID,AES_DECRYPT(telephone,?) as telephone,gender,AES_DECRYPT(houseAddress,?) as houseAddress,dateOfBirth FROM patient WHERE patientID = ?");
        $info -> bind_param("sssssi",$key,$key,$key,$key,$key,$id);
        if($info->execute()) {
            $result = $info->get_result();
            if($result->num_rows > 0) {
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
        echo "<span>frdgdg</span>";
        $id2 = $_SESSION['patientID'];
        $firstname = $_POST['first-name'];
        $lastname = $_POST['last-name'];
        $natid = $_POST['natID'];
        $address = $_POST['address'];
        $tel = $_POST['telephone'];
        $dob = $_POST['date-of-birth'];

    
        $q = $mysqli -> prepare("UPDATE patient SET firstName=AES_ENCRYPT(?,?),lastName=AES_ENCRYPT(?,?),houseAddress=AES_ENCRYPT(?,?),telephone=AES_ENCRYPT(?,?),dateOfBirth=? WHERE patientID = ?");
        $q -> bind_param("sssssssssi", $firstname,$key,$lastname,$key,$address,$key,$tel,$key,$dob,$id2);
        ini_set('display_errors', 1);
                error_reporting(E_ALL);
        if($q->execute()) {
            header('Location: myprofile.php');
    
        } else {
            header('Location: myprofile.php');
            echo "Select failed. Error: " .$mysqli->error;

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

            <form action="editpatient.php" method="post">
                    <input type = "hidden" name="formType" value="editpatient"/>
                    <div class="form-group">
                        <label for="first-name">First Name:</label>
<?php                        echo "<input type='text' name='first-name' value=" .$userDetails['firstName'] . ">";
?>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <?php       echo "<input type='text' name='last-name' value=" .$userDetails['lastName'] . ">";
?>                    </div>
    
                    <div class="form-group">
                        <label for="date-of-birth">Date of Birth:</label>
                        <?php                        echo "<input type='date' name='date-of-birth' value=" .$userDetails['dateOfBirth'] . ">";
?>                    </div>
                    <div class="form-group">
                        <label for="telephone">Telephone:</label>
                        <?php                        echo "<input type='text' name='telephone'  maxlength = '10' minlength = '10' value=" .$userDetails['telephone'] . ">";
?>                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <?php                        echo "<input type='text' name='address' value=" .$userDetails['houseAddress'] . ">";
?>                    </div>
                    
                    <div class="form-groupmy">
                        <button type="submit" name="editsubmit" >Submit</button>
                        <button type="submit" name="editCancel" >Cancel</button>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
</body>
</html>