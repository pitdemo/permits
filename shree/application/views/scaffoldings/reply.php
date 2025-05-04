<?php 

    $this->load->view('layouts/preload');

    $this->load->view('layouts/user_header');

    $id=(isset($records['id'])) ? $records['id'] : '';

    $job_id=(isset($records['job_id'])) ? $records['job_id'] : '';

    $disabled=''; $remarks_id='';

    if($id!='')
    {
        $remarks_id=(isset($records['remarks_id'])) ? $records['remarks_id'] : '';

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
                            <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id; ?>" />
                            <input type="hidden" id="remarks_id" name="remarks_id" value="<?php echo $records['remarks_id']; ?>" />
                            <input type="hidden" id="remarks_owner_user_id" name="remarks_owner_user_id" value="<?php echo $records['remarks_owner_user_id']; ?>" />
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="form-group has-feedback">
                                                            <label class="form-label">Remark ID</label>
                                                            <?php echo $remarks_id; ?>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                        <label class="form-label">Title</label>
                                                        <div class="form-control-plaintext">
                                                        <?php echo (isset($records['title'])) ? $records['title'] : ''; ?>
                                                        </div>
                                                </div>

                                                <div class="col-sm-2">
                                                        <label class="form-label">Screenshot</label>
                                                            <div class="form-control-plaintext">
                                                                    <?php echo (isset($records['images']) && $records['images']!='') ? '<br /><a href="javascript:void(0);" class="open_model" data-url="'.base_url().'uploads/permits/'.$job_id.'/'.$records['images'].'" ><img src="'.base_url().'uploads/permits/'.$job_id.'/'.$records['images'].'" width="80" height="80"/></a>' : ''; ?>
                                                            </div>
                                                </div>

                                                <div class="col-sm-2">
                                                        <label class="form-label">Responsible Persons</label>
                                                        <?php 
                                                            echo (isset($records['custodian_name'])) ? $records['custodian_name'] : '';
                                                            echo (isset($records['issuer_name'])) ? '<br/>'.$records['issuer_name'] : '';
                                                         ?>
                                                </div> 

                                                

                                            </div><!--/row-->

                                            <div class="row"><div class="col-sm-12" id="pdf_response">&nbsp;</div></div>

                                            <div class="row"> 
                                                <div class="col-sm-6">
                                                        <label class="form-label">Comments</label>
                                                        <?php echo (isset($records['comments'])) ? $records['comments'] : ''; ?>
                                                </div> 
                                                <div class="col-sm-2">
                                                        <label class="form-label">Raised by</label>
                                                        <?php 
                                                            echo (isset($records['first_name'])) ? $records['custodian_name'] : '';
                                                         ?>
                                                </div> 
                                                <div class="col-sm-2">
                                                        <label class="form-label">Raised on</label>
                                                        <?php 
                                                            echo (isset($records['created'])) ? date('d.m.Y H:i A',strtotime($records['created'])) : '';
                                                         ?>
                                                </div> 
                                            </div><!--/row-->

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>

                                            <div class="row"><div class="col-sm-12 text-warning" style="text-transform:uppercase;"><b><u>Your Comments Here</u></b></div></div>

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>

                                          

                                            <?php
                                            if(count($conversations)>0) {

                                               # echo '<pre>'; print_r($conversations);

                                            ?>
                                            <div class="chat">
                                                    <div class="chat-bubbles">
                                                        <?php
                                                        foreach($conversations as $key => $conversation):

                                                            $is_safety=$conversation['is_safety'];

                                                            $first_name=$conversation['first_name'];

                                                            $comments=$conversation['comments'];

                                                            $created=$conversation['created'];

                                                            $image_path=(isset($conversation['images']) && $conversation['images']!='') ? base_url().'uploads/permits/'.$job_id.'/'.$conversation['images'] : base_url().'assets/img/noimage.png';

                                                            $image='<div class="col-auto"><a href="javascript:void(0);" class="open_model" data-url="'.$image_path.'" ><span class="avatar" style="background-image: url('.$image_path.')"></span></a></div>';
                                                        ?>
                                                        <?php
                                                        if($is_safety=='yes') {

                                                        ?>
                                                        <div class="chat-item">
                                                            <div class="row align-items-end justify-content-end">
                                                                <div class="col col-lg-6">
                                                                <div class="chat-bubble chat-bubble-me">
                                                                    <div class="chat-bubble-title">
                                                                    <div class="row">
                                                                        <div class="col chat-bubble-author"><?php echo $first_name; ?></div>
                                                                        <div class="col-auto chat-bubble-date"><?php echo date('d.m.Y H:i A',strtotime($created)); ?></div>
                                                                    </div>
                                                                    </div>
                                                                    <div class="chat-bubble-body">
                                                                    <p><?php echo $comments; ?></p>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                                <?php
                                                                  echo $image; ?>
                                                            </div>
                                                        </div>
                                                        <?php } else { ?>
                                                        <div class="chat-item">
                                                            <div class="row align-items-end">
                                                                <?php
                                                                  echo $image; ?>
                                                                <div class="col col-lg-6">
                                                                <div class="chat-bubble">
                                                                    <div class="chat-bubble-title">
                                                                    <div class="row">
                                                                        <div class="col chat-bubble-author"><?php echo $first_name; ?></div>
                                                                        <div class="col-auto chat-bubble-date"><?php echo date('d.m.Y H:i A',strtotime($created)); ?></div>
                                                                    </div>
                                                                    </div>
                                                                    <div class="chat-bubble-body">
                                                                    <p><?php echo $comments; ?></p>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } endforeach; ?>
                                                    </div>
                                            </div> 
                                            <?php }
                                            
                                            if($show_form==1)
                                            {
                                            ?>

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>

                                            <div class="row"> 
                                                <div class="col-sm-6">
                                                        <label class="form-label">Comments*</label>
                                                        <textarea rows="5" class="form-control" placeholder="Here can be your comments" name="comments" id="comments"></textarea>
                                                </div> 

                                                <div class="col-sm-4">
                                                        <label class="form-label">Screenshot (If any)</label>
                                                            <div class="form-control-plaintext">
                                                                    <input type="file" class="form-control" name="screenshots" id="screenshots" accept="image/jpeg,image/png,application/gif"/>
                                                            </div>
                                                </div>
                                            </div>

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                        <div class="form-group has-feedback">
                                                        <input type="submit" name="step1" id="step1" class="btn btn-success submit" value="Post Comment">
                                                        </div>
                                                </div>
                                            </div>
                                            <?php } else {
                                                echo '<br/><div class="alert alert-danger">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                                     <strong>You don\'t have privillege to post comment.</strong> 
                                            </div>';
                                            }
                                            ?>
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
                screenshots: { required:false,extension: "png|jpeg|jpg|gif",filesize: 1048576 },	 
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
                "url" : base_url+'remarks/reply_form_action',	
                data:data,	
                processData: false,
                contentType: false,
                dataType:"json",
                    success:function(data){                        
                      window.location.href=window.location;
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

  