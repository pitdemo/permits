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

<style type="text/css">
	

.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}

</style>   
<?php
$controller=$this->router->fetch_class();
$method=$this->router->fetch_method();
	#UPDATE `formwork15aug`.`users` SET `email_address` = 'ananthakumar7@gmail.com' WHERE `users`.`id` = 198;
	$segment=$this->uri->segment_array();
	
	$eip_checklists_active=$permits_time_calc_active=$loto_time_calc_active=$time_calc_active=$open_permits_active=$permits_active=$reports_active=$day_wise_active=$department_wise_active=$zone_wise_active=$name_wise_active=$jobs_isolations_active=$isolation_active=$isolation_type1=$isolation_type2=$myjobs_active=$users_active=$departments_active=$jobs_active=$zones_active=$users_active=$day_in_process_active=$contractors_active=$dashboard_active=$closed_permits_active=$electrical_permits_active=$confined_permits_active=$reports_active=$sops_active=$eip_active=$backup_active='';

    
	if($controller=='dashboard' && ($method=='index'))
	$dashboard_active='active_menu';
	else if($controller=='departments' && ($method=='form' || $method=='index'))
	$departments_active='active_menu';
	if($controller=='departments' && ($method=='users' || $method=='user_form'))
	$users_active='active_menu';
	else if($controller=='jobs' && ($method=='form' || $method=='index' || $method=='users'))
	$jobs_active='active_menu';
	else if($controller=='jobs' && ($method=='jobs' || $method=='myjobs' || $method=='view'))
	$myjobs_active='active_menu';
	else if($controller=='jobs' && ($method=='day_in_process' || $method=='time_form'))
	$day_in_process_active='active_menu';
	else if($controller=='jobs' && ($method=='closed_permits'))
	$closed_permits_active='active_menu';
	else if($controller=='zones' && ($method=='form' || $method=='index' || $method=='users'))
	$zones_active='active_menu';
	else if($controller=='contractors' && ($method=='form' || $method=='index'))
	$contractors_active='active_menu';
	else if($controller=='jobs_isolations')
	$jobs_isolations_active='active_menu';
	else if($controller=='isolations')
		$isolation_active='active_menu';
    else if($controller=='eip_checklists')
        $eip_checklists_active='active_menu';
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
    else if($controller=='reports')
    	$reports_active='active_menu';
    else if($controller=='sops')
        $sops_active='active_menu';
    else if($controller=='eips')
        $eip_active='active_menu';
    else if($controller=='backup')
        $backup_active='active_menu';
	
	$readonly=(isset($readonly)) ? $readonly : '';
	
	if($readonly=='hide')
	{
		$day_in_process_active='active_menu';	
		
		$myjobs_active=$jobs_active='';
	}
	
?>  
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
                    
          <li class="user user-menu <?php echo $zones_active; ?>"><a href="<?php echo base_url();?>zones">Zones</a></li>
          <li class="user user-menu <?php echo $departments_active; ?>"><a href="<?php echo base_url();?>departments">Departments</a></li>
 		  <li class="dropdown user user-menu <?php echo $isolation_active; ?>">
            <a href="<?php echo base_url(); ?>isolations/index/type/description" class="dropdown-toggle" data-toggle="dropdown">
                <span>Isolations<i class="caret"></i></span></a>
          <ul class="dropdown-menu dropdown-custom dropdown-menu-right">                            
          <li class="<?php echo $isolation_type1; ?>"><a href="<?php echo base_url();?>isolations/index/type/description">Description</a></li>
          <li class="<?php echo $isolation_type2; ?>"><a href="<?php echo base_url();?>isolations/index/type/isolation_type">Isolation type</a></li>       
                                    </ul>
                                </li>          
        <li class="user user-menu <?php echo $users_active; ?>"><a href="<?php echo base_url();?>departments/users">Users</a></li> 
        <li class="user user-menu <?php echo $contractors_active; ?>"><a href="<?php echo base_url();?>contractors">Contractors</a></li>  
        <li class="user user-menu <?php echo $sops_active; ?>"><a href="<?php echo base_url();?>sops">SOP/WI</a></li>        
              
          <li class="user user-menu <?php echo $eip_checklists_active; ?>"><a href="<?php echo base_url();?>eip_checklists">Check Lists</a></li>      
          <li class="dropdown user user-menu <?php echo $reports_active; ?>">
            			 <a tabindex="-1" href="#"  class="dropdown-toggle" data-toggle="dropdown">
                		<span>Reports<i class="caret"></i></span>
                		</a>
			          <ul class="dropdown-menu dropdown-custom dropdown-menu-right reports_menu">         

			          	  <li class="dropdown-submenu"><a href="javascript:void(0);">Common</a>        
				          	  <ul class="dropdown-menu">           
					          <li ><a tabindex="-1"  href="<?php echo base_url();?>reports/department_wise">Departments</a>
		                      <li><a href="<?php echo base_url();?>reports/date_wise">Date Wise</a></li></ul></li>

				          <?php
				          	$this->permit_types = unserialize(PERMITS);

                            $m=1;

				          	foreach($this->permit_types as $permit_type => $permit_label)
				          	{

                                if($m==1)
                                {
                                    echo '<li class="dropdown-submenu"><a href="'.base_url().'reports/'.$permit_type.'_report">'.$permit_label.'</a>        
                                            <ul class="dropdown-menu">           
                                            <li ><a tabindex="-1"  href="'.base_url().'reports/jobs_category_wise">Category wise</a>
                                            </ul></li>';
                                }  
                                else
				          		echo '<li><a href="'.base_url().'reports/'.$permit_type.'_report">'.$permit_label.'</a></li>';

				          		#echo '  class="dropdown-submenu"<ul class="dropdown-menu"><li><a href="'.base_url().'reports/'.$permit_type.'_date_wise">Date Wise</a></li></ul></li>';

                                $m++;
				          	}
				          ?>		       
                     </ul>
          </li>      
			
		  <li class="user user-menu <?php echo $eip_active; ?>"><a href="<?php echo base_url();?>eips">EIPs</a></li>	
          <li class="user user-menu <?php echo $backup_active; ?>"><a href="<?php echo base_url();?>backup">Backup</a></li>
        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user"></i>
                                <span>Welcome <?php echo $this->session->userdata(ADMIN.'first_name'); ?> <i class="caret"></i></span>
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
?>
        
        
