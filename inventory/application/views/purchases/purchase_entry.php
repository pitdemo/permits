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
            <a href="<?php echo base_url();?>purchases">Manage Purchases</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Purchase Entry</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
    
      
      <!--/.page-header-->
          <a href="javascript:void(0);" id="add_more" class="btn btn-info" style="float:right"><img src="<?php echo base_url(); ?>images/add_more.png" width="20" alt="Add More" ></a>
      <!--/.page-header-->

      <div class="row-fluid" style="margin-top:30px">
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative" style="border-bottom:none !important;">
           
          </div>
          <div class="row-fluid" > 
            <!--PAGE CONTENT BEGINS HERE-->
            <form name="purchase_form" id="purchase_form" action="" method="post">
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
                        <th class="center" width="15%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending" style="width: 197px;">Remarks</th>
                    	<!--<th class="center" width="15%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Action</th>-->
                    </tr>
                  </thead>
                  
            		<tbody role="alert" aria-live="polite" aria-relevant="all">
            			<tr class="odd">
            				<td valign="top" class="dataTables_empty">
            				<input type="hidden" name="supplier[]" style="width:200px"  id="supplier"/>
													</td>
            				<td valign="top" class="dataTables_empty">
            				<input type="hidden" name="item_select[]" style="width:200px"  id="item_select"/>
            				</td>
            				<td valign="top" class="dataTables_empty">	<input type="text"  name="purchase_date[]" class="purchase_entry_date" readonly="readonly" placeholder="Purchase date" ></td>
            			<td valign="top" class="dataTables_empty"><input type="text" class="qtyNumeric" name="qtys[]"></td>
            			<td valign="top" class="dataTables_empty"><input type="text" class='amount_box' name="amounts[]"></td>
                        <td valign="top" class="dataTables_empty"><textarea name="remarks[]]" rows="2"></textarea></td>
<!--            				<td valign="top" class="dataTables_empty"><a href="javascript:void(0);" id="add_more"><img src="<?php echo base_url(); ?>images/add_more.png" width="20" alt="Add More" ></a></td>
-->            			</tr>
            		</tbody>
            	</table>
            	<button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" type="submit">Submit</button>
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
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>purchases/ajax_get_active_suppliers/",
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
											url: "<?php echo  base_url(); ?>purchases/ajax_get_active_items/",
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
			var add_html = '<tr class="odd"><td valign="top" class="dataTables_empty"><input type="hidden" name="supplier[]" style="width:200px" id="supplier'+k+'" /></td><td valign="top" class="dataTables_empty">	<input type="hidden" name="item_select[]" style="width:200px"  id="item_select'+k+'"/></td><td valign="top" class="dataTables_empty">	<input type="text"  name="purchase_date[]" readonly="readonly" class="purchase_entry_date'+k+'" placeholder="Purchase date" ></td><td valign="top" class="dataTables_empty"><input type="text" class="qtyNumeric" name="qtys[]" value=""></td><td valign="top" class="dataTables_empty"><input type="text" class="amount_box" name="amounts[]"></td><td valign="top" class="dataTables_empty"><textarea rows="2" name="remarks[]"></textarea><br><a href="javascript:void(0)" class="remove"><span style="float:right;margin-right:180px">(X)</span></a></td></tr>';
			$('#table_report tr:last').after(add_html);
			
			$('.purchase_entry_date'+k+'').datetimepicker(
 			{
						format:'Y-m-d',
						<?php
							// only allow past date select for admin
						if($this->session->userdata('session_user_type')!= $user_roles[0] || $this->session->userdata('session_user_type')!= $user_roles[1]){
						?>
						//minDate : 0,
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
											url: "<?php echo  base_url(); ?>purchases/ajax_get_active_suppliers/",
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
											url: "<?php echo  base_url(); ?>purchases/ajax_get_active_items/",
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
	
	$('.purchase_entry_date').datetimepicker(
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
	$("#purchase_form" ).submit(function( event ) {
			var supplier_err=item_err=date_err=qty_err=amt_err=0;
			var err_msg='';
			
			//validate supplier names
			$('input[name="supplier[]"]').each(function(){
  						if($(this).val()=='')
  					{
  						 supplier_err++;	
  					}	
				});
				
				//validate item code
			$('input[name="item_select[]"]').each(function(){
  						if($(this).val()=='')
  					{
  						 item_err++;	
  					}	
				});
				
				//validate purchase date
			$('input[name="purchase_date[]"]').each(function(){
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
			
			if(supplier_err==0&&item_err==0&&date_err==0&&qty_err==0&&amt_err==0)
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
