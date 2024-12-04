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
        <li class="active">Manage Category</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
    
     
     <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>>
            <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
            
            
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="category_form" id="category_form" method="post">
        <div class="row-fluid">
        <br>
          
            <?php if($this->session->userdata('session_user_type')!='viewer'){?>
        <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php echo base_url();?>expenses/expenses_category'" type="button">+ Create Expenses Category</button>
        <?php } ?>
       
        
          <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                    <th class="center" width="10%">ID</th>
                    <th class="center" width="25%">Category</th>
  					<th class="center" width="25%">Created</th>
                       <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type')=='admin'){?>
                      <th class="center" width="10%">Status</th>
                      <?php } ?> 
                       <?php if($this->session->userdata('session_user_type')=='super_admin' ){?>
                      <th class="center" width="10%">Action</th> 
                      <?php } ?>   
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
				var url = "<?php echo base_url();?>expenses/ajax_get_expense_category/";  // data tables to load bluk records using ajax
				var oTable1 =$('#table_report').dataTable({
							  "bDestroy": true,
							  "aaSorting": [[ 2, "desc" ]],
							  "bAutoWidth": false,
							   <?php if($this->session->userdata('session_user_type')=='super_admin'){?>
							  "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 0,1,2,3,4] }],
							 <?php }
							 if($this->session->userdata('session_user_type')=='admin'){?>
							  "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ 0,1,2,3] }],
							 <?php }
							 ?>
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
                                                    return data;
                                            }
								    },
									
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
                                        "mRender": function (data,type,full) 
										{ 
                                                   var date_created = data;
													var dateAr1 = date_created.split('-');
													var sYear = dateAr1[0];
													var sMonth = dateAr1[1].toString();
													var dateAr2 = dateAr1[2].split(" ");
													var sDay = dateAr2[0];
													
													var created_date = sYear + '-' + sMonth + '-'+ sDay ;
													return 	created_date;
												   //return data;
                                            }
								    },
									
											 <?php if( $this->session->userdata('session_user_type')=='admin'){?>
											{
													"fnCreatedCell": function(nTd, sData, oData, iRow, iCol)
												   {
													   $(nTd).css('text-align', 'center');
												   },
												"mRender": function (data,type,full) { 
												
												
															var status = '<?php echo STATUS_ACTIVE; ?>';
															var data = data;
															var id = full[0];
															var current = new Date();
															var get_current_date = formatDate(current);
															 // Days you want to subtract
															var dateAr = get_current_date.split('-');
															var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0]; 
															var date = new Date(dateAr[0],dateAr[1]-1,dateAr[2]);
															var get_current_date_new = formatDate(date);
															var newdate = new Date(date);
															newdate.setDate(newdate.getDate() - 6); // minus the date
															var nd = new Date(newdate);
															var last_six = formatDate(nd);
															var date_created = full[2];
															var dateAr1 = date_created.split('-');
															var sYear = dateAr1[0];
															var sMonth = (Number(dateAr1[1])).toString();
															var dateAr2 = dateAr1[2].split(" ");
															var sDay = dateAr2[0];
															
															var created_date = sYear + '-' + sMonth + '-'+ sDay ;
															if(data == 'active')

																{
															   //  if((last_six <= created_date) && (created_date <=get_current_date_new ))
																 if(created_date >= last_six && created_date >= get_current_date_new)
																	{
																return '<img style="cursor:pointer;" onClick="change_status_category('+full[4]+',this);"  src="<?php echo base_url()?>assets/images/active.png" style="cursor:pointer;" title="Change Inactive">';
																	}
																	else
																	{
										 return '<img src="<?php echo base_url()?>assets/images/expired.png" title="Date Expired" style="cursor:pointer;">';
																	
																	}
																}
															  if(data == 'inactive')
																{
																   return '<img src="<?php echo base_url()?>assets/images/inactive.png" title="Change Active">';
																}
											}
										},
										<?php } ?>
																			
											 <?php if($this->session->userdata('session_user_type')=='super_admin'){?>
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
								 								return '<img style="cursor:pointer;" title="'+title_msg+'" onClick="change_status_category('+full[4]+',this);" src="<?php echo base_url(); ?>assets/images/'+status_image+'">';
														}
											}, <?php } ?>
											
											<?php if($this->session->userdata('session_user_type')=='super_admin'){?>
											{
													"fnCreatedCell": function(nTd, sData, oData, iRow, iCol)
												   {
													   $(nTd).css('text-align', 'center');
												   },
												"mRender": function (data,type,full) { 
								 								return '	<div class="btn-group"><a href="<?php echo base_url()?>expenses/edit_category/'+btoa(full[4])+'" class="btn btn-mini btn-info" type="button" title="Edit"><i class="icon-edit bigger-120"></i></a><button type="button" class="btn btn-mini btn-danger" onClick="delete_item_category('+full[4]+',this)" title="Delete"><i class="icon-trash bigger-120"></i></button></div>';
														}
											}, <?php } ?>
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
			
			function delete_item_category(category_id,element)
			{
				var choice=confirm("Do you wish to continue?");
				if (choice==true)
				{
					var oTable = $('#table_report').dataTable();
					$(element).parents('tr').addClass('row_selected');
					var anSelected = fnGetSelected( oTable );
					$.ajax({
					url: '<?php echo base_url();?>expenses/delete_item_category',
					type: 'POST',
					data: { category_id:category_id },
					success: function(){
						if ( anSelected.length !== 0 )
						 {
							oTable.fnDeleteRow( anSelected[0] );
						 }
						 
						if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
						{
							$("#succ_msg").show();
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Category details has been deleted successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Category details has been deleted successfully.<br></div>');
						}
					}
					});										
				}
				else
				{
					return false;
				}
			}
			function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

			function change_status_category(category_id,element)
			{
                if(confirm("Do you wish to continue?"))
                {
				$.ajax({
					url: '<?php echo base_url();?>expenses/change_status_category',
					type: 'POST',
					data: { category_id:category_id },
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
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Category status has been changed successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Category status has been changed successfully.<br></div>');
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
