<?php
session_start();
require_once('connect.php');



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
                        </label>
                    </div>
                    <div>
                        <button type = "submit" name = "subsearch">Search</button>
                    </div>
                    </form>
                </div>
                <br>
</br>
                <table> 
                    <col width="10%" >
                    <col width="10%">
                    <col width="15%">
                    <col width="25%">
                    <col width="25%">
                    <col width="50%">
                
                    <tr> 
                        <th>Date</th>
                        <th>Time</th>
                        <th>Dentist</th>
                        <th>Patient</th>
                        <th>Patient National ID</th>
                        <th>Reason</th>
                    </tr>
                    <?php
                    $query = "SELECT a.appointmentDate as ad, a.appointmentTime as at, s.firstName as sfn, p.firstName as pfn, p.nationalID as nid, a.reason as reason FROM appointment a JOIN patient p ON p.patientID = a.patientID JOIN staff s ON s.staffID = a.staffID ";
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
                            echo    '<td>'.$row['reason'].'</td>';
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
        <form action = "adminappointment.php" method ="post">
            <p><u>Create Appointment</u></p>
            <div class="form-group">
                <label >National ID:</label>
                <input type="text" name="nationalid" required>
            </div>
            <input type = "hidden" name="formType" value="adappointment"/>
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
                            $date = $_POST['dateapp'];
                            $time = $_POST['timeapp'];
                            $doc = $_POST['doctor'];
                            $reason = $_POST['reason'];
                            $natid = $idresults->fetch_assoc();
                            $patientID = $natid['patientID'];
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
                    $combid->close();
                }
            ?>
        </form>
    </div>
</body>
</html> 