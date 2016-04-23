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

<form action="insertSchedule.php" method="post" id="insertScheduleform" >
    
    <b>Add Shift</b>
    
            <p>Worker ID:
                <input type="text" name="worker_id" size="30" value="" />
            </p>

            <p>First Name:
                <input type="text" name="first_name" size="30" value="" />
            </p>
    
            <p>Last Name:
                <input type="text" name="last_name" size="30" value="" />
            </p>

            <p>Date Begin(YYYY-MM-DD):
                <input type="text" name="date_begin" size="30" value="" />
            </p>

            <p>Time Begin(HH:MM:SS):
                <input type="text" name="time_begin" size="30" value="" />
            </p>
    
            <p>Date End(YYYY-MM-DD):
                <input type="text" name="date_end" size="30" value="" />
            </p>

            <p>Time End(HH:MM:SS):
                <input type="text" name="time_end" size="30" value="" />
            </p>
            <?php
            echo '<p>Manager ID:
                <input type="text" form="insertScheduleform" name="managerID" size="30" value="' . $id . '" />
            </p>';
            ?>

            <p>
                <input type="submit" name="submit" value="Submit" class="button"/>
            </p>

</form>

<?php
$siteBuilder->getClosinghtmlTags();
?>
  
