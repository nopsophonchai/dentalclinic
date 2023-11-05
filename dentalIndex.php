
<?php
    
    require_once('connect.php');
    $formtype = $_POST['formType'];
    
    if($formtype == 'login')
    {
        echo "hi".$formtype;
        if(isset($_POST['sub']))
        {
            $Username = $_POST['username'];
            $Password = $_POST['password'];
            if($Username == 'Admin' && $Password == 'Admin123')
            {
                //Redirects to admin(Staff) page
            }
            else
            {
                $q = "SELECT * FROM userAccounts WHERE Username = '$Username' AND Password = '$Password'";
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
        
    }
    elseif($formtype == 'signup')
    {
            
        if(isset($_POST['signupbutton']))
        {
            echo "HI";
            $Username = $_POST['username'];
            $Password = $_POST['password'];
            $fname = $_POST['first-name'];
            $lname = $_POST['last-name'];
            $gender = $_POST['gender'];
            $telephone = $_POST['telephone'];
            $dob = $_POST['date-of-birth'];
            $nationalID = 1111;
            $q = "INSERT INTO patient (firstName,lastName, gender, nationalID, telephone, houseAddress, dataOfBirth) VALUES ('$fname','$lname','$gender',$nationalID,'$telephone','123123123','$dob')";
            $result = $mysqli->query($q);
                if(!$result){
                    echo "Select failed. Error: ".$mysqli->error ;
                    return false;
                }
                else
                {
                    //Redirects to Patient page
                    echo "Data inserted successfully";
                }
                $lastid = $mysqli->insert_id;
                $r = "INSERT INTO userAccounts (UserID, Username, Password) VALUES ($lastid, '$Username', '$Password')";
                $resultsUA = $mysqli->query($r);
                if (!$resultsUA) {
                    echo "Insert failed. Error: " . $mysqli->error;
                    return false;
                } else {
                    // Redirects to Patient page
                    echo "Data inserted successfully";
                }
        }
    }

    







?>