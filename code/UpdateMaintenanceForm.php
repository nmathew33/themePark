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
    if(isset($_POST['closeMaintenance'])){
        require_once('../db_connection.php');
        
        $query = "DELETE FROM Maintenance WHERE idMaintenance= ?";

        $stmt = mysqli_prepare($dbc, $query);

        mysqli_stmt_bind_param($stmt, "i", $_POST['closeMaintenance']);

        mysqli_stmt_execute($stmt);

        $affected_rows = mysqli_stmt_affected_rows($stmt);

        if($affected_rows == 1){
            
            echo '<center><h1>User Successfully Entered</h1></center>';
            mysqli_stmt_close($stmt);
            mysqli_close($dbc);
            header('Location: maintenance.php');

        } else {
            
            echo '<center><h1>Error Occurred</h1></center>';
            echo mysqli_error();
            
            mysqli_stmt_close($stmt);
            mysqli_close($dbc);
            
            
        } 

        
    }
    if(isset($_POST['updateMaintenance'])){
        require_once('../db_connection.php');

        $query = "SELECT idMaintenance, user_created, ticket_description, ride
            FROM Maintenance Where idMaintenance =" . $_POST['updateMaintenance'];
        $response = @mysqli_query($dbc, $query);
        if($response){
            $row = mysqli_fetch_array($response);
            $maint = $row['idMaintenance'];
            $userID = $row['user_created'];
            $ride = $row['ride'];
            $descrip = $row['ticket_description']; 
            echo '<form action="resolveMaintenance.php" method="post" id="updateEmployeeForm">';
            echo '<b>Update Ticket</b>';
            echo '<input type="hidden" name="maint_id" value="'. $maint .'"/>';
                
            echo '<p>User ID: '. $userID .'
                    </p>
                    <p>Ride ID: '. $ride .'
                    </p>
                    <p>
                        Ticket Description: '. $descrip.'
                    </p>
    
        <p>Closing User ID:
            <input type="text" name="closed_id" size="30" value="" />
        </p>
        <p>
            Resolution Details:
        </p>
        <textarea name = "close_description" rows = "5" cols = "50">
            </textarea>
        <p>
            <input type="submit" name="submit" value="Update" class="button"/>
        </p>';
            
            echo '</form>';
        } else {
            echo "Couldn't obtain Maintenance Ticket";

            echo mysqli_error($dbc);
        }

        mysqli_close($dbc);
    }
?>


<?php
$siteBuilder->getClosinghtmlTags();
?>
