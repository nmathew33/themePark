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

$siteBuilder->getOpeningHtmlTags('Managment');

$siteBuilder->getGreyOverLay();

$siteBuilder->getMenu();
?>

<div class = "content" >
    <center class="info">
        <h1>Managment</h1>
        <table class = "menu">
            <tr>
                <td><a href="viewEmployee.php" class="clockInButton">Employees</a></td>
                <td><a href="viewSchedule.php" class="clockInButton">Shift Schedule</a></td>
                <td><a href="viewConcessionStands.php" class="clockInButton">Concession Stands</a></td>
                <td><a href="viewConcession.php" class="clockInButton">Concessions</a></td>
                <td><a href="viewRides.php" class="clockInButton">Rides</a></td>
				<td><a href="viewClock.php" class="clockInButton">Clock Times</a></td>
                <td><a href="rainOut.php" class="clockInButton">Rain Outs</a></td>
            </tr>
			<tr>
				<td><a href="viewTicketTransactions.php" class="clockInButton">Ticket Transactions</a></td>
				<td><a href="viewConcessionTransactions.php" class="clockInButton">Concession Transactions</a></td>
				<td><a href="viewRideUsage.php" class="clockInButton">Ride Usage</a></td>
			</tr>
        </table>
    </center>
</div>

<h1>Managment</h1>

<div class="button_group_managment">
    <div><a href="viewEmployee.php" >Employees</a></div>
    <div><a href="viewSchedule.php" class="">Shift Schedule</a></div>
    <div><a href="viewConcessionStands.php" class="">Concession Stands</a></div>
    <div><a href="viewConcession.php" class="">Concessions</a></div>
    <div><a href="viewRides.php" class="">Rides</a></div>
    <div><a href="viewClock.php" class="">Clock Times</a></div>
    <div><a href="rainOut.php" class="">Rain Outs</a></div>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>
