<?php
    session_start();
    require_once('../connect.php');
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
    else
    {
        $q = $mysqli->prepare("SELECT AES_DECRYPT(firstName,?) as firstName FROM staff WHERE staffID = ?");
        $q -> bind_param("si",$key,$_SESSION['staffID']);
        if($q->execute())
        {
            $result = $q->get_result();
            $results = $result -> fetch_assoc();
        }
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
        <h1 class = "form-groupAdminmana1"> Welcome <?php echo $results['firstName'];?>.</h1> 
        <div class="create_staff-form1">

            

                    <div></div>
                   <div class="form-groupAdminmana1">
                <form action="stafflookup.php" method="post">
                <input class ="multiline-button"type="submit"style="color: var(--button-text-color);"
               value="Patient and Staff lookup">
                </form>
                   </div>
                   <div class="form-groupAdminmana1">
                <form action="../adminappointment.php" method="post">
                   <input  type="submit"style="color: var(--button-text-color);" value="Appointment">
                </form>
                
                   </div>
                   <div class="form-groupAdminmana1">
            <form action="staffcreatepatient.php" method="post">
                   <input type="submit"style="color: var(--button-text-color);" value="Create Patient">
            </form>
                   </div>
                   <form action="../login.php" method="post">
                   <input class = "hover-button" type="submit"style="color: var(--button-text-color);" name = "log" value="Logout"></form>
                    
                    
                   

        

        </div>
    </div>
</body>
</html>

