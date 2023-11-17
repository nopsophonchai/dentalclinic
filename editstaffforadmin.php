<?php 
    session_start();
    require_once('connect.php');
    require_once('adminconfig.php');
    $encryption_key = $key; 
    if(!isset($_SESSION['staffID']))
    {
        header("Location: login.php");
    }
    else
    {
        $id = $_SESSION['staffID'];
        echo $_SESSION['staffID'];
        $info = $mysqli -> prepare("SELECT staffID,AES_DECRYPT(staff.firstName, ?) as firstName,AES_DECRYPT(staff.lastName, ?) as lastName,gender,
        AES_DECRYPT(staff.nationalID, ?) as nationalID,telephone,AES_DECRYPT(staff.houseAddress, ?) as houseAddress,dateOfBirth,
        avaStat,type.typeName,AES_DECRYPT(staff.specialty, ?) as specialty,AES_DECRYPT(staff.salary, ?) as salary
        FROM staff JOIN type ON staff.typeID = type.typeID WHERE staff.staffID = ?");
        $info->bind_param("ssssssi", $encryption_key, $encryption_key, $encryption_key, $encryption_key, $encryption_key, $encryption_key, $id);
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
        $id2 = $_SESSION['staffID'];
        $firstname = $_POST['first-name'];
        $lastname = $_POST['last-name'];
        $gender = $_POST['gender'];
        $type = $_POST['type'];
        $dob = $_POST['date-of-birth'];
        $salary = $_POST['salary'];
        $stat = $_POST['status'];
        

    
        $q = $mysqli -> prepare("UPDATE staff SET firstName=AES_ENCRYPT(?, ?),lastName=AES_ENCRYPT(?, ?),gender=?,dateOfBirth=?,avaStat=?,typeID=?,salary=AES_ENCRYPT(?, ?) WHERE staffID = ?");
        $q -> bind_param("ssssssiiisi", $firstname, $encryption_key,$lastname, $encryption_key,$gender ,$dob,$stat,$type,$salary, $encryption_key,$id2);
        ini_set('display_errors', 1);
                error_reporting(E_ALL);
        if($q->execute()) {
            $_SESSION['staffID'] = $id2;
            header('Location: view_profile.php?type=staff');
    
        } else {
            header('Location: view_profile.php?type=staff');
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
            <h2 class="signup-heading"> Staff Profile </h2>

            <form action="editstaffforadmin.php" method="post">
            <input type="hidden" name="formType" value="editstaff"/>
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
                        <label>Salary: </label>
                            <input type = "text" name = "salary" value ="<?php echo $userDetails['salary'];?>">
                    </div>
                    <div class="form-group">
                        <label for="date-of-birth">Date of Birth:</label>
                        <?php                        echo "<input type='text' name='date-of-birth' value=" .$userDetails['dateOfBirth'] . ">";
?>                    </div>
                    
                    
                            <div class="form-group">
                        <label for="status">Status:</label>
                        <select name = "status" required>
                            <option value = 1 >1</option>
                            <option value = 0>0</option>
                        </select>
                    </div>
                    
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