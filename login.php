<!DOCTYPE html > 
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

            $stmt2 = $mysqli->prepare("SELECT * FROM staffAccounts WHERE Username = ?");
            $stmt2->bind_param("s",$username);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $stmt->execute();
                if ($stmt2->errno) {
                    // handle error here
                    echo "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error;
                }



            
            
            if($result2->num_rows === 0)
            {
                if ($result->num_rows === 0) {
                
                    echo "<span style = 'color: red'>Username does not exist!</span>";
                } else {
                    $row = $result->fetch_assoc();
                    if (password_verify($password,$row['Password'])) {
                        header("Location: Adminmanager.php");
                        
                    } else {
                        echo '<span style = "color: red">Incorrect Password</span>';
                    
                    }
                }
            }
            else
            {
                ini_set('display_errors', 1);
                error_reporting(E_ALL);

                $row = $result2->fetch_assoc();
                if(password_verify($password,$row['Password']))
                {
                    header("Location: Adminmanager.php");
                }
                else
                {
                    echo '<span style = "color: red">Incorrect Password</span>';
                    echo '<span style = "color: red">'.$row['Password'].'</span>';
                }
                
            }
            $stmt -> close();
            $stmt2->close();
            
        }
  
        ?>
            <input type="submit" value="Login" name = "sub">
        </form>
        


        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</html>