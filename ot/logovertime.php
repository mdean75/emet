<?php  //logovertime.php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session();

// full title to display on larger screens
$page_title = "Overtime Tracking - Enter Overtime Record";
// shortened page title for mobile devices
$page_title_short = "Enter Overtime Record";

$page_security = 5;

utility::checkForLogin($_SERVER['PHP_SELF']);

utility::restrict_page_access($page_security, '', 'home.php', 'status-code', '3X99');
$show_success_modal = false;

if (isset($_SESSION['success'])) {
  
  if ($_SESSION['success']) {
   
    $show_success_modal = true;
    unset($_SESSION['success']);
  }
}


if (isset($_POST['submit'])) {
  /*  ------------------------------------------------------------
      variables passed from the overtime entry form using POST 
      method.
     ------------------------------------------------------------ */

$emplid = ($_POST['emplid']);
$firstname = ($_POST['fname']);
$lastname = ($_POST['lname']);
$hours = (trim($_POST['hours_worked']));
$date_worked = (trim($_POST['date_worked']));
$shift = ($_POST['shift_worked']);
$ot_type = ($_POST['overtime_type']);
$notes = (trim($_POST['notes']));
$ot_entered_by = ($_POST['entered_by']);

$username = ($_SESSION['username']);// for activity logging

$sql = "SELECT * FROM ots_tbllogovertimeworked WHERE (Empl_ID = :empl_id AND DateWorkedOT = :date_worked AND ShiftWorkedOT = :shift_worked)";

$db = new database;
$db->query($sql);

$db->bind(':empl_id',$emplid);
$db->bind(':date_worked', $date_worked);
$db->bind(':shift_worked', $shift);

// no ot record with that id, date and shift in the database
    if (!empty($db->resultset())){
      $ot_already_logged = true;
      $_SESSION['error'] = "Overtime has already been logged for this employee, date, and shift";
      header('location: logovertime.php');
      exit;
      
    }else {
      $db->begin_trans();

      try{

        $sql = "INSERT INTO ots_tbllogovertimeworked(Empl_ID, DateWorkedOT, ShiftWorkedOT, HoursWorked, OvertimeType, notes, EnteredBy) VALUES(:emplid, :date_worked, :shift, :hours, :ot_type, :notes, :ot_entered_by)";

        $db->query($sql);
        
        $db->bind(':emplid', $emplid);
        $db->bind(':date_worked', $date_worked);
        $db->bind(':shift', $shift);
        $db->bind(':hours', $hours);
        $db->bind(':ot_type', $ot_type);
        $db->bind(':notes', $notes);
        $db->bind(':ot_entered_by', $ot_entered_by);

        $db->execute();

        $sql = "UPDATE users_profile SET ThirdDate = SecondDate, SecondDate = DateLastWorkedOT, ThirdShift = SecondShift, SecondShift = ShiftLastWorked WHERE userid =:emplid";

        $db->query($sql);

        $db->bind(':emplid', $emplid);

        $db->execute();

        $sql = "SELECT Empl_ID, Max(DateWorkedOT) AS MaxOfDateWorkedOT, Max(ShiftWorkedOT) AS LastShiftWorked FROM ots_tbllogovertimeworked GROUP BY Empl_ID";

        $db->query($sql);

        $results = $db->resultset($sql);

        foreach ($results as $row) {
          $Empl_ID=$row['Empl_ID'];
          //$first=$row['FirstName'];
          //$last=$row['LastName'];
          $maxdate=$row['MaxOfDateWorkedOT'];
          $maxshift=$row['LastShiftWorked'];

          $sql = "UPDATE users_profile SET DateLastWorkedOT = :maxdate, ShiftLastWorked = :maxshift WHERE userid =:employee";

          $db->query($sql);

          $db->bind(':maxdate', $maxdate);
          $db->bind(':maxshift', $maxshift);
          $db->bind(':employee', $Empl_ID);

          $db->execute();




          $_SESSION['success'] = true;



        } // end foreach
        $db->commit();
        header('location: logovertime.php');
        exit;
      } // end try
      catch (Exception $e) {
        echo 'Something failed: ' . $e->getMessage();

        $db->rollback();
      } // end catch
    } // end if .. else
  } // end if isset post submit


        
 /* ----------------------------------------------------------------------- 
      this script displays a select box populated with all employees
      and when an employee is selected uses ajax to display the overtime 
      entry form from 'load_data.php' with employee first and last name 
      pre-poplulated with read only attribute
    -----------------------------------------------------------------------*/

 
 ?>  
 
<!DOCTYPE html>
<html>
<head>
  
  <?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>
<body>

  <div class="modal" id="modalConfirm">
        <div class="modal-dialog modal-sm" role="dialog">
          <div class="modal-content">
            <div class="modal-header" style="color:white; background-color: #00cc44;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h1 class="modal-title">Success!</h1>
              
            </div>
            <div class="modal-body">
              <h2 class="text-center" >Overtime record added!</h2>
            </div>
            <div class="modal-footer">
              
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              
            </div>
          </div>
        </div>
    </div>
<?php

require_once ($_SERVER['DOCUMENT_ROOT']."/page-header.php");

// retrieve database records to selct box
  $db = new database;
    $db->query("SELECT * FROM users_profile");
    
  $results = $db->resultset();
?>

</nav>

<!-- Display the employee select box -->

<div class="container"> 

<?php

  if (isset($_SESSION['error'])) { ?>
  <br>
      
  <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
    <h2><?php echo $_SESSION['error']; 
        unset($_SESSION['error']);
        ?> 
    </h2>
  </div>
  <br>
 

  <?php }

?>
  <div class="col-md-6 col-md-offset-3">


    <?php 
    if ($db->rowcount() > 0) { ?>

      <select class="form-control input-lg align-select-box" name="employee" id="employee" >
        <option value="">Select Employee To Enter OT</option> 
                <?php //echo fill_empl_list($conn); ?> 
                <?php 
        // display fetched results in select box
        foreach ($results as $row) { ?>
        <option value="<?php echo filter_var($row['userid'], FILTER_SANITIZE_NUMBER_INT); ?>"><?php echo filter_var($row['userid'], FILTER_SANITIZE_NUMBER_INT)." ".filter_var($row['fname'], FILTER_SANITIZE_STRING)." ".filter_var($row['lname'], FILTER_SANITIZE_STRING); ?></option>?>
        <?php }} ?> 
      </select>  
  </div>
  <div class="row">
    <div class="col-md-12 col-md-offset-3" id="display_record">  
                <?php //echo display_ot_entry_form($conn);?>  
           </div>
  </div>

           

      </div>
   </div>     
 </div> 

<?php 
require_once ($_SERVER['DOCUMENT_ROOT']."/footer.html");

if ($show_success_modal) {?>
  <script>
       
    $('#modalConfirm').appendTo("body").modal('show')
       
</script> <?php

}
?>

</body>  
</html> 

<?php
  
  /*else{
    echo "
		<div class='container page-header' style='padding-top: 40px; margin-bottom: 20px;'>
			<div class='row'>
				<div class='col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3'>
					<div>
						<h2 class='text-center'>Officer or Administrator Access Required!</h2>
						<h3 class='text-center'>You will be redirected in a few seconds</h3>
						<h3 class='text-center'>Or you may click the button below to continue now</h3>
					</div>
					<div>
						<a href='overtime.php' class='btn btn-success col-xs-12 col-md-4 col-md-offset-4' role='button'>Continue</a>
					</div>
				</div>
			</div>
		</div>";
		echo " <meta http-equiv='refresh' content='5; url=overtime.php'>";
		
        }

  }*/

?>



<script>
$('#datepicker').datepicker({
    format: 'yyyy-mm-dd'
    
});
</script>



<!-- **************************************************
      ajax script to load the overtime entry form 
     **************************************************
-->

 <script>  
 $(document).ready(function(){  
      $('#employee').change(function(){  
           var ID = $(this).val();  
           $.ajax({  
                url:"logovertime.inc.php",  
                method:"POST",  
                data:{ID:ID},  
                success:function(data){  
                     $('#display_record').html(data);  
                }  
           });  
      });  
 });  
 </script> 
