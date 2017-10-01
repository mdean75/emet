<?php //user-maintenance.php 

// full title to display on larger screens
$page_title = "Administration - User/Profile Maintenance";
// shortened page title for mobile devices
$page_title_short = "User/Profile Maintenance";

$page_security = 7;

?>

<!DOCTYPE html>
<html>
<head>
	
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>
<body>
<?php

require_once ($_SERVER['DOCUMENT_ROOT']."/admin-header.php");

utility::restrict_page_access($page_security, '', 'index.php', 'status-code', '3X99');

?>
  	<div >
  		<ol class="breadcrumb breadcrumb-nav">
  			<li><a href="/admin-menu.php">Admin Home</a></li>
  			<li class="active">Admin User Maintenance</a></li>
  			
  			<li class="navbar-right"><a href="/index.html">Home</a></li>
  		</ol>
  	</div>
  
  
</nav>
<div class="container">
	<div class="row row-grid">
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-1">
		  	<a href="user/add-user.php" class="thumbnail">
				<img src="/images/icons/user_add.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">Add New User</h3>
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-2">
			<a href="user/edit-user.php" class="thumbnail">
				<img src="/images/icons/user_edit.png" alt="overtime tracking image">
			</a>
			<div class="caption">
				<h3 class="text-center">Edit/Update User</h3>
			</div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-2">
			<a href="user/delete-user.php" class="thumbnail">
				<img src="/images/icons/user_delete.png" alt="controlled substance image">
			</a>
			<div class="caption">
				<h3 class="text-center">Delete User</h3>
			</div>
		</div>
				
		
	</div>
</div>

<?php 
require_once ($_SERVER['DOCUMENT_ROOT']."/footer.html");
?>
	
</body>
</html>

