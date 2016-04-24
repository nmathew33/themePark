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

$siteBuilder->getOpeningHtmlTags('Maintenance');

$siteBuilder->getGreyOverLay();

$siteBuilder->getMenu();
?>

<div class = "content">
        <h1>
        Ride Maintenance
        </h1>
        <a href="createMaintenance.php" class="add_ticket_button">
        <button class="add_maintenance">Create</button>
        </a>
        <a href="maintenanceManage.php" class="add_ticket_button">
        <button class="mod_maintenance">Manage</button>
        </a>
        <a href="maintPick.php" class="add_ticket_button">
        <button class="maint_reports">View Reports</button>
        </a>
 </div>


<?php
$siteBuilder->getClosinghtmlTags();
?>