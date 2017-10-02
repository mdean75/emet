<?php //admin_access.add.php

// full title to display on larger screens
$page_title = "Administration - Add New Access Level";
// shortened page title for mobile devices
$page_title_short = "Add Access Level";

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

$db = new database;

$sql = "SELECT * FROM users_accesslvl ORDER BY accesslvl_value ASC";

$db->query($sql);
$results = $db->resultset();

?>

  <div >
    <ol class="breadcrumb breadcrumb-nav">
      <li><a href="/admin-menu.php">Admin Home</a></li>
      <li><a href="/admin/site-maintenance.php">Site Maintenance</a></li>
      <li><a href="/admin/site-maintenance/manage-fields.php">Manage List Fields</a></li>
      <li><a href="/admin/site-maintenance/manage-list-fields/list-edit-menu.php">Edit Fields</a></li>
      <li class="active">Edit Access Level</a></li>
    </ol>
  </div>
</nav>

<div class="container" style="margin-bottom: 15px;">
	<div class="col-md-6 col-md-offset-3">
	<?php 
    			
      			if ($db->rowcount() > 0) { ?>
	
  		<select class="form-control input-lg" name="accessList" id="accessList">
  			<option value="">Select Access To Edit</option>
    	  <?php foreach ($results as $row) { ?>
      		<option value="<?php echo $row['id']; ?>"><?php echo $row['accesslvl_name']." - Level: ".$row['accesslvl_value']; ?></option>?>
     	  <?php }} ?>
			
		</select><br>
	</div>

	<div class="col-md-6 col-md-offset-3">
		<div class="row" id="displayRecord">  
             
        </div>
    </div>
	
</div>

<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>

</body>
</html>

<script>  
 $(document).ready(function(){  
      $('#accessList').change(function(){  
           var ID = $(this).val();  
           $.ajax({  
                url:"form.editAccess.php",  
                method:"POST",  
                data:{ID:ID},  
                success:function(data){  
                     $('#displayRecord').html(data);  
                }  
           });  
      });  
 });  
 </script> 
