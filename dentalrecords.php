<?php
    session_start();
    require_once('connect.php');
    if(isset($_POST["dentexit"])){
        header ("Location: mainpage.php");
        exit;
    }
    elseif(isset($_POST['myprof'])){
        header("Location: myprofile.php");
        exit;
    }
    elseif(isset($_POST['myappointments'])){
        header("Location: myapp.php");
        exit;
    }
    elseif(isset($_POST['billinghistory'])){
        header("Location: billhistory.php");
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
        <div class="form-groupmyprof1">
        <form action="myprofile.php" method="post">
            <div class="form-groupmain">
                <button class ="hover-button" type="submit" name="myprof" >My Profile</button>
            </div></form>
            <form action="myapp.php" method="post">
        <div class="form-groupmain">
                <button class ="hover-button"type="submit" name="myappointments" >My Appointments</button>
                </div></form>
                <form action="billinghis.php" method="post">
                <div class="form-groupmain">
                <button class ="hover-button"type="submit" name="billinghistory" >Billing History</button>
                </div></form>
</div></div>
        <div class="signup-formlook">
            <h2 class="signup-heading"> Dental Records </h2>
            <div class="app-form">
            <table> 
                <col width="20%">
                <col width="20%">
                <col width="20%">
                <col width="20%">

               
                <tr> 
                    <th>Time</th>
                    <th>Diagnosis</th>
                    <th>Treatment</th>
                    <th>Remarks</th>
                    <th>Dentist</th>
                </tr>
            <?php 
                $pat_id = $_SESSION['patientID'];
                $dent = $mysqli->prepare("SELECT records.recordTime as recordtime, records.diagnosis , records.treatment, AES_DECRYPT(records.remarks,?) as recordremark, AES_DECRYPT(staff.firstName,?) as firstName FROM records JOIN patient ON patient.patientID = records.patientID JOIN staff ON staff.staffID = records.staffID WHERE patient.patientID = ?");
                $dent -> bind_param("ssi",$key,$key,$pat_id);

                if ($dent -> execute()){
                    $result=$dent->get_result();
                    while($row=$result->fetch_assoc()){
                        ?>
                    <tr>
                    <td><?=$row['recordtime']?></td>
                    <td><?=$row['diagnosis']?></td>
                    <td><?=$row['treatment']?></td>
                    <td><?=$row['recordremark']?></td>
                    <td><?=$row['firstName']?></td>
                    </tr>
                    <?php
                    }
                } elseif ($dent === false) {
                    die("Prepare failed: " . $mysqli->error);
                }
            
            ?>
            </table>
            <form action = "mainpage.php" method="post">
            <div class="form-groupappointment">
                <button class ="hover-button" type="submit" name="dentexit" >Return</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>