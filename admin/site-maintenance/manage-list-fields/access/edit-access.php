<?php //admin_access.add.php

require_once "../../../../resources/dbcon.php";

$page_title = "Administration - Add New Access Level";
$page_title_short = "Add Access Level";

$page_security = 7;
?>

<!DOCTYPE html>
<html>
<head>
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>
<body style="min-height: 100vh;">
<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/admin-header.php');
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
    			$sql = "SELECT * FROM users_accesslvl ORDER BY accesslvl_value ASC";
    			$stmt = $conn->prepare($sql);
		
				$stmt->execute();

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC); 
      			if ($stmt->rowCount() > 0) { ?>
	
  		<select class="form-control input-lg" name="accessList" id="accessList">
  			<option value="">Select Access To Edit</option>
    	  <?php foreach ($results as $row) { ?>
      		<option value="<?php echo $row['id']; ?>"><?php echo $row['accesslvl_name'] ?></option>?>
     	  <?php }} ?>
			
		 	
		</select><br>
	</div>

	<div class="col-md-6 col-md-offset-3">
		<div class="row" id="displayRecord">  
             
        </div>
    </div>
	
</div>


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

 
<script type="text/javascript">
	$(document).ready(function(){
		var current = 1;
		
		widget      = $(".step");
		btnnext     = $(".next");
		btnback     = $(".back"); 
		btnsubmit   = $(".submit");

		// Init buttons and UI
		widget.not(':eq(0)').hide();
		hideButtons(current);
		setProgress(current);

		// Next button click action
		btnnext.click(function(){
			if(current < widget.length){
				// Check validation
				if($(".form").valid()){
					widget.show();
					widget.not(':eq('+(current++)+')').hide();
					setProgress(current);
				}
			}
			hideButtons(current);
		})

		// Back button click action
		btnback.click(function(){
			if(current > 1){
				current = current - 2;
				if(current < widget.length){
					widget.show();
					widget.not(':eq('+(current++)+')').hide();
					setProgress(current);
				}
			}
			hideButtons(current);
		})

	    $('.form').validate({ // initialize plugin
			ignore:":not(:visible)",			
			rules: {
				accesslvl_name     : "required",
				accesslvl_value     : "required",
				
			},
	    });

	});

	// Change progress bar action
	setProgress = function(currstep){
		var percent = parseFloat(100 / widget.length) * currstep;
		percent = percent.toFixed();
		$(".progress-bar").css("width",percent+"%").html(percent+"%");		
	}

	// Hide buttons according to the current step
	hideButtons = function(current){
		var limit = parseInt(widget.length); 

		$(".action").hide();

		if(current < limit) btnnext.show();
		if(current > 1) btnback.show();
		if (current == limit) { 
			// Show entered values
			$(".display label:not(.control-label)").each(function(){
				console.log($(this).parent().find("label:not(.control-label)").html($("#" + $(this).data("id")).val()));	
			});
			btnnext.hide(); 
			btnsubmit.show();
		}
	}
</script>

<script type="text/javascript" src="/js/mmenu.js"></script>