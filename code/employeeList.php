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

$siteBuilder->getOpeningHtmlTags('Welcome');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>

<div class = "content" >
            <h1>Employee List</h1>
            <div class="reports">
                <?php
                    require_once('../db_connection.php');

                    $query = "SELECT idUsers, Roles.name, first_name, last_name, email, address, phone,
                    ssn, gender, date_employed FROM Users, Roles Where idRoles = role_id";

                    $response = @mysqli_query($dbc, $query);

                    if($response){
                    echo '<table align="left"
                    cellspacing="5" cellpadding="8" class="report">

                    <tr><td align="left"><b>ID</b></td>
                    <td align="left"><b>Role</b></td>
                    <td align="left"><b>First Name</b></td>
                    <td align="left"><b>Last Name</b></td>
                    <td align="left"><b>Email</b></td>
                    <td align="left"><b>Address</b></td>
                    <td align="left"><b>Phone</b></td>
                    <td align="left"><b>SSN</b></td>
                    <td align="left"><b>Gender</b></td>
                    <td align="left"><b>Date Employed</b></td></tr>';

                
                    while($row = mysqli_fetch_array($response)){

                    echo '<tr><td align="left">' . 
                    $row['idUsers'] . '</td><td align="left">' . 
                    $row['name'] . '</td><td align="left">' .
                    $row['first_name'] . '</td><td align="left">' . 
                    $row['last_name'] . '</td><td align="left">' .
                    $row['email'] . '</td><td align="left">' . 
                    $row['address'] . '</td><td align="left">' . 
                    $row['phone'] . '</td><td align="left">' .
                    $row['ssn'] . '</td><td align="left">' .
                    $row['gender'] . '</td><td align="left">' .
                    $row['date_employed'] . '</td><td align="left">';

                    echo '</tr>';
                    }

                    echo '</table>';
                    } else {

                    echo "Couldn't issue database query<br />";

                    echo mysqli_error($dbc);

                    }

                    mysqli_close($dbc);

                    ?>
            </div>

<?php
$siteBuilder->getClosinghtmlTags();
?>
