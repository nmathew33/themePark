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

$siteBuilder->getOpenHtmlTags();

$siteBuilder->getGreyOverLay();


$siteBuilder->getMenu();
?>
<form action="insertConcessionStand.php" method="post" id="insertConcessionStandForm" >
    
    <b>Add Concession Stand</b>
    
        <p>Name:
            <input type="text" name="name" size="30" value="" />
        </p>

        <p>Description:
            <input type="text" name="description" size="30" value="" />
        </p>

        <p>Location:
            <input type="text" name="location" size="30" value="" />
        </p>

        <p>
            <input type="submit" name="submit" value="Submit" class="button"/>
        </p>
            
</form>
<?php
$siteBuilder->getClosinghtmlTags();
?>