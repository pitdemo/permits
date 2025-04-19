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
              <div class="col" style="padding-left:25px;">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                  Materials
                </h2>
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
                 
                 <?php $this->load->view($this->router->fetch_class().'/search_form'); ?>

                  <div class="row row-cards">
                      <div class="col-12">       

                          <div class="card">
                          <table class="table custom-table table-striped" id="table"
                                                 data-toggle="table"
                                                 data-pagination="true"
                                                 data-search="false"
                                                 data-cache="false"
                                                 data-sort-name="first_name" 
                                                 data-sort-order="asc"
                                                  data-page-size="20"   
                                                 data-page-list="[5, 10, 20, 50, 100, 200]">
                                    <thead>
                                        <tr>
                                            <th data-field='sl_no' width="210px" data-sortable="true">SL NO</th>
                                            <th data-field='description' width="100px" data-sortable="true">Short Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($checklists->num_rows()>0)
                                        {
                                            $checklists=$checklists->result_array();
                                            
                                            $i=0;
                                            
                                                foreach($checklists as $data)
                                                {
                                                    $status=$data['status'];
                                                    
                                                    $id=$data['id'];                                        
                                                
                                                    switch($status)
                                                    {
                                                        case STATUS_ACTIVE:
                                                                        $status_class='success';
                                                                        break;  
                                                        case STATUS_INACTIVE:
                                                                        $status_class='danger';
                                                                        break;  
                                                    }

                                                    $path=preg_replace('/[^A-Za-z0-9]/', '',$data['sl_no']);

                                                    $path=$data['file_name'];

                                                    $tx=base_url().'uploads/sops_wi/'.$path;
                                                    
                                        ?>      
                                                <tr class="<?php echo ($i%2==0) ? 'odd' : 'even'; ?>">
                                                
                                                <td  style="text-align: center;"><a href="javascript:void(0);" class="show_image" title="View Description" data-src="<?php echo $tx; ?>" data-toggle="modal" data-target="#modal-full-width"><?php echo $data['sl_no']; ?></a></td>
                                                <td  style="text-align: center;"><?php echo wordwrap($data['description'],60,'<br />'); ?></td>
                                                </tr>
                                        <?php 
                                                    $i++;
                                                }
                                        }                                        
                                        ?>
                                     </tbody>              
                          </table>  
                          </div>
                      </div>
                  </div>    

                  <div class="modal modal-blur fade" id="modal-full-width" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="attached_image">Full width modal</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="show_pdf_information">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn me-auto" data-dismiss="modal">Close</button>
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
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>
    <link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet" type="text/css" />
     <script>
     $(document).ready(function(e) 
    {
        
        $('#search').click(function()
        {
            var search_txt=$('#search_txt').val();

            var record_type=$('.record_type:checked').val();

            var params='/record_type/'+record_type;

            if(search_txt!='')
                params=params+'/search_txt/'+search_txt;

            window.location='<?php echo base_url().$this->data['controller']; ?>index'+params; 

        });

        $('body').on('click','.show_image',function()
        {
        
            var id=$(this).attr('data-src');

            $('#attached_image').html($(this).attr('title'));

            $.ajax({    
                "type" : "POST",
                dataType: 'json',
                "beforeSend": function(){  },
                "url" : base_url+'eip_checklists/ajax_get_sop_wi/',
                "data" : {'file_name' : id},
                success: function(data){
                $('#show_pdf_information').html(data.response);
                }
            });     
            
        });

        $('#show_records_modal').on('hidden.bs.modal', function (e) {
            $('.show_image').attr('src','');
        });


    });

    </script>
  </body>
</html>

  