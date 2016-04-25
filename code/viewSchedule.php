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
      <a href="insertScheduleForm.php" class="button">Add New Shift</a>
    </form>



        <?php
            if(isset($_POST['yearMonth'])){

                $month = $_POST['yearMonth'];

                echo '<form action="editingSchedule.php" method="post" enctype="multipart/form=data">
                           <button type="submit" name="yearMonth" value="' . $month . '">Select</button>
                        </form> ';
                echo '<div class="reports">';

                require_once('../db_connection.php');

                $month = $month . '%';

                $query = "SELECT idShift_Schedule, idUsers, first_name, last_name, name, shift_begin, shift_end, phone, created_by FROM Shift_Schedule, Users, Roles WHERE idUsers = worker_id AND role_id = idRoles AND Shift_Schedule.archive='no' AND shift_begin LIKE '$month'";

                $response = @mysqli_query($dbc, $query);

                if($response){
                echo '<table align="left"
                cellspacing="5" cellpadding="8" class="report">

                <tr><td align="left"><b>ID</b></td>
                <td align="left"><b>Role</b></td>
                <td align="left"><b>First Name</b></td>
                <td align="left"><b>Last Name</b></td>
                <td align="left"><b>Shift Begin</b></td>
                <td align="left"><b>Shift End</b></td>
                <td align="left"><b>Phone</b></td>
                <td align="left"><b>Manager ID</b></td></tr>';


                while($row = mysqli_fetch_array($response)){

                echo '<tr><td align="left">' .
                $row['idUsers'] . '</td><td align="left">' .
                $row['name'] . '</td><td align="left">' .
                $row['first_name'] . '</td><td align="left">' .
                $row['last_name'] . '</td><td align="left">' .
                $row['shift_begin'] . '</td><td align="left">' .
                $row['shift_end'] . '</td><td align="left">' .
                $row['phone'] . '</td><td align="left">' .
                $row['created_by'] . '</td>';

                echo '</tr>';
                }

                echo '</table>';
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
