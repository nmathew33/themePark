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

$siteBuilder->getOpeningHtmlTags('Rides');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>
<div class = "content" >
    <h1>Rides</h1>
    <form action="viewRides.php" method="post">
       <select name = 'by'>
            <option value="idRides">ID</option>
            <option value="in_use">Active</option>
            <option value="staff">Staff</option>
            <option value="name">Name</option>
            <option value="description">Description</option>
            <option value="date_created">Date Created</option>
        </select>
      <input type="submit">
      <a href="insertRideForm.php" class="button">Add Ride</a>
    </form>
    


    
        <?php
            if(isset($_POST['by'])){
                
            $by = $_POST['by'];

                echo '<form action="editingRides.php" method="post" enctype="multipart/form=data"> 
                            <button type="submit" name="by" value="' . $by . '">Select</button>
                        </form> ';
                echo '<div class="reports">';
                
                $query = "SELECT idRides, in_use, staff, name, description, date_created FROM Rides ORDER BY " . $by;
            } else{
                
                 echo '<form action="editingRides.php" method="post" enctype="multipart/form=data"> 
                        <button type="submit" value="">Select</button>
                    </form> ';
                echo '<div class="reports">';
            
                $query = "SELECT idRides, in_use, staff, name, description, date_created FROM Rides";
                
            }
            require_once('../db_connection.php');

            $response = @mysqli_query($dbc, $query);
            
            if($response){
            echo '<table align="left"
            cellspacing="5" cellpadding="8" class="report">

            <tr><td align="left"><b>ID</b></td>
            <td align="left"><b>Name</b></td>
            <td align="left"><b>Active</b></td>
            <td align="left"><b>Description</b></td>
            <td align="left"><b>Staff</b></td>
            <td align="left"><b>date_created</b></td></tr>';

        
            while($row = mysqli_fetch_array($response)){

            echo '<tr><td align="left">' . 
            $row['idRides'] . '</td><td align="left">' . 
            $row['name'] . '</td><td align="left">' .
            ($row['in_use'] ? 'yes' : 'no') . '</td><td align="left">' .
            $row['description'] . '</td><td align="left">' .
            $row['staff'] . '</td><td align="left">' . 
            $row['date_created'] . '</td><td align="left">';

            echo '</tr>';
            }

            echo '</table>';
            } else {

            echo "Couldn't issue database query<br />";

            echo mysqli_error($dbc);

            }

            mysqli_close($dbc);

            echo '</div>';
        ?>
  
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>
