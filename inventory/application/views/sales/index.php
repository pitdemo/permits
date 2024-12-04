<?php $this->load->view('layouts/header');?>
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
        <li class="active">Manage Customers</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
          
                <select onchange="window.open(this.options[this.selectedIndex].value,'_blank')" name="website">
<option value="">Select Customer Name</option>
<?php 
if(!empty($payment_details))
  {
	foreach($payment_details as $val)
	{
?>
	<option value="<?php echo base_url()?>sales/customer_navigation"><?php echo $val['customer_name']?></option>
<?php 
	}
	}?>
</select>
          <form name="customer_form" id="customer_form" method="post">
        <div class="row-fluid">
        <br>
       
          <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                      <th class="center" width="25%">Name</th>
                        <th class="center" width="15%">Payment Date</th>
                         <th class="center" width="20%">Amount</th>
                      <th class="center" width="10%">Status</th>                                           
                      <th class="center" width="20%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
				              </tbody>
            </table>
          </div>
             
          
          <div class="clearfix"></div>
          <br/>
        
        </div>
         </form>
        
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div>
      <br/>
      <br/>
            <?php $this->load->view('layouts/footer');?>
      <!--/row--> 
    </div>
    <!--/#page-content--> 
    
    <!--/#ace-settings-container--> 
  </div>
  <!--/#main-content--> 
</div>
<!--/.fluid-container#main-container--> 

<!--<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> -->

<!--basic scripts--> 

<?php $this->load->view('layouts/footer_script');?>

<!--page specific plugin scripts--> 
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script type="text/javascript">
			$(function() {
							
				var url = "<?php echo base_url();?>sales/ajax_get_payments/";  // data tables to load bluk records using ajax
				var oTable1 =$('#table_report').dataTable({
							  "bDestroy": true,
							  "bAutoWidth": false,
							  "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 0,1,2,3,4] }],
							  "bProcessing": true,
          "bServerSide": true,
							  "bStateSave": true,
							  "oLanguage": {"sProcessing": ""},
          "sAjaxSource":url,
							  "aoColumns": [
								  {
											"fnCreatedCell": function(nTd, sData, oData, iRow, iCol)
												   {
													   $(nTd).css('text-align', 'center');
												   },
												"mRender": function (data,type,full) {                          
								 						return data.substr(0, 1).toUpperCase() + data.substr(1);
												}
											},
										{
											"fnCreatedCell": function(nTd, sData, oData, iRow, iCol)
												   {
													   $(nTd).css('text-align', 'center');
												   },
												"mRender": function (data,type,full) {  
													if(data!='')                        
								 						return data;
								 				else
								 						return '---';
												}
											},
										{
													"fnCreatedCell": function(nTd, sData, oData, iRow, iCol)
												   {
													   $(nTd).css('text-align', 'center');
												   },
												"mRender": function (data,type,full) {
													if(data!='')
																return data;
													else
																return '---';
												}
											},
											{
													"fnCreatedCell": function(nTd, sData, oData, iRow, iCol)
												   {
													   $(nTd).css('text-align', 'center');
												   },
												"mRender": function (data,type,full) { 
															var status = '<?php echo STATUS_ACTIVE; ?>';
															if(data==status)
															{
																	status_image = 'active.png';
																	title_msg='Change Inactive';
															}
															else
															{
																	status_image = 'inactive.png';
																	title_msg='Change Active';
															}                           
								 								return '<img style="cursor:pointer;" title="'+title_msg+'" onClick="change_status('+full[4]+',this);" src="<?php echo base_url(); ?>assets/images/'+status_image+'">';
														}
											},
											{
													"fnCreatedCell": function(nTd, sData, oData, iRow, iCol)
												   {
													   $(nTd).css('text-align', 'center');
												   },
												"mRender": function (data,type,full) { 
								 								return '	<div class="btn-group"><a href="<?php echo base_url()?>sales/edit_payment/'+btoa(full[4])+'" class="btn btn-mini btn-info" type="button" title="Edit"><i class="icon-edit bigger-120"></i></a><button type="button" class="btn btn-mini btn-danger" onClick="delete_item('+full[4]+',this)" title="Delete"><i class="icon-trash bigger-120"></i></button></div>';
														}
											},
             ],
                             
								});
								
								//end
								
				if(window.location.hash)
				{
					oTable1.fnFilter(window.location.hash.substring(1));
				}				
					
			});
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}
			
			function delete_item(id,element)
			{
				var choice=confirm("Do you wish to continue?");
				if (choice==true)
				{
					var oTable = $('#table_report').dataTable();
					$(element).parents('tr').addClass('row_selected');
					var anSelected = fnGetSelected( oTable );
					$.ajax({
					url: '<?php echo base_url();?>sales/delete_item',
					type: 'POST',
					data: {id:id },
					success: function(){
						if ( anSelected.length !== 0 )
						 {
							oTable.fnDeleteRow( anSelected[0] );
						 }
						 
						if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
						{
							$("#succ_msg").show();
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Customer Payment details has been deleted successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Customer Payment details has been deleted successfully.<br></div>');
						}
					}
					});										
				}
				else
				{
					return false;
				}
			}
			function change_status(id,element)
			{
                if(confirm("Do you wish to continue?"))
                {
				$.ajax({
					url: '<?php echo base_url();?>sales/change_status',
					type: 'POST',
					data: { id:id },
					beforeSend: function() { $(element).attr('src','<?php echo base_url();?>'+'assets/images/loader.gif'); },
					success: function(msg){
						if($.trim(msg) == 'inactive')
						{
							$(element).attr('src','<?php echo base_url();?>'+'assets/images/inactive.png');
							$(element).attr('title','Change Active');
						}
						else
						{
							$(element).attr('src','<?php echo base_url();?>'+'assets/images/active.png');
							$(element).attr('title','Change Inactive');
						}
						
						if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
						{
							$("#succ_msg").show();
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Customer status has been changed successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Customer status has been changed successfully.<br></div>');
						}
						
					}
					});
                }
                else
                    return false;
			}
		</script>
</body>
</html>
