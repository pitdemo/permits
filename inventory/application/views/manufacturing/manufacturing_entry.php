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
            <a href="<?php echo base_url();?>manufacturing">Manage Manufacture</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Manufacturing Entry</li>
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
            <form class="form-horizontal" action="" method="post" name="manufacture_form" id="manufacture_form">
                 <input type="hidden" name="m_id" id="m_id" value="" >
                 <input type="hidden" name="f_id" id="f_id" value="" > 
            <div class="control-group">
      			<label class="control-label" for="form-field-1">Manufacture Item<sup>*</sup></label>
                <div class="controls">
      		       <input type="hidden" name="manufacture_item" style="width:220px" id="manufacture_item"/>
                    <?php echo form_error('manufacture_item');?>
                </div>
      								
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Manufacture Quantity<sup>*</sup></label>
                <div class="controls">
      		        <input type="text" class="qtyNumeric" placeholder="Manufacture Quantity" value="<?php echo set_value('manufacture_qty'); ?>" name="manufacture_qty" id="manufacture_qty" >
                    <?php echo form_error('manufacture_qty');?>
                </div>
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Manufacture Date<sup>*</sup></label>
                <div class="controls">
      		        <input type="text" name="manufacture_date" id="manufacture_date"  placeholder="Manufacture date" >
                    <?php echo form_error('manufacture_date');?>
                </div>
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Material Item<sup>*</sup></label>
                <div class="controls">
      		       <input type="hidden" name="material_item[]" style="width:220px" id="material_item0"/>
                    <?php echo form_error('material_item');?>
                </div>
            </div>
            <div class="input_fields_wrap">
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Material Quantity <sup>*</sup></label>
                <div class="controls">
      		         <input type="text" placeholder="Material Quantity" class="qtyNumeric" value="<?php echo set_value('material_qty'); ?>" name="material_qty[]" id="material_qty0" >
                    <?php echo form_error('material_qty');?>
                </div>
      								
            </div>
                <a href="javascript:void(0)" class="btn btn-mini btn-info fmo_rel cboxElement add_field_button" title="Add More" style="text-decoration: none;float:right; margin-right:520px;">+ Add More</a><br>
            </div>
                
      <div class="control-group">
        <div class="controls">       
      <button type="submit" name="add" class="btn btn-info" > Submit <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
      <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>manufacturing'"> Cancel </button>
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

                                $(wrapper).append('<div class="pack"><div class="control-group"><label class="control-label" for="form-field-1"><a href="#" class="remove_field">(X)</a> Material Item<sup>*</sup></label><div class="controls"><input type="hidden" name="material_item[]" style="width:220px" id="material_item'+i+'" class="item_select"/></div></div><div class="input_fields_wrap"><div class="control-group"><label class="control-label" for="form-field-1">Material Quantity<sup>*</sup></label><div class="controls"><input type="text" class="qtyNumeric" placeholder="Material Quantity" name="material_qty[]" id="material_qty'+i+'" ></div></div></div>');
                                
                                $("#material_item"+i+"").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>manufacturing/ajax_get_active_items/",
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
                                
                                
                                //quantity textbox allow only number script start
                        $('.qtyNumeric').keydown(function (e) {
                                    if (e.shiftKey || e.ctrlKey || e.altKey) {
                                    e.preventDefault();
                                    } else {
                                var key = e.keyCode;
                                if (!((key == 8) || (key == 9) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
                                e.preventDefault();
                                }
                                }
                                });
                        //end
 
                            //end
                                i++;

                            }
                        });


                        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text	
                            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
                        })
                    //end
                        
                    // script for datetime picker
                    $('#manufacture_date').datetimepicker({
                        format:'Y-m-d',
                        maxDate : '<?php echo date('Y-m-d'); ?>',
                       timepicker:false
                    });	
                    //end
                    
                    
                    //Loading server side remote data using select2 from items table
                    $("#manufacture_item").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>manufacturing/ajax_get_active_items/",
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
                    
                          //Loading server side remote data using select2 from items table
                    $("#material_item0").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>manufacturing/ajax_get_active_items/",
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
                    
                    //quantity textbox allow only number script start
                        $('.qtyNumeric').keydown(function (e) {
                                    if (e.shiftKey || e.ctrlKey || e.altKey) {
                                    e.preventDefault();
                                    } else {
                                var key = e.keyCode;
                                if (!((key == 8) || (key == 9) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
                                e.preventDefault();
                                }
                                }
                                });
                        //end
	
                    
                    // validation for while clicking the submit button
	               $("#manufacture_form" ).submit(function( event ) {
                      var manufacture_item_err=manufacture_qty_err=date_err=material_item_err=material_qty_err=stock_err=0;
                      var err_msg='';
                        
                      if($("#manufacture_item").val()=='') // validation for manufacture item
                      {
                          manufacture_item_err++;
                          err_msg+= "\n * Manufacture item field is required";
                      }
                       
                       // validation for manufacture qty 
                       if($("#manufacture_qty").val()=='')
                      {
                          manufacture_qty_err++;
                          err_msg+= "\n * Manufacture quantity field is required";
                      }
                        
                        // validation for manufacture date 
                       if($("#manufacture_date").val()=='')
                      {
                          date_err++;
                          err_msg+= "\n * Manufacture date field is required";
                      }
                       
                                mq=0
                    var total_val = "";

                    $('input[name="material_item[]"]').each(function(){
                            if($(this).val()=='')
                            {
                                 material_item_err++;	
                            }
                            else
                            {
                                qty_txtboxes = $('input[name="material_qty[]"]');
                                qty =  qty_txtboxes.eq(mq).val();
                                item_id = $(this).val();
                                if(qty!='')
                                {
                                    total_val += '{"item_id":'+item_id+',"qty":'+qty+'},'; // json format
                                }
                            }
                            mq++;
                        });
                     
                       item_names='';

                        //using ajax to check all item stock details and required quantity
                  if( total_val != "" )
                   {
                    $.ajax({
                           url: '<?php echo base_url();?>items/get_item_stock_details',
                           type: 'POST',
                           async : false,
                           data: { total_val:total_val },
                           success: function(data){ // ajax response return insufficient stock item names
                                  if(data!='')
                                  {
                                      stock_err++; 
                                      item_names = data;
                                  }
                             }
                         });
                   }
                       
                //validate material quantity
                $('input[name="material_qty[]"]').each(function(){
                            if($(this).val()=='')
                        {
                             material_qty_err++;	
                        }
                    
				});
                       
                    if(stock_err!=0)
                    {
                        err_msg+="\n * The following items have insufficient quantities in stock - "+item_names+"";
                    }
                    
                    if(material_item_err!=0)
                    {
                        err_msg+="\n *  All material item field is required ";
                    }
                    
                       if(material_qty_err!=0)
                    {
                        err_msg+="\n *  All material quantity field is required ";
                    }
                       
                    if(manufacture_item_err==0&&manufacture_qty_err==0&&date_err==0&&stock_err==0&&material_item_err==0&&material_qty_err==0)
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
