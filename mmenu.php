<?php // mmenu.php

?>

<div id="myPage">
  <div class="container-fluid">
    <div class="row">
  <div class="col-sm-12" style="width: 100vw;background-color: #006bb3; padding: 0;">

    <button id="my-icon" class="hamburger hamburger--collapse col-sm-2" type="button"  style="padding-bottom: 0;">

    <span class="hamburger-box col-xs-2 col-sm-2">
      <span class="hamburger-inner" style="color: white;"></span>
    </span>
    <label class="col-sm-2 col-xs-2 text-right" for="#my-icon"><h4 style="color: white; padding-left: 10px; ">Menu</h4></label>
    </button>

<h2 class="col-sm-8 col-sm-offset-0 text-center hidden-xs" style="color: white;"><strong>A</strong><span style="color: silver;">mbulance</span> <strong>S</strong><span style="color: silver;">ervice</span> <strong>T</strong><span style="color: silver;">racking</span> <strong>A</strong><span style="color: silver;">nd</span> <strong>R</strong><span style="color: silver;">eporting</span></h2> 

  </div><!-- end div container -->
  
</div><!-- end div row -->
  </div> <!-- div style -->
  <!-- nav my-menu is for the mmenu off campus navigation -->
  
  <nav id="my-menu" class="mm-menu mm-offcanvas">
   <ul>
      <li><a href="/home.php">Home</a></li>
      <li><span>Admin</span>

        <ul>
            
          <li><a href="/admin-menu.php/">Admin Main Menu</a></li>
          <li><span>User Maintenance</span>
            <ul>
              <li><a href="/admin/user-maintenance.php">User Maintenance Menu</a></li>
              <li><a href="/admin/user/add-user.php">Add New User</a></li>
              <li><a href="/admin/user/edit-user.php">Edit User</a></li>
              <li><a href="/admin/user/delete-user.php">Delete User</a></li>
            </ul>    
          </li>
          <li><span>Site Maintenance</span>
            <ul>
              <li><a href="/admin/site-maintenance.php">Site Maintenance Menu</a>
                <ul>
                  <li><span>Manage List Fields</span>
                    <ul>
                      <li><span>Add Fields</span>
                        <ul>
                          <li><a href="/admin/site-maintenance/manage-list-fields/access/add-access.php">Add Access Level</a></li>
                          <li><a href="/admin/site-maintenance/manage-list-fields/assignment/add-assignment.php">Add Assignment</a></li>
                        </ul>
                      </li>
                      <li><span>Edit Fields</span>
                        <ul>
                          <li><a href="/admin/site-maintenance/manage-list-fields/access/edit-access.php">Edit Access Level</a></li>
                          <li><a href="/admin/site-maintenance/manage-list-fields/assignment/edit-assignment.php">Edit Assignment</a></li>
                        </ul>
                      </li>
                      <li><span>Delete Fields</span>
                        <ul>
                          <li><a href="/admin/site-maintenance/manage-list-fields/access/delete-access.php">Delete Access Level</a></li>
                          <li><a href="/admin/site-maintenance/manage-list-fields/assignment/delete-assignment.php">Delete Assignment</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                </ul>
              </li>
              
            </ul> 
          </li>
                      
        </ul>
      </li>
      <li><span>Profile</span>
        <ul>
          <li><a href="/change-password.php">Change Password</a></li>
          <li><a href="#">Edit Profile</a></li>
        </ul>
      </li>
      <li><a href="/logout.php">Logout</a></li>

   </ul>
  </nav>

