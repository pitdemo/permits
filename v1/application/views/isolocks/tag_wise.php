<?php $this->load->view('layouts/admin_header',array('page_name'=>'Department wise')); ?>
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
                                <li ><a href="javascript:void(0);"><i class="fa fa-home"></i>ISO Locks</a></li>
                                <li class="active"><a href="javascript:void(0);">Listing</a></li>
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
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                  <label class="control-label labeledit" for="date01">Equipments</label>
                                  <div class="controls">
                                  <select class="form-control equipments select2" name="eq" id="eq" multiple="multiple">
                                  <option value="">- - Show All - - </option>
                                    <?php 
                                        if(!empty($zones))
                                        {
                                           foreach($zones as $list)
                                           {
                                              $id=$list['id'];
                                            
                                              if(in_array($id,$selected_eq))
                                              $sel='selected=selected';
                                              else
                                              $sel='';
                                            
                                        ?>
                                    <option value="<?php echo $id;?>" <?php echo $sel; ?>><?php echo $list['equipment_name'].' - '.$list['equipment_number'];?></option>
                                    <?php }} ?>
                                  </select>         
                                </div>
                               </div>
                            </div>    

                                           
                                 <div class="col-lg-1 col-md-6 col-sm-6 col-xs-6 full-width">
                                      <div class="form-group">
                                        <label class="none invisible" for="search">Search</label>
                                        <div class="clearfix"></div>
                                        <button type="button" class="btn btn1 search" data-url="tag_wise" ><i class="fa fa-search"></i> Search</button> 
                                      </div>
                                </div>
                     </div>   
   
                </form>   
                      
                        <?php $params = '';; ?>
            <table id="report_table" class="report_table  custom-table table-striped"
                                 data-toolbar="#toolbar"
                                 data-toggle="table"
                                 data-pagination="true"
                                 data-sort-name="li.id" 
                                 data-sort-order="desc"                                
                                 data-page-size="25"   
                                 data-page-list="[25,50,100,150,200,250,All]"
                                 data-export-options='{"fileName": "equipment_wise_report"}'
                                 data-side-pagination="server"
                                 data-pagination-V-Align="both"
                                 data-url="<?php echo base_url(); ?>isolocks/ajax_search_tag_wise<?php echo $params; ?>"
                         >
                          <thead>
                            <tr>
                             <th data-field='equipment_number' width="210px" data-sortable="true">Equipment Number</th>                                                                                        
                             <th data-field='equipment_name' width="210px" data-sortable="true">Equipment Name</th>                                                                                        
                             <th data-field='isolated_tagno3' class="center" data-sortable="false">ISO Tag No</th>
                             <th data-field='no_of_permits' width="210px"  class="center"  data-sortable="true">No.of Permits</th>
                             <th data-field='status' class="center" data-sortable="false">Status</th>
                             <th data-field='created' class="center" data-sortable="false">Created On</th>
                            </tr>
                          </thead>
                          <tbody id="show_investment">
                          </tbody>                          
            </table>         
                    <div>&nbsp;</div>   

              
                <a href="javascript:void(0)" tableexport-id="report_table" tableexport-filename="ISO Locks" class="btn btn-success export_csv">Export to XLS</a>
            </div>

        </div>
        <!--/col--> 

         

    </div>
    <!--/row--> 

</div>

         <div class="modal modal-blur fade" id="modal-scrollable" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="log_title">Scrollable modal</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="log_text">
                        
                        </div>
                        <div class="modal-footer">
                          <button type="button" id="modal-scrollable-close" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
         </div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer'); ?>
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-table-export.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableExport.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableexport-xls-bold-headers.js"></script>
<script src="<?php echo base_url(); ?>assets/js/isolocks.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>
<link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
  $(document).ready(function() { 
     $('.select2').select2({
        placeholder: "- - Select - -",
        allowClear: true   
    });
  });
</script>