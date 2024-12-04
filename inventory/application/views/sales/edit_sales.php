<?php
	 $user_roles = unserialize(USER_ROLES);
?>
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
            <a href="<?php echo base_url();?>sales">Manage Sales</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Edit Sales Details</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative">
            <h1>Edit Sales Details</h1>
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form class="form-horizontal" action="" method="post" name="sales_form" id="sales_form">
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
                                if($sales_details['user_type']=='supplier') // set selected option code based on user type
                                {
                                    if($sales_details['user_id']==$supplier['id'])
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
                                if($sales_details['user_type']=='customer') // set selected option code based on user type
                                {
                                    if($sales_details['user_id']==$customer['id'])
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
      		    <label class="control-label" for="form-field-1">Item Code/Name<sup>*</sup></label>
                <div class="controls">
				   <select name="item_id" id="item_id" style="width:220px">
                       <?php
                        if(!empty($items))
                        {
                            foreach($items as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" <?php echo  (set_value('item_id',(isset($sales_details['item_id']))?$sales_details['item_id']:'') == $item['id'])?'SELECTED':''; ?>><?php echo $item['item_code'].'-'.$item['item_name']; ?></option>
                        <?php
                            }
                        }
    
                        ?>
                    </select>  
                    <?php echo form_error('item_id');?>
                </div>
            </div>
            <div class="control-group">
      		    <label class="control-label" for="form-field-1">Sales date<sup>*</sup></label>
                <div class="controls">
				   <input type="text"  name="sales_date" readonly="readonly" id="sales_date" class="sales_entry_date" placeholder="Sales date" value="<?php echo set_value('sales_date',isset($sales_details['sales_date'])? $sales_details['sales_date'] : ''); ?>" >
                    <?php echo form_error('sales_date');?>
                </div>
            </div>
            <div class="control-group">
      		    <label class="control-label" for="form-field-1">Quantity<sup>*</sup></label>
                <div class="controls">
				   <input type="text"  name="qty" id="qty" class="qtyNumeric" placeholder="Quantity" value="<?php echo set_value('qty',isset($sales_details['qty'])? $sales_details['qty'] : ''); ?>" >
                    <?php echo form_error('qty');?>
                </div>
            </div>
            <div class="control-group">
      		    <label class="control-label" for="form-field-1">Amount<sup>*</sup></label>
                <div class="controls">
				   <input type="text"  name="amount" id="amount" class="amount_box" placeholder="Amount" value="<?php echo set_value('amount',isset($sales_details['amount'])? $sales_details['amount'] : ''); ?>" >
                    <?php echo form_error('amount');?>
                </div>
            </div>
            
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
                    
                    // date picker for purchase date
                    $('.sales_entry_date').datetimepicker(
                        {
	                       format:'Y-m-d',
							<?php
								// only allow past date select for admin
							if($this->session->userdata('session_user_type')!= $user_roles[0] || $this->session->userdata('session_user_type')!= $user_roles[1]){
							?>
							minDate : 0,
							<?php
							}
							?>
                          timepicker:false
                        });	
                    
                    //quantity textbox allow only number script start
                        $('.qtyNumeric').keydown(function (e) {
                                    if (e.shiftKey || e.ctrlKey || e.altKey) {
                                    e.preventDefault();
                                    } else {
                                var key = e.keyCode;
                                if (!((key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
                                e.preventDefault();
                                }
                                }
                                });
                        //end
                   // amount conversion script code
                        $(".amount_box").blur(function(){
                          res =  accounting.formatMoney($(this).val(),'');
                          $(this).val(res);
                        });
                    //end	
                    // form validation start
					var validator = $("#sales_form").validate({
					errorClass:'error-val',
					ignore: "",
						rules:
					{
							user_id:
							{
								required:true
							},
                            sales_date:
                            {
                                required:true,
                            },
                            qty:
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
                        sales_date:
                        {
                            required:'Please choose sales date',
                        },
                        qty:
                        {
                            required:'Quantity field is required',
                        },
					},
					errorPlacement: function(error, element)
					{						
						error.insertAfter(element);						
					},
					submitHandler: function()
					{
						document.sales_form.submit();
						$('button[type=submit], input[type=submit]').attr('disabled',true);
					},
						wrapper: "div"
					});
				});
		
		</script>
 </body>
</html>
