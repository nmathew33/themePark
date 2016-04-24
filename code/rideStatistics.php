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

$siteBuilder->getOpeningHtmlTags('Ride Statistics');

$siteBuilder->getGreyOverLay();

$siteBuilder->getMenu();
?>
<div class = "content" >
    <h1>Ride Statistics Report</h1>
    <form action="rideStatistics.php" method="post">
      Schedule (month and year):
      <input type="month" name="yearMonth">
	  <input type="submit">
    </form>



        <?php
            if(isset($_POST['yearMonth'])){

                $month = $_POST['yearMonth'];

                echo '<div class="reports">';
                ?>

                <div class="report-header">
                    <h4>Four O Four Land</h4>
                    4773 Ashmor Drive <br />
                    Houston, TX <br />

                <?php
                date_default_timezone_set('America/Chicago');
                $date = date('m/d/Y h:i:s a', time());
                echo "<br />This report was generated at $date</div>";
                require_once('../db_connection.php');

                $month = $month . '%';

                $query =
				"SELECT
                    r.name,
                    (SELECT
                            COUNT(*)
                        FROM
                            Ride_Usage
                        WHERE
                            ride = r.idRides AND
                            date LIKE '$month') total_usage,
                    r.in_use,
                    (SELECT
                            COUNT(*)
                        FROM
                            Maintenance
                        WHERE
                            ride = r.idRides AND
                            date_created LIKE '$month') total_maintainance,
                    (SELECT
                            COUNT(*)
                        FROM
                            Rainout
                        WHERE
                            ride = r.idRides AND
                            date LIKE '$month') total_rainouts
                FROM
                    Rides r
                ;";

                $response = @mysqli_query($dbc, $query);
                if($response){

                echo '<table align="left"
                cellspacing="5" cellpadding="8" class="report">

                <tr><td align="left"><b>Ride Name</b></td>
				<td align="left"><b>Total Usage</b></td>
                <td align="left"><b>Total Maintenance Tickets</b></td>
                <td align="left"><b>Total Rainouts</b></td>';


                while($row = mysqli_fetch_array($response)){

                echo '<tr><td align="left">' .
                $row['name'] . '</td><td align="left">' .
				$row['total_usage'] . '</td><td align="left">' .
                $row['total_maintainance'] . '</td><td align="left">' .
                $row['total_rainouts'] . '</td>';

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

<?php
    if (isset($_POST['yearMonth'])) {

    }

 ?>

<?php
$siteBuilder->getClosinghtmlTags();
?>
