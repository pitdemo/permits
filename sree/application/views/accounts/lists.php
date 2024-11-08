<?php $this->load->view('layouts/header',array('page_name'=>'Listing')); ?>
		<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap.css" rel="stylesheet">
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
                  <a data-target="#myModal" data-toggle="modal" data-backdrop="static" data-keyboard="false" role="button" class="pull-right btn btn-primary"><i class="fa fa-share-square-o"></i>Import</a>
                  <a href="javascript:;"  onClick="javascript:get_access_token('');" class="pull-right btn btn-flickr" role="button">Process</a>
                  </h1>
                 <div class="clearfix"></div>
                  <?php $this->load->view('accounts/popup_modal');  $this->load->view('layouts/msg');  ?>
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
                                    
						<div class="filters">
                <form role="form" id="filter_form" name="filter_form" method="post">
                    <div class="row">
                        <?php $statuses= array(STATUS_MATCHED,STATUS_CONFIRMED,STATUS_CLOSED); ?>
                        <div class="col-lg-3 col-md-2 col-sm-6 width117">
                            <div class="form-group">
                                <label for="status" class="edit-label">Status</label>
                                <select size="1" class="form-control" name="filter_status" id="filter_status">
                                    <option value="">Select</option>
                                    <?php foreach($statuses as $status) : ?>
                                    <option value="<?php echo $status;?>" <?php if(isset($filters['filter_status']) && $filters['filter_status']==$status) { ?> selected <?php } ?>><?php echo ucfirst($status);?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        
                        <?php $account_types= array(PI,NonPI); ?>
                        <div class="col-lg-3 col-md-1 col-sm-6 width117">
                            <div class="form-group">
                                <label for="account type" class="edit-label">Account Type</label>
                                <select size="1" class="form-control" name="account_type" id="account_type">  
                                    <option value="">Select</option>      
                                    <?php foreach($account_types as $account_type) : ?>
                                    <option value="<?php echo $account_type;?>" <?php if(isset($filters['account_type']) && $filters['account_type']==$account_type) { ?> selected <?php } ?>><?php echo $account_type;?></option>
                                    <?php endforeach;?>                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-2 col-sm-4 col-xs-9 full-width search_box">
                            <div class="form-group">
                                <label for="search" class="edit-label">Search</label>
                                <input type="text" placeholder="" class="form-control" name="search" id="search" value="<?php echo (isset($filters['search'])) ? $filters['search'] : ''; ?>">
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
                                                   data-search="false"                            
                                                   data-pagination="true"
                                                   data-side-pagination="server"
                                                   data-page-list="[5, 10, 20, 50, 100, 200]">
                            								  <thead>
                                <tr>
                                    <th data-field='chk_box' width="20px;" class="bg-img-none" ><input type="checkbox" data-checked="all" name="checkbox1"  class='bulk_action'></th>
                                   <th data-field='name' width="210px" data-sortable="true" >Account Name</th>
                                   <th data-field='fund_account_number' data-sortable="true"  width="100px">Fund.Acc</th>
                                  <th data-field='pi_account_number' data-sortable="true"  width="100px">PI.Acc</th>
                                  <th data-field='custodian' data-sortable="true"  width="100px">Custodian</th>
                                  <th data-field='account_type' width="100px" data-sortable="true" >Type</th>
                                  <th data-field='tax_status' width="75px" data-sortable="true" >Category</th>
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
                            	<a href="javascript:;" class="btn btn-primary match_datas" data-checked="all" data-status="<?php echo STATUS_MATCHED.'|all|'.STATUS_PENDING; ?>">Match</a>	     
                            	<a href="javascript:;" class="btn btn-success update_status" data-checked="all" data-status="<?php echo STATUS_CONFIRMED.'|all|all'; ?>" >Open</a>
                                 <a href="javascript:;" class="btn btn-warning update_status" data-checked="all" data-status="<?php echo STATUS_CLOSED.'|all|all'; ?>" >Closed</a>
                                 <a href="javascript:;" class="btn btn-danger update_status" data-checked="all" data-status="<?php echo STATUS_DENIED.'|all|all'; ?>">Denied</a>
                                 <a href="javascript:;" class="btn btn-warning active unmatch" data-checked="all" data-status="<?php echo STATUS_MATCHED.'|all|all'; ?>">Unmatch</a>
                            </div> 
                        </div>     
                        
                        
<?php $this->load->view('accounts/popup_unmatch'); ?>                                                                           
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
                                                   data-search="true"                            
                                                   data-pagination="true"
                                                   data-side-pagination="server"
                                                    data-search-text="<?php echo (isset($filters['fund_account_number'])) ? $filters['fund_account_number'] : ""; ?>"
                                                   data-page-list="[5, 10, 20, 50, 100, 200]">
                              <thead>
                                <tr>
                        <?php
						if(in_array(constant($this->session->userdata('user_role')),array(CIO,DCS)))
						{
						?>	
                                
                                    <th data-field='chk_box' width="20px;" class="bg-img-none" ><input type="checkbox" name="checkbox1" data-checked="pending"  class='bulk_action'></th>
						<?php
						}
						?>
                                   <th data-field='name' width="210px;" data-sortable="true" >Account Name</th>
                                   <th data-field='fund_account_number'  data-sortable="true"  width="100px">Fund.Acc</th>
                                  <th data-field='custodian' data-sortable="true"  width="100px">Custodian</th>
                                  <th data-field='tax_status' width="75px" data-sortable="true" >Category</th>
                                  <th data-field='rmd' width="75px" data-sortable="false" class="center" >RMD</th>
                                </tr>
                              </thead>
                        
                            </table>            
                        </div>            
						</div>
                        
                        <?php
						if(in_array(constant($this->session->userdata('user_role')),array(CIO,DCS)))
						{
						?>	
						<div class="row">
                            <div class="col-lg-12 tax-con">                          	 
                            	 <a href="javascript:;" class="btn btn-success update_confirm_status" data-checked="pending" data-status="<?php echo STATUS_CONFIRMED.'|pending|'.STATUS_PENDING; ?>">Confirm NON-PI</a>	
                                 <a href="javascript:;" class="btn btn-primary match_datas" data-checked="pending" data-status="<?php echo STATUS_MATCHED.'|pending|'.STATUS_PENDING; ?>">Match & Confirm</a>	
                                 <a href="javascript:;" class="btn btn-danger update_status" data-checked="pending" data-status="<?php echo STATUS_DENIED.'|pending|'.STATUS_PENDING; ?>">Denied</a>
                            </div> 
                        </div>  
                        <?php
						}
						?>
                        
                            
                  
								</div>
       
                          <a data-target="#relate_confirm_modal" id="relate_confirm" data-toggle="modal">&nbsp;</a>
                        
                         <a data-target="#unrelate_confirm_modal" id="unrelate_confirm" data-toggle="modal">&nbsp;</a>
                                
                                
<?php $this->load->view('accounts/popup_match'); ?>                                  
                                        
							</div>
						</div>
					</div>
				</div><!--/col-->
			</div><!--/row-->
		</div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer_script'); ?>

<script src="<?php echo base_url(); ?>assets/js/accounts.js"></script> 
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
 <script src="<?php echo base_url(); ?>assets/plugins/gritter/js/jquery.gritter.min.js"></script>         


<script type="text/javascript">

	$(document).ready(function()
	{
	//	$('#myTab a:first').tab('show');
	
		$('#myTab a').click(function (e) {
	
		  e.preventDefault();
	
		  $(this).tab('show');
		  
		  $('.bulk_action').removeAttr('checked');
		  
		  var attr=$(this).attr('href');
		  
		  	var $refresh_table=$(attr+'_table');
			
			var status=$(this).attr('data-status');
			
			//var search_text=$.trim($('#'+status+' :input').val());
			
			console.log('SS '+$('#'+status+' :input').attr('name'));
			
			var params_url='/';
			
			if(status=='all')
			{
				var i=0;
				
				  $('#filter_form').find(':input').each(function ()
				  {
						index= $(this).attr('name');
						
						value= encodeURIComponent($(this).val());
						
						if(index == 'filter_status')
						{
							if($.trim(value)=='')
							value='all';
							
							params_url+=index+'/'+value+'/'; i++;
						}
						else if(index == 'account_type' || index == 'search')
						{
							if($.trim(value)!='')
							{ 
								params_url+=index+'/'+value+'/'; i++;
							}
						}

				  });  
				
			}
			else
			{
				params_url+='filter_status/'+status;
			}
			
			$refresh_table.bootstrapTable('refresh', {
			method:'post',
			url: base_url+'accounts/ajax_fetch_data/'+params_url
			});	
			
				/*if(search_text!='')
				params_url+='/search/'+search_text; */
			
			
		 	window.history.pushState("", "", '<?php echo base_url();?>accounts/index/'+params_url);   			
			
			if($('#filter_form').length>0)
			$('#filter_form')[0].reset();

		});
		
		<?php
		
		$f_status=$filters['filter_status'];
				if(in_array($f_status,array('all',STATUS_CONFIRMED,STATUS_MATCHED,STATUS_CLOSED)))
					$f_status='all';
				else
					$f_status=STATUS_PENDING;	
		?>
		$('a[href=#<?php echo $f_status; ?>]').trigger('click');
		
		$('.relate_confirm_status').click(function()
		{
			var chked=$('.check_fund_name').length;
			
			if(chked==0)
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
				
				  var status_of_data = current_status[0];
				  jObject = '{"'+relate_accounts[0]+'":"'+relate_accounts[1]+'"}';
			}
			else
			{
				 var chked=$('.check_fund_name:checked').length;
			
				  if(chked==0)
				  {
					alert('Please select atleast one'); 
					return false;
				  }
				  var ids = [];
		  
				  var fund_account_num=[];
				  
				  var fund_account_pi_num=[];
				  
				  var data_status=[];
				  
				  var matched=1;
				  
				  $(".check_fund_name:checked").each(function ()
				  {
					  
					  ids.push($(this).val());
					  
					  fund_account_num.push($(this).attr('data-fund_account_no'));
					  
					  fund_account_pi_num.push($(this).attr('data-pi_fund_account_no'));
					  
					  data_status.push($(this).attr('data-status'));
					  
				  });
				 Array.prototype.associate = function (keys) {
				  var result = {};
				
				  this.forEach(function (el, i) {
					result[keys[i]] = el;
				  });
				
				  return result;
				};
				var status_of_data = data_status[0];
				var fund_acc_and_pi_number=[];
				fund_acc_and_pi_number = (fund_account_pi_num.associate(fund_account_num));
				jObject = JSON.stringify(fund_acc_and_pi_number);  
			}
			$.ajax({    
						"type" : "POST",
						"beforeSend": function(){ $("#form button[name='yes_button']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled','disabled'); },
						"url" : base_url+'accounts/ajax_match_confirm_status/',
						"data" : {fund_acc_pi_number:jObject,datastatus:status_of_data},
						success: function(data){ 
							$('#relate_confirm_modal').modal('hide');
							
							$('#gritter_success').trigger('click');
							
							var refresh_tab=$("#myTab li.active a").attr("href")
							
							$('a[href='+refresh_tab+']').trigger('click');
							$("html, body").animate({ scrollTop: 0 }, "slow");
						},
					complete: function() { $("#form button[name='yes_button']").html("Yes").attr('disabled',false); }
					}); 
		});

			//ALL TABLE FILTERS
			$('#filter_form').submit(function()
			{
				var params_url='';
				
				var i=0;
				//Pushing values in Query Parameters
				  $('#filter_form').find(':input').each(function ()
				  {
						index= $(this).attr('name');
						
						value= encodeURIComponent($(this).val());
						
						if(index == 'filter_status')
						{
							if($.trim(value)=='')
							value='all';
							
							params_url+=index+'/'+value+'/'; i++;
						}
						else if(index == 'account_type' || index == 'search')
						{
							if($.trim(value)!='')
							{ 
								params_url+=index+'/'+value+'/'; i++;
							}
						}

				  });  
				  
				  if(i>0)
				  {
						$('#all_table').bootstrapTable('refresh', {
						method:'post',
						url: base_url+'accounts/ajax_fetch_data/'+params_url
						});		
										  
					 window.history.pushState("", "", '<?php echo base_url();?>accounts/index/'+params_url);   
				  }	
				  
				return false;
				
			}); //Filter Form Submit Ends Here

		
	});		 
	
	function get_access_token(params)
	{
		base=base_url+'api/get_batch_access_token/<?php echo $api_params; ?>';
		
		if(params=='')
			data_url=base+'type/token';
		else
		data_url=base+params;	
		
		$.ajax({
				url:data_url,
				type: 'POST',
				"beforeSend": function(){ 						
								$('#api_response').show();						
								$('#api_response_msg').html('Start to call API');
				},
				data: {'id':5},
				cache: false,
				dataType: 'json',
				processData: false, // Don't process the files
				contentType: false, // Set content type to false as jQuery will tell the server its a query string request
				success: function(data, textStatus, jqXHR)
				{
					var css_class='';
					
					var response_msg=data.message;
					
					if(data.status)
					{
						if(data.status=='confirmed')
						css_class='alert alert-success';
						else if(data.status=='denied')
						css_class='alert alert-danger';
						
						if(data.type=='batch')
						{
							setTimeout(get_access_token, 300000,'type/accounts');
						}
						
						$('#api_response').attr('class',css_class).show();
						
						$('#api_response_msg').html(response_msg);
					}
					
					$('#body').html(data.message+' - Type '+data.type);
					
					//$('#body').html('Inner'+jqXHR+' - '+textStatus+' - '+data);
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
					
					$('#body').html('Failed Inner'+jqXHR+' - '+textStatus+' - '+errorThrown);
					// Handle errors here
				}
			});		
		
		
	}
			
</script>

 <?php $this->load->view('layouts/footer'); ?>

