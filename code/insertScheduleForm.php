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

$siteBuilder->getOpeningHtmlTags('Welcome');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();

?>

<div class = "content" >
    <form action="insertSchedule.php" method="post" id="insertScheduleform" >
        
        <b>Add Shift</b>
            <div class = "col1">
        
                <p>Worker ID:
                    <input type="text" name="worker_id" size="30" value="" />
                </p>

                <p>First Name:
                    <input type="text" name="first_name" size="30" value="" />
                </p>
        
                <p>Last Name:
                    <input type="text" name="last_name" size="30" value="" />
                </p>

            </div>

            <div class = "col2">

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

            </div>
    </form>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>
  
