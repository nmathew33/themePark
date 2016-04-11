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

$siteBuilder->getOpeningHtmlTags('User');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>

<dic class="content">
        <?php

            if(isset($_POST['submit'])){
    
                $data_missing = array();
               if(empty($_POST['maint_id'])){

                    $data_missing[] = 'Maintenance ID';

                } else {

                    $maint = trim($_POST['maint_id']);

                }
                if(empty($_POST['closed_id'])){

                    $data_missing[] = 'Close ID';

                } else {

                    $user = trim($_POST['closed_id']);

                }

                if(empty($_POST['close_description'])){

                    $data_missing[] = 'Resolve Desciption';

                } else{

                    $descrip = trim($_POST['close_description']);

                }

               

                
    
                if(empty($data_missing)){
                    
                    require_once('../db_connection.php');
                    
                    $query = "UPDATE Maintenance SET user_closed = ?, date_closed = ?, closed_description = ?
                    WHERE idMaintenance = $maint";
                    
                    $stmt = mysqli_prepare($dbc, $query);
                    
                    $dateEnd = date("Y-m-d H:i:s");               
  
                    mysqli_stmt_bind_param($stmt, "ids", $user,$dateEnd, $descrip);
              
                    mysqli_stmt_execute($stmt);
                    
                    $affected_rows = mysqli_stmt_affected_rows($stmt);
                    
                    if($affected_rows == 1){
                        
                        echo '<center><h1>Ticket Resolved</h1></center>';
                        
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

        <a href="maintenance.php" class="add_maintenance">Back</a>
        </div>

<?php
$siteBuilder->getClosinghtmlTags();
?>
