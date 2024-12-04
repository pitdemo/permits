<?php $this->load->view('layouts/header');?>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
</script>
<body>
<div class="navbar navbar-inverse header-con">
    <?php $this->load->view('layouts/logo');?>
  <!--/.navbar-inner--> 
</div>
<div class="container-fluid" id="main-container"> <a id="menu-toggler" href="#"> <span></span> </a>
   <?php $this->load->view('layouts/menu');?>
  <div id="main-content" class="clearfix">
    <div id="breadcrumbs">
      <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url();?>customers">Manage Customers</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Create Customer</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative">
            <h1>Create Customer</h1>
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form class="form-horizontal" action="" method="post" name="customer_form" id="customer_form">
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Customer name<sup>*</sup></label>
                <div class="controls">
      													<input type="text" placeholder="Customer name" value="" name="customer_name" id="customer_name" >
                    <?php echo form_error('customer_name');?>
                </div>
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Email</label>
                <div class="controls">
      													<input type="text" placeholder="Email address" value="" name="email_id" id="email_id" >
                    <?php echo form_error('email_id');?>
                </div>
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Phone No.</label>
                <div class="controls">
      													<input type="text" placeholder="Phone no" value="" name="phone_no" id="phone_no" >
                    <?php echo form_error('phone_no');?>
                </div>
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Address</label>
                <div class="controls">
      													<textarea name="address" id="address" rows="5"></textarea>
                    <?php echo form_error('address');?>
                </div>
      								
            </div>
            
      <div class="control-group">
        <div class="controls">       
      <button type="submit" name="add" class="btn btn-info" > Create <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
      <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>customers'"> Cancel </button>
      </div>
      </div>
      <aside class="clear"></aside>
    </form>
            
            <!--PAGE CONTENT ENDS HERE--> 
          </div>
        </div>
        
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div><br/><br/>
       <?php $this->load->view('layouts/footer');?>
      <!--/row--> 
    </div>
    <!--/#page-content--> 
    
    <!--/#ace-settings-container--> 
  </div>
  <!--/#main-content--> 
</div>
<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> 
	<?php $this->load->view('layouts/footer_script');?> 
		<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery.validate.min.js'></script>
		<script type="text/javascript">
				$(document).ready(function(){
					
					var validator = $("#item_form").validate({
					errorClass:'error-val',
					ignore: "",
						rules:
					{
							item_name:
							{
								required:true
							},
							item_type:
							{
								required:true
							},
					},
					messages:
					{
						item_name:
						{
							required: 'Please enter item name'
						},
						item_type:
						{
							required: 'Please choose item type'
						},
					},
					
					errorPlacement: function(error, element)
					{						
						error.insertAfter(element);						
					},
					
					submitHandler: function()
					{
						document.item_form.submit();
						$('button[type=submit], input[type=submit]').attr('disabled',true);
					},
						wrapper: "div"
						
					});
					
				   
				});
		
		</script>
 </body>
</html>
