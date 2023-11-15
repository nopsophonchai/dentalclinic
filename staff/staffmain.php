<?php
    session_start();
    if(isset($_POST['log'])) {
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit;
    }
    if(!isset($_SESSION['staffID']))
    {
        header('Location: ../login.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title> Dentiste(Create Staff) </title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    
    <div class="container">
        <div class="logo-containersignup">
        </div>
        <div class="create_staff-form1">

            

                    <div></div>
                   <div class="form-groupAdminmana1">
                <form action="stafflookup.php" method="post">
                   <button type="submit"style="color: var(--button-text-color);">
                    <span style="white-space: nowrap;">Patient And Staff</span>
                    <br>
                    <span style="white-space: nowrap;">Lookup</span>
                    </button>
                </form>
                   </div>
                   <div class="form-groupAdminmana1">
                <form action="../adminappointment.php" method="post">
                   <input type="submit"style="color: var(--button-text-color);" value="Appointment">
                </form>
                
                   </div>
                   <div class="form-groupAdminmana1">
            <form action="../admincreate.php" method="post">
                   <input type="submit"style="color: var(--button-text-color);" value="Create Patient">
            </form>
                   </div>
                   <form action="../login.php" method="post">
                   <input type="submit"style="color: var(--button-text-color);" name = "log" value="Logout"></form>
                    
                    
                   

        

        </div>
    </div>
</body>
</html>

