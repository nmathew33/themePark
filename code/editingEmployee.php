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

<h1>Employee List</h1>
<form action="editingEmployee.php" method="post">
    <select name = 'by'>
        <option value="idUsers">ID</option>
        <option value="name">Role</option>
        <option value="first_name">First Name</option>
        <option value="last_name">Last Name</option>
        <option value="email">Email</option>
        <option value="address">Address</option>
        <option value="phone">Phone</option>
        <option value="ssn">SSN</option>
        <option value="gender">Gender</option>
        <option value="date_employed">Date Employed</option>
    </select>
    <input type="submit">
    <a href="registrate_new_user.php" class="button">Add Employee</a>
</form>

    <?php
    
        if(isset($_POST['by'])){
            
        $by = $_POST['by'];

            echo '<form action="viewEmployee.php" method="post" enctype="multipart/form=data"> 
                        <button type="submit" name="by" value="' . $by . '">Select</button>
                    </form> ';
            echo '<div class="reports">';
            
            $query = "SELECT idUsers, Roles.name, first_name, last_name, email, address, phone,
        ssn, gender, date_employed FROM Users, Roles Where idRoles = role_id ORDER BY " . $by;
        
        } else{
            
                echo '<form action="viewEmployee.php" method="post" enctype="multipart/form=data"> 
                    <button type="submit" value="">Select</button>
                </form> ';
            echo '<div class="reports">';
        
            $query = "SELECT idUsers, Roles.name, first_name, last_name, email, address, phone,
                        ssn, gender, date_employed FROM Users, Roles Where idRoles = role_id";
            
        }
        require_once('../db_connection.php');

        $response = @mysqli_query($dbc, $query);
        
        echo '<form action="updateEmployeeForm.php" method="post" enctype="multipart/form=data">';
        
        if($response){
        echo '<table align="left"
        cellspacing="5" cellpadding="8" class="report">

        <tr><td align="left"><b></b></td>
        <td align="left"><b></b></td>
        <td align="left"><b>ID</b></td>
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
            '<button type="submit" name="updateEmployeeID" value="' . $row['idUsers'] . '">edit</button>'  . '</td><td align="left">' . 
            '<button type="submit" name="deleteEmployeeID" value="' . $row['idUsers'] . '">delete</button>'  . '</td><td align="left">' . 
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
        echo '</form>';
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
