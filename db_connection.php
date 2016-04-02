<?php 

DEFINE ('DB_USER', 'Umaland16');
DEFINE ('DB_PASSWORD', 'hotcheetos16');
DEFINE ('DB_HOST', 'dbumaland.cgjodcjloglm.us-west-1.rds.amazonaws.com:3306');
DEFINE ('DB_NAME', 'UmaLand');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die('Could not connect to MYSQL ' . mysqli_connect_error());

?>