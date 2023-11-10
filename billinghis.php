<?php
session_start();
require_once('connect.php');
    if(isset($_POST["mainpage.php"])){
        header("Location: mainpage.php");
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
    elseif(isset($_POST['dentalrecords'])){
        header("Location: dentalrecords.php");
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
        <form action="dentalrecords.php" method="post">
        <div class="form-groupmyprof">
        <button type="submit" name="dentalrecord" >Dental Records</button>
        </div></form>
</div>    
    </div>
        <div class="signup-form">
            <h2 class="signup-heading"> Billing History </h2>
            <div class="app-form">
            <table> 
                <col width="20%">
                <col width="20%">
                <col width="20%">

                <tr> 
                    <th>Time</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            <?php
                    $pat_id = $_SESSION['patientID'];
                    $bill = $mysqli->prepare("SELECT billing.amount,billing.billingTime,billing.description FROM billing JOIN patient on billing.patientID = patient.patientID WHERE patient.patientID = ?");
                    $bill ->bind_param("i",$pat_id);

                    if ($bill-> execute()){
                        $result=$bill->get_result();
                        while($row=$result->fetch_assoc()){
                            ?>
                            <tr>
                            <td><?=$row['billingTime']?></td>
                            <td><?=$row['description']?></td>
                            <td><?=$row['amount']?></td>
                            </tr>
                            <?php
                        }
                    }elseif ($bill ===false){
                        die("prepare failed: " . $mysqli->error);
                    }
               ?>
            </table>
            <form action = "mainpage.php" method ="post">
            <div class="form-groupmyapp">
                        <button type="submit" name="billexit" >Return</button>
                    </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>