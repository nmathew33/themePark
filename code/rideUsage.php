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

<center class="info">
    <h1>Ride Usage</h1>
    <form action="rideUsage.php" method="post" id="rideusage">
        <div>
            <ul class="rideUsageForm">
                <li>
                    <input name="customerID" type="text" placeholder="Customer ID" />
                </li>
                <li>
                    <?php

                        require_once('../db_connection.php');

                        $query = "SELECT * FROM Rides WHERE in_use = 1";
                        $response = @mysqli_query($dbc, $query);
                        if($response){
                            echo '<select name="rideID"  form="rideusage">';

                            while($row = mysqli_fetch_array($response)){
                                echo '<option value="' . $row['idRides'] . '">' .
                                $row['name'];
                                echo '</option>';
                            }

                            echo '</select>';
                        } else {
                            echo "Couldn't obtain role list";

                            echo mysqli_error($dbc);
                        }



                    ?>
                </li>
            </ul>
        </div>
        <div class="rideUsageInput">
                <input type="submit" name="submit" value="Submit" class = "button">
        </div>
    </form>
</center>

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
        date_default_timezone_set('America/Chicago');
        $date = date('Y-m-d H:i:s', time());
		$query = "INSERT INTO Ride_Usage (customer, ride, date) VALUES ($customer, $ride, '$date')";

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
