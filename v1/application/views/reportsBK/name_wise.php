<?php $this->load->view('layouts/admin_header',array('page_name'=>'Combined Permits')); ?>
<style>
    .label:hover{
        cursor: pointer; cursor: hand;
    }
  .custom-table.select-all tr td:first-child { width:350px !important; }
  .export { visibility:hidden !important; }
  td.center { text-align: center !important;  }
</style>
    <link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap.css" rel="stylesheet">
<!-- start: Content -->

<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="javascript:void(0);"><i class="fa fa-home"></i>Reports</a></li>
                                <li class="active"><a href="javascript:void(0);">Combined Permits</a></li>
                            </ul>
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            
                                    <!--progress bar start-->
                                    <section class="panel">
                                    <div class="panel-body">
                    <?php $this->load->view('layouts/msg'); ?>
                  
                    <div id="no-more-tables" class="overflow768">     
                    
                  <form name="filter_form" id="filter_form">
                  
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
                                <button type="button" class="btn btn1 department_search" ><i class="fa fa-search"></i> Search</button> 
                          </div>
                                    </div>
                     </div>                       
                </form>   
                      
                        <?php $params = '?subscription_date_start='.$subscription_date_start.'&subscription_date_end='.$subscription_date_end; ?>
            <table class="report_table  custom-table table-striped"
                        data-toolbar="#toolbar"
                       data-toggle="table"
                         data-pagination="true"
                   data-sort-name="no_of_permits" 
                                   data-sort-order="asc"
                                    data-show-export="true"
                                   data-page-size="50"   
                                   data-page-list="[25,50,All]"
                                     data-export-options='{"fileName": "department_wise_report"}'
                                     data-pagination-V-Align="both"
                                   data-url="<?php echo base_url(); ?>reports/ajax_search_department_wise<?php echo $params; ?>"
                         >
                          <thead>
                            <tr>
                               <th data-field='department_name' width="210px" data-sortable="true">Departments</th>
                               <?php
                               foreach($this->permit_types as $permit_type => $permit_label)
                               {
                               ?>
                               <th data-field='<?php echo $permit_type; ?>' class="center" data-sortable="false" width="70px"><?php echo $permit_label; ?></th>
                               <?php 
                                }
                             ?>
                             <th data-field='total_permits' class="center" data-sortable="false">Total</th>
                            </tr>
                          </thead>
              <tbody id="show_investment">
                             </tbody>                          
            </table>         
                    <div>&nbsp;</div>   

              
                    <a href="javascript:void(0)" data-export-type="0" role="button" class="export_csv pull-left btn btn-success">Export CSV</a>
           <a href="javascript:void(0)" style="margin-left:20px;" data-export-type="1" role="button" class="export_csv pull-left btn btn-primary">Export XLS</a>
                           
             

            </div>

        </div>
        <!--/col--> 

    </div>
    <!--/row--> 

</div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer'); ?>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-table-export.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableExport.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>
<link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet" type="text/css" />
