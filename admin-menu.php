<?php //admin-menu.php 
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

// full title to display on larger screens
$page_title = "Administration Main Menu";
// shortened page title for mobile devices
$page_title_short = "Admin Main Menu";

$page_security = 7;

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

  <div >
  		<ol class="breadcrumb breadcrumb-nav">
  			<li class="active">Admin Home</a></li>
  			<li class="navbar-right"><a href="index.html">Home</a></li>
  			
  		</ol>
  		
  	</div>
  
</nav>




<div class="container">
	<div class="row row-grid">

		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-0">
		  	<a href="/admin/user-maintenance.php" class="thumbnail">
				<img src="/images/icons/user_process.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">User Maintenance</h3>
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-1">
			<a href="/home.php" class="thumbnail">
				<img src="/images/icons/database_process.png" alt="overtime tracking image">
			</a>
			<div class="caption">
				<h3 class="text-center">Overtime Maintenance</h3>
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-1">
			<a href="/home.php" class="img-thumbnail">
				<img src="/images/icons/application_process.png" alt="controlled substance image">
			</a>
			<div class="caption">
				<h3 class="text-center">Controlled Substance Maintenance</h3>
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-1">
			<a href="/admin/site-maintenance.php" class="thumbnail">
				<img src="/images/icons/world_process.png" alt="site setup image">
			</a>
			<div class="caption">
				<h3 class="text-center">Site Setup</h3>
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
 

