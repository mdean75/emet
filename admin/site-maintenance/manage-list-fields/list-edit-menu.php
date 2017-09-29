<?php //user_maintenance.php 

$page_title = "Administration - Select Table To Edit List Fields";
$page_title_short = "Edit List Fields";

$page_security = 7;
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
      <li><a href="/admin/site-maintenance/manage-fields.php">Manage List Fields</a></li>
      <li class="active">Edit Fields</a></li>
       <li class="navbar-right"><a href="/index.html">Home</a></li>
    </ol>
  </div>
</nav>
<div class="container">
	<div class="row row-grid">
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-3">
		  	<a href="access/edit-access.php" class="thumbnail">
				<img src="/images/icons/folder_info.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">Access Groups</h3>
			</div>
    </div>
    <div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-2">
        <a href="assignment/edit-assignment.php" class="thumbnail">
        <img src="/images/icons/folder_info.png" alt="user maintenance image" ">
      </a>
      <div class="caption">
        <h3 class="text-center">Assignments</h3>
      </div>
		</div>
		
				
		
	
</div>


	
</body>
</html>

<script type="text/javascript" src="/js/mmenu.js"></script>