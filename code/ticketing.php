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
        <form action="form_sent.php" method="post">
            <div id="adultList">
                <h3>Adults</h3>
                <ul>
                    <li>
                    <input name="first_name[]" type="text" placeholder="First Name" />
                    </li>
                    <li>
                    <input name="last_name[]" type="text" placeholder="Last Name" />
                    </li>
                    <li>
                    <input name="email[]" type="text" placeholder="E-Mail">
                    </li>
                    <li>
                    <input name="address[]" type="text" placeholder="Address">
                    </li>
                    <li>
                    <input name="phone[]" type="text" placeholder="Phone">
                    </li>
                </ul>
            </div>
            <button id="addAdult" onclick="addAdult()">Add Adult</button>
            
            <br>
            <br>
            <div id="childList">
                <h3>Children</h3>
                <ul>
                    <li>
                    <input name="child_first_name[]" type="text" placeholder="First Name" />
                    </li>
                    <li>
                    <input name="child_last_name[]" type="text" placeholder="Last Name" />
                    </li>
                    <li>
                    <input name="child_email[]" type="text" placeholder="E-Mail">
                    </li>
                    <li>
                    <input name="child_address[]" type="text" placeholder="Address">
                    </li>
                    <li>
                    <input name="child_phone[]" type="text" placeholder="Phone">
                    </li>
                </ul>
            </div>
            <button id="addChild" onclick="addChild()">Add Child</button>            
            
            <input type="submit">
        </form>
    </center>
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>