<?php
session_start();

// must include the autoloader script manually as the login page does not have 
// the header file where the autoloader gets called for all other pages
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');
// user already logged, call to static method redirect
if (isset($_SESSION['userid'])) {
  utility::redirect('', 'home.php', 'status-code', '3X89');
}
session_regenerate_id(true);


// set a temporary cookie to check to ensure that cookies are enabled
// this cookie will be tested for on the login action page
setcookie("check_login", "test", time()+60*5 );

// full title to display on larger screens
$page_title = "ASTAR Login";
// shortened page title for mobile devices
$page_title_short = "ASTAR Login";

$page_security = 0;
?>

<!DOCTYPE html>
<html>
<head>
  <?php
  // all the meta, script and css files
  require_once ("head.php");?>
</head>
<body>
  <?php 
  require_once ($_SERVER['DOCUMENT_ROOT'].'/page-header.php');





?>
      
<div class='container'>
    <div class='row'>

<?php if (isset($_GET['status-code'])) {
        if ($_GET['status-code'] == '4X88') {
          echo '
            <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
              <h2>Cookies are required but are currently disabled!  Please re-enable cookies and try again</h2>
            </div>';
        }elseif (($_GET['status-code'] == '4X31') || 
                 ($_GET['status-code'] == '4X32') || 
                 ($_GET['status-code'] == '4X33')) {

          if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 1; 
          }else{
            $_SESSION['login_attempts']++;
          }
        
      
    

      echo '
    
        <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          <h2>No user was found with those credentials, please try again!</h2>
        </div>';
      }elseif ($_GET['status-code'] == '4X34') {
        echo '
    
        <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          <h2>Incorrect CAPTCHA entered, please try again!</h2>
        </div>';
      }
    }
     
        ?>

        <div class='col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 panel panel-primary'>   

            <h2 class="text-center">Login</h2>
            <div class="col-sm-10 col-sm-offset-1">
                <form role='form' action='/resources/oop.login.action.php' method='POST'>

                    <div class='form-group'>
                        <label for='username' class="pull-left">User Name</label>
                                      
                        <input type='text' class='form-control' name='username' tabindex="1" autofocus  />
                    </div>
                                      
                    <div class='form-group'>
                        <label for='password' class="pull-left">Password</label>
                                      
                        <input type='password' class='form-control' name='password' tabindex="2" />
                    </div>
              

                  <?php 
                  // only display the captcha code if 3 or more failed login attempts
                  if (isset($_SESSION['login_attempts'])) {
                    if ($_SESSION['login_attempts'] > 3) {
                    ?>
                    <br><br>
                    <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                    <input class="col-sm-12" type="text" name="captcha_code" tabindex="3" required="required" />

                      <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false"><img src="securimage/images/refresh.png" alt="refresh"></a>
                      <br><br><br><br>
                      <?php
                       }
                     }
                       ?>
                       <input type="hidden" name="ua" value="<?php echo $_SERVER['HTTP_USER_AGENT'] ?> ">
                       <input type="hidden" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR'] ?> ">
                      
                    <input type='submit' name='submit' class='btn btn-default btn-primary btn-block' tabindex="4" value='Login!'/><br>                   
                    
                <a href="/forgot-password.php" >I forgot my password</a>
                </form><hr>
                <a href="../index.php" class="col-xs-4 btn btn-danger">Cancel</a><br><br><br>
                
            </div>
        </div>
    </div><!-- end row -->  
<div> <!-- end container -->
</div>
       
<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>

</body>

