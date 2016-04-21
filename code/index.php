<?php
session_start();

if(isset($_POST['username'])){
	require_once("../db_connection.php");

	$username = strip_tags($_POST['username']);
	$password = strip_tags($_POST['password']);

	$username = mysqli_real_escape_string($dbc, $username);
	$password = mysqli_real_escape_string($dbc, $password);

	$query = "SELECT idUsers, role_id, first_name, last_name, email, password FROM Users Where email = '$username' LIMIT 1";
	$response = @mysqli_query($dbc,$query);
	$row = mysqli_fetch_array($response);

	$dbId = $row['idUsers'];
	$dbRoleId = $row['role_id'];
	$dbFirst_name = $row['first_name'];
	$dbLast_name = $row['last_name'];
	$dbEmail = $row['email'];
	$dbPassword = $row['password'];

	mysqli_close($dbc);

	if($username == $dbEmail && $password == $dbPassword){
		//Set session variables 
		$_SESSION['username'] = $username;
		$_SESSION['id'] = $dbId;
		$_SESSION['roleId'] = $dbRoleId;
		$_SESSION['first_name'] = $dbFirst_name;
		$_SESSION['last_name'] = $dbLast_name;
		//Now direct to users feed
		header("Location: welcome.php");
	} else{
		echo "<h2>Oops that username or password combination was inccorect</h2>";
	}
    
    
}
if(isset($_SESSION['id'])){
    header("Location: welcome.php");
}

require("themeparkSiteBuilder.php");
$siteBuilder = new themeParkSiteBuilder();

$siteBuilder->getOpeningHtmlTags();

// $siteBuilder->getGreyOverLay();


$siteBuilder->getOpenContentTags();
?>

	<div class = "login">
		Log In
			<form action="index.php" method="post" enctype="multipart/form=data"> 
               <div class="form-input">
                    <h2 class='label'>Username</h2>
                    <input type="text" name="username" class = "input">
               </div>
               <div class="form-input">
                    <h2 class='label'>Password</h2> 
                    <input type="password" name="password" class = "input">
               </div>
               <div class="form-input">
                    <input type="submit" name="submit" value="LOGIN" class = "button"> 
               </div>
			</form>	
	</div>

<?php
$siteBuilder->getCloseContentTags();
$siteBuilder->getClosinghtmlTags();

?>
