<!DOCTYPE html>
<html>
<head>

 
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <link rel="stylesheet" href="css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
      <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>
      <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.validate.js"></script>

  <title>Index Page</title>

</head>
<body>

<?php 
session_start();
print_r($_SESSION);

?>


<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 panel panel-primary bg-custom page-header">
      <div class="col-sm-10 col-sm-offset-1">
        <h2 class="text-center">NJCAD Employee Portal</h2><br>
        
 <!--   <div class="col-sm-0 col-xs-0">
          <a class="text-left" href="pin.log.php"><h4><em>Narcotic Log</em></h4></a>
          
        </div>
 -->
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
        
               
        <img class="img-responsive" src="images/logo.png" alt="2016_Logo_njcad" style="opacity: 0.6;">
     
      </div>
    </div>
  </div>
</div>
    
</body>
</html>
