<?php 

$this->load->view('layouts/preload');
$this->load->view('layouts/user_header');
$user_instructions=unserialize(USER_INSTRUCTIONS);
$validate=$validate_3_form='';
$user_id = $this->session->userdata('user_id');
$session_department_id=$this->session->userdata('department_id');
$plant_type=$this->session->userdata('plant_type');
#echo 'OKK'.$session_department_id; exit;
$session_is_isolator=$this->session->userdata('is_isolator');
$form1_button_name='Create';
$form2_button_name='Next';
$form1_button_name='Save All';
$zone_name='';
$job_status_validation='';
$final_submit=0;
$permit_status_enable=0;
$checkbox_clearance='';
$remove_clearance_inputs_disabled='';
$select_zone_id=(isset($records['zone_id'])) ? $records['zone_id'] : '';        
if($zones->num_rows()>0)
{
    $zones=$zones->result_array();

    foreach($zones as $list){

            if($select_zone_id==$list['id'])
            $zone_name = $list['name'];
    }
}

$contractor_name='';
$contractor_id=(isset($records['contractor_id'])) ? $records['contractor_id'] : '';    

foreach($contractors as $list){

       # echo '<br />AAA '.$contractor_id.' = '.$list['id'];

        if($contractor_id==$list['id'])
        { $contractor_name = $list['name']; break; }
}

$avi_message='';

$record_id = (isset($records['id'])) ? $records['id'] : '';

if($record_id>0)
$form1_button_name='Save';

//Checking Excavation is checked or not
$permit_types = (isset($records['permit_type_ids'])) ? json_decode($records["permit_type_ids"],true) : array();

$permit_type_ids = (isset($records['permit_type_ids'])) ? json_decode($records["permit_type_ids"],true) : array();

$clerance_department_disabled = (in_array(9,$permit_types)) ? '' : 'disabled'; 

function get_authorities($authority_id,$authorities)
{
  $acceptance_issuing_name='';

  foreach($authorities as $fet)
  {
    $role=$fet['user_role'];
    
    $id=$fet['id'];
    
    $first_name=$fet['first_name'];     

    if($authority_id==$id)
      { $acceptance_issuing_name=$first_name; break; }

  }
  return $acceptance_issuing_name;
}

function sops_wi_dropdown($master_data,$selected_data)
{
    $selected_file_path='';

    $options='';

    foreach($master_data as $sop):

      $sel='';

      $desc=$sop['sl_no'].' '.$sop['description'];

      $sop_id=$sop['id'];

      $path=$sop['file_name'];

      if($sop['id']==$selected_data)
      {
          $sel='selected="selected"';

          $selected_file_path=$path;
      } 

    $options.='<option value="'.$sop['id'].'" data-desc="'.$path.'" '.$sel.'>'.$desc.'</option>';

    endforeach;  

    if($selected_file_path!='') {
      $tx=base_url().'uploads/sops_wi/'.$selected_file_path;
      $selected_file_path='<a href="javascript:void(0);" class="show_image" title="View Description" data-src="'.$tx.'" data-bs-toggle="modal" data-bs-target="#modal-full-width">Show Desc</a>';
    }

    return array('dropdown'=>$options,'show_desc'=>$selected_file_path);

}
$jquery_exec='';
$department_id=(isset($records['department_id'])) ? $records['department_id'] : $department['id'];
$job_approval_status=unserialize(JOBAPPROVALS);
$approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';
$show_button=(isset($records['show_button'])) ? $records['show_button'] : 'show';
$acceptance_custodian_id=(isset($records['acceptance_custodian_id'])) ? $records['acceptance_custodian_id'] : '';
$acceptance_performance_id = (isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';
$acceptance_custodian_name='';
if($acceptance_custodian_id>0) {
  $acceptance_custodian_name=get_authorities($acceptance_custodian_id,$authorities);
}
$acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';
$acceptance_issuing_approval=(isset($records['acceptance_issuing_approval'])) ? $records['acceptance_issuing_approval'] : NO;

$acceptance_issuing_name='';
if($acceptance_issuing_id>0) {
  $acceptance_issuing_name=get_authorities($acceptance_issuing_id,$authorities);
}

$acceptance_performing_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';
$status = (isset($records['status'])) ? $records['status'] : '';
$final_status_date=(isset($records['final_status_date'])) ? $records['final_status_date'] : '';
$cancellation_issuing_id = (isset($records['cancellation_issuing_id']) && $records['cancellation_issuing_id']>0) ? $records['cancellation_issuing_id'] : '';
$cancellation_performing_id = (isset($records['cancellation_performing_id'])) ? $records['cancellation_performing_id'] : '';
$is_excavation = (isset($records['is_excavation'])) ? $records['is_excavation'] : '';
$is_loto=(isset($records['is_loto'])) ? $records['is_loto'] : '';
$is_loto_closure_approval_completed=(isset($records['is_loto_closure_approval_completed'])) ? $records['is_loto_closure_approval_completed'] : '';
$is_loto_tags_approval_completed=(isset($records['is_loto_tags_approval_completed'])) ? $records['is_loto_tags_approval_completed'] : NO;

$jobs_extends_avail=(isset($jobs_extends) && count($jobs_extends)>0) ? "1" : '0';
$loto_closure_ids=(isset($records['loto_closure_ids']) && $records['loto_closure_ids']!='') ?  json_decode($records['loto_closure_ids'],true) : array();
                                    
$loto_closure_ids_dates=(isset($records['loto_closure_ids_dates']) && $records['loto_closure_ids_dates']!='') ?  json_decode($records['loto_closure_ids_dates'],true) : array();

$isolate_types=(isset($job_isolations['isolate_types']) && $job_isolations['isolate_types']!='') ?  json_decode($job_isolations['isolate_types'],true) : array();

$clerance_department_user_ids = (isset($records['clerance_department_user_id'])) ? json_decode($records['clerance_department_user_id'],true) : array();
$clearance_department_dates = (isset($records['clearance_department_dates'])) ? json_decode($records['clearance_department_dates'],true) : array();


$isolated_user_ids = (isset($job_isolations['isolated_user_ids'])) ? json_decode($job_isolations['isolated_user_ids'],true) : array();
$isolate_types= (isset($job_isolations['isolate_types'])) ? json_decode($job_isolations['isolate_types'],true) : array();
$isolated_name_approval_datetimes = (isset($job_isolations['isolated_name_approval_datetime'])) ? json_decode($job_isolations['isolated_name_approval_datetime'],true) : array();
$acceptance_loto_issuing_id = (isset($job_isolations['acceptance_loto_issuing_id'])) ? $job_isolations['acceptance_loto_issuing_id'] : '';
$acceptance_loto_pa_id = (isset($job_isolations['acceptance_loto_pa_id'])) ? $job_isolations['acceptance_loto_pa_id'] : '';

$acceptance_custodian_approval=(isset($records['acceptance_custodian_approval'])) ? $records['acceptance_custodian_approval'] : NO;

//Waiting Custodian/HOD Acceptance
if(in_array($approval_status,array(CUSTODIAN_CANCELLED,WAITING_CUSTODIAN_ACCPETANCE,PERMIT_REOPENED))) 
{
    $show_button='hide';

    if($user_id==$acceptance_performing_id && $acceptance_custodian_approval==NO && in_array($approval_status,array(PERMIT_REOPENED,WAITING_CUSTODIAN_ACCPETANCE)))
    $show_button='';
    else if(!in_array($user_id,array($acceptance_custodian_id,$acceptance_performing_id)) && $acceptance_custodian_approval==YES)
    $show_button='hide';
    else if($user_id==$acceptance_custodian_id && $acceptance_custodian_approval==NO)
    {
      $records['acceptance_custodian_date']=date('Y-m-d H:i');
      $form1_button_name='Approve';
      $show_button='';
    } 
}



//Waiting for IA Acceptance
if(in_array($approval_status,array(WAITING_IA_ACCPETANCE,IA_CANCELLED))) 
{
    $show_button='hide';
   // if($user_id!=$acceptance_issuing_id && $user_id!=$acceptance_performing_id)
    if($user_id==$acceptance_issuing_id)
    {
      $records['acceptance_issuing_date']=date('Y-m-d H:i');
      $form1_button_name='Approve';
      $permit_status_enable=1; $final_submit=1;
      $acceptance_issuing_approval='Approve';
    } 
}



$department_clearance=0;
//After IA Approved But Excavation is enabled
if(in_array($approval_status,array(WAITINGDEPTCLEARANCE,DEPTCLEARANCECOMPLETED))) 
{

  $i=0;

  $show_button='hide';

  foreach($clearance_departments as $list):

    $clerance_department_user_id = isset($clerance_department_user_ids[$list['id']]) && $clerance_department_user_ids[$list['id']]!='' ? $clerance_department_user_ids[$list['id']] : '';

    $dates_checked = isset($clearance_department_dates[$list['id']]) && $clearance_department_dates[$list['id']]!='' ? 'checked' : '';

    if($clerance_department_user_id==$user_id && $dates_checked==''){
        $clearance_department_dates[$list['id']] = date('d-m-Y H:i');
        $jquery_exec.="$('.clearance_department_remarks".$list['id']."').removeAttr('disabled');";
        $i++;
    }
    
  endforeach;

  if($i>0){
  $records['clearance_department_dates']=json_encode($clearance_department_dates);
  $department_clearance='1';
  $form1_button_name='Approve Dept Clearance';
  }
}

$iso_clearance=0;
//After IA/PA Approved but Loto is enabled
if(in_array($approval_status,array(WAITING_ISOLATORS_COMPLETION))) 
{ 
    $i=0;

    $show_button='hide';

    foreach($isolated_user_ids as $key => $label):

      if($label!='')
      {
         $dates_checked = isset($isolated_name_approval_datetimes[$key]) && $isolated_name_approval_datetimes[$key]!='' ? $isolated_name_approval_datetimes[$key] : '';

          $exp_label=explode(',',$label);

          if(in_array($user_id,$exp_label) && $dates_checked=='')
          {
            $isolated_name_approval_datetimes[$key] = date('d-m-Y H:i');
            $validate.=",'isolated_tagno1[".$key."]':{required:true}";
            $validate.=",'isolated_tagno3[".$key."]':{required:true}";
            $validate.=",'isolated_ia_name[".$key."]':{required:true}";

            $i++;
          }
      } 

    endforeach;

   # echo '<pre>'; print_r($_SESSION); exit;

    if($i>0){
      #$job_isolations['isolated_name_approval_datetime']=json_encode($isolated_name_approval_datetimes);
      $iso_clearance='1';
      $form1_button_name='Update Lock No';
    }
}


$isolation_info_done = (isset($records['isolation_info_done'])) ? $records['isolation_info_done'] : '';
//if loto is enabled
if(in_array($approval_status,array(WAITING_CCR_INFO,WAITING_TO_KEY))){

  $show_button='hide';

  if($isolation_info_done==NO && $user_id==$acceptance_performing_id){
    $final_submit=1; $remove_inputs_disabled='isolation_info_content';
    $form1_button_name='Update Isolation Info';
  }
}

$issuer_checklists_done = (isset($records['issuer_checklists_done'])) ? $records['issuer_checklists_done'] : '';
//IA Checkpoint updates
if(in_array($approval_status,array(WAITING_IA_CHECKPOINTS_UPDATES)))
{
    $show_button='hide';

    if($issuer_checklists_done==NO && $user_id==$acceptance_issuing_id){
      $final_submit=1; $remove_inputs_disabled='issuer_checklists_contents';
      $form1_button_name='Update Checklists Info';
    }
}

//After IA Approved 
if(in_array($approval_status,array(AWAITING_FINAL_SUBMIT)))     // && $final_status_date!=''
{
    //if($user_id!=$acceptance_performing_id)
    $show_button='hide';

    //Before Final Submit by PA
    if(in_array($approval_status,array(AWAITING_FINAL_SUBMIT)) && $status==STATUS_PENDING && $user_id==$acceptance_performing_id)
    { $form1_button_name='Final Submit'; $final_submit=1; $remove_inputs_disabled='tryout_done_contents'; }
}



$extends_column=0;
$block_disable=0; //To disable extends IA Input
$show_extends_status=0; //To show extneds IA Approve or Cancel
$allow_onchange_extends=1; //To allow extends when status change
$ext_issuing_authorities_dates=$ext_reference_codes=$show_reference_codes=array();

$ext_performing_authorities=(isset($jobs_extends['ext_performing_authorities']) && $jobs_extends['ext_performing_authorities']!='') ? json_decode($jobs_extends['ext_performing_authorities'],true) : array();

$ext_issuing_authorities=(isset($jobs_extends['ext_issuing_authorities']) && $jobs_extends['ext_issuing_authorities']!='') ? json_decode($jobs_extends['ext_issuing_authorities'],true) : array();

$ext_issuing_authorities_dates=(isset($jobs_extends['ext_issuing_authorities_dates']) && $jobs_extends['ext_issuing_authorities_dates']!='') ? json_decode($jobs_extends['ext_issuing_authorities_dates'],true) : array();

$ext_performing_authorities_dates=(isset($jobs_extends['ext_performing_authorities_dates']) && $jobs_extends['ext_performing_authorities_dates']!='') ? json_decode($jobs_extends['ext_performing_authorities_dates'],true) : array();

$ext_reference_codes=(isset($jobs_extends['ext_reference_codes']) && $jobs_extends['ext_reference_codes']!='') ? json_decode($jobs_extends['ext_reference_codes'],true) : array();

$schedule_to_dates=(isset($jobs_extends['schedule_to_dates']) && $jobs_extends['schedule_to_dates']!='') ? json_decode($jobs_extends['schedule_to_dates'],true) : array();

if($final_status_date!='')
{
    #echo 'AAA '.$session_department_id.'  ==  '.$department_id; exit;
    //Allow users to change the status
    if($session_department_id==$department_id && in_array($approval_status,array(WORK_IN_PROGRESS)))
    {
      $permit_status_enable=1;
      //When Loto is enabled and not completed approval
      if($is_loto==YES && $is_loto_closure_approval_completed==NO)
      {
       // $permit_status_enable=0;
      }
      else
      {
            //Check the permit is already sent request to cancel/completion to IA & accessing by another users
            if($user_id!=$cancellation_performing_id && in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION))){
                $permit_status_enable=0;}
            if($user_id==$cancellation_issuing_id && in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION))){
              $form1_button_name='Approve & Close'; $final_submit=1; 
              $records['cancellation_issuing_date']=date('Y-m-d H:i');
            }
      }

    } 

    //Extends
    if(in_array($approval_status,array(WAITING_IA_EXTENDED,APPROVE_IA_EXTENDED,CANCEL_IA_EXTENDED)))
    {
      
      $extend_flag=0;

      for($e=1;$e<=6;$e++)
      {
          //PA
          if(isset($ext_performing_authorities[$e]) && $ext_performing_authorities[$e]==$user_id && isset($ext_issuing_authorities_dates) && $ext_issuing_authorities_dates[$e]=='') // PA Edit
          {
                $extend_flag=1;
                $extends_column=$e;
                $jobs_extends_avail=$e;
                $form1_button_name='Save All'; $final_submit=1; break;
          }
          else if(isset($ext_performing_authorities[$e]) && $ext_performing_authorities[$e]==$user_id && $approval_status==CANCEL_IA_EXTENDED) // PA Edit
          {
            $extend_flag=1;
              $permit_status_enable=1;
                $extends_column=$e;
                $jobs_extends_avail=$e;
                $form1_button_name='Save All'; $final_submit=1; break;
          }
          
          else if(isset($ext_issuing_authorities[$e]) && $ext_issuing_authorities[$e]==$user_id && isset($ext_issuing_authorities_dates) && $ext_issuing_authorities_dates[$e]=='') //IA Approval
          {
            $extend_flag=1;
                $extends_column=$e;
                $jobs_extends_avail=$e;
                $form1_button_name='Approve Extend'; 
                $ext_issuing_authorities_dates[$e]=date('d-m-Y H:i');
                $ext_reference_codes[$e]=strtoupper(substr(md5(microtime()),0,5));
                $show_reference_codes[$e]=$e;
                $final_submit=1;
                $block_disable=1;
                $show_extends_status=1; 
                $permit_status_enable=1; break;
          } else if($session_department_id==$department_id && isset($ext_performing_authorities_dates) && $ext_performing_authorities_dates[$e]=='' && isset($ext_issuing_authorities_dates) && $ext_issuing_authorities_dates[$e]=='' && $approval_status==APPROVE_IA_EXTENDED) //New user extended
          { 
            $extend_flag=1;
              #$schedule_to_dates[$e-1]='21-08-2024';

              $earlier = new DateTime($schedule_to_dates[$e-1]);
              $later = new DateTime(date('d-m-Y'));

              $abs_diff = $later->diff($earlier)->format('%R%a');

             # echo '<br /> Date '.$schedule_to_dates[$e-1].' ========= '.date('d-m-Y').' ===='.strtotime($schedule_to_dates[$e-1]).' =========== '.$later->diff($earlier)->format('%R%a').' ================== '.$abs_diff;

              //Disable to extend if the TO date is set as tomorroww
             // if(isset($schedule_to_dates) && $schedule_to_dates[$e-1]!=date('d-m-Y')){
             // if(isset($schedule_to_dates) && $abs_diff==1){
              if(isset($schedule_to_dates) && $abs_diff<=0)
              {
                $extends_column=$e;
                $form1_button_name='Extend Permit '; 
                $block_disable=0;
              } else
              {
                $extends_column=0;
                $form1_button_name='Save All';
              }
              
              $jobs_extends_avail=$e;
              $permit_status_enable=1; 
              $final_submit=1; break;
          } else if($e==6 && $session_department_id==$department_id)
          {
            
            $jobs_extends_avail=$e;
            $permit_status_enable=1; 
            $final_submit=1; break;
          }

      }

    }

    //Approve IA Cancellation/Completion
    if(in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION)))
    {
      //When Loto is enabled and not completed approval
      if($is_loto==YES && $is_loto_closure_approval_completed==NO)
      {
        $permit_status_enable=0;
      }
      else
      {
            //Check the permit is already sent request to cancel/completion to IA & accessing by another users
            if($user_id!=$cancellation_performing_id && in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION))){
                $permit_status_enable=0;}
            else if($user_id==$cancellation_performing_id && in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION))){
              $permit_status_enable=1;}

            if($user_id==$cancellation_issuing_id && in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION))){
              $form1_button_name='Approve & Close'; $final_submit=1;
              $records['cancellation_issuing_date']=date('Y-m-d H:i');
            }
      }

    } 
}

//Self Cancel
if($approval_status==SELF_CANCEL)
$show_button='hide';


?>
<link href="<?php echo base_url(); ?>assets/latest/plugins/select2/css/select2.css" rel="stylesheet">
<style>
label.error { display:none !important;}
textarea,input[type="text"] { text-transform: uppercase; }
#job_form2 .form-check { margin-bottom:2px !important;}
.form-check-label { color:black !important;}
.form-check-input { border-color:black;}
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
         

          <div class="modal modal-blur fade" id="modal-scrollable" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="log_title">Scrollable modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="log_text">
                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
         </div>


          <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane tab1 active show" id="tabs-home-6 ">

                  
                  <form id="job_form" name="job_form" enctype="multipart/form-data" > 
                      <input type="hidden" id="id" name="id" value="<?php echo $record_id; ?>" />
                      <input type="hidden" id="permit_no" name="permit_no" value="<?php echo (isset($records['permit_no'])) ? $records['permit_no'] : $permit_no ?>" />
                      <input type="hidden" id="last_modified_id" name="last_modified_id" value="<?php echo (isset($records['last_modified_id'])) ? $records['last_modified_id'] : ''; ?>" />
                      <input type="hidden" id="clearance_department_required" name="clearance_department_required" value="<?php echo $clerance_department_disabled=='' && $record_id!='' ? "true" : "false" ?>" />
                      <input type="hidden" name="department_id" id="department_id" value="<?php echo $department_id ?>" />
                      <input type="hidden" name="jobs_extends_avail" id="jobs_extends_avail" value="<?php echo $jobs_extends_avail; ?>" />
                      <input type="hidden" name="allow_onchange_extends" id="allow_onchange_extends" value="<?php echo $allow_onchange_extends; ?>" />
                      <input type="hidden" name="is_excavation" id="is_excavation" value="<?php echo (isset($records['is_excavation'])) ? $records['is_excavation'] : ''; ?>" />
                      
                    <!-- Step A Start -->
                      <?php
                      $this->load->view('jobs/print_options',array('record_id'=>$record_id,'final_status_date'=>$final_status_date,'is_loto'=>$is_loto,'permit_no'=>(isset($records['permit_no'])) ? $records['permit_no'] : $permit_no)); 
                      ?>
                      
                        <div class="row row-cards">
                          <div class="col-md-3">
                            <div class="mb-3">
                              <label class="form-label">Permit No <?php #echo $show_button; ?></label>
                              <div class="form-control-plaintext"><b><?php echo (isset($records['permit_no'])) ? $records['permit_no'] : $permit_no ?></b></div>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="mb-3">
                              <label class="form-label">Department</label>
                              <div class="form-control-plaintext"><?php
                              echo $department['name']; ?></div>
                            </div>
                          </div>

                          <?php
                            $permit_fr=(isset($records['permit_for'])) ? $records['permit_for'] : $plant_type; 
                          ?>

                          <div class="col-md-3">
                            <div class="mb-3">
                              <label class="form-label">Permit for</label>
                              <div class="form-control-plaintext"><?php
                              echo $this->plant_types[$permit_fr]; ?></div>
                            </div>
                          </div>
                          <input type="hidden" name="permit_for" id="permit_for" value="<?php echo $permit_fr; ?>" />

                          
                          <div class="col-sm-6 col-md-3">
                            <div class="mb-3">
                              <label class="form-label">Select Zone</label>
                              <input type="hidden" name="zone_id" id="zone_id"  class="select2dropdown form-control" value="<?php echo $select_zone_id; ?>"  data-type="zones" data-account-text="<?php echo $zone_name; ?>" data-account-number="<?php echo $select_zone_id; ?>" data-width="300px"/> 
                              
                              <span id="zone_id_others" style="display:<?php echo $zone_name=='Others' ? 'block' : 'none'; ?>;"> <br /><br />
                                    <input type="text" class="form-control" name="others_zone" id="others_zone"  value="<?php echo (isset($records['others_zone'])) ? $records['others_zone'] : ''; ?>" >
                              </span>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-3">
                            <div class="mb-3">
                              <label class="form-label">Start Date & Time</label>
                              <input type="text" class="form-control" name="location_time_start" id="location_time_start"  value="<?php echo (isset($records['location_time_start'])) ? $records['location_time_start'] : date('d-m-Y H:i'); ?>" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-3">
                            <div class="mb-3">
                              <label class="form-label">End Date & Time</label>
                              <input type="text" class="form-control" name="location_time_to" id="location_time_to"  value="<?php echo (isset($records['location_time_to'])) ? $records['location_time_to'] : date('d-m-Y H:i',strtotime("+".PERMIT_CLOSE_AFTER." hours")); ?>" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Select Contractor</label>
                            
                            <select class="form-control select2"  name="contractor_id" id="contractor_id" multiple>
                                <?php   
                                  $select_contractor_id=(isset($records['contractor_id'])) ? explode(',',$records['contractor_id']) : array();
                                  foreach($contractors as $list){
                                ?>
                                <option value="<?php echo $list['id'];?>" <?php if(in_array($list['id'],$select_contractor_id)) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php } ?>
                                  </select>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Sub/Other Contractor</label>
                            <input type="text" class="form-control" placeholder="Sub/Other Contractor Name" name="sub_contractor" id="sub_contractor"  value="<?php echo (isset($records['sub_contractor'])) ? $records['sub_contractor'] :  ''; ?>">
                          </div>
                        </div>
                       
                      


                        <div class="col-md-6">
                          <div class="mb-3 mb-0">
                            <label class="form-label">Work Description</label>
                            <textarea rows="3" class="form-control" placeholder="Here can be your description"
                            value="" name="job_name" id="job_name"><?php echo (isset($records['job_name'])) ? $records['job_name'] :  ''; ?></textarea>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3 mb-0">
                            <label class="form-label">Location</label>
                            <textarea rows="3" class="form-control" placeholder="Here can be your description"
                            value="" name="location" id="location"><?php echo (isset($records['location'])) ? $records['location'] :  ''; ?></textarea>
                          </div>
                        </div>


                        <div class="col-sm-6 col-md-12">
                          <div class="mb-3">
                            <label class="form-label text-red">To be filled by Permit Initiator</label>                            
                          </div>
                        </div>


                        <div class="col-md-12">
                                <div class="mb-3">                                   
                                    <div>
                                        <?php
                                            $checked='';
                                            
                                            foreach($permits as $list){

                                             // $checked=$list['id']==$permit_type_id ? "checked='checked'" : '';
                                              $checked=(in_array($list['id'],$permit_type_ids)) ? "checked='checked'" : '';

                                              $is_excav=$list['is_excavation'];

                                              $disabled='';

                                              if($list['department_id']!=$department_id && $list['department_id']>0) {
                                                $disabled='disabled';
                                              }
                                              
                                          
                                        ?>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input permit_type_ids" name="permit_type_ids[]" type="checkbox" value="<?php echo $list['id']; ?>" <?php echo $checked; ?> <?php echo $disabled; ?> data-excavation="<?php echo $is_excav; ?>">
                                        <span class="form-check-label"><?php echo $list['name']; ?><?php #echo $list['id']; ?></span>
                                    </label>
                                    <?php } ?>
                                    </div>
                                </div>
                        </div>

                        <div class="col-xl-12 permit_checklists" id="permit_checklists" >
                                     
                        </div>

                    </div> 

                    <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>

                    <div class="row g-5 clearance_departments" style="display:<?php echo $is_excavation==YES ? 'block' : 'none'; ?>">
                      <div class="col-xl-12">
                              <div class="row">
                                  <div class="col-md-6 col-xl-12">
                                        <div class="mb-3">
                                        <label class="form-label text-red">Clearance required from other Department</label>
                                        </div>
                                        <div class="table-responsive">
                                                <table class="table mb-0" border="1">
                                                  <tbody>
                                                  <tr>
                                                    <?php
                                                    
                                                    $clerance_department_user_id=(isset($records['clerance_department_user_id'])) ? json_decode($records['clerance_department_user_id'],true) : array();

                                                    $clearance_department_remarks=(isset($records['clearance_department_remarks'])) ? json_decode($records['clearance_department_remarks'],true) : array();

                                                    $clearance_department_dates=(isset($records['clearance_department_dates'])) ? json_decode($records['clearance_department_dates'],true) : array();

                                                    # print_r($clerance_department_user_id); 
                                                    $r=1;
                                                    foreach($clearance_departments as $list):

                                                      $validate.=",'clerance_department_user_id[".$list['id']."]':{required:function(element) {
                                                        if($('input[name=\"clerance_department_id[".$list['id']."]\"]').is(':checked')) 
                                                        return true; 
                                                        else return false;
                                                        }}";

                                                      $validate.=",'clerance_department_id[".$list['id']."]':{required:function(element) {
                                                          
                                                          if(Number($('.clerance_department_id:checked').length)==0 && $('#clearance_department_required').val()=='true') {
                                                                return true;
                                                          } else return false;

                                                      //  return Boolean($('#clearance_department_required').val()); 
                                                          
                                                        },minlength:1}";

                                                        $checked = isset($clerance_department_user_id[$list['id']]) && $clerance_department_user_id[$list['id']]!='' ? 'checked' : '';

                                                        $department_user_id = isset($clerance_department_user_id[$list['id']]) && $clerance_department_user_id[$list['id']]!='' ? $clerance_department_user_id[$list['id']] : '';

                                                        $name = ''; $disabled='disabled';

                                                        # echo '<pre>'; print_r($allusers);

                                                        if($checked!='')
                                                        {
                                                          $name = get_authorities($department_user_id,$allusers);
                                                          $disabled='';
                                                        }
                                                        if(in_array($user_id,array($acceptance_performance_id,$acceptance_custodian_id)) && $approval_status==WAITING_CUSTODIAN_ACCPETANCE && $department_user_id!='')
                                                          $clerance_department_disabled=$disabled=''; 
                                                        
                                                    ?>
                                                    
                                                      <td>
                                                          <label class="form-check">
                                                                  <input class="form-check-input clerance_department_id" name="clerance_department_id[<?php echo $list['id']; ?>]" type="checkbox" value="<?php echo $list['id']; ?>" <?php echo $clerance_department_disabled; ?> <?php echo $checked; ?> <?php echo $disabled; ?>>
                                                                  <span class="form-check-label"><?php echo $list['name']; ?></span>
                                                          </label>
                                                      
                                                      <input type="hidden" name="clerance_department_user_id[<?php echo $list['id']; ?>]" id="clerance_department_user_id<?php echo $list['id']; ?>"  class="select2dropdown form-control" value="<?php echo $department_user_id; ?>"  data-type="clearance_department" data-account-text="<?php echo $name; ?>" data-account-number="<?php echo $department_user_id; ?>" data-width="300px" <?php echo $clerance_department_disabled; ?> data-filter-value="<?php echo $list['id']; ?>" <?php echo $disabled; ?>/> </td>
                                                    
                                                    <?php
                                                    endforeach;
                                                    ?>
                                                    </tr>                                                    
                                                    <tr>
                                                      <?php
                                                      $r=1;
                                                      foreach($clearance_departments as $list):

                                                        $checked = isset($clerance_department_user_id[$list['id']]) && $clerance_department_user_id[$list['id']]!='' ? 'checked' : '';

                                                        $disabled='disabled';
                                                        $name='';

                                                        if($checked!='')
                                                        {
                                                         # $disabled='';
                                                          $name = isset($clearance_department_remarks[$list['id']]) && $clearance_department_remarks[$list['id']]!='' ? $clearance_department_remarks[$list['id']] : '';
                                                        }

                                                      ?>
                                                      <td>
                                                              <label class="form-check" style="padding-left:0px;">
                                                                  <span class="form-check-label">Notes (If any)</span>  
                                                              </label>
                                                              <textarea rows="2" class="form-control clearance_department_remarks<?php echo $list['id']; ?>" 
                                                              name="clearance_department_remarks[<?php echo $list['id']; ?>]" id="clearance_department_remarks[<?php echo $list['id']; ?>]" <?php echo $disabled; ?>><?php echo $name; ?></textarea>
                                                      </td>
                                                      <?php
                                                      endforeach;
                                                      ?>
                                                    </tr>
                                                    <tr>
                                                      <?php
                                                      $r=1;
                                                      foreach($clearance_departments as $list):

                                                        $clearance_department_date = isset($clearance_department_dates[$list['id']]) && $clearance_department_dates[$list['id']]!='' ? $clearance_department_dates[$list['id']] : '';

                                                      ?>
                                                      <td>
                                                              <label class="form-check" style="padding-left:0px;">
                                                                  <span class="form-check-label">Sign Date&Time</span>  
                                                              </label>
                                                              <input type="text" name="clearance_department_dates[<?php echo $list['id']; ?>]" id="clearance_department_dates[<?php echo $list['id']; ?>]" class="form-control" readonly  value="<?php echo $clearance_department_date; ?>"/>
                                                      </td>
                                                      <?php
                                                      endforeach;
                                                      ?>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                        </div>     
                                  </div>
                                  
                                  
                              </div> 
                      </div>
                    </div> 

                    <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>
                   
                    <div class="row g-5">
                        <div class="col-md-3">
                                <div class="mb-3">
                                <span class="form-label text-red"><b>Isolation Require</b></span><br />
                                      <?php
                                      $disabled='';
                                      $isolation_requires=array(YES,NO);

                                      $is_loto=(isset($records['is_loto'])) ? $records['is_loto'] : ''; 

                                      foreach($isolation_requires as $key => $val):

                                          $chk = $is_loto==$val ? 'checked' : ''; 
                                      ?>
                                        <label class="form-check form-check-inline">
                                                <input  type="radio" 
                                                name="is_loto" value="<?php echo $val; ?>"  class="form-check-input is_loto" data-id="<?php echo $key; ?>" <?php echo $chk; ?> <?php echo $disabled; ?>><span class="form-check-label"><?php echo $val; ?></span>
                                        </label>
                                      <?php endforeach; ?>
                                </div>
                          </div>
                   </div>
                   

                    <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>
                  
                  
                   <div class="row g-5 loto_sections"  style="display:<?php echo $is_loto==YES ? 'block' : 'none'; ?>">
                            <div class="col-xl-12">
                                  <div class="table-responsive" >
                                      <table class="table mb-0" border="1" id="isolation_table">
                                                    </table>
                                  </div>
                           </div>
                   </div>
                    
                   <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>

                    <div class="row g-5">
                        <div class="col-sm-6 col-md-12">
                          <div class="mb-3">
                            <label class="form-label text-red">SOP & WI</label>                            
                          </div>
                        </div>
                    </div>
                    <div class="row g-5">
                        <div class="col-md-6">
                          <div class="mb-3 mb-0">
                                    <?php
                                    $other_inputs=(isset($records['other_inputs']) && $records['other_inputs']!='') ? json_decode($records['other_inputs'],true) : array();

                                    $selected_sop=(isset($records['sop'])) ? $records['sop'] :  '';

                                    $sops = array_values(array_filter($user_instruction_infos, function ($filt)  { return $filt['record_type'] == SOPS; }));

                                    if(count($sops)>0) {
                                      $result = sops_wi_dropdown($sops,$selected_sop);
                                    ?>
                                      <label class="form-label">SOP</label>
                                      <select class="form-control select3" name="sop" id="sop" data-target="show_sop" ><option value="" data-desc=""> - - Select SOP - - </option>
                                      <?php  echo $result['dropdown']; ?>
                                    </select>
                                    <span id="show_sop" style="padding-left:165px;"><?php echo $result['show_desc']; ?></span>
                                    <?php
                                    } else 
                                    {
                                    ?>
                                      <label class="form-check form-check-inline">
                                      <input type="checkbox" <?php if(in_array('SOP',$other_inputs)) { ?> checked="checked" <?php } ?> name="other_inputs[]" class="other_inputs form-check-input" value="SOP"  /><span class="form-check-label">SOP</span></label>
                                    <?php
                                    }
                                    ?>

                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3 mb-0">
                                  <?php
                                  $wis = array_values(array_filter($user_instruction_infos, function ($filt)  { return $filt['record_type'] == WORK_INSTRUCTIONS; }));

                                  if(count($wis)>0) {
                                    $result = sops_wi_dropdown($wis,(isset($records['wi'])) ? $records['wi'] :  '');
                                  ?>
                                    <label class="form-label">No.of Workers</label>
                                    <select class="form-control select3" name="wi" id="wi" data-target="show_wi" ><option value="" data-desc=""> - - Select Work Instruction - - </option>
                                    <?php echo $result['dropdown']; ?>
                                  </select>
                                  <span id="show_wi" style="padding-left:165px;"><?php echo $result['show_desc']; ?></span>
                                  <?php
                                  } else 
                                  {
                                    $disabled='disabled';
                                  ?>
                                  <label class="form-check form-check-inline">
                                    <input type="checkbox" <?php if(in_array('WI',$other_inputs)) { $disabled=''; ?> checked="checked" <?php } ?> name="other_inputs[]" class="other_inputs form-check-input wi" value="WI"  /><span class="form-check-label">Work instructions clearly explained to the all the members in the working Group</span></label>
                                    <br />
                                    <label class="form-check" style="padding-left:0px;">
                                      <span class="form-check-label">WI Notes (If any)</span>  
                                  </label>
                                  <textarea rows="2" class="form-control wi_notes" 
                                  name="wi_notes" <?php echo $disabled; ?>><?php echo (isset($records['wi_notes'])) ? $records['wi_notes'] :  ''; ?></textarea>
                                  <?php
                                  }
                                  ?>
                          </div>
                        </div>
                    </div> 

                    <div class="row g-5">
                        <div class="col-sm-6 col-md-12">
                          <div class="mb-3">
                            <label class="form-label text-red">Safety Instructions</label>                            
                          </div>
                        </div>
                    </div>
                    <div class="row g-5"><div class="col-sm-6 col-md-12">&nbsp;</div></div>
                  <div class="row g-5">
                      <div class="col-md-3">
                            <div class="mb-3 mb-0">
                            <label class="form-label">Initiator Name & Signature</label>
                            <div class="form-control-plaintext"><?php echo strtoupper((isset($records['acceptance_performing_name'])) ? $records['acceptance_performing_name'] :  $this->session->userdata('first_name')); ?> <?php echo (isset($records['acceptance_performing_date'])) ? strtoupper($records["acceptance_performing_date"]) :  date('d-m-Y H:i');?>HRS</div>

                            <input type="hidden" class="form-control" placeholder="" value="<?php echo (isset($records['acceptance_performing_name'])) ? $records['acceptance_performing_name'] :  $this->session->userdata('first_name'); ?>" disabled name="acceptance_performing_name" id="acceptance_performing_name"/>
                            <input type="hidden" class="form-control" placeholder="" value="<?php echo (isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] :  $this->session->userdata('user_id'); ?>"  disabled name="acceptance_performing_id" id="acceptance_performing_id"/>
                          
                            </div>
                      </div>
                      <div class="col-md-3">
                            <div class="mb-3 mb-0">
                            <label class="form-label">Co-Permittee</label>
                            <?php
                            $copermittee_id=(isset($records['copermittee_id'])) ? $records['copermittee_id'] : '';
                            ?>
                            <input type="text" name="copermittee_id" id="copermittee_id" class="form-control"  value="<?php echo $copermittee_id; ?>"/>
                            
                            </div>
                      </div>
                      <?php
                       
                           $disabled='';
                          if($record_id!='')
                              $disabled=($user_id==$acceptance_performing_id && $approval_status==WAITING_CUSTODIAN_ACCPETANCE) ? '' : 'disabled';
                      ?>
                      <div class="col-md-3 col-xl-3">
                              <div class="mb-3">
                              <label class="form-label">Custodian (Section Head/HOD)</label>
                              <input type="hidden" name="acceptance_custodian_id" id="acceptance_custodian_id"  class="select2dropdown form-control" value="<?php echo $acceptance_custodian_id; ?>"  data-type="custodian_id" data-account-text="<?php echo $acceptance_custodian_name; ?>" data-account-number="<?php echo $acceptance_custodian_id; ?>" data-width="300px" data-filter-value="<?php echo (isset($records['department_id'])) ? $records['department_id'] : $department['id']; ?>" data-skip-users="<?php echo $record_id=='' ? $user_id : $acceptance_performance_id; ?>" <?php echo $disabled; ?> data-filter-user-role="<?php echo $record_id=='' ? $this->session->userdata('is_section_head') : $records['is_section_head']; ?>"/>
                              </div>
                              <div class="mb-3">
                              
                              </div>
                              <div class="mb-3">
                              <label class="form-label">Signature Date & Time</label>
                              <input value="<?php echo (isset($records['acceptance_custodian_date'])) ? $records['acceptance_custodian_date'] : ''; ?>" type="text" id="acceptance_custodian_date"  name="acceptance_custodian_date" class="form-control" readonly="readonly" />
                              </div>                    
                      </div>
                      
                      <div class="col-md-3 col-xl-3">
                              <div class="mb-3">
                              <label class="form-label">Name of the Issuer</label>
                              <input type="hidden" name="acceptance_issuing_id" id="acceptance_issuing_id"  class="select2groupbydropdown form-control" value="<?php echo $acceptance_issuing_id; ?>"  data-type="issuing_id" data-account-text="<?php echo $acceptance_issuing_name; ?>" data-account-number="<?php echo $acceptance_issuing_id; ?>" data-width="300px" data-filter-value="<?php echo (isset($records['department_id'])) ? $records['department_id'] : $department['id']; ?>" data-skip-users="<?php echo $record_id=='' ? $user_id : $acceptance_performance_id; ?>" <?php echo $disabled; ?>/>
                              </div>
                              <div class="mb-3">
                              
                              </div>
                              <div class="mb-3">
                              <label class="form-label">Signature Date & Time</label>
                              <input value="<?php echo (isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : ''; ?>" type="text" id="acceptance_issuing_date"  name="acceptance_issuing_date" class="form-control" readonly="readonly" />
                              </div>                    
                      </div>
                  </div>

                  <?php
                  if($acceptance_issuing_approval==YES) 
                  {
                        if($is_loto==YES && $is_loto_tags_approval_completed==YES) {
                   ?>

                   <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>

                   <div class="row g-5">
                        <div class="col-sm-6 col-md-12">
                          <div class="mb-3">
                            <label class="form-label text-red">Isolation Info</label>                            
                          </div>
                        </div>
                    </div>

                   <div class="row g-5 isolation_info_content">
                        <div class="col-md-3">
                                <div class="mb-3">
                                <span class="form-check-label"><b>Done Isolation</b></span><br />
                                      <?php
                                      $tryouts=array(YES,NO);

                                      $done_isolation=(isset($records['done_isolation'])) ? $records['done_isolation'] : ''; 

                                      $validate.=",'done_isolation':{required:true}";
                                      $validate.=",'done_isolation_notes':{required:true}";

                                      foreach($tryouts as $key => $val):

                                          $chk = $done_isolation==$val ? 'checked' : '';
                                      ?>
                                        <label class="form-check form-check-inline">
                                                <input  type="radio" 
                                                name="done_isolation" value="<?php echo $val; ?>"  class="form-check-input done_isolation" data-id="<?php echo $val; ?>" <?php echo $chk; ?> <?php echo $disabled; ?>><span class="form-check-label"><?php echo $val; ?></span>
                                        </label>
                                      <?php endforeach; ?>
                                </div>
                        </div>
                        
                        <div class="col-md-3">
                                      <div class="mb-3 self_cancel">
                                        <label class="form-label">Isolation Notes</label>
                                        <textarea rows="3" class="form-control" placeholder="Here can be your notes"
                                        name="done_isolation_notes" id="done_isolation_notes"><?php echo (isset($records['done_isolation_notes'])) ? $records['done_isolation_notes'] :  ''; ?></textarea>
                                      </div>    
                        </div>
                        <div class="col-md-3">
                                <div class="mb-3">
                                <span class="form-check-label"><b>Key with me</b></span><br />
                                      <?php
                                      $tryouts=array(YES,NO);

                                      $keywithme_done=(isset($records['keywithme_done'])) ? $records['keywithme_done'] : ''; 
                                      
                                      $validate.=",'keywithme_done':{required:true}";
                                      $validate.=",'keywithme_done_notes':{required:true}";


                                      foreach($tryouts as $key => $val):

                                          $chk = $keywithme_done==$val ? 'checked' : '';
                                      ?>
                                        <label class="form-check form-check-inline">
                                                <input  type="radio" 
                                                name="keywithme_done" value="<?php echo $val; ?>"  class="form-check-input keywithme_done" data-id="<?php echo $val; ?>" <?php echo $chk; ?> <?php echo $disabled; ?>><span class="form-check-label"><?php echo $val; ?></span>
                                        </label>
                                      <?php endforeach; ?>
                                </div>
                        </div>
                        <div class="col-md-3">
                                      <div class="mb-3 self_cancel">
                                        <label class="form-label">Key Notes</label>
                                        <textarea rows="3" class="form-control" placeholder="Here can be your notes"
                                        name="keywithme_done_notes" id="keywithme_done_notes"><?php echo (isset($records['keywithme_done_notes'])) ? $records['keywithme_done_notes'] :  ''; ?></textarea>
                                      </div>    
                        </div>
                   </div>

                   <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>

                   <div class="row g-5" style="display:none;">
                      <?php
                           $disabled=$clerance_department_disabled='';
                          $r=1;
                          $isoaltion_info_department_user_id=(isset($records['isoaltion_info_department_user_id'])) ? json_decode($records['isoaltion_info_department_user_id'],true) : array();
                          foreach($isoaltion_info_departments as $list):

                            $name='';

                            $validate.=",'isoaltion_info_department_user_id[".$list['id']."]':{required:true}";

                            $clearance_department_date = isset($clearance_department_dates[$list['id']]) && $clearance_department_dates[$list['id']]!='' ? $clearance_department_dates[$list['id']] : '';

                            $department_user_id = isset($isoaltion_info_department_user_id[$list['id']]) && $isoaltion_info_department_user_id[$list['id']]!='' ? $isoaltion_info_department_user_id[$list['id']] : '';
                            
                            if($department_user_id!='')
                                $name = get_authorities($department_user_id,$allusers);
                      ?>
                      <div class="col-md-3 col-xl-3">
                              <div class="mb-3">
                              <label class="form-label">Issuer <?php echo $list['name']; ?></label>
                              <input type="hidden" name="isoaltion_info_department_user_id[<?php echo $list['id']; ?>]" id="isoaltion_info_department_user_id<?php echo $list['id']; ?>"  class="select2dropdown form-control" 
                              value="<?php echo $department_user_id; ?>"  data-type="clearance_department" data-account-text="<?php echo $name; ?>" data-account-number="<?php echo $department_user_id; ?>" data-skip-users="<?php echo $acceptance_performance_id; ?>" data-width="300px" <?php echo $clerance_department_disabled; ?> data-filter-value="<?php echo $list['id']; ?>" <?php echo $disabled; ?>/> 
                              </div>
                              <!--<div class="mb-3">
                              
                              </div>
                              <div class="mb-3">
                              <label class="form-label">Signature Date & Time</label>
                              <input type="text" name="isoaltion_info_department_user_dates[<?php echo $list['id']; ?>]" id="isoaltion_info_department_user_dates[<?php echo $list['id']; ?>]" class="form-control" readonly  value="<?php echo $clearance_department_date; ?>"/>
                              </div>   -->                
                      </div>
                      <?php
                          endforeach;
                      ?>
                   </div>
                    
                   <?php
                   if($isolation_info_done==YES) { ?>
                        <div class="row row-cards issuer_checklists_contents">
                                <div class="col-md-6 col-xl-6">
                                      <div class="mb-3">
                                      <span class="form-check-label"><b>Issuer Checklists</b></span><br />
                                      <table class="table mb-0" border="1">
                                      <tbody>
                                          <tr>
                                                <th width="0.1%">Yes</th><th width="0.1%">No</th><th width="0.1%">N/A</th>
                                                <th width="7%">Checklists</th>
                                            </tr>
                                      </tbody>
                                            <?php
                                            $ccr_lists=unserialize(CCR_CHECKLISTS);

                                            $issuer_checklists=(isset($records['issuer_checklists'])) ? json_decode($records['issuer_checklists'],true) : array(); 

                                            $validate.=",'issuer_cecklists_notes':{required:true}";


                                            foreach($ccr_lists as $key => $val):

                                              $data = (isset($issuer_checklists[$key])) ? $issuer_checklists[$key] : '';

                                              $y_checked = $data=='y' ? "checked='checked'" : '';
                                              $n_checked = $data=='n' ? "checked='checked'" : '';
                                              $na_checked = $data=='na' ? "checked='checked'" : '';

                                              $validate.=",'issuer_checklists[".$key."]':{required:true}";

                                            ?>
                                            <tr>
                                                  <td> 
                                                  <label class="form-check form-check-inline">
                                                  <input class="form-check-input issuer_checklists" type="radio" 
                                                  value="y" name="issuer_checklists[<?php echo $key; ?>]" <?php echo $y_checked; ?> <?php echo $disabled; ?>>
                                                  </label></td><td>
                                                  <label class="form-check form-check-inline">
                                                  <input class="form-check-input issuer_checklists" type="radio" 
                                                  value="n" name="issuer_checklists[<?php echo $key; ?>]"  <?php echo $n_checked; ?> <?php echo $disabled; ?>>
                                                  </label></td><td>
                                                  <label class="form-check form-check-inline">
                                                  <input class="form-check-input issuer_checklists" type="radio" 
                                                  value="na" name="issuer_checklists[<?php echo $key; ?>]"  <?php echo $na_checked; ?> <?php echo $disabled; ?>>
                                                  </label>
                                                  </td>
                                                  <td> 
                                                  <?php echo $val; ?>
                                                  </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            </table>
                                      </div>
                                </div>
                                
                                <div class="col-md-4 col-xl-4">
                                            <div class="mb-3 " style="padding-top:32px;">
                                              <label class="form-label">Any other instruction or advise</label>
                                              <textarea rows="3" class="form-control" placeholder="Here can be your notes"
                                              name="issuer_cecklists_notes" id="issuer_cecklists_notes"><?php echo (isset($records['issuer_cecklists_notes'])) ? $records['issuer_cecklists_notes'] :  ''; ?></textarea>
                                            </div>    
                                </div>
                                
                        </div>
                  <?php } } 
                   if($is_loto==YES) { ?>
                   <div class="row g-5 tryout_done_contents" style="display:<?php echo $isolation_info_done==YES && $issuer_checklists_done==YES ? 'block' : 'none'; ?>">
                            <div class="col-md-3">
                              <div class="mb-3">
                                    <span class="form-check-label"><b>Tryout Done</b></span><br />
                                      <?php
                                      $tryouts=unserialize(TRYOUT);

                                      $validate.=",'tryout_done':{required:true}";
                                      $validate.=",'tryout_done_notes':{required:true}";

                                      $tryout_done=(isset($records['tryout_done'])) ? $records['tryout_done'] : ''; 
                                      $tryouts=$is_loto==YES ? array_slice($tryouts,0,count($tryouts)-1) : $tryouts;

                                      foreach($tryouts as $key => $val):

                                          $chk = $tryout_done==$key ? 'checked' : '';

                                          $disabled=$is_loto==NO ? '' : 'disabled';
                                      ?>
                                        <label class="form-check form-check-inline">
                                                <input  type="radio" name="tryout_done" value="<?php echo $key; ?>"  class="form-check-input tryout_done" data-id="<?php echo $key; ?>" <?php echo $chk; ?> <?php echo $disabled; ?> /><span class="form-check-label"><?php echo $val; ?></span>
                                        </label>
                                      <?php endforeach; ?>
                                </div>
                            </div> 
                          <div class="col-md-3">
                                      <div class="mb-3 ">
                                        <label class="form-label">Key Notes</label>
                                        <textarea rows="3" class="form-control" placeholder="Here can be your notes"
                                        name="tryout_done_notes" id="tryout_done_notes"><?php echo (isset($records['tryout_done_notes'])) ? $records['tryout_done_notes'] :  ''; ?></textarea>
                                      </div>    
                          </div>
                   </div>
                   <?php
                  } }
                  $job_status=array();
                          
                          // Waiting for IA Approval
                          if($user_id==$acceptance_performance_id && in_array($approval_status,array(SELF_CANCEL,WAITING_CUSTODIAN_ACCPETANCE,PERMIT_REOPENED))) 
                          {
                              $job_status=array(SELF_CANCEL=>'Self Cancel',WAITING_CUSTODIAN_ACCPETANCE=>'Waiting Custodian Approval');

                              if($approval_status==IA_CANCELLED) { 
                              $job_status[IA_CANCELLED]='IA Cancelled';
                              $job_status[WAITING_IA_ACCPETANCE]='Send IA Approval';
                              }
                              if($approval_status==PERMIT_REOPENED){
                                $job_status[WAITING_CUSTODIAN_ACCPETANCE]='Send Custodian Approval';
                              }

                              $job_status_validation=1;
                          }   
                          else if($user_id==$acceptance_custodian_id && in_array($approval_status,array(WAITING_CUSTODIAN_ACCPETANCE,PERMIT_REOPENED)))      // Waiting for Custodian Approval && Reviewing
                          {
                                $job_status=array(PERMIT_REOPENED=>'Reopen',CUSTODIAN_CANCELLED=>'Cancel Initiator Request',WAITING_IA_ACCPETANCE=>'Approve Initiator Request');
                                $job_status_validation=1;
                          }  
                          // Waiting for IA Approval && IA Reviewing
                          else if($user_id==$acceptance_issuing_id && in_array($approval_status,array(WAITING_IA_ACCPETANCE,IA_CANCELLED,IA_APPROVED,PERMIT_REOPENED))) 
                          {
                              $job_status=array(PERMIT_REOPENED=>'Reopen',IA_CANCELLED=>'Cancel Initiator Request',IA_APPROVED=>'Approve Initiator Request');
                              $job_status_validation=1;
                          }else if(in_array($approval_status,array(WAITINGDEPTCLEARANCE,DEPTCLEARANCECOMPLETED))) 
                          {
                              $job_status=array(WAITINGDEPTCLEARANCE=>'Waiting Dept Clearance',DEPTCLEARANCECOMPLETED=>'Completed Dept Clearance');
                              $job_status_validation=1;
                          }else if(in_array($approval_status,array(WAITING_ISOLATORS_COMPLETION))) 
                          {
                              $job_status=array(WAITING_ISOLATORS_COMPLETION=>'Waiting Isolators Clearance',APPROVED_ISOLATORS_COMPLETION=>'Isolators Clearance Completed');
                              $job_status_validation=1;
                          } 

                         
                          //After Final Step is completed by PA
                          if($final_status_date!='')// && $department_id==$session_department_id
                          {
                              $job_status=array(WORK_IN_PROGRESS=>'In Progress',WAITING_IA_COMPLETION=>'Completion',WAITING_IA_CANCELLATION=>'Cancellation',WAITING_IA_EXTENDED=>'Extends');

                              if($jobs_extends_avail>0 && in_array($approval_status,array(WAITING_IA_EXTENDED,APPROVE_IA_EXTENDED,CANCEL_IA_EXTENDED)))
                              {    
                                   if($extends_column>0)
                                   {
                                   $approval_status=WAITING_IA_EXTENDED;
                                   $job_status[WAITING_IA_EXTENDED]='Extended';
                                   } else 
                                   {
                                     unset($job_status[WAITING_IA_EXTENDED]);
                                    // $approval_status=APPROVE_IA_EXTENDED;
                                   //  $job_status[APPROVE_IA_EXTENDED]='Extended';
                                   }
                                   unset($job_status[WORK_IN_PROGRESS]);
                              }

                              if($is_excavation=='Yes'){
                               //unset($job_status[IA_APPROVED]);
                             //unset($job_status[WORK_IN_PROGRESS]);
                              // $job_status[DEPTCLEARANCECOMPLETED]='Dept Clearance Completed';
                              }
                          }

                          //Extends Approval
                          if($final_status_date!='' && in_array($approval_status,array(WAITING_IA_EXTENDED)) && $show_extends_status==1)
                          {
                             $job_status=array(CANCEL_IA_EXTENDED=>'Cancel Extends',APPROVE_IA_EXTENDED=>'Approve Extends');
                          }
                          
                          if($final_status_date!='' && in_array($approval_status,array(APPROVED_IA_CANCELLATION,APPROVED_IA_COMPLETION))) {
                             $job_status=array(APPROVED_IA_CANCELLATION=>'Cancelled',APPROVED_IA_COMPLETION=>'Completed');
                          }
                  ?>
                  
                  <?php
                  if($record_id!='' && count($job_status)>0)
                  {
                  ?>         
                    <div class="row g-5">
                          <div class="col-md-6 col-xl-6">
                              <div class="mb-3">
                                  <label class="form-label text-red">Permit Status</label>
                                  <?php
                                    echo $avi_message;
                                    foreach($job_status as $key =>$label)
                                    {
                                      $chk = ($approval_status==$key) ? "checked" : '';
                                      $class='';

                                      if($avi_message!='' && in_array($key,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION)))
                                        $class='avi_message_class';
                                  ?>
                                      <label class="form-check form-check-inline" >
                                            <input class="form-check-input job_status <?php echo $class; ?>" type="radio" 
                                            value="<?php echo $key; ?>" name="approval_status" <?php echo $chk; ?> ><?php echo $label; ?>
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
                    </div>   

                    <div class="row g-5 extends" style="display:<?php echo (in_array($approval_status,array(WAITING_IA_EXTENDED)) || $jobs_extends_avail>0) ? 'block' : 'none'; ?>;">
                          <div class="col-xl-12">
                              <div class="mb-3">
                              <label class="form-label text-red">Renewal of Permit to Work</label>                            
                              </div>
                              <div class="table-responsive" style="overflow: auto;">
                                <table class="table mb-0" border="1" style=" width: 150%;">                                  
                                  <tbody>
                                    <?php
                                    $acceptance_issuing_date=(isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : '';
                                    $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$acceptance_issuing_date));

                                    

                                    $ext_columns=array('schedule_from_dates'=>'From Date','schedule_to_dates'=>'To Date','ext_performing_authorities'=>'Initiator','ext_performing_authorities_dates'=>'Initiator Signed Date','ext_issuing_authorities'=>'Issuer','ext_issuing_authorities_dates'=>'Issuer Signed Date','ext_oxygen_readings'=>'%  of  Oxygen level <br>19.5  to  23.5  %','ext_gases_readings'=>'Combustible gases<br> 0  %','ext_carbon_readings'=>'Carbon Monoxide<br>0-25  ppm','ext_reference_codes'=>'Reference Code');
                                    $c=1;

                                    $schedule_from_dates=(isset($jobs_extends['schedule_from_dates']) && $jobs_extends['schedule_from_dates']!='') ? json_decode($jobs_extends['schedule_from_dates'],true) : array();

                                    $schedule_to_dates=(isset($jobs_extends['schedule_to_dates']) && $jobs_extends['schedule_to_dates']!='') ? json_decode($jobs_extends['schedule_to_dates'],true) : array();

                                    $ext_contractors=(isset($jobs_extends['ext_contractors']) && $jobs_extends['ext_contractors']!='') ? json_decode($jobs_extends['ext_contractors'],true) : array();

                                    $ext_contractors=(isset($jobs_extends['ext_contractors']) && $jobs_extends['ext_contractors']!='') ? json_decode($jobs_extends['ext_contractors'],true) : array();

                                    $ext_contractors=(isset($jobs_extends['ext_contractors']) && $jobs_extends['ext_contractors']!='') ? json_decode($jobs_extends['ext_contractors'],true) : array();

                                    $ext_performing_authorities=(isset($jobs_extends['ext_performing_authorities']) && $jobs_extends['ext_performing_authorities']!='') ? json_decode($jobs_extends['ext_performing_authorities'],true) : array();

                                    $ext_performing_authorities_dates=(isset($jobs_extends['ext_performing_authorities_dates']) && $jobs_extends['ext_performing_authorities_dates']!='') ? json_decode($jobs_extends['ext_performing_authorities_dates'],true) : array();

                                    $ext_issuing_authorities=(isset($jobs_extends['ext_issuing_authorities']) && $jobs_extends['ext_issuing_authorities']!='') ? json_decode($jobs_extends['ext_issuing_authorities'],true) : array();

                                    $ext_oxygen_readings=(isset($jobs_extends['ext_oxygen_readings']) && $jobs_extends['ext_oxygen_readings']!='') ? json_decode($jobs_extends['ext_oxygen_readings'],true) : array();

                                    $ext_gases_readings=(isset($jobs_extends['ext_gases_readings']) && $jobs_extends['ext_gases_readings']!='') ? json_decode($jobs_extends['ext_gases_readings'],true) : array();

                                    $ext_carbon_readings=(isset($jobs_extends['ext_carbon_readings']) && $jobs_extends['ext_carbon_readings']!='') ? json_decode($jobs_extends['ext_carbon_readings'],true) : array();

                                    $ext_column_values=array('schedule_from_dates'=>$schedule_from_dates,'schedule_to_dates'=>$schedule_to_dates,'ext_contractors'=>$ext_contractors,'ext_performing_authorities'=>$ext_performing_authorities,'ext_performing_authorities_dates'=>$ext_performing_authorities_dates,'ext_issuing_authorities'=>$ext_issuing_authorities,'ext_issuing_authorities_dates'=>$ext_issuing_authorities_dates,'ext_oxygen_readings'=>$ext_oxygen_readings,'ext_gases_readings'=>$ext_gases_readings,'ext_carbon_readings'=>$ext_carbon_readings,'	ext_cop'=>array(),'ext_reference_codes'=>$ext_reference_codes);

                                      //Confined
                                      if(!in_array(7,$permit_types))
                                      {
                                        unset($ext_columns['ext_oxygen_readings']);
                                        unset($ext_column_values['ext_oxygen_readings']);
                                        unset($ext_columns['ext_gases_readings']);
                                        unset($ext_column_values['ext_gases_readings']);
                                        unset($ext_columns['ext_carbon_readings']);
                                        unset($ext_column_values['ext_carbon_readings']);
                                      }

                                    foreach($ext_columns as $field_name => $td_label)
                                    {

                                    ?>
                                    <tr>
                                      <td width="7%"><?php echo $td_label; ?></td>
                                        <?php
                                        for($c=1;$c<=5;$c++)
                                        {
                                            $td_inpput_value=(isset($ext_column_values[$field_name][$c]) && $ext_column_values[$field_name][$c]!='') ? $ext_column_values[$field_name][$c] : '';

                                            $show_reference_code=(isset($show_reference_codes[$c]) && $show_reference_codes[$c]!='') ? $show_reference_codes[$c] : '';

                                            switch($field_name)
                                            {
                                                case 'schedule_from_dates': 
                                                      $td_input=$this->public_model->extends_from_date($field_name,$td_inpput_value,$c,1);
                                                      break;
                                                case 'schedule_to_dates':
                                                      $schedule_to_date=(isset($schedule_to_dates[$c]) && $schedule_to_dates[$c]!='') ? $schedule_to_dates[$c] : '';
                                                      $td_input=$this->public_model->extends_from_date($field_name,$td_inpput_value,$c,2);
                                                      break;
                                                case 'ext_contractors':
                                                      $td_input=$this->public_model->extends_contractors($field_name,$contractors,$td_inpput_value,$c);
                                                      break;
                                                case 'ext_performing_authorities':
                                                case 'ext_issuing_authorities':
                                                      $td_input=$this->public_model->extends_authorities($field_name,$td_inpput_value,$c,$user_id,$authorities,$td_inpput_value);
                                                      break;
                                                case 'ext_oxygen_readings':
                                                case 'ext_gases_readings':
                                                case 'ext_carbon_readings':
                                                      $td_input='<input type="text" class="extends'.$c.' form-control '.$field_name.$c.'" name="'.$field_name.'['.$c.']" id="'.$field_name.'['.$c.']" value="'.$td_inpput_value.'">';
                                                      break;
                                                case 'ext_performing_authorities_dates':
                                                case 'ext_issuing_authorities_dates':
                                                      $td_input='<input type="hidden" class="extends'.$c.' form-control '.$field_name.$c.'" name="'.$field_name.'['.$c.']" id="'.$field_name.'['.$c.']" value="'.$td_inpput_value.'"><span id="'.$field_name.$c.'">'.$td_inpput_value.'</span>';
                                                      break;
                                              case 'ext_reference_codes':
                                                        $td_input='<input type="hidden" class="extends'.$c.' form-control '.$field_name.$c.'" name="'.$field_name.'['.$c.']" id="'.$field_name.'['.$c.']" value="'.$td_inpput_value.'"><span id="'.$field_name.$c.'">'.($show_reference_code=='' ? $td_inpput_value : '').'</span>';
                                                        break;
                                                default:
                                                      $td_input='';
                                                      break;
                                            }

                                        ?>
                                          <td><?php echo $td_input; ?></td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                  </tbody>
                                </table>
                              </div>     
                          </div>
                   </div>
                   <?php
                  if($is_loto==YES && $final_status_date!='') { ?>
                  <div class="loto_sections_completion"  data-id="8" style="display:<?php echo (in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION,APPROVED_IA_CANCELLATION,APPROVED_IA_COMPLETION))) ? 'block' : 'none'; ?>;">
                    <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>
                    <div class="row g-5 ">
                          <div class="col-xl-12">
                                  <div class="row">
                                      <div class="col-md-6 col-xl-12">
                                          <div class="mb-3">
                                          <label class="form-label text-red">Closure of permit to work (1st copy of Permit must be routed during permit closure)</label>
                                          </div>                                           
                                      </div>
                                  </div>                            
                          
                          </div> 
                    </div> 
  
                    <div class="table-responsive">
                        <table class="table mb-0" border="1">
                        <?php
                        $arr = array(1=>'The job is completed, all men & material removed from site. <br />Safe to remove isolations as stated clause-A&C.',2=>'Please remove isolations as stated clause-A&C.',3=>'I have removed all isolation as listed clause-A&C and <br />all isolations as per clause-A&C are restored. Equipment ready to start');

                        $arr_sub = array(1=>'Permit Initiator Name & Sign',2=>'Issuer Name & Sign',3=>'Isolator Name & Sign');

                        $arr_users=array(1=>'performing',2=>'loto_closure_issuing',3=>'loto_closure_isolators');       
                        
                        $arr_dropdonws=array(1=>'select2dropdown',2=>'select2groupbydropdown',3=>'select2dropdown');

                        $isolate_types = array_values(array_filter($isolate_types));

                        $isolate_types=implode(',',$isolate_types);

                        $input_department=(isset($records['department_id']) && $records['department_id']>0) ? $records['department_id'] : $department['id'];

                        foreach($arr as $key => $label):
                          $input_value=$input_value_text=$input_filter_value=$input_skip_value=$input_date_value=$prev_input_date_value=$prev_input_user_id_value='';

                          $input_value=(isset($loto_closure_ids[$key]) && $loto_closure_ids[$key]!='')  ? $loto_closure_ids[$key] : '';

                       
                          if($input_value!=''){
                            $input_value_text=get_authorities($input_value,$allusers);
                          }

                        

                          $input_date_value=(isset($loto_closure_ids_dates[$key]) && $loto_closure_ids_dates[$key]!='')  ? $loto_closure_ids_dates[$key] : '';

                          if($key>1)
                          {
                            $prev_input_date_value=(isset($loto_closure_ids_dates[$key-1]) && $loto_closure_ids_dates[$key-1]!='')  ? $loto_closure_ids_dates[$key-1] : '';
                            $prev_input_user_id_value=(isset($loto_closure_ids[$key-1]) && $loto_closure_ids[$key-1]!='')  ? $loto_closure_ids[$key-1] : '';
                          }

                          $readonly=($key==1 || $input_date_value!='') ? 'readonly' : '';

                            switch($key)
                            {
                                case 1:                                               
                                      $input_date_value = $input_date_value=='' ? date('d-m-Y H:i') : $input_date_value;
                                      if($input_value=='')
                                      {
                                          $input_value=$user_id;
                                          $input_value_text=$this->session->userdata('first_name');
                                      }
                                      break;                                            
                                case 2:
                                      $input_skip_value=$user_id;
                                      if($user_id==$input_value && $input_date_value=='')
                                      {
                                          $input_date_value=date('d-m-Y H:i');
                                          $input_skip_value='';
                                          $form1_button_name='Approve'; $final_submit=1;
                                      }
                                      break;
                                case 3:
                                        $input_department=$isolate_types;
                                        //$input_department=$department_id;
                                        $input_skip_value='';
                                        $readonly='readonly';
                                        if($user_id==$input_value && $input_date_value=='' && $prev_input_date_value!='')
                                        {
                                            $input_date_value=date('d-m-Y H:i');
                                            $form1_button_name='Approve'; 
                                            $final_submit=1;
                                        } else if($user_id==$prev_input_user_id_value){
                                            $readonly='';
                                            $remove_clearance_inputs_disabled='loto_sections_completion_input_id'.$key;
                                        }
                                        break;
                            }

                            if($readonly=='')
                            {
                                $validate.=",'loto_closure_ids[".$key."]':{required:function(element) {
                                if($('.loto_sections_completion').is(':visible')==true) 
                                return true; 
                                else return false;
                                }}";
                            }


                            
                        ?>
                          <tr>
                                    <td> <label class="form-label"><?php echo ($key).' '.$label.' '.$remove_inputs_disabled; ?></label></td>
                                    <td><label class="form-label"><?php echo $arr_sub[$key]; ?></label>
                                    <div class="form-control-plaintext"> 
                                    <input type="hidden" name="loto_closure_ids[<?php echo $key; ?>]" id="loto_closure_ids[<?php echo $key; ?>]"  data-id="<?php echo $key; ?>" class="<?php echo $arr_dropdonws[$key]; ?> form-control  loto_sections_completion_inputs loto_sections_completion_input_id<?php echo $key; ?>" value="<?php echo $input_value; ?>"  data-type="<?php echo $arr_users[$key]; ?>" data-account-text="<?php echo $input_value_text; ?>" data-account-number="<?php echo $input_value; ?>" data-width="300px" data-filter-value="<?php echo $input_department; ?>" data-skip-users="<?php echo $input_skip_value; ?>" data-departments="<?php echo $input_department; ?>" <?php echo $readonly; ?> data-filter-departments="<?php echo $department_id; ?>" />
                                    </div>
                                    </td>
                                    <td><label class="form-label">&nbsp;</label><div class="form-control-plaintext"><input type="text" class="form-control loto_closure_ids_dates" name="loto_closure_ids_dates[<?php echo $key; ?>]" id="loto_closure_ids_dates[<?php echo $key; ?>]" data-id="<?php echo $key; ?>" value="<?php echo $input_date_value; ?>" placeholder="DD/MM/YYYY HH/MM" readonly/></div></td>
                          </tr>
                        <?php
                        endforeach;
                        ?>
                        </table> 
                    </div>
                  </div>
                  <?php } 

                      if($final_status_date!='')
                      {

                      ?>
                        <div class="row g-5 completion" style="display:<?php echo (in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION,APPROVED_IA_CANCELLATION,APPROVED_IA_COMPLETION))) ? 'block' : 'none'; ?>;">
                              <div class="col-xl-12">
                                  <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>
                                  <div class="row">
                                        <div class="col-md-6 col-xl-3">
                                            <div class="mb-3">
                                                <label class="form-label text-red">Initiator Work <span class="status_txt"><?php echo (in_array($approval_status,array(5,6))) ? 'Completion' : 'Cancellation'; ?></span></label>
                                                <div class="form-control-plaintext">Work <span class="status_txt"><?php echo (in_array($approval_status,array(5,6))) ? 'Completion' : 'Cancellation'; ?></span>, all persons are withdrawn and material removed from the area.</div>
                                            </div>    
                                                                      
                                        </div>
                                        <div class="col-md-6 col-xl-3">
                                            <div class="mb-3">
                                                <label class="form-label text-red">Initiator Name</label>
                                                    <div class="mb-3">
                                                      
                                                      <div class="form-control-plaintext "><?php echo strtoupper((isset($records['cancellation_performing_name']) && $records['cancellation_performing_name']!='') ? $records['cancellation_performing_name'] :  $this->session->userdata('first_name')); ?></div>

                                                      <label class="form-label text-red">Signature Date&Time</label>

                                                      <div class="form-control-plaintext"><?php echo (isset($records['cancellation_performing_date'])) ? strtoupper($records["cancellation_performing_date"]) :  date('d-m-Y H:i');?>HRS
                                                      </div>

                                                      <input type="hidden" class="form-control" placeholder="" value="<?php echo (isset($records['cancellation_performing_name']) && $records['cancellation_performing_name']!='') ? $records['cancellation_performing_name'] :  $this->session->userdata('first_name'); ?>" disabled name="cancellation_performing_name" id="cancellation_performing_name"/>
                                                      <input type="hidden" class="form-control" placeholder="" value="<?php echo (isset($records['cancellation_performing_id'])) ? $records['cancellation_performing_id'] :  $this->session->userdata('user_id'); ?>"  disabled name="cancellation_performing_id" id="cancellation_performing_id"/>
                                                    </div>    
                                            </div>                   
                                        </div>
                                        <div class="col-md-6 col-xl-3">
                                          <div class="mb-3">
                                              <label class="form-label text-red">Issuer Work <span class="status_txt"><?php echo (in_array($approval_status,array(5,6))) ? 'Completion' : 'Cancellation'; ?></span></label>
                                              <div class="form-control-plaintext">I have inspected the work area and declare the work for which the permit was issued has been properly.</div>
                                          </div>        
                                          </div>
                                          <?php
                                          $cancellation_issuing_name='';

                                          if(!!$cancellation_issuing_id)
                                          $cancellation_issuing_name = get_authorities($cancellation_issuing_id,$authorities);
                                          ?>
                                          <div class="col-md-6 col-xl-3">
                                              <div class="mb-3">
                                                  <label class="form-label text-red">Name of the Issuer</label>
                                                        <div class="mb-3">
                                                              
                                                              <input type="hidden" name="cancellation_issuing_id" id="cancellation_issuing_id"  class="select2groupbydropdown form-control" value="<?php echo $cancellation_issuing_id; ?>"  data-type="issuing_id" data-account-text="<?php echo $cancellation_issuing_name; ?>" data-account-number="<?php echo $cancellation_issuing_id; ?>" data-width="300px" data-filter-value="<?php echo (isset($records['department_id'])) ? $records['department_id'] : $department['id']; ?>" data-skip-users="<?php echo $record_id=='' || $records['cancellation_performing_id']=='' ? $user_id : $acceptance_performance_id.','.$records['cancellation_performing_id']; ?>" />
                                                              </div>
                                                              <div class="mb-3">
                                                              
                                                              </div>
                                                              <div class="mb-3">
                                                              <label class="form-label">Signature Date & Time</label>
                                                              <input value="<?php echo (isset($records['cancellation_issuing_date'])) ? $records['cancellation_issuing_date'] : ''; ?>" type="text" id="cancellation_issuing_date"  name="cancellation_issuing_date" class="form-control" readonly="readonly" />
                                                      </div> 
                                              </div>                   
                                          </div>
                                  </div>
                              </div>
                      </div>
                      <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>
                      <?php
                      }
                    
                  }    
                 
                   if($show_button!='hide' || $final_submit==1 || $permit_status_enable==1 || $department_clearance==1 || $iso_clearance==1) { ?>
                  
                  <div class="row g-5">
                      <div class="col-xl-12" style="text-align:right;">
                      
                        <input type="submit" name="step1" id="step1" class="btn btn-success submit" value="<?php echo $form1_button_name; ?>" data-next-step="2" data-current-step="1">
                  
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

<div class="modal modal-blur fade" id="modal-full-width" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="attached_image">Full width modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="show_pdf_information">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
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
  $(window).on("load", function () {
    setTimeout(function() {
      $('#modal-download :input').prop('disabled',false);
                <?php     
                if($permit_status_enable==1){
                ?>
                  $('.job_status').prop('disabled',false);
                  $('#notes').prop('disabled',false);
                  $(".completion :input").prop('disabled',false);
                  $('.submit').prop('disabled',false);

                  if($('.loto_sections_completion').length>0){
                    $('.loto_sections_completion :input').prop('disabled',false);
                  }

                <?php } 
                  if($department_clearance==1 || $iso_clearance==1 || $final_submit==1) { 
                ?>
                $('.submit').prop('disabled',false);
              <?php
                }
                if($checkbox_clearance!='') {
                  echo "$('.".$checkbox_clearance."').prop('disabled',false)";
                }
     
                echo $jquery_exec;
                
                if(in_array($approval_status,array(AWAITING_FINAL_SUBMIT)))
                {
                      echo '$(".tryout_done:last").removeAttr("disabled");';
                }

              if($acceptance_issuing_approval=='Approve'){
              ?>
                $('.eq_given_local').each(function(){

                var val = $(this).val();
                var data_id=$(this).attr('data-id');
                var tag_value=$('.isolated_tagno3'+data_id).val();
                //alert('Looop start '+data_id+' Val '+val+' Tag Value '+tag_value);
                    if(val!='' && tag_value==''){
                    //   $('.isolate_type'+data_id).removeAttr('disabled');
                        <?php
                        if($plant_type==CEMENT_PLANT){
                        ?>
                        $('.isolated_tagno1'+data_id).prop('disabled',false);
                        <?php
                          }
                        ?>

                        // alert('Looop END '+data_id);
                        $('.isolated_user_ids'+data_id).prop('disabled',false);
                        $('.submit').prop('disabled',false);
                    }

                });
              <?php
              }
              if($remove_inputs_disabled!=''){

                echo '$(".'.$remove_inputs_disabled.' :input").removeAttr("disabled");';
              }  
              if($remove_clearance_inputs_disabled!=''){
                echo '$(".'.$remove_clearance_inputs_disabled.'").removeAttr("disabled");';
              }
            ?>
     }, 500);
   //   alert('Window on End Load');
});

  $(document).ready(function() {
    <?php 
       if($show_button=='hide' || in_array($approval_status,array(SELF_CANCEL)))
       {
         ?>
           $('input,textarea,select').attr('disabled',true);
       <?php
       }
     ?>

    <?php  
    if($is_loto==YES) { ?>
       load_lotos();
    <?php } ?>



    //Need to remove this line
   //$('input,textarea,select').attr('disabled',false);

   function load_lotos()
  {
          var data = new FormData();  
          data.append('zone_id',$('#zone_id').val());
          data.append('approval_status','<?php echo $approval_status; ?>');
          <?php
          if($job_isolations) {
            ?>
            data.append('job_id','<?php echo $record_id; ?>');
          <?php
          }
          ?>
          $.ajax({
          url: base_url+'eip_checklists/ajax_get_eip_checklists/',
          type: 'POST',
          "beforeSend": function(){  },
          data: data,
          async: false,
          cache: false,
          dataType: 'json',
          processData: false, // Don't process the files
          contentType: false, // Set content type to false as jQuery will tell the server its a query string request
          success: function(data, textStatus, jqXHR)
          {
            $('#isolation_table').html(data.rows);		

            <?php
            if($this->show_filter_form=='')
            {
            ?>
                if(data.electrical_shutdown!='')
                  $('.electrical_shutdown').show();
                else 
                  $('.electrical_shutdown').hide();
            <?php
            }
            ?>

            load_lotos_select2();
          },
          error: function(jqXHR, textStatus, errorThrown)
          {
            $('#isolation_table').html('Failure Response '+jqXHR?.responseText+' = '+textStatus);	

            // is_checklist=data.num_rows;
          }
        });
      //  $(".eq_select2").select2("destroy");
        
  }

  function load_lotos_select2(){ 

    $(".eq_select2").select2('destroy'); 
    $(".eq_select_iso").select2('destroy'); 
    $(".eq_select2").select2({placeholder: "- - Select - - ",width:'200px'}); 
    $(".eq_select_iso").select2({placeholder: "- - Select - - ",width:'200px'}); 
  }
  
  $(".is_loto").change(function()
  {
      var val=$(this).val();      
      console.log('Is loto ',val);
      var loto=0;
      
      if(val=='Yes')
        loto=1;

      if(loto==1){
        $('.loto_sections').show(); 
        load_lotos();
      } else{
        $('.loto_sections').hide(); 
      }
  });


  $("#zone_id").change(function()
  {
      var val=$(this).val();
      var loto='';

      var is_loto=$('.is_loto:checked').val();

      var data=$(this).select2('data');


      data_text='';

      if(!!data) {
        data_text=data?.text;
      }

      $('#zone_id_others').hide();

      if(data_text=='Others') {
          $('#zone_id_others').show();
      }

     

      if(is_loto=='Yes')
        loto=1;

      if(loto==1){
        $('.loto_sections').show();
       // $('.loto_sections_div').show();
      //  $('.loto_sections_approval').show(); 

        load_lotos();
      } else{
        $('.loto_sections').hide();
       // $('.loto_sections_div').hide();
     //   $('.loto_sections_approval').hide();
      }
  });

  $('.wi').change(function(){

      var val=$(this).val();

      if($(this).is(':checked')==true) {
        $('.wi_notes').prop('disabled',false);
      } else{
        $('.wi_notes').prop('disabled',true);
        $('.wi_notes').val();
      }
        

  });
    		

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

      //Cancellation/Completion
      if(val=='5' || val=='7') {

        if($('.extends').length>0)
        {
          var pre_arr=new Array('schedule_from_dates','schedule_to_dates','ext_performing_authorities','ext_issuing_authorities','ext_oxygen_readings','ext_gases_readings','ext_carbon_readings');

          var extends_val_avail=0;

          var e=$('#jobs_extends_avail').val();

            for (i = 0; i < pre_arr.length; i++) 
            {
              var field_name=pre_arr[i]+''+e+'';

              console.log('Field Name ',field_name);

              console.log('Field Value ',$('.'+field_name).val());

              if($('.'+field_name).length>0 && $('.'+field_name).val()!='' && $('.ext_reference_codes'+e).val()=='')
              {
                  extends_val_avail=1;
                  console.log('Value is Available '+field_name+' = ='+$('.'+field_name).val());
                  $('.job_status').val(22).prop('checked',true);
                  alert('Please complete or reset the current extends column');
                  return false;
              }
            }  

            if(extends_val_avail==0){
              $(".extends :input").attr("disabled", true);
            }
        }

          $('.completion').show();
          
          if($('.loto_sections_completion').length>0){
            $('.loto_sections_completion').show();
          }

      } else{
        $('.completion').hide();
        if($('.loto_sections_completion').length>0){
              $('.loto_sections_completion').hide();
        }
        
      }
          
      if(val=='5' || val=='6')
        $('.status_txt').html('Completion');
      else if(val=='7' || val=='8')
        $('.status_txt').html('Cancellation');

      if(val=='22'){
          $('.extends').show();
          check_extends(0);
      }

  });

  function check_extends(block_disable)
  {
     var jobs_extends_avail=$('#jobs_extends_avail').val();
     var allow_onchange_extends=$('#allow_onchange_extends').val();

     console.log('jobs_extends_avail',jobs_extends_avail+' = '+block_disable+' = '+allow_onchange_extends)

      if(allow_onchange_extends==1)
      {
          //First Extends
          if(jobs_extends_avail=='0'){
            $('.extends1').prop('disabled',false);
            $('#ext_performing_authorities1').removeAttr('disabled');
            $('#ext_issuing_authorities1').removeAttr('disabled');
          } else {
            console.log('Job Extends False');
            $('.extends'+jobs_extends_avail).prop('disabled',false);
            $('#ext_contractors'+jobs_extends_avail).select2().prop('disabled',false);
            
            if(block_disable==0){
              $('#ext_performing_authorities'+jobs_extends_avail).removeAttr('disabled');
              $('#ext_issuing_authorities'+jobs_extends_avail).removeAttr('disabled');
            } else {
              $('#ext_performing_authorities'+jobs_extends_avail).prop('disabled',true);
              $('#ext_issuing_authorities'+jobs_extends_avail).prop('disabled',true);
            }
          }
      }
  }
  $(".permit_type_ids").change(function()
  {  
      
      $('#clearance_department_required').val(false);
      $('.clerance_department_id').attr('disabled',true);
      $('.precautions').hide();
      var loto=''; var clearance_departments='';
      var arr= []
      $('#is_excavation').val('No');
      var job_id=$('#id').val();
      var data = new FormData();			

      $(".permit_type_ids:checked").each(function(index,value) {

        var is_excav=$(this).attr('data-excavation');

        if(is_excav==1){
            clearance_departments=1;
            $('#is_excavation').val('Yes');
         }

         arr.push(Number($(this).val()))
      });
    
      data.append('permit_type_ids',arr);		
      data.append('job_id',job_id);
      data.append('show_button','<?php echo $show_button; ?>');
      
      if(arr.length>0)
      {
          $.ajax({    
            "type" : "POST",
            "url" : base_url+'permit_checklists/ajax_get_permit_checklists',	
            data:data,	
            type: 'POST',
            processData: false,
            contentType: false,
            dataType:"json",
            success:function(data, textStatus, jqXHR){

              $('#permit_checklists').html(data.response);

            },
            error: function(jqXHR, textStatus, errorThrown){
              alert('ERror Jobs Form '+errorThrown);
            }
          });		
    
      }
      if(clearance_departments==1){
        $('.clearance_departments').show();
        $('#clearance_department_required').val(true);
        $('.clerance_department_id').removeAttr('disabled');
      } else {
        $('.clearance_departments').hide();
      }

  });
 
  $('body').on('change','.eq_given_local',function() 
  {
      var val=$(this).val();
      var data_id=$(this).attr('data-id');
      
      if(val!='') {
          $('.equipment_descriptions'+data_id).prop('disabled',false);
      } else {
        $('.equipment_descriptions'+data_id).val('');
        $('.equipment_descriptions'+data_id).trigger('change');
      }

  });

  $('body').on('click','.loto_add_more',function() {
       
       $('.eq_select2').select2("destroy");
         var $tableBody = $('#isolation_table').find("tbody"),
         $trLast = $tableBody.find("tr:last"),
         $trNew = $trLast.clone().find('input').val('').end();
         $trLast.after($trNew);
 
         $('#isolation_table tr:last').each(function(j) {
 
           var rowId=$(this).attr('data-row-id');
           rowId++;
           $(this).attr('id','equip_row_id'+rowId);
           $(this).attr('data-row-id',rowId);
           i=rowId;
         if (j === 1)
             return;

            //Eq Local            
            var textinput = $(this).find('.eq_given_local');
             textinput.eq(0).attr('data-id', i);
             textinput.eq(0).attr('id', 'eq_given_local['+i+']');
             textinput.eq(0).attr('name', 'eq_given_local['+i+']');
             textinput.eq(0).attr('class', 'form-control eq_given_local form-control eq_given_local'+i);
            // textinput.eq(0).attr('disabled', 'disabled');
             $('.eq_given_local'+i).val('');
              
             //Desc OR Others
             var textinput = $(this).find('.equipment_descriptions');
             //console.log('OKKKKKKKKKKKKKKKKK ',textinput.eq(0).find("span.select2 "));
             textinput.eq(0).find("span.select2 ").remove();
             textinput.eq(0).attr('data-id', i);
             textinput.eq(0).attr('id', 'equipment_descriptions['+i+']');
             textinput.eq(0).attr('name', 'equipment_descriptions['+i+']');
             textinput.eq(0).attr('class', 'form-control equip_desc equipment_descriptions equip_desc_dropdown eq_select2 equipment_descriptions'+i);    
             textinput.eq(0).attr('disabled', 'disabled');        
             //$('.equipment_descriptions'+i).val('');
             
 
             var textinput = $(this).find('.equipment_descriptions_name');
             textinput.eq(0).attr('data-id', i);
             textinput.eq(0).attr('id', 'equipment_descriptions_name['+i+']');
             textinput.eq(0).attr('name', 'equipment_descriptions_name['+i+']');
             textinput.eq(0).attr('class', 'form-control equipment_descriptions_name equipment_descriptions_name'+i);
             textinput.eq(0).hide();
 
             //Tag No
             var textinput = $(this).find('.equipment_tag_no');
             textinput.eq(0).attr('data-id', i);
             textinput.eq(0).attr('id', 'equipment_tag_nos['+i+']');
             textinput.eq(0).attr('name', 'equipment_tag_nos['+i+']');
             textinput.eq(0).attr('class', 'form-control equipment_tag_no equipment_tag_no'+i);
 
             //Isolation types            
             var textinput = $(this).find('.isolate_types');
             textinput.eq(0).attr('data-id', i);
             textinput.eq(0).attr('id', 'isolate_type['+i+']');
             textinput.eq(0).attr('name', 'isolate_types['+i+']');
             textinput.eq(0).attr('class', 'isolate_types form-control isolate_type'+i);
             textinput.eq(0).attr('disabled', 'disabled');
             $('.isolate_type'+i).val('');
 
             //PA Lock            
             var textinput = $(this).find('.isolated_pa_tagno');
             textinput.eq(0).attr('data-id', i);
             textinput.eq(0).attr('id', 'isolated_tagno1['+i+']');
             textinput.eq(0).attr('name', 'isolated_tagno1['+i+']');
             textinput.eq(0).attr('class', 'form-control isolated_pa_tagno isolated_tagno1'+i);
             textinput.eq(0).attr('disabled', 'disabled'); 

             //IA Lock      
             var textinput = $(this).find('.isolated_ia_tagno');
             textinput.eq(0).attr('data-id', i);
             textinput.eq(0).attr('id', 'isolated_tagno3['+i+']');
             textinput.eq(0).attr('name', 'isolated_tagno3['+i+']');
             textinput.eq(0).attr('class', 'form-control isolated_ia_tagno isolated_tagno3'+i);
             textinput.eq(0).attr('disabled', 'disabled');

             var ii=i-1;
             console.log('OKKKK ',".isolated_user_ids"+(ii));
             //Name of Isolator
             var textinput = $(this).find('.isolated_user_ids');
             textinput.eq(0).attr('data-id', i);             
             textinput.eq(0).attr('id', 'isolated_user_ids['+i+']');
             textinput.eq(0).attr('name', 'isolated_user_ids['+i+']');
             textinput.eq(0).attr('class', 'form-control isolated_user_ids  data-iso-name  isolated_user_ids'+i); //eq_select_iso
             textinput.eq(0).attr('disabled', 'disabled');
             textinput.eq(0).attr('style','display:none');

            
             
             //Isolator Date&Time
             var textinput = $(this).find('.isolated_name_approval_datetime');
             textinput.eq(0).attr('data-id', i);
             textinput.eq(0).attr('id', 'isolated_name_approval_datetime['+i+']');
             textinput.eq(0).attr('name', 'isolated_name_approval_datetime['+i+']');
             textinput.eq(0).attr('class', 'form-control isolated_name_approval_datetime isolated_name_approval_datetime'+i);
             textinput.eq(0).attr('disabled', 'disabled');
 
             load_lotos_select2();
         });
 
   });

  $(".clerance_department_id").change(function()
  {   
      $(".clerance_department_id").each(function(index,value) {
          if($(this).is(':checked')==true) {
            $('#clerance_department_user_id'+$(this).val()).removeAttr('disabled');
           // $('.clearance_department_remarks'+$(this).val()).removeAttr('disabled');
          }
          else {
            $('#clerance_department_user_id'+$(this).val()).val('');
            $('#clerance_department_user_id'+$(this).val()).attr('disabled','disabled'); 
            $('.clearance_department_remarks'+$(this).val()).prop('disabled','disabled'); 
           }
      });

  });

  $('.submit').click(function()
  {
        var next_step=$(this).attr('data-next-step');
        var current_step=$(this).attr('data-current-step');   
        tab1_validation(next_step,current_step);
  }); 

function tab1_validation(next_step,current_step)
{
    $('input, select, textarea').each(function() {
        $(this).removeClass('error');
    });

    $('#job_form').removeData('validator'); 

    var clearance_department_id_flag= Boolean($('#clearance_department_required').val());

    console.log('Is Height Work ',$('#checkpoints3').is(':disabled'))
    console.log('Is HeHotight Work ',$('#checkpoints4').is(':visible'))

    $("#job_form").validate({ 
          ignore: '.ignore',
          focusInvalid: true, 
          errorClass: 'error is-invalid',
          validClass: 'is-valid',
          debug:true,
          rules: {        
            permit_for:{required:<?php echo $flag; ?>},
            zone_id : {required:<?php echo $flag; ?>},
            others_zone:{required:function(element) {
                              if($('#others_zone').is(':visible')==true) 
                              return true; 
                              else return false;
            }},
            contractor_id : {required:<?php echo $flag; ?>},
            "permit_type_ids[]": { required: true, minlength: 1 }, 
            job_name:{required:<?php echo $flag; ?>},
            location:{required:<?php echo $flag; ?>},
            acceptance_custodian_id:{required:<?php echo $flag; ?>},
            acceptance_issuing_id:{required:<?php echo $flag; ?>},
            is_loto:{required:<?php echo $flag; ?>},
            notes:{required:function(element) {
                              if($('#notes').is(':visible')==true) 
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
           
              form_submit('submit');
              console.log('Form 1 Success')
              return false;
          }
    });



    //Precautions
    var pre_arr=new Array('checklists','ppes');

    for (i = 0; i < pre_arr.length; i++) 
    {
          var field_name=pre_arr[i];
          
          var alpha_vals='';


        //Appling Validating only to visible permit types
        if($('.'+field_name).is(':visible')==true)
        {
            $("."+field_name).each(function ()
            { 
                var name = $(this).attr('name')
                
                $("input[name*='"+name+"']").rules("add", "required");    
            });
        }
    }
    

    if($('.job_status').length > 0)
    {
      $("input[name*='approval_status']").rules("add", "required");   
    }

    if($('.tryout_done').length > 0)
    {
      $("input[name*='tryout_done']").rules("add", "required");   
    }
    

    if($('.loto_sections').is(':visible')==true)
    {
      var elem = $(".equipment_tag_no");
      var count=0;
      $(".equipment_tag_no").each(function() {
        
          if($(this).val()=='')
          { console.log('Failed'); count++; }

          console.log('EQ Value '+$(this).val()+' = '+count);
      });

      var tbllength= $('#isolation_table tbody').find('tr').length;
      
      console.log('tbllengthtbllength ',tbllength)
      console.log('Countd ',count+' = '+elem.length)
      
      if (count == elem.length) {

        console.log('1st row validation');

        var j=1;

        var name = 'equipment_descriptions[1]';
        
          var fieldsarr=new Array('equipment_tag_no','equipment_descriptions_name','equipment_tag_nos','isolate_type','isolated_tagno1','isolated_tagno3','isolated_name','eq_given_local','isolated_user_ids');

          for(i=1;i<=1;i++)
          {
              //var val = $.trim($('.equipment_descriptions'+i).val());
              var val = $.trim($('.eq_given_local'+i+' :selected').val());

              console.log('tbllengthtbllength Val ',val+' = '+i);

              console.log('Text '+$('.eq_given_local'+i+' :selected').val());
                
              console.log('Desc Not empty ',val+' = '+i)
              
              for (j = 0; j<fieldsarr.length; j++) 
              {
                var field_name=fieldsarr[j]+'['+i+']'; 

                  if($('.'+fieldsarr[j]+''+i).length>0 && $('.'+fieldsarr[j]+''+i).is(':visible')==true) { 
                      $('.'+fieldsarr[j]+''+i).rules("add", "required");   
                      $("input[name*='"+field_name+"']").rules("add", "required");  
                  } 
                
              } 
             
          }
        

          if($('.equipment_descriptions_name1').length>0 && $('.equipment_descriptions_name1').is(':visible')==true) {
              console.log('1 condition');
              $('.equipment_descriptions_name1').rules("add", "required");   
          }
         

      } else {

        var fieldsarr=new Array('equipment_tag_no','equipment_descriptions_name','equipment_tag_nos','isolate_type','isolated_tagno1','isolated_tagno3');

        //'isolated_tagno2',,'isolated_user_ids'

          //,'isolated_ia_name','isolated_user_ids'
          //'equipment_descriptions',
     
          for(i=1;i<=tbllength;i++)
          {
              //var val = $.trim($('.equipment_descriptions'+i).val());
              var val = $.trim($('.eq_given_local'+i+' :selected').val());

              console.log('tbllengthtbllength Val ',val+' = '+i);

              console.log('Text '+$('.eq_given_local'+i+' :selected').val());

              if(val!='')
              {                   
                      console.log('Desc Not empty ',val+' = '+i)
                    for (j = 0; j<fieldsarr.length; j++) 
                    {
                      var field_name=fieldsarr[j]+'['+i+']';

                      //var field_name=fieldsarr[j];

                        console.log('field_namefield_name ','.'+fieldsarr[j]+''+i)
                       if($('.'+fieldsarr[j]+''+i).length>0 && $('.'+fieldsarr[j]+''+i).is(':visible')==true) { 
                           
                            $('.'+fieldsarr[j]+''+i).rules("add", "required");   
                            $("input[name*='"+field_name+"']").rules("add", "required");
                           
                       } 
                      
                    }
                   
              }
          }

      }
      
      if($('.loto_sections_approval').is(':visible')==true)
          $("input[name*='acceptance_loto_issuing_id']").rules("add", "required"); 
        
      if($('.re_energized').is(':visible')==true)
      {
          $('.re_energized:visible').each(function() {

            var row_id=$(this).attr('data-id');

            $('.re_energized'+row_id).rules("add", "required");  
            
          });
      }

    }

    //Loto IA Approval Checkbox
    if($('.loto_ia_checkox').prop('disabled')==false) {

      $('.loto_ia_checkox').filter(function () 
      {
            var row_id=$(this).attr('data-id');
            var field_name = 'loto_ia_checkox['+row_id+']';
            $('.loto_ia_checkox_input'+row_id).rules("add", "required");  
      });
    }

    if($('.pa_equip_identified').prop('disabled')==false) {

          $('.pa_equip_identified').filter(function () 
          {
                var row_id=$(this).attr('data-id');
                var field_name = 'loto_ia_checkox['+row_id+']';
                $('.pa_equip_identified_input'+row_id).rules("add", "required");  
          });
    }

    if($('.extends').length>0 && $('.extends').is(':visible')==true)
    {
          console.log('Extends Input Validation');

          var pre_arr=new Array('schedule_from_dates','schedule_to_dates','ext_performing_authorities','ext_issuing_authorities','ext_no_of_workers','ext_oxygen_readings','ext_gases_readings','ext_carbon_readings');

        for(e=1;e<=6;e++)
        {
            for (i = 0; i < pre_arr.length; i++) 
            {
              var field_name=pre_arr[i]+'['+e+']';

              console.log('Field Name ',field_name);

              $("input[name*='"+field_name+"']").rules("add", "required");   
              $("select[name*='"+field_name+"']").rules("add", "required");  

              if(pre_arr[i]=='ext_oxygen_readings')
              $("input[name*='"+field_name+"']").rules("add", {"required":true,"range":[19.25,23.5]});  
              else if(pre_arr[i]=='ext_gases_readings')
              $("input[name*='"+field_name+"']").rules("add", {"required":true,"range":[0,5]}); 
              else if(pre_arr[i]=='ext_carbon_readings')
              $("input[name*='"+field_name+"']").rules("add", {"required":true,"range":[0,25]});  

            }  
        }
    }

    if($('.loto_sections_completion').is(':visible')==true){

      console.log('Lotot Section Completion visisble')
       
        for(i=1;i<=5;i++)
        {
            var field_name = 'loto_closure_ids['+i+']';

          //  $('.loto_sections_completion_input_id'+i).rules("add", "required");

          //  console.log('FFFFFFFFFFFFFFFFFF ',"'"+field_name+"'");
           // $("'"+field_name+"'").rules("add", "required");   
            //$("input[name*='loto_closure_ids']").rules("add", "required");   
           
           // console.log('Invalie ',$(this).val());
           // console.log('Invalie 2222222222  ',$(this).attr('data-id'));
        }
    }

   // if($('.completion').length > 0)
    if($('.completion').is(':visible')==true)
    {
      $("input[name*='cancellation_issuing_id']").rules("add", "required");   
    }    
    
} 


var formaction=1;
function form_submit(submit_type)
{
  
  //alert('Parent;'); return  false;

  var pre_arr=new Array('checklists','ppes','permit_type_ids','permit_for','other_inputs','tryout_done','is_loto','done_isolation','keywithme_done','issuer_checklists','re_energized','additional_info','others_ppes');
  
      var data = new FormData();          
      var $inputs = $('form#job_form :input[type=text],form#job_form :input[type=hidden],select,textarea,form#job_form2 :input[type=text],form#job_form2 :input[type=hidden],form#job_form3 :input[type=text],form#job_form3 :input[type=hidden]');
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

      data.append('submit_type',submit_type);

      console.log('form action ',formaction);
      
      for (i = 0; i < pre_arr.length; i++) 
      {
            var field_name=pre_arr[i];
            
            var alpha_vals='';

            $("."+field_name+":checked").each(function ()
            {
              data.append(this.name,$(this).val());
            });
      }
      
     
      if($('input[name=status]').length>0)
      data.append('status',$('input[name=status]:checked').val());

       $(".submit").val("Processing...").attr('disabled',true);   
       $(".btn-danger").attr('disabled',true);   
      if(formaction==1)
      {
          formaction=2;
          $.ajax({
              url: base_url+'jobs/form_action',
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
                    window.location.href=base_url+'jobs/form/id/'+$('#id').val();
                  }
                  else
                  {
                    window.location.href='<?php echo $redirect;?>';
                  }              
              },
              error: function(data, textStatus,errorThrown)
              {

                  alert('Data Response '+data.responseText);
                  alert('Data Response '+data.textStatus);
                  alert('Data Response '+errorThrown);                  
                 // console.log('Error ',data.failure)
                 // $('#error').show();
                  
                 // $('#error_msg').html(data.failure);
              }
            });       

            $(".submit").val("Save");   
            $(".btn-danger").prop('disabled',false);   
      }
}

$.validator.setDefaults({ 
ignore: [],
});



$.validator.addMethod('minStrict', function (value, el, param) {
  return value > param;
}); 

$('body').on('click','.generate_pdf',function() {
    
    var print_id=$('#id').val();

    var url = $('.pdf_for:checked').attr('data-url');

    var pdf_type=$('.pdf_type:checked').val();
    
    var data = new FormData();			
    
    data.append('id',print_id);		

    data.append('pdf_type',pdf_type);

    $('#pdf_response').html("PDF generation process has been started. Please wait a min...");


      $.ajax({    
        "type" : "POST",
        "url" : base_url+url,	
        data:data,	
        processData: false,
        contentType: false,
        dataType:"json",
        success:function(data){

              var target='target="_blank"';

              <?php
              if($this->show_filter_form!='') { ?> target=''; <?php } ?>

          
              if(data?.status==1){
                  $('#pdf_response').html('<span style="color:green;"><a href="'+data?.file_path+'" '+target+'>Click Here</a> to download the PDF</span>');
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

$('body').on('click','.open_download_model',function() {
    $('#pdf_response').html('');
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
          
          alert('ERror Print out');
        }
      });		
    
  
});

<?php
if($permit_type_ids!='') {
    ?>
      //$('.permit_type_id').trigger('change');
      $('.permit_type_ids').trigger('change');
    <?php
    }

    if($extends_column>0){
      echo "check_extends(".$block_disable.");";
  }
?>
});


</script>
</body>
</html>

