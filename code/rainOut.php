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
    <h1>Rain Outs</h1>
    <form action="rainOut.php" method="post">
      Rain Out (month and year):
      <input type="month" name="yearMonth">
	  <input type="submit">
    </form>


    
        <?php
            if(isset($_POST['yearMonth'])){
                
                $month = $_POST['yearMonth'];

                echo '<div class="reports">';

                require_once('../db_connection.php');

                $month = $month . '%';

                $query = 
				"SELECT idRainout, name, comments, date, Rainout.date_created
				FROM Rainout, Rides
				WHERE ride = idRides AND  date LIKE '$month'";

                $response = @mysqli_query($dbc, $query);
                if($response){
                echo '<table align="left"
                cellspacing="5" cellpadding="8" class="report">

                <tr><td align="left"><b>idRainout</b></td>
				<td align="left"><b>Name</b></td>
                <td align="left"><b>Comments</b></td>
                <td align="left"><b>date</b></td>
                <td align="left"><b>date_created</b></td></tr>';

            
                while($row = mysqli_fetch_array($response)){

                echo '<tr><td align="left">' . 
                $row['idRainout'] . '</td><td align="left">' .
				$row['name'] . '</td><td align="left">' . 
                $row['comments'] . '</td><td align="left">' .
                $row['date'] . '</td><td align="left">' . 
                $row['date_created'] . '</td><td align="left">';

                echo '</tr>';
                }

                echo '</table>';
                } else {

                echo "Couldn't issue database query<br />";

                echo mysqli_error($dbc);

                }

                mysqli_close($dbc);

                }    
                echo '</div>';
        ?>
  
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>
