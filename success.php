<!-- success.html -->

<!DOCTYPE html>
<html>
<head>
	<title>Success!</title>
	<style type="text/css">
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

	</style>
</head>
<body>
<div class="popOver" style="width: 100%; text-align: center">
	
	
	<h1>Success!</h1>
</div>
<?php 

if (isset($_GET['redirect'])) {
	$redirect = $_GET['redirect'];
	switch ($redirect) {
		case 'user-add':
			header( "refresh:2; url=/admin/user/add-user.php" ); 
			break;

		case 'access-add':
			header( "refresh:2; url=admin/site-maintenance/manage-list-fields/access/add-access.php" ); 
			break;

		case 'assignment-add':
			header( "refresh:1; url=admin/site-maintenance/manage-list-fields/assignment/add-assignment.php" ); 
			break;

		case 'access-edit':
			header( "refresh:2; url=admin/site-maintenance/manage-list-fields/access/edit-access.php" ); 
			break;

		case 'assignment-edit':
			header( "refresh:2; url=admin/site-maintenance/manage-list-fields/assignment/edit-assignment.php" ); 
			break;

		case 'changePassword':
			header( "refresh:2; url=index.html" ); 
			break;

		case 'deletePassword':
			header( "refresh:2; url=http://localhost/admin/userMaintenance/deleteUser.php" );
			break;

		case 'forgot-password':
			header( "refresh:2; url=http://localhost/index.html" );
			break;

		case 'delete-assignment':
			header( "refresh:2; url=/admin/site-maintenance/manage-list-fields/assignment/delete-assignment.php" );
			break;

		case 'delete-accesslvl':
			header( "refresh:2; url=admin/site-maintenance/manage-list-fields/access/delete-access.php" );
			break;

		case 'user-edit':
			header( "refresh:2; url=admin/user/edit-user.php" );
			break;

		case 'user-delete':
			header( "refresh:2; url=/admin/user/delete-user.php" );
			break;
			

		default:
			header( "refresh:2; url=/admin-menu.php" ); 
			break;
	}
}

?>
</body>
</html>