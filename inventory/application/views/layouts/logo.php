<div class="navbar-inner">
    <div class="container-fluid"> <a href="<?php echo base_url();?>items" class="brand"> <img src="<?php echo base_url();?>assets/images/new_logo.png" style="  max-width: 70% !important;"/> </a><!--/.brand-->
      
      <ul class="nav ace-nav pull-right">
        <li class="light-blue user-profile"> <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle"> <img class="nav-user-photo" src="<?php echo base_url();?>assets/avatars/avatar2.png" alt="Jason's Photo" /> <span id="user_info"> <small>You are logged in as</small> <strong><?php echo ($this->session->userdata('session_username')) ? ucfirst($this->session->userdata('session_username')) : 'Admin'; ?></strong> </span> <i class="icon-caret-down"></i> </a>
        
          <ul class="pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer" id="user_menu">
            <!--<li> <a href="<?php echo base_url();?>admin/setting"> <i class="icon-cog"></i> Edit Profile </a> </li>-->
            <li> <a href="<?php echo base_url();?>setting/change_password"> <i class="icon-key"></i> Change Password </a> </li>
            <li class="divider"></li>
            <li> <a href="<?php echo base_url();?>setting/logout"> <i class="icon-off"></i> Logout </a> </li>
          </ul>
        </li>
      </ul>
      <!--/.ace-nav--> 
    </div>
    <!--/.container-fluid--> 
  </div>
