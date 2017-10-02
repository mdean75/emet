<?php //edit-assignment.php

// full title to display on larger screens
$page_title = "Administration - Edit Assignment Groups";
// shortened page title for mobile devices
$page_title_short = "Edit Assignments";

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
$sql = "SELECT * FROM users_assignment";

$db->query($sql);
$results = $db->resultset();	

?>

  <div >
    <ol class="breadcrumb breadcrumb-nav">
       <li><a href="/admin-menu.php">Admin Home</a></li>
      <li><a href="/admin/site-maintenance.php">Site Maintenance</a></li>
      <li><a href="/admin/site-maintenance/manage-fields.php">Manage List Fields</a></li>
      <li><a href="/admin/site-maintenance/manage-list-fields/list-edit-menu.php">Edit Fields</a></li>
      <li class="active">Edit Assignment</a></li>
    </ol>
  </div>
</nav>

<div class="container">
	<div class="col-md-6 col-md-offset-3">
	<?php 
		
      			if ($db->rowcount() > 0) { ?>
	
  		<select class="form-control input-lg" name="assignmentList" id="assignmentList">
  			<option value="">Select Assignment To Edit</option>
    	  <?php foreach ($results as $row) { ?>
      		<option value="<?php echo $row['id']; ?>"><?php echo $row['assignment_name']; ?></option>?>
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
      $('#assignmentList').change(function(){  
           var ID = $(this).val();  
           $.ajax({  
                url:"form.edit-assignment.php",  
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
				fname     : "required",
				lname     : "required",
				email    : {required : true, email:true},
				username : "required",
				alevel : "required",
				assignment : "required",
				
				rpassword: { required : true, equalTo: "#password"},
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