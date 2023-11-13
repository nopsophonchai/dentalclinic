<?php 
    session_start();
    require_once('connect.php');
    
    if(!isset($_SESSION['patientID']))
    {
        header("Location: login.php");
    }
    else
    {
        $id = $_SESSION['patientID'];
        $info = $mysqli -> prepare("SELECT * FROM billing WHERE patientID = ?");
        $info -> bind_param("i", $id);
        if($info->execute()) {
            $result = $info->get_result();
            if($result->num_rows > 0) {
                $userDetails = $result->fetch_assoc();
            } else {
                echo "No records found.";
            }
        } else {
            echo "Select failed. Error: " . $mysqli->error;
        }
        $info->close();
        
    }
    if (isset($_POST['billeditsubmit'])) {
        echo "<span>frdgdg</span>";
        $id2 = $_SESSION['patientID'];
        $date = $_POST['bill-time'];
        $description = $_POST['bill-des'];
        $amount = $_POST['bill-amount'];
    
        $q = $mysqli -> prepare("UPDATE billing SET description=?,amount=?,billingTime=? WHERE patientID = ?");
        $q -> bind_param("isss", $id2,$date,$description,$amount);
        ini_set('display_errors', 1);
                error_reporting(E_ALL);
        if($q->execute()) {
            header('Location: adminbilling.php');
    
        } else {
            echo "Select failed. Error: " .$mysqli->error;

        }
        $q->close();
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
        </div>
        <div class="signup-form">
            <h2 class="signup-heading"> Edit Billing  </h2>

            <form action="editbilling.php" method="post">
                    <input type = "hidden" name="formType" value="editpatient"/>
                    <div class="form-group">
                    <label for="bill-time">Time:</label>
<?php                        echo "<input type='datetime-local' name='bill-time' value=" .$userDetails['billingTime'] . ">";
?>
                    </div>
                    <div class="form-group">
                        <label for="bill-des">Description:</label>
                        <?php       echo "<input type='text' name='bill-des' value=" .$userDetails['description'] . ">";
?>                    </div>
                    <div class="form-group">
                        <label for="bill-amount">Amount:</label>
                        <?php        echo "<input type='text' name='bill-amount' value=" .$userDetails['amount'] . ">";
?>                    </div>
                    <div class="form-groupbilledit">
                        <button type="submit" name="billeditsubmit" >Submit</button>
                        <button type="submit" name="billeditCancel" >Cancel</button>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
</body>
</html>