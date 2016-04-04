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
        <dic class="content">
        <?php

            if(isset($_POST['submit'])){
    
                $data_missing = array();
    
                if(empty($_POST['first_name'])){

                    $data_missing[] = 'First Name';

                } else {

                    $f_name = trim($_POST['first_name']);

                }

                if(empty($_POST['last_name'])){

                    $data_missing[] = 'Last Name';

                } else{

                    $l_name = trim($_POST['last_name']);

                }

                if(empty($_POST['idShift_Schedule'])){

                    $data_missing[] = 'idShift_Schedule';

                } else{

                    $shiftID = trim($_POST['idShift_Schedule']);

                }

                if(empty($_POST['worker_id'])){

                    $data_missing[] = 'worker_id';

                } else {

                    $workerID = trim($_POST['worker_id']);

                }

                if(empty($_POST['date_begin'])){

                    $data_missing[] = 'date_begin';

                } else {

                    $date_begin = trim($_POST['date_begin']);

                }

                if(empty($_POST['time_begin'])){

                    $data_missing[] = 'time_begin';

                } else {

                    $time_begin = trim($_POST['time_begin']);

                }

                if(empty($_POST['date_end'])){

                    $data_missing[] = 'date_end';

                } else {

                    $date_end = trim($_POST['date_end']);

                }

                if(empty($_POST['time_end'])){

                    $data_missing[] = 'time_end';

                } else {

                    $time_end = trim($_POST['time_end']);

                }

                if(empty($_POST['managerID'])){

                    $data_missing[] = 'managerID';

                } else {

                    $managerID = trim($_POST['managerID']);

                }

                if(empty($data_missing)){
                    
                    require_once('../db_connection.php');
                    
                    $query = "UPDATE Shift_Schedule SET worker_id= ?, shift_begin = ?, shift_end= ?, created_by = ? WHERE idShift_Schedule = ?";
                    
                    $stmt = mysqli_prepare($dbc, $query);
                    
                    $shift_begin = $date_begin . ' ' . $time_begin;
                    
                    $shift_end = $date_end . ' ' . $time_end;
                    
                    
                    mysqli_stmt_bind_param($stmt, "issii", $workerID, $shift_begin, $shift_end, $managerID, $shiftID);
                    
                    mysqli_stmt_execute($stmt);
                    
                    $affected_rows = mysqli_stmt_affected_rows($stmt);
                    
                    if($affected_rows == 1){
                        
                        echo '<center><h1>Update Successfully Entered</h1></center>';
                        
                        mysqli_stmt_close($stmt);
                        mysqli_close($dbc);
                        
                        
                    } else {
                        
                        echo '<center><h1>Error Occurred</h1></center>';
                        echo mysqli_error();
                        
                        mysqli_stmt_close($stmt);
                        mysqli_close($dbc);
                       
                        
                    }
                    
                } else {
                    
                    echo '<center><h1>You need to enter the following data</h1>';
                    
                    foreach($data_missing as $missing){
                        
                        echo "$missing<br />";
                        
                    }
                    
                    echo '</center>';
                    
                }
                
            }

        ?>

        <a href="schedule.php" class="button">View Schedules</a>
        </div>
</body>
</html>