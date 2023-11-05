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

            <form action="createstaff.php" method="post">
                    <div class="form-group">
                        <label for="first-name">First Name:</label>
                        <input type="text" id="first-name" name="first-name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <input type="text" id="last-name" name= "last-name" required>
                    </div>
                    <div class="form-group">
                        <label>Gender:</label>
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label>
                    </div>
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <input type="text" id="type" name="type" required>
                    </div>
                    <div class="form-group">
                        <label for="date-of-birth">Date of Birth:</label>
                        <input type="date" id="date-of-birth" name="date-of-birth" required>
                    </div>
                    <div class="form-group">
                        <label for="salary">Salary:</label>
                        <input type="text" id="salary" name="salary" required>
                    </div>
                    
                    
                    <input type="submit" value="Submit" style="color: #FFFFFF;">
                <input type="submit" name="backbutton" value="Back"onClick="window.location='Adminmanager.php';">
            </form>
        </div>
    </div>
</body>
</html>
