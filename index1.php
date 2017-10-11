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


<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 panel panel-primary bg-custom page-header" style="padding-top: 10px; margin-bottom: 70px;">
      <div class="col-sm-10 col-sm-offset-1">
        <!-- <h2 class="text-center">NJCAD Employee Portal</h2><br> -->
        
 <!--   <div class="col-sm-0 col-xs-0">
          <a class="text-left" href="pin.log.php"><h4><em>Narcotic Log</em></h4></a>
          
        </div>
 -->
    <?php  if (isset($_SESSION['userid'])) {?>
        <div class="col-sm-offset-1 col-sm-3 col-xs-6">
          <a class="text-center" href="/admin-menu.php"><h4><em>Admin Menu</em></h4></a>
          
        </div>
        <div class="col-sm-2 col-xs-6">
          <a class="text-center" href="/filemanager.php"><h4><em>View Files</em></h4></a>
          
        </div>
        
        <div class="col-sm-1 col-xs-6">
          <a class="text-center" href="links.php"><h4><em>Links</em></h4></a>
          
        </div>
        <div class="col-sm-4 col-xs-6">
          <a class="text-center" href="overtime.php"><h4><em>Overtime Database</em></h4></a>
          <br><br>
        </div>
        <?php } ?>
               
        <img class="img-responsive" src="images/logo.png" alt="2016_Logo_njcad" style="opacity: 0.6;">
     
      </div>
    </div>
  </div>
</div>
    
<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>

</body>
</html>
