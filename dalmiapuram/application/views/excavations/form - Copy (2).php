<?php 
#error_reporting(0); 
$page_name='Create Permit';

$readonly=false;

$status=$eip_opened=$approval_status='';

 $job_approval_status=unserialize(JOBAPPROVALS);

 if(!empty($records))
 {
   $page_name='Edit Permit';
   
   $record_id=$records['id'];
   
   $show_button=$records['show_button'];
   
   $acceptance_performing_id=$records['acceptance_performing_id'];
   
   $acceptance_issuing_id=$records['acceptance_issuing_id'];
   
   $record_user_id = $records['user_id'];
   
   if($show_button=='hide')
   $readonly=true;

   $approval_status = $records['approval_status'];
 }
 else
 $record_id=''; 
 
 $permission=$this->session->userdata('permission');
 $user_role=strtolower($this->session->userdata('user_role'));
 $this->load->view('layouts/header',array('page_name'=>$page_name));
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
table.form_work tr td { padding:0px 5px 0 5px; }
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
.form-control { margin-bottom: 5px;  }
table#extendable select { margin-top:3px; }
</style>
<?php

$border_top="0px solid #231f20";
$border_bottom="0px solid #231f20";


 if(isset($records))
 $precautions=json_decode($records['precautions']);
 else
 $precautions=array();

 if(isset($records))
 $m_depth=json_decode($records['m_depth']);
 else
 $m_depth=array();


 if(isset($records))
 $dept_issuing_id=json_decode($records['dept_issuing_id']);
 else
 $dept_issuing_id=array();

 if(isset($records))
 $dept_issuing_date=json_decode($records['dept_issuing_date']);
 else
 $dept_issuing_date=array();

 if(isset($records))
 $dept_approval_status=json_decode($records['dept_approval_status']);
 else
 $dept_approval_status=array();

 if(isset($records))
 $dept_remarks=json_decode($records['dept_remarks']);
 else
 $dept_remarks=array();

 $acceptance_issuing_approval=(isset($records['acceptance_issuing_approval'])) ? $records['acceptance_issuing_approval'] : '';

 $acceptance_performing_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';

 $acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';

 $disable_common_fields='';

 if($record_id!='')
 {
    if($user_id!=$acceptance_performing_id && $user_id!=$acceptance_issuing_id) #&& $acceptance_issuing_approval!='Yes'
     $disable_common_fields='disabled="disabled"';
 }    
?>
<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>excavations/"><i class="fa fa-home"></i>Excavation</a></li>
                                <li class="active"><?php echo (isset($records['id'])) ? 'Edit' : 'New'.' Permit'; ?></li>
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
                                        
                          <?php $this->load->view('layouts/msg'); ?>              
<form id="job_form" name="job_form" enctype="multipart/form-data" > 
      <input type="hidden" id="id" name="id" value="<?php echo (isset($records['id'])) ? $records['id'] : ''; ?>" />
      <input type="hidden" id="permit_no" name="permit_no" value="<?php echo (isset($records['permit_no'])) ? $records['permit_no'] : $permit_no ?>" />
      <input type="hidden" id="last_modified_id" name="last_modified_id" value="<?php echo (isset($records['last_modified_id'])) ? $records['last_modified_id'] : ''; ?>" />
                                                    
            <?php
            if(!empty($record_id))
            {
             
            ?>  
                        <a href="javascript:void(0);" style="float:right;" 
                        data-id="<?php echo $record_id; ?>" class="print_out"><i class="fa fa-print">Print PDF</i></a>
                        <?php
            }
            ?>

                                                                
   <table cellspacing="0" border="0" width="100%" align="center" class="form_work">
             <tr height=36 style='height:27.0pt'>
                            <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan= height="30" align="left" width="25% !important;" valign=top><b>Select Department </b>
                               <input type="hidden" name="department_id" id="department_id" value="<?php echo $department['id']; ?>" />
                              <br /><?php echo $department['name']; ?>                              <br /></td>

                            <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan= height="30" align="left" width="25% !important;" valign=top><b>Zone</b>
                              <select class="form-control" name="zone_id" id="zone_id" style="width:200px;" <?php echo $disable_common_fields; ?>>
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
    <td style="border-top: 1px solid #231f20; border-bottom: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan=2 height="30" align="left" class="title"  valign=top>Location <br /><input type="text" class="form-control" name="location" id="location" value="<?php echo (isset($records['location'])) ? $records['location'] : ''; ?>"  <?php echo $disable_common_fields; ?>/></td>
   
    <td style="; border-left: 1px solid #231f20; border-right: 1px solid #231f20;" valign="middle" colspan=6  class="title" width="500" align="left" valign=top>
  
  <b>Mechanical Department:</b></td>
    </tr>
  
  <tr>
    <td style="border-top: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan= height="37" align="left" valign=top><b>Date From </b><br><input type="text" readonly="readonly" class="form-control" name="location_time_start" id="location_time_start" style="width:175px;" value="<?php echo (isset($records['location_time_start'])) ? $records['location_time_start'] : date('d-m-Y H:i'); ?>"  />      </td>
  
    <td style="border-top: 1px solid #231f20; border-left: 1px solid #231f20; border-right: 1px solid #231f20" colspan= align="left" valign=top><b>Date To </b><br><input type="text" readonly="readonly" class="form-control" name="location_time_to" id="location_time_to" style="width:175px;" value="<?php echo (isset($records['location_time_to'])) ? $records['location_time_to'] : ''; ?>" />      </td>
 
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-left: 1px solid #231f20; border-right: 0px solid #231f20" colspan=5 align="left" valign=top>1) Underground Pipe Lines</td>
   
  <?php
  $dept_issue_id=(isset($dept_issuing_id->d)) ? $dept_issuing_id->d : '';

  $disabled='disabled=disabled';

  $d_approval_status= (isset($dept_approval_status->d)) ? $dept_approval_status->d : '';

  if($user_id==$dept_issue_id && $d_approval_status!='Yes')
  {
      $disabled='';

      if($d_approval_status!='Yes')
      $dept_issuing_date->d=date('d-m-Y H:i'); 
  }

  ?>  
   <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-left: 0px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top> <center>
                            <input name="precautions[d]" data-attr="d" data-checkbox='true'  type="radio"  class="radio_button precautions" value="Yes" <?php if(isset($precautions->d) && $precautions->d=='Yes') { ?> checked="checked" <?php } echo $disabled; ?> />
                              Y&nbsp;
                              <input type="radio" name="precautions[d]" class="radio_button precautions" value="No" data-attr="d"  <?php if(isset($precautions->d) && $precautions->d=='No') { ?> checked="checked" <?php } echo $disabled; ?> />
                              N&nbsp;</center>
    </td>
    
  </tr>
  <tr>
    <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=5 height="270" align="left" valign=top class="title"> 
  <strong>This Permits Cover</strong><br>
  1) Any excavation on the ground<br>
  2) Road Concreate Breaking<br>  <br>
  <div class="col-sm-9">Description  of  Work:

    <input type="text" class="form-control" name="job_name" id="job_name" value="<?php echo (isset($records['job_name'])) ? $records['job_name'] : ''; ?>" <?php echo $disable_common_fields; ?> />


  </div>
  <div class="col-sm-3">Earth work depth:

    <input type="text" class="form-control" name="earth_work_depth" id="earth_work_depth" value="<?php echo (isset($records['earth_work_depth'])) ? $records['earth_work_depth'] : ''; ?>" <?php echo $disable_common_fields; ?> />


  </div>


  <br>

  <div class="col-sm-4" style="clear:both;"><br /><b>Permit Issued to</b><br /></div>
  
  <div class="col-sm-6" style="clear:both;">
  <br />
  Name  of  Contractor 
    <select class="form-control" name="contractor_id" id="contractor_id" style="width:200px;" <?php echo $disable_common_fields; ?>>
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
                              <input type="text" <?php echo $disable_common_fields; ?> value="<?php echo $other_contractors; ?>" name="other_contractors" id="other_contractors" class="form-control" style="width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  />
      </div>                        
<div class="col-sm-3"><br />
    No of Persons<input type="text"  value="<?php echo (isset($records['contractors_involved'])) ? $records['contractors_involved'] : ''; ?>" name="contractors_involved" id="contractors_involved" class="form-control numinput" style="width:130px;" <?php echo $disable_common_fields; ?>/>
</div>  

  <?php
  $dept_issue_id=(isset($dept_issuing_id->d)) ? $dept_issuing_id->d : '';

  $disabled='disabled=disabled';

  $d_approval_status= (isset($dept_approval_status->d)) ? $dept_approval_status->d : '';

  if($user_id==$dept_issue_id && $d_approval_status!='Yes')
  {
      $disabled='';

      if($d_approval_status!='Yes')
      $dept_issuing_date->d=date('d-m-Y H:i'); 
  }

  ?>  
  </td>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 1px solid #231f20" colspan="6" align="left" valign=top>
  <div class="col-sm-12 text-left" style="padding-left:0px !important;">2)Underground Pipe Line at  <input type="text"  name="m_depth[d]" id="mec_depth" value="<?php echo (isset($m_depth->d)) ? $m_depth->d : ''; ?>" <?php echo $disabled; ?>> in depth</div>


<br>

  <div class="col-sm-9"><b>Remarks (If any):</b><br />
    <textarea name="dept_remarks[d]" class="form-control" rows="5" cols="30" <?php if($d_approval_status=='Yes') { ?> disabled="disabled" <?php } ?> <?php echo $disable_common_fields; ?>><?php echo (isset($dept_remarks->d)) ? $dept_remarks->d : ''; ?></textarea>
  </div>


  <div class="col-sm-6 "><b>Name</b>

<select id="me_dept_issuing_id" name="dept_issuing_id[d]" <?php if($d_approval_status=='Yes') { ?> disabled="disabled" <?php } ?> class="form-control authority performing dept_issuing_id">
                                  <option value="" selected="selected">- - Select - -</option>
  <?php
  $dept_issue_id=(isset($dept_issuing_id->d)) ? $dept_issuing_id->d : '';
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
             $flag=0;
             else
             $flag=1;
          }
          else
          $flag=1;
          
      if($flag==1 && $fet['department_id']==EIP_MECHANICAL)
      {
          if($dept_issue_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>

  </div><div class="col-sm-6"><b>Digital Sign/Date & Time</b>
<input type="text" style="width:150px;" value="<?php echo (isset($dept_issuing_date->d)) ? $dept_issuing_date->d : ''; ?>"  name="dept_issuing_date[d]" class="form-control" readonly="readonly" />

<input type="hidden" style="width:150px;" value="<?php echo (isset($dept_approval_status->d)) ? $dept_approval_status->d : ''; ?>"  name="dept_approval_status[d]" class="form-control" readonly="readonly" />


  </div> 

</td>
    </tr>
  
   
  <tr>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 1px solid #231f20" colspan=6 align="left" valign=top><b>Safety Department</b></td>
 </tr>
 
  <?php
  $dept_issue_id=(isset($dept_issuing_id->e)) ? $dept_issuing_id->e : '';

  $disabled='disabled=disabled';

  $d_approval_status= (isset($dept_approval_status->e)) ? $dept_approval_status->e : '';

  if($user_id==$dept_issue_id && $d_approval_status!='Yes')
  {
      $disabled='';

      if($d_approval_status!='Yes')
      $dept_issuing_date->e=date('d-m-Y H:i'); 
  }


  ?>   
  <tr>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right:0px solid #231f20" colspan=5 align="left" valign=top>1) Underground Fire Hydrant Line is passing through the area</td>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-left: 0px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input type="radio"  name="precautions[e]" class="radio_button precautions" data-checkbox="true" data-attr="e" value="Yes" <?php if(isset($precautions->e) && $precautions->e=='Yes') { ?> checked="checked" <?php } echo $disabled; ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($precautions->e) && $precautions->e=='No') { ?> checked="checked" <?php } echo $disabled; ?> class="radio_button precautions"  name="precautions[e]" data-attr="e" value="No" data-checkbox="true" />
                              N&nbsp;
                              </center></td>
    
  </tr>
  
  <tr>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 1px solid #231f20" colspan=6 align="left" valign=top><br />2) Underground Fire Hydrant line at <input type="text"  name="m_depth[e]" id="saf_depth"  value="<?php echo (isset($m_depth->e)) ? $m_depth->e : ''; ?>" <?php echo $disabled; ?>> m depth <br /></td>
  </tr>
  
  
  <tr>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 1px solid #231f20" colspan=6 align="left" valign=top><br />Excavation to be done by Manual : <input type="text" name="manual_done" id="manual_done" value="<?php echo (isset($records['manual_done'])) ? $records['manual_done'] : ''; ?>" <?php echo $disabled; ?>> Powerd : <input type="text" name="powered" id="powered" value="<?php echo (isset($records['powered'])) ? $records['powered'] : ''; ?>" <?php echo $disabled; ?>> <br /><br /></td>
  </tr>

  <?php
  $dept_issue_id=(isset($dept_issuing_id->a)) ? $dept_issuing_id->a : '';

  $disabled='disabled=disabled';

  $d_approval_status= (isset($dept_approval_status->a)) ? $dept_approval_status->a : '';

  if($user_id==$dept_issue_id && $d_approval_status!='Yes')
  {
      $disabled='';

      if($d_approval_status!='Yes')
      $dept_issuing_date->a=date('d-m-Y H:i'); 
  }


  ?>
  <tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=4 height="" align="left" valign=top><b>Electrical Department: </b><br>
  1) Underground Electrical cables are passing through the area <span style="float:right;"><input type="radio"  name="precautions[a]" class="radio_button precautions" data-checkbox="true" data-attr="a" value="Yes" <?php if(isset($precautions->a) && $precautions->a=='Yes') { ?> checked="checked" <?php } ?>  <?php echo $disabled; ?>/>
                              Y&nbsp;
                              <input type="radio" <?php if(isset($precautions->a) && $precautions->a=='No') { ?> checked="checked" <?php } ?> class="radio_button precautions"  name="precautions[a]" data-attr="a" value="No" data-checkbox="true" <?php echo $disabled; ?>/>
                              N&nbsp;</span><br>
    2) Underground Electrical Cables at <input type="text"  name="m_depth[a]" id="el_depth" value="<?php echo (isset($m_depth->a)) ? $m_depth->a : ''; ?>" <?php echo $disabled; ?>> m depth<br>
  <br>
  <div class="col-sm-9"><b>Remarks (If any):</b><br />
    <textarea name="dept_remarks[a]" class="form-control" rows="5" cols="30" <?php echo $disable_common_fields; ?> <?php if($d_approval_status=='Yes') { ?> disabled="disabled" <?php } ?>><?php echo (isset($dept_remarks->a)) ? $dept_remarks->a : ''; ?></textarea>
  </div>


  <div class="col-sm-6 "><b>Name</b>

            <select id="el_dept_issuing_id" <?php if($d_approval_status=='Yes') { ?> disabled="disabled" <?php } ?> name="dept_issuing_id[a]"  class="form-control authority performing dept_issuing_id">
                                  <option value="" selected="selected">- - Select - -</option>
  <?php
  
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
             $flag=0;
             else
             $flag=1;
          }
          else
          $flag=1;
          
      if($flag==1 && $fet['department_id']==EIP_ELECTRICAL)
      {
          if($dept_issue_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>

  </div><div class="col-sm-6"><b>Digital Sign/Date & Time</b>
<input type="text" style="width:150px;" value="<?php echo (isset($dept_issuing_date->a)) ? $dept_issuing_date->a : ''; ?>"  name="dept_issuing_date[a]" class="form-control" readonly="readonly" />

<input type="hidden" style="width:150px;" value="<?php echo $d_approval_status; ?>"  name="dept_approval_status[a]" class="form-control" readonly="readonly" />

  </div> 

   </td>
   
   
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 1px solid #231f20" colspan=6 align="left" valign=top><b>Other Precautions</b></td>
    
  </tr>
  
  <?php
  $dept_issue_id=(isset($dept_issuing_id->e)) ? $dept_issuing_id->e : '';

  $disabled='disabled=disabled';

  $d_approval_status= (isset($dept_approval_status->e)) ? $dept_approval_status->e : '';

  if($user_id==$dept_issue_id && $d_approval_status!='Yes')
  {
      $disabled='';

      if($d_approval_status!='Yes')
      $dept_issuing_date->e=date('d-m-Y H:i'); 
  }

  ?>    
  <tr>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom: <?php echo $border_bottom; ?>; border-right: 0px solid #231f20" colspan=5 align="left" valign=top>1) Work area Barricaded</td>
<td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-left: 0px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input type="radio"  name="precautions[f]" class="radio_button precautions" data-checkbox="true" data-attr="f" value="Yes" <?php if(isset($precautions->f) && $precautions->f=='Yes') { ?> checked="checked" <?php } echo $disabled; ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($precautions->f) && $precautions->f=='No') { ?> checked="checked" <?php } echo $disabled; ?> class="radio_button precautions"  name="precautions[f]" data-attr="f" value="No" data-checkbox="true" />
                              N&nbsp;</center>
    </td> 
 </tr>
   
  
  <tr>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 0px solid #231f20" colspan=5 align="left" valign=top>2) Arrangements made for road diversion</td>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-left: 0px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input type="radio"  name="precautions[g]" class="radio_button precautions" data-checkbox="true" data-attr="g" value="Yes" <?php if(isset($precautions->g) && $precautions->g=='Yes') { ?> checked="checked" <?php } echo $disabled; ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($precautions->g) && $precautions->g=='No') { ?> checked="checked" <?php } echo $disabled; ?> class="radio_button precautions"  name="precautions[g]" data-attr="g" value="No" data-checkbox="true" />
                              N&nbsp;</center></td>
  </tr>
  
  <tr>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 0px solid #231f20" colspan=5 align="left" valign=top>3) Arrangements made for climbing up and down </td>
<td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-left: 0px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input type="radio"  name="precautions[h]" class="radio_button precautions" data-checkbox="true" data-attr="h" value="Yes" <?php if(isset($precautions->h) && $precautions->h=='Yes') { ?> checked="checked" <?php } echo $disabled; ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($precautions->h) && $precautions->h=='No') { ?> checked="checked" <?php } echo $disabled; ?> class="radio_button precautions"  name="precautions[h]" data-attr="h" value="No" data-checkbox="true" />
                              N&nbsp;</center>
    </td>   
   </tr>
   
   
   
  <?php
  $dept_issue_id=(isset($dept_issuing_id->b)) ? $dept_issuing_id->b : '';

  $disabled='disabled=disabled';

  $d_approval_status= (isset($dept_approval_status->b)) ? $dept_approval_status->b : '';

  if($user_id==$dept_issue_id && $d_approval_status!='Yes')
  {
      $disabled='';

      if($d_approval_status!='Yes')
      $dept_issuing_date->b=date('d-m-Y H:i'); 
  }


  #echo 'FFAnand '.$disable_common_fields.' = '.$d_approval_status;
  ?>   
  <tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=5 height="" align="left" valign=top><b>Instrument Department:</b> <br>
  1) Underground Instrument cables are passing through the area <span style="float:right;"><input type="radio"  name="precautions[b]" class="radio_button precautions" data-checkbox="true" data-attr="b" value="Yes" <?php if(isset($precautions->b) && $precautions->b=='Yes') { ?> checked="checked" <?php } ?> <?php echo $disabled; ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($precautions->b) && $precautions->b=='No') { ?> checked="checked" <?php } ?> class="radio_button precautions"  name="precautions[b]" data-attr="b" value="No" data-checkbox="true" <?php echo $disabled; ?> />
                              N&nbsp;</span><br>
    2) Underground Instrument Cables at <input type="text"  name="m_depth[b]" id="it_depth" value="<?php echo (isset($m_depth->b)) ? $m_depth->b : ''; ?>" <?php echo $disabled; ?> > m depth<br>
  <br>

  <div class="col-sm-9"><b>Remarks (If any):</b><br />
    <textarea name="dept_remarks[b]" class="form-control" rows="5" cols="30" <?php echo $disable_common_fields; ?> <?php if($d_approval_status=='Yes') { ?> disabled="disabled" <?php } ?> ><?php echo (isset($dept_remarks->b)) ? $dept_remarks->b : ''; ?></textarea>
  </div>


  <div class="col-sm-6 "><b>Name</b>

<select id="in_dept_issuing_id" <?php if($d_approval_status=='Yes') { ?> disabled="disabled" <?php } ?>  name="dept_issuing_id[b]"  class="form-control authority performing dept_issuing_id">
                                  <option value="" selected="selected">- - Select - -</option>
  <?php
 
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
             $flag=0;
             else
             $flag=1;
          }
          else
          $flag=1;
          
      if($flag==1 && $fet['department_id']==EIP_INSTRUMENTAL)
      {
          if($dept_issue_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>

  </div><div class="col-sm-6"><b>Digital Sign/Date & Time</b>
<input type="text" style="width:150px;" value="<?php echo (isset($dept_issuing_date->b)) ? $dept_issuing_date->b : ''; ?>"  name="dept_issuing_date[b]" class="form-control" readonly="readonly" />

<input type="hidden" style="width:150px;" value="<?php echo $d_approval_status; ?>"  name="dept_approval_status[b]" class="form-control" readonly="readonly" />

  </div> 

   </td>

  <?php
  $dept_issue_id=(isset($dept_issuing_id->e)) ? $dept_issuing_id->e : '';

  $disabled='disabled=disabled';

  $d_approval_status= (isset($dept_approval_status->e)) ? $dept_approval_status->e : '';

  if($user_id==$dept_issue_id && $d_approval_status!='Yes')
  {
      $disabled='';

      if($d_approval_status!='Yes')
      $dept_issuing_date->e=date('d-m-Y H:i'); 
  }


  ?>    
   
     <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 0px solid #231f20" colspan=5 align="left" valign=top>4)Arrangements made for Removing Excess excavated soil</td>
<td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-left: 0px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><center>
                            <input type="radio"  name="precautions[i]" class="radio_button precautions" data-checkbox="true" data-attr="i" value="Yes" <?php if(isset($precautions->i) && $precautions->i=='Yes') { ?> checked="checked" <?php } echo $disabled; ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($precautions->i) && $precautions->i=='No') { ?> checked="checked" <?php } echo $disabled; ?> class="radio_button precautions"  name="precautions[i]" data-attr="i" value="No" data-checkbox="true" />
                              N&nbsp;</center>
    </td
  </tr>
  
  
  <tr>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 0px solid #231f20" colspan=5 align="left" valign=top>
    <br />5)Arrangements made for shoring /shuttering</td>
<td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-left: 0px solid #231f20; border-right: 1px solid #231f20" align="left" valign=top><br /><center>
                            <input type="radio"  name="precautions[j]" class="radio_button precautions" data-checkbox="true" data-attr="j" value="Yes" <?php if(isset($precautions->j) && $precautions->j=='Yes') { ?> checked="checked" <?php } echo $disabled; ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($precautions->j) && $precautions->j=='No') { ?> checked="checked" <?php } echo $disabled; ?> class="radio_button precautions"  name="precautions[j]" data-attr="j" value="No" data-checkbox="true" />
                              N&nbsp;</center>
    </td> 
 </tr>

 <tr>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>
      <br />
      <div class="col-sm-9"><b>Remarks (If any):</b><br />
    <textarea name="dept_remarks[e]" class="form-control" rows="5" cols="30" <?php if($d_approval_status=='Yes') { ?> disabled="disabled" <?php } ?> <?php echo $disable_common_fields; ?>><?php echo (isset($dept_remarks->e)) ? $dept_remarks->e : ''; ?></textarea><br /> 
  </div>

 
    </td>

 </tr>
   
  
  <tr>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 1px solid #231f20" colspan=6 align="left" valign=top></td>
  </tr>
  
  <tr>
    <td style="border-top: <?php echo $border_top; ?>; border-bottom:<?php echo $border_bottom; ?>; border-right: 1px solid #231f20" colspan=6 align="left" valign=top>

      <div class="col-sm-6 "><b>Name</b>

<select id="saf_dept_issuing_id" name="dept_issuing_id[e]" <?php if($d_approval_status=='Yes') { ?> disabled="disabled" <?php } ?> class="form-control authority performing dept_issuing_id">
                                  <option value="" selected="selected">- - Select - -</option>
  <?php
  $dept_issue_id=(isset($dept_issuing_id->e)) ? $dept_issuing_id->e : '';
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
             $flag=0;
             else
             $flag=1;
          }
          else
          $flag=1;
          
      if($flag==1 && $fet['department_id']==EIP_SAFETY)
      {
          if($dept_issue_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>

  </div><div class="col-sm-6"><b>Digital Sign/Date & Time</b>
<input type="text" style="width:150px;" value="<?php echo (isset($dept_issuing_date->e)) ? $dept_issuing_date->e : ''; ?>"  name="dept_issuing_date[e]" class="form-control" readonly="readonly" />

<input type="hidden" style="width:150px;" value="<?php echo (isset($dept_approval_status->e)) ? $dept_approval_status->e : ''; ?>"  name="dept_approval_status[e]" class="form-control" readonly="readonly" />

  </div> 

    <br><br> <br><br> <br><br>
    <div class="col-sm-6"><b>Performing Authority</b>


    </div><div class="col-sm-6 text-left"><b>Issuing Authority</b>


    </div>
    
    </td>     
   </tr>
   
  <?php
  $dept_issue_id=(isset($dept_issuing_id->c)) ? $dept_issuing_id->c : '';

  $disabled='disabled=disabled';

  $d_approval_status= (isset($dept_approval_status->c)) ? $dept_approval_status->c : '';

  if($user_id==$dept_issue_id && $d_approval_status!='Yes')
  {
      $disabled='';

      if($d_approval_status!='Yes')
      $dept_issuing_date->c=date('d-m-Y H:i'); 
  }

  ?>  

  <tr>
    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan= height="" align="left" valign=top><b>IT Department:</b> <br>
  1) Underground IT cables are passing through the area <span style="float:right;"><input type="radio"  name="precautions[c]" class="radio_button precautions" data-checkbox="true" data-attr="c" value="Yes" <?php if(isset($precautions->c) && $precautions->c=='Yes') { ?> checked="checked" <?php } echo $disabled; ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($precautions->c) && $precautions->c=='No') { ?> checked="checked" <?php } echo $disabled; ?> class="radio_button precautions"  name="precautions[c]" data-attr="c" value="No" data-checkbox="true" />
                              N&nbsp;</span><br>
    2) Underground IT Cables at <input type="text"  name="m_depth[c]" id="it_depth" value="<?php echo (isset($m_depth->c)) ? $m_depth->c : ''; ?>" <?php echo $disabled; ?>> m depth<br><br>


      <div class="col-sm-9"><b>Remarks (If any):</b><br />
    <textarea name="dept_remarks[c]" class="form-control" rows="5" cols="30" <?php echo $disable_common_fields; ?> <?php if($d_approval_status=='Yes') { ?> disabled="disabled" <?php } ?>><?php echo (isset($dept_remarks->c)) ? $dept_remarks->c : ''; ?></textarea>
  </div>
 
  <div class="col-sm-6 "><b>Name</b>

<select id="it_dept_issuing_id" name="dept_issuing_id[c]" <?php if($d_approval_status=='Yes') { ?> disabled="disabled" <?php } ?>   class="form-control authority performing dept_issuing_id">
                                  <option value="" selected="selected">- - Select - -</option>
  <?php
  
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
             $flag=0;
             else
             $flag=1;
          }
          else
          $flag=1;
          
         /* if($department['id']==EIP_TECHNICAL)
          $in_array=array(EIP_CIVIL,$department['id'],EIP_INSTRUMENTAL);
          else
          $in_array=array(EIP_CIVIL,$department['id']); Anand  */

      if($flag==1 && $fet['department_id']==EIP_IT)
      {
          if($dept_issue_id==$id) $chk='selected';
  ?>
                                  <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                  <?php
      }
    }
  }
   ?>
                                </select>

  </div><div class="col-sm-6"><b>Digital Sign/Date & Time</b>
<input type="text" style="width:150px;" value="<?php echo (isset($dept_issuing_date->c)) ? $dept_issuing_date->c : ''; ?>"  name="dept_issuing_date[c]" class="form-control" readonly="readonly" />

<input type="hidden" style="width:150px;" value="<?php echo (isset($dept_approval_status->c)) ? $dept_approval_status->c : ''; ?>"  name="dept_approval_status[c]" class="form-control" readonly="readonly" />

  </div> 

   </td>
   
   
    <td style="border-top: <?php echo $border_top; ?>;border-bottom: 1px solid #231f20; border-right: 1px solid #231f20" colspan=6  align="left" valign=top>
  
 <?php
 $acceptance_performing_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';
 ?>
    <div class="col-sm-6" style="padding-left:15px !important;"><b>Name :</b>

<select id="acceptance_performing_id" <?php if($user_id!=$acceptance_performing_id && $record_id!='') { ?> disabled="disabled" <?php } ?> name="acceptance_performing_id"  class="form-control authority performing" >
                                  <option value="" selected="selected">- - Select - -</option>
  <?php
  
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
       $flag=0;

          if($record_id=='')
          {
             if($id==$user_id)
             $flag=1;                      
          }
          else
          {
              if($id==$record_user_id)
                $flag=1;
          } 
          
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

    </div><div class="col-sm-6 text-left"><b>Name :</b><br />
<?php

$acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';

$acceptance_issuing_date=(isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : '';

$acceptance_issuing_approval=(isset($records['acceptance_issuing_approval'])) ? $records['acceptance_issuing_approval'] : 'No';

$show_name_of_ia='disabled="disabled"';

if($user_id==$acceptance_issuing_id && $acceptance_issuing_approval!='Yes')      
{
  $acceptance_issuing_date=date('d-m-Y H:i');

  if($permission==READ)
  $show_name_of_ia='';

}
?>
      <select id="acceptance_issuing_id" name="acceptance_issuing_id"  class="form-control authority performing"  disabled="disabled">
                                  <option value="" selected="selected">- - Select - -</option>
  <?php
  
  if($authorities!='')
  {
   # echo '<pre>'; print_r($authorities);
    foreach($authorities as $fet)
    {
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk=$flag='';

          if($record_id=='')
          {
             if($id==$user_id)
             $flag=0;
             else
             $flag=1;
          }
          else
          {
              if($id!=$acceptance_performing_id)
              $flag=1;
          }
            
      if($flag==1 && in_array($fet['department_id'],array(EIP_CIVIL,$department['id'])))
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


     </div><br><br><br>
    
    <div class="col-sm-6" style="padding-left:15px !important;"><b>Digital Sign/Date & Time :</b><br />

<input type="text" style="width:150px;" value="<?php echo (isset($records['acceptance_performing_date'])) ? $records['acceptance_performing_date'] : ''; ?>" id="acceptance_performing_date" name="acceptance_performing_date" class="form-control" readonly="readonly" />

     </div>  
     <div class="col-sm-6" style="padding-left:15px !important;"><b>Digital Sign/Date & Time :</b><br />

<input type="text" style="width:150px;" value="<?php echo $acceptance_issuing_date; ?>" id="acceptance_issuing_date" name="acceptance_issuing_date" class="form-control" readonly="readonly" />

<input type="hidden" name="acceptance_issuing_approval" id="acceptance_issuing_approval" value="<?php echo $acceptance_issuing_approval; ?>" />


  <p><span style="float:left;"><b>Name of IA:</b><br /> 
            <input type="text" <?php echo $show_name_of_ia; ?> name="acceptance_name_of_ia" id="acceptance_name_of_ia" class="form-control" value="<?php echo (isset($records['acceptance_name_of_ia'])) ? $records['acceptance_name_of_ia'] : ''; ?>"/>
          </span>
   </p>
      <br /> <br />
       <br />
       <b>Remarks (If any):</b>
       <br />
       <?php

          $disabled='';
          
           if($user_id==$acceptance_issuing_id)     
           $disabled="disabled='disabled'";


         echo 'FF '.$user_id.'- '.$acceptance_issuing_id.'= '.$disabled;
      ?>
      <textarea name="acceptance_issuing_remarks" id="acceptance_issuing_remarks" class="form-control" <?php echo $disabled; ?> rows="5" cols="30" <?php echo $disable_common_fields; ?>><?php echo (isset($records['acceptance_issuing_remarks'])) ? $records['acceptance_issuing_remarks'] : ''; ?></textarea>

     </div>  
    
  </td>
    
  </tr> 
  
  
  
 
  </table>
  
 <div>&nbsp;</div>
              <input type="hidden" id="show_button" name="show_button" />

              <?php
              $label='';

              if($record_id=='')
                $label='Create';
              else
              {

                 #   echo '<pre>'; print_r($dept_approval_status); print_r($dept_issuing_id); exit;

                  if($acceptance_issuing_approval!='Yes')
                  {
                      $range=range('a','e');

                      #for($l=0;$l<count($range);$l++)
                      foreach($range as $r)
                      {
                        #echo '<br /> '.$range[$l].' '.$dept_issuing_id->$range[$l].' == '.$user_id.' && '.$dept_approval_status->$range[$l];

                          if($dept_issuing_id->$r==$user_id && $dept_approval_status->$r!='Yes')
                          {
                            $label='Approve & Submit';

                            break;
                          }  
                      } 

                      if($label=='')
                      {
                        if($user_id==$acceptance_issuing_id && $approval_status==3) //all department users filled data
                        $label='Approve & Submit';  
                        else if($user_id==$acceptance_performing_id && $approval_status!=4)
                        $label='Submit';  
                      }
                  }
              }

              if($label!='')
              echo '<button class="btn btn-sm btn-primary show_button"  value="show" type="submit"><i class="fa fa-dot-circle-o"></i>  '.$label.'</button>';

              ?>
             
             <input type="hidden" id="is_popup_submit" name="is_popup_submit" value=""  />
             <?php
             $redirect=base_url().$param_url;
             ?>
             <a  class="btn btn-sm btn-danger" href="<?php echo $redirect; ?>"><i class="fa fa-ban"> Go Back</i></a> 

             <?php
            if(!empty($record_id))
            {
             
            ?>  
                        <a href="javascript:void(0);" style="float:right;" 
                        data-id="<?php echo $record_id; ?>" class="print_out"><i class="fa fa-print">Print PDF</i></a>
                        <?php
            }
            ?>


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
<?php $this->load->view('layouts/footer'); ?>      
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script> 
<script>
  $(document).ready(function() {

    $('#gritter_trigger').val(''); // skip gritter success popup

		 var counter = 1; // define textbox counts
    
    });



</script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/excavation_permits.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.thickbox.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<link href="<?php echo base_url(); ?>assets/css/jquery.thickbox.css" rel="stylesheet" media="screen" type="text/css" />

<link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet"type="text/css" />
<script src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>

<script type="text/javascript">
  $(document).ready(function() {


    $('.precautions').click(function() {

        var attr=$(this).attr('data-attr');

        var val=$(this).val();

        if(val=='No')
        {
            $('input[name="m_depth['+attr+']"]').val('').attr('disabled',true);
        }
        else
            $('input[name="m_depth['+attr+']"]').removeAttr('disabled'); 


    });


    <?php

    if($disable_common_fields=='')
    {

    ?>
    
    var min_date='<?php echo (isset($records['location_time_start'])) ? date('H:i',strtotime($records['location_time_start'])) : date('H:i'); ?>';

    $('#location_time_to').datepicker({ 
      autoclose: true,
      dateFormat: 'dd-mm-yy',
      minDate: '0',      
      maxDate: '+1m',
      onSelect: function(dateText) {
        //console.log("Selected date: " + dateText + "; input's current value: " + this.value);
        $('#location_time_to').val(dateText+' '+min_date);
      }
    });
        <?php
     }   
        if($record_id!='')
        {
              if($record_user_id!=$user_id)   //Disable all Department clearance id
              {
        ?>  
                $('.dept_issuing_id').attr('disabled',true);
        <?php        
              } 

              if($label=='')
              {
        ?>        

                $('input,select,textarea').attr('disabled',true);
        <?php
              }
        }
        ?>
    $('#acceptance_performing_id').change(function() {
        
        var va=$(this).val();
        
        $('#acceptance_performing_date').val('');
        
        var eip=$('input[name=is_isoloation_permit]:checked').val();
        
        if(va!='')        
        {
          $('#acceptance_performing_date').val(ShowLocalDate());
          
          //if(eip=='N/A')
          $('#acceptance_issuing_id,#acceptance_issuing_date').removeAttr('disabled');
        }
        else
        $('#acceptance_issuing_id,#acceptance_issuing_date').attr('disabled',true).val('');
    });    

    $('#self_cancellation').click(function() 
    {
        
        var x = confirm('Are you sure to cancel this permit without IA approval?');

        $('#self_cancellation_description').val('');

          if(x==true)
          {
             $('#self_cancellation_section').show();
          }
          else
          $('#self_cancellation_section').hide();
    
    });    
    
   
    function ShowLocalDate()
    {
      var dNow = new Date();
      
      var localdate= ( (dNow.getDate()<10?'0':'') + dNow.getDate() ) + '-' + ( ((dNow.getMonth()+1)<10?'0':'') + (dNow.getMonth()+1) ) + '-' + dNow.getFullYear() + ' ' + ( (dNow.getHours()<10?'0':'') + dNow.getHours() ) + ':' +
       ( (dNow.getMinutes()<10?'0':'') + dNow.getMinutes() );
      return localdate;
    }
    
    function ShowLocalTime()
    {
      var dNow = new Date();
      
      var localdate= ( (dNow.getHours()<10?'0':'') + dNow.getHours() ) + ':' + (dNow.getMinutes()<10?'0':'');
      
      return localdate;     
    }



$('#contractor_id').change(function() {
  
    

    if($(this).val()=='others')
    {
      $('#other_contractors').show(); 
    }
    else
      $('#other_contractors').hide().val('');
  
  
});
    <?php 

    $flag='true';   $validate='';    

        $arr = range('a', 'e');

        for($i=0;$i<count($arr);$i++)
        {
          $validate.=",'dept_issuing_id[".$arr[$i]."]': {required:".$flag."}";
        }       
    
    if(!empty($record_id))
    {
        $arr = range('a', 'j');

        for($i=0;$i<count($arr);$i++)
        {
          $validate.=",'precautions[".$arr[$i]."]': {required:".$flag."}";
        }   


        $arr=range('a','e');
      
      for($i=0;$i<count($arr);$i++)
      {
        $validate.=",'m_depth[".$arr[$i]."]':{ required:".$flag."}";
      }

    }

     ?>
    
    $("#job_form").validate({ 
              ignore: '.ignore',
              focusInvalid: true, 
      rules: {
        department_id:{required:<?php echo $flag; ?>},
        zone_id:{required:<?php echo $flag; ?>},
        other_contractors : {  required:function(element) { if($('#contractor_id').val()=='others') return true; else return false;  }   },
        contractor_id:{required:<?php echo $flag; ?>},
        location:{required:<?php echo $flag; ?>},
        location_date: { required:<?php echo $flag; ?> },
        location_time_start: { required:<?php echo $flag; ?> },
        location_time_to: { required:<?php echo $flag; ?> },
        job_name: { required:<?php echo $flag; ?> },
        manual_done: { required:<?php echo $flag; ?> },
        powered: { required:<?php echo $flag; ?> },
        contractors_involved: { required:<?php echo $flag; ?>,digits:true,minStrict: 0 },
        acceptance_performing_id : { required:<?php echo $flag; ?>},
        acceptance_issuing_id : { required:<?php echo $flag; ?>},
        acceptance_name_of_ia : {required:<?php echo $flag; ?>},
        earth_work_depth:{ required:<?php echo $flag; ?>}
        <?php echo $validate; ?> },
      messages:
      {
        department_id : {required:'Required' },
        zone_id : {required:'Required' },
        contractor_id : {required:'Required' },
        location:{required:'Required' },
        location_date:{required:'Required' },
        location_time_start:{required:'Required' },
        location_time_to:{required:'Required' },
        job_name:{required:'Required' },
        earth_work_depth:{required:'Required' },
        contractors_involved:{required:'Required' }/*,
        'hazards[a]': {required:'Required'}*/
        
      },
    errorPlacement: function(error,element){
            error.appendTo(element.parent().parent());                        
        },          
    invalidHandler: function(form, validator) {
      submitted = true;
    },          
    submitHandler:function()
        {

            form_submit();
      
            return false;   
      
        }
    });
  
    $.validator.addMethod('minStrict', function (value, el, param) {
      return value > param;
    }); 
  
    function form_submit()
    {
      
      //alert('Parent;');
      
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
          
          $(".precautions:checked").each(function ()
          {
            data.append(this.name,$(this).val());
          });
                   

        // alert('OK'); return false;
          $("#job_form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled',true);   
          $(".btn-danger").attr('disabled',true);           

          $.ajax({
                  url: base_url+'excavations/form_action',
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
                        window.location.href=base_url+'excavations/form/id/'+$('#id').val();
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
                            window.location.href='<?php echo $redirect;?>';
                          }  
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
