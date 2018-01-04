<?php  //manage-fields.php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "Administration - Manage List Fields";
// shortened page title for mobile devices
$page_title_short = "Manage List Fields";

$page_security = 7;

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

require_once($_SERVER['DOCUMENT_ROOT']."/page-header.php");

?>
   
</nav>
<div class="container">
	<div class="row row-grid">
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-2">
		  	<a href="/admin/site-maintenance/manage-list-fields/list-add-menu.php" class="thumbnail">
				<img src="/images/icons/database_add.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">Add Fields</h3>
			</div>
    </div>
    <div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-1">
        <a href="/admin/site-maintenance/manage-list-fields/list-edit-menu.php" class="thumbnail">
        <img src="/images/icons/database_edit.png" alt="user maintenance image" ">
      </a>
      <div class="caption">
        <h3 class="text-center">Edit Fields</h3>
      </div>
		</div>
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-1">
        <a href="/admin/site-maintenance/manage-list-fields/list-delete-menu.php" class="thumbnail">
        <img src="/images/icons/database_remove.png" alt="user maintenance image" ">
      </a>
      <div class="caption">
        <h3 class="text-center">Delete Fields</h3>
      </div>
    </div>
				
		
	
</div>

<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>
	
</body>
</html>

