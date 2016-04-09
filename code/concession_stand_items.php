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

	$siteBuilder->getSubTitle();

	$siteBuilder->getMenu();
?>

<div class = "content" >
     <center class="info">
             <h1>Concessions Stands</h1>
 			<?php

             if(isset($_POST['ConcessionName'])){
             	echo '<div class="reports">';

             	require_once('../db_connection.php');

                $query = "SELECT idConcession_Pricing, name ,price 
                 		  FROM Concession_Pricing
                 		  WHERE location = " . $_POST['ConcessionName'];

                $response = @mysqli_query($dbc, $query);

                if($response){
 	            echo '<table align="left"
 	            cellspacing="5" cellpadding="8" class="report">

 	            <tr><td align="left"><b>Name</b></td>
 	            <td align="left"><b>Concession ID</b></td>
 	            <td align="left"><b>Price</b></td></tr>';

             	while($row = mysqli_fetch_array($response)){
             		echo 'while poop';
            	echo '<tr><td align="left">' . 
            	$row['idConcession_Pricing'] . '</td><td align="left">' . 
            	$row['name'] . '</td><td align="left">' .
            	$row['price'] . '</td><td align="left">';
            	echo '</tr>';

            	}
            	echo '</table>';
            } else {
            	echo "Couldn't issue database query<br />";
            	//echo mysqli_error($dbc);
            }
            //mysqli_close($dbc);
            echo '</div>';
        }
        ?>
     </center>
 </div> 

<?php
 $siteBuilder->getClosinghtmlTags();
 ?>
