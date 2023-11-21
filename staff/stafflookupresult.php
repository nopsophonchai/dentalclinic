<?php
session_start();
require_once('../connect.php');
require_once('adminconfig.php');
    $encryption_key = $key; 
if(!isset($_SESSION['staffID']))
{
    header('Location: ../login.php');
    exit();

}

if (isset($_POST['searchbutton'])) {
    $searchitem = $_POST['SearchText'];

    $q = "SELECT CONCAT(AES_DECRYPT(patient.firstname, ?), ' ', AES_DECRYPT(patient.lastname, ?)) AS name, patientID, 'patient' AS table_name FROM patient  
    WHERE CONCAT(LOWER(CONVERT(AES_DECRYPT(patient.firstname, ?) USING utf8)), ' ', LOWER(CONVERT(AES_DECRYPT(patient.lastname, ?) USING utf8))) LIKE LOWER(?)";

    $q .= " UNION ALL ";

    $q .= "SELECT CONCAT(AES_DECRYPT(staff.firstname, ?), ' ', AES_DECRYPT(staff.lastname, ?)) AS name, staffID, 'staff' AS table_name FROM staff  
        WHERE CONCAT(LOWER(CONVERT(AES_DECRYPT(staff.firstname, ?) USING utf8)), ' ', LOWER(CONVERT(AES_DECRYPT(staff.lastname, ?) USING utf8))) LIKE LOWER(?)";

    $stmt = $mysqli->prepare($q);
    if (!$stmt) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    } else {
        $param = "%$searchitem%";
        $stmt->bind_param("ssssssssss", $encryption_key, $encryption_key, $encryption_key, $encryption_key,
            $param, $encryption_key, $encryption_key, $encryption_key, $encryption_key, $param);

        $stmt->execute();

        $result = $stmt->get_result();

        if (!$result) {
            echo "Select failed. Error: " . $mysqli->error;
            return false;
        }
    }
} else {
    $result = null; }

function getTableName($data)
{
    if (isset($data['name']) && isset($data['table_name'])) {
        return $data['table_name'];
    } else {
        return 'unknown';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title> Dentiste </title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    <div class="container">
        <div class="logo-containermyapp">
        </div>
        <div class="signup-form">
            <h2 class="signup-heading"> Lookup Result </h2>
            <div class="app-form">
                <table>
                    <thead>
                        <tr>
                        <th>Name</th>
                    <th>Type</th>
                    <th>profile</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result) {
                            while ($row = $result->fetch_array()) {
                                $table = getTableName($row);
                            
                                ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $table; ?></td><td>
                                    <form action="staffview.php" method="post">
            <input type="hidden" name="row_id" value="<?php echo $row['patientID']; ?>">
            <input type="hidden" name="type" value="<?php echo $table; ?>">
            <input type="submit" name="view_profile" value="view profile"></input>
                                        </form></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <form action="stafflookup.php" method="post">
                    <div class="form-groupmyapp">
                        <button type="submit" name="Adminlookupexit">Return</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
