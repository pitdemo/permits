
<?php $this->load->view('layouts/header');?>
<style type="text/css">
.tr_link{
 display:none;
 }
 .ot_link{
 display:none;
 }

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
<input type="hidden" name="re_id" id="re_id" >
<div class="container-fluid" id="main-container"> <a id="menu-toggler" href="#"> <span></span> </a>
   <?php $this->load->view('layouts/menu');?>
  <div id="main-content" class="clearfix">
    <div id="breadcrumbs">
      <ul class="breadcrumb">
      	 <li>
            <a href="<?php echo base_url();?>receipts">Manage Receipts</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Receipts Entry</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
         <a href="javascript:void(0);" id="add_more" class="btn btn-info" style="float:right"><img src="<?php echo base_url(); ?>images/add_more.png" width="20" alt="Add More" ></a>

      <!--/.page-header-->
      
     <div class="row-fluid" style="margin-top:30px">
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative" style="border-bottom:none !important;">
           
          </div>
          <div class="row-fluid" > 
            <!--PAGE CONTENT BEGINS HERE-->
            <form name="receipt_form" id="receipt_form" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="r_id" id="r_id" value="" >
             <input type="hidden" name="f_id" id="f_id" value="" >   
            	
          	<table id="table_report" class="table table-striped table-bordered table-hover dataTable" aria-describedby="table_report_info">
                  <thead>
                    <tr role="row">
                    	<th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Code: activate to sort column ascending">Supplier/Customer *</th>
                    	<th class="center" width="15%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Amount *</th>
                    	<th class="center" width="20%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Date *</th>
                    	<th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Attachment</th>
                        <th class="center" width="20%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending" style="width: 197px;">Remarks</th>
                    	<!--<th class="center" width="15%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Action</th>-->
                    </tr>
                  </thead>
                  
            		<tbody role="alert" aria-live="polite" aria-relevant="all">
            			<tr class="odd">
            				<td valign="top" class="dataTables_empty">
            				<input type="hidden" name="suppliers[]" style="width:200px"  id="supplier"/>
							<a class="ot_link" href="javascript:void(0);" style="font-size:xx-small;" hidden>Show Transaction |</a>
            				<a class="tr_link" href="javascript:void(0);" style="font-size:xx-small;" hidden>Show Outstanding</a>
            				<p class="danger" id="error_show" style="color:red;font-size:xx-small;" hidden>No Outstanding</p>
													</td>
                            <td valign="top" class="dataTables_empty"><input type="text" class='amount_box' name="amounts[]"></td>
            				<td valign="top" class="dataTables_empty">	<input type="text"  name="receipt_date[]" class="receipt_entry_date" placeholder="Receipt date" ></td>
            			<td valign="top" class="dataTables_empty"><input type="file" class="attachment" name="attachments[]"></td>
            			<td valign="top" class="dataTables_empty"><textarea name="remarks[]]" rows="2"></textarea></td>
            				<!--<td valign="top" class="dataTables_empty"><a href="javascript:void(0);" id="add_more"><img src="<?php echo base_url(); ?>images/add_more.png" width="20" alt="Add More" ></a></td>-->
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/colorbox.css"/>
<script src="<?php echo base_url();?>js/jquery.colorbox-min.js"></script>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
$('.tr_link').hide();
	$('.ot_link').hide();

// get select2 selected values.

	$('#supplier').change(function(){
	var c_id=$('#supplier').val();

	var cst_id=c_id.substring(0,c_id.length - 2);
	$('#re_id').attr('value',c_id);
	var result=0;
	// console.log(cst_id);
	if(c_id!=''){

	$.ajax({
		type:'post',
		url:'<?php echo base_url();?>receipts/transactions/'+c_id,
		data:{id:cst_id},
		success:function(data){
			// console.log(data);
			if(data=='false')
			{
				$('#error_show').show();
				$('.ot_link').show();
				// result="Negative OutStanding";
				// return false;
			}
			else
			{
				result=data;
				$('.tr_link').show();
				$('.ot_link').show();
				// $('.tr_link').attr('href', base_url+"receipts/transactions/" + c_id);

			}

		}

	});
	}
	$('#error_show').hide();
	$('.tr_link').hide();
	$('.ot_link').hide();
                    }); 
$('.tr_link').click(function(){
	var cc_id=$('#re_id').val();
	$.colorbox({
                         href:'<?php echo base_url();?>receipts/transactions/'+cc_id,
                         iframe:true, 
                         reposition:true,
                         opacity:0.7 , 
                         rel:'group1',
                         slideshow:false,
                         height:"90%",
                         width:"80%",
                     });
});

$('.ot_link').click(function(){
	var cc_id=$('#re_id').val();
	$.colorbox({
                         href:'<?php echo base_url();?>receipts/out_transactions/'+cc_id,
                         iframe:true, 
                         reposition:true,
                         opacity:0.7 , 
                         rel:'group1',
                         slideshow:false,
                         height:"90%",
                         width:"80%",
                     });
});

                    return false;
	}); 




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
											url: "<?php echo  base_url(); ?>receipts/ajax_get_active_suppliers/",
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
			var add_html = '<tr class="odd"><td valign="top" class="dataTables_empty"><input type="hidden" name="suppliers[]" style="width:200px" id="supplier'+k+'" data-id="'+k+'" /><a class="tr_link'+k+'" style="display:none;font-size:xx-small;" id="ot_link'+k+'" href="javascript:void(0);" data-id="'+k+'">Show Transaction |</a><a class="tr_link'+k+'" style="display:none;font-size:xx-small;" id="tr_link'+k+'" href="javascript:void(0);" data-id="'+k+'">Show Outstanding</a><br><p id="error_show'+k+'" style="color:red;font-size:xx-small;" hidden>No Outstanding</p></td><td valign="top" class="dataTables_empty"><input type="text" class="amount_box" name="amounts[]"></td><td valign="top" class="dataTables_empty">	<input type="text"  name="receipt_date[]" class="receipt_entry_date'+k+'" placeholder="Receipt date" ></td><td valign="top" class="dataTables_empty"><input type="file" class="attachment" name="attachments[]"></td><td valign="top" class="dataTables_empty"><textarea rows="2" name="remarks[]"></textarea><br><a href="javascript:void(0)" class="remove"><span style="float:right;margin-right:180px">(X)</span></a></td></tr><input type="hidden" name="re_id'+k+'" id="re_id'+k+'" value="" >';
			$('#table_report tr:last').after(add_html);
			
			$('.receipt_entry_date'+k+'').datetimepicker(
 			{
						format:'Y-m-d',
						maxDate : '<?php echo date('Y-m-d'); ?>',
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
											url: "<?php echo  base_url(); ?>receipts/ajax_get_active_suppliers/",
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


// get select2 selected values.
$('body').on('change',"#supplier"+k,function() { 
	q=$(this).data('id');
	var c_id = $(this).val();
	$('#re_id'+q).attr('value',c_id);
	var cst_id=c_id.substring(0,c_id.length - 2);

	$("#re_id"+k).attr('value',c_id);

	var result=0;
	if(c_id!=''){

	$.ajax({
		type:'post',
		url:'<?php echo base_url();?>receipts/transactions/'+c_id,
		data:{id:cst_id},
		success:function(data){
			if(data=='false')
			{
				$('#error_show'+q).show();
				$("#ot_link"+q).show();
			}
			else
			{
				result=data;
				$("#tr_link"+q).show();
				$("#ot_link"+q).show();
			}

		}

	});
	}
	$('#error_show'+q).hide();
	$("#tr_link"+q).hide();
	$("#ot_link"+q).hide();

    }); 

// OutStanding Open Dynamically using ColorBOx......
$('body').on('click',"#tr_link"+k,function() { 
	j=$(this).data('id');
	var cc_id=$("#re_id"+j).val();
	$.colorbox({
                         href:'<?php echo base_url();?>receipts/transactions/'+cc_id,
                         iframe:true, 
                         reposition:true,
                         opacity:0.7 , 
                         rel:'group1',
                         slideshow:false,
                         height:"90%",
                         width:"80%",
                     });
});

$('body').on('click',"#ot_link"+k,function() { 
	j=$(this).data('id');
	var cc_id=$("#re_id"+j).val();
	$.colorbox({
                         href:'<?php echo base_url();?>receipts/out_transactions/'+cc_id,
                         iframe:true, 
                         reposition:true,
                         opacity:0.7 , 
                         rel:'group1',
                         slideshow:false,
                         height:"90%",
                         width:"80%",
                     });
});


				
 				k++;
 				
		});
	
	$('.receipt_entry_date').datetimepicker(
 {
	format:'Y-m-d',
	maxDate : '<?php echo date('Y-m-d'); ?>',
   timepicker:false
 });	
	
	// validation for while clicking the submit button
	$("#receipt_form" ).submit(function( event ) {
		
			var supplier_err=date_err=amt_err=attachment_err=0;
			var err_msg='';
			
			//validate supplier names
			$('input[name="suppliers[]"]').each(function(){
  						if($(this).val()=='')
  					{
  						 supplier_err++;	
  					}	
				});
				
				//validate receipt date
			$('input[name="receipt_date[]"]').each(function(){
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
            //validate supplier names
			$('input[name="attachments[]"]').each(function(){
                    if($(this).val()!='')
                    {
                         var val = $(this).val();
                        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                                case 'gif': case 'jpg': case 'png': case 'jpeg':
                                    break;
                                default:
                                    //$(this).val('');
                                    // error message here
                                    attachment_err++;
                                    break;
                            }
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
            if(attachment_err!=0)
			{
					err_msg+= "\n * Attachments accepts only jpg,jpeg,png,gif";
			}
			
			if(supplier_err==0&&date_err==0&&amt_err==0&&attachment_err==0)

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
