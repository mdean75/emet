<?php

$page_title = "NJCAD.info Login";
$page_title_short = "NJCAD Login";
         
?>
<!doctype html>
<html>
<head>
  <?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>

<body>

<?php

require_once "page-header.php";
session_regenerate_id(true);
if (isset($_SESSION['username'])){
  echo $_SESSION['username'];
}
?>

                      
<div class='container'>
    <div class='row'>
    <?php if (!isset($_GET['retry'])){
              $_SESSION['a'] = 1; 
            }else{
              $_SESSION['a']++;

      echo '
    
        <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          <h2>No user was found with those credentials, please try again!</h2>
        </div>';
      }
     
        ?>

        <div class='col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 panel panel-primary'>   

            <h2 class="text-center">Login</h2>
            <div class="col-sm-10 col-sm-offset-1">
                <form role='form' action='/resources/login.action.php' method='GET'>
                    <div class='form-group'>
                        <label for='username' class="pull-left">User Name</label>
                                      
                        <input type='text' class='form-control' name='username' tabindex="1" autofocus required="required" />
                    </div>
                                      
                    <div class='form-group'>
                        <label for='password' class="pull-left">Password</label>
                                      
                        <input type='password' class='form-control' name='password' tabindex="2" required="required" />
                    </div>
              <!--      Remember Me?: <input type="checkbox" name="autologin"><br />
              -->

                  <?php 
                  if ($_SESSION['a'] > 2) {
                    ?>
                    <br><br>
                    <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                    <input class="col-sm-12" type="text" name="captcha_code" tabindex="3" required="required" />

                      <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false"><img src="securimage/images/refresh.png" alt="refresh"></a>
                      <br><br><br><br>
                      <?php
                       }
                       ?>
                       <input type="hidden" name="ua" value="<?php echo $_SERVER['HTTP_USER_AGENT'] ?> ">
                       <input type="hidden" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR'] ?> ">
                      
                    <input type='submit' name='submit' class='btn btn-default btn-primary btn-block' tabindex="4" value='Login!'/><br>
              
                    <!-- ***********************************************************************
                        The value of this field is where the page will redirect to after
                        successful login
                    ***********************************************************************
                    -->
                    
                    
                <a href="forgot-password.php" >I forgot my password</a>
                </form><hr>
                <a href="../index.php" class="col-xs-4 btn btn-danger">Cancel</a><br><br><br>
                
            </div>
        </div>
    </div><!-- end row -->  
<div> <!-- end container -->
                      
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
</script>

</html>