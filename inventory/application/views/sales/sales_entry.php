<?php
	 $user_roles = unserialize(USER_ROLES);
?>
<?php $this->load->view('layouts/header');?>
<style type="text/css">
input[type="text"] { width:150px; }
select{width:150px;}
</style>
 <?php  
			if(SITE_WORK == 'progress')
{
   echo "<script>alert('work in progress');</script>";
  
}

 ?>
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
        <li class="active">Sales Entry</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
    <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
   <!--   <a href="javascript:void(0);" id="add_more"  class="btn btn-info" style="margin-left:530px" >Add More</a>-->
      <!--/.page-header-->

      <div class="row-fluid" style="margin-top:30px"> 
        <!--PAGE CONTENT BEGINS HERE-->
        <div class="row-fluid">
          <div class="page-header position-relative" style="border-bottom:none !important;">
            
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form name="sales_form" id="sales_form" action="" method="post">
            <input type="hidden" name="c_id" id="c_id" value="" >
            <input type="hidden" name="f_id" id="f_id" value="" >            	
          	<table id="table_report" class="table table-striped table-bordered table-hover dataTable" aria-describedby="table_report_info">
                  <thead>
                    <tr role="row">
                    	<th class="center" width="8%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Code: activate to sort column ascending">Supplier/Customer *</th>
                    	<th class="center" width="8%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Item Code *</th>
                    	<th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Date *</th>
                    	<th class="center" width="2%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Qty *</th>
                    	<th class="center" width="8%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Amount *</th>
                    	<th class="center" width="15%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Remarks</th>
                      <!--  <th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Action</th>-->
                    </tr>
                  </thead>
                  
            		<tbody role="alert" aria-live="polite" aria-relevant="all">
            			<tr class="odd">
            				<td valign="top" class="dataTables_empty supplierlist">
            				<input type="hidden" name="supplier[]" style="width:200px"  id="supplier"/>
													</td>
            				<td valign="top" class="dataTables_empty ">
            				<input type="hidden" name="item_select[]" style="width:200px"  id="item_select"/>
                            <br><a href="javascript:void(0)" class="add_more_new"><span style="float:right;margin-right:120px">(Add)</span></a>
            				</td>
            				<td valign="top" class="dataTables_empty sales_datelist">	<input type="text"  name="sales_date[]" class="sales_entry_date" readonly placeholder="Sales date" ></td>
            			<td valign="top" class="dataTables_empty"><input type="text" class="qtyNumeric" name="qtys[]" id="qty"></td>
            			<td valign="top" class="dataTables_empty"><input type="text" class='amount_box' name="amounts[]"></td>
                        <td valign="top" class="dataTables_empty"><textarea name="remarks[]]" rows="2"></textarea></td>
            				<!--<td valign="top" class="dataTables_empty"><a href="javascript:void(0);" id="add_more"><img src="<?php echo base_url(); ?>images/add_more.png" width="20" alt="Add More" ></a></td>-->
            			</tr>
            		</tbody>
            	</table>
            	<button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" type="submit" >Submit</button>

            <!--PAGE CONTENT ENDS HERE--> 
            
          </div>
        </div>
        </form>
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div><br/><br/>
       <?php $this->load->view('layouts/footer');?>
    </div>
    <!--/#page-content--> 
  </div>
  <!--/#main-content--> 
</div>
<?php $this->load->view('layouts/footer_script');?>
<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a>
<script type="text/javascript" src="<?php echo base_url('js/jquery-1.11.0.min.js')?>"></script> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/jquery.datetimepicker.css"/>
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	
	/*$(".getValue1").click(function() {
    alert($("#supplier").val());
});*/



// amount conversion script code
	$(".amount_box").blur(function(){
	  res =  accounting.formatMoney($(this).val(),'');
	  $(this).val(res);
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
	
	// select2 load remote data code start
 $("#supplier").select2({
	 	//alert("Selected value is: "+$("#supplier").val());
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>sales/ajax_get_active_suppliers/",
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
                                                var supplier_list = [];
                                                var customer_list = [];
														$.each(data, function (index, item) {
                                                            lastchar = item.id;
                                                            res = lastchar.substr(lastchar.length - 1);
                                                           if(res=='s')
                                                           {
                                                               supplier_list.push({
																id: item.id,
																text:item.internal
															     });
                                                           }
                                                            else
                                                            {
                                                                customer_list.push({
																id: item.id,
																text:item.internal
															     });
                                                            }
                                                            
														});
                                                        if(supplier_list.length > 0)
                                                        {
                                                             myResults.push({
                                                                    text: 'Suppliers',
                                                                    children:supplier_list
                                                                });    
                                                        }
                                                        if(customer_list.length > 0)
                                                        {
                                                               myResults.push( {
                                                                    text: 'Customers',
                                                                    children:customer_list
                                                                }); 
                                                        }
                                                        
                                                        
														return {
															results: myResults
														};
												 
											}
										},
					
								});
 
 //Loading server side remote data using select2 from items table
 $("#item_select").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>sales/ajax_get_active_items/",
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
															
														});
														return {
															results: myResults
														};
												 
											}
										},
					
								});
 
 //end
	$('#table_report').on('click','.remove',function(){
			if(confirm('Are you confirm?'))
			{
					$(this).parents('tr').remove();
			}
			else
				return false;
		});
		
		
		
		
	k=1;
	$('#add_more').click(function(){
			var add_html1 = '<tr class="odd"><td valign="top" class="dataTables_empty"><input type="hidden" name="supplier[]" style="width:200px" id="supplier'+k+'" /></td><td valign="top" class="dataTables_empty">	<input type="hidden" name="item_select[]" style="width:200px"  id="item_select'+k+'"/><br><a href="javascript:void(0)" class="add_more_new"><span style="float:right;margin-right:120px">(Add)</span></a></td><td valign="top" class="dataTables_empty">	<input type="text"  name="sales_date[]" class="sales_entry_date'+k+'" readonly="readonly" placeholder="Sales date" ></td><td valign="top" class="dataTables_empty"><input type="text" class="qtyNumeric" name="qtys[]" value=""></td><td valign="top" class="dataTables_empty"><input type="text" class="amount_box" name="amounts[]"></td><td valign="top" class="dataTables_empty"><textarea rows="2" name="remarks[]"></textarea><br><a href="javascript:void(0)" class="remove"><span style="float:right;margin-right:120px">(X)</span></a></td></tr>';
			$('#table_report tr:last').after(add_html1);
			
			$('.sales_entry_date'+k+'').datetimepicker(
 			{
						format:'Y-m-d',
						<?php
							// only allow past date select for admin
						if($this->session->userdata('session_user_type')!= $user_roles[0] || $this->session->userdata('session_user_type')!= $user_roles[1]){
						?>
						maxDate : 0,
						<?php
						}
						?>
   				timepicker:false
 				});	
 				
				
				// ajax server side
					$("#supplier"+k+"").select2({
						
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>sales/ajax_get_active_suppliers/",
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
                                                 var supplier_list = [];
                                                var customer_list = [];
														$.each(data, function (index, item) {
															lastchar = item.id;
                                                            res = lastchar.substr(lastchar.length - 1);
                                                           if(res=='s')
                                                           {
                                                               supplier_list.push({
																id: item.id,
																text:item.internal
															     });
                                                           }
                                                            else
                                                            {
                                                                customer_list.push({
																id: item.id,
																text:item.internal
															     });
                                                            }
														});
                                                
                                                         if(supplier_list.length > 0)
                                                        {
                                                             myResults.push({
                                                                    text: 'Suppliers',
                                                                    children:supplier_list
                                                                });    
                                                        }
                                                        if(customer_list.length > 0)
                                                        {
                                                               myResults.push( {
                                                                    text: 'Customers',
                                                                    children:customer_list
                                                                }); 
                                                        }
														return {
															results: myResults
														};
												 
											}
										},
					
								});
								
								//Loading server side remote data using select2 from items table
 $("#item_select"+k+"").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>sales/ajax_get_active_items/",
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


				
 				k++;
 				
		});

k1=0;

$('#table_report').on('click','.add_more_new',function(){
	
			var add_html1 = '<tr class="odd"><td valign="top" class="dataTables_empty supplierlist"><input type="hidden" value="" name="supplier[]" style="width:200px" id="supplier'+k1+'" /></td><td valign="top" class="dataTables_empty">	<input type="hidden" name="item_select[]" style="width:200px"  id="item_select'+k1+'"/><br><a href="javascript:void(0)" class="add_more_new" ><span style="float:right;margin-right:120px">(Add)</span></a></td><td valign="top" class="dataTables_empty sales_datelist">	<input type="text"  name="sales_date[]" class="sales_entry_date'+k1+'" readonly="readonly" placeholder="Sales date" ></td><td valign="top" class="dataTables_empty"><input type="text" class="qtyNumeric" name="qtys[]" value=""></td><td valign="top" class="dataTables_empty"><input type="text" class="amount_box" name="amounts[]"></td><td valign="top" class="dataTables_empty"><textarea rows="2" name="remarks[]"></textarea><br><a href="javascript:void(0)" class="remove"><span style="float:right;margin-right:120px">(X)</span></a></td></tr>';
			$('#table_report tr:last').after(add_html1);
		
				
				console.log('K : '+k1);
				
				var prev_data_value=prev_data_text='';
				if(k1==0)
				{
					if($('#supplier').val()!='' && $('#supplier').select2('data').text!='')
					{
						prev_data_value=($('#supplier').val()) ? $('#supplier').val() : '';
						prev_data_text = ($('#supplier').select2('data').text) ? $('#supplier').select2('data').text : '';
					}
				}
				else
				{
					
						prev_data_value=($('#supplier'+k1+'').val()) ? $('#supplier'+k1+'').val() : '';
						prev_data_text = ($('#supplier'+k1+'').select2('data').text) ? $('#supplier'+k1+'').select2('data').text : '';
						
							$('.supplierlist').each(function () {	
					
						var htm=$(this).html();
						
						if (htm.toLowerCase().indexOf("- - select - -") < 0)
						{
							console.log('Not Select');
							
							
							console.log(htm);	
							
							if(htm.toLowerCase().indexOf("select2-chosen") > 0)
							{
								prev_data_text=$(htm).find('span.select2-chosen').text();
								
								console.log('Prevd : '+prev_data_text);
								
								prev_data_value=$(htm).filter('input[name^="supplier"]').val();
								
								console.log('Prev : '+prev_data_value);
							}
							else
							console.log('Failed');
						}
							
					});
					
					
				}
				// ajax server side
				console.log('Value : '+prev_data_value);
				
				console.log('Value Text : '+prev_data_text);
				
				$("#supplier"+k1+"").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>sales/ajax_get_active_suppliers/",
											dataType: 'json',
											cache: true,
   											quietMillis: 200,
											data: function (term, page) {
												
												return {
													q: term, // search term
													page_limit: 10,
													s:15
												};
											},											
											results: function (data, page) { // parse the results into the format expected by Select2.
												// since we are using custom formatting functions we do not need to alter remote JSON data
												var myResults = [];
                                                 var supplier_list = [];
                                                var customer_list = [];
														$.each(data, function (index, item) {
															lastchar = item.id;
                                                            res = lastchar.substr(lastchar.length - 1);
                                                           if(res=='s')
                                                           {
                                                               supplier_list.push({
																id: item.id,
																text:item.internal
															     });
                                                           }
                                                            else
                                                            {
                                                                customer_list.push({
																id: item.id,
																text:item.internal
															     });
                                                            }
														});
                                                
                                                         if(supplier_list.length > 0)
                                                        {
                                                             myResults.push({
                                                                    text: 'Suppliers',
                                                                    children:supplier_list
                                                                });    
                                                        }
                                                        if(customer_list.length > 0)
                                                        {
                                                               myResults.push( {
                                                                    text: 'Customers',
                                                                    children:customer_list
                                                                }); 
                                                        }
														
														return {
															results: myResults
														};
												 
											}
										},
					
								});
								
								
								
				if(prev_data_text!='' && prev_data_value!='')
				{				
					$("#supplier"+k1+"").select2('data',{"text":prev_data_text,"id":prev_data_value});		
				
					$("#supplier"+k1+"").val(prev_data_value);		
				}
					
								//Loading server side remote data using select2 from items table
 $("#item_select"+k1+"").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>sales/ajax_get_active_items/",
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
															
														});
														return {
															results: myResults
														};
												 
											}
										},
					
								});
								
								
					console.log(' Date K : '+k1);
				    var datepicker_class=datepicker_val='';
					$('input[name^="sales_date"]').each(function () { 
					  console.log('Date : '+$(this).val());
					  if($(this).val()!='')
					  {
					   datepicker_val=$(this).val();
					  }
					  datepicker_class=$(this).attr('class');
					});
					if(datepicker_val!='')
					{
					 console.log('Cls'+datepicker_class);
					 $('.'+datepicker_class).val(datepicker_val);
					}
			
					$('.sales_entry_date'+k1+'').datetimepicker(
 						{
						format:'Y-m-d',
						<?php
							// only allow past date select for admin
						if($this->session->userdata('session_user_type')!= $user_roles[0] || $this->session->userdata('session_user_type')!= $user_roles[1]){
						?>
						maxDate : 0,
						<?php
						}
						?>
   				timepicker:false
 				});	
				//end 	
				// amount conversion script code
					$(".amount_box").blur(function(){
	 							 res =  accounting.formatMoney($(this).val(),'');
	 							 $(this).val(res);
								});
				//end	
				
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
								k1++;
			
		});
		
									
	
	$('.sales_entry_date').datetimepicker(
 {
	format:'Y-m-d',
	<?php
		// only allow past date select for admin
	if($this->session->userdata('session_user_type')!= $user_roles[0] || $this->session->userdata('session_user_type')!= $user_roles[1]){
	?>
	maxDate : 0,
	<?php
	}
	?>
   timepicker:false
 });	
	
	// validation for while clicking the submit button
	$("#sales_form" ).submit(function( event ) {
		
			var supplier_err=item_err=date_err=qty_err=amt_err=stock_err=0;
			var err_msg='';
            var item_names='';
            
		  /*  $('input[name="c_id"]').each(function(){
  						if($(this).val()=='')
  					{
  						 submit_err++;	
  					}	
				});*/
				
					
			//validate supplier names
			$('input[name="supplier[]"]').each(function(){
  						if($(this).val()=='')
  					{
  						 supplier_err++;	
  					}	
				});
				
				//validate item code
            q=0
            var total_val = "";
        
            $('input[name="item_select[]"]').each(function(){
  					if($(this).val()=='')
  					{
  						 item_err++;	
  					}
                    else
                    {
                        qty_txtboxes = $('input[name="qtys[]"]');
                        qty =  qty_txtboxes.eq(q).val();
                        item_id = $(this).val();
                        if(qty!='')
                        {
                            total_val += '{"item_id":'+item_id+',"qty":'+qty+'},'; // json format
                        }
                    }
                    q++;
				});
          
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
        
        //validate sales date
        $('input[name="sales_date[]"]').each(function(){
  						if($(this).val()=='')
  					{
  						 date_err++;	
  					}	
				});
				
				//validate quantity
			$('input[name="qtys[]"]').each(function(){
  						if($(this).val()=='')
  					{
  						 qty_err++;	
  					}
                    
				});
			
					//validate amounts
			$('input[name="amounts[]"]').each(function(){
  						if($(this).val()=='')
  					{
  						 amt_err++;	
  					}	
				});				
				
				if(supplier_err!=0)
			{
					err_msg+= "\n * All supplier/customer field is required";
			}
            if(stock_err!=0)
            {
                err_msg+="\n * The following items have insufficient quantities in stock - "+item_names+"";
            }
			if(item_err!=0)
			{
					err_msg+= "\n * All item code field is required";
			}
			if(date_err!=0)
			{
					err_msg+= "\n * All date field is required";
			}
		
			if(qty_err!=0)
			{
					err_msg+= "\n * All quantity field is required";
			}
			
			if(amt_err!=0)
			{
					err_msg+= "\n * All amount field is required";
			}
		
			if(supplier_err==0&&item_err==0&&date_err==0&&qty_err==0&&amt_err==0&&stock_err==0)
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
