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
              <div class="col">
                <!-- Page pre-title -->
               
                <h2 class="page-title">
                  Dashboard
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                Next Auto Refresh : <div id="countdown" style="font-weight:bold;" class="blink_me">00:59</div>         
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
                 
               

                  <div class="row row-cards">
                      <div class="col-12">       

                          <div class="card">
                                <table class="table custom-table table-striped table-responsive" id="table"
                                      data-toggle="table"
                                      data-url="<?php echo $ajax_paging_url.$ajax_paging_params.((isset($params_url)) ? $params_url : ''); ?>"
                                      data-pagination="true"
                                      data-search="false"
                                      data-page-size="50"
                                      data-sort-name="id" 
                                      data-sort-order="desc"
                                      data-side-pagination="server"
                                      data-show-refresh="false"
                                      data-page-list="[50,100,150]">
                                  <thead>
                                    <tr>
                                      <th data-field='id' width="110px" class="center" data-sortable="true">Permit No</th>
                                      <th data-field='job_name' width="210px" data-sortable="true">Permit Desc</th>
                                      <th data-field='is_loto' width="210px" data-sortable="true">Loto</th>
                                      <th data-field='permit_types' width="210px" data-sortable="false">Permit Types</th>
                                      <th data-field='approval_status' class="center" width="75px">Approval Status</th>
                                      <th data-field='waiating_approval_by' class="center" width="75px">Waiting / Last Approved By</th>
                                      <th data-field='created' class="center" data-sortable="true" width="75px">Created</th>
                                      <th data-field='modified' class="center" data-sortable="true" width="75px">Last updated on</th>
                                      <th data-field='time_diff' class="center" data-sortable="true" width="75px">Expire within</th>
                                      <th data-field='reference_codes' class="center" data-sortable="false" width="75px">Ref Codes</th>
                                    </tr>
                                  </thead>
                            
                                </table>     
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
  
		
		$('.search_data').click(function()
		{ 
						$('#table').bootstrapTable('refresh', {
						method:'post',
						url: '<?php echo $ajax_paging_url; ?>'
						});		 
				return false;
		}); //Filter Form Submit Ends Here

    
    var timeleft = 59;
    var downloadTimer = setInterval(function(){
      if(timeleft <= 0){
       timeleft=59;
       $('#table').bootstrapTable('refresh');
      }
      console.log('lllllaa ',timeleft.length)
      document.getElementById("countdown").innerHTML = '00:'+(timeleft<=9 ? '0'+timeleft : timeleft);     
      timeleft -= 1;
    }, 1000);
        
	});
  
</script>


  </body>
</html>

  