<?php 
$page_name='Create Account';
 if(isset($user_info['id'])){
     $page_name='Edit Account';
 }
$this->load->view('layouts/admin_header',array('page_name'=>$page_name)); ?>

<!-- start: Content -->

<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>departments/users"><i class="fa fa-home"></i>Department Users</a></li>
                                <li class="active"><?php echo isset($user_info['id'])?'Edit':'Create';?> Account</li>                                
                                
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

 					<div class="panel panel-default">
						<div class="acc-header">
                         <form role="form" id="form" name="form" method="post" enctype="application/x-www-form-urlencoded">
                            	<input type="hidden" id="id" name="id" value="<?php echo isset($user_info['id']) ? base64_encode($user_info['id']):'';?>">
                           <div class="row">

			    <div class="col-sm-6">

			        <div class="panel panel-default">
			            <div class="panel-heading">
			                <h2><strong>Account</strong> <small>Info</small></h2>
			            </div>
			            <div class="panel-body">
			                <div class="row">

			                    <div class="col-sm-12">

			                        <div class="form-group has-feedback">
			                            <label for="name">Select Department*</label>
                                        <select size="1" class="form-control input-sm" name="department_id" id="department_id" tabindex="1" autofocus>
                                        	<option value="" selected>Select</option>
                                            <?php if(!empty($departments)) {  foreach($departments as $list){?>
                                            <option value="<?php echo $list['id'];?>"><?php echo $list['name'];?></option>
                                            <?php } } ?>
			                            </select>
			                        </div>

			                    </div>
                               
			                </div><!--/row-->

			                <div class="row">

			                    <div class="col-sm-12">

			                        <div class="form-group has-feedback">
			                            <label for="ccnumber">Full Name</label>
			                            <input type="text"  id="first_name" name="first_name" placeholder="Full Name" class="form-control" value="<?php echo isset($user_info['first_name']) ? $user_info['first_name'] :'';?>" tabindex="2">
			                        </div>

			                    </div>

			                </div><!--/row-->
                            
                            <div class="row">
                                  <div class="col-sm-12">
                                    	<div class="form-group has-feedback">
			                        	<label class="control-label">Mobile Number*</label>
                                        <input type="text" class="form-control" placeholder="Enter 10digit Mobile Number" name="mobile_number" id="mobile_number" value="<?php echo isset($user_info['mobile_number']) ? $user_info['mobile_number'] :'';?>" tabindex="3">
			                   			 </div>
                                    </div>
                            </div>
                            
                             <?php $isolator=isset($user_info['is_isolator']) ? $user_info['is_isolator'] :'No';
                             $is_safety=isset($user_info['is_safety']) ? $user_info['is_safety'] :'No';
							 ?>
                             
                            <div class="row" id="isolator_yes" style="display:<?php echo ($isolator=='No') ? 'none' : 'block'; ?>;">
                                  <div class="col-sm-12">
                                    	<div class="form-group has-feedback">
			                        	<label class="control-label">Select Isolation types*</label>
                                       
                                        <select size="10" style='height: auto !important;'  class="form-control input-sm" multiple="multiple" name="isolations" id="isolations" tabindex="4">
                                            <?php
											foreach($isolations as $isolation)
											{
												$id=$isolation['id'];
												
													if(in_array($id,$user_isolations))
													$sel="selected";
													else
													$sel='';
											?>	
			                                <option value="<?php echo $id; ?>" <?php echo $sel; ?>><?php echo $isolation['name']; ?></option>
                                            <?php
											}
											?>
			                            </select>
			                   			 </div>
                                    </div>
                            </div>


                            <div class="form-group">
                                <label for="vat">Is Safety</label>
                                        <?php
										$roles=array('Yes','No');
										?>
                                        <select size="1" class="form-control input-sm" name="is_safety" id="is_safety" tabindex="9">                                        	
                                            <?php
											foreach($roles as $role_name)
											{
												if($role_name==$is_safety)
												$chk="selected";
												else
												$chk='';
											?>	
			                                <option value="<?php echo $role_name; ?>" <?php echo $chk; ?>><?php echo $role_name; ?></option>
                                            <?php
											}
											?>
			                            </select>
			                 </div>

			                <!--/row-->
			            </div>
			        </div>

			    </div><!--/col-->

			    <div class="col-sm-6">

			        <div class="panel panel-default">
			            <div class="panel-heading">
			                <h2><strong>Login</strong> <small>Info</small></h2>
			            </div>
			            <div class="panel-body">
			                <div class="form-group">
			                    <label for="company">Username*</label>
			                    <input type="text"  id="email_address" class="form-control" name="email_address" value="<?php echo isset($user_info['email_address']) ? $user_info['email_address'] :'';?>" tabindex="5" placeholder="Username" style="text-transform:lowercase;">
			                </div>

                            <div class="form-group">
                                <label for="vat">Password*</label>
                                <input type="text" tabindex="6"  id="pass_word" name="pass_word" class="form-control" value="<?php echo isset($user_info['pass_word']) ? base64_decode($user_info['pass_word']) :'';?>" placeholder="Password">
                                <button class="btn btn-xs btn-flickr gen_pwd" type="button" style="margin-top: 4px;float:right;" tabindex="7"><span style="margin-left:0px">Generate Password</span></button>
                            </div>


							<div class="form-group">
                                <label for="vat">Is Isolator</label>
                                        <?php
										$roles=array('Yes','No');
										?>
                                        <select size="1" class="form-control input-sm" name="is_isolator" id="is_isolator" tabindex="8">                                        	
                                            <?php
											foreach($roles as $role_name)
											{
												if($role_name==$isolator)
												$chk="selected";
												else
												$chk='';
											?>	
			                                <option value="<?php echo $role_name; ?>" <?php echo $chk; ?>><?php echo $role_name; ?></option>
                                            <?php
											}
											?>
			                            </select>
			                 </div>


			                 <div class="form-group">
                                <label for="vat">Permission*</label>
                                        <?php
                                        $permission=isset($user_info['permission']) ? $user_info['permission'] :WRITE;
										$roles=array(READ,WRITE);
										?>
                                        <select size="1" class="form-control input-sm" name="permission" id="permission" tabindex="9">                                        	
                                            <?php
											foreach($roles as $role_name)
											{
												if($role_name==$permission)
												$chk="selected";
												else
												$chk='';
											?>	
			                                <option value="<?php echo $role_name; ?>" <?php echo $chk; ?>><?php echo ucfirst($role_name); ?></option>
                                            <?php
											}
											?>
			                            </select>
			                 </div>

			                <!--/row-->

			                
			            </div>
			        </div>

			    </div><!--/col-->

			</div>
                           <button class="btn btn-sm btn-primary" type="submit" tabindex="8"><i class="fa fa-dot-circle-o"></i> Submit</button>
                           
                           <?php
						   $redi='';
						   if(isset($user_info['id']))
						   $redi='/department_id/'.$user_info['department_id'];
						   
						   ?>
                           <a class="btn btn-sm btn-danger" href="<?php echo base_url();?>departments/users<?php echo $redi; ?>" tabindex="9"><i class="fa fa-ban"></i> Cancel</a>
                           			
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
	
	
		$('#is_isolator').change(function() {
			
			var val=$(this).val();
			
				if(val=='Yes')
				{
					$('#isolator_yes').show();
				}
				else
					$('#isolator_yes').hide();
			 });
                    <?php if(isset($user_info['department_id']) &&  $user_info['department_id'] !='') { ?>                    
                                        $('#department_id').val('<?php echo $user_info['department_id'];?>') ;
                                        //$('#email_address').prop('disabled','disabled') ;
                                <?php } 
        //Changing the selection if company id exisits in url
        $comp = array_search('department_id',$this->uri->segment_array());
        $department_id='';
        if($comp !==FALSE && $this->uri->segment($comp+1))
        {?>
            $('#department_id').val('<?php echo $this->uri->segment($comp+1);?>') ;
            <?php    
        }
        ?>

          $.extend($.validator.messages, {
              required: "Required",
        });
		// validate signup form on keyup and submit
		$("#form").validate({
			rules: {
				department_id: { required:true },	
				permission: {required:true},			
				first_name: { required:true,name_format: true },
				mobile_number: { required: true,digits:true,maxlength:10 },
				email_address: { required:true,minlength:6,maxlength:55,remote: {
					url:base_url+"users/ajax_check_email_exists/"+$('#id').val(),
					type:"post",
					data:{
						username: function(){
							return $("#email_address").val();
						}
					},
					async:false 
				} },
                isolations: { required:function(element) { if($('#is_isolator').val()=='Yes') return true; else return false; } },				
				pass_word:{required: true, password_format: true, minlength:3, maxlength:16},
			},
			messages: {
                email_address: { required:"Required",remote:'Given username is already exists. Please try different one'},
			}
			,submitHandler: function()
			{
				$("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled','disabled');
				//document.admin_user_form.submit();
					var data = new FormData();					
                    var $inputs = $('form#form :input');
                     $inputs.each(function() {
                            data.append(this.name,$(this).val());
                    });						
						if($('#id').val()=='')
						data.append('submit','insert');
						else
						data.append('submit','update');
			
					$.ajax({
						url: base_url+'departments/user_form_action/',
						type: 'POST',
						"beforeSend": function(){ },
						data: data,
						cache: false,
						dataType: 'json',
						processData: false, // Don't process the files
						contentType: false, // Set content type to false as jQuery will tell the server its a query string request
						success: function(data, textStatus, jqXHR)
						{
                            if(data){
                                window.location.href='<?php echo base_url();?>departments/users/department_id/'+$('#department_id').val();
                            }
                            //$("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Done").prop('disabled',false);							
						},
						error: function(data, textStatus,errorThrown)
						{
                                //$("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").prop('disabled',false);
								$('#error').show();
								
								$('#error_msg').html(data.failure);
		
						}
					});
				}			
		});
		
	$.validator.addMethod('name_format',function(value, element){
		return this.optional(element)	|| /^[a-zA-Z\s.']+$/i.test(value);
	},"Please enter Only Characters");
		
	jQuery.validator.addMethod("password_format", function(value, element){
		if(value.indexOf(' ') === -1)
			return true;
		else
			return false;
    },"Passwords are 3-16 characters without spaces");

	$(document).on("click",'.gen_pwd', function(e){
			e.preventDefault();
			var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
			var pass = "";
			
			for (var x = 0; x < 8; x++) {
				var i = Math.floor(Math.random() * chars.length);
				pass += chars.charAt(i);
			}
			$("#pass_word").val(pass);
			$("#pass_word").valid();
		});
        

	});
	</script>

<?php $this->load->view('layouts/footer'); ?>