<?php //form.edit-user.php
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
			, users_profile.carrierId, usersGroups.groupId   
				FROM users_auth 
				INNER JOIN users_profile on users_profile.userid = users_auth.userid 
				LEFT JOIN usersGroups on users_profile.userid = usersGroups.userId 
				WHERE users_profile.userid = :id";

		$db = new database;
		$db->query($sql);
		$db->bind(':id', $uid);
		$result = $db->resultset();

		foreach ($result as $row) {

			$id = $row['userid'];
			$uname = $row['username'];
			$email = $row['email'];
			$accesslvl = $row['accesslvl'];
			$fname = $row['fname'];
			$lname = $row['lname'];
			$assignment = $row['assignment'];
			$medic_num = $row['medic_num'];
			$phone = $row['phone'];
			$alt_phone = $row['alt_phone'];
			$carrier = $row['carrierId'];
			$usersGroups[] = $row['groupId'];
		}
		
	}
	catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}


?>



<div class="container">
	
<form class="form-horizontal form" method="POST" action="/resources/manage-user-action.php">
	  <div class="col-md-6 col-md-offset-0">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	
			<br>
			<div class="step">
				  <div class="form-group">
				    <label for="fname" class="col-sm-3 control-label">User ID</label>
				    <div class="col-sm-9">
				      <input type="text" name="userid" class="form-control" id="userid" placeholder="User ID" readonly value=<?php echo filter_var($id, FILTER_SANITIZE_NUMBER_INT); ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="fname" class="col-sm-3 control-label">First Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name" value=<?php echo filter_var($fname, FILTER_SANITIZE_STRING); ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="lname" class="col-sm-3 control-label">Last Name</label>
				    <div class="col-sm-9">
				      <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name" value=<?php echo filter_var($lname, FILTER_SANITIZE_STRING); ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="email" class="col-sm-3 control-label">Email</label>
				    <div class="col-sm-9">
				      <input type="text" name="email" class="form-control" id="email" placeholder="email" value=<?php echo filter_var($email, FILTER_SANITIZE_EMAIL); ?>  >
				    </div>
				  </div>			  
				  
			</div>
			<div class="step">
				  <div class="form-group">
				    <label for="username" class="col-sm-2 control-label">Username</label>
				    <div class="col-sm-10">
				      <input type="text" name="username" class="form-control" id="username" placeholder="Username" value=<?php echo filter_var($uname, FILTER_SANITIZE_STRING); ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="alevel" class="col-sm-2 control-label">Access Level</label>
				    <div class="col-sm-10">

				    	<?php 
    			$sql = "SELECT * FROM users_accesslvl ORDER BY accesslvl_value ASC";
    			$db->query($sql);
    			//$stmt = $conn->prepare($sql);
				$results = $db->resultset();
				//$stmt->execute();

				//$results = $stmt->fetchAll(PDO::FETCH_ASSOC); 
      			if ($db->rowcount() > 0) { ?>
	
  		<select class="form-control" name="alevel" id="alevel">
  			<option >Select Access Level</option>
    	  <?php foreach ($results as $row) { ?>
      		<option value="<?php echo filter_var($row['accesslvl_value'], FILTER_SANITIZE_NUMBER_INT); ?>" <?php if ($accesslvl == $row['accesslvl_value']) echo "selected='selected'" ?>"  ><?php echo filter_var($row['accesslvl_value'], FILTER_SANITIZE_NUMBER_INT)." ".filter_var($row['accesslvl_name'], FILTER_SANITIZE_STRING); ?></option>?>
     	  <?php }} ?>
			
		 	
		</select><br>


				
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="assignment" class="col-sm-2 control-label">Assignment</label>
				    <div class="col-sm-10">
				    	<?php 
    			$sql = "SELECT * FROM users_assignment ORDER BY assignment_name ASC";
    			//$stmt = $conn->prepare($sql);
				$db->query($sql);
				//$stmt->execute();


				$results = $db->resultset(); 
      			if ($db->rowcount() > 0) { ?>
	
  		<select class="form-control" name="assignment" id="assignment">
  			<option >Select Assignment</option>
    	  <?php foreach ($results as $row) { ?>
      		<option value="<?php echo filter_var($row['id'], FILTER_SANITIZE_NUMBER_INT); ?>" <?php if ($assignment == $row['id']) echo "selected='selected'" ?>"  ><?php echo filter_var($row['id'], FILTER_SANITIZE_NUMBER_INT)." ".filter_var($row['assignment_name'], FILTER_SANITIZE_STRING); ?></option>?>
     	  <?php }} ?>
			
		 	
		</select><br>



				   
				    </div>
				  </div>

				  		  	
			</div>
			

			<div class="step">
				<h3>Select Groups</h3>
				<div class="form-group">

				<?php 

				$groups = User::getAllGroups();

				foreach ($groups as $group) { ?>
					<div class="col-sm-8 col-sm-offset-1">
						<label>
					    <input type="checkbox" name="groups[]" value="<?php echo $group['groupId']; ?>" 
					    <?php 

					    if (in_array($group['groupId'], $usersGroups)) { 
					    	echo "checked = 'checked'";
					    } 

					    ?> >
					    <?php echo $group['groupName']; ?>
					  </label>

				    </div>

				<?php }	?>


					
				  </div>
			</div>

			<div class="step">
				<div class="form-group">
				    <label for="medic" class="col-sm-3 control-label">Medic Number</label>
				    <div class="col-sm-9">
				      <input type="text" name="medic" class="form-control" id="medic" placeholder="Enter Medic Number" value=<?php echo filter_var($medic_num, FILTER_SANITIZE_STRING); ?> >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="phone" class="col-sm-3 control-label">Phone Number</label>
				    <div class="col-sm-9">
				      <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number" value=<?php echo filter_var($phone, FILTER_SANITIZE_STRING); ?>  >
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="altphone" class="col-sm-3 control-label">Altername Phone</label>
				    <div class="col-sm-9">
				      <input type="text" name="altphone" class="form-control" id="altphone" placeholder="altphone" value=<?php echo filter_var($alt_phone, FILTER_SANITIZE_STRING); ?> >
				    </div>
				</div>

				    <div class="form-group">
					    <label for="assignment" class="col-sm-3 control-label">Carrier</label>
					    <div class="col-sm-9">
				    	<?php 
		    			$sql = "SELECT * FROM carrier ORDER BY carrierName ASC";
		    			//$stmt = $conn->prepare($sql);
						$db->query($sql);
						//$stmt->execute();


						$results = $db->resultset(); 
		      			if ($db->rowcount() > 0) { ?>
	
					  		<select class="form-control" name="carrier" id="carrier">
					  			<option value="0">Select Carrier</option>
					    	  <?php foreach ($results as $row) { if ($row['carrierId'] != 0) { ?>
					      		<option value="<?php echo filter_var($row['carrierId'], FILTER_SANITIZE_NUMBER_INT); ?>" <?php if ($carrier == $row['carrierId']) echo "selected='selected'" ?>"  ><?php echo filter_var($row['carrierId'], FILTER_SANITIZE_NUMBER_INT)." ".filter_var($row['carrierName'], FILTER_SANITIZE_STRING); ?></option>?>
					     	  <?php }}} ?>
								
							 	
							</select><br>



				   
				    	</div>
				  	</div>



				  	
				  <input type="hidden" name="test" value="?">		  
				  
			</div>
			<div class="step display">
				<h4>Confirm Details</h4>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">User ID</label>
				    <div class="col-sm-9">
				    	<label data-id="userid"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">First Name</label>
				    <div class="col-sm-9">
				    	<label data-id="fname"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Last Name</label>
				    <div class="col-sm-9">
				    	<label data-id="lname"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">Email</label>
				    <div class="col-sm-9">
				    	<label data-id="email"></label>
				    </div>
				  </div>

				  

				  <div class="form-group">
				    <label class="col-sm-3 control-label">Username</label>
				    <div class="col-sm-9">
				    	<label data-id="username"></label>
				    </div>


				  
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">Access Level</label>
				    <div class="col-sm-9">
				    	<label data-id="alevel"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Assignment</label>
				    <div class="col-sm-9">
				    	<label data-id="assignment"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Medic Number</label>
				    <div class="col-sm-9">
				    	<label data-id="medic"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Phone Number</label>
				    <div class="col-sm-9">
				    	<label data-id="phone"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Alternate Phone</label>
				    <div class="col-sm-9">
				    	<label data-id="altphone"></label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-sm-3 control-label">Carrier</label>
				    <div class="col-sm-9">
				    	<label data-id="carrier"></label>
				    </div>
				  </div>			  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<input type="submit" class="action btn-hot text-capitalize submit btn" name="submit" value="edit-user"></input>
			      </div>
			  </div>
			</div>			

		</div>
		</div><br><br><br>
	  </div> 
	</form> 
	</div>
<?php } 
?>
 
 <script type="text/javascript">
 	//form-widget.js 

/* This script will break the form into "steps" so a long form can 
   be created using a single page form but only small portion of 
   the form will be displayed at a time giving the effect of a 
   multiple page form.  It also will validate specified fields
   using jQuery form validation plugin.

   Credit to Amit Patil for the script 
   			http://www.amitpatil.me/multi-step-form-with-progress-bar-and-validation/

   And the jQuery Validation plugin
   			https://jqueryvalidation.org/

*/

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
				fname     	: "required",
				lname     	: "required",
				email    	: {required : true, email:true},
				username 	: "required",
				alevel 		: "required",
				assignment 	: "required",
				phone    	: {required : false, phoneUS:true},
				
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

<script type="text/javascript" src="/js/additional-methods.js"></script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>