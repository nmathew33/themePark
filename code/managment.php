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
<div class="button_group_managment">
    <div><a href="viewTicketTransactions.php">Ticket Transactions</a></div>
    <div><a href="viewConcessionTransactions.php">Concession Transactions</a></div>
    <div><a href="viewRideUsage.php">Ride Usage</a></div>



<?php
$siteBuilder->getClosinghtmlTags();
?>
