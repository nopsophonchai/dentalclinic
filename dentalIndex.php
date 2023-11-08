
<?php
    // session_start();
    require_once('connect.php');
    $formtype = $_POST['formType'];
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
                        // $_SESSION['patientID'] = $lastid;
                        // header('Location: mainpage.php')
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
    
    elseif($formtype == 'mainpage')
    {
        echo 'Form Type is: ' . htmlspecialchars($_POST['logout']);
        echo 'hi';
        if(isset($_POST['123']))
        {
            header('Location: login.php');
            exit;
        }
        elseif(isset($_POST['myprofile']))
        {
            header('Location: myprofile.php');
            exit;
        }
    }

    







?>