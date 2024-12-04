<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forget Password - mailer</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,300italic,300' rel='stylesheet' type='text/css'>
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
		</div> </div> 
  <br />
  <span style="line-height:22px;">
  Dear  <?php echo $first_name !='' ? $first_name:''; ?>  ,
  <br />
  </span>
  <br />
<br />
<span style="line-height:22px;">
A password reset request has been made for your user account at <?php echo "<a href='".base_url()."'> Accounting Software </a>"; ?>

<br />
</span>

<br />
 <span style="line-height:22px;">
Username :
<?php echo $username; ?>
<br />
</span>
<br />
<span style="line-height:22px;">
Please click on the following link to reset your new password

<br />

<?php echo "<a href='".base_url().'login/reset_password/'.$id."'> ".base_url().'login/reset_password/'.$id." </a>"; ?>
<br />
</span>
<br />

<!--<span style="line-height:22px;">
Regards,
<br />
<br />
The <?php //echo "<a href='".base_url()."'> Accounting Software </a>"; ?> Team

</span>
<br />-->
<br />

</div>
</div>
  
  <div style="float:left; width:92%; background-color:#035489; padding:12px 4% 12px 4%; color:#fff; font-size:16px; -webkit-border-radius: 0px 0px 4px 4px; -moz-border-radius:0px 0px 4px 4px; -o-border-radius: 0px 0px 4px 4px; -ms-border-radius: 0px 0px 4px 4px; border-radius:0px 0px 4px 4px; ">
Cheers,<br />
<strong style="font-weight:600;"> Sri Radhika Agency</strong>

  </div>
  
  <div style="float:left; width:92%; padding:10px 4% 10px 4%; color:#666; font-size:14px; text-align:center; line-height:22px;">
Copy right © 2015 Sri Radhika Agency. All Rights Reserved.<br />


  </div>
  
  
  <div style="clear:both;"></div>
</div>




</body>
</html>
