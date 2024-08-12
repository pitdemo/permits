<?php $this->load->view('layouts/header',array('page_name'=>'Listing')); ?>
		<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/daterangepicker-bs3.css" rel="stylesheet">
<style>
    .label:hover{
        cursor: pointer; cursor: hand;
    }
</style>
<!-- start: Content -->
<div class="main acccount-con min-height">
			<div class="row mr-none">		
				<div class="col-lg-12">
                  <h1>Accounts <a href="<?php echo base_url().$this->data['controller'].'form/'; ?>" role="button" class="pull-right btn btn btn-success"><i class="fa fa-pencil"></i>Create</a>
                  <a data-target="#myModal" data-toggle="modal" role="button" class="pull-right btn btn-primary"><i class="fa fa-share-square-o"></i>Import</a></h1>
                 <div class="clearfix"></div>
                  <?php $this->load->view('accounts/popup_csv_modal');  $this->load->view('layouts/msg');  ?>
                 <div class="panel panel-default transaction">
						<div class="panel-heading pad-none">
                              <ul class="nav tab-menu nav-tabs" id="myTab">
                                  <li class="active"><a href="#all" data-status="all">Confirmed</a></li>
                                  <li><a href="#pending" data-status="pending">Pending</a></li>
                              </ul>
						</div>
                        <div class="clearfix"></div>
						<div class="panel-body">		

						<div id="myTabContent" class="tab-content">
	                                <div class="tab-pane active" id="all">
                                                <!--                             FILTERS START HERE -->
            <div class="filters">
                <form role="form" id="filter_form" name="filter_form" method="get">
                    <div class="row">
                        <div class="col-lg-3 col-md-2 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label class="control-label" for="daterange"> Date Range </label>
                                <div class="controls">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control" id="daterange" value=""  tabindex="1" name="start_close_dates" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="start_date" name="start_date">
                        <input type="hidden" id="closed_date" name="closed_date">
                        
                        <?php $statuses= array(STATUS_CONFIRMED,STATUS_CLOSED); ?>
                        <div class="col-lg-2 col-md-2 col-sm-6 width117">
                            <div class="form-group">
                                <label for="status" class="edit-label">Status</label>
                                <select size="1" class="form-control" name="status" id="status">
                                    <option value="">Select</option>
                                    <?php foreach($statuses as $status) : ?>
                                    <option value="<?php echo $status;?>"><?php echo ucfirst($status);?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        
                        <?php $account_types= array(PI,NonPI); ?>
                        <div class="col-lg-2 col-md-1 col-sm-6 width117">
                            <div class="form-group">
                                <label for="account type" class="edit-label">Account Type</label>
                                <select size="1" class="form-control" name="account_type" id="account_type">  
                                    <option value="">Select</option>      
                                    <?php foreach($account_types as $account_type) : ?>
                                    <option value="<?php echo $account_type;?>"><?php echo $account_type;?></option>
                                    <?php endforeach;?>                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-2 col-sm-4 col-xs-9 full-width search_box">
                            <div class="form-group">
                                <label for="search" class="edit-label">Search</label>
                                <input type="text" placeholder="" class="form-control" name="search" id="search">
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-2 col-xs-3 full-width">
                            <div class="form-group">
                                <label for="search" class="none invisible edit-label">Search</label>
                                <button class="btn btn1" type="submit" ><i class="fa fa-search"></i> <span class="text-hidden">Search</span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
                            <!--                             FILTERS ENDS HERE -->                                        

                                                        <div class="panel-body redeme-table">
                                                        <div id="no-more-tables" class="overflow">
                                                            <table class="table datatable custom-table table-striped select-all " id="all_table"
                                                   data-toggle="table"
                                                   data-hover="true" 
                                                   data-striped="true" 
                                                   data-smart-display="true" 
                                                   data-sort-name="name" 
                                                   data-sort-order="asc"
                                                   data-page-size="20"   
                                                   data-url="<?php echo $url;?>"
                                                   data-pagination="true"                                                   
                                                   data-side-pagination="server"
                                                   data-page-list="[5, 10, 20, 50, 100, 200]">
                            								  <thead>
                                <tr>
                                    <th data-field='chk_box' width="20px;" class="bg-img-none" ><input type="checkbox" name="checkbox1"  class='bulk_action'></th>
                                   <th data-field='name' width="210px" data-sortable="true" >Account Name</th>
                                   <th data-field='fund_account_number' data-sortable="true"  width="100px">Fund.Acc</th>
                                  <th data-field='pi_account_number' data-sortable="true"  width="100px">PI.Acc</th>
                                  <th data-field='custodian' data-sortable="true"  width="100px">Custodian</th>
                                  <th data-field='account_type' width="100px" data-sortable="true" >Type</th>
                                  <th data-field='account_category' width="75px" data-sortable="true" >Category</th>
                                  <th data-field='rmd' width="75px" data-sortable="false" >RMD</th>
                                  <th data-field='status' width="70px" data-sortable="true" >Status</th>
                                  <th data-field='action' width="150px">Action</th>
                                </tr>
                              </thead>
                            </table> 
                                                        </div>            
                                                        </div>
                                                        
								<div class="row">
                            <div class="col-lg-12 tax-con">                          	 
                            	<a href="javascript:;" class="btn btn-success update_status" data-status="<?php echo STATUS_CONFIRMED.'|all|all'; ?>" >Open</a>
                                 <a href="javascript:;" class="btn btn-warning update_status" data-status="<?php echo STATUS_CLOSED.'|all|all'; ?>" >Closed</a>
                                 <a href="javascript:;" class="btn btn-danger update_status" data-status="<?php echo STATUS_DENIED.'|all|all'; ?>">Denied</a>
                            </div> 
                        </div>                                                        
                                        </div>
                                        
                        <div class="tab-pane" id="pending">
							<div class="panel-body redeme-table">
                      			  <div id="no-more-tables" class="overflow">
										<table class="table datatable custom-table table-striped select-all " id="pending_table"
                                                   data-toggle="table"
                                                   data-hover="true" 
                                                   data-striped="true" 
                                                   data-smart-display="true" 
                                                   data-sort-name="name" 
                                                   data-sort-order="desc"
                                                   data-page-size="50"   
                                                   data-pagination="true"                                                    
                                                   data-side-pagination="server"
                                                   data-page-list="[5, 10, 20, 50, 100, 200]">
                              <thead>
                                <tr>
                                    <th data-field='chk_box' width="20px;" class="bg-img-none" ><input type="checkbox" name="checkbox1"  class='bulk_action'></th>
                                   <th data-field='name' width="210px" data-sortable="true" >Account Name</th>
                                   <th data-field='fund_account_number' data-sortable="true"  width="100px">Fund.Acc</th>
                                  <th data-field='custodian' data-sortable="true"  width="100px">Custodian</th>
                                  <th data-field='account_category' width="75px" data-sortable="true" >Category</th>
                                  <th data-field='rmd' width="75px" data-sortable="false" >RMD</th>
                                </tr>
                              </thead>
                        
                            </table>            
                        </div>            
						</div>
                        
                        <a data-target="#relate_confirm_modal" id="relate_confirm" data-toggle="modal">&nbsp;</a>
                        
						<div class="row">
                            <div class="col-lg-12 tax-con">                          	 
                            	 <a href="javascript:;" class="btn btn-success update_status" data-status="<?php echo STATUS_CONFIRMED.'|pending|'.STATUS_PENDING; ?>">Confirm</a>	
                                 <a href="javascript:;" class="btn btn-primary match_datas" data-status="<?php echo STATUS_MATCHED.'|pending|'.STATUS_PENDING; ?>">Match & Confirm</a>	
                                 <a href="javascript:;" class="btn btn-danger update_status" data-status="<?php echo STATUS_DENIED.'|pending|'.STATUS_PENDING; ?>">Denied</a>
                            </div> 
                        </div>  
                        
                        
                        <div  class="modal fade modal-danger" id="relate_confirm_modal" >
  <div class="modal-dialog">
  
  <form method="post" enctype="application/x-www-form-urlencoded">
    <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="color:white;font-size:14px;" >Confirm</h4>
              </div>
              <div class="modal-body" id="relate_popup_msg">
                	Match Funding Account XXX to PI account YYY?
              </div>
     		  <div class="modal-footer">
        <button type="button" class="btn btn-defaultm" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary relate_confirm_status">Yes</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>                      
								</div>
                                
                                
                                        
							</div>
						</div>
					</div>
				</div><!--/col-->
			</div><!--/row-->
		</div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer_script'); ?>


<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
 <script src="<?php echo base_url(); ?>assets/plugins/gritter/js/jquery.gritter.min.js"></script>         
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>         
<script src="<?php echo base_url(); ?>assets/js/daterangepicker.min.js"></script>         


<script type="text/javascript">

    var $all = $('#table');
	//var $pending = $('#pending_table');
	//var $waiting_approval = $('#waiting_approval_table');
	$all.bootstrapTable({
		    method: 'post',
		    contentType: 'application/x-www-form-urlencoded',
		});
		
		
	$(document).ready(function()
	{
		$('#myTab a:first').tab('show');
	
		$('#myTab a').click(function (e) {
	
		  e.preventDefault();
	
		  $(this).tab('show');
		  
		  var attr=$(this).attr('href');
		  
		  	var $refresh_table=$(attr+'_table');
			
			//var record_type=attr.replace('#',''); +'/account_type/'+record_type+'/'
			
			var status=$(this).attr('data-status');
			
			$refresh_table.bootstrapTable('refresh', {
			method:'post',
			url: base_url+'accounts/ajax_fetch_data/filter_status/'+status
			});				

		});
		
		<?php
		if(!empty($record_type))
		{
		?>
		$('a[href=#<?php echo $record_type; ?>]').trigger('click');
		<?php
		}
		?>
		
	$('.relate_confirm_status').click(function()
	{ 
		  var ids = [];
		  
		  var relate_accounts=[];
		  
		  var current_status=[];
		  
		  var account_name=[];
		  
		  var matched=1;
		  
		  $("input.checkbox:checked").each(function ()
		  {
			  ids.push($(this).val());
			  
			  relate_accounts.push($(this).attr('data-account'));
			  
			  current_status.push($(this).attr('data-status'));
			  
		  });
		  
				$.ajax({    
					"type" : "POST",
					"beforeSend": function(){ $(this).html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled','disabled'); },
					"url" : base_url+'accounts/ajax_change_status/',
					"data" : {'current_status':current_status,'ids' : ids,'status':'confirmed','relate_accounts':relate_accounts},
					success: function(data){
						$('#relate_confirm_modal').modal('hide');
						
						$('#gritter_success').trigger('click');
						
						$('a[href=#pending]').trigger('click');
					}
				});				 
		 
		 
	});
		
		$('.match_datas').click(function() { 
			
			 var chked=$('.checkbox:checked').length;
			 
			 if(chked==0)
			 {
				 $('#gritter_required').trigger('click');
				
				return false; 
			 }
			 else if(chked==1)
			 {
				alert("Please select atleast two records for matching");
				
				return false; 
				
			 }
			else  if(chked==2)
			 {
				 
				  var account_number=[];
				  
				  var account_name=[];
				  
				  var record_type=[];
				  
				  var matched=account_type_match=1;
				  
				  $("input.checkbox:checked").each(function ()
				  {
					  account_number.push($(this).attr('data-account'));
					  
					  if($.inArray($(this).attr('data-name'), account_name))
					  {
						account_name.push($(this).attr('data-name'));
					  }
					  else
					  {
							$('.btn-defaultm').trigger('click');
							
							matched=2;
					  }
					   
					  if($.inArray($(this).attr('data-record-type'), record_type))
					  {
						record_type.push($(this).attr('data-record-type'));
					  }
					  else
					  {
							$('.btn-defaultm').trigger('click');
							
							account_type_match=2;
					  }
				  });
				  
				  if(matched==1)
				  {
					alert('Account name for funding & PI account does not match');
					
					return false;
					  
				  }
				  
				  if(account_type_match==2)
				  {
					alert('Please select one PI & Non-PI accounts');
					
					return false;  
				  }
				 
				 var relate_popup_msg='';
				 
				 if(record_type[0]=='PI')
				 relate_popup_msg='<b>'+account_number[1]+'</b> to PI account <b>'+account_number[0]+'</b>';
				 else
				 relate_popup_msg='<b>'+account_number[0]+'</b> to PI account <b>'+account_number[1]+'</b>';
				 
  				 $('#relate_confirm').trigger('click');
				 
				 $('#relate_popup_msg').html('Are you sure to match funding account '+relate_popup_msg+'?');
						
			 }
			 else
			 {
				 alert("Maximum two records can be only selected for matching");
				 
				 return false;
			 }
		
		
		});
        
        //Filters If exists in URL
        <?php if(!empty($filters)): foreach($filters as $name => $val) : ?>
            $('#<?php echo $name;?>').val('<?php echo $val;?>');
        <?php endforeach; endif; ?>
        
                    
       //Date Range Picker
        var $drp = $('#daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear',
                    cancelClass: "btn-danger",
            },
        },function(start, end, label) {
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#closed_date').val(end.format('YYYY-MM-DD'))
        });
    
        //DateRange From Filters 
        <?php if(!empty($daterange)): ?>
                    $('#daterange').val('<?php echo date("m/d/Y",strtotime(str_replace("-","/",$daterange['start_date'])));?> - <?php echo date("m/d/Y",strtotime(str_replace("-","/",$daterange['closed_date'])));?>');
        <?php endif; ?>
        
        //Clear Input 
        $(document).on('click','.cancelBtn',function(){
          $('#daterange').val('');
          $('#start_date,#closed_date').val('');    
        });
        

    
        //ALL TABLE FILTERS
        $('#filter_form').on('submit',function(){
            
            //Empty the dates If no date range specified
            if($('#daterange').val()==''){
                $('#start_date,#closed_date').val('');
            }
            var $params={}, filter_url='';
            //Pushing values in Query Parameters
             $('#filter_form').find(':input').each(function () {
                    if($(this).val() !=''){
                        $params[$(this).attr('name')] = $(this).val();
                    }
              });  
            
            //Forming URL for Address Bar
            $.each($params, function( index, value ){
                if(index!='start_close_dates'){
                    filter_url +=index+'/'+value+'/';                    
                }
            });            
            
            var url='';
            
            //Changing Address Bar URL by Checking If Search Parameters Exists                        
            if( filter_url!=''){                
                
                 var limit=$('#all .page-list').find('.active').text();
                
                 var offset=$('#all .page-list').find('.active').text() * ( $('#all .pagination').find('.active').text() - 1);
                
                var addressbar_url = '<?php echo base_url();?>accounts/index/filter_status/all/'+filter_url+'limit/'+limit+'/offset/'+offset;
                
                var url = '<?php echo base_url();?>accounts/ajax_fetch_data/filter_status/all/'+filter_url
                
                window.history.pushState("", "", addressbar_url);                
                
            }
            else{
                window.history.pushState("", "", '<?php echo base_url();?>accounts/');                    
            }
            
            //Refreshing The Table
            $('#all_table').bootstrapTable('refresh', {
                     url: url
            });			            
            
            return false;
            
        }); //Filter Form Submit Ends Here
    
    });	//Jquery Document Ready Ends Here
    
    
    
		  $("#portfolio_id").select2({
									allowClear: true,
									placeholder: "- - Select - - ",
									 minimumInputLength: 1,									
									 quietMillis: 100,
									 multiple:false,
									  ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
											url: "<?php echo  base_url(); ?>facility_report/ajax_get_residents/",
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
		
     

    
</script>

 <?php $this->load->view('layouts/footer'); ?>