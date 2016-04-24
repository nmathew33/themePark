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

    <?php 
        if(isset($_POST['deleteShiftID'])){
            require_once('../db_connection.php');
            
            $query = "UPDATE Shift_Schedule SET archive='yes' WHERE idShift_Schedule=?;";

            $stmt = mysqli_prepare($dbc, $query);

            mysqli_stmt_bind_param($stmt, "i", $_POST['deleteShiftID']);

            mysqli_stmt_execute($stmt);

            $affected_rows = mysqli_stmt_affected_rows($stmt);

            if($affected_rows == 1){
                
                echo '<center><h1>User Successfully Entered</h1></center>';
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
                header('Location: viewSchedule.php');

            } else {
                
                echo '<center><h1>Error Occurred</h1></center>';
                echo mysqli_error();
                
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
               
                
            } 

            
        }
        if(isset($_POST['updateShiftID'])){
            require_once('../db_connection.php');

            $query = "SELECT idShift_Schedule, idUsers, first_name, last_name, shift_begin, shift_end, created_by FROM Shift_Schedule, Users WHERE idUsers = worker_id AND idShift_Schedule=" . $_POST['updateShiftID'] . " LIMIT 1";
            $response = @mysqli_query($dbc, $query);
            if($response){
                $row = mysqli_fetch_array($response);
                echo '<form action="updateSchedule.php" method="post" id="insertScheduleform">';
                echo '<b>Update Shift</b>';
                
                    
                echo '<p>Shift Schedule ID:
                    <input type="text" name="idShift_Schedule" size="30" value="' . $row['idShift_Schedule'] . '" />
                </p>
        
                <p>Worker ID:
                    <input type="text" name="worker_id" size="30" value="'. $row['idUsers'] .'" />
                </p>

                <p>First Name:
                    <input type="text" name="first_name" size="30" value="' . $row['first_name'] . '" />
                </p>
        
                <p>Last Name:
                    <input type="text" name="last_name" size="30" value="'. $row['last_name'] . '" />
                </p>';

                echo '<p>Date Begin(YYYY-MM-DD):
                    <input type="text" name="date_begin" size="30" value="" />
                </p>

                <p>Time Begin(HH:MM:SS):
                    <input type="text" name="time_begin" size="30" value="" />
                </p>
        
                <p>Date End(YYYY-MM-DD):
                    <input type="text" name="date_end" size="30" value="" />
                </p>

                <p>Time End(HH:MM:SS):
                    <input type="text" name="time_end" size="30" value="" />
                </p>

                <p>Manager ID:
                    <input type="text" name="managerID" size="30" value="' . $id . '" />
                </p>';

                echo '<p>
                    <input type="submit" name="submit" value="Submit" class="button"/>
                </p>';

                echo '</form>';
            } else {
                echo "Couldn't obtain schedule to update";

                echo mysqli_error($dbc);
            }

            mysqli_close($dbc);
        }
    ?>


<?php
$siteBuilder->getClosinghtmlTags();
?>
