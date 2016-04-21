<?php
session_start();

if(isset($_SESSION['id'])){
    $username = $_SESSION['username']; 
    $id = $_SESSION['id'];
    $roleId = $_SESSION['roleId'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];

    require_once("../db_connection.php");
    $query = "SELECT idClock_Times, active_status FROM Clock_Times Where user_id = '$id' AND clock_out IS NULL LIMIT 1";
    $response = @mysqli_query($dbc,$query);
} else{
    header("Location: index.php");
}

require("themeparkSiteBuilder.php");
$siteBuilder = new themeParkSiteBuilder();

$siteBuilder->getOpeningHtmlTags('Clock In/out');

$siteBuilder->getGreyOverLay();


$siteBuilder->getMenu();

?>
        
<div class = "content" >
    <?php
        date_default_timezone_set('America/Chicago');
        /*  Echo the Date
            h : 12 hr format
            H : 24 hr format
            i : minutes
            s : seconds
            u : Microseconds
            a : lowercase am or pm
            l : Full text for the day
            F : full text for the month 
            j : day of the month
            S : suffix for the day
            Y : 4 digit year    
        */
            
        echo '<center class="info"><h1>' . date('h:i:s a'). '</h1><p>' . date('l F jS, Y ') . 'CST</p>' . '</center>';
        if (mysqli_num_rows($response) == 0) { 
           echo '<center><a href="in.php" class="clockInButton">Clock In</a></center>';
        } else { 
            $row = mysqli_fetch_array($response);
            $_SESSION['idClock_Times'] = $row['idClock_Times'];
            $_SESSION['active_status'] = $row['active_status'];
           echo '<center><a href="out.php" class="clockOutButton">Clock Out</a></center>';
        }
        mysqli_close($dbc);  
    ?>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>
