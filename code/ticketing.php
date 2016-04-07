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

$siteBuilder->getOpeningHtmlTags('Ticketing');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>

<div class = "content" >
    <center class="info">
        <h1>Ticketing</h1>    
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