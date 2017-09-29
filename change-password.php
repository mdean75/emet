<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

$page_title = "NJCAD.info Forgot Password";
$page_title_short = "NJCAD Forgot Password";
         
?>
<!doctype html>
<html>
<head>
  <?php require_once ("/head.php"); ?>

</head>

<body>

<?php

require_once "admin-header.php";





$db = new database;

$sql = "SELECT userid, password FROM users_auth WHERE userid = :uid ";
$db->query($sql);

$db->bind(':uid', $_SESSION['userid']);
$result = $db->resultset();

if (empty($result)){ 

    echo "no results!";
    die;
}else{
  foreach ($result as $row){
    $id = $row['userid'];
    $password = $row['password'];
  }
    
}


  

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
                <form role='form' action='/resources/manage-user-action.php' method='GET'>
                    <div class='form-group'>
                        <label for='currentPassword' class="pull-left">Current Password</label>
                                      
                        <input type='text' class='form-control' name='currentPassword' tabindex="1" autofocus required="required" />
                    </div>
                                      
                    <div class='form-group'>
                        <label for='newPassword' class="pull-left">New Password</label>
                                      
                        <input type='text' class='form-control' name='newPassword' tabindex="2" required="required" />
                    </div>

                    <div class='form-group'>
                        <label for='confirmPassword' class="pull-left">Confirm Password</label>
                                      
                        <input type='text' class='form-control' name='confirmPassword' tabindex="2" required="required" />
                    </div>
              
                   
                    <input type='hidden' name='db-id' tabindex="1" value="<?php echo $id; ?>" />
                     <input type='hidden' name='db-password' tabindex="1" value="<?php echo $password; ?>" />
                     <br>
                    

                    <button type="submit" class=" btn-hot text-capitalize submit btn btn-primary btn-block" name="submit" value="change-password">Change Password !</button>
              
                                   
                </form>

                <br><br><br>
                
            </div>
        </div>
    </div><!-- end row -->  
<div> <!-- end container -->



                
</body>





</html>

<!-- javascript file that counts down then calls logout if no activity -->
<script type="text/javascript" src="/js/timed-logout.js"></script>
<!-- javascript script to dismiss alert -->
<script type="text/javascript" src="/js/dismiss-alert.js"></script>
<script type="text/javascript" src="/js/mmenu.js"></script>