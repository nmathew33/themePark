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

$siteBuilder->getOpeningHtmlTags('Ride Usage');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>

<div class = "content" >
    <center class="info">
        <h1>Ride Usage</h1>
        <form action="rideUsage.php" method="post">
            <div>
                <ul class="rideUsageForm">
					<li>
						<input name="customerID" type="text" placeholder="Customer ID" />
					</li>
					<li>
						<input name="rideID" type="text" placeholder="Ride ID" />
					</li>
				</ul>
            </div>
			<div class="rideUsageInput">
                    <input type="submit" name="submit" value="Submit" class = "button"> 
            </div>
        </form>
    </center>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
if (isset($_POST['submit'])) {
	// get values
	$customer = trim($_POST['customerID']);
	$ride = trim($_POST['rideID']);
	$data_missing = array();
	
	// check if empty
	if(empty($customer)) {
		$data_missing[] = 'Customer ID';
	} if (empty($ride)) {
		$data_missing[] = 'Ride ID';
	}
	
	if(!empty($data_missing)) {
		echo '<center><h1>You need to enter the following data: ';
		foreach ($data_missing as $data) {
			echo "($data) ";
		}
		echo '</h1></center>';
	} else {
		require_once('../db_connection.php');
		
		$query = "INSERT INTO Ride_Usage (customer, ride) VALUES ($customer, $ride)";
		
		$stmt = mysqli_prepare($dbc, $query);
		mysqli_stmt_execute($stmt);
		
		// check that there wasn't an error
		$affected_rows = mysqli_stmt_affected_rows($stmt);
		
		if ($affected_rows == 1) {
			echo '<center><h1>Ride Usage Successfully Entered</h1></center>';
		} else {
			echo '<center><h1>User ID or Ride ID is incorrect</h1></center>';
			echo mysqli_error();
		}
		
		mysqli_stmt_close($stmt);
		mysqli_close($dbc);
	}
}

?>

<script>console.log("mysql error",<?php echo mysqli_error(); ?>);</script>