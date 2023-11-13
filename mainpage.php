<?php 
    session_start();
    require_once('connect.php');
    $today = date("Y-m-d");
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
    <form action = "mainpage.php" method ="post">
                <div class="form-group">
                    <label for="dateapp">Select Date:</label>
                    <input type="date" id="dateapp" name="dateapp" min="<?php echo $today; ?>" required>
                    <input type="submit" name = "subdate" value = "Confirm Date">
                </div>
     </form>
    <form action = "mainpage.php" method ="post">
            
            
            
            <?php

            
            if(isset($_POST['dateapp']) && !empty($_POST['dateapp']))
            {
                
                $_SESSION['dateapp'] = $_POST['dateapp'];
                $mydate = $_SESSION['dateapp'];
                $times = $mysqli->prepare("SELECT appointmentTime FROM appointment WHERE appointmentDate = ? AND completion = 0");
                        $times -> bind_param("s",$mydate);
                        $aquiredTime = [];
                        if($times->execute())
                        {
                            $resultsTime = $times->get_result();

                            while($myTime = $resultsTime->fetch_assoc())
                            {
                                $timeMine = new DateTime($myTime['appointmentTime']);
                                $timeMine = $timeMine -> format('H:i');
                                $aquiredTime[] = $timeMine;
                            }
                        }
                        else
                        {

                        }
                        // print_r($aquiredTime);
            echo '<span>Current Date: '. $_SESSION['dateapp'].'</span>';
            echo '<br></br>';
            echo '<div class="form-group">';
            echo   '<label for="timeapp">Select Time:</label>';
            echo  '<select name = "timeapp">';

                        
                        
                        $timestart = new DateTime('09:00');
                        $timeend = new DateTime('17:00');
                        $step = new DateInterval('PT30M');
                        for($current = clone $timestart; $current < $timeend; $current->add($step))
                        {
                            $time = $current->format('H:i');
                            if ($time >= '12:00' && $time < '13:00' || in_array($time, $aquiredTime)) {
                                continue;
                            }
                            echo '<option value="'.$time.'">'.$time.'</option>';
                        }
                    
            echo  '</select>';
            echo '</div>';
                    }
            ?>


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
            <?php
                if(isset($_POST['submitapp']))
                {
                
                            $date = $_SESSION['dateapp'];
                            $time = $_POST['timeapp'];
                            $doc = $_POST['doctor'];
                            $reason = $_POST['reason'];

                            $patientID = $_SESSION['patientID'];

                            $check = $mysqli->prepare("SELECT * FROM appointment WHERE appointmentDate = ? AND appointmentTime = ? AND reason = ?");
                            $check -> bind_param("sss",$date,$time,$reason);
                            if($check->execute())
                            {
                                $checkresult = $check->get_result();
                                if($checkresult -> num_rows === 0)
                                {
                                    $ins = $mysqli->prepare("INSERT INTO appointment (appointmentDate,appointmentTime,reason,staffID,patientID,completion) VALUES (?,?,?,?,?,0)");
                                        $ins -> bind_param("sssii",$date,$time,$reason,$doc,$patientID);
                                        if ($ins -> execute()){

                                            header('Location: mainpage.php');
                                            exit;
                                        }else {
                                            echo '<span>Error: ' . $mysqli->error . '</span>';
                                        }
                                        $ins->close();
                                }
                            }
                            else
                            {
                                echo '<span>Error: ' . $mysqli->error . '</span>';
                            }

                    
                    $combid->close();
                }
            ?>
        </form>
    </div>
    </div>
</body>
</html>