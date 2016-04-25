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

<h1>Management</h1>

<h2>Controles: </h2>
<div class="button_group_managment">
    <div><a href="viewEmployee.php" >Employees</a></div>
    <div><a href="viewSchedule.php" class="">Shift Schedule</a></div>
    <div><a href="viewConcessionStands.php" class="">Concession Stands</a></div>
    <div><a href="viewConcession.php" class="">Concessions</a></div>
    <div><a href="viewRides.php" class="">Rides</a></div>
</div>

<h2>Reports: </h2>
<div class="button_group_managment">
    <div><a href="viewTicketTransactions.php">Ticket Transactions</a></div>
    <div><a href="viewConcessionTransactions.php">Concession Trans..</a></div>
    <div><a href="viewRideUsage.php">Ride Usage</a></div>
    <div><a href="rideStatistics.php">Ride Statistics</a></div>
    <div><a href="viewClock.php" class="">Clock Times</a></div>
    <div><a href="rainOut.php" class="">Rain Outs</a></div>
</div>



<?php
$siteBuilder->getClosinghtmlTags();
?>
