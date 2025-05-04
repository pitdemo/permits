<?php 
$job_approval_status=unserialize(SCAFFOLDINGS_APPROVALS);

$validate=$show_button='';

$button_value='Create';

$this->load->view('layouts/preload');

$this->load->view('layouts/user_header');

$id=(isset($records['id'])) ? $records['id'] : '';

$job_id=(isset($records['job_id'])) ? $records['job_id'] : '';

$scaffolding_id=(isset($records['scaffolding_id'])) ? $records['scaffolding_id'] : '';

$user_id=$this->session->userdata('user_id');

$disabled=$issuer_disabled=''; $permit_no='';

$issuer_name='';

$initiator_name=$this->session->userdata('first_name');

$issuer_name=(isset($records['issuer_name'])) ? $records['issuer_name'] : ''; 

$acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : ''; 

$acceptance_performance_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : $user_id; 

$approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : WAITING_CUSTODIAN_ACCPETANCE;

if($id!='')
{
    $permit_no=(isset($records['permit_no'])) ? $records['permit_no'] : '';

    $disabled=$issuer_disabled='disabled';

    $initiator_name=(isset($records['first_name'])) ? $records['first_name'] : '';

    if(in_array($user_id,array($acceptance_performance_id)) && in_array($approval_status,array(WAITING_CUSTODIAN_ACCPETANCE,PERMIT_REOPENED))){
        $issuer_disabled=''; $button_value='Update Info';
    } else if(in_array($user_id,array($acceptance_issuing_id)) && $approval_status==WAITING_CUSTODIAN_ACCPETANCE){
        $records['acceptance_issuing_date']=date('d-m-Y h:i');
        $validate.=",'approval_status':{required:true}";
        $button_value='Approve';
    } else {
        $show_button='hide';
    }
}   

//Self Cancel
if($approval_status==SELF_CANCEL)
$show_button='hide';

$jobs_checklists_values=(isset($records['check_points'])) ? json_decode($records['check_points'],true) : array();

?>

<link href="<?php echo base_url(); ?>assets/latest/plugins/select2/css/select2.css" rel="stylesheet">

<style>
label.error { display:none !important;}
.error { color:red; font-weight:normal;}
textarea,input[type="text"] { text-transform: uppercase; }
.kg_table {
    border:1 px solid !important;
    border-collapse: collapse !important;
}
.form-check-label { color:black !important;}
.form-check-input { border-color:black;}
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
                  Scaffoldings
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
                            <input type="hidden" id="permit_no" name="permit_no" value="<?php echo $id; ?>" />
                            <input type="hidden" id="scaffolding_id" name="scaffolding_id" value="<?php echo $scaffolding_id; ?>" />
                            <input type="hidden" id="acceptance_performing_id" name="acceptance_performing_id" value="<?php echo $acceptance_performance_id; ?>" />

                      <?php
                      $this->load->view($this->data['controller'].'/print_options',array('record_id'=>$id)); 
                      ?>
                           
                                    <div class="panel panel-default">
                                        <div class="panel-body">

                                        <div class="row"><div class="col-sm-12" id="pdf_response">&nbsp;</div></div>

                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="form-group has-feedback">
                                                            <label class="form-label">Select Permit No*</label>
                                                            <input type="hidden" name="job_id" id="job_id"  class="select2dropdown form-control" value="<?php echo $job_id; ?>"  data-type="permits" data-account-text="<?php echo $permit_no; ?>" data-account-number="<?php echo $job_id; ?>" data-width="300px" <?php echo $disabled; ?> data-title="job_title"/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                        <label class="form-label">Location</label>
                                                        <div class="form-control-plaintext">
                                                        <span id="job_title" style="text-transform:uppercase;"><?php echo (isset($records['location'])) ? $records['location'] : ''; ?></span></div>
                                                </div>

                                                <div class="col-sm-3">
                                                        <label class="form-label">Purpose Of*</label>
                                                        <div class="form-control-plaintext">
                                                        <input type="text" class="form-control" name="purpose_of" id="purpose_of"  value="<?php echo (isset($records['purpose_of'])) ? $records['purpose_of'] : ''; ?>"></div>
                                                </div>

                                                <div class="col-sm-2">
                                                        <label class="form-label">Meter*</label>
                                                        <div class="form-control-plaintext">
                                                        <input type="text" class="form-control num_inputs" name="meter" id="meter"  value="<?php echo (isset($records['meter'])) ? $records['meter'] : ''; ?>"></div>
                                                </div>
                                              

                                            </div>

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>

                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <?php

                                                    $load_duties=(isset($records['load_duty'])) && $records['load_duty']!=''  ? json_decode($records['load_duty'],true) : array();

                                                    $titles=array(1=>'Maximum  Safe load in Kg',2=>'Maximum bay length / width in Meter');

                                                    $title_values=array(1=>array(75,150,225,300,450,600),2=>array(2.7,2.2,1.8,1.4,1.0,0.8));

                                                    ?>

                                                <table border="1" class="table" id="table" style="border-collapse: collapse;">
                                                    <thead>
                                                        <tr>       
                                                        <th style="text-align:center;">Load Duty</th>
                                                        <th colspan="2" style="text-align:center;">Light</th>                                      
                                                        <th colspan="2" style="text-align:center;">Medium</th>
                                                        <th colspan="2" style="text-align:center;">Heavy/Special</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        foreach($titles as $t_key => $title):

                                                            $values=$title_values[$t_key];

                                                            $validate.=",'load_duty[".$t_key."]':{required:true}";
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $title; ?></td>
                                                            <?php
                                                            foreach($values as $v_key => $value):

                                                                $val=(isset($load_duties[$t_key])) ? $load_duties[$t_key] : '';

                                                                $sel=($val==$v_key && $val!='') ? 'checked' : '';
                                                            ?>
                                                            <td>
                                                                <label class="form-check form-check-inline">
                                                                        <input type="radio" name="load_duty[<?php echo $t_key; ?>]" value="<?php echo $v_key; ?>" class="form-check-input load_duty" <?php echo $sel; ?>><span class="form-check-label"><?php echo $value; ?></span>
                                                                </label>
                                                            </td>
                                                            <?php
                                                            endforeach;
                                                            ?>
                                                        </tr>
                                                        <?php
                                                        endforeach;
                                                        ?>
                                                    </tbody>
                                                
                                                    </table>     
                                                        
                                                </div>
                                            </div>

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group has-feedback">
                                                            <label class="form-label">Initiator Name</label>
                                                            <div class="form-control-plaintext"><?php echo strtoupper((isset($records['acceptance_performing_name'])) ? $records['acceptance_performing_name'] :  $this->session->userdata('first_name')); ?></div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                        
                                                <label class="form-label">Name of the Responsible Person*</label>

                                                <input type="hidden" name="acceptance_issuing_id" id="acceptance_issuing_id"  class="select2dropdown form-control" value="<?php echo $acceptance_issuing_id; ?>"  data-type="civil" data-account-text="<?php echo $issuer_name; ?>" data-account-number="<?php echo $acceptance_issuing_id; ?>" data-width="300px" <?php echo $issuer_disabled; ?>/>

                                                </div>
                                            </div>

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group has-feedback">
                                                            <label class="form-label">Signature Date & Time</label>
                                                            <div class="form-control-plaintext"><?php echo (isset($records['acceptance_performing_date'])) ? strtoupper($records["acceptance_performing_date"]) :  date('d-m-Y H:i');?>HRS</div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label class="form-label">Signature Date & Time</label>
                                                    <input value="<?php echo (isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : ''; ?>" type="text" id="acceptance_issuing_date"  name="acceptance_issuing_date" class="form-control" readonly="readonly" />
                                                </div>
                                            </div>

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>

                                            <div class="col-xl-12" id="checklists_table" style="display:<?php echo count($jobs_checklists_values)>0 ? 'block' : 'none'; ?>" >
                                                <div class="row">
                                                    <div class="col-md-6 col-xl-6"><div class="mb-3">
                                                        <table border="1" class="table mb-0">
                                                            <tbody>
                                                            <tr>
                                                                <th width="0.1%">Yes</th>
                                                                <th width="0.1%">No</th>
                                                                <th width="0.1%">N/A</th>
                                                                <th width="7%">Check Points</th>
                                                            </tr>
                                                            <?php
                                                            
                                                            foreach($checklists as $checklists):

                                                                $key=$checklists['id'];
                                                                $label=$checklists['name'];
                    
                                                                $data = (isset($jobs_checklists_values[$key])) ? $jobs_checklists_values[$key] : '';
                    
                                                                $y_checked = $data=='y' ? "checked='checked'" : '';
                                                                $n_checked = $data=='n' ? "checked='checked'" : '';
                                                                $na_checked = $data=='na' ? "checked='checked'" : '';

                                                                if($data=='')
                                                                $validate.=",'check_points[".$key."]':{required:function(element) {
                                                                    if($('input[name=\"approval_status\"]:checked').val()==".IA_APPROVED.") 
                                                                    return true; 
                                                                    else return false;
                                                                    }}";
            

                                                                $response='<tr>
                                                                <td> 
                                                                <label class="form-check form-check-inline">
                                                                <input class="form-check-input check_points" type="radio" 
                                                                value="y" name="check_points['.$key.']" '.$y_checked.' >
                                                                </label>
                                                                </td><td>
                                                                <label class="form-check form-check-inline">
                                                                <input class="form-check-input check_points" type="radio" 
                                                                value="n" name="check_points['.$key.']" '.$n_checked.' >
                                                                </label>
                                                                </td><td>
                                                                <label class="form-check form-check-inline">
                                                                <input class="form-check-input check_points" type="radio" 
                                                                value="na" name="check_points['.$key.']" '.$na_checked.' >
                                                                </label>
                                                                </td>
                                                                <td> 
                                                                '.$label.'
                                                                </td>
                                                                </tr>';
                                                                echo $response;
                                                            endforeach;
                                                            ?>
                                                        </tbody>
                                                        </table>
                                                    </div></div>

                                                    <div class="col-md-6 col-xl-4"><div class="mb-3">
                                                        <label class="form-label">Remarks (If any)</label>
                                                        <textarea rows="10" class="form-control" placeholder="Here can be your descriptions" name="check_points_notes" id="check_points_notes"><?php #echo (isset($records['check_points_notes'])) ? $records['check_points_notes'] : ''; ?></textarea>
                                                    </div></div>
                                                </div>
                                            </div>


                                            <?php
                                            $job_status=array();
                                            // Waiting for IA Approval
                                            if($user_id==$acceptance_performance_id && in_array($approval_status,array(SELF_CANCEL,WAITING_CUSTODIAN_ACCPETANCE,PERMIT_REOPENED))) 
                                            {
                                                $job_status=array(SELF_CANCEL=>'Self Cancel',WAITING_CUSTODIAN_ACCPETANCE=>'Waiting Approval');

                                              

                                                $job_status_validation=1;
                                            }   
                                            else if($user_id==$acceptance_issuing_id && in_array($approval_status,array(WAITING_CUSTODIAN_ACCPETANCE,PERMIT_REOPENED))) 
                                            {
                                                $job_status=array(PERMIT_REOPENED=>'Need More Info',IA_APPROVED=>'Approve Initiator Request');
                                                $job_status_validation=1;
                                            }

                                            if($id!='' && count($job_status)>0)
                                            {
                                            ?>         
                                                    <div class="row">
                                                        <div class="col-md-4 col-xl-4">
                                                            <div class="mb-3">
                                                                <label class="form-label text-red">Permit Status</label>
                                                                <?php
                                                                    
                                                                    foreach($job_status as $key =>$label)
                                                                    {
                                                                    $chk = ($approval_status==$key) ? "checked" : '';
                                                                    $class='';
                                                                ?>
                                                                    <label class="form-check form-check-inline" >
                                                                            <input class="form-check-input job_status <?php echo $class; ?>" type="radio" 
                                                                            value="<?php echo $key; ?>" name="approval_status" <?php echo $chk; ?> ><?php echo $label; ?>
                                                                    </label>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>                             
                                                        </div>
                                                       
                                                    </div> 

                                                    
                                            <?php } ?>

                                            

                                            <div class="row"> 
                                                <div class="col-sm-4">
                                                        <label class="form-label">Notes*</label>
                                                        <textarea rows="5" class="form-control" placeholder="Here can be your descriptions" name="notes" id="notes"></textarea>
                                                </div> 
                                                <div class="col-md-6 col-xl-6"  >
                                                            <div class="mb-3">
                                                            <label class="form-label">Notes History</label>
                                                                    <table class="table mb-0" border="1">
                                                                    <tbody>
                                                                            <tr>
                                                                            <th>Status</th>
                                                                            <th>Notes</th>
                                                                            <th>Posted by</th>
                                                                            <th>Date</th>
                                                                            </tr>                                                  
                                                                            <?php
                                                                                if(isset($notes) && count($notes)>0)
                                                                                {
                                                                                    foreach($notes as $key => $value):
                                                                                        echo '<tr>';
                                                                                        
                                                                                        echo '<td>'.$job_approval_status[$value['approval_status']].'</td>';
                                                                                        echo '<td>'.strtoupper($value['notes']).'</td>';
                                                                                        echo '<td>'.$value['last_updated_by'].'</td>';
                                                                                        echo '<td>'.date('d-m-Y H:i:A',strtotime($value['created'])).'</td>';

                                                                                        echo '</tr>';
                                                                                    endforeach;
                                                                                } else
                                                                                echo '<tr><td colspan="4" align="center">No Remarks Found</td></tr>';
                                                                            ?>
                                                                    </tbody>
                                                                    </table>
                                                            </div>                             
                                                        </div>                                  
                                               
                                               
                                            </div><!--/row-->

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>
                                            <?php
                                            if($show_button!='hide') {
                                            ?>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                        <div class="form-group has-feedback">
                                                        <input type="submit" name="step1" id="step1" class="btn btn-success submit" value="<?php echo $button_value; ?>">
                                                        </div>
                                                </div>
                                            </div>
                                            <?php } ?>

                                            <div class="row"><div class="col-sm-12">&nbsp;</div></div>

                                            <!--/row-->
                                        </div>
                                                
                                        
                                    </div>
                            </form>
                        </div>
                </div>    

                <div class="row"><div class="col-sm-12">&nbsp;</div></div>  

                </div>
        </div>
      </div> 
<script src="<?php echo base_url(); ?>assets/latest/js/tabler.min.js?1692870487" defer></script>
<script src="<?php echo base_url(); ?>assets/latest/js/demo.min.js?1692870487" defer></script>
<script src="<?php echo base_url();?>assets/latest/js/jquery-3.7.1.js"></script>
<script src="<?php echo base_url(); ?>assets/latest/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/latest/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/latest/js/permits.js"></script>
<?php $redirect=base_url().$param_url.'/?mode='.$this->session->userdata('mode'); ?>
<script type="text/javascript">

$(document).ready(function() {

    <?php 
       if($show_button=='hide' || in_array($approval_status,array(SELF_CANCEL)))
       {
         ?>
           $('input,textarea,select').attr('disabled',true);
       <?php
       }
     ?>

$('body').on('click','.generate_pdf',function() {
    
    var print_id=$('#id').val();

    var url = $('.pdf_for:checked').attr('data-url');

    var pdf_type='p';
    
    var data = new FormData();			
    
    data.append('id',print_id);		

    data.append('pdf_type',pdf_type);

    $('#pdf_response').html("PDF generation process has been started. Please wait a min...");

      $.ajax({    
        "type" : "POST",
        "url" : base_url+'prints/scaffoldings',	
        data:data,	
        processData: false,
        contentType: false,
        dataType:"json",
        success:function(data){

              var target='target="_blank"';

              <?php
              if($this->show_filter_form!='') { ?> target=''; <?php } ?>

          
              if(data?.status==1){
                  $('#pdf_response').html('<span style="color:green;"><a href="'+data?.file_path+'" '+target+'>Click Here</a> to download the PDF<br /></span>');
              } else {
                  $('#pdf_response').html('<span style="color:red;">'+data?.msg+'</span>');
              }
         
        },
        error: function(jqXHR, textStatus, errorThrown){
          //if fails      
          alert('Error in Print out '+jqXHR?.responseText+' = '+textStatus+'. Please contact system administrator');
        }
      });	
});


    $('.job_status').click(function(){

        var val = $(this).val();

        if(val=='<?php echo SELF_CANCEL; ?>')
        {
            var x = confirm('Are you sure to self cancel your request?');

            if(x==true)
            $(this).prop('checked',false);
        
            return false;
        }

        if(val=='<?php echo IA_APPROVED; ?>')
        {
            $('#checklists_table').show();
        } else {
            $('#checklists_table').hide();
        }


    });


    $("#job_form").validate({ 
          ignore: '.ignore, .cr-slider',
          focusInvalid: true, 
          errorClass: 'error is-invalid',
          validClass: 'is-valid',
          debug:true,
			rules: {
                purpose_of:{
                    required:true
                },
                job_id:{
                    required:true
                },
                meter:{
                    required:true
                },
                acceptance_issuing_id:{
                    required:true
                },
                notes:{
                    required:true
                }
                <?php echo $validate; ?>
            },
           highlight: function( element, errorClass, validClass )
          {     
                //if(element.type=='text' || element.type=='textarea' || element.type=='hidden')
                // {
                  $(element).addClass(errorClass);
              //  }
          },  
          unhighlight: function (element, errorClass, validClass) 
          {
              //  if(element.type=='text' || element.type=='textarea' || element.type=='hidden')
              //  {
                  $(element).removeClass(errorClass).addClass(validClass);
              //   }
          },
          errorPlacement: function(error,element){
                  error.appendTo(element.parent().parent());                        
              },          
          invalidHandler: function(form, validator) {
            submitted = true;
              // console.log('Invalid Handler ',validator)
          },      
          submitHandler:function(){

                $(".submit").val("Processing...").attr('disabled',true);   

                var data = new FormData();          
                var $inputs = $('form#job_form :input[type=text],form#job_form :input[type=hidden],select,textarea');
                    $inputs.each(function() {
                    console.log('Input Name ',this.name+ ' '+$(this).val());
                    data.append(this.name,$(this).val());
                });   

                var pre_arr=new Array('load_duty','job_status','check_points');

                for (i = 0; i < pre_arr.length; i++) 
                {
                        var field_name=pre_arr[i];

                        $("."+field_name+":checked").each(function ()
                        {
                        data.append(this.name,$(this).val());
                        });
                }

               

                $.ajax({    
                "type" : "POST",
                "url" : base_url+'scaffoldings/form_action',	
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
});

</script>

</body>
</html>

  