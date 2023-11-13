<?php
session_start();
require_once('connect.php');
$today = date("Y-m-d");


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
                <div>
                    <div>
                        <form action = "adminappointment.php" method = "post">
                        <label>Search By Dentist:</label>
                        <input type="text" name="searchName">
                    </div>
                    <div>
                        <label>Search By Date:</label>
                        <input type="date" name="searchDate">

                    </div>
                    <div>
                        <label>Show Active Appointments Only:</label>
                        <input type="checkbox" name="complete" value = 1>
  
                    </div>
                    <div>
                        <button type = "submit" name = "subsearch">Search</button>
                    </div>
                    </form>
                </div>
                <br>
                </br>
                <table style="table-layout: fixed; width: 55%;"> 
                    <colgroup>
                        <col style="width: 60px;">
                        <col style="width: 60px;">
                        <col style="width: 50px;">
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                        <col style="width: 150px;">
                        <col style="width: 7%;">
                        <col style="width: 7%;">
                    </colgroup>
                
                    <tr> 
                        <th style="white-space: nowrap;">Date</th>
                        <th style="word-wrap: break-word;">Time</th>
                        <th style="word-wrap: break-word;">Dentist</th>
                        <th style="word-wrap: break-word;">Patient</th>
                        <th style="word-wrap: break-word;">Patient National ID</th>
                        <th >Reason</th>
                        <th style="word-wrap: break-word;">Status</th>
                        <th style="word-wrap: break-word;">Toggle Status</th>
                    </tr>
                    <?php
                    $query = "SELECT a.appointmentID as aid, a.appointmentDate as ad, a.appointmentTime as at, s.firstName as sfn, p.firstName as pfn, p.nationalID as nid, a.reason as reason,a.completion as com FROM appointment a JOIN patient p ON p.patientID = a.patientID JOIN staff s ON s.staffID = a.staffID ";
                    $parameters = [];
                    $types = '';
                    if(isset($_POST['subsearch']))
                    {
                    $namesearch = $_POST['searchName'] ?? "";
                    $datesearch = $_POST['searchDate'] ?? "";
                    if($namesearch != "" && $datesearch != "")
                    {
                        $query .= "WHERE s.firstName LIKE ? AND a.appointmentDate = ?";
                        $parameters[] = "%".$namesearch."%";
                        $parameters[] = $datesearch;
                        $types = "ss";
                    }
                    elseif ($namesearch != "") {
                        $query .= " WHERE s.firstName LIKE ?";
                        $parameters[] = "%".$namesearch."%";
                        $types = 's';
                    } 
                    elseif ($datesearch != "") {
                        $query .= " WHERE a.appointmentDate = ?";
                        $parameters[] = $datesearch;
                        $types = 's';
                    }
                    if(isset($_POST['complete']))
                    {
                        $query .= " AND completion = 0";
                    }

                    
                    }
                    $que = $mysqli->prepare($query);
                    if(!empty($parameters))
                    {
                        $que -> bind_param($types,...$parameters);
                    }
                    if($que->execute())
                    {
                        $results = $que->get_result();
                        while($row = $results->fetch_assoc())
                        {
                            
                            echo '<tr>';
                            echo    '<td>'.$row['ad'].'</td>';
                            echo    '<td>'.$row['at'].'</td>';
                            echo    '<td>'.$row['sfn'].'</td>'; 
                            echo    '<td>'.$row['pfn'].'</td>';
                            echo    '<td>'.$row['nid'].'</td>';
                            echo    '<td style="word-break: break-all; overflow: auto; ">'.$row['reason'].'</td>';
                            if($row['com'] == 0)
                            {
                                echo    '<td>Active</td>';
                            }
                            elseif($row['com'] == 1)
                            {
                                echo    '<td>Completed</td>';
                            }
                            else
                            {
                                echo '<td>CANCELLED</td>';
                            }
                            echo '<td>';
                            echo '<form action = "updateapp.php" method = "post">';
                            echo '<input type="hidden" name="id" value="' . $row['aid'] . '">';
                            echo '<input type = "submit" value = "Edit">';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }

                    
                ?>
                </table>
                <form action="Adminmanager.php" method="post">
                    <div class="form-groupmyapp">
                    <button type="submit" name="myappexit" >Return</button>
                    </div>
                </form>
            </div>
        















    
    <div class="appformcontainer">
    <p><u>Create Appointment</u></p>
    <form action = "adminappointment.php" method ="post">
                <div class="form-group">
                    <label for="dateapp">Select Date:</label>
                    <input type="date" id="dateapp" name="dateapp" min="<?php echo $today; ?>" required>
                    <input type="submit" name = "subdate" value = "Confirm Date">
                </div>
     </form>
        <form action = "adminappointment.php" method ="post">
            
            
            
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
                <label >National ID:</label>
                <input type="text" name="nationalid" required>
            </div>
            <input type = "hidden" name="formType" value="adappointment"/>
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
                    $combid = $mysqli->prepare("SELECT * FROM patient WHERE nationalID = ?");
                    $combid -> bind_param("s",$_POST['nationalid']);
                    if($combid->execute())
                    {
                        $idresults = $combid->get_result();
                        if($idresults -> num_rows === 0)
                        {
                            echo '<span style = "color: red; font-size: 12px;">NATIONAL ID DOES NOT EXIST IN DATABASE!</span>';
                        }
                        else
                        {
                            $date = $_SESSION['dateapp'];
                            $time = $_POST['timeapp'];
                            $doc = $_POST['doctor'];
                            $reason = $_POST['reason'];
                            $natid = $idresults->fetch_assoc();
                            $patientID = $natid['patientID'];

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

                                            header('Location: adminappointment.php');
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

                        }
                        $check->close();

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
</body>
</html> 