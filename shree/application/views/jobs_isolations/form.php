<?php $this->load->view('layouts/header',array('page_name'=>'Listing')); ?>
<style type="text/css">
table.form_work tr td { padding:0px 5px 0 5px; }
.radio_button { padding:0 2px 0px 2px; }
label.error { display:none; }
.float_right { float:right; padding-right:5px; }
label.error { display:none !important; }
input[type=checkbox].box_big {
    transform: scale(3);
    -ms-transform: scale(2);
    -webkit-transform: scale(2);
    padding: 10px;
}
.authority { width:170px; }
</style>
<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>jobs_isolations"><i class="fa fa-home"></i>EIP's</a></li>
                                <li class="active"><a href="javascript:void(0);" id="bread_crumb">Edit</a></li>
                            </ul>
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                                    <!--progress bar start-->
                                    <section class="panel">
                                       <div class="panel-body ">
                                       
                                                   <?php $this->load->view('jobs/energy_content',array('records'=>$records,'is_popup'=>false)); ?>
          		 						
                        
                        				</div>       
                                    </section>
                                    <!--progress bar end-->
                             
                        </div>
                    </div>

                </section>
            </div>
        </div>
<?php $this->load->view('layouts/footer'); ?>
