<?php $this->load->view('layouts/admin_header',array('page_name'=>(isset($brand_details['name'])) ? 'Edit' : 'Create '.$this->data['controller'])); ?>
<!--MAIN CONTENT -->

<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>isolations/"><i class="fa fa-home"></i>Isolations</a></li>
                                <li class="active"><?php echo (isset($brand_details['name'])) ? 'Edit ' : 'Create '; echo rtrim($this->data['controller'],'/'); ?>  Form</li>                                
                                
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
                        	
                            
                            <?php
							if($isolation_type=='description')
							{
							?>	
							<div class="row">
			                    <div class="col-sm-12">
			                        <div class="form-group has-feedback">
			                            <label for="name">Select Isolation Type*</label>
                                        <select name="isolation_type_id" id="isolation_type_id" class="form-control">
                                        	<option value="" selected="selected">Select</option>
                                            <?php
											
											$isolation_type_id=(isset($brand_details['isolation_type_id'])) ? $brand_details['isolation_type_id'] : '';
												foreach($isolations as $isolation)
												{
													$isolation_id=$isolation['id'];
													
													if($isolation_type_id==$isolation_id)
													$sel="selected";
													else
													$sel='';
											?>
                                            	<option value="<?php echo $isolation_id; ?>" <?php echo $sel; ?>><?php echo $isolation['name']; ?></option>
                                                <?php
												}
												?>
                                        </select>
                                          <?php echo form_error('name');?>
			                        </div>
			                    </div>
			                </div>                       
                        	<?php
							}
							else
							{
								$department_id=(isset($department_ids)) ? $department_ids : array();
								
								
							?>
								<div class="row">
			                    <div class="col-sm-12">
			                        <div class="form-group has-feedback">
			                            <label for="name">Assign Department*</label>
                                        <select name="department_id[]" id="department_id[]" multiple="multiple" size="15" class="form-control">
                                            <?php
											#$department_ids=explode(',',$department_id);
											
												foreach($departments as $department)
												{
													$department_id=$department['id'];
													
													if(in_array($department_id,$department_ids))
													$sel="selected";
													else
													$sel='';
											?>
                                            	<option value="<?php echo $department_id; ?>" <?php echo $sel; ?>><?php echo $department['name']; ?></option>
                                                <?php
												}
												?>
                                        </select>
                                          <?php echo form_error('name');?>
			                        </div>
			                    </div>
			                </div>                            
                            <?php
							}
							?>
                            
			                <div class="row">

			                    <div class="col-sm-12">

			                        <div class="form-group has-feedback">
			                            <label for="name">Name*</label>
                                         <input type="text" placeholder="Name" class="form-control" value="<?php echo set_value('name',(isset($brand_details['name'])) ? $brand_details['name'] : ''); ?>" 
                                         name="name" id="name" >
                                          <?php echo form_error('name');?>
			                        </div>

			                    </div>

			                </div>
                            
                            
			            </div>
			        </div>
			    </div><!--/col-->

			    <!--/col-->

			</div>
                           <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>
                           
                           <?php
						   
						   $redi='';
						   
						   if($isolation_type=='description')
						   $redi='/isolation_type_id/'.$isolation_type_id;
						?>   
                           <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>isolations/index/type/<?php echo $isolation_type.$redi; ?>"><i class="fa fa-ban"> Cancel</i></a>                         
                            
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
				isolation_type_id : { required:true },
				'department_id[]' : { required:true,minlength:1 }
            },
			messages:
			{
				name:{
                    required:'Required'
                },
				isolation_type_id: { required:'Required' },
				'department_id[]' : { required:'Reqired' }
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