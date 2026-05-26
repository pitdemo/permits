<?php 

error_reporting(0);

$system_current_date=$this->data['system_current_date'];

$page_name='Create Permit';

$readonly=false;

$status=$eip_opened='';

 $job_approval_status=unserialize(JOBAPPROVALS);

 if(!empty($records))
 {
     $page_name='Edit Permit';
   
   $record_id=$records['id'];
   
   $show_button=$records['show_button'];
   
   $acceptance_performing_id=$records['acceptance_performing_id'];
   
   $acceptance_issuing_id=$records['acceptance_issuing_id'];
   
   $status=$records['status'];
   
   $cancellation_performing_id=$records['cancellation_performing_id'];
   
   $cancellation_issuing_id=$records['cancellation_issuing_id'];
   
   if($show_button=='hide')
   $readonly=true;
 }
 else
 $record_id=''; 
 
 $jobs_isoloations_ids = array();
 
 $user_role=strtolower($this->session->userdata('user_role'));
 $this->load->view('layouts/admin_header',array('page_name'=>$page_name));
?>
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap.css" rel="stylesheet">

<style>
.watch_person_textbox {width: 70% !important;}
.add_remove_btn {margin-left: 20px !important;}
div.watch_person_div {
  display: -webkit-box !important;
}
#zone_id_label {padding-top: 18px !important;} /*swathi*/
#location_time_to_label {padding-top: 22px !important;} /*swathi*/
table.form_work tr td { padding:5px 5px 5px 5px; }
.radio_button { padding:0 2px 0px 2px; }
label.error { display:none; }
.float_right { float:right; padding-right:5px; }
label.error { display:none !important; }

input[type=checkbox].box_big {
    transform: scale(3);
    -ms-transform: scale(2);
    -webkit-transform: scale(2);
    padding: 10px;
}
#TB_window { margin-top:-300px !important; z-index:1000 !important; }

.authority { width:170px; }

input { 
    text-transform: uppercase;
}
input[type="text"][disabled],select[disabled] {
   color: black;
}
.form-control.select2-container, .select2-offscreen { width:250px !important; }
.select2-container.select2-container-multi.form-control.selected_eip.error { border-color:red; }
.text_bold { font-weight:bold; text-align:left; word-break: break-all; }

      .table-inner-td{
      border-right:1px solid #000 !important;
      border-bottom:1px solid #000;
      height:30px;
      padding:10px !important;
      }
      .border-bottom{
      border-bottom:1px solid #000 !important;
      }
table.tr_heights td { line-height:20px !important; }      

td .form-control { margin:0px 0px 5px 0px; max-width:370px; }
.title { font-size:14px; font-weight:bold; }
td.form_work { padding-left:3px; }

.select2-container.select2-container-multi.form-control.selected_eip.error { border-color:red; }
span.error{
    outline: none;
    border: 1px solid #800000;
    box-shadow: 0 0 5px 1px #800000;
  }
  #person_name-error { padding-left: 20px; }
</style>
<!-- start: Content -->
 <a class="thickbox" href="<?php echo base_url(); ?>jobs/ajax_show_energy_info/?TB_iframe=true&keepThis=true&width=1050" id="energy_form" title=" Energy Isolation Permit Form" style="visibility:hidden;">Thickbox</a>
<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content"> 
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>confined_permits"><i class="fa fa-home"></i>Confined Permits</a></li>
                                <li class="active"><?php echo (isset($records['id'])) ? 'Edit' : 'New'.' Permit'; ?></li></ul>
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <!--progress bar start-->
                                    <section class="panel">
                                        
                                        <div class="panel-body">
  <?php
  if($job_status_error_msg!='')
  {
  ?>  
        <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><?php echo $job_status_error_msg; ?></strong> 
       </div>
     <?php
  }
  ?>
           
    <form id="job_form" name="job_form" enctype="multipart/form-data" > 
        <input type="hidden" id="id" name="id" value="<?php echo (isset($records['id'])) ? $records['id'] : ''; ?>" />
        <input type="hidden" id="permit_no" name="permit_no" value="<?php echo (isset($records['permit_no'])) ? $records['permit_no'] : $permit_no ?>" />
                                                    
            <?php
            if(!empty($record_id))
            {
              if($readonly==false)
              $st='visibility:hidden;';
              else
              $st='';
            ?>  
                        <a href="javascript:void(0);" style="float:right;<?php echo $st; ?>" data-id="<?php echo $record_id; ?>" class="print_out"><i class="fa fa-print">Print PDF</i></a>
                        <?php
            }
            ?>                                                    
   <table cellspacing="0" border="0" width="100%" align="center" class="form_work">
             <tr height=36 style='height:27.0pt'>
                            <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=3 height="30" align="left" width="500px" valign=top><b>Select Department </b>
                              <input type="hidden" name="department_id" id="department_id" value="<?php echo $department['id']; ?>" />
                              <br /><?php echo $department['name']; ?>
                              <br /></td>

                            <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=3 height="30" align="left" width="500px" valign=top><b>Zone</b>
                              <select class="form-control" name="zone_id" id="zone_id" style="width:200px;">
                                <option value="">- - Select Zone - - </option>
                                <?php   
                  $zone_name='';
                  $select_zone_id=(isset($records['zone_id'])) ? $records['zone_id'] : '';        
                  if($zones->num_rows()>0)
                      {
                     $zones=$zones->result_array();

                                        foreach($zones as $list){
                      
                      ?>
                                <option value="<?php echo $list['id'];?>" <?php if($select_zone_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php }} ?>
                              </select></td>
                             
                               <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;padding-right:5px;" colspan=15 height="30" align="right" width="500px" valign=top><b>Permit No</b><br />#<span id="permit_no"><?php echo (isset($records['permit_no'])) ? $records['permit_no'] : $permit_no; ?></span></td>
                          </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 height="30" align="left" class="title" width="500px" valign=top>Location <br /><input type="text" class="form-control" name="location" id="location" value="<?php echo (isset($records['location'])) ? $records['location'] : ''; ?>"  /></td>
   
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;" valign="middle" colspan=5  class="title" width="500" align="left" valign=top><b>Hazards / concerns  Identified:</b></td>
    <td width="92" align="left"  style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" class="title" valign="middle"><center>YES/NO</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6  class="title"  valign="middle">Precautions  to  be  Taken:</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;width:200px;" colspan=2 align="left"  class="title" valign="middle"><center>YES  /NA</center></td>
  </tr>
  
  <tr>
    <td style="border-top: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=3 height="37" align="left" valign=top><b>Date From </b><br><input type="text" readonly="readonly" class="form-control" name="location_time_start" id="location_time_start" style="width:175px;" value="<?php echo (isset($records['location_time_start'])) ? $records['location_time_start'] : $system_current_date; ?>" />      </td>
  
    <td style="border-top: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=3 align="left" valign=top><b>Date To </b><br><input type="text" readonly="readonly" class="form-control" name="location_time_to" id="location_time_to" style="width:175px;" value="<?php echo (isset($records['location_time_to'])) ? $records['location_time_to'] : date('d-m-Y H:i',strtotime($system_current_date."+26 hours")); ?>" />      </td>

 
 <?php
 if(isset($records))
 $hazards=json_decode($records['hazards']);
 else
 $hazards=array();
 
 if(isset($records))
 $hazards_options=json_decode($records['hazards_options']);
 else
 $hazards_options=array();
 
 if(isset($records))
 $precautions=json_decode($records['precautions']);
 else
 $precautions=array();

 if(isset($records))
 $precautions_text=json_decode($records['precautions_text']);
 else
 $precautions_text=array();

 
 if(isset($records))
 $precautions_options=json_decode($records['precautions_options']);
 else
 $precautions_options=array();
 
  

              $haz_options=array(); $pre_options=array();
              if(isset($hazards_options->a))
              {
                $haz_options=explode('|',rtrim($hazards_options->a,'|')); 
              }
              
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->a) && $hazards->a=='Yes')
              $pre_text_disabled='';
            
?> 
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>a) UnSafe  access  to  work  area</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top> <center>
                            <input name="hazards[a]" data-attr="a" data-checkbox='true' <?php if(isset($hazards->a) && $hazards->a=='Yes') { ?> checked="checked" <?php } ?> type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[a]" class="radio_button hazards" value="No" data-attr="a" data-checkbox='true' <?php if(isset($hazards->a) && $hazards->a=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>a) Safe access and egress provided</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;width:140px;" colspan=2 align="left" valign=top ><center>
                    <input data-attr="a" name="precautions[a]"  <?php if(isset($precautions->a) && $precautions->a=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="a" type="radio" <?php if(isset($precautions->a) && $precautions->a=='N/A') { ?> checked="checked" <?php } ?> name="precautions[a]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center> </td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 rowspan=9 height="270" align="left" valign=top class="title"> Description  of  Job:<br><input type="text" class="form-control" name="job_name" id="job_name" value="<?php echo (isset($records['job_name'])) ? $records['job_name'] : ''; ?>"/><br>  Equipment  Name  &amp;  No<br><input  value="<?php echo (isset($records['equipment_name'])) ? $records['equipment_name'] : ''; ?>" type="text"  class="form-control" name="equipment_name" id="equipment_name" style="width:400px;" /> <br />Name  of  Contractor/DCBL:-<br>
    <select class="form-control" name="contractor_id" id="contractor_id" style="width:200px;">
                                <option value="">- - Select Contractor - - </option>
                                <?php   
                  $zone_name='';
                  $select_contractor_id=(isset($records['contractor_id'])) ? $records['contractor_id'] : '';        
                  if($contractors->num_rows()>0)
                      {
                     $contractors=$contractors->result_array();

                                        foreach($contractors as $list){
                      
                      ?>
                                <option value="<?php echo $list['id'];?>" <?php if($select_contractor_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php }} ?>
                                  <option value="others" <?php if($select_contractor_id=='others') { ?> selected="selected" <?php } ?>>Others</option>
                              </select> <br />
                              <?php $other_contractors=(isset($records['other_contractors'])) ? $records['other_contractors'] : ''; ?>
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="other_contractors" id="other_contractors" class="form-control" style="width:200px;margin-bottom:10px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  />

                              <?php $access_card=(isset($records['access_card'])) ? $records['access_card'] : ''; ?>


    Access  Card  Available <input type="radio" name="access_card" <?php if($access_card=='Yes') { ?> checked="checked" <?php } ?>class="radio_button" value="Yes" />Yes&nbsp;<input type="radio" name="access_card" class="radio_button" value="No" <?php if($access_card=='No') { ?> checked="checked" <?php } ?>/>No. <br><br>

<?php
              $jobs_isoloations_ids=array();
              
              $eip_disabled='';
              
              if($isoloation_permit_no!='')
              {
                if($isoloation_permit_no->num_rows()>0)
                {
                  $fets_permits=$isoloation_permit_no->result_array();
                    
                  $jobs_isoloations_ids=array_column($fets_permits,'jobs_isoloations_id');
                }
              } 

  $no_active=$na_active=$yes_active=$yes_existing_active='';
  if(isset($records))
  {
    $is_isoloation_permit=(isset($records['is_isoloation_permit'])) ? $records['is_isoloation_permit'] : '';
    
    if($is_isoloation_permit=='Existing') 
    $no_active='checked';
    else if($is_isoloation_permit=='N/A')
    $na_active='checked';
    else if($is_isoloation_permit=='Yes')
    $yes_active='checked';
    else
    {
      $yes_existing_active='checked'; $no_active=' ';
    }
  }
  else
  $na_active='checked';               
?>              
                              <p><b>Is EIP obtained:</b></p>
                               <input type="radio" name="is_isoloation_permit" class="radio_button on_off" data-relate='' <?php echo $yes_active; ?> value="Yes"/>
                              Yes
                              &nbsp; <input type="radio" name="is_isoloation_permit" class="radio_button on_off" data-relate='' <?php echo $yes_existing_active; ?> value="yes_existing"/>
                              Yes & Existing
                              &nbsp;
                              <input name="is_isoloation_permit" <?php echo $no_active; ?> type="radio" value="Existing" class="radio_button on_off" data-relate='isoloation'/>
                              Existing&nbsp;
                              <input name="is_isoloation_permit" value="N/A" <?php echo $na_active; ?> type="radio" class="radio_button on_off" data-relate='isoloation' />
                              N/A

                              <p>&nbsp;</p>

                  <p><b>If yes Energy Isolation Permit No:</b> &nbsp;
                           
                              <select class="form-control selected_eip select2-offscreen" multiple name="isoloation_permit_no" id="isoloation_permit_no" <?php if($no_active=='') { ?> disabled="disabled" <?php } ?>>
                              <?php
                if($eips->num_rows()>0)
                {
                  $fet_eips=$eips->result_array();
                  
                  foreach($fet_eips as $fet_eip)
                  {
                    $eip_id=$fet_eip['id'];
                    
                    $eip_section=$fet_eip['section'];
                    
                    $eip_status=$fet_eip['status'];
                    
                    if(array_search($eip_id,$jobs_isoloations_ids)!==FALSE)
                    {
                      $chk="selected='selected'";
                    
                    if($eip_status==STATUS_OPENED)
                    $eip_opened++;
                    }
                    else
                    $chk='';
                    
                ?>
                                <option value="<?php echo $eip_id; ?>" <?php echo $chk; ?>><?php echo $eip_section.'(#'.$eip_id.')'; ?></option>
                               <?php
                  }
                }
                ?>
                              </select>   

                                  </p>

    <br />Attach  list  if  more  persons are  involved</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>b) Oxygen  deficient  atmosphere</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>

                            <input name="hazards[b]" data-attr="b" data-checkbox='true'  checked="checked"  type="radio" disabled="disabled"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" disabled="disabled" name="hazards[b]" class="radio_button hazards" value="No" data-attr="b" data-checkbox='true'  />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>b)  Gas  monitoring  test  Carried  out</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="b" name="precautions[b]" checked="checked" value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="b" type="radio"  name="precautions[b]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>c) Ignition  of  Flammables</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input name="hazards[c]" data-attr="c" data-checkbox='true' <?php if(isset($hazards->c) && $hazards->c=='Yes') { ?> checked="checked" <?php } ?> type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[c]" class="radio_button hazards" value="No" data-attr="c" data-checkbox='true' <?php if(isset($hazards->c) && $hazards->c=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>c)  Space  free  of  Flamable/Combustible  Material</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="c" name="precautions[c]"  <?php if(isset($precautions->c) && $precautions->c=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="c" type="radio" <?php if(isset($precautions->c) && $precautions->c=='N/A') { ?> checked="checked" <?php } ?> name="precautions[c]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>d) Corrosives  or  Irritatives</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input name="hazards[d]" data-attr="d" data-checkbox='true' <?php if(isset($hazards->d) && $hazards->d=='Yes') { ?> checked="checked" <?php } ?> type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[d]" class="radio_button hazards" value="No" data-attr="d" data-checkbox='true' <?php if(isset($hazards->d) && $hazards->d=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>d) Use  of  appropriate  PPE</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="d" name="precautions[d]"  <?php if(isset($precautions->d) && $precautions->d=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="d" type="radio" <?php if(isset($precautions->d) && $precautions->d=='N/A') { ?> checked="checked" <?php } ?> name="precautions[d]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>e) Excessive  Temperature</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input name="hazards[e]" data-attr="e" data-checkbox='true' <?php if(isset($hazards->e) && $hazards->e=='Yes') { ?> checked="checked" <?php } ?> type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[e]" class="radio_button hazards" value="No" data-attr="e" data-checkbox='true' <?php if(isset($hazards->e) && $hazards->e=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>e) Eqpt.  Cooled/Forced  ventilation facilities  provided</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="e" name="precautions[e]"  <?php if(isset($precautions->e) && $precautions->e=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="e" type="radio" <?php if(isset($precautions->e) && $precautions->e=='N/A') { ?> checked="checked" <?php } ?> name="precautions[e]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>f)   Gas/Vapour  or  Fumes  produced by  operation</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input name="hazards[f]" data-attr="f" data-checkbox='true' <?php if(isset($hazards->f) && $hazards->f=='Yes') { ?> checked="checked" <?php } ?> type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[f]" class="radio_button hazards" value="No" data-attr="f" data-checkbox='true' <?php if(isset($hazards->f) && $hazards->f=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>f)  Forced  ventilation facilities  provided</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="f" name="precautions[f]"  <?php if(isset($precautions->f) && $precautions->f=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="f" type="radio" <?php if(isset($precautions->f) && $precautions->f=='N/A') { ?> checked="checked" <?php } ?> name="precautions[f]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>g)  Electrocution</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input name="hazards[g]" data-attr="g" data-checkbox='true' <?php if(isset($hazards->g) && $hazards->g=='Yes') { ?> checked="checked" <?php } ?> type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[g]" class="radio_button hazards" value="No" data-attr="g" data-checkbox='true' <?php if(isset($hazards->g) && $hazards->g=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>g) 24  volt  supply  provided  to  lights &amp;  equipment</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="g" name="precautions[g]"  <?php if(isset($precautions->g) && $precautions->g=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="g" type="radio" <?php if(isset($precautions->g) && $precautions->g=='N/A') { ?> checked="checked" <?php } ?> name="precautions[g]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>h) Moving  Machinery</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input name="hazards[h]" data-attr="h" data-checkbox='true' <?php if(isset($hazards->h) && $hazards->h=='Yes') { ?> checked="checked" <?php } ?> type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[h]" class="radio_button hazards" value="No" data-attr="h" data-checkbox='true' <?php if(isset($hazards->h) && $hazards->h=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>h) Hazardous  Energy  Isolation  ensured</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="h" name="precautions[h]"  <?php if(isset($precautions->h) && $precautions->h=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="h" type="radio" <?php if(isset($precautions->h) && $precautions->h=='N/A') { ?> checked="checked" <?php } ?> name="precautions[h]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>i)  Falling  Objects</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input name="hazards[i]" data-attr="i" data-checkbox='true' <?php if(isset($hazards->i) && $hazards->i=='Yes') { ?> checked="checked" <?php } ?> type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[i]" class="radio_button hazards" value="No" data-attr="i" data-checkbox='true' <?php if(isset($hazards->i) && $hazards->i=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>i)  loose  material  removed /barrier  provided</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="i" name="precautions[i]"  <?php if(isset($precautions->i) && $precautions->i=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="i" type="radio" <?php if(isset($precautions->i) && $precautions->i=='N/A') { ?> checked="checked" <?php } ?> name="precautions[i]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>j) Poor  Ventilation</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input name="hazards[j]" data-attr="j" data-checkbox='true' <?php if(isset($hazards->j) && $hazards->j=='Yes') { ?> checked="checked" <?php } ?> type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[j]" class="radio_button hazards" value="No" data-attr="j" data-checkbox='true' <?php if(isset($hazards->j) && $hazards->j=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>j)  Proper  ventillation facilities provided</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="j" name="precautions[j]"  <?php if(isset($precautions->j) && $precautions->j=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="j" type="radio" <?php if(isset($precautions->j) && $precautions->j=='N/A') { ?> checked="checked" <?php } ?> name="precautions[j]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 rowspan=11 height="313" align="left" valign=top>Watch Person Name        : 
    <input type="text" name="watch_person_name" id="watch_person_name" value="<?php echo (isset($records['watch_person_name'])) ? $records['watch_person_name'] : '';?>" class="form-control">
    <br>Name of the other person :<br>
   
 <div class="inc">

 <?php $watch_other_person_names = (isset($records['watch_other_person_names'])) ? json_decode($records['watch_other_person_names']) : 
 array(0=>'');   ?>
        
        <?php

        $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';

        for($wp=0;$wp<count($watch_other_person_names);$wp++)
        {
          $wp_name = (isset($watch_other_person_names[$wp])) ? $watch_other_person_names[$wp] : '';
        
        ?>
            <div class="controls watch_person_div">
                <input type="text" class="form-control watch_person_textbox" name="watch_other_person_names[]" value="<?php echo $wp_name; ?>"/> 
                <?php
                if($wp==0)
                {                 
                  if($approval_status<=3) {
                ?>
                  <button class="btn btn-info add_remove_btn" type="button" id="append" name="append">
                  Add</button>
                  <br>           
                <?php } } else if($approval_status<=3) { ?> <a href="javascript:void(0);" class="remove_this btn btn-danger add_remove_btn">Remove</a> <?php } ?>  
            </div>
        <?php } ?>    
      </div>



   </td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>k)  Poor  Illumination</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input name="hazards[k]" data-attr="k" data-checkbox='true' disabled="disabled"  checked="checked" type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[k]" class="radio_button hazards" value="No" data-attr="k" data-checkbox='true'   disabled="disabled" />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>k)  Adequate  Illumination  provided</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="k" name="precautions[k]"  checked="checked"  disabled="disabled" value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="k" type="radio"  disabled="disabled" name="precautions[k]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>l)Probability  of  Fire</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input name="hazards[l]" data-attr="l" data-checkbox='true' <?php if(isset($hazards->l) && $hazards->l=='Yes') { ?> checked="checked" <?php } ?> type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[l]" class="radio_button hazards" value="No" data-attr="l" data-checkbox='true' <?php if(isset($hazards->l) && $hazards->l=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>l) Fire Extinguishers availability ensured</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="l" name="precautions[l]"  <?php if(isset($precautions->l) && $precautions->l=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="l" type="radio" <?php if(isset($precautions->l) && $precautions->l=='N/A') { ?> checked="checked" <?php } ?> name="precautions[l]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=5 align="left" valign=top>m)Emergency  management /rescue</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input name="hazards[m]" data-attr="m" data-checkbox='true'  checked="checked" disabled="disabled"  type="radio"  class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[m]" class="radio_button hazards" value="No" data-attr="m" data-checkbox='true' disabled="disabled" />
                              N&nbsp;</center></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>m)  Trained  Watch  person  outside confined  space  Means  of communication  kept  ready(Phone/Rope)</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=top><center>
                    <input data-attr="m" name="precautions[m]" checked="checked" disabled="disabled"  value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="m" type="radio" disabled="disabled" name="precautions[m]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center></td>
  </tr>
  <tr >
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>n) Others <input type="text" name="hazards_other" id="hazards_other" class="form-control" width="100px" value="<?php echo (isset($records['hazards_other'])) ? $records['hazards_other'] : ''; ?>" /></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20" colspan=6 align="left" valign=top>n) Others <input type="text" class="form-control" name="precautions_other" id="precautions_other" width="100px" value="<?php echo (isset($records['precautions_other'])) ? $records['precautions_other'] : ''; ?>" /></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="center" valign=top><br></td>
  </tr>
 <?php
  if(isset($records))
  $required_ppe=explode(',',rtrim($records['required_ppe'],','));
  else
  $required_ppe=array();
  ?>  
   <tr>
   <td rowspan="2" colspan="14" style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-right: 1px solid #231f20;padding-left:5px;" >
   <span class="title">Required PPE</span>
   <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=35 class=xl76  colspan="3" style='height:26.25pt;border-top:none;
    width:111pt'>
                                    <input type="checkbox" name="required_ppe[]" class="required_ppe"  checked="checked" disabled="disabled" value="Helmet" />&nbsp; Helmet
                                  </td>
                                  <td height=35 class=xl76  colspan="3" style='height:26.25pt;border-top:none;
    width:111pt'>
                                    <input type="checkbox" name="required_ppe[]" class="required_ppe"  checked="checked" disabled="disabled" value="Safety Shoes" />&nbsp; Safety Shoes
                                  </td>
                                   <td height=35 class=xl76  colspan="3" style='height:26.25pt;border-top:none;
    width:111pt'>
                                    <input type="checkbox" disabled="disabled" name="required_ppe[]" class="required_ppe"   value="Eye Protection" checked="checked" />&nbsp; Eye Protection
                                  </td>
                                   <td height=35 class=xl76  colspan="3" style='height:26.25pt;border-top:none;
    width:111pt'>
                                    <input type="checkbox" name="required_ppe[]" class="required_ppe" value="Ear Protection" <?php if(in_array('Ear Protection',$required_ppe)) { ?> checked="checked" <?php } ?>/>&nbsp; Ear Protection
                                  </td>
                                   <td height=35 class=xl76  colspan="3" style='height:26.25pt;border-top:none;
    width:111pt'>
                                    <input type="checkbox" name="required_ppe[]" class="required_ppe" value="Hand Gloves" <?php if(in_array('Hand Gloves',$required_ppe)) { ?> checked="checked" <?php } ?>/>&nbsp; Hand Gloves
                                  </td>
                                </tr>

                                 <tr>
                                  <td height=35 class=xl76  colspan="3" style='height:26.25pt;border-top:none;
    width:111pt'>
                                    <input type="checkbox" name="required_ppe[]" class="required_ppe"  value="Full Body Harness" <?php if(in_array('Full Body Harness',$required_ppe)) { ?> checked="checked" <?php } ?>/>&nbsp; Full Body Harness
                                  </td>
                                  <td height=35 class=xl76  colspan="3" style='height:26.25pt;border-top:none;
    width:111pt'>
                                    <input type="checkbox" name="required_ppe[]" class="required_ppe"  value="Nose mask" <?php if(in_array('Nose mask',$required_ppe)) { ?> checked="checked" <?php } ?>/>&nbsp; Nose mask
                                  </td>
                                   <td height=35 class=xl76  colspan="3" style='height:26.25pt;border-top:none;
    width:111pt'>
                                    <input name="required_ppe[]" <?php if(in_array('Others',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" data-other='required_ppe_other' value="Others" type="checkbox" />&nbsp; Others
                                  </td>
                                   <td height=35 class=xl76  colspan="3" style='height:26.25pt;border-top:none;
    width:111pt'>
                                    <?php
     $required_ppe_other=(isset($records['required_ppe_other'])) ? $records['required_ppe_other'] : '';
    ?> 
    <input name="required_ppe_other" id="required_ppe_other" class="form-control" value="<?php echo $required_ppe_other; ?>" width="100px" type="text" <?php if(empty($required_ppe_other)) { ?> disabled="disabled" <?php } ?>>
                                  </td>
                                   <td height=35 class=xl76  colspan="3" style='height:26.25pt;border-top:none;
    width:111pt'>
                                    
                                  </td>
                                </tr>

                              </table>

   </td>
  </tr>
  <tr>
  </tr>
  <tr>
   
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 rowspan=9 align="left" valign=top><span class="title">Authorisation     &amp;     Acceptance:</span><br /> <span class="title">Performing  Authority:</span><br>I  have  had  permit  explained  I shall work  in  accordance  with  the  control measures  identified<br>
    <p><span style="float:left;">Name: <br />
                              
                                <select id="acceptance_performing_id" name="acceptance_performing_id"  class="form-control authority performing">
                                  <option value="" selected="selected">- - Select - -</option>
                                  <?php
  $acceptance_performing_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
            if($record_id=='')
          {
             if($id==$user_id)
             $flag=1;
             else
             $flag=0;
          }
          else
          $flag=1;
          
      if($flag==1)
      {
          if($acceptance_performing_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>
                                </span> <span style="float:right;">Digital Sign/Date & Time: <br />
                                  <input type="text" style="width:150px;" value="<?php echo (isset($records['acceptance_performing_date'])) ? $records['acceptance_performing_date'] : ''; ?>" id="acceptance_performing_date" name="acceptance_performing_date" class="form-control" readonly="readonly" />
                                </span></p>
                                  <span class="clearfix"></span>
                  <p><b>Issuing Authority: </b></p>
                              <p>I have ensured that each of the identified control measures is suitable and sufficient. The content of this permit has been explained to the
                                holder and work may proceed.</p>
                             
                              <p><span style="float:left;">Name: <br />
                              <?php
                $acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';
                ?>
                                <select id="acceptance_issuing_id" <?php if($acceptance_issuing_id=='') { ?>  disabled="disabled" <?php } ?> name="acceptance_issuing_id" class="form-control issuing authority">
                                  <option value="">- - Select - -</option>
                                  <?php
  
  if($issuing_authorities!='')
  {
    foreach($issuing_authorities as $fet)
    {    
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
            if($record_id=='')
          {
             if($id!=$user_id)
             $flag=1;
             else
             $flag=0;
          }
          else
          $flag=1;
          
      if($flag==1 && $acceptance_performing_id!=$id)
      {
          if($acceptance_issuing_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>
       </span> 
                <?php  

                $acceptance_issuing_date=(isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : ''; 
                
                $acceptance_issuing_approval=(isset($records['acceptance_issuing_approval'])) ? $records['acceptance_issuing_approval'] : ''; 
                
                $acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : ''; 
                
                if($acceptance_issuing_approval=='No' && $user_id==$acceptance_issuing_id)
                $acceptance_issuing_date=$system_current_date;
                
                if(!empty($acceptance_issuing_date))
                $acceptance_issuing_date=date('d-m-Y H:i',strtotime($acceptance_issuing_date));

                $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';

                 if($approval_status==13)
                $acceptance_issuing_date='';
                
                ?>
                                <span style="float:right;">Digital Sign/Date & Time:
                                  <input value="<?php echo $acceptance_issuing_date; ?>" type="text" id="acceptance_issuing_date" style="width:150px;" name="acceptance_issuing_date" class="form-control" readonly="readonly" />
                                </span></p>

  <span class="clearfix"></span>



                 

<p><span style="float:left;" class="title">Safety Sign: <br />
                <?php
                $acceptance_safety_sign_id=(isset($records['acceptance_safety_sign_id'])) ? $records['acceptance_safety_sign_id'] : '';
                ?>
    <select id="acceptance_safety_sign_id" <?php if($acceptance_safety_sign_id=='' || $acceptance_safety_sign_id==$user_id || $approval_status!=1) { ?>  disabled="disabled" <?php } ?> name="acceptance_safety_sign_id" class="form-control authority">
                                  <option value="">- - Select - -</option>
                                  <?php
  
  if($safety_authorities!='')
  {
    foreach($safety_authorities as $fet)
    {
    
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
          if($record_id=='')
          {
             if($id!=$user_id)
             $flag=1;
             else
             $flag=0;
          }
          else
          $flag=1;
          
      if($flag==1 && $acceptance_performing_id!=$id)
      {
          if($acceptance_safety_sign_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>
       </span> 
                
                <?php  

                $acceptance_safety_date=(isset($records['acceptance_safety_date'])) ? $records['acceptance_safety_date'] : ''; 
                
                $acceptance_safety_approval=(isset($records['acceptance_safety_approval'])) ? $records['acceptance_safety_approval'] : 'No'; 
                
                $acceptance_safety_id=(isset($records['acceptance_safety_sign_id'])) ? $records['acceptance_safety_sign_id'] : ''; 

                #echo 'SS   '.$acceptance_safety_approval.'  ==== '.$user_id.' = = '.$acceptance_safety_id;
                
                if($acceptance_safety_approval=='No' && $user_id==$acceptance_safety_id)
                $acceptance_safety_date=$system_current_date;
                
                if(!empty($acceptance_safety_date))
                $acceptance_safety_date=date('d-m-Y H:i',strtotime($acceptance_safety_date));

                $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';

                 if($approval_status==10)
                $acceptance_issuing_date='';
                
                ?>
                                <span style="float:right;">Digital Sign/Date & Time:
                                  <input value="<?php echo $acceptance_safety_date; ?>" type="text" id="acceptance_safety_date" style="width:150px;" name="acceptance_safety_date" class="form-control" readonly="readonly" />
                                </span></p>
                             </td>

<?php
               $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';
               
               $st=(isset($records['status'])) ? $records['status'] : '';


                
                $work_msg='<span id="change_status_label">Completion / Cancellation</span>';
                
                
                if($st=='Completion' || $st == 'Cancellation')
                $work_msg=$st;
                
               ?>                             
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=8 rowspan=9 align="left" valign=top><b>Work <?php echo $work_msg; ?></b><br /> <b>Performing  Authority:</b><br>Work  completed,  all  persons  are withdrawn  and  material  removed from  the  area<br>

<p><span style="float:left;">Name: <br />
 <?php 
    $cancellation_performing_id=(isset($records['cancellation_performing_id'])) ? $records['cancellation_performing_id'] : '';
 ?>                                
                               <select id="cancellation_performing_id"  disabled name="cancellation_performing_id"  class="form-control authority performing">
                                  <option value="" selected="selected">- - Select - -</option>
                                  <?php
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $flag=0;
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
             if($id==$user_id || $cancellation_performing_id==$id)
             $flag=1;
      if($flag==1)
      {
          if($cancellation_performing_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>
                                </span> <span style="float:right;">Digital Sign/Date & Time: <br />
                                  <input type="text" style="width:150px;" value="<?php echo (isset($records['cancellation_performing_date'])) ? $records['cancellation_performing_date'] : ''; ?>" id="cancellation_performing_date" name="cancellation_performing_date" class="form-control" readonly="readonly" />
                                </span></p>
                                  <span class="clearfix"></span>
                  <p><b>Issuing Authority: </b></p>
                              <p>I have ensured that each of the identified control measures is suitable and sufficient. The content of this permit has been explained to the
                                holder and work may proceed.</p>
<?php 
  $acceptance_issuing_approval=(isset($records['acceptance_issuing_approval'])) ? $records['acceptance_issuing_approval'] : '';
  $cancellation_issuing_id=(isset($records['cancellation_issuing_id'])) ? $records['cancellation_issuing_id'] : '';
?>                              
                              <p><span style="float:left;">Name: <br />
                                <select id="cancellation_issuing_id"  disabled="disabled" name="cancellation_issuing_id"  class="form-control authority issuing">
                                  <option value="">- - Select - -</option>
                                  <?php
  
  if($issuing_authorities!='')
  {
    foreach($issuing_authorities as $fet)
    {
      
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      $flag=0;
  
            if($record_id!=''  && $cancellation_issuing_id<=0)
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($cancellation_issuing_id>0)
          $flag=1;
          
          
      if($flag==1 && $cancellation_performing_id!=$id)
      {
          if($cancellation_issuing_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>
       </span> 
<?php  

$cancellation_issuing_approval=(isset($records['cancellation_issuing_approval'])) ? $records['cancellation_issuing_approval'] : 'No';
                
if($cancellation_issuing_approval=='No' && $user_id==$cancellation_issuing_id)
$cancellation_issuing_date=$system_current_date;
else 
$cancellation_issuing_date=(isset($records['cancellation_issuing_date'])) ? $records['cancellation_issuing_date'] : '';

if(!empty($cancellation_issuing_date))
$cancellation_issuing_date=date('d-m-Y H:i',strtotime($cancellation_issuing_date));                

#echo 'fF '.$cancellation_issuing_approval.' = '.$user_id.' == '.$cancellation_issuing_id.' = '.$cancellation_issuing_date;
?>
                                <span style="float:right;">Digital Sign/Date & Time:
                                  <input value="<?php echo $cancellation_issuing_date; ?>" type="text" id="cancellation_issuing_date" style="width:150px;" name="cancellation_issuing_date" class="form-control" readonly="readonly" />
                                </span></p>

    </td>
  </tr>
  <tr>
  </tr>
  <tr>
  </tr>
  <tr>
  </tr>
  <tr>
  </tr>

  <?php

    $disabled='';
    if($acceptance_safety_sign_id!=$user_id)
    $disabled = 'disabled=disabled';  
  ?>
  <tr>
    <td width="129" height="35"  align="left" valign=top style="border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20"><b><font face="Verdana" size=1>Test</font></b></td>
    <td style="border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=4 align="left" valign=top>Acceptable conditions</td>
    <td style="border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20"align="left" valign=top>Present Reading</td>
  </tr>


  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" height="35" align="left" valign=top>Oxygen</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=4 align="cener" valign=top><b>19.5  to  23.5  %</b></td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;padding-top:3px;"  align="left" valign=top><input type="text" class="form-control" name="oxygen_reading" id="oxygen_reading" value="<?php echo (isset($records['oxygen_reading'])) ? $records['oxygen_reading'] : ''; ?>" <?php echo $disabled; ?> /></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" height="35" align="left" valign=top>Combustible gases</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=4 align="center" valign=top sdval="0" sdnum="1033;0;0%">0%</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;padding-top:3px;"  align="left" valign=top><input type="text" class="form-control" name="gases_reading" id="gases_reading" value="<?php echo (isset($records['gases_reading'])) ? $records['gases_reading'] : ''; ?>" <?php echo $disabled; ?> /></td>
  </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" height="35" align="left" valign=top>Carbon Monoxide</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=4 align="center" valign=top>0-25  ppm</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;padding-top:3px;"align="left" valign=top><input type="text" class="form-control" name="carbon_reading" id="carbon_reading" value="<?php echo (isset($records['carbon_reading'])) ? $records['carbon_reading'] : ''; ?>" <?php echo $disabled; ?> /></td>
  </tr>

      <?php

      $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';

      if($approval_status==1)
      { $cls_span=13;
        $display_style = 'none';
      }  
      else
      { $display_style='block'; $cls_span=21; }

       $self_cancellation_description=(isset($records['self_cancellation_description'])) ? strtoupper($records['self_cancellation_description']) : '';

        if(!empty($record_id))
        {
            if($acceptance_performing_id==$user_id && ($approval_status==1 || $approval_status==13))
            {
               

      ?>
     <tr height=21 style='height:15.75pt'>
      <td height=21 class=xl83 width=831 style='height:15.75pt;width:111pt;border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;'><b>Status:</b><span
style='mso-spacerun:yes'>                   </span></td>
      
      <?php if($approval_status==1) { ?>
      <td colspan="5"><input type="radio" name="self_cancellation" id="self_cancellation" value="cancel" /> Self Cancellation&nbsp;&nbsp;</td> <?php } ?>
      <td colspan="<?php echo $cls_span; ?>" class=xl155 style='border-right:1.0pt solid black;
border-left:none;width:825pt'><span id="self_cancellation_section" style="display:<?php echo $display_style; ?>;">
<b>Reason for cancellation : </b><?php if($approval_status==1) { ?><input type="text" name="self_cancellation_description" id="self_cancellation_description" class="form-control" style="width:400px;"><?php } else { echo $self_cancellation_description; } ?></span>

</td>
    </tr>
    <?php
          }
          else if($approval_status==13)
          {
    ?>        
      <tr height=21 style='height:15.75pt'>
      <td height=21 class=xl83 width=831 style='height:15.75pt;width:111pt;border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;'><b>Reason for cancellation : </b><span
style='mso-spacerun:yes'>                   </span></td>
      <td colspan="19" class=xl155 style='height:15.75pt;width:111pt;border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;'>
<?php echo $self_cancellation_description; ?>

</td>
    </tr>

    <?php
          }
    }

       if($readonly===true)
       {
       ?>                 
            <tr height=41 style='height:15.75pt'>
              <td height=41 class=xl83 width=148 style='height:15.75pt;width:111pt;border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;vertical-align: middle;'><b>Permit Status: </b><span
              style='mso-spacerun:yes'>                   </span></td>
              <td colspan=6 class=xl155 style='border-right:1.0pt solid black;
              border-left:none;'>
              <?php
              #$job_status=unserialize(JOB_STATUS);
        
        $job_status=array('open'=>'Open','cancel'=>'Cancellation','completion'=>'Completion','extended'=>'Extended');
              
              $status=(isset($records['status'])) ? $records['status'] : 'open';
        
         $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';
        
        $acceptance_performing_date=date('YMD',strtotime($records['acceptance_performing_date']));
        
        $time_diff=$records['time_diff'];
        
        $current_date=date('YMD');
                
        $s=0;
        
        $display_style='none';

                foreach($job_status as $key =>$label)
                {
                    if($status==$label)
                    $chk='checked="checked"';
                    else
                    $chk='';
          
          $hide=0;
          
          if($s==1)
          {
            #if($acceptance_performing_date!=$current_date || strtolower($status)!='open')
            
            if($time_diff>=PERMIT_CLOSE_AFTER)  # || strtolower($status)!='open'
            $hide=1;
            #else
            #$display_style='block';
          }
          else if($s==0)
          $hide=1;
          
          #$hide = 0; //Temp

          if($hide==0)
          echo '<input type="radio" class="status" name="status" '.$chk.' value="'.$label.'">&nbsp;'.$label.'&nbsp;';
          
          $s++;
                }
          $self_cancellation_description=(isset($records['self_cancellation_description'])) ? $records['self_cancellation_description'] : '';
            
            if($self_cancellation_description!='')
            $display_style='block';
            
            ?>  
              </td> 
              <td colspan="16" style='height:15.75pt;width:111pt;border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20;'><span id="self_cancellation_section" style="display:<?php echo $display_style; ?>;">Reason for cancellation <br /> <input type="text" value="<?php echo $self_cancellation_description; ?>" name="self_cancellation_description" id="self_cancellation_description" class="form-control" style="width:400px;"></span></td>
              
             </tr>
          <?php 
       }
       ?>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=22 height="29" align="left" valign=top>7)Revalidation<br>I  have  visited  the  work  area  and  checked  the  oxygen  level,  found  it  well  within  the  requirement  of  this  permit  and  the  readings  are  as  follows  :</td>
  </tr>

  </table>
  <?php

     if(isset($records))
     $schedule_date=json_decode($records['schedule_date']);
     else
     $schedule_date=array();
   
     if(isset($records))
     $extended_time_period=json_decode($records['extended_time_period']);
     else
     $extended_time_period=array();    

     if(isset($records))
     {
        $extended_ia_from_approval_status=json_decode($records['extended_issuing_from_approval_status']);

        $extended_ia_to_approval_status=json_decode($records['extended_issuing_to_approval_status']);

        $extended_sa_from_approval_status=json_decode($records['extended_safety_from_approval_status']);

        $extended_sa_to_approval_status=json_decode($records['extended_safety_to_approval_status']);

     }
     else
     $extended_ia_from_approval_status=$extended_ia_to_approval_status = $extended_sa_from_approval_status = $extended_sa_to_approval_status = array();
   
    #echo '<pre>'; print_r($extended_sa_from_approval_status);
   
   
   $sch_date_a=(isset($schedule_date->a)) ? $schedule_date->a : '';
    
   if($sch_date_a!='')  
   $diff=$this->public_model->datetime_diff(array('start_date'=>$system_current_date,'end_date'=>$sch_date_a));
   else
   $diff=$this->public_model->datetime_diff(array('start_date'=>$system_current_date,'end_date'=>$acceptance_issuing_date));
     
   $diff_days=$diff['days'];
   
   $ext_ia_app_status=(isset($extended_ia_to_approval_status->a)) ? ucfirst($extended_ia_to_approval_status->a) : '';

   $ext_sa_app_status=(isset($extended_sa_to_approval_status->a)) ? ucfirst($extended_sa_to_approval_status->a) : '';

   if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
   $ia_app_status=APPROVED;
   else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
   $ia_app_status='';
   else 
   $ia_app_status=WAITING; 


    if($ia_app_status==WAITING)
    $disabled='disabled="disabled"';
    else
    $disabled='';



  ?>

  <table align="center" width="100%">
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" rowspan=2 height="43" align="left" valign=top>Time interval</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" valign=top><font face="Verdana" size=1>Date:</font><input type="text" value="<?php echo $sch_date_a; ?>" name="schedule_date[a]"  class="schedule_date form-control" id="schedule_date1" data-diff="<?php echo $diff_days; ?>" data-id="1" data-alpha-id="a" style="width: 107px;" data-ia-approval="<?php echo $ia_app_status; ?>" <?php echo $disabled; ?>/></td>

  <?php
    
     $extended_ranges=range('b','f');

     $er=2;

     foreach($extended_ranges as $extended_range)
     {

       $previous_char = chr(ord($extended_range)-1);

       $sch_date=(isset($schedule_date->$extended_range)) ? $schedule_date->$extended_range : '';

       $previous_sch_date = (isset($schedule_date->$previous_char)) ? $schedule_date->$previous_char : '';

       
        
       if($sch_date!='')  
       $diff=$this->public_model->datetime_diff(array('start_date'=>$system_current_date,'end_date'=>$sch_date));
       else 
       $diff=$this->public_model->datetime_diff(array('end_date'=>$previous_sch_date,'start_date'=>$system_current_date));      
       
      #$diff_days=($diff['days']==0) ? $diff['days']+1 : $diff['days'];
      $diff_days=$diff['days'];

      #echo '<br /> Previous Days  '.$previous_sch_date.' = '.$diff_days.' = '.$diff['days'];

       $ext_time_period=(isset($extended_time_period->$extended_range)) ? strtolower($extended_time_period->$extended_range) : '';  
       

       if($ext_time_period=='to')
       {
          $ext_ia_app_status=(isset($extended_ia_to_approval_status->$extended_range)) ? ucfirst($extended_ia_to_approval_status->$extended_range) : '';

          $ext_sa_app_status=(isset($extended_sa_to_approval_status->$extended_range)) ? ucfirst($extended_sa_to_approval_status->$extended_range) : '';
       }
       else
       {
          $ext_ia_app_status=(isset($extended_ia_from_approval_status->$extended_range)) ? ucfirst($extended_ia_from_approval_status->$extended_range) : '';

          $ext_sa_app_status=(isset($extended_sa_from_approval_status->$extended_range)) ? ucfirst($extended_sa_from_approval_status->$extended_range) : '';

       }   

       if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
       $ia_app_status=APPROVED;
       else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
       $ia_app_status='';
       else 
       $ia_app_status=WAITING;     
    
  ?>                               
    <td style="padding-left:5px; border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=3 align="left" valign=top><font face="Verdana" size=1>Date:</font><input type="text" value="<?php echo $sch_date; ?>" name="schedule_date[<?php echo $extended_range; ?>]"  class="schedule_date form-control" style="width: 107px;" data-alpha-id="<?php echo $extended_range; ?>" id="schedule_date<?php echo $er; ?>" data-id="<?php echo $er; ?>" data-diff="<?php echo $diff_days; ?>" data-ia-approval="<?php echo $ia_app_status; ?>" /></td>
    <?php
      $er++;
   }

   ?>
  </tr>
<?php
     if(isset($records))
     $schedule_from_time=json_decode($records['schedule_from_time']);
     else
     $schedule_from_time=array();
 
     if(isset($records))
     $schedule_to_time=json_decode($records['schedule_to_time']);
     else
     $schedule_to_time=array();
    

    $default_from_time = '09:00';

    $default_to_time = '18:00';

    $ext_time_period=(isset($extended_time_period->a)) ? strtolower($extended_time_period->a) : '';  

       
       $ext_ia_app_status=(isset($extended_ia_to_approval_status->a)) ? ucfirst($extended_ia_to_approval_status->a) : '';

       $ext_sa_app_status=(isset($extended_sa_to_approval_status->a)) ? ucfirst($extended_sa_to_approval_status->a) : '';
      
      
       if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
       $ia_app_status=APPROVED;
       else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
       $ia_app_status='';
       else 
       $ia_app_status=WAITING;     
    ?>  
  <tr>
    <td style="padding:3px 3px 0px 3px;border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="center" valign=top><font face="Verdana" size=1><?php echo generate_time(array('class'=>'schedule_to_time schedule_time schedule_to1','name'=>'schedule_to_time[a]','selected_value'=>(isset($schedule_to_time->a)) ? $schedule_to_time->a : '','default_time'=>$default_to_time,'data_time_field'=>'to','data_time_attr'=>'a','data_id'=>1,'data_ia_approval'=>$ia_app_status)); ?></font>
     <input type="hidden" name="extended_time_period[a]" id="extended_time_period[a]" class="extended_time_period1" value="<?php echo $ext_time_period; ?>" />   
    </td>

    <?php
      $er=2;
      foreach($extended_ranges as $extended_range)
      {

        $ext_time_period = (isset($extended_time_period->$extended_range)) ? strtolower($extended_time_period->$extended_range) : ''; 

          $ext_ia_app_status=$ext_sa_app_status='';

         if($ext_time_period=='from')         
         {
            $ext_ia_app_status=(isset($extended_ia_from_approval_status->$extended_range)) ? ucfirst($extended_ia_from_approval_status->$extended_range) : '';

            $ext_sa_app_status=(isset($extended_sa_from_approval_status->$extended_range)) ? ucfirst($extended_sa_from_approval_status->$extended_range) : '';

         }   

         #echo '<br /> DD '.$ext_ia_app_status.' = '.$ext_sa_app_status;

         if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
         $ia_app_status=APPROVED;
         else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
         $ia_app_status='';
         else 
         $ia_app_status=WAITING;           
 
    ?>    
    <td style="padding:3px 3px 0px 3px;border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" ><font face="Verdana" size=1><?php echo generate_time(array('class'=>'schedule_from_time schedule_time schedule_from'.$er,'name'=>'schedule_from_time['.$extended_range.']','selected_value'=>(isset($schedule_from_time->$extended_range)) ? $schedule_from_time->$extended_range : '','default_time'=>$default_from_time,'data_time_field'=>'from','data_time_attr'=>$extended_range,'data_id'=>$er,'data_ia_approval'=>$ia_app_status)); ?></font></td>
    <?php

      $ext_ia_app_status=$ext_sa_app_status='';

         if($ext_time_period=='to')        
        {
            $ext_ia_app_status=(isset($extended_ia_to_approval_status->$extended_range)) ? ucfirst($extended_ia_to_approval_status->$extended_range) : '';

            $ext_sa_app_status=(isset($extended_sa_to_approval_status->$extended_range)) ? ucfirst($extended_sa_to_approval_status->$extended_range) : '';
         }

         if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
         $ia_app_status=APPROVED;
         else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
         $ia_app_status='';
         else 
         $ia_app_status=WAITING;             
     ?>    
    <td width="103" align="left" style="padding:3px 3px 0px 3px;border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20"><font face="Verdana" size=1><?php echo generate_time(array('class'=>'schedule_to_time schedule_time schedule_to'.$er,'name'=>'schedule_to_time['.$extended_range.']','selected_value'=>(isset($schedule_to_time->$extended_range)) ? $schedule_to_time->$extended_range : '','default_time'=>$default_to_time,'data_time_field'=>'to','data_time_attr'=>$extended_range,'data_id'=>$er,'data_ia_approval'=>$ia_app_status)); ?></font></td>
    <input type="hidden" name="extended_time_period[<?php echo $extended_range; ?>]" id="extended_time_period[<?php echo $extended_range; ?>]" class="extended_time_period<?php echo $er; ?>" value="<?php echo $ext_time_period; ?>" />   
    <?php 
        $er++;
      }
    ?>  
  </tr>

<?php
     if(isset($records))
     $watch_person_from_time=json_decode($records['watch_person_from_time']);
     else
     $watch_person_from_time=array();
 
     if(isset($records))
     $watch_person_to_time=json_decode($records['watch_person_to_time']);
     else
     $watch_person_to_time=array();
      
     $ext_ia_app_status=(isset($extended_ia_to_approval_status->a)) ? ucfirst($extended_ia_to_approval_status->a) : '';

     $ext_sa_app_status=(isset($extended_sa_to_approval_status->a)) ? ucfirst($extended_sa_to_approval_status->a) : '';
     
      

       if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
       $ia_app_status=APPROVED;
       else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
       $ia_app_status='';
       else 
       $ia_app_status=WAITING;     

       
    ?>  
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" height="27" align="left" valign=top>Watch  Person Name:</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="left" ><input type="text" value="<?php echo (isset($watch_person_to_time->a)) ? $watch_person_to_time->a : ''; ?>" name="watch_person_to_time[a]" data-id="1" data-ia-approval="<?php echo $ia_app_status; ?>" class="watch_person_to_time form-control watch_person_to1" style="width: 107px;" /></td>
    <?php
      $er=2;
      foreach($extended_ranges as $extended_range)
      {

          $ext_time_period = (isset($extended_time_period->$extended_range)) ? strtolower($extended_time_period->$extended_range) : ''; 

          $ext_ia_app_status=$ext_sa_app_status='';

         if($ext_time_period=='from')         
         {
            $ext_ia_app_status=(isset($extended_ia_from_approval_status->$extended_range)) ? ucfirst($extended_ia_from_approval_status->$extended_range) : '';

            $ext_sa_app_status=(isset($extended_sa_from_approval_status->$extended_range)) ? ucfirst($extended_sa_from_approval_status->$extended_range) : '';

         }   

         if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
         $ia_app_status=APPROVED;
         else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
         $ia_app_status='';
         else 
         $ia_app_status=WAITING;                   
    ?>    

    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" >
    <input type="text" value="<?php echo (isset($watch_person_from_time->$extended_range)) ? $watch_person_from_time->$extended_range : ''; ?>" name="watch_person_from_time[<?php echo $extended_range; ?>]"  class="watch_person_from_time form-control watch_person_from<?php echo $er; ?>" data-id="<?php echo $extended_range; ?>" data-ia-approval="<?php echo $ia_app_status; ?>" style="width: 107px;" />
    </td>
    <?php

        $ext_ia_app_status=$ext_sa_app_status='';

        if($ext_time_period=='to')        
        {
            $ext_ia_app_status=(isset($extended_ia_to_approval_status->$extended_range)) ? ucfirst($extended_ia_to_approval_status->$extended_range) : '';

            $ext_sa_app_status=(isset($extended_sa_to_approval_status->$extended_range)) ? ucfirst($extended_sa_to_approval_status->$extended_range) : '';
         }
         

        if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
         $ia_app_status=APPROVED;
         else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
         $ia_app_status='';
         else 
         $ia_app_status=WAITING;              
         
     ?>    
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" >
    <input type="text" value="<?php echo (isset($watch_person_to_time->$extended_range)) ? $watch_person_to_time->$extended_range : ''; ?>" name="watch_person_to_time[<?php echo $extended_range; ?>]"  class="watch_person_to_time form-control watch_person_to<?php echo $er; ?>" style="width: 107px;" data-id="<?php echo $extended_range; ?>" data-ia-approval="<?php echo $ia_app_status; ?>"/>
    </td>
    <?php
      $er++;
    }
    ?>
      </tr>
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" height="19" align="left">Sl.  No</td>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=21 align="left" valign=top>Name  of  personne  involved  in  the  confined  space  work  :</td>
  </tr>
  <?php

     if(isset($records))
     $watch_other_person_from_names=json_decode($records['watch_other_person_from_names'],true);
     else
     $watch_other_person_from_names=array();
 
     if(isset($records))
     $watch_other_person_to_names=json_decode($records['watch_other_person_to_names'],true);
     else
     $watch_other_person_to_names=array();

     $r=1;

     $n=1;
  
     $ext_ia_app_status=(isset($extended_ia_to_approval_status->a)) ? ucfirst($extended_ia_to_approval_status->a) : '';

     $ext_sa_app_status=(isset($extended_sa_to_approval_status->a)) ? ucfirst($extended_sa_to_approval_status->a) : '';    
      

       if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
       $ia_app_status=APPROVED;
       else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
       $ia_app_status='';
       else 
       $ia_app_status=WAITING;     

    # echo '<pre>'; print_r($watch_other_person_from_names); 


    for($i=1;$i<=10;$i++)
    {

        #$dz=(isset($watch_other_person_to_names['a'][$i])) ? strtolower($watch_other_person_to_names['a'][$i]) : '';

  ?>    
    
  <tr>
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" height="17" align="left" valign=middle sdval="7" sdnum="1033;"><center><?php echo $i; ?></center></td>
    <td style="padding-top:3px; border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6 align="center" valign=middle><input type="text" class="form-control watch_other_person_to_names watch_other_person_to<?php echo $r; ?>" name="watch_other_person_to_names[a][<?php echo $i; ?>]" value="<?php echo (isset($watch_other_person_to_names['a'][$i])) ? $watch_other_person_to_names['a'][$i] : ''; ?>" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
        <?php
          $er=2; 
          foreach($extended_ranges as $extended_range)
          {


             $ext_time_period = (isset($extended_time_period->$extended_range)) ? strtolower($extended_time_period->$extended_range) : ''; 

              $ext_ia_app_status=$ext_sa_app_status='';
                 if($ext_time_period=='from')
                {
                    $ext_ia_app_status=(isset($extended_ia_from_approval_status->$extended_range)) ? ucfirst($extended_ia_from_approval_status->$extended_range) : '';

                    $ext_sa_app_status=(isset($extended_sa_from_approval_status->$extended_range)) ? ucfirst($extended_sa_from_approval_status->$extended_range) : '';

                 }   

                 if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
                 $ia_app_status=APPROVED;
                 else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
                 $ia_app_status='';
                 else 
                 $ia_app_status=WAITING;                       
                $r++;
        ?>    
    <td style="padding-top:3px; border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 align="left" valign=middle>
      <input type="text" class="form-control watch_other_person_from_names  watch_other_person_from<?php echo $er; ?>" name="watch_other_person_from_names[<?php echo $extended_range; ?>][<?php echo $i; ?>]"  value="<?php echo (isset($watch_other_person_from_names[$extended_range][$i])) ? strtolower($watch_other_person_from_names[$extended_range][$i]) : ''; ?>" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
      <?php


        $ext_ia_app_status=$ext_sa_app_status='';

        if($ext_time_period=='to')        
        {
            $ext_ia_app_status=(isset($extended_ia_to_approval_status->$extended_range)) ? ucfirst($extended_ia_to_approval_status->$extended_range) : '';

            $ext_sa_app_status=(isset($extended_sa_to_approval_status->$extended_range)) ? ucfirst($extended_sa_to_approval_status->$extended_range) : '';
         }
       
        if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
         $ia_app_status=APPROVED;
         else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
         $ia_app_status='';
         else 
         $ia_app_status=WAITING;           

         ?>      

      <?php $r++; ?>
    <td style="padding-top:3px; border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" align="left" valign=middle><input type="text" class="form-control watch_other_person_to_names   watch_other_person_to<?php echo $er; ?>" name="watch_other_person_to_names[<?php echo $extended_range; ?>][<?php echo $i; ?>]" value="<?php echo (isset($watch_other_person_to_names[$extended_range][$i])) ? strtolower($watch_other_person_to_names[$extended_range][$i]) : ''; ?>" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
        <?php
          $er++;
          }

          $r=1;
        ?>     
  </tr>

  <?php } 

       $extended_safety_from_approval_status = $extended_safety_to_approval_status = $extended_safety_to_sign_id=$extended_safety_from_sign_id=array();   

     if(isset($records))
     {
        $extended_to_oxygen_reading=json_decode($records['extended_to_oxygen_reading']);

        $extended_safety_from_approval_status=json_decode($records['extended_safety_from_approval_status']);

        $extended_safety_to_approval_status=json_decode($records['extended_safety_to_approval_status']);

        $extended_safety_to_sign_id=json_decode($records['extended_safety_to_sign_id']);

        $extended_safety_from_sign_id=json_decode($records['extended_safety_from_sign_id']);
     }   
     else
     $extended_to_oxygen_reading=array();
 
     if(isset($records))
     $extended_from_oxygen_reading=json_decode($records['extended_from_oxygen_reading']);
     else
     $extended_from_oxygen_reading=array();

    
     $safety_approval_status=(isset($extended_safety_to_approval_status->a)) ? $extended_safety_to_approval_status->a : '';

     $extended_safety_id=(isset($extended_safety_to_sign_id->a)) ? $extended_safety_to_sign_id->a : '';

     #echo '<br /> Safety '.$extended_safety_id.' = '.$user_id;
    
  ?>
  <tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="26" align="left" ><font size=1>%  of  Oxygen level <br>19.5  to  23.5  %</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" ><input type="text" class="form-control extended_to_oxygen_reading extended_oxygen_to1" name="extended_to_oxygen_reading[a]" name="extended_to_oxygen_reading[a]" value="<?php echo (isset($extended_to_oxygen_reading->a)) ? strtolower($extended_to_oxygen_reading->a) : ''; ?>" <?php if($extended_safety_id!=$user_id) { ?> disabled="disabled" <?php } ?>/></td>
        <?php
          $er=2;
          foreach($extended_ranges as $extended_range)
          {

               $ext_time_period = (isset($extended_time_period->$extended_range)) ? strtolower($extended_time_period->$extended_range) : ''; 


                 if($ext_time_period=='to')
                 $ext_sa_app_status=(isset($extended_sa_to_approval_status->$extended_range)) ? ucfirst($extended_sa_to_approval_status->$extended_range) : '';
                 else
                 $ext_sa_app_status=(isset($extended_sa_from_approval_status->$extended_range)) ? ucfirst($extended_sa_from_approval_status->$extended_range) : '';                   

                
                 $ia_app_status=$ext_sa_app_status;
                               

              
        ?>        
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" ><input type="text" class="form-control extended_from_oxygen_reading extended_oxygen_from<?php echo $er; ?>" name="extended_from_oxygen_reading[<?php echo $extended_range; ?>]" name="extended_from_oxygen_reading[<?php echo $extended_range; ?>]" value="<?php echo (isset($extended_from_oxygen_reading->$extended_range)) ? strtolower($extended_from_oxygen_reading->$extended_range) : '';  ?>" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>

        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" ><input type="text" class="form-control extended_to_oxygen_reading extended_oxygen_to<?php echo $er; ?>" name="extended_to_oxygen_reading[<?php echo $extended_range; ?>]" name="extended_to_oxygen_reading[<?php echo $extended_range; ?>]" value="<?php echo (isset($extended_to_oxygen_reading->$extended_range)) ? strtolower($extended_to_oxygen_reading->$extended_range) : ''; ?>"  data-ia-approval="<?php echo $ia_app_status; ?>"/></td>   
        <?php
            $er++;
          }

     if(isset($records))
     $extended_from_gases_reading=json_decode($records['extended_from_gases_reading']);
     else
     $extended_from_gases_reading=array();
 
     if(isset($records))
     $extended_to_gases_reading=json_decode($records['extended_to_gases_reading']);
     else
     $extended_to_gases_reading=array();

       $ext_sa_app_status=(isset($extended_sa_to_approval_status->a)) ? ucfirst($extended_sa_to_approval_status->a) : '';

       $ia_app_status=$ext_sa_app_status;            

        ?>  
  </tr>
  <tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="43" align="left" ><font size=1>Combustible gases<br> 0  %</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" valign="middle"><input type="text" class="form-control extended_to_gases_reading extended_gases_to1" name="extended_to_gases_reading[a]" name="extended_to_gases_reading[a]" value="<?php echo (isset($extended_to_gases_reading->a)) ? strtolower($extended_to_gases_reading->a) : ''; ?>" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
     <?php
          $er=2;
          foreach($extended_ranges as $extended_range)
          {

                $ext_time_period = (isset($extended_time_period->$extended_range)) ? strtolower($extended_time_period->$extended_range) : ''; 


                 if($ext_time_period=='to')
                 $ext_sa_app_status=(isset($extended_sa_to_approval_status->$extended_range)) ? ucfirst($extended_sa_to_approval_status->$extended_range) : '';
                 else
                 $ext_sa_app_status=(isset($extended_sa_from_approval_status->$extended_range)) ? ucfirst($extended_sa_from_approval_status->$extended_range) : '';                   

                
                 $ia_app_status=$ext_sa_app_status;            
        ?>     
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" ><input type="text" class="form-control extended_from_gases_reading extended_gases_from<?php echo $er; ?>" name="extended_from_gases_reading[<?php echo $extended_range; ?>]" name="extended_from_gases_reading[<?php echo $extended_range; ?>]" value="<?php echo (isset($extended_from_gases_reading->$extended_range)) ? strtolower($extended_from_gases_reading->$extended_range) : ''; ?>" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left">
      <input type="text" class="form-control extended_to_gases_reading extended_gases_to<?php echo $er; ?>" name="extended_to_gases_reading[<?php echo $extended_range; ?>]" name="extended_to_gases_reading[<?php echo $extended_range; ?>]" value="<?php echo (isset($extended_to_gases_reading->$extended_range)) ? strtolower($extended_to_gases_reading->$extended_range) : ''; ?>"  data-ia-approval="<?php echo $ia_app_status; ?>"/>      
    </td>
    <?php
          $er++;
          }

     if(isset($records))
     $extended_from_carbon_reading=json_decode($records['extended_from_carbon_reading']);
     else
     $extended_from_carbon_reading=array();
 
     if(isset($records))
     $extended_to_carbon_reading=json_decode($records['extended_to_carbon_reading']);
     else
     $extended_to_carbon_reading=array();

       $ext_sa_app_status=(isset($extended_sa_to_approval_status->a)) ? ucfirst($extended_sa_to_approval_status->a) : '';

       $ia_app_status=$ext_sa_app_status;            


        ?>  
  </tr>
  <tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="43" align="left" ><font size=1>Carbon Monoxide<br>0-25  ppm</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" ><input type="text" class="form-control extended_to_carbon_reading extended_carbon_to1" name="extended_to_carbon_reading[a]" name="extended_to_carbon_reading[a]" value="<?php echo (isset($extended_to_carbon_reading->a)) ? strtolower($extended_to_carbon_reading->a) : ''; ?>" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
     <?php
          $er=2;
          foreach($extended_ranges as $extended_range)
          {

                $ext_time_period = (isset($extended_time_period->$extended_range)) ? strtolower($extended_time_period->$extended_range) : ''; 


                 if($ext_time_period=='to')
                 $ext_sa_app_status=(isset($extended_sa_to_approval_status->$extended_range)) ? ucfirst($extended_sa_to_approval_status->$extended_range) : '';
                 else
                 $ext_sa_app_status=(isset($extended_sa_from_approval_status->$extended_range)) ? ucfirst($extended_sa_from_approval_status->$extended_range) : '';                   

                
                 $ia_app_status=$ext_sa_app_status;                    
        ?>     

    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" ><input type="text" class="form-control extended_from_carbon_reading extended_carbon_from<?php echo $er; ?>" name="extended_from_carbon_reading[<?php echo $extended_range; ?>]" value="<?php echo (isset($extended_from_carbon_reading->$extended_range)) ? strtolower($extended_from_carbon_reading->$extended_range) : ''; ?>"  data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" ><input type="text" class="form-control extended_to_carbon_reading extended_carbon_to<?php echo $er; ?>" name="extended_to_carbon_reading[<?php echo $extended_range; ?>]"  value="<?php echo (isset($extended_to_carbon_reading->$extended_range)) ? strtolower($extended_to_carbon_reading->$extended_range) : ''; ?>"  data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
    <?php
            $er++;
          }
    ?>    
  </tr>

    <?php
     if(isset($records))
     $extended_performing_to_authority=json_decode($records['extended_performing_to_authority']);
     else
     $extended_performing_to_authority=array();

     if(isset($records))
     $extended_performing_from_authority=json_decode($records['extended_performing_from_authority']);
     else
     $extended_performing_from_authority=array();    

       $ext_time_period=(isset($extended_time_period->a)) ? strtolower($extended_time_period->a) : '';  
      
       $ext_ia_app_status=(isset($extended_ia_to_approval_status->a)) ? ucfirst($extended_ia_to_approval_status->a) : '';

       $ext_sa_app_status=(isset($extended_sa_to_approval_status->a)) ? ucfirst($extended_sa_to_approval_status->a) : '';      
      

       if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
       $ia_app_status=APPROVED;
       else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
       $ia_app_status='';
       else 
       $ia_app_status=WAITING; 

    ?>  
  <tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="28" align="center" valign=middle><font size=1>PA</font></td>

    <td style="padding-top:3px;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" valign="middle" ><select id="extended_performing_to_authority[a]" name="extended_performing_to_authority[a]"  class="performing_authority form-control extended_pa_to1" data-ia-approval="<?php echo $ia_app_status; ?>"> <option value="" selected="selected">- - Select - -</option>
   <?php
    $performing_authority=(isset($extended_performing_to_authority->a)) ? $extended_performing_to_authority->a : '';
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {    
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
      
          if($performing_authority=='')
          { 
             if($id==$user_id)
             $flag=1;
          }
          else
          {
            if($performing_authority==$id) { $chk='selected'; $flag=1; }
          }
          
      if($flag==1)
      {
          
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
      }
    }
  }
   ?>
                            </select></td>
        <?php
          $er=2;
          foreach($extended_ranges as $extended_range)
          {

                $ext_time_period = (isset($extended_time_period->$extended_range)) ? strtolower($extended_time_period->$extended_range) : ''; 

                 $ext_ia_app_status=$ext_sa_app_status=''; 

                 if($ext_time_period=='from')
                 {
                    $ext_ia_app_status=(isset($extended_ia_from_approval_status->$extended_range)) ? ucfirst($extended_ia_from_approval_status->$extended_range) : '';

                    $ext_sa_app_status=(isset($extended_sa_from_approval_status->$extended_range)) ? ucfirst($extended_sa_from_approval_status->$extended_range) : '';

                 }   

                 if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
                 $ia_app_status=APPROVED;
                 else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
                 $ia_app_status='';
                 else 
                 $ia_app_status=WAITING;                                   
        ?>     
                                
                <td style="padding-top:3px;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" >
                  <select data-ia-approval="<?php echo $ia_app_status; ?>" id="extended_performing_from_authority[<?php echo $extended_range; ?>]" name="extended_performing_from_authority[<?php echo $extended_range; ?>]"  class="performing_authority form-control extended_pa_from<?php echo $er; ?>"> <option value="" selected="selected">- - Select - -</option>
                <?php
                $performing_authority=(isset($extended_performing_from_authority->$extended_range)) ? $extended_performing_from_authority->$extended_range : '';
              if($authorities!='')
              {
                foreach($authorities as $fet)
                {    
                  
                  $id=$fet['id'];
                  
                  $first_name=$fet['first_name'];
                  
                  $chk='';
                  
                  $flag=0;
                  
                      if($performing_authority=='')
                      { 
                         if($id==$user_id)
                         $flag=1;
                      }
                      else
                      {
                        if($performing_authority==$id) { $chk='selected'; $flag=1; }
                      }
                      
                  if($flag==1)
                  {
                      
              ?>
                                          <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                          <?php
                  }
                }
              }
               ?>
                            </select>
    </td>

<?php

        $ext_ia_app_status=$ext_sa_app_status='';
        
        if($ext_time_period=='to')        
        {
            $ext_ia_app_status=(isset($extended_ia_to_approval_status->$extended_range)) ? ucfirst($extended_ia_to_approval_status->$extended_range) : '';

            $ext_sa_app_status=(isset($extended_sa_to_approval_status->$extended_range)) ? ucfirst($extended_sa_to_approval_status->$extended_range) : '';
         }
       
        if($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
         $ia_app_status=APPROVED;
         else if($ext_ia_app_status=='' && $ext_sa_app_status=='')
         $ia_app_status='';
         else 
         $ia_app_status=WAITING;  
?>             
    <td style="padding-top:3px;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" ><select data-ia-approval="<?php echo $ia_app_status; ?>"  id="extended_performing_to_authority[<?php echo $extended_range; ?>]" name="extended_performing_to_authority[<?php echo $extended_range; ?>]"  class="performing_authority form-control extended_pa_to<?php echo $er; ?>"> <option value="" selected="selected">- - Select - -</option>
    <?php
    $performing_authority=(isset($extended_performing_to_authority->$extended_range)) ? $extended_performing_to_authority->$extended_range : '';
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {    
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
      
          if($performing_authority=='')
          { 
             if($id==$user_id)
             $flag=1;
          }
          else
          {
            if($performing_authority==$id) { $chk='selected'; $flag=1; }
          }
          
      if($flag==1)
      {
          
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
      }
    }
  }
   ?>
                            </select></td>
    <?php
        $er++;
    }
    ?>                            
    
  </tr>

<tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="28" align="center" valign=middle><font size=1>SA</font></td>

    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" >      
    <?php  $safety_approval_status=(isset($extended_safety_to_approval_status->a)) ? $extended_safety_to_approval_status->a : ''; ?>

    <input type="hidden" name="extended_safety_to_approval_status[a]" id="extended_safety_to_approval_status[a]" value="<?php echo $safety_approval_status; ?>" class="extended_safety_to_approval_status1"/>

    <select data-ia-approval="<?php echo $safety_approval_status; ?>" id="extended_safety_to_sign_id[a]" name="extended_safety_to_sign_id[a]"  class="safety_authority form-control extended_sa_to1">
                                  <option value="">- - Select - -</option>
<?php
  $safety_sign_id=(isset($extended_safety_to_sign_id->a)) ? $extended_safety_to_sign_id->a : '';

   $performing_authority = (isset($extended_performing_to_authority->a)) ? $extended_performing_to_authority->a : '';
  if($safety_authorities!='')
  {
    foreach($safety_authorities as $fet)
    {
      
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
          if($record_id!=''  && $safety_sign_id=='')
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($safety_sign_id>0)
          {
            $flag=1;
            
            if($id==$performing_authority)
            $flag=0;
          }
          
      if($flag==1 && $performing_authority!=$id)
      {
          if($safety_sign_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>



    </td>

        <?php
          $er=2;
          foreach($extended_ranges as $extended_range)
          {


        ?>  
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left">
      <?php $safety_approval_status=(isset($extended_safety_from_approval_status->$extended_range)) ? $extended_safety_from_approval_status->$extended_range : ''; ?>

      <input type="hidden" name="extended_safety_from_approval_status[<?php echo $extended_range; ?>]" id="extended_safety_from_approval_status[<?php echo $extended_range; ?>]" class="extended_safety_from_approval_status<?php echo $extended_range;?>" value="<?php echo $safety_approval_status; ?>" />

<select data-ia-approval="<?php echo $safety_approval_status; ?>" id="extended_safety_from_sign_id[<?php echo $extended_range; ?>]" name="extended_safety_from_sign_id[<?php echo $extended_range; ?>]"  class="safety_authority form-control extended_sa_from<?php echo $er; ?>">
                                  <option value="">- - Select - -</option>
<?php
  $safety_sign_id=(isset($extended_safety_from_sign_id->$extended_range)) ? $extended_safety_from_sign_id->$extended_range : '';

   $performing_authority = (isset($extended_performing_from_authority->$extended_range)) ? $extended_performing_from_authority->$extended_range : '';
  if($safety_authorities!='')
  {
    foreach($safety_authorities as $fet)
    {
      $is_safety=$fet['is_safety'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
          if($record_id!=''  && $safety_sign_id=='')
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($safety_sign_id>0)
          {
            $flag=1;
            
            if($id==$performing_authority)
            $flag=0;
          }
          
      if($flag==1 && $performing_authority!=$id)
      {
          if($safety_sign_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>


    </td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" >
      <?php $safety_approval_status=(isset($extended_safety_to_approval_status->$extended_range)) ? $extended_safety_to_approval_status->$extended_range : ''; ?>

       <input type="hidden" name="extended_safety_to_approval_status[<?php echo $extended_range; ?>]" id="extended_safety_to_approval_status[<?php echo $extended_range; ?>]" value="<?php echo $safety_approval_status; ?>" class="extended_safety_to_approval_status<?php echo $er;?>"/>

      <select data-ia-approval="<?php echo $safety_approval_status; ?>" id="extended_safety_to_sign_id[<?php echo $extended_range; ?>]" name="extended_safety_to_sign_id[<?php echo $extended_range; ?>]"  class="safety_authority form-control extended_sa_to<?php echo $er; ?>">
                                  <option value="">- - Select - -</option>
<?php
  $safety_sign_id=(isset($extended_safety_to_sign_id->$extended_range)) ? $extended_safety_to_sign_id->$extended_range : '';

   $performing_authority = (isset($extended_performing_to_authority->$extended_range)) ? $extended_performing_to_authority->$extended_range : '';
  if($safety_authorities!='')
  {
    foreach($safety_authorities as $fet)
    {
      $is_safety=$fet['is_safety'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
          
     if($id!=$performing_authority)
     $flag=1;
     else
     $flag=0;
        
          
      if($flag==1 && $performing_authority!=$id)
      {
          if($safety_sign_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>

</td>
        <?php
              $er++;
          }
        ?>
  </tr>    

<?php
     
     $extended_issuing_to_approval_status = $extended_issuing_from_approval_status = array();

     if(isset($records))
     {
        $extended_issuing_to_authority=json_decode($records['extended_issuing_to_authority']);

        $extended_issuing_to_approval_status=json_decode($records['extended_issuing_to_approval_status']);
     }  
     else
     $extended_issuing_to_authority=array();

     if(isset($records))
     {
        $extended_issuing_from_authority=json_decode($records['extended_issuing_from_authority']);

        $extended_issuing_from_approval_status=json_decode($records['extended_issuing_from_approval_status']);
     }   
     else
     $extended_issuing_from_authority=array();  

    ?>    
  <tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="28" align="center" valign=middle><font size=1>IA</font></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" >
 <?php $issuing_approval_status=(isset($extended_issuing_to_approval_status->a)) ? $extended_issuing_to_approval_status->a : ''; ?>

       <input type="hidden" name="extended_issuing_to_approval_status[a]" id="extended_issuing_to_approval_status[a]" value="<?php echo $issuing_approval_status; ?>" class="extended_issuing_to_approval_status1"/>

      <select id="extended_issuing_to_authority[a]" name="extended_issuing_to_authority[a]"  class="issuing_authority form-control extended_ia_to1" data-ia-approval="<?php echo $issuing_approval_status; ?>"> <option value="" selected="selected">- - Select - -</option>      
      <?php
  $issuing_authority=(isset($extended_issuing_to_authority->a)) ? $extended_issuing_to_authority->a : '';
  
  $performing_authority = (isset($extended_performing_to_authority->a)) ? $extended_performing_to_authority->a : '';
  
  if($issuing_authorities!='')
  {
    foreach($issuing_authorities as $fet)
    {
     
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
          if($record_id!=''  && $issuing_authority=='')
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($issuing_authority>0)
          {
            $flag=1;
            
            if($id==$performing_authority)
            $flag=0;
          }
      
      
      if($flag==1)
      {
          if($issuing_authority==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
      }
    }
  }
   ?>

    </select></td>

    <?php
          $er=2;
          foreach($extended_ranges as $extended_range)
          {

                $ext_time_period = (isset($extended_time_period->$extended_range)) ? strtolower($extended_time_period->$extended_range) : ''; 

      
        ?>     

    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left">
        <?php $issuing_approval_status=(isset($extended_issuing_from_approval_status->$extended_range)) ? $extended_issuing_from_approval_status->$extended_range : ''; ?>

       <input type="hidden" name="extended_issuing_from_approval_status[<?php echo $extended_range; ?>]" id="extended_issuing_from_approval_status[<?php echo $extended_range; ?>]" value="<?php echo $issuing_approval_status; ?>" class="extended_issuing_from_approval_status<?php echo $issuing_approval_status; ?>"/>


      <select data-ia-approval="<?php echo $issuing_approval_status; ?>" id="extended_issuing_from_authority[<?php echo $extended_range; ?>]" name="extended_issuing_from_authority[<?php echo $extended_range; ?>]"  class="issuing_authority form-control extended_ia_from<?php echo $er; ?>"> <option value="" selected="selected">- - Select - -</option>      
      <?php
  $issuing_authority=(isset($extended_issuing_from_authority->$extended_range)) ? $extended_issuing_from_authority->$extended_range : '';
  
  $performing_authority = (isset($extended_performing_from_authority->$extended_range)) ? $extended_performing_from_authority->$extended_range : '';
  
  if($issuing_authorities!='')
  {
    foreach($issuing_authorities as $fet)
    {
     
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
          if($record_id!=''  && $issuing_authority=='')
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($issuing_authority>0)
          {
            $flag=1;
            
            if($id==$performing_authority)
            $flag=0;
          }
      
      
      if($flag==1)
      {
          if($issuing_authority==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
      }
    }
  }
   ?>

    </select>
        </td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" >

      <?php $issuing_approval_status=(isset($extended_issuing_to_approval_status->$extended_range)) ? $extended_issuing_to_approval_status->$extended_range : ''; ?>

       <input type="hidden" name="extended_issuing_to_approval_status[<?php echo $extended_range; ?>]" id="extended_issuing_to_approval_status[<?php echo $extended_range; ?>]" value="<?php echo $issuing_approval_status; ?>" class="extended_issuing_to_approval_status<?php echo $er; ?>"/>

      <select data-ia-approval="<?php echo $issuing_approval_status; ?>" id="extended_issuing_to_authority[<?php echo $extended_range; ?>]" name="extended_issuing_to_authority[<?php echo $extended_range; ?>]"  class="issuing_authority form-control extended_ia_to<?php echo $er; ?>"> <option value="" selected="selected">- - Select - -</option>      
      <?php
  $issuing_authority=(isset($extended_issuing_to_authority->$extended_range)) ? $extended_issuing_to_authority->$extended_range : '';
  
  $performing_authority = (isset($extended_performing_to_authority->$extended_range)) ? $extended_performing_to_authority->$extended_range : '';
  
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
     
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
          if($record_id!=''  && $issuing_authority=='')
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($issuing_authority>0)
          {
            $flag=1;
            
            if($id==$performing_authority)
            $flag=0;
          }
      
      
      if($flag==1)
      {
          if($issuing_authority==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
      }
    }
  }
   ?>

    </select></td>
    <?php
          $er++;
        }
    ?>   
    
  </tr>

  <?php
    $ref_code_show='hidden';


     if(isset($records))
     $extended_reference_code_from=json_decode($records['extended_reference_code_from']);
     else
     $extended_reference_code_from=array();

     if(isset($records))
     $extended_reference_code_to=json_decode($records['extended_reference_code_to']);
     else
     $extended_reference_code_to=array();    

    #echo '<pre>'; print_r($extended_reference_code_from);
                
    $ext_ia_app_status=(isset($extended_ia_to_approval_status->a)) ? ucfirst($extended_ia_to_approval_status->a) : '';

    $ext_sa_app_status=(isset($extended_sa_to_approval_status->a)) ? ucfirst($extended_sa_to_approval_status->a) : '';

      

      if(ucfirst($ext_ia_app_status)===APPROVED && ucfirst($ext_sa_app_status)===APPROVED)
      $ref_code_show='text';
    ?>      
  <tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="28" align="center" valign=middle><font size=1>Ref Code</font></td>

    <td style="padding-top:3px;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" valign="middle"> 
    <input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($extended_reference_code_to->a)) ? $extended_reference_code_to->a : ''; ?>" name="extended_reference_code_to[a]" id="extended_reference_code_to[a]"  class="extended_reference_code_to1 form-control" style="width: 107px;" />
    </td>

        <?php
          $er=2;
          foreach($extended_ranges as $extended_range)
          {

                $ext_time_period = (isset($extended_time_period->$extended_range)) ? strtolower($extended_time_period->$extended_range) : ''; 


                 if($ext_time_period=='to')
                 {
                    $ext_ia_app_status=(isset($extended_ia_to_approval_status->$extended_range)) ? ucfirst($extended_ia_to_approval_status->$extended_range) : '';

                    $ext_sa_app_status=(isset($extended_sa_to_approval_status->$extended_range)) ? ucfirst($extended_sa_to_approval_status->$extended_range) : '';

                    $ref_code = (isset($extended_reference_code_to->$extended_range)) ? $extended_reference_code_to->$extended_range : '';
                 }
                 else
                 {
                    $ext_ia_app_status=(isset($extended_ia_from_approval_status->$extended_range)) ? ucfirst($extended_ia_from_approval_status->$extended_range) : '';

                    $ext_sa_app_status=(isset($extended_sa_from_approval_status->$extended_range)) ? ucfirst($extended_sa_from_approval_status->$extended_range) : '';

                    

                 }   

                 $ref_code = (isset($extended_reference_code_from->$extended_range)) ? $extended_reference_code_from->$extended_range : '';

                 $ref_code_to = (isset($extended_reference_code_to->$extended_range)) ? $extended_reference_code_to->$extended_range : '';

               /*f($ext_ia_app_status==APPROVED && $ext_sa_app_status==APPROVED)
                 $ref_code_show='';
                 else
                 $ref_code_show='hidden'; */

                #echo '<br /> Ref code '.$ext_time_period.' = '.$ref_code.' - '.$ref_code_to;  
                
                if($ref_code=='')                
                $ref_code_show='hidden'; 
                else
                $ref_code_show='text';  


                           
        ?>  
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left">

       <input type="<?php echo $ref_code_show; ?>" value="<?php echo $ref_code; ?>" name="extended_reference_code_from[<?php echo $extended_range; ?>]" id="extended_reference_code_from[<?php echo $extended_range; ?>]"  class="extended_reference_code_from<?php echo $er; ?> form-control" style="width: 107px;" disabled="disabled"/></td>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" > 

          <?php
                if($ref_code_to=='')                
                $ref_code_show='hidden'; 
                else
                $ref_code_show='text';  
          ?>    
            <input type="<?php echo $ref_code_show; ?>" value="<?php echo $ref_code_to; ?>" name="extended_reference_code_to[<?php echo $extended_range; ?>]" id="extended_reference_code_to[<?php echo $extended_range; ?>]"  class="extended_reference_code_to<?php echo $er; ?> form-control" style="width: 107px;"  disabled="disabled"/>
</td>
        <?php
            $er++;
          }
        ?>
  </tr>  
  
</table>
 <div>&nbsp;</div>
<input type="hidden" id="show_button" name="show_button" />
             <?php
            $is_show_button=(isset($records['show_button'])) ? $records['show_button'] : 'show';
            
            $is_popup_submit=$is_extended=$is_show_extended_button=0;
            
            $show_extend_field=-01;$show_flag=0;$redirect=''; $show_button=false; $enable_extend_inputs=$exten_time_period='';
            
           # echo '<br /> S : '.$is_show_button.' = '.$show_flag.' - '.$approval_status;

            if(empty($record_id))
            {
                $show_flag=1; //Initiate Create Button

                echo '<button class="btn btn-sm btn-primary show_button"  value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Create</button>';
            }
            else
            {
                if($approval_status<13)
                {
                  if($is_show_button=='show')
                  {
                      $label=' Submit';
                      
                      $submit_value='show';             
                      
                      $show_final=0;
                    
                      //If IA approved and PA come back his job
                      if($acceptance_issuing_approval=='Yes' && $user_id==$records['acceptance_performing_id'])
                      {
                        $show_final=1;
                        
                        $show_button=true;
                      }     //IF SA not approved and come to this job
                      else if($acceptance_safety_approval=='No' && $user_id==$records['acceptance_safety_sign_id'])
                      {
                        $label=' Approve & Submit';
                        
                        $submit_value=' approveSA'; 
                        
                        $is_popup_submit=1;
                        
                        if($job_status_error_msg!='')
                        $show_flag=22;
                        else                  
                        { $show_flag=3;     $show_button=true; }      
                      }                    //If SA approved and IA come to this job
                      else if($acceptance_issuing_approval=='No' && $user_id==$records['acceptance_issuing_id'] && $acceptance_safety_approval=='Yes')
                      {
                        $label=' Approve & Submit';
                        
                        $submit_value=' approveIA'; 
                        
                        $is_popup_submit=1;
                        
                        if($job_status_error_msg!='')
                        $show_flag='';
                        else                  
                        { $show_flag=3; $show_button=true; }          
                      } //If PA come and IA not approved yet
                      else if($acceptance_issuing_approval=='No' && $user_id==$records['acceptance_performing_id'])
                      {
                        $show_flag=2;$show_button=true;
                      }
                      else if($acceptance_issuing_approval=='Yes' && $user_id==$records['acceptance_issuing_id'])
                      {
                        $show_flag='';
                      }
                      else
                      $show_flag='';

                      #echo 'FF '.$show_flag.' = '.$show_final;
                    
                      //if(in_array($show_flag,array(2,3)))
                      if($show_button===true)
                      {
                           if($show_final==0) 
                           echo '<button class="btn btn-sm btn-primary show_button"  value="'.$submit_value.'" type="submit"><i class="fa fa-dot-circle-o"></i> '.$label.'</button>';
                          else { #$is_popup_submit=1;
                          
                          if($eip_opened==count($jobs_isoloations_ids))
                           echo '<button class="btn btn-sm btn-primary show_button" value="hide" type="submit"><i class="fa fa-dot-circle-o"></i> Final Submit</button>';
                          }
                      }
                  }
                  else   //After Final Submit
                  {
                      if(strtolower($status)!='extended')
                      {
                        if(!in_array($approval_status,array(3,5,6,7,8,)) || ($cancellation_performing_id==$user_id && $cancellation_issuing_date==''))  
                        {
                            $show_flag=4;
                            echo '<button class="btn btn-sm btn-primary show_button"  value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>'; 
                        }
                        else if(in_array($user_id,array($cancellation_issuing_id)) && in_array($approval_status,array(3,5,7)))
                        {
                          echo '<button class="btn btn-sm btn-primary show_button"  value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Approve '.$status.' & Submit</button>';
                          $show_flag=5;
                        }
                      }
                      else
                      {

                         $extended_time= json_decode($records['extended_time_period'],true);

                         $fil=array_filter($extended_time);

                         end($fil); $fil_key=key($fil); //a,b,c,d  #echo 'FF '.$fil_key;

                         $range=range('a','f'); 

                         $schedule_date=json_decode(json_encode($schedule_date),true);

                         $extended_time_period=json_decode(json_encode($extended_time_period),true);

                         $extended_safety_to_approval_status=json_decode(json_encode($extended_safety_to_approval_status),true);

                         $extended_issuing_to_approval_status=json_decode(json_encode($extended_issuing_to_approval_status),true);

                         $extended_safety_to_sign_id=json_decode(json_encode($extended_safety_to_sign_id),true);

                         $extended_issuing_to_authority=json_decode(json_encode($extended_issuing_to_authority),true);

                         $extended_performing_to_authority=json_decode(json_encode($extended_performing_to_authority),true);


                         $extended_safety_from_approval_status=json_decode(json_encode($extended_safety_from_approval_status),true);

                         $extended_issuing_from_approval_status=json_decode(json_encode($extended_issuing_from_approval_status),true);

                         $extended_safety_from_sign_id=json_decode(json_encode($extended_safety_from_sign_id),true);

                         $extended_issuing_from_authority=json_decode(json_encode($extended_issuing_from_authority),true);

                         $extended_performing_from_authority=json_decode(json_encode($extended_performing_from_authority),true);

                         #echo '<pre>'; print_r(json_decode(json_encode($extended_time_period),true));
                      
                        for($r=0;$r<count($range);$r++)
                        {

                          $sch_date=(isset($schedule_date[$range[$r]])) ? $schedule_date[$range[$r]] : '';

                          $exten_time_period = (isset($extended_time_period[$range[$r]])) ? $extended_time_period[$range[$r]] : '';

                          $is_show_extended_button=1; $is_extended_sa_approval=''; $is_extended_ia_approval=''; $is_extended=0;

                          $show_extend_field=($r+1);      

                          #echo 'fF '.$extended_safety_to_approval_status[$range[$r]].' = '.$extended_issuing_to_approval_status[$range[$r]].' = Time '.$exten_time_period;

                              if($sch_date!='')
                              {
                                  if($fil_key==$range[$r])
                                  {
                                    if($exten_time_period=='to')
                                    {

                                      if($extended_safety_to_approval_status[$range[$r]]==WAITING || $extended_issuing_to_approval_status[$range[$r]]==WAITING)
                                      {
                                        $ex='';

                                          if($extended_safety_to_sign_id[$range[$r]]==$user_id)
                                          {
                                            if($extended_safety_to_approval_status[$range[$r]]==WAITING)
                                            {
                                              $is_extended_sa_approval=1;
                                              $ex='SA';
                                            }
                                          }                                 
                                          if($extended_issuing_to_authority[$range[$r]]==$user_id && $ex=='')
                                          {
                                            if($extended_issuing_to_approval_status[$range[$r]]==WAITING)
                                            {
                                              $is_extended_ia_approval=2;      
                                              $ex='IA';
                                            }
                                          } 

                                          #echo 'FF '.$ex;

                                          if($extended_safety_to_approval_status[$range[$r]]==APPROVED && $extended_issuing_to_approval_status[$range[$r]]==APPROVED)
                                          {
                                              $is_show_extended_button=1;

                                              break;
                                          }

                                          if($ex!='')
                                          {
                                             $is_extended=1;  if($ex=='SA') $show_flag=6; else $show_flag=7;    $enable_extend_inputs=($r+1);
                                            
                                             echo '<button class="btn btn-sm btn-primary show_button"  value="hides" type="submit"><i class="fa fa-dot-circle-o"></i> Approve  '.$ex.' '.$status.' & Submit</button>';  
                                                   break;
                                          }
                                          $ex='PA';  

                                          break;                             
                                      }
                                        else
                                        $ex='PA';


                                      #echo '<br>TO '.$extended_performing_to_authority->$range[$r].' == '.$user_id.' = '.$ex;
                                        if($extended_performing_to_authority[$range[$r]]==$user_id)     
                                        {
                                          $is_show_extended_button=0;

                                          if($ex=='PA')
                                          {
                                                 $is_extended_ia_approval=1;   
                                                 $is_extended=1;   
                                          }

                                          #break;
                                        }  
                                        else if($extended_safety_to_approval_status[$range[$r]]==APPROVED && $extended_issuing_to_approval_status[$range[$r]]==APPROVED)
                                        {
                                          $is_show_extended_button=0;
                                        }       
                                    }
                                    else 
                                    {
                                      $ex='';

                                      if($extended_safety_from_approval_status[$range[$r]]==WAITING || $extended_issuing_from_approval_status[$range[$r]]==WAITING)
                                      {
                                            if($extended_safety_from_sign_id[$range[$r]]==$user_id)
                                            {
                                              if($extended_safety_from_approval_status[$range[$r]]==WAITING)
                                              {
                                                $ex='SA';

                                                $is_extended_sa_approval=1;
                                              }
                                            } 
                                          
                                            if($extended_issuing_from_authority[$range[$r]]==$user_id && $ex=='') 
                                            {

                                              #echo 'FF '.$extended_issuing_from_authority->$range[$r];
                                              if($extended_issuing_from_approval_status[$range[$r]]==WAITING)
                                              { 
                                                $ex='IA';

                                                $is_extended_ia_approval=2; 
                                              } 
                                            } 

                                            if($extended_safety_from_approval_status[$range[$r]]==APPROVED && $extended_issuing_from_approval_status[$range[$r]]==APPROVED)
                                            {
                                                $is_show_extended_button=1;

                                                break;
                                            }

                                            if($ex!='')
                                            {
                                               $is_extended=1; if($ex=='SA') $show_flag=6; else $show_flag=7;   $enable_extend_inputs=($r+1);                                                      
                                              
                                               echo '<button class="btn btn-sm btn-primary show_button"  value="hides" type="submit"><i class="fa fa-dot-circle-o"></i> Approve  '.$ex.' '.$status.' & Submit</button>';  
                                               break;
                                            }   

                                            $ex='PA'; 


                                           break;                                                                
                                      } 
                                      else
                                      $ex='PA';

                                      

                                      if($extended_performing_from_authority[$range[$r]]==$user_id )     
                                      {
                                        $is_show_extended_button=0;

                                        if($ex=='PA')
                                        {
                                              $is_extended_ia_approval=1;   

                                              $is_extended=1;   

                                              $enable_extend_inputs=($r+1);

                                              $exten_time_period='to';

                                              $show_flag=9;
                                        }           
                                        break;
                                      }

                                      #echo '<br /> From '.$extended_safety_from_approval_status[$range[$r]].' = '.$extended_issuing_from_approval_status[$range[$r]];
                                      if($extended_safety_from_approval_status[$range[$r]]==APPROVED && $extended_issuing_from_approval_status[$range[$r]]==APPROVED)
                                      {
                                        $is_show_extended_button=2;

                                        $is_extended=1;  $is_extended_ia_approval=1;    

                                        $enable_extend_inputs=($r+1);

                                        $exten_time_period='to';

                                        $show_flag=9;

                                        break;
                                      }
                                      else
                                      {
                                          #$is_show_extended_button=0;

                                          break;
                                      }
                                    }
                                  }
                              }   
                              else
                              {
                                $is_extended_ia_approval=0;

                                $is_show_extended_button=0;

                                $enable_extend_inputs=($r+1);

                                $exten_time_period='from';

                                $show_flag=8;

                                break;
                              }                    
                        }

                        #echo '<br /> Final '.$is_show_extended_button.' = '.$ex;

                        if($is_show_extended_button==0 || $is_show_extended_button==2)
                        {
                          echo '<button class="btn btn-sm btn-primary show_button"  value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>';
                        }

                       # echo 'Last '.$enable_extend_inputs.' = = '.$exten_time_period.' = '.$show_flag;
                        //print_r($fil);
                      }

                  }
               } 
            }
           
            $redirect=base_url().$param_url;
            ?>
            <a  class="btn btn-sm btn-danger" href="<?php echo $redirect; ?>"><i class="fa fa-ban"> Go Back</i></a>  
             <input type="hidden" id="is_popup_submit" name="is_popup_submit" value="<?php #echo $is_popup_submit; ?>"  />
            <?php
            if(!empty($record_id))
            {
              if($readonly==false)
              $st='visibility:hidden;';
              else
              $st='';
            ?>  
                        <a href="javascript:void(0);" style="float:right;<?php echo $st; ?>" data-id="<?php echo $record_id; ?>" class="print_out"><i class="fa fa-print">Print PDF</i></a>
                        <?php
            }

           
            ?>      
</form>                                           
<?php $this->load->view('layouts/footer'); ?>      

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script> 
<script>
  $(document).ready(function() {
    $('#gritter_trigger').val(''); // skip gritter success popup     
    });

</script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/confined_permits.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.thickbox.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<link href="<?php echo base_url(); ?>assets/css/jquery.thickbox.css" rel="stylesheet" media="screen" type="text/css" />

<link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet"type="text/css" />
<script src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>

<script type="text/javascript">   
  
    function open_thick(epi_id)
    {      
      var win = window.open('<?php echo base_url(); ?>jobs_isolations/form/id/'+epi_id, '_blank');
      if (win) {
        //Browser has allowed it to be opened
        win.focus();
      } else {
        //Browser has blocked it
        alert('Please allow popups for this website');
      }     
      
    }
    
  $(document).ready(function()
  {   

        //$('.schedule_date').prop('readonly',true);

        $selected_eip=$('select.selected_eip').select2(
        {
            formatSelection: function(term) {            
              return "<a href='#' onclick=open_thick('"+term.id+"')>"+term.text+"</a>";            
        }
      });

       $('body').on('click','.status',function() 
      { 
          console.log('Value : '+$('.status:checked').val());

          if($('.status:checked').val()=='Cancellation')
          {
            $('#self_cancellation_section').show();

            $('#self_cancellation_description').removeAttr('disabled');
          }  
          else
          {
            
            $('#self_cancellation_section').hide();

            $('#self_cancellation_description').val('');                  
          }

              console.clear();

              if($('.status:checked').val()!='Extended')
              {
                $('#change_status_label').html($('.status:checked').val());

                d=0;

                 var inside=1;

                $('input[name^="schedule_date"]').each(function()
                {         
                  
                      d++;

                      var current_val = $(this).val();

                      var data_id=$(this).attr('data-id'); //1,2,3,

                      var data_alpha_id=$(this).attr('data-alpha-id');

                      var extend_time_period = $('.extended_time_period'+data_id).val();                

                      console.log('Selected Date  '+$(this).val()+ ' Data ID '+data_id+' EXT Time '+extend_time_period);

                     if(extend_time_period=='') 
                      extend_time_period='from';                

                      //var sa_approval_status = $('.extended_safety_'+extend_time_period+'_approval_status'+data_id).val();

                      var sa_approval_status = $('input[name="extended_safety_'+extend_time_period+'_approval_status['+data_alpha_id+']"').val();

                      var ia_approval_status = $('input[name="extended_issuing_'+extend_time_period+'_approval_status['+data_alpha_id+']"').val();

                     console.log('SA Approral '+sa_approval_status+ ' Extended time period '+ia_approval_status+ ' = = = Data ID '+data_id+' ]]]'+'.extended_safety_'+extend_time_period+'_approval_status'+data_id);

                      //var ia_approval_status = $('.extended_issuing_'+extend_time_period+'_approval_status'+data_id).val();           

                      //if($('input[id="issuing_authority_approval_status['+d+']"]').val()=='Waiting')

                      console.log('Failed '+data_alpha_id+' = = '+extend_time_period+' = = = input[name="schedule_to_time['+data_alpha_id+']"]'+ ' Va '+$('.schedule_to'+data_id).val());

                      if($(this).val()!='' && (sa_approval_status=='Approved' && ia_approval_status=='Waiting'))
                      {
                        alert("Sorry, you can't "+$('.status:checked').val()+" this job. Please check job approval status");

                        $('input[name="status"]').removeAttr('checked');
                      
                        $('input:radio[name="schedule_date"]').filter('[value="Extended"]').attr('checked', true);

                        inside=2;
                        
                        return false;
                        
                      }
                      else if($(this).val()!='' && (sa_approval_status=='Waiting' && ia_approval_status==''))
                      {
                          if(confirm('Are you sure going to change status?'))
                          {
                              if(extend_time_period=='from' || d==1)
                              $(this).val('');

                              $('.watch_person_'+extend_time_period+data_id).val('');

                              $('.watch_other_person_'+extend_time_period+data_id).val('');

                              $('.schedule_'+extend_time_period+data_id).val('');


                              $('.extended_pa_'+extend_time_period+data_id).val('');

                              $('.extended_sa_'+extend_time_period+data_id).val('');

                              $('.extended_ia_'+extend_time_period+data_id).val('');

                              inside=2;

                              return false;
                          }
                      }
                      else
                      {
                        if($(this).val()=='')
                        {
                          console.log('.Empty schedule_'+extend_time_period+data_id);

                          $('#schedule_date'+data_id).val('').attr('disabled',true); 

                          $('.schedule_'+extend_time_period+data_id).val('').trigger('change').attr('disabled',true);

                          return false;
                        }
                        else
                        {   

                            if(sa_approval_status=='Waiting' || sa_approval_status=='' || typeof sa_approval_status==='undefined')
                            {
                              if(extend_time_period=='from')
                              $('#schedule_date'+data_id).val('').attr('disabled',true);  

                              $('.schedule_'+extend_time_period+data_id).val('').trigger('change').attr('disabled',true);
                            }
                            else
                            {
                                  if(extend_time_period=='from' && sa_approval_status=='Approved' && $('.schedule_to'+data_id).val()=='')
                                  {

                                    console.log('New Condition '+$('.schedule_'+extend_time_period+data_id));

                                    $('.schedule_to'+data_id).val('').trigger('change').attr('disabled',true);

                                  }
                            }

                        }

                      }
                  
                
                });   

                  if($('#cancellation_performing_id').val()=='')
                  $('#cancellation_performing_id').removeAttr('disabled');      
              }
              else
              {

                var acceptance_issuing_date=$('#acceptance_issuing_date').val().substr(0,10);
                
                var current_date=Date.parse(new Date());

                $('#change_status_label').html('Completion / Cancellation');
                
                //console.log('Current : '+current_date);
                
                $('#cancellation_performing_id,#cancellation_issuing_id,#cancellation_performing_date,#cancellation_issuing_date').attr('disabled',true).val('');
                
                d=0;
                $('input[name^="schedule_date"]').each(function()
                {
                  d++;
                  
                  var schedule_date=$(this).val();
                  
                  var selector_name = $(this).attr('name');

                  var data_id=$(this).attr('data-id'); //1,2,3,

                  var data_alpha_id=$(this).attr('data-alpha-id');

                  var extend_time_period = $('.extended_time_period'+data_id).val();

                  console.log('-------------------------');

                  console.log('Data ID '+data_id+' extend_time_period '+extend_time_period);

                  if(extend_time_period=='')    //When changing status
                  {
                    if(data_id!=1)
                    {

                      console.log("extended_time_period "+$('.extended_time_period'+(data_id-1)).val()+' == '+$('#schedule_date'+(data_id-1)).attr('data-ia-approval'));

                      if($('.extended_time_period'+(data_id-1)).val()!='' && $('.schedule_date'+(data_id-1)).attr('data-ia-approval')=='Approved')  
                      {
                        $(this).removeAttr('disabled');
                        console.log('Yes Removed');
                       } 
                    }       

                    //console.log('Removed Disabled');
                  } 
                  
                  var escaped_selector_name = selector_name.match(/\[(.*?)\]/);
                  
                  var selector_name=escaped_selector_name[1];
                  
                  var date_diff = $(this).attr('data-diff');
                  
                  var data_ia_approval=$(this).attr('data-ia-approval');//.toLowerCase(); 

                  if(typeof data_ia_approval==='undefined')
                    data_ia_approval='';
                  else
                    data_ia_approval=data_ia_approval.toLowerCase();
                  
                  
                  if(d!=1)
                  acceptance_issuing_date=$('#schedule_date'+(d-1)).val();  
                  
                      min_date=(parseInt)(d-1);             
                      
                      max_date='+'+d+'d';
                      
                      set_date=new Date();

                      set_date=new Date();
                      
                      console.log('Date Diff '+date_diff);
                      
                      if(date_diff==0)
                      {
                         max_date='+1d';
                         
                         min_date='-0';
                         
                        if(schedule_date!=acceptance_issuing_date && schedule_date!='')
                        min_date=max_date='-0';
                        
                         //console.log('Dfiif 0 '+d + acceptance_issuing_date+ ' = '+min_date+' '+max_date);
                      }
                      else
                      {
                        //max_date=min_date='+'+date_diff+'d';
                        
                        min_date='-0';
                        max_date='-0';
                        
                        if(d==1)
                        set_date = $('#acceptance_issuing_date').val();
                        else
                        set_date = $('#schedule_date'+(d-1)).val();
                        
                        if(date_diff<0)
                        max_date='+1d';
                        
                        //min_date=$('#schedule_date'+(d-1)).val(); 
                        
                        //console.log('Failed Date: '+min_date+' - '+max_date+ ' = '+set_date+' D '+d+' Prev '+$('#schedule_date'+(d-1)).val());
                      }

                     
                      
                      $( "#schedule_date"+d ).datepicker({
                        dateFormat: 'dd-mm-yy',
                        inline: true,
                        minDate:min_date,
                        maxDate: max_date,
                        onSelect: function (date)
                        {                         
                          var time_period = $('input[name="extended_time_period['+selector_name+']"]').val();                   

                          if(time_period=='' )
                          time_period='from';

                          if(selector_name=='a')
                          time_period='to';                    

                          console.log('Time period '+time_period);

                            if(selector_name!='a')
                            {
                                if(time_period=='from')
                                {
                                    //alert($('.schedule_to'+(data_id-1)).attr('data-ia-approval')+ ' = '+data_id);

                                    if($('.schedule_to'+(data_id-1)).attr('data-ia-approval')!='Approved' && $('.schedule_to'+(data_id-1)).val()!='')
                                    {
                                        //var xx=confirm('Are you going to clear previous entry'alert('Invalid Selection'); 

                                        alert('Sorry, you extending too many entry. Please refresh this page again');

                                        $(this).val('').attr('disabled',true);

                                        return false;
                                    }
                                    else
                                    {
                                        if($('.schedule_to'+(data_id-1)).val()=='')
                                          $('.schedule_to'+(data_id-1)).val('').prop('disabled',true);

                                    }

                                }
                            }

                              $('select[name="schedule_'+time_period+'_time['+selector_name+']"]').removeAttr('disabled');                    
                          },
                        showButtonPanel: true,
                        closeText: 'Clear',
                        onClose: function(e) {
                        }
                      }).focus(function() {
                        
                      
                              
                        $('.ui-datepicker-close').click(function() {                           

                           
                          var time_period = $('input[name="extended_time_period['+selector_name+']"]').val();

                          var chk_sa_approval_status = $('input[name="extended_safety_'+time_period+'_approval_status['+selector_name+']"]').val();

                          var chk_ia_approval_status = $('input[name="extended_issuing_'+time_period+'_approval_status['+selector_name+']"]').val();   

                          console.log('chk_sa_approval_status '+chk_sa_approval_status+' = = '+chk_ia_approval_status);

                            if(chk_sa_approval_status=='Approved' || chk_ia_approval_status=='Approved')               
                            {
                                 alert("Sorry, you can't clear this date. Please check job approval status"); 
                                  
                                  return false;
                            }  
                            else
                            {
                                alert('Failed '+time_period);

                                $('input[name="extended_safety_'+time_period+'_approval_status['+selector_name+']"]').val('');

                                $('input[name="extended_issuing_'+time_period+'_approval_status['+selector_name+']"]').val('');   

                                $('select[name="schedule_'+time_period+'_time['+selector_name+']"').val('').trigger('change').attr('disabled',true);

                            }                  
                            $('selector').datepicker('setDate', null);
                            $('input[name="schedule_date['+selector_name+']"]').val('');
                          

                          });
                        
                         });
                         
                    
                    show_next=0;


                    
                    if(d!=1)
                    {
                      //console.log('D Value '+parseInt(d) + ' IA Approval Status '+$('input[name="schedule_date['+selector_name+']"]').val()+ ' = Selector '+selector_name);

                      //if($('input[id="issuing_authority_approval_status['+(parseInt(d)-parseInt(1))+']"]').val()!='Approved')
                      if(data_ia_approval!='approved')
                      show_next=1;  

                      console.log('Selector Name '+selector_name+' - Shwo Next '+show_next);
                      
                    }
                    
                    //console.log('Selector '+selector_name+' Value '+$('#schedule_date['+selector_name+']"]').val());

                    var ia_approval=$('#schedule_date'+(parseInt(data_id)-1)).attr('data-ia-approval');

                    console.log('IA ApDproval '+typeof ia_approval);

                    if(typeof ia_approval==='undefined')
                    ia_approval='';
                    else 
                    ia_approval=ia_approval.toLowerCase();


                    if( ($('input[name="schedule_date['+selector_name+']"]').val()=='' && d!=1 && ia_approval=='approved') || extend_time_period=='')    //Anand
                    {   
                        console.log('remove dusavked '+ia_approval);

                        if($.inArray(ia_approval, [ "approved", ""])!==-1)
                        {
                          $('input[name="schedule_date['+selector_name+']"]').prop('disabled',false);  

                         //$('input[name="schedule_date['+selector_name+']"]').trigger('click');
                          
                          if($('.schedule_to'+(parseInt(data_id)-1)).val()=='')
                          $('.schedule_to'+(parseInt(data_id)-1)).prop('disabled',false);

                        }  
                          return false;

                    }
                    else
                    return true;
                });
                
                
              }
      });  
    
      //$('.datepicker').prop('readonly', true);    

      <?php

      $disable_extend="$('.schedule_date,.performing_authority,.issuing_authority,.safety_authority,.schedule_from_time,.schedule_to_time,.watch_person_to_time,.watch_person_from_time,.watch_other_person_to_names,.watch_other_person_from_names,.extended_from_oxygen_reading,.extended_to_oxygen_reading,.extended_from_gases_reading,.extended_to_gases_reading,.extended_from_carbon_reading,.extended_to_carbon_reading').attr('disabled',true);"; 

      $disable_cancel="$('#cancellation_performing_id,#cancellation_issuing_id').attr('disabled',true);";

      $disable_all="$('input,select').attr('disabled',true);";

       switch($show_flag)
       {
          case 1:  //Inititate Create
       ?>           
                   <?php echo $disable_cancel; echo $disable_extend; ?>
       <?php
                    break; 
          case 2:  //If PA Come back
       ?>
                    $('#acceptance_performing_id').attr('disabled',true);
                    <?php echo $disable_extend; echo $disable_cancel; 
                    break;             
          case 3:        //IF SA come back
       ?>   
                   $('#acceptance_performing_id,#acceptance_issuing_id').attr('disabled',true);  
                   <?php echo $disable_extend; ?>
                                 
       <?php   
                     break;
          case 4:      //Set Cancel/Complete
       ?>
                     <?php echo $disable_all; ?>
                     $('.status').removeAttr('disabled');
       <?php 
                    break;     
          case 5:
       ?>
                      <?php echo $disable_all; ?>
                      
       <?php    
                    break;            
          case 6:   //Extend Safety
       ?> 
                      <?php echo $disable_all; ?>
                      $('.extended_oxygen_<?php echo $exten_time_period.$enable_extend_inputs; ?>,.extended_gases_<?php echo $exten_time_period.$enable_extend_inputs; ?>,.extended_carbon_<?php echo $exten_time_period.$enable_extend_inputs; ?>').prop('disabled',false);
                      console.log('Extend');
                      
       <?php   
                      break;
          case 7:     //Extend IA
       ?>
                       <?php echo $disable_all; ?>
                      $('.watch_person_<?php echo $exten_time_period.$enable_extend_inputs; ?>,.watch_other_person_<?php echo $exten_time_period.$enable_extend_inputs; ?>').prop('disabled',false);
       <?php
                      break;  
          case 8:     //New Date Extend
       ?>   
                       <?php echo $disable_all; ?> 
                       $('.status').removeAttr('disabled'); 
                       $('#schedule_date<?php echo $enable_extend_inputs; ?>').prop('disabled',false);
                       $('.status:checked').trigger('click');
                       console.log('Extend Date');
       <?php
                      break;      
          case 9:     //Disable current date and next date with "TO"
       ?>   
                       <?php echo $disable_all; ?> 
                       $('.status').removeAttr('disabled'); 
                       $('#schedule_date<?php echo $enable_extend_inputs; ?>').prop('disabled',true);
                       $('.status:checked').trigger('click');
                       console.log('Extend Date');
       <?php
                      break;                                                                                                      
          default:
       ?>  
                   <?php echo $disable_all; ?>
       <?php
                   break;                                          
       }

       ?>
     
      

      <?php

      $flag='true';
      
      $arr = range('a', 'm');   
      
      $validate='';
      for($i=0;$i<count($arr);$i++)
      {
        $validate.=",'hazards[".$arr[$i]."]': {required:".$flag."},'precautions[".$arr[$i]."]': {required:".$flag."}";
      }
      
      if(!empty($record_id))
      {
        $validate.=",status:{required:true}";
        
        $validate.=",cancellation_performing_id : { required:function(element) { if($('input[name=status]:checked').val()=='Completion' || $('input[name=status]:checked').val()=='Cancellation') return true; else return false;  }},cancellation_issuing_id: { required:function(element) { if($('#cancellation_performing_id').val()!='') return true; else return false; }}"; 
        
        $arr=range('a','f');
        
        for($i=0;$i<count($arr);$i++)
        {
          $validate.=",'schedule_date[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=status]:checked').val()=='Extended')
                          return true; 
                          else return false;
                         }}";
          $validate.=",'schedule_from_time[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_date[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";    

          $validate.=",'schedule_to_time[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_date[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";                     

          $validate.=",'watch_person_to_time[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_to_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";      

          $validate.=",'watch_person_from_time[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_from_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";                               

          $validate.=",'watch_other_person_to_names[".$arr[$i]."][1]':{required:function(element) {
                          if($('input[name=\"schedule_to_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";      

          $validate.=",'watch_other_person_from_names[".$arr[$i]."][1]':{required:function(element) {
                          if($('input[name=\"schedule_from_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";                               

          $validate.=",'extended_to_oxygen_reading[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_to_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         },range:[19.25,23.5]}";                                                                           

          $validate.=",'extended_from_oxygen_reading[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_from_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         },range:[19.25,23.5]}";                                                                           


          $validate.=",'extended_to_gases_reading[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_to_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         },range:[0,5]}";                                                                           

          $validate.=",'extended_from_gases_reading[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_from_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         },range:[0,5]}";                                                                           


          $validate.=",'extended_to_carbon_reading[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_to_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         },range:[0,25]}";                                                                           

          $validate.=",'extended_from_carbon_reading[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_from_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         },range:[0,25]}";   
        
          $validate.=",'extended_performing_to_authority[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_to_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";
        
           $validate.=",'extended_performing_from_authority[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_from_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";

          $validate.=",'extended_safety_to_sign_id[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_to_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";
          $validate.=",'extended_safety_from_sign_id[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_from_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";                       

          $validate.=",'extended_issuing_to_authority[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_to_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";
          $validate.=",'extended_issuing_from_authority[".$arr[$i]."]':{required:function(element) {
                          if($('input[name=\"schedule_from_time[".$arr[$i]."]\"]').val()!='')
                          return true; 
                          else return false;
                         }}";                       

        }
          
      }
    
      #if($acceptance_performing_id==$user_id && $approval_status==1)
      if($acceptance_performing_id==$user_id) #&& $approval_status<=2
      $validate.=",'self_cancellation_description':{required:function(element) {
                            if($('input[name=self_cancellation]:checked').val()=='cancel' || $('.status:checked').val()=='Cancellation')
                            return true; 
                            else return false;
                           }}";
     ?>
    
    $("#job_form").validate({ 
              ignore: '.ignore',
              focusInvalid: true, 
      rules: {
        department_id:{required:<?php echo $flag; ?>},
        zone_id:{required:<?php echo $flag; ?>},        
        'other_inputs[]': {required:<?php echo $flag; ?>},
        'works[]': { required:<?php echo $flag; ?>,minlength:1},
        other_contractors : {  required:function(element) { if($('#contractor_id').val()=='others') return true; else return false;  }   },
        contractor_id:{required:<?php echo $flag; ?>},
                location:{required:<?php echo $flag; ?>},
        location_date: { required:<?php echo $flag; ?> },
        location_time_start: { required:<?php echo $flag; ?> },
        location_time_to: { required:<?php echo $flag; ?> },
        equipment_name: { required:<?php echo $flag; ?> },
        job_name: { required:<?php echo $flag; ?> },       
        acceptance_performing_id : { required:<?php echo $flag; ?>},
        acceptance_issuing_id : { required:<?php echo $flag; ?>},
        status : { required: <?php echo $flag; ?> },
        job_name : { required:<?php echo $flag; ?> },
        access_card : { required:<?php echo $flag; ?> },
        oxygen_reading : {required:<?php echo $flag; ?>,range:[19.25,23.5]},
        gases_reading : {required:<?php echo $flag; ?>,range:[0,5]},
        carbon_reading : {required:<?php echo $flag; ?>,range:[0,25]},
        required_ppe_other : { required:<?php echo $flag; ?>},
        acceptance_safety_sign_id : {required:<?php echo $flag; ?>},
        watch_person_name : { required:<?php echo $flag; ?> },
        'watch_other_person_names[]': { required:<?php echo $flag; ?> },       
        'isoloation_permit_no' : { required:function(element) {
                          if($('input[name="is_isoloation_permit"]:checked').val()!='N/A') 
                          return <?php echo $flag; ?>;
                          else
                          return false;         
           },minlength:1}
        <?php echo $validate; ?>            
            },
      messages:
      {
        department_id : {required:'Required' },
        zone_id : {required:'Required' },
        contractor_id : {required:'Required' },
        location:{required:'Required' },
        location_date:{required:'Required' },
        location_time_start:{required:'Required' },
        location_time_to:{required:'Required' },
        equipment_name:{required:'Required' },
        job_name:{required:'Required' }
      },
      highlight: function( element, errorClass, validClass )
              {
                // select2/*if($('input[name="photos_attached[1]"]').val()=='') return validate_flag; else return false;}*/
                if( $(element).hasClass('select2-hidden-accessible') ){
                    dzik = $(element).next('span.select2');

                    if(dzik)
                        dzik.addClass( errorClass ).removeClass( validClass );
                }
                else {

                    if($(element).attr('name')!='isoloation_permit_no') 
                        $(element).addClass(errorClass).removeClass(validClass);
                    else
                         $(element).parents("div.control-group").addClass(errorClass).removeClass(validClass);

                    //console.log('Error '+errorClass+' = '+validClass+" = = "+$(element).attr('name'));
                  } 
                    
            },  
             unhighlight: function (element, errorClass, validClass) {
                 var elem = $(element);
                 if (elem.hasClass("select2-hidden-accessible")) {
                      $("#select2-" + elem.attr("id") + "-container").parent().removeClass(errorClass);
                 } else {
                     elem.removeClass(errorClass);

                     
                 }
             },
    errorPlacement: function(error,element){
            error.appendTo(element.parent().parent());                        
        }/*,
    showErrors: function(errorMap, errorList) {
        if (submitted) {
          var summary = "You have the following errors: <br/>";
          $.each(errorList, function() { summary += " * " + this.message + "<br/>"; });
          $("#form_errors").html(summary);
          //submitted = false;
        }
        //--> if you dont want to see the errors in line remove this below line?
        this.defaultShowErrors();
      }*/,          
    invalidHandler: function(form, validator) {
      submitted = true;
    },          
        submitHandler:function(){
      
      
      //if( $("input[name=is_isoloation_permit]:checked").val()=='Yes' && $('.selected_eip option:selected').length<=0)
      if($.inArray($("input[name=is_isoloation_permit]:checked").val(), [ "Yes", "yes_existing"])!==-1   && $('.selected_eip option:selected').length<=0)
      {
         
          $('#is_popup_submit').val('0');
      }
      
      //if($("input[name=is_isoloation_permit]:checked").val()=='Yes' && $('#is_popup_submit').val()!=1)
      if($.inArray($("input[name=is_isoloation_permit]:checked").val(), [ "Yes", "yes_existing"])!==-1   && $('#is_popup_submit').val()!=1)
      {
        var isoloation_permit_no='';
        
        <?php
        if(!empty($record_id))
        {
        ?>  
          if($('.selected_eip option:selected').length>0)
          var isoloation_permit_no=$('.selected_eip option:selected:eq(0)').val();
        <?php } ?>
      
        
          if(isoloation_permit_no=='')
          { 
            var url = "<?php echo base_url(); ?>jobs/ajax_show_energy_info/id/"+isoloation_permit_no+"?TB_iframe=true&keepThis=true&width=1150&height=550";
            
            tb_show("Energy Isolation Permit Form", url);     

            console.log('sDFDSFDSf');  
          }
          else
          $('#is_popup_submit').val(1);
      }
      else
      $('#is_popup_submit').val(1);
      
      //alert('Submit');return false;
      
      if($('#is_popup_submit').val()==1)
      form_submit();
      
            return false;   
      
        }
    });
  
    $.validator.addMethod('minStrict', function (value, el, param) {
      return value > param;
    }); 
  
    function form_submit()
    {
      
          //alert('Parent;'); return false;
      
          var data = new FormData();          
          var $inputs = $('form#job_form :input[type=text],form#job_form :input[type=hidden],select');
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
          
          var vls='';
          $(".required_ppe:checked").each(function ()
          {
            vls+=$(this).val()+',';
          });
          
          data.append('required_ppe',vls);
    
    
          var vls='';
          $(".other_inputs:checked").each(function ()
          {
            vls+=$(this).val()+',';
          });
          
          data.append('other_inputs',vls);         
          
         
          $(".precautions:checked").each(function ()
          {
            data.append(this.name,$(this).val());
          });
          
    
          $(".hazards:checked").each(function ()
          {
            data.append(this.name,$(this).val());
          });        
         
          
          $(".precautions:checked").each(function ()
          {
            data.append(this.name,$(this).val());
          });

          data.append('access_card',$('input[name=access_card]:checked').val());
          
          data.append('is_isoloation_permit',$('input[name=is_isoloation_permit]:checked').val());
          
          data.append('acceptance_performing_date',$('#acceptance_performing_date').val());
          
          data.append('acceptance_issuing_date',$('#acceptance_issuing_date').val());

          data.append('cancellation_performing_date',$('#cancellation_performing_date').val());
          
          data.append('cancellation_issuing_date',$('#cancellation_issuing_date').val());
          
        $("#job_form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled',true);   
        $(".btn-danger").attr('disabled',true);   
          
          
          if($('input[name=status]').length>0)
          data.append('status',$('input[name=status]:checked').val());
           
          $.ajax({
                  url: base_url+'confined_permits/form_action',
                  type: 'POST',
                  "beforeSend": function(){ },
                  data: data,
                  cache: false,
                  dataType: 'json',
                  processData: false, // Don't process the files
                  contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                  success: function(data, textStatus, jqXHR)
                  {
                        
                       //alert('Success'); return false;

                    //   window.location.href='<?php echo $redirect;?>';
                    if(data.print_out!='')
                    {
                      $('.print_out:first').trigger('click');
                      
                       setTimeout(function () { 
                            window.location.href='<?php echo $redirect;?>';
                         }, 10 * 1000);
                      
                    }
                    else                    
                    {
                      window.location.href='<?php echo $redirect;?>';
                    }             
                  },
                  error: function(data, textStatus,errorThrown)
                  {
                      $('#error').show();
                      
                      $('#error_msg').html(data.failure);
                  }
                });       
    }

});
</script>
