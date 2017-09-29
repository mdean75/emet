<?php // forgot-password.php

$page_title = "NJCAD.info Forgot Password";
$page_title_short = "NJCAD Forgot Password";
  
$page_security = 0;

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
    if (isset($_GET['status-code'])) {
      if (($_GET['status-code']) == '4X31'){
    echo '
    
        <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          <h2>Invalid username or email!</h2>
        </div>';
      }
    }
      ?>
        
        <div class='col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 panel panel-primary'>   

            <h2 class="text-center">Enter username and email to reset password</h2>
            <div class="col-sm-10 col-sm-offset-1">
                <form role='form' action='/resources/manage-user-action.php' method='POST'>
                    <div class='form-group'>
                        <label for='username' class="pull-left">User Name</label>
                                      
                        <input type='text' class='form-control' name='username' tabindex="1" autofocus required="required" />
                    </div>
                                      
                    <div class='form-group'>
                        <label for='email' class="pull-left">Email</label>
                                      
                        <input type='text' class='form-control' name='email' tabindex="2" required="required" />
                    </div>
             
                   <button type="submit" class="btn-primary text-capitalize submit btn btn-primary btn-block" name="submit" value="forgot-password">Forgot Password !</button>
                            
                </form><hr>
                <a href="/index.html" class="col-xs-4 btn btn-danger">Cancel</a><br><br><br>
                
            </div>
        </div>
    
    </div><!-- end row -->  
<div> <!-- end container -->  

<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>

</body>
</html>


