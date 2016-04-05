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

<div class = "content" >
    <form action="user_added.php" method="post" id="userform" >
        
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


<?php
$siteBuilder->getClosinghtmlTags();
?>