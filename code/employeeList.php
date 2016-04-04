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
            <h1>Employee List</h1>
            <div class="reports">
                <?php
                    require_once('../db_connection.php');

                    $query = "SELECT idUsers, Roles.name, first_name, last_name, email, address, phone,
                    ssn, gender, date_employed FROM Users, Roles Where idRoles = role_id";

                    $response = @mysqli_query($dbc, $query);

                    if($response){
                    echo '<table align="left"
                    cellspacing="5" cellpadding="8" class="report">

                    <tr><td align="left"><b>ID</b></td>
                    <td align="left"><b>Role</b></td>
                    <td align="left"><b>First Name</b></td>
                    <td align="left"><b>Last Name</b></td>
                    <td align="left"><b>Email</b></td>
                    <td align="left"><b>Address</b></td>
                    <td align="left"><b>Phone</b></td>
                    <td align="left"><b>SSN</b></td>
                    <td align="left"><b>Gender</b></td>
                    <td align="left"><b>Date Employed</b></td></tr>';

                
                    while($row = mysqli_fetch_array($response)){

                    echo '<tr><td align="left">' . 
                    $row['idUsers'] . '</td><td align="left">' . 
                    $row['name'] . '</td><td align="left">' .
                    $row['first_name'] . '</td><td align="left">' . 
                    $row['last_name'] . '</td><td align="left">' .
                    $row['email'] . '</td><td align="left">' . 
                    $row['address'] . '</td><td align="left">' . 
                    $row['phone'] . '</td><td align="left">' .
                    $row['ssn'] . '</td><td align="left">' .
                    $row['gender'] . '</td><td align="left">' .
                    $row['date_employed'] . '</td><td align="left">';

                    echo '</tr>';
                    }

                    echo '</table>';
                    } else {

                    echo "Couldn't issue database query<br />";

                    echo mysqli_error($dbc);

                    }

                    mysqli_close($dbc);

                    ?>
            </div>
                
        </div>
	</body>
</html>