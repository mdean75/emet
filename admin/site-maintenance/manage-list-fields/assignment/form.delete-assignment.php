<?php //form.deleteAssignment.php

require_once "../../../../resources/dbcon.php";

if(isset($_POST["ID"]))  
 {  
      if($_POST["ID"] != '')  
      {  
           $sql = "SELECT * FROM users_assignment WHERE id = '".$_POST["ID"]."'";  
      }  
      else  
      {  
           $sql = "SELECT * FROM users_assignment";  
      }  

try {
		$aid = $_POST["ID"];
		$sql = "SELECT users_assignment.id, users_assignment.assignment FROM users_assignment WHERE id = :aid ";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':aid', $aid);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		$id = $result['id'];
		$assignment = $result['assignment'];
	}
	catch (PDOException $e) {
		echo "Something didn't work ".$e->getMessage();
	}

?>
<div class="container">
<form class="form-horizontal form" type="get" action="/resources/manage-list-action.php">
	  <div class="col-md-6 col-md-offset-0">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	

		<br>
			<div class="step">
				  <h4>Confirm: Delete This Assignment?</h4><br><br>
				  <div class="form-group">
				    <label for="assignment-id" class="col-sm-3 control-label">Assignmnt ID</label>
				    <div class="col-sm-9">
				      <input type="text" name="assignment-id" class="form-control" id="assignment-id" value=<?php echo $id; ?> readonly>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="assignment-name" class="col-sm-3 control-label">Assignment Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="assignment-name" class="form-control" id="assignment-name" value="<?php echo $assignment; ?>" >
				    </div>
				  </div>	

				  		    
				  
			</div>

			<div class="step display">
				<h4><strong>Warning: Submitting this form will permanently delete this assignment!</strong></h4>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Assignment Level ID</label>
				    <div class="col-sm-8">
				    	<label data-id="assignment-id"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Assignment Level Name</label>
				    <div class="col-sm-8">
				    	<label data-id="assignment-name"></label>
				    </div>
				  </div>
				  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<button type="submit" class="action btn-hot text-capitalize submit btn" name="submit" value="delete-assignment">Delete</button>
					
			      </div>
			  </div>
			</div>
		</div>
		
	  </div> 
	</form> 

	</div>
<?php } ?>

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
