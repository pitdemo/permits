<?php $this->load->view('layouts/header');?>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
</script>
<body>
<div class="navbar navbar-inverse header-con">
    <?php $this->load->view('layouts/logo');?>
  <!--/.navbar-inner--> 
</div>
<div class="container-fluid" id="main-container"> <a id="menu-toggler" href="#"> <span></span> </a>
   <?php $this->load->view('layouts/menu');?>
  <div id="main-content" class="clearfix">
    <div id="breadcrumbs">
      <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url();?>suppliers">Manage Suppliers</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Edit Suppliers</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative">
            <h1>Edit Supplier</h1>
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form class="form-horizontal" action="" method="post" name="supplier_form" id="supplier_form">
              <div class="control-group">
      								<label class="control-label" for="form-field-1">Sales Person<sup>*</sup></label>
                <div class="controls">
                    <select name="sales_person_id" id="sales_person_id" style="width:220px">
                       <?php
                            // display expense category based on optgroup
                        if(!empty($sales_persons))
                        {
                            echo "<optgroup label='Sales person Name'>";
                            foreach($sales_persons as $sales_person)
                            {
                                $selected_opt='';
                               
                                    if($supplier_details['sales_person_id']==$sales_person['id'])
                                        $selected_opt = "selected='selected'";
                             // end
                        ?>
                           <option value="<?php echo $sales_person['id']; ?>-s" <?php echo $selected_opt; ?>><?php echo ucfirst($sales_person['sales_person_name']); ?></option>
                        <?php
                            }
                            echo "</optgroup>";
                        }
    
                        ?>
                       
                       
                    </select>   													
                    <?php echo form_error('sales_person_id');?>
                </div>
            </div>
            
            
            
            <div class="control-group">
      			<label class="control-label" for="form-field-1">Customer Name<sup>*</sup></label>
                <div class="controls">
      													<input type="text" placeholder="Customer name" value="<?php echo set_value('supplier_name',$supplier_details['supplier_name']); ?>" name="supplier_name" id="supplier_name" >
                    <?php echo form_error('supplier_name');?>
                </div>
      								
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Email</label>
                <div class="controls">
      													<input type="text" placeholder="Email address" value="<?php echo set_value('email_id',$supplier_details['email_id']); ?>" name="email_id" id="email_id" >
                    <?php echo form_error('email_id');?>
                </div>
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Phone No.</label>
                <div class="controls">
      													<input type="text" placeholder="Phone no" value="<?php echo set_value('phone_no',$supplier_details['phone_no']); ?>" name="phone_no" id="phone_no" >
                    <?php echo form_error('phone_no');?>
                </div>
            </div>
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Address</label>
                <div class="controls">
      													<textarea name="address" id="address" rows="5"><?php echo set_value('address',strip_tags($supplier_details['address'])); ?></textarea>
                    <?php echo form_error('address');?>
                </div>
      								
            </div>
      <div class="control-group">
        <div class="controls">       
      <button type="submit" name="add" class="btn btn-info" > Update <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
      <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>suppliers'"> Cancel </button>
      </div>
      </div>
      <aside class="clear"></aside>
    </form>
            
            <!--PAGE CONTENT ENDS HERE--> 
          </div>
        </div>
        
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div><br/><br/>
       <?php $this->load->view('layouts/footer');?>
      <!--/row--> 
    </div>
    <!--/#page-content--> 
    
    <!--/#ace-settings-container--> 
  </div>
  <!--/#main-content--> 
</div>
<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> 
	<?php $this->load->view('layouts/footer_script');?> 
		<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery.validate.min.js'></script>
		<script type="text/javascript">
				$(document).ready(function(){
					
					var validator = $("#supplier_form").validate({
					errorClass:'error-val',
					ignore: "",
						rules:
					{
							sales_person_id:
							{
								required:true
							},
							supplier_name:
							{
								required:true
							},
							email_id:
							{
								email:true
							},
							phone_no:
							{
								number:true,
								maxlength: 10,
							}
					},
					messages:
					{
						sales_person_id:
						{
							required: 'Please choose sales Person'
						},
						supplier_name:
						{
							required: 'Please enter Supplier name'
						},
						email_id:
						{
							email: 'Please enter valid email format'
						},
						phone_no:
							{
								number:"Please enter only numbers",
							},
					},
					
					errorPlacement: function(error, element)
					{						
						error.insertAfter(element);						
					},
					
					submitHandler: function()
					{
						document.supplier_form.submit();
						$('button[type=submit], input[type=submit]').attr('disabled',true);
					},
						wrapper: "div"
						
					});
					
				   
				});
		
		</script>
 </body>
</html>
