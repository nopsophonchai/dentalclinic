<?php
    if(isset($_POST["dentexit"])){
        header ("Location: mainpage.php");
        exit;
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title> Dentiste </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="logo-containermyapp">
        </div>
        <div class="signup-form">
            <h2 class="signup-heading"> Dental Records </h2>
            <div class="app-form">
            <table> 
                <col width="20%">
                <col width="20%">
                <col width="20%">
                <col width="20%">

               
                <tr> 
                    <th>Time</th>
                    <th>Diagnosis</th>
                    <th>Treatment</th>
                    <th>Note</th>
                </tr>
                <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>

                </tr>
            </table>
            <form action = "mainpage.php" method="post">

            <div class="form-groupmyapp">
                        <button type="submit" name="dentexit" >Return</button>
                    </div>
</form>
            </div>
        </div>
    </div>
</body>
</html>