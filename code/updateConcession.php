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

$siteBuilder->getOpeningHtmlTags('Concession');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();

?>
<dic class="content">
    <?php

        if(isset($_POST['submit'])){

            $data_missing = array();

            if(empty($_POST['idConcession'])){

                $data_missing[] = 'idConcession';

            } else {

                $idConcession = trim($_POST['idConcession']);

            }

            if(empty($_POST['price'])){

                $data_missing[] = 'price';

            } else{

                $price = trim($_POST['price']);

            }

            if(empty($_POST['name'])){

                $data_missing[] = 'name';

            } else {

                $name = trim($_POST['name']);

            }
            
            if(empty($_POST['location'])){

                $data_missing[] = 'location';

            } else {

                $location = trim($_POST['location']);

            }

            
            if(empty($data_missing)){
                
                require_once('../db_connection.php');
                
                $query = "UPDATE Concession_Pricing SET location = ?, price = ?, name = ? WHERE idConcession_Pricing = ?";

                $stmt = mysqli_prepare($dbc, $query);
                
                $doubleprice = floatval($price);
                                
                mysqli_stmt_bind_param($stmt, "idsi", $location, $doubleprice, $name, $idConcession);
                
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

    <a href="viewConcession.php" class="button">View Concession Stands</a>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>