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
        if(isset($_POST['updateConcessionID'])){
            require_once('../db_connection.php');

            $query = "SELECT idConcession_Pricing, Concession_Pricing.location AS lo, price, Concession_Pricing.name, Concession_Stands.name AS cstn, Concession_Stands.location AS cstl FROM Concession_Pricing, Concession_Stands WHERE idConcession_Pricing=" . $_POST['updateConcessionID'] . " AND Concession_Pricing.location = idConcession_Stands LIMIT 1";
            $response = @mysqli_query($dbc, $query);
            if($response){
                
                $row = mysqli_fetch_array($response);
                $concessionId = $row['idConcession_Pricing'];
                $concessionName = $row['name'];
                $concessionLocationID = $row['lo'];
                $cstn = $row['cstn'];
                $cstl = $row['cstl'];
                $concessionPrice = $row['price'];
                
                echo '<form action="updateConcession.php" method="post" id="updateConcession">';
                echo '<b>Update Shift</b>
                        <div class = "col1">';
                
                    
                echo '<input type="hidden" name="idConcession" size="30" value="' . $concessionId . '" />';
                
                echo '<p>Location:';
                    $query = "SELECT idConcession_Stands, Concession_Stands.location as loc, name FROM Concession_Stands";
                    $response = @mysqli_query($dbc, $query);
                    if($response){
                        echo '<select name="location"  form="updateConcession">';
                        echo '<option value="' . $concessionLocationID . '">' . $cstn . " -- " . $cstl .'</option>'; 
                        while($row = mysqli_fetch_array($response)){
                            echo '<option value="' . $row['idConcession_Stands'] . '">' . 
                            $row['name'] . " -- " . $row['loc'];
                            echo '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo "Couldn't obtain role list";

                        echo mysqli_error($dbc);
                    }
            
                echo '</p>';
                
                echo '
                <p>Name:
                    <input type="text" name="name" size="30" value="'. $concessionName .'" />
                </p>
        
                <p>Price:
                    <input type="text" name="price" size="30" value="'. $concessionPrice . '" />
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