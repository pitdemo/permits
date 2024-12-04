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
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui-1.10.3.custom.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/chosen.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-timepicker.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/daterangepicker.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colorpicker.css" />
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
            $(".colorbox_inline").colorbox({ iframe:true,width:"480px",height:"306px",scrolling: "false"});
        })
        
          </script>
          
          <script src="<?php echo base_url();?>js/jquery-1.10.2.min.js"></script> 
		 <script src="<?php echo base_url();?>js/jquery.colorbox-min.js"></script>
         <link href="<?php echo base_url();?>css/colorbox.css" rel="stylesheet" />
		<script> window.setTimeout(function() {
											   parent.$.colorbox.close();
												}, 2000); </script>
 <style type="text/css">
			.error_msg {
				text-align:left;
			}
			.login-con .form-horizontal .control-label {
				vertical-align:top;
			}
		</style>
        <!--inline styles if any-->
	</head>



<body>
<!--<form action="" method="post" id="forgot_password" name="forgot_password">
<section id="forgot">
<section id="popup">
<h1>Forgot Password</h1>
  <input type="hidden" name="login_as" id="login_as" value="admin">
<aside class="row"><font class="lable">Username</font><input name="email_id" id="email_id" type="text" value="<?php echo set_value('email_id'); ?>" placeholder="Enter your username"/>
 <?php echo form_error('email_id'); ?>
 <?php if($this->session->flashdata('forget_email_check') !=''){?><div for="password" generated="true" class="error_msg" style="display: block;"><?php echo $this->session->flashdata('forget_email_check');?></div> <?php } ?>	
</aside>
<aside ><button class="btn btn-info" type="submit" name="login" >Submit</button></aside>
</section>
</section>
</form>
-->
<div class="row-fluid heading">Forgot Password</div>
<div class="container-fluid" id="main-container">
        
  			<div id="page-content" class="clearfix login-con">
    			<div class="row-fluid"> 
      			<!--PAGE CONTENT BEGINS HERE-->      
      				 <form class="form-horizontal" method="post" id="forgot_password" name="forgot_password">
              <div class="control-group">
               <h1>Reset password link sent to Admin.</h1>
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
</body>
