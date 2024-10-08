<?php 

    $this->load->view('layouts/preload');

    $this->load->view('layouts/user_header');

?>

<link href="<?php echo base_url(); ?>assets/css/bootstrap-table.css" type="text/css" rel="stylesheet"> 
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/common.css" rel="stylesheet" type="text/css" />
<style>
.error { color:red; font-weight:normal;}
</style>
<div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Settings
                </div>
                <h2 class="page-title">
                  Change Password
                </h2>
              </div>
              <!-- Page title actions -->
             
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
                            <form name="chng_password" id='chng_password' method="post" enctype="application/x-www-form-urlencoded">
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
                                                        <input type="password"  name='new_password' id="new_password" class="form-control" placeholder="New Password">
                                                    </div>

                                                </div>

                                            </div><!--/row-->
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                        <div class="form-group has-feedback">
                                                        <label class="control-label">Confirm Password*</label>
                                                        <input type="password" name='conf_password' id="conf_password" class="form-control" placeholder="Confirm Password">
                                                        </div>
                                                    </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                        <div class="form-group has-feedback">
                                                        <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>
                                                        </div>
                                                    </div>
                                            </div>

                                            <!--/row-->
                                        </div>
                                                
                                        
                                    </div>
                            </form>
                        </div>
                </div>    

           
          </div>
        </div>
      </div> 
<script src="<?php echo base_url(); ?>assets/js/jquery.min2.0.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
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
  </body>
</html>

  