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

$siteBuilder->getOpeningHtmlTags('Maintenance Report');

$siteBuilder->getGreyOverLay();

$siteBuilder->getMenu();
?>

 <img src="icon.jpg" alt="icon" class = "reportIcon">
<div class = "content">
        <h1>
            Maintenance Report
        </h1>
 </div>
<div class = "maintenanceMenu">
<?php
        require_once('../db_connection.php');

            $query = "SELECT idMaintenance, user_created, date_created, user_closed,date_closed,
            ticket_description,closed_description, ride FROM UmaLand.Maintenance WHERE user_closed IS NOT NULL ";


            $response = @mysqli_query($dbc, $query);
            $rowcount=mysqli_num_rows($response);

            if($response)
            {
                echo '<table align = left"
                cellspacing="10" cellpadding = "8" class="report"
                <tr><td align = "left"><b> Closed Tickets: '.$rowcount.'</b></td></tr>
                <tr><td align = "left"><b>Ticket #</b></td>
                <td align="left"><b>Date_Created</b></td>
                <td align="left"><b>User_Created</b></td>
                <td align="left"><b>Ride ID</b></td>
                <td align="left"><b>Ticket_Description</b></td>
                <td align="left"><b>User_Closed</b></td>
                <td align="left"><b>Date_Closed</b></td>
                <td align="left"><b>Resolution</b></td>';

                while($row = mysqli_fetch_array($response))
                {
                    echo '<tr><td align="left">'.
                    $row['idMaintenance'] . '</td><td align="left">' .
                    $row['date_created'] . '</td><td align="left">' .
                    $row['user_created'] . '</td><td align="left">' .
                    $row['ride'] . '</td><td align="left">' .
                    $row['ticket_description'] . '</td><td align="left">'.
                    $row['user_closed'] . '</td><td align="left">'.
                    $row['date_closed'] . '</td><td align="left">'.
                    $row['closed_description'] . '</td>';              
                }
             }
              mysqli_close($dbc);
            ?>
    </div>
    <?php
$siteBuilder->getClosinghtmlTags();
?>
