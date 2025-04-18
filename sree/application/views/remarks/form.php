<?php 

    $this->load->view('layouts/preload');

    $this->load->view('layouts/user_header');

    $id=(isset($records['id'])) ? $records['id'] : '';

    $job_id=(isset($records['job_id'])) ? $records['job_id'] : '';

    $disabled=''; $permit_no='';

    if($id!='')
    {
        $permit_no=(isset($records['permit_no'])) ? $records['permit_no'] : '';

        $disabled='disabled';
    }   

?>

<link href="<?php echo base_url(); ?>assets/latest/plugins/select2/css/select2.css" rel="stylesheet">

<style>
.error { color:red; font-weight:normal;}
textarea,input[type="text"] { text-transform: uppercase; }
</style>
<div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none" style="<?php echo $this->show_filter_form;?>;">
          <div class="container-xl">
            <div class="row g-2 align-items-center" >
              <div class="col"  style="padding-left:25px;">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Permits
                </div>
                <h2 class="page-title">
                  Safety Remarks
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
                            <form name="job_form" id='job_form' method="post" enctype="application/x-www-form-urlencoded">
                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="form-group has-feedback">
                                                            <label class="form-label">Select Permit No*</label>
                                                            <input type="hidden" name="job_id" id="job_id"  class="select2dropdown form-control" value="<?php echo $job_id; ?>"  data-type="permits" data-account-text="<?php echo $permit_no; ?>" data-account-number="<?php echo $job_id; ?>" data-width="300px" <?php echo $disabled; ?>/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                        <label class="form-label">Title*</label>
                                                        <div class="form-control-plaintext">
                                                        <input type="text" class="form-control" name="title" id="title"  value="<?php echo (isset($records['title'])) ? $records['title'] : ''; ?>"></div>
                                                </div>

                                                <div class="col-sm-4">
                                                        <label class="form-label">Screenshot*</label>
                                                            <div class="form-control-plaintext">
                                                                    <input type="file" class="form-control" name="screenshots" id="screenshots" accept="image/jpeg,image/png,application/gif"/>

                                                                    <input type="hidden" name="screenshots_hidden" id="screenshots_hidden" value="<?php echo (isset($records['images']) && $records['images']!='') ? $records['images'] : ''; ?>"/>
                                                                    <?php echo (isset($records['images']) && $records['images']!='') ? '<br /><a href="javascript:void(0);" class="open_model" data-url="'.base_url().'uploads/permits/'.$job_id.'/'.$records['images'].'" ><img src="'.base_url().'uploads/permits/'.$job_id.'/'.$records['images'].'" width="80" height="80"/></a>' : ''; ?>

                                                            </div>
                                                </div>

                                            </div><!--/row-->

                                            <div class="row"><div class="col-sm-12" id="pdf_response">&nbsp;</div></div>

                                            <div class="row"> 
                                                <div class="col-sm-6">
                                                        <label class="form-label">Comments*</label>
                                                        <textarea rows="5" class="form-control" placeholder="Here can be your comments" name="comments" id="comments"><?php echo (isset($records['comments'])) ? $records['comments'] : ''; ?></textarea>
                                                </div> 
                                                <?php
                                                if($id!=''){

                                                ?>
                                                <div class="col-sm-6">
                                                        <label class="form-label">Responsible Persons</label>
                                                        <?php 
                                                            echo (isset($records['custodian_name'])) ? $records['custodian_name'] : '';
                                                            echo (isset($records['issuer_name'])) ? '<br/>'.$records['issuer_name'] : '';
                                                         ?>
                                                </div> 

                                                <?php
                                                }
                                                ?>
                                            </div><!--/row-->

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                        <div class="form-group has-feedback">
                                                        <input type="submit" name="step1" id="step1" class="btn btn-success submit" value="Save">
                                                        </div>
                                                </div>
                                            </div>

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>

                                            <!--/row-->
                                        </div>
                                                
                                        
                                    </div>
                            </form>
                        </div>
                </div>    

              

           
                <div class="row"><div class="col-sm-12">&nbsp;</div></div>         
                
                <div class="modal modal-blur fade" id="modal-download" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="log_title">Preview</h5>
                            <button type="button" class="btn-close pop_close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="log_text" align="left">
                                <img src="" id="image_url" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-auto pop_close">Close</button>
                        </div>
                        </div>
                    </div>
                </div>

          
          
                </div>
        </div>
      </div> 
<script src="<?php echo base_url(); ?>assets/latest/js/tabler.min.js?1692870487" defer></script>
<script src="<?php echo base_url(); ?>assets/latest/js/demo.min.js?1692870487" defer></script>
<script src="<?php echo base_url();?>assets/latest/js/jquery-3.7.1.js"></script>
<script src="<?php echo base_url(); ?>assets/latest/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/latest/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/additional-methods.js"></script>
<script src="<?php echo base_url(); ?>assets/latest/js/permits.js"></script>
<?php $redirect=base_url().$param_url; ?>
<script type="text/javascript">

$(document).ready(function() {

    $('#screenshots').on('change', prepareUpload);
    
    var files; var report_file;

    function prepareUpload(event)
    { 
      files = event.target.files;
    }

    $('body').on('click','.pop_close',function() 
    {
        $('#modal-download').modal('hide');
    });

    $('body').on('click','.open_model',function() 
    {
        var data_url=$(this).attr('data-url');	
        
        $('#image_url').attr('src',data_url);

        $('#modal-download').modal('show');
    });

    $("#job_form").validate({ 
          ignore: '.ignore, .cr-slider',
          focusInvalid: true, 
          errorClass: 'error is-invalid',
          validClass: 'is-valid',
          debug:true,
			rules: {
                title:{
                    required:true
                },
                screenshots: { required:function(element) { if($('#screenshots_hidden').val()=='') return true; else return false; },extension: "png|jpeg|jpg|gif",filesize: 1048576 },	 
                comments:{
                    required:true
                }
            },
		errorPlacement: function(error,element){
            error.appendTo(element.parent().parent());                        
        },
        submitHandler:function(){

            $(".submit").val("Processing...").attr('disabled',true);   

                var data = new FormData();          
                var $inputs = $('form#job_form :input[type=text],form#job_form :input[type=hidden],select,textarea,form#job_form :input[type=radio]');
                    $inputs.each(function() {
                    if(this.type=='radio')
                    {
                        if(this.name)
                        {
                        var checked_val = $("input[name="+this.name+"]:checked").val();
                        
                        data.append(this.name,checked_val);
                        }
                    }
                    else
                    {
                        console.log('Input Name ',this.name+ ' '+$(this).val());
                        data.append(this.name,$(this).val());
                    }
                    
                });   

                if(files)
                {
                    $.each(files, function(key, value)
                    {
                        console.log('Key '+key+' - '+value+' Name : '+$(this).attr('name'));
                        data.append(key, value);
                        // data.append(key,'file');
                    });
                }

                $.ajax({    
                "type" : "POST",
                "url" : base_url+'remarks/form_action',	
                data:data,	
                processData: false,
                contentType: false,
                dataType:"json",
                    success:function(data){                        
                      window.location.href='<?php echo $redirect; ?>';
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                    //if fails      
                    $('#pdf_response').html('Error in '+jqXHR?.responseText+' = '+textStatus+'. Please contact system administrator');
                    $(".submit").val("Save").prop('disabled',false);   
                    }
                });	
           

        }
    });

        $.validator.addMethod('filesize', function(value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
    }, 'File size must be less than {0} bytes');
});

</script>

</body>
</html>

  