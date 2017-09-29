<?php //admin_assignment.add.php

$page_title = "Administration - Add New Assignment";
$page_title_short = "Add Assignment";

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
      <li><a href="/admin/site-maintenance/manage-list-fields/list-add-menu.php">Add Fields</a></li>
      <li class="active">Add Assignment</a></li>
      <li class="navbar-right"><a href="/index.html">Home</a></li>
    </ol>
  </div>
</nav>

<div class="container">
	
	<form class="form-horizontal form" type="get" action="/resources/manage-list-action.php">
	  <div class="col-md-6 col-md-offset-3">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	

		<br>
			<div class="step">
				  <div class="form-group">
				    <label for="new_assignment" class="col-sm-4 control-label">Enter New Assignment</label>
				    <div class="col-sm-8">
				      <input type="text" name="new_assignment" class="form-control" id="new_assignment" placeholder="Enter New Assignment">
				    </div>
				  </div>

				  
			</div>

			<div class="step display">
				<h4>Confirm Details</h4>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Assignment</label>
				    <div class="col-sm-9">
				    	<label data-id="new_assignment"></label>
				    </div>
				  </div>
				  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<button type="submit" name="submit" class="action btn-hot text-capitalize submit btn" value="submitNewAssignment">Submit</button>
			      </div>
			  </div>
			</div>
		</div>
		
	  </div> 
	</form> 
  </div>

</body>
</html>

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
				new_assignment    : "required",
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