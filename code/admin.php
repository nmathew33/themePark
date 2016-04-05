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

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>

<div class = "content" >
    <center class="info">
        <h1>Admin</h1>
        <table class = "menu">
            <tr>
                <td><a href="registrate_new_user.php" class="clockInButton">Add New User</a></td>
            </tr>
        </table>
    </center>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>

