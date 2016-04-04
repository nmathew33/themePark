<?php
session_start();

if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
} else{
    header("Location: index.php");
}
?>
<html>
	<head>
		<title>Register User</title>
        <link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
        <img src="http://hdwallpaperslovely.com/wp-content/gallery/black-and-grey-wallpaper/Black_and_Grey_Pattern_by_kkll70.png">
        <div class = "subheader">
	   	   UmaLand
           <a href="logout.php" class="button">Sign Out</a>
	    </div>
        
        <div>
            <table class = "menu">
                <tr>
                    <td><a href="clockInOut.php" class="buttonMenu">Clock In/Out</a></td>
                    <td><a href="scheduling.php" class="buttonMenu">Scheduling</a></td>
                    <td><a href="ticketing.php" class="buttonMenu">Ticketing</a></td>
                    <td><a href="concessions.php" class="buttonMenu">Concessions</a></td>
                    <td><a href="maintenance.php" class="buttonMenu">Maitenance</a></td>
                    <td><a href="managment.php" class="buttonMenu">Management</a></td>
                    <td><a href="admin.php" class="buttonMenu">Admin</a></td>
                </tr>
            </table>
        </div>
        
        <div class = "content" >
        <?php 
            if(isset($_POST['deleteShiftID'])){
                require_once('../db_connection.php');
                
                $query = "DELETE FROM Shift_Schedule WHERE idShift_Schedule=?;";

                $stmt = mysqli_prepare($dbc, $query);

                mysqli_stmt_bind_param($stmt, "i", $_POST['deleteShiftID']);

                mysqli_stmt_execute($stmt);

                $affected_rows = mysqli_stmt_affected_rows($stmt);

                if($affected_rows == 1){
                    
                    echo '<center><h1>User Successfully Entered</h1></center>';
                    mysqli_stmt_close($stmt);
                    mysqli_close($dbc);
                    header('Location: schedule.php');

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
                    echo '<b>Update Shift</b>
                            <div class = "col1">';
                    
                        
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

                    echo '</div>';

                    echo '<div class = "col2">';

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

                    echo '</div>';
                    echo '</form>';
                } else {
                    echo "Couldn't obtain schedule to update";

                    echo mysqli_error($dbc);
                }

                mysqli_close($dbc);
            }
        ?>
        </div>
	</body>
</html>
