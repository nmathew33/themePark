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

<div class = "content" >
    <form action="user_added.php" method="post" id="rainout" >
        
        <b>Insert Rain Out</b>
        <div>
            <p>Date:
                <input type="date" name="date" value="" />
            </p>
            
            <p>Rides:
                <?php 

                    require_once('../db_connection.php');

                    $query = "SELECT * FROM Rides";
                    $response = @mysqli_query($dbc, $query);
                    if($response){
                        echo '<select name="ride"  form="rainout">';

                        while($row = mysqli_fetch_array($response)){
                            echo '<option value="' . $row['idRides'] . '">' .
                            $row['name'];
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

            <p>Comment:
                <input type="text" name="comment" size="30" value="" />
            </p>
        </div>
        
    </form>
</div>


<?php
$siteBuilder->getClosinghtmlTags();
?>