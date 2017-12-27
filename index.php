<?php
session_start();
// full title to display on larger screens
$page_title = "NJCAD Ambulance Service Tracking and Reporting";
// shortened page title for mobile devices
$page_title_short = "NJCAD ASTAR";

$page_security = 0;

?>

<!DOCTYPE html>
<html>
<head>

  <?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
</head>
<body>

<?php 

  require_once ($_SERVER['DOCUMENT_ROOT'].'/page-header.php');


?>


<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3 panel panel-primary bg-custom page-header" style="padding-top: 10px; margin-bottom: 70px;">
  <h1  class="text-center">Click Image To Login</h1>
      <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
        <!-- <h2 class="text-center">NJCAD Employee Portal</h2><br> -->
        
 <!--   <div class="col-sm-0 col-xs-0">
          <a class="text-left" href="pin.log.php"><h4><em>Narcotic Log</em></h4></a>
          
        </div>
 -->
    
               
        <a href="/oop.login.php"><img class="img-responsive" src="/images/icons/logo.png" alt="ems logo" style="margin: 0 auto; opacity: 0.6; padding: 20px;"></a>
     
      </div>
    </div>
  </div>
</div>
    
<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>

</body>
</html>