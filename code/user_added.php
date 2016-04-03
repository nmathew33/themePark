<html>
    <head>
        <title>Register User</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <img src="http://hdwallpaperslovely.com/wp-content/gallery/black-and-grey-wallpaper/Black_and_Grey_Pattern_by_kkll70.png">
        <div class = "subheader">
	   	   UmaLand
	    </div>
        
        <div>
            <table class = "menu">
                <tr>
                    <td><a href="clockInOut.php" class="buttonMenu">Check In/Out</a></td>
                    <td><a href="scheduling.php" class="buttonMenu">Scheduling</a></td>
                    <td><a href="ticketing.php" class="buttonMenu">Ticketing</a></td>
                    <td><a href="concessions.php" class="buttonMenu">Concessions</a></td>
                    <td><a href="maintenance.php" class="buttonMenu">Maitenance</a></td>
                    <td><a href="managment.php" class="buttonMenu">Management</a></td>
                    <td><a href="admin.php" class="buttonMenu">Admin</a></td>
                </tr>
            </table>
        </div>
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
                    
                    mysqli_stmt_bind_param($stmt, "sisssssssss", $userId, $roleId, $f_name, $l_name, $email,
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
</body>
</html>