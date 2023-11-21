<?php
session_start();
require_once('connect.php');
$today = date("Y-m-d");
if(!isset($_SESSION['adminID']) && !isset($_SESSION['staffID']))
    {
        header("Location: login.php");
        exit();
    }
if(isset($_POST['myappexit']))
{
    if(isset($_SESSION['adminID']))
    {
        header("Location: Adminmanager.php");
        exit();
    }
    elseif(isset($_SESSION['staffID']))
    {
        header("Location: staff/staffmain.php");
        exit();
    }
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
                <div class ="checkapp">
                    <div class ="sepapp">
                    <div class = "form-group">
                        <form action = "adminappointment.php" method = "post">
                        <label>Search By Dentist:</label>
                        <input type="text" name="searchName">
                    </div>
                    <div class = "form-group">
                        <label>Search By Patient National ID:</label>
                        <input type="text" name="searchPatient">
                    </div>
                    <div class = "form-group">
                        <label>Search By Date:</label>
                        <input type="date" name="searchDate">
                    </div>
                    <div class="form-group">
                        <label>Show Active Appointments Only:</label>
                        <input type="checkbox" name="complete" value = 1>
                    </div>
                    <div class="form-group1">
                        <button type = "submit" name = "subsearch">Search</button>   
                    </form>
                    <form action="adminappointment.php" method="post">
                    <button type="submit" name="myappexit" >Return</button>
                </form>
            </div>
                </div>
        
        <div class="appformcontainer1">
        <form action = "adminappointment.php" method ="post">
                    <div class="appformcontainertime">  
                        <div class = "form-groupapptime"> 
                         <p><u>Create Appointment</u></p>
                        <label for="dateapp">Select Date:</label>
                        <input type="date" id="dateapp" name="dateapp" min="<?php echo $today; ?>" required>   
                         </div>
                        <div class = "form-groupapp1">
                        <input type="submit" name = "subdate" value = "Confirm Date"></div>
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
                        
    
                ?></div>
                <div class="appformcontainerreason">
                <div class="form-groupapp">
                    <label >National ID:</label>
                    <input type="text" name="nationalid" maxlength = "13" required>
                </div>
                <input type = "hidden" name="formType" value="adappointment"/>
                <div class="form-groupapp">
                    <label for="Docotr">Select Dentist:</label>
                    <select id="Doctor" name="doctor">
                    <?php
                        $q = $mysqli->prepare("SELECT staffID,AES_DECRYPT(firstName,?) as firstName,AES_DECRYPT(lastName,?) as lastName,specialty FROM staff WHERE typeID = 1 AND avaStat = 1");
                        $q -> bind_param("ss", $key,$key);
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
                <div class="form-groupapp1">
                    <input type="submit" name ="submitapp" value="Submit">
                    <input type="submit"  name="cancelapp" value="Cancel">
                </div>
                <?php } ?>
            </div>
                <?php
                    if(isset($_POST['submitapp']))
                    {
                        $combid = $mysqli->prepare("SELECT * FROM patient WHERE nationalID = AES_ENCRYPT(?,?)");
                        $combid -> bind_param("ss",$_POST['nationalid'],$key);
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
    
                                $check = $mysqli->prepare("SELECT * FROM appointment WHERE appointmentDate = AES_ENCRYPT(?,?) AND appointmentTime = AES_ENCRYPT(?,?) AND reason = AES_ENCRYPT(?,?)");
                                $check -> bind_param("ssssss",$date,$key,$time,$key,$reason,$key);
                                if($check->execute())
                                {
                                    $checkresult = $check->get_result();
                                    if($checkresult -> num_rows === 0)
                                    {
                                        $ins = $mysqli->prepare("INSERT INTO appointment (appointmentDate,appointmentTime,reason,staffID,patientID,completion) VALUES (?,?,AES_ENCRYPT(?,?),?,?,0)");
                                            $ins -> bind_param("ssssii",$date,$time,$reason,$key,$doc,$patientID);
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
                </div>

                <br>
                </br>
                <div class="admintable">
                <table style="table-layout: fixed; width: 80%;"> 
                    <colgroup>
                        <col style="width: 13%;">
                        <col style="width: 13%;">
                        <col style="width: 13%;">
                        <col style="width: 13%;">
                        <col style="width: 13%;">
                        <col style="width: 13%;">
                        <col style="width: 12.5%;">
                        <col style="width: 12.5%;">
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
                    $query = "SELECT a.appointmentID as aid, a.appointmentDate as ad, a.appointmentTime as at, AES_DECRYPT(s.firstName,'dental') as sfn, AES_DECRYPT(p.firstName,'dental') as pfn, AES_DECRYPT(p.nationalID,'dental') as nid, AES_DECRYPT(a.reason,'dental') as reason,a.completion as com FROM appointment a JOIN patient p ON p.patientID = a.patientID JOIN staff s ON s.staffID = a.staffID ";
                    $parameters = [];
                    $types = '';

                    if (isset($_POST['subsearch'])) {
                        $namesearch = $_POST['searchName'] ?? "";
                        $datesearch = $_POST['searchDate'] ?? "";
                        $patsearch = $_POST['searchPatient'] ?? "";

                        if ($namesearch != "" || $datesearch != "" || $patsearch != "") {
                            $query .= "WHERE ";

                            if ($namesearch != "") {
                                $query .= "LOWER(CONVERT(AES_DECRYPT(s.firstName, 'dental') USING utf8) ) LIKE LOWER(?)";
                                $parameters[] = "%" . $namesearch . "%";
                                $types .= 's';
                            }

                            if ($datesearch != "") {
                                if ($namesearch != "") {
                                    $query .= " AND ";
                                }
                                $query .= "a.appointmentDate = ?";
                                $parameters[] = $datesearch;
                                $types .= 's';
                            }

                            if ($patsearch != "") {
                                if ($namesearch != "" || $datesearch != "") {
                                    $query .= " AND ";
                                }
                                $query .= "LOWER(AES_DECRYPT(p.nationalID, 'dental')) LIKE LOWER(?)";
                                $parameters[] = "%" . $patsearch . "%";
                                $types .= 's';
                            }

                            if (isset($_POST['complete'])) {
                                $query .= " AND a.completion = 0";
                            }
                        }
                        else
                        {
                            if (isset($_POST['complete'])) {
                                $query .= "WHERE a.completion = 0";
                            }
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
                </div>
</div>
</body>
</html> 