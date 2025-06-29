<?php 

    $this->load->view('layouts/preload');
    $this->load->view('layouts/user_header');    
    $ajax_paging_url=base_url().$this->data['controller'].'ajax_fetch_show_all_data/';
    $ajax_paging_params='page_name/'.$this->router->fetch_method().'/';
?>

<link href="<?php echo base_url(); ?>assets/css/bootstrap-table.css" type="text/css" rel="stylesheet"> 
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/common.css" rel="stylesheet" type="text/css" />

<div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none" style="<?php echo $this->show_filter_form;?>;">
          <div class="container-xl">
            <div class="row g-2 align-items-center" >
              <div class="col"  style="padding-left:25px;">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                 Safety Remarks
                </h2>
              </div>
              <?php
              if($this->session->userdata('is_safety')=='yes') {
              ?>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="<?php echo base_url(); ?>/remarks/form" class="btn btn-primary d-none d-sm-inline-block" >
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Create
                  </a>               
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>


        <!-- Page body -->
        <div class="page-body" style="background-color:white;">
          <div class="container-xl">
                  <div class="row row-cards">
                      <div class="col-12">          
                      <?php $this->load->view('layouts/msg'); ?>
                      </div>
                  </div>    
                 
                 <?php $this->load->view('remarks/search_form',array('ajax_paging_url'=>$ajax_paging_url,'ajax_paging_params'=>$ajax_paging_params)); ?>

                  <div class="row row-cards">
                    <?php
                     if($this->session->userdata('mode')=='mobile' && $this->session->userdata('is_safety')=='yes')
                     {
                     ?>                    
                        <div class="col-auto ms-auto d-print-none">
                         <div class="btn-list">
                           <a href="<?php echo base_url(); ?>/remarks/form/?mode=<?php echo $this->session->userdata('mode'); ?>" class="btn btn-primary" > 
                             Create
                           </a>               
                         </div>
                     </div> <br /><br />
                     <?php } ?>

                      <div class="col-auto ms-auto d-print-none">
                         <div class="btn-list">
                           <a href="<?php echo base_url(); ?>/localworks/pdf/?mode=<?php echo $this->session->userdata('mode'); ?>" class="btn btn-primary" > 
                             Create
                           </a>               
                         </div>
                     </div>

                      <div class="col-12">    
                          <div class="card">

                          
                                <table class="table custom-table table-striped table-responsive" id="table"
                                      data-toggle="table"
                                      data-url="<?php echo $ajax_paging_url.$ajax_paging_params.((isset($params_url)) ? $params_url : ''); ?>"
                                      data-pagination="true"
                                      data-search="false"
                                      data-page-size="20"
                                      data-sort-name="id" 
                                      data-sort-order="desc"
                                      data-side-pagination="server"
                                      data-show-refresh="false"
                                      data-page-list="[20,30,50]">
                                  <thead>
                                    <tr>       
                                      <th data-field='remarks_id'  class="center" data-sortable="true">Remark ID</th>
                                      <th data-field='title'  width="210px" data-sortable="false">Title</th>                                      
                                      <th data-field='images' class="center" width="75px">Screen</th>
                                      <th data-field='approval_status' class="center" width="75px">Job Status</th>
                                      <th data-field='responsible_persons' class="center" data-sortable="true" width="75px">Responsible Persons</th>  
                                      <th data-field='created' class="center" data-sortable="true" width="75px">Raised On</th>
                                      <th data-field='created_by' class="center" data-sortable="true" width="75px">Raised by </th>  
                                      <th data-field='action' class="center" data-sortable="true" width="75px">Action</th>  
                                    </tr>
                                  </thead>
                            
                                </table>     
                          </div>
                      </div>
                  </div>    


                  <div class="modal modal-blur fade" id="modal-download" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="log_title">Preview</h5>
                        <button type="button" class="btn-close pop_close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body" id="log_text" align="left">
                            <img src="" id="image_url" />
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn me-auto pop_close">Close</button>
                      </div>
                    </div>
                  </div>
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
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>
    <link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet" type="text/css" />

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
        $('.date-picker').datepicker({ 
            autoclose: true,
            dateFormat: 'dd/mm/yy',
            maxDate: '0' 
        });

    $('body').on('click','.open_model',function() 
		{
            var data_url=$(this).attr('data-url');	
            
            $('#image_url').attr('src',data_url);

            $('#modal-download').modal('show');
		});

    $('body').on('click','.pop_close',function() 
		{

            $('#modal-download').modal('hide');
		});

		$('body').on('click','.reset',function() 
		{
            var data_url=$(this).attr('data-url');	
            
            window.location.href=data_url;
		});
		
            $('.search_data').click(function()
            {
                var form_id=$(this).attr('data-form-name');
                //if(form_id=='all')
                var params_url=$(this).attr('data-params');

				        var i=0;
				        //Pushing values in Query Parameters
                  $('form#form').find(':input[type=hidden],select,:input[type=text]').each(function ()
                  {
                    index= $(this).attr('name');
                    
                    value= $.trim(encodeURI($(this).val()));
                    
                    if(!!value && value!='' && typeof index!=='undefined' && value!='all' && value!='null')
                    { 
                      if(index=='subscription_date_start' || index=='subscription_date_end')
                      value=value.replace(/\//g, '-');
                      
                      params_url+=index+'/'+value+'/'; i++;

                    }
                  });

                    $('#table').bootstrapTable('refresh', {
                    method:'post',
                    url: '<?php echo $ajax_paging_url; ?>'+params_url
                    });		
                                                
                    window.history.pushState("", "", '<?php echo base_url().$this->data['controller'].'/'.$this->router->fetch_method(); ?>/'+params_url); 
                        
				return false;
			    }); //Filter Form Submit Ends Here
		
	});
  
</script>


  </body>
</html>

  