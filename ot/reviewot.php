<?php //reviewot.php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "Overtime Tracking - ReviewOvertime Record";
// shortened page title for mobile devices
$page_title_short = "Review Overtime Record";

$page_security = 1;

utility::checkForLogin($_SERVER['PHP_SELF']);

utility::restrict_page_access($page_security, '', 'home.php', 'status-code', '3X99');

$db = new database;

/* ------------------------------------------------------------
	Code to process edit overtime record follows
   ------------------------------------------------------------
*/
   $show_edit_modal = false;
   $show_delete_modal = false;

if (isset($_POST['submit-edit'])) {
	
	// set posted variables
	$post_record_id = $_POST['record_id'];
	$post_emplid = $_POST['emplid'];
	$post_fname = $_POST['fname'];
	$post_lname = $_POST['lname'];
	$post_date_worked = $_POST['date_worked'];
	$post_hours_worked = $_POST['hours_worked'];
	$post_shift_worked = $_POST['shift_worked'];
	$post_overtime_type = $_POST['overtime_type'];
	$post_notes = $_POST['notes'];

	$updatedby = $_SESSION['username'];
	date_default_timezone_set('America/Chicago');
	$updatedtime = date('Y-m-d H:i:s');
	
	$sql = "UPDATE ots_tbllogovertimeworked SET DateWorkedOT = :dateworked, ShiftWorkedOT = :shiftworked, HoursWorked = :hoursworked, OvertimeType = :overtimetype, notes = :notes, UpdatedBy = :updatedby, UpdatedTimestamp = :updatedtime WHERE ID = :record_id";


	$db->query($sql);

	$db->bind('dateworked', $post_date_worked);
	$db->bind('shiftworked', $post_shift_worked);
	$db->bind('hoursworked', $post_hours_worked);
	$db->bind('overtimetype', $post_overtime_type);
	$db->bind('notes', $post_notes);
	$db->bind('record_id', $post_record_id);
	$db->bind('updatedtime', $updatedtime);
	$db->bind('updatedby', $updatedby);

	$db->execute();

	$sql = "SELECT Empl_ID, MAX(DateWorkedOT) AS MaxOfDateWorked, MAX(ShiftWorkedOT) AS MaxOfShiftWorked FROM ots_tbllogovertimeworked GROUP BY Empl_ID";

	// query to select 3 most recent shifts worked

	//$query = "SELECT * FROM ots_tbllogovertimeworked WHERE Empl_ID = :empl_id ORDER BY DateWorkedOT DESC, ShiftWorkedOT DESC LIMIT 3";

	//$db->query($query);
	//$db->bind(':empl_id', $)


	$db->query($sql);
	$results = $db->resultset();

	foreach ($results as $row) {
		$employee = $row['Empl_ID'];
		$maxdate = $row['MaxOfDateWorked'];
		$maxshift = $row['MaxOfShiftWorked'];

		$sql = "UPDATE users_profile SET DateLastWorkedOT = :datelastworked, ShiftLastWorked = :shiftlastworked WHERE userid = :userid";

		$db->query($sql);
		$db->bind(':datelastworked', $maxdate);
		$db->bind(':shiftlastworked', $maxshift);
		$db->bind(':userid', $employee);

		$db->execute();

		
	}
	$show_edit_modal = true;

/* ------------------------------------------------------------
	Code to process delete overtime record follows
   ------------------------------------------------------------
*/
}elseif (isset($_POST['submit-delete'])) {
	//echo "you are trying to delete a record";
	$delete_id = $_POST['record_id'];

	$sql = "DELETE FROM ots_tbllogovertimeworked WHERE ID = :record_id";

	$db->query($sql);

	$db->bind(':record_id', $delete_id);

	$db->execute();

	$show_delete_modal = true;
}


/* ------------------------------------------------------------
	Code to retrieve overtime records and paginate for display
    This will set the offset and result number
   ------------------------------------------------------------
*/
$sql = "SELECT ID FROM ots_tbllogovertimeworked";
$db->query($sql);

// Get number of results returned
$numrows = count($db->resultset());

// GET variable 'page' is used for pagination
if (isset($_GET['page'])) {
	$current_page = $_GET['page'];
  // If the page is less than 1 it is invalid, reset to page 1 with offset 0 so we can look at the first record
	if ($_GET['page'] < 1) {
		$offset = 0;
		$current_page = 1;
  // If the page is greater than the total number of rows it is also invalid, reset to look at the last valid record
	}elseif ($_GET['page'] > $numrows) {
		$offset = $numrows - 1;
		$current_page = $numrows;
  // looks correct, set the offset to the current desired page minus 1
	}else {
	$offset = $_GET['page'] - 1;
	}
// initial page load with no GET variable set, default to the first record
}else{
	$current_page = 1;
	$offset = 0;
}

$sql = "SELECT users_profile.fname, 
			   users_profile.lname, 
			   ots_tbllogovertimeworked.ID, 
			   ots_tbllogovertimeworked.Empl_ID, 
			   ots_tbllogovertimeworked.DateWorkedOT, 
			   ots_tbllogovertimeworked.HoursWorked, 
			   ots_tbllogovertimeworked.ShiftWorkedOT, 
			   ots_tbllogovertimeworked.OvertimeType, 
			   ots_tbllogovertimeworked.EnteredBy, 
			   ots_tbllogovertimeworked.EnteredTimestamp, 
			   ots_tbllogovertimeworked.notes, 
			   ots_tbllogovertimeworked.UpdatedBy, 
			   ots_tbllogovertimeworked.UpdatedTimestamp 
			   FROM ots_tbllogovertimeworked 
			   INNER JOIN users_profile 
			   on users_profile.userid=ots_tbllogovertimeworked.Empl_ID ";

$sql .= "LIMIT $offset,1";

$db->query($sql);
$result = $db->resultset();

foreach ($result as $row) {
	$id = $row['ID'];
	$fname = $row['fname'];
	$lname = $row['lname'];
	$emplid = $row['Empl_ID'];
	$date_worked = $row['DateWorkedOT'];
	$shift_worked = $row['ShiftWorkedOT'];
	$hours_worked = $row['HoursWorked'];
	$ot_type = $row['OvertimeType'];
	$notes = $row['notes'];
	$entered_by = $row['EnteredBy'];
	$entered_time = $row['EnteredTimestamp'];
	$updated_by = $row['UpdatedBy'];
	$updated_time = $row['UpdatedTimestamp'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
</head>
<style type="text/css">
	.disable {
		pointer-events: none;
		cursor: default;
		color: silver;
	}

	.btn-dark {
		color: #ffffff;
		background-color: #595959;
	}

	.btn-dark:hover{
		color: #cccccc;
		
	}

	.btn-grow:hover{
		transform: scale(1.2);
	}


</style>

<body>
	

<?php

require_once ($_SERVER['DOCUMENT_ROOT']."/page-header.php");


?>

<div class="modal" id="modalEditConfirm">
        <div class="modal-dialog modal-sm" role="dialog">
          <div class="modal-content">
            <div class="modal-header" style="color:white; background-color: #00cc44;">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h1 class="modal-title">Success!</h1>
              
            </div>
            <div class="modal-body">
              <h2 class="text-center" >Overtime record updated!</h2>
            </div>
            <div class="modal-footer">
              
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              
            </div>
          </div>
        </div>
    </div>


    <div class="modal" id="modalDeleteConfirm">
        <div class="modal-dialog modal-sm" role="dialog">
          <div class="modal-content">
            <div class="modal-header" style="color:white; background-color: red;">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h1 class="modal-title">Success!</h1>
              
            </div>
            <div class="modal-body">
              <h2 class="text-center" >Overtime record deleted!</h2>
            </div>
            <div class="modal-footer">
              
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              
            </div>
          </div>
        </div>
    </div>
         




<div class='container' style='padding-top: 40px;'>
  <div class="row">


          <!-- <div class='row'>
            <div class='col-md-6 col-md-offset-3 col-sm-7 col-sm-offset-2 well well-lg'>
              <h2 class='text-center'>Enter Overtime Worked</h2><br> -->
    <form method='POST' class='form-horizontal form' style='padding: 20px;'>
        <div class="col-md-6 col-md-offset-3">
            <div class="progress">
                <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                  		
                </div>
            </div>

            <div class="box row-fluid"> 
                <br>
                <!-- hidden field for overtime record id -->
                <input type="hidden" name="record_id" value="<?php echo $id; ?>">
                <!-- hidden field for employee id -->
                <input type="hidden" name="emplid" value="<?php echo $emplid; ?>">

                <div class="step">
                  	<div class='form-group'>
                    	<label for='fname' class='col-sm-3 control-label'>First Name</label>
                    	<div class='col-sm-9'>
                      		<input type='text' class='form-control' name='fname' id='fname' value="<?php echo $fname; ?>"  readonly />
                    	</div>
                  	</div>

                  	<div class='form-group'>
                    	<label for='lname' class='col-sm-3 control-label'>Last Name</label>
                    	<div class='col-sm-9'>
                      		<input type='text' class='form-control' name='lname' id='lname' value="<?php echo $lname;?>" readonly autofocus tabindex="1"/>
                    	</div>
                  	</div>

                  	<div class='form-group'>
                    	<label for='date_worked' class='col-sm-3 control-label'>Date Worked OT</label>
                    	<div class='col-sm-9'>
                      		<input type='text' class='form-control' name='date_worked' id='datepicker' placeholder='yyyy/mm/dd' data-date-autoclose='true' required value="<?php echo $date_worked; ?>" tabindex="2"  />
                    	</div>
                  	</div>

                      	
                  	<div class='form-group'>
                    	<label for='hours_worked' class='col-sm-3 control-label'>Hours Worked</label>
                    	<div class='col-sm-9'>
                      		<input type='number' min='1' max='24' class='form-control' name='hours_worked' id='hours_worked' required value="<?php echo $hours_worked; ?>" tabindex="3" />
                    	</div>
                  	</div>

                  	<div class='form-group'>
                    	<label for='shift_worked' class='col-sm-3 control-label'>Shift Worked</label>
                    	<div class='radio col-sm-9'>
                      		<label><input type='radio' id='shift_worked' name='shift_worked' value='1' <?php if ($shift_worked == 1) { ?> checked='checked' <?php }?> >Day</label><br>
                      		<label><input type='radio' id='shift_worked' name='shift_worked' value='2' <?php if ($shift_worked == 2) { ?> checked='checked' <?php }?>>Night</label><br>
                      		<label><input type='radio' id='shift_worked' name='shift_worked' value='3' <?php if ($shift_worked == 3) { ?> checked='checked' <?php }?>>24 Hours</label>
                    	</div>
                  	</div>

                  	<div class='form-group'>
                    	<label for='overtime_type' class='col-sm-3 control-label'>Overtime Type</label>
                    	<div class='col-sm-9'>
                      		<select class='form-control' name='overtime_type' id='overtime_type' required tabindex="4">
		                        <option><?php echo $ot_type; ?></option>
		                        <option>Voluntary</option>
		                        <option>Mandatory</option>
		                        <option>Special Assignment</option>
                      		</select>
                    	</div>
                  	</div>
                  
                  	<div class="form-group">
                    	<label for='notes' class='col-sm-3 control-label'>Notes</label>
                    		<div class='col-sm-9'>
                      			<textarea maxlength='100' class='form-control' rows='3' name='notes' id='notes' style='resize: none' placeholder='Enter any notes (optional)' tabindex="5"><?php echo $notes; ?></textarea>
                    		</div>
                 	 </div>

                 	<div class='form-group'>
                    	<label for='entered_by' class='col-sm-3 control-label'>Entered By</label>
                    	<div class='col-sm-9'>
                      		<input type='text' class='form-control' name='entered_by' id='entered_by' value="<?php echo $entered_by;?>" readonly />
                    	</div>
                  	</div>

                  	<div class='form-group'>
                    	<label for='entered_timestamp' class='col-sm-3 control-label'>Entered Timestamp</label>
                    	<div class='col-sm-9'>
                      		<input type='text' class='form-control' name='entered_timestamp' id='entered_timestamp' value="<?php echo $entered_time;?>" readonly />
                    	</div>
                  	</div>

                  	<div class='form-group'>
                    	<label for='updated_by' class='col-sm-3 control-label'>Updated By</label>
                    	<div class='col-sm-9'>
                      		<input type='text' class='form-control' name='updated_by' id='updated_by' value="<?php echo $updated_by;?>" readonly />
                    	</div>
                  	</div>

                  	<div class='form-group'>
                    	<label for='updated_timestamp' class='col-sm-3 control-label'>Updated Timestamp</label>
                    	<div class='col-sm-9'>
                      		<input type='text' class='form-control' name='updated_timestamp' id='updated_timestamp' value="<?php echo $updated_time;?>" readonly />
                    	</div>
                  	</div>

                </div>



                <div class="row">
                  <div class="col-sm-12">
                    <div class="pull-right">
                    	
                    	

                    	


                      <?php if ($_SESSION['accesslvl'] >= 8) {?>
                      	
                      	<input type="submit" class="action btn-danger text-capitalize submit btn" name="submit-delete" value="Delete Record" onclick="return confirm('Are you sure? This will permanently delete this record!')"></input>
                      <?php } ?>

                      <?php if ($_SESSION['accesslvl'] >= 5) {?>
                      <input type="submit" class="action btn-info text-capitalize submit btn" name="submit-edit" value="Edit Record" tabindex="9"></input>
                      <?php } ?>
                    </div>
                  </div>
                </div>

    <!-- navigation links below -->


                  	<hr>
                  	<div class="text-center">
                		<a href="reviewot.php?page=1" class="btn btn-dark btn-grow <?php if ($current_page <= 1 ) { echo 'disabled';  }else echo ''; ?>" > << </a>

						<a href="reviewot.php?page=<?php echo $current_page - 1 ?>" class="btn btn-dark btn-grow  <?php if ($current_page <= 1 ) { echo 'disabled';  } else echo ''; ?>" > < </a>
<span style="font-size: 2rem; font-weight: 800;"><strong class="hidden-xs">Navigation</strong></a><span>
						<a href="reviewot.php?page=<?php echo $current_page + 1 ?>" class="btn btn-dark btn-grow <?php if ($current_page >= $numrows ) { echo 'disabled'; }else echo ''; ?>" > > </a>

						<a href="reviewot.php?page=<?php echo $numrows ?>" class="btn btn-dark btn-grow <?php if ($current_page >= $numrows ) { echo 'disabled'; }else echo ''; ?>" > >> </a>
					</div>
            	</div>
        	</div>
    	</div>

	</form>
</div>
</div> <!-- needed to end the mmenu div -->

<?php


?>

<?php 
require_once ($_SERVER['DOCUMENT_ROOT']."/footer.html");


if ($show_edit_modal) {?>
	<script>
       
    $('#modalEditConfirm').appendTo("body").modal('show')
       
</script> <?php

}

if ($show_delete_modal) {?>
	<script>
       
    $('#modalDeleteConfirm').appendTo("body").modal('show')
       
</script> <?php

}
?>

<script>
$('#datepicker').datepicker({
    format: 'yyyy-mm-dd'
    
});
</script>


</body>

</html>
