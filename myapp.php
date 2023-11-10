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
</div>
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
            $app = $mysqli->prepare("SELECT appointment.appointmentDate,appointment.appointmentTime,staff.firstName AS staffFirstName,appointment.reason FROM appointment JOIN staff on staff.staffID = appointment.staffID JOIN patient ON patient.patientID = appointment.patientID  WHERE  patient.patientID = ?");
            $app -> bind_param("i",$pat_id);

            if ($app -> execute()){
                $result=$app->get_result();
                while($row=$result->fetch_assoc()){
                    ?>
                 <tr>
                 <td><?=$row['appointmentDate']?></td>
                    <td><?=$row['appointmentTime']?></td>
                    <td><?=$row['staffFirstName']?></td>
                    <td><?=$row['reason']?></td>
                </tr>
                <?php
            }
        } elseif ($app === false) {
                die("Prepare failed: " . $mysqli->error);
            }

?>
            </table>
            <form action="mainpage.php" method="post">
            <div class="form-groupmyapp">
                        <button type="submit" name="myappexit" >Return</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>