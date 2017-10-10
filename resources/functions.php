<?php //functions.php

/*function canary(){
 // session_start(); 
	if (!isset($_SESSION['canary'])){
		header("location: /oop.login.php");
	}elseif ($_SESSION['canary'] < time() - 300) {
			session_regenerate_id(true);
			$_SESSION['canary'] = time();
		}
	}*/

function restrictToAdmin(){
 // session_start(); 
  if (isset($_SESSION['accesslvl'])){
    if (($_SESSION['accesslvl']) < 8){
      echo '
        <br>
        <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          <h2>Error: You do not have the correct permissions to view this page!</h2>
        </div>';
      
      die;
    }
  }
}
    
   

function footer() {
  echo '
  <div class="text-center navbar navbar-default navbar-fixed-bottom" >
    <br>
    <small class="text-center">&copy 2017 Designed by DeAngelo</small>
</div>';
}


/*  -----------------------------------
    Random string generator 
    ---------------------------------*/

function generateRandomString($length) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

/*  --------------------------------------
    send email to new user with token to 
    reset password
    --------------------------------------*/

function newAccountSendMail($user, $token, $email) {
  require_once('vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
  $m = new PHPMailer;

$m->isSMTP();
$m->SMTPAuth = true;
$m->SMTPDebug = 0;

$m->Host = 'smtp.gmail.com';
//$m->Host = gethostbyname('tls://mail.njcad.info');
$m->Username = 'deangelomp@gmail.com';
$m->Password = "Elijah518";
$m->SMTPSecure = 'ssl';
$m->Port = 465;

$m->From = 'support@njcad.info';
$m->FromName = 'NJCAD Web Administrator';

$m->addAddress($email);
$m->isHTML(true);


$m->Subject = 'New user account created';
$m->Body = '<p>You have been assigned a new user account on the NJCAD Web Portal.  </p>
      <p>User: <strong>'.$user.'</strong></p>
      <p>Click on this link or copy and paste it into your broswer to activate your account and choose a password.  This is a one time use link and will also expire in 24 hours.  <strong>http://'.$_SERVER['HTTP_HOST'].'/reset-password.php?token='.$token.'</strong></p>
      <p>If you do not use this link before it expires you will need to reset your password through the following link. <strong>http://'.$_SERVER['HTTP_HOST'].'/forgot-password.php</strong></p>
      <br>
      <p>Thank You,</p>
      <p>Management</p>';
$m->AltBody = '';
if($m->send()){ 

  //echo "success";
}else{
  echo $m->ErrorInfo;

 }
}

function forgotPasswordSendMail($user, $token, $email) {
  require_once('vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
  $m = new PHPMailer;

$m->isSMTP();
$m->SMTPAuth = true;
$m->SMTPDebug = 0;

$m->Host = 'smtp.gmail.com';
//$m->Host = gethostbyname('tls://mail.njcad.info');
$m->Username = 'deangelomp@gmail.com';
$m->Password = "Elijah518";
$m->SMTPSecure = 'ssl';
$m->Port = 465;

$m->From = 'support@njcad.info';
$m->FromName = 'NJCAD Web Administrator';

$m->addAddress($email);
$m->isHTML(true);


$m->Subject = 'Password reset requested';
$m->Body = '<p>We have received a password reset request for you.  If you did not initiate this request, please contact your administrator immediately.  </p>
      
      <p>To complete this request and choose a new password, click on this link or copy and paste it into your broswer.  This is a one time use link and will also expire in 24 hours.  <strong>http://'.$_SERVER['HTTP_HOST'].'/reset-password.php?token='.$token.'</strong></p>
      <p>If you do not use this link before it expires you will need to reset your password through the following link. <strong>http://'.$_SERVER['HTTP_HOST'].'/forgot-password.php</strong></p>
      <br>
      <p>Thank You,</p>
      <p>Management</p>';
$m->AltBody = '';
if($m->send()){ 

  //echo "success";
}else{
  echo $m->ErrorInfo;

 }
}

function shiftReportSendMail($name, $email, $jeffco_1, $jeffco_2, $unit_6817_1, $unit_6817_2, $unit_6827_1, $unit_6827_2, $unit_6837_1, $unit_6837_2, $unit_6847_1, $unit_6847_2, $duties_1, $duties_2, $other, $training, $pr) {
  require_once('../resources/vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
  $m = new PHPMailer;

$m->isSMTP();
$m->SMTPAuth = true;
$m->SMTPDebug = 0;

$m->Host = 'smtp.gmail.com';
//$m->Host = gethostbyname('tls://mail.njcad.info');
$m->Username = 'deangelomp@gmail.com';
$m->Password = "Elijah518";
$m->SMTPSecure = 'tls';
$m->Port = 587;

$m->AddReplyTo($email, $name);

$m->setFrom('from@example.com', 'Shift Report');
$m->From = 'mdeangelo@njcad.com';
$m->FromName = 'Michael DeAngelo';

$m->addAddress('mdeangelo@njcad.com');
$m->isHTML(true);


$m->Subject = 'Shift report for '.date("n/j/y");

$m->Body = "<p>Prepared by: $name  </p><br>
      <h3>Day 1</h3>
      <p>Jeffco dispatcher contacted: $jeffco_1</p>
      <p>6817 Crew: $unit_6817_1</p>
      <p>6827 Crew: $unit_6827_1</p>
      <p>6837 Crew: $unit_6837_1</p>
      <p>6847 Crew: $unit_6847_1</p>
      

      <h3>Day 2</h3>
      <p>Jeffco dispatcher contacted: $jeffco_2</p>
      <p>6817 Crew: $unit_6817_2</p>
      <p>6827 Crew: $unit_6827_2</p>
      <p>6837 Crew: $unit_6837_2</p>
      <p>6847 Crew: $unit_6847_2</p><br><br>

      <h3>Additional Items</h3>
      <p>Extra duties performed at station 1: $duties_1</p>
      <p>Extra duties performed at station 2: $duties_2</p>
      <p>Training and/or meetings attended: $training</p>
      <p>PR event attended: $pr</p><br>

      <h3>Other items to report or pass along </h3>
      <p>$other</p>
      ";
$m->AltBody = '';
if($m->send()){ 
  
  //echo "success";
}else{
  echo $m->ErrorInfo;

 }
}

function shiftReportSendMail24($name, $email, $jeffco_1, $unit_6817_1, $unit_6827_1, $unit_6837_1, $unit_6847_1, $duties_1, $duties_2, $other, $training, $pr) {
  require_once('../resources/vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
  $m = new PHPMailer;

$m->isSMTP();
$m->SMTPAuth = true;
$m->SMTPDebug = 0;

$m->Host = 'smtp.gmail.com';
//$m->Host = gethostbyname('tls://mail.njcad.info');
$m->Username = 'deangelomp@gmail.com';
$m->Password = "Elijah518";
$m->SMTPSecure = 'tls';
$m->Port = 587;

$m->AddReplyTo($email, $name);

$m->setFrom('from@example.com', 'Your Name');
$m->From = 'mdeangelo@njcad.com';
$m->FromName = 'Michael DeAngelo';

$m->addAddress('deangelomp@gmail.com');
$m->isHTML(true);


$m->Subject = 'Shift report for '.date("n/j/y");

$m->Body = "<p>Prepared by: $name  </p><br>
      <h3>Day 1</h3>
      <p>Jeffco dispatcher contacted: $jeffco_1</p>
      <p>6817 Crew: $unit_6817_1</p>
      <p>6827 Crew: $unit_6827_1</p>
      <p>6837 Crew: $unit_6837_1</p>
      <p>6847 Crew: $unit_6847_1</p>

      <h3>Additional Items</h3>
      <p>Extra duties performed at station 1: $duties_1</p>
      <p>Extra duties performed at station 2: $duties_2</p>
      <p>Training and/or meetings attended: $training</p>
      <p>PR event attended: $pr</p><br>

      <h3>Other items to report or pass along </h3>
      <p>$other</p>
      ";
$m->AltBody = '';
if($m->send()){ 
  $message = "Prepared by: $name \r\n  
      Day 1

      Jeffco dispatcher contacted: $jeffco_1

      6817 Crew: $unit_6817_1
      6827 Crew: $unit_6827_1
      6837 Crew: $unit_6837_1
      6847 Crew: $unit_6847_1

      Additional Items
      Extra duties performed at station 1: $duties_1
      Extra duties performed at station 2: $duties_2
      Training and/or meetings attended: $training
      PR event attended: $pr

      Other items to report or pass along 
      $other \r\n \r\n
      ";
  return $message;
  //echo "success";
}else{
  echo $m->ErrorInfo;

 }
}

function my_session_start() {
    session_start();
    if (isset($_SESSION['destroyed'])) {
       if ($_SESSION['destroyed'] < time()-300) {
           // Should not happen usually. This could be attack or due to unstable network.
           // Remove all authentication status of this users session.
           remove_all_authentication_flag_from_active_sessions($_SESSION['userid']);
           throw(new DestroyedSessionAccessException);
       }
       if (isset($_SESSION['new_session_id'])) {
           // Not fully expired yet. Could be lost cookie by unstable network.
           // Try again to set proper session ID cookie.
           // NOTE: Do not try to set session ID again if you would like to remove
           // authentication flag.
           session_commit();
           session_id($_SESSION['new_session_id']);
           // New session ID should exist
           session_start();
           return;
       }
   }
}


function my_session_regenerate_id() {
    // New session ID is required to set proper session ID
    // when session ID is not set due to unstable network.
    $new_session_id = session_create_id();
    $_SESSION['new_session_id'] = $new_session_id;
    
    // Set destroy timestamp
    $_SESSION['destroyed'] = time();
    
    // Write and close current session;
    session_commit();

    // Start session with new session ID
    session_id($new_session_id);
    ini_set('session.use_strict_mode', 0);
    session_start();
    ini_set('session.use_strict_mode', 1);
    
    // New session does not need them
    unset($_SESSION['destroyed']);
    unset($_SESSION['new_session_id']);
}

?>