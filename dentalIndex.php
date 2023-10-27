
<?php
    require_once('connect.php');
    $formtype = $_POST['formType'];
    if($formType == 'login')
    {
        $Username = $_POST['Username'];
        $Password = $_POST['Password'];
        if($Username == 'Admin' && $Password == 'Admin123')
        {
            //Redirects to admin(Staff) page
        }
        else
        {
            $q = "SELECT * FROM userAccounts WHERE Username = $Username AND Password = $Password";
            $result = $mysqli->query($q);
            if(!$result){
                echo "Select failed. Error: ".$mysqli->error ;
                return false;
            }
            elseif($result->num_rows == 0)
            {
                echo "Incorrect username or password!";
                return false;
            }
            else
            {
                //Redirects to Patient page
            }
        }
        
    }







?>