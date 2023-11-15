<?php 
    session_start();
    require_once('connect.php');
    if (isset($_GET['patientid'])) {
        $_SESSION['id2'] = $_GET['patientid'];
    }
    if (isset($_GET['recordid'])) {
        $_SESSION['ID'] = $_GET['recordid'];
    }
    
    // echo $_SESSION['ID'];
    if(!isset($_SESSION['patientID']))
    {
        header("Location: login.php");
    }
    else
    {
        $id = $_SESSION['patientID'];
        $info = $mysqli -> prepare("SELECT * FROM records WHERE patientID = ? AND recordID = ?");
        $info -> bind_param("ii", $id,$_SESSION['ID']);
        if($info->execute()) {
            $result = $info->get_result();
            if($result->num_rows > 0) {
                $userDetails = $result->fetch_assoc();
                $date = new DateTime($userDetails['recordTime']);
                $formattedDate = $date->format('Y-m-d\TH:i');
                $userDetails['recordTime'] = $formattedDate;

            } else {
                echo "No records found.";
            }
            
        } else {
            echo "Select failed. Error: " . $mysqli->error;
        }
        $info->close();
        
    }
    if (isset($_POST['dentaleditsubmit'])) {
        
        $id2 = $_SESSION['id2'];
        $ID = $_SESSION['ID'];
        $note = $_POST['dental-note'];
        $treat = $_POST['dental-treatment'];
        $diag = $_POST['dental-diagnosis'];
        // echo "<span>mm".$id2."</span>";
        $q = $mysqli -> prepare("UPDATE records SET remarks=?,treatment=?,diagnosis=? WHERE recordID = ?");
        $q -> bind_param("sssi",$note,$treat,$diag,$ID);
        ini_set('display_errors', 1);
                error_reporting(E_ALL);
        if($q->execute()) {
     
            header('Location: admindental.php');
    
        } else {
            // echo "<span>".$_SESSION['ID']."</span>";
            echo "Select failed. Error: " .$mysqli->error;

        }
        $q->close();
    }
    elseif($_POST['dentaleditcancel']){
        header('Location: admindental.php');
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
        </div>
            <div class = "formgroup">
            <h2 class="signup-heading"> Edit Dental Records  </h2>
            <form action="admineditdental.php" method="post">
                    <input type = "hidden" name="formType" value="editpatient"/>
                    <div class="form-group">
                    <label for="dental-time">Time:</label>
<?php                        echo "<input type='datetime-local' name='dental-time' value=" .$userDetails['recordTime'] . ">";
?>
                    </div>
                    <div class="form-group">
                        <label for="dental-note">Note:</label>
                        <?php       echo "<input type='text' name='dental-note' value=" .$userDetails['remarks'] . ">";
?>                    </div>
                    <div class="form-group">
                        <label for="dental-treatment">Treatment:</label>
                        <?php        echo "<input type='text' name='dental-treatment' value=" .$userDetails['treatment'] . ">";
?>                    </div>
                    <div class="form-group">
                        <label for="dental-diagnosis">Diagnosis:</label>
                        <?php        echo "<input type='text' name='dental-diagnosis' value=" .$userDetails['diagnosis'] . ">";
?>                    </div>

                </div><div class="form-groupdentaledit">
                        <button type="submit" name="dentaleditsubmit" >Submit</button>
                        <button type="submit" name="dentaleditCancel" >Cancel</button>
                    </div>
               
            </form>
            <div class ="form-groupdentaledit">
            <form action = "admindental.php" method = "post">
                <button type="submit" name="back" >Back</button>
</div></form>
</div>   

        
    </div>
</body>
</html>