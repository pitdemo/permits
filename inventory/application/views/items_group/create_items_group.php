<?php $this->load->view('layouts/header');?>
<style type="text/css">
    .sweet-alert h2 {
        font-size:20px !important;
    }
</style>
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
            <a href="<?php echo base_url();?>items_group">Manage Items Group</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Items Group Entry</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <br>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form class="form-horizontal" action="" method="post" name="itemgroup_form" id="itemgroup_form">
                 <input type="hidden" name="e_id" id="e_id" value="" >
               <input type="hidden" name="f_id" id="f_id" value="" > 
            <div class="input_fields_wrap">
            
            <div class="control-group">
      						<label class="control-label" for="form-field-1">Item Group name<sup>*</sup></label>
                <div class="controls">
      		         <input type="text" placeholder="Item Group name" value="<?php echo set_value('item_group_name'); ?>" name="item_group_name" id="item_group_name" >
                    <?php echo form_error('item_group_name');?>
                </div>
      								
            </div>
            <div class="control-group">
                  <label class="control-label" for="form-field-1">Items<sup>*</sup></label>
                <div class="controls">
                 <!-- <input type="hidden" name="persons[]" style="width:220px" id="persons0"/>
                    <?php echo form_error('persons');?> -->
                    <select name="item_id[]" multiple="multiple" id="item_id" style="width:316px;margin-top:-10px">
                     <option value=" "></option>
                       <?php
                        if(!empty($items))
                        {
                            //$srch_items = explode(",",$get['chk_item_id']);
                            foreach($items as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" ><?php echo $item['item_code'].'-'.$item['item_name']; ?></option>
                        <?php
                            }
                        }
    
                        ?>
                    </select>
                </div>
            </div>
            
              <!-- <a href="javascript:void(0)" class="btn btn-mini btn-info fmo_rel cboxElement add_field_button" title="Add More" style="text-decoration: none;float:right; margin-right:520px;">+ Add More</a><br> -->
            </div>
                
      <div class="control-group">
        <div class="controls">       
      <button type="submit" name="add" class="btn btn-info" > Submit <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
      <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>items_group'"> Cancel </button>
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
    <script type="text/javascript" src="<?php echo base_url('js/jquery-1.11.0.min.js')?>"></script> 
    
		<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery.validate.min.js'></script>
   

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
    <script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script>
		<script type="text/javascript">
				$(document).ready(function(){
          $('#item_id').select2({
allowClear: true,
placeholder: "- - Itemwise - - "}); // select box select2 plugin

                    // validation for while clicking the submit button
	               $("#itemgroup_form" ).submit(function( event ) {
                      var itemgroup_already_exists_err=itemgroup_name=items=0;
                      var err_msg='';
                        
                       
                 /*     // validation for expense date   
                    $('input[name="phone_no[]"]').each(function(){
                            if($(this).val()=='')
                            {
                                 date_err++;
                         	    
                            }
                        });*/
											
				/*$('input[name="phone_no[]"]').each(function(){
								if($(this).val()!='')
								{
									 user_phone = $(this).val();
									 phone_pattern = /^\d{10}$/;
									 if(phone_pattern.test(user_phone)==false)
										date_err++;
								}	
				});
*/

 // itemgroup validation
            exists_names='';
                $('input[name="item_group_name"]').each(function(){
                    if($(this).val()=='')
                    {
                         itemgroup_name++; 
                    }
                    else
                    {
                        name = $(this).val();
                        $.ajax({
                           url: '<?php echo base_url();?>items_group/ajax_check_itemgroup_exists_or_not',
                           type: 'POST',
                           data: { name:name },
                           async: false,    
                            success: function(data){ // ajax response return username already exists in admin table
                                    if(data=='exists')
                                    {
                                       itemgroup_already_exists_err++;
                                       exists_names += name+',';
                                    }
                                }
                            });
                    }
                });
            

                   
					$('select[name="item_id[]"]').each(function(){
            //alert($(this).val());
                            if($(this).val() == null)
                            {
                                 items++;	
                            }
                        });
                     
					   
					//validate  Amount
					/*$('input[name="email_ids[]"]').each(function(){
								if($(this).val()=='')
							{
								 email_ids_err++;	
							}
						
					});*/
					
					
				

				/*					//validate Description
					$('textarea[name="cus_add[]"]').each(function(){
								if($(this).val()=='')
							{
								 cus_add_err++;	
							}
						
					});*/

                       
                                        
                    if(itemgroup_name!=0)
                    {
                        err_msg+="\n *  Please fill the Item group name ";
                    }
					 if(itemgroup_already_exists_err!=0)
            {
              err_msg+= "\n * The following Groupname already exists - "+exists_names.substring(0, exists_names.length - 1);+"";
            }
                    
                       if(items!=0)
                    {
                        err_msg+="\n * Please select the items";
                    }
				

                       
					
                       
                    if(itemgroup_name==0&&itemgroup_already_exists_err==0&&items==0)
			         {
					
					if($('#f_id').val()=='')
					{
						console.log('Form sub');
						
						$('#f_id').val(1);
						
						return true;
					}
					else
					{
						console.log('Form Not sub');
						
						return false;
					}
					
				}
				     else
				     {
                        swal(err_msg);  // sweetalert syntax
                        return false;
				     }
                       
                   });
    			   
				});
		
		</script>
 </body>
</html>
