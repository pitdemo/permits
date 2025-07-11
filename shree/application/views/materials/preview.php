<?php 

    $this->load->view('layouts/preload');
    $this->load->view('layouts/user_header');    
    $ajax_paging_url=base_url().$this->data['controller'].'ajax_fetch_show_all_data/';
    $ajax_paging_params='page_name/'.$this->router->fetch_method().'/';
?>

<script src="<?php echo base_url(); ?>assets/js/jquery.min2.0.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" rel="stylesheet" />
<!--Popup Lightbox Js-->
<script src="<?php echo base_url(); ?>assets/latest/js/jquery.popup.lightbox.js"></script>
<!--Popup Lightbox CSS-->
<link href="<?php echo base_url(); ?>assets/latest/css/popup-lightbox.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/common.css" rel="stylesheet" type="text/css" />
<style>
    
      .container { margin: 150px auto; max-width: 960px; text-align: center; }
      .img-container {
        margin: 20px;
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

}
.img-container img:hover{
  transform: scale(0.97);
 -webkit-transform: scale(0.97);
 -moz-transform: scale(0.97);
 -o-transform: scale(0.97);
  opacity: 0.75;
 -webkit-opacity: 0.75;
 -moz-opacity: 0.75;
  transition: .3s;
 -webkit-transition: .3s;
 -moz-transition: .3s;
}
</style>

 <script>
         $(document).ready(function(){

         $(".img-container").popupLightbox({
          width: 600,
      height: 450
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
                  Study Materials
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
                      <div class="col-12">       

                           <div class="img-container">
                            <img src="https://www.jqueryscript.net/dummy/1.jpg" alt="Fitness" />
                            <img src="https://www.jqueryscript.net/dummy/2.jpg" alt="jQueryScript.Net"/>
                            <img src="https://www.jqueryscript.net/dummy/3.jpg" alt="Girls"/>
                            <img src="https://www.jqueryscript.net/dummy/4.jpg" alt="Fashion" />
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

  