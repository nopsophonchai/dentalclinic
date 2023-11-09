<?php require_once('connect.php')?>
<!DOCTYPE html>
<html>
<head>
    <title> Dentiste(Create Staff) </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    
    <div class="container">
        <div class="logo-containersignup">
        </div>
        <div class="create_staff-form">
            <h2 class="signup-heading"> Create Staff </h2>

            <form action="dentalIndex.php" method="post">
                    <input type = "hidden" name = "formType" value = "createstaff"/>
                    <div class="form-group">
                        <label for="first-name">First Name:</label>
                        <input type="text" id="first-name" name="first-name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <input type="text" id="last-name" name= "last-name" required>
                    </div>
                    <div class="form-group">
                        <label>National ID:</label>
                        <input type="text" name = "natid" required>
                    </div>
                    <div class="form-group">
                        <label>Gender:</label>
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label>
                    </div>
                    <div class="form-group">
                        <label>Type:</label>
                        <select name="type" required>
                        <?php
                            $t = $mysqli->prepare("SELECT * FROM type");
                            if($t->execute())
                            {
                                $result = $t->get_result();
                                while($row = $result-> fetch_assoc()){
                                    echo '<option value ="'.$row['typeID'].'">'.$row['typeName'].'</option>';
                                }
                                
                            }
                            else
                            {
                                echo 'error';
                            }
                            $t->close();
                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="salary">Specialty:</label>
                        <input type="text" id="specialty" name="specialty" required>
                    </div>
                    <div class="form-group">
                        <label for="date-of-birth">Date of Birth:</label>
                        <input type="date" id="date-of-birth" name="date-of-birth" required>
                    </div>
                    <div class="form-group">
                        <label>Telephone:</label>
                        <input type="text" name = "telephone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary:</label>
                        <input type="text" id="salary" name="salary" required>
                    </div>
                    
                    
                    <input type="submit" name = "Submitr" value="Submitr" style="color: #FFFFFF;">
                <input type="submit" name="backbutton" value="Back"onClick="window.location='Adminmanager.php';">
            </form>
        </div>
    </div>
</body>
</html>
