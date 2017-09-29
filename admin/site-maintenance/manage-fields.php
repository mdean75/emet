<?php  //manageFields.php

$page_title = "Administration - Manage List Fields";
$page_title_short = "Manage List Fields";
?>

<!DOCTYPE html>
<html>
<head>

	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

    
	<title><?php echo $page_title; ?></title>

</head>
<body>
<?php

require_once('/../../admin-header.php');

?>
  <div>
    <ol class="breadcrumb breadcrumb-nav">
      <li><a href="/admin-menu.php">Admin Home</a></li>
      <li><a href="/admin/site-maintenance.php">Site Maintenance</a></li>
      <li class="active">Manage List Fields</a></li>
      <li class="navbar-right"><a href="/index.html">Home</a></li>
    </ol>
  </div>
  
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


	
</body>
</html>

<script type="text/javascript" src="/js/mmenu.js"></script>