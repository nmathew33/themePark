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

$siteBuilder->getOpeningHtmlTags('Admin');

$siteBuilder->getGreyOverLay();


$siteBuilder->getMenu();
?>
<header style="background-color:#4F52BA;">
	<div>
		<center>
			<h1 style="color:white;">Archived Data</h1>
		</center>
	</div>
</header>


	<div>
		<form action="archive.php" method="post" id="priceform" >
            <p>Select Table
            	<select name = 'sqlarchive'>
  				<option value="SELECT * FROM Users WHERE archive='yes'">Employees</option>
  				<option value="SELECT * FROM Shift_Schedule WHERE archive='yes'">Shift Schedule</option>
  				<option value="SELECT * FROM Concession_Stands WHERE archive='yes'">Concession Stands</option>
  				<option value="SELECT * FROM Concession_Pricing WHERE archive='yes'">Concessions</option>  				
  				<option value="SELECT * FROM Rides WHERE archive='yes'">Rides</option>
  				<option value="SELECT * FROM Maintenance WHERE archive='yes'">Maintenance</option>
				</select>
            </p>
            <input type = "submit" value="Select">
        </form>
        <?php
        	if (isset($_POST['sqlarchive'])){
        		require_once('../db_connection.php');

        		$response = @mysqli_query($dbc, $_POST['sqlarchive']);

        		echo '<form action="archiveModify.php" id="modify" method="post" enctype="multipart/form=data">';

        		echo '<table align="left"cellspacing="5" cellpadding="8" class="report"><tr>';

        		echo "<td align='left'></td>";
        		echo "<td align='left'></td>";

	            while($property = mysqli_fetch_field($response)){
	            	$columnName[] = $property->name;
	            	echo "<td align='left'><b>$property->name</b></td>";
	            }

	            $tableName = ltrim($columnName[0], 'id');

	            echo "<input type='hidden' name='tableName' value='$tableName' form='modify'>";

	            echo '</tr>';

	            while($row = mysqli_fetch_array($response)){

		            echo '<tr>';
		            echo '<td align="left"><button type="submit" name="restore" value="' . $row["$columnName[0]"] . '" form="modify">restore</button>'  . '</td><td align="left">' ;
           			echo '<button type="submit" name="delete" value="' . $row["$columnName[0]"] . '" form="modify">delete</button>'  . '</td>' ;
		            foreach ($columnName as $cn) {
					    echo '<td align="left">' . $row["$cn"] . '</td>';
					}
		            

		            echo '</tr>';
		         }

	            echo '</table>';
	            echo '</form>';
        	}
        ?>
	</div>


<?php
$siteBuilder->getClosinghtmlTags();
?>