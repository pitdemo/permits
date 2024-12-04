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
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>

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
             <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('forget_pwd_sent') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('forget_pwd_sent'):'';?></span><br></div>

  			<div id="page-content" class="clearfix login-con">
    			<div class="row-fluid"> 
      			<!--PAGE CONTENT BEGINS HERE-->      
      				 <form class="form-horizontal" method="post" id="forgot_password" name="forgot_password">
              <div class="control-group">
                <label class="control-label" for="form-field-1">Username</label>
                <div class="controls">
                  <input type="text" value="<?php echo set_value('email_id'); ?>" id="email_id" name="email_id" placeholder="" />
                  <?php echo form_error('email_id'); ?>
                   <?php if($this->session->flashdata('forget_email_check') !=''){?><div for="password" generated="true" class="error_msg" style="display: block;"><?php echo $this->session->flashdata('forget_email_check');?></div> <?php } ?>	
</aside>
                </div>
              </div>
              
              <div class="control-group">
                <div class="controls">
                 <button class="btn btn-info" type="submit" name="login" >Submit</button>
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
</body>
<script type="text/javascript">

$(document).ready(function(){
	//alert("test");
	var validator = $("#forgot_password").validate({
	errorClass:'error_msg',
	rules:
	{
		email_id:
		{
			required:true
			
		}
		
	},
	
	messages:
	{
		email_id:
		{
			required: 'Please Enter Your Username'
			
		}
		
	},
	
	errorPlacement: function(error, element)
	{
		//$('#derror').hide();
		/*var y = $('body').height();
    	parent.$.colorbox.resize({height:y+30});*/
		error.fadeIn(600).appendTo(element.parent());
	},
	
	submitHandler: function()
	{
		document.forgot_password.submit();
	},
		wrapper: ""
		
			
		
		/*errorElement:"span",
		errorClass:"login_errmsg_whitebg"*/
	});
	
	jQuery.validator.addMethod("specialChars", function( value, element ) 
	{
		return this.optional(element) || /^[a-zA-z0-9,\s_-]+$/.test(value);
	}, "Please avoid special characters");
	
	
	jQuery.validator.addMethod("password", function( value, element ) {
		return this.optional(element) || /^[a-zA-z0-9]+$/.test(value);
	}, "Avoid special characters");
		
	 /*$(document).on('click','#cancel',function(){
		   parent.$.colorbox.close();
	 });*/
	
	
});

</script>