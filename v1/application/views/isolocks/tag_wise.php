<?php 

    $this->load->view('layouts/preload');

    $this->load->view('layouts/user_header');

    
    $ajax_paging_url=base_url().$this->data['controller'].'ajax_fetch_show_all_data/';
    $ajax_paging_params='page_name/'.$this->router->fetch_method().'/';

    function dropdown_status($master_data,$selected_data)
  {
      $return='';

      $selected_data=explode(',',$selected_data);

      foreach($master_data as $key => $data):

        $sel = in_array($key,$selected_data) ? 'selected' : '';

        $return.='<option value="'.$key.'" '.$sel.'>'.$data.'</option>';

      endforeach;

      return $return;

  }

?>

<link href="<?php echo base_url(); ?>assets/css/bootstrap-table.css" type="text/css" rel="stylesheet"> 
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/common.css" rel="stylesheet" type="text/css" />

<div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col" style="padding-left:25px;">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                  TAGS
                </h2>
              </div>
              <!-- Page title actions -->
              
            </div>
          </div>
        </div>


        <!-- Page body -->
        <div class="page-body" style="background-color:white;">
          <div class="container-xl">
                  <div class="row row-cards">
                      <div class="col-12">          

                       <form name="filter_form" id="filter_form">
                          <div class="row">      
                              <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                                  <div class="form-group">
                                    <label class="control-label labeledit" for="date01">Equipments</label>
                                    <div class="controls">
                                    <select class="form-control equipments select2" name="eq" id="eq" multiple="multiple">
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
                              
                              <div class="col-sm-3 col-md-2">
                                    <div class="mb-3">
                                    <label class="form-label"><b>Status</b></label>
                                    <select name="status" id="status" class="form-control select2">
                                        <?php echo dropdown_status(array(''=>'Show All',STATUS_ACTIVE=>'Active',STATUS_CLOSED=>'Closed'),$status); ?>
                                    </select>
                                    </div>
                              </div>
                              <div class="col-lg-1 col-md-6 col-sm-6 col-xs-6 full-width">
                                  <div class="form-group">
                                    <label class="none invisible" for="search">Search</label>
                                    <div class="clearfix"></div>
                                    
                                    <button class="form-control search" type="button" data-url="tag_wise" data-form-name="form"><i class="fa fa-search"></i> <span class="text-hidden">Search</span></button>
                                     <a href="<?php echo base_url(); ?>isolocks/tag_wise" style="padding-top:10px;"  data-url="<?php echo base_url(); ?>iso_locks/tag_wise" >Reset</a>
                                  </div>
                              </div>
                          </div>  
                        </form>   
                       
                      </div>
                  </div>    
                 
                 <?php $params = '';; ?>
                  <div class="row"><div class="col-12">&nbsp;</div></div>
                  <div class="row row-cards">
                      <div class="col-12">       

                          <div class="card">
                                <table class="table custom-table table-striped table-responsive report_table" id="table"
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
                                 data-url="<?php echo base_url(); ?>isolocks/ajax_search_tag_wise<?php echo $params; ?>">
                                  <thead>
                                    <tr>
                                      <th data-field='chk_box' width="20px;" class="bg-img-none center" ><input type="checkbox" name="checkbox1"  class='bulk_action'></th>
                                      <th data-field='equipment_number' width="210px" data-sortable="true">Equipment Number</th>                                                                                        
                                      <th data-field='equipment_name' width="210px" data-sortable="true">Equipment Name</th>                                                                                        
                                      <th data-field='isolated_tagno3' class="center" data-sortable="false">ISO Tag No</th>
                                      <th data-field='no_of_permits' width="210px"  class="center"  data-sortable="true">No.of Permits</th>
                                      <th data-field='status' class="center" data-sortable="false">Status</th>
                                      <th data-field='created' class="center" data-sortable="false">Created On</th>
                                    </tr>
                                  </thead>
                            
                                </table>     

                                <div class="row">
                                      <div class="col-sm-12" style="margin-left:5px;">
                                              
                                              <div class="form-group has-feedback">
                                                <a class="btn btn-primary" onclick="change_status(this);" data-url='<?php echo base_url();?>isolocks/ajax_update_users' data-status='<?php echo STATUS_CLOSED; ?>' data-bulk='bulk'>Set as Closed</a>       
                                              <a href="javascript:void(0)" tableexport-id="report_table" tableexport-filename="ISO Locks" class="btn btn-success export_csv">Export to XLS</a>
                                              </div>
                                      </div>
                                </div>

                          </div>
                      </div>
                  </div>    

           
          </div>
        </div>
      </div>

      <div class="modal modal-blur fade" id="modal-scrollable" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="log_title">Scrollable modal</h5>
                         
                        </div>
                        <div class="modal-body" id="log_text">
                        
                        </div>
                        <div class="modal-footer">
                          <button type="button" id="modal-scrollable-close" class="btn me-auto" data-bs-dismiss="modal" style="background-color:red;color:white;">Close</button>
                        </div>
                      </div>
                    </div>
     </div>

     
   
 <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.min2.0.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
   
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-table.js"></script>   

    <script src="<?php echo base_url(); ?>assets/js/bootstrap-table-export.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/tableExport.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/tableexport-xls-bold-headers.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>
    <link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet" type="text/css" />

    <script src="<?php echo base_url(); ?>assets/js/bootstrap-table-export.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/isolocks.js"></script> 

  

<?php $this->load->view('layouts/latest_footer'); ?>
  </body>
</html>

  