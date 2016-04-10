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

$siteBuilder->getOpeningHtmlTags('Ride');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>

<div class = "content" >
    <?php 
        if(isset($_POST['deleteRidesID'])){
            require_once('../db_connection.php');
            
            $query = "DELETE FROM Rides WHERE idRides=?;";

            $stmt = mysqli_prepare($dbc, $query);

            mysqli_stmt_bind_param($stmt, "i", $_POST['deleteRidesID']);

            mysqli_stmt_execute($stmt);

            $affected_rows = mysqli_stmt_affected_rows($stmt);

            if($affected_rows == 1){
                
                echo '<center><h1>User Successfully Entered</h1></center>';
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
                header('Location: viewRides.php');

            } else {
                
                echo '<center><h1>Error Occurred</h1></center>';
                echo mysqli_error($dbc);
                
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
               
                
            } 

            
        }
        if(isset($_POST['updateR'])){
            require_once('../db_connection.php');

            $query = "SELECT * FROM Rides WHERE idRides = " . $_POST['updateRidesID'] . " LIMIT 1";
            $response = @mysqli_query($dbc, $query);
            if($response){
                
                echo '<form action="updateRide.php" method="post" id="updateRide">';
                echo '<b>Update Shift</b>
                        <div class = "col1">';
                
                    
                echo '<input type="hidden" name="idConcession" size="30" value="' . $_POST['updateRidesID'] . '" />';
                
                
                
                echo '
                <p>Name:
                    <input type="text" name="name" size="30" value="'. $row['name'] .'" />
                </p>
        
                <p>Price:
                    <input type="text" name="price" size="30" value="'. $row['name']  . '" />
                </p>';

                echo '</div>';

                echo '<p>
                    <input type="submit" name="submit" value="Submit" class="button"/>
                </p>';

                echo '</form>';
            } else {
                echo "Couldn't obtain schedule to update";

                echo mysqli_error($dbc);
            }

            mysqli_close($dbc);
        }
    ?>
    
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>