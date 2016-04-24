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
    <h1>Concession Pricing</h1>
    <form action="viewConcession.php" method="post">
       <select name = 'by'>
            <option value="idConcession_Pricing">ID</option>
            <option value="Concession_Stands.location">Location</option>
            <option value="price">Price</option>
            <option value="name">Name</option>
        </select>
      <input type="submit">
      <a href="insertConcessionForm.php" class="button">Add Concession</a>
    </form>


    
        <?php
            if(isset($_POST['by'])){
                
            $by = $_POST['by'];

                echo '<form action="editingConcession.php" method="post" enctype="multipart/form=data"> 
                            <button type="submit" name="by" value="' . $by . '">Select</button>
                        </form> ';
                echo '<div class="reports">';
                
                $query = "SELECT idConcession_Pricing, Concession_Pricing.name, Concession_Pricing.price, Concession_Stands.name AS cstn, Concession_Stands.location FROM Concession_Pricing, Concession_Stands WHERE Concession_Pricing.location = idConcession_Stands AND Concession_Pricing.archive='no' ORDER BY " . $by;
            } else{
                
                 echo '<form action="editingConcession.php" method="post" enctype="multipart/form=data"> 
                        <button type="submit" value="">Select</button>
                    </form> ';
                echo '<div class="reports">';
            
                $query = "SELECT idConcession_Pricing, Concession_Pricing.name, Concession_Pricing.price, Concession_Stands.name AS cstn, Concession_Stands.location FROM Concession_Pricing, Concession_Stands WHERE Concession_Pricing.location = idConcession_Stands AND Concession_Pricing.archive='no'";
                
            }
            require_once('../db_connection.php');

            $response = @mysqli_query($dbc, $query);
            
            if($response){
            echo '<table align="left"
            cellspacing="5" cellpadding="8" class="report">

            <tr><td align="left"><b>ID</b></td>
            <td align="left"><b>Name</b></td>
            <td align="left"><b>Stand</b></td>
            <td align="left"><b>Location</b></td>
            <td align="left"><b>Price</b></td></tr>';

        
            while($row = mysqli_fetch_array($response)){

            echo '<tr><td align="left">' . 
            $row['idConcession_Pricing'] . '</td><td align="left">' . 
            $row['name'] . '</td><td align="left">' .
            $row['cstn'] . '</td><td align="left">' .
            $row['location'] . '</td><td align="left">' .
            $row['price'] . '</td><td align="left">';

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
  
<?php
$siteBuilder->getClosinghtmlTags();
?>
