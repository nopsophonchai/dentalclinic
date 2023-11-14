<?php
    session_start();
    ini_set('display_errors', 1);
                error_reporting(E_ALL);
    $formtype = 0; 
    if(isset($_POST['formType']))
    {
        $formtype = $_POST['formType'];
    }
   
    require_once('connect.php');
    var_dump($_POST);
    
    if($formtype == 'signup')
    {
        if(isset($_POST['signupbutton']))
        {
            $Username = $_POST['username'];
            $Password = $_POST['password'];
            $confirmPassword = $_POST['conpasswd'];
            if ($Password !== $confirmPassword) {
                header("Location: signup.php?error=Passwords do not match");
                exit();
            }
        

            
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
    if($formtype == 'createpatient')
    {
        if(isset($_POST['signupbutton']))
        {

            $Username = $_POST['username'];
            $Password = $_POST['password'];
            $fname = $_POST['first-name'];
            $lname = $_POST['last-name'];
            $gender = $_POST['gender'];
            $telephone = $_POST['telephone'];
            $dob = $_POST['date-of-birth'];
            $nationalID = $_POST['natid'];
            $address = $_POST['address'];
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
                        header('Location: Adminmanager.php');
                    }
                    else
                    {
                        
                        echo "Select failed. Error: ".$mysqli->error ;
                        
                    }
                    $r->close();
                }
                else
                {echo 'username already exists!';
                header("Location: admincreate.php");
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
     elseif($formtype=='insertdental'){
        if(isset($_POST['subdental'])){
            $patID11 = $_SESSION['patientID'];
            $dentnote = $_POST['dental-note'];
            $denttreat = $_POST['dental-treatment'];
            $dentdiag = $_POST['dental-diagnosis'];

            $insd = $mysqli ->prepare("INSERT INTO records(remarks,treatment,diagnosis,patientID) VALUES (?,?,?,?)");
            $insd -> bind_param("sssi",$dentnote,$denttreat,$dentdiag,$patID11);
            if ($insd -> execute()){
                header('Location: admindental.php');
                exit;
            }else {
                echo '<span>Error: ' . $mysqli->error . '</span>';
            }
            $insd->close();
        }
        elseif(isset($_POST['canceldental'])){
            header('Location: admindental.php');
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
    }elseif($formtype == 'viewprofile')
    {   echo "thrthdg";
        if(isset($_POST['editpatient']))
        {
            header('Location: editpatientforadmin.php');
            exit;
        }elseif(isset($_POST['editstaff']))
        {
            header('Location: editstaffforadmin.php');
            exit;
        }
        elseif(isset($_POST['myprofexit']))
        {
            header('Location: adminlookup.php');
            exit;
        }elseif(isset($_POST['dentalrecords']))
        {
            header('Location: admindental.php');
            exit;
        }elseif(isset($_POST['adminbilling']))
        {
            header('Location: adminbilling.php');
            exit;
        }elseif(isset($_POST['myprofexittolookup']))
        {
            session_unset();
            session_destroy();
            header('Location: adminlookup.php');
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
    
    elseif($formtype == 'editpatientforadmin')
    {   echo "thrthdg";
        if(isset($_POST['editsubmit']))
        {header('Location: view_profile.php');
            exit;
        }
        elseif(isset($_POST['editcancel']))
        {header('Location: view_profile.php');
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
            $Username = $_POST['usernameStaff'];
            $hashedPass = password_hash($_POST['passwordStaff'],PASSWORD_DEFAULT);
            
            $q = $mysqli->prepare("SELECT * FROM staff WHERE nationalID = ?");
            $q->bind_param("s", $natid);
            if ($q->execute()) {
                $results = $q->get_result();
                if ($results->num_rows === 0) {
                    $w = $mysqli->prepare("INSERT INTO staff (firstName, LastName, gender, nationalID, telephone, houseAddress, dateOfBirth, avaStat, typeID, specialty, salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $w->bind_param("sssssssiisi", $fname, $lname, $gender, $natid, $tele, $address, $dob, $ava, $type, $specialty, $salary);
                    if ($w->execute()) {
                        echo '<span>Staff created</span>';
                  
                    } else {
                        echo '<span>Error: ' . $mysqli->error . '</span>';
                    }
                    
                    $lastid = $mysqli->insert_id;
                    $r = $mysqli->prepare("INSERT INTO staffAccount (username, password,staffID) VALUES (?,?,?)");
                    $r -> bind_param("ssi",$Username,$hashedPass,$lastid);
                    if($r->execute()){
                        
                        echo "Data inserted successfully";
                        header('Location: Adminmanager.php');
                    }
                    else
                    {
                        
                        echo "Select failed. Error: ".$mysqli->error ;
                        
                    }
                    $r->close();
                } else {
                    echo '<span>National ID already exists!</span>';
                }
                
            } else {
                echo "Error: " . $mysqli->error;
            }
        }
        
        echo 'hi';
    }
    elseif ($formtype =='appointment'){
        echo 'hi'.$_POST['doctor'].$_SESSION['patientID'];
        if(isset($_POST['submitapp'])){
            $patientID = $_SESSION['patientID'];
            $date = $_POST['dateapp'];
            $time = $_POST['timeapp'];
            $doc = $_POST['doctor'];
            $reason = $_POST['reason'];
        
            //$timecheck = $mysqli ->prepare("SELECT * FROM appointment WHERE staffID = ? AND appointmentTime >= ? AND appointmentDate = ? AND ");
            

            $q2 =$mysqli ->prepare("INSERT INTO appointment (appointmentDate,appointmentTime,reason,staffID,patientID,completion) VALUES (?,?,?,?,?,0)");
            $q2 -> bind_param("sssii",$date,$time,$reason,$doc,$patientID);
            if ($q2 -> execute()){

                header('Location: myapp.php');
                exit;
            }else {
                echo '<span>Error: ' . $mysqli->error . '</span>';
            }
            $q2->close();

        }
    }

    elseif($formtype=='insertbilling'){

        if(isset($_POST['subbill'])){
            $patID = $_POST['patientIDBil'];
            $date = $_POST['bill-time'];
            $description = $_POST['bill-des'];
            $amount = $_POST['bill-amount'];

            $insb = $mysqli ->prepare("INSERT INTO billing(description,amount,billingTime,patientID) VALUES (?,?,?,?)");
            $insb -> bind_param("sssi",$description,$amount,$date,$patID);
            if ($insb -> execute()){
                header('Location: adminbilling.php');
                exit;
            }else {
                echo '<span>Error: ' . $mysqli->error . '</span>';
            }
            $insb->close();
        }
        
    }
    // elseif($formtype == 'createpatient')
    // {
            
    //     if(isset($_POST['admincreatepatient']))
    //     {
    //         echo 'Hi';

    //         $Username = $_POST['username'];
    //         $Password = $_POST['password'];
    //         $fname = $_POST['first-name'];
    //         $lname = $_POST['last-name'];
    //         $gender = $_POST['gender'];
    //         $telephone = $_POST['telephone'];
    //         $dob = $_POST['date-of-birth'];
    //         $nationalID = $_POST['natid'];
    //         $address = $_POST['address'];
    //         echo $Username."".$Password."".$fname."".$lname."".$gender."".$telephone."".$dob."".$nationalID."".$address;
    //         $hashedPass = password_hash($Password,PASSWORD_DEFAULT);
    //         $usercheck = $mysqli->prepare("SELECT Username FROM userAccounts WHERE Username = ?");
    //         $usercheck -> bind_param("s",$Username);
    //         echo 'Hi';
    //         ini_set('display_errors', 1);
    //             error_reporting(E_ALL);
    //         if($usercheck -> execute())
    //         {
    //             $result = $usercheck->get_result();
    //             if($result->num_rows === 0 )
    //             {
    //                 $stmt = $mysqli->prepare("INSERT INTO patient (firstName,lastName, gender, nationalID, telephone, houseAddress, dateOfBirth) VALUES (?,?,?,?,?,?,?)");
    //                 if ($stmt === false) {
    //                     die("Prepare failed: " . $mysqli->error);
    //                 }
    //                 $stmt -> bind_param("sssssss",$fname,$lname,$gender,$nationalID,$telephone,$address,$dob);
          
    //                 if($stmt->execute()){
                        
    //                     echo "Data inserted successfully";

    //                 }
    //                 else
    //                 {
                        
    //                     echo "Select failed. Error: ".$mysqli->error ;
                        
    //                 }
                    
    //                 $lastid = $mysqli->insert_id;
    //                 $stmt->close();
    //                 $r = $mysqli->prepare("INSERT INTO userAccounts (Username, Password,patientID) VALUES (?,?,?)");
    //                 $r -> bind_param("ssi",$Username,$hashedPass,$lastid);
    //                 if($r->execute()){
    //                     ini_set('display_errors', 1);
    //             error_reporting(E_ALL);
    //                     echo "Data inserted successfully";
    //                     $_SESSION['patientID'] = $lastid;
    //                     header('Location: Adminmanager.php');
    //                 }
    //                 else
    //                 {
                        
    //                     echo "Select failed. Error: ".$mysqli->error ;
                        
    //                 }
    //                 $r->close();
    //             }
    //             else
    //             {echo 'username already exists!';
    //             header("Location: admincreatepatient.php");
    //         exit;}
            
    //         }
    //         else
    //         {
    //             echo $mysqli->error;
    //         }
    //         $usercheck -> close();

    //     }
    // }
    
    
?>