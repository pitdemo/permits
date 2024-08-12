<?php 

    $this->load->view('layouts/preload');

    $this->load->view('layouts/user_header');
?>

<div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                  Open Permits
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="<?php echo base_url(); ?>/jobs/form" class="btn btn-primary d-none d-sm-inline-block" >
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
            <div class="row row-deck row-cards">
             <div class="col-lg-12">
                  <div class="row row-cards">
                      <div class="col-12">          
                        <?php $this->load->view('layouts/msg'); ?>
                          <div class="card">
                                <table class="table custom-table table-striped table-responsive" id="table"
                                          data-toggle="table"
                                            data-url="<?php echo base_url().$this->data['controller']; ?>ajax_fetch_open_permits/show_button/show/<?php echo (isset($params_url)) ? $params_url : ''; ?>"
                                            data-pagination="true"
                                      data-search="false"
                                      data-page-size="100"
                                      data-sort-name="id" 
                                          data-sort-order="desc"
                                          data-side-pagination="server"
                                            data-page-list="[100, 200]">
                                  <thead>
                                    <tr>
                                      <th data-field='id' width="110px" class="center" data-sortable="true">Permit No</th>
                                      <th data-field='job_name' width="210px" data-sortable="true">Permit Desc</th>
                                      <th data-field='approval_status' class="center" width="75px">Approval Status</th>
                                      <th data-field='waiating_approval_by' class="center" width="75px">Waiting / Last Approved By</th>
                                      <th data-field='created' class="center" data-sortable="true" width="75px">Created</th>
                                      <th data-field='modified' class="center" data-sortable="true" width="75px">Last updated on</th>
                                      <th data-field='time_diff' class="center" data-sortable="true" width="75px">Expire within</th>
                                    </tr>
                                  </thead>
                            
                                </table>     
                          </div>
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
    <script src="<?php echo base_url(); ?>assets/plugins/gritter/js/jquery.gritter.min.js"></script>       
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script> 

    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jobs.js"></script>

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
				var params_url='show_button/show/';

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
						url: base_url+'jobs/ajax_fetch_show_all_data/'+params_url
						});		
										  
					 window.history.pushState("", "", '<?php echo base_url().$this->data['controller'];?>show_all/'+params_url);   	
				  
				return false;
			}); //Filter Form Submit Ends Here
		
	});
</script>

  </body>
</html>

  