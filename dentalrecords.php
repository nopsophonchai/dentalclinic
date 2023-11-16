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
        <div class="logo-containermyapp">
        <div class="form-groupmyprof1">
        <form action="myprofile.php" method="post">
            <div class="form-groupmyprof">
                <button type="submit" name="myprof" >My Profile</button>
            </div></form>
            <form action="myapp.php" method="post">
        <div class="form-groupmyprof">
                <button type="submit" name="myappointments" >My Appointments</button>
                </div></form>
                <form action="billinghis.php" method="post">
                <div class="form-groupmyprof">
                <button type="submit" name="billinghistory" >Billing History</button>
                </div></form>
</div></div>
        <div class="signup-form">
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
                </tr>
            <?php 
                $pat_id = $_SESSION['patientID'];
                $dent = $mysqli->prepare("SELECT records.recordTime,records.diagnosis,records.treatment,records.remarks FROM records JOIN patient ON patient.patientID = records.patientID WHERE patient.patientID = ?");
                $dent -> bind_param("i",$pat_id);
                if ($dent -> execute()){
                    $result=$dent->get_result();
                    while($row=$result->fetch_assoc()){
                        ?>
                    <tr>
                    <td><?=$row['recordTime']?></td>
                    <td><?=$row['diagnosis']?></td>
                    <td><?=$row['treatment']?></td>
                    <td><?=$row['remarks']?></td>
                    </tr>
                    <?php
                    }
                } elseif ($dent === false) {
                    die("Prepare failed: " . $mysqli->error);
                }
            
            ?>
            </table>
            <form action = "mainpage.php" method="post">
            <div class="form-groupmyapp">
                <button type="submit" name="dentexit" >Return</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>