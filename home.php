<?php //home.php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

// if there is no user session the user must login first, redirect to login page
if (empty($_SESSION)) {
	utility::redirect('', 'oop.login.php', 'status-code', '3X31');
}
// set page name variables to use in the header
// full title to display on larger screens
$page_title = "User Main";
// shortened page title for mobile devices
$page_title_short = "User Main";
// required minimum access level to view this page
$page_security = 1;

utility::restrict_page_access($page_security, '', 'index.php', 'status-code', '3X99');

if ($page_security != 0) {

  User::regenerate_session();
  // include mobile menu code from external file mmenu.php
  require_once ($_SERVER['DOCUMENT_ROOT'].'/mmenu.php');
}

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
  			<li class="active">Home</a></li>
  			<li class="navbar-right"><a href="index.html">Home</a></li>
  			
  		</ol>
  		
  	</div>
  
</nav>




<div class="container">
	<div class="row row-grid">

		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-0">
		  	<a href="/ot/overtime-menu.php" class="thumbnail">
				<img src="/images/icons/user_process.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">Overtime Tracking</h3>
			</div>
		</div>

		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-1">
			<a href="/manager-menu.php" class="thumbnail">
				<img src="/images/icons/application_process.png" alt="controlled substance image">
			</a>
			<div class="caption">
				<h3 class="text-center">Manager Menu</h3>
			</div>
		</div>

		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-1">
			<a href="home.php" class="thumbnail">
				<img src="/images/icons/database_process.png" alt="overtime tracking image">
			</a>
			<div class="caption">
				<h3 class="text-center">Controlled Substance</h3>
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-1">
			<a href="home.php" class="thumbnail">
				<img src="/images/icons/application_process.png" alt="controlled substance image">
			</a>
			<div class="caption">
				<h3 class="text-center">Edit Profile</h3>
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
