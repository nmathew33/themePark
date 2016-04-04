<?php 
session_start();

$id = $_SESSION['id'];

date_default_timezone_set('America/Chicago');
$date = date('Y-m-d H:i:s');

require_once('../db_connection.php');
                
$query = "INSERT INTO Clock_Times (user_id, clock_in, active_status) VALUES (?, ?,'Y')";

$stmt = mysqli_prepare($dbc, $query);

mysqli_stmt_bind_param($stmt, "is", $id, $date);

mysqli_stmt_execute($stmt);

$affected_rows = mysqli_stmt_affected_rows($stmt);
                
if($affected_rows == 1){
    
    echo '<center><h1>User Successfully Entered</h1></center>';
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