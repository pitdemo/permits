
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
            <a href="<?php echo base_url();?>customer_payments">Manage Customer Payments</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Customer Payments</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 

        
      <!--/.page-header-->
      <div class="alert alert-info" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?><br></div>
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative" style="border-bottom:none !important;">
           
          </div>
          <div class="row-fluid" > 
            <!--PAGE CONTENT BEGINS HERE-->
            <form name="payment_form" id="payment_form" action="" method="post">
            <!-- <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php echo base_url();?>customer_payments/bulk_insert'" type="button">Import data from CSV</button><br>-->
            <input type="hidden" name="c_id" id="c_id" value="" >
            	
          	<table id="table_report" class="table table-striped table-bordered table-hover dataTable" aria-describedby="table_report_info">
                  <thead>
                    <tr role="row">
          <th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Code: activate to sort column ascending">Customer *</th>
             <th class="center" width="20%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Date *</th>
               <th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Amount *</th>
            	<th class="center" width="15%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Action</th>
                    </tr>
                  </thead>
                  
            		<tbody role="alert" aria-live="polite" aria-relevant="all">
            			<tr class="odd">
            				<td valign="top" class="dataTables_empty">
            				<input type="hidden" name="customers[]" style="width:200px"  id="customer"/>
													</td>
            				
            				<td valign="top" class="dataTables_empty">	<input type="text"  name="payment_date[]" class="payment_entry_date" placeholder="Date of Deposit" ></td>
            			<td valign="top" class="dataTables_empty"><input type="text" class='amount_box' name="amounts[]"></td>
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
		if (!((key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
		e.preventDefault();
		}
		}
		});
//end
	
	// select2 load remote data code start
 $("#customer").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>customer_payments/ajax_get_active_customers/",
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
																id: item.customer_name,
																
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
			var add_html = '<tr class="odd"><td valign="top" class="dataTables_empty"><input type="hidden" name="customers[]" style="width:200px" id="customer'+k+'" /></td><td valign="top" class="dataTables_empty">	<input type="text"  name="payment_date[]" class="payment_entry_date'+k+'" placeholder="Date of Deposit" ></td><td valign="top" class="dataTables_empty"><input type="text" class="amount_box" name="amounts[]"></td><td valign="top" class="dataTables_empty"><a href="javascript:void(0)" class="remove"><img src="<?php  echo base_url(); ?>images/remove_icon.png" width="20" alt="Remove"></a></td></tr>';
			$('#table_report tr:last').after(add_html);
			
			$('.payment_entry_date'+k+'').datetimepicker(
 			{
						format:'Y-m-d',
						minDate : 0,
   				timepicker:false
 				});	
 				
				
				// ajax server side
					$("#customer"+k+"").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { 
											url: "<?php echo  base_url(); ?>customer_payments/ajax_get_active_customers/",
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
																id: item.customer_name,
																
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
	
	$('.payment_entry_date').datetimepicker(
 {
	format:'Y-m-d',
	minDate : 0,
   timepicker:false
 });	
	
	// validation for while clicking the submit button
	$("#payment_form" ).submit(function( event ) {
			var customer_err=item_err=date_err=qty_err=amt_err=0;
			var err_msg='';
			
			//validate Customer names
			$('input[name="customers[]"]').each(function(){
  						if($(this).val()=='')
  					{
  						 customer_err++;	
  					}	
				});
				
				//validate payment date
			$('input[name="payment_date[]"]').each(function(){
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
				
				if(customer_err!=0)
			{
					err_msg+= "\n * All customer field is required";
			}
			
			if(date_err!=0)
			{
					err_msg+= "\n * All date field is required";
			}
		
			
			
			if(amt_err!=0)
			{
					err_msg+= "\n * All amount field is required";
			}
			
			if(customer_err==0&& date_err==0&&qty_err==0&&amt_err==0)
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
