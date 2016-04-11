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

$siteBuilder->getOpeningHtmlTags('Rain Out');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();

?>
<dic class="content">
    <?php

        if(isset($_POST['submit'])){

            $data_missing = array();

            if(empty($_POST['ride'])){

                $data_missing[] = 'ride';

            } else {

                $ride = trim($_POST['ride']);

            }

            if(empty($_POST['comment'])){

                $data_missing[] = 'comment';

            } else{

                $comment = trim($_POST['comment']);

            }

            if(empty($_POST['date'])){

                $data_missing[] = 'date';

            } else {

                $date = trim($_POST['date']);

            }

            
            if(empty($data_missing)){
                
                require_once('../db_connection.php');
                
                $query = "INSERT INTO Rainout (idRainout, ride, comments, date, date_created) VALUES (?, ?, ?, ?, NOW());";

                $stmt = mysqli_prepare($dbc, $query);
                
                $idRainout = sprintf("%04d", mt_rand(1, 9999));
                                
                mysqli_stmt_bind_param($stmt, "iiss", $idRainout, $ride, $comment, $date);
                
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

    <a href="rainOut.php" class="button">View Rain Outs</a>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>