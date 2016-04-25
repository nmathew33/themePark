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
	if (isset($_POST['restore'])){
		require_once('../db_connection.php');

		$query = "UPDATE ". $_POST['tableName'] ." SET archive = 'no' WHERE id". $_POST['tableName'] . "=" . $_POST['restore'];

		    $stmt = mysqli_prepare($dbc, $query);

            mysqli_stmt_execute($stmt);

            $affected_rows = mysqli_stmt_affected_rows($stmt);

            if($affected_rows == 1){
                
                echo '<center><h1>User Successfully Restored</h1></center>';
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);

            } else {
                
                echo '<center><h1>Error Occurred</h1></center>';
                echo mysqli_error($dbc);
                
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
               
                
            } 
	}
	if (isset($_POST['delete'])){
		require_once('../db_connection.php');

		$query = "DELETE FROM ". $_POST['tableName'] ." WHERE id". $_POST['tableName'] . "=" . $_POST['delete'];

		    $stmt = mysqli_prepare($dbc, $query);

            mysqli_stmt_execute($stmt);

            $affected_rows = mysqli_stmt_affected_rows($stmt);

            if($affected_rows == 1){
                
                echo '<center><h1>User Successfully Deleted</h1></center>';
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);

            } else {
                
                echo '<center><h1>Error Occurred</h1></center>';
                echo mysqli_error($dbc);
                
                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
               
                
            } 
	}
?>

<?php
$siteBuilder->getClosinghtmlTags();
?>