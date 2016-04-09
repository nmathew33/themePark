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

$siteBuilder->getOpeningHtmlTags('Concession Stand');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>

<div class = "content" >
    <form action="insertConcessionStand.php" method="post" id="insertConcessionStandForm" >
        
        <b>Add Shift</b>
            <div class = "col1">
        
                <p>Name:
                    <input type="text" name="name" size="30" value="" />
                </p>

                <p>Description:
                    <input type="text" name="description" size="30" value="" />
                </p>
        
            </div>

            <div class = "col2">

                <p>Location:
                    <input type="text" name="location" size="30" value="" />
                </p>

                <p>
                    <input type="submit" name="submit" value="Submit" class="button"/>
                </p>

            </div>
    </form>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>