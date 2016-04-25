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

$siteBuilder->getOpeningHtmlTags('Ticket Transactions Report');

$siteBuilder->getGreyOverLay();

$siteBuilder->getMenu();
?>
<div class = "content" >
    <h1>Ticket Transactions Report</h1>
    <form action="viewTicketTransactions.php" method="post">
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
                echo "<br />This report was generated at $date";
                require_once('../db_connection.php');

                $query =
                "SELECT
                    SUM(pricing) revenue
                FROM
                    Ticket_Sales";
                $response = @mysqli_query($dbc, $query);
                while ($row = mysqli_fetch_array($response)) {
                    echo "The total revenue generated this month through ticket sales is $" . $row['revenue']."</div>";
                }

                $month = $month . '%';

                $query =
				"SELECT
					ts.idTicket_Sales,
					ts.date,
					ts.season_pass,
					ts.customer_id,
                    ts.pricing,
					c.first_name AS cfname,
					c.last_name AS clname,
					u.first_name AS ufname,
					u.last_name AS ulname
				FROM
					Ticket_Sales as ts,
					Customers as c,
					Users as u
				WHERE
					ts.customer_id = c.idCustomers AND
					ts.user_id = u.idUsers AND
					ts.date LIKE '$month'
				ORDER BY
					ts.date ASC;";

                $response = @mysqli_query($dbc, $query);
                if($response){
                echo '<table align="left"
                cellspacing="5" cellpadding="8" class="report">

                <tr>
				<td align="left"><b>Ticket #</b></td>
				<td align="left"><b>Date Sold</b></td>
                <td align="left"><b>Pricing</b></td>
                <td align="left"><b>Season Pass</b></td>
                <td align="left"><b>Customer ID</b></td>
                <td align="left"><b>Customer Name</b></td>
                <td align="left"><b>Employee Name</b></td>
				</tr>';


                while($row = mysqli_fetch_array($response)){

				$customer = $row['cfname'] . ' ' . $row['clname'];
				$employee = $row['ufname'] . ' ' . $row['ulname'];
				$season = 'No';
				if ($row['season_pass'] != null) {
					$season = 'Yes';
				}

                echo '<tr><td align="left">' .
                $row['idTicket_Sales'] . '</td><td align="left">' .
				$row['date'] . '</td><td align="left">' .
                $row['pricing'] . '</td><td align="left">' .
                $season . '</td><td align="left">' .
                $row['customer_id'] . ' ' . '</td><td align="left">' .
                $customer . '</td><td align="left">' .
                $employee . '</td>';

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
$siteBuilder->getClosinghtmlTags();
?>
