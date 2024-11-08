<?php $this->load->view('layouts/admin_header',array('page_name'=>'Listing'));  ?>
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap.css" rel="stylesheet">
<style type="text/css"> .export { visibility:hidden !important; }</style>
<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="javascript:void(0);"><i class="fa fa-home"></i>Reports</a></li>
                                <li class="active"><a href="javascript:void(0);">Electrical Permit Reports</a></li>
                            </ul>
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                                    <!--progress bar start-->
                                    <section class="panel">
                                       <div class="panel-body ">
                                       	
                            <?php $this->load->view('layouts/msg');  $status_arr=array('PA'=>'Performing Authority','IA'=>'Issuing Authority','all'=>'All'); $active=''; ?>
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
                <div class="panel-body">
          					  <div id="myTabContent" class="tab-content">            						
                        <?php
      								  
      								  $job_approvals=unserialize(JOBAPPROVALS);

      								  foreach($status_arr as $status => $status_name)
      								  {
      									  if($filters['filter_status']==$status)
      									  $active='active';
      									  else
      									  $active='';									  
      								  ?>	    
                                    <div class="tab-pane <?php echo $active; ?>" id="<?php echo $status; ?>">
                                    
                                    	<?php $this->load->view('layouts/reports_filter_options',array('status'=>$status,'job_approvals'=>$job_approvals)); ?>                                       
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
                                       <th data-field='chk_box' width="20px;" class="bg-img-none" align="center" ><input type="checkbox" name="checkbox1"  class='bulk_action'></th>
                                       <th data-field='id' width="210px" class="center" data-sortable="true">Permit No</th>
                                       <th data-field='job_name' width="210px" data-sortable="true">Permit Desc</th>
                                       <th data-field='approval_status' class="center" width="75px">Approval Status</th>
                                       <th data-field='waiating_approval_by' class="center" width="75px">Waiting / Approved By</th>
                                       <th data-field='status' class="center" data-sortable="true" width="75px">Permit Status</th>
                                       <th data-field='created' class="center" data-sortable="true" width="75px">Created</th>
                   <th data-field='modified' class="center" data-sortable="true" data-sortable="true" width="75px">Last updated on</th>
                   <th data-field='time_diff' class="center" data-sortable="true" width="75px">Expire within</th>
                   <th data-field='extended_missed_dates' class="center" data-sortable="false" width="75px">Ext. Date</th>
                                      <!-- <th data-field='action' class="center" width="75px">Action</th> -->
                                    </tr>
                                  </thead>
                            
                                </table>            
                              </div>

<a href="javascript:void(0)" tableexport-id="<?php echo $status; ?>_table" tableexport-filename="Electrical Permit Report" class="btn btn-success export_csv">Export to XLS</a>
<a data-url="<?php echo base_url().$controller; ?>ajax_change_status" data-table="<?php echo ELECTRICALPERMITS; ?>" data-table-id="<?php echo $status; ?>_table"  data-modal-class="modal-danger" data-button-class="btn btn-danger" class="btn btn-danger change_reports_status">Self Cancel</a>

                                    </div>
                                  <?php
								  }
								  ?>
          
          	</div>
          		 		</div>
                        
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
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-table-export.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableExport.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableexport-xls-bold-headers.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>
<link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">$(document).ready(function() { $('a[href=#<?php echo $filters['filter_status']; ?>]').trigger('click'); });</script>