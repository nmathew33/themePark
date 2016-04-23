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

        if(empty($_POST['name'])){

            $data_missing[] = 'Name';

        } else {

            $name = trim($_POST['name']);

        }

        if(empty($_POST['description'])){

            $data_missing[] = 'description';

        } else{

            $description = trim($_POST['description']);

        }

        if(empty($_POST['location'])){

            $data_missing[] = 'location';

        } else {

            $location = trim($_POST['location']);

        }

        
        if(empty($data_missing)){
            
            require_once('../db_connection.php');
            
            $query = "INSERT INTO Concession_Stands (idConcession_Stands, name, description, location) VALUES (?, ?, ?, ?);";
            
            $idConcession_Stands = sprintf("%04d", mt_rand(1, 9999));
            
            $stmt = mysqli_prepare($dbc, $query);
                            
            mysqli_stmt_bind_param($stmt, "isss", $idConcession_Stands, $name, $description, $location);
            
            mysqli_stmt_execute($stmt);
            
            $affected_rows = mysqli_stmt_affected_rows($stmt);
            
            if($affected_rows == 1){
                
                echo '<center><h1>Concession_Stands Successfully Entered</h1></center>';
                
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

<a href="viewConcessionStands.php" class="button">View Concession Stands</a>

<?php
$siteBuilder->getClosinghtmlTags();
?>

