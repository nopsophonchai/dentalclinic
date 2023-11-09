<?php 
    session_start();
    require_once('connect.php');
    if(!isset($_SESSION['patientID']))
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
        <div class="logo-containersignup">
        </div>
        <div class="signup-form">
        <h2 class="signup-heading"> Main Page </h2>
            <form action="dentalIndex.php" method="post">
                <input type = "hidden" name="formType" value="mainpage"/>
            
                <div class="form-groupapp">
                        <button type="submit" name="myprofile" >My Profile</button>
                </div>
                <div class="form-groupapp">
                    <button type="submit" name="myapp" >My Appointments</button>
                </div>
                <div class="form-groupapp">
                    <button type="submit" name="dentalrecords" >Dental Records</button>
                </div>
                <div class="form-groupapp">
                    <button type="submit" name="BillingHistory" >Billing History</button>
                </div>
                    <div class="form-groupapp">
                    <button type="submit" name="123" >Log Out</button>
                </div>
            </form>
        </div>
    <div class="appformcontainer">
        <form action = "dentalindex.php" method ="post">
        <input type = "hidden" name="formType" value="appointment"/>

        <p><u>Appointmet fillout form </u></p>
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
            <select id="Doctor" name="doctor" required>
            <?php
                $q = $mysqli->prepare("SELECT firstName,lastName,specialty FROM staff WHERE typeID = 1 AND avaStat = 1");
                if($q->execute())
                {
                    $results = $q->get_result();
                    while($row=$results->fetch_assoc())
                    {
                        echo '<option value ='.$row['staffID'].'>'.$row['firstName'].' '.$row['lastName'].' | '.$row['specialty'].'</option>';
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