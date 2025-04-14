<?php 

    $this->load->view('layouts/preload');

    $this->load->view('layouts/user_header');
?>

<link href="<?php echo base_url(); ?>assets/latest/plugins/select2/css/select2.css" rel="stylesheet">
<style>
.error { color:red; font-weight:normal;}
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
                  Share to Others
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
                                <input type="hidden" name="id" id="id" value="<?php echo $records['id']; ?>" />
                                <input type="hidden" name="permit_no" id="permit_no" value="<?php echo $records['permit_no']; ?>" />
                                    <div class="panel panel-default">
                                                        
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="form-group has-feedback">
                                                         <label class="form-label">Permit No <?php #echo $show_button; ?></label>
                                                        <div class="form-control-plaintext" style="padding-top:1px;"><b><?php echo $records['permit_no']; ?></b></div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                        <label class="form-label">PDF for</label>
                                                         
                                                        <label class="form-check form-check-inline">
                                                            <input class="form-check-input pdf_for" type="radio" 
                                                            value="P" name="pdf_for" checked data-url="prints/printout">Work Permit
                                                        </label>
                                                        <?php
                                                        if($records['is_loto']==YES) { ?>
                                                        <label class="form-check form-check-inline electrical_shutdown">
                                                            <input class="form-check-input pdf_for" type="radio" 
                                                            value="S" name="pdf_for"  data-url="prints/electrical">Shutdown
                                                        </label>

                                                        <label class="form-check form-check-inline electrical_shutdown">
                                                            <input class="form-check-input pdf_for" type="radio" 
                                                            value="A" name="pdf_for"  data-url="prints/electrical">Both
                                                        </label>
                                                        <?php } ?>
                                                </div>

                                                <div class="col-sm-4">
                                                        <label class="form-label">PDF Type</label>
                                                         
                                                        <label class="form-check form-check-inline">
                                                            <input class="form-check-input pdf_type" type="radio" 
                                                            value="P" name="pdf_type" checked>Portrait
                                                        </label>

                                                        <label class="form-check form-check-inline">
                                                            <input class="form-check-input pdf_type" type="radio" 
                                                            value="L" name="pdf_type">Landscape
                                                        </label>
                                                </div>

                                            </div><!--/row-->

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>

                                            <div class="row">
                                                
                                                <div class="col-sm-6">
                                                    <div class="form-group has-feedback">
                                                        <label for="form-label"><b>Recipients*</b></label>
                                                        
                                                        <select class="form-control select2"  name="user_ids" id="user_ids" multiple>
                                                            <?php   
                                                            foreach($allusers as $list){
                                                            ?>
                                                            <option value="<?php echo $list['id'];?>"><?php echo $list['first_name'].' - '.$list['employee_id'];?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group has-feedback">
                                                        <label for="form-label"><b>Mail Subject*</b></label>                                                        
                                                        <input type="text" class="form-control" placeholder="" name="mail_subject" id="mail_subject" value="<?php echo 'Permit '.$records['permit_no'].' Info'; ?>">
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>

                                            <div class="row">
                                                
                                                <div class="col-sm-6">
                                                    <div class="form-group has-feedback">
                                                        <label for="form-label"><b>Mail Content*</b></label>                                                        
                                                        <textarea rows="7" class="form-control" placeholder="Here can be your description"  name="mail_desc" id="mail_desc">Hi Guys, Please find material as a PDF for the <?php echo $records['permit_no']; ?></textarea>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row"><div class="col-sm-12" id="pdf_response">&nbsp;</div></div>
                                            
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                        <div class="form-group has-feedback">
                                                        <input type="submit" name="step1" id="step1" class="btn btn-success submit" value="Send Mail">
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

           
          </div>
        </div>
      </div> 
<script src="<?php echo base_url(); ?>assets/latest/js/tabler.min.js?1692870487" defer></script>
<script src="<?php echo base_url(); ?>assets/latest/js/demo.min.js?1692870487" defer></script>
<script src="<?php echo base_url();?>assets/latest/js/jquery-3.7.1.js"></script>
<script src="<?php echo base_url(); ?>assets/latest/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/latest/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/latest/js/permits.js"></script>
<script type="text/javascript">

$(document).ready(function() {


    $("#job_form").validate({ 
			rules: {
                mail_desc:{
                    required:true
                },
                mail_subject:{
                    required:true
                },
                user_ids:{
                    required:false
                }
            },
		errorPlacement: function(error,element){
            error.appendTo(element.parent().parent());                        
        },
        submitHandler:function(){

            $(".submit").val("Processing...").attr('disabled',true);   
                
            var print_id=$('#id').val();

            var pdf_type=$('.pdf_type:checked').val();

            var file_paths=[];

            var pdf_for = $('.pdf_for:checked').val();

            var url = $('.pdf_for:checked').attr('data-url');

            var pre_arr=new Array(url);

            if(pdf_for=='A'){
                pre_arr=new Array("prints/printout","prints/electrical");
            }

            for (i = 0; i < pre_arr.length; i++) 
            {
                    var data = new FormData();			

                    data.append('id',print_id);		

                    data.append('pdf_type',pdf_type);

                    url=pre_arr[i];

                    console.log('URL ',url);

                    $.ajax({    
                    'async': false,
                    "type" : "POST",
                    "url" : base_url+url,	
                    data:data,	
                    processData: false,
                    contentType: false,
                    dataType:"json",
                        success:function(data){
                            if(data?.status==1){
                                file_paths.push(data.file_path);
                            } else {
                                $('#pdf_response').html('<span style="color:red;">'+data?.msg+'</span>');
                                $(".submit").val("Send Mail").prop('disabled',false);   
                            }
                        
                        },
                        error: function(jqXHR, textStatus, errorThrown){
                        //if fails      
                        $('#pdf_response').html('Error in Print out '+jqXHR?.responseText+' = '+textStatus+'. Please contact system administrator');
                        $(".submit").val("Send Mail").prop('disabled',false);   
                        }
                    });	
            }
           

                var data = new FormData();          
                var $inputs = $('form#job_form :input[type=text],form#job_form :input[type=hidden],select,textarea');
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

                data.append('files',file_paths);

                $.ajax({    
                "type" : "POST",
                "url" : base_url+'jobs/share_form_action',	
                data:data,	
                processData: false,
                contentType: false,
                dataType:"json",
                    success:function(data){
                        
                        window.location.href=base_url+'jobs/form/id/'+$('#id').val();

                        $(".submit").val("Send Mail").prop('disabled',false);   
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                    //if fails      
                    $('#pdf_response').html('Error in Print out '+jqXHR?.responseText+' = '+textStatus+'. Please contact system administrator');
                    $(".submit").val("Send Mail").prop('disabled',false);   
                    }
                });	
           

        }
    });

});

</script>

</body>
</html>

  