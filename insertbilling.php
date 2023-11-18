<?php session_start();
?>
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
        <div class="formgroup">
            <h2 class="signup-heading"> <?php echo $_SESSION['patientID'];?>Insert Billing </h2>

            <form action="dentalIndex.php" method="post">
                    <input type = "hidden" name="formType" value="insertbilling"/>
                    <input type = "hidden" name="patientIDBil" value=<?php echo $_SESSION['patientID'];?>/>
                    <div class="form-group">
                        <label for="bill-des">Description:</label>
                        <input type="text" name= "bill-des" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="bill-amount">Amount:</label>
                        <input type="number" step="0.01" name= "bill-amount" required>
                    </div>
                    
                    <div class="form-groupbilledit">
                    <button type="submit" name="subbill">Submit</button> 
                    <button type="submit" name="cancelbill">Cancel</button>
                </div>
            </form>
            <div class ="form-groupbilledit">
            <form action = "adminbilling.php" method = "post">
                <button type="submit" name="back" >Back</button>
</div></form>
        </div>
    </div>
</body>
</html>
