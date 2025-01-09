<?php $this->load->view('layouts/admin_header',array('page_name'=>(isset($brand_details['name'])) ? 'Edit' : 'Create'.' Department')); ?>
<!--MAIN CONTENT -->
<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>eip_checklists/"><i class="fa fa-home"></i>Loto EQ Lists</a></li>
                                <li class="active"><?php echo (isset($brand_details['name'])) ? 'Edit' : 'Create'; ?> EQ Form</li>                                
                                
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

                                <div class="col-sm-12">

                                    <div class="form-group has-feedback">
                                        <label for="name">Select Zone*</label>
                                        <select class="form-control" name="zone_id" id="zone_id">
                                                <option value="">- - Select Zone - - </option>
                                                <?php if(!empty($zones))
                                                {
                                                    foreach($zones as $list)
                                                    {
                                                        $zone_id=(isset($brand_details['zone_id'])) ? $brand_details['zone_id'] : '';
                                                ?>
                                                <option value="<?php echo $list['id'];?>" <?php if($zone_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                                <?php }
                                                } ?>
                                            </select>         
                                          <?php echo form_error('zone_id');?>
                                    </div>

                                </div>

                            </div><!--/row-->

                        
			                <div class="row">

			                    <div class="col-sm-12">

			                        <div class="form-group has-feedback">
			                            <label for="name">Equipment Number*</label>
                                         <input type="text" placeholder="Equipment Number" class="form-control" value="<?php echo set_value('equipment_name',(isset($brand_details['equipment_name'])) ? $brand_details['equipment_name'] : ''); ?>" 
                                         name="equipment_name" id="equipment_name" >
                                          <?php echo form_error('equipment_name');?>
			                        </div>

			                    </div>

			                </div><!--/row-->

                            <div class="row">

                                <div class="col-sm-12">

                                    <div class="form-group has-feedback">
                                        <label for="name">Equipment Description*</label>
                                         <input type="text" placeholder="Equipment Description" class="form-control" value="<?php echo set_value('equipment_number',(isset($brand_details['equipment_number'])) ? $brand_details['equipment_number'] : ''); ?>" 
                                         name="equipment_number" id="equipment_number" >
                                          <?php echo form_error('equipment_number');?>
                                    </div>

                                </div>

                            </div><!--/row-->

			            </div>
			        </div>
			    </div><!--/col-->

			    <!--/col-->

			</div>
                           <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>
                           <a  class="btn btn-sm btn-danger" href="<?php echo base_url().$this->data['controller'];?>"><i class="fa fa-ban"> Cancel</i></a>                         
                            
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
                equipment_name:{
                    required:true
                },
                equipment_number:{
                    required:true
                },
                zone_id:{required:true}
            },
			messages:
			{
				equipment_name:{
                    required:'Required'
                },
                equipment_number:{
                    required:'Required'
                },
                zone_id:{
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