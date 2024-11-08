<?php 
#error_reporting(0); 
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
.issuing_authority { margin-top: 15px; }
</style>
<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>utpumps/"><i class="fa fa-home"></i>UT Pump Permits</a></li>
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

  $this->load->view('layouts/msg');
  ?>
                                        
                                        
      <form id="job_form" name="job_form" enctype="multipart/form-data" > 
                  <input type="hidden" id="id" name="id" value="<?php echo (isset($records['id'])) ? $records['id'] : ''; ?>" />
                    <input type="hidden" id="permit_no" name="permit_no" value="<?php echo (isset($records['permit_no'])) ? $records['permit_no'] : $permit_no ?>" />
                     <input type="hidden" id="last_modified_id" name="last_modified_id" value="<?php echo (isset($records['last_modified_id'])) ? $records['last_modified_id'] : ''; ?>" />

          <div class="panel panel-default">
            <div class="acc-header"> 
                        
                        <?php
            if(!empty($record_id))
            {
              if($readonly==false)
              $st='visibility:hidden;';
              else
              $st='';
            ?>  
                        <a href="javascript:void(0);" style="float:right;<?php echo $st; ?>" 
                        data-id="<?php echo $record_id; ?>" class="print_out"><i class="fa fa-print">Print PDF</i></a>
                        <?php
            }
            ?>
                        <?php #echo '<pre>'; print_r($zones->result_array()); ?>
                        <table align="center" width="100%" border="1" class="form_work"  >
                          <tr height=36 style='height:27.0pt'>
                            <td height=36 class=xl102 colspan="2" style='height:27.0pt;
  width:936pt'><b>Select Department </b>
                <input type="hidden" name="department_id" id="department_id" value="<?php echo $department['id']; ?>" />
                             <br /> <br /><?php echo $department['name']; ?>
                              <br /></td>
                            <td class=xl70 colspan="2" valign="top" style='width:48pt'><b>Zone</b>
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
                              <td class=xl70 colspan="4" valign="top" style='width:48pt'><b>Permit No</b>
                              <br /><br />#<span id="permit_no"><?php echo (isset($records['permit_no'])) ? $records['permit_no'] : $permit_no; ?></span>
                              </td>
                              <td colspan="8"></td>
                          </tr>
                        
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
 
 
 #echo '<pre>'; print_r($hazards_options);
 ?>
                          <tr height=26 style='mso-height-source:userset;height:19.5pt'>
                            <td height=117 colspan="4" rowspan=3 valign="top" class=xl123 style='height:87.75pt;width:111pt;'>
                              <b>Location: <input type="text" class="form-control" name="location" id="location" value="<?php echo (isset($records['location'])) ? $records['location'] : ''; ?>" placeholder="Location Here..." />

                                <div style="width:250px;">
                                    <div style="float:left;width: 100px;padding:15px 0px 5px 0px;">
                                      <b>Date From</b>
                                      <input type="text" readonly="readonly" class="form-control" name="location_time_start" id="location_time_start" style="width:155px;" value="<?php echo (isset($records['location_time_start'])) ? $records['location_time_start'] : date('d-m-Y H:i'); ?>" />    
                                    </div>
                                    <div style="float: right;width: 100px;padding:15px 0px 5px 30px;">
                                    <b>To</b><input type="text" readonly="readonly" name="location_time_to" id="location_time_to" class="form-control valid" style="width:155px;float:left;" value="<?php echo (isset($records['location_time_to'])) ? $records['location_time_to'] : date('d-m-Y H:i',strtotime("+12 hours")); ?>" > 
                                    </div>  
                               </div>     

                              </td>
                          
                            <?php
             
              
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->a) && $hazards->a=='Yes')
              $pre_text_disabled='';
            
                            ?>
                            <td colspan=4 class=xl198 style='border-right:.5pt solid black;
  width:25pt'><b>Hazards / concerns Identified:</b></td>
                            <td class=xl87 align="center" width=108 style='border-top:none;border-left:none;width:75pt'><b>YES/NO</b></td>
                            <td colspan=6 class=xl198 style='border-right:.5pt solid black;
  border-left:none;width:400pt'><b>Precautions to be Taken:</b></td>
                            <td class=xl74 style='border-top:none;border-left:none;width:75pt' align="center"><b>YES/NA</b></td>
                          </tr>
                          
                          <tr height=23 style='mso-height-source:userset;height:17.25pt'>
                            <td colspan=4 height=117 class=xl115 style='height:17.25pt;
  width:25pt'>1) Safe access to work area</td>
                            <td class=xl87 width=108 style='border-top:none;border-left:none;width:75pt'>
                                <center>
                               <input type="radio"  name="hazards[a]" class="radio_button hazards" data-checkbox="true" data-attr="a" value="Yes" <?php if(isset($hazards->a) && $hazards->a=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($hazards->a) && $hazards->a=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards"  name="hazards[a]" data-attr="a" value="No" data-checkbox="true" />
                              N&nbsp;
                            </center>
                            </td>
                            <td colspan=6 class=xl115 style='border-left:none;width:400pt'>1) Pump connected to proper water supply source
                               <input type="text" class="form-control" name="precautions_text[a]" id="precautions_text[a]" value="<?php echo (isset($precautions_text->a)) ? $precautions_text->a : ''; ?>" <?php #echo $pre_text_disabled; ?>/>
                            </td>
                            <td class=xl74 style='border-top:none;border-left:none;width:75pt'>
                              
                              <center>
                              <input data-attr="a" type="radio" <?php if(isset($precautions->a) && $precautions->a=='Yes') { ?> checked="checked" <?php } ?> name="precautions[a]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="a" <?php if(isset($precautions->a) && $precautions->a=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[a]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center>

                            </td>
                          </tr>                                          
                          <tr style='mso-height-source:userset;height:33.75pt'>
                            <td colspan=4 height=117 class=xl115 style='height:33.75pt;
  width:25pt'>2) Spilage of Hot material</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'> 
                            <center>                             
                              <input type="radio"  name="hazards[b]" class="radio_button hazards" data-checkbox="true" data-attr="b" value="Yes" <?php if(isset($hazards->b) && $hazards->b=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($hazards->b) && $hazards->b=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards"  name="hazards[b]" data-attr="b" value="No" data-checkbox="true" />
                              N&nbsp;</center></td>
                            <?php
                            $eip_disabled = '';           
                            $pre_c=(isset($precautions->c)) ? $precautions->c : '';

                            $pre_text_disabled='disabled="disabled"';

                            if(isset($hazards->b) && $hazards->b=='Yes')
                            $pre_text_disabled='';              
                            ?>
                            <td colspan=6 class=xl119 style='border-left:none;width:400pt'>2) All hose joints connected properly<input type="text" class="form-control" name="precautions_text[b]" id="precautions_text[b]" value="<?php echo (isset($precautions_text->b)) ? $precautions_text->b : ''; ?>" <?php #echo $pre_text_disabled; ?>/></td>
                            <td class=xl75 style='border-top:none;width:75pt'>

                              <center>
                              <input data-attr="b" type="radio" <?php if(isset($precautions->b) && $precautions->b=='Yes') { ?> checked="checked" <?php } ?> name="precautions[b]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="b" <?php if(isset($precautions->b) && $precautions->b=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[b]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center>

                            </td>
                          </tr>
                          <tr height=50 style='mso-height-source:userset;height:37.5pt'>
                            <td colspan=4 height=50 class=xl117 style='height:47.5pt;
  width:400pt'><b>Nature of Job:</b>&nbsp;
                              <input type="text"  value="<?php echo (isset($records['job_name'])) ? $records['job_name'] : ''; ?>" name="job_name" id="job_name" class="form-control" style="width:400px;" /></td>
                              
                            <?php           
           
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->c) && $hazards->c=='Yes')
              $pre_text_disabled='';              
              
                            ?>
                              
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  width:25pt'>3) Presence of Inflammables</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'>
                              <center>
                              <input type="radio"  name="hazards[c]" class="radio_button hazards" data-checkbox="true" data-attr="c" value="Yes" <?php if(isset($hazards->c) && $hazards->c=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($hazards->c) && $hazards->c=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards "  name="hazards[c]" data-attr="c" value="No" data-checkbox="true" />
                              N&nbsp;
                            </center>
                            </td>
                            <td colspan=6 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:400pt'>3) All hose joints thread tightened properly<br />
  <input type="text" class="form-control" name="precautions_text[c]" id="precautions_text[c]" value="<?php echo (isset($precautions_text->c)) ? $precautions_text->c : ''; ?>" <?php #echo $pre_text_disabled; ?>/></td>
                            <td class=xl75 style='border-top:none;border-left:none;width:75pt;'><center>
                              <input data-attr="c" type="radio" <?php if(isset($precautions->c) && $precautions->c=='Yes') { ?> checked="checked" <?php } ?> name="precautions[c]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="c" <?php if(isset($precautions->c) && $precautions->c=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[c]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=70 style='mso-height-source:userset;height:52.5pt'>
                          <td colspan=2  height=84 class=xl139 valign="top" style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'><b>Name of the Contractor:</b>&nbsp;
                              <select class="form-control contractors" name="contractor_id" id="contractor_id" style="width:200px;" data-show="other_contractors">
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
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="other_contractors" id="other_contractors" class="form-control" style="width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  />

                            </td>
                              
                             
                            <td colspan=2 valign="top"  class=xl139 style='border-right:1.0pt solid black; border-bottom:1.0pt solid black;width:130;'><b>No of Persons involved</b>&nbsp;
                              <input type="text"  value="<?php echo (isset($records['contractors_involved'])) ? $records['contractors_involved'] : ''; ?>" name="contractors_involved" id="contractors_involved" class="form-control numinput" style="width:130px;" /></td>
                            <td colspan=4 class=xl115 style='width:25pt'>4) Excessive Temperature</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'>

                               <center> 
                              <input data-attr="d" type="radio" class="radio_button hazards hazard_option" data-checkbox='yes' value="Yes" <?php if(isset($hazards->d) && $hazards->d=='Yes') { ?> checked="checked" <?php } ?>  name="hazards[d]" />
                              Y&nbsp;
                              <input data-attr="d" type="radio"  name="hazards[d]" data-checkbox='yes' <?php if(isset($hazards->d) && $hazards->d=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards hazard_option" value="No" />
                              N&nbsp;
                            </center>
                            </td>
                            <td colspan=6 class=xl119 style='border-left:none;width:400pt'>
                            <?php            
              
                              $pre_d=(isset($precautions->d)) ? $precautions->d : '';

                                $pre_text_disabled='disabled="disabled"';

                              if(isset($hazards->d) && $hazards->d=='Yes')
                              $pre_text_disabled='';              

                            ?>
                           4) Any hole present on the hose line/hose damaged<br />
                             <input type="text" class="form-control" name="precautions_text[d]" id="precautions_text[d]" value="<?php echo (isset($precautions_text->d)) ? $precautions_text->d : ''; ?>" <?php #echo $pre_text_disabled; ?> /></td>
                            <td class=xl75 style='border-top:none;width:75pt'><center>
                              <input data-checkbox="yes" data-attr="d" type="radio" <?php if($pre_d=='Yes') { ?> checked="checked" <?php } ?> name="precautions[d]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-checkbox="yes" data-attr="d" <?php if($pre_d=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[d]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=73 style='mso-height-source:userset;height:54.75pt'>
                            <td colspan=4 rowspan="6"  height=84 class=xl139 valign="top" style='border-right:1.0pt solid black;border-bottom:1.0pt solid white;'>
                                
                               <!-- ADD MORE -->
<br>Name of the other person :<br>
                                <div class="inc">

 <?php 

 #echo '<pre>'; print_r($records['watch_other_person_names']);

 		$watch_other_person_names = (isset($records['watch_other_person_names'])) ? json_decode($records['watch_other_person_names']) : 
 array(0=>'');   ?>
        
        <?php

        $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';

        $is_show_button=(isset($records['show_button'])) ? $records['show_button'] : 'show';

        for($wp=0;$wp<count($watch_other_person_names);$wp++)
        {
          $wp_name = (isset($watch_other_person_names[$wp])) ? $watch_other_person_names[$wp] : '';
        
        ?>
            <div class="controls watch_person_div">
                <input type="text" class="form-control watch_person_textbox" name="watch_other_person_names[]" style="width:250px;" value="<?php echo $wp_name; ?>"/> 
                <?php
                if($wp==0)
                {                 
                  if($is_show_button!='hide') {
                ?>
                  <button class="btn btn-info add_remove_btn" type="button" id="append" name="append">
                  Add</button>
                  <br>           
                <?php } } else if($is_show_button!='hide') { ?> <a href="javascript:void(0);" class="remove_this btn btn-danger add_remove_btn">Remove</a> <?php } ?>  
            </div>
        <?php } ?>    
      </div>
                               

                            </td>

                            <td colspan=4 class=xl115 style='width:25pt'>5) Baricaded the work area</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'>
                               <center> 
                              <input data-attr="e" type="radio" class="radio_button hazards"  name="hazards[e]" data-checkbox='true' value="Yes" <?php if(isset($hazards->e) && $hazards->e=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="e"  name="hazards[e]" type="radio" <?php if(isset($hazards->e) && $hazards->e=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" data-checkbox='true' />
                              N&nbsp;</center></td>
                            <td colspan=6 class=xl119 style='border-left:none;width:400pt'>
                            
                            <?php
            
                            $pre=(isset($precautions->e)) ? $precautions->e : '';

                            $pre_text_disabled='disabled="disabled"';

                            if(isset($hazards->e) && $hazards->e=='Yes')
                            $pre_text_disabled='';              

                            ?>
                            
                            5) Hoses are properly protected & Barriacded that area<br />
                               <input type="text" class="form-control" name="precautions_text[e]" id="precautions_text[e]" value="<?php echo (isset($precautions_text->e)) ? $precautions_text->e : ''; ?>" <?php #echo $pre_text_disabled; ?>/></td>
                            <td class=xl75 style='border-top:none;width:75pt'><center>
                              <input data-checkbox="yes" data-attr="e" type="radio" <?php if($pre=='Yes') { ?> checked="checked" <?php } ?> name="precautions[e]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-checkbox="yes" data-attr="e" <?php if($pre=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[e]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>     
                           <tr height=61 style='mso-height-source:userset;height:45.75pt'>                          

                            <?php
  
                            $pre_text_disabled='disabled="disabled"';

                            if(isset($hazards->f) && $hazards->f=='Yes')
                            $pre_text_disabled='';     
                            ?>                              
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:25pt'>6) Falling objects</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'><center><input data-attr="f" type="radio" class="radio_button hazards"  name="hazards[f]" value="Yes" <?php if(isset($hazards->f) && $hazards->f=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="f"  name="hazards[f]" type="radio" <?php if(isset($hazards->f) && $hazards->f=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</center></td>
                            <td colspan=6 class=xl119 style='border-left:none;width:400pt'><span
  style='mso-spacerun:yes'> </span>6) Any water leakages in water hose line<br />
                               <input type="text" class="form-control" name="precautions_text[f]" id="precautions_text[f]" value="<?php echo (isset($precautions_text->f)) ? $precautions_text->f : ''; ?>" <?php #echo $pre_text_disabled; ?> /></td>
                            <td class=xl75 style='border-top:none;width:75pt'><center>
                              <input data-attr="f" type="radio" <?php if(isset($precautions->f) && $precautions->f=='Yes') { ?> checked="checked" <?php } ?> name="precautions[f]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="f" <?php if(isset($precautions->f) && $precautions->f=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[f]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=40 style='mso-height-source:userset;height:50.0pt'>
                          
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:25pt'</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'></td>
                            <td colspan=6 class=xl119 style='border-left:none;width:400pt'>7) Pump earthing cable in good condition<br />
                               <input type="text" class="form-control " name="precautions_text[g]" id="precautions_text[g]" value="<?php echo (isset($precautions_text->g)) ? $precautions_text->g : ''; ?>" /></td>
                            <td class=xl75 style='border-top:none;border-left:none;width:75pt'><center>
                              <input data-attr="g" type="radio" <?php if(isset($precautions->g) && $precautions->g=='Yes') { ?> checked="checked" <?php } ?> name="precautions[g]"  value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="g" <?php if(isset($precautions->g) && $precautions->g=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[g]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                         
                          <tr height=44 style='mso-height-source:userset;height:33.0pt'>
                           <!--  <td colspan=4 rowspan=2 height=77 class=xl151 style='height:57.75pt;width:400pt'> 333
 </td> -->
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black; width:25pt'> 
  
                          
  </td>
                            <td class=xl70></td>
                            <td colspan=6 class=xl119 style='width:400pt'>8) Jet gun connected properly
                <input type="text" class="form-control" name="precautions_text[h]" id="precautions_text[h]" value="<?php echo (isset($precautions_text->h)) ? $precautions_text->h : ''; ?>"  />                               
                            </td>
                            <td class=xl75 style='border-top:none;width:75pt'><center>
                              <input data-attr="h" type="radio" <?php if(isset($precautions->h) && $precautions->h=='Yes') { ?> checked="checked" <?php } ?> name="precautions[h]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="h" <?php if(isset($precautions->h) && $precautions->h=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[h]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                         
                          <tr height=33 style='mso-height-source:userset;height:24.75pt'>
                            <td colspan=4 height=77 class=xl194 style='border-right:.5pt solid black;height:24.75pt;width:25pt'></td>
                            <td class=xl95 width=108 style='border-left:none;width:75pt'></td>
                            <td colspan=6 class=xl195 style='width:400pt'>9) Walkways are baricaded from the High Pressure hose<br /> <input type="text" class="form-control" name="precautions_text[i]" id="precautions_text[i]" value="<?php echo (isset($precautions_text->i)) ? $precautions_text->i : ''; ?>"  /></td>
                            <td class=xl75 style='border-top:none;width:75pt'><center>
                              <input data-attr="i" type="radio" <?php if(isset($precautions->i) && $precautions->i=='Yes') { ?> checked="checked" <?php } ?> name="precautions[i]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="i" <?php if(isset($precautions->i) && $precautions->i=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[i]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                        
                            
                          <tr height=34 style='mso-height-source:userset;height:25.5pt'>
                           
                           
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black; width:25pt'></td>


                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'></td>
                            <td colspan=6 class=xl119 style='border-left:none;width:400pt'>10) Personal protective equipment available & Inspected<br /> <input type="text" class="form-control" name="precautions_text[j]" id="precautions_text[j]" value="<?php echo (isset($precautions_text->j)) ? $precautions_text->j : ''; ?>" /></td>
                            <td class=xl75 style='border-top:none;width:75pt'><center>
                              <input data-attr="j" type="radio" <?php if(isset($precautions->j) && $precautions->j=='Yes') { ?> checked="checked" <?php } ?> name="precautions[j]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="j" <?php if(isset($precautions->j) && $precautions->j=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[j]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=52 style='mso-height-source:userset;height:39.0pt;'>
                            <td rowspan="3" height=52  width=1100 style='height:39.0pt;width:111pt;border-right-color: white;'></td>
                            <td colspan=3 rowspan="3" class=xl70 style='mso-ignore:colspan;border-right:0px;'></td>
                            <td colspan=4 class=xl115 style='width:25pt'></td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'>
                            </td>
                            <td colspan=6 class=xl115 style='border-left:none;width:400pt'>11) Sufficient water available in tank<br /> <input type="text" class="form-control" name="precautions_text[k]" id="precautions_text[k]" value="<?php echo (isset($precautions_text->k)) ? $precautions_text->k : ''; ?>" /></td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'><center>
                              <input data-attr="k" type="radio" <?php if(isset($precautions->k) && $precautions->k=='Yes') { ?> checked="checked" <?php } ?>  name="precautions[k]"  value="Yes" class="radio_button precautions"/>
                              Y&nbsp;<input <?php if(isset($precautions->k) && $precautions->k=='N/A') { ?> checked="checked" <?php } ?> data-attr="k" type="radio" name="precautions[k]" value="N/A" class="radio_button precautions"  /> N/A</center></td>
                          </tr>
                          <tr height=52 style='mso-height-source:userset;height:39.0pt'>
                            
                            
                            <td colspan=4 class=xl115 style='width:25pt'></td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'>
                            
                            
                            </td>
                            <td colspan=6 class=xl115 style='border-left:none;width:400pt'>12) Communication between watch person and pump operator is ensured<br /> <input type="text" class="form-control" name="precautions_text[l]" id="precautions_text[l]" value="<?php echo (isset($precautions_text->l)) ? $precautions_text->l : ''; ?>" /></td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'><center>
                              <input data-attr="l" type="radio" <?php if(isset($precautions->l) && $precautions->l=='Yes') { ?> checked="checked" <?php } ?>  name="precautions[l]"  value="Yes" class="radio_button precautions"/>
                              Y&nbsp;<input <?php if(isset($precautions->l) && $precautions->l=='N/A') { ?> checked="checked" <?php } ?> data-attr="l" type="radio" name="precautions[l]" value="N/A" class="radio_button precautions"  /> N/A</center></td>
                          </tr>
                          <tr height=52 style='mso-height-source:userset;height:39.0pt'>
                           
                            
                            <td colspan=4 class=xl115 ></td>
                            <td class=xl95 width=108 ></td>
                            <td colspan=6 class=xl115 style='border-left:none;width:400pt'>13) UT pump operator is aware of the SOAP for ut pump operation<br /> <input type="text" class="form-control" name="precautions_text[m]" id="precautions_text[m]" value="<?php echo (isset($precautions_text->m)) ? $precautions_text->m : ''; ?>" /></td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:75pt'><center>
                              <input data-attr="m" type="radio" <?php if(isset($precautions->m) && $precautions->m=='Yes') { ?> checked="checked" <?php } ?>  name="precautions[m]"  value="Yes" class="radio_button precautions"/>
                              Y&nbsp;<input <?php if(isset($precautions->m) && $precautions->m=='N/A') { ?> checked="checked" <?php } ?> data-attr="m" type="radio" name="precautions[m]" value="N/A" class="radio_button precautions"  /> N/A</center></td>
                          </tr>
                          <tr height=21 style='height:15.75pt'>
                            <td colspan=4 height=21 class=xl131 style='height:15.75pt;
  width:400pt'>&nbsp;</td>
                            <td colspan=5 class=xl166 style='border-right:.5pt solid black;
  width:25pt'>Others <input type="text" name="hazards_other" id="hazards_other" class="form-control" width="100px" value="<?php echo (isset($records['hazards_other'])) ? $records['hazards_other'] : ''; ?>" /><br /></td>
                            <td colspan=7 class=xl166 style='border-left:none;width:400pt'>Others <center>
                              <input type="text" class="form-control" name="precautions_other" id="precautions_other" width="100px" value="<?php echo (isset($records['precautions_other'])) ? $records['precautions_other'] : ''; ?>" />
                            </center> <br /></td>
                          </tr>
                          <tr height=22 style='mso-height-source:userset;height:16.5pt'>
                            <td colspan=4 height=22 class=xl125 style='border-right:1.0pt solid black;
  height:16.5pt;width:235pt'><center>
                              <b>Required PPE</b>
                            </center></td>
                            <td colspan=5 rowspan=5 style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'><p><b>Authorisation & Acceptance: </b></p>
                              <p><b>Performing Authority: </b></p>
                              <p>I have had the contents of this permit explained to me and I shall work in accordance with the control measures identified </p>
                              
                              <p><span style="float:left;">Name: <br />
                              
                                <select id="acceptance_performing_id" name="acceptance_performing_id"  class="form-control authority performing">
                                  <option value="" selected="selected">- - Select - -</option>
                                  <?php
  $acceptance_performing_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
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
                              <br />
                              <br />
                              <br />
                              <br />
                              <p><b>Issuing Authority: </b></p>
                              <p>I have ensured that each of the identified control measures is suitable and sufficient. The content of this permit has been explained to the holder and work may proceed.</p>
                             
                              <p><span style="float:left;">Name: <br />
                              <?php
                $acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';
                ?>
                                <select id="acceptance_issuing_id" <?php if($acceptance_issuing_id=='') { ?>  disabled="disabled" <?php } ?> name="acceptance_issuing_id" class="form-control issuing authority">
                                  <option value="">- - Select - -</option>
                                  <?php
  
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
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
                                <?php  $acceptance_issuing_date=(isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : ''; 
                
                $acceptance_issuing_approval=(isset($records['acceptance_issuing_approval'])) ? $records['acceptance_issuing_approval'] : ''; 
                
                $acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : ''; 


                $show_name_of_ia='disabled="disabled"';
                
                if($acceptance_issuing_approval=='No' && $user_id==$acceptance_issuing_id)
                {
                    $acceptance_issuing_date=date('d-m-Y H:i');

                    if($permission==READ)
                    $show_name_of_ia='';
                }
                if(!empty($acceptance_issuing_date))
                $acceptance_issuing_date=date('d-m-Y H:i',strtotime($acceptance_issuing_date));

                $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';

                 if($approval_status==10)
                $acceptance_issuing_date='';
                
                ?>
                                <span style="float:right;">Digital Sign/Date & Time:
                                  <input value="<?php echo $acceptance_issuing_date; ?>" type="text" id="acceptance_issuing_date" style="width:150px;" name="acceptance_issuing_date" class="form-control" readonly="readonly" />
                                </span></p>
                              <br />
                              <br />

                            
                              <br />
                              <br />

                               <p><span style="float:left;"><b>Name of IA:</b><br /> 

                                    <input type="text" <?php echo $show_name_of_ia; ?> name="acceptance_name_of_ia" id="acceptance_name_of_ia" class="form-control" value="<?php echo (isset($records['acceptance_name_of_ia'])) ? $records['acceptance_name_of_ia'] : ''; ?>"/>
                                  </span>
                                </p>
                              <br />
                              <br /> <br />


                            </td>
                            <td colspan=8 rowspan=7 valign="top" style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'>
                            <?php
               $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';
               
               $st=(isset($records['status'])) ? $records['status'] : '';


                
                $work_msg='<span id="change_status_label">Completion / Cancellation</span>';
                
                
                if($st=='Completion' || $st == 'Cancellation')
                $work_msg=$st;
                
               ?>
                            <p><b>Work <?php echo $work_msg ?>: </b></p>
                              <p><b>Performing Authority: </b></p>
                              <p>Work completed, all persons are withdrawn and material removed from the area.</p><br />
                             
                              <p><span style="float:left;">Name:<br />
                <?php 
                
                
                 $cancellation_performing_id=(isset($records['cancellation_performing_id'])) ? $records['cancellation_performing_id'] : '';
                 
                 
  
                ?>                              
                                <select id="cancellation_performing_id"  disabled name="cancellation_performing_id"  class="form-control authority performing">
                                  <option value="">- - Select - -</option>
                                  <?php
 
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
  
            /*if($record_id!=''  && $cancellation_performing_id<=0)
          {
             if($id==$user_id)
             $flag=1;
          }
          else if($cancellation_performing_id>0)
          $flag=1; */
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
                                  <input type="text" value="<?php echo (isset($records['cancellation_performing_date'])) ? $records['cancellation_performing_date'] : ''; ?>" id="cancellation_performing_date" style="width:140px;"  name="cancellation_performing_date" class="form-control datepicker" />
                                </span></p>
                              <br />
                              <br />
                              <br />
                              <br />
                              <p><b>Issuing Authority: </b></p>
                              <p>I have inspected the work area and declare the work for which the permit was issued has been properly.</p>
                            
                             
                              <p><span style="float:left;">Name: <br />
                <?php 
                $acceptance_issuing_approval=(isset($records['acceptance_issuing_approval'])) ? $records['acceptance_issuing_approval'] : '';
                ?>                                
                                <select id="cancellation_issuing_id"  disabled="disabled" name="cancellation_issuing_id"  class="form-control authority issuing">
                                  <option value="" selected="selected">- - Select - -</option>
                                  <?php
  $cancellation_issuing_id=(isset($records['cancellation_issuing_id'])) ? $records['cancellation_issuing_id'] : '';
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
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

                 $show_name_of_ia='disabled="disabled"';
                
                if($cancellation_issuing_approval=='No' && $user_id==$cancellation_issuing_id)
                {
                    $cancellation_issuing_date=date('d-m-Y H:i');

                    if($permission==READ)
                    $show_name_of_ia='';
                }    
                else 
                $cancellation_issuing_date=(isset($records['cancellation_issuing_date'])) ? $records['cancellation_issuing_date'] : '';
                
                if(!empty($cancellation_issuing_date))
                $cancellation_issuing_date=date('d-m-Y H:i',strtotime($cancellation_issuing_date));
                ?>                
                                
                                
                                 <span style="float:right;">Digital Sign/Date & Time: <br />
                                  <input type="text" value="<?php echo $cancellation_issuing_date; ?>" id="cancellation_issuing_date" style="width:140px;" name="cancellation_issuing_date" class="form-control datepicker" />
                                </span></p>
                              <br />
                              <br /><br /><br />

                                <p><span style="float:left;"><b>Name of IA:</b><br /> 
                                    <input type="text" <?php echo $show_name_of_ia; ?> name="cancellation_name_of_ia" id="cancellation_name_of_ia" class="form-control" value="<?php echo (isset($records['cancellation_name_of_ia'])) ? $records['cancellation_name_of_ia'] : ''; ?>"/>
                                  </span>
                                </p>
                              <br />
                              <br /> <br />



                            </td>
                          </tr>
                          <tr height=35 style='mso-height-source:userset;height:26.25pt'>
                            <td height=35 width=1100 colspan="2" style='height:26.25pt;width:111pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <?php
  if(isset($records))
  $required_ppe=explode(',',rtrim($records['required_ppe'],','));
  else
  $required_ppe=array();
  
 
  #print_r($required_ppe);
  ?>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=35 class=xl76 width=148 colspan="3" style='height:26.25pt;border-top:none;
    width:111pt'><span style='mso-spacerun:yes'> </span>Safety Helmet<span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" class="required_ppe"  checked="checked" disabled="disabled" value="Helmet" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                            <td colspan=2 height=35 style='  height:26.25pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=3  height=35 class=xl148 width=165 style='
    height:26.25pt;border-left:none;width:124pt'>Eye protection <span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" checked="checked"  disabled="disabled"  class="required_ppe" value="Eye Protection" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=38 style='mso-height-source:userset;height:28.5pt'>
                            <td height=38 width=1100 colspan="2" style='height:28.5pt;width:111pt' align=left
  valign=top><table cellpadding=0 cellspacing=0>
                              <tr>
                                <td height=38 class=xl76 width=148 style='height:28.5pt;border-top:none;
    width:111pt'>Shoe<span
    style='mso-spacerun:yes'><span class="float_right">
                                  <input type="checkbox" name="required_ppe[]"  checked="checked" disabled="disabled"    class="required_ppe" value="Shoe" />
                                </span></span></td>
                              </tr>
                            </table></td>
                            <td colspan=2 height=38 style='border-right:1.0pt solid black;
  height:28.5pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=38 class=xl148 width=165 style='height:28.5pt;border-left:none;width:124pt'>Hand Gloves (Special type) <span class="float_right">
                                    <input <?php if(in_array('Hand Gloves',$required_ppe)) { ?> checked="checked" <?php } ?> type="checkbox" name="required_ppe[]"  class="required_ppe" value="Hand Gloves" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=41 style='mso-height-source:userset;height:30.75pt'>
                            <td height=41 width=1100 style='height:30.75pt;width:111pt' align=left
  valign=top colspan="2"><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=41 class=xl76 width=148 style='height:30.75pt;border-top:none;
    width:111pt'>Kelver Suit<span style='mso-spacerun:yes'><span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" <?php if(in_array('Kelver Suit',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Kelver Suit" />
                                  </span></span></td>
                                </tr>
                              </table>
                            </span></td>
                            <td colspan=2 height=41 style='height:28.5pt;border-left:none;width:124pt' valign=top>
                            	


                            		<table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=38 class=xl148 width=165 style='height:28.5pt;border-left:none;width:124pt'>Nose Mask<span class="float_right">
                                    <input <?php if(in_array('Nose',$required_ppe)) { ?> checked="checked" <?php } ?> type="checkbox" name="required_ppe[]"  class="required_ppe" value="Nose" />
                                  </span></td>
                                </tr>
                              </table>


                            </td>
                          </tr>
                          
                          
                          <tr height=47 style='mso-height-source:userset;height:35.25pt'>
                            <td height=47 colspan="2" width=1100 style='height:35.25pt;width:111pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=47 class=xl77 width=148 style='height:35.25pt;border-top:none;
    width:111pt'>Others <span class="float_right">
                                    <input name="required_ppe[]" <?php if(in_array('Others',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" data-other='required_ppe_other' value="Others" type="checkbox" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                            <td colspan=2 height=47 style='border-right:1.0pt solid black;
  height:35.25pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=47 class=xl150 width=165 style='
    height:35.25pt;border-left:none;width:124pt'>
      <?php
     $required_ppe_other=(isset($records['required_ppe_other'])) ? $records['required_ppe_other'] : '';
    ?> 
    <input name="required_ppe_other" id="required_ppe_other" class="form-control" value="<?php echo $required_ppe_other; ?>" width="100px" type="text" <?php if(empty($required_ppe_other)) { ?> disabled="disabled" <?php } ?>>
    </td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <?php

                          $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';

                          if($approval_status==1)
                          { $cls_span=13;
                            $display_style = 'none';
                          }  
                          else
                          { $display_style='block'; $cls_span=15; }

                           $self_cancellation_description=(isset($records['self_cancellation_description'])) ? $records['self_cancellation_description'] : '';

                            if(!empty($record_id))
                            {
                                if($acceptance_performing_id==$user_id && ($approval_status==1 || $approval_status==10))
                                {
                                   

                          ?>
                           <tr height=21 style='height:15.75pt'>
                            <td height=21 class=xl83 width=1100 style='height:15.75pt;width:111pt'><b>Status:</b><span
  style='mso-spacerun:yes'>                   </span></td>
                            
                            <?php if($approval_status==1) { ?>
                            <td colspan="2"><input type="radio" name="self_cancellation" id="self_cancellation" value="cancel" /> Self Cancellation&nbsp;&nbsp;</td> <?php } ?>
                            <td colspan="<?php echo $cls_span; ?>" class=xl155 style='border-right:1.0pt solid black;
  border-left:none;width:825pt'><span id="self_cancellation_section" style="display:<?php echo $display_style; ?>;">
  <b>Reason for cancellation : </b><?php if($approval_status==1) { ?><input type="text" name="self_cancellation_description" id="self_cancellation_description" class="form-control" style="width:400px;"><?php } else { echo $self_cancellation_description; } ?></span>

  </td>
                          </tr>
                          <?php
                                }
                                else if($approval_status==10)
                                {
                          ?>        
                            <tr height=21 style='height:15.75pt'>
                            <td height=21 class=xl83 width=1100 style='height:15.75pt;width:111pt'><b>Reason for cancellation : </b><span
  style='mso-spacerun:yes'>                   </span></td>
                            <td colspan="15" class=xl155 style='border-right:1.0pt solid black;
  border-left:none;width:825pt;vertical-align:top;'>
  <?php echo $self_cancellation_description; ?>

  </td>
                          </tr>

                          <?php
                                }
                          }
                          ?>  

             </table>
	<table align="center" width="100%" id="extendable"  border="1" class="form_work" >            
             <?php
       if($readonly===true)
       {
       ?>                 
            <tr height=41 style='height:15.75pt'>
              <td height=41 class=xl83 width=148 style='height:55.75pt;width:111pt'><b>Permit Status: </b><span
              style='mso-spacerun:yes'>                   </span></td>
              <td colspan=3 class=xl155 width=1100 style='border-right:1.0pt solid black;
              border-left:none;width:825pt'>
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
              <td colspan="14"><span id="self_cancellation_section" style="display:<?php echo $display_style; ?>;">Reason for cancellation <br /> <input type="text" value="<?php echo $self_cancellation_description; ?>" name="self_cancellation_description" id="self_cancellation_description" class="form-control" style="width:400px;"></span></td>
              
             </tr>
          <?php 
       }
    
    ?>
	
	<?php		
 	if(isset($records))
     $schedule_date=json_decode($records['schedule_date']);
     else
     $schedule_date=array();
   
     if(isset($records))
     $issuing_authority_approval_status=json_decode($records['issuing_authority_approval_status']);
     else
     $issuing_authority_approval_status=array();
   
   #echo '<pre>'; print_r($schedule_date);
   
   
   $sch_date_a=(isset($schedule_date->a)) ? $schedule_date->a : '';
    
   if($sch_date_a!='')  
   $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$sch_date_a));
   else
   $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$acceptance_issuing_date));
     
   $diff_days=$diff['days'];
   
    $ia_app_status=(isset($issuing_authority_approval_status->a)) ? strtolower($issuing_authority_approval_status->a) : '';
   
  #@echo '<br /> Diff Days A : '.$diff_days;
   
    ?>
                          <tr height=21 style='height:15.75pt'>
                            <td height=21 class=xl83 width=831 style='height:15.75pt;width:111pt'><b>Revalidation:</b><span
  style='mso-spacerun:yes'>                   </span></td>
                            <td colspan=15 class=xl155 style='border-right:1.0pt solid black;
  border-left:none;width:825pt'><span style='mso-spacerun:yes'>  </span><b>I have
                              visited the work area and understand and well comply with the requirements of
                              this permit</b></td>
                          </tr>
                                       <tr height=21 style='height:15.75pt'>
                            <td rowspan=4 height=83 class=xl157 width=831 style='border-bottom:.5pt solid black;
      height:62.25pt;width:111pt'><b>SCHEDULE</b></td>
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:124pt'>Date :
                              <input type="text" value="<?php echo $sch_date_a; ?>" name="schedule_date[a]"  class="schedule_date form-control" id="schedule_date1" data-diff="<?php echo $diff_days; ?>" data-id="1" style="width: 167px;" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
  <?php
  
   $sch_date_b=(isset($schedule_date->b)) ? $schedule_date->b : '';
    
   if($sch_date_b!='')  
   $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$sch_date_b));
   else 
   $diff=$this->public_model->datetime_diff(array('end_date'=>$sch_date_a,'start_date'=>date('Y-m-d H:i:s')));
     
   $diff_days=$diff['days'];
   
   $ia_app_status=(isset($issuing_authority_approval_status->b)) ? strtolower($issuing_authority_approval_status->b) : '';
   
   #echo '<br /> Diff Days B : '.$diff_days.' - '.$ia_app_status_a;

  ?>                                
                                        
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;  border-left:none;width:150px !important;'>Date :
                              <input type="text" value="<?php echo $sch_date_b; ?>" name="schedule_date[b]"  class="schedule_date form-control" style="width: 167px;" id="schedule_date2" data-id="2" data-diff="<?php echo $diff_days; ?>" data-ia-approval="<?php echo $ia_app_status; ?>" /></td>
<?php $ia_app_status=(isset($issuing_authority_approval_status->c)) ? strtolower($issuing_authority_approval_status->c) : ''; 
  
   $sch_date_c=(isset($schedule_date->c)) ? $schedule_date->c : '';
    
   if($sch_date_c!='')  
   $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$sch_date_c));
   else
   $diff=$this->public_model->datetime_diff(array('end_date'=>$sch_date_b,'start_date'=>date('Y-m-d H:i:s')));
     
   $diff_days=$diff['days'];
  ?>                                
                                        
       
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:117pt'>Date :
                               <input type="text" value="<?php echo (isset($schedule_date->c)) ? $schedule_date->c : ''; ?>" name="schedule_date[c]" data-diff="<?php echo $diff_days; ?>" class="schedule_date form-control" style="width: 167px;" id="schedule_date3" data-id="3" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
  <?php $ia_app_status=(isset($issuing_authority_approval_status->d)) ? strtolower($issuing_authority_approval_status->d) : ''; 
   $sch_date_d=(isset($schedule_date->d)) ? $schedule_date->d : '';
    
   if($sch_date_d!='')  
   $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$sch_date_d));
   else
   $diff=$this->public_model->datetime_diff(array('end_date'=>$sch_date_c,'start_date'=>date('Y-m-d H:i:s')));
     
   $diff_days=$diff['days'];
  
  ?>     
  
                                
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:122pt'>Date :
                               <input type="text" value="<?php echo (isset($schedule_date->d)) ? $schedule_date->d : ''; ?>" name="schedule_date[d]" data-diff="<?php echo $diff_days; ?>" class="schedule_date form-control" style="width: 167px;" id="schedule_date4" data-id="4" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
                         
<?php $ia_app_status=(isset($issuing_authority_approval_status->e)) ? strtolower($issuing_authority_approval_status->e) : ''; 
  
   $sch_date_e=(isset($schedule_date->e)) ? $schedule_date->e : '';
    
   if($sch_date_e!='')  
   $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$sch_date_e));
   else
   $diff=$this->public_model->datetime_diff(array('end_date'=>$sch_date_d,'start_date'=>date('Y-m-d H:i:s')));
     
   $diff_days=$diff['days'];
       
     ?>                                  
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:173pt'>Date :
                              <input type="text" value="<?php echo (isset($schedule_date->e)) ? $schedule_date->e : ''; ?>" name="schedule_date[e]" data-diff="<?php echo $diff_days; ?>" class="schedule_date form-control" style="width: 120px;" id="schedule_date5" data-id="5" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
  <?php $ia_app_status=(isset($issuing_authority_approval_status->f)) ? strtolower($issuing_authority_approval_status->f) : ''; 
  
  
   $sch_date_f=(isset($schedule_date->f)) ? $schedule_date->f : '';
    
   if($sch_date_e!='')  
   $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$sch_date_f));
   else
   $diff=$this->public_model->datetime_diff(array('start_date'=>$sch_date_e,'end_date'=>date('Y-m-d H:i:s')));
     
   $diff_days=$diff['days'];
  
  ?>                                
                              
                            <td colspan=5  class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:163pt'>Date :
                              <input type="text" value="<?php echo (isset($schedule_date->f)) ? $schedule_date->f : ''; ?>" name="schedule_date[f]" data-diff="<?php echo $diff_days; ?>" class="schedule_date form-control" style="width: 120px;" id="schedule_date6" data-id="6" data-ia-approval="<?php echo $ia_app_status; ?>"/></td>
                          </tr>
                          <tr height=21 style='height:15.75pt'>
                            <td colspan=2 height=83 class=xl146 style='border-right:1.0pt solid black;
      height:15.75pt;border-left:none;width:124pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                            <td colspan=2 class=xl146 style='border-right:1.0pt solid black;
      border-left:none;width:126pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                            <td colspan=2 class=xl146 style='border-right:1.0pt solid black;
      border-left:none;width:117pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                            <td colspan=2 class=xl146 style='border-right:1.0pt solid black;
      border-left:none;width:122pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                            <td colspan=2 class=xl93 style='border-right:1.0pt solid black;
      border-left:none;width:173pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                            <td colspan=5  class=xl93 style='border-right:1.0pt solid black;
      border-left:none;width:163pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>

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
    
    ?>

                          <tr height="21" style="height:15.75pt">
                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">From</td>
                          <td class="xl94" width="83" style="border-top:none;border-left:none;width: 100px !important;">

<?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[a]','selected_value'=>(isset($schedule_from_time->a)) ? $schedule_from_time->a : '')); ?>

                          </td>

                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">From</td>
                          <td class="xl94" width="83" style="border-top:none;border-left:none;width: 100px !important;">

                             <?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[b]','selected_value'=>(isset($schedule_from_time->b)) ? $schedule_from_time->b : '')); ?>

                          </td>

                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">From</td>
                          <td class="xl94" width="83" style="border-top:none;border-left:none;width: 100px !important;">

                              <?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[c]','selected_value'=>(isset($schedule_from_time->c)) ? $schedule_from_time->c : '')); ?>
                          </td>

                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">From</td>
                          <td class="xl94" width="83" style="border-top:none;border-left:none;width: 100px !important;">

                               <?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[d]','selected_value'=>(isset($schedule_from_time->d)) ? $schedule_from_time->d : '')); ?>                          </td>

                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">From</td>
                          <td class="xl94" width="83" style="border-top:none;border-left:none;width: 100px !important;">

                              <?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[e]','selected_value'=>(isset($schedule_from_time->e)) ? $schedule_from_time->e : '')); ?>
                          </td>

                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">From</td>
                          <td class="xl94" colspan="4"  width="83" style="border-top:none;border-left:none;width: 100px !important;">
                               <?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[f]','selected_value'=>(isset($schedule_from_time->f)) ? $schedule_from_time->f : '')); ?>
                          </td>
                          </tr>


                          <tr height="21" style="height:15.75pt">
                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">To</td>
                          <td class="xl94" width="83" style="border-top:none;border-left:none;width: 100px !important;">

                              <?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[a]','selected_value'=>(isset($schedule_to_time->a)) ? $schedule_to_time->a : '')); ?>

                          </td>

                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">To</td>
                          <td class="xl94" width="83" style="border-top:none;border-left:none;width: 100px !important;">

                               <?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[b]','selected_value'=>(isset($schedule_to_time->b)) ? $schedule_to_time->b : '')); ?>                          </td>

                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">To</td>
                          <td class="xl94" width="83" style="border-top:none;border-left:none;width: 100px !important;">

                             <?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[c]','selected_value'=>(isset($schedule_to_time->c)) ? $schedule_to_time->c : '')); ?>
                          </td>

                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">To</td>
                          <td class="xl94" width="83" style="border-top:none;border-left:none;width: 100px !important;">

                              <?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[d]','selected_value'=>(isset($schedule_to_time->d)) ? $schedule_to_time->d : '')); ?>

                          </td>

                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">To</td>
                          <td class="xl94" width="83" style="border-top:none;border-left:none;width: 100px !important;">

                              <?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[e]','selected_value'=>(isset($schedule_to_time->e)) ? $schedule_to_time->e : '')); ?>

                          </td>

                          <td height="83" class="xl93" style="
      height:15.75pt;
      border-top:none;
      border-left:none;
      width:  !important;
      ">To</td>
                              <td class="xl94" colspan="4"  width="83" style="border-top:none;border-left:none;width: 100px !important;">
                                   <?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[f]','selected_value'=>(isset($schedule_to_time->f)) ? $schedule_to_time->f : '')); ?>                              </td>
                          </tr>
 <?php
 if(isset($records))
 {
    $extended_contractors_id=json_decode($records['extended_contractors_id']);

    $extended_others_contractors_id=json_decode($records['extended_others_contractors_id']);                                      
 }   
 else                           
 $extended_contractors_id=$extended_others_contractors_id=array();
?>
       <tr height=40 style='height:30.0pt'>
                            <td height=40 class=xl84 width=831 style='height:30.0pt;border-top:none;
  width:111pt'>Name of the Contractor</td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:124pt;padding-top:3px;'>

                                <select class="form-control extended_contractors_id contractors" name="extended_contractors_id[a]"  data-show="extended_others_contractors_id_a" style="width:170px;margin-top:10px;" data-attr="a">
                               <option value="">- - Select - -</option>
                                <?php                                   
                                $select_contractor_id=(isset($extended_contractors_id->a)) ? $extended_contractors_id->a : '';     
                                    foreach($contractors as $list)
                                    {
                      
                                  ?>
                                <option value="<?php echo $list['id'];?>" <?php if($select_contractor_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php } ?>
                                  <option value="others" <?php if($select_contractor_id=='others') { ?> selected="selected" <?php } ?>>Others</option>
                              </select> <br />
                              <?php $other_contractors=(isset($extended_others_contractors_id->a)) ? $extended_others_contractors_id->a : '' ?>
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="extended_others_contractors_id[a]" id="extended_others_contractors_id_a" class="extended_others_contractors_id form-control" style="margin-bottom:5px;width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  />



</td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:126pt;padding-top:3px;'>

       <select class="form-control extended_contractors_id contractors" name="extended_contractors_id[b]"  data-show="extended_others_contractors_id_b" style="width:170px;margin-top:10px;" data-attr="b">
                               <option value="">- - Select - -</option>
                                <?php                                   
                                $select_contractor_id=(isset($extended_contractors_id->b)) ? $extended_contractors_id->b : '';     
                                    foreach($contractors as $list)
                                    {
                      
                                  ?>
                                <option value="<?php echo $list['id'];?>" <?php if($select_contractor_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php } ?>
                                  <option value="others" <?php if($select_contractor_id=='others') { ?> selected="selected" <?php } ?>>Others</option>
                              </select> <br />
                              <?php $other_contractors=(isset($extended_others_contractors_id->b)) ? $extended_others_contractors_id->b : '' ?>
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="extended_others_contractors_id[b]" id="extended_others_contractors_id_b" class="extended_others_contractors_id form-control" style="margin-bottom:5px;width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  />



      </td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:117pt;padding-top:3px;'>

       <select class="form-control extended_contractors_id contractors" name="extended_contractors_id[c]"  data-show="extended_others_contractors_id_c" style="width:170px;margin-top:10px;" data-attr="c">
                               <option value="">- - Select - -</option>
                                <?php                                   
                                $select_contractor_id=(isset($extended_contractors_id->c)) ? $extended_contractors_id->c : '';     
                                    foreach($contractors as $list)
                                    {
                      
                                  ?>
                                <option value="<?php echo $list['id'];?>" <?php if($select_contractor_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php } ?>
                                  <option value="others" <?php if($select_contractor_id=='others') { ?> selected="selected" <?php } ?>>Others</option>
                              </select> <br />
                              <?php $other_contractors=(isset($extended_others_contractors_id->c)) ? $extended_others_contractors_id->c : '' ?>
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="extended_others_contractors_id[c]" id="extended_others_contractors_id_c" class="extended_others_contractors_id form-control" style="margin-bottom:5px;width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  />


    </td>
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt;padding-top:3px;'>


 <select class="form-control extended_contractors_id contractors" name="extended_contractors_id[d]"  data-show="extended_others_contractors_id_d" style="width:170px;margin-top:10px;" data-attr="d">
                               <option value="">- - Select - -</option>
                                <?php                                   
                                $select_contractor_id=(isset($extended_contractors_id->d)) ? $extended_contractors_id->d : '';     
                                    foreach($contractors as $list)
                                    {
                      
                                  ?>
                                <option value="<?php echo $list['id'];?>" <?php if($select_contractor_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php } ?>
                                  <option value="others" <?php if($select_contractor_id=='others') { ?> selected="selected" <?php } ?>>Others</option>
                              </select> <br />
                              <?php $other_contractors=(isset($extended_others_contractors_id->d)) ? $extended_others_contractors_id->d : '' ?>
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="extended_others_contractors_id[d]" id="extended_others_contractors_id_d" class="extended_others_contractors_id form-control" style="margin-bottom:5px;width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  />   


</td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:173pt;padding-top:3px;'>


   <select class="form-control extended_contractors_id contractors" name="extended_contractors_id[e]"  data-show="extended_others_contractors_id_e" style="width:170px;margin-top:10px;" data-attr="e">
                               <option value="">- - Select - -</option>
                                <?php                                   
                                $select_contractor_id=(isset($extended_contractors_id->e)) ? $extended_contractors_id->e : '';     
                                    foreach($contractors as $list)
                                    {
                      
                                  ?>
                                <option value="<?php echo $list['id'];?>" <?php if($select_contractor_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php } ?>
                                  <option value="others" <?php if($select_contractor_id=='others') { ?> selected="selected" <?php } ?>>Others</option>
                              </select> <br />
                              <?php $other_contractors=(isset($extended_others_contractors_id->e)) ? $extended_others_contractors_id->e : '' ?>
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="extended_others_contractors_id[e]" id="extended_others_contractors_id_e" class="extended_others_contractors_id form-control" style="margin-bottom:5px;width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  />


</td>
                            <td width="213" colspan=5 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:163pt;padding-top:3px;'>


  <select class="form-control extended_contractors_id contractors" name="extended_contractors_id[f]"  data-show="extended_others_contractors_id_f" style="width:170px;margin-top:10px;" data-attr="f">
                               <option value="">- - Select - -</option>
                                <?php                                   
                                $select_contractor_id=(isset($extended_contractors_id->f)) ? $extended_contractors_id->f : '';     
                                    foreach($contractors as $list)
                                    {
                      
                                  ?>
                                <option value="<?php echo $list['id'];?>" <?php if($select_contractor_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php } ?>
                                  <option value="others" <?php if($select_contractor_id=='others') { ?> selected="selected" <?php } ?>>Others</option>
                              </select> <br />
                              <?php $other_contractors=(isset($extended_others_contractors_id->f)) ? $extended_others_contractors_id->f : '' ?>
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="extended_others_contractors_id[f]" id="extended_others_contractors_id_f" class="extended_others_contractors_id form-control" style="margin-bottom:5px;width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  />

</td>
                          </tr>                    





<?php
     if(isset($records))
     $no_of_persons=json_decode($records['no_of_persons']);
     else
     $no_of_persons=array();
    
?>

                                                    <tr height=40 style='height:30.0pt'>
                            <td height=40 class=xl84 width=831 style='height:30.0pt;border-top:none;
  width:111pt'>No of Persons involved</td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:124pt;padding-top:3px;'><input type="text" value="<?php echo (isset($no_of_persons->a)) ? $no_of_persons->a : ''; ?>" name="no_of_persons[a]"  class="no_of_persons form-control numinput" style="width: 167px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:126pt;padding-top:3px;'><input type="text" value="<?php echo (isset($no_of_persons->b)) ? $no_of_persons->b : ''; ?>" name="no_of_persons[b]"  class="no_of_persons form-control numinput" style="width: 167px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:117pt;padding-top:3px;'><input type="text" value="<?php echo (isset($no_of_persons->c)) ? $no_of_persons->c : ''; ?>" name="no_of_persons[c]"  class="no_of_persons form-control numinput" style="width: 167px;" /></td>
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt;padding-top:3px;'><input type="text" value="<?php echo (isset($no_of_persons->d)) ? $no_of_persons->d : ''; ?>" name="no_of_persons[d]"  class="no_of_persons form-control numinput" style="width: 167px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:173pt;padding-top:3px;'><input type="text" value="<?php echo (isset($no_of_persons->e)) ? $no_of_persons->e : ''; ?>" name="no_of_persons[e]"  class="no_of_persons form-control numinput"  /></td>
                            <td width="213" colspan=5 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:163pt;padding-top:3px;'><input type="text" value="<?php echo (isset($no_of_persons->f)) ? $no_of_persons->f : ''; ?>" name="no_of_persons[f]"  class="no_of_persons form-control numinput"  /></td>
                          </tr>
 <?php
     if(isset($records))
     $performing_authority=json_decode($records['performing_authority']);
     else
     $performing_authority=array();
    
    ?>                          
                                                    <tr height=34 style='mso-height-source:userset;height:25.5pt'>
                            <td height=34 class=xl84 width=831 style='height:25.5pt;border-top:none;
  width:111pt'>Performing Authority</td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:124pt'>
<select id="performing_authority[a]" name="performing_authority[a]"  class="performing_authority form-control authority performing" style="width: 170px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
    $performing_authority_a=(isset($performing_authority->a)) ? $performing_authority->a : '';

  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
      
          if($performing_authority_a=='')
          { 
             if($id==$user_id)
             $flag=1;
          }
          else
          {
            if($performing_authority_a==$id) { $chk='selected'; $flag=1; }
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
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:126pt'><select id="performing_authority[b]" name="performing_authority[b]"  class="performing_authority form-control authority performing" style="width: 170px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
    $performing_authority_b=(isset($performing_authority->b)) ? $performing_authority->b : '';

  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
      
          if($performing_authority_b=='')
          { 
             if($id==$user_id)
             $flag=1;
          }
          else
          {
            if($performing_authority_b==$id) { $chk='selected'; $flag=1; }
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
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:117pt'>

<select id="performing_authority[c]" name="performing_authority[c]"  class="performing_authority form-control authority performing" style="width: 170px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
    $performing_authority_c=(isset($performing_authority->c)) ? $performing_authority->c : '';

  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
      
          if($performing_authority_c=='')
          { 
             if($id==$user_id)
             $flag=1;
          }
          else
          {
            if($performing_authority_c==$id) { $chk='selected'; $flag=1; }
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
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'>

<select id="performing_authority[d]" name="performing_authority[d]"  class="performing_authority form-control authority performing" style="width: 170px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
    $performing_authority_d=(isset($performing_authority->d)) ? $performing_authority->d : '';

  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
      
          if($performing_authority_d=='')
          { 
             if($id==$user_id)
             $flag=1;
          }
          else
          {
            if($performing_authority_d==$id) { $chk='selected'; $flag=1; }
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
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:173pt'>

<select id="performing_authority[e]" name="performing_authority[e]"  class="performing_authority form-control authority performing" >
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
    $performing_authority_e=(isset($performing_authority->e)) ? $performing_authority->e : '';

  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
      
          if($performing_authority_e=='')
          { 
             if($id==$user_id)
             $flag=1;
          }
          else
          {
            if($performing_authority_e==$id) { $chk='selected'; $flag=1; }
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
                            <td colspan=5 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:163pt'>

  <select id="performing_authority[f]" name="performing_authority[f]"  class="performing_authority form-control authority performing" >
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
    $performing_authority_f=(isset($performing_authority->f)) ? $performing_authority->f : '';

  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
      
          if($performing_authority_f=='')
          { 
             if($id==$user_id)
             $flag=1;
          }
          else
          {
            if($performing_authority_f==$id) { $chk='selected'; $flag=1; }
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
                          </tr>
<?php
     if(isset($records))
     $issuing_authority=json_decode($records['issuing_authority']);
     else
     $issuing_authority=array();
   
     if(isset($records))
     $issuing_authority_approval_status=json_decode($records['issuing_authority_approval_status']);
     else
     $issuing_authority_approval_status=array();


     if(isset($records))
     $extend_issuing_authority_name_of_ia=json_decode($records['extend_issuing_authority_name_of_ia']);
     else
     $extend_issuing_authority_name_of_ia=array();
    
    ?>                          
                                                    <tr height=30 style='mso-height-source:userset;height:22.5pt'>
                            <td height=30 class=xl85 width=831 style='height:22.5pt;border-top:none;
  width:111pt'>Issuing Authority</td>
                            <td colspan=2 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'>
  
<input type="hidden" name="issuing_authority_approval_status[a]" id="issuing_authority_approval_status[1]" value="<?php echo (isset($issuing_authority_approval_status->a)) ? $issuing_authority_approval_status->a : ''; ?>" />
  
  <select id="issuing_authority[a]" name="issuing_authority[a]"  class="issuing_authority form-control authority issuing" style="width: 170px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $issuing_authority_a=(isset($issuing_authority->a)) ? $issuing_authority->a : '';
  
  
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
            if($record_id!=''  && $issuing_authority_a=='')
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($issuing_authority_a>0)
          {
            $flag=1;
            
            if($id==$performing_authority_a)
            $flag=0;
          }
      
      
      if($flag==1)
      {
          if($issuing_authority_a==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
      }
    }
  }
   ?>
                            </select>


<br /><p><b>Name of IA</b></p>
  <?php

   $show_name_of_ia="disabled='disabled';";

   $issuing_authority_approval_status_a=(isset($issuing_authority_approval_status->a)) ? $issuing_authority_approval_status->a : '';

   if($issuing_authority_a==$user_id && $issuing_authority_approval_status_a!='Approved' && $permission==READ)
   $show_name_of_ia='';

  ?>  
 <input type="text" <?php echo $show_name_of_ia; ?> name="extend_issuing_authority_name_of_ia[a]" id="extend_issuing_authority_name_of_ia[a]" class="form-control" value="<?php echo (isset($extend_issuing_authority_name_of_ia->a)) ? $extend_issuing_authority_name_of_ia->a : ''; ?>"/><br />



</td>
                            <td colspan=2 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'>
  
    <input type="hidden" name="issuing_authority_approval_status[b]" id="issuing_authority_approval_status[2]" value="<?php echo (isset($issuing_authority_approval_status->b)) ? $issuing_authority_approval_status->b : ''; ?>" />
  
  <select id="issuing_authority[b]" name="issuing_authority[b]"  class="issuing_authority form-control authority issuing" style="width: 170px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $issuing_authority_b=(isset($issuing_authority->b)) ? $issuing_authority->b : '';
  
  
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
            if($record_id!=''  && $issuing_authority_b=='')
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($issuing_authority_b>0)
          {
            $flag=1;
            
            if($id==$performing_authority_b)
            $flag=0;
          }
      
      
      if($flag==1)
      {
          if($issuing_authority_b==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
      }
    }
  }
   ?>
                            </select>

<br /><p><b>Name of IA</b></p>
  <?php

   $show_name_of_ia="disabled='disabled';";

   $issuing_authority_approval_status_b=(isset($issuing_authority_approval_status->b)) ? $issuing_authority_approval_status->b : '';

   if($issuing_authority_b==$user_id && $issuing_authority_approval_status_b!='Approved' && $permission==READ)
   $show_name_of_ia='';

  ?>  
 <input type="text" <?php echo $show_name_of_ia; ?> name="extend_issuing_authority_name_of_ia[b]" id="extend_issuing_authority_name_of_ia[b]" class="form-control" value="<?php echo (isset($extend_issuing_authority_name_of_ia->b)) ? $extend_issuing_authority_name_of_ia->b : ''; ?>"/><br />

                          </td>
                            <td colspan=2 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'>
  
   <input type="hidden" name="issuing_authority_approval_status[c]" id="issuing_authority_approval_status[3]" value="<?php echo (isset($issuing_authority_approval_status->c)) ? $issuing_authority_approval_status->c : ''; ?>" />
  
  <select id="issuing_authority[c]" name="issuing_authority[c]"  class="issuing_authority form-control authority issuing" style="width: 170px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $issuing_authority_c=(isset($issuing_authority->c)) ? $issuing_authority->c : '';
  
  
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
            if($record_id!=''  && $issuing_authority_c=='')
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($issuing_authority_c>0)
          {
            $flag=1;
            
            if($id==$performing_authority_c)
            $flag=0;
          }
      
      
      if($flag==1)
      {
          if($issuing_authority_c==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
      }
    }
  }
   ?>
                            </select>

<br /><p><b>Name of IA</b></p>
  <?php

   $show_name_of_ia="disabled='disabled';";

   $issuing_authority_approval_status_c=(isset($issuing_authority_approval_status->c)) ? $issuing_authority_approval_status->c : '';

   if($issuing_authority_c==$user_id && $issuing_authority_approval_status_c!='Approved' && $permission==READ)
   $show_name_of_ia='';

  ?>  
 <input type="text" <?php echo $show_name_of_ia; ?> name="extend_issuing_authority_name_of_ia[c]" id="extend_issuing_authority_name_of_ia[c]" class="form-control" value="<?php echo (isset($extend_issuing_authority_name_of_ia->c)) ? $extend_issuing_authority_name_of_ia->c : ''; ?>"/><br />










                          </td>
                            <td colspan=2 class=xl179  style='border-right:1.0pt solid black;
  border-left:none;'>
  


    <input type="hidden" name="issuing_authority_approval_status[d]" id="issuing_authority_approval_status[4]" value="<?php echo (isset($issuing_authority_approval_status->d)) ? $issuing_authority_approval_status->d : ''; ?>" />
  
  <select id="issuing_authority[d]" name="issuing_authority[d]"  class="issuing_authority form-control authority issuing" style="width: 170px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $issuing_authority_d=(isset($issuing_authority->d)) ? $issuing_authority->d : '';
  
  
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
            if($record_id!=''  && $issuing_authority_d=='')
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($issuing_authority_d>0)
          {
            $flag=1;
            
            if($id==$performing_authority_d)
            $flag=0;
          }
      
      
      if($flag==1)
      {
          if($issuing_authority_d==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
      }
    }
  }
   ?>
                            </select>
<br /><p><b>Name of IA</b></p>
  <?php

   $show_name_of_ia="disabled='disabled';";

   $issuing_authority_approval_status_d=(isset($issuing_authority_approval_status->d)) ? $issuing_authority_approval_status->d : '';

   if($issuing_authority_d==$user_id && $issuing_authority_approval_status_d!='Approved' && $permission==READ)
   $show_name_of_ia='';

  ?>  
 <input type="text" <?php echo $show_name_of_ia; ?> name="extend_issuing_authority_name_of_ia[d]" id="extend_issuing_authority_name_of_ia[d]" class="form-control" value="<?php echo (isset($extend_issuing_authority_name_of_ia->d)) ? $extend_issuing_authority_name_of_ia->d : ''; ?>"/><br />




                          </td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;'>
    <input type="hidden" name="issuing_authority_approval_status[e]" id="issuing_authority_approval_status[5]" value="<?php echo (isset($issuing_authority_approval_status->e)) ? $issuing_authority_approval_status->e : ''; ?>" />
  
  <select id="issuing_authority[e]" name="issuing_authority[e]"  class="issuing_authority form-control authority issuing" >
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $issuing_authority_e=(isset($issuing_authority->e)) ? $issuing_authority->e : '';
  
  
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
            if($record_id!=''  && $issuing_authority_e=='')
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($issuing_authority_e>0)
          {
            $flag=1;
            
            if($id==$performing_authority_e)
            $flag=0;
          }
      
      
      if($flag==1)
      {
          if($issuing_authority_e==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
      }
    }
  }
   ?>
                            </select>

<br /><p><b>Name of IA</b></p>
  <?php

   $show_name_of_ia="disabled='disabled';";

   $issuing_authority_approval_status_e=(isset($issuing_authority_approval_status->e)) ? $issuing_authority_approval_status->e : '';

   if($issuing_authority_e==$user_id && $issuing_authority_approval_status_e!='Approved' && $permission==READ)
   $show_name_of_ia='';

  ?>  
 <input type="text" <?php echo $show_name_of_ia; ?> name="extend_issuing_authority_name_of_ia[e]" id="extend_issuing_authority_name_of_ia[e]" class="form-control" value="<?php echo (isset($extend_issuing_authority_name_of_ia->e)) ? $extend_issuing_authority_name_of_ia->e : ''; ?>"/><br />








                          </td>
                            <td colspan=5 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'>
   <input type="hidden" name="issuing_authority_approval_status[f]" id="issuing_authority_approval_status[6]" value="<?php echo (isset($issuing_authority_approval_status->f)) ? $issuing_authority_approval_status->f : ''; ?>" />
  
  <select id="issuing_authority[f]" name="issuing_authority[f]"  class="issuing_authority form-control authority issuing">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $issuing_authority_f=(isset($issuing_authority->f)) ? $issuing_authority->f : '';
  
  
  if($authorities!='')
  {
    foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
            if($record_id!=''  && $issuing_authority_f=='')
          {
             if($id!=$user_id)
             $flag=1;
          }
          else if($issuing_authority_f>0)
          {
            $flag=1;
            
            if($id==$performing_authority_f)
            $flag=0;
          }
      
      
      if($flag==1)
      {
          if($issuing_authority_f==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
      }
    }
  }
   ?>
                            </select>

<br /><p><b>Name of IA</b></p>
  <?php

   $show_name_of_ia="disabled='disabled';";

   $issuing_authority_approval_status_f=(isset($issuing_authority_approval_status->f)) ? $issuing_authority_approval_status->f : '';

   if($issuing_authority_f==$user_id && $issuing_authority_approval_status_f!='Approved' && $permission==READ)
   $show_name_of_ia='';

  ?>  
 <input type="text" <?php echo $show_name_of_ia; ?> name="extend_issuing_authority_name_of_ia[f]" id="extend_issuing_authority_name_of_ia[f]" class="form-control" value="<?php echo (isset($extend_issuing_authority_name_of_ia->f)) ? $extend_issuing_authority_name_of_ia->f : ''; ?>"/><br />








                          </td>
                          </tr>
 <?php
     if(isset($records))
     $reference_code=json_decode($records['reference_code']);
     else
     $reference_code=array();
    
    ?>                                 
<tr height=40 style='height:30.0pt'>
                            <td height=40 class=xl84 width=831 style='height:30.0pt;border-top:none;
  width:111pt'>Reference Code</td>
<?php
    $ref_code_show='hidden';
  
  $issuing_authority_a=(isset($issuing_authority->a)) ? $issuing_authority->a : ''; 
  $issuing_authority_approval_status_a=(isset($issuing_authority_approval_status->a)) ? $issuing_authority_approval_status->a : '';
  
    if($issuing_authority_a==$user_id || $issuing_authority_approval_status_a=='Approved')
  $ref_code_show='text';
  ?>      
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:124pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->a)) ? $reference_code->a : ''; ?>" name="reference_code[a]" id="reference_code1"  class="reference_code form-control" style="width: 107px;" /></td>
  <?php
    $ref_code_show='hidden';
  
  $issuing_authority_b=(isset($issuing_authority->b)) ? $issuing_authority->b : ''; 
  $issuing_authority_approval_status_b=(isset($issuing_authority_approval_status->b)) ? $issuing_authority_approval_status->b : '';
  
    if($issuing_authority_b==$user_id || $issuing_authority_approval_status_b=='Approved')
  $ref_code_show='text';
  ?>  
      
  
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:126pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->b)) ? $reference_code->b : ''; ?>" name="reference_code[b]" id="reference_code2"   class="reference_code form-control" style="width: 107px;" /></td>
    <?php
    $ref_code_show='hidden';

  $issuing_authority_c=(isset($issuing_authority->c)) ? $issuing_authority->c : ''; 
  $issuing_authority_approval_status_c=(isset($issuing_authority_approval_status->c)) ? $issuing_authority_approval_status->c : '';
  
    if($issuing_authority_c==$user_id || $issuing_authority_approval_status_c=='Approved')
  $ref_code_show='text';
  ?>  
  
    
  
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:117pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->c)) ? $reference_code->c : ''; ?>" name="reference_code[c]" id="reference_code3"   class="reference_code form-control" style="width: 107px;" /></td>
  
  <?php
    $ref_code_show='hidden';
  
  $issuing_authority_d=(isset($issuing_authority->d)) ? $issuing_authority->d : ''; 
  $issuing_authority_approval_status_d=(isset($issuing_authority_approval_status->d)) ? $issuing_authority_approval_status->d : '';
  
    if($issuing_authority_d==$user_id || $issuing_authority_approval_status_d=='Approved')
  $ref_code_show='text';
  ?>  
    
  
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->d)) ? $reference_code->d : ''; ?>" name="reference_code[d]"  id="reference_code4"  class="reference_code form-control" style="width: 107px;" /></td>
  
  <?php
    $ref_code_show='hidden';
  
  $issuing_authority_e=(isset($issuing_authority->e)) ? $issuing_authority->e : ''; 
  $issuing_authority_approval_status_e=(isset($issuing_authority_approval_status->e)) ? $issuing_authority_approval_status->e : '';
  
    if($issuing_authority_e==$user_id || $issuing_authority_approval_status_e=='Approved')
  $ref_code_show='text';
  ?>  
  
    
  
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:173pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->e)) ? $reference_code->e : ''; ?>" name="reference_code[e]" id="reference_code5"   class="reference_code form-control" style="width: 107px;" /></td>
  
  <?php
    $ref_code_show='hidden';
  
  $issuing_authority_f=(isset($issuing_authority->f)) ? $issuing_authority->f : ''; 
  $issuing_authority_approval_status_f=(isset($issuing_authority_approval_status->f)) ? $issuing_authority_approval_status->f : '';
  
    if($issuing_authority_f==$user_id || $issuing_authority_approval_status_f=='Approved')
  $ref_code_show='text';
  ?>  
    
  
                            <td width="213" colspan=5 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:163pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->f)) ? $reference_code->f : ''; ?>" name="reference_code[f]" id="reference_code6"   class="reference_code form-control" style="width: 107px;" /></td>
                          </tr>                          
                          
                           
                           <tr height=31 style='height:23.25pt'>
                            <td colspan=16 height=31 class=xl182 style='border-right:1.0pt solid black;
  height:23.25pt;width:936pt'>
                        <b><?php echo EMERGENCY_CONTACT_NUMBER; ?>
</b>
 
                          </td></tr>
                          
                        </table>
                        <div>&nbsp;</div>
                        <input type="hidden" id="show_button" name="show_button" />
                        <?php
            $is_show_button=(isset($records['show_button'])) ? $records['show_button'] : 'show';
            
            $is_popup_submit=$is_extended=$is_show_extended_button=0;
            
            $show_extend_field=-01;
            
            $show_flag=2;

            $redirect=$ext_name_of_ia=$ext_range=$cancel_ia='';

            $is_draft=(isset($records['is_draft'])) ? $records['is_draft'] : NO;

            $draft_user_id=(isset($records['draft_user_id'])) ? $records['draft_user_id'] : '';

            $submit_value='show'; $show_draft=0;

            $draft=NO;

            if($is_draft==YES && $user_id!=$draft_user_id)
              $draft=YES;
            
            if($approval_status<9 && $draft==NO)
            {
                if($is_show_button=='show')
                {
                  $label=' Submit';
                  
                  $submit_value='show';             
                  
                  $show_final=0;
                  
                  if($record_id!='')
                  {
                    //If IA approved and PA come back his job
                    if($acceptance_issuing_approval=='Yes' && $user_id==$records['acceptance_performing_id'])
                    {
                      $show_final=1;
                      
                      $show_flag=2;
                    }
                    else if($acceptance_issuing_approval=='No' && $user_id==$records['acceptance_issuing_id'])
                    {
                      $label=' Approve & Submit';
                      
                      $submit_value=' approveIA'; 
                      
                      $is_popup_submit=1;
                      
                      if($job_status_error_msg!='')
                      $show_flag=22;
                      else                  
                      $show_flag=2;           
                    }
                    else if($acceptance_issuing_approval=='No' && $user_id==$records['acceptance_performing_id'])
                    {
                      $show_flag=2;
                    }
                    else if($acceptance_issuing_approval=='Yes' && $user_id==$records['acceptance_issuing_id'])
                    {
                      $show_flag=1;
                    }
                    else
                    $show_flag=1;
                    
                    
                  }
                  
                  if($show_flag==2)
                  {
                       if($show_final==0) 
                            echo '<button class="btn btn-sm btn-primary show_button" id="submit" value="'.$submit_value.'" type="submit"><i class="fa fa-dot-circle-o"></i> '.$label.'</button>';
                      else { #$is_popup_submit=1;
                      
                            $submit_value='hide';

                           echo '<button class="btn btn-sm btn-primary show_button" id="submit" value="hide" type="submit"><i class="fa fa-dot-circle-o"></i> Final Submit</button>';
                      }
                  }
                }
                else
                {
                  if($approval_status!=4)
                  {
                    #in_array($user_id,array($acceptance_performing_id,$cancellation_performing_id)) && 
                    if(strtolower($status)=='extended')
                    {
                      $range=range('a','f'); 
                        $r=0;

                           if(isset($records))
                           $issuing_authority=json_decode($records['issuing_authority'],true);
                           else
                           $issuing_authority=array();

                           if(isset($records))
                           $issuing_authority_approval_status=json_decode($records['issuing_authority_approval_status'],true);
                           else
                           $issuing_authority_approval_status=array();

                           if(isset($records))
                           $performing_authority=json_decode($records['performing_authority'],true);
                           else
                           $performing_authority=array();
                         
                      foreach($range as $key => $rr)
                      {
                        
                        #echo '<br /> A '.$performing_authority->$range[$r].' - == '.$user_id.' && '. $issuing_authority_approval_status->$range[$r];
                        
                        if($issuing_authority[$rr]==$user_id && $issuing_authority_approval_status[$rr]!='Approved')
                        {
                          $is_extended=1; $is_show_extended_button=1;


                           if($permission==READ)
                            { $ext_range=$rr; $ext_name_of_ia=$issuing_authority[$rr]; }

                          $submit_value='hides';

                          echo '<button class="btn btn-sm btn-primary show_button" id="submit" value="hides" type="submit"><i class="fa fa-dot-circle-o"></i> Approve '.$status.' & Submit</button>';  
                         break;
                        }
                        if($performing_authority[$rr]==$user_id && !in_array($issuing_authority_approval_status[$rr],array('Approved','')))
                        {
                          $show_extend_field=$r;
                          
                          $is_extended=1; $is_show_extended_button=0; break;
                        }
                        else if($issuing_authority[$rr]!='' && $issuing_authority_approval_status[$rr]!='Approved') 
                        {
                          $is_extended=$is_show_extended_button=1;
                        }
                        
                        $r++;
                        
                      }
                      if($is_show_extended_button==0)
                      {
                        $submit_value='show';
                          echo '<button class="btn btn-sm btn-primary show_button" id="submit" value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>';
                      }    
    
                    }
                    else if(!in_array($approval_status,array(3,5,6)) || ($cancellation_performing_id==$user_id && $cancellation_issuing_date==''))  
                    {
                        $show_flag=2; $submit_value='show';
                    echo '<button class="btn btn-sm btn-primary show_button" id="submit" value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>'; }
                    else if(in_array($user_id,array($cancellation_issuing_id)) && in_array($approval_status,array(3,5)))
                    {
                      $cancel_ia=1; $submit_value='show';
                    echo '<button class="btn btn-sm btn-primary show_button" id="submit" value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Approve '.$status.' & Submit</button>';
                    $show_flag=2;
                    }
                                    
                  }
                  
                }
                  
                  /*if($is_show_button=='show')
                  $redirect=base_url().'jobs/';
                  else
                  $redirect=base_url().'jobs/day_in_process'; */
                  
            ?>
                        <input type="hidden" id="is_popup_submit" name="is_popup_submit" value="<?php #echo $is_popup_submit; ?>"  />
                        <?php
            }
            
            $redirect=base_url().$param_url;
            ?>
                           <a  class="btn btn-sm btn-danger" href="<?php echo $redirect; ?>"><i class="fa fa-ban"> Go Back</i></a>  
                           
                           <?php if($approval_status<2 || $record_id=='') { ?>
            <button class="btn btn-sm btn-info show_button" id="draft" data-submit="0" value="<?php echo $submit_value; ?>" type="submit"><i class="fa fa-dot-circle-o"></i> Save as Draft</button> <?php } ?>
                
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
                      </div>
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
<?php $this->load->view('layouts/footer'); ?>      
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script> 
<script>
  $(document).ready(function() {

    $('#gritter_trigger').val(''); // skip gritter success popup

		 var counter = 1; // define textbox counts
    
    	$("#append").click( function(e) {

        e.preventDefault();
        
        if(counter >= 10)
        {
          alert("Only 10 textboxes allowed");
          return false;
        }

        $(".inc").append('<div class="controls watch_person_div"><input class="form-control watch_person_textbox" type="text" name="watch_other_person_names[]" style="width:250px;"><a href="javascript:void(0);" class="remove_this btn btn-danger add_remove_btn">Remove</a><br></div>');

        counter++;

        return false;
        });

   
    });



</script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/utpumps_permits.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.thickbox.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<link href="<?php echo base_url(); ?>assets/css/jquery.thickbox.css" rel="stylesheet" media="screen" type="text/css" />

<link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet"type="text/css" />
<script src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

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
    
    
    <?php
    $acceptance_issuing_approval=isset($records['acceptance_issuing_approval']) ? $records['acceptance_issuing_approval'] : 'No';
    if($acceptance_issuing_approval=='No')
    {
    ?>  
    $('.extended_contractors_id,.schedule_date,.no_of_persons,.performing_authority,.issuing_authority,.schedule_from_time,.schedule_to_time').attr('disabled',true);
    <?php
    }


    
    if(!empty($record_id))
    {
      if($show_flag==1 || $approval_status==9 || $approval_status==10)
      {
    ?>
      $('input,select').attr('disabled',true);
    <?php
      }
    ?>
      $('#acceptance_performing_id').attr('disabled',true);
    <?php 
      if($acceptance_performing_id!=$user_id)
      {
    ?>
      $('#acceptance_issuing_id').attr('disabled',true);
    <?php
      }
    }
    else
    {
    ?>
    //$('.precautions').attr('disabled',true);  //,.hazard_option,.precaution_option
    <?php 
    }
    if($acceptance_issuing_approval=='Yes' )# || 
    {
    ?>
      $('input,select').attr('disabled',true);
    <?php 
      //if( $user_id==$acceptance_performing_id && $readonly===true)
      //{
    ?>
        $('.status').removeAttr('disabled');  //changed by today
    <?php
    //  }
      
      if(strtolower($status)=='extended')
      {
          if($is_extended==1)
          echo "$('.status').attr('disabled',true);";
          
          #echo 'Anand  '.$show_extend_field;  exit;
          
          if($show_extend_field>=0)
          {
          
            $show_extend_field=($show_extend_field)+1;
      ?>      
            //$('.status,#schedule_date').removeAttr('disabled');alert(<?php echo $show_extend_field; ?>);
  
            
            //alert($('select[name="schedule_from_time['<?php echo $range[$show_extend_field-1]; ?>']"]').val());
              $('.status').removeAttr('disabled').attr('readonly',true);
              $('.status:checked').trigger('click');  
              $('select[name="schedule_from_time[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('select[name="schedule_to_time[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('input[name="no_of_persons[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('input[name="schedule_date[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('select[name="issuing_authority[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('select[name="extended_contractors_id[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('input[name="extended_others_contractors_id[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
      <?php
          }
      ?>    
        $('#cancellation_performing_id,#cancellation_issuing_id').attr('disabled',true);
      <?php
      }
      else
      {
          if($approval_status>2)
          {
        ?>
          $('#cancellation_performing_id,#cancellation_issuing_id,.status').attr('disabled',true);  
        <?php
            if($user_id==$cancellation_performing_id && $cancellation_issuing_date=='')
            {
        ?>
              $('#cancellation_issuing_id,.status').removeAttr('disabled');   //,.status Removed on 12-06     
        <?php
            }
          }
      }

       if($user_id==$ext_name_of_ia && $permission==READ)
       {
       echo "$('input[name=\"extend_issuing_authority_name_of_ia[".$ext_range."]\"]').removeAttr('disabled');";
       }

       if($cancel_ia==1 && $permission==READ)
       {
          echo "$('input[name=\"cancellation_name_of_ia\"]').removeAttr('disabled');";
       }

    ?>  
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

        
        if($('.status:checked').val()!='Extended')
        {
          $('#change_status_label').html($('.status:checked').val());

          d=0;
          $('input[name^="schedule_date"]').each(function()
          {
            
            //console.log('WW '+$('input[id="issuing_authority_approval_status['+d+']"]').val());
            d++;
            if($('input[id="issuing_authority_approval_status['+d+']"]').val()=='Waiting')
            {
              alert("Sorry, you can't "+$('.status:checked').val()+" this job. Please check job approval status");
              
              //$('.status').removeAttr('checked');
              
              $('input[name="status"]').removeAttr('checked');
              
              return false;
              
            }
            
          
          });
          $('select[name^="schedule_from_time"] option:not(:selected),select[name^="schedule_to_time"] option:not(:selected),select[name^="performing_authority"] option:not(:selected),select[name^="issuing_authority"] option:not(:selected),select[name^="extended_contractors_id"] option:not(:selected)').prop('disabled', true);

          $('input[name^="no_of_persons"],input[name^="schedule_date"]').attr('disabled','disabled');  
          
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
            
            var escaped_selector_name = selector_name.match(/\[(.*?)\]/);
            
            var selector_name=escaped_selector_name[1];
            
            var date_diff = $(this).attr('data-diff');
            
            var data_ia_approval=$(this).attr('data-ia-approval').toLowerCase(); 
            
            if(date_diff<0 && data_ia_approval!='approved')
            return false;
            
            if(d!=1)
            acceptance_issuing_date=$('#schedule_date'+(d-1)).val();  
            
                min_date=(parseInt)(d-1);             
                
                max_date='+'+d+'d';
                
                //console.log('DD :'+d + ' - Difference : '+date_diff);
                
                set_date=new Date();
                
                
                if(date_diff==0)
                {
                   max_date='+1d';
                   
                   min_date='-0';
                   
                  if(schedule_date!=acceptance_issuing_date && schedule_date!='')
                  min_date=max_date='-0';
                  
                   console.log('Dfiif 0 '+d + acceptance_issuing_date+ ' = '+min_date+' '+max_date);
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
                  
                  //console.log('Failed Date'+min_date+' - '+max_date+ ' = '+set_date);
                }
                
                console.log('Final '+min_date+' - '+max_date+ ' = '+set_date);
                //$( "#schedule_date"+d ).datepicker();
                
                //$("#schedule_date"+d).datepicker('setValue',set_date);   
                
                //$("#schedule_date"+d ).datepicker("setValue",  set_date);
              
                $( "#schedule_date"+d ).datepicker({
                  dateFormat: 'dd-mm-yy',
                  inline: true,
                  minDate:min_date,
                  maxDate: max_date,
                  onSelect: function (date) {
                    //$('input[name="schedule_from_time['+selector_name+']"]').val(ShowLocalTime);
              //alert('Select '+Math.random().toString(36).substring(7));
              
                    //$('input[name="reference_code['+selector_name+']"]').val(Math.random().toString(36).substring(7));
                    
                    //$('input[name="reference_code['+selector_name+']"]').val($('#permit_no').val()+'-0'+d);

                     $('input[name="reference_code['+selector_name+']"]').val(Math.random().toString(13).substring(0,9).replace('0.', ''));
                      
                    
                     $('select[name="schedule_from_time['+selector_name+']"],input[name="no_of_persons['+selector_name+']"],select[name="schedule_to_time['+selector_name+']"],select[name="extended_contractors_id['+selector_name+']"],input[name="extended_others_contractors_id['+selector_name+']"],select[name="issuing_authority['+selector_name+']"],select[name="performing_authority['+selector_name+']"]').prop('disabled',false);
                    
                     $('select[name="schedule_from_time['+selector_name+']"],select[name="schedule_to_time['+selector_name+']"]').removeAttr('readonly');
                    
                     $('select[name="schedule_from_time['+selector_name+']"],select[name="schedule_to_time['+selector_name+']"]').removeAttr('disabled');

                     $('select[name="schedule_from_time['+selector_name+']"],select[name="schedule_to_time['+selector_name+']"]').prop('disabled',false);

                     $('select[name="extended_contractors_id['+selector_name+']"],input[name="extended_others_contractors_id['+selector_name+']"]').removeAttr('readonly');

                     $('select[name="extended_contractors_id['+selector_name+']"],input[name="extended_others_contractors_id['+selector_name+']"]').prop('disabled',false);
                    
                    },
                  showButtonPanel: true,
                  closeText: 'Clear',
                  onClose: function(e) {
                  }
                }).focus(function() {
                  
                  console.log('Current : '+$(this).attr('data-id'));
                  //alert('Close '+Math.random().toString(36).substring(7));
                  $('.ui-datepicker-close').click(function() {
                      
                    $('select[name="schedule_from_time['+selector_name+']"],input[name="reference_code['+selector_name+']"],input[name="no_of_persons['+selector_name+']"],select[name="extended_contractors_id['+selector_name+']"],input[name="extended_others_contractors_id['+selector_name+']"],select[name="schedule_to_time['+selector_name+']"],select[name="issuing_authority['+selector_name+']"],select[name="performing_authority['+selector_name+']"]').val('').prop('disabled',true);
                    
                    $('selector').datepicker('setDate', null);
                    $('input[name="schedule_date['+selector_name+']"]').val('');
                    $('input[name="issuing_authority_approval_status['+selector_name+']"]').val('');
                    });
                  
                   });
                   
              
              show_next=0;
              
              if(d!=1)
              {
                if($('input[id="issuing_authority_approval_status['+(parseInt(d)-parseInt(1))+']"]').val()!='Approved')
                show_next=1;  
                
              }
              
              if($('input[name="schedule_date['+selector_name+']"]').val()=='' && show_next==0)
              { 
                $('input[name="schedule_date['+selector_name+']"]').prop('disabled',false);  
                
                return false;
              }
              else
              return true;
              
          });
          
          
        }
      });
      
      if($('.status:checked').val()!='')
      {
        <?php
        if($user_id!=$cancellation_performing_id)
        {
        ?>  
        $('.status:checked').trigger('click');
        <?php
        }
        ?>
      }
    <?php 
    }
    ?>
    
    function ShowLocalDate()
    {
      var dNow = new Date();
      
      var localdate= ( (dNow.getDate()<10?'0':'') + dNow.getDate() ) + '-' + ( ((dNow.getMonth()+1)<10?'0':'') + (dNow.getMonth()+1) ) + '-' + dNow.getFullYear() + ' ' + ( (dNow.getHours()<10?'0':'') + dNow.getHours() ) + ':' +
       ( (dNow.getMinutes()<10?'0':'') + dNow.getMinutes() );
       
       
       
        // console.log( (dNow.getMinutes()<10?'0':'') + dNow.getMinutes() );
       
       // console.log( (dNow.getHours()<10?'0':'') + dNow.getHours() );
      
      return localdate;
      
    }
    
    function ShowLocalTime()
    {
      var dNow = new Date();
      
      var localdate= ( (dNow.getHours()<10?'0':'') + dNow.getHours() ) + ':' + (dNow.getMinutes()<10?'0':'');
      
      return localdate;     
    }
    
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
    
    $('#acceptance_issuing_id').change(function() {
        
        var va=$(this).val();
        
        //$('#acceptance_issuing_date').val('');
        
        //if(va!='')        
        //$('#acceptance_issuing_date').val(ShowLocalDate());
    });
    
    $('#cancellation_performing_id').change(function() {
        
        var va=$(this).val();
        
        $('#cancellation_performing_date').val('');
        
        var eip=$('input[name=is_isoloation_permit]:checked').val();
        
        if(va!='')        
        {
          $('#cancellation_performing_date').val(ShowLocalDate());
          
          $('#cancellation_issuing_id,#cancellation_issuing_date').removeAttr('disabled');
        }
        else
        $('#cancellation_issuing_id,#cancellation_issuing_date').attr('disabled',true);
    });
    
    
    
  <!-- Show transaction info in popup -->
  $('body').on('click','.show_energy_info',function() {
    
    var id=$(this).attr('data-id');
    
    var data = new FormData();
    
    data.append('id',id);
    
    
    $.ajax({
      url: base_url+'jobs/ajax_show_energy_info/',
      type: 'POST',
      "beforeSend": function(){ console.log('Before Send'); },
      data: data,
      cache: false,
      processData: false, // Don't process the files
      contentType: false, // Set content type to false as jQuery will tell the server its a query string request
      success: function(data, textStatus, jqXHR)
      {
        $('#show_information').html(data);
      },
      error: function(jqXHR, textStatus, errorThrown)
      {
        $('#show_information').html('Invalid Credentials');
      }
    });
  });
    
    
    $('.datepicker').prop('readonly', true);
    
    $('.zone_list').change(function() {
      
      var val=$(this).val();
      
      var spl='';
      
      if(val!='')
      {
         spl=val.split('|');
       
        //$('#zone_id').html(spl[1]); 
        
        
          $.ajax({    
            "type" : "POST",
            dataType: 'json',
            "beforeSend": function(){  },
            "url" : base_url+'jobs/ajax_fetch_department_users/',
            "data" : {'department_id' : spl[0]},
            success: function(data){
              
              $('.performing').html(data.pa);
              
              $('.issuing').html(data.ia);
            }
          });     
        
        
      }
      else { 
      //$('#zone_id').html('- - -'); 
      
      $('.performing,.issuing').html('<option value="">- - Select - -</option>');
      
        }
          
    });
    
  $('.show_button').click(function() {
    $('#show_button').val($(this).val());
  }); 
  
  $('.on_off').change(function() {
    
    var date_relate=$(this).attr('data-relate');
    
    var val=$(this).val();
    
    if(date_relate!='')
    {
      if(val=='Yes')
      {
        
        $('.'+date_relate).removeAttr('disabled');
        
        //$('#energy_form').trigger('click');   
      }
      else
      { $('.'+date_relate).attr('disabled',true);  $('.'+date_relate).removeClass('error'); }
    }
  }); 
    
    
$('.required_ppe').change(function()
{
  var data_other=$(this).attr('data-other');
  
  if(typeof data_other!=='undefined')
  { 
    if($(this).is(':checked'))
    $('#'+data_other).removeAttr('disabled');
    else
    {
      $('#'+data_other).attr('disabled','disabled');
      
      $('#'+data_other).val('');
    }
      
    
  }
  
  //alert($(this).attr('data-other'));
    
});
    



$(".box_big").click(function() {
    
        $('.required_ppe:eq(4)').removeAttr('checked');
        //$('.required_ppe:eq(4)').removeAttr('disabled');
    
  $(".box_big:checked").each(function(index,value) {  
      if($(this).val()=='height_work')
      {
        $('.required_ppe:eq(4)').prop('checked', true);
        //$('.required_ppe:eq(4)').prop('disabled', true);
      }
  });
});





$('input[name=is_isoloation_permit]').change(function() {
  
  var sel_val=$(this).val();
  
  var acceptance_performing_id=$('#acceptance_performing_id').val();
  
  var id=$('#id').val();
  
  if(id=='')
  {
    $('#acceptance_issuing_id,#acceptance_issuing_date,#acceptance_performing_id,#acceptance_performing_date').val('');
    
    $('#acceptance_issuing_id,#acceptance_issuing_date').attr('disabled',true); 
  }
  console.log('Val '+sel_val);
    
    if(sel_val=='Existing')
    {
      $('select.selected_eip').select2("enable");
      
      $selected_eip.rules('add','required');
    }
    else
    {
      $('select.selected_eip').select2("disable")
      
      $("select.selected_eip").select2("val", "");  
      
      $selected_eip.rules('remove','required');
    }
  
});

$('.contractors').change(function()
{
    var data_show=$(this).attr('data-show');  
  
    if($(this).val()=='others')    
    {
       $('#'+data_show).show();

       $('#'+data_show).prop('disabled',false);
    }      
    else
    {
        $('#'+data_show).hide().val('');
        $('#'+data_show).prop('disabled',true);
    }    
  
  
});
    <?php $flag='true';
    
    #$arr=array('a','b','c','d','e','f','g','h',);
    
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
        
        $validate.=",'extended_contractors_id[".$arr[$i]."]':{required:function(element) {
                        if($('input[name=\"schedule_date[".$arr[$i]."]\"]').val()!='')
                        return true; 
                        else return false;
                       }}";
        
        $validate.=",'extended_others_contractors_id[".$arr[$i]."]':{required:function(element) {
                        if($('select[name=\"extended_contractors_id[".$arr[$i]."]\"]').val()=='others')
                        return true; 
                        else return false;
                       }}";    

                       
        $validate.=",'no_of_persons[".$arr[$i]."]':{required:function(element) {
                        if($('input[name=\"schedule_date[".$arr[$i]."]\"]').val()!='')
                        return true; 
                        else return false;
                       },digits:true,minStrict: 0 }";
        $validate.=",'performing_authority[".$arr[$i]."]':{required:function(element) {
                        if($('input[name=\"schedule_date[".$arr[$i]."]\"]').val()!='')
                        return true; 
                        else return false;
                       }}";
        $validate.=",'issuing_authority[".$arr[$i]."]':{required:function(element) {
                        if($('input[name=\"schedule_date[".$arr[$i]."]\"]').val()!='')
                        return true; 
                        else return false;
                       }}";

        $validate.=",'extend_issuing_authority_name_of_ia[".$arr[$i]."]':{required:true}";                    
      }

    }
    
  #if($acceptance_performing_id==$user_id && $approval_status==1)
  if($acceptance_performing_id==$user_id && $approval_status<=2)
  $validate.=",'self_cancellation_description':{required:function(element) {
                        if($('input[name=self_cancellation]:checked').val()=='cancel' || $('.status:checked').val()=='Cancellation')
                        return true; 
                        else return false;
                       }}";

    #$validate='';
    
    
     ?>

      $('#draft').click(function() 
      { 
           $('input, select, textarea').each(function() {
                $(this).removeClass('error');
            });
            
            $('#job_form').removeData('validator');

            $("#job_form").validate({ 
                      ignore: '.ignore',
                      focusInvalid: true, 
              rules: {
                job_name: { required:<?php echo $flag; ?> },
                acceptance_performing_id : { required:<?php echo $flag; ?>}
                    },
              messages:
              {
                job_name : {required:'Required' },
                acceptance_performing_id : {required:'Required' }
              },
            errorPlacement: function(error,element){
                    error.appendTo(element.parent().parent());                        
                },          
            invalidHandler: function(form, validator) {
              submitted = true;
            },          
                submitHandler:function()
                {
                    $('#is_popup_submit').val(1);
            
                    if($('#is_popup_submit').val()==1)
                    {
                        if($('#draft').attr('data-submit')==0)
                        {
                          $('#draft').attr('data-submit',1);

                          form_submit('draft');
                        }  
                    }
              
                    return false;   
              
                }
            });
      });

      $('#submit').click(function() 
      { 
            $("#job_form").validate({ 
                      ignore: '.ignore',
                      focusInvalid: true, 
              rules: {
                department_id:{required:<?php echo $flag; ?>},
                zone_id:{required:<?php echo $flag; ?>},
                //'other_inputs[]': { required:<?php echo $flag; ?>,minlength:1},alert($('input[name="other_inputs"]:checked').length);
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
                contractors_involved: { required:<?php echo $flag; ?>,digits:true,minStrict: 0 },
                acceptance_performing_id : { required:<?php echo $flag; ?>},
                acceptance_issuing_id : { required:<?php echo $flag; ?>},
                status : { required: true },
                cancellation_name_of_ia : { required:<?php echo $flag; ?>},
                acceptance_name_of_ia: { required:<?php echo $flag; ?>},
                required_ppe_other : { required:true}       
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
                job_name:{required:'Required' },
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
                    $('#is_popup_submit').val(1);
            
                    if($('#is_popup_submit').val()==1)
                    form_submit('submit');
              
                    return false;   
              
                }
            });
      });

    $.validator.addMethod('minStrict', function (value, el, param) {
      return value > param;
    }); 

    if($('#submit').length<=0)
    {
        
        $('#draft').hide();

         $('input,select').attr('disabled',true);
    }
  
    function form_submit(submit_type)
    {
      
      //alert('Parent;');
      
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
          
          data.append('submit_type',submit_type);

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
          
         // data.append('is_isoloation_permit',$('input[name=is_isoloation_permit]:checked').val());
          
          //data.append('status',$('input[name=status]:checked').val());
          
          //data.append('is_scaffolding_certification',$('input[name=is_scaffolding_certification]:checked').val());    
          
          //data.append('acceptance_performing_id',$('#acceptance_performing_id').val());
          data.append('acceptance_performing_date',$('#acceptance_performing_date').val());
          
          //data.append('acceptance_issuing_id',$('#acceptance_issuing_id').val());
          data.append('acceptance_issuing_date',$('#acceptance_issuing_date').val());
          
          //data.append('cancellation_performing_id',$('#cancellation_performing_id').val());
          data.append('cancellation_performing_date',$('#cancellation_performing_date').val());
          
          //data.append('cancellation_issuing_id',$('#cancellation_issuing_id').val());
          data.append('cancellation_issuing_date',$('#cancellation_issuing_date').val());
          
          $("#job_form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled',true);   
          $(".btn-danger").attr('disabled',true);   
          
          
          if($('input[name=status]').length>0)
          data.append('status',$('input[name=status]:checked').val());
           
          $.ajax({
                  url: base_url+'utpumps/form_action',
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
                        window.location.href=base_url+'utpumps/form/id/'+$('#id').val();
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
