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
                }
            },
			messages:
			{
				name:{
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