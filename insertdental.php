<?php
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
        <div class="logo-containersignup">
        </div>
        <div class="formgroup">
            <h2 class="signup-heading"> Insert Dental </h2>

            <form action="dentalIndex.php" method="post">
                    <input type = "hidden" name="formType" value="insertdental"/>
                    
                    <div class="form-group">
                        <label for="dental-note">Note:</label>
                        <input type="text" name= "dental-note" required>
                    </div>
                    <div class="form-group">
                        <label for="dental-treatment">Treatment:</label>
                        <input type="text" name= "dental-treatment" required>
                    </div>
                    <div class="form-group">
                        <label for="dental-diagnosis">Diagnosis:</label>
                        <input type="text" name= "dental-diagnosis" required>
                    </div>
                    <div class="form-group">
                        <label >Select Dentist:</label>
                        <select name="doctor">
                        <?php
                            $q = $mysqli->prepare("SELECT staffID,AES_DECRYPT(firstName,?) as firstName,AES_DECRYPT(lastName,?) as lastName,specialty FROM staff WHERE typeID = 1");
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

                <div class="form-groupdentaledit">
                <button type="submit" name="subdental">Submit</button> 
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
