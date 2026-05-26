<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dalmia Cement</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="icon" href="<?php echo base_url(); ?>assets/img/logo.jpg" sizes="16x16" >
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url(); ?>assets/css/ionicons.min.css" rel="stylesheet" type="text/css" />

        <link href='<?php echo base_url(); ?>assets/css/lato.css' rel='stylesheet' type='text/css'>
        
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-table.css" type="text/css" rel="stylesheet">        
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo base_url(); ?>assets/css/jquery.gritter.css" type="text/css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/custom.css" type="text/css" rel="stylesheet">

        <script type="text/javascript">var base_url='<?php echo base_url(); ?>'; </script>   
        
        <script src="<?php echo base_url(); ?>assets/js/jquery.min2.0.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
            
    </head>
<?php
$controller=$this->router->fetch_class();
$method=$this->router->fetch_method();
	#UPDATE `formwork15aug`.`users` SET `email_address` = 'ananthakumar7@gmail.com' WHERE `users`.`id` = 198;
	$segment=$this->uri->segment_array();
	
	$permits_time_calc_active=$loto_time_calc_active=$time_calc_active=$open_permits_active=$permits_active=$reports_active=$day_wise_active=$department_wise_active=$zone_wise_active=$name_wise_active=$jobs_isolations_active=$isolation_active=$isolation_type1=$isolation_type2=$myjobs_active=$users_active=$departments_active=$jobs_active=$zones_active=$users_active=$day_in_process_active=$contractors_active=$dashboard_active=$closed_permits_active=$electrical_permits_active=$confined_permits_active=$utpumps_active=$my_permits_active=$excavation_permits_active='';

    
	if($controller=='dashboard' && ($method=='index'))
	$dashboard_active='active_menu';
	else if($controller=='departments' && ($method=='form' || $method=='index'))
	$departments_active='active_menu';
	if($controller=='departments' && ($method=='users' || $method=='user_form'))
	$users_active='active_menu';
	else if($controller=='jobs' && ($method=='form' || $method=='index' || $method=='users'))
	$jobs_active='active_menu';
	else if($controller=='jobs' && ($method=='jobs' || $method=='view'))
	$myjobs_active='active_menu';
	else if($controller=='jobs' && ($method=='day_in_process' || $method=='time_form'))
	$day_in_process_active='active_menu';
	else if($controller=='jobs' && ($method=='closed_permits'))
	$closed_permits_active='active_menu';
	else if($controller=='zones' && ($method=='form' || $method=='index' || $method=='users'))
	$zones_active='active_menu';
	else if($controller=='contractors' && ($method=='form' || $method=='index'))
	$contractors_active='active_menu';
	else if($controller=='jobs_isolations' && $method=='index')
	$jobs_isolations_active='active_menu';
	else if($controller=='isolations')
		$isolation_active='active_menu';
    else if($controller=='utpumps')
        $utpumps_active='active_menu';    
	else if($controller=='reports')
	{
			$reports_active='active_menu';
			if($method=='zone_wise')
			$zone_wise_active='active_menu';
			else if($method=='name_wise')
			$name_wise_active='active_menu';
			else if($method=='department_wise')
			$department_wise_active='active_menu';
			else if($method=='day_wise')
			$day_wise_active='active_menu';
			else if($method=='open_permits')
			$open_permits_active='active_menu';
			else if($method=='permits_time_calc' || $method == 'loto_time_calc')
			{
				$time_calc_active='active_menu';
				
				if($method=='permits_time_calc')
				$permits_time_calc_active='active_menu';
				else
				$loto_time_calc_active='active_menu';
			}
	}
	else if($controller=='permits')
		$permits_active='active_menu';
    else if($controller=='electrical_permits')
        $electrical_permits_active='active_menu';
    else if($controller=='confined_permits')    
        $confined_permits_active='active_menu';
	else if($controller=='excavations')    
        $excavation_permits_active='active_menu';

	$readonly=(isset($readonly)) ? $readonly : '';
	
	if($readonly=='hide' && $controller=='jobs')
	{
		$day_in_process_active='active_menu';	
		
		$myjobs_active=$jobs_active='';
	}
	
	if($method=='myjobs' || $method=='show_all')
	{
		$my_permits_active='active_menu';

		$electrical_permits_active=$confined_permits_active=$utpumps_active=$jobs_active=$excavation_permits_active='';
	}

	if($method=='day_in_process')
	{
		$day_in_process_active='active_menu';

		$electrical_permits_active=$confined_permits_active=$utpumps_active=$jobs_active=$excavation_permits_active='';
	}

	if($method=='closed_permits')
	{
		$closed_permits_active='active_menu';

		$electrical_permits_active=$confined_permits_active=$utpumps_active=$jobs_active=$excavation_permits_active='';
	}
?>    
	
<style type="text/css">
.dropdown-menu.dropdown-custom>li>a:hover { color: white !important; }
</style>
    <body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="javascript:void(0);" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="<?php echo base_url(); ?>assets/img/logo.jpg" alt="Dalmia Cement" title="Dalmia Cement" />
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
               
                <div class="navbar-left">
                    <ul class="nav navbar-nav">
                    <?php
						if($this->session->userdata('is_default_password_changed') == 'yes') {  ?>			
        <!-- <li class="user user-menu <?php echo $dashboard_active; ?>"><a href="<?php echo base_url();?>dashboard">Dashboard</a></li> 
       	
       	<li class="user user-menu <?php echo $jobs_active; ?>"><a href="<?php echo base_url();?>jobs/myjobs">My Permits</a></li>-->

 		 <li class="dropdown user user-menu <?php echo $my_permits_active; ?>">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                <span>My Permits<i class="caret"></i></span></a>
          <ul class="dropdown-menu dropdown-custom dropdown-menu-right">    
          <li ><a href="<?php echo base_url();?>jobs/show_all/user_role/PA/">All Permits</a></li>                        
          <li ><a href="<?php echo base_url();?>jobs/myjobs/user_role/PA/">Combined</a></li>
          <li ><a href="<?php echo base_url();?>electrical_permits/myjobs/user_role/PA/">Electrical</a></li>     
          <li><a href="<?php echo base_url();?>confined_permits/myjobs/user_role/PA/">Confined</a></li>  
          <li ><a href="<?php echo base_url();?>utpumps/myjobs/user_role/PA/">UTP</a></li>
          <li ><a href="<?php echo base_url();?>excavations/myjobs/user_role/PA/">Excavation</a></li></ul></li> 

        <li class="user user-menu <?php echo $jobs_active; ?>"><a href="<?php echo base_url();?>jobs">Combined Work Permits</a></li>                
        <li class="user user-menu <?php echo $jobs_isolations_active; ?>"><a href="<?php echo base_url();?>jobs_isolations">EIP</a></li>
        
        <li class="user user-menu <?php echo $electrical_permits_active; ?>"><a href="<?php echo base_url();?>electrical_permits/myjobs">Electrical</a></li>        
        <li class="user user-menu <?php echo $confined_permits_active; ?>"><a href="<?php echo base_url();?>confined_permits">Confined</a></li>    
         <li class="user user-menu <?php echo $utpumps_active; ?>"><a href="<?php echo base_url();?>utpumps">UTPumps</a></li> 
         <li class="user user-menu <?php echo $excavation_permits_active; ?>"><a href="<?php echo base_url();?>excavations">Excavations</a></li> 

 		  <li class="dropdown user user-menu <?php echo $day_in_process_active; ?>">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                <span>Day End Process<i class="caret"></i></span></a>
          <ul class="dropdown-menu dropdown-custom dropdown-menu-right">                            
          <li ><a href="<?php echo base_url();?>jobs/day_in_process">Combined</a></li>
          <li ><a href="<?php echo base_url();?>electrical_permits/day_in_process">Electrical</a></li>     
          <li><a href="<?php echo base_url();?>confined_permits/day_in_process">Confined</a></li>  
          <li ><a href="<?php echo base_url();?>utpumps/day_in_process">UTP</a></li>
          <li ><a href="<?php echo base_url();?>excavations/day_in_process/">Excavation</a></li>
          <li ><a href="<?php echo base_url();?>jobs_isolations/day_in_process/">EIP</a></li>

          </ul></li> 



        

         <li class="dropdown user user-menu <?php echo $closed_permits_active; ?>">
            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                <span>Closed Permits<i class="caret"></i></span></a>
          <ul class="dropdown-menu dropdown-custom dropdown-menu-right">                            
          <li ><a href="<?php echo base_url();?>jobs/closed_permits">Combined</a></li>
          <li ><a href="<?php echo base_url();?>electrical_permits/closed_permits">Electrical</a></li>     
          <li><a href="<?php echo base_url();?>confined_permits/closed_permits">Confined</a></li>  
          <li ><a href="<?php echo base_url();?>utpumps/closed_permits">UTP</a></li>
          <li ><a href="<?php echo base_url();?>excavations/closed_permits/">Excavation</a></li></ul></li>


        <!-- waiting jobs -->
        <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope"></i>
                <span class="label label-danger" id="waiting_jobs_count"></span>
            </a>
            <ul class="dropdown-menu">
                <li class="header" id="waiting_jobs_list_header">No waiting jobs found</li>
                <li id="waiting_jobs_list">
                    
                </li>
            </ul>
        </li>
        <!-- approved jobs -->
        <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope"></i>
                <span class="label label-success" id="approved_jobs_count"></span>
            </a>
            <ul class="dropdown-menu">
                <li class="header" id="approved_jobs_list_header">No approved jobs found</li>
                <li id="approved_jobs_list">
                    
                </li>
            </ul>
        </li>
        <?php } ?>

        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user"></i>
                                <span>Welcome <?php echo $this->session->userdata('first_name'); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">                                
                                        <li ><a href="<?php echo base_url();?>users/change_password">Change Password</a></li>
        <li ><a href="<?php echo base_url();?>users/logout">Logout</a></li>

                    </ul>
                </div>
            </nav>
        </header>
<?php 

$popup_controllers = array('jobs');

$popup_methods = array('form');

if(@constant($this->session->userdata('user_role')) != SA )
{  ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jobs_count.js"></script>
	<span id="gritter_jobs_list" data-title="Success!" data-msg=''></span>
     <input type='hidden' id='gritter_trigger' name='gritter_trigger' value='1'> 
    <style type="text/css">
        div .gritter-item a
        {
            color:#fff !important;
            text-decoration: underline !important; 
        }
    </style> 
<?php } ?>
        
        
