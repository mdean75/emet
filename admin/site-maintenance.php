<?php  //siteMaintenance.php
//Require_once "../../resources/functions.php";



$page_title = "Administration - Site Maintenance";
$page_title_short = "Site Maintenance";


?>

<!DOCTYPE html>
<html>
<head>
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>
<body>
<?php
require_once "../admin-header.php";
canary();
?>
  <div >
      <ol class="breadcrumb breadcrumb-nav">
        <li><a href="../admin-menu.php">Admin Home</a></li>
        <li class="active">Site Maintenance</a></li>
        <li class="navbar-right"><a href="/index.html">Home</a></li>
      </ol>
    </div>
  
</nav>
<div class="container">
	<div class="row row-grid">
		<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-3">
		  	<a href="siteMaintenance/create_tables.php" class="thumbnail">
				<img src="/images/icons/folder_info.png" alt="user maintenance image" ">
			</a>
			<div class="caption">
				<h3 class="text-center">Create Tables</h3>
			</div>
    </div>
    <div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-2">
        <a href="site-maintenance/manage-fields.php" class="thumbnail">
        <img src="/images/icons/folder_info.png" alt="user maintenance image" ">
      </a>
      <div class="caption">
        <h3 class="text-center">Manage List Fields</h3>
      </div>
		</div>
		
				
		
	
</div>
	
</body>
</html>
<script type="text/javascript" src="/js/mmenu.js"></script>