<?php
/*
    The purpose of this page is to retrieve a user record from the database based on 
    the token GET variable. This was emailed to the user in the form of a clickable link. The record associated with the token is first retrived, then the user must authenticate by entering the username and email from the corresponding record. If incorrect credentials are entered, the user is redirected back to this page with an error status code set which controls displaying an error modal.

*/
session_start();
session_regenerate_id(true);

// must include the autoloader script 
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');
// user already logged in, call to static method redirect
if (isset($_SESSION['userid'])) {
  utility::redirect('', 'home.php', 'status-code', '3X89');
}


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

require_once ($_SERVER['DOCUMENT_ROOT'].'/page-header.php');



/*
    If the GET array is empty then the user attempted to directly browse to this page without using the link in the email with the token. This is not allowed, redirect to the login page.
*/
if (empty($_GET)){
    echo '
        <br>
        <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          <h2>Please use the link from your email!</h2>
        </div>';
        utility::js_redirect('', 'oop.login.php', 'status-code', '4X91');
       
        
}// end if empty get
  else{ // get not empty

    // if status-code variable is set then the user entered incorrect username or email, display modal. 
    if (isset($_GET['status-code'])) {
      if ($_GET['status-code'] == '4X31') {

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
              <h2 style="height: 30vh;">Incorrect credentials entered, please retry.</h2>
            </div>
            <div class="modal-footer">
              
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>';
      ?>
      <!-- script to automatically fire the modal if the status-code is set -->
        <script>
        function checkForRetry() {
            $('#retryModal').modal('show')
        } // end script

        </script>
      <?php ;

    } // end if status-code == 4X31
  } // end if isset status-code
      else{ // status-code not set
        if (isset($_GET['token'])) {
          $token = $_GET['token'];
          $_SESSION['token'] = $_GET['token'];
        }else{
          $token = $_SESSION['token'];
        }

        
        $db = new database;

        $sql = "SELECT userid, username, email, tokenExpiration, tokenAttempts FROM users_auth WHERE token = :token";
        $db->query($sql);
        $db->bind(':token', $token);

        $result = $db->resultset();

        if (empty($result)){ 

        }// end if empty result

          else{
              foreach ($result as $row) {
              // set all values to session variable for use on subsequent pages
              $_SESSION['id'] = $row['userid'];
              $_SESSION['uname'] = $row['username'];
              $_SESSION['email'] = $row['email'];  
              $_SESSION['tokenExpiration'] = $row['tokenExpiration'];  
              $_SESSION['tokenAttempts'] = $row['tokenAttempts'];  // not used yet
              

              } // end foreach
          } // end else

        // check to see if the token is not expired and display alert if it is
        if ((empty($_SESSION['tokenExpiration'])) || ($_SESSION['tokenExpiration'] < time())) {
           echo '
    
          <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
            <h2>Either you entered the incorrect username and/or email or the link you are attempting to use is expired or has already been used!  Please click on "Forgot Password" to request a new link.</h2>
          </div>';
          utility::js_redirect('', 'oop.login.php', 'status-code', '4X35');


        } // end if token expiration
          // token is valid
          else{
  
?>
            <div class='container'>
                <div class='row'>
    

                  <div class='col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 panel panel-primary'>   

                    <h2 class="text-center">Enter username and email to reset password</h2>
                    <div class="col-sm-10 col-sm-offset-1">
                        <form role='form' action='reset-password-step2.php' method='POST'>
                            <div class='form-group'>
                                <label for='username' class="pull-left">User Name</label>
                                                
                                <input type='text' class='form-control' name='username' tabindex="1" autofocus required="required" />
                            </div>
                                              
                            <div class='form-group'>
                                <label for='email' class="pull-left">Email</label>
                                              
                                <input type='text' class='form-control' name='email' tabindex="2" required="required" />
                            </div>

                            <input type='submit' name='submit-step1' class='btn btn-default btn-primary btn-block' tabindex="4" value='Submit!'/><br>
                      
                                           
                        </form><hr>
                        <a href="/index.html" class="col-xs-4 btn btn-danger">Cancel</a><br><br><br>
                        
                    </div>
                  </div>
                </div><!-- end row -->  
            <div> <!-- end container -->


<?php
          } // end else token is valid
      } // end else isset retry
    } // end else empty get
 
?>
                
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>

<!-- Script to dismiss the alert after time elapsed  -->
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 8000);
</script>

<!-- when modal is closed go back to try again -->
<script>
  var token = '<?php echo $_SESSION['token']; ?>';
  $('#retryModal').on('hide.bs.modal', function (e) {
  window.history.go(-1);
})
</script>

</html>