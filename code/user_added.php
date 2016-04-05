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

$siteBuilder->getOpeningHtmlTags('User');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>

<dic class="content">
        <?php

            if(isset($_POST['submit'])){
    
                $data_missing = array();
    
                if(empty($_POST['first_name'])){

                    $data_missing[] = 'First Name';

                } else {

                    $f_name = trim($_POST['first_name']);

                }

                if(empty($_POST['last_name'])){

                    $data_missing[] = 'Last Name';

                } else{

                    $l_name = trim($_POST['last_name']);

                }

                if(empty($_POST['role'])){

                    $data_missing[] = 'Role';

                } else{

                    $role = trim($_POST['role']);

                }

                if(empty($_POST['email'])){

                    $data_missing[] = 'Email';

                } else {

                    $email = trim($_POST['email']);

                }

                if(empty($_POST['street'])){

                    $data_missing[] = 'Street';

                } else {

                    $street = trim($_POST['street']);

                }

                if(empty($_POST['city'])){

                    $data_missing[] = 'City';

                } else {

                    $city = trim($_POST['city']);

                }

                if(empty($_POST['state'])){

                    $data_missing[] = 'State';

                } else {

                    $state = trim($_POST['state']);

                }

                if(empty($_POST['zip'])){

                    $data_missing[] = 'Zip Code';

                } else {

                    $zip = trim($_POST['zip']);

                }

                if(empty($_POST['phone'])){

                    $data_missing[] = 'Phone Number';

                } else {

                    $phone = trim($_POST['phone']);

                }

                if(empty($_POST['ssn'])){

                    $data_missing[] = 'Social Security Number';

                } else {

                    $ssn = trim($_POST['ssn']);

                }

                if(empty($_POST['gender'])){

                    $data_missing[] = 'Gender';

                } else {

                    $gender = trim($_POST['gender']);

                }

                if(empty($_POST['password'])){

                    $data_missing[] = 'Password';

                } else {

                    $password = trim($_POST['password']);

                }

                if(empty($_POST['employed_date'])){

                    $data_missing[] = 'Date Employed';

                } else {

                    $e_date = trim($_POST['employed_date']);

                }

                
    
                if(empty($data_missing)){
                    
                    require_once('../db_connection.php');
                    
                    $query = "INSERT INTO Users (idUsers, role_id, first_name, last_name, email,
                    address, phone, ssn, gender, password, date_employed) VALUES ( ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = mysqli_prepare($dbc, $query);
                    
                    $userId = sprintf("%06d", mt_rand(1, 999999));
                    
                    $roleId = intval($role);
                    
                    $address = $street . ' ' . $city . ', ' . $state . ' ' . $zip;
                    
                    mysqli_stmt_bind_param($stmt, "iisssssssss", $userId, $roleId, $f_name, $l_name, $email,
                                           $address, $phone, $ssn, $gender, $password, $e_date);
                    
                    mysqli_stmt_execute($stmt);
                    
                    $affected_rows = mysqli_stmt_affected_rows($stmt);
                    
                    if($affected_rows == 1){
                        
                        echo '<center><h1>User Successfully Entered</h1></center>';
                        
                        mysqli_stmt_close($stmt);
                        mysqli_close($dbc);
                        
                        
                    } else {
                        
                        echo '<center><h1>Error Occurred</h1></center>';
                        echo mysqli_error();
                        
                        mysqli_stmt_close($stmt);
                        mysqli_close($dbc);
                       
                        
                    }
                    
                } else {
                    
                    echo '<center><h1>You need to enter the following data</h1>';
                    
                    foreach($data_missing as $missing){
                        
                        echo "$missing<br />";
                        
                    }
                    
                    echo '</center>';
                    
                }
                
            }

        ?>

        <a href="registrate_new_user.php" class="button">Create New User</a>
        </div>

<?php
$siteBuilder->getClosinghtmlTags();
?>
