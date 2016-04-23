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

$siteBuilder->getOpeningHtmlTags('Concessions');

$siteBuilder->getGreyOverLay();

$siteBuilder->getMenu();
?>

<center class="info">
        <h1>Concessions Stands</h1>
        <form action="concession_stand_items.php" method="post" id="priceform" >
            <p>Concession Stand Name:
            <?php 

                require_once('../db_connection.php');

                $query = "SELECT * FROM Concession_Stands";
                $response = @mysqli_query($dbc, $query);
                if($response){
                    echo '<select name="ConcessionName"  form="priceform">';

                    while($row = mysqli_fetch_array($response)){
                        echo '<option value="' . $row['idConcession_Stands'] . '">' . $row['name'];
                        echo '</option>';
                    }

                    echo '</select>';
                } else {
                    echo "Couldn't obtain role list";

                    echo mysqli_error($dbc);
                }

                mysqli_close($dbc);

            ?>
            </p>
            <input type = "submit" value="Select">
        </form>
</center>


<?php
$siteBuilder->getClosinghtmlTags();
?>