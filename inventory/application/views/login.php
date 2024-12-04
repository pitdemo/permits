<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8" />
        <title>Accounting Software</title>
        <meta name="description" content="Common form elements and layouts" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link id="page_favicon" href="<?php echo base_url(); ?>images/favicon.ico" rel="icon" type="image/x-icon" />
        <!--basic styles-->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" />
        
        <!--[if IE 7]>
                  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
                <![endif]-->
        
        <!--page specific plugin styles-->
       
        <!--fonts-->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
        <!--ace styles-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-skins.min.css" />
        <!--[if lte IE 8]>
                  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
                <![endif]-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />
        <script src="<?php echo base_url();?>js/jquery.min.v1.8.3.js"></script>
        <link href="<?php echo base_url();?>css/colorbox.css" rel="stylesheet" />
        <script src="<?php echo base_url();?>js/jquery.colorbox-min.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $(".colorbox_inline").colorbox({ iframe:true,width:"450px",height:"326px",scrolling: "false"});
        })
        
          </script>
        <!--inline styles if any-->
	</head>

	<body>
		<div class="navbar navbar-inverse header-con">
  			<div class="navbar-inner">
    			<div class="row-fluid" style="text-align:center; margin-top:10px;"> <a href="<?php echo base_url('admin');?>"><img src="<?php echo base_url(); ?>assets/images/new_logo.png"/></a><!--/.brand-->       
		      	<!--/.ace-nav--> 
    			</div>
    			<!--/.container-fluid--> 
  			</div>
  			<!--/.navbar-inner--> 
		</div>
		<div class="row-fluid heading">Login</div>
		<div class="container-fluid" id="main-container">
  			<div id="page-content" class="clearfix login-con">
             <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
    			<div class="row-fluid"> 
      			<!--PAGE CONTENT BEGINS HERE-->      
      				<form class="form-horizontal" id='login_form' name='login_form' method='post' action=''>
                        <input type="hidden" name="login_as" id="login_as" value="admin">
						<div class="control-group">
							<label class="control-label" id="role">Username</label>
							<div class="controls">
								<input type="text" id="username" name="username" placeholder="Username" value="<?php echo set_value('username');?>" />
                                <?php echo form_error('username'); ?>
							</div>                                
						</div>
						<div class="control-group">
							<label class="control-label">Password</label>
							<div class="controls">
								<input type="password" id="password" name="password" placeholder="Password" value="<?php echo set_value('password');?>" />
                                <?php echo form_error('password'); ?>									
								<?php if($this->session->flashdata('error') !=''){?><div for="password" generated="true" class="error_msg" style="display: block;"><?php echo $this->session->flashdata('error');?></div> <?php } ?>
                               																										
							</div>                                
						</div>
						<div class="form-actions">
                         <aside class="row chek" style="margin-top:20px;"> <a href="<?php echo base_url('login/forget_password');?>" class="colorbox_inline"> Forgot Password?</a></aside>

							<button class="btn btn-info" type="submit" style="margin-top:20px;" name="login" >Login</button>
							
						</div>
					</form>      
      			<!--PAGE CONTENT ENDS HERE--> 
    			</div>
    			<!--/row--> 
  			</div>
  			<!--/#page-content-->   
			<!--/#ace-settings-container--> 
		</div>
		<div class="clearfix"></div>
		<br/>
		<br/>
        <div class="footer row-fluid">
          <div class="span12 text-center">&nbsp; Copyright &copy; <?php echo date('Y'); ?> Accounting Software</div>
        </div>
		<!--/.fluid-container#main-container--> 

		<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> 
		<!--basic scripts-->
        
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
                $("#username").focus();
				var user_name = '';
				var validator = $("#login_form").validate({
																errorClass:'error_msg',
																rules:
																{
																	
																	username:
																	{
																		required: true,
																		email: function(element){
																			if($('#login_as').val() != 'admin')
																				return true;
																		}																		
																	},
																	password:
																	{
																		required: true																																				
																	}
																},
																messages:
																{
																	username:
																	{
																		
																		required: function(element){
																			if($('#login_as').val() == 'admin')
																			{
																				return "The Username field is required";
																			}
																			else
																			{
																				return "The Email field is required";
																			}
																		},
																		email: "Please enter valid email address."
																	},
																	password:
																	{
																		required: "The Password field is required."
																	}
																},
																errorPlacement: function(error, element)
																{
																	error.fadeIn(600).appendTo(element.parent());
																	
																},
																submitHandler: function()
																{
																	document.login_form.submit();
																},
																wrapper: ""
																
																});																																															
															});
			
		</script>
        <style type="text/css">
			.error_msg {
				text-align:left;
			}
			.login-con .form-horizontal .control-label {
				vertical-align:top;
			}
		</style>
	</body>
</html>
