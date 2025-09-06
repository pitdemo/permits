<?php $this->load->view('layouts/header',array('page_name'=>'Time Calculation of LOTO')); ?>
<style>
    .label:hover{
        cursor: pointer; cursor: hand;
    }
	.export { visibility:hidden !important; }
</style>
		<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap.css" rel="stylesheet">

<!-- start: Content -->
<div class="main acccount-con min-height">
  <div class="row mr-none">
    <div class="col-lg-12">
      <div class="panel panel-default">
      <h1>Time Calculation of LOTO</h1>
        <div class="acc-header acc-header1">
        	
        </div>
        <div class="panel-body">
            <?php $this->load->view('layouts/msg'); ?>
          <div id="no-more-tables" class="overflow768">
          
          		<form name="filter_form" id="filter_form">
                	
                    <?php
					$selected_departments=(isset($selected_departments)) ? explode(',',$selected_departments) : array();
					
					$selected_zones=(isset($selected_zones)) ? explode(',',$selected_zones) : array();
					
					$selected_users=(isset($selected_users)) ? explode(',',$selected_users) : array();
					
					$permit_no=(isset($permit_no)) ? $permit_no : '';
					?>
					<div class="row">    
                                 <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Loto Start Date</label>
                                                              <div class="controls">
                                                                  <div class="input-group date">
                                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                      <input type="text" class="form-control date-picker" name="subscription_date_start" id="subscription_date_start" data-date-format="dd/mm/yyyy" readonly value="<?php echo $subscription_date_start; ?>">
                                                                  </div>
                                                              </div>
                                                      </div>
                                                          </div>
                                                          
                               <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Loto End Date</label>
                                                              <div class="controls">
                                                                  <div class="input-group date">
                                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                      <input type="text" class="form-control date-picker" name="subscription_date_end" id="subscription_date_end" data-date-format="dd/mm/yyyy" readonly value="<?php echo $subscription_date_end; ?>">
                                                                  </div>
                                                              </div>
                                                      </div>
                                                          </div>
                                                          
                                                          
								<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Departments</label>
                                                              <div class="controls">
                                                                   <select class="form-control department_list select2" name="departments[]" id="departments[]" multiple="multiple">
                                    <option value="">- - Show All - - </option>
                                    <?php if(!empty($departments))
									{
                                        foreach($departments as $list)
										{
											$id=$list['id'];
											
											if(in_array($id,$selected_departments))
											$sel='selected=selected';
											else
											$sel='';
									?>
                                    <option value="<?php echo $id;?>" <?php echo $sel; ?> ><?php echo $list['name'];?></option>
                                    <?php }} ?>
                                </select>         
                                                              </div>
                                                      </div>
                                                          </div>        
                                                          
                                                          
									<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Zones</label>
                                                              <div class="controls">
                                                                   <select class="form-control zones_list select2" name="zones[]" id="zones[]" multiple="multiple">
                                    <option value="">- - Show All - - </option>
                                    <?php if(!empty($zones))
										  {
                                            foreach($zones as $list)
										   {
											   	$id=$list['id'];
												
											if(in_array($id,$selected_zones))
											$sel='selected=selected';
											else
											$sel='';
												
									?>
                                    <option value="<?php echo $id;?>" <?php echo $sel; ?>><?php echo $list['name'];?></option>
                                    <?php }} ?>
                                </select>         
                                                              </div>
                                                      </div>
                                                          </div>
                     </div>    
                     
                     <div class="row">    
                                 
                                                          
                                                          <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Permit Status</label>
                                                              <div class="controls">
                                                                   <select class="form-control permit_status select2" name="permit_status" id="permit_status" multiple="multiple">
                                    <option value="">- - Show All - - </option>
                                    <?php 
									$work_types=array(STATUS_OPENED,STATUS_CLOSED);
									
								#	$work_types = array_merge($work_types,unserialize(CLOSED_PERMITS));
									
                                        foreach($work_types as $list)
										{
											if(in_array($list,$selected_permit_status))
											$sel='selected=selected';
											else
											$sel='';
									?>
                                    <option value="<?php echo $list;?>" <?php echo $sel; ?> ><?php echo ucfirst(str_replace('_',' ',$list));?></option>
                                    <?php } ?>
                                </select>         
                                                              </div>
                                                      </div>
                                                          </div>
                                                          
                                                          <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Associated Permit.NO</label>
                                                              <div class="controls">
                                                                   <input type="text" name="permit_no" id="permit_no" class="form-control" value="<?php echo $permit_no; ?>" />    
                                                              </div>
                                                      </div>
                                                          </div>
                                                          
                                                          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Users</label>
                                                              <div class="controls">
                                                                   <select class="form-control users_list select2" name="users" id="users" >
                                    <option value="">- - Show All - - </option>
                                    <?php if(!empty($users))
									{
                                        foreach($users as $list)
										{
											$id=$list['id'];
											
											if(in_array($id,$selected_users))
											$sel='selected=selected';
											else
											$sel='';
									?>
                                    <option value="<?php echo $id;?>" <?php echo $sel; ?> ><?php echo $list['first_name'];?></option>
                                    <?php }} ?>
                                </select>         
                                                              </div>
                                                      </div>
                                                          </div>
                                                          
                                                          <div class="col-lg-1 col-md-6 col-sm-6 col-xs-6 full-width">
                                    	<div class="form-group">
                                        <label class="none invisible" for="search">Search</label>
                                        <div class="clearfix"></div>
			                        	<button type="button" class="btn btn1 time_calc_loto_search" ><i class="fa fa-search"></i> Search</button> 
			                    </div>
                                    </div>
                     </div>                  
                </form>     
                        <br>

                  <table class="table datatable custom-table table-striped select-all" id="search_table"
                                     data-toggle="table"
                                     data-hover="true" 
                                     data-striped="true" 
                                     data-smart-display="true" 
                                     data-sort-name="j.id" 
                                     data-sort-order="desc"
                                     data-page-size="50"   
                                     data-search="false"                            
                                     data-pagination="true"
                                     data-side-pagination="server"
                                     data-show-export="true"
                                     data-export-options='{"fileName": "loto_time_calc_report"}'
                                     data-pagination-V-Align="both"
                                     
                                     data-page-list="[100, 150, 200, 250,All]">
                          <thead>
                                    <tr>
                                            <th data-field='id' width="210px" class="center" data-sortable="true">SL.NO</th>
                                           <th data-field='auth_PA' class="center" width="75px">Auth PA</th>
                                           <th data-field='remarks_performing_date' class="center" width="75px">PA App. Date</th>
                                           <th data-field='remarks_issuing_date' class="center" width="75px">IA App. Date</th>
                                           
                                           <th data-field='ia_time_diff' class="center" width="75px">PA to IA time diff</th>
                                           <th data-field='auth_IA' class="center" width="75px">Auth IA</th>
                                           <th data-field='final_submit_diff' class="center" width="75px">Final Submit Diff</th>                                           <th data-field='status' class="center" width="75px">Status</th>
                                    </tr>
                          </thead>
 							<tbody id="show_investment">
                             </tbody>                          
            </table>            
          </div>
          
                     <a href="javascript:void(0)" data-export-type="0" role="button" class="export_csv pull-left btn btn-success">Export CSV</a>
           <a href="javascript:void(0)" style="margin-left:20px;" data-export-type="1" role="button" class="export_csv pull-left btn btn-primary">Export XLS</a>

          
        </div>   
        
                            
      </div>
     
    </div>
    <!--/col--> 
    
  </div>
  <!--/row--> 
  
</div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer_script'); $this->load->view('layouts/footer'); ?>
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-table-export.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableExport.js"></script>

<script src="<?php echo base_url(); ?>assets/js/reports.js"></script> 
<script type="text/javascript">
	$(document).ready(function() { 
		 $('.select2').select2({
			  placeholder: "- - Select - -",
			  allowClear: true	 
		});
		
		$('.time_calc_loto_search').trigger('click');
	});
</script>