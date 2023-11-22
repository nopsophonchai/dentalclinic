<?php 
    session_start();
    if(!isset($_SESSION['adminID']) && !isset($_SESSION['staffID']))
    {
        header("Location: login.php");
        exit();
    }?>
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
        <div class="signup-formlook">
            <h2 class="signup-heading"> Account Lookup </h2>
            <form action="Adminlookupresult.php" method="post">
                    <div class="form-grouplooksearch">
                        <input type="text" id="SearchText" name="SearchText" >
                    </div>
                    <div class="form-grouplook">
                    <button class = "buttonlook"type="submit" name="searchbutton">Search</button>
                    </form>
                    <button class="buttonlook" type="button" onClick="window.location='Adminmanager.php';">Return</button>
            
        </div>
    </div>
</body>
</html>
