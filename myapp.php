<?php
session_start();
require_once('connect.php');
    if(isset($_POST['myappexit'])){
        header("Location: mainpage.php");
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
        </div>
        <div class="signup-form">
            <h2 class="signup-heading"> My Appointments </h2>
            <table> 
                <col width="25%">
                <col width="50%">
                <col width="25%">
               
                <tr> 
                    <th>Date</th>
                    <th>Time</th>
                    <th>Doctor</th>
                    <th>Reason</th>
                </tr>
        <?php
            $pat_id = $_SESSION['patientID'];
            $app = $mysqli->prepare("SELECT * FROM appointment,staff,patient WHERE patient.patientID = appointment.patientID AND patient.patientID = ? AND staff.staffID = appointment.staffID");
            $app -> bind_param("i",$pat_id);
            if ($app -> execute()){
                $result=$app->get_result();
                while($row=$result->fetch_assoc()){?>
                 <tr>
                 <td><?=$row['appointmentDate']?></td>
                    <td><?=$row['appointmentTime']?></td>
                    <td><?=$row['firstName']?></td>
                    <td><?=$row['reason']?></td>
                </tr>


                <?php}
                


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