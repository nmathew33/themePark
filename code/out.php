<?php
session_start();

$clockId = $_SESSION['idClock_Times']; 

date_default_timezone_set('America/Chicago');
$date = date('Y-m-d H:i:s');

require_once('../db_connection.php');
                
$query = "UPDATE Clock_Times SET clock_out= ?, active_status = 'N' WHERE idClock_Times = ?";

$stmt = mysqli_prepare($dbc, $query);

mysqli_stmt_bind_param($stmt, "si", $date, $clockId);

mysqli_stmt_execute($stmt);

$affected_rows = mysqli_stmt_affected_rows($stmt);

if($affected_rows == 1){
    
    echo '<center><h1>User Successfully Entered</h1></center>';
    $_SESSION['active_status'] = 'N';
    mysqli_stmt_close($stmt);
    mysqli_close($dbc);
    header('Location: clockInOut.php');

} else {
    
    echo '<center><h1>Error Occurred</h1></center>';
    echo mysqli_error();
    
    mysqli_stmt_close($stmt);
    mysqli_close($dbc);
   
    
} 
?>