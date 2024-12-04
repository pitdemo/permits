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
            <a href="<?php echo base_url();?>sales">Manage Payments</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Edit Customer payments</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 

        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative">
            <h1>Edit Customer</h1>
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
          

            
            <form class="form-horizontal" action="" method="post" name="customer_form" id="customer_form">
            <div class="control-group">
      			<label class="control-label" for="form-field-1">Customer Name<sup>*</sup></label>
                <div class="controls">
      													<input type="text" placeholder="Customer name" value="<?php echo set_value('customer_name',$payment_details['customer_name']); ?>" name="customer_name" id="customer_name" >
                    <?php echo form_error('customer_name');?>
                </div>
      								
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Amount</label>
                <div class="controls">
      													<input type="text" placeholder="Amount" class='amount_box'  value="<?php echo set_value('amount',$payment_details['amount']); ?>"  name="amount" id="amount" >
                    <?php echo form_error('amount');?>
                </div>
            </div>
           <?php /*?> <div class="control-group">
      						<label class="control-label" for="form-field-1">Phone No.</label>
                <div class="controls">
      													<input type="text" placeholder="Phone no" value="<?php echo set_value('phone_no',$customer_details['phone_no']); ?>" name="phone_no" id="phone_no" >
                    <?php echo form_error('phone_no');?>
                </div>
            </div>
            <?php */?>
      <div class="control-group">
        <div class="controls">       
      <button type="submit" name="add" class="btn btn-info" > Update <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
      <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>sales'"> Cancel </button>
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

	<?php $this->load->view('layouts/footer_script');?> 
    <a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> 
    <script type="text/javascript" src="<?php echo base_url('js/jquery-1.11.0.min.js')?>"></script> 
<script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>

    <script type="text/javascript">
$(function(){

// amount conversion script code
	$(".amount_box").blur(function(){
	  res =  accounting.formatMoney($(this).val(),'');
	  $(this).val(res);
});
});
//end	
</script>

		<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery.validate.min.js'></script>
		<script type="text/javascript">
				$(document).ready(function(){
					
					var validator = $("#customer_form").validate({
					errorClass:'error-val',
					ignore: "",
						rules:
					{
							customer_name:
							{
								required:true
							},
							amount:
							{
								required:true
							},
							/*phone_no:
							{
								number:true,
								maxlength: 10,
							}*/
					},
					messages:
					{
						customer_name:
						{
							required: 'Please enter customer name'
						},
						amount:
						{
							required: 'Please enter valid amount'
						},
						/*phone_no:
							{
								number:"Please enter only numbers",
							},*/
					},
					
					errorPlacement: function(error, element)
					{						
						error.insertAfter(element);						
					},
					
					submitHandler: function()
					{
						document.customer_form.submit();
						$('button[type=submit], input[type=submit]').attr('disabled',true);
					},
						wrapper: "div"
						
					});
					
				   
				});
		
		</script>
 </body>
</html>
