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
            <form action="insertSchedule.php" method="post" id="insertScheduleform" >
                
                <b>Add Shift</b>
                    <div class = "col1">
                
                        <p>Worker ID:
                            <input type="text" name="worker_id" size="30" value="" />
                        </p>

                        <p>First Name:
                            <input type="text" name="first_name" size="30" value="" />
                        </p>
                
                        <p>Last Name:
                            <input type="text" name="last_name" size="30" value="" />
                        </p>

                    </div>

                    <div class = "col2">

                        <p>Date Begin(YYYY-MM-DD):
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
                        <?php
                        echo '<p>Manager ID:
                            <input type="text" form="insertScheduleform" name="managerID" size="30" value="' . $id . '" />
                        </p>';
                        ?>

                        <p>
                            <input type="submit" name="submit" value="Submit" class="button"/>
                        </p>

                    </div>
            </form>
        </div>
	</body>
</html>
