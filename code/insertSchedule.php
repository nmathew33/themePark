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

$siteBuilder->getOpeningHtmlTags('Shift Schedule');

$siteBuilder->getGreyOverLay();


$siteBuilder->getMenu();

?>
<dic class="content">
    <?php

        if(isset($_POST['submit'])){

            $data_missing = array();

            if(empty($_POST['first_name'])){

                $data_missing[] = 'First Name';

            } else {

                $f_name = trim($_POST['first_name']);

            }

            if(empty($_POST['last_name'])){

                $data_missing[] = 'Last Name';

            } else{

                $l_name = trim($_POST['last_name']);

            }

            if(empty($_POST['worker_id'])){

                $data_missing[] = 'worker_id';

            } else {

                $workerID = trim($_POST['worker_id']);

            }

            if(empty($_POST['date_begin'])){

                $data_missing[] = 'date_begin';

            } else {

                $date_begin = trim($_POST['date_begin']);

            }

            if(empty($_POST['time_begin'])){

                $data_missing[] = 'time_begin';

            } else {

                $time_begin = trim($_POST['time_begin']);

            }

            if(empty($_POST['date_end'])){

                $data_missing[] = 'date_end';

            } else {

                $date_end = trim($_POST['date_end']);

            }

            if(empty($_POST['time_end'])){

                $data_missing[] = 'time_end';

            } else {

                $time_end = trim($_POST['time_end']);

            }

            if(empty($_POST['managerID'])){

                $data_missing[] = 'managerID';

            } else {

                $managerID = trim($_POST['managerID']);

            }

            if(empty($data_missing)){
                
                require_once('../db_connection.php');
                
                $query = "INSERT INTO Shift_Schedule (worker_id, shift_begin, shift_end, created_by) VALUES ( ?, ?, ?, ?)";
                
                $stmt = mysqli_prepare($dbc, $query);
                
                $shift_begin = $date_begin . ' ' . $time_begin;
                
                $shift_end = $date_end . ' ' . $time_end;
                
                
                mysqli_stmt_bind_param($stmt, "issi", $workerID, $shift_begin, $shift_end, $managerID);
                
                mysqli_stmt_execute($stmt);
                
                $affected_rows = mysqli_stmt_affected_rows($stmt);
                
                if($affected_rows == 1){
                    
                    echo '<center><h1>Schedule Successfully Entered</h1></center>';
                    
                    mysqli_stmt_close($stmt);
                    mysqli_close($dbc);
                    
                    
                } else {
                    
                    echo '<center><h1>Error Occurred</h1></center>';
                    echo mysqli_error();
                    
                    mysqli_stmt_close($stmt);
                    mysqli_close($dbc);
                   
                    
                }
                
            } else {
                
                echo '<center><h1>You need to enter the following data</h1>';
                
                foreach($data_missing as $missing){
                    
                    echo "$missing<br />";
                    
                }
                
                echo '</center>';
                
            }
            
        }

    ?>

    <a href="viewSchedule.php" class="button">View Schedules</a>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>


        
