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
            <a href="<?php echo base_url();?>items">Manage Items</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Edit Item</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative">
            <h1>Edit Item</h1>
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form class="form-horizontal" action="" method="post" name="item_form" id="item_form">
            <div class="control-group">
      			<label class="control-label" for="form-field-1">Item Name<sup>*</sup></label>
                <div class="controls">
      													<input type="text" placeholder="Item name" value="<?php echo set_value('item_name',$item_details['item_name']); ?>" name="item_name" id="item_name" >
                    <?php echo form_error('item_name');?>
                </div>
      								
            </div>
            <div class="control-group">
      			<label class="control-label" for="form-field-1">Item Type<sup>*</sup></label>
                <div class="controls">
      				<select name="item_type" id="item_type">
                  		<option value="Manufactured" <?php echo  (set_value('item_type',(isset($item_details['item_type']))?$item_details['item_type']:'') == "Manufactured")?'SELECTED':''; ?>>Manufactured</option>
                  		 <option value="Purchased" <?php echo  (set_value('item_type',(isset($item_details['item_type']))?$item_details['item_type']:'') == "Purchased")?'SELECTED':''; ?>>Purchased</option>
                  		 <option value="Service" <?php echo  (set_value('item_type',(isset($item_details['item_type']))?$item_details['item_type']:'') == "Service")?'SELECTED':''; ?>>Service</option>
                  		 
           	</select>
                </div>
      			<?php echo form_error('plan_method');?>
            </div>
      <div class="control-group">
        <div class="controls">       
      <button type="submit" name="add" class="btn btn-info" > Update <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
      <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>items'"> Cancel </button>
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
					
					var validator = $("#item_form").validate({
					errorClass:'error-val',
					ignore: "",
						rules:
					{
							item_name:
							{
								required:true
							},
							item_type:
							{
								required:true
							},
					},
					messages:
					{
						item_name:
						{
							required: 'Please enter item name'
						},
						item_type:
						{
							required: 'Please choose item type'
						},
					},
					
					errorPlacement: function(error, element)
					{						
						error.insertAfter(element);						
					},
					
					submitHandler: function()
					{
						document.item_form.submit();
						$('button[type=submit], input[type=submit]').attr('disabled',true);
					},
						wrapper: "div"
						
					});
					
				   
				});
		
		</script>
 </body>
</html>
