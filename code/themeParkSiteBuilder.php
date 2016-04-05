<?php
class ThemeParkSiteBuilder{

	protected $title = '<div class = "header">UmaLand</div>';
	protected $subTitle = '<div class = "subheader">UmaLand<a href="logout.php" class="button">Sign Out</a></div>';

	public function getOpeningHtmlTags($title){
		echo '<html>
				<head>
					<title>' . $title . '</title>
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
		echo '<div>
            <table class = "menu">
                <tr>
                    <td><a href="clockInOut.php" class="buttonMenu">Clock In/Out</a></td>
                    <td><a href="scheduling.php" class="buttonMenu">Scheduling</a></td>
                    <td><a href="ticketing.php" class="buttonMenu">Ticketing</a></td>
                    <td><a href="concessions.php" class="buttonMenu">Concessions</a></td>
                    <td><a href="maintenance.php" class="buttonMenu">Maitenance</a></td>
                    <td><a href="managment.php" class="buttonMenu">Management</a></td>
                    <td><a href="admin.php" class="buttonMenu">Admin</a></td>
                </tr>
            </table>
        </div>
        <div class="contentBackDrop"></div>';
	}

	public function getOpenContentTags(){
		echo '<div class = "content">';
	}
	public function getCloseContentTags(){
		echo '</div>';
	}
	public function getClosinghtmlTags(){
		echo '</body>
		</html>';
	}



}
?>