<?php

class ThemeParkSiteBuilder{

	protected $title = '<div class = "header">Four O Four Land</div>';
	protected $subTitle = '<div class = "subheader">Four O Four Land<a href="logout.php" class="button">Sign Out</a></div>';

	public function getOpeningHtmlTags($title){
		echo '<html>
				<head>
					<title>' . $title . '</title>
        			<link rel="stylesheet" type="text/css" href="style.css">
				</head>
			<body>';
	}

    public function getOpenHtmlTags(){
		echo '<html>
				<head>
					<title>' . 'Four o Four Land'  . '</title>
        			<link rel="stylesheet" type="text/css" href="style.css">
				</head>
			<body>';
	}

	public function getGreyOverLay(){
		echo '<div class="overlay"></div>';
	}

	public function getTitle(){
		echo $this->title;
	}

	public function getSubTitle(){
		echo $this->subTitle;
	}

	public function getMenu(){

		echo '<div class = "subheader">&nbsp<a href="logout.php" class="button">Sign Out</a></div>';
		
		if ($_SESSION['roleId'] == '1'){
		echo '

			<div class="left-bar">
				<div class="logo">
					Four o Four land
				</div>
				<a href="clockInOut.php"><div class="menu-item">Clock In/Out</div></a>
				<a href="rideUsage.php"><div class="menu-item">Ride Usage</div></a>
				<a href="scheduling.php"><div class="menu-item">Scheduling</div></a>
				<a href="ticketing.php"><div class="menu-item">Ticketing</div></a>
				<a href="concessions.php"><div class="menu-item">Concessions</div></a>
				<a href="maintenance.php"><div class="menu-item">Maintenance</div></a>
				<a href="managment.php"><div class="menu-item">Management</div></a>
				<a href="admin.php"><div class="menu-item">Admin</div></a>
			</div>
			<div class = "content">
				<div class="content-inner">
				';
			} else if ($_SESSION['roleId'] == '2'){
			echo '

			<div class="left-bar">
				<div class="logo">
					Four o Four land
				</div>
				<a href="clockInOut.php"><div class="menu-item">Clock In/Out</div></a>
				<a href="rideUsage.php"><div class="menu-item">Ride Usage</div></a>
				<a href="scheduling.php"><div class="menu-item">Scheduling</div></a>
				<a href="ticketing.php"><div class="menu-item">Ticketing</div></a>
				<a href="concessions.php"><div class="menu-item">Concessions</div></a>
				<a href="maintenance.php"><div class="menu-item">Maintenance</div></a>
				<a href="managment.php"><div class="menu-item">Management</div></a>

			</div>
			<div class = "content">
				<div class="content-inner">
				';				
			} else if ($_SESSION['roleId'] == '3'){
			echo '
			<div class="left-bar">
				<div class="logo">
					Four o Four land
				</div>
				<a href="clockInOut.php"><div class="menu-item">Clock In/Out</div></a>
				<a href="scheduling.php"><div class="menu-item">Scheduling</div></a>
				<a href="maintenance.php"><div class="menu-item">Maintenance</div></a>				
			</div>
			<div class = "content">
				<div class="content-inner">
				';				
			} else if ($_SESSION['roleId'] == '4'){
			echo '
			<div class="left-bar">
				<div class="logo">
					Four o Four land
				</div>
				<a href="clockInOut.php"><div class="menu-item">Clock In/Out</div></a>
				<a href="scheduling.php"><div class="menu-item">Scheduling</div></a>
				<a href="ticketing.php"><div class="menu-item">Ticketing</div></a>
			</div>
			<div class = "content">
				<div class="content-inner">
				';				
			} else if ($_SESSION['roleId'] == '5'){
			echo '
			<div class="left-bar">
				<div class="logo">
					Four o Four land
				</div>
				<a href="clockInOut.php"><div class="menu-item">Clock In/Out</div></a>
				<a href="scheduling.php"><div class="menu-item">Scheduling</div></a>
				<a href="concessions.php"><div class="menu-item">Concessions</div></a>
			</div>
			<div class = "content">
				<div class="content-inner">
				';				
			} else if ($_SESSION['roleId'] == '6'){
			echo '
			<div class="left-bar">
				<div class="logo">
					Four o Four land
				</div>
				<a href="clockInOut.php"><div class="menu-item">Clock In/Out</div></a>
				<a href="rideUsage.php"><div class="menu-item">Ride Usage</div></a>
				<a href="scheduling.php"><div class="menu-item">Scheduling</div></a>
			</div>
			<div class = "content">
				<div class="content-inner">
				';				
			} else if ($_SESSION['roleId'] == '7'){
			echo '
			<div class="left-bar">
				<div class="logo">
					Four o Four land
				</div>
				<a href="clockInOut.php"><div class="menu-item">Clock In/Out</div></a>
				<a href="rideUsage.php"><div class="menu-item">Ride Usage</div></a>
				<a href="scheduling.php"><div class="menu-item">Scheduling</div></a>
				<a href="ticketing.php"><div class="menu-item">Ticketing</div></a>
				<a href="concessions.php"><div class="menu-item">Concessions</div></a>
			</div>
			<div class = "content">
				<div class="content-inner">
				';				
			}

	}

	public function getClosinghtmlTags(){
			echo '
				</div>
			</div>
					</div>
                <script src="script.js" ></script>
            </body>
		</html>';
	}



}
?>
