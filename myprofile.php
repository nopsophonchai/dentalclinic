<!DOCTYPE html>
<html>
<head>
    <title> Dentiste </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        
        <div class="logo-containersignup">
        <div class="form-groupmyprof1">

        <div class="form-groupmyprof">
                <button type="submit" name="dentalrecords" >Dental Records</button>
                </div>
                <div class="form-groupmyprof">
                <button type="submit" name="Billing History" >Billing History</button>
</div>
</div>
        </div>
        <div class="signup-form">
            <h2 class="signup-heading"> My profile</h2>

            <form action="dentalIndex.php" method="post">
                    <input type = "hidden" name="formType" value="signup"/>
                    <div class="form-group">
                        <label for="first-name">First Name:</label>
                        <input type="text" id="first-name" name="first-name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <input type="text" id="last-name" name= "last-name" required>
                    </div>
                    <div class="form-group">
                        <label for="natid">National ID:</label>
                        <input type="text" id="natid" name= "natid" required>
                    </div>
                    <div class="form-group">
                        <label>Gender:</label>
                        <input type="radio" id="male" name="gender" value="male">
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="female">Female</label>
                    </div>
                    <div class="form-group">
                        <label for="date-of-birth">Date of Birth:</label>
                        <input type="date" id="date-of-birth" name="date-of-birth" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telephone:</label>
                        <input type="text" id="telephone" name="telephone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                    
                    <div class="form-groupmy">
                        <button type="submit" name="edit" >Edit</button>
                        <button type="submit" name="exit" >Exit</button>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
</body>
</html>