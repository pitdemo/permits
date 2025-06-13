<?php $this->load->view('layouts/admin_header',array('page_name'=>(isset($brand_details['name'])) ? 'Edit' : 'Create'.' Department')); ?>
<!--MAIN CONTENT -->
<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>zones/"><i class="fa fa-home"></i>Zones</a></li>
                                <li class="active"><?php echo (isset($brand_details['name'])) ? 'Edit' : 'Create'; ?> Zone Form</li>                                
                                
                            </ul>
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <!--progress bar start-->
                                                          <section class="panel">
                                        
                                        <div class="panel-body">
                                        
                                       	<form name="form" id='form' method="post" enctype="application/x-www-form-urlencoded">
						<div class="acc-header">
                            	
                           <div class="row">

			    <div class="col-sm-6">

			        <div class="panel panel-default">
			            
			            <div class="panel-body">
                        
                        <?php $this->load->view('layouts/msg'); ?>
                        
			                <div class="row">

			                    <div class="col-sm-4">

			                        <div class="form-group has-feedback">
			                            <label for="name">Name*</label>
                                         <input type="text" placeholder="Zone name" class="form-control" value="<?php echo set_value('name',(isset($brand_details['name'])) ? $brand_details['name'] : ''); ?>" 
                                         name="name" id="name" >
                                          <?php echo form_error('name');?>
			                        </div>

			                    </div>

                                <div class="col-sm-4">
			                        <div class="form-group has-feedback">
			                            <label for="name">Plant Type*</label>
                                        <?php
                                         $plant_types=$this->plant_types;
                                         $plant_type=(isset($brand_details['plant_type'])) ? $brand_details['plant_type'] : '';
                                         ?>
                                         <select name="plant_type" id="plant_type" class="form-control">
                                            <option value="" selected>Select Plant</option>
                                            <?php
                                           

                                            foreach($plant_types as $key => $plant):

                                                $sel=$plant_type==$key ? 'selected' : '';

                                                echo '<option value="'.$key.'" '.$sel.'>'.$plant.'</option>';

                                            endforeach;
                                            ?>
                                         </select>
			                        </div>

			                    </div>


                                 <div class="col-sm-4">
			                        <div class="form-group has-feedback">
			                            <label for="name">Zone Type*</label>
                                        <?php
                                         $zone_types=array(PRODUCTION=>'Production',NON_PRODUCTION=>'Non Production');
                                         $zone_type=(isset($brand_details['zone_type'])) ? $brand_details['zone_type'] : '';
                                         ?>
                                         <select name="zone_type" id="zone_type" class="form-control">
                                            <option value="" selected>Select Zone Type</option>
                                            <?php
                                           

                                            foreach($zone_types as $key => $plant):

                                                $sel=$zone_type==$key ? 'selected' : '';

                                                echo '<option value="'.$key.'" '.$sel.'>'.$plant.'</option>';

                                            endforeach;
                                            ?>
                                         </select>
			                        </div>

			                    </div>

			                </div><!--/row-->
			            </div>
			        </div>
			    </div><!--/col-->

			    <!--/col-->

			</div>
                           <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>
                           <a  class="btn btn-sm btn-danger" href="<?php echo base_url();?>zones/"><i class="fa fa-ban"> Cancel</i></a>                         
                            
						</div>
						</form>
                                       
                                            
                                            
                                        </div>
                                    </section>
                                    <!--progress bar end-->

                                </div>
                            </div>

                            
                        </div>
                    </div>

                </section>
            </div>
            <!-- Right side column. Contains the navbar and content of the page -->
            
        </div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer_script'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script>
	$(document).ready(function() {
    $("#form").validate({ 
			rules: {
                name:{
                    required:true
                },
                plant_type:{
                    required:true
                },
                zone_type:{
                    required:true
                }
            },
			messages:
			{
				name:{
                    required:'Required'
                },
                plant_type:{
                    required:'Required'
                },
                zone_type:{
                    required:'Required'
                }
			},
		errorPlacement: function(error,element){
            error.appendTo(element.parent().parent());                        
        },
        submitHandler:function(){
                 $("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing");
                form.submit();
        }
    });
    });
    /*$.extend($.validator.messages, {
        required: "Required",
    });*/
</script>
<?php $this->load->view('layouts/footer'); ?>