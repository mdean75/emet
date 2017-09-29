<?php //form.delete-user.php
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

if(isset($_POST["ID"]))  
 {  
      if($_POST["ID"] != '')  
      {  
           $sql = "SELECT * FROM users_auth WHERE userid = '".$_POST["ID"]."'";  
      }  
      else  
      {  
           $sql = "SELECT * FROM users_auth";  
      }  

try {
		$uid = $_POST["ID"];
		$sql = "SELECT users_auth.userid, users_auth.email, users_auth.username, users_auth.accesslvl, users_profile.fname, users_profile.lname, users_profile.assignment, users_profile.medic_num, users_profile.phone, users_profile.alt_phone 
				FROM users_auth 
				INNER JOIN users_profile on users_profile.userid = users_auth.userid 
				WHERE users_profile.userid = :id";

		$db = new database;
		$db->query($sql);
		$db->bind(':id', $uid);
		$result = $db->resultset();

		foreach ($result as $row) {
			
		
			$id = $row['userid'];
			$uname = $row['username'];
			$fname = $row['fname'];
			$lname = $row['lname'];
		}
		
	}
	catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

?>

	<div class="container">
		<form class="form-horizontal form" method="POST" action="/resources/manage-user-action.php" >
	  <div class="col-md-6 col-md-offset-0">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	

		<br>
			
			
			<div class="step">
				  <h4>Confirm: Delete This User?</h4><br>
				  <div class="form-group">
				    <label for="userid" class="col-sm-3 control-label">User ID</label>
				    <div class="col-sm-9">
				      <input type="text" name="userid" class="form-control" id="userid" value=<?php echo filter_var($id, FILTER_SANITIZE_NUMBER_INT); ?> readonly>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="email" class="col-sm-3 control-label">User Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="username" class="form-control" id="username" value=<?php echo filter_var($uname, FILTER_SANITIZE_STRING); ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="fname" class="col-sm-3 control-label">First Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="fname" class="form-control" id="fname" value=<?php echo filter_var($fname, FILTER_SANITIZE_STRING); ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="lname" class="col-sm-3 control-label">Last Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="lname" class="form-control" id="lname" value=<?php echo filter_var($lname, FILTER_SANITIZE_STRING); ?> >
				    </div>
				  </div>

				  			  
			</div>

			<div class="step display">
				<h4><strong>Warning: Submitting this form will permanently delete this User!</strong></h4>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">User ID</label>
				    <div class="col-sm-8">
				    	<label data-id="userid"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">User Name</label>
				    <div class="col-sm-8">
				    	<label data-id="username"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">First Name</label>
				    <div class="col-sm-8">
				    	<label data-id="fname"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-4 control-label">Last Name</label>
				    <div class="col-sm-8">
				    	<label data-id="lname"></label>
				    </div>
				  </div>
				  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<button type="submit" class="action btn-hot text-capitalize submit btn" name="submit" value="delete-user">Delete</button>
					
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
