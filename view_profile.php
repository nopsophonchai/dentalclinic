<!DOCTYPE html>
<html>

<head>
    <title> Dentiste </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>



            <?php
            // Assuming you have a database connection established
            session_start();
            require_once('connect.php');


            if (isset($_POST['view_profile'])) {
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
                        ?>

                        <form action="dentalIndex.php" method="post">
                            <input type="hidden" name="formType" value="view_profile" />

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
                
                <form action="billing_history.php" method="post">
    <input type="hidden" name="patientID" value="<?php echo $userDetails['patientID'];?>">
    <button type="submit" name="Billing History">Billing History</button>
</form>
</div>
        </div></form>
        <div class="signup-form">
            <h2 class="signup-heading"> My profile</h2>

            <form action="dentalIndex.php" method="post">
                    <input type = "hidden" name="formType" value="myprofile"/>
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
                        <button type="submit" name="edit" >Edit</button>
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
                    <input type = "hidden" name="formType" value="myprofile"/>
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
                        <button type="submit" name="edit" >Edit</button>
                        <button type="submit" name="myprofexittolookup" >Return</button>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
                                <?php
                            }
                            ?>

                            <div class="form-groupmy">
                                <button type="submit" name="edit">Edit</button>
                                <button type="submit" name="myprofexit">Return</button>
                            </div>
                        </form>

                    <?php
                    } else {
                        echo "Record not found for ID: $row_id in table: $table";
                    }

                    $stmt->close();
                } else {
                    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                }
            }

            // Close the database connection when done
            $mysqli->close();
            ?>

        </div>
    </div>
</body>

</html>
