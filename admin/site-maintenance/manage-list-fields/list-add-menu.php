<?php //user_maintenance.php 
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "Administration - Select Table To Add Fields";
// shortened page title for mobile devices
$page_title_short = "Select Table To Add Fields";

$page_security = 7;

utility::restrict_page_access($page_security, '', 'index.php', 'status-code', '3X99');
?>

<!DOCTYPE html>
<html>
<head>
  
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>
<body>
  
<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/admin-header.php');

?>

  <div >
    <ol class="breadcrumb breadcrumb-nav">
      <li><a href="/admin-menu.php">Admin Home</a></li>
      <li><a href="/admin/site-maintenance.php">Site Maintenance</a></li>
      <li><a href="/admin/site-Maintenance/manage-fields.php">Manage List Fields</a></li>
      <li class="active">Add Fields</a></li>
      <li class="navbar-right"><a href="/index.html">Home</a></li>
    </ol>
  </div>
  
</nav>
<div class="container">
	<div class="row row-grid">
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-3">
		  	<a href="/admin/site-maintenance/manage-list-fields/access/add-access.php" class="thumbnail">
				<img src="/images/icons/folder_info.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">Access Groups</h3>
			</div>
    </div>
    <div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-2">
        <a href="/admin/site-maintenance/manage-list-fields/assignment/add-assignment.php" class="thumbnail">
        <img src="/images/icons/folder_info.png" alt="user maintenance image" ">
      </a>
      <div class="caption">
        <h3 class="text-center">Assignments</h3>
      </div>
		</div>
		
				
		
	
</div>

<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>
	
</body>
</html>
