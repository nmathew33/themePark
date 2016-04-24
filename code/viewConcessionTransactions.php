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

$siteBuilder->getOpeningHtmlTags('Concessions Transactions Report');

$siteBuilder->getGreyOverLay();

$siteBuilder->getMenu();
?>
<div class = "content" >
    <h1>Concessions Transactions Report</h1>
    <form action="viewConcessionTransactions.php" method="post">
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
                    cs.idConcession_Sales,
                    cs.pricing,
                    cst.name,
                    c.first_name cfn,
                    c.last_name cln,
                    u.first_name ufn,
                    u.last_name uln,
                    cs.date
                FROM
                    Concession_Sales cs
                        LEFT OUTER JOIN
                    Concession_Stands cst ON cs.location = cst.idConcession_Stands
                        LEFT OUTER JOIN
                    Customers c ON cs.customer_id = c.idCustomers
                        LEFT OUTER JOIN
                    Users u ON cs.user_id = idUsers
                WHERE
                    cs.date LIKE '$month'";

                $response = @mysqli_query($dbc, $query);
                if($response){
                echo '<table align="left"
                cellspacing="5" cellpadding="8" class="report">

                <tr><td align="left"><b>Concession Sales ID</b></td>
				<td align="left"><b>Price</b></td>
                <td align="left"><b>Stand Name</b></td>
                <td align="left"><b>Customer Name</b></td>
                <td align="left"><b>Staff Name</b></td>
                <td align="left"><b>Date</b></td>';


                while($row = mysqli_fetch_array($response)){

                echo '<tr><td align="left">' .
                $row['idConcession_Sales'] . '</td><td align="left">' .
				$row['pricing'] . '</td><td align="left">' .
                $row['name'] . '</td><td align="left">' .
                $row['cfn'] . ' ' . $row['cln'] . '</td><td align="left">' .
                $row['ufn'] . ' ' . $row['uln'] . '</td><td align="left">' .
                $row['date'] . '</td>';

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
