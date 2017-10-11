<?php // reset-password-step2.php
session_start();
/*
    The purpose of this page is to enter the new password and confirm it.
    This page receives 2 POST variables (username and email) from reset-password.php.
    On initial load, these values are placed in session variables. This allows for
    for redirect back to this page to retry (after entering non-matching new passwords) without resubmitting post data. On failure, this page is called without any POST data
    set and so all processing will take place using session variables.
*/
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

// ***********************************************
// ***********************************************
// change this to a static method
if (isset($_SESSION['userid'])) {
  utility::redirect('', 'home.php', 'status-code', '3X89');
}
// *************************************************

$page_title = "NJCAD.info Reset Password";
$page_title_short = "NJCAD Reset Password";

$page_security = 0;


if (isset($_POST['submit-step1'])) {
// $_SESSION['token'] is set on reset-password.php
// if user attempts to bypass that page and browse to this page 
// directly, redirect to index.php. This is checked for by checking for 
// the token session variable which is only set on reset-password.php
// and is removed when the password is successfully changed.
if (!isset($_SESSION['token'])) {
  utility::redirect('', 'index.php', 'status-code', '3X99');
}
// if email and username are set then the user entered them correctly
// set the session variables that will be used
if (isset($_POST['username']) && isset($_POST['email'])){

  $_SESSION['get_user'] = strtolower(trim($_POST['username']));
  $_SESSION['get_email'] = strtolower(trim($_POST['email']));

   $valid_password_length = true; // initialize variable
    // flag that checks for 1) the user entered password matches the db password and 
    // 2) the new password matches the confirm password
    $passwords_match = true; 
    $valid_password_pattern = true;
  
}

// database user associated with the token being used was retrieved on previous page script
// and stored in a session variable.  If the value retrieved from the database does not match what the user
// entered then redirect with status code set
if ($_SESSION['get_user'] != $_SESSION['uname']) {
  utility::redirect('', 'reset-password.php', 'status-code', '4X31');
  
  
}else{
// database user email associated with the token being used was retrieved on previous page script
// and stored in a session variable.  If the value retrieved from the database does not match what the user
// entered then redirect with status code set
  if ($_SESSION['get_email'] != $_SESSION['email']) {
    utility::redirect('', 'reset-password.php', 'status-code', '4X31');
     
  }
}
}// end submit-step1
elseif (isset($_POST['submit-step2'])) {
      $db = new database;

      $id = $_SESSION['id'];
      $newPassword = trim($_POST['new-password']);
      $confirmPassword = trim($_POST['confirm-password']);
      $user = $_SESSION['uname'];
      $email = $_SESSION['email'];

      // initialize variables, set flag to true initially

      // flag to check password length meets requirements
      $valid_password_length = true; 
      // flag that checks for 1) the user entered password matches the db password and 
      // 2) the new password matches the confirm password
      $passwords_match = true; 
      // flag to check that user entered password meets the required pattern
      $valid_password_pattern = true;

      $pattern = "~^(?=[a-zA-Z])(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])~";

      // passwords dont' match, redirect to retry
      if ($newPassword != $confirmPassword) {
        $passwords_match = false;
        
              
      }elseif (strlen($newPassword) < 8) {
        $valid_password_length = false;
            
      }elseif (!preg_match($pattern, $newPassword)){ 
            
        $valid_password_pattern = false;
        
          }else{
        // hash password before updating database
        $newPassword = User::hash_password($newPassword);
      

      // use transactions for updates, first query updates the password, if that succeeds then remove the token and token expiration
      $db->begin_trans();

      try {
        // first change the password
        $db->query("UPDATE users_auth SET password = :password WHERE userid = :id");
        $db->bind(':password', $newPassword);
        $db->bind(':id', $id);

        
        $db->execute();
        // then remove the token and token expiration

        $db->query("UPDATE users_auth SET token = NULL, tokenExpiration = NULL WHERE userid = :id");
        $db->bind(':id', $id);
        
        $db->execute();

        $db->commit();

        // after success unset the session variables
        session_unset();

        utility::redirect('', 'success.php', 'redirect', 'change-password');
      }
       
      catch (Exception $e) {
          echo 'there was an error with the sql: ' . $e->getMessage();
          $db->rollback();
        } // end catch
      }

      
}

?>
<!doctype html>
<html>
<head>
  
  <?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>
<!-- the onload here is used to fire the error modal automatically only if the error status code is set -->
<body onload="checkForRetry()">

<?php

require_once "page-header.php";


/* **************************************
    first check for 'status-code = 4X33' 
    variable, if it is set then fire a 
    bootstrap modal with a message and go 
    back and retry when modal is closed. 
    Also the rest of the script is not 
    loaded if the retry variable is set
  **************************************** */
  
if (isset($_POST['submit-step2'])) {
  if (!$passwords_match || !$valid_password_length || !$valid_password_pattern) {
  echo '
  <div class="modal" id="retryModal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header" style="color:white; background-color: red;">
        <h1 class="modal-title">Retry</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h2 style="height: 30vh;">Passwords did not match or did not meet requirements, please retry.</h2>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>';

// script to automatically fire the modal if the status-code is set
?>
    <script>
    function checkForRetry() {
        $('#retryModal').modal('show')
    }

    </script>
<?php ;

}}
//else{
?>

                      
<div class='container'>
    <div class='row'>
   

        <div class='col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 panel panel-primary'>   

            <h2 class="text-center">Enter new password and confirm</h2>
            <div class="col-sm-10 col-sm-offset-1">
                <form role='form' method='POST'>
                    <div class='form-group'>
                        <label for='new-password' class="pull-left">New Password</label>
                                      
                        <input type='password' class='form-control' name='new-password' tabindex="1" autofocus required="required" />
                    </div>
                                      
                    <div class='form-group'>
                        <label for='confirm-password' class="pull-left">Re-enter Password</label>
                                      
                        <input type='password' class='form-control' name='confirm-password' tabindex="2" required="required" />
                    </div>
             
                   
                    <button type='submit' name='submit-step2' class='btn btn-default btn-primary btn-block' tabindex="4" value='reset-change-password'>Change Password!</button><br>
              
                                   
                </form><hr>
                <a href="/index.php" class="col-xs-4 btn btn-danger">Cancel</a><br><br><br>
                
            </div>
        </div>
    </div><!-- end row -->  
<div> <!-- end container -->
                <?php //} ?>      
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>

<!-- Script to dismiss the alert after time elapsed  -->
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
</script>

<!-- when modal is closed go back to try again -->

</html>