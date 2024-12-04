<?php $this->load->view('layouts/header');?>
<style type="text/css">
    .sweet-alert h2 {
        font-size:20px !important;
    }
</style>
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
            <a href="<?php echo base_url();?>Suppliers">Manage Suppliers</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Supplier Entry</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <br>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form class="form-horizontal" action="" method="post" name="expense_form" id="expense_form">
                 <input type="hidden" name="e_id" id="e_id" value="" >
               <input type="hidden" name="f_id" id="f_id" value="" > 
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Sales persons<sup>*</sup></label>
                <div class="controls">
      		       <input type="hidden" name="persons[]" style="width:220px" id="persons0"/>
                    <?php echo form_error('persons');?>
                </div>
            </div>
            <div class="input_fields_wrap">
            
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Supplier name<sup>*</sup></label>
                <div class="controls">
      		         <input type="text" placeholder="Supplier name" value="<?php echo set_value('suppliers'); ?>" name="suppliers[]" id="suppliers" >
                    <?php echo form_error('suppliers');?>
                </div>
      								
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Email-ID</label>
                <div class="controls">
      		         <input type="text" placeholder="Email-Id"  value="<?php echo set_value('email_ids'); ?>" name="email_ids[]" id="email_ids0" >
                    <?php echo form_error('email_ids');?>
                </div>
      								
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Address</label>
                <div class="controls">
<!--      		         <input type="text" placeholder="Expense Description" value="<?php echo set_value('sup_add'); ?>" name="sup_add[]" id="sup_add0" >-->
                     <textarea placeholder="Address" value="<?php echo set_value('sup_add'); ?>" name="sup_add[]" id="sup_add0" rows="2"></textarea>
                    <?php echo form_error('sup_add');?>
                </div>
      								
            </div>
            
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Contact No<sup>*</sup></label>
                <div class="controls">
      		        <input type="text" name="phone_no[]" id="phone_no0"  placeholder="Contact no" >
                    <?php echo form_error('phone_no');?>
                </div>
            </div>
                            <a href="javascript:void(0)" class="btn btn-mini btn-info fmo_rel cboxElement add_field_button" title="Add More" style="text-decoration: none;float:right; margin-right:520px;">+ Add More</a><br>
            </div>
                
      <div class="control-group">
        <div class="controls">       
      <button type="submit" name="add" class="btn btn-info" > Submit <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
      <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>suppliers'"> Cancel </button>
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
    <script type="text/javascript" src="<?php echo base_url('js/jquery-1.11.0.min.js')?>"></script> 
    
		<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery.validate.min.js'></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/jquery.datetimepicker.css"/>
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
    <script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script>
		<script type="text/javascript">
				$(document).ready(function(){
                    //when click add more button add dynamically material items and material quantity elements
                        var max_fields      = 100; //maximum input boxes allowed
                        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
                        var add_button      = $(".add_field_button"); //Add button ID

                        var x = 1; //initlal text box count
                        var i=1;
                        var j=0;



                        $(add_button).click(function(e){ //on add input button click
                            e.preventDefault();
                            if(x < max_fields){ //max input box allowed
                                x++; //text box increment

                               							
								/*$(wrapper).append('<div class="pack"><div class="control-group"><label class="control-label" for="form-field-1"><a href="#" class="remove_field">(X)</a>Sales Person<sup>*</sup></label><div class="controls"><input type="hidden" name="persons[]" style="width:220px" id="persons'+i+'" class="item_select"/></div></div><div class="input_fields_wrap"><div class="control-group"><label class="control-label" for="form-field-1">Customer Name<sup>*</sup></label><div class="controls"><input type="text"  placeholder="Email-ID" name="email_ids[]" id="email_ids'+i+'" ></div></div><div class="control-group"><label class="control-label" for="form-field-1">Email_id<sup>*</sup></label><div class="controls"><input type="text"  placeholder="Email_id" name="phone_no[]" id="phone_no'+i+'" ></div></div><div class="control-group"><label class="control-label" for="form-field-1">Address<sup>*</sup></label><div class="controls"><textarea placeholder="address"  name="sup_add[]" id="sup_add'+i+'" rows="2"></textarea></div></div><div class="control-group"><label class="control-label" for="form-field-1">Contact No<sup>*</sup></label><div class="controls"><input type="text"  placeholder="Contact No" name="phone_no[]" id="phone_no'+i+'" ></div></div></div></div></div>');*/
								
								$(wrapper).append('<div class="pack"><div class="control-group"><label class="control-label" for="form-field-1"><a href="#" class="remove_field">(X)</a>Sales Person<sup>*</sup></label><div class="controls"><input type="hidden" name="persons[]" style="width:220px" id="persons'+i+'" class="item_select"/></div></div><div class="input_fields_wrap"><div class="control-group"><label class="control-label" for="form-field-1">Customer Name<sup>*</sup></label><div class="controls"><input type="text"  placeholder="Customer name" name="suppliers[]" id="suppliers'+i+'" ></div></div><div class="control-group"><label class="control-label" for="form-field-1">Email_id</label><div class="controls"><input type="text"  placeholder="Email-ID" name="email_ids[]" id="email_ids'+i+'" ></div></div><div class="control-group"><label class="control-label" for="form-field-1">Address</label><div class="controls"><textarea placeholder="address"  name="sup_add[]" id="sup_add'+i+'" rows="2"></textarea></div></div><div class="control-group"><label class="control-label" for="form-field-1">Contact No<sup>*</sup></label><div class="controls"><input type="text"  placeholder="Contact No" name="phone_no[]" id="phone_no'+i+'" ></div></div></div></div></div>');
								
                                $("#persons"+i+"").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>suppliers/ajax_get_active_salesperson/",
											dataType: 'json',
											cache: true,
   									quietMillis: 200,
											data: function (term, page) {
												return {
													q: term, // search term
													page_limit: 10,
													s:15,
												};
											},
											results: function (data, page) { // parse the results into the format expected by Select2.
												// since we are using custom formatting functions we do not need to alter remote JSON data
												var myResults = [];
														$.each(data, function (index, item) {
															myResults.push({
																id: item.id,
																text:item.internal
															});
															console.log(myResults);
														});
														return {
															results: myResults
														};
												 
											}
										},
					
								});
                                
                                
								
								
                                
							// amount conversion script code
									$(".amount_box").blur(function(){
									  res =  accounting.formatMoney($(this).val(),'');
									  $(this).val(res);
								});
								
                        //end
 
                 
                                i++;

                            }
                        });


                        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text	
                            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
                        })
                    //end
                            
                    
                          //Loading server side remote data using select2 from items table
                    $("#persons0").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>suppliers/ajax_get_active_salesperson/",
											dataType: 'json',
											cache: true,
   									quietMillis: 200,
											data: function (term, page) {
												return {
													q: term, // search term
													page_limit: 10,
													s:15,
												};
											},
											results: function (data, page) { // parse the results into the format expected by Select2.
												// since we are using custom formatting functions we do not need to alter remote JSON data
												var myResults = [];
														$.each(data, function (index, item) {
															myResults.push({
																id: item.id,
																text:item.internal
															});
															console.log(myResults);
														});
														return {
															results: myResults
														};
												 
											}
										},
					
								});
 
                            //end
                    
						// amount conversion script code
							$(".amount_box").blur(function(){
							  res =  accounting.formatMoney($(this).val(),'');
							  $(this).val(res);
						});
						//end	
	
                   
                    //end
                    // validation for while clicking the submit button
	               $("#expense_form" ).submit(function( event ) {
                      var date_err=phone_err=persons_err=suppliers_err=email_ids_err=0;
                      var err_msg='';
                        
                       
                 /*     // validation for expense date   
                    $('input[name="phone_no[]"]').each(function(){
                            if($(this).val()=='')
                            {
                                 date_err++;
                         	    
                            }
                        });*/
											
				/*$('input[name="phone_no[]"]').each(function(){
								if($(this).val()!='')
								{
									 user_phone = $(this).val();
									 phone_pattern = /^\d{10}$/;
									 if(phone_pattern.test(user_phone)==false)
										date_err++;
								}	
				});
*/
                    $('input[name="phone_no[]"]').each(function(){
  				if($(this).val()!='')
  				{
					 user_phone = $(this).val();
					 phone_pattern = /^\d{10}$/;
					 if(phone_pattern.test(user_phone)==false)
						 date_err++;
  				}
				else
				{
					 phone_err++;
				}
});
					$('input[name="persons[]"]').each(function(){
                            if($(this).val()=='')
                            {
                                 persons_err++;	
                            }
                        });
                     
					   $('input[name="suppliers[]"]').each(function(){
                            if($(this).val()=='')
                            {
                                 suppliers_err++;	
                            }
                        });
					//validate  Amount
					/*$('input[name="email_ids[]"]').each(function(){
								if($(this).val()=='')
							{
								 email_ids_err++;	
							}
						
					});*/
					
					
					$('input[name="email_ids[]"]').each(function(){
  				if($(this).val()!='')
  				{
					 user_email = $(this).val();
					 email_pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
					 if(email_pattern.test(user_email)==false)
						 email_ids_err++;	
  				}	
});

				/*					//validate Description
					$('textarea[name="sup_add[]"]').each(function(){
								if($(this).val()=='')
							{
								 sup_add_err++;	
							}
						
					});*/

                       
                                        
                    if(persons_err!=0)
                    {
                        err_msg+="\n *  All Sales person field is required ";
                    }
					 if(suppliers_err!=0)
                    {
                        err_msg+="\n *  All Customers field is required ";
                    }
                    
                       if(email_ids_err!=0)
                    {
                        err_msg+="\n * Invalid email format";
                    }
					if(phone_err!=0)
					{
								err_msg+= "\n * Please fill all person contact no";
						}



                       
					 if(date_err!=0)
                    {
                         err_msg+= "\n * Invalid phone number format(10 numbers only)";
                    }
                       
                    if(date_err==0&&phone_err==0&&persons_err==0&&suppliers_err==0&&email_ids_err==0)
			         {
					
					if($('#f_id').val()=='')
					{
						console.log('Form sub');
						
						$('#f_id').val(1);
						
						return true;
					}
					else
					{
						console.log('Form Not sub');
						
						return false;
					}
					
				}
				     else
				     {
                        swal(err_msg);  // sweetalert syntax
                        return false;
				     }
                       
                   });
    			   
				});
		
		</script>
 </body>
</html>
