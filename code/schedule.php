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
            <h1>Shift Schedule</h1>
            <form action="schedule.php" method="post">
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

                        $query = "SELECT idShift_Schedule, idUsers, first_name, last_name, name, shift_begin, shift_end, phone, created_by FROM Shift_Schedule, Users, Roles WHERE idUsers = worker_id AND role_id = idRoles AND shift_begin LIKE '$month'";

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
                        $row['created_by'] . '</td><td align="left">';

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
          
        </div>
	</body>
</html>