<?php
session_start();
require_once('connect.php');
    if(isset($_POST["admindentalinsert"])){
        header("Location: insertdental.php");
        exit;
    }
    elseif(isset($_POST['admindentalexit'])){
        if(isset($_SESSION['adminID']))
        {
            header("Location: view_profile.php?type=patient");
            exit;
        }
        elseif(isset($_SESSION['staffID']))
        {
            header("Location: staff/staffview.php?type=patient");
            exit;
        }
    }
    if(!isset($_SESSION['staffID']) && !isset($_SESSION['adminID']))
    {
        header("Location: login.php");
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
        <div class="logo-containermyapp">
    
    </div>
        <div class="formgroup">
            <h2 class="signup-heading"> Patient Dental Records </h2>
            <div class="app-form">
            <table> 
                <col width="30%">
                <col width="30%">
                <col width="20%">
                <col width="10%">
                <col width="10%">


                <tr> 
                    <th>DateTime</th>
                    <th>Note</th>
                    <th>Treatment</th>
                    <th>Diagnosis</th>
                    <th>Dentist</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            <?php
                    $pat_id = $_SESSION['patientID'];
                    $dental = $mysqli->prepare("SELECT records.patientID, records.recordID,records.recordTime,AES_DECRYPT(records.remarks,?) as remarks,records.treatment, records.diagnosis,AES_DECRYPT(staff.firstName,?) as firstName FROM records JOIN patient on records.patientID = patient.patientID JOIN staff on records.staffID = staff.staffID WHERE patient.patientID = ?");
                    $dental ->bind_param("ssi",$key,$key,$pat_id);

                    if ($dental-> execute()){
                        $result=$dental->get_result();
                        while($row=$result->fetch_assoc()){
                            ?>
                            <tr>
                            <td><?=$row['recordTime']?></td>
                            <td><?=$row['remarks']?></td>
                            <td><?=$row['treatment']?></td>
                            <td><?=$row['diagnosis']?></td>
                            <td><?=$row['firstName']?></td>
                            <td><a href='admineditdental.php?patientid=<?=$row['patientID']?>&recordid=<?=$row['recordID']?>'><img src="Modify.png" width="24" height="24"></a></td>
                            <td><a href='admindeldental.php?patientid=<?=$row['patientID']?>&recordid=<?=$row['recordID']?>'> <img src="Delete.png" width="24" height="24"></a></td>
                            </tr>
                            <?php
                        }
                    }elseif ($dental ===false){
                        die("prepare failed: " . $mysqli->error);
                    }
               ?>
            </table>
            <form action = "insertdental.php" method ="post">
            <div class="form-groupdental">
                        <button class ="hover-button" type="submit" name="admindentalinsert" >Insert</button>
                </form>
                <form action ="admindental.php" method ="post">
                        <button class ="hover-button" type="submit" name="admindentalexit" >Return</button>
                    </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>