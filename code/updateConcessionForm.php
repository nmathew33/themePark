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

$siteBuilder->getOpeningHtmlTags('Ticketing');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>

<div class = "content" >
    <?php 
        if(isset($_POST['deleteConcessionID'])){
            require_once('../db_connection.php');
            
            $query = "DELETE FROM Concession_Pricing WHERE idConcession_Pricing=?;";

            $stmt = mysqli_prepare($dbc, $query);

            mysqli_stmt_bind_param($stmt, "i", $_POST['deleteConcessionID']);

            mysqli_stmt_execute($stmt);

            $affected_rows = mysqli_stmt_affected_rows($stmt);

            if($affected_rows == 1){
                
                echo '<center><h1>User Successfully Entered</h1></center>';
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
                header('Location: viewConcession.php');

            } else {
                
                echo '<center><h1>Error Occurred</h1></center>';
                echo mysqli_error($dbc);
                
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
               
                
            } 

            
        }
        if(isset($_POST['updateConcessionStandID'])){
            require_once('../db_connection.php');

            $query = "SELECT idConcession_Stands, name, description, location FROM Concession_Stands WHERE idConcession_Stands=" . $_POST['updateConcessionStandID'] . " LIMIT 1";
            $response = @mysqli_query($dbc, $query);
            if($response){
                $row = mysqli_fetch_array($response);
                echo '<form action="updateConcessionStand.php" method="post" id="ConcessionStand">';
                echo '<b>Update Shift</b>
                        <div class = "col1">';
                
                    
                echo '<input type="hidden" name="idConcession_Stands" size="30" value="' . $row['idConcession_Stands'] . '" />';
                echo '
                <p>Name:
                    <input type="text" name="name" size="30" value="'. $row['name'] .'" />
                </p>

                <p>Description:
                    <input type="text" name="description" size="100" value="' . $row['description'] . '" />
                </p>
        
                <p>Location:
                    <input type="text" name="location" size="30" value="'. $row['location'] . '" />
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