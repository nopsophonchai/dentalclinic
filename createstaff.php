<?php
session_start();
require_once('connect.php');
$encryption_key = $key;
$err = "";
if (isset($_POST['Submit'])) { // Updated the condition here

    $fname = $_POST['first-name'];
            $lname = $_POST['last-name'];
            $natid = $_POST['natid'];
            $gender = $_POST['gender'];
            $type = $_POST['type'];
            $dob = $_POST['date-of-birth'];
            $tele = $_POST['telephone'];
            $salary = $_POST['salary'];
            $address = $_POST['address'];
            $specialty = $_POST['specialty'];
            $ava = 1;
            $Username = $_POST['usernameStaff'];

    $hashedPass = password_hash($_POST['passwordStaff'], PASSWORD_DEFAULT);
    if ($_POST['passwordStaff'] !== $_POST['staffConfirm']) {
        $err =  '<span style="color: red">Passwords do not match!</span>';
        
    } else {
        $q = $mysqli->prepare("SELECT * FROM staff WHERE AES_DECRYPT(nationalID, ?) = ?");
        $q->bind_param("ss", $encryption_key,$natid);
        
        if ($q->execute()) {
            $results = $q->get_result();
            if ($results->num_rows === 0) {
                $w = $mysqli->prepare("INSERT INTO staff (firstName, LastName, gender, nationalID, telephone, houseAddress, dateOfBirth, avaStat, typeID, specialty, salary) VALUES (AES_ENCRYPT(?, ?), AES_ENCRYPT(?, ?), ?, AES_ENCRYPT(?, ?), AES_ENCRYPT(?, ?), AES_ENCRYPT(?, ?), ?, ?, ?, ?, AES_ENCRYPT(?, ?))");
                $w->bind_param("ssssssssssssiisss", $fname, $encryption_key, $lname, $encryption_key, $gender, $natid, $encryption_key, $tele, $encryption_key, $address, $encryption_key, $dob, $ava, $type, $specialty, $salary, $encryption_key);
                if ($w->execute()) {
                    echo '<span>Staff created</span>';
                    $lastid = $mysqli->insert_id;
                    $r = $mysqli->prepare("INSERT INTO staffAccount (username, password,staffID) VALUES (?,?,?)");
                    $r -> bind_param("ssi",$Username,$hashedPass,$lastid);
                    if($r->execute()){
                        echo "Data inserted successfully";
                        header('Location: Adminmanager.php');
                    } else {
                        echo "Select failed. Error: " . $mysqli->error;
                    }
                    $r->close();
                } else {
                    echo '<span>Error: ' . $mysqli->error . '</span>';
                }
            } else {
                echo '<span>National ID already exists!</span>';
            }
        } else {
            echo "Error: " . $mysqli->error;
        }
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <title> Dentiste(Create Staff) </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    
    <div class="container">
        <div class="logo-containersignup">
        </div>
        <div class="create_staff-form">
            <h2 class="signup-heading"> Create Staff </h2>

            <form action="createstaff.php" method="post">
                    <input type = "hidden" name = "formType" value = "createstaff"/>
                    
                    <div class="form-group">
                        <label for="first-name">First Name:</label>
                        <input type="text" id="first-name" name="first-name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <input type="text" id="last-name" name= "last-name" required>
                    </div>
                    <div class="form-group">
                        <label>National ID:</label>
                        <input type="text" name = "natid" minlength = "13" maxlength = "13" required>
                    </div>
                    <div class="form-group">
                        <label>Gender:</label>
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label>
                    </div>
                    <div class="form-group">
                        <label>Type:</label>
                        <select name="type" required>
                        <?php
                            $t = $mysqli->prepare("SELECT * FROM type");
                            if($t->execute())
                            {
                                $result = $t->get_result();
                                while($row = $result-> fetch_assoc()){
                                    echo '<option value ="'.$row['typeID'].'">'.$row['typeName'].'</option>';
                                }
                                
                            }
                            else
                            {
                                echo 'error';
                            }
                            $t->close();
                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="salary">Specialty:</label>
                        <input type="text" id="specialty" name="specialty" required>
                    </div>
                    <div class="form-group">
                        <label for="date-of-birth">Date of Birth:</label>
                        <input type="date" id="date-of-birth" name="date-of-birth" required>
                    </div>
                    <div class="form-group">
                        <label>Telephone:</label>
                        <input type="text" name = "telephone" maxlength = "10" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary:</label>
                        <input type="text" id="salary" name="salary" minlength = "10" maxlength = "10" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="usernameStaff" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="passwordStaff" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm Password:</label>
                        <input type="password" name="staffConfirm" required>
                    </div>
                    <div class="form-group">
                    <label for="password"><?php echo $err;?></label>
                        </div>
                   
            
                    
                    <input type="submit" name = "Submit" value="Submit" style="color: #FFFFFF;">
                <input type="submit" name="backbutton" value="Back"onClick="window.location='Adminmanager.php';">
            </form>
        </div>
    </div>
</body>
</html>
