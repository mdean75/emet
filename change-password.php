<?php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

User::regenerate_session(true);

$page_title = "NJCAD.info Forgot Password";
$page_title_short = "NJCAD Forgot Password";
  
$page_security = 1;

utility::checkForLogin($_SERVER['PHP_SELF']);

utility::restrict_page_access($page_security, '', 'home.php', 'status-code', '3X99');

// form processing is triggered by $_POST['submit']
if (isset($_POST['submit'])) {
    // initialize variables, set flag to true initially

    // flag to check password length meets requirements
    $valid_password_length = true; 
    // flag that checks for 1) the user entered password matches the db password and 
    // 2) the new password matches the confirm password
    $passwords_match = true; 
    // flag to check that user entered password meets the required pattern
    $valid_password_pattern = true;
    
    // password required pattern: requires at least 1 uppercase, 1 lowercase and 1 number
    // also first character cannot be a number
    $pattern = "~^(?=[a-zA-Z])(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])~";

    // user entered passwords
    $currentPassword = trim($_POST['currentPassword']);
    $newPassword = trim($_POST['newPassword']);
    $confirmPassword = trim($_POST['confirmPassword']);
    // use the session variable for userid as this script will change the password for the logged in user
    $id = $_SESSION['userid'];

    // instantiate User class and set username and password
    $user = new User($_SESSION['username'], $currentPassword);
    
    // get the hashed password from the database 
    $db_password = $user->get_db_password($id);  

    // verify if user entered current password is correct, if not redirect to try again
    if (!password_verify($currentPassword, $db_password)){
        
        $passwords_match = false;

        
    }else{ // password was correct, continue script

    // verify if user entered new password and new password confirmation match and if so hash the new password to prepare to update the database record, if not set the variable to trigger the alert message to try again
        if ($newPassword != $confirmPassword) {
            
            $passwords_match = false;
            
            
        }elseif (strlen($newPassword) < 8) {
            $valid_password_length = false;
        }elseif (!preg_match($pattern, $newPassword)){ 
        
                $valid_password_pattern = false;
        
        }else{ // correct current pass, new password matched confirm password, correct pattern
        
    

            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $db = new database;
            try {
                //  change the password
                $sql = "UPDATE users_auth SET password = :newpass WHERE userid = :id ";
                $db->query($sql);
                $db->bind(':newpass', $newPassword);
                $db->bind(':id', $id);
                $db->execute();

                utility::redirect('', 'home.php', 'redirect', 'change-password');
            }
            catch (Exception $e) {
                    echo 'there was an error with the sql: ' . $e->getMessage();
                
            } // end catch
        } // end (all passwords correct)
    } // end password verify
} // end isset $_POST['submit']
?>
<!doctype html>
<html>
<head>

  <?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>

<body>

<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/page-header.php');

?>
                    
<div class='container'>
    <div class='row'>
    <?php 
    //if (isset($_GET['retry'])) {

    if (isset($passwords_match)) {
        if (!$passwords_match) {

    echo '
        <br>
        <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          <h2>Incorrect current password entered or the new passwords did not match!</h2>
        </div>';

        
        // only run this check if the first check passed
        //}elseif (strlen($newPassword) < 8) {
        }elseif (!$valid_password_length) {
                echo '
                    <br>
                    <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                      <h2>New password must be at least 8 characters long!</h2>
                    </div>';
        } // end check for matching password and string length check
        elseif (!$valid_password_pattern) {
            echo '
                    <br>
                    <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                      <h2>Password must begin with a letter and contain at least 1 uppercase, 1 lowercase and 1 number!</h2>
                    </div>';
        }
        
    } // end if isset $passwords_match

      ?>
        <br>
        <div class='col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 panel panel-primary'>   

            <h2 class="text-center">Change Password</h2><br>
            <div class="col-sm-10 col-sm-offset-1">
                <form role='form' method='POST'>
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