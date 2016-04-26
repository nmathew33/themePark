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

$siteBuilder->getOpeningHtmlTags('Clock Times Report');

$siteBuilder->getGreyOverLay();

$siteBuilder->getMenu();
?>
    <h1>Clock Times</h1>
    <form action="viewClock.php" method="post">
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
					idClock_Times,
					idUsers,
					name,
					first_name,
					last_name,
					clock_in,
					clock_out,
					phone
				FROM
					Clock_Times,
					Users,
					Roles
				WHERE
					idUsers = user_id AND
					role_id = idRoles AND
					clock_in LIKE '$month'
                ORDER BY
                    clock_in";

                $response = @mysqli_query($dbc, $query);
                if($response){
                echo '<table align="left"
                cellspacing="5" cellpadding="8" class="report">

                <tr><td align="left"><b>Clock ID</b></td>
				<td align="left"><b>User ID</b></td>
                <td align="left"><b>Role</b></td>
                <td align="left"><b>First Name</b></td>
                <td align="left"><b>Last Name</b></td>
                <td align="left"><b>Clock In</b></td>
                <td align="left"><b>Clock Out</b></td>
                <td align="left"><b>Phone</b></td></tr>';


                while($row = mysqli_fetch_array($response)){

                echo '<tr><td align="left">' .
                $row['idClock_Times'] . '</td><td align="left">' .
				$row['idUsers'] . '</td><td align="left">' .
                $row['name'] . '</td><td align="left">' .
                $row['first_name'] . '</td><td align="left">' .
                $row['last_name'] . '</td><td align="left">' .
                $row['clock_in'] . '</td><td align="left">' .
                $row['clock_out'] . '</td><td align="left">' .
                $row['phone'] . '</td>';

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

<?php
$siteBuilder->getClosinghtmlTags();
?>
