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
            <center class="info">
                <h1>Managment</h1>
                <table class = "menu">
                <tr>
                    <td><a href="employeeList.php" class="clockInButton">View All Employees</a></td>
                    <td><a href="schedule.php" class="clockInButton">Schedule Employees</a></td>
                </tr>
            </table>
            </center>
        </div>
	</body>
</html>
