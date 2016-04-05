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

$siteBuilder->getOpeningHtmlTags('Shift Schedule');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>

<div class = "content" >
    <?php 
        if(isset($_POST['deleteEmployeeID'])){
            require_once('../db_connection.php');
            
            $query = "DELETE FROM Users WHERE idUsers=?;";

            $stmt = mysqli_prepare($dbc, $query);

            mysqli_stmt_bind_param($stmt, "i", $_POST['deleteEmployeeID']);

            mysqli_stmt_execute($stmt);

            $affected_rows = mysqli_stmt_affected_rows($stmt);

            if($affected_rows == 1){
                
                echo '<center><h1>User Successfully Entered</h1></center>';
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
                header('Location: viewEmployee.php');

            } else {
                
                echo '<center><h1>Error Occurred</h1></center>';
                echo mysqli_error();
                
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
               
                
            } 

            
        }
        if(isset($_POST['updateEmployeeID'])){
            require_once('../db_connection.php');

            $query = "SELECT idUsers, role_id, Roles.name, first_name, last_name, email, address, phone,
            ssn, gender, password, date_employed FROM Users, Roles Where idRoles = role_id AND idUsers =" . $_POST['updateEmployeeID'];
            $response = @mysqli_query($dbc, $query);
            if($response){
                $row = mysqli_fetch_array($response);
                $userID = $row['idUsers'];
                $rID = $row['role_id']; 
                $rName = $row['name']; 
                $fname = $row['first_name']; 
                $lname = $row['last_name']; 
                $email = $row['email']; 
                $adress = $row['address']; 
                $phone = $row['phone']; 
                $ssn = $row['ssn']; 
                $gender = $row['gender']; 
                $pass = $row['password']; 
                $demployed = $row['date_employed'];                
          
                echo '<form action="updateEmployee.php" method="post" id="updateEmployeeForm">';
                echo '<b>Update Employee</b>
                        <div class = "col1">';
                echo '<input type="hidden" name="userID" value="'. $userID .'"/>';
                    
                echo '<p>First Name:
                            <input type="text" name="first_name" size="30" value="'.$fname.'" />
                        </p>
                
                        <p>Last Name:
                            <input type="text" name="last_name" size="30" value="'.$lname.'" />
                        </p>';
                echo '<p>Role: ';        
                $query = "SELECT * FROM Roles WHERE name != 'admin'";
                $response = @mysqli_query($dbc, $query);
                if($response){
                    echo '<select name="role"  form="updateEmployeeForm">';
                    
                    echo '<option value="' . $rID . '">' .
                        $rName . '</option>';

                    while($row = mysqli_fetch_array($response)){
                        echo '<option value="' . $row['idRoles'] . '">' .
                        $row['name'] . '</option>';
                    }

                    echo '</select>';
                } else {
                    echo "Couldn't obtain role list";

                    echo mysqli_error($dbc);
                }
                echo '</p>'; 
                echo '<p>Email:
                            <input type="text" name="email" size="30" value="'.$email.'" />
                        </p>
                
                        <p>Address:
                            <input type="text" name="address" size="30" value="'.$adress.'" />
                        </p>';
                
                echo '</div>';

                echo '<div class = "col2">';

                echo '<p>Phone Number:
                            <input type="text" name="phone" size="12" value="'.$phone.'" />
                        </p>

                        <p>Social Security Number:
                            <input type="text" name="ssn" size="9" value="'.$ssn.'" />
                        </p>
                
                        <p>Gender (M or F):
                            <input type="text" name="gender" size="1" maxlength="1" value="'.$gender.'" />
                        </p>
                
                        <p>Password:
                            <input type="password" name="password" size="30" value="'.$pass.'" />
                        </p>

                        <p>Date Employed (YYYY-MM-DD):
                            <input type="text" name="employed_date" size="10" value="'.$demployed.'" />
                        </p>
                
                        <p>
                            <input type="submit" name="submit" value="Submit" class="button"/>
                        </p>';

                echo '</div>';
                echo '</form>';
            } else {
                echo "Couldn't obtain Employee to update";

                echo mysqli_error($dbc);
            }

            mysqli_close($dbc);
        }
    ?>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>
