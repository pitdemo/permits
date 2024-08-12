<?php 
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


 
 $user_role=strtolower($this->session->userdata('user_role'));
 $this->load->view('layouts/header',array('page_name'=>$page_name));

 $completion_lists=array('a'=>'Men, material, & tools have been cleared','b'=>'Safety nets/Lifelines removed','c'=>'Caution boards/barricade removed','d'=>'Checked the working & adjacent areas and found no smoke & fire','e'=>'Guards have been placed back in position','f'=>'Openings/Handrails fixed back','h'=>'Scaffholding/Ladder has been removed','i'=>'Area has been cleaned (Oil spillage, Oil Soaked cotton waste, Scraps, etc) and inspected');
?>
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap.css" rel="stylesheet">
<style>
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
.schedule_to_time { margin-bottom: 3px; }

.select2-container.select2-container-multi.form-control.selected_eip.error { border-color:red; }
span.error{
    outline: none;
    border: 1px solid #800000;
    box-shadow: 0 0 5px 1px #800000;
  }
  #person_name-error { padding-left: 20px; }

  .hazards_options,.precautions_options { vertical-align: middle; margin-top:2px !important;}
</style>


<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="<?php echo base_url(); ?>jobs/"><i class="fa fa-home"></i>Combined Work Permits</a></li>
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
  ?>
                                        
                                        
                                                        <form id="job_form" name="job_form" enctype="multipart/form-data" > 
                  <input type="hidden" id="id" name="id" value="<?php echo (isset($records['id'])) ? $records['id'] : ''; ?>" />
                    <input type="hidden" id="permit_no" name="permit_no" value="<?php echo (isset($records['permit_no'])) ? $records['permit_no'] : $permit_no ?>" />
                   
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
                              <td colspan="8">
                                <b>Line</b>
                                <?php $line=(isset($records['line'])) ? $records['line'] : ''; ?>
                              <br /><br />
                              <input name="line" type="radio" <?php if($line==1) { ?> checked="checked" <?php } ?> class="radio_button" value="1" />
                              Line 1&nbsp;
                              <input type="radio" name="line" class="radio_button" value="2"  <?php if($line==2) { ?> checked="checked" <?php } ?> />
                              Line 2&nbsp;
                              <input type="radio" name="line" class="radio_button" value="3"  <?php if($line==3) { ?> checked="checked" <?php } ?> />
                              Colony&nbsp;
                              &nbsp;
                              <input type="radio" name="line" class="radio_button" value="4"  <?php if($line==4) { ?> checked="checked" <?php } ?> />
                              Mines&nbsp;
                              </td>
                          </tr>
                          <?php
  if(isset($records))
  $work_types=explode(',',rtrim($records['work_types'],','));
  else
  $work_types=array();
 ?>
                          <tr height=31 style='mso-height-source:userset;height:23.25pt'>
                            <td height=94 class=xl97 width=831 style='height:23.25pt;width:111pt'>&nbsp;</td>
                            <td colspan=3 class=xl162 style='width:189pt'><center>
                              <b>HEIGHT WORK</b>
                            </center></td>
                            <td rowspan=2 height=94 width=77  align="center" valign="middle"><input type="checkbox" name="works[]" value="height_work"  <?php if(in_array('height_work',$work_types)) { ?> checked="checked" <?php } ?>   class="box_big" /></td>
                            <td colspan=3 class=xl162 style='width:184pt'><center>
                              <b>HOT WORK</b>
                            </center></td>
                            <td rowspan=2 height=94 width=108 align="center" valign="middle"><input type="checkbox" name="works[]" value="hot_work" class="box_big" <?php if(in_array('hot_work',$work_types)) { ?> checked="checked" <?php } ?> /></td>
                            <td colspan=3 class=xl104 style='width:173pt'><center>
                              <b>GENERAL WORK</b>
                            </center></td>
                            <td rowspan=2 height=94 colspan="4" align="center" valign="middle"><input type="checkbox" name="works[]" value="general_work" class="box_big" <?php if(in_array('general_work',$work_types)) { ?> checked="checked" <?php } ?>/></td>
                          </tr>
                          <tr height=63 style='mso-height-source:userset;height:47.25pt'>
                            <td height=94 class=xl71 width=831 style='height:47.25pt;width:111pt'>&nbsp;</td>
                            <td colspan=3 class=xl188 style='width:189pt'>Work at a Height of
                              1.5 Mts. &amp; above</td>
                            <td colspan=3 class=xl188 style='width:184pt'>Work related to
                              Welding / Cutting /Grinding /Open flame</td>
                            <td colspan=3 class=xl190 >Works other than
                              Height, Hot, Confined Space,Electrical &amp; Excavation</td>
                          </tr>
                          <tr height=23 style='mso-height-source:userset;height:17.25pt'>
                            <td rowspan=4 height=117 class=xl123 width=831 style='height:87.75pt;width:111pt;' valign="top"><center>
                              <b>Location</b>
                            </center>
                              <br />
                              <br />
                              <input type="text" class="form-control" name="location" id="location" value="<?php echo (isset($records['location'])) ? $records['location'] : ''; ?>" placeholder="Location Here..." /></td>

                              <td colspan="3" class=xl106 style='border-left:none;width:130pt;' valign="middle"><center>
                              <b>Date & Time</b>
                            </center></td>

                            <!--<td  class=xl106 style='border-left:none;width:130pt;' valign="middle"><center>
                              <b>Date</b>
                            </center></td>
                            <td colspan=2 class=xl106 style='border-left:none;width:130pt;padding:2px;' valign="top"><input type="text" class="form-control " readonly="readonly" name="location_date" id="location_date" width="50px"  value="<?php echo (isset($records['location_date'])) ? $records['location_date'] : date('d-m-Y'); ?>" /></td>-->



                            <td colspan=4 class=xl108 style='border-right:.5pt solid black;
  width:245pt'><span style='mso-spacerun:yes'> </span><b>Hazards / concerns
                              Identified:</b></td>
                            <td class=xl86 width=108 style='border-top:none;border-left:none;width:55pt'><center>
                              <b>YES/NO</b>
                            </center></td>
                            <td colspan=6 class=xl108 style='border-left:none;width:247pt'><b>Precautions to be Taken:</b></td>
                            <td class=xl89 style='width:89pt'><center>
                              <b>YES/NA</b>
                            </center></td>
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
                           <td rowspan="3" class=xl106 width=426 style='width:59pt' valign="top"><center>
                             <br/> <b>From</b>
                             <br/>
                             <br/><br/><br/>
                             <b>To</b>
                            </center></td>

                            <td rowspan=3 colspan="2" height=117 class=xl111 width=83 style='border-bottom:.5pt solid black;
  height:70.5pt;border-top:none;width:65pt' valign="top"><center>
                              <!-- <b>FROM</b><br />-->
                              <br /> 
                              <?php #echo generate_time(array('width'=>'75px','name'=>'location_time_start','selected_value'=>(isset($records['location_time_start'])) ? $records['location_time_start'] : '')); ?>
                              
                <input type="text" readonly="readonly" class="form-control" name="location_time_start" id="location_time_start" style="width:175px;" value="<?php echo (isset($records['location_time_start'])) ? $records['location_time_start'] : date('d-m-Y H:i'); ?>" />                               
                            <!-- </center></td>
                            <td rowspan=3 class=xl113 width=100 style='border-bottom:.5pt solid black;
  border-top:none;width:65pt' valign="top"><center> -->
                              <br/>
                              <!-- <b>TO</b> <br />-->
                              
                              <br />
                              <?php //echo generate_time(array('width'=>'75px','name'=>'location_time_to','selected_value'=>(isset($records['location_time_to'])) ? $records['location_time_to'] : '')); ?>
                              <input type="text" readonly="readonly" name="location_time_to" id="location_time_to" class="form-control valid" style="width:175px;" value="<?php echo (isset($records['location_time_to'])) ? $records['location_time_to'] : date('d-m-Y H:i',strtotime("+12 hours")); ?>" >
                            </center>  <br/>
                              </td>
                            <?php
              $haz_options=array(); $pre_options=array();
              if(isset($hazards_options->a))
              {
                $haz_options=explode('|',rtrim($hazards_options->a,'|')); 
              }
              
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->a) && $hazards->a=='Yes')
              $pre_text_disabled='';
            
                            ?>
                            <td colspan=4 class=xl198 style='border-right:.5pt solid black;
  width:245pt'>a) <input type="checkbox" name="hazards_options[a]" data-attr="a" <?php if(in_array('Platform',$haz_options)) { ?> checked="checked" <?php } ?> value="Platform" class="radio_button hazards_options" id="No permanent Platform"/> <label for="No permanent Platform">No permanent Platform</label> <input  data-attr="a" type="checkbox" name="hazards_options[a]" class="radio_button hazards_options" value="Handrails" id="Handrails" <?php if(in_array('Handrails',$haz_options)) { ?>  checked="checked" <?php } ?> /><label for="Handrails">Handrails</label> <input  data-attr="a" type="checkbox" <?php if(in_array('Stairs',$haz_options)) { ?> checked="checked" <?php } ?> value="Stairs" name="hazards_options[a]" class="hazards_options radio_button" id="Stairs"/> <label for="Stairs">Stairs</label></td>
                            <td class=xl87 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'><input name="hazards[a]" data-attr="a" data-checkbox='true' type="radio" <?php if(isset($hazards->a) && $hazards->a=='Yes') { ?> checked="checked" <?php } ?> class="radio_button hazards hazard_option" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[a]" class="radio_button hazards hazard_option" value="No" data-attr="a" data-checkbox='true' <?php if(isset($hazards->a) && $hazards->a=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</td>
                            <td colspan=6 class=xl198 style='border-right:.5pt solid black;
  border-left:none;width:247pt'>a) Standard &amp; certified Scaffold provided <br />
                <input type="text" class="form-control" name="precautions_text[a]" id="precautions_text[a]" value="<?php echo (isset($precautions_text->a)) ? $precautions_text->a : ''; ?>" <?php echo $pre_text_disabled; ?> />                               
  </td>
                            <td class=xl74 style='border-top:none;border-left:none;width:89pt'><center>
                              <input data-attr="a" name="precautions[a]"  <?php if(isset($precautions->a) && $precautions->a=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="a" type="radio" <?php if(isset($precautions->a) && $precautions->a=='N/A') { ?> checked="checked" <?php } ?> name="precautions[a]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <?php
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->b) && $hazards->b=='Yes')
              $pre_text_disabled='';
                    ?>
                          <tr height=23 style='mso-height-source:userset;height:17.25pt'>
                            <td colspan=4 height=117 class=xl115 style='height:17.25pt;
  width:245pt'>b) Un Safe Access to work area</td>
                            <td class=xl87 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'><input data-attr="b" name="hazards[b]" value="Yes" <?php if(isset($hazards->b) && $hazards->b=='Yes') { ?> checked="checked" <?php } ?> type="radio" class="radio_button hazards" />
                              Y&nbsp;
                              <input data-attr="b" type="radio" <?php if(isset($hazards->b) && $hazards->b=='No') { ?> checked="checked" <?php } ?> name="hazards[b]" class="radio_button hazards"  value="No"/>
                              N&nbsp;</td>
                            <td colspan=6 class=xl115 style='border-left:none;width:247pt'>b)
                              Suitable Access Provided.<br />
                              <input type="text" class="form-control" name="precautions_text[b]" id="precautions_text[b]" value="<?php echo (isset($precautions_text->b)) ? $precautions_text->b : ''; ?>" <?php echo $pre_text_disabled; ?> /></td>
                            <td class=xl74 style='border-top:none;border-left:none;width:89pt'><center>
                              <input data-attr="b" name="precautions[b]" <?php if(isset($precautions->b) && $precautions->b=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="b" type="radio" name="precautions[b]" <?php if(isset($precautions->b) && $precautions->b=='N/A') { ?> checked="checked" <?php } ?> value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=45 style='mso-height-source:userset;height:33.75pt'>
                            <td colspan=4 height=117 class=xl115 style='height:33.75pt;
  width:245pt'>c) Falling of material</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'><input data-attr="c"   name="hazards[c]" <?php if(isset($hazards->c) && $hazards->c=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button hazards" />
                              Y&nbsp;
                              <input data-attr="c"  type="radio" <?php if(isset($hazards->c) && $hazards->c=='No') { ?> checked="checked" <?php } ?> value="No" name="hazards[c]" class="radio_button hazards" />
                              N&nbsp;</td>
                            <?php
              if(isset($precautions_options->c))
              {
                $pre_options=explode('|',rtrim($precautions_options->c,'|')); 
              }
              
              $pre_c=(isset($precautions->c)) ? $precautions->c : '';

              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->c) && $hazards->c=='Yes')
              $pre_text_disabled='';              
                            ?>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>c)
                              <input type="checkbox" name="precautions_options[c]" id="Loose materials removed & barricade tape" data-attr="c" <?php if(in_array('Loose materials removed & barricade tape',$pre_options)) { ?> checked="checked" <?php } if($pre_c=='N/A') { ?> disabled="disabled" <?php } ?> value="Loose materials removed &amp; barricade tape" class="radio_button precautions_options" /> <label for="Loose materials removed & barricade tape">Loose materials removed &amp; barricade tape</label> <input type="checkbox" name="precautions_options[c]" data-attr="c" <?php if(in_array('Signs provided',$pre_options)) { ?> checked="checked" <?php } if($pre_c=='N/A') { ?> disabled="disabled" <?php } ?>  value="Signs provided" class="radio_button precautions_options" id="Signs provided"/> <label for="Signs provided">Signs provided</label><br /><input type="text" class="form-control" name="precautions_text[c]" id="precautions_text[c]" value="<?php echo (isset($precautions_text->c)) ? $precautions_text->c : ''; ?>" <?php echo $pre_text_disabled; ?>/></td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="c" type="radio" <?php if($pre_c=='Yes') { ?> checked="checked" <?php } ?> name="precautions[c]" data-checkbox="yes" value="Yes" class="radio_button precautions precaution_option"/>
                              Y&nbsp;
                              <input data-attr="c" data-checkbox="yes" <?php if($pre_c=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[c]" value="N/A" class="radio_button precautions precaution_option" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=50 style='mso-height-source:userset;height:37.5pt'>
                            <td colspan=4 height=50 class=xl117 style='height:47.5pt;
  width:300pt'><b>Equipment name:</b>&nbsp;
                              <input type="text" value="<?php echo (isset($records['equipment_name'])) ? $records['equipment_name'] : ''; ?>" class="form-control" name="equipment_name" id="equipment_name" style="width:400px;" /></td>
                              
                            <?php
              if(isset($hazards_options->d))
              {
                $haz_options=explode('|',rtrim($hazards_options->d,'|')); 
              }
              
              $jobs_isoloations_ids=array();
              
              $eip_disabled='';
              
              if($isoloation_permit_no!='')
              {
                if($isoloation_permit_no->num_rows()>0)
                {
                  $fets_permits=$isoloation_permit_no->result_array();
                    
                  $jobs_isoloations_ids=array_column($fets_permits,'jobs_isoloations_id');
                  
                  if($eips->num_rows()>0)
                  {
                      $fet_eips=$eips->result_array();
                      
                      foreach($fet_eips as $fet_eip)
                      {
                        $eip_id=$fet_eip['id'];
                        
                        if(array_search($eip_id,$jobs_isoloations_ids)!==FALSE)
                        $eip_disabled='disabled=disabled';      
                      }
                  }
                }
              }
              
              
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->d) && $hazards->d=='Yes')
              $pre_text_disabled='';              
              
                            ?>
                              
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  width:245pt'>d) <input type="checkbox" name="hazards_options[d]" data-checkbox='true' data-attr="d" <?php if(in_array('Electrical Lines',$haz_options)) { ?> checked="checked" <?php } ?> value="Electrical Lines" class="radio_button hazards_options" <?php echo $eip_disabled; ?> id="Over Head Electrical Lines"/> <label for="Over Head Electrical Lines">Over Head Electrical Lines</label> <input <?php echo $eip_disabled; ?> type="checkbox" data-checkbox='true' name="hazards_options[d]" data-attr="d" <?php if(in_array('Electric shock to personnel',$haz_options)) { ?> checked="checked" <?php } ?> value="Electric shock to personnel" class="radio_button hazards_options" id="Electric shock to personnel"/> <label for="Electric shock to personnel">Electric shock to personnel</label></td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'><input type="radio"  name="hazards[d]" class="radio_button hazards hazard_option" data-checkbox="true" data-attr="d" value="Yes" <?php if(isset($hazards->d) && $hazards->d=='Yes') { ?> checked="checked" <?php } ?> <?php echo $eip_disabled; ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($hazards->d) && $hazards->d=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards hazard_option"  name="hazards[d]" data-attr="d" value="No" data-checkbox="true" <?php echo $eip_disabled; ?>/>
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:247pt'>d) Isolation of power supply<br />
  <input type="text" class="form-control" name="precautions_text[d]" id="precautions_text[d]" value="<?php echo (isset($precautions_text->d)) ? $precautions_text->d : ''; ?>" <?php echo $pre_text_disabled; ?>/></td>
                            <td class=xl75 style='border-top:none;border-left:none;width:89pt;'><center>
                              <input data-attr="d" type="radio" <?php if(isset($precautions->d) && $precautions->d=='Yes') { ?> checked="checked" <?php } ?> name="precautions[d]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="d" <?php if(isset($precautions->d) && $precautions->d=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[d]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=70 style='mso-height-source:userset;height:52.5pt'>
                            <td colspan=4 height=70 class=xl120 style='height:52.5pt;
  width:300pt'><b>Nature of Job:</b>&nbsp;
                            <?php
              if(isset($hazards_options->e))
              {
                $haz_options=explode('|',rtrim($hazards_options->e,'|')); 
              }

            

                            ?>
  
                              <input type="text"  value="<?php echo (isset($records['job_name'])) ? $records['job_name'] : ''; ?>" name="job_name" id="job_name" class="form-control" style="width:400px;" /></td>
                            <td colspan=4 class=xl115 style='width:245pt'>e) Failure of
                              <input type="checkbox" data-checkbox="true" name="hazards_options[e]" data-attr="e" <?php if(in_array('Scaffolding',$haz_options)) { ?> checked="checked" <?php } ?> value="Scaffolding" class="radio_get_max_permit_idbutton hazards_options" id="Scaffolding"/> <label for="Scaffolding">Scaffolding</label> <input data-checkbox="true" type="checkbox" name="hazards_options[e]" data-attr="e" <?php if(in_array('Ladders',$haz_options)) { ?> checked="checked" <?php } ?> value="Ladders" class="radio_button hazards_options" id="Ladders"/> <label for="Ladders">Ladders</label> <input data-checkbox="true" type="checkbox" name="hazards_options[e]" data-attr="e" <?php if(in_array('Crane',$haz_options)) { ?> checked="checked" <?php } ?> value="Crane" class="radio_button hazards_options" id="Crane"/> <label for="Crane">Crane</label> <input data-checkbox="true" type="checkbox" name="hazards_options[e]" data-attr="e" <?php if(in_array('Other lifting equipment',$haz_options)) { ?> checked="checked" <?php } ?> value="Other lifting equipment" class="radio_button hazards_options" id="Other lifting equipment"/> <label for="Other lifting equipment">Other lifting equipment</label> </td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'><input data-attr="e" type="radio" class="radio_button hazards hazard_option" data-checkbox='yes' value="Yes" <?php if(isset($hazards->e) && $hazards->e=='Yes') { ?> checked="checked" <?php } ?>  name="hazards[e]" />
                              Y&nbsp;
                              <input data-attr="e" type="radio"  name="hazards[e]" data-checkbox='yes' <?php if(isset($hazards->e) && $hazards->e=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards hazard_option" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>
                            <?php
              if(isset($precautions_options->e))
              {
                $pre_options=explode('|',rtrim($precautions_options->e,'|')); 
              }
              
              $pre_e=(isset($precautions->e)) ? $precautions->e : '';

                $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->e) && $hazards->e=='Yes')
              $pre_text_disabled='';              

                            ?>
                            e)
                             <input type="checkbox" name="precautions_options[e]" id="Certification of Scaffolds" data-attr="e" 
               <?php if(in_array('Certification of Scaffolds',$pre_options)) { ?> checked="checked" <?php } if($pre_e=='N/A') { ?> disabled="disabled" <?php } ?> value="Certification of Scaffolds" class="radio_button precautions_options" /> <label for="Certification of Scaffolds">Certification of Scaffolds</label> <input type="checkbox" name="precautions_options[e]" data-attr="e" <?php if(in_array('Cranes',$pre_options)) { ?> checked="checked" <?php } if($pre_e=='N/A') { ?> disabled="disabled" <?php } ?> value="Cranes" class="radio_button precautions_options" id="Cranes"/> <label for="Cranes">Cranes</label> <input type="checkbox" name="precautions_options[e]" data-attr="e" <?php if(in_array('lifting eqpt. & tackles ensured & visual inspection done',$pre_options)) { ?> checked="checked" <?php } if($pre_e=='N/A') { ?> disabled="disabled" <?php } ?> value="lifting eqpt. &amp; tackles ensured &amp; visual inspection done" id="lifting eqpt. &amp; tackles ensured &amp; visual inspection done" class="radio_button precautions_options" /> <label for="lifting eqpt. &amp; tackles ensured &amp; visual inspection done">lifting eqpt. &amp; tackles ensured &amp; visual inspection done</label>&nbsp;<input data-checkbox="true" type="checkbox" name="precautions_options[e]" data-attr="e" <?php if(in_array('Certified ladder',$pre_options)) { ?> checked="checked" <?php } ?> value="Certified ladder" class="radio_button precautions_options" id="Certified ladder"/> <label for="Certified ladder">Certified ladder</label><br />
                             <input type="text" class="form-control" name="precautions_text[e]" id="precautions_text[e]" value="<?php echo (isset($precautions_text->e)) ? $precautions_text->e : ''; ?>" <?php echo $pre_text_disabled; ?> /></td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-checkbox="yes" data-attr="e" type="radio" <?php if($pre_e=='Yes') { ?> checked="checked" <?php } ?> name="precautions[e]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-checkbox="yes" data-attr="e" <?php if($pre_e=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[e]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=73 style='mso-height-source:userset;height:54.75pt'>
                            <td colspan=2  height=84 class=xl139 valign="top" style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'><b>Name of the Contractor:</b>&nbsp;
                              <select class="form-control contractors" data-show="other_contractors" name="contractor_id" id="contractor_id" style="width:200px;">
                                <option value="">- - Select Contractor - - </option>
                                <?php   
                                  $zone_name='';
                                  $select_contractor_id=(isset($records['contractor_id'])) ? $records['contractor_id'] : '';

                                        foreach($contractors as $list){
                      
                                ?>
                                <option value="<?php echo $list['id'];?>" <?php if($select_contractor_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php } ?>
                                  <option value="others" <?php if($select_contractor_id=='others') { ?> selected="selected" <?php } ?>>Others</option>
                              </select> <br />
                              <?php $other_contractors=(isset($records['other_contractors'])) ? $records['other_contractors'] : ''; ?>
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="other_contractors" id="other_contractors" class="form-control" style="width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  /></td>
                              
                              </td>
                            <td colspan=2 valign="top"  class=xl139 style='border-right:1.0pt solid black; border-bottom:1.0pt solid black;width:130pt'><b>No of Persons involved</b>&nbsp;
                              <input type="text"  value="<?php echo (isset($records['contractors_involved'])) ? $records['contractors_involved'] : ''; ?>" name="contractors_involved" id="contractors_involved" class="form-control numinput" style="width:130px;" /></td>
                            <td colspan=4 class=xl115 style='width:245pt'>f) Fall of person
                              from -height</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'><input data-attr="f" type="radio" class="radio_button hazards"  name="hazards[f]" data-checkbox='true' value="Yes" <?php if(isset($hazards->f) && $hazards->f=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="f"  name="hazards[f]" type="radio" <?php if(isset($hazards->f) && $hazards->f=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" data-checkbox='true' />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>
                            
                            <?php
              if(isset($precautions_options->f))
              {
                $pre_options=explode('|',rtrim($precautions_options->f,'|')); 
              }
              
              $pre_f=(isset($precautions->f)) ? $precautions->f : '';

              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->f) && $hazards->f=='Yes')
              $pre_text_disabled='';              

                            ?>
                            
                            f)
                              <input type="checkbox" name="precautions_options[f]" data-attr="f" 
                <?php if(in_array('Use of Full Body Harness',$pre_options)) { ?> checked="checked" <?php }  if($pre_f=='N/A') { ?> disabled="disabled" <?php } ?> value="Use of Full Body Harness" class="radio_button precautions_options" id="Use of Full Body Harness"/> <label for="Use of Full Body Harness">Use of Full Body Harness</label> <input type="checkbox" name="precautions_options[f]" data-attr="f" <?php if(in_array('Anchor points',$pre_options)) { ?> checked="checked" <?php } if($pre_f=='N/A') { ?> disabled="disabled" <?php } ?> value="Anchor points" class="radio_button precautions_options" id="Anchor points"/> <label for="Anchor points">Anchor points</label> <input type="checkbox" name="precautions_options[f]" data-attr="f" <?php if(in_array('Fall arrestors',$pre_options)) { ?> checked="checked" <?php } if($pre_f=='N/A') { ?> disabled="disabled" <?php } ?> value="Fall arrestors" class="radio_button precautions_options" id="Fall arrestors"/> <label for="Fall arrestors">Fall arrestors</label> <input type="checkbox" name="precautions_options[f]" data-attr="f" <?php if(in_array('Safety Nets',$pre_options)) { ?> checked="checked" <?php } if($pre_f=='N/A') { ?> disabled="disabled" <?php } ?> value="Safety Nets" class="radio_button precautions_options" id="Safety Nets"/> <label for="Safety Nets">Safety Nets</label> 
                              <input type="checkbox" name="precautions_options[f]" data-attr="f" <?php if(in_array('Life lines',$pre_options)) { ?> checked="checked" <?php } if($pre_f=='N/A') { ?> disabled="disabled" <?php } ?> value="Life lines" class="radio_button precautions_options" id="Life lines"/> <label for="Life lines">Life lines</label> <input type="checkbox" name="precautions_options[f]" data-attr="f" <?php if(in_array('Vertigo Test Certificate',$pre_options)) { ?> checked="checked" <?php } if($pre_f=='N/A') { ?> disabled="disabled" <?php } ?> value="Vertigo Test Certificate" class="radio_button precautions_options" id="Vertigo Test Certificate"/> <label for="Vertigo Test Certificate">Vertigo Test Certificate
                              ensured as required</label><br />
                               <input type="text" class="form-control" name="precautions_text[f]" id="precautions_text[f]" value="<?php echo (isset($precautions_text->f)) ? $precautions_text->f : ''; ?>" <?php echo $pre_text_disabled; ?>/></td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-checkbox="yes" data-attr="f" type="radio" <?php if($pre_f=='Yes') { ?> checked="checked" <?php } ?> name="precautions[f]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-checkbox="yes" data-attr="f" <?php if($pre_f=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[f]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <?php
  
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

              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->g) && $hazards->g=='Yes')
              $pre_text_disabled='';              


 ?>
 
 <a class="thickbox" href="<?php echo base_url(); ?>jobs/ajax_show_energy_info/?TB_iframe=true&keepThis=true&width=1050" id="energy_form" title=" Energy Isolation Permit Form" style="visibility:hidden;">Thickbox</a>
                          <tr height=61 style='mso-height-source:userset;height:45.75pt'>
                            <td colspan=4 height=61 class=xl136 style='border-right:1.0pt solid black;
  height:45.75pt;width:300pt'><b>Is EIP obtained:</b>
                              <input type="radio" name="is_isoloation_permit" class="radio_button on_off" data-relate='' <?php echo $yes_active; ?> value="Yes"/>
                              Yes
                              &nbsp;
                              <input type="radio" name="is_isoloation_permit" class="radio_button on_off" data-relate='' <?php echo $yes_existing_active; ?> value="yes_existing"/>
                              Yes & Existing
                              &nbsp;
                              <input name="is_isoloation_permit" <?php echo $no_active; ?> type="radio" value="Existing" class="radio_button on_off" data-relate='isoloation'/>
                              Existing&nbsp;
                              <input name="is_isoloation_permit" value="N/A" <?php echo $na_active; ?> type="radio" class="radio_button on_off" data-relate='isoloation' />
                              N/A</td>
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:245pt'>g)Liquid or gas under pressure</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'><input data-attr="g" type="radio" class="radio_button hazards"  name="hazards[g]" value="Yes" <?php if(isset($hazards->g) && $hazards->g=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="g"  name="hazards[g]" type="radio" <?php if(isset($hazards->g) && $hazards->g=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'><span
  style='mso-spacerun:yes'> </span>g)After energy isolation, equipment/pipe
                              line fully drained &amp; depressurised/ cleaning of area done.<br />
                               <input type="text" class="form-control" name="precautions_text[g]" id="precautions_text[g]" value="<?php echo (isset($precautions_text->g)) ? $precautions_text->g : ''; ?>" <?php echo $pre_text_disabled; ?> /></td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="g" type="radio" <?php if(isset($precautions->g) && $precautions->g=='Yes') { ?> checked="checked" <?php } ?> name="precautions[g]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="g" <?php if(isset($precautions->g) && $precautions->g=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[g]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=40 style='mso-height-source:userset;height:50.0pt'>
                            <td colspan=4 height=40 class=xl128 style='border-right:1.0pt solid black;
  height:30.0pt;width:300pt'><b>If yes Energy Isolation Permit No:</b> &nbsp;
                            <?php
              if(isset($hazards_options->h))
              {
                $haz_options=explode('|',rtrim($hazards_options->h,'|')); 
              }
              
              #print_r($jobs_isoloations_ids);
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->h) && $hazards->h=='Yes')
              $pre_text_disabled='';              

                            ?>
  
                              <!--<input type="text" readonly="readonly" class="form-control isoloation" name="isoloation_permit_no" id="isoloation_permit_no" <?php if($yes_active!='') { ?> value="<?php echo (isset($records['isoloation_permit_no'])) ? $records['isoloation_permit_no'] : ''; ?>" <?php } else { ?> disabled="disabled" <?php } ?> style="width:300px;" />--><br />
                              <select class="form-control selected_eip select2-offscreen" multiple name="isoloation_permit_no" id="isoloation_permit_no" 
                              <?php if($no_active=='') { ?> disabled="disabled" <?php } ?>>
                              <?php
                                if($record_id!='')
                                {
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
                                        
                                          if(in_array($eip_status,array(STATUS_OPENED)))
                                          $eip_opened++;
                                          }
                                          else
                                          $chk='';
                                        
                                    ?>
                                                    <option value="<?php echo $eip_id; ?>" <?php echo $chk; ?>><?php echo $eip_section.'(#'.$eip_id.')'; ?></option>
                                                   <?php
                                      }
                                    }
                                 }   
                                  ?>
                              </select>   
                              
                              </td>
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:245pt'>h) <input type="checkbox" name="hazards_options[h]" data-attr="h" 
  <?php if(in_array('Danger due to naked flames',$haz_options)) { ?> checked="checked" <?php } ?> value="Danger due to naked flames" class="radio_button hazards_options" id="Danger due to naked flames"/> <label for="Danger due to naked flames">Danger due to naked flames</label> <input type="checkbox" name="hazards_options[h]" data-attr="h" 
  <?php if(in_array('Ignition of Flammables',$haz_options)) { ?> checked="checked" <?php } ?> value="Ignition of Flammables" class="radio_button hazards_options" id="Ignition of Flammables"/> <label for="Ignition of Flammables">Ignition of Flammables</label></td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'><input data-attr="h" type="radio" class="radio_button hazards hazard_option"  name="hazards[h]" data-checkbox="true" value="Yes" <?php if(isset($hazards->h) && $hazards->h=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="h"  name="hazards[h]" type="radio" <?php if(isset($hazards->h) && $hazards->h=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards hazard_option" value="No" data-checkbox="true" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>h)
                              Space free o<font class="font12">f Flammables<span
  style='mso-spacerun:yes'> </span></font><br />
                               <input type="text" class="form-control" name="precautions_text[h]" id="precautions_text[h]" value="<?php echo (isset($precautions_text->h)) ? $precautions_text->h : ''; ?>" <?php echo $pre_text_disabled; ?>/></td>
                            <td class=xl75 style='border-top:none;border-left:none;width:89pt'><center>
                              <input data-attr="h" type="radio" <?php if(isset($precautions->h) && $precautions->h=='Yes') { ?> checked="checked" <?php } ?> name="precautions[h]"  value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="h" <?php if(isset($precautions->h) && $precautions->h=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[h]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=42 style='mso-height-source:userset;height:31.5pt'>
                            <td colspan=2 rowspan=2 height=84 class=xl139 valign="top" style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'><b>Is scaffolding TAG certification obtained</b>
                              <?php
  $yes_active='';
  $no_active=$na_active='';
  if(isset($records))
  {
    $is_scaffolding_certification=(isset($records['is_scaffolding_certification'])) ? $records['is_scaffolding_certification'] : '';
    
    if($is_scaffolding_certification=='No') 
    $no_active='checked';
    else if($is_scaffolding_certification=='N/A')
    $na_active='checked';
    else
    $yes_active='checked';
  }
  else
  $no_active='checked';
  
  ?>
                              <br />
                              <input type="radio" class="radio_button on_off" data-relate='scaffolding' name="is_scaffolding_certification"  <?php echo $yes_active; ?> value="Yes"/>
                              Yes&nbsp;
                              <input type="radio" <?php echo $no_active; ?> class="radio_button on_off" data-relate='scaffolding' name="is_scaffolding_certification" value="No"/>
                              No&nbsp;
                               </td>
                            <td colspan=2 valign="top" rowspan=2 class=xl139 style='border-right:1.0pt solid black; border-bottom:1.0pt solid black;width:130pt'><b>If Yes Scaffold</b><br />
                              Tag No:-<br />
                              <input type="text" class="form-control scaffolding" style="width:110px;" <?php if($yes_active!='') { ?>  value="<?php echo (isset($records['scaffolding_certification_no'])) ? $records['scaffolding_certification_no'] : ''; ?>" <?php } else { ?> disabled="disabled" <?php } ?> name="scaffolding_certification_no" id="scaffolding_certification_no" />
                              <br />
                              Issued by :<br />
                              <input type="text" class="form-control scaffolding" style="width:110px;" <?php if($yes_active!='') { ?>  value="<?php echo (isset($records['scaffolding_certification_issed_by'])) ? $records['scaffolding_certification_issed_by'] : ''; ?>" <?php } else { ?> disabled="disabled" <?php } ?>  name="scaffolding_certification_issed_by" id="scaffolding_certification_issed_by"/>
                              <br /></td>
                              
                            <?php
              if(isset($hazards_options->i))
              {
                $haz_options=explode('|',rtrim($hazards_options->i,'|')); 
              }

              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->i) && $hazards->i=='Yes')
              $pre_text_disabled='';              

                            ?>
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:245pt'>i) <?php /* <input type="checkbox" name="hazards_options[i]" data-attr="i" <?php if(in_array('Defective Welding',$haz_options)) { ?> checked="checked" <?php } ?> value="Defective Welding" class="radio_button hazards_options" /> Defective Welding <input type="checkbox" name="hazards_options[i]" data-attr="i" <?php if(in_array('Gas cutting sets',$haz_options)) { ?> checked="checked" <?php } ?> value="Gas cutting sets" class="radio_button hazards_options" /> Gas cutting sets<span
  style='mso-spacerun:yes'> </span> */ ?>Using Any Welding/Gas Cutting Sets</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'><input data-attr="i" type="radio" class="radio_button hazards hazard_option"  name="hazards[i]" value="Yes" <?php if(isset($hazards->i) && $hazards->i=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input  name="hazards[i]" data-attr="i" type="radio" <?php if(isset($hazards->i) && $hazards->i=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards hazard_option"  value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>i) <font
  class="font14">Welding, gas cutting sets checked </font><font class="font12">and
                              Rectified<br /> <input type="text" class="form-control" name="precautions_text[i]" id="precautions_text[i]" value="<?php echo (isset($precautions_text->i)) ? $precautions_text->i : ''; ?>" <?php echo $pre_text_disabled; ?>/></font></td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input type="radio" data-attr="i" <?php if(isset($precautions->i) && $precautions->i=='Yes') { ?> checked="checked" <?php } ?> name="precautions[i]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="i" <?php if(isset($precautions->i) && $precautions->i=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[i]"  value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=42 style='mso-height-source:userset;height:31.5pt'>
                            <td colspan=4 height=84 class=xl119 style='border-right:.5pt solid black;
  height:31.5pt;border-left:none;width:245pt'>j)<span
  style='mso-spacerun:yes'>  </span>Fire during work activity</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'>
                            
                            
                            <?php
              if(isset($precautions_options->j))
              {
                $pre_options=explode('|',rtrim($precautions_options->j,'|')); 
              }
              
              $pre_j=(isset($precautions->j)) ? $precautions->j : '';

              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->j) && $hazards->j=='Yes')
              $pre_text_disabled='';              

                            ?>
                            
                            
                            <input data-attr="j" data-checkbox='true' type="radio" class="radio_button hazards"  name="hazards[j]" value="Yes" <?php if(isset($hazards->j) && $hazards->j=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="j" data-checkbox='true'  name="hazards[j]" type="radio" <?php if(isset($hazards->j) && $hazards->j=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>j) 
                            
                            <input type="checkbox" name="precautions_options[j]" data-attr="j" <?php if(in_array('Adequate protection',$pre_options)) { ?> checked="checked" <?php } if($pre_j=='N/A') { ?> disabled="disabled" <?php } ?> value="Adequate protection" class="radio_button precautions_options" id="Adequate protection"/> <label for="Adequate protection">Adequate protection</label> <input type="checkbox" name="precautions_options[j]" data-attr="j" <?php if(in_array('Fire extinguisher and Fire blanket available',$pre_options)) { ?> checked="checked" <?php } if($pre_j=='N/A') { ?> disabled="disabled" <?php } ?> value="Fire extinguisher and Fire blanket available" class="radio_button precautions_options" id="Fire extinguisher and Fire blanket available"/> <label for="Fire extinguisher and Fire blanket available">Fire extinguisher and Fire blanket available</label><br /> <input type="text" class="form-control" name="precautions_text[j]" id="precautions_text[j]" value="<?php echo (isset($precautions_text->j)) ? $precautions_text->j : ''; ?>" <?php echo $pre_text_disabled; ?>/></td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="j" type="radio" <?php if($pre_j=='Yes') { ?> checked="checked" <?php } ?> name="precautions[j]" data-checkbox="yes" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="j" data-checkbox="yes" <?php if($pre_j=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[j]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=44 style='mso-height-source:userset;height:33.0pt'>
                            <td colspan=4 rowspan=2 height=77 class=xl151 style='height:57.75pt;
  width:300pt'> 
  
  <?php
   $other_inputs=(isset($records['other_inputs'])) ? explode(',',rtrim($records['other_inputs'],',')) : array(); $display='none;';
  ?>   
  
  <input type="checkbox" <?php if(in_array('SOP',$other_inputs)) { ?> checked="checked" <?php } ?> name="other_inputs[]" class="other_inputs" value="SOP"  /> SOP <br /> <input class="other_inputs"  name="other_inputs[]" <?php if(in_array('Work instructions clearly explained to the all the members',$other_inputs)) { ?> checked="checked" <?php } ?> value="Work instructions clearly explained to the all the members"  type="checkbox" /> Work instructions clearly explained to the all the members in the working Group <br /><input type="checkbox" checked="checked"   name="other_inputs[]" disabled="disabled" class="other_inputs peptalk" value="Peptalk"  /> Peptalk  
      <span id="peptalk" >
        <input type="text" class="form-control peptalk_text" name="other_inputs_text" value="<?php echo (isset($records['other_inputs_text'])) ? $records['other_inputs_text'] : ''; ?>" style="margin-bottom: 3px;"/>
      </span>

    </td>
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  width:245pt'>k) 
  
                            <?php
              if(isset($hazards_options->k))
              {
                $haz_options=explode('|',rtrim($hazards_options->k,'|')); 
              }

              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->k) && $hazards->k=='Yes')
              $pre_text_disabled='';              

                            ?>
  
  <input type="checkbox" name="hazards_options[k]" data-attr="k" <?php if(in_array('Machinery',$haz_options)) { ?> checked="checked" <?php } ?> value="Machinery" class="radio_button hazards_options" <?php echo $eip_disabled; ?> id="Moving Machinery"/> <label for="Moving Machinery">Moving Machinery</label> <input type="checkbox" name="hazards_options[k]" data-attr="k" <?php if(in_array('Electric shock',$haz_options)) { ?> checked="checked" <?php } ?> value="Electric shock" class="radio_button hazards_options" <?php echo $eip_disabled; ?> id="Electric shock"/> <label for="Electric shock">Electric shock&nbsp;</label><font
  class="font20"><input type="checkbox" name="hazards_options[k]" data-other="hazards_options_k" data-attr="k" 
  <?php if(in_array('Other Energy',$haz_options)) { ?> checked="checked" <?php } ?> value="Other Energy" class="radio_button hazards_options" <?php echo $eip_disabled; ?> id="Other Energy"/> <label for="Other Energy">Other Energy</label></font>
  
          <span id="hazards_options_k" style="display:none;"><input type="text" name="hazards_other_options[k]" id="hazards_other_options[k]" class="form-control" /></span>
  </td>
                            <td class=xl70 style="text-align:center;"><input data-attr="k" type="radio" class="radio_button hazards hazard_option" value="Yes" <?php if(isset($hazards->k) && $hazards->k=='Yes') { ?> checked="checked" <?php } ?> data-checkbox="true"  name="hazards[k]" <?php echo $eip_disabled; ?>/>
                              Y&nbsp;
                              <input type="radio" data-attr="k"  name="hazards[k]" <?php if(isset($hazards->k) && $hazards->k=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards hazard_option" value="No" data-checkbox="true" <?php echo $eip_disabled; ?>/>
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='width:247pt'>k) Hazardous Energy Isolation ensured
                <input type="text" class="form-control" name="precautions_text[k]" id="precautions_text[k]" value="<?php echo (isset($precautions_text->k)) ? $precautions_text->k : ''; ?>" <?php echo $pre_text_disabled; ?> />                               
                            </td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="k" type="radio" <?php if(isset($precautions->k) && $precautions->k=='Yes') { ?> checked="checked" <?php } ?> name="precautions[k]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="k" <?php if(isset($precautions->k) && $precautions->k=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[k]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <?php
                                        $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->l) && $hazards->l=='Yes')
              $pre_text_disabled='';              

              ?>
                          <tr height=33 style='mso-height-source:userset;height:24.75pt'>
                            <td colspan=4 height=77 class=xl194 style='border-right:.5pt solid black;
  height:24.75pt;width:245pt'>l) Poor ventilation</td>
                            <td class=xl95 width=108 style='border-left:none;width:55pt;text-align:center;'><input data-attr="l" type="radio"  name="hazards[l]" class="radio_button hazards" value="Yes" <?php if(isset($hazards->l) && $hazards->l=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="l"  name="hazards[l]" type="radio" <?php if(isset($hazards->l) && $hazards->l=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl195 style='width:247pt'>l) Proper ventilation
                              facilities provided<br /> <input type="text" class="form-control" name="precautions_text[l]" id="precautions_text[l]" value="<?php echo (isset($precautions_text->l)) ? $precautions_text->l : ''; ?>" <?php echo $pre_text_disabled; ?> /></td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="l" type="radio" <?php if(isset($precautions->l) && $precautions->l=='Yes') { ?> checked="checked" <?php } ?> name="precautions[l]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="l" <?php if(isset($precautions->l) && $precautions->l=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[l]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <?php
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->m) && $hazards->m=='Yes')
              $pre_text_disabled='';              
                        ?>
                            
                          <tr height=34 style='mso-height-source:userset;height:25.5pt'>
                            <td height=34 class=xl71 width=831 style='height:25.5pt;width:111pt'>&nbsp;</td>
                            <td colspan=3 class=xl70 style='mso-ignore:colspan'></td>
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  width:245pt'>m) Poor Illumination<span style='mso-spacerun:yes'> </span></td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'><input data-attr="m"  name="hazards[m]" type="radio" class="radio_button hazards" value="Yes" <?php if(isset($hazards->m) && $hazards->m=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="m" name="hazards[m]" type="radio" <?php if(isset($hazards->m) && $hazards->m=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>m)Adequate<span style='mso-spacerun:yes'>  </span>Illumination<br /> <input type="text" class="form-control" name="precautions_text[m]" id="precautions_text[m]" value="<?php echo (isset($precautions_text->m)) ? $precautions_text->m : ''; ?>" <?php echo $pre_text_disabled; ?>/></td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="m" type="radio" <?php if(isset($precautions->m) && $precautions->m=='Yes') { ?> checked="checked" <?php } ?> name="precautions[m]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="m" <?php if(isset($precautions->m) && $precautions->m=='N/A') { ?> checked="checked" <?php } ?> type="radio" name="precautions[m]" value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center></td>
                          </tr>
                          <tr height=52 style='mso-height-source:userset;height:39.0pt'>
                            <td height=52 class=xl71 width=831 style='height:39.0pt;width:111pt'>&nbsp;</td>
                            <td colspan=3 class=xl70 style='mso-ignore:colspan'></td>
                            <td colspan=4 class=xl115 style='width:245pt'>n) Emergency
                              preparedness of employees</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'>
                            <?php
              if(isset($precautions_options->n))
              {
                $pre_options=explode('|',rtrim($precautions_options->n,'|')); 
              }
              
              $pre_n=(isset($precautions->n)) ? $precautions->n : '';

               $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->n) && $hazards->n=='Yes')
              $pre_text_disabled='';     
                            ?>
                            
                            <input data-attr="n" type="radio" data-checkbox='true'  name="hazards[n]" class="radio_button hazards" value="Yes" checked="checked" disabled="disabled" />
                              Y&nbsp;
                              <input data-attr="n" type="radio"  name="hazards[n]" <?php if(isset($hazards->n) && $hazards->n=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" data-checkbox='true' value="No" disabled="disabled"/>
                              N&nbsp;</td>
                            <td colspan=6 class=xl115 style='border-left:none;width:247pt'>n) 
                            <input type="checkbox" name="precautions_options[n]" data-attr="n"  checked="checked" disabled="disabled"  value="Adequate Awareness of emergency procedures" class="radio_button precautions_options" /> Adequate Awareness of emergency procedures <input type="checkbox" name="precautions_options[n]" data-attr="n" checked="checked" disabled="disabled" value="Ensure for clear emergency exits" class="radio_button precautions_options" /> Ensure for clear emergency exits.<br /> <input type="text" class="form-control" name="precautions_text[n]" id="precautions_text[n]" value="<?php echo (isset($precautions_text->n)) ? $precautions_text->n : ''; ?>" /></td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt;text-align:center;'><input data-attr="n" type="radio" checked="checked" disabled="disabled" name="precautions[n]" data-checkbox="yes" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;<input data-checkbox="yes" data-attr="n" type="radio" name="precautions[n]" value="N/A" class="radio_button precautions" disabled="disabled" /> N/A</td>
                          </tr>
                          <tr height=21 style='height:15.75pt'>
                            <td colspan=4 height=21 class=xl131 style='height:15.75pt;
  width:300pt'>&nbsp;</td>
                            <td colspan=5 class=xl166 style='border-right:.5pt solid black;
  width:245pt'>o)Others <input type="text" name="hazards_other" id="hazards_other" class="form-control" width="100px" value="<?php echo (isset($records['hazards_other'])) ? $records['hazards_other'] : ''; ?>" /><br /></td>
                            <td colspan=7 class=xl166 style='border-left:none;width:247pt'>o)Others <center>
                              <input type="text" class="form-control" name="precautions_other" id="precautions_other" width="100px" value="<?php echo (isset($records['precautions_other'])) ? $records['precautions_other'] : ''; ?>" />
                            </center> <br /></td>
                          </tr>
                          <?php

                              $hot_works=array('a'=>'Workmen briefed on Fire fighting methods?','b'=>'No bulk storage facility of flammable or combustible material like gas, liquid coal, fine coal, oil etc within 10 m vicinity of hot work area?','c'=>'Obstruction placed to stop spark propagation?','d'=>'Compressed gas Cylinders are kept in upright position and latched?','e'=>'Checked condition of all tools & accessories for job, (ex regulator, hoses, cables, cutting torch, Weld M/c & earthing, flashback arrester, etc)?','f'=>'Flashback arrester fitted to regulator of Oxy – acetylene hoses at both ends','g'=>'Welding cable and earthing cable are crimped with proper size lugs','h'=>'Workmen are competent and equipped with appropriate PPE’s (i.e) including face shield / Welding goggles / Apron / Welders shoe / Leatherhand gloves','i'=>'Only industrial type electrical appliances are in use','j'=>'Hoses are free from damage and connected with hose clamp','k'=>'No cable joint within 1 Mtr from the holder / Grinding machine and completely insulated from Machine body','l'=>'Gas testing for presence of any flammable gases or vapor in the vicinity of work place done?','m'=>'Type of Fire Extinguisher - Water/Foam/C02/ABC/DCP');


                             if(isset($records))
                             $hot_work_checklists=json_decode($records['hot_work_checklists']);
                             else
                             $hot_work_checklists=array();

                             $checklist='';

                             if(!in_array('hot_work',$work_types))
                              $checklist='disabled=disabled';


                          ?>
                          <tr height=22 style='mso-height-source:userset;height:16.5pt'>
                              <td colspan=16>
                                  <table align="center" width="100%">
                                    <tr>
                                      <td width="50%">
                                          <table align="center" width="100%">
                                              <tr>
                                                <td colspan="2" align="center" style="padding-top:15px;border-right:.5pt solid black;border-left:none;"><b>HOT Work Check List</b></td>
                                              </tr>  
                                              <tr><td colspan="2" style="border-right:.5pt solid black;border-left:none;border-bottom:.5pt solid black;">&nbsp;</td></tr>

                                              <?php
                                              foreach($hot_works as $key => $works)
                                              {


                                              ?>
                                              <tr>
                                              <td style="border-right:.5pt solid black;border-left:none;height:45px;" width="700px"><?php echo $key.') '.$works; ?></td>
                                              <td style="border-right:.5pt solid black;border-left:none;" width="100px">
                                                <center>
                                                    <input data-attr="<?php echo $key; ?>" type="radio" <?php if(isset($hot_work_checklists->$key) && $hot_work_checklists->$key=='Yes') { ?> checked="checked" <?php } ?> name="hot_work_checklists[<?php echo $key; ?>]" value="Yes" class="radio_button hot_works" id="hot_work_checklist<?php echo $key; ?>" <?php echo $checklist; ?>/>
                                                    <label for="hot_work_checklist<?php echo $key; ?>">Y</label>&nbsp;
                                                    <input id="hot_work_no_checklist<?php echo $key; ?>" data-attr="<?php echo $key; ?>" type="radio" <?php if(isset($hot_work_checklists->$key) && $hot_work_checklists->$key=='NA') { ?> checked="checked" <?php } ?> name="hot_work_checklists[<?php echo $key; ?>]" value="NA" class="radio_button hot_works" <?php echo $checklist; ?>/><label for="hot_work_no_checklist<?php echo $key; ?>">NA</label>
                                                </center>
                                                </td>
                                               </tr>
                                               <?php
                                                }
                                              ?>
                                          </table>
                                      </td>
                                      <?php

                                      $height_works=array('a'=>'Engaged worker is having authorized height work access card','b'=>'Are all persons are instructed on hazards & precautions related to the work at height?','c'=>'All elevated working platforms, portable & fixed ladders, scaffolding condition, etc are checked?','d'=>'Crawling ladders provided for jobs on fragile roofs?','e'=>'Certified Full body double lanyard safety harness is used by all workmen engaged at height work','f'=>'Adequate arrangements (rigid support) for anchorage of safety harness provided?','g'=>'Certified Ladder has been provided and the distance between the ladder support and the base is 1:4','h'=>'Are barricades/safety cordon provided at the elevation to avoid fall of material?','i'=>'Is the work area clear of overhead electrical lines and other protruding material?','j'=>'Is the Lifeline (vertical or horizontal) arranged?','k'=>'Whether competent person certified the scaffolding and tag provided','l'=>'Proper guardrail and access to the scaffolding is provided');


                                     if(isset($records))
                                     $height_work_checklists=json_decode($records['height_work_checklists']);
                                     else
                                     $height_work_checklists=array();

                                     $checklist='';

                                     if(!in_array('height_work',$work_types))
                                      $checklist='disabled=disabled';

                                    ?>
                                      <td width="50%" valign="top">
                                          <table align="center" width="100%">
                                              <tr>
                                                <td colspan="2" align="center" style="padding-top:15px;"><b>Working At Height</b></td>
                                              </tr>  
                                              <tr><td colspan="2" style="border-bottom:.5pt solid black;">&nbsp;</td></tr>
                                             <?php
                                              foreach($height_works as $key => $works)
                                              {


                                              ?>
                                              <tr>
                                              <td style="border-right:.5pt solid black;border-left:none;height:45px;" width="700px"><?php echo $key.') '.$works; ?></td>
                                              <td style="border-left:none;" width="100px">
                                                <center>
                                                    <input data-attr="<?php echo $key; ?>" type="radio" <?php if(isset($height_work_checklists->$key) && $height_work_checklists->$key=='Yes') { ?> checked="checked" <?php } ?> name="height_work_checklists[<?php echo $key; ?>]" value="Yes" class="radio_button height_works" id="height_work_checklists<?php echo $key; ?>" <?php echo $checklist; ?>/>
                                                    <label for="height_work_checklists<?php echo $key; ?>">Y</label>&nbsp;
                                                    <input data-attr="<?php echo $key; ?>" type="radio" <?php if(isset($height_work_checklists->$key) && $height_work_checklists->$key=='NA') { ?> checked="checked" <?php } ?> name="height_work_checklists[<?php echo $key; ?>]" value="NA" class="radio_button height_works" id="height_work_no_checklists<?php echo $key; ?>" <?php echo $checklist; ?>/><label for="height_work_no_checklists<?php echo $key; ?>">NA</label>&nbsp;
                                                </center>
                                                </td>
                                               </tr>
                                               <?php
                                                }
                                              ?>
                                              <tr>
                                              <td style="border-right:.5pt solid black;border-left:none;height:45px;" width="700px">&nbsp;</td>
                                              <td style="border-left:none;" width="100px">
                                                &nbsp;
                                                </td>
                                               </tr>
                                          </table>
                                      </td>        
                                    </tr>  
                                  </table>  
                              </td>
                          </tr>     

                          <tr height=22 style='mso-height-source:userset;height:16.5pt'>
                            <td colspan=4 height=22 class=xl125 style='border-right:1.0pt solid black;
  height:16.5pt;width:235pt'><center>
                              <b>Required PPE</b>
                            </center></td>
                            <td colspan=5 rowspan=7 style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'><p><b>Authorisation & Acceptance: </b></p>
                              <p><b>Performing Authority: </b></p>
                              <p>I have had the contents of this permit explained to me and I shall work in accordance with the control measures identified </p>
                              <p>&nbsp;</p>
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
                                </span> <span style="float:right;">Sign/Date & Time: <br />
                                  <input type="text" style="width:150px;" value="<?php echo (isset($records['acceptance_performing_date'])) ? $records['acceptance_performing_date'] : ''; ?>" id="acceptance_performing_date" name="acceptance_performing_date" class="form-control" readonly="readonly" />
                                </span></p>
                              <br />
                              <br />
                              <br />
                              <br />
                              <p><b>Issuing Authority: </b></p>
                              <p>I have ensured that each of the identified control measures is suitable and sufficient. The content of this permit has been explained to the
                                holder and work may proceed.</p>
                              <p>&nbsp;</p>
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
                
                if($acceptance_issuing_approval=='No' && $user_id==$acceptance_issuing_id)
                $acceptance_issuing_date=date('d-m-Y H:i');
                
                if(!empty($acceptance_issuing_date))
                $acceptance_issuing_date=date('d-m-Y H:i',strtotime($acceptance_issuing_date));

                $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';

                 if($approval_status==10)
                $acceptance_issuing_date='';
                
                ?>
                                <span style="float:right;">Sign/Date & Time:
                                  <input value="<?php echo $acceptance_issuing_date; ?>" type="text" id="acceptance_issuing_date" style="width:150px;" name="acceptance_issuing_date" class="form-control" readonly="readonly" />
                                </span></p>
                              <br />
                              <br />
                              <br />
                              <br /></td>
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
                              <p>Work completed, all persons are withdrawn and material removed from the area.</p>
                              <p>&nbsp;</p>
                              <p><span style="float:left;">Name:<br />
                <?php 
                
                
                 $cancellation_performing_id=(isset($records['cancellation_performing_id'])) ? $records['cancellation_performing_id'] : '';
                 
                 
  /*  foreach($authorities as $fet)
    {
      $role=$fet['user_role'];
      
      $id=$fet['id'];
      
      $first_name=$fet['first_name'];
      
      $chk='';
      
      $flag=0;
  
            if($record_id!=''  && $cancellation_performing_id<=0)
          {
             if($id==$user_id)
             $flag=1;
             
             echo '<br /> Ins : '.$flag;
          }
          else if($cancellation_performing_id>0)
          $flag=1;
          
          echo '<br /> Flag : '.$id.' - '.$user_id.' - '.$flag;
    } */
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
                                </span> <span style="float:right;">Sign/Date: <br />
                                  <input type="text" value="<?php echo (isset($records['cancellation_performing_date'])) ? $records['cancellation_performing_date'] : ''; ?>" id="cancellation_performing_date" style="width:140px;"  name="cancellation_performing_date" class="form-control datepicker" />
                                </span></p>
                              <br />
                              <br />
                              <br />
                              <br />
                              <p><b>Issuing Authority: </b></p>
                              <p>I have inspected the work area and declare the work for which the permit was issued has been properly.</p>
                              <p>&nbsp;</p>
                              <br />
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
                
                #if($cancellation_issuing_approval=='No' && $user_id==$cancellation_issuing_id)
                if(in_array($approval_status,array(3,5)) && $user_id==$cancellation_issuing_id)
                $cancellation_issuing_date=date('d-m-Y H:i');
                else 
                $cancellation_issuing_date=(isset($records['cancellation_issuing_date'])) ? $records['cancellation_issuing_date'] : '';
                
                if(!empty($cancellation_issuing_date))
                $cancellation_issuing_date=date('d-m-Y H:i',strtotime($cancellation_issuing_date));
                ?>                
                                
                                
                                 <span style="float:right;">Sign/Date: <br />
                                  <input type="text" value="<?php echo $cancellation_issuing_date; ?>" id="cancellation_issuing_date" style="width:140px;" name="cancellation_issuing_date" class="form-control datepicker" />
                                </span></p>
                              <br />
                              <br /></td>
                          </tr>
                          <tr height=35 style='mso-height-source:userset;height:26.25pt'>
                            <td height=35 width=831 colspan="2" style='height:26.25pt;width:111pt' align=left
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
    width:111pt'><span style='mso-spacerun:yes'> </span>Safety shoes<span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" class="required_ppe"  checked="checked" disabled="disabled" value="Safety Shoes" />
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
                            <td height=38 width=831 colspan="2" style='height:28.5pt;width:111pt' align=left
  valign=top><table cellpadding=0 cellspacing=0>
                              <tr>
                                <td height=38 class=xl76 width=148 style='height:28.5pt;border-top:none;
    width:111pt'>Safety Helmet<span
    style='mso-spacerun:yes'><span class="float_right">
                                  <input type="checkbox" name="required_ppe[]"  checked="checked" disabled="disabled"    class="required_ppe" value="Safety Helmet" />
                                </span></span></td>
                              </tr>
                            </table></td>
                            <td colspan=2 height=38 style='border-right:1.0pt solid black;
  height:28.5pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=38 class=xl148 width=165 style='height:28.5pt;border-left:none;width:124pt'>Ear protection <span class="float_right">
                                    <input <?php if(in_array('Ear Protection',$required_ppe)) { ?> checked="checked" <?php } ?> type="checkbox" name="required_ppe[]"  class="required_ppe" value="Ear Protection" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=41 style='mso-height-source:userset;height:30.75pt'>
                            <td height=41 width=831 style='height:30.75pt;width:111pt' align=left
  valign=top colspan="2"><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=41 class=xl76 width=148 style='height:30.75pt;border-top:none;
    width:111pt'>Full body Harness<span style='mso-spacerun:yes'><span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" <?php if(in_array('Full body Harness',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Full body Harness" />
                                  </span></span></td>
                                </tr>
                              </table>
                            </span></td>
                            <td colspan=2 height=41 style='border-right:1.0pt solid black;
  height:30.75pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=41 class=xl121 width=165 style='
    height:30.75pt;border-left:none;width:124pt'>Welding shield <span class="float_right">
                                    <input name="required_ppe[]" <?php if(in_array('Welding sheid',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Welding sheid" type="checkbox" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=36 style='mso-height-source:userset;height:27.0pt'>
                            <td height=36 colspan="2" width=831 style='height:27.0pt;width:111pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=36 class=xl76 width=148 style='height:27.0pt;border-top:none;
    width:111pt'>Safety Net<span style='mso-spacerun:yes'><span class="float_right">
                                    <input value="Safety net" name="required_ppe[]" <?php if(in_array('Safety net',$required_ppe,true)) { ?> checked="checked" <?php } ?>    class="required_ppe" type="checkbox" />
                                  </span></span></td>
                                </tr>
                              </table>
                            </span></td>
                            <td colspan=2 height=36 style='border-right:1.0pt solid black;
  height:27.0pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=36 class=xl121 width=165 style='
    height:27.0pt;border-left:none;width:124pt'>Coverall Suit <span class="float_right">
                                    <input name="required_ppe[]" <?php if(in_array('Coverall Suit',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Coverall Suit" type="checkbox" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=47 style='mso-height-source:userset;height:35.25pt'>
                            <td height=47 colspan="2" width=831 style='height:35.25pt;width:111pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=47 class=xl77 width=148 style='height:35.25pt;border-top:none;
    width:111pt'>Nose Mask <span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" <?php if(in_array('Nose Mask',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Nose Mask" />
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
    height:35.25pt;border-left:none;width:124pt'>Hand Gloves <span class="float_right">
                                    <input name="required_ppe[]" <?php if(in_array('Hand Gloves',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Hand Gloves" type="checkbox" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=47 style='mso-height-source:userset;height:35.25pt'>
                            <td height=47 colspan="2" width=831 style='height:35.25pt;width:111pt' align=left
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
                            <td height=21 class=xl83 width=831 style='height:15.75pt;width:111pt'><b>Status:</b><span
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
                            <td height=21 class=xl83 width=831 style='height:15.75pt;width:111pt'><b>Reason for cancellation : </b><span
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

                          <tr height=21 style='height:15.75pt'>
                            <td height=21 class=xl83 width=831 style='height:15.75pt;width:111pt'><b>Revalidation:</b><span
  style='mso-spacerun:yes'>                   </span></td>
                            <td colspan=15 class=xl155 style='border-right:1.0pt solid black;
  border-left:none;width:825pt'><span style='mso-spacerun:yes'>  </span><b>I have
                              visited the work area and understand and well comply with the requirements of
                              this permit</b></td>
                          </tr>
             <?php
       if($readonly===true)
       {
       ?>                 
            <tr height=41 style='height:15.75pt'>
              <td height=41 class=xl83 width=148 style='height:55.75pt;width:111pt'><b>Permit Status: </b><span
              style='mso-spacerun:yes'>                   </span></td>
              <td colspan=4 class=xl155 width=1100 style='border-right:1.0pt solid black;
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
                      
                      #if($time_diff>=PERMIT_CLOSE_AFTER)  # || strtolower($status)!='open'
                      #$hide=1;
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
            $display_style='block';   //Anand
            
            ?>  
              </td> 
              <td colspan="12">

                <span id="self_cancellation_section" style="display:<?php echo $display_style; ?>;">Reason for cancellation <br /> <input type="text" value="<?php echo $self_cancellation_description; ?>" name="self_cancellation_description" id="self_cancellation_description" class="form-control" style="width:400px;"></span>

                            <?php
                             if(isset($records))
                             $completion_checklist=json_decode($records['completion_checklist']);
                             else
                             $completion_checklist=array();

                              $checklist_show='none';

                             if($approval_status>2 && $approval_status<=4) 
                             $checklist_show='block'; 

                          ?>
                                          <table align="center" width="100%" id="completion_checklist" style="display:<?php echo $checklist_show; ?>;">
                                              <tr>
                                                <td colspan="2" align="center" style="padding-top:15px;border-left:none;"><b>Completion Check List</b></td>
                                              </tr>  
                                              <tr><td colspan="2" style="border-left:none;border-bottom:.5pt solid black;">&nbsp;</td></tr>

                                              <?php
                                              foreach($completion_lists as $key => $works)
                                              {


                                              ?>
                                              <tr>
                                              <td style="border-right:.5pt solid black;border-left:none;height:45px;" width="700px"><?php echo $key.') '.$works; ?></td>
                                              <td style="border-left:none;" width="300px">
                                                <center>
                                                    <input data-attr="<?php echo $key; ?>" type="radio" <?php if(isset($completion_checklist->$key) && $completion_checklist->$key=='Yes') { ?> checked="checked" <?php } ?> name="completion_checklist[<?php echo $key; ?>]" value="Yes" class="radio_button completion_checklist" id="completion_checklist<?php echo $key; ?>" <?php echo $checklist; ?>/>
                                                    <label for="completion_checklist<?php echo $key; ?>">Y</label>&nbsp;
                                                    <input id="completion_no_checklist<?php echo $key; ?>" data-attr="<?php echo $key; ?>" type="radio" <?php if(isset($completion_checklist->$key) && $completion_checklist->$key=='NA') { ?> checked="checked" <?php } ?> name="completion_checklist[<?php echo $key; ?>]" value="NA" class="radio_button completion_checklist" <?php echo $checklist; ?>/><label for="completion_no_checklist<?php echo $key; ?>">NA</label>
                                                </center>
                                                </td>
                                               </tr>
                                               <?php
                                                }
                                              ?>
                                          </table>


              </td>
              
             </tr>
          <?php 
       }
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

  </table>
   <table align="center" width="100%" border="1" class="form_work"  >
                          <tr height=21 style='height:15.75pt'>
                            <td rowspan=3 height=83 class=xl157 width=831 style='border-bottom:.5pt solid black;
      height:62.25pt;width:111pt'><b>SCHEDULE</b></td>
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:200px;' valign="middle">Date :
                              <input type="text" value="<?php echo $sch_date_a; ?>" name="schedule_date[a]"  class="schedule_date form-control" id="schedule_date1" data-diff="<?php echo $diff_days; ?>" data-id="1" style="width: 127px;" data-ia-approval="<?php echo $ia_app_status; ?>"/><br /></td>
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
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:200px;;vertical-align: middle;'>Date :
                              <input type="text" value="<?php echo $sch_date_b; ?>" name="schedule_date[b]"  class="schedule_date form-control" style="width: 107px;" id="schedule_date2" data-id="2" data-diff="<?php echo $diff_days; ?>" data-ia-approval="<?php echo $ia_app_status; ?>" /><br /></td>
  <?php $ia_app_status=(isset($issuing_authority_approval_status->c)) ? strtolower($issuing_authority_approval_status->c) : ''; 
  
   $sch_date_c=(isset($schedule_date->c)) ? $schedule_date->c : '';
    
   if($sch_date_c!='')  
   $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$sch_date_c));
   else
   $diff=$this->public_model->datetime_diff(array('end_date'=>$sch_date_b,'start_date'=>date('Y-m-d H:i:s')));
     
   $diff_days=$diff['days'];
  ?>                                
       
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:200px;'>Date :
                              <input type="text" value="<?php echo (isset($schedule_date->c)) ? $schedule_date->c : ''; ?>" name="schedule_date[c]" data-diff="<?php echo $diff_days; ?>" class="schedule_date form-control" style="width: 107px;" id="schedule_date3" data-id="3" data-ia-approval="<?php echo $ia_app_status; ?>"/><br /></td>
  <?php $ia_app_status=(isset($issuing_authority_approval_status->d)) ? strtolower($issuing_authority_approval_status->d) : ''; 
   $sch_date_d=(isset($schedule_date->d)) ? $schedule_date->d : '';
    
   if($sch_date_d!='')  
   $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$sch_date_d));
   else
   $diff=$this->public_model->datetime_diff(array('end_date'=>$sch_date_c,'start_date'=>date('Y-m-d H:i:s')));
     
   $diff_days=$diff['days'];
  
  ?>  
  
                                
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:200px;'>Date :
                              <input type="text" value="<?php echo (isset($schedule_date->d)) ? $schedule_date->d : ''; ?>" name="schedule_date[d]" data-diff="<?php echo $diff_days; ?>" class="schedule_date form-control" style="width: 107px;" id="schedule_date4" data-id="4" data-ia-approval="<?php echo $ia_app_status; ?>"/><br /></td>
  <?php $ia_app_status=(isset($issuing_authority_approval_status->e)) ? strtolower($issuing_authority_approval_status->e) : ''; 
  
   $sch_date_e=(isset($schedule_date->e)) ? $schedule_date->e : '';
    
   if($sch_date_e!='')  
   $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$sch_date_e));
   else
   $diff=$this->public_model->datetime_diff(array('end_date'=>$sch_date_d,'start_date'=>date('Y-m-d H:i:s')));
     
   $diff_days=$diff['days'];
       
     ?>                       
                              
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:200px;'>Date :
                              <input type="text" value="<?php echo (isset($schedule_date->e)) ? $schedule_date->e : ''; ?>" name="schedule_date[e]" data-diff="<?php echo $diff_days; ?>" class="schedule_date form-control" style="width: 107px;" id="schedule_date5" data-id="5" data-ia-approval="<?php echo $ia_app_status; ?>"/><br /></td>
  <?php $ia_app_status=(isset($issuing_authority_approval_status->f)) ? strtolower($issuing_authority_approval_status->f) : ''; 
  
  
   $sch_date_f=(isset($schedule_date->f)) ? $schedule_date->f : '';

    
   if($sch_date_e!='')  
   $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$sch_date_f));
   else
   $diff=$this->public_model->datetime_diff(array('start_date'=>$sch_date_e,'end_date'=>date('Y-m-d H:i:s')));
     
   $diff_days=$diff['days'];
  
  ?>                                
                              
                            <td colspan=5  class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:200px;'>Date :
                              <input type="text" value="<?php echo (isset($schedule_date->f)) ? $schedule_date->f : ''; ?>" name="schedule_date[f]" data-diff="<?php echo $diff_days; ?>" class="schedule_date form-control" 
                              style="width: 107px;" id="schedule_date6" data-id="6" data-ia-approval="<?php echo $ia_app_status; ?>"/><br /></td>
                          </tr>
                          <tr height=21 style='height:15.75pt'>
                            <td colspan=2 height=83 class=xl146 style='border-right:1.0pt solid black;
      height:15.75pt;border-left:none;width:124pt'><b>
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
                            <td colspan=2 class=xl146 style='border-right:1.0pt solid black;
      border-left:none;width:122pt'><b>
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
      border-left:none;width:122pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                            <td colspan=5  class=xl93 style='border-right:1.0pt solid black;border-left:none;width:183pt'><b>
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
                          <tr height=20 style='height:15.0pt'>
                            <td height=83 class=xl78 colspan="2" style='border-top:none;border-left:none;'>
                              From<br />
                            <?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[a]','selected_value'=>(isset($schedule_from_time->a)) ? $schedule_from_time->a : '')); ?>
                          
                            To <br />
<?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[a]','selected_value'=>(isset($schedule_to_time->a)) ? $schedule_to_time->a : '')); ?>
</td>
                          
                            <td class=xl78  colspan="2" style='border-top:none;border-left:none;'>
                               From<br />
                            <?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[b]','selected_value'=>(isset($schedule_from_time->b)) ? $schedule_from_time->b : '')); ?>
                            To <br />
                           <?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[b]','selected_value'=>(isset($schedule_to_time->b)) ? $schedule_to_time->b : '')); ?></td>


                            <td class=xl78 colspan="2"  style='border-top:none;border-left:none;'>
                              From<br />
                            <?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[c]','selected_value'=>(isset($schedule_from_time->c)) ? $schedule_from_time->c : '')); ?>
                            To<br />
                           <?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[c]','selected_value'=>(isset($schedule_to_time->c)) ? $schedule_to_time->c : '')); ?></td>


                            <td class=xl80 colspan="2" width=85 style='border-top:none;border-left:none;'>
                              From<br />
                            <?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[d]','selected_value'=>(isset($schedule_from_time->d)) ? $schedule_from_time->d : '')); ?>
                              To <br />
                           <?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[d]','selected_value'=>(isset($schedule_to_time->d)) ? $schedule_to_time->d : '')); ?></td>


                            <td class=xl82 width=107 colspan="2" style='border-top:none;border-left:none;'>
                              From <br />
                            <?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[e]','selected_value'=>(isset($schedule_from_time->e)) ? $schedule_from_time->e : '')); ?>
                              To <br />
                            <?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[e]','selected_value'=>(isset($schedule_to_time->e)) ? $schedule_to_time->e : '')); ?></td>


                            <td class=xl82 width=225 colspan="5" style='border-top:none;border-left:none;'>
                              From <br />
                            <?php echo generate_time(array('class'=>'schedule_from_time','name'=>'schedule_from_time[f]','selected_value'=>(isset($schedule_from_time->f)) ? $schedule_from_time->f : '')); ?>
                            To <br />
                            <?php echo generate_time(array('class'=>'schedule_to_time','name'=>'schedule_to_time[f]','selected_value'=>(isset($schedule_to_time->f)) ? $schedule_to_time->f : '')); ?></td>
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
                            <td height=40 class=xl84 width=831 style='height:40.0pt;border-top:none;
  width:111pt'>Name of the Contractor</td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:124pt;vertical-align:middle;'><select class="form-control extended_contractors_id contractors" name="extended_contractors_id[a]"  data-show="extended_others_contractors_id_a" style="width:170px;margin-top:10px;" data-attr="a">
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
  border-left:none;width:126pt'><select class="form-control extended_contractors_id contractors" name="extended_contractors_id[b]"  data-show="extended_others_contractors_id_b" style="width:170px;margin-top:10px;" data-attr="b">
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
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="extended_others_contractors_id[b]" id="extended_others_contractors_id_b" class="extended_others_contractors_id form-control" style="margin-bottom:5px;width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><select class="form-control extended_contractors_id contractors" name="extended_contractors_id[c]"  data-show="extended_others_contractors_id_c" style="width:170px;margin-top:10px;" data-attr="c">
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
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="extended_others_contractors_id[c]" id="extended_others_contractors_id_c" class="extended_others_contractors_id form-control" style="margin-bottom:5px;width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  /></td>
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'>
                            <select class="form-control extended_contractors_id contractors" name="extended_contractors_id[d]"  data-show="extended_others_contractors_id_d" style="width:170px;margin-top:10px;" data-attr="c">
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
  border-left:none;width:122pt'>
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
  border-left:none;width:122pt'><select class="form-control extended_contractors_id contractors" name="extended_contractors_id[f]"  data-show="extended_others_contractors_id_f" style="width:170px;margin-top:10px;" data-attr="f">
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
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="extended_others_contractors_id[f]" id="extended_others_contractors_id_f" class="extended_others_contractors_id form-control" style="margin-bottom:5px;width:200px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  /></td>
                          </tr>

                          <?php
                           if(isset($records))
                           $no_of_persons=json_decode($records['no_of_persons']);
                           else
                           $no_of_persons=array();
    
                          ?>
                          <tr height=40 style='height:30.0pt'>
                            <td height=40 class=xl84 width=831 style='height:40.0pt;border-top:none;
  width:111pt'>No of Persons involved</td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:124pt'><input type="text" value="<?php echo (isset($no_of_persons->a)) ? $no_of_persons->a : ''; ?>" name="no_of_persons[a]"  class="no_of_persons form-control" style="width: 107px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:126pt'><input type="text" value="<?php echo (isset($no_of_persons->b)) ? $no_of_persons->b : ''; ?>" name="no_of_persons[b]"  class="no_of_persons form-control" style="width: 107px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><input type="text" value="<?php echo (isset($no_of_persons->c)) ? $no_of_persons->c : ''; ?>" name="no_of_persons[c]"  class="no_of_persons form-control" style="width: 107px;" /></td>
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><input type="text" value="<?php echo (isset($no_of_persons->d)) ? $no_of_persons->d : ''; ?>" name="no_of_persons[d]"  class="no_of_persons form-control" style="width: 107px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><input type="text" value="<?php echo (isset($no_of_persons->e)) ? $no_of_persons->e : ''; ?>" name="no_of_persons[e]"  class="no_of_persons form-control" style="width: 107px;" /></td>
                            <td width="213" colspan=5 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><input type="text" value="<?php echo (isset($no_of_persons->f)) ? $no_of_persons->f : ''; ?>" name="no_of_persons[f]"  class="no_of_persons form-control" style="width: 107px;" /></td>
                          </tr>
                          <?php
     if(isset($records))
     $performing_authority=json_decode($records['performing_authority']);
     else
     $performing_authority=array();
    
    ?>
                          <tr height=34 style='mso-height-source:userset;height:25.5pt'>
                            <td height=34 class=xl84 width=831 style='height:35.5pt;border-top:none;
  width:111pt'>Performing Authority</td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:124pt'><select id="performing_authority[a]" name="performing_authority[a]"  class="performing_authority form-control authority performing" style="width: 145px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  #$select=(isset($performing_authority->a)) ? $performing_authority->a : '';
  
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
                            </select></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:126pt'><select id="performing_authority[b]" name="performing_authority[b]"  class="performing_authority form-control authority performing" style="width: 145px;">
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
                            </select></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><select id="performing_authority[c]" name="performing_authority[c]"  class="performing_authority form-control authority performing" style="width: 145px;">
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
      
      $flag=0;
      
      $chk='';
      
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
                            </select></td>
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><select id="performing_authority[d]" name="performing_authority[d]"  class="performing_authority form-control authority performing" style="width: 145px;">
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
                            </select></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><select id="performing_authority[e]" name="performing_authority[e]"  class="performing_authority form-control authority performing" style="width: 145px;">
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
                            </select></td>
                            <td colspan=5 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><select id="performing_authority[f]" name="performing_authority[f]"  class="performing_authority form-control authority performing" style="width: 145px;">
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
                            </select></td>
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
    
    ?>
                          <tr height=30 style='mso-height-source:userset;height:22.5pt'>
                            <td height=30 class=xl85 width=831 style='height:32.5pt;border-top:none;
  width:111pt'>Issuing Authority</td>
                            <td colspan=2 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'>
  
  <input type="hidden" name="issuing_authority_approval_status[a]" id="issuing_authority_approval_status[1]" value="<?php echo (isset($issuing_authority_approval_status->a)) ? $issuing_authority_approval_status->a : ''; ?>" />
  
  <select id="issuing_authority[a]" name="issuing_authority[a]"  class="issuing_authority form-control authority issuing" style="width: 145px;">
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
                            </select></td>
                            <td colspan=2 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'>
  
    <input type="hidden" name="issuing_authority_approval_status[b]" id="issuing_authority_approval_status[2]" value="<?php echo (isset($issuing_authority_approval_status->b)) ? $issuing_authority_approval_status->b : ''; ?>" />

  <select id="issuing_authority[b]" name="issuing_authority[b]"  class="issuing_authority form-control authority issuing" style="width: 145px;">
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
                            </select></td>
                            <td colspan=2 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'>
  
    <input type="hidden" name="issuing_authority_approval_status[c]" id="issuing_authority_approval_status[3]" value="<?php echo (isset($issuing_authority_approval_status->c)) ? $issuing_authority_approval_status->c : ''; ?>" />

  <select id="issuing_authority[c]" name="issuing_authority[c]"  class="issuing_authority form-control authority issuing" style="width: 145px;">
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
                            </select></td>
                            <td colspan=2 class=xl179  style='border-right:1.0pt solid black;
  border-left:none;'>
  


    <input type="hidden" name="issuing_authority_approval_status[d]" id="issuing_authority_approval_status[4]" value="<?php echo (isset($issuing_authority_approval_status->d)) ? $issuing_authority_approval_status->d : ''; ?>" />

  <select id="issuing_authority[d]" name="issuing_authority[d]"  class="issuing_authority form-control authority issuing" style="width: 145px;">
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
                            </select></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;'>
    <input type="hidden" name="issuing_authority_approval_status[e]" id="issuing_authority_approval_status[5]" value="<?php echo (isset($issuing_authority_approval_status->e)) ? $issuing_authority_approval_status->e : ''; ?>" />

  <select id="issuing_authority[e]" name="issuing_authority[e]"  class="issuing_authority form-control authority issuing" style="width: 145px;">
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
                            </select></td>
                            <td colspan=5 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'>
    <input type="hidden" name="issuing_authority_approval_status[f]" id="issuing_authority_approval_status[6]" value="<?php echo (isset($issuing_authority_approval_status->f)) ? $issuing_authority_approval_status->f : ''; ?>" />

  <select id="issuing_authority[f]" name="issuing_authority[f]"  class="issuing_authority form-control authority issuing" style="width: 145px;">
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
                            </select></td>
                          </tr>
 <?php
     if(isset($records))
     $extended_scaffolding_certification_no=json_decode($records['extended_scaffolding_certification_no']);
     else
     $extended_scaffolding_certification_no=array();
    
    ?>   

<tr height=40 style='height:30.0pt'>
                            <td height=40 class=xl84 width=831 style='height:30.0pt;border-top:none;
  width:111pt'>Scaffold Tag</td>
  <?php
     $ref_code_show='disabled="disabled"';
  
    $issuing_authority_a=(isset($issuing_authority->a)) ? $issuing_authority->a : ''; 
    $issuing_authority_approval_status_a=(isset($issuing_authority_approval_status->a)) ? $issuing_authority_approval_status->a : '';
    
    if(in_array($user_id,array($issuing_authority_a,$performing_authority_a)))
    $ref_code_show='';

    #echo '<br /> AAAAAAAAAAAAAAAAAA '.$issuing_authority_approval_status_a;
  ?>  
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:124pt'><input type="text"  value="<?php echo (isset($extended_scaffolding_certification_no->a)) ? $extended_scaffolding_certification_no->a : ''; ?>" name="extended_scaffolding_certification_no[a]" <?php echo $ref_code_show; ?> id="extended_scaffolding_certification_no1"  class="extended_scaffolding_certification_no form-control" style="width: 141px;" /></td>

  <?php
    $ref_code_show='disabled="disabled"';
  
  $issuing_authority_b=(isset($issuing_authority->b)) ? $issuing_authority->b : ''; 
  $issuing_authority_approval_status_b=(isset($issuing_authority_approval_status->b)) ? $issuing_authority_approval_status->b : '';
  
    if(in_array($user_id,array($issuing_authority_b,$performing_authority_b)))
    $ref_code_show='';



  ?>  
  
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:126pt'><input <?php echo $ref_code_show; ?> type="text" value="<?php echo (isset($extended_scaffolding_certification_no->b)) ? $extended_scaffolding_certification_no->b : ''; ?>" name="extended_scaffolding_certification_no[b]" id="extended_scaffolding_certification_no2"   class="form-control" style="width: 141px;" /></td>
  
  <?php
     $ref_code_show='disabled="disabled"';

  $issuing_authority_c=(isset($issuing_authority->c)) ? $issuing_authority->c : ''; 
  $issuing_authority_approval_status_c=(isset($issuing_authority_approval_status->c)) ? $issuing_authority_approval_status->c : '';
  
   if(in_array($user_id,array($issuing_authority_c,$performing_authority_c)))
    $ref_code_show='';
  ?>  
  
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:117pt'><input <?php echo $ref_code_show; ?> type="text" value="<?php echo (isset($extended_scaffolding_certification_no->c)) ? $extended_scaffolding_certification_no->c : ''; ?>" name="extended_scaffolding_certification_no[c]" id="extended_scaffolding_certification_no3"   class="form-control"   style="width: 141px;" /></td>
  
  <?php
    $ref_code_show='disabled="disabled"';
  
  $issuing_authority_d=(isset($issuing_authority->d)) ? $issuing_authority->d : ''; 
  $issuing_authority_approval_status_d=(isset($issuing_authority_approval_status->d)) ? $issuing_authority_approval_status->d : '';
  
    if(in_array($user_id,array($issuing_authority_d,$performing_authority_d)))
    $ref_code_show='';
  ?>  
  
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><input <?php echo $ref_code_show; ?> type="text" value="<?php echo (isset($extended_scaffolding_certification_no->d)) ? $extended_scaffolding_certification_no->d : ''; ?>" name="extended_scaffolding_certification_no[d]" id="extended_scaffolding_certification_no4"  class=" form-control" style="width: 141px;" /></td>
  
  <?php
    $ref_code_show='disabled="disabled"';
  
  $issuing_authority_e=(isset($issuing_authority->e)) ? $issuing_authority->e : ''; 
  $issuing_authority_approval_status_e=(isset($issuing_authority_approval_status->e)) ? $issuing_authority_approval_status->e : '';
  
    if(in_array($user_id,array($issuing_authority_e,$performing_authority_e)))
    $ref_code_show='';
  ?>  
  
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:173pt'><input <?php echo $ref_code_show; ?> type="text" value="<?php echo (isset($extended_scaffolding_certification_no->e)) ? $extended_scaffolding_certification_no->e : ''; ?>" name="extended_scaffolding_certification_no[e]" id="extended_scaffolding_certification_no5"    class="form-control" style="width: 141px;" /></td>
  
  <?php
    $ref_code_show='disabled="disabled"';
  
  $issuing_authority_f=(isset($issuing_authority->f)) ? $issuing_authority->f : ''; 
  $issuing_authority_approval_status_f=(isset($issuing_authority_approval_status->f)) ? $issuing_authority_approval_status->f : '';
  
     if(in_array($user_id,array($issuing_authority_f,$performing_authority_f)))
    $ref_code_show='';
  ?>  
  
                            <td width="213" colspan=5 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:163pt'><input <?php echo $ref_code_show; ?> type="text" value="<?php echo (isset($extended_scaffolding_certification_no->f)) ? $extended_scaffolding_certification_no->f : ''; ?>" name="extended_scaffolding_certification_no[f]" id="extended_scaffolding_certification_no6"    class="form-control" style="width: 141px;" /></td>
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
  border-left:none;width:124pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->a)) ? $reference_code->a : ''; ?>" name="reference_code[a]" id="reference_code1"  class="reference_code form-control" style="width: 141px;" /></td>
  <?php
    $ref_code_show='hidden';
  
  $issuing_authority_b=(isset($issuing_authority->b)) ? $issuing_authority->b : ''; 
  $issuing_authority_approval_status_b=(isset($issuing_authority_approval_status->b)) ? $issuing_authority_approval_status->b : '';
  
    if($issuing_authority_b==$user_id || $issuing_authority_approval_status_b=='Approved')
  $ref_code_show='text';
  ?>  
  
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:126pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->b)) ? $reference_code->b : ''; ?>" name="reference_code[b]" id="reference_code2"   class="reference_code form-control" style="width: 141px;" /></td>
  
  <?php
    $ref_code_show='hidden';

  $issuing_authority_c=(isset($issuing_authority->c)) ? $issuing_authority->c : ''; 
  $issuing_authority_approval_status_c=(isset($issuing_authority_approval_status->c)) ? $issuing_authority_approval_status->c : '';
  
    if($issuing_authority_c==$user_id || $issuing_authority_approval_status_c=='Approved')
  $ref_code_show='text';
  ?>  
  
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:117pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->c)) ? $reference_code->c : ''; ?>" name="reference_code[c]" id="reference_code3"   class="reference_code form-control" style="width: 141px;" /></td>
  
  <?php
    $ref_code_show='hidden';
  
  $issuing_authority_d=(isset($issuing_authority->d)) ? $issuing_authority->d : ''; 
  $issuing_authority_approval_status_d=(isset($issuing_authority_approval_status->d)) ? $issuing_authority_approval_status->d : '';
  
    if($issuing_authority_d==$user_id || $issuing_authority_approval_status_d=='Approved')
  $ref_code_show='text';
  ?>  
  
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->d)) ? $reference_code->d : ''; ?>" name="reference_code[d]"  id="reference_code4"  class="reference_code form-control" style="width: 141px;" /></td>
  
  <?php
    $ref_code_show='hidden';
  
  $issuing_authority_e=(isset($issuing_authority->e)) ? $issuing_authority->e : ''; 
  $issuing_authority_approval_status_e=(isset($issuing_authority_approval_status->e)) ? $issuing_authority_approval_status->e : '';
  
    if($issuing_authority_e==$user_id || $issuing_authority_approval_status_e=='Approved')
  $ref_code_show='text';
  ?>  
  
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:173pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->e)) ? $reference_code->e : ''; ?>" name="reference_code[e]" id="reference_code5"   class="reference_code form-control" style="width: 141px;" /></td>
  
  <?php
    $ref_code_show='hidden';
  
  $issuing_authority_f=(isset($issuing_authority->f)) ? $issuing_authority->f : ''; 
  $issuing_authority_approval_status_f=(isset($issuing_authority_approval_status->f)) ? $issuing_authority_approval_status->f : '';
  
    if($issuing_authority_f==$user_id || $issuing_authority_approval_status_f=='Approved')
  $ref_code_show='text';
  ?>  
  
                            <td width="213" colspan=5 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:163pt'><input type="<?php echo $ref_code_show; ?>" value="<?php echo (isset($reference_code->f)) ? $reference_code->f : ''; ?>" name="reference_code[f]" id="reference_code6"   class="reference_code form-control" style="width: 141px;" /></td>
                          </tr>                          
                          
                           <tr height=31 style='height:23.25pt'>
                            <td colspan=16 height=31 class=xl182 style='border-right:1.0pt solid black;
  height:23.25pt;width:936pt'>
                        <b>  <?php echo EMERGENCY_CONTACT_NUMBER; ?> 
</b>
 
                          </td></tr>
                          
                        </table>
                        <div>&nbsp;</div>
                        <input type="hidden" id="show_button" name="show_button" />
                        <?php
            $is_show_button=(isset($records['show_button'])) ? $records['show_button'] : 'show';

            $is_rejected=(isset($records['is_rejected'])) ? $records['is_rejected'] : NO;
            
            $is_popup_submit=$is_extended=$is_show_extended_button=0;
            
            $show_extend_field=-01;

            $is_reject='';
            
            $show_flag=2;

            $redirect='';
            
            #echo '<pre>'; print_r($records);echo '<br /> S : '.$is_show_button.' = '.$show_flag.' - '.$approval_status;
            
            
            if($approval_status<9)
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
                    else if($acceptance_issuing_approval=='No' && $user_id==$records['acceptance_issuing_id'] && $is_rejected==NO)
                    {
                        $label=' Approve & Submit';
                        
                        $is_reject=1;

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
                       echo '<button class="btn btn-sm btn-primary show_button"  value="'.$submit_value.'" type="submit"><i class="fa fa-dot-circle-o"></i> '.$label.'</button>';
                      else { #$is_popup_submit=1;
                      
                      if($eip_opened==count($jobs_isoloations_ids))
                       echo '<button class="btn btn-sm btn-primary show_button" value="hide" type="submit"><i class="fa fa-dot-circle-o"></i> Final Submit</button>';
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
                      
                      #for($r=0;$r<count($range);$r++)

                      $r=0;
                      foreach($range as $ranges)
                      {
                        
                        #echo '<br /> A '.$performing_authority->$range[$r].' - == '.$user_id.' && '. $issuing_authority_approval_status->$range[$r];
                        
                        if($issuing_authority->$ranges==$user_id && $issuing_authority_approval_status->$ranges!='Approved'  && $is_rejected==NO)
                        {
                          $is_extended=1; $is_show_extended_button=1; $is_reject=1;
                          echo '<button class="btn btn-sm btn-primary show_button"  value="hides" type="submit"><i class="fa fa-dot-circle-o"></i> Approve '.$status.' & Submit</button>';  
                         break;
                        }
                        if($performing_authority->$ranges==$user_id && !in_array($issuing_authority_approval_status->$ranges,array('Approved','')))
                        {
                          $show_extend_field=$r;
                          
                          $is_extended=1; $is_show_extended_button=0; break;
                        }
                        else if($issuing_authority->$ranges!='' && $issuing_authority_approval_status->$ranges!='Approved') 
                        {
                          $is_extended=$is_show_extended_button=1;
                        }
                        
                        $r++;
                      }

                     
                      if($is_show_extended_button==0)
                      echo '<button class="btn btn-sm btn-primary show_button"  value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>';
    
                    }
                    else if(!in_array($approval_status,array(3,5,6)) || ($cancellation_performing_id==$user_id && $cancellation_issuing_date==''))  
                    {
                        $show_flag=2;
                        echo '<button class="btn btn-sm btn-primary show_button"  value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>'; }
                    else if(in_array($user_id,array($cancellation_issuing_id)) && in_array($approval_status,array(3,5))  && $is_rejected==NO)
                    {
                      $is_reject=1;
                      echo '<button class="btn btn-sm btn-primary show_button"  value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Approve '.$status.' & Submit</button>';
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

            if($is_reject!=''  && $is_rejected==NO)
              echo '<button class="btn btn-sm btn-danger show_button"  value="reject" type="submit"><i class="fa fa-dot-circle-o"></i> Reject Request</button>';
            ?>
             <a  class="btn btn-sm btn-danger" href="<?php echo $redirect; ?>"><i class="fa fa-ban"> Go Back</i></a>  
                           
                
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
<?php

      $this->load->view('jobs/popup_energy_model_form'); 

function generate_time($array_args)
{
  extract($array_args);
  
  $selected_value=(isset($selected_value)) ? $selected_value : '';
  
  $width=(isset($width)) ? $width : '110px';
  
  $class=(isset($class)) ? $class : '';
  
  $id=(isset($id)) ? $id : $name;
?>  
  <select name="<?php echo $name; ?>" id="<?php echo $id; ?>"  class="form-control <?php echo $class; ?>" style="width:<?php echo $width; ?>;">
      <option value="" selected="selected">Select</option>
  <?php for($i = 0; $i < 24; $i++)
    {
  
      $t=$i ; #% 12 ? $i % 12 : 12
      
          if($i<=9)
          $i='0'.$i;
      
      for($s=0;$s<=45;$s+=15)
      {
          #$t.= ':00';
          
          #$a=$i >= 12 ? 'pm' : 'am';
          
          #$t=$t.' '.$a;
          
          if($s==0)
          $t= ':00';
          else
          $t=':'.$s;
          
          
          $t=$i.$t;
          
      
          if($t==$selected_value)
          $sel="selected=selected";
          else
          $sel='';
   ?>
   <option value="<?php echo $t; ?>" <?php echo $sel; ?>><?php echo $t; ?></option>
     
  <?php } } ?>
  </select>
<?php 
}

 $this->load->view('layouts/footer'); ?>      
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script> 
<script>
  $(document).ready(function() {

    $('#gritter_trigger').val(''); // skip gritter success popup

    $("#form").validate({ 
      rules: {
                name:{
                    required:true
                }
            },
      messages:
      {
        name:{
                    required:'Required'
                }
      },
    errorPlacement: function(error,element){
            error.appendTo(element.parent().parent());                        
        },
        submitHandler:function(){
                 $("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing");
                form.submit();
        }
    });
    });

</script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jobs.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.thickbox.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<link href="<?php echo base_url(); ?>assets/css/jquery.thickbox.css" rel="stylesheet" media="screen" type="text/css" />

<link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet"type="text/css" />
<script src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>

<script type="text/javascript">   

    function open_thick(epi_id)
    {
      
      //var url = "<?php echo base_url(); ?>jobs/ajax_show_energy_info/id/"+epi_id+"?TB_iframe=true&keepThis=true&width=1050&height=550";
      
      //tb_show("Energy Isolation Permit Form", url); 
      
      var win = window.open('<?php echo base_url(); ?>jobs_isolations/form/id/'+epi_id, '_blank');
      if (win) {
        //Browser has allowed it to be opened
        win.focus();
      } else {
        //Browser has blocked it
        alert('Please allow popups for this website');
      }     
      
    }

  $(document).ready(function() {

    $('.peptalk').change(function() {

            console.log($(this).is(':checked'));

          if($(this).is(':checked')==true)
          {
            $('#peptalk').show();
          }
          else
          {
            $('#peptalk').hide();

            $('.peptalk_text').val('');
          }


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
    
    $selected_eip=$('select.selected_eip').select2(
      {
          formatSelection: function(term) {
             // return "<a href='<?php echo base_url(); ?>jobs/ajax_show_energy_info/id/"+term.id+"?TB_iframe=true&keepThis=true&width=1050&height=550' data-attr-id='"+term.id+"' class='open_thick thickbox'>"+term.text+"</a>";
            return "<a href='#' onclick=open_thick('"+term.id+"')>"+term.text+"</a>";
            //return "<a href='<?php echo base_url(); ?>jobs_isolations/form/id/"+term.id+"/' target='_blank'>"+term.text+"</a>";
      }
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
    $('.precautions').attr('disabled',true);  //,.hazard_option,.precaution_option
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
              $('.status').removeAttr('disabled').attr('readonly',true);
              $('.status:checked').trigger('click');  
              $('select[name="schedule_from_time[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('select[name="schedule_to_time[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('input[name="no_of_persons[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('select[name="extended_contractors_id[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('input[name="schedule_date[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('select[name="issuing_authority[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('select[name="extended_others_contractors_id[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
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

          if($approval_status>2 && $approval_status<4 && in_array($user_id,array($cancellation_performing_id,$cancellation_issuing_id)))
          echo "$('.completion_checklist').removeAttr('disabled');";
            
      }
    ?>  
      $('body').on('click','.status',function() 
      { 
                console.log('Value : '+$('.status:checked').val());

                if($('.status:checked').val()=='Cancellation')
                {
                  $('#self_cancellation_section').show();

                  $('#self_cancellation_description').removeAttr('disabled');

                  $('#completion_checklist').hide();

                  $('.completion_checklist').removeAttr('disabled');     
                }  
                else if($('.status:checked').val()=='Completion')
                {
                  $('#completion_checklist').show();

                  $('#self_cancellation_section').hide();

                  $('#self_cancellation_description').val('');   

                  $('.completion_checklist').removeAttr('disabled');     
                }
                else
                {  

                  $('.completion_checklist').removeAttr('disabled');     

                  $('#completion_checklist').hide();

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

          console.log('Line no :2041');

          $('input[name^="no_of_persons"],input[name^="schedule_date"],input[name^="extended_others_contractors_id"]').attr('disabled','disabled');  
          
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


            //console.log('data_ia_approval '+data_ia_approval);

            if(data_ia_approval!='approved')
            {
                $('input[name="extended_others_contractors_id['+selector_name+']"]').prop('disabled',false);  //Newly added

                if(schedule_date!='' && $('#scaffolding_certification_no').val()!='')
                $('input[name="extended_scaffolding_certification_no['+selector_name+']"]').prop('disabled',false); 
            }    
            
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
                   
    		                $('input[name="reference_code['+selector_name+']"]').val(Math.random().toString(13).substring(0,9).replace('0.', ''));
                          
                        console.log('Line no : 3045');

                        $('select[name="schedule_from_time['+selector_name+']"],input[name="no_of_persons['+selector_name+']"],select[name="extended_contractors_id['+selector_name+']"],input[name="extended_others_contractors_id['+selector_name+']"],select[name="schedule_to_time['+selector_name+']"],select[name="issuing_authority['+selector_name+']"],select[name="performing_authority['+selector_name+']"]').prop('disabled',false);
                        
                        $('select[name="extended_contractors_id['+selector_name+']"],input[name="extended_others_contractors_id['+selector_name+']"]').removeAttr('readonly');

                        $('select[name="extended_contractors_id['+selector_name+']"],input[name="extended_others_contractors_id['+selector_name+']"]').prop('disabled',false);

                        $('select[name="schedule_from_time['+selector_name+']"],select[name="schedule_to_time['+selector_name+']"]').removeAttr('readonly');
                        
                        $('select[name="schedule_from_time['+selector_name+']"],select[name="schedule_to_time['+selector_name+']"]').removeAttr('disabled');

                        $('select[name="schedule_from_time['+selector_name+']"],select[name="schedule_to_time['+selector_name+']"]').prop('disabled',false);


                       
                        if($('#scaffolding_certification_no').val()!='')
                        {
                           $('input[name="extended_scaffolding_certification_no['+selector_name+']"]').removeAttr('disabled');          

                           $('input[name="extended_scaffolding_certification_no['+selector_name+']"]').prop('disabled',false);   

                           $('input[name="extended_scaffolding_certification_no['+selector_name+']"]').val($('#scaffolding_certification_no').val()); 
                        }
                           
                        console.log('Here '+$('#scaffolding_certification_no').val());                    
                    },
                  showButtonPanel: true,
                  closeText: 'Clear',
                  onClose: function(e) {
                  }
                }).focus(function() {
                  
                  console.log('Current : '+$(this).attr('data-id'));
                  //alert('Close '+Math.random().toString(36).substring(7));
                  $('.ui-datepicker-close').click(function() {
                      
                      console.log('Line no :3070');

                    $('select[name="schedule_from_time['+selector_name+']"],input[name="reference_code['+selector_name+']"],input[name="no_of_persons['+selector_name+']"],select[name="extended_contractors_id['+selector_name+']"],input[name="extended_others_contractors_id['+selector_name+']"],select[name="schedule_to_time['+selector_name+']"],select[name="issuing_authority['+selector_name+']"],select[name="performing_authority['+selector_name+']"]').val('').prop('disabled',true);
                    
                    $('selector').datepicker('setDate', null);
                    $('input[name="schedule_date['+selector_name+']"]').val('');
                    $('input[name="issuing_authority_approval_status['+selector_name+']"]').val('');
                    $('input[name="extended_scaffolding_certification_no['+selector_name+']"]').val('');
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
    
  $('.show_button').click(function() 
  {
        if($(this).val()=='reject')
        {
            if(!confirm('Are you sure to reject PA request?'))
            return false;  
        }

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
    
    



$(".hazard_option").change(function()
{   
  var val=$(this).val();
  
  var is_checkbox=$(this).attr('data-checkbox');
  
  var data_attr=$(this).attr('data-attr');
  
  if(val=='No')
  {
    if(is_checkbox)
    {
       $('input[name="hazards_options['+data_attr+']"]').removeAttr('checked').attr('disabled',true).removeClass('error');
    }
    
    // $('input[name="precautions_options['+data_attr+']"]').removeAttr('checked').attr('disabled',true);
  }
  else
  { 
    if(is_checkbox)
    $('input[name="hazards_options['+data_attr+']"]').removeAttr('disabled');
    
  }

});

$(".hazards:checked").each(function(index,value) {
   
   //console.log('Index : '+index+' = '+$(this).val()+' - '+$(this).attr('data-attr'));
   
   if($(this).attr('data-checkbox') && $(this).val()=='No')
   $('input[name="hazards_options['+$(this).attr('data-attr')+']"]').removeAttr('checked').attr('disabled',true);
   
  // $('.precautions  data-attr="'+$(this).attr('data-attr')+'"').removeAttr('disabled');
   
});

$(".hazards_options:checked").each(function(index,value) {
   
   //$('input[name="hazards['+$(this).attr('data-attr')+']"]').removeAttr('disabled');
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
    <?php
    
    if(empty($record_id))
    {
    ?>    
    /*$(".hazards").each(function(index,value) {
      
        if($(this).val()=='Yes')
        $(this).attr('checked',true);
        
        var at=$(this).attr('data-attr');
        
        
        $('input[name="precautions['+at+']"]').prop("disabled", false);
    }); 
    */
    //$('input[name="hazards[n]"]:first').attr('checked',true);
    //$('input[name="precautions[n]"]').prop("disabled", false);
    <?php
    }
    ?>

$(".hazards").click(function() {
  
  var at=$(this).attr('data-attr');
  
  var chk=$(this).attr('data-checkbox');
  
  $('input[name="precautions['+at+']"]').removeAttr('disabled');
  
  $('input[name="precautions['+at+']"]').removeAttr('checked');

  console.log($(this).val()+' = '+at);
  
  if($(this).val()=='No')
  {
    $('input[name="precautions['+at+']"]:eq(1)').prop('checked', true);
    
    $('input[name="precautions_options['+at+']"]').removeAttr('checked').attr('disabled',true);

    $('input[name="precautions_text['+at+']"]').val('').attr('disabled',true);
  }
  else
  {
    $('input[name="precautions_options['+at+']"]').removeAttr('disabled',true);    

    $('input[name="precautions_text['+at+']"]').removeAttr('disabled',true);  
  } 
    
});

$(".box_big").click(function() 
{
    var height_checklist='';

    var hot_checklist='';
    
        $('.required_ppe:eq(4)').removeAttr('checked');
        //$('.required_ppe:eq(4)').removeAttr('disabled');  
        var b=1;
        $(".box_big:checked").each(function(index,value)
        {  
            if($(this).val()=='height_work')
            {
              $('.required_ppe:eq(4)').prop('checked', true);
              $('.required_ppe:eq(4)').prop('disabled', true);

              b=2;

              height_checklist=1;
            }

            if($(this).val()=='hot_work')
             hot_checklist=1;

            if(b==1)
           $('.required_ppe:eq(4)').prop('disabled', false);
      });

     
      if(height_checklist==1)
        $('.height_works').prop('disabled',false);
      else
      {
          $('.height_works').prop('disabled',true);

          $('.height_works').removeAttr('checked');
          
          //$('.height_works').filter("[value='NA']").attr('checked', true);
      }

     if(hot_checklist==1)
        $('.hot_works').prop('disabled',false);
      else
      {
        $('.hot_works').prop('disabled',true);
        $('.hot_works').removeAttr('checked');
        //$('.hot_works').filter("[value='NA']").attr('checked', true);
      }  



});

$(".precautions").click(function() {
  
  var at=$(this).attr('data-attr');
  
  var haz_val=$('input[name="hazards['+at+']"]:checked').val();
  
  var pre_val=$(this).val();
  
  console.log('REv : '+haz_val);
  
  if(haz_val!='Yes')
  {
    if(pre_val!='N/A')
    {
      alert('Please select N/A');
    
      $(this).removeAttr('checked');
    }
  }
  
  var is_checkbox=$(this).attr('data-checkbox');
  
  var data_attr=$(this).attr('data-attr');
  
  if(pre_val=='N/A')
  {
    if(is_checkbox)
    {
       $('input[name="precautions_options['+data_attr+']"]').removeAttr('checked').attr('disabled',true);
    }
  }
  else
  { 
    if(is_checkbox)
    $('input[name="precautions_options['+data_attr+']"]').removeAttr('disabled');
    
  }
  
});

$(".precautions_options:checked").each(function(index,value) {
   //$('input[name="precautions['+$(this).attr('data-attr')+']"]').removeAttr('disabled'); No need 
});

$(".precautions_options").click(function() {
  
  var at=$(this).attr('data-attr');
  
  //console.log('Lenght : '+$('input[name="hazards_options['+at+']"]:checked').length);
  var checked_length=$('input[name="precautions_options['+at+']"]:checked').length;
  
  if(checked_length>0)
  $('input[name="precautions['+at+']"]').removeAttr('disabled');
  else
  $('input[name="precautions['+at+']"]').attr('disabled',true);
  
  
  if($(this).attr('data-other'))
  {
    if($(this).is(':checked'))
    $('#'+$(this).attr('data-other')).show();
    else
    $('#'+$(this).attr('data-other')).hide();
    
  }
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

  var zone_id=$('#zone_id').val();

  console.log('Val '+sel_val);
    
    //console.log('Return '+$.inArray(sel_val, ["Yes", "yes_existing"]));
    //if(sel_val=='Existing')
    if($.inArray(sel_val, ["Existing",'yes_existing'])!==-1) 
    {
        if(zone_id!='')
        {
            $.ajax({
            url: base_url+'jobs_isolations/ajax_get_isolations/',
            type: 'POST',
            data: {'zone_id' : zone_id},
            dataType: 'json',
            success: function(data, textStatus, jqXHR)
            {
              $('select.selected_eip').append(data.options);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {

            }
          }); 
     
          $('select.selected_eip').select2("enable");
          
          $selected_eip.rules('add','required');
       }
       else
       alert('Please select Zone');  

      console.log('SFSDFSDFsd');
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
    
    $arr = range('a', 'n');
    
    
    $validate='';
    for($i=0;$i<count($arr);$i++)
    {
      $validate.=",'hazards[".$arr[$i]."]': {required:".$flag."},'precautions[".$arr[$i]."]': {required:".$flag."}";
    }
    

    $arr=range('a','m');

    for($i=0;$i<count($arr);$i++)
    {
      $validate.=",'hot_work_checklists[".$arr[$i]."]': {required:".$flag."},'height_work_checklists[".$arr[$i]."]': {required:".$flag."}";
    }    


    $arr=array('a','d','e','h','i','k');
    for($i=0;$i<count($arr);$i++)
    {
      $validate.=",'hazards_options[".$arr[$i]."]':{required:function(element) {
                      if($('input[name=\"hazards[".$arr[$i]."]\"]:checked').val()=='Yes') 
                      return true; 
                      else return false;
                     }}";
    }

    $arr=array('c','e','f','j','n');
    for($i=0;$i<count($arr);$i++)
    {
      $validate.=",'precautions_options[".$arr[$i]."]':{required:function(element) {
                      if($('input[name=\"precautions[".$arr[$i]."]\"]:checked').val()=='Yes') 
                      return true; 
                      else return false;
                     }}";
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
        $validate.=",'extended_scaffolding_certification_no[".$arr[$i]."]':{required:function(element) {
                        if($('input[name=\"schedule_date[".$arr[$i]."]\"]').val()!='')
                        return true; 
                        else return false;
                       }}";               
      }

      if($approval_status>=2 && $approval_status<=4) //Complition Check list
      {
          foreach($completion_lists as $key => $val)
          {
            $validate.=",'completion_checklist[".$key."]': { required:function(element) { if($('input[name=status]:checked').val()=='Completion') return true; else return false;  }}";
          }

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

     $("select").on("select2:close", function (e) {  
        $(this).valid(); 
    });


    
    $("#job_form").validate({ 
              ignore: '.ignore',
              focusInvalid: true, 
      rules: {
        department_id:{required:<?php echo $flag; ?>},
        zone_id:{required:<?php echo $flag; ?>},
        line : {required:<?php echo $flag; ?>},
        //'other_inputs[]': { required:<?php echo $flag; ?>,minlength:1},alert($('input[name="other_inputs"]:checked').length);
        other_inputs_text :{ required:function(element) {
                          if($('.peptalk').is(':checked')==true) 
                          return <?php echo $flag; ?>;
                          else
                          return false;
           }},
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
        required_ppe_other : { required:true},
        'isoloation_permit_no' : { required:function(element) {
                          if($('input[name="is_isoloation_permit"]:checked').val()!='N/A') 
                          return <?php echo $flag; ?>;
                          else
                          return false;         
           },minlength:1},
        scaffolding_certification_no :{ required:function(element) {
                          if($('input[name="is_scaffolding_certification"]:checked').val()=='Yes') 
                          return <?php echo $flag; ?>;
                          else
                          return false;
           }}, 
        scaffolding_certification_issed_by : { required:function(element) {
                          if($('input[name="is_scaffolding_certification"]:checked').val()=='Yes') 
                          return <?php echo $flag; ?>;
                          else
                          return false;
           }}  
        <?php echo $validate; ?>    
        /*'hazards[a]': {required:true},
        'hazards_options[a]':{
                    required:function(element) 
                    { console.log('SS '+$('input[name="hazards[a]"]:checked').val()); 
                      if($('input[name="hazards[a]"]:checked').val()=='Yes') 
                      return true; 
                      else return false;
                     }}*/
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
      if($.inArray($("input[name=is_isoloation_permit]:checked").val(), [ "yes_existing",'Yes'])>=0  && $('.selected_eip option:selected').length<=0)
      {
          //alert('Please select at least one EIP');
      
          //return false;
        
          $('#is_popup_submit').val('0');
      }
      
      //if($("input[name=is_isoloation_permit]:checked").val()=='Yes' && $('#is_popup_submit').val()!=1)
      if($.inArray($("input[name=is_isoloation_permit]:checked").val(), [ "Yes", "yes_existing"])>=0  && $('#is_popup_submit').val()!=1)
      {
        var isoloation_permit_no='';
        
        <?php
        if(!empty($record_id))
        {
        ?>  
          if($('.selected_eip option:selected').length>0)
          var isoloation_permit_no=$('.selected_eip option:selected:eq(0)').val();
        <?php } ?>
        //$('#isoloation_permit_no').val();
        
        //alert(isoloation_permit_no); return false;
        
          if(isoloation_permit_no=='')
          { 
            var url = "<?php echo base_url(); ?>jobs/ajax_show_energy_info/id/"+isoloation_permit_no+"?TB_iframe=true&keepThis=true&width=1150&height=550";
            
            tb_show("Energy Isolation Permit Form", url);       
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

  
  $.validator.setDefaults({ 
    ignore: [],
    });


  
    $.validator.addMethod('minStrict', function (value, el, param) {
      return value > param;
    }); 
  
    function form_submit()
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
          

          var check_lists=new Array('hot_works','height_works','completion_checklist');

          for (i = 0; i < check_lists.length; i++) 
          {
              var cl=check_lists[i];

              $("."+cl+":checked").each(function ()
              {
                data.append($(this).attr('name'),$(this).val());
              });
          } 
            
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
          var vls='';
          $(".box_big:checked").each(function ()
          {
            vls+=$(this).val()+',';
          });
          
          data.append('work_types',vls);
          
          var pre_arr=new Array('c','e','f','j','n');
          
          for (i = 0; i < pre_arr.length; i++) 
          {
            var alpha=pre_arr[i];
            
            var alpha_vals='';
            
            var field_name='precautions_options['+alpha+']';
            
            $('input[name="'+field_name+'"]:checked').each(function ()
            {
              alpha_vals+=$(this).val()+'|';
              
            });
            
            data.append(field_name,alpha_vals);
          }
          $(".precautions:checked").each(function ()
          {
            data.append(this.name,$(this).val());
          });
          
    
          $(".hazards:checked").each(function ()
          {
            data.append(this.name,$(this).val());
          });
          
          
          var pre_arr=new Array('a','d','e','h','i','k');
          
          for (i = 0; i < pre_arr.length; i++) 
          {
            var alpha=pre_arr[i];
            
            var alpha_vals='';
            
            var field_name='hazards_options['+alpha+']';
            
            $('input[name="'+field_name+'"]:checked').each(function ()
            {
              alpha_vals+=$(this).val()+'|';
            });
            
            data.append(field_name,alpha_vals);
          }
          
          $(".precautions:checked").each(function ()
          {
            data.append(this.name,$(this).val());
          });
          
          data.append('is_isoloation_permit',$('input[name=is_isoloation_permit]:checked').val());

          data.append('line',$('input[name=line]:checked').val());
          
          //data.append('status',$('input[name=status]:checked').val());
          
          data.append('is_scaffolding_certification',$('input[name=is_scaffolding_certification]:checked').val());    
          
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
