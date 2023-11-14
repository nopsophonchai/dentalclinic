<?php
    session_start();
    require_once('connect.php');
    if(isset($_POST['row_id']))
    {
        $_SESSION['patientID'] = $_POST['row_id'];
    }
    
?>

<!DOCTYPE html>
<html>

<head>
    <title> Dentiste </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>



            <?php
            
            
            if (isset($_POST['view_profile'])) { 
                echo "gofirstif";
                $row_id = $_POST['row_id'];
    $table = $_POST['type'];
                $query = "";
                if ($table === 'patient') {
                    $query = "SELECT * FROM patient WHERE patientID = ?";
                } elseif ($table === 'staff') {
                    $query = "SELECT staff.*, type.typeName FROM staff JOIN type ON staff.typeID = type.typeID WHERE staffID = ?";
                } else {
                    echo "Invalid table type.";
                    exit();
                }

                $stmt = $mysqli->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("s", $row_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $userDetails = $result->fetch_assoc();
                        if($table === 'patient'){
                            $_SESSION['patientID'] = $userDetails['patientID'];}
                            elseif($table === 'staff'){
                                $_SESSION['staffID'] = $userDetails['staffID'];}
                              ?>

                        <form action="dentalIndex.php" method="post">
                            <input type="hidden" name="formType" value="viewprofile" />

                            <?php
                            if ($table === 'patient') {
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

            <form action="dentalIndex.php" method="post">
            <input type="hidden" name="formType" value="viewprofile" />
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
                    <form action="editpatientforadmin.php" method="post">
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
            <h2 class="signup-heading"> My profile</h2>

            <form action="dentalIndex.php" method="post">
                    <input type = "hidden" name="formType" value="viewprofile"/>
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
                        <?php echo '<label>'.$userDetails['avaStat'].'</label>'; ?>
                    </div>
                    <div class="form-groupmy">
                        <form action="editstaffforadmin.php" method="post">
                    <input type="hidden" name="staffID" value="<?php echo $_SESSION['staffID']; ?>"/>
                        <button type="submit" name="editstaff" >Edit</button>
                        </form>
                        <button type="submit" name="myprofexittolookup" >Return</button>
                    </div>
                </div>
               
            </form>
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
            }elseif (!isset($_POST['view_profile'])&&(isset($_SESSION['patientID']))) { 
                echo "gosecondif";
                $row_id = $_SESSION['patientID'];
    $table = $_POST['type'];
                $query = "";
                
                    $query = "SELECT * FROM patient WHERE patientID = ?";
                
                $stmt = $mysqli->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("s", $row_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $userDetails = $result->fetch_assoc();
                        
                            $_SESSION['patientID'] = $userDetails['patientID'];
                              ?>

                        <form action="dentalIndex.php" method="post">
                            <input type="hidden" name="formType" value="viewprofile" />

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

            <form action="dentalIndex.php" method="post">
            <input type="hidden" name="formType" value="viewprofile" />
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
                    <form action="editpatientforadmin.php" method="post">
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
            } /*elseif (!isset($_POST['view_profile'])&&(isset($_SESSION['staffID']))) { 
                echo "gothirdif";
                $row_id = $_SESSION['staffID'];
    $table = $_POST['type'];
                
                
                $query = "SELECT staff.*, type.typeName FROM staff JOIN type ON staff.typeID = type.typeID WHERE staffID = ?";
                
                $stmt = $mysqli->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("s", $row_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $userDetails = $result->fetch_assoc();
                        
                            $_SESSION['staffID'] = $userDetails['staffID'];
                              ?>

                        <form action="dentalIndex.php" method="post">
                            <input type="hidden" name="formType" value="viewprofile" />

                            <?php
                             
                                // Display patient-specific information
                                ?>
                                   <div class="container">
        
        <div class="logo-containersignup">
        
        </div>
        <div class="signup-form">
            <h2 class="signup-heading"> My profile</h2>

            <form action="dentalIndex.php" method="post">
                    <input type = "hidden" name="formType" value="viewprofile"/>
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
                        <?php echo '<label>'.$userDetails['avaStat'].'</label>'; ?>
                    </div>
                    <div class="form-groupmy">
                        <form action="editstaffforadmin.php" method="post">
                    <input type="hidden" name="staffID" value="<?php echo $_SESSION['staffID']; ?>"/>
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
            }*/

            // Close the database connection when done
            $mysqli->close();
            ?>

        </div>
    </div>
</body>

</html>