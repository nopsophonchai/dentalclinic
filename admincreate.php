<?php
session_start();
require_once("connect.php");
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('adminconfig.php');
$key = $key; 
if(isset($_POST['signupbutton']))
{

    $Username = $_POST['username'];
    $Password = $_POST['password'];
    $Conpass = $_POST['conpasswd'];
    
    if($Password != $Conpass)
    {
        

    }
    else{
    $fname = $_POST['first-name'];
    $lname = $_POST['last-name'];
    $gender = $_POST['gender'];
    $telephone = $_POST['telephone'];
    $dob = $_POST['date-of-birth'];
    $nationalID = $_POST['natid'];
    $address = $_POST['address'];
    $hashedPass = password_hash($Password, PASSWORD_DEFAULT);
    
    $usercheck = $mysqli->prepare("SELECT Username FROM userAccounts WHERE Username = ?");
    $usercheck->bind_param("s", $Username);
    
    if($usercheck->execute())
    {
        $result = $usercheck->get_result();
        if($result->num_rows === 0)
        {
            $stmt = $mysqli->prepare("INSERT INTO patient (firstName, lastName, gender, nationalID, telephone, houseAddress, dateOfBirth) VALUES (AES_ENCRYPT(?,?),AES_ENCRYPT(?,?),?,AES_ENCRYPT(?,?),AES_ENCRYPT(?,?),AES_ENCRYPT(?,?),?)");
            if ($stmt === false) {
                die("Prepare failed: " . $mysqli->error);
            }
            $stmt->bind_param("ssssssssssss", $fname,$key, $lname, $key,$gender, $nationalID, $key,$telephone, $key,$address,$key, $dob);

            if($stmt->execute()){
                echo "Data inserted successfully";
            }
            else
            {
                echo "Select failed. Error: " . $mysqli->error;
            }

            $lastid = $mysqli->insert_id;
            $stmt->close();
            
            $r = $mysqli->prepare("INSERT INTO userAccounts (Username, Password, patientID) VALUES (?,?,?)");
            $r->bind_param("ssi", $Username, $hashedPass, $lastid);
            if($r->execute()){
                echo "Data inserted successfully";
                if(isset($_SESSION['adminID']))
                {
                    header("Location: Adminmanager.php");
                    exit();
                }
                elseif(isset($_SESSION['staffID']))
                {
                    header("Location: staff/staffmain.php");
                    exit();
                }
            }
            else
            {
                echo "Select failed. Error: " . $mysqli->error;
            }
            $r->close();
        }
        else
        {
            echo 'Username already exists!';
            header("Location: admincreate.php");
            exit();
        }
    }
    else
    {
        echo $mysqli->error;
    }
    $usercheck->close();
}}
elseif(isset($_POST['backbutton']))
{
    if(isset($_SESSION['adminID']))
    {
        header("Location: Adminmanager.php");
        exit();
    }
    elseif(isset($_SESSION['staffID']))
    {
        header("Location: staff/staffmain.php");
        exit();
    }
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
        <div class="formgroup">
            <h2 class="signup-heading">Create Patient</h2>

            <form action="admincreate.php" method="post">
                    <input type = "hidden" name="formType" value="createpatient"/>
                    <div class="form-group">
                        <label for="first-name">First Name:</label>
                        <input type="text" id="first-name" name="first-name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <input type="text" id="last-name" name= "last-name" required>
                    </div>
                    <div class="form-group">
                        <label for="natid">National ID:</label>
                        <input type="text" id="natid" name= "natid" minlength = "13" maxlength = "13" required>
                    </div>
                    <div class="form-group">
                        <label>Gender:</label>
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label>
                    </div>
                    <div class="form-group">
                        <label for="date-of-birth">Date of Birth:</label>
                        <input type="date" id="date-of-birth" name="date-of-birth" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telephone:</label>
                        <input type="text" id="telephone" name="telephone" minlength = "13" maxlength = "13" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="passrord">Password:</label>
                        <input type="text" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="conpasswd">Confirm Password:</label>
                        <input type="text" id="conpasswd" name="conpasswd" required>
                    </div>
                    <?php 
                    if(isset($_POST['signupbutton']))
                    {
                        if($_POST['password'] != $_POST['conpasswd'])
                        {
                            echo "<span style='color:red'>Passwords do not match!</span>";
                        }
                    }
                        
            ?>
                    <input type="submit" name="signupbutton" value="Create"> 
                    
                   
            </form>
            
            <form action = "dentalIndex.php" method = "post">
            <input type = "hidden" name="formType" value="createpatient"/>

            <input type="submit" name="backbutton" value="Back">
</form>
        </div>
    </div>
</body>
</html>
