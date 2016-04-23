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
        
        if(empty($_POST['idRides'])){

            $data_missing[] = 'idRides';

        } else {

            $idRides = trim($_POST['idRides']);

        }

        if(empty($_POST['name'])){

            $data_missing[] = 'name';

        } else {

            $name = trim($_POST['name']);

        }

        if(empty($_POST['description'])){

            $data_missing[] = 'description';

        } else{

            $description = trim($_POST['description']);

        }

        if(empty($_POST['in_use'])){

            $data_missing[] = 'in_use';

        } else {

            $in_use = (trim($_POST['in_use']) == '1');

        }
        
        if(empty($_POST['staff'])){

            $data_missing[] = 'staff';

        } else{

            $staff = trim($_POST['staff']);

        }

        if(empty($_POST['date_created'])){

            $data_missing[] = 'date_created';

        } else {

            $date_created = trim($_POST['date_created']);

        }

        
        if(empty($data_missing)){
            
            require_once('../db_connection.php');
            
            $query = "UPDATE Rides SET in_use = ?, staff = ?, name = ?, description = ?, date_created = ? WHERE idRides = ?";

            $stmt = mysqli_prepare($dbc, $query);
            
            mysqli_stmt_bind_param($stmt, "sssssi", $in_use, $staff, $name, $description, $date_created, $idRides);
            
            mysqli_stmt_execute($stmt);
            
            $affected_rows = mysqli_stmt_affected_rows($stmt);
            
            if($affected_rows == 1){
                
                echo '<center><h1>Concession Successfully Entered</h1></center>';
                
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

<a href="viewRides.php" class="button">View Rides</a>


<?php
$siteBuilder->getClosinghtmlTags();
?>