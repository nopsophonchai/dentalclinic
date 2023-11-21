<?php
session_start();
require_once('connect.php');
    if(isset($_POST['myappexit'])){
        header("Location: mainpage.php");
        exit;
    }
    elseif(isset($_POST['myprof'])){
        header("Location: myprofile.php");
        exit;
    }
    elseif(isset($_POST['dentalrecords'])){
        header("Location: dentalrecords.php");
        exit;
    }
    elseif(isset($_POST['billinghistory'])){
        header("Location: billinghis.php");
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
        <div class="logo-containermyapp">
            <div class="form-groupmyprof1">
            <form action="myprofile.php" method="post">
            <div class="form-groupmyprof">
                <button type="submit" name="myprof" >My Profile</button>
            </div></form>
            <form action="dentalrecords.php" method="post">
            <div class="form-groupmyprof">
                <button type="submit" name="dentalrecords" >Dental Records</button>
            </div></form>
            <form action="billinghis.php" method="post">
            <div class="form-groupmyprof">
            <button type="submit" name="billinghistory" >Billing History</button>
            </form>
            
            
</div>
<form action="mainpage.php" method="post">
            <div class="form-groupmyprof">
                        <button type="submit" name="myappexit" >Return</button>
            </div>
            </form>
</div>     
        </div>
        <div class="signup-form">
            <h2 class="signup-heading"> My Appointments </h2>
            <table> 
                <col width="25%" >
                <col width="25%">
                <col width="25%">
                <col width="50%">
               
                <tr> 
                    <th>Date</th>
                    <th>Time</th>
                    <th>Doctor</th>
                    <th>Reason</th>
                </tr>
        <?php
            $pat_id = $_SESSION['patientID'];
            $app = $mysqli->prepare("SELECT appointment.appointmentDate,appointment.appointmentTime,AES_DECRYPT(staff.firstName,?) AS staffFirstName, AES_DECRYPT(appointment.reason,?) as appreason FROM appointment JOIN staff on staff.staffID = appointment.staffID JOIN patient ON patient.patientID = appointment.patientID  WHERE  patient.patientID = ? AND appointment.completion = 0");
            $app -> bind_param("ssi",$key,$key,$pat_id);

            if ($app -> execute()){
                $result=$app->get_result();
                while($row=$result->fetch_assoc()){
                    ?>
                 <tr>
                 <td><?=$row['appointmentDate']?></td>
                    <td><?=$row['appointmentTime']?></td>
                    <td><?=$row['staffFirstName']?></td>
                    <td><?=$row['appreason']?></td>
                </tr>
                <?php
            }
        } elseif ($app === false) {
                die("Prepare failed: " . $mysqli->error);
            }

?>
            </table>
            
            </div>
        </div>
    </div>
</body>
</html>