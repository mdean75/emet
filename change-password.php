<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

$page_title = "NJCAD.info Forgot Password";
$page_title_short = "NJCAD Forgot Password";
  
$page_security = 1;

?>
<!doctype html>
<html>
<head>

  <?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>

<body>

<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/admin-header.php');

?>
                    
<div class='container'>
    <div class='row'>
    <?php 
    if (isset($_GET['retry'])) {

    echo '
    
        <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          <h2>Incorrect current password entered or the new passwords did not match!</h2>
        </div>';
      }
      ?>
        <br>
        <div class='col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 panel panel-primary'>   

            <h2 class="text-center">Change Password</h2><br>
            <div class="col-sm-10 col-sm-offset-1">
                <form role='form' action='/resources/manage-user-action.php' method='POST'>
                    <div class='form-group'>
                        <label for='currentPassword' class="pull-left">Current Password</label>
                                      
                        <input type='password' class='form-control' name='currentPassword' tabindex="1" autofocus required="required" />
                    </div>
                                      
                    <div class='form-group'>
                        <label for='newPassword' class="pull-left">New Password</label>
                                      
                        <input type='password' class='form-control' name='newPassword' tabindex="2" required="required" />
                    </div>

                    <div class='form-group'>
                        <label for='confirmPassword' class="pull-left">Confirm Password</label>
                                      
                        <input type='password' class='form-control' name='confirmPassword' tabindex="2" required="required" />
                    </div>
              
                     <br>
                    

                    <button type="submit" class=" btn-hot text-capitalize submit btn btn-primary btn-block" name="submit" value="change-password">Change Password !</button>
              
                                   
                </form>

                <br><br><br>
                
            </div>
        </div>
    </div><!-- end row -->  
<div> <!-- end container -->

<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>
                
</body>

</html>

