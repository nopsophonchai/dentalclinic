<?php

    if(isset($_POST["mainpage.php"])){
        header("Location: mainpage.php");
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
            <h2 class="signup-heading"> Billing History </h2>
            <div class="app-form">
            <table> 
                <col width="20%">
                <col width="20%">
                <col width="20%">

               
                <tr> 
                    <th>Time</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
                <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>


            </table>
            <form action = "mainpage.php" method ="post">
            <div class="form-groupmyapp">
                        <button type="submit" name="billexit" >Return</button>
                    </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>