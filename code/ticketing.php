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
<<<<<<< HEAD
        <h1>Ticketing</h1>    
=======
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
>>>>>>> refs/remotes/tahmidMahmud/master
    </center>
	
	<div class = "count">
		<h2>Log In</h2>
			<form action="ticketing.php" method="post"> 
				<div class = "num_adults">
					<h3>Number of Adults</h3>
					<input type="number" name="adults" min=1>
				</div>
				<div class = "num_children">
					<h3>Number of Children (Under "48)</h3> 
					<input type="number" name="children" min=0>
				</div>
				<div class = "num_infants">
					<h3>Number of Infants (Under 2 years)</h3> 
					<input type="number" name="infants" min=0>
				</div>
			    <input type="submit" name="submit" value="Continue" class ="button"> 
			</form>	
	</div>
</div>

<?php
$adults = $_POST['adults'];
$children = $_POST['children'];
$infants = $_POST['infants'];

$siteBuilder->getClosinghtmlTags();
?>