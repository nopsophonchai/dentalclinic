<?php 
    session_start();
    require_once('connect.php');
    if (isset($_GET['patientid'])) {
        $_SESSION['id2'] = $_GET['patientid'];
    }
    if (isset($_GET['recordid'])) {
        $_SESSION['ID'] = $_GET['recordid'];
    }
    
    // echo $_SESSION['ID'];
    if(!isset($_SESSION['patientID']))
    {
        header("Location: login.php");
    }
    else
    {
        $id = $_SESSION['patientID'];
        $info = $mysqli -> prepare("SELECT recordID,recordTime,AES_DECRYPT(remarks,?) as dentalremark,treatment,diagnosis,patientID, AES_DECRYPT(staff.firstName,'dental') as firstName FROM records JOIN staff ON staff.staffID = records.staffID WHERE patientID = ? AND recordID = ?");
        $info -> bind_param("sii",$key, $id,$_SESSION['ID']);
        if($info->execute()) {
            $result = $info->get_result();
            if($result->num_rows > 0) {
                $userDetails = $result->fetch_assoc();
                $date = new DateTime($userDetails['recordTime']);
                $formattedDate = $date->format('Y-m-d\TH:i');
                $userDetails['recordTime'] = $formattedDate;

            } else {
                echo "No records found.";
            }
            
        } else {
            echo "Select failed. Error: " . $mysqli->error;
        }
        $info->close();
        
    }
    if (isset($_POST['dentaleditsubmit'])) {
        $id2 = $_SESSION['id2'];
        $ID = $_SESSION['ID'];
        $note = $_POST['dental_note'];
        $treat = $_POST['dental_treatment'];
        $diag = $_POST['dental_diagnosis'];
        $doctor = $_POST['doctor'];

        $q = $mysqli->prepare("UPDATE records SET staffID = ?, remarks = AES_ENCRYPT(?,?), treatment = ?, diagnosis = ?, recordTime = ? WHERE recordID = ?");
        $q->bind_param("isssssi", $doctor,$note,$key, $treat, $diag, $_POST['dental-time'], $ID);

        ini_set('display_errors', 1);
                error_reporting(E_ALL);
        if($q->execute()) {
            echo 'hi';
            header('Location: admindental.php');
    
        } else {
            // echo "<span>".$_SESSION['ID']."</span>";
            echo "Select failed. Error: " .$mysqli->error;

        }
        $q->close();
    }
    elseif($_POST['dentaleditcancel']){
        header('Location: admindental.php');
        exit;
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
            <div class = "formgroup">
            <h2 class="signup-heading"> Edit Dental Records  </h2>
            <form action="admineditdental.php" method="post">
                    <input type = "hidden" name="formType" value="editpatient"/>
                    <div class="form-group">
                    <label for="dental-time">Time:</label>
<?php                        echo "<input type='datetime-local' name='dental_time' value='".$userDetails['recordTime'] ."'>";
?>
                    </div>
                    <div class="form-group">
                        <label for="dental-note">Note:</label>
                        <?php       echo "<input type='text' name='dental_note' value= '".$userDetails['dentalremark'] ."'>";
?>                    </div>
                    <div class="form-group">
                        <label for="dental-treatment">Treatment:</label>
                        <?php        echo "<input type='text' name='dental_treatment' value='" .$userDetails['treatment'] . "'>";
?>                    </div>
                    <div class="form-group">
                        <label for="dental-diagnosis">Diagnosis:</label>
                        <?php        echo "<input type='text' name='dental_diagnosis' value='" .$userDetails['diagnosis'] . "'>";
?>                    </div>
                    <div class="form-group">
                        <label>Select Dentist:</label>
                        <select name="doctor">
                            <?php
                            $q = $mysqli->prepare("SELECT staffID,AES_DECRYPT(firstName,?) as firstName,AES_DECRYPT(lastName,?) as lastName,specialty FROM staff WHERE typeID = 1");
                            $q->bind_param("ss", $key, $key);
                            if ($q->execute()) {
                                $results = $q->get_result();
                                while ($row = $results->fetch_assoc()) {
                                    $selected = ($row['firstName'] == $userDetails['firstName']) ? 'selected' : '';
                                    echo '<option value="' . $row['staffID'] . '" ' . $selected . '>' . $row['firstName'] . ' ' . $row['lastName'] . ' | ' . $row['specialty'] . '</option>';
                                }
                            } else {
                                echo '<option value="e">error</option>';
                            }
                            ?>
                        </select>
                    </div>

                </div><div class="form-groupdentaledit">
                        <button type="submit" name="dentaleditsubmit" >Submit</button>
                        <button type="submit" name="dentaleditCancel" >Cancel</button>
                    </div>
               
            </form>
            <div class ="form-groupdentaledit">
            <form action = "admindental.php" method = "post">
                <button type="submit" name="back" >Back</button>
</div></form>
</div>   

        
    </div>
</body>
</html>