<?php $this->load->view('layouts/admin_header',array('page_name'=>'Date wise')); ?>
<style>
    .label:hover{
        cursor: pointer; cursor: hand;
    }
  .custom-table.select-all tr td:first-child { width:350px !important; }
  .export { visibility:hidden !important; }
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
                                <li ><a href="javascript:void(0);"></i>Combined Reports</a></li>
                                <li class="active"><a href="javascript:void(0);">Category wise</a></li>
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
                  
                    <?php
          $selected_departments=(isset($selected_departments)) ? explode(',',$selected_departments) : array();
          
          $selected_zones=(isset($selected_zones)) ? explode(',',$selected_zones) : array();

          
          ?>
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
                                                          
                                                          
                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Departments</label>
                                                              <div class="controls">
                                                                   <select class="form-control department_list select2" name="departments" id="departments" multiple="multiple">
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
                                                          
                                                          
                  <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Zones</label>
                                                              <div class="controls">
                                                                   <select class="form-control zones_list select2" name="zones" id="zones" multiple="multiple">
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
                                                      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Ignition of Flammables</label>
                                                              <div class="controls">
                                                                   <select class="form-control select2" name="flammables" id="flammables" >
                                                                        <option value="" selected="selected"></option>
                                                                        <?php
                                                                        $a=array(YES,NO);

                                                                        foreach($a as $val)
                                                                        {
                                                                            if($val==$selected_flammables)
                                                                             $sel='selected=selected';
                                                                              else
                                                                              $sel='';  
                                                                        ?>
                                                                        <option value="<?php echo $val; ?>" <?php echo $sel; ?>><?php echo $val; ?></option>    
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>         
                                                              </div>
                                                      </div>
                                                          </div>                                                              

                                                          
                                                          <div class="col-lg-1 col-md-6 col-sm-6 col-xs-6 full-width">
                                      <div class="form-group">
                                        <label class="none invisible" for="search">Search</label>
                                        <div class="clearfix"></div>
                                <button type="button" class="btn btn1 day_search" ><i class="fa fa-search"></i> Search</button> 
                          </div>
                                    </div>
                     </div>      

                     <div class="row">  
                                 <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                       <div class="form-group">
                                           <label class="control-label labeledit" for="date01">Peptalk</label>
                                              <div class="controls">
                                                  <select class="form-control select2" name="is_peptalk" id="is_peptalk" >
                                                      <option value="" selected="selected" >- - Show All - -</option>
                                                              <?php
                                                              $a=array(YES,NO);

                                                              foreach($a as $val)
                                                              {
                                                                  if($val==$is_peptalk)
                                                                   $sel='selected=selected';
                                                                    else
                                                                    $sel='';  
                                                              ?>
                                                              <option value="<?php echo $val; ?>" <?php echo $sel; ?>><?php echo $val; ?></option>    
                                                              <?php
                                                              }
                                                              ?>
                                                   </select>                              
                                              </div>
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
                                     data-sort-name="permit_created"                                     
                                     data-sort-order="desc"
                                     data-page-size="50"   
                                     data-search="false"                            
                                     data-pagination="true"
                                     data-side-pagination="server"                                    
                                     data-pagination-V-Align="both"
                                     data-page-list="[50, 100, 200,All]">
                          <thead>
                            <tr>
                               <th data-field='permit_created' width="310px" data-sortable="true">Date</th>
                               <th data-field='no_of_permits' class="center" data-sortable="true" width="70px">Combined work</th>
                               <th data-field='hot_work' class="center" data-sortable="true" width="70px">Hot Work</th>
                               <th data-field='height_work' class="center" data-sortable="true" width="70px">Height Work</th>
                               <th data-field='general_work' class="center" data-sortable="true" width="70px">General Work</th>
                            </tr>
                          </thead>
              <tbody id="show_investment">
                             </tbody>                          
            </table>                   
                    <div>&nbsp;</div>   

                <div class="col-lg-12 tax-con">
                   <a href="javascript:void(0)" tableexport-id="search_table" tableexport-filename="Combined Permit Report Category Wise" class="btn btn-success export_csv">Export to XLS</a>                     
                </div>

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
   
    $('.day_search').trigger('click');

    $( ".date-picker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd/mm/yy',
      maxDate:'0',
      onSelect: function(dateText, inst) { $('#'+$(this).attr('id')).val(dateText); }
    });

  });
</script>