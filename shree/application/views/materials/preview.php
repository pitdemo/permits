<?php 

    $this->load->view('layouts/preload');
    $this->load->view('layouts/user_header');    
    $ajax_paging_url=base_url().$this->data['controller'].'ajax_fetch_show_all_data/';
    $ajax_paging_params='page_name/'.$this->router->fetch_method().'/';
?>

<script src="<?php echo base_url(); ?>assets/js/jquery.min2.0.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/latest/css/style.argonbox.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/latest/js/jquery.argonbox.js"></script>
<link href="<?php echo base_url(); ?>assets/css/common.css" rel="stylesheet" type="text/css" />
<style>
     .container { margin: 150px auto; max-width: 960px; text-align: center; }
      .img-container {
        margin: 25px;
}

.img-container img {
   width: 200px;
   height: auto;
   border: 1px solid #ccc;
   border-radius: 5px;
   cursor: pointer;
   -webkit-tap-highlight-color: transparent;
   transition: .3s;
  -webkit-transition: .3s;
  -moz-transition: .3s;
  margin:10px;
}

.img-caption {
    background: rgba(0, 0, 0, 0.3);
    padding: 10px;
    position: absolute;
    bottom: 0;
    color: #fff;
   
    width: 100%;
    box-sizing: border-box;
}
    
</style>

 <script>
$(function() {
"use strict";
$(".argonbox a").click(function() {
$(this).argonBox({
"duration": "slow"
});
return false;
}); 
});
      </script>
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
                  Study Materials New
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

                  <div class="row row-cards">
                      <div class="col-2">       
                        <b>Sl.No </b><br />
                        <?php echo $checklists['sl_no']; ?>
                      </div>
                       <div class="col-4">       
                        <b>Description</b><br />
                        <?php echo $checklists['description']; ?>
                      </div>
                       <div class="col-2">       
                        <b>Type </b><br />
                        <?php echo $checklists['record_type']; ?>
                      </div>
                      <div class="col-4">     
                        <a href="<?php echo base_url(); ?>/materials/index/mode=<?php echo $this->session->userdata('mode'); ?>" class="btn btn-primary d-none d-sm-inline-block" >
                        Back
                        </a> 
                      </div>
                  </div>

                  <div class="row row-cards">
                      <div class="col-12">       

                           <div class="argonbox img-container">
                            <?php
                                $path=UPLODPATH.'uploads/sops_wi/1/';
                                $i=1;
                                if ($handle = opendir($path)) {
                                while (false !== ($fileName = readdir($handle))) {
                                if($fileName != '.' && $fileName != '..') {
                                    echo '<a href="'.base_url().'uploads/sops_wi/1/'.$fileName.'" title="Page '.$i.'"><img src="'.base_url().'uploads/sops_wi/1/'.$fileName.'" alt="Page '.$i.'"><div class="img-caption">ABCD</div></a>';
                                    $i++;
                                }
                            }}

                            ?>
                            
                            </div>

                      </div>
                  </div>    

                 
          </div>
        </div>
      </div>

      
   
 <!-- Libs JS -->
    <!-- Tabler Core -->
  
  </body>
</html>

  