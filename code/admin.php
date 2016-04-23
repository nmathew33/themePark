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

$siteBuilder->getOpeningHtmlTags('Admin');

$siteBuilder->getGreyOverLay();


$siteBuilder->getMenu();
?>
<h1>Admin</h1>


<div class="button_group">
    <div><a href="registrate_new_user.php">Add New User</a></div>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>

