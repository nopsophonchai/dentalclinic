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
            <h2 class="signup-heading"> Insert Dental </h2>

            <form action="dentalIndex.php" method="post">
                    <input type = "hidden" name="formType" value="insertdental"/>
                    
                    <div class="form-group">
                        <label for="dental-note">Note:</label>
                        <input type="text" name= "dental-note" required>
                    </div>
                    <div class="form-group">
                        <label for="dental-treatment">Treatment:</label>
                        <input type="text" name= "dental-treatment" required>
                    </div>
                    <div class="form-group">
                        <label for="dental-diagnosis">Diagnosis:</label>
                        <input type="text" name= "dental-diagnosis" required>
                    </div>
                    
                    <div class="form-groupdentaledit">
                    <button type="submit" name="subdental">Submit</button> 
                    <button type="button"name="canceldental">Return</button>
                </div>
            </form>
            <div class ="form-groupdentaledit">
            <form action = "admindental.php" method = "post">
                <button type="submit" name="back" >Back</button>
</div></form>
        </div>
    </div>
</body>
</html>
