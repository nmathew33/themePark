<?php
session_start();

$_SESSION['week'] = ((isset($_SESSION['week'])) ? $_SESSION['week'] : 0);
if(isset($_GET['Next'])){
     $_SESSION['week']++;
}
if(isset($_GET['Previous'])){
     $_SESSION['week']--;
}

if(isset($_SESSION['id'])){
    $username = $_SESSION['username']; 
    $id = $_SESSION['id'];
    $roleId = $_SESSION['roleId'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
} else{
    header("Location: index.php");
}

require("themeparkSiteBuilder.php");
$siteBuilder = new themeParkSiteBuilder();

$siteBuilder->getOpeningHtmlTags('Scheduling');

$siteBuilder->getGreyOverLay();


$siteBuilder->getMenu();
?>

<h1>Shift Schedule</h1>
<form action="scheduling.php" method="get">
    <input type="submit" name="Previous" value="Previous" />
    <input type="submit" name="Next" value="Next" />
</form>



    <?php
            $week = 0;
            
            if(isset($_POST['week'])){
                if($_POST['week'] == 'Next'){
                    $week = $week + 1;        
                }
                if($_POST['week'] == 'Previous'){
                    
                }
            }
        
            echo '<div class="reports">';

            require_once('../db_connection.php');

            

            $query = "SELECT 
                        shift.idShift_Schedule, shift.shift_begin, shift.shift_end,
                        (SELECT idUsers FROM Users user WHERE idUsers=". $id ." AND user.idUsers = shift.worker_id) AS workerID,
                        (SELECT first_name FROM Users user WHERE idUsers=". $id ." AND user.idUsers = shift.worker_id) AS workerFirstName,
                        (SELECT last_name FROM Users user WHERE idUsers=". $id ." AND user.idUsers = shift.worker_id) AS workerLastName,
                        (SELECT idUsers FROM Users user WHERE user.idUsers = shift.created_by) AS managerID,
                        (SELECT first_name FROM Users user WHERE user.idUsers = shift.created_by) AS managerFirstName,
                        (SELECT last_name FROM Users user WHERE user.idUsers = shift.created_by) AS managerLastName,
                        (SELECT phone FROM Users user WHERE user.idUsers = shift.created_by) AS managerPhone
                        FROM Shift_Schedule shift WHERE YEARWEEK(shift.shift_begin) = (YEARWEEK(NOW()) + " . $_SESSION['week'] . ")";

            $response = @mysqli_query($dbc, $query);
            
            if($response){
            echo '<table align="left"
            cellspacing="5" cellpadding="8" class="report">

            <tr><td align="left"><b>ID</b></td>
            <td align="left"><b>Shift Begin</b></td>
            <td align="left"><b>Shift End</b></td>
            <td align="left"><b>First Name</b></td>
            <td align="left"><b>Last Name</b></td>
            <td align="left"><b>Manager</b></td>
            <td align="left"><b>Phone</b></td></tr>';

        
            while($row = mysqli_fetch_array($response)){

            echo '<tr><td align="left">' . 
            $row['workerID'] . '</td><td align="left">' . 
            $row['shift_begin'] . '</td><td align="left">' .
            $row['shift_end'] . '</td><td align="left">' . 
            $row['workerFirstName'] . '</td><td align="left">' .
            $row['workerLastName'] . '</td><td align="left">' . 
            $row['managerFirstName'] . ' ' . $row['managerLastName'] . '</td><td align="left">' . 
            $row['managerPhone'] . '</td><td align="left">';

            echo '</tr>';
            }

            echo '</table>';
            } else {

            echo "Couldn't issue database query<br />";

            echo mysqli_error($dbc);

            }

            mysqli_close($dbc);

            echo '</div>';
    ?>
  
<?php
$siteBuilder->getClosinghtmlTags();
?>