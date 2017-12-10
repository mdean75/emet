<?php //adminHeader.php

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');
//require_once "resources/functions.php";



// if authenticated session, regenerate the session and include the menu
if ($page_security != 0) {

  //User::regenerate_session();
  // include mobile menu code from external file mmenu.php
  require_once ($_SERVER['DOCUMENT_ROOT'].'/mmenu.php');
}

?>




<nav class="well well-sm nav-well">
  	<div class="container-fluid">
  		<div class="row">
  			<div class="col-xs-2">
    			<br>
        		<!--<input type="image" src="/images/icons/logo.png" name="image" height="64" width="64" onclick='window.history.go(-1); return false;''>-->
            <a href="/home.php"><input type="image" src="/images/icons/logo.png" name="image" height="64" width="64" ></a>
        		<br>
        		<p class="col-xs-2">Home</p>
      	</div>
      	<div class="col-xs-7">
              <br>
      		<h1 class="hidden-xs col-sm-10 col-sm-offset-1 text-center"><?php echo $page_title; ?></h1>
    			<h1 class="visible-xs-block col-xs-12 text-center"><?php echo $page_title_short; ?></h1>
        </div>
        <div class="col-xs-3">
            <?php
            if (isset($_SESSION['last_activity_time'])){ ?>
            <p class="text-right">Logged in as: <?php echo $_SESSION['username']; ?> </p>
           <br>
            <a href="/logout.php"><button class="navbar-btn pull-right"><strong>Logout</strong></button></a>
            <?php } else{ ?>
            <br><br>
            <a href="/oop.login.php"><button class="navbar-btn pull-right"><strong>Login</strong></button></a>
            <?php } ?>

      				<br>
      	</div>
          
  		</div>
  	</div>
  
  
</nav>