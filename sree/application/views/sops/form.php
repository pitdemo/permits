<?php $this->load->view('layouts/admin_header',array('page_name'=>(isset($brand_details['name'])) ? 'Edit' : 'Create'.' Department')); 


$id=isset($brand_details['id']) ? base64_encode($brand_details['id']):'';

$plant_types=$this->plant_types; $plant_types=(array_slice($plant_types,0,count($plant_types)-1));

?>
<!--MAIN CONTENT -->
<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>sops/"><i class="fa fa-home"></i>SOPS/WI</a></li>
                                <li class="active"><?php echo (isset($brand_details['name'])) ? 'Edit' : 'Create'; ?> Form</li>
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
                                            <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                                            <input type="hidden" name="uploadpath" id="uploadpath" value="<?php echo (isset($brand_details['file_name'])) ? $brand_details['file_name'] : ''; ?>" />
						<div class="acc-header">
                            	
                           <div class="row">

			    <div class="col-sm-12">

			        <div class="panel panel-default">
			            
			            <div class="panel-body">
                        
                        <?php $this->load->view('layouts/msg'); 
                        $record_type=(isset($brand_details['record_type'])) ? $brand_details['record_type'] : ''; ?>

                            <div class="row">

                                <div class="col-sm-4">

                                    <div class="form-group has-feedback">
                                        <label for="name">Select Department*</label>
                                        <select class="form-control" name="department_id" id="department_id">
                                                <option value="">- - Select Department - - </option>
                                                <?php if(!empty($departments))
                                                {
                                                    foreach($plant_types as $key => $plant)
                                                    {
                                                        echo '<optgroup label="'.$plant.'">';
                                                            foreach($departments as $list)
                                                            {
                                                                $department_id=(isset($brand_details['department_id'])) ? $brand_details['department_id'] : '';
                                                                if($list['plant_type']==$key)
                                                                {
                                                        ?>
                                                        <option value="<?php echo $list['id'];?>" <?php if($department_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                                        <?php }}
                                                        echo '</optgroup>';
                                                    }
                                                } 
                                                
                                                ?>
                                            </select>         
                                          <?php echo form_error('department_id');?>
                                    </div>

                                </div>

                                <div class="col-sm-4" >

                                        <div class="form-group has-feedback">
                                            <label for="name">Record Type*</label>  
                                            <select name="record_type" id="record_type" class="form-control">
                                                    <option value="">Select Record Type</option>
                                                    <option value="<?php echo SOPS; ?>" <?php if($record_type==SOPS) { ?> selected <?php } ?>>SOP</option>
                                                    <option value="<?php echo WORK_INSTRUCTIONS; ?>" <?php if($record_type==WORK_INSTRUCTIONS) { ?> selected <?php } ?>>Work Instruction</option>
                                            </select>
                                        </div>    
                                </div> 

                            </div><!--/row-->

                        
			                <div class="row">

			                    <div class="col-sm-4">

			                        <div class="form-group has-feedback">
			                            <label for="name">Code*</label>
                                         <input type="text"  class="form-control" value="<?php echo set_value('sl_no',(isset($brand_details['sl_no'])) ? $brand_details['sl_no'] : ''); ?>" 
                                         name="sl_no" id="sl_no" >
                                          <?php echo form_error('sl_no');?>
			                        </div>

			                    </div>

                                <div class="col-sm-6">

                                    <div class="form-group has-feedback">
                                        <label for="name">Description*</label>
                                         <input type="text"  class="form-control" value="<?php echo set_value('description',(isset($brand_details['description'])) ? $brand_details['description'] : ''); ?>" 
                                         name="description" id="description" >
                                          <?php echo form_error('description');?>
                                    </div>

                                </div>

			                </div><!--/row-->

                            <div class="row">

                                <div class="col-sm-12">

                                    <div class="form-group has-feedback">
                                        <label for="name">File*</label>
                                         <input type="file" name="sop_file" id="sop_file" />

                                         <br />

                                         <?php


                                          $tx='';
                                          if($id!='')
                                          {

                                            $sel_sop=(isset($brand_details['file_name'])) ? $brand_details['file_name'] : '';

                                            $tx=base_url().'uploads/sops_wi/'.$sel_sop;

                                            $tx='<a href="javascript:void(0);" class="show_image" title="View Description" data-src="'.$tx.'" data-toggle="modal" data-target="#show_records_modal">Show Desc</a>';

                                            echo '<span id="show_sop" style="padding-left:165px;">'.$tx.'</span>';

                                            $this->load->view('layouts/popup_show_image_modal'); 
                                          }  

                                         

                                         ?>
                                    </div>

                                </div>

                            </div><!--/row-->

			            </div>
			        </div>
			    </div><!--/col-->

			    <!--/col-->

			</div>
                           <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>
                           <a  class="btn btn-sm btn-danger" href="<?php echo base_url().$this->data['controller'];?>"><i class="fa fa-ban"> Cancel</i></a>                         
                            
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/additional-methods.js"></script>
<script>
	$(document).ready(function() 
    {

            $('body').on('click','.show_image',function()
           {
            
            var id=$(this).attr('data-src');



            $('#attached_image').html($(this).attr('title'));

                $.ajax({    
                  "type" : "POST",
                  dataType: 'json',
                  "beforeSend": function(){  },
                  "url" : base_url+'eip_checklists/ajax_get_sop_wi/',
                  "data" : {'file_name' : id},
                  success: function(data){
                    $('#show_pdf_information').html(data.response);
                  }
                });     

          });


            $('input[type=file]').on('change', prepareUpload);

            $('input[type=file]').on('click', prepareUpload);
            
            var files;

            function prepareUpload(event)
            {
                files = event.target.files;

                $('#uploadpath').val('');      
            } 


             $("#form").validate({ 
			         rules: {
                        department_id:{
                            required:true
                        },
                        record_type:{required:true},
                        sl_no: { required:true,remote: {
                            url:base_url+"sops/ajax_check_symbol_exists/"+$('#id').val(),
                            type:"post",
                            data:{
                                sl_no: function(){
                                    return $("#sl_no").val();
                                },
                                'record_type':function() {
                                      return $('#record_type').val()
                                }
                            },
                            async:false 
                        } },
                        description:{required:true},
                        sop_file: 
                        {
                            required: {
                                depends: function () { if($( "#uploadpath" ).val()!='') { return false; } else { return true; } }
                            },
                            extension: "pdf",
                            filesize:10
                        }  
                },
    			messages:
    			{
    				department_id:{
                        required:'Required'
                    },
                    record_type:{required:'Required'},
                    sl_no:{
                        required:'Required',
                        remote:'Given symbol is already exists. Please try different one'
                    },
                    description:{
                        required:'Required'
                    },
                    sop_file: { required : 'Required',extension:'Please upload PDF file only'}       
    			},
        		errorPlacement: function(error,element){
                    error.appendTo(element.parent().parent());                        
                },
                submitHandler:function()
                {
                    $("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing");

                    var data = new FormData();
        
                      if(files)
                      {             
                        $.each(files, function(key, value)
                        {
                          data.append(key, value);
                        });
                      }       
                
                      var $inputs = $('form#form :input');
                      $inputs.each(function() {            
                          data.append(this.name,$(this).val());                           
                      });    


                        $.ajax({
                              url: '<?php echo base_url(); ?>sops/ajax_form_submit',
                              type: 'POST',
                              data: data,
                              mimeTypes:"multipart/form-data", 
                              cache: false,
                              dataType: 'json',
                              processData: false, // Don't process the files
                              contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                              success: function(data, textStatus, jqXHR)
                              {
                                  window.location.href=base_url+"sops/index/record_type/"+$('#record_type').val();
                              }                              
                            });

                        return false;
                }
            });

            $.validator.addMethod('filesize', function (value, element, param) {
    
          file_name = $('#uploadpath').val();

          if(file_name!='')
          {

              var extension = file_name.replace(/^.*\./, '');

              extension = extension.toLowerCase();

              console.log('Extension '+extension);

              if(extension!='xlsx')
              return true;

             var iSize = (element.files[0].size / 1024); 
             if (iSize / 1024 > 1) 
             { 
                if (((iSize / 1024) / 1024) > 1) 
                { 
                    iSize = (Math.round(((iSize / 1024) / 1024) * 100) / 100);

                    return false;
                 
                }
                else
                { 
                    iSize = (Math.round((iSize / 1024) * 100) / 100);

                    if(iSize>10)
                      return false;
                    else
                      return true;
                    
                } 
             } 
             else 
             {
                iSize = (Math.round(iSize * 100) / 100);
                return true;
             } 
          }
          else
          return true;   
   
            }, 'File size must be less than 10MB ');

    });
    /*$.extend($.validator.messages, {
        required: "Required",
    });*/
</script>
<?php $this->load->view('layouts/footer'); ?>