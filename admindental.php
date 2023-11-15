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
    if(!isset($_SESSION['staffID']))
    {
        header("Location: login.php");
    }
    elseif(!isset($_SESSION['adminID']))
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
            <h2 class="signup-heading"> <?php echo $_SESSION['patientID'];?>Patient Dental Records </h2>
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
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            <?php
                    $pat_id = 1;
                    $dental = $mysqli->prepare("SELECT records.patientID, records.recordID,records.recordTime,records.remarks,records.treatment, records.diagnosis FROM records JOIN patient on records.patientID = patient.patientID WHERE patient.patientID = ?");
                    $dental ->bind_param("i",$pat_id);

                    if ($dental-> execute()){
                        $result=$dental->get_result();
                        while($row=$result->fetch_assoc()){
                            ?>
                            <tr>
                            <td><?=$row['recordTime']?></td>
                            <td><?=$row['remarks']?></td>
                            <td><?=$row['treatment']?></td>
                            <td><?=$row['diagnosis']?></td>
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
                        <button type="submit" name="admindentalinsert" >Insert</button>
                </form>
                <form action ="admindental.php" method ="post">
                        <button type="submit" name="admindentalexit" >Return</button>
                    </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>