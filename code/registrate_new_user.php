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
                    <td><a href="http://localhost/themePark/code/clockInOut.php" class="buttonMenu">Check In/Out</a></td>
                    <td><a href="http://localhost/themePark/code/scheduling.php" class="buttonMenu">Scheduling</a></td>
                    <td><a href="http://localhost/themePark/code/ticketing.php" class="buttonMenu">Ticketing</a></td>
                    <td><a href="http://localhost/themePark/code/concessions.php" class="buttonMenu">Concessions</a></td>
                    <td><a href="http://localhost/themePark/code/maintenance.php" class="buttonMenu">Maitenance</a></td>
                    <td><a href="http://localhost/themePark/code/managment.php" class="buttonMenu">Management</a></td>
                    <td><a href="http://localhost/themePark/code/admin.php" class="buttonMenu">Admin</a></td>
                </tr>
            </table>
        </div>
        
        <div class = "content" >
            <form action="http://localhost/themePark/code/user_added.php" method="post" id="userform" >
                
                <b>Add a New User</b>
                <div class = "col1">
                    <p>First Name:
                        <input type="text" name="first_name" size="30" value="" />
                    </p>
            
                    <p>Last Name:
                        <input type="text" name="last_name" size="30" value="" />
                    </p>
                    
                    <p>Role:
                        <?php 

                            require_once('../db_connection.php');

                            $query = "SELECT * FROM Roles";
                            $response = @mysqli_query($dbc, $query);
                            if($response){
                                echo '<select name="role"  form="userform">';

                                while($row = mysqli_fetch_array($response)){
                                    echo '<option value="' . $row['idRoles'] . '">' .
                                    $row['name'];
                                    echo '</option>';
                                }

                                echo '</select>';
                            } else {
                                echo "Couldn't obtain role list";

                                echo mysqli_error($dbc);
                            }

                            mysqli_close($dbc);

                        ?>
                    </p>

                    <p>Email:
                        <input type="text" name="email" size="30" value="" />
                    </p>
            
                    <p>Street:
                        <input type="text" name="street" size="30" value="" />
                    </p>
            
                    <p>City:
                        <input type="text" name="city" size="30" value="" />
                    </p>
                </div>
                <div class = "col2">
                    <p>State (2 Characters):
                        <input type="text" name="state" size="2" maxlength="2" value="" />
                    </p>
            
                    <p>Zip Code:
                        <input type="text" name="zip" size="5" maxlength="5" value="" />
                    </p>

                    <p>Phone Number:
                        <input type="text" name="phone" size="12" value="" />
                    </p>

                    <p>Social Security Number:
                        <input type="text" name="ssn" size="9" value="" />
                    </p>
            
                    <p>Gender (M or F):
                        <input type="text" name="gender" size="1" maxlength="1" value="" />
                    </p>
            
                    <p>Password:
                        <input type="password" name="password" size="30" value="" />
                    </p>

                    <p>Date Employed (YYYY-MM-DD):
                        <input type="text" name="employed_date" size="10" value="" />
                    </p>
            
                    <p>
                        <input type="submit" name="submit" value="Submit" class="button"/>
                    </p>
                </div>
            </form>
        </div>
	</body>
</html>
