<?php
    session_start();
    require_once('../connect.php');
    require_once('adminconfig.php');
    $encryption_key = $key; 
    if(isset($_POST['row_id']))
    {
        $_SESSION['patientID'] = $_POST['row_id'];
    }
    if(!isset($_SESSION['staffID']))
    {
        header('Location: ../login.php');
        exit();
    }
    
?>

<!DOCTYPE html>
<html>
<head>
    <title> Dentiste </title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>



            <?php
            
            
            if (isset($_POST['view_profile'])) { 
                echo "gofirstif";
                $row_id = $_POST['row_id'];
                $table = $_POST['type'];
                $query = "";
                if ($table === 'patient') {
                    $query = "SELECT patientID,AES_DECRYPT(firstName, ?) as firstName,AES_DECRYPT(lastName, ?) as lastName,gender,
                    AES_DECRYPT(nationalID, ?) as nationalID,AES_DECRYPT(telephone, ?) as telephone,AES_DECRYPT(houseAddress, ?) as houseAddress,
                    dateOfBirth FROM patient WHERE patientID = ?";
                } elseif ($table === 'staff') {
                    $query = "SELECT staffID,AES_DECRYPT(staff.firstName, ?) as firstName,AES_DECRYPT(staff.lastName, ?) as lastName,gender,
                    AES_DECRYPT(staff.nationalID, ?) as nationalID,telephone,AES_DECRYPT(staff.houseAddress, ?) as houseAddress,dateOfBirth,
                    avaStat,type.typeName,AES_DECRYPT(staff.specialty, ?) as specialty,AES_DECRYPT(staff.salary, ?) as salary
             FROM staff JOIN type ON staff.typeID = type.typeID WHERE staff.staffID = ?";
                } else {
                    echo "Invalid table type.";
                    exit();
                }

                $stmt = $mysqli->prepare($query);

                if ($stmt) {
                    if ($table === 'patient') {
                        $stmt->bind_param("ssssss", $encryption_key, $encryption_key, $encryption_key, $encryption_key, $encryption_key, $row_id);
                        
                    }
                    elseif ($table === 'staff') {
                        $stmt->bind_param("sssssss", $encryption_key, $encryption_key, $encryption_key, $encryption_key, $encryption_key, $encryption_key, $row_id);
                        }
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $userDetails = $result->fetch_assoc();
                        if($table == 'patient'){
                            $_SESSION['patientID'] = $userDetails['patientID'];}
                            elseif($table == 'staff'){
                                $_SESSION['thisStaff'] = $userDetails['staffID'];}
                              ?>

                        <form action="../dentalIndex.php" method="post">
                            <input type="hidden" name="formType" value="staffview" />

                            <?php
                            if ($table === 'patient') {
                                ?>
                                <div class="container">
                                        
                                        <div class="logo-containersignup">
                                        <div class="form-groupmyprof1">

                                        <div class="form-groupmyprof">
                                                <button type="submit" name="dentalrecords" >Dental Records</button>
                                                </div>
                                                
                                                <div class="form-groupmyprof">
                                                <button type="submit" name="adminbilling" >Billing History</button>
                                </div>
                                </div>
                                        </div>
                                        <div class="signup-form">
                                            <h2 class="signup-heading"> My profile</h2>

                                            <form action="../dentalIndex.php" method="post">
                                            <input type="hidden" name="formType" value="staffview" />
                                                    <div class="form-group">
                                                        <label for="first-name">First Name:</label>
                                                        <?php echo '<label>'.$userDetails['firstName'].'</label>'; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="last-name">Last Name:</label>
                                                        <?php echo '<label>'.$userDetails['lastName'].'</label>'; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="natid">National ID:</label>
                                                        <?php echo '<label>'.$userDetails['nationalID'].'</label>'; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Gender:</label>
                                                        <?php echo '<label>'.$userDetails['gender'].'</label>'; ?>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="date-of-birth">Date of Birth:</label>
                                                        <?php echo '<label>'.$userDetails['dateOfBirth'].'</label>'; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="telephone">Telephone:</label>
                                                        <?php echo '<label>'.$userDetails['telephone'].'</label>'; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address">Address:</label>
                                                        <?php echo '<label>'.$userDetails['houseAddress'].'</label>'; ?>
                                                    </div>
                                                    
                                                    <div class="form-groupmy">
                                                    <form action="../editpatientforadmin.php" method="post">
                                                    <input type="hidden" name="patientID" value="<?php echo $_SESSION['patientID']; ?>"/>
                                                        <button type="submit" name="editpatient" >Edit</button>
                                                        </form>
                                                        <button type="submit" name="myprofexittolookup" >Return</button>
                                                    </div>
                                                </div>
                                            
                                            </form>
                                        </div>
                                    </div>
                                <?php
                            } elseif ($table === 'staff') {
                                // Display staff-specific information
                                ?>
                                 <div class="container">
        
        <div class="logo-containersignup">
        <div class="form-groupmyprof1">

        
                
           
</div>
        </div>
        <div class="signup-form">
            <h2 class="signup-heading"> My profile <?php echo $_SESSION['staffID']." ".$_SESSION['thisStaff'];?></h2>

            <form action="../dentalIndex.php" method="post">
                    <input type = "hidden" name="formType" value="staffview"/>
                    <div class="form-group">
                        <label for="first-name">First Name:</label>
                        <?php echo '<label>'.$userDetails['firstName'].'</label>'; ?>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <?php echo '<label>'.$userDetails['lastName'].'</label>'; ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Gender:</label>
                        <?php echo '<label>'.$userDetails['gender'].'</label>'; ?>
                        </div> <div class="form-group">
                        <label for="telephone">Type:</label>
                        <?php echo '<label>'.$userDetails['typeName'].'</label>'; ?>
                    
                    </div>
                    <div class="form-group">
                        <label for="date-of-birth">Date of Birth:</label>
                        <?php echo '<label>'.$userDetails['dateOfBirth'].'</label>'; ?>
                    </div>
                    <?php if($_SESSION['staffID'] == $_SESSION['thisStaff'])
                    { ?>
                    <div class="form-group">
                        <label for="address">Salary:</label>
                        <?php echo '<label>'.$userDetails['salary'].'</label>'; ?>
                    </div>
                    <?php }?>
                    <div class="form-group">
                        <label for="address">Status:</label>
                        <?php if($userDetails['avaStat'] == 0)
                        {
                            echo '<label>Unavailable</label>'; 
                        }
                        else
                        {
                            echo '<label>Available</label>'; 
                        }
                        ?>
                    </div>
                    <div class="form-groupmy">
                        
                        <button type="submit" name="myprofexittolookup" >Return</button>
                    </div>
                    
                </div>
               
            </form>
            <form action = "staffview.php?type=staff" method = "post">
                <?php if($_SESSION['staffID'] == $_SESSION['thisStaff'])
                    { ?>
                <input type = "submit" name="statusset" value= "Set Status">
                    </form>
                    <?php 
                    
                        if(isset($_POST['statusset']))
                        {
                            $statusNum = 0;
                            if($userDetails['avaStat'] === 0)
                            {
                                $statusNum = 1;
                                $userDetails['avaStat'] = 1;
                            }
                            $st = $mysqli->prepare("UPDATE staff SET avaStat = ? WHERE staffID = ?");
                            $st -> bind_param("ii",$statusNum,$_SESSION['thisStaff']);
                            if($st->execute())
                            {
                                
                                header("Location: staffview.php?type=staff");
                            }
                        }
                    
                    ?>
                    <?php }?>
        </div>
    </div>
                                <?php
                            }
                            ?>

                            
                        </form>

                    <?php
                    } else {
                        echo "Record not found for ID: $row_id in table: $table";
                    }

                    $stmt->close();
                } else {
                    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                }
            }elseif (isset($_GET['type'])) { $type = $_GET['type'];
                if($type === 'patient'){
                echo "gosecondif";
                $row_id = $_SESSION['patientID'];
    $table = $_POST['type'];
    $query = "";
                
    $query = "SELECT patientID,AES_DECRYPT(firstName, ?) as firstName,AES_DECRYPT(lastName, ?) as lastName,gender,
    AES_DECRYPT(nationalID, ?) as nationalID,AES_DECRYPT(telephone, ?) as telephone,AES_DECRYPT(houseAddress, ?) as houseAddress,
    dateOfBirth FROM patient WHERE patientID = ?";
                
                $stmt = $mysqli->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("ssssss", $encryption_key, $encryption_key, $encryption_key, $encryption_key, $encryption_key, $row_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $userDetails = $result->fetch_assoc();
                        
                            $_SESSION['patientID'] = $userDetails['patientID'];
                              ?>

                        <form action="../dentalIndex.php" method="post">
                            <input type="hidden" name="formType" value="staffview" />

                            <?php
                             
                                // Display patient-specific information
                                ?>
                                   <div class="container">
        
        <div class="logo-containersignup">
        <div class="form-groupmyprof1">

        <div class="form-groupmyprof">
                <button type="submit" name="dentalrecords" >Dental Records</button>
                </div>
                
                <div class="form-groupmyprof">
                <button type="submit" name="adminbilling" >Billing History</button>
</div>
</div>
        </div>
        <div class="signup-form">
            <h2 class="signup-heading"> My profile</h2>

            <form action="../dentalIndex.php" method="post">
            <input type="hidden" name="formType" value="staffview" />
                    <div class="form-group">
                        <label for="first-name">First Name:</label>
                        <?php echo '<label>'.$userDetails['firstName'].'</label>'; ?>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <?php echo '<label>'.$userDetails['lastName'].'</label>'; ?>
                    </div>
                    <div class="form-group">
                        <label for="natid">National ID:</label>
                        <?php echo '<label>'.$userDetails['nationalID'].'</label>'; ?>
                    </div>
                    <div class="form-group">
                        <label>Gender:</label>
                        <?php echo '<label>'.$userDetails['gender'].'</label>'; ?>

                    </div>
                    <div class="form-group">
                        <label for="date-of-birth">Date of Birth:</label>
                        <?php echo '<label>'.$userDetails['dateOfBirth'].'</label>'; ?>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telephone:</label>
                        <?php echo '<label>'.$userDetails['telephone'].'</label>'; ?>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <?php echo '<label>'.$userDetails['houseAddress'].'</label>'; ?>
                    </div>
                    
                    <div class="form-groupmy">
                    <form action="../editpatientforadmin.php" method="post">
                    <input type="hidden" name="patientID" value="<?php echo $_SESSION['patientID']; ?>"/>
                        <button type="submit" name="editpatient" >Edit</button>
                        </form>
                        <button type="submit" name="myprofexittolookup" >Return</button>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
                                <?php
                            
                                // Display staff-specific information
                                ?>
                                 

                    <?php
                    } else {
                        echo "Record not found for ID: $row_id in table: $table";
                    }

                    $stmt->close();
                } else {
                    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                }
            } 
            if($type === 'staff'){echo "gothirdif";
                $row_id = $_SESSION['thisStaff'];
    $table = $_POST['type'];
                
                
    $query = "SELECT staffID,AES_DECRYPT(staff.firstName, ?) as firstName,AES_DECRYPT(staff.lastName, ?) as lastName,gender,
    AES_DECRYPT(staff.nationalID, ?) as nationalID,telephone,AES_DECRYPT(staff.houseAddress, ?) as houseAddress,dateOfBirth,
    avaStat,type.typeName,AES_DECRYPT(staff.specialty, ?) as specialty,AES_DECRYPT(staff.salary, ?) as salary
    FROM staff JOIN type ON staff.typeID = type.typeID WHERE staff.staffID = ?";
    
    $stmt = $mysqli->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("sssssss", $encryption_key, $encryption_key, $encryption_key, $encryption_key, $encryption_key, $encryption_key, $row_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $userDetails = $result->fetch_assoc();
                        
                            $_SESSION['thisStaff'] = $userDetails['staffID'];
                              ?>

                        <form action="../dentalIndex.php" method="post">
                            <input type="hidden" name="formType" value="staffview" />

                            <?php
                             
                                // Display patient-specific information
                                ?>
                                   <div class="container">
        
        <div class="logo-containersignup">
        
        </div>
        <div class="signup-form">
            <h2 class="signup-heading"> My profile</h2>

            <form action="../dentalIndex.php" method="post">
                    <input type = "hidden" name="formType" value="staffview"/>
                    <div class="form-group">
                        <label for="first-name">First Name:</label>
                        <?php echo '<label>'.$userDetails['firstName'].'</label>'; ?>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <?php echo '<label>'.$userDetails['lastName'].'</label>'; ?>
                    </div>
                    
                    <div class="form-group">
                        <label>Gender:</label>
                        <?php echo '<label>'.$userDetails['gender'].'</label>'; ?>
                        </div> <div class="form-group">
                        <label for="telephone">Type:</label>
                        <?php echo '<label>'.$userDetails['typeName'].'</label>'; ?>
                    
                    </div>
                    <div class="form-group">
                        <label for="date-of-birth">Date of Birth:</label>
                        <?php echo '<label>'.$userDetails['dateOfBirth'].'</label>'; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Salary:</label>
                        <?php echo '<label>'.$userDetails['salary'].'</label>'; ?>
                    </div>
                    <div class="form-group">
                        <label for="address">Status:</label>
                        <?php if($userDetails['avaStat'] == 0)
                        {
                            echo '<label>Unavailable</label>'; 
                        }
                        else
                        {
                            echo '<label>Available</label>'; 
                        }
                        ?>
                    </div>
                    <div class="form-groupmy">
    
                        <button type="submit" name="myprofexittolookup" >Return</button>
                    </div>
                </div>
               
            </form>
            <?php if($_SESSION['staffID'] == $_SESSION['thisStaff']) { ?>
            <form action = "../dentalIndex.php" method = "post">
                <input type = "hidden" name = "formType" value = "status">
                <input type = "hidden" name = "avaStat" value = <?php echo $userDetails['avaStat']?>>
                <input type = "hidden" name = "staffID" value = <?php echo $_SESSION['thisStaff']?>>
                <input type = "submit" name="statusset" value= "Set Status">
                    </form>
                    <?php 
                       } 
                    ?>
                    
        </div>
    </div>
                                <?php
                            
                                // Display staff-specific information
                                ?>
                                 

                    <?php
                    } else {
                        echo "Record not found for ID: $row_id in table: $table";
                    }

                    $stmt->close();
                } else {
                    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                }}
        }
            $mysqli->close();
            ?>

        </div>
    </div>
</body>

</html>
