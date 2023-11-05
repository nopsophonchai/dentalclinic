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
        <div class="signup-form">
        <h2 class="signup-heading"> Main Page </h2>
            <form action="dentalIndex.php" method="post">
                    <input type = "hidden" name="formType" value="signup"/>
            
                <div class="form-groupapp">
                        <button type="submit" name="myprofile" >My Profile</button>
                </div>
                <div class="form-groupapp">
                    <button type="submit" name="myapp" >My Appointments</button>
                </div>
                <div class="form-groupapp">
                    <button type="submit" name="dentalrecords" >Dental Records</button>
                </div>
                <div class="form-groupapp">
                    <button type="submit" name="Billing History" >Billing History</button>
                </div>
                    <div class="form-groupapp">
                    <button type="submit" name="Log out" >Log Out</button>
                </div>
            </form>
        </div>
    <div class="appformcontainer">
        <p><u>Appointmet fillout form </u></p>
        <div class="form-group">
            <label for="dateapp">Select Date:</label>
            <input type="date" id="dateapp" name="dateapp" required>
        </div>
        <div class="form-group">
            <label for="timeapp">Select Time:</label>
            <input type="time" id="timeapp" name="timeapp" required>
        </div>
        <div class="form-group">
            <label for="Docotr">Select Doctor:</label>
            <select id="Doctor" name="doctor" required>
            <option value= "zues" >Zues</option>
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
    </div>
    </div>
</body>
</html>