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

$siteBuilder->getOpeningHtmlTags('Concession Stand');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>

<div class = "content" >
    <form action="insertConcession.php" method="post" id="insertConcessionStandForm" >
        
        <b>Add Shift</b>
            <div class = "col1">
        
                <p>Stand:
                    <?php 

                        require_once('../db_connection.php');

                        $query = "SELECT * FROM Concession_Stands";
                        $response = @mysqli_query($dbc, $query);
                        if($response){
                            echo '<select name="stand"  form="insertConcessionStandForm">';

                            while($row = mysqli_fetch_array($response)){
                                echo '<option value="' . $row['idConcession_Stands'] . '">' . 
                                $row['name'] . " -- " . $row['location'];
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

                <p>Name:
                    <input type="text" name="name" size="30" value="" />
                </p>
        
            </div>

            <div class = "col2">

                <p>Price:
                    <input type="text" name="price" size="30" value="" />
                </p>

                <p>
                    <input type="submit" name="submit" value="Submit" class="button"/>
                </p>

            </div>
    </form>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>