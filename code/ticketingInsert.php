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
        
        
        if(empty($_POST['total_value_input'])){

            $data_missing[] = 'total_value_input';

        } else {

            $total_value_input = trim($_POST['total_value_input']);

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
            $card_amount = floatval(trim($_POST['card_amount']));
        } elseif ($cash) {
            $cash_payment = trim($_POST['cash']);
        } elseif ($card) {
            $card_number = trim($_POST['cnumber']);
            $cvv = trim($_POST['cvv']);
            $expireMM = trim($_POST['expireMM']);
            $expireYY = trim($_POST['expireYY']);
            $bank = trim($_POST['bank']);
            $card_amount = floatval(trim($_POST['card_amount']));
        } else {
             $data_missing[] = 'Payment Information';
        }
        
        if(empty($data_missing)){
            
            if($card && $cash){
                require_once('../db_connection.php');

                $query = "INSERT INTO Transactions (sale_type) VALUES (3);";
                
                $stmt = mysqli_prepare($dbc, $query);
                                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
                
                $query = "SELECT MAX(idTransactions) FROM Transactions;";
                $response = @mysqli_query($dbc, $query);
                if($response){
                    $row = mysqli_fetch_array($response);
                    $transaction_id = $row['MAX(idTransactions)'];
                }
                
                $query = "INSERT INTO Card_Payment (card_number, expiration, cvv, bank, transaction_id, amount) VALUES (?, ?, ?, ?, $transaction_id, $card_amount);";

                $stmt = mysqli_prepare($dbc, $query);

                $expiration = "$expireYY-$expireMM-01";
                
                mysqli_stmt_bind_param($stmt, "ssss", $card_number, $expiration, $cvv, $bank);
                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
                
                $query = "INSERT INTO Cash_Payment (amount, transaction_id) VALUES (?, $transaction_id);";

                $stmt = mysqli_prepare($dbc, $query);
                
                $cash_payment = floatval($cash_payment);
                                
                mysqli_stmt_bind_param($stmt, "d", $cash_payment);
                
                mysqli_stmt_execute($stmt);
                
                $affected_rows = mysqli_stmt_affected_rows($stmt);
                
                if($affected_rows == 1){
                    
                    echo '<center><h1>Sale Successful</h1></center>';
                    
                    mysqli_stmt_close($stmt);
                    
                } else {
                    
                    echo '<center><h1>Error Occurred</h1></center>';
                    echo mysqli_error($dbc);
                    
                    mysqli_stmt_close($stmt);

                }
            } elseif ($cash) {
                require_once('../db_connection.php');

                $query = "INSERT INTO Transactions (sale_type) VALUES (1);";
                
                $stmt = mysqli_prepare($dbc, $query);
                                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
                
                $query = "SELECT MAX(idTransactions) FROM Transactions;";
                $response = @mysqli_query($dbc, $query);
                if($response){
                    $row = mysqli_fetch_array($response);
                    $transaction_id = $row['MAX(idTransactions)'];

                }
                
                $query = "INSERT INTO Cash_Payment (amount, transaction_id) VALUES (?, $transaction_id);";

                $stmt = mysqli_prepare($dbc, $query);
                
                $cash_payment = floatval($cash_payment);
                                
                mysqli_stmt_bind_param($stmt, "d", $cash_payment);
                
                mysqli_stmt_execute($stmt);
                
                $affected_rows = mysqli_stmt_affected_rows($stmt);
                
                if($affected_rows == 1){
                    
                    echo '<center><h1>Sale Successfull</h1></center>';
                    
                    mysqli_stmt_close($stmt);
                    
                } else {
                    
                    echo '<center><h1>Error Occurred</h1></center>';
                    echo mysqli_error($dbc);
                    
                    mysqli_stmt_close($stmt);        
                }
            } elseif ($card) {
                require_once('../db_connection.php');

                $query = "INSERT INTO Transactions (sale_type) VALUES (2);";
                
                $stmt = mysqli_prepare($dbc, $query);
                                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
                
                $query = "SELECT MAX(idTransactions) FROM Transactions;";
                $response = @mysqli_query($dbc, $query);
                if($response){
                    $row = mysqli_fetch_array($response);
                    $transaction_id = $row['MAX(idTransactions)'];

                }
                
                $query = "INSERT INTO Card_Payment (card_number, expiration, cvv, bank, transaction_id, amount) VALUES (?, ?, ?, ?, $transaction_id, $card_amount);";

                $stmt = mysqli_prepare($dbc, $query);

                $expiration = "$expireYY-$expireMM-01";
                                
                mysqli_stmt_bind_param($stmt, "ssss", $card_number, $expiration, $cvv, $bank);
                
                mysqli_stmt_execute($stmt);
                
                $affected_rows = mysqli_stmt_affected_rows($stmt);
                
                if($affected_rows == 1){
                    
                    echo '<center><h1>Sale Successfull</h1></center>';
                    
                    mysqli_stmt_close($stmt);
                    
                } else {
                    
                    echo '<center><h1>Error Occurred</h1></center>';
                    echo mysqli_error($dbc);
                    
                    mysqli_stmt_close($stmt);        
                }
            }
            
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
                    }
                    
                date_default_timezone_set('America/Chicago');
                $date = date('Y-m-d H:i:s');
                    
               $query = "INSERT INTO Ticket_Sales (customer_id, pricing, date, user_id, transaction_id) VALUES ($coustomer_id, ". $_POST['adult_price'] . ", '$date', $id,  $transaction_id);";

               
                $stmt = mysqli_prepare($dbc, $query);
                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
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
                    }
                    
                    date_default_timezone_set('America/Chicago');
                    $date = date('Y-m-d H:i:s');
                    
                    $query = "INSERT INTO Ticket_Sales (customer_id, pricing, date, user_id, transaction_id) VALUES ($coustomer_id," . $_POST['child_price']. ", '$date', $id,  $transaction_id);";

                    $stmt = mysqli_prepare($dbc, $query);
                    
                    mysqli_stmt_execute($stmt);
                    
                    mysqli_stmt_close($stmt);
                }
            }
            
            
            mysqli_close($dbc);
            
        } else {
            
            echo '<center><h1>You need to enter the following data</h1>';
            
            foreach($data_missing as $missing){
                
                echo "$missing<br />";
                
            }
            
            echo '</center>';
            
        }
    }
    
?>

<a href="ticketing.php" class="button">New Sale</a>

<?php
$siteBuilder->getClosinghtmlTags();
?>