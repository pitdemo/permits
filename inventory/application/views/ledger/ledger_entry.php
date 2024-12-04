<?php
	 $user_roles = unserialize(USER_ROLES);
?>
<?php $this->load->view('layouts/header');?>
<style type="text/css">
input[type="text"] { width:150px; }
select{width:150px;}
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
            <a href="<?php echo base_url();?>ledger">Manage Ledger</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Ledger Entry</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
    <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative" style="border-bottom:none !important;">
           
          </div>
          <div class="row-fluid" > 
            <!--PAGE CONTENT BEGINS HERE-->
            <form name="sales_form" id="sales_form" action="" method="post">
            <input type="hidden" name="c_id" id="c_id" value="" >
            	
          	<table id="table_report" class="table table-striped table-bordered table-hover dataTable" aria-describedby="table_report_info">
                  <thead>
                    <tr role="row">
                    	<th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Code: activate to sort column ascending">Supplier/Customer *</th>
                    	<th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Credit/Debit *</th>
                    	<th class="center" width="20%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Date *</th>
                    	
                    	<th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Amount *</th>
                    	<th class="center" width="20%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Remarks</th>
                        <th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Action</th>
                    </tr>
                  </thead>
                  
            		<tbody role="alert" aria-live="polite" aria-relevant="all">
            			<tr class="odd">
            				<td valign="top" class="dataTables_empty">
            				<input type="hidden" name="suppliers[]" style="width:200px"  id="supplier"/>
													</td>
            				<td valign="top" class="dataTables_empty ledger_datelist">	
            				<select name="ledger_type[]" id="ledger_type" style="width:206px;margin-top:0">
               <option value="Credit" >Credit</option>
                 <option value="Debit" >Debit</option>
                            </select> </td>
            				<td valign="top" class="dataTables_empty">	<input type="text"  name="ledger_date[]" class="ledger_entry_date" readonly="readonly" placeholder="Ledger date" ></td>
            			<td valign="top" class="dataTables_empty"><input type="text" class='amount_box' name="amounts[]"></td>
                        <td valign="top" class="dataTables_empty"><textarea name="remarks[]]" rows="2"></textarea></td>
            				<td valign="top" class="dataTables_empty"><a href="javascript:void(0);" id="add_more"><img src="<?php echo base_url(); ?>images/add_more.png" width="20" alt="Add More" ></a></td>
            			</tr>
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
											url: "<?php echo  base_url(); ?>ledger/ajax_get_active_suppliers/",
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
 
$('#ledger_type').select2({
allowClear: true,
placeholder: "- - Itemwise - - "}); // select box select2 plugin


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
			var add_html = '<tr class="odd"><td valign="top" class="dataTables_empty"><input type="hidden" name="suppliers[]" style="width:200px" id="supplier'+k+'" /></td><td valign="top" class="dataTables_empty"><select name="ledger_type[]" id="ledger_type'+k+'" style="width:206px;margin-top:0"><option value="credit" >Credit</option><option value="debit" >Debit</option>                    </select> </td><td valign="top" class="dataTables_empty">	<input type="text"  name="ledger_date[]" class="ledger_entry_date'+k+'" readonly="readonly" placeholder="Ledger date" ></td><td valign="top" class="dataTables_empty"><input type="text" class="amount_box" name="amounts[]"></td><td valign="top" class="dataTables_empty"><textarea rows="2" name="remarks[]"></textarea></td><td valign="top" class="dataTables_empty"><a href="javascript:void(0)" class="remove"><img src="<?php  echo base_url(); ?>images/remove_icon.png" width="20" alt="Remove"></a></td></tr>';
			$('#table_report tr:last').after(add_html);
			
			$('.ledger_entry_date'+k+'').datetimepicker(
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
											url: "<?php echo  base_url(); ?>ledger/ajax_get_active_suppliers/",
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

$("#ledger_type"+k+"").select2({
allowClear: true,
placeholder: "- - Itemwise - - "}); // select box select2 plugin

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
	
	$('.ledger_entry_date').datetimepicker(
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
			var supplier_err=date_err=qty_err=amt_err=0;
			var err_msg='';
            
            
			
			//validate supplier names
			$('input[name="suppliers[]"]').each(function(){
  						if($(this).val()=='')
  					{
  						 supplier_err++;	
  					}	
				});
				
				
		
				
           
        //validate sales date
        $('input[name="ledger_date[]"]').each(function(){
  						if($(this).val()=='')
  					{
  						 date_err++;	
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
           
		
			if(date_err!=0)
			{
					err_msg+= "\n * All date field is required";
			}
		
		
			if(amt_err!=0)
			{
					err_msg+= "\n * All amount field is required";
			}
		
			if(supplier_err==0&&date_err==0&&amt_err==0)
			{
					return true;
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
