<?php $this->load->view('layouts/admin_header',array('page_name'=>(isset($brand_details['name'])) ? 'Edit' : 'Create'.' Department')); ?>
<!--MAIN CONTENT -->
<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>hod/"><i class="fa fa-home"></i>HOD's</a></li>
                                <li class="active">Set HOD's</li>                                
                                
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

                        if($msg!='')
                        {

                       ?>
                        <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?php echo $msg;?></strong> 
                        </div>
                        <?php
                        }
                        ?>



                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group has-feedback" style="text-align:center;">
                                        <label style="text-align:center;"><?php echo $selected_plant_type; ?> Department Name</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group has-feedback" style="text-align:center;">
                                        <label><?php echo $selected_plant_type; ?>  Users Name</label>
                                    </div>
                                </div>
                            </div>    


                            <?php

                            $d=1; $validate='';
                            foreach($departments as $department)
                            {
                                $department_id=$department['id'];

                                $validate.="'user_id[".$d."]': {required:true},";

                            ?>
			                <div class="row">

			                    <div class="col-sm-6">

			                        <div class="form-group has-feedback">
			                           
                                         <input type="hidden" value="<?php echo $department_id; ?>"  name="department_id[]" id="department_id[]" >
                                          <?php echo $department['name']; ?>
			                        </div>

			                    </div>

                                <div class="col-sm-6">

                                    <div class="form-group has-feedback">
                                       
                                            <select name="user_id[<?php echo $d; ?>]" id="user_id<?php echo $d; ?>" class="form-control">
                                                <option value="">- - Select - -</option>
                                                <?php
                                                $u=0;
                                                foreach($users as $user)
                                                {
                                                    $user_id=$user['id'];

                                                    $user_department_id=$user['department_id'];

                                                    $user_name=$user['first_name'];

                                                    $is_hod=$user['is_hod'];

                                                    if($department_id==$user_department_id)
                                                    {

                                                ?>
                                                    <option value="<?php echo $user_id; ?>" <?php if($is_hod==YES) { ?> selected="selected" <?php } ?>><?php echo $user_name; ?></option>  
                                                <?php
                                                        #unset($users[$u]);
                                                    }   

                                                    $u++;   
                                                }
                                                ?>
                                            </select>    
                                    </div>

                                </div>

			                </div>

                            <?php
                                $d++;
                            }
                            ?>


			            </div>
			        </div>
			    </div><!--/col-->

			    <!--/col-->

			</div>
                           <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>
                                      
                            
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
	$(document).ready(function(){
    $("#form").validate({ rules: {
            <?php echo rtrim($validate,','); ?>
    }   
   });
  });
    /*$.extend($.validator.messages, {
        required: "Required",
    });*/
</script>
<?php $this->load->view('layouts/footer'); ?>