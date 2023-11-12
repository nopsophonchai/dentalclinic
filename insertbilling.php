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
            <h2 class="signup-heading"> Insert Billing </h2>

            <form action="dentalIndex.php" method="post">
                    <input type = "hidden" name="formType" value="insertbilling"/>
                    <div class="form-group">
                        <label for="bill-time">Time:</label>
                        <input type="datetime-local"name="bill-time" required>
                    </div>
                    <div class="form-group">
                        <label for="bill-des">Description:</label>
                        <input type="text" name= "bill-des" required>
                    </div>
                    <div class="form-group">
                        <label for="bill-amount">Amount:</label>
                        <input type="text" name= "bill-amount" required>
                    </div>
                    
                    <div class="form-groupbill">
                    <input type="submit" name="subbill" value="Submit"> 
                    <input type="submit" name="cancelbill" value="Cancel">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
