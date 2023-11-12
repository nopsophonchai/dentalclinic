<?php
session_start();
require_once('connect.php');
if(isset($_POST['submitapp']))
{
    
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
                <form action="Adminmanager.php" method="post">
                <div class="form-groupmyapp">
                            <button type="submit" name="myappexit" >Return</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        <div class="appformcontainer">
        <form action = "dentalIndex.php" method ="post">
        <input type = "hidden" name="formType" value="adappointment"/>

        <p><u>Appointmet fillout form </u></p>
        <div class="form-group">
            <label >National ID:</label>
            <input type="text" name="nationalid" required>
        </div>
        <div class="form-group">
            <label for="dateapp">Select Date:</label>
            <input type="date" id="dateapp" name="dateapp" required>
        </div>
        <div class="form-group">
            <label for="timeapp">Select Time:</label>
            <input type="time" id="timeapp" name="timeapp" required>
        </div>
        <div class="form-group">
            <label for="Docotr">Select Dentist:</label>
            <select id="Doctor" name="doctor">
            <?php
                $q = $mysqli->prepare("SELECT staffID,firstName,lastName,specialty FROM staff WHERE typeID = 1 AND avaStat = 1");
                if($q->execute())
                {
                    $results = $q->get_result();
                    while($row=$results->fetch_assoc())
                    {
                        echo '<option value ="'.$row['staffID'].'">'.$row['firstName'].' '.$row['lastName'].' | '.$row['specialty'].'</option>';
                    }
                    
                }
                else{
                    echo '<option value ="e">error</option>';
                }
            ?>
            </select>
        </div>
        <div class="form-groupapp">
            <label for="reason">Please write your Reason:</label>
            <textarea id="reason" name="reason" ></textarea>
        </div>
        <div class="form-groupapp">
            <input type="submit" name ="submitapp" value="Submit">
            <input type="submit"  name="cancelapp" value="Cancel">
        </div>
</form>
    </div>
    </div>
</body>
</html>