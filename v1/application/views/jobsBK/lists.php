<?php $this->load->view('layouts/header',array('page_name'=>'Listing')); ?>

<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="javascript:void(0);"><i class="fa fa-home"></i>Permits</a></li>
                                <li class="active"><a href="javascript:void(0);">ALL</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                        

                         
                                    <!--progress bar start-->
                                    <section class="panel">
                                    
                                                       
                                        
                                      
                                                  <?php $status='combined';
		  
		  		 $job_approvals=unserialize(JOBAPPROVALS);
		  
			  $zone_id=(isset($filters['zone_id'])) ? $filters['zone_id'] : '';
			  
			  $approval_status=(isset($filters['approval_status'])) ? $filters['approval_status'] : '';
		  
		  
		   ?>	
           					<div class="panel-body ">
                    <a href="<?php echo base_url().$this->data['controller'].'form/'; ?>" role="button" class="pull-right btn btn btn-success"><i class="fa fa-pencil"></i>Create</a></h1><br/>
           <?php $this->load->view('layouts/msg'); $this->load->view('layouts/marquee'); ?>  
          							<div class="filters">
                                        		<form role="form" id="<?php echo $status; ?>_form" name="<?php echo $status; ?>_form" method="post">
                                                
                                                	<div class="row">
                                                        <div class="col-lg-2 col-md-2 col-sm-6 width117">
                                                            <div class="form-group">
                                								<label for="status" class="edit-label">Select Zone</label>
                                                   					<select class="form-control" name="zone_id" id="zone_id" style="width:200px;">
                                                                            <option value="">- - Select Zone - - </option>
                                                                            <?php 	
                                                                                      foreach($zones as $list)
                                                                                      {
                                                                            ?>
                                                                            <option value="<?php echo $list['id'];?>" <?php if($zone_id==$list['id']) { ?> selected="selected" <?php } ?> ><?php echo $list['name'];?></option>
                                                                            <?php 
                                                                                        }
                                                                            ?>
                                                     </select> 
                                                     		</div>
                                                         </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 width117">
                                                            <div class="form-group">
                                								<label for="status" class="edit-label">Approval Status</label>
                                                   					<select class="form-control" name="approval_status" id="approval_status" style="width:200px;">
                                                                            <option value="">- - Select Status - - </option>
                                                                            <?php 	
                                                                                     // for($j=0;$j<count($job_approvals);$j++)
																					 foreach($job_approvals as $approve_id => $approve_name)
                                                                                      {
                                                                            ?>
                                                                            <option value="<?php echo $approve_id;?>" 
																			<?php if($approval_status==$approve_id) { ?> selected="selected" <?php } ?> ><?php echo $approve_name;?></option>
                                                                            <?php 
                                                                                        }
                                                                            ?>
                                                     </select> 
                                                     		</div>
                                                         </div>
                                                     <div class="col-lg-2 col-md-1 col-sm-2 col-xs-3 full-width">
                                                          <div class="form-group">
                                                                        <label for="search" class="none invisible edit-label ">Search</label>
                                                                         <div class="clearfix"></div>
                                                                        <button class="btn btn1 search_data" type="button" data-form-name="<?php echo $status; ?>"><i class="fa fa-search"></i> <span class="text-hidden">Search</span></button>&nbsp;<a href="javascript:void(0);"  style="padding-top:10px;" class="reset" data-status="<?php echo $status; ?>">Reset</a>
                                                            </div>
                        							</div>                                                         
                                                         
                                                         
                                                     </div>       
                                                 </form>       
                                        </div>
                                        
          						    <table class="table custom-table table-striped" id="table"
						           data-toggle="table"
					               data-url="<?php echo base_url().$this->data['controller']; ?>ajax_fetch_data/show_button/show/<?php echo (isset($params_url)) ? $params_url : ''; ?>"
					               data-pagination="true"
								   data-search="true"
								   data-sort-name="id" 
                                   data-sort-order="desc"
						           data-side-pagination="server"
					               data-page-list="[5, 10, 20, 50, 100, 200]">
              <thead>
                <tr>
                	<th data-field='id' width="110px" class="center" data-sortable="true">Permit No</th>
                   <th data-field='job_name' width="210px" data-sortable="true">Permit Desc</th>
                   <th data-field='auth_PA' class="center" width="75px">Auth PA</th>
                   <th data-field='auth_IA' class="center" width="75px">Auth IA</th>
                  <th data-field='approval_status' class="center" width="75px">Approval Status</th>
                  <th data-field='waiating_approval_by' class="center" width="75px">Waiting / Last Approved By</th>
                   <th data-field='created' class="center" data-sortable="true" width="75px">Created</th>
                   <th data-field='modified' class="center" data-sortable="true" width="75px">Last updated on</th>
                   <th data-field='time_diff' class="center" data-sortable="true" width="75px">Expire within</th>
                   <!-- <th data-field='action' class="center" width="75px">Action</th>-->
                </tr>
              </thead>
        
            </table>            

							</div>
                                    </section>
                                    <!--progress bar end-->
                        </div>
                    </div>

                </section>
            </div>
            <!-- Right side column. Contains the navbar and content of the page -->
            	<?php $this->load->view('jobs/popup_show_jobs_history_modal'); ?> 
        </div>
<?php $this->load->view('layouts/footer'); ?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jobs.js"></script>
<script>
    var $table = $('#table');
		$table.bootstrapTable({
		    method: 'post',
		    contentType: 'application/x-www-form-urlencoded',
            //Verifying the data is null or not
            responseHandler:function(res) {
                if(res.rows==null){
                    $table.bootstrapTable('removeAll');
                }
                return res;
            }
		});

	$(document).ready(function()
	{
		$('body').on('click','.reset',function() 
		{
				var data_status=$(this).attr('data-status');	
				
				window.location='<?php echo base_url().$this->data['controller'];?>';;			
		});
		
		$('.search_data').click(function()
		{
				var form_id=$(this).attr('data-form-name');
				//if(form_id=='all')
				var params_url='show_button/show/';

				var i=0;
				//Pushing values in Query Parameters
				  $('form#'+form_id+'_form').find(':input[type=hidden],select,:input[type=text]').each(function ()
				  {
						index= $(this).attr('name');
						
						value= $.trim(encodeURI($(this).val()));
						
						if(value!='' && typeof index!=='undefined' && value!='all')
						{ 
							if(index=='subscription_date' || index=='proceeds_due_by_date')
							value=value.replace(/\//g, '-');
							
							params_url+=index+'/'+value+'/'; i++;

						}
				  });
						$('#table').bootstrapTable('refresh', {
						method:'post',
						url: base_url+'jobs/ajax_fetch_data/'+params_url
						});		
										  
					 window.history.pushState("", "", '<?php echo base_url().$this->data['controller'];?>index/'+params_url);   	
				  
				return false;
			}); //Filter Form Submit Ends Here
		
	});
</script>

