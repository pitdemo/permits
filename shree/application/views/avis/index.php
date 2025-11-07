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
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col" style="padding-left:25px;">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                  AVI
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list" >
                  <a href="<?php echo base_url(); ?>/avis/form" class="btn btn-primary d-none d-sm-inline-block" >
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Create
                  </a>               
                </div>
              </div>
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
                 
                 <?php $this->load->view('avis/search_form',array('ajax_paging_url'=>$ajax_paging_url,'ajax_paging_params'=>$ajax_paging_params)); ?>

                  <div class="row row-cards">
                  <?php
                     if($this->session->userdata('mode')=='mobile')
                     {
                     ?>                    
                        <div class="col-auto ms-auto d-print-none">
                         <div class="btn-list">
                           <a href="<?php echo base_url(); ?>/avis/form/?mode=<?php echo $this->session->userdata('mode'); ?>" class="btn btn-primary" > 
                             Create
                           </a>               
                         </div>
                     </div> <br /><br />
                     <?php } ?>
                      <div class="col-12">       

                          <div class="card">
                                  <table class="table custom-table table-striped table-responsive" id="table"
                                          data-toggle="table"
                                            data-url="<?php echo base_url().$this->data['controller']; ?>ajax_fetch_show_all_data/show_button/show/<?php echo (isset($params_url)) ? $params_url : ''; ?>"
                                            data-pagination="true"
                                      data-search="false"
                                      data-page-size="50"
                                      data-sort-name="id" 
                                          data-sort-order="desc"
                                          data-side-pagination="server"
                                            data-page-list="[50,100, 200]">
                                  <thead>
                                    <tr>
                                      <th data-field='id' width="110px" class="center" data-sortable="true">AVI No</th>
                                      <th data-field='zone_name' width="210px" data-sortable="true">Zone</th>
                                      <th data-field='no_of_isolators' width="210px" data-sortable="true">No.of Equipments</th>
                                      <th data-field='approval_status' class="center" width="75px">Approval Status</th>
                                      <th data-field='waiating_approval_by' class="center" width="75px">Waiting / Last Approved By</th>
                                      <th data-field='created' class="center" data-sortable="true" width="75px">Created</th>
                                      <th data-field='modified' class="center" data-sortable="true" width="75px">Last updated on</th>
                                    </tr>
                                  </thead>
                            
                                </table> 
                                <!-- <div class="row">
                                      <div class="col-sm-12" style="padding:25px;">
                                              <div class="form-group has-feedback">
                                              <a href="javascript:void(0)" tableexport-id="table" tableexport-filename="Dept Permit Report" class="btn btn-success export_csv">Export</a>
                                              </div>
                                      </div>
                                </div> 
                              -->
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

    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jobs.js"></script>
         <script src="<?php echo base_url(); ?>assets/latest/js/tabler.min.js?1692870487" defer></script>
    <script src="<?php echo base_url(); ?>assets/latest/js/demo.min.js?1692870487" defer></script>

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

    

		$('body').on('click','.reset',function() 
		{
				var data_status=$(this).attr('data-status');	
				
				window.location='<?php echo base_url().$this->data['controller'];?>/show_all';;			
		});
		
		$('.search_data').click(function()
		{
				var form_id=$(this).attr('data-form-name');
				//if(form_id=='all')
				var params_url='index/show_button/show/';

				var i=0;
				//Pushing values in Query Parameters
				  $('form#'+form_id+'_form').find(':input[type=hidden],select,:input[type=text]').each(function ()
				  {
						index= $(this).attr('name');
						
						value= $.trim(encodeURI($(this).val()));
						
						if(value!='' && typeof index!=='undefined' && value!='all')
						{ 
							if(index=='subscription_date' || index=='proceeds_due_by_date')
							value=value.replace(/\//g, '-');
							
							params_url+=index+'/'+value+'/'; i++;

						}
				  });
						$('#table').bootstrapTable('refresh', {
						method:'post',
						url: base_url+'avis/ajax_fetch_show_all_data/'+params_url
						});		
										  
					 window.history.pushState("", "", '<?php echo base_url().$this->data['controller'];?>index/show_all/'+params_url);   	
				  
				return false;
			}); //Filter Form Submit Ends Here
		
	});
</script>

  </body>
</html>

  