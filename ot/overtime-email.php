<?php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
?>

<?php
//User::regenerate_session();

// full title to display on larger screens
$page_title = "Overtime Tracking - Overtime Report";
// shortened page title for mobile devices
$page_title_short = "Overtime Report";

$page_security = 1;

?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
	
</head>
<body>
	

<?php

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

/* **********************************
	for testing: using personal email
	switch back when deployed
*************************************
$m->Host = 'gator4209.hostgator.com';
//$m->Host = gethostbyname('tls://mail.njcad.info');
$m->Username = 'support@njcad.info';
$m->Password = "Njcad2820'";
$m->SMTPSecure = 'ssl';
$m->Port = 465;
*/

$m->From = 'support@njcad.info';
$m->FromName = 'NJCAD Web Administrator';

//$m->addAddress('fulltime@njcad.com');
$m->addAddress('astarmailtest@gmail.com');

$m->addAttachment($_SERVER['DOCUMENT_ROOT'].'/mandatory-overtime.pdf');

//$m->addCC('');
//$m->addBCC('');

$m->isHTML(true);


$m->Subject = 'Mandatory Overtime List';
$m->Body = '<p>The overtime list has been updated. Please refer to the attached copy.</p>
			<br>
			<p>Thank You,</p>
			<p>Management</p>';
$m->AltBody = '';


if($m->send()){	?>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3" style="margin-top: 60px;">
				<div class="alert alert-success">
					<h2 class="text-center">Successfully sent report</h2>
					<h3 class='text-center'>This window will automatically close in a few seconds</h3>
					<h3 class='text-center'>Or you may click the button below to continue now</h3>
				</div>
				<div>
					<button type="button" class='btn btn-danger col-xs-12 col-md-4 col-md-offset-4' onclick="window.open('', '_self', ''); window.close();">Close</button>
					
				</div>	
			</div>
		</div>
	</div>

	
<?php  
	
}else{
	echo $m->ErrorInfo;

}

?>
</body>
</html>
<script type="text/javascript">
	setTimeout("window.open('', '_self', ''); window.close();", 5000);


</script>