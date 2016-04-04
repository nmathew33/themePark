<?php
session_start();

if(isset($_SESSION['id'])){
    $username = $_SESSION['username']; 
    $id = $_SESSION['id'];
    $roleId = $_SESSION['roleId'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];

    require_once("../db_connection.php");
    $query = "SELECT idClock_Times, active_status FROM Clock_Times Where user_id = '$id' AND clock_out IS NULL LIMIT 1";
    $response = @mysqli_query($dbc,$query);
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
                    <td><a href="clockInOut.php" class="buttonMenu">Check In/Out</a></td>
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
                date_default_timezone_set('America/Chicago');
                /*  Echo the Date
                    h : 12 hr format
                    H : 24 hr format
                    i : minutes
                    s : seconds
                    u : Microseconds
                    a : lowercase am or pm
                    l : Full text for the day
                    F : full text for the month 
                    j : day of the month
                    S : suffix for the day
                    Y : 4 digit year    
                */
                    
                echo '<center class="info"><h1>' . date('h:i:s a'). '</h1><p>' . date('l F jS, Y ') . 'CST</p>' . '</center>';
                if (mysqli_num_rows($response) == 0) { 
                   echo '<center><a href="in.php" class="clockInButton">Clock In</a></center>';
                } else { 
                    $row = mysqli_fetch_array($response);
                    $_SESSION['idClock_Times'] = $row['idClock_Times'];
                    $_SESSION['active_status'] = $row['active_status'];
                   echo '<center><a href="out.php" class="clockOutButton">Clock Out</a></center>';
                }
                mysqli_close($dbc);  
            ?>
        </div>
	</body>
</html>
