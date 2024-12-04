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
            <a href="<?php echo base_url();?>customer_payments">Manage Payments</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Edit Payment Details</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative">
            <h1>Edit Payment Details</h1>
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form class="form-horizontal" action="" method="post" name="payment_form" id="payment_form">
            <div class="control-group">
      								<label class="control-label" for="form-field-1">Supplier/Customer<sup>*</sup></label>
                <div class="controls">
                    <select name="user_id" id="user_id" style="width:220px">
                       <?php
                            // display both customers and suppliers based on optgroup
                        if(!empty($suppliers))
                        {
                            echo "<optgroup label='Suppliers'>";
                            foreach($suppliers as $supplier)
                            {
                                $selected_opt='';
                                if($payment_details['user_type']=='supplier') // set selected option code based on user type
                                {
                                    if($payment_details['user_id']==$supplier['id'])
                                        $selected_opt = "selected='selected'";
                                } // end
                        ?>
                           <option value="<?php echo $supplier['id']; ?>-s" <?php echo $selected_opt; ?>><?php echo ucfirst($supplier['supplier_name']); ?></option>
                        <?php
                            }
                            echo "</optgroup>";
                        }
    
                        ?>
                        <?php
                        if(!empty($customers))
                        {
                            echo "<optgroup label='Customers'>";
                            foreach($customers as $customer)
                            {
                                $selected_opt='';
                                if($payment_details['user_type']=='customer') // set selected option code based on user type
                                {
                                    if($payment_details['user_id']==$customer['id'])
                                        $selected_opt = "selected='selected'";
                                } // end
                                 
                        ?>
                           <option value="<?php echo $customer['id']; ?>-c" <?php echo $selected_opt; ?>><?php echo ucfirst($customer['customer_name']); ?></option>
                        <?php
                            }
                            echo "</optgroup>";
                        }
    
                        ?>
                    </select>   													
                    <?php echo form_error('user_id');?>
                </div>
            </div>
            
          
            <div class="control-group">
      		    <label class="control-label" for="form-field-1">Payment date<sup>*</sup></label>
                <div class="controls">
				   <input type="text"  name="payment_date" id="payment_date" class="payment_entry_date" placeholder="Payment date" value="<?php echo set_value('payment_date',isset($payment_details['payment_date'])? $payment_details['payment_date'] : ''); ?>" >
                    <?php echo form_error('payment_date');?>
                </div>
            </div>
            
            <div class="control-group">
      		    <label class="control-label" for="form-field-1">Amount<sup>*</sup></label>
                <div class="controls">
				   <input type="text"  name="amount" id="amount" class="amount_box" placeholder="Amount" value="<?php echo set_value('amount',isset($payment_details['amount'])? $payment_details['amount'] : ''); ?>" >
                    <?php echo form_error('amount');?>
                </div>
            </div>
            
      <div class="control-group">
        <div class="controls">       
      <button type="submit" name="add" class="btn btn-info" > Update <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
      <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>customer_payments'"> Cancel </button>
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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/jquery.datetimepicker.css"/>
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script>
		<script type="text/javascript">
				$(document).ready(function(){
                   
                    $('select').select2(); // select box select2 plugin
                    
                    // date picker for payment date
                    $('.payment_entry_date').datetimepicker(
                        {
	                       format:'Y-m-d',
	                       //minDate : 0,
                          timepicker:false
                        });	
                    
                   
                        //end
                   // amount conversion script code
                        $(".amount_box").blur(function(){
                          res =  accounting.formatMoney($(this).val(),'');
                          $(this).val(res);
                        });
                    //end	
                    // form validation start
					var validator = $("#payment_form").validate({
					errorClass:'error-val',
					ignore: "",
						rules:
					{
							user_id:
							{
								required:true
							},
                            payment_date:
                            {
                                required:true,
                            },
                           
                            
                            
					},
					messages:
					{
						user_id:
						{
							required: 'Please choose customer name or supplier name'
						},
                        payment_date:
                        {
                            required:'Please choose payment date',
                        },
                      
					},
					errorPlacement: function(error, element)
					{						
						error.insertAfter(element);						
					},
					submitHandler: function()
					{
						document.payment_form.submit();
						$('button[type=submit], input[type=submit]').attr('disabled',true);
					},
						wrapper: "div"
					});
				});
		
		</script>
 </body>
</html>
