<?php
session_start();
require_once('connect.php');
    if(isset($_POST["adminbillinginsert"])){
        header("Location: insertbilling.php");
        exit;
    }
    elseif(isset($_POST['adminbillexit'])){
        header("Location: adminmanager.php");
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
            <h2 class="signup-heading"> Patient Billing History </h2>
            <div class="app-form">
            <table> 
                <col width="20%">
                <col width="20%">
                <col width="20%">
                <col width="20%">
                <col width="20%">


                <tr> 
                    <th>Time</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Edit</th>
                    <th>Delete</th>
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
                            <td><a href='editbilling.php?patientid=<?=$row['patientID']?>'><img src="Modify.png" width="24" height="24"></a></td>
                            <td><a href='delbilling.php?patuentid=<?=$row['patientID']?>'> <img src="Delete.png" width="24" height="24"></a></td>
                            </tr>
                            <?php
                        }
                    }elseif ($bill ===false){
                        die("prepare failed: " . $mysqli->error);
                    }
               ?>
            </table>
            <form action = "insertbilling.php" method ="post">
            <div class="form-groupbill">
                        <button type="submit" name="adminbillinsert" >Insert</button>
                </form>
                <form action ="view_profile.php" method ="post">
                        <button type="submit" name="adminbillexit" >Return</button>
                    </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>