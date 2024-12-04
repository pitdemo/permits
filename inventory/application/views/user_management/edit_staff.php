
<?php $this->load->view('layouts/header');?>
<style type="text/css">
input[type="text"] { width:180px; }
input[type="password"] { width:180px; }
select{width:190px;}
</style>

<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
</script>
<body>
<div class="navbar navbar-inverse header-con">
    <?php $this->load->view('layouts/logo');?>
  <!--/.navbar-inner--> 
</div>
<div class="container-fluid" id="main-container">
 <a id="menu-toggler" href="#"> <span></span> </a>
   <?php $this->load->view('layouts/menu');?>
  <div id="main-content" class="clearfix">
    <div id="breadcrumbs">
      <ul class="breadcrumb">
      	 <li>
            <a href="<?php echo base_url();?>user_management">Manage Users</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Edit User Details</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    
    <div id="page-content" class="clearfix"> 
    
       <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>>
            <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative" style="border-bottom:none !important;">
           
          </div>
          <div class="row-fluid" > 
            <!--PAGE CONTENT BEGINS HERE-->
            <form class="form-horizontal" action="" method="post" name="staff_form" id="staff_form">
            <div class="control-group">
      			<label class="control-label" for="form-field-1">First Name<sup>*</sup></label>
                <div class="controls">
      			<input type="text" name="staff_firstname" value="<?php echo set_value('adm_firstname',$staff_details['adm_firstname']); ?>" >
                </div>
            </div>
           <div class="control-group">
      			<label class="control-label" for="form-field-1">Last Name</label>
                <div class="controls">
			<input type="text" name="staff_lastname" value="<?php echo set_value('adm_lastname',$staff_details['adm_lastname']); ?>">                </div>
            </div>
            <div class="control-group">
      			<label class="control-label" for="form-field-1">User Name</label>
                <div class="controls">
			<input type="text" name="user_name" value="<?php echo set_value('adm_username',$staff_details['adm_username']); ?>" readonly>                </div>
            </div>
            <div class="control-group">
      			<label class="control-label" for="form-field-1">Password<sup>*</sup></label>
                <div class="controls">
			<input type="password" name="password" value="<?php echo set_value('adm_password',$this->encrypt->decode( $staff_details['adm_password'])); ?>">
                            </div>
            </div>
           
            <div class="control-group">
      			<label class="control-label" for="form-field-1">User Role</label>
                <div class="controls">
      			<select name="user_role" id="user_role" >
                               <?php
                                $user_types = unserialize(USER_ROLES);
                                foreach($user_types as $role)
                                {
                            ?>
         <option value="<?php echo $role ?>" <?php echo ($role == $staff_details['user_role'])?'selected="selected"':"";?>><?php echo ucfirst($role); ?></option>
         
                            <?php } ?>
                            </select>
                </div>
            </div>
             <div class="control-group">
      			<label class="control-label" for="form-field-1">Email-Id</label>
                <div class="controls">
			<input type="text" name="email_id" value="<?php echo set_value('adm_email',$staff_details['adm_email']); ?>">                            </div>
            </div>
             <div class="control-group">
      		<label class="control-label" for="form-field-1">Phone No<sup>*</sup></label>
            <div class="controls">
			<input type="text" name="phone_no" value="<?php echo set_value('phone_no',$staff_details['phone_no']); ?>">                            			            </div>
            </div>
            <div class="control-group">
      			<label class="control-label" for="form-field-1">User Permissions<sup>*</sup></label>
                <div class="controls">
      			<select name="permissions[]" id="permissions" multiple="multiple" style="width:200px;">
                               <?php
                               $permission_value=$staff_details['permissions'];
							   $selected_values = explode(",",$permission_value);
								$user_permissions = unserialize(USER_PERMISSIONS);
                                foreach($user_permissions as $permissions)
                                {
                           
                            echo "<option value='$permissions'".((in_array($permissions,$selected_values)) ? " selected='selected'":"").">$permissions</option>"; ?>
                            <?php } ?>
                            </select>
                </div>
            </div>
			<div class="control-group">
      			<label class="control-label" for="form-field-1">&nbsp;</label>
                <div class="controls">
      			<input type="checkbox" style="opacity:1" class="select_all" title="permissions" />&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;  Select All
							
                </div>
            </div>
           
      <div class="control-group">
        <div class="controls">       
      <button type="submit" name="add" class="btn btn-info" > Update <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
      <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>user_management'"> Cancel </button>
      </div>
      </div>
      <aside class="clear"></aside>
    </form>
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div><br/><br/>
       <?php $this->load->view('layouts/footer');?>
    </div>
    <!--/#page-content--> 
  </div>
  <!--/#main-content--> 
</div>
</div>
</div>
<?php $this->load->view('layouts/footer_script');?>
<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script>
  <script type="text/javascript">
        $("document").ready(Show_Alert());
 
        function Show_Alert() 
		{
          $('select[name="user_role"]').each(function(){
		   $('#permissions').prop('disabled', $(this).val() === 'super_admin');
		    $('#permissions').prop('enabled', $(this).val() === 'admin');
		  $('#permissions').prop('enabled', $(this).val() === 'staff');
		    $('#permissions').prop('enabled', $(this).val() === 'viewer');
		  
		  });
        }
		</script>
       
<script type="text/javascript">
$(function(){
    
    
   
    // form validation while clicking submit button
        $("#staff_form" ).submit(function( event ) {
            f1=password_err=phone_err=invalid_phone_err=email_err=invalid_email_err=email_already_exist_err=permisssion_err=0;
            msg='';
            
            
            //firstname validation
            $('input[name="staff_firstname"]').each(function(){
                    if($(this).val()=='')
                    {
                         f1++;	
                    }	
				});
          
            //password validation
            $('input[name="password"]').each(function(){
                    if($(this).val()=='')
                    {
                         password_err++;	
                    }	
            });
             //get user role
            		
			$('#user_role').change(function() {
			$('#permissions').prop('disabled', $(this).val() === 'super_admin');
			 $('#permissions').prop('enabled', $(this).val() === 'admin');
			$('#permissions').prop('enabled', $(this).val() === 'staff');
			$('#permissions').prop('enabled', $(this).val() === 'viewer');
			}).change(); // And invoke immediately

			
					
            //phone no validation
            $('input[name="phone_no"]').each(function(){
  				if($(this).val()=='')
  				{
  					phone_err++;
  				}
  				else
  				{
					 user_phone = $(this).val();
					 phone_pattern = /^\d{10}$/;
					 if(phone_pattern.test(user_phone)==false)
						invalid_phone_err++;
  				}	
                });
            
            
               
            //email validation
            exists_emails='';
            $('input[name="email_id"]').each(function(){
				if($(this).val()!='')
  				{
					 user_email = $(this).val();
					 email_pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
					 if(email_pattern.test(user_email)==false)
                     {
						 invalid_email_err++;
                     }
                     else // using ajax to check email id already present in admin table
                     {
                          $.ajax({
                           url: '<?php echo base_url();?>user_management/check_email_exists_or_not',
                           type: 'POST',
                           data: { email_id:user_email,staff_id:<?php echo $staff_details['adm_id'];?>},
                           async: false,    
                            success: function(data){ // ajax response return email id already exists in admin table
                                    if(data=='exists')
                                    {
                                        email_already_exist_err++;
                                       exists_emails += user_email+',';
                                    }
                                }
                            });
                     }
  		        }	
              });
            
			//permissions validation
             $('select[name="permissions[]"]').each(function(){
                    if($(this).val()==null && ($('#user_role').val() =='staff' || $('#user_role').val() =='admin' || $('#user_role').val() =='viewer') )
                    {
                         permisssion_err++;	
                    }	
				
            });
			
			
            //set the error msg here
            if(f1!=0)
            {
                    msg+= "\n * Please fill the Firstname";
            }
         
          
            if(password_err!=0)
            {
                    msg+= "\n * Please fill the Password";
            }
            if(phone_err!=0)
            {
                 msg+="\n * Please fill the Phone No";
            }	
            if(invalid_phone_err!=0)
            {
                msg+="\n * Invalid Phone Number format(10 numbers only)";
            }
	       if(invalid_email_err!=0)
           {
	           msg+="\n * Invalid Email format";
	       }  
           
            
             if(email_already_exist_err!=0)
            {
              msg+= "\n * The following Email ids already exists - "+exists_emails.substring(0, exists_emails.length - 1);+"";
            }
              if(permisssion_err!=0)
            {
                 msg+="\n * Please select the User Permission";
            }
            
            
            if(f1==0&&password_err==0&&phone_err==0&&invalid_phone_err==0&&email_err==0&&invalid_email_err==0&&email_already_exist_err==0&&permisssion_err==0)
		    {
				return true;
			}
			else
			{
                swal(msg); // sweetalert syntax
                return false;
            }
        });	
				var $permissions=$("#permissions").select2({
									allowClear: true,
									placeholder: "- - Select - - "
								});
								
				//checkall permission script
			$(".select_all").click(function(){
					
					var sel=$(this).attr('title');
					
						if($(this).is(':checked') ){
							$("#"+sel+" > option").prop("selected","selected");
						}else{
							$("#"+sel+" > option").removeAttr("selected");
						 }
						 
						 $("#"+sel).trigger("change");
				});
		//end
    //end
});    
</script>
	</body>
</html>

	