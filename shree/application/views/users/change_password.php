<?php $this->load->view('layouts/header',array('page_name'=>'Change password')); ?>
<!--MAIN CONTENT -->

<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>departments/users/"><i class="fa fa-home"></i>Users</a></li>
                                <li class="active">Change Password</li>                                
                                
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
                        <?php $this->load->view('layouts/msg');
                        
                        
                                
                            if($this->session->userdata('is_default_password_changed') == 'no')
                            {
                         ?>

                         <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>                           
                            <strong>Please change your default login password and then start to access this application.</strong> 
                        </div>
                        <?php
                            }
                            ?>
                        <form name="chng_password" id='chng_password' method="post" enctype="application/x-www-form-urlencoded">
						<div class="acc-header">
                    		
                           <div class="row">

			    <div class="col-sm-6">

			        <div class="panel panel-default">
			            
			            <div class="panel-body">


			                <div class="row">
			                    <div class="col-sm-12">
			                        <div class="form-group has-feedback">
			                            <label for="name">Old Password*</label>
                                         <input type="password" name='old_password' id="old_password" class="form-control" placeholder="Old Password">
			                        </div>

			                    </div>

			                </div><!--/row-->

			                <div class="row">

			                    <div class="col-sm-12">

			                        <div class="form-group has-feedback">
			                            <label for="ccnumber">New Password*</label>
			                            <input type="password"  name='new_password' id="new_password" class="form-control numinput" placeholder="New Password" maxlength="4">
			                        </div>

			                    </div>

			                </div><!--/row-->
                            
                            <div class="row">
                                  <div class="col-sm-12">
                                    	<div class="form-group has-feedback">
			                        	<label class="control-label">Confirm Password*</label>
                                        <input type="password" name='conf_password' id="conf_password" class="form-control numinput" placeholder="Confirm Password" maxlength="4">
			                   			 </div>
                                    </div>
                            </div>
                            
                            

			                <!--/row-->
			            </div>
			        </div>
			    </div><!--/col-->

			    <!--/col-->
			    </div>
                           <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>
                           <a  class="btn btn-sm btn-danger" href="<?php echo base_url();?>departments/users/"><i class="fa fa-ban">Cancel</i></a>                         
                            
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
    $("#chng_password").validate({ 
			rules: {
                old_password:{
                    required:true
                },
                new_password:{
                    required:true
                },
                conf_password:{
                    required:true,
                    equalTo:'#new_password'
                }
            },
			messages:
			{
				old_password:{
                    required:'Please enter old password'
                },
                new_password:{
                    required:'Please enter new password'
                },
                conf_password:{
                    required:'Retype your new password',
                    equalTo:'Confirm password and new password should be same'
                }
			},
		errorPlacement: function(error,element){
            error.appendTo(element.parent().parent());                        
        },
        submitHandler:function(){
                 $("#chng_password button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing");
                chng_password.submit();
        }
    });
    });
    /*$.extend($.validator.messages, {
        required: "Required",
    });*/
</script>
<?php $this->load->view('layouts/footer'); ?>