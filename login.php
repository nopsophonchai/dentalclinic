<!doctype html > 
<?php require_once('connect.php')?>
<html> 
    <head> 
        <title> Dentiste </title>
        <link rel="stylesheet" type="text/css" href="style.css"> 
    </head>
    <body>
        <div class="container">
        <div class="logo-container">
        </div>
        <div class="login-form">
        
        <form action="login.php" method="post">
            <input type = "hidden" name="formType" value="login"/>
            <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group"></div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            
        </div>
        <?php
        if (isset($_POST['sub'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

           
            $stmt = $mysqli->prepare("SELECT * FROM userAccounts WHERE Username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                
                echo "<span style = 'color: red'>Username does not exist!</span>";
            } else {
                $row = $result->fetch_assoc();
                if ($password == $row['Password']) {
                    header("Location: dentalindex.php");
                    exit;
                } else {
                    echo '<span style = "color: red">Incorrect Password</span>';
                    echo '<pre>';
                    print_r($row);
                    echo '</pre>';
                }
            }
        }
        ?>
            <input type="submit" value="Login" name = "sub">
        </form>
        


        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</html>