<!DOCTYPE html>
<html>
<head>
    <title>Dentiste</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
    <div class="logo-containersignup">
        </div>
        <div class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="#" class="menu-button">My Profile</a></li>
                <li><a href="#" class="menu-button">Dental Records</a></li>
                <li><a href="#" class="menu-button">Billing History</a></li>
                <li><a href="#" class="menu-button">My Appointments</a></li>
                <li><a href="#" class="menu-button">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h2>Appointment Form</h2>
            <form action="appointment.php" method="post" class="login-form">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="doctor">Doctor:</label>
                    <select id="doctor" name="doctor" required>
                        <option value="dr_smith">Dr. Smith</option>
                        <option value="dr_jones">Dr. Jones</option>
                        <option value="dr_doe">Dr. Doe</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="reason">Reason for Appointment:</label>
                    <textarea id="reason" name="reason" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit">
                    <input type="reset" value="Cancel">
                </div>
            </form>
        </div>
    </div>
</body>
</html>