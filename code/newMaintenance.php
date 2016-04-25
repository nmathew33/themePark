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

<?php

    if(isset($_POST['submit'])){

        $data_missing = array();

        if(empty($_POST['user_id'])){

            $data_missing[] = 'User ID';

        } else {

            $user = trim($_POST['user_id']);

        }

        if(empty($_POST['ride_id'])){

            $data_missing[] = 'Ride ID';

        } else{

            $ride = trim($_POST['ride_id']);

        }

        if(empty($_POST['description'])){

            $data_missing[] = 'Desciption';

        } else{

            $descrip = trim($_POST['description']);

        }

        

        

        if(empty($data_missing)){
            
            require_once('../db_connection.php');
            
            $query = "INSERT INTO Maintenance (idMaintenance, user_created, date_created, ticket_description,ride) 
            VALUES (?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($dbc, $query);
            
            $maintID = sprintf("%04d", mt_rand(1, 9999));  
            
            $rideID = intval($ride); 
            
            date_default_timezone_set('America/Chicago');
            $dateCreate = date("Y-m-d H:i:s");               

            mysqli_stmt_bind_param($stmt, "iissi", $maintID, $user,$dateCreate, $descrip,$rideID);
        
            mysqli_stmt_execute($stmt);
            
            $affected_rows = mysqli_stmt_affected_rows($stmt);
            
            if($affected_rows == 1){
                
                echo '<center><h1>Maintenance Ticket Created</h1></center>';
                
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
                
                
            } else {
                
                echo '<center><h1>Error Occurred</h1></center>';
                echo mysqli_error($dbc);
                
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

<a href="maintenance.php" class="button">View Maintenance Tickets</a>


<?php
$siteBuilder->getClosinghtmlTags();
?>
