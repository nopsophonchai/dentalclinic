<?php

    if(isset($_POST['myappexit'])){
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
            <h2 class="signup-heading"> My Appointments </h2>
            <table> 
                <col width="25%">
                <col width="50%">
                <col width="25%">
               
                <tr> 
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Reason</th>
                </tr>

                <tr>

                <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <!--
                <table>
                <col width="10%">
                <col width="20%">
                <col width="30%">
                <col width="30%">
                <col width="5%">
                <col width="5%">

                <tr>
                    <th>Group Code</th> 
                    <th>Group Name</th>
                    <th>Remark</th>
                    <th>URL</th>
                    <th>Edit</th>
                    <th>Del</th>
                </tr>
                -->
            <form action="mainpage.php" method="post">

            <div class="form-groupmyapp">
                        <button type="submit" name="myappexit" >Return</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>