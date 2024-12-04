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
            $(".colorbox_inline").colorbox({ iframe:true,width:"480px",height:"306px"});
        })
        
          </script>
        <!--inline styles if any-->
	</head>

	<body>
		<div class="navbar navbar-inverse header-con">
  			<div class="navbar-inner">
    			<div class="row-fluid" style="text-align:center; margin-top:10px;"> <a href="<?php echo base_url('admin');?>"><img src="<?php echo base_url(); ?>assets/images/logo.png"/></a><!--/.brand-->       
		      	<!--/.ace-nav--> 
    			</div>
    			<!--/.container-fluid--> 
  			</div>
  			<!--/.navbar-inner--> 
		</div>
		<div class="row-fluid heading">Reset Password</div>
		<div class="container-fluid" id="main-container">
  			<div id="page-content" class="clearfix login-con">
    			<div class="row-fluid"> 
      			<!--PAGE CONTENT BEGINS HERE-->      
      				 <form class="form-horizontal" name="reset_password" id="reset_password" method="post">
              <div class="control-group">
                <label class="control-label" for="form-field-1">New password</label>
                <div class="controls">
                  <input type="password" value="<?php echo set_value('new_password'); ?>" id="new_password" name="new_password" placeholder="" />
                  <?php echo form_error('new_password'); ?>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="form-field-1">Retype password</label>
                <div class="controls">
                  <input type="password" value="<?php echo set_value('retype_password'); ?>" name="retype_password" id="retype_password" placeholder="" />
                  <?php echo form_error('retype_password'); ?>
                  
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <button class="btn btn-info" type="submit" name="change"> Change Now </button>
                  &nbsp; &nbsp; &nbsp;
                 
                </div>
              </div>
              
              <!--/row-->
              
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
          <div class="span12 text-center">&nbsp; Copyright &copy; <?php echo date('Y'); ?> Sri Radhika Agency</div>
        </div>
		<!--/.fluid-container#main-container--> 

		<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> 
		<!--basic scripts-->
        
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
                
				var validator = $("#reset_password").validate({
	
	onkeyup: false,
	errorClass:'error_msg',
	
	rules:
	{
		
		new_password:
		{
			 required:true,
			 minlength: 6
		},
		retype_password:
		{
			 required:true,
			 equalTo: "#new_password"
		}
	
	
	
	
	
	},
	messages:
	{
		
		new_password:
		{
			required: "The new password field is required",
			minlength: jQuery.format("The password field must be at least {0} characters in length.")
		},
		retype_password:
		{
			required: "The confirm password field is required",
			equalTo: "Confirm password should be same as new password."
		},
		debug:true
	},
	errorPlacement: function(error, element)
	{
		error.appendTo(element.parent());
	},
	submitHandler: function()
	{
		//$("#enabled_js").val("1");
		document.reset_password.submit();
	},
	
	wrapper: "div"
	
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
