<?php $this->load->view('layouts/admin_header',array('page_name'=>'Listing')); ?>

<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>departments/"><i class="fa fa-home"></i>Departments</a></li>
                                <li class="active"><?php echo (isset($brand_details['name'])) ? 'Edit' : 'Create'.' Department'; ?></li>                                
                                
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

			    <div class="col-sm-8">

			        <div class="panel panel-default">
			            
			            <div class="panel-body">
                        
                        <?php $this->load->view('layouts/msg'); ?>
                        
			                <div class="row">

			                    <div class="col-sm-4">

			                        <div class="form-group has-feedback">
			                            <label for="name">Name*</label>
                                         <input type="text" placeholder="Department name" class="form-control" value="<?php echo set_value('name',(isset($brand_details['name'])) ? $brand_details['name'] : ''); ?>" 
                                         name="name" id="name" >
                                          <?php echo form_error('name');?>
			                        </div>

			                    </div>

                                <div class="col-sm-4">
			                        <div class="form-group has-feedback">
			                            <label for="name">Short Code*</label>
                                         <input type="text" placeholder="Department Short Code" class="form-control" value="<?php echo set_value('short_code',(isset($brand_details['short_code'])) ? $brand_details['short_code'] : ''); ?>" 
                                         name="short_code" id="short_code" maxlength="5">
                                          <?php echo form_error('short_code');?>
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
			                    </div

			                </div><!--/row-->

                            
                          
			            </div>
			        </div>
			    </div><!--/col-->

			    <!--/col-->
                <div class="row"> 
                    <div class="col-sm-8">
                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>
                        <a  class="btn btn-sm btn-danger" href="<?php echo base_url();?>departments/"><i class="fa fa-ban"> Cancel</i></a>   
                    </div>
                </div>
			</div>
                                                
                            
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
<?php $this->load->view('layouts/footer'); ?>        
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script>
	$(document).ready(function() {
    $("#form").validate({ 
			rules: {
                name:{
                    required:true
                },
                short_code:{
                    required:true
                },
                plant_type:{
                    required:true
                }
            },
			messages:
			{
				name:{
                    required:'Required'
                },
                short_code:{
                    required:'Required'
                },
                plant_type:{
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

</script>