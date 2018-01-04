<?php //overtime-menu.php

session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

// full title to display on larger screens
$page_title = "Overtime Main Menu";
// shortened page title for mobile devices
$page_title_short = "OT Main Menu";

$page_security = 1;

utility::checkForLogin($_SERVER['PHP_SELF']);

utility::restrict_page_access($page_security, '', 'home.php', 'status-code', '3X99');
?>

<!DOCTYPE html>
<html>
<head>
	
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>
<body>
<?php 

require_once ($_SERVER['DOCUMENT_ROOT'].'/page-header.php');



?>

</nav>

<div class="container">
	<div class="row row-grid">

		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-1">
		  	<a href="/ot/logovertime.php" class="thumbnail">
				<img src="/images/icons/application_add.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">Enter Overtime Worked</h3>
			</div>
		</div>

		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-2">
		  	<a href="/ot/reviewot.php" class="thumbnail">
				<img src="/images/icons/application_edit.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">Review/Edit Overtime</h3>
			</div>
		</div>

		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-2">
		  	<a href="/ot/overtime-report.php" class="thumbnail" target="_blank">
				<img src="/images/icons/page_info.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">View Overtime List</h3>
			</div>
		</div>

	</div>
	
	
</div>
</div> <!-- end myPage from header -->
<?php 
require_once ($_SERVER['DOCUMENT_ROOT']."/footer.html");
?>
</body>

</html>