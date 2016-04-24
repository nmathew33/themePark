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

        if(empty($_POST['ConcessionName'])){

            $data_missing[] = 'ConcessionName';

        } else {

            $concessionName = trim($_POST['ConcessionName']);

        }

        if(empty($_POST['customerID'])){

            $data_missing[] = 'customerID';

        } else{

            $customerID = trim($_POST['customerID']);

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
            
            if($card && $cash){
                require_once('../db_connection.php');
            
                $query = "INSERT INTO Concession_Sales (pricing, location, customer_id, user_id, date) VALUES (?, ?, ?, ?, ?);";

                $stmt = mysqli_prepare($dbc, $query);
                
                $tinput = floatval($total_value_input);
                
                $customerID = intval($customerID);
                
                $concessionName = intval($concessionName);
                                
                date_default_timezone_set('America/Chicago');
                $date = date('Y-m-d H:i:s');
                                
                mysqli_stmt_bind_param($stmt, "diiis", $tinput, $concessionName, $customerID, $id, $date);
                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
        
                $query = "SELECT idConcession_Sales FROM Concession_Sales WHERE date ='" . $date. "'";
                $response = @mysqli_query($dbc, $query);
                if($response){
                    $row = mysqli_fetch_array($response);
                    $sale_id = $row['idConcession_Sales'];
                    echo $sale_id;

                }
            
                $query = "INSERT INTO Transactions (sale_type, concession_sale_id) VALUES (3, $sale_id);";
                
                
                $stmt = mysqli_prepare($dbc, $query);
                                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
                
                $query = "SELECT idTransactions FROM Transactions WHERE concession_sale_id = $sale_id";
                $response = @mysqli_query($dbc, $query);
                if($response){
                    $row = mysqli_fetch_array($response);
                    $transaction_id = $row['idTransactions'];
                    echo $sale_id;

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
                    
                    echo '<center><h1>Sale Successfull</h1></center>';
                    
                    mysqli_stmt_close($stmt);
                    mysqli_close($dbc);
                    
                    
                } else {
                    
                    echo '<center><h1>Error Occurred</h1></center>';
                    echo mysqli_error($dbc);
                    
                    mysqli_stmt_close($stmt);
                    mysqli_close($dbc);
                    
                    
                }
            } elseif ($cash) {
                require_once('../db_connection.php');
            
                $query = "INSERT INTO Concession_Sales (pricing, location, customer_id, user_id, date) VALUES (?, ?, ?, ?, ?);";

                $stmt = mysqli_prepare($dbc, $query);
                
                $tinput = floatval($total_value_input);
                
                
                $customerID = intval($customerID);
                
                $concessionName = intval($concessionName);
                               
                date_default_timezone_set('America/Chicago');
                $date = date('Y-m-d H:i:s');
                                
                mysqli_stmt_bind_param($stmt, "diiis", $tinput, $concessionName, $customerID, $id, $date);
                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
     
                $query = "SELECT idConcession_Sales FROM Concession_Sales WHERE date ='" . $date. "'";
                $response = @mysqli_query($dbc, $query);
                if($response){
                   $row = mysqli_fetch_array($response);
                   $sale_id = $row['idConcession_Sales'];
                }
            
                $query = "INSERT INTO Transactions (sale_type, concession_sale_id) VALUES (1, $sale_id);";
                
                
                $stmt = mysqli_prepare($dbc, $query);
                                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
                
                $query = "SELECT idTransactions FROM Transactions WHERE concession_sale_id = $sale_id";
                $response = @mysqli_query($dbc, $query);
                if($response){
                   $row = mysqli_fetch_array($response);
                   $transaction_id = $row['idTransactions'];

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
                    mysqli_close($dbc);
                    
                    
                } else {
                    
                    echo '<center><h1>Error Occurred</h1></center>';
                    echo mysqli_error($dbc);
                    
                    mysqli_stmt_close($stmt);
                    mysqli_close($dbc);
                    
                    
                }
            } elseif ($card) {
                require_once('../db_connection.php');
            
                $query = "INSERT INTO Concession_Sales (pricing, location, customer_id, user_id, date) VALUES (?, ?, ?, ?, ?);";

                $stmt = mysqli_prepare($dbc, $query);
                
                $tinput = floatval($total_value_input);
                
                $customerID = intval($customerID);
                
                $concessionName = intval($concessionName);
                                
                date_default_timezone_set('America/Chicago');
                $date = date('Y-m-d H:i:s');
                                
                mysqli_stmt_bind_param($stmt, "diiis", $tinput, $concessionName, $customerID, $id, $date);
                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
        
                $query = "SELECT idConcession_Sales FROM Concession_Sales WHERE date ='" . $date. "'";
                $response = @mysqli_query($dbc, $query);
                if($response){
                    $row = mysqli_fetch_array($response);
                    $sale_id = $row['idConcession_Sales'];

                }
            
                $query = "INSERT INTO Transactions (sale_type, concession_sale_id) VALUES (2, $sale_id);";
                
                
                $stmt = mysqli_prepare($dbc, $query);
                                
                mysqli_stmt_execute($stmt);
                
                mysqli_stmt_close($stmt);
                
                $query = "SELECT idTransactions FROM Transactions WHERE concession_sale_id = $sale_id";
                $response = @mysqli_query($dbc, $query);
                if($response){
                    $row = mysqli_fetch_array($response);
                    $transaction_id = $row['idTransactions'];

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
                    mysqli_close($dbc);
                    
                    
                } else {
                    
                    echo '<center><h1>Error Occurred</h1></center>';
                    echo mysqli_error($dbc);
                    
                    mysqli_stmt_close($stmt);
                    mysqli_close($dbc);
                    
                    
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