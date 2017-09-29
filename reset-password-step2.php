<?php // reset-password-step2.php

/*
    The purpose of this page is to enter the new password and confirm it.
    This page receives 2 POST variables (username and email) from reset-password.php.
    On initial load, these values are placed in session variables. This allows for
    for redirect back to this page to retry (after entering non-matching new passwords) without resubmitting post data. On failure, this page is called without any POST data
    set and so all processing will take place using session variables.
*/
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

$page_title = "NJCAD.info Reset Password";
$page_title_short = "NJCAD Reset Password";

$page_security = 0;
     
?>
<!doctype html>
<html>
<head>
  
  <?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>
<!-- the onload here is used to fire the error modal automatically only if the error status code is set -->
<body onload="checkForRetry()">

<?php

require_once "admin-header.php";
session_regenerate_id(true);

/* **************************************
    first check for 'status-code = 4X33' 
    variable, if it is set then fire a 
    bootstrap modal with a message and go 
    back and retry when modal is closed. 
    Also the rest of the script is not 
    loaded if the retry variable is set
  **************************************** */
  
if (isset($_GET['status-code'])) {
  if ($_GET['status-code'] == '4X33') {
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
        <h2 style="height: 30vh;">Passwords did not match, please retry.</h2>
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

}}else{

// if email and username are set then the user entered them correctly
// set the session variables that will be used
if (isset($_POST['username']) && isset($_POST['email'])){

  $_SESSION['get_user'] = $_POST['username'];
  $_SESSION['get_email'] = $_POST['email'];
  
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
 

?>

                      
<div class='container'>
    <div class='row'>
   

        <div class='col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 panel panel-primary'>   

            <h2 class="text-center">Enter new password and confirm</h2>
            <div class="col-sm-10 col-sm-offset-1">
                <form role='form' action='/resources/manage-user-action.php' method='POST'>
                    <div class='form-group'>
                        <label for='username' class="pull-left">New Password</label>
                                      
                        <input type='password' class='form-control' name='new-password' tabindex="1" autofocus required="required" />
                    </div>
                                      
                    <div class='form-group'>
                        <label for='password' class="pull-left">Re-enter Password</label>
                                      
                        <input type='password' class='form-control' name='confirm-password' tabindex="2" required="required" />
                    </div>
             
                   
                    <button type='submit' name='submit' class='btn btn-default btn-primary btn-block' tabindex="4" value='reset-change-password'>Change Password!</button><br>
              
                                   
                </form><hr>
                <a href="/index.php" class="col-xs-4 btn btn-danger">Cancel</a><br><br><br>
                
            </div>
        </div>
    </div><!-- end row -->  
<div> <!-- end container -->
                <?php } ?>      
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
<script>
  $('#retryModal').on('hide.bs.modal', function (e) {
  window.location.href = '/reset-password-step2.php';
})
</script>
</html>