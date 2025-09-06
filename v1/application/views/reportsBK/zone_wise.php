<?php $this->load->view('layouts/header',array('page_name'=>'Zone Wise')); ?>
<style>
    .label:hover{
        cursor: pointer; cursor: hand;
    }
	.btn-group { visibility:hidden !important; }
</style>
<!-- start: Content -->
<div class="main acccount-con min-height">
  <div class="row mr-none">
    <div class="col-lg-12">
      <div class="panel panel-default">	
      			<h1>Zone wise permit report</h1>
        <div class="acc-header acc-header1">
          <form role="form">
            
          </form>
        </div>
        <div class="panel-body">
            <?php $this->load->view('layouts/msg'); ?>
          <div id="no-more-tables" class="overflow768">
         
					<div class="row">    
                                 <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Permit Start Date</label>
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
                                                              <label class="control-label labeledit" for="date01">Permit End Date</label>
                                                              <div class="controls">
                                                                  <div class="input-group date">
                                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                      <input type="text" class="form-control date-picker" name="subscription_date_start" id="subscription_date_end" data-date-format="dd/mm/yyyy" readonly value="<?php echo $subscription_date_end; ?>">
                                                                  </div>
                                                              </div>
                                                      </div>
                                                          </div>
                                                          
                                                          <div class="col-lg-1 col-md-6 col-sm-6 col-xs-6 full-width">
                                    	<div class="form-group">
                                        <label class="none invisible" for="search">Search</label>
                                        <div class="clearfix"></div>
			                        	<button type="button" class="btn btn1 zone_search" ><i class="fa fa-search"></i> Search</button> 
			                    </div>
                                    </div>
                     </div>                      
                        <br>

          	<?php $params = '?subscription_date_start='.$subscription_date_start.'&subscription_date_end='.$subscription_date_end; ?>
            <table class="report_table  custom-table table-striped"
            					  data-toolbar="#toolbar"
						           data-toggle="table"
					               data-pagination="true"
								   data-sort-name="no_of_permits" 
                                   data-sort-order="desc"
                                    data-show-export="true"
                                   data-page-size="50"   
                                   data-page-list="[25,50,All]"
                                     data-export-options='{"fileName": "zone_wise_report"}'
                                     data-pagination-V-Align="both"
                                   data-url="<?php echo base_url(); ?>reports/ajax_search_zone_wise<?php echo $params; ?>"
					               >
                          <thead>
                            <tr>
                               <th data-field='zone_name' width="210px" data-sortable="true">Zone Name</th>
                               <th data-field='no_of_permits' class="center" data-sortable="true" width="70px">No of permits</th>
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
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/bootstrap-table-export.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableExport.js"></script>
