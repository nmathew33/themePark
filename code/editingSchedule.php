<?php
session_start();

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

$siteBuilder->getOpenHtmlTags();

$siteBuilder->getGreyOverLay();


$siteBuilder->getMenu();
?>

<h1>Shift Schedule</h1>
<form action="viewSchedule.php" method="post">
    Schedule (month and year):
    <input type="month" name="yearMonth">
    <input type="submit">
</form>



    <?php
        if(isset($_POST['yearMonth'])){
            
            $month = $_POST['yearMonth'];

            echo '<form action="viewSchedule.php" method="post" enctype="multipart/form=data"> 
                        <button type="submit" name="yearMonth" value="' . $month . '">Back</button>
                    </form> ';
            echo '<div class="reports">';

            require_once('../db_connection.php');

            $month = $month . '%';

            $query = "SELECT idShift_Schedule, idUsers, first_name, last_name, name, shift_begin, shift_end, phone, created_by FROM Shift_Schedule, Users, Roles WHERE idUsers = worker_id AND role_id = idRoles AND shift_begin AND archive = 'no' LIKE '$month'";

            $response = @mysqli_query($dbc, $query);
            
            echo '<form action="updateScheduleForm.php" method="post" enctype="multipart/form=data">';

            if($response){
            echo '<table align="left"
            cellspacing="5" cellpadding="8" class="report">

            <tr><td align="left"><b></b></td>
            <td align="left"><b></b></td>
            <td align="left"><b>ID</b></td>
            <td align="left"><b>Role</b></td>
            <td align="left"><b>First Name</b></td>
            <td align="left"><b>Last Name</b></td>
            <td align="left"><b>Shift Begin</b></td>
            <td align="left"><b>Shift End</b></td>
            <td align="left"><b>Phone</b></td>
            <td align="left"><b>Manager ID</b></td></tr>';

            
            while($row = mysqli_fetch_array($response)){

            echo '<tr><td align="left">' . 
            '<button type="submit" name="updateShiftID" value="' . $row['idShift_Schedule'] . '">edit</button>'  . '</td><td align="left">' . 
            '<button type="submit" name="deleteShiftID" value="' . $row['idShift_Schedule'] . '">delete</button>'  . '</td><td align="left">' . 
            $row['idUsers'] . '</td><td align="left">' . 
            $row['name'] . '</td><td align="left">' .
            $row['first_name'] . '</td><td align="left">' . 
            $row['last_name'] . '</td><td align="left">' .
            $row['shift_begin'] . '</td><td align="left">' . 
            $row['shift_end'] . '</td><td align="left">' . 
            $row['phone'] . '</td><td align="left">' .
            $row['created_by'] . '</td><td align="left">';

            echo '</tr>';
            }

            echo '</table>';
            echo '</form>';
            } else {

            echo "Couldn't issue database query<br />";

            echo mysqli_error($dbc);

            }

            mysqli_close($dbc);

            }    
            echo '</div>';
    ?>


<?php
$siteBuilder->getClosinghtmlTags();
?>

 