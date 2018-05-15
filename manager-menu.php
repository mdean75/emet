<?php //overtime-menu.php

session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "Manager Menu";
// shortened page title for mobile devices
$page_title_short = "Manager Menu";

$page_security = 5;

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

	<?php
  if (isset($_SESSION['error'])) { ?>
  <br>
      
  <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
    <h2><?php echo $_SESSION['error']; ?> </h2>
  </div>
  <br>
  <div class="col-sm-6 col-sm-offset-4">
  <h3>Click to return to home page<a href="/home.php"><button class="btn btn-danger">Home</button></a></h3>
</div>

  <?php }else{ 

?>
	<div class="row row-grid">

		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-1">
		  	<a href="/manager/shift-report-48.php" class="thumbnail">
				<img src="/images/icons/application_add.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">Shift Report 48</h3>
			</div>
		</div>

		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-2">
		  	<a href="/manager/shift-report-24.php" class="thumbnail">
				<img src="/images/icons/application_edit.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">Shift Report 24</h3>
			</div>
		</div>

		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-2">
		  	<a href="/manager/files.php" class="thumbnail">
				<img src="/images/icons/page_info.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">View Shift Log</h3>
			</div>
		</div>

	</div>
	
	
</div>
</div> <!-- end myPage from header -->
<?php }
require_once ($_SERVER['DOCUMENT_ROOT']."/footer.html");
?>
</body>

</html>