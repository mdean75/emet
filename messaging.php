<?php // messaging.php
session_start();

require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/autoloader.php');

// mail configuration parameters for PHPMailer code
require_once("../mail-config.php");

User::regenerate_session(true);

$page_title = "NJCAD.info SMS Messaging";
$page_title_short = "NJCAD Messaging";
  
$page_security = 1;

utility::checkForLogin($_SERVER['PHP_SELF']);

utility::restrict_page_access($page_security, '', 'home.php', 'status-code', '3X99');

// process form if POST data is present
if ($_POST) {
    // define array used to store all message recipients
    $recipients = array();
    
    // if either users or group is present, proceed
    if ((isset($_POST['users'])) || (isset($_POST['group']))) {
        // process the users array
        if (isset($_POST['users'])) {
            // iterate over the users array to get the mobile number and carrier domain for each user id selected
            foreach ($_POST['users'] as $user) {
                try {
                    $sql = "SELECT users_profile.phone, carrier.carrierDomain 
                            FROM users_profile  
                            INNER JOIN carrier ON users_profile.carrierId = carrier.carrierId  
                            WHERE users_profile.userId = :userId";

                    $db = new database;
                    $db->query($sql);

                    $db->bind(':userId', $user);
                    $result = $db->fetchSingle();
                    
                    // concatenate phone and carrierDomain to build the send address and add to the array
                    $recipients[] = $result['phone'].$result['carrierDomain'];

                }catch (PDOException $e) {
                    error_log($e->StackTraceAsString);
                    $_SESSION['error'] = "An error occurred with the database. Contact the administrator if the problem persists.";
                    header('location: messaging.php');
                    die();
                } // end try catch

            } // end foreach
        }
        // process the group array
        if (isset($_POST['group'])) {
            // iterate over the group array to get all users assigned to that group that have a phone number in their record and select the mobile number and carrier domain for each corresponding user id
            foreach ($_POST['group'] as $sendGroup) {
                try{
                    $sql = "SELECT users_profile.phone, carrier.carrierDomain 
                            FROM groups 
                            INNER JOIN usersGroups ON usersGroups.groupId = groups.groupId 
                            INNER JOIN users_profile on users_profile.userid = usersGroups.userId 
                            INNER JOIN carrier on carrier.carrierId = users_profile.carrierId 
                            WHERE (groups.groupId = :id AND users_profile.phone > '')";

                    $db = new database;
                    $db->query($sql);

                    $db->bind(':id', $sendGroup);
                    $result = $db->resultset();
                    
                    
                    // iterate over each user returned in the group results and check if the send address has been added to the array.  If not in the array already concatenate phone and carrierDomain to build the send address and add to the array
                    foreach ($result as $row) {
                        if (!in_array($row['phone'].$row['carrierDomain'], $recipients)) {

                            $recipients[] = $row['phone'].$row['carrierDomain'];
                        } // end if
                        
                    } // end foreach
                   
                }catch (PDOException $e) {
                    error_log($e->StackTraceAsString);
                    $_SESSION['error'] = "An error occurred with the database. Contact the administrator if the problem persists.";
                    header('location: messaging.php');
                    die();
                } // end try catch

            } // end foreach post group
        } // end if isset post group
        
        // create the email message and send using PHPMailer
        require_once('resources/vendor/phpmailer/phpmailer/PHPMailerAutoload.php');

        $m = new PHPMailer;

        $m->isSMTP();
        $m->SMTPAuth = true;
        $m->SMTPDebug = 0;

        $m->Host = MAIL_HOST;
        $m->Username = MAIL_USER;
        $m->Password = MAIL_PASSWORD;
        $m->SMTPSecure = MAIL_SECURE;
        $m->Port = MAIL_PORT;

        $m->From = MAIL_FROM;
        $m->FromName = 'SMS Messaging';

        // iterate of the recipients array and add each address to the email recipients
        foreach ($recipients as $user) {
            $m->addAddress($user);
        }
        $m->isHTML(true);

        $m->Body = $_POST['message'];

        $m->AltBody = '';

        // set the successful send message and redirect to display
        if($m->send()){ 
            $_SESSION['success'] = "SMS Message successfully sent";
            header('location: messaging.php');
            die();
        }else{
            error_log($m->ErrorInfo);

        }


    } // end if isset($_POST)



   
    
    
} // end if ($_POST)
?>
<!doctype html>
<html>
<head>

  <?php require_once ($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>

</head>

<body>

<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/page-header.php');

?>
                    
<div class='container'>
    <div class='row'>
    <?php 
    // if session success is set display the message and clear the variable
    if (isset($_SESSION['success'])) { ?>
        

    
        <br>
        <div class="col-sm-6 col-sm-offset-3 text-center alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          <h2><?php echo $_SESSION['success'];
                    unset($_SESSION['success']);?></h2>
        </div>
        <?php 

        
        
        
    } // end if isset $_SESSION['success']

    // if session error is set display the error and clear the variable
    if (isset($_SESSION['error'])) { ?>
        

    
        <br>
        <div class="col-sm-6 col-sm-offset-3 text-center alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
          <h2><?php echo $_SESSION['error'];
                    unset($_SESSION['error']);?></h2>
        </div>
        <?php 

        
        
        
    } // end if isset $_SESSION['error']

      ?>
        <br>
        <div class='col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 panel panel-primary'>   

            <h2 class="text-center">Send SMS Message</h2><br>
            <div class="col-sm-10 col-sm-offset-1">
                <form role='form' method='POST'>
                    <div class="form-group">
                        <label>Select Group</label><br>


                        <?php 
                $sql = "SELECT * FROM groups ORDER BY groupName ASC";
                
                $db = new database();
                $db->query($sql);
                
                $results = $db->resultset(); ?>
                <div class="hidden-xs"> <?php
                foreach ($results as $group) { ?>
                    <label class="checkbox-inline"><input type="checkbox" name="group[]" value="<?php echo $group['groupId']; ?>"><?php echo $group['groupName']; ?></label> 
                

                <?php } ?>
                </div>

                <div class="visible-xs-block"> <?php
                    foreach ($results as $group) { ?>
                    <label class="checkbox-inline"><input type="checkbox" name="group[]" value="<?php echo $group['groupId']; ?>"><?php echo $group['groupName']; ?></label><br> 
                

                <?php } ?>
                </div>
                        
                    </div><hr>
                    <div class="form-group">
                        <label>Select Individuals (hold down control to select multiple)</label><br>
                        <select multiple class="form-control" name="users[]">

                            <?php 
                           
                            $sql = "SELECT users_profile.userid, users_profile.fname, users_profile.lname FROM users_profile WHERE users_profile.carrierId > '' ORDER BY users_profile.lname ASC";
                            $db = new database();
                            $db->query($sql);
                            
                           
                            $results = $db->resultset();

                            foreach ($results as $row){ ?>

                            <option value="<?php echo filter_var($row['userId'], FILTER_SANITIZE_NUMBER_INT); ?>"><?php echo filter_var($row['lname'], FILTER_SANITIZE_STRING). ", ". filter_var($row['fname'], FILTER_SANITIZE_STRING);?></option>
                        <?php } ?>
                            
                        </select>
                    </div><hr>
                    <div class='form-group'>
                        <label for='currentPassword' class="pull-left">Message</label><br>
                                      
                        <textarea name="message" rows="5" class="form-control" style="resize: none;"></textarea>
                    </div>
                                      
                    
              
                     <br>
                    

                    <button type="submit" class=" btn-hot text-capitalize submit btn btn-primary " name="submit" value="sendMsg">Send Message</button>
              
                                   
                </form>

                <br><br><br>
                
            </div>
        </div>
    </div><!-- end row -->  
<div> <!-- end container -->

<?php 
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.html');
?>
           
</body>

</html>