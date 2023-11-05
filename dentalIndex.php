
<?php
    
    require_once('connect.php');
    $formtype = $_POST['formType'];
    
    // if($formtype == 'login')
    // {
    //     echo "hi".$formtype;
    //     if(isset($_POST['sub']))
    //     {
    //         $Username = $_POST['username'];
    //         $Password = $_POST['password'];
    //         if($Username == 'Admin' && $Password == 'Admin123')
    //         {
    //             header("Location: Adminmanager.php");
    //         }
    //         else
    //         {
    //             $q = "SELECT * FROM userAccounts WHERE Username = '$Username' AND Password = '$Password'";
    //             $result = $mysqli->query($q);
    //             if(!$result){
    //                 echo "Select failed. Error: ".$mysqli->error ;
    //                 return false;
    //             }
    //             elseif($result->num_rows == 0)
    //             {
    //                 echo "Incorrect username or password!";
    //                 return false;
    //             }
    //             else
    //             {
    //                 //Redirects to Patient page
    //             }
    //         }
    //     }
        
    // }
    if($formtype == 'signup')
    {
            
        if(isset($_POST['signupbutton']))
        {
            echo 'Hi';

            $Username = $_POST['username'];
            $Password = $_POST['password'];
            $fname = $_POST['first-name'];
            $lname = $_POST['last-name'];
            $gender = $_POST['gender'];
            $telephone = $_POST['telephone'];
            $dob = $_POST['date-of-birth'];
            $nationalID = $_POST['natid'];
            $address = $_POST['address'];
            echo $Username."".$Password."".$fname."".$lname."".$gender."".$telephone."".$dob."".$nationalID."".$address;
            $hashedPass = password_hash($Password,PASSWORD_DEFAULT);
            $usercheck = $mysqli->prepare("SELECT Username FROM userAccounts WHERE Username = ?");
            $usercheck -> bind_param("s",$Username);
            echo 'Hi';
            ini_set('display_errors', 1);
                error_reporting(E_ALL);
            $usercheck -> execute();
            if($usercheck -> execute())
            {
                $result = $usercheck->get_result();
                if($result->num_rows === 0 )
                {
                    $stmt = $mysqli->prepare("INSERT INTO patient (firstName,lastName, gender, nationalID, telephone, houseAddress, dateOfBirth) VALUES (?,?,?,?,?,?,?)");
                    if ($stmt === false) {
                        die("Prepare failed: " . $mysqli->error);
                    }
                    $stmt -> bind_param("sssssss",$fname,$lname,$gender,$nationalID,$telephone,$address,$dob);
          
                    if($stmt->execute()){
                        
                        echo "Data inserted successfully";
                    }
                    else
                    {
                        
                        echo "Select failed. Error: ".$mysqli->error ;
                        
                    }
                    
                    $lastid = $mysqli->insert_id;
                    $stmt->close();
                    $r = $mysqli->prepare("INSERT INTO userAccounts (Username, Password,patientID) VALUES (?,?,?)");
                    $r -> bind_param("ssi",$Username,$hashedPass,$lastid);
                    if($r->execute()){
                        
                        echo "Data inserted successfully";
                    }
                    else
                    {
                        
                        echo "Select failed. Error: ".$mysqli->error ;
                        
                    }
                    $r->close();
                }
                else
                {echo 'username already exists!';
                header("Location: signup.php");}
            
            }
            else
            {
                echo $mysqli->error;
            }
            $usercheck -> close();

        }
    }

    







?>