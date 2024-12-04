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
            <a href="<?php echo base_url();?>receipts">Manage Receipts</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Edit Receipt Details</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative">
            <h1>Edit Receipt Details</h1>
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form class="form-horizontal" action="" method="post" name="receipt_form" id="receipt_form" enctype="multipart/form-data">
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
                                if($receipt_details['user_type']=='supplier') // set selected option code based on user type
                                {
                                    if($receipt_details['user_id']==$supplier['id'])
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
                                if($receipt_details['user_type']=='customer') // set selected option code based on user type
                                {
                                    if($receipt_details['user_id']==$customer['id'])
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
      		    <label class="control-label" for="form-field-1">Receipt date<sup>*</sup></label>
                <div class="controls">
				   <input type="text"  name="receipt_date" id="receipt_date" class="receipt_entry_date" placeholder="Receipt date" value="<?php echo set_value('receipt_date',isset($receipt_details['receipt_date'])? $receipt_details['receipt_date'] : ''); ?>" >
                    <?php echo form_error('receipt_date');?>
                </div>
            </div>
            <div class="control-group">
      		    <label class="control-label" for="form-field-1">Amount<sup>*</sup></label>
                <div class="controls">
				   <input type="text"  name="amount" id="amount" class="amount_box" placeholder="Amount" value="<?php echo set_value('amount',isset($receipt_details['amount'])? $receipt_details['amount'] : ''); ?>" >
                    <?php echo form_error('amount');?>
                </div>
            </div>
                <div class="control-group">
      		    <label class="control-label" for="form-field-1">Attachment</label>
                <div class="controls">
				   <input type="file"  name="attachment" id="attachment">
                    <?php echo form_error('attachment');?>
                    
                     
                </div><br>
                   <span style="margin-left:180px">
                       <?php if($receipt_details['attachment']!='') {?>
                    (OR) &nbsp;&nbsp;
                    <img src="<?php echo base_url(); ?>uploads/receipts/<?php echo $receipt_details['attachment']; ?>" width="100" height="100">
                    <?php } ?>
                    </span>
            </div>
            
      <div class="control-group">
        <div class="controls">       
      <button type="submit" name="add" class="btn btn-info" > Update <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
      <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>receipts'"> Cancel </button>
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
     <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/additional-methods.js'></script>
		<script type="text/javascript">
				$(document).ready(function(){
                   
                    $('select').select2(); // select box select2 plugin
                    
                    // date picker for purchase date
                    $('.receipt_entry_date').datetimepicker(
                        {
	                       format:'Y-m-d',
	                      // minDate : 0,
                          timepicker:false
                        });	
                   // amount conversion script code
                        $(".amount_box").blur(function(){
                          res =  accounting.formatMoney($(this).val(),'');
                          $(this).val(res);
                        });
                    //end	
                    // form validation start
					var validator = $("#receipt_form").validate({
					errorClass:'error-val',
					ignore: "",
						rules:
					{
							user_id:
							{
								required:true
							},
                            receipt_date:
                            {
                                required:true,
                            },
                            amount:
                            {
                                required:true,
                            },
                            attachment:
							{
								extension:"jpg|jpeg|png|gif",
							},
                            
                            
					},
					messages:
					{
						user_id:
						{
							required: 'Please choose customer name or supplier name'
						},
                        receipt_date:
                        {
                            required:'Please choose receipt date',
                        },
                        amount:
                        {
                            required:'Amount field is required',
                        },
                        attachment:
                        {
                            extension:"Allowed types only jpg | jpeg | png | gif",
                        },
					},
					errorPlacement: function(error, element)
					{						
						error.insertAfter(element);						
					},
					submitHandler: function()
					{
						document.receipt_form.submit();
						$('button[type=submit], input[type=submit]').attr('disabled',true);
					},
						wrapper: "div"
					});
				});
		
		</script>
 </body>
</html>
