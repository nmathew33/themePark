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

<?php

    if(isset($_POST['submit'])){
        $data_missing = array();
        
        if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address'])){
            $fname = $_POST['first_name'];
            $lname = $_POST['last_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            
            $numOfAdults = sizeof($fname);
                       
            if(!($numOfAdults == sizeof($lname)) || !($numOfAdults == sizeof($email)) || !($numOfAdults == sizeof($phone)) || !($numOfAdults == sizeof($address))){
                $data_missing[] = 'Adult information is not complete';

            }
            for($i = 0; $i < $numOfAdults;$i++)
            {
                $fname[$i] = trim($fname[$i]);
                $lname[$i] = trim($lname[$i]);
                $email[$i] = trim($email[$i]);
                $phone[$i] = trim($phone[$i]);
                $address[$i] = trim($address[$i]);
            }
        } else{
            $data_missing[] = 'Adult information is not complete';
        }
        
        
        if(isset($_POST['child_first_name']) && isset($_POST['child_last_name']) && isset($_POST['child_email']) && isset($_POST['child_phone']) && isset($_POST['child_address'])){
            $child_fname = $_POST['child_first_name'];
            $child_lname = $_POST['child_last_name'];
            $child_email = $_POST['child_email'];
            $child_phone = $_POST['child_phone'];
            $child_address = $_POST['child_address'];
            
            $numOfChildren = sizeof($child_fname);
 
            if(!($numOfChildren == sizeof($child_lname)) || !($numOfChildren == sizeof($child_email)) || !($numOfChildren == sizeof($child_phone)) || !($numOfChildren == sizeof($child_address))){
                $data_missing[] = 'Children information is not complete';

            }
            
            for($i = 0; $i < $numOfChildren;$i++)
            {
                $child_fname[$i] = trim($child_fname[$i]);
                $child_lname[$i] = trim($child_lname[$i]);
                $child_email[$i] = trim($child_email[$i]);
                $child_phone[$i] = trim($child_phone[$i]);
                $child_address[$i] = trim($child_address[$i]);
            }
        }
        
        
        $card = (!empty($_POST['cnumber']) && !empty($_POST['cvv']) && !empty($_POST['expireMM']) && !empty($_POST['expireYY']));
        $cash = !empty($_POST['cash']);
        
        if($card && $cash){
            $card_number = trim($_POST['cnumber']);
            $cvv = trim($_POST['cvv']);
            $expireMM = trim($_POST['expireMM']);
            $expireYY = trim($_POST['expireYY']);
            $bank = trim($_POST['bank']);
            
            $cash_payment = trim($_POST['cash']);
            $card_amount = floatval($total_value_input) - floatval($cash_payment);
        } elseif ($cash) {
            $cash_payment = trim($_POST['cash']);
        } elseif ($card) {
            $card_number = trim($_POST['cnumber']);
            $cvv = trim($_POST['cvv']);
            $expireMM = trim($_POST['expireMM']);
            $expireYY = trim($_POST['expireYY']);
            $bank = trim($_POST['bank']);
            $card_amount = floatval($total_value_input);
        } else {
             $data_missing[] = 'Payment Information';
        }
        
        if(empty($data_missing)){
            
            require_once('../db_connection.php');
            
            for($i = 0; $i < $numOfAdults;$i++)
            {
                $query = "INSERT INTO Customers (first_name, last_name, email, address, phone) VALUES (?, ?, ?, ?, ?);";

                $stmt = mysqli_prepare($dbc, $query);
                                
                mysqli_stmt_bind_param($stmt, "sssss", $fname[$i], $lname[$i], $email[$i], $address[$i], $phone[$i]);
                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
                
                $query = "SELECT idCustomers FROM Customers WHERE first_name = '$fname[$i]' AND last_name = '$lname[$i]' AND email = '$email[$i]' AND address = '$address[$i]' AND phone = '$phone[$i]'";
                    $response = @mysqli_query($dbc, $query);
                    if($response){
                        $row = mysqli_fetch_array($response);
                        $coustomer_id = $row['idCustomers'];
                        echo $coustomer_id;
                    }
            }
            
            if(isset($_POST['child_first_name']) ){
                for($i = 0; $i < $numOfChildren;$i++)
                {
                $query = "INSERT INTO Customers (first_name, last_name, email, address, phone) VALUES (?, ?, ?, ?, ?);";

                    $stmt = mysqli_prepare($dbc, $query);
                                    
                    mysqli_stmt_bind_param($stmt, "sssss", $child_fname[$i], $child_lname[$i], $child_email[$i], $child_address[$i], $child_phone[$i]);
                    
                    mysqli_stmt_execute($stmt);
                    
                    mysqli_stmt_close($stmt);
                    
                    $query = "SELECT idCustomers FROM Customers WHERE first_name = '$child_fname[$i]' AND last_name = '$child_lname[$i]' AND email = '$child_email[$i]' AND address = '$child_address[$i]' AND phone = '$child_phone[$i]'";
                    $response = @mysqli_query($dbc, $query);
                    if($response){
                        $row = mysqli_fetch_array($response);
                        $coustomer_id = $row['idCustomers'];
                        echo $coustomer_id;
                    }
                }
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

<a href="concessions.php" class="button">New Sale</a>

<?php
$siteBuilder->getClosinghtmlTags();
?>