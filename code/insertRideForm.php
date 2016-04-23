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

<form action="insertRide.php" method="post" id="insertRide" >
    
    <b>Add Ride</b>
 
        <p>Name:
            <input type="text" name="name" size="30" value="" />
        </p>
        
        <p>Description:
            <input type="text" name="description" size="30" value="" />
        </p>
        
        <p>in Use:                    
            <select name="in_use"  form="insertRide">
                <option value="1">yes</option>
                <option value="2">no</option>
            </select>
        </p>

        <p>Staff:
            <input type="text" name="staff" size="30" value="" />
        </p>
        
        
        <p>Date Created (YYYY-MM-DD):
            <input type="text" name="date_created" size="30" value="" />
        </p>

        <p>
            <input type="submit" name="submit" value="Submit" class="button"/>
        </p>

    
</form>


<?php
$siteBuilder->getClosinghtmlTags();
?>