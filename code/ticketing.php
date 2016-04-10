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
// $query = "INSERT INTO Users (idUsers, role_id, first_name, last_name, email,
// address, phone, ssn, gender, password, date_employed) VALUES ( ?, ?, ?, ?,
// ?, ?, ?, ?, ?, ?, ?)";
require("themeparkSiteBuilder.php");
$siteBuilder = new themeParkSiteBuilder();
$siteBuilder->getOpeningHtmlTags('Ticketing');
$siteBuilder->getGreyOverLay();
$siteBuilder->getSubTitle();
$siteBuilder->getMenu();
?>

<div class = "content" >
    <center class="info">
        <h1>Ticketing</h1>
        
        <?php if(isset($_POST['first_name'][0])){
            echo $_POST['first_name'][0];
        } ?>
        <form action="ticketing.php" method="post">
                <div class="col-50">
                    <h3>Adults</h3>
                    <div class='ticket_input'>
                        <div>
                            <input name="first_name[]" type="text" placeholder="First Name" />
                            <input name="last_name[]" type="text" placeholder="Last Name" />
                            <input name="email[]" type="text" placeholder="E-Mail">
                            <input name="address[]" type="text" placeholder="Address">
                            <input name="phone[]" type="text" placeholder="Phone">
                        </div>
                        <div id="adultList"></div>
                        <div id="addAdult" onclick="addAdult()"  class='ticket_input'>Add Adult</div>
                    </div>
                </div>

                <div class="col-50">
                    <h3>Children</h3>
                    <div class='ticket_input'>
                        <div id="childList"></div>
                        <div id="addChild" onclick="addChild()" class='ticket_input'>Add Child</div>                    
                    </div>
                </div>
            <input class='full-width-submit' type="submit">
        </form>
    </center>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>