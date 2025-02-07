<?php 

$this->load->view('layouts/preload');

$this->load->view('layouts/user_header');

$validate='';
$user_id = $this->session->userdata('user_id');
$session_department_id=$this->session->userdata('department_id');

$zone_name='';
$job_status_validation='';
$final_submit=0;
$form1_button_name='Save';
$app_status='a';

$select_zone_id=(isset($records['zone_id'])) ? $records['zone_id'] : '';        
if(isset($zones) && $zones->num_rows()>0)
{
    $zones=$zones->result_array();

    foreach($zones as $list){

            if($select_zone_id==$list['id'])
            $zone_name = $list['name'];
    }
}

$record_id = (isset($records['id'])) ? $records['id'] : '';


function get_authorities($authority_id,$allusers)
{
  $acceptance_issuing_name='';

  foreach($allusers as $fet)
  {
    $role=$fet['user_role'];
    
    $id=$fet['id'];
    
    $first_name=$fet['first_name'];     

    if($authority_id==$id)
      { $acceptance_issuing_name=$first_name; break; }

  }
  return $acceptance_issuing_name;
}
$show_button='show';
$department_id=(isset($records['department_id'])) ? $records['department_id'] : $department['id'];
$job_approval_status=unserialize(JOBAPPROVALS);
$approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';

$acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';
$acceptance_performing_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';



if(!!$acceptance_performing_id)
$records['acceptance_performing_name'] = get_authorities($acceptance_performing_id,$allusers);
 

$status = (isset($records['status'])) ? $records['status'] : '';
$final_status_date=(isset($records['final_status_date'])) ? $records['final_status_date'] : '';
$cancellation_issuing_id = (isset($records['cancellation_issuing_id'])) ? $records['cancellation_issuing_id'] : '';
$cancellation_performing_id = (isset($records['cancellation_performing_id'])) ? $records['cancellation_performing_id'] : '';


$isolated_user_ids = (isset($records['isolated_user_ids'])) ? json_decode($records['isolated_user_ids'],true) : array();
$isolated_name_approval_datetimes = (isset($records['isolated_name_approval_datetime'])) ? json_decode($records['isolated_name_approval_datetime'],true) : array();
$closure_isolator_ids = (isset($records['closure_isolator_ids'])) ? json_decode($records['closure_isolator_ids'],true) : array();
$isolated_name_closure_datetimes = (isset($records['isolated_name_closure_datetime'])) ? json_decode($records['isolated_name_closure_datetime'],true) : array();

$jobs_closer_performing_ids=(isset($records['jobs_closer_performing_ids'])) ? json_decode($records['jobs_closer_performing_ids'],true) : array();
$jobs_closer_performing_approval_datetimes = (isset($records['jobs_closer_performing_approval_datetime'])) ? json_decode($records['jobs_closer_performing_approval_datetime'],true) : array();

$jobs_performing_ids=(isset($records['jobs_performing_ids'])) ? json_decode($records['jobs_performing_ids'],true) : array();
$jobs_performing_approval_datetimes=(isset($records['jobs_performing_approval_datetime'])) ? json_decode($records['jobs_performing_approval_datetime'],true) : array();
$acceptance_issuing_date = (isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : '';

$acceptance_loto_issuing_id = (isset($job_isolations['acceptance_loto_issuing_id'])) ? $job_isolations['acceptance_loto_issuing_id'] : '';
$closure_issuing_id = (isset($records['closure_issuing_id'])) ? $records['closure_issuing_id'] : '';

$zone_id= (isset($records['zone_id'])) ? $records['zone_id'] : '';
$permit_no= (isset($records['permit_no'])) ? $records['permit_no'] : '';
$disable_acceptance_issuing_id='';
$disable_acceptance_issuing_id = ($record_id!='' && $zone_id!='' && $user_id!=$acceptance_performing_id) ? 'disabled' : ($acceptance_issuing_date!='' ? 'disabled' : '');

$remove_disable='';

//Waiting for IA Acceptance
if(in_array($approval_status,array(WAITING_IA_ACCPETANCE,IA_CANCELLED))) 
{
    if($user_id!=$acceptance_issuing_id && $user_id!=$acceptance_performing_id)
    $show_button='hide';
    else if($user_id==$acceptance_issuing_id)
    {
      $records['acceptance_issuing_date']=date('Y-m-d H:i');
      $show_button='show';
      $form1_button_name='Approve';
    }
}


//After IA Approved
if(in_array($approval_status,array(WAITING_AVI_PA_APPROVALS)))     // && $final_status_date!=''
{
    $i=1; $j=$k=0;

    $show_button='hide';
   
    $i=0;
    foreach($jobs_performing_ids as $key => $jobs_performing_id){

      foreach($jobs_performing_id as $job_id => $performing_id):

        $jobs_performing_approval_datetime=(isset($jobs_performing_approval_datetimes[$key][$job_id])) ? $jobs_performing_approval_datetimes[$key][$job_id] : '';

        //Disable the checkbox
        //if($jobs_performing_approval_datetime!=''){
          $remove_disable.='$(".jobs_loto_ids'.$key.'").attr("disabled",true);';
       // }
      
        if($user_id==$performing_id && $jobs_performing_approval_datetime==''){
          $k=1;
        }

        if(in_array($user_id,array($acceptance_issuing_id)) && $jobs_performing_approval_datetime==''){
            $remove_disable.='$(".jobs_performing_ids'.$key.$job_id.'").removeAttr("disabled");';
        }

      endforeach;

    }
     
    //Allow to edit PA & IA
    if(in_array($user_id,array($acceptance_issuing_id))){
      $show_button='show';
    }

    if($k>0){
      $iso_clearance='1';
      $show_button='show';
      $form1_button_name='Approve';
      $app_status=WAITING_AVI_PA_APPROVALS;
    }
    
}

$iso_clearance=0;

//After IA/Job owners  Approved but Loto is enabled
if(in_array($approval_status,array(WAITING_ISOLATORS_COMPLETION,WORK_IN_PROGRESS))) 
{
    $i=0; $e=1;

    $show_button='hide';

    foreach($isolated_user_ids as $key => $label):

      if($label!='')
      {
         $dates_checked = isset($isolated_name_approval_datetimes[$e]) && $isolated_name_approval_datetimes[$e]!='' ? $isolated_name_approval_datetimes[$e] : '';

          if($user_id==$label && $dates_checked=='')
          {
            $isolated_name_approval_datetimes[$e] = date('d-m-Y H:i');
            $validate.=",'isolated_user_ids[".$e."]':{required:true}";
            $i++;
          }
      } 
      $e++;
    endforeach;

    if($i>0){
      #$job_isolations['isolated_name_approval_datetime']=json_encode($isolated_name_approval_datetimes);
      $iso_clearance='1';
      $show_button='show';
      $form1_button_name='Approve Isolations';
    }

    if($user_id==$acceptance_issuing_id){
      $show_button='show';
      $form1_button_name='Save';
    }

}




//After PA Approved 
if(in_array($approval_status,array(AWAITING_FINAL_SUBMIT)))     // && $final_status_date!=''
{
    //if($user_id!=$acceptance_performing_id)
    $show_button='hide';

    //Before Final Submit by PA
    if(in_array($approval_status,array(AWAITING_FINAL_SUBMIT)) && $status==STATUS_PENDING && $user_id==$acceptance_performing_id)
    { $form1_button_name='Final Submit'; $show_button='show';  $iso_clearance='1'; }
}

$closure=0;
//After Final Submit
if(in_array($approval_status,array(WORK_IN_PROGRESS,WAITING_CLOSURE_IA_COMPLETION))  && $final_status_date!='')     // && $final_status_date!=''
{
  $form1_button_name='Save'; 
  $show_button='hide';  

  if($acceptance_performing_id==$user_id) {
       $closure=1; $show_button='show';  }
  else if($closure_issuing_id==$user_id && $approval_status==WAITING_CLOSURE_IA_COMPLETION) {
      $closure=2; $show_button='show'; $records['closure_issuing_date']=date('Y-m-d H:i'); $form1_button_name='Approve';  }
}




//Isolator Close
if(in_array($approval_status,array(WAITING_CLOSURE_ISOLATORS_COMPLETION))) 
{
    $i=0; $r=1; $j=0;

    $show_button='hide';

    #echo '<pre>'; print_r($isolated_name_closure_datetimes);

    foreach($closure_isolator_ids as $key => $label):

      if($label!='')
      {
         $dates_checked = isset($isolated_name_closure_datetimes[$key]) && $isolated_name_closure_datetimes[$key]!='' ? $isolated_name_closure_datetimes[$key] : '';

         if($dates_checked=='' && $closure_issuing_id==$user_id){
              $show_button='show';
              $remove_disable.='$(".closure_isolator_ids'.$key.'").removeAttr("disabled");';
         }

         foreach($jobs_closer_performing_ids[$key] as $job_id => $performing_id):

          $jobs_closer_performing_approval_datetime=(isset($jobs_closer_performing_approval_datetimes[$key][$job_id])) ? $jobs_closer_performing_approval_datetimes[$key][$job_id] : '';

         # echo 'AA '.$jobs_closer_performing_approval_datetime.' = '.$key.' = '.$job_id.' = '.$performing_id;

          if($jobs_closer_performing_approval_datetime==''  && $closure_issuing_id==$user_id){
              $show_button='show';
             // jobs_closer_performing_ids[1238][7183]
              $remove_disable.='$(".jobs_closer_performing_ids'.$key.$job_id.'").removeAttr("disabled");';
          }


         endforeach;

        # echo 'AAAAAAAAA'.$user_id.' ='.$label.' = '.$dates_checked;

        if($user_id==$label && $dates_checked=='')
        { 
          $i++;
        }
      } 
      $r++;
    endforeach;

    if($i>0){
      $iso_clearance='1';
      $show_button='show';
      $form1_button_name='Approve Isolations';
    }
}




//Job Owners Close
//After IA Approved
if(in_array($approval_status,array(WAITING_AVI_PA_CLOSING_APPROVALS)))     // && $final_status_date!=''
{
    $i=1; $j=$k=0;

    $show_button='hide';
   
    $i=0;
    foreach($jobs_closer_performing_ids as $key => $jobs_performing_id){

      foreach($jobs_performing_id as $job_id => $performing_id):

        $jobs_performing_approval_datetime=(isset($jobs_closer_performing_approval_datetimes[$key][$job_id])) ? $jobs_closer_performing_approval_datetimes[$key][$job_id] : '';
      
        if($user_id==$performing_id && $jobs_performing_approval_datetime==''){
          $k=1;
        }

      endforeach;

    }
     
    //Allow to edit PA & IA
    if(in_array($user_id,array($acceptance_issuing_id))){
      $show_button='show';
    }

    if($k>0){
      $iso_clearance='1';
      $show_button='show';
      $form1_button_name='Approve';
      $app_status=WAITING_AVI_PA_APPROVALS;
    }
    
}


//Waiting PA Closure
if(in_array($approval_status,array(WAITING_PA_CLOSURE))) 
{
  $show_button='hide';  

    if($user_id==$acceptance_performing_id)
    {
      $records['closure_performing_again_date']=date('Y-m-d H:i');
      $show_button='show';
      $form1_button_name='Close AVI';
    }
}

$disable_job_id = ($record_id!='' && $zone_id!='') ? 'disabled' : '';

//Self Cancel
if($approval_status==SELF_CANCEL || $status==STATUS_CLOSED)
$show_button='hide';

?>
<link href="<?php echo base_url(); ?>assets/latest/plugins/select2/css/select2.css" rel="stylesheet">
<script>var base_url='<?php echo base_url(); ?>'; </script>
<style>
label.error { display:none !important;}
textarea,input[type="text"],select option { text-transform: uppercase;font-size:12px; }
#job_form2 .form-check { margin-bottom:2px !important;}
</style>
<div class="page-wrapper">
    
<!-- Page body -->
<div class="page-body">
<div class="container-xl">
<div class="row row-cards">

<div class="col-lg-12">
  <div class="row row-cards">
    <div class="col-12">                
        <div class="card">
     
          <div class="card-body">
             

                <div class="tab-content">
                  <div class="tab-pane tab1 active show" id="tabs-home-6 ">
                  <form id="job_form" name="job_form" enctype="multipart/form-data" > 
                      <input type="hidden" id="id" name="id" value="<?php echo $record_id; ?>" />
                      <input type="hidden" id="last_modified_id" name="last_modified_id" value="<?php echo (isset($records['last_modified_id'])) ? $records['last_modified_id'] : ''; ?>" />
                    <!-- Step A Start -->
                      <?php $this->load->view('avis/print_options',array('record_id'=>$record_id)); ?>
                      
                        <div class="row row-cards">
                              <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                  <label class="form-label">Select Zone to work on</label>
                                  <input type="hidden" name="zone_id" id="zone_id"  class="select2dropdown form-control" value="<?php echo $select_zone_id; ?>"  data-type="zones" data-account-text="<?php echo $zone_name; ?>" data-account-number="<?php echo $select_zone_id; ?>" data-width="300px" data-change="yes" <?php echo $disable_job_id; ?>/> 
                                </div>
                              </div>                                                     
                              <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                      <label class="form-label">Initiator Name</label>
                                      <div class="form-control-plaintext"><?php echo strtoupper((isset($records['acceptance_performing_name']) && $records['acceptance_performing_name']!='') ? $records['acceptance_performing_name'] :  $this->session->userdata('first_name')); ?></div>
                                      <input type="hidden" class="form-control" placeholder="" value="<?php echo (isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] :  $this->session->userdata('user_id'); ?>"  disabled name="acceptance_performing_id" id="acceptance_performing_id"/>
                                      <?php
                                      $acceptance_performance_id = (isset($records['acceptance_performance_id'])) ? $records['acceptance_performance_id'] : '';
                                      ?>
                                    </div>
                              </div>
                              <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                      <label class="form-label">Signature Date & Time</label>
                                      <div class="form-control-plaintext"><?php echo (isset($records['acceptance_performing_date'])) ? strtoupper($records["acceptance_performing_date"]) :  date('d-m-Y H:i');?>HRS</div>
                                      <input type="hidden" class="form-control" placeholder="" value="<?php echo (isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] :  $this->session->userdata('user_id'); ?>"  disabled name="acceptance_performing_id" id="acceptance_performing_id"/>
                                      <?php
                                      $acceptance_performance_id = (isset($records['acceptance_performance_id'])) ? $records['acceptance_performance_id'] : '';
                                      ?>
                                    </div>
                              </div>
                        </div>
                        
                        

                        <div class="row row-cards ">
                              <div class="col-md-4">
                                <div class="mb-3 mb-0">
                                  <label class="form-label">Issuer</label>
                                  <div class="form-control-plaintext">Authorized isolator, temporarily energize the above equipment.</div>
                                </div>
                                
                              </div>
                              <?php
                               $acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';

                               $acceptance_issuing_name='';
     
                               if(!!$acceptance_issuing_id)
                               $acceptance_issuing_name = get_authorities($acceptance_issuing_id,$allusers);
                              ?>
                              <div class="col-md-4">
                                <div class="mb-3 mb-0">
                                  <label class="form-label">Name of the Issuer</label>
                                  <div class="form-control-plaintext">
                                  <input type="hidden" name="acceptance_issuing_id" id="acceptance_issuing_id"  class="select2dropdown form-control" value="<?php echo $acceptance_issuing_id; ?>"  data-type="issuing_id" data-account-text="<?php echo $acceptance_issuing_name; ?>" data-account-number="<?php echo $acceptance_loto_issuing_id; ?>" data-width="300px" data-filter-value="<?php echo (isset($records['department_id'])) ? $records['department_id'] : $department['id']; ?>" data-skip-users="<?php echo $record_id=='' ? $user_id : $acceptance_performing_id; ?>" data-change="no" <?php echo $disable_acceptance_issuing_id; ?>/>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-4">
                               <div class="mb-3 mb-0">
                                  <label class="form-label">Signature Date & Time</label>
                                  <div class="form-control-plaintext"><input value="<?php echo (isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : ''; ?>" type="text" id="acceptance_issuing_date"  name="acceptance_issuing_date" class="form-control" readonly="readonly" /></div>
                                </div>
                              </div>
                        </div>


                              
                 
                   <div class="row g-5 loto_sections"  >
                            <div class="col-xl-12">
                                  <div class="table-responsive">
                                          <table class="table mb-0" border="1" id="isolation_table">
                                          </table>
                                  </div>
                           </div>
                   </div>


                  <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>

                  <?php
                   if($final_status_date!='')
                   {
                  ?>  

                  <div class="row g-5"><div class="col-xl-12"><label class="form-label text-red">Closure of AVI</label></div></div>
                  <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>

                          <div class="row row-cards ">
                              <div class="col-md-4">
                                <div class="mb-3 mb-0">
                                  <label class="form-label ">Permit Raiser</label>
                                  <div class="form-control-plaintext">Please isolate the equipment as stated clause-A</div>
                                </div> 
                              </div>
                              <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                      <label class="form-label ">Initiator Name</label>
                                      <div class="form-control-plaintext"><?php echo strtoupper((isset($records['acceptance_performing_name'])) ? $records['acceptance_performing_name'] :  ''); ?></div>
                                      <input type="hidden" class="form-control" placeholder="" value="<?php echo (isset($records['closure_performing_id']) && $records['closure_performing_id']>0) ? $records['closure_performing_id'] :  $this->session->userdata('user_id'); ?>"  disabled name="closure_performing_id" id="closure_performing_id"/> 
                                    </div>
                              </div>
                              <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                      <label class="form-label ">Signature Date & Time</label>
                                      <div class="form-control-plaintext"><?php echo (isset($records['closure_performing_date']) && $records['closure_performing_date']!='') ? strtoupper($records["closure_performing_date"]) :  date('d-m-Y H:i');?>HRS</div>
                                    </div>
                              </div>
                               
                          </div>

                        <div class="row row-cards closure_inputs">
                              <div class="col-md-4">
                                <div class="mb-3 mb-0">
                                  <label class="form-label ">Permit Issuer</label>
                                  <div class="form-control-plaintext">Please isolate the equipment as stated clause-A</div>
                                </div>
                                
                              </div>
                              <?php
                               $closure_issuing_id=(isset($records['closure_issuing_id']) && $records['closure_issuing_id']>0) ? $records['closure_issuing_id'] : '';

                               $closure_issuing_name='';
     
                               if(!!$closure_issuing_id)
                               $closure_issuing_name = get_authorities($closure_issuing_id,$allusers);
                              ?>
                              <div class="col-md-4">
                                <div class="mb-3 mb-0">
                                  <label class="form-label ">Name of the Issuer</label>
                                  <div class="form-control-plaintext">
                                  <input type="hidden" name="closure_issuing_id" id="closure_issuing_id"  class="select2dropdown form-control" value="<?php echo $closure_issuing_id; ?>"  data-type="issuing_id" data-account-text="<?php echo $closure_issuing_name; ?>" data-account-number="<?php echo $closure_issuing_id; ?>" data-width="300px" data-filter-value="<?php echo (isset($records['department_id'])) ? $records['department_id'] : $department['id']; ?>" data-skip-users="<?php echo $record_id=='' ? $user_id : $acceptance_performing_id; ?>" data-change="no" <?php echo $disable_acceptance_issuing_id; ?>/>
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-4">
                               <div class="mb-3 mb-0">
                                  <label class="form-label ">Signature Date & Time</label>
                                  <div class="form-control-plaintext"><input value="<?php echo (isset($records['closure_issuing_date'])) ? $records['closure_issuing_date'] : ''; ?>" type="text" id="closure_issuing_date"  name="closure_issuing_date" class="form-control" readonly="readonly" /></div>
                                </div>
                              </div>
                        </div>
                      
                       

                        <div class="row row-cards ">
                              <div class="col-md-4">
                                <div class="mb-3 mb-0">
                                  <label class="form-label text-black">Permit Raiser</label>
                                  <div class="form-control-plaintext">Please isolate the equipment as stated clause-A</div>
                                </div> 
                              </div>
                              <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                      <label class="form-label ">Initiator Name</label>
                                      <div class="form-control-plaintext"><?php echo strtoupper((isset($records['acceptance_performing_name'])) ? $records['acceptance_performing_name'] :  ''); ?></div>
                                      <input type="hidden" class="form-control" placeholder="" value="<?php echo (isset($records['closure_performing_again_id']) && $records['closure_performing_again_id']>0) ? $records['closure_performing_again_id'] :  $this->session->userdata('user_id'); ?>"  disabled name="closure_performing_again_id" id="closure_performing_again_id"/> 
                                    </div>
                              </div>
                              <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                      <label class="form-label ">Signature Date & Time</label>
                                      <div class="form-control-plaintext"><?php echo (isset($records['closure_performing_again_date']) && $records['closure_performing_again_date']!='') ? strtoupper($records["closure_performing_again_date"]).'HRS' :  '';?></div>
                                    </div>
                              </div>
                               
                          </div>
                  
                  <?php
                   }

                  
                  $job_status=array();
                          
                  // Waiting for IA Approval
                  if($user_id==$acceptance_performing_id && ($approval_status==WAITING_IA_ACCPETANCE || $approval_status==SELF_CANCEL || $approval_status==IA_CANCELLED)) 
                  {
                     
                      $job_status=array(SELF_CANCEL=>'Self Cancel',WAITING_IA_ACCPETANCE=>'Waiting IA Approval');

                      if($approval_status==IA_CANCELLED)
                       { 
                          $job_status[IA_CANCELLED]='IA Cancelled';
                          $job_status[WAITING_IA_ACCPETANCE]='Send IA Approval';
                       }

                      $job_status_validation=1;
                  }  // Waiting for IA Approval && IA Reviewing
                  else if($user_id==$acceptance_issuing_id && in_array($approval_status,array(WAITING_IA_ACCPETANCE,IA_CANCELLED,IA_APPROVED))) 
                   {
                       $job_status=array(IA_CANCELLED=>'Cancel PA Request',IA_APPROVED=>'Approve PA Request');
                       $job_status_validation=1;
                   } 
                  if($record_id!='' && count($job_status)>0)
                  {
                    ?>
                  <div class="row g-5">
                        <div class="col-md-6 col-xl-6">
                            <div class="mb-3">
                                <label class="form-label text-red">Permit Status</label>
                                <?php
                                  foreach($job_status as $key =>$label)
                                  {
                                    $chk = ($approval_status==$key) ? "checked" : '';
                                ?>
                                    <label class="form-check form-check-inline" >
                                          <input class="form-check-input job_status" type="radio" 
                                          value="<?php echo $key; ?>" name="approval_status" <?php echo $chk; ?>><?php echo $label; ?>
                                    </label>
                                    <?php
                                  }
                                  ?>
                                    <div class="mb-3 self_cancel">
                                      <label class="form-label">Notes (If any)</label>
                                      <textarea rows="3" class="form-control" placeholder="Here can be your notes"
                                      name="notes" id="notes"><?php #echo (isset($records['self_cancellation_description'])) ? $records['self_cancellation_description'] :  ''; ?></textarea>
                                    </div>    
                              </div>                             
                        </div>
                        <div class="col-md-6 col-xl-6"  >
                            <div class="mb-3">
                            <table class="table mb-0" border="1">
                            <tbody>
                                    <tr>
                                          <th>Status</th>
                                          <th>Notes</th>
                                          <th>Posted by</th>
                                          <th>Date</th>
                                    </tr>                                                  
                                    <?php
                                      if(count($notes)>0)
                                      {
                                            foreach($notes as $key => $value):
                                              echo '<tr>';
                                              
                                              echo '<td>'.$job_approval_status[$value['approval_status']].'</td>';
                                              echo '<td>'.$value['notes'].'</td>';
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
                  </div>   
                  <?php
                  }
                  if($show_button=='show')
                  {
                  ?>

                  <div class="row g-5">
                      <div class="col-xl-12" style="text-align:right;">
                           <button class="btn btn-success form_submit" type="submit" name="step1" id="step1" data-next-step="2" data-current-step="1"><?php echo $form1_button_name; ?></button>
                      </div>
                  </div>
                  <?php } ?>
                  <!-- Step A Ends -->
                   </form>
              </div>   
                    </div>
              </div>
            </div>
            </div>                
          </div>
        </div>
    </div>
  </div>
</div>        
</div>

</div>
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="<?php echo base_url(); ?>assets/latest/js/tabler.min.js?1692870487" defer></script>
<script src="<?php echo base_url(); ?>assets/latest/js/demo.min.js?1692870487" defer></script>
<script src="<?php echo base_url();?>assets/latest/js/jquery-3.7.1.js"></script>
<script src="<?php echo base_url(); ?>assets/latest/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/latest/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/latest/js/permits.js"></script>
<?php $flag='true';  $redirect=base_url().$param_url;  ?>
<script>
  $(document).ready(function() {
   
    <?php
    if($show_button=='hide' || in_array($approval_status,array(SELF_CANCEL,AWAITING_FINAL_SUBMIT,WAITING_ISOLATORS_COMPLETION,$app_status)) || $final_status_date!='')
    {
      ?>
        $('input,textarea,select').attr('disabled',true);
    <?php
    }
    if($iso_clearance==1) { 
    ?>
      $('.form_submit').removeAttr('disabled');
    <?php
      }
    if($closure==1) { 
    ?>
        $('.closure_inputs :input').removeAttr('disabled');
        $('.closure_isolator_ids').removeAttr('disabled');
    <?php
    } else if($closure==2) { 
      ?>
        $('.closure_isolator_ids').removeAttr('disabled');
      <?php
      }
    ?>
   

  $('.job_status').change(function(){

      var val = $(this).val();

      if(val=='<?php echo SELF_CANCEL; ?>')
      {
          var x = confirm('Are you sure to self cancel your permit?');

          if(x==true)
            $('.self_cancel').show();
          else
          {
            $('.self_cancel').hide();

            $(this).prop('checked',false);
          }  
          return false;

      }

      if(val=='5' || val=='7') {
          $('.completion').show();
      } else
          $('.completion').hide();


  });
 var formaction=1;
  $('.form_submit').click(function()
  {    
    $('input, select, textarea').each(function() {
        $(this).removeClass('error');
    });

    $('#job_form').removeData('validator'); 

    $("#job_form").validate({ 
          ignore: '.ignore',
          focusInvalid: true, 
          onfocusout: false,
          errorClass: 'error is-invalid',
          validClass: 'is-valid',
          debug:true,
          rules: {        
            zone_id : {required:<?php echo $flag; ?>},
            acceptance_issuing_id : {required:<?php echo $flag; ?>},
            "jobs_loto_ids[1]": {required:function(element) {
                                          if($('.jobs_loto_ids:checked').length==0) 
                                          return true; 
                                          else return false;
                                          }}
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
          submitHandler:function()
          {

            console.log('1st this formact ',formaction)
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
                  data.append(this.name,$(this).val());
                }
                
            });   

            if($('.job_status').length > 0)
            {
              data.append('approval_status',$('.job_status:checked').val());
            }

            var pre_arr=new Array('jobs_loto_ids','closed_lotos');

            for (i = 0; i < pre_arr.length; i++) 
            {
                  var field_name=pre_arr[i];
                  
                  var alpha_vals='';

                  $("."+field_name+":checked").each(function ()
                  {
                    data.append(this.name,$(this).val());
                  });
            }

            // data.append('jobs_loto_id',jobs_loto_id);
             // data.append('submit_type',submit_type);
      
              $("#job_form button").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled',true);   
              
              if($('input[name=status]').length>0)
              data.append('status',$('input[name=status]:checked').val());

              if(formaction==1)
              {
                  formaction=2;
                  $.ajax({
                    url: base_url+'avis/form_action',
                    type: 'POST',
                    "beforeSend": function(){ },
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function(data, textStatus, jqXHR)
                    {   
                        if(data.status==false)
                        {
                          window.location.href=base_url+'avis/form/id/'+$('#id').val();
                        }
                        else
                        {
                      
                            if(data.print_out!='')
                            {
                              $('.print_out:first').trigger('click');
                              
                                setTimeout(function () { 
                                    window.location.href='<?php echo $redirect;?>';
                                  }, 10 * 1000);
                              
                            }
                            else                    
                            {
                              console.log('Here');
                              window.location.href='<?php echo $redirect;?>';
                            }   
                        }              
                    },
                    error: function(data, textStatus,errorThrown)
                    {
                        console.log('Error ',data.failure)
                        $('#error').show();
                        
                        $('#error_msg').html(data.failure);
                    }
                  });     
              }
          }  
        
      
    });


    if($('.loto_sections').is(':visible')==true)
    {
        console.log('Inside')
        
        $(".jobs_loto_ids:checked").each(function ()
        {
            var field_name='.isolated_user_ids'+$(this).attr('data-id');

            console.log('Field Name ',field_name)

            if($(this).val()>0){
              console.log('Validation Set')
              $('.isolated_user_ids'+$(this).attr('data-id')).rules("add", "required");

              if($('.closure_inputs').is(':visible')==true)
                $('.closure_isolator_ids'+$(this).attr('data-id')).rules("add", "required");

            }
        });
    }

    if($('.closure_inputs').is(':visible')==true)
    {
          console.log('erererer')
          $("input[name*='closure_issuing_id']").rules("add", "required");   
    }

    if($('.job_status').length > 0)
    {
      $("input[name*='approval_status']").rules("add", "required");   
    }
});


$.validator.setDefaults({ 
ignore: [],
});



$.validator.addMethod('minStrict', function (value, el, param) {
  return value > param;
}); 

$('body').on('click','.print_out',function() {
    
    var print_id=$(this).attr('data-id');

    var url = $(this).attr('data-url');
    
    var data = new FormData();			
    
    data.append('id',print_id);		
    
      $.ajax({    
        "type" : "POST",
        "url" : base_url+url,	
        data:data,	
        type: 'POST',
        processData: false,
        contentType: false,
        dataType:"json",
        success:function(data, textStatus, jqXHR){
          
          //alert('Status '+textStatus);alert(data); return false;return false;
              var newWin = window.open(data.file_path, '', 'left=0,top=0,width=900,height=600,toolbar=0,scrollbars=0,status=0');
              //newWin.document.write(data);
              newWin.document.close();
              newWin.focus();
              //newWin.print();
              newWin.onload = function() {    };
              //newWin.close();
              newWin.print();
              //return false; 
        },
        error: function(jqXHR, textStatus, errorThrown){
          //if fails     
          
          alert('ERror');
        }
      });		
    
  
});

 
      
});


$(window).on('load', function() {
  $(".jobs_loto_ids:checked").each(function ()
  {
      $(this).trigger('change');
  });

  if($('.form_submit').is(':visible')==false)
    $('input,textarea,select').attr('disabled',true);

    <?php echo $remove_disable; ?>
  
});
</script>
<?php $this->load->view('layouts/latest_footer'); ?>
</body>
</html>

