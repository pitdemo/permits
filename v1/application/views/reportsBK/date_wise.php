<?php $this->load->view('layouts/admin_header',array('page_name'=>'Date wise')); ?>
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
                                <li ><a href="javascript:void(0);">Common</a></li>
                                <li class="active"><a href="javascript:void(0);">Date wise</a></li>
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
                                                      <input type="text" class="form-control date-picker" name="subscription_date_end" id="subscription_date_end" data-date-format="dd/mm/yyyy" readonly value="<?php echo $subscription_date_end; ?>">
                                                  </div>
                                              </div>
                                         </div>
                                 </div>

                                                  
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                  <label class="control-label labeledit" for="date01">Zones</label>
                                  <div class="controls">
                                  <select class="form-control zones_list select2" name="zones[]" id="zones[]" multiple="multiple">
                                  <option value="">- - Show All - - </option>
                                    <?php 
                                        if(!empty($zones))
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
                                                          
                                 <div class="col-lg-1 col-md-6 col-sm-6 col-xs-6 full-width">
                                      <div class="form-group">
                                        <label class="none invisible" for="search">Search</label>
                                        <div class="clearfix"></div>
                                        <button type="button" class="btn btn1 search" data-url="date_wise" ><i class="fa fa-search"></i> Search</button> 
                                      </div>
                                </div>
                     </div>                       
                </form>   
                      
                        <?php $params = '?subscription_date_start='.$subscription_date_start.'&subscription_date_end='.$subscription_date_end; ?>
            <table id="report_table" class="report_table  custom-table table-striped"
                        data-toolbar="#toolbar"
                       data-toggle="table"
                         data-pagination="true"
                        data-sort-name="j.created" 
                                   data-sort-order="desc"                                   
                                   data-page-size="50"   
                                   data-page-list="[25,50,100,150,All]"                                   
                                   data-pagination-V-Align="both"
                                   data-url="<?php echo base_url(); ?>reports/ajax_search_date_wise<?php echo $params; ?>"
                         >
                          <thead>
                            <tr>
                               <th data-field='j.created' width="210px" data-sortable="true">Date</th>
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

               <a href="javascript:void(0)" tableexport-id="report_table" tableexport-filename="Common Report Date wise" class="btn btn-success export_csv">Export to XLS</a>
               

            </div>

        </div>
        <!--/col--> 

    </div>
    <!--/row--> 

</div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer'); ?>
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-table-export.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableExport.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableexport-xls-bold-headers.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>
<link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
  $(document).ready(function() { 

    $( ".date-picker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd/mm/yy',
      maxDate:'0',
      onSelect: function(dateText, inst) { $('#'+$(this).attr('id')).val(dateText); }
    });
    
     $('.select2').select2({
        placeholder: "- - Select - -",
        allowClear: true   
    })
  
  });
</script>