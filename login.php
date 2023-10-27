<!doctype html > 
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
            <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group"></div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
</html>