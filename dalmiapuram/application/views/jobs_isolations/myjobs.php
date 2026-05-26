<?php $this->load->view('layouts/header',array('page_name'=>'My Jobs')); ?>
<style>
    .label:hover{
        cursor: pointer; cursor: hand;
    }
</style>
<!-- start: Content -->
<div class="main acccount-con min-height">
  <div class="row mr-none">
    <div class="col-lg-12">
      <h1><?php echo ucfirst(rtrim($this->data['controller'],'/')); ?> <a href="<?php echo base_url().$this->data['controller'].'form/'; ?>" role="button" class="pull-right btn btn btn-success"><i class="fa fa-pencil"></i>Create</a></h1>
      <div class="panel panel-default">
       
            <?php $this->load->view('layouts/msg'); $status_arr=array('PA'=>'Performing Authority','IA'=>'Issuing Authority'); $active=''; ?>
            
                 <div class="panel panel-default transaction">
                 
						<div class="panel-heading pad-none">
							<ul class="nav tab-menu nav-tabs" id="myTab">
                            	<?php
								$s=0;
								foreach($status_arr as $status => $status_name)
								{
								?>
                                
                                <li <?php echo ($s==0) ? 'class="active"' : ''; ?>><a href="#<?php echo $status; ?>" data-status="<?php echo $status; ?>"><?php echo ucfirst($status_name); ?></a></li>
                                		
								<?php	
									$s++;
								}
								?>
                        	</ul>
                        </div>
                            
            
                                    <div class="clearfix"></div>

       				      <div class="panel-body">
          					  <div id="myTabContent" class="tab-content">
            						
                                  <?php
								  foreach($status_arr as $status => $status_name)
								  {
									  if($filters['filter_status']==$status)
									  $active='active';
									  else
									  $active='';
								  ?>	    
                                    <div class="tab-pane <?php echo $active; ?>" id="<?php echo $status; ?>">
                                    
                                        <div id="no-more-tables" class="overflow768">
                                           <table width="100%" class="table datatable custom-table table-striped select-all " id="<?php echo $status; ?>_table"
                                     data-toggle="table"
                                     data-hover="true" 
                                     data-striped="true" 
                                     data-smart-display="true" 
                                     data-sort-name="id" 
                                     data-sort-order="desc"
                                     data-page-size="20"   
                                     data-search="true"                            
                                     data-pagination="true"
                                     data-side-pagination="server"
                                     data-page-list="[5, 10, 20, 50, 100, 200]">
                                                       
                                  <thead>
                                    <tr>
                                       <th data-field='id' width="210px" class="center" data-sortable="true">Permit No</th>
                                       <th data-field='job_name' width="210px" data-sortable="true">Job Name</th>
                                       <!--<th data-field='name' width="100px" data-sortable="true">Contactor Name</th>
                                       <th data-field='location' width="100px">Location</th>-->
                                       <th data-field='approval_status' class="center" width="75px">Approval Status</th>
                                       <th data-field='status' class="center" width="75px">Job Status</th>
                                       <th data-field='created' class="center" width="75px">Created</th>
                                    </tr>
                                  </thead>
                            
                                </table>            
                              </div>
                              
                                    </div>
                                  <?php
								  }
								  ?>
          
          	</div>
          		 		</div>           
        </div>   
        
<?php $this->load->view('jobs/popup_show_jobs_history_modal'); ?>                                  
      </div>
     
    </div>
    <!--/col--> 
    
  </div>
  <!--/row--> 
  
</div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer_script'); $this->load->view('layouts/footer'); ?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jobs.js"></script>
<script>

	$(document).ready(function()
	{

		$('#myTab a').click(function (e)
		 {
	
		  		e.preventDefault();
				
		  		$(this).tab('show');
		  
		  		$('.bulk_action').removeAttr('checked');
		  
		  	var attr=$(this).attr('href');
			
			
		  
		  	var $refresh_table=$(attr+'_table');
			
			var status=$(this).attr('data-status');
			
			
			console.log('AA ' +attr+' - '+$refresh_table);
			
			var i=0;
			
			var params_url='user_role/'+status+'/';
			 
			$refresh_table.bootstrapTable('refresh', {
			method:'post',
			responseHandler: function(res) { console.log('Test'); },
			url: base_url+'jobs/ajax_myjobs_fetch_data/'+params_url
			}).on('page-change.bs.table', function (e, size, number) {
				
				//var x=confirm('Are you sure '+size+' , '+number); if(x==false) return false;
				
      		  	//console.log('Event: page-change.bs.table');
   			 }).on('post-body.bs.table', function (data) {
      		  	//console.log('Event: '+data);
   			 }).on('all.bs.table', function (e, name, args) {
               // console.log('load-success');
            });	
			
			console.log('SSS '+params_url);
			
		 	window.history.pushState("", "", '<?php echo base_url().$this->data['controller'];?>myjobs/'+params_url);   			
		});
		
		$('a[href=#<?php echo $filters['filter_status']; ?>]').trigger('click');
	});
    /*var $table = $('#table');
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
		*/
</script>