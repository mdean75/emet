<?php //test-modal.php
// full title to display on larger screens
$page_title = "Test Modal";
// shortened page title for mobile devices
$page_title_short = "Test Modal";

$page_security = 0;


?>

<!DOCTYPE html>
<html>
<head>
	<?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
</head>
<body>



	<div class="modal" id="confirmDelete">
        <div class="modal-dialog modal-sm" role="dialog">
          <div class="modal-content">
            <div class="modal-header" style="color:white; background-color: red;">
              <h1 class="modal-title">Retry</h1>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <h2 style="height: 30vh;">Incorrect credentials entered, please retry.</h2>
            </div>
            <div class="modal-footer">
              
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" class="action btn-hot text-capitalize submit btn" name="submit-delete" value="Delete Record"></input>
              <button class="btn btn-primary odom-submit">Save changes</button>
            </div>
          </div>
        </div>
    </div>

<script>
        
            $('#confirmDelete').modal('show')
        


        </script>
</body>
</html>


