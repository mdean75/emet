<?php  //logovertime.inc.php
session_start();
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');
$loggedinuser = $_SESSION['username'];
 //$connect = mysqli_connect("localhost", "root", "", "njcad");  


/*  ----------------------------------------------------------
      assigns logged in user to variable to be called later
    ---------------------------------------------------------- */

 

 /*  ------------------------------------------------------------
      query to retrieve employee names from 'tblemployees'
     ------------------------------------------------------------ */

 if(isset($_POST["ID"]))  
 {  
      if($_POST["ID"] != '')  
      {  
           $sql = "SELECT * FROM users_profile WHERE ID = '".$_POST["ID"]."'";  
      }  
      else  
      {  
           $sql = "SELECT * FROM users_profile";  
      }  

  try {
    $uid = $_POST["ID"];
    $sql = "SELECT fname, lname, userid 
            FROM users_profile WHERE userid = :id";
    $db = new database;
    $db->query($sql);
    $db->bind(':id', $uid);
    $result = $db->resultset();

    foreach ($result as $row) {
      $fname = $row['fname'];
      $lname = $row['lname'];
      $userid = $row['userid'];
    }
  }
  catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
  }
  
      /*$result = mysqli_query($conn, $sql); 

      while($row = mysqli_fetch_array($result))  
      {  
           
           $output = $row["FirstName"]; 

           $output2 = $row["LastName"];  

           $output3 = $row['ID'];           
      }  */
  ?>
  
  <!-- **********************************************************************
  	jquery-ui extension, needed for datepicker
       **********************************************************************
  -->
  

<script>
$('#datepicker').datepicker({
    format: 'yyyy-mm-dd'
    
});
</script>

  
  
  <?php    
 /*  ------------------------------------------------------------
      form to display overtime worked record
     ------------------------------------------------------------ */
     ?><!--
        <div class='container center-block' style='padding-top: 40px;'>
          <div class="col-xs-12">-->
          <!-- <div class='row'>
            <div class='col-md-6 col-md-offset-3 col-sm-7 col-sm-offset-2 well well-lg'>
              <h2 class='text-center'>Enter Overtime Worked</h2><br> -->
          <form action='logovertime.php' method='POST' class='form-horizontal form' style='padding: 20px;'>
            <div class="col-md-6 col-md-offset-0">
                <div class="progress">
                  <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="box row-fluid"> 
                <br>

                <div class="step">
                  <div class='form-group'>
                    <label for='fname' class='col-sm-3 control-label'>First Name</label>
                    <div class='col-sm-9'>
                      <input type='text' class='form-control' name='fname' id='fname' value="<?php echo $fname; ?>" readonly required />
                    </div>
                  </div>

                  <div class='form-group'>
                    <label for='lname' class='col-sm-3 control-label'>Last Name</label>
                    <div class='col-sm-9'>
                      <input type='text' class='form-control' name='lname' id='lname' value="<?php echo $lname; ?>" readonly required />
                    </div>
                  </div>

                  <div class='form-group'>
                    <label for='date_worked' class='col-sm-3 control-label'>Date Worked OT</label>
                    <div class='col-sm-9'>
                      <input type='text' class='form-control' name='date_worked' id='datepicker' placeholder='yyyy/mm/dd' data-date-autoclose='true' required />
                    </div>
                  </div>

                      <input type='hidden' class='form-control' name='emplid' id='emplid' value="<?php echo $userid; ?>"  required />

                  <div class='form-group'>
                    <label for='hours_worked' class='col-sm-3 control-label'>Hours Worked</label>
                    <div class='col-sm-9'>
                      <input type='number' min='1' max='24' class='form-control' name='hours_worked' id='hours_worked' required />
                    </div>
                  </div>

                  <div class='form-group'>
                    <label for='shift_worked' class='col-sm-3 control-label'>Shift Worked</label>
                    <div class='radio col-sm-9'>
                      <label><input type='radio' id='shift_worked' name='shift_worked' value='1'>Day</label><br>
                      <label><input type='radio' id='shift_worked' name='shift_worked' value='2'>Night</label><br>
                      <label><input type='radio' id='shift_worked' name='shift_worked' value='3'>24 Hours</label>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label for='overtime_type' class='col-sm-3 control-label'>Overtime Type</label>
                    <div class='col-sm-9'>
                      <select class='form-control' name='overtime_type' id='overtime_type' required >
                        <option>Select Type of OT</option>
                        <option>Voluntary</option>
                        <option>Mandatory</option>
                        <option>Special Assignment</option>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for='notes' class='col-sm-3 control-label'>Notes</label>
                    <div class='col-sm-9'>
                      <textarea maxlength='100' class='form-control' rows='3' name='notes' id='notes' style='resize: none' placeholder='Enter any notes (optional)'></textarea>
                    </div>
                  </div>

                  <div class='form-group'>
                    
                    <div class='col-sm-4'>
                      <input type='hidden' class='form-control' name='entered_by' id='entered_by'  value="<?php echo $loggedinuser; ?>" />
                    </div>

                    
                    <div class='col-sm-4'>
                       <input type='hidden' class='form-control' name='entered_timestamp' id='entered_timestamp'  />

                    </div>
                  </div>

                  

                </div>

                <div class="step display">
                  <h4>Confirm Details</h4>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">User ID</label>
                      <div class="col-sm-9">
                        <label data-id="emplid"></label>
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
                    <label class="col-sm-3 control-label">Date Worked</label>
                    <div class="col-sm-9">
                      <label data-id="datepicker"></label>
                    </div>
                  </div> 

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Hours Worked</label>
                    <div class="col-sm-9">
                      <label data-id="hours_worked"></label>
                    </div>
                  </div>   

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Shift Worked</label>
                    <div class="col-sm-9">
                      <label data-id="shift_worked"></label>
                    </div>
                  </div>   

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Overtime Type</label>
                    <div class="col-sm-9">
                      <label data-id="overtime_type"></label>
                    </div>
                  </div> 

                  <div class="form-group">
                    <label class="col-sm-3 control-label">Notes</label>
                    <div class="col-sm-9">
                      <label data-id="notes"></label>
                    </div>
                  </div>              

                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <div class="pull-right">
                      <button type="button" class="action btn-sky text-capitalize back btn">Back</button>
                      <button type="button" class="action btn-sky text-capitalize next btn">Next</button>
                      <input type="submit" class="action btn-hot text-capitalize submit btn" name="submit" value="Submit"></input>
                    </div>
                  </div>
                </div>
              </div>
        </div>
      </form>
    </div>
    </div>

<?php
 }
 
?> 

 <script type="text/javascript" src="/js/form-widget.js"></script>
  
<script>
$('#datepicker').datepicker({
    format: 'yyyy-mm-dd'
    
});
</script>