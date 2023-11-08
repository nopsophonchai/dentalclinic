
<?php
    session_start();
    ini_set('display_errors', 1);
                error_reporting(E_ALL);
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
                        ini_set('display_errors', 1);
                error_reporting(E_ALL);
                        echo "Data inserted successfully";
                        $_SESSION['patientID'] = $lastid;
                        header('Location: mainpage.php');
                    }
                    else
                    {
                        
                        echo "Select failed. Error: ".$mysqli->error ;
                        
                    }
                    $r->close();
                }
                else
                {echo 'username already exists!';
                header("Location: signup.php");
            exit;}
            
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
        echo 'hi'.isset($_POST['BillingHistory']);
        if(isset($_POST['123']))
        {
            header('Location: login.php');
            session_unset(); 
            session_destroy();
            exit;
        }
        elseif(isset($_POST['myprofile']))
        {
            header('Location: myprofile.php');
            exit;
        }
        elseif(isset($_POST['myapp']))
        {
            header('Location: myapp.php');
            exit;
        }
        elseif(isset($_POST['dentalrecords']))
        {
            header('Location: dentalrecords.php');
            exit;
        }
        elseif(isset($_POST['BillingHistory']))
        {
            header('Location: billinghis.php');
            exit;
        }

    }
    elseif($formtype == 'myprofile')
    {   echo "thrthdg";
        if(isset($_POST['edit']))
        {
            header('Location: editpatient.php');
            exit;
        }
        elseif(isset($_POST['myprofexit']))
        {
            header('Location: mainpage.php');
            exit;
        }
    }
    elseif($formtype == 'editpatient')
    {   echo "thrthdg";
      /*  if(isset($_POST['editsubmit']))
        {
            exit;
        }
       /* elseif(isset($_POST['myprofile']))
        {
            header('Location: myprofile.php');
            exit;
        }*/
    }
    elseif ($formtype == 'createstaff') {
        
        if (isset($_POST['Submitr'])) {
            echo 'hi';
            $fname = $_POST['first-name'];
            $lname = $_POST['last-name'];
            $natid = $_POST['natid'];
            $gender = $_POST['gender'];
            $type = $_POST['type'];
            $dob = $_POST['date-of-birth'];
            $tele = $_POST['telephone'];
            $salary = $_POST['salary'];
            $address = $_POST['address'];
            $specialty = $_POST['specialty'];
            $ava = 1;
            
            $q = $mysqli->prepare("SELECT * FROM staff WHERE nationalID = ?");
            $q->bind_param("s", $natid);
            if ($q->execute()) {
                $results = $q->get_result();
                if ($results->num_rows === 0) {
                    $w = $mysqli->prepare("INSERT INTO staff (firstName, LastName, gender, nationalID, telephone, houseAddress, dateOfBirth, avaStat, typeID, specialty, salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $w->bind_param("sssssssiisi", $fname, $lname, $gender, $natid, $tele, $address, $dob, $ava, $type, $specialty, $salary);
                    if ($w->execute()) {
                        echo '<span>Staff created</span>';
                        header('Location: Adminmanager.php');
                        exit;
                    } else {
                        echo '<span>Error: ' . $mysqli->error . '</span>';
                    }
                    $w->close();
                } else {
                    echo '<span>National ID already exists!</span>';
                }
                $q->close();
            } else {
                echo "Error: " . $mysqli->error;
            }
        }
    }
    
    







?>