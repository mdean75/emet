<?php  //success.html 
require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');
$page_title = "NJCAD.info Reset Password";
$page_title_short = "NJCAD Reset Password";

$page_security = 0;
?>

<!DOCTYPE html>
<html>
<head>
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
<!--	<style type="text/css">
		body {-webkit-transform:translateZ(0); /* Fix webkit flicker*/
			background-color: #c5d0e2;
		}

.popOver {
    height: 100%;
    width: 100%;
    position: fixed;
    background-color: #aaa;
    -webkit-animation: bummer 1.3s;
    animation: bummer 1.3s;
    -webkit-transform: scale(1,1); 
    transform: scale(1,1);
    -webkit-animation-fill-mode: forwards;
   
    animation-fill-mode: forwards; /* Add this so that your modal doesn't 
                                      close after the animation completes */
}

@-webkit-keyframes bummer {
	
    100% {
        -webkit-transform: scale(8,8); 

    }
}

@keyframes bummer {
	
    100% {
        transform: scale(8,8); 
    }
}

	</style>-->
	
	<script>
        function checkForRetry() {
            $('#retryModal').modal('show')
        } // end script

</script>
</head>
<body onload="checkForRetry()">
<div>
	
	
	<div class="modal" id="retryModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" >
              <button type="button" class="close text-right" data-dismiss="modal" aria-label="Close">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
              </button>
              <h1 class="modal-title" style="color:white;">Success!</h1>
              
            </div>
            <!-- <div class="modal-body">
              <h2 style="height: 30vh;">The action was successful</h2>
            </div>
            <div class="modal-footer">
              
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> -->
          </div>
        </div>
      </div>
</div>
<?php 

if (isset($_GET['redirect'])) {
	$redirect = $_GET['redirect'];
	switch ($redirect) {
		case 'user-add':
			utility::js_redirect('admin/user/', 'add-user.php', 'status-code', '3X01');
			break;

		case 'access-add':
			utility::js_redirect('admin/site-maintenance/manage-list-fields/access/', 'add-access.php', 'status-code', '3X01');
			break;

		case 'assignment-add':
			utility::js_redirect('admin/site-maintenance/manage-list-fields/assignment/', 'add-assignment.php', 'status-code', '3X01'); 
			break;

		case 'access-edit':
			utility::js_redirect('admin/site-maintenance/manage-list-fields/access/', 'edit-access.php', 'status-code', '3X01');
			break;

		case 'assignment-edit':
			utility::js_redirect('admin/site-maintenance/manage-list-fields/assignment/', 'edit-assignment.php', 'status-code', '3X01');
			break;

		case 'change-password':
			utility::js_redirect('', 'home.php', 'status-code', '3X01');
			break;

		case 'deletePassword':
			utility::js_redirect('admin/user/', 'delete-user.php', 'status-code', '3X01');
			break;

		case 'forgot-password':
			utility::js_redirect('', 'index.php', 'status-code', '3X01');
			break;

		case 'delete-assignment':
			utility::js_redirect('admin/site-maintenance/manage-list-fields/assignment/', 'delete-assignment.php', 'status-code', '3X01');
			break;

		case 'delete-accesslvl':
			utility::js_redirect('admin/site-maintenance/manage-list-fields/access/', 'delete-access.php', 'status-code', '3X01');
			break;

		case 'user-edit':
			utility::js_redirect('admin/user/', 'edit-user.php', 'status-code', '3X01');
			break;

		case 'user-delete':
			utility::js_redirect('admin/user/', 'delete-user.php', 'status-code', '3X01');
			break;
			

		default:
			header( "refresh:2; url=/admin-menu.php" ); 
			utility::js_redirect('', 'home.php', 'status-code', '3X01');
			break;
	}
}

?>
<script>
        function checkForRetry() {
            $('#retryModal').modal('show')
        } // end script

</script>

<script>
  $('#retryModal').on('hide.bs.modal', function (e) {
  window.replace();
})
</script>
</body>
</html>