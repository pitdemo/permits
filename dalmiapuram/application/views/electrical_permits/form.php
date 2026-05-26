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
 
 #$jobs_isoloations_ids = array();
 $permission=$this->session->userdata('permission');
 $user_role=strtolower($this->session->userdata('user_role'));
 $this->load->view('layouts/header',array('page_name'=>$page_name));
?>
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap.css" rel="stylesheet">

<style>
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

.select2-container.select2-container-multi.form-control.selected_eip.error { border-color:red; }
span.error{
    outline: none;
    border: 1px solid #800000;
    box-shadow: 0 0 5px 1px #800000;
  }
  #person_name-error { padding-left: 20px; }
  .issuing_authority { margin-top: 15px; }
   .form-control.select3 { width:450px !important; } { width:400px !important;}
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
                                <li ><a href="<?php echo base_url(); ?>electrical_permits"><i class="fa fa-home"></i>Electrical Work Permits</a></li>
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
            <table align="center" width="100%" border="1" class="form_work"  >
            <tr height=36 style='height:27.0pt'>
                            <td height=36 class=xl102 colspan="2" style='height:27.0pt;'><b>Select Department </b>
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
                              <td class=xl70 colspan="4" valign="top" style='width:48pt'>
                              
                              </td>
                              <td colspan="8"><b>Permit No</b><br /><br />#<span id="permit_no"><?php echo (isset($records['permit_no'])) ? $records['permit_no'] : $permit_no; ?></span></td>
                          </tr>
                          
                          
                          <tr height=23 style='mso-height-source:userset;height:17.25pt'>
                            <td rowspan=2 colspan="4"  height=117 class=xl123  style='height:87.75pt;width:111pt;' valign="top">
                            <br /><br />
                            <table width="100%" align="center">
                            <tr><td style="height:50px;" colspan="2"><b>Location</b> <br /> <input type="text" class="form-control" name="location" id="location" value="<?php echo (isset($records['location'])) ? $records['location'] : ''; ?>" placeholder="Location Here..." /></td>
                             </tr>
                            
                              <tr><td colspan="2">&nbsp;</td></tr>
                            <td style="height:50px;"><b>From</b><br />
                              <!-- <b>FROM</b><br />-->
                              <input type="text" readonly="readonly" class="form-control" name="location_time_start" id="location_time_start" style="width:225px;" value="<?php echo (isset($records['location_time_start'])) ? $records['location_time_start'] : date('d-m-Y H:i'); ?>" />                               </td>
                              
                              
                              <td style="height:50px;"><b>To</b><br />
                              
                              <input type="text" readonly="readonly" name="location_time_to" id="location_time_to" class="form-control valid" style="width:225px;" value="<?php echo (isset($records['location_time_to'])) ? $records['location_time_to'] : date('d-m-Y H:i',strtotime("+12 hours")); ?>" >                           
                              </td>       </tr>                     
                            </table>                        
                       
                            </td><td colspan=2 class=xl108 style='border-right:.5pt solid black;
  width:245pt'><b>Hazards / concerns Identified:</b></td><td align="center"> <b>YES/NO</b></td>



                                          
      <td colspan="8" class="xl198" style='border-right:.5pt solid black; border-left:none;padding:0px !important;'>               
          <table align="center" width="100%"  class="tr_heights" >
          <tr>
            <td style="width:80% !important;border-bottom:0px !important;border-right:1px solid #000;"  class="table-inner-td"><b>Precautions to be Taken:</b>    </td>
            <td style="width:20% !important;border-bottom:0px !important;border-right:0px solid #000;"  class="table-inner-td"><center>    <b>YES/NA</b>  </center>    </td>
          </tr>
        </table>
      </td> 

                            
              
                          </tr>
                                                    <tr height=26 style='mso-height-source:userset;height:19.5pt'>
                           <!--<td rowspan="3" class=xl106 width=426 style='width:59pt' valign="top">
                           <center>
                             <br/> <b>From</b>
                             <br/>
                             <br/><br/><br/>
                             <b>To</b>
                            </center></td>
                              
                            <td rowspan=3 colspan="2" height=117 class=xl111 width=83 style='border-bottom:.5pt solid black;
  height:70.5pt;border-top:none;width:65pt' valign="top"><center>
                            <br />
                              <input type="text" readonly="readonly" class="form-control" name="location_time_start" id="location_time_start" style="width:175px;" value="<?php echo (isset($records['location_time_start'])) ? $records['location_time_start'] : date('d-m-Y H:i'); ?>" />                               
                           
                              <br/>
                             
                              
                              <br />
                              
                              <input type="text" readonly="readonly" name="location_time_to" id="location_time_to" class="form-control valid" style="width:175px;" value="<?php echo (isset($records['location_time_to'])) ? $records['location_time_to'] : date('d-m-Y H:i',strtotime("+26 hours")); ?>" >
                            </center>  <br/>
                              </td>-->
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
 
  if(isset($records))
 $precautions_sub=json_decode($records['precautions_sub']);
 else
 $precautions_sub=array();

              $haz_options=array(); $pre_options=array();
              if(isset($hazards_options->a))
              {
                $haz_options=explode('|',rtrim($hazards_options->a,'|')); 
              }
              
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->a) && $hazards->a=='Yes')
              $pre_text_disabled='';
            
?>                             
                             <td colspan=2 class=xl198 style='border-right:.5pt solid black;vertical-align:top;  width:245pt'>a) <input type="checkbox" name="hazards_options[a]" data-attr="a" <?php if(in_array('Electrical shock to the personal',$haz_options)) { ?> checked="checked" <?php } ?> value="Electrical shock to the personal" class="radio_button hazards_options" /> Electrical shock to the personal <input  data-attr="a" type="checkbox" name="hazards_options[a]" class="radio_button hazards_options" value="Electrocution" <?php if(in_array('Electrocution',$haz_options)) { ?> checked="checked" <?php } ?> /> Electrocution </td>
                            <td class=xl87 width=108 style='border-top:none;vertical-align:top;border-left:none;'>
                            <center>
                            <input name="hazards[a]" data-attr="a" data-checkbox='true' <?php if(isset($hazards->a) && $hazards->a=='Yes') { ?> checked="checked" <?php } ?> type="radio"  class="radio_button hazards hazard_option" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[a]" class="radio_button hazards hazard_option" value="No" data-attr="a" data-checkbox='true' <?php if(isset($hazards->a) && $hazards->a=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</center></td>
        <td colspan=8 class=xl198 style='border-right:.5pt solid black; border-left:none;width:189pt;padding:0px !important;'>
                
                
        
        <table align="center" width="100%"  class="tr_heights" >
        <tr>
        <td style="80% !important;" class="table-inner-td">a) (i)Work area isolated by opening MCCB/ACB/SFU/VCB/AB Switch /MCB is isolated / Fuse removed locked and tagged <br />
                <input type="text" class="form-control" name="precautions_text[a]" id="precautions_text[a]" value="<?php echo (isset($precautions_text->a)) ? $precautions_text->a : ''; ?>" <?php echo $pre_text_disabled; ?> /></td>

        <td  style="width:20% !important;" class="border-bottom">
        <center>
                    <input data-attr="a" name="precautions[a]"  <?php if(isset($precautions->a) && $precautions->a=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="a" type="radio" <?php if(isset($precautions->a) && $precautions->a=='N/A') { ?> checked="checked" <?php } ?> name="precautions[a]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;
                    </center> 
        </td>
        </tr>



        
        
                <tr>
                <td class="table-inner-td">    ii) Rubber mat provided</td>
        <td class="border-bottom">  <center>                           
                                                                                   
                              <input data-attr="a" name="precautions[aii]"  <?php if(isset($precautions->aii) && $precautions->aii=='Yes') { ?> checked="checked" <?php } ?>  value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="a" type="radio" <?php if(isset($precautions->aii) && $precautions->aii=='N/A') { ?> checked="checked" <?php } ?>  name="precautions[aii]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;</center>
                            </td>
        </tr>
        
        
        <tr>
                <td class="table-inner-td">    iii) Proper elect connection, Dryness of, floor ensured</td>
        <td class="border-bottom">  <center>                           
                                                                                    
                              <input data-attr="a" name="precautions[aiii]"  <?php if(isset($precautions->aiii) && $precautions->aiii=='Yes') { ?> checked="checked" <?php } ?>  value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="a" type="radio" <?php if(isset($precautions->aiii) && $precautions->aiii=='N/A') { ?> checked="checked" <?php } ?>  name="precautions[aiii]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;</center>
                            </td>
        </tr>
        
        <tr>
                <td class="table-inner-td">    iv) Discharge using suitable discharge rods/Earthing trolleys</td>
        <td class="border-bottom">  <center> 
                              <input data-attr="a" name="precautions[aiv]"  <?php if(isset($precautions->aiv) && $precautions->aiv=='Yes') { ?> checked="checked" <?php } ?>  value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="a" type="radio" <?php if(isset($precautions->aiv) && $precautions->aiv=='N/A') { ?> checked="checked" <?php } ?>  name="precautions[aiv]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;</center>
                            </td>
        </tr>
        
        <tr>
                <td class="table-inner-td">v) Ensure proper clearness from OH line if any</td>
        <td class="border-bottom">  <center> 
                              <input data-attr="a" name="precautions[av]"  <?php if(isset($precautions->av) && $precautions->av=='Yes') { ?> checked="checked" <?php } ?>  value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="a" type="radio" <?php if(isset($precautions->av) && $precautions->av=='N/A') { ?> checked="checked" <?php } ?>  name="precautions[av]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;</center>
                            </td>
        </tr>
        
        <tr rowspan="2">
                <td class="table-inner-td" style="height:12px;border-bottom:0px solid #000 !important;">vi) Electrical hard Gloves / Tools inspected</td>
        <td style='border-left:1px solid #000 !important;'>  <center> 
                              <input data-attr="a" name="precautions[avi]"  <?php if(isset($precautions->avi) && $precautions->avi=='Yes') { ?> checked="checked" <?php } ?>  value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="a" type="radio" <?php if(isset($precautions->avi) && $precautions->avi=='N/A') { ?> checked="checked" <?php } ?>  name="precautions[avi]" class="radio_button precautions" value="N/A" />
                              N/A&nbsp;</center>
                            </td>
        </tr>
        
        </table>                                            
  </td>                           
                          </tr>
              <!-- 
                         <tr  style="border:0px;">
                            <td colspan=12></td>
                          </tr>


 <tr  style="border:0px;">
                            <td colspan=12></td>
                          </tr> -->

 <tr height=50 style='mso-height-source:userset;height:37.5pt' rowspan="2">
                            <td colspan=4 height=50 class=xl117 style='height:47.5pt;
  width:300pt'><b>Equipment name:</b>&nbsp;
                              <input  value="<?php echo (isset($records['equipment_name'])) ? $records['equipment_name'] : ''; ?>" type="text"  class="form-control" name="equipment_name" id="equipment_name" style="width:400px;" /></td>
<?php
              $haz_options=array(); $pre_options=array();
              if(isset($hazards_options->b))
              {
                $haz_options=explode('|',rtrim($hazards_options->b,'|')); 
              }
              
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->b) && $hazards->b=='Yes')
              $pre_text_disabled='';
?>                              
                                                          
                            <td colspan=2 class=xl119 style='border-right:.5pt solid black;
  width:245pt'>b) <input type="checkbox"  name="hazards_options[b]" data-attr="b" <?php if(in_array('Equipment Accidental Back Charge',$haz_options)) { ?> checked="checked" <?php } ?> value="Equipment Accidental Back Charge" class="radio_button hazards_options" /> Equipment Accidental Back Charge <input type="checkbox" name="hazards_options[b]" data-attr="b" <?php if(in_array('Interconnection available',$haz_options)) { ?> checked="checked" <?php } ?> value="Interconnection available" class="radio_button hazards_options" /> Interconnection available</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;'>
                             <center> 
                                <input data-attr="b" name="hazards[b]" value="Yes" <?php if(isset($hazards->b) && $hazards->b=='Yes') { ?> checked="checked" <?php } ?> type="radio" class="radio_button hazards hazard_option" data-checkbox='true'/>
                                Y&nbsp;
                                <input data-attr="b" type="radio" <?php if(isset($hazards->b) && $hazards->b=='No') { ?> checked="checked" <?php } ?> name="hazards[b]" class="radio_button hazards hazard_option"  value="No" data-checkbox='true'/>
                                N&nbsp;
                                </center>
                              </td>
                
                
                
        <td colspan=8 class=xl198 style='border-right:.5pt solid black; border-left:none;width:189pt;padding:0px !important;'>
          <table align="center" width="100%"  class="tr_heights" >
        <tr>
        <td  class="table-inner-td" style="width:80%  !important;border-bottom:0px solid #000 !important;">b) All possible back feeding supplies are disconnected<br />
                <input type="text" class="form-control" name="precautions_text[b]" id="precautions_text[a]" value="<?php echo (isset($precautions_text->b)) ? $precautions_text->b : ''; ?>" <?php echo $pre_text_disabled; ?> />

                </td>
        <td class="border-bottom" style="border-bottom:0px solid #000 !important;">
                          <center>
                              <input data-attr="b" name="precautions[b]" <?php if(isset($precautions->b) && $precautions->b=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="b" type="radio" name="precautions[b]" <?php if(isset($precautions->b) && $precautions->b=='N/A') { ?> checked="checked" <?php } ?> value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center>
        </td>
        </tr>
          </table></td>
                          </tr>
<?php
              
             # echo '<pre>'; print_r($records); 
              $haz_options=array(); $pre_options=array();
              if(isset($hazards_options->c))
              {
                $haz_options=explode('|',rtrim($hazards_options->c,'|')); 
              }
              
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->c) && $hazards->c=='Yes')
              $pre_text_disabled='';

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

 ?>                    <tr style='mso-height-source:userset;height:52.5pt'>
                            
              <td colspan=4  class=xl120 style='height:52.5pt; width:300pt' valign="top">
              <b>Nature of Job:</b>&nbsp;                              
                              <input type="text"  name="job_name" id="job_name" class="form-control" style="width:400px;" value="<?php echo (isset($records['job_name'])) ? $records['job_name'] : ''; ?>"/>
                              <p><b>Is EIP obtained:</b></p>
                               <input type="radio" name="is_isoloation_permit" class="radio_button on_off" data-relate='' <?php echo $yes_active; ?> value="Yes"/>
                              Yes
                              &nbsp;
                              <input type="radio" name="is_isoloation_permit" class="radio_button on_off" data-relate='' <?php echo $yes_existing_active; ?> value="yes_existing"/>
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

                    $eip_no=$fet_eip['eip_no'];
                    
                    if(array_search($eip_id,$jobs_isoloations_ids)!==FALSE)
                    {
                      $chk="selected='selected'";
                    
                    if($eip_status==STATUS_OPENED)
                    $eip_opened++;
                    }
                    else
                    $chk='';
                    
                ?>
                                <option value="<?php echo $eip_id; ?>" <?php echo $chk; ?>><?php echo $eip_section.'(#'.$eip_no.')'; ?></option>
                               <?php
                  }
                }
                ?>
                              </select>   

                                  </p>
                              </td>
                
                            <td colspan=2 class=xl115 style='width:245pt'>c) <input type="checkbox" name="hazards_options[c]" data-attr="c" <?php if(in_array('Presense of residual energy in equipment',$haz_options)) { ?> checked="checked" <?php } ?> value="Presense of residual energy in equipment" class="radio_button hazards_options" /> Presense of residual energy in equipment <input type="checkbox" name="hazards_options[c]" data-attr="c" <?php if(in_array('Capacitor',$haz_options)) { ?> checked="checked" <?php } ?> value="Capacitor" class="radio_button hazards_options" /> Capacitor <input type="checkbox" name="hazards_options[c]" data-attr="c" <?php if(in_array('Cables',$haz_options)) { ?> checked="checked" <?php } ?> value="Cables" class="radio_button hazards_options" /> Cables & Presense of Unauthorised entry into work area</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;'>
                            <center> 
                                <input data-attr="c" name="hazards[c]" value="Yes" <?php if(isset($hazards->c) && $hazards->c=='Yes') { ?> checked="checked" <?php } ?> type="radio" class="radio_button hazards hazard_option" data-checkbox="true"/>
                                Y&nbsp;
                                <input data-attr="c" type="radio" <?php if(isset($hazards->c) && $hazards->c=='No') { ?> checked="checked" <?php } ?> name="hazards[c]" class="radio_button hazards hazard_option" data-checkbox="true" value="No"/>
                                N&nbsp;
                                </center>
                              </td>
                            
                                         
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

<td colspan=8 class=xl198 style='border-right:.5pt solid black; border-left:none;width:189pt;padding:0px !important;'>
      <table align="center" width="100%"  class="tr_heights" >
        <tr>
        <td  class="table-inner-td" style="width:80%  !important;border-bottom:1px solid #000 !important;">
        c) (i) Line <input type="checkbox" name="precautions_options[c]" data-attr="c" <?php if(in_array('Line',$pre_options)) { ?> checked="checked" <?php } if($pre_c=='N/A') { ?> disabled="disabled" <?php } ?> value="Line" class="radio_button precautions_options" /> Equipment is disconnected, if required <input type="checkbox" name="precautions_options[c]" data-attr="c" <?php if(in_array('Equipment',$pre_options)) { ?> checked="checked" <?php } if($pre_c=='N/A') { ?> disabled="disabled" <?php } ?> value="Equipment" class="radio_button precautions_options" /> Earthed and earth  continuity checked <input type="checkbox" name="precautions_options[c]" data-attr="c" <?php if(in_array('Areabarricated',$pre_options)) { ?> checked="checked" <?php } if($pre_c=='N/A') { ?> disabled="disabled" <?php } ?> value="Areabarricated" class="radio_button precautions_options" /> Areabarricated
              </td>
        <td class="border-bottom" style="border-bottom:1px solid #000 !important;">
                  <center>
                              <input data-attr="c" data-checkbox="yes" name="precautions[c]" <?php if(isset($precautions->c) && $precautions->c=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="c" data-checkbox="yes" type="radio" name="precautions[c]" <?php if(isset($precautions->c) && $precautions->c=='N/A') { ?> checked="checked"  <?php } ?> value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center>
        </td>
        </tr>
        <tr>
        <td  class="table-inner-td" style="width:189pt !important;border-bottom:1px solid #000 !important;">
<?php
              if(isset($precautions_options->cii))
              {
                $pre_options=explode('|',rtrim($precautions_options->cii,'|')); 
              }

              $pre_c=(isset($precautions->cii)) ? $precautions->cii : '';
?>
        ii) <input type="checkbox" name="precautions_options[cii]" data-attr="cii" <?php if(in_array('Danger',$pre_options)) { ?> checked="checked" <?php } if($pre_c=='N/A') { ?> disabled="disabled" <?php } ?> value="Danger" class="radio_button precautions_options" /> Danger Board <input type="checkbox" name="precautions_options[cii]" data-attr="cii" <?php if(in_array('Safety',$pre_options)) { ?> checked="checked" <?php } if($pre_c=='N/A') { ?> disabled="disabled" <?php } ?> value="Safety" class="radio_button precautions_options" /> Safety tag displayed.
        
        </td>
      
        <td class="border-bottom" style="border-bottom:1px solid #000 !important;">
                            <center>
                              <input data-attr="cii" data-checkbox="yes" name="precautions[cii]" <?php if(isset($precautions->cii) && $precautions->cii=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="cii" data-checkbox="yes" type="radio" name="precautions[cii]" <?php if(isset($precautions->cii) && $precautions->cii=='N/A') { ?> checked="checked" <?php } ?>   value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center>
        </td>
        </tr>
        
<?php
              if(isset($precautions_options->ciii))
              {
                $pre_options=explode('|',rtrim($precautions_options->ciii,'|')); 
              }

              $pre_c=(isset($precautions->ciii)) ? $precautions->ciii : '';
?>        
        <tr>
        <td  class="table-inner-td" style="width:189pt !important;border-bottom:0px solid #000 !important;">
        iii) <input type="checkbox" name="precautions_options[ciii]" data-attr="ciii" <?php if(in_array('wait',$pre_options)) { ?> checked="checked" <?php } if($pre_c=='N/A') { ?> disabled="disabled" <?php } ?> value="wait" class="radio_button precautions_options" /> Wait for 1Minute after switching off the Power supply and Ensure Capacitors were discharged by using proper discharge rod <input type="checkbox" name="precautions_options[ciii]" data-attr="ciii" <?php if(in_array('Earthing',$pre_options)) { ?> checked="checked" <?php } if($pre_c=='N/A') { ?> disabled="disabled" <?php } ?> value="Earthing" class="radio_button precautions_options" /> Earthing trolleys.
        
        </td>
      
        <td class="border-bottom" style="border-bottom:0px solid #000 !important;">
                  <center>
                              <input data-attr="ciii" data-checkbox="yes" name="precautions[ciii]" <?php if(isset($precautions->ciii) && $precautions->ciii=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="ciii" data-checkbox="yes" type="radio" name="precautions[ciii]" <?php if(isset($precautions->ciii) && $precautions->ciii=='N/A') { ?> checked="checked" <?php } ?>  data-checkbox="true"  value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center>
        </td>
        </tr>       
          </table>        
          </td>
          </tr>         
        
                
                          <tr height=73 style='mso-height-source:userset;height:54.75pt'>
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
                              <input type="text"  value="<?php echo $other_contractors; ?>" name="other_contractors" id="other_contractors" class="form-control" style="width:200px;margin-bottom:10px;<?php if($other_contractors=='') { ?>display:none;<?php } ?>"  /></td>
                              
                              </td>
                            <td colspan=2 valign="top"  class=xl139 style='border-right:1.0pt solid black; border-bottom:1.0pt solid black;width:130pt'><b>No of Persons involved</b>&nbsp;
                              <input type="text"  value="<?php echo (isset($records['contractors_involved'])) ? $records['contractors_involved'] : ''; ?>" name="contractors_involved" id="contractors_involved" class="form-control numinput" style="width:130px;" /></td>

<?php
              $haz_options=array(); $pre_options=array();
              if(isset($hazards_options->d))
              {
                $haz_options=explode('|',rtrim($hazards_options->d,'|')); 
              }
              
              $pre_text_disabled='disabled="disabled"';

              if(isset($hazards->d) && $hazards->d=='Yes')
              $pre_text_disabled='';
?>                           
                                  
                            <td colspan=2 class=xl115 style='width:245pt'>d) <input type="checkbox" name="hazards_options[d]" data-attr="d" <?php if(in_array('Electrical',$haz_options)) { ?> checked="checked" <?php } ?> value="Electrical" class="radio_button hazards_options" /> Electrical Fire while racking out <input type="checkbox" name="hazards_options[d]" data-attr="d" <?php if(in_array('breaker',$haz_options)) { ?> checked="checked" <?php } ?> value="breaker" class="radio_button hazards_options" /> in of breaker <input type="checkbox" name="hazards_options[d]" data-attr="d" <?php if(in_array('mcc',$haz_options)) { ?> checked="checked" <?php } ?> value="mcc" class="radio_button hazards_options" /> MCC Feeder Module</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;'>

                             <center> 
                                <input data-attr="d" name="hazards[d]" value="Yes" <?php if(isset($hazards->d) && $hazards->d=='Yes') { ?> checked="checked" <?php } ?> type="radio" class="radio_button hazards hazard_option" data-checkbox="true" />
                                Y&nbsp;
                                <input data-attr="d" type="radio" <?php if(isset($hazards->d) && $hazards->d=='No') { ?> checked="checked" <?php } ?> name="hazards[d]" class="radio_button hazards hazard_option" data-checkbox="true"  value="No"/>
                                N&nbsp;
                                </center>
                              </td>
                              </td>
                            
                
                
                
        <td colspan=8 class=xl198 style='border-right:.5pt solid black; border-left:none;width:189pt;padding:0px !important;'>
                
          <table align="center" width="100%"  class="tr_heights" >
            <tr>
              <td  class="table-inner-td" style="width:80%  !important;border-bottom:1px solid #000 !important;">
                d) i) Using suitable fire suit & SOP  </td>     
              <td class="border-bottom" style="border-bottom:1px solid #000 !important;">
                            <center>
                              <input data-attr="d" name="precautions[d]" <?php if(isset($precautions->d) && $precautions->d=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="d" type="radio" name="precautions[d]" <?php if(isset($precautions->d) && $precautions->d=='N/A') { ?> checked="checked" <?php } ?> value="N/A" class="radio_button precautions" />
                              N/A&nbsp;
                            </center>
              </td>
            </tr>
            
            <tr>
              <td  class="table-inner-td" style="width:189pt !important;border-bottom:0px solid #000 !important;">
                ii) Ensure nearby Eyewash towers are working properly
              </td>     
              <td class="border-bottom" style="border-bottom:0px solid #000 !important;">
                <center>
                                <input data-attr="dii" name="precautions[dii]" <?php if(isset($precautions->dii) && $precautions->dii=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                                Y&nbsp;
                                <input data-attr="dii" type="radio" name="precautions[dii]" <?php if(isset($precautions->dii) && $precautions->dii=='N/A') { ?> checked="checked" <?php } ?> value="N/A" class="radio_button precautions" />
                                N/A&nbsp;
                 </center>
              </td>
            </tr>
          </table>
        </td> 
      </tr>
                          <tr height=61 style='mso-height-source:userset;height:45.75pt'>
<?php $height_work_involved=(isset($records['height_works_involved'])) ? $records['height_works_involved'] : ''; ?>
                            <td colspan=4 height=61 class=xl136 style='border-right:1.0pt solid black;
  height:45.75pt;width:300pt'>If Electrical works involved are at height, work at height permit no :                              
                                <select class="form-control select2"  name="height_works_involved" id="height_works_involved" >
                                <option value="" selected>- - Select - -</option>
                              <?php
                if($height_works->num_rows()>0)
                {
                  $fet_height_works=$height_works->result_array();
                  
                  foreach($fet_height_works as $fet_height_work)
                  {
                    $height_work_id=$fet_height_work['id'];

                    $height_work_no=$fet_height_work['permit_no'];

                    $height_work_location = $fet_height_work['location'];
                    
                    if($height_work_no==$height_work_involved)
                    $chk="selected='selected'";                   
                    else
                    $chk='';
                    
                ?>
                   <option value="<?php echo $height_work_no; ?>" <?php echo $chk; ?>><?php echo strtoupper($height_work_location.' (#'.$height_work_no.')'); ?></option>
                               <?php
                  }
                }
                ?>
                              </select>   


                              </td>
                            <td colspan=2 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:245pt'>e)Fire during work activity</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;'>

                                <center> 
                                <input data-attr="e" name="hazards[e]" value="Yes" <?php if(isset($hazards->e) && $hazards->e=='Yes') { ?> checked="checked" <?php } ?> type="radio" class="radio_button hazards" />
                                Y&nbsp;
                                <input data-attr="e" type="radio" <?php if(isset($hazards->e) && $hazards->e=='No') { ?> checked="checked" <?php } ?> name="hazards[e]" class="radio_button hazards"  value="No"/>
                                N&nbsp;
                                </center>
                              </td>
<?php
              if(isset($precautions_options->e))
              {
                $pre_options=explode('|',rtrim($precautions_options->e,'|')); 
              }

              $pre_c=(isset($precautions->e)) ? $precautions->e : '';
?>                  
        <td colspan=8 class=xl198 style='border-right:.5pt solid black; border-left:none;width:189pt;padding:0px !important;'>
                
          <table align="center" width="100%"  class="tr_heights" >
            <tr>
              <td  class="table-inner-td" style="width:80%  !important;border-bottom:1px solid #000 !important;">
                e) i) <input type="checkbox" name="precautions_options[e]" data-attr="e" 
                <?php if(in_array('Availability',$pre_options)) { ?> checked="checked" <?php }  if($pre_c=='N/A') { ?> disabled="disabled" <?php } ?> value="Availability" class="radio_button precautions_options" /> Availability of fire extinguisher 
                <input type="checkbox" name="precautions_options[e]" data-attr="e" 
                <?php if(in_array('Tender',$pre_options)) { ?> checked="checked" <?php }  if($pre_c=='N/A') { ?> disabled="disabled" <?php } ?> value="Tender" class="radio_button precautions_options" /> Tender Ensuired
              </td>     
              <td class="border-bottom" style="border-bottom:1px solid #000 !important;">
                  <center>
                                <input data-attr="e" name="precautions[e]" <?php if(isset($precautions->e) && $precautions->e=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                                Y&nbsp;
                                <input data-attr="e" type="radio" name="precautions[e]" <?php if(isset($precautions->e) && $precautions->e=='N/A') { ?> checked="checked" <?php } ?> value="N/A" class="radio_button precautions" />
                                N/A&nbsp;
                 </center>
              </td>
            </tr>
            
            <tr>
              <td  class="table-inner-td" style="width:189pt !important;border-bottom:0px solid #000 !important;">
                ii) Ensure nearby water line to suppress the fire
              </td>     
              <td class="border-bottom" style="border-bottom:0px solid #000 !important;">
             <center>
                                <input data-attr="eii" name="precautions[eii]" <?php if(isset($precautions->eii) && $precautions->eii=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                                Y&nbsp;
                                <input data-attr="eii" type="radio" name="precautions[eii]" <?php if(isset($precautions->eii) && $precautions->eii=='N/A') { ?> checked="checked" <?php } ?> value="N/A" class="radio_button precautions" />
                                N/A&nbsp;
                 </center>
              </td>
            </tr>
          </table>
        </td>         
      </tr>         
                
        
                          <tr height=40 style='mso-height-source:userset;height:50.0pt'>

                              <td colspan=4 height=61 class=xl136 style='border-right:1.0pt solid black;
  height:45.75pt;width:300pt'>If Electrical works involved are at Confined space, confined space no :
                                <input type="text" value="<?php echo (isset($records['confined_space_involved'])) ? $records['confined_space_involved'] : ''; ?>" name="confined_space_involved" id="confined_space_involved" class="form-control" style="width:400px;">
                              </td>


                            <td colspan=2 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:245pt'>f) Poor illumination in night <br /><br />
                                g) Poor Ventilation
      

   </td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;'>


                             <center> 
                                <input data-attr="f" name="hazards[f]" value="Yes" <?php if(isset($hazards->f) && $hazards->f=='Yes') { ?> checked="checked" <?php } ?> type="radio" class="radio_button hazards" />
                                Y&nbsp;
                                <input data-attr="f" type="radio" <?php if(isset($hazards->f) && $hazards->f=='No') { ?> checked="checked" <?php } ?> name="hazards[f]" class="radio_button hazards"  value="No"/>
                                N&nbsp;
                                </center> <br /><br />

                                 <center> 
                                <input data-attr="g" name="hazards[g]" value="Yes" <?php if(isset($hazards->g) && $hazards->g=='Yes') { ?> checked="checked" <?php } ?> type="radio" class="radio_button hazards" />
                                Y&nbsp;
                                <input data-attr="g" type="radio" <?php if(isset($hazards->g) && $hazards->g=='No') { ?> checked="checked" <?php } ?> name="hazards[g]" class="radio_button hazards"  value="No"/>
                                N&nbsp;
                                </center>

                              </td>
                
        <td colspan=8 class=xl198 style='border-right:.5pt solid black; border-left:none;width:189pt;padding:0px !important;'>
                
          <table align="center" width="100%"  class="tr_heights" >
            <tr>
              <td  class="table-inner-td" style="width:80%  !important;border-bottom:1px solid #000 !important;">
                f) Adequate illumination provided
              </td>     
              <td class="border-bottom" style="border-bottom:1px solid #000 !important;">
                   <center>
                                <input data-attr="f" name="precautions[f]" <?php if(isset($precautions->f) && $precautions->f=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                                Y&nbsp;
                                <input data-attr="f" type="radio" name="precautions[f]" <?php if(isset($precautions->f) && $precautions->f=='N/A') { ?> checked="checked" <?php } ?> value="N/A" class="radio_button precautions" />
                                N/A&nbsp;
                 </center>
              </td>
            </tr>
            
            <tr>
              <td  class="table-inner-td" style="width:189pt !important;border-bottom:0px solid #000 !important;">
                g) Proper ventilation facilities provided
              </td>     
              <td class="border-bottom" style="border-bottom:0px solid #000 !important;">
              <center>
                                <input data-attr="g" name="precautions[g]" <?php if(isset($precautions->g) && $precautions->g=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                                Y&nbsp;
                                <input data-attr="g" type="radio" name="precautions[g]" <?php if(isset($precautions->g) && $precautions->g=='N/A') { ?> checked="checked" <?php } ?> value="N/A" class="radio_button precautions" />
                                N/A&nbsp;
                 </center>
              </td>
            </tr>
          </table>
        </td>   
            </tr>
      
              <tr height=21 style='height:15.75pt'>
                         
                              <td colspan=4 height=61 class=xl136 style='border-right:1.0pt solid black;
  height:45.75pt;width:300pt'>
   <?php
   $other_inputs=(isset($records['other_inputs'])) ? explode(',',rtrim($records['other_inputs'],',')) : array(); $display='none;';
  ?>  
   <?php
   $other_inputs=(isset($records['other_inputs'])) ? explode(',',rtrim($records['other_inputs'],',')) : array(); $display='none;';

   $selected_file_path=''; 
   if($sops->num_rows()>0 && !in_array('SOP',$other_inputs))
   {
        $sops=$sops->result_array();

        $sel_sop=(isset($records['sop'])) ? $records['sop'] : '';

        echo '<b>SOP</b><br /><select class="form-control select3" name="sop" id="sop" data-target="show_sop" ><option value="" data-desc=""> - - Select SOP - - </option>';

        foreach($sops as $sop):

              $sel='';

             $desc=$sop['sl_no'].' '.$sop['description'];

             $path=$sop['file_name'];

             if($sop['id']==$sel_sop)
             {
                $selected_file_path=$path;
                $sel='selected="selected"';
             } 

          echo '<option value="'.$sop['id'].'" data-desc="'.$path.'" '.$sel.'>'.$desc.'</option>';

        endforeach;  

       
        echo '</select> <br />';

         $tx='';
        if($sel_sop!='')
        {

          $sel_sop=$selected_file_path;
          $tx=base_url().'uploads/sops_wi/'.$sel_sop;

          $tx='<a href="javascript:void(0);" class="show_image" title="View Description" data-src="'.$tx.'" data-toggle="modal" data-target="#show_records_modal">Show Desc</a>';
        }  

        echo '<span id="show_sop" style="padding-left:165px;">'.$tx.'</span>';
   }
   else
   {  
  ?>  
   <input type="checkbox" <?php if(in_array('SOP',$other_inputs)) { ?> checked="checked" <?php } ?> name="other_inputs[]" class="other_inputs" value="SOP"  /> SOP
   <?php
 }
 ?>

    <br /> 
    <?php
    $selected_file_path=''; 
    if($wis->num_rows()>0 && !in_array('Work instructions clearly explained to the all the members',$other_inputs))
   {
        $wis=$wis->result_array();

        $work_instruction=(isset($records['work_instruction'])) ? $records['work_instruction'] : '';

        echo '<b>Work Instruction</b><br /><select class="form-control select3" name="work_instruction" id="work_instruction" data-target="show_wi" ><option value="" data-desc=""> - - Select Work Instruction - - </option>';

        foreach($wis as $wi):

             $sel='';

             $desc=$wi['sl_no'].' '.$wi['description'];

             $path=$wi['file_name'];

              if($wi['id']==$work_instruction)
              $sel='selected="selected"';

          echo '<option value="'.$wi['id'].'" '.$sel.' data-desc="'.$path.'">'.$desc.'</option>';

        endforeach;  

        echo '</select> <br />';

         $tx='';
        if($work_instruction!='')
        {

          $work_instruction=$selected_file_path;
          $tx=base_url().'uploads/sops_wi/'.$work_instruction;

          $tx='<a href="javascript:void(0);" class="show_image" title="View Description" data-src="'.$tx.'" data-toggle="modal" data-target="#show_records_modal">Show Desc</a>';
        }  


        echo '<span id="show_wi" style="padding-left:165px;">'.$tx.'</span>';
   }
   else
   {
   ?>
   <input class="other_inputs"  name="other_inputs[]" <?php if(in_array('Work instructions clearly explained to the all the members',$other_inputs)) { ?> checked="checked" <?php } ?> value="Work instructions clearly explained to the all the members"  type="checkbox" /> Work instructions clearly explained to the all the <br />members in the working Group <?php } ?> <br />


   <input type="checkbox" <?php if(in_array('Peptalk',$other_inputs)) { $display='block'; ?> checked="checked" <?php } ?>  name="other_inputs[]" class="other_inputs peptalk" value="Peptalk"  /> Peptalk  
      <span id="peptalk" style="display:<?php echo $display; ?>">
        <input type="text" class="form-control peptalk_text" name="other_inputs_text" value="<?php echo (isset($records['other_inputs_text'])) ? $records['other_inputs_text'] : ''; ?>" style="margin-bottom: 3px;"/>
      </span>
                              </td>
                            <td colspan=2 class=xl166 style='border-right:.5pt solid black;
  width:245pt'>h) NDT Equipment are used (Megger/Multimeter, etc.)

  </td>
  <td class=xl95 width=108 style='border-top:none;border-left:none;'>


                           <center> 
                                <input data-attr="h" name="hazards[h]" value="Yes" <?php if(isset($hazards->h) && $hazards->h=='Yes') { ?> checked="checked" <?php } ?> type="radio" class="radio_button hazards" />
                                Y&nbsp;
                                <input data-attr="h" type="radio" <?php if(isset($hazards->h) && $hazards->h=='No') { ?> checked="checked" <?php } ?> name="hazards[h]" class="radio_button hazards"  value="No"/>
                                N&nbsp;
                                </center>


                              </td>
                
                
        <td colspan=8 class=xl198 style='border-right:.5pt solid black; border-left:none;width:189pt;padding:0px !important;'>
                
          <table align="center" width="100%"  class="tr_heights" >
            <tr>
              <td  class="table-inner-td" style="width:80%  !important;border-bottom:1px solid #000 !important;">
                h) i) Having valid calibration certificate
              </td>     
              <td class="border-bottom" style="border-bottom:1px solid #000 !important;">
               <center>
                                <input data-attr="h" name="precautions[h]" <?php if(isset($precautions->h) && $precautions->h=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                                Y&nbsp;
                                <input data-attr="h" type="radio" name="precautions[h]" <?php if(isset($precautions->h) && $precautions->h=='N/A') { ?> checked="checked" <?php } ?> value="N/A" class="radio_button precautions" />
                                N/A&nbsp;
                 </center>
              </td>
            </tr>
            
            <tr>
              <td  class="table-inner-td" style="width:189pt !important;border-bottom:0px solid #000 !important;">
                ii) By using standard / quality probes
              </td>     
              <td class="border-bottom" style="border-bottom:0px solid #000 !important;">
               <center>
                                <input data-attr="hii" name="precautions[hii]" <?php if(isset($precautions->hii) && $precautions->hii=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                                Y&nbsp;
                                <input data-attr="hii" type="radio" name="precautions[hii]" <?php if(isset($precautions->hii) && $precautions->hii=='N/A') { ?> checked="checked" <?php } ?> value="N/A" class="radio_button precautions" />
                                N/A&nbsp;
                 </center>
              </td>
            </tr>
          </table>
        </td>   
            </tr>

<tr height=21 style='height:15.75pt'>
                         
                              <td colspan=4 height=61 class=xl136 style='border-right:1.0pt solid black;
  height:45.75pt;width:300pt'>
                              </td>
                            <td colspan=4 valign="top" class=xl166 style='border-right:.5pt solid black; width:245pt;padding:5px !important;'> i) Others
                            <input type="text" name="hazards_other" id="hazards_other" class="form-control" width="100px" value="<?php echo (isset($records['hazards_other'])) ? $records['hazards_other'] : ''; ?>" />
        <!-- <table align="center" class="tr_heights" width="100%">
            <tr ><td class="border-bottom" style="width:326px !important;border-right:1px solid #000;height:40px !important;">i) Other special precautions, if any</td>

                <td class="border-bottom" style="border-left:1px solid #000 !important;">
                    <input data-attr="i" type="radio" class="radio_button hazards "  name="hazards[i]" data-checkbox="true" value="Yes"  />
                    Y&nbsp;
                    <input data-attr="i"  name="hazards[i]" type="radio"  class="radio_button hazards " value="No" data-checkbox="true" />
                    N&nbsp; </td</tr>
          <tr><td style="border-right:1px solid #000;height:40px !important;">Is Energy Isolation Permit obtained ? </td>
             <td style="border-left:1px solid #000 !important;">
                  <input data-attr="j" type="radio" class="radio_button hazards "  name="hazards[j]" data-checkbox="true" value="Yes"  />
                  Y&nbsp;
                  <input data-attr="j"  name="hazards[j]" type="radio"  class="radio_button hazards " value="No" data-checkbox="true" />
                  N&nbsp; </td>
          </tr> </table>-->

  </td>
                
  <td colspan=8 valign="top" class=xl198 style='border-right:.5pt solid black; border-left:none;width:335px;padding:5px !important;'> i) Others
  <input type="text" class="form-control" name="precautions_other" id="precautions_other" width="100px" value="<?php echo (isset($records['precautions_other'])) ? $records['precautions_other'] : ''; ?>" />
         <!--  <table align="center" width="100%"  class="tr_heights">
            <tr>
              <td  class="table-inner-td" style="width:189pt !important;border-right:px solid #000 !important;">
                i) EIP No
              </td>     
              <td class="border-bottom" style="border-bottom:1px solid #000 !important;">
              <center>
                <input type="text" class="form-control" />
              </center> 
              </td>
            </tr>
            
            <tr>
              <td  class="table-inner-td" style="width:189pt !important;border-bottom:0px solid #000 !important;">
                Issued by name
              </td>     
              <td class="border-bottom" style="border-bottom:0px solid #000 !important;">
              <center>
                <select class="form-control"><option>Select IA</option></select>
              </center> 
              </td>
            </tr> 
          </table>-->
        </td>   
            </tr>                          
             
                          <tr height=22 style='mso-height-source:userset;height:16.5pt'>
                            <td colspan=4 height=22 class=xl125 style='border-right:1.0pt solid black;
  height:16.5pt;width:235pt'><center>
                              <b>Required PPE</b>
                            </center></td>
                            <td colspan=4 rowspan=7 style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'><p><b>Authorisation & Acceptance: </b></p>
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


                                </span> <span style="float:right;">Digital Sign/Date & Time <br />
                                  <input type="text" style="width:150px;" value="<?php echo (isset($records['acceptance_performing_date'])) ? $records['acceptance_performing_date'] : ''; ?>" id="acceptance_performing_date" name="acceptance_performing_date" class="form-control" readonly="readonly" />
                                </span></p>
                              <br />
                              <br />
                              <br />
                              <br />
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
<?php  $acceptance_issuing_date=(isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : ''; 
                
                $acceptance_issuing_approval=(isset($records['acceptance_issuing_approval'])) ? $records['acceptance_issuing_approval'] : ''; 

                $show_name_of_ia='disabled="disabled"';
                
                $acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : ''; 
                
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
                                </span> 
                                                                <span style="float:right;">Digital Sign/Date & Time
                                 <input value="<?php echo $acceptance_issuing_date; ?>" type="text" id="acceptance_issuing_date" style="width:150px;" name="acceptance_issuing_date" class="form-control" readonly="readonly" />
                                </span></p>
                              <br />
                              <br />
                              <br />
                              <br /><p><span style="float:left;"><b>Name of IA:</b><br /> 

                                    <input type="text" <?php echo $show_name_of_ia; ?> name="acceptance_name_of_ia" id="acceptance_name_of_ia" class="form-control" value="<?php echo (isset($records['acceptance_name_of_ia'])) ? $records['acceptance_name_of_ia'] : ''; ?>"/>
                                  </span>
                                </p>
                              <br />
                              <br /> <br /></td>
<?php
               $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';
               
               $st=(isset($records['status'])) ? $records['status'] : '';


                
                $work_msg='<span id="change_status_label">Completion / Cancellation</span>';
                
                
                if($st=='Completion' || $st == 'Cancellation')
                $work_msg=$st;
                
               ?>                              
                            <td colspan=8 rowspan=7 valign="top" style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'>


                                                        <p><b>Work <?php echo $work_msg ?>: </b></p>
                              <p><b>Performing Authority: </b></p>
                              <p>Work completed, all persons are withdrawn and material removed from the area.</p>
                              <p>&nbsp;</p>
                              <p style="margin-top:-31px;"><span style="float:left;">Name:<br />
                                              
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
   ?></select>
                                </span> <span style="float:right;">Digital Sign/Date & Time <br />
                                  <input type="text" value="<?php echo (isset($records['cancellation_performing_date'])) ? $records['cancellation_performing_date'] : ''; ?>" id="cancellation_performing_date" style="width:140px;"  name="cancellation_performing_date" class="form-control datepicker" />
                                </span></p>
                              <br />
                              <br />
                              <br />
                              <br />
                              <p><b>Issuing Authority: </b></p>
                              <p>I have inspected the work area and declare the work for which the permit was issued has been properly.</p>
                              <p>&nbsp;</p>
                             
                              <p style="margin-top:-10px;"><span style="float:left;">Name: <br />
                                                
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
                                
                                
                                 <span style="float:right;">Digital Sign/Date & Time <br />
                                  <input type="text" value="<?php echo $cancellation_issuing_date; ?>" id="cancellation_issuing_date" style="width:140px;" name="cancellation_issuing_date" class="form-control datepicker" />
                                </span></p>
                              <br /> <br /> <br />
                              <br /> <p><span style="float:left;"><b>Name of IA:</b><br /> 
                                    <input type="text" <?php echo $show_name_of_ia; ?> name="cancellation_name_of_ia" id="cancellation_name_of_ia" class="form-control" value="<?php echo (isset($records['cancellation_name_of_ia'])) ? $records['cancellation_name_of_ia'] : ''; ?>"/>
                                  </span>
                                </p>
                              <br />
                              <br /> <br /></td>
                          </tr>
<?php
  if(isset($records))
  $required_ppe=explode(',',rtrim($records['required_ppe'],','));
  else
  $required_ppe=array();

  ?>                          
                          <tr height=35 style='mso-height-source:userset;height:26.25pt'>
                            <td height=35 width=831 colspan="2" style='height:26.25pt;width:111pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                                                            <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=35 class=xl76 width=148 colspan="3" style='height:26.25pt;border-top:none;
    width:130pt'><span style='mso-spacerun:yes'> </span>Helmet<span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" class="required_ppe" checked="checked"  disabled="disabled"  value="Helmet" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                            <td colspan=2 height=35 style='  height:26.25pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=3  height=35 class=xl148 width=165 style='
    height:26.25pt;border-left:none;width:124pt'>Insulted ladder <span class="float_right">
                                    <input type="checkbox" <?php if(in_array('Insulted ladder',$required_ppe)) { ?> checked="checked" <?php } ?> name="required_ppe[]"  class="required_ppe" value="Insulted ladder" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=38 style='mso-height-source:userset;height:28.5pt'>
                            <td height=38 width=831 colspan="2" style='height:28.5pt;width:130pt' align=left
  valign=top><table cellpadding=0 cellspacing=0>
                              <tr>
                                <td height=38 class=xl76 width=148 style='height:28.5pt;border-top:none;
    width:130pt'>Electrical gloves 440/17KV<span
    style='mso-spacerun:yes'><span class="float_right">
                                  <input type="checkbox" name="required_ppe[]" <?php if(in_array('Electrical',$required_ppe)) { ?> checked="checked" <?php } ?>  class="required_ppe" value="Electrical" />
                                </span></span></td>
                              </tr>
                            </table></td>
                            <td colspan=2 height=38 style='border-right:1.0pt solid black;
  height:28.5pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=38 class=xl148 width=165 style='height:28.5pt;border-left:none;width:124pt'>Fullbody Harness <span class="float_right">
                                    <input  type="checkbox" name="required_ppe[]" <?php if(in_array('Fullbody',$required_ppe)) { ?> checked="checked" <?php } ?> class="required_ppe" value="Fullbody" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=41 style='mso-height-source:userset;height:30.75pt'>
                            <td height=41 width=831 style='height:30.75pt;width:130pt' align=left
  valign=top colspan="2"><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=41 class=xl76 width=148 style='height:30.75pt;border-top:none;
    width:130pt'>Fuse Puller<span style='mso-spacerun:yes'><span class="float_right">
                                    <input type="checkbox" name="required_ppe[]"  <?php if(in_array('Fuse Puller',$required_ppe)) { ?> checked="checked" <?php } ?>   class="required_ppe" value="Fuse Puller" />
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
    height:30.75pt;border-left:none;width:124pt'>Clamp/Multi Meter/Meggar <span class="float_right">
                                    <input name="required_ppe[]"   <?php if(in_array('Clamp',$required_ppe)) { ?> checked="checked" <?php } ?>  class="required_ppe" value="Clamp" type="checkbox" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=36 style='mso-height-source:userset;height:27.0pt'>
                            <td height=36 colspan="2" width=831 style='height:27.0pt;width:130pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=36 class=xl76 width=148 style='height:27.0pt;border-top:none;
    width:130pt'>Insulated Safety Shoes<span style='mso-spacerun:yes'><span class="float_right">
                                    <input value="Safety Shoes" name="required_ppe[]"  disabled="disabled" checked="checked"    class="required_ppe" type="checkbox" />
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
    height:27.0pt;border-left:none;width:124pt'>Fire Proof sult <span class="float_right">
                                    <input name="required_ppe[]"  <?php if(in_array('Fire',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Fire" type="checkbox" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=47 style='mso-height-source:userset;height:35.25pt'>
                            <td height=47 colspan="2" width=831 style='height:35.25pt;width:130pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=47 class=xl77 width=148 style='height:35.25pt;border-top:none;
    width:130pt'>Goggles <span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" disabled="disabled" checked="checked"    class="required_ppe" value="Goggles" />
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
    height:35.25pt;border-left:none;width:124pt'>Earthing trolleys<span class="float_right">
                                    <input name="required_ppe[]"  disabled="disabled" checked="checked"   class="required_ppe" value="Earthing trolleys" type="checkbox" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=47 style='mso-height-source:userset;height:35.25pt'>
                            <td height=47 colspan="2" width=831 style='height:35.25pt;width:130pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=47 class=xl77 width=148 style='height:35.25pt;border-top:none;
    width:130pt'>Others <span class="float_right">
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
              <td colspan="12"><span id="self_cancellation_section" style="display:<?php echo $display_style; ?>;">Reason for cancellation <br /> <input type="text" value="<?php echo $self_cancellation_description; ?>" name="self_cancellation_description" id="self_cancellation_description" class="form-control" style="width:400px;"></span></td>
              
             </tr>
          <?php 
       }
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
  width:111pt' valign="top">Name of the Contractor</td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;border-left:none;width:124pt'>
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
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;border-left:none;width:126pt'>
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
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;border-left:none;width:117pt'>

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
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;border-left:none;width:122pt'>

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
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;border-left:none;width:173pt'>


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
                            <td width="213" colspan=5 class=xl177 style='border-right:1.0pt solid black; border-left:none;width:163pt'>

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
  border-left:none;width:124pt'><input type="text" value="<?php echo (isset($no_of_persons->a)) ? $no_of_persons->a : ''; ?>" name="no_of_persons[a]"  class="no_of_persons form-control numinput" style="width: 167px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:126pt'><input type="text" value="<?php echo (isset($no_of_persons->b)) ? $no_of_persons->b : ''; ?>" name="no_of_persons[b]"  class="no_of_persons form-control numinput" style="width: 167px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:117pt'><input type="text" value="<?php echo (isset($no_of_persons->c)) ? $no_of_persons->c : ''; ?>" name="no_of_persons[c]"  class="no_of_persons form-control numinput" style="width: 167px;" /></td>
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><input type="text" value="<?php echo (isset($no_of_persons->d)) ? $no_of_persons->d : ''; ?>" name="no_of_persons[d]"  class="no_of_persons form-control numinput" style="width: 167px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:173pt'><input type="text" value="<?php echo (isset($no_of_persons->e)) ? $no_of_persons->e : ''; ?>" name="no_of_persons[e]"  class="no_of_persons form-control numinput" style="width: 120px;" /></td>
                            <td width="213" colspan=5 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:163pt'><input type="text" value="<?php echo (isset($no_of_persons->f)) ? $no_of_persons->f : ''; ?>" name="no_of_persons[f]"  class="no_of_persons form-control numinput" style="width: 120px;" /></td>
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

<select id="performing_authority[e]" name="performing_authority[e]"  class="performing_authority form-control authority performing" style="width: 120px;">
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

  <select id="performing_authority[f]" name="performing_authority[f]"  class="performing_authority form-control authority performing" style="width: 120px;">
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
  
  <select id="issuing_authority[e]" name="issuing_authority[e]"  class="issuing_authority form-control authority issuing" style="width: 120px;">
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
  
  <select id="issuing_authority[f]" name="issuing_authority[f]"  class="issuing_authority form-control authority issuing" style="width: 120px;">
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
                        <b> <?php echo EMERGENCY_CONTACT_NUMBER; ?> 
</b>
 
                          </td></tr>
                          
                        </table>
                        <div>&nbsp;</div>
                        <input type="hidden" id="show_button" name="show_button" />
            <?php
            $is_show_button=(isset($records['show_button'])) ? $records['show_button'] : 'show';
            
            $is_popup_submit=$is_extended=$is_show_extended_button=0;

            $is_draft=(isset($records['is_draft'])) ? $records['is_draft'] : NO;

            $draft_user_id=(isset($records['draft_user_id'])) ? $records['draft_user_id'] : '';
            
            $show_extend_field=-01;
            
            $show_flag=2;

            $redirect=$ext_name_of_ia=$ext_range=$cancel_ia='';

            $submit_value='show'; $show_draft=0;

            $draft=NO;

            if($is_draft==YES && $user_id!=$draft_user_id)
              $draft=YES;


            #echo '<br /> S : '.$is_show_button.' = '.$show_flag.' - '.$approval_status;
            
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
                        

                          if($eip_opened==count($jobs_isoloations_ids))
                          {
                            $submit_value='hide';

                            echo '<button class="btn btn-sm btn-primary show_button" id="submit" value="hide" type="submit"><i class="fa fa-dot-circle-o"></i> Final Submit</button>';
                          }  
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

                          #echo '<pre>'; print_r($issuing_authority); exit;
                      
                      #for($r=0;$r<count($range);$r++) 
                         $r=0;
                       foreach($range as $key => $rr)
                      {
                        
                         #echo '<br /> A '.$performing_authority[$r].' - == '.$user_id.' && '. $issuing_authority_approval_status[$r]; exit;
                        
                        if($issuing_authority[$rr]==$user_id && $issuing_authority_approval_status[$rr]!='Approved')
                        {
                          $is_extended=1; $is_show_extended_button=1;  if($permission==READ)
                                                                        { $ext_range=$rr; $ext_name_of_ia=$issuing_authority[$rr]; }
                          $submit_value='hides';                                              
                          echo '<button class="btn btn-sm btn-primary show_button"  id="submit" value="hides" type="submit"><i class="fa fa-dot-circle-o"></i> Approve '.$status.' & Submit</button>';  
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
                        $show_flag=2;

                        $submit_value='show';

                        echo '<button class="btn btn-sm btn-primary show_button" id="submit" value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>'; }
                    else if(in_array($user_id,array($cancellation_issuing_id)) && in_array($approval_status,array(3,5)))
                    {
                          if($permission==READ)
                          $cancel_ia=1;

                        $submit_value='show';

                          echo '<button class="btn btn-sm btn-primary show_button" id="submit" value="show" type="submit"><i class="fa fa-dot-circle-o"></i> Approve '.$status.' & Submit</button>';
                          $show_flag=2;
                    }
                                    
                  }
                  
                }

                  
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
<?php  


function generate_time($array_args)
{
  extract($array_args);
  
  $selected_value=(isset($selected_value)) ? $selected_value : '';
  
  $width=(isset($width)) ? $width : '90px';
  
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

$this->load->view('layouts/footer');  $this->load->view('layouts/popup_show_image_modal');  ?>      
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
<script type="text/javascript" src="<?php echo base_url();?>assets/js/electrical_permits.js"></script>
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

  $(document).ready(function() {

     $('#height_works_involved,.select2').select2();

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
            return "<a href='#' onclick=open_thick('"+term.id+"')>"+term.text+"</a>";            
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
            //$('.status,#schedule_date').removeAttr('disabled');alert(<?php echo $show_extend_field; ?>);
  
            
            //alert($('select[name="schedule_from_time['<?php echo $range[$show_extend_field-1]; ?>']"]').val());
              $('.status').removeAttr('disabled').attr('readonly',true);
              $('.status:checked').trigger('click');  
              $('select[name="schedule_from_time[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('select[name="schedule_to_time[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('input[name="no_of_persons[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('input[name="schedule_date[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('select[name="extended_contractors_id[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('select[name="extended_others_contractors_id[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
              $('select[name="issuing_authority[<?php echo $range[$show_extend_field-1]; ?>]"]').removeAttr('disabled');
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
              
                    $('input[name="reference_code['+selector_name+']"]').val(Math.random().toString(36).substring(7));
                    
                    //$('input[name="reference_code['+selector_name+']"]').val($('#permit_no').val()+'-0'+d);
                      
                    
                    $('select[name="schedule_from_time['+selector_name+']"],input[name="no_of_persons['+selector_name+']"],select[name="extended_contractors_id['+selector_name+']"],input[name="extended_others_contractors_id['+selector_name+']"],select[name="schedule_to_time['+selector_name+']"],select[name="issuing_authority['+selector_name+']"],select[name="performing_authority['+selector_name+']"]').prop('disabled',false);
                    
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
      url: base_url+'electrical_permits/ajax_show_energy_info/',
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
            "url" : base_url+'electrical_permits/ajax_fetch_department_users/',
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

     if($user_id==$ext_name_of_ia && $permission==READ)
     {
     echo "$('input[name=\"extend_issuing_authority_name_of_ia[".$ext_range."]\"]').removeAttr('disabled');";
     }

     if($cancel_ia==1 && $permission==READ)
     {
        echo "$('input[name=\"cancellation_name_of_ia\"]').removeAttr('disabled');";
     }

    ?>

$(".hazards").click(function() {
  
  var at=$(this).attr('data-attr');
  
  var chk=$(this).attr('data-checkbox');
  
  $('input[name="precautions['+at+']"]').removeAttr('disabled');
  
  $('input[name="precautions['+at+']"]').removeAttr('checked');

  console.log($(this).val()+' = '+at);
  
    if(at=='a')
    {
      $('input[name="precautions[aii]"]').removeAttr('disabled');
      $('input[name="precautions[aii]"]').removeAttr('checked');

      $('input[name="precautions[aiii]"]').removeAttr('disabled');
      $('input[name="precautions[aiii]"]').removeAttr('checked');

      $('input[name="precautions[aiv]"]').removeAttr('disabled');
      $('input[name="precautions[aiv]"]').removeAttr('checked');

      $('input[name="precautions[av]"]').removeAttr('disabled');
      $('input[name="precautions[av]"]').removeAttr('checked');

      $('input[name="precautions[avi]"]').removeAttr('disabled');
      $('input[name="precautions[avi]"]').removeAttr('checked');
      
    }  
    else if(at=='c')
    {
      $('input[name="precautions[cii]"]').removeAttr('disabled');
      $('input[name="precautions[ciii]"]').removeAttr('disabled');

      $('input[name="precautions[cii]"]').removeAttr('checked');
      $('input[name="precautions[ciii]"]').removeAttr('checked');
    }
    else if(at=='e' || at=='h' || at=='d')
    {
      $('input[name="precautions['+at+'ii]"]').removeAttr('disabled');
      $('input[name="precautions['+at+'ii]"]').removeAttr('checked');
      
    }

  if($(this).val()=='No')
  {
    $('input[name="precautions['+at+']"]:eq(1)').prop('checked', true);
    
    $('input[name="precautions_options['+at+']"]').removeAttr('checked').attr('disabled',true);

    $('input[name="precautions_text['+at+']"]').val('').attr('disabled',true);

    if(at=='a')
    {
      $('input[name="precautions[aii]"]:eq(1)').prop('checked', true);
      $('input[name="precautions[aiii]"]:eq(1)').prop('checked', true);
      $('input[name="precautions[aiv]"]:eq(1)').prop('checked', true);
      $('input[name="precautions[av]"]:eq(1)').prop('checked', true);
      $('input[name="precautions[avi]"]:eq(1)').prop('checked', true);     
      
      $('input[name="precautions_options[aii]"]').removeAttr('checked').attr('disabled',true);
      $('input[name="precautions_options[aiii]"]').removeAttr('checked').attr('disabled',true);
      $('input[name="precautions_options[aiv]"]').removeAttr('checked').attr('disabled',true);
      $('input[name="precautions_options[av]"]').removeAttr('checked').attr('disabled',true);
      $('input[name="precautions_options[avi]"]').removeAttr('checked').attr('disabled',true); 
    }
    else if(at=='c')
    {
      $('input[name="precautions[cii]"]:eq(1)').prop('checked', true);
      $('input[name="precautions[ciii]"]:eq(1)').prop('checked', true);
      $('input[name="precautions_options[cii]"]').removeAttr('checked').attr('disabled',true); 
      $('input[name="precautions_options[ciii]"]').removeAttr('checked').attr('disabled',true); 
    }
    else if(at=='e' || at=='h' || at=='d')
    {
      $('input[name="precautions['+at+'ii]"]').prop('checked', true);
      $('input[name="precautions_options['+at+'ii]"]').removeAttr('checked').attr('disabled',true); 
    }

  }
  else
  {
    $('input[name="precautions_options['+at+']"]').removeAttr('disabled',true);    

    $('input[name="precautions_text['+at+']"]').removeAttr('disabled',true);  

    if(at=='a')
    {
      $('input[name="precautions_options[aii]"]').removeAttr('disabled',true);  
      $('input[name="precautions_options[aiii]"]').removeAttr('disabled',true);  
      $('input[name="precautions_options[aiv]"]').removeAttr('disabled',true);  
      $('input[name="precautions_options[av]"]').removeAttr('disabled',true);  
      $('input[name="precautions_options[avi]"]').removeAttr('disabled',true);  
    }
    else if(at=='c')
    { 
      $('input[name="precautions_options[cii]"]').removeAttr('disabled',true);  
      $('input[name="precautions_options[ciii]"]').removeAttr('disabled',true);  
    }
    else if(at=='e' || at=='h' || at=='d')
    {
      $('input[name="precautions_options['+at+'ii]"]').removeAttr('disabled',true);  
    }

  } 
    
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

$(".precautions").click(function() {
  
  var at=$(this).attr('data-attr');
  

  //console.log('First string '+at.charAt(0));

  var first_char=at.charAt(0);

  if(first_char=='c' || first_chat=='e')
  at=first_char;

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
  console.log('Val '+sel_val);
    
    if($.inArray(sel_val, ["Existing", "yes_existing"])!==-1) 
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
    
    $arr = range('a', 'i');
    
    
    $validate='';
    for($i=0;$i<count($arr);$i++)
    {
      $validate.=",'hazards[".$arr[$i]."]': {required:".$flag."},'precautions[".$arr[$i]."]': {required:".$flag."}";
    }
      
     $validate.=",'precautions[cii]': {required:".$flag."},'precautions[ciii]': {required:".$flag."},'precautions[eii]': {required:".$flag."}";

    $arr=array('a','d','e','h','i','k','b','c');
    for($i=0;$i<count($arr);$i++)
    {
      $validate.=",'hazards_options[".$arr[$i]."]':{required:function(element) {
                      if($('input[name=\"hazards[".$arr[$i]."]\"]:checked').val()=='Yes') 
                      return true; 
                      else return false;
                     }}";
    }

    $arr=array('c','e','cii','ciii');
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
                job_name:{required:'Required' },
                acceptance_performing_id:{required:'Required' }
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
                  },      
              invalidHandler: function(form, validator) {
                submitted = true;
              },          
              submitHandler:function()
              {
                //if( $("input[name=is_isoloation_permit]:checked").val()=='Yes' && $('.selected_eip option:selected').length<=0)
                if($.inArray($("input[name=is_isoloation_permit]:checked").val(), [ "Yes", "yes_existing"])!==-1  && $('.selected_eip option:selected').length<=0)
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
                    }
                    else
                    $('#is_popup_submit').val(1);
                }
                else
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
                location:{required:<?php echo $flag; ?>},        
               'other_inputs[]': {required:<?php echo $flag; ?>},
                other_contractors : {  required:function(element) { if($('#contractor_id').val()=='others') return true; else return false;  }   },
                contractor_id:{required:<?php echo $flag; ?>},
                /*delete location:{required:<?php echo $flag; ?>},
                location_date: { required:<?php echo $flag; ?> },
                location_time_start: { required:<?php echo $flag; ?> },
                location_time_to: { required:<?php echo $flag; ?> },*/
                equipment_name: { required:<?php echo $flag; ?> },
                job_name: { required:<?php echo $flag; ?> },
                contractors_involved: { required:<?php echo $flag; ?>,digits:true,minStrict: 0 },
                acceptance_performing_id : { required:<?php echo $flag; ?>},
                acceptance_issuing_id : { required:<?php echo $flag; ?>},
                cancellation_name_of_ia : { required:<?php echo $flag; ?>},
                acceptance_name_of_ia: { required:<?php echo $flag; ?>},
                status : { required: true },
                required_ppe_other : { required:true},
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
                equipment_name:{required:'Required' },
                job_name:{required:'Required' },
                contractors_involved:{required:'Required' }
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
                  },      
              invalidHandler: function(form, validator) {
                submitted = true;
              },          
              submitHandler:function()
              {
                //if( $("input[name=is_isoloation_permit]:checked").val()=='Yes' && $('.selected_eip option:selected').length<=0)
                if($.inArray($("input[name=is_isoloation_permit]:checked").val(), [ "Yes", "yes_existing"])!==-1  && $('.selected_eip option:selected').length<=0)
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
                    }
                    else
                    $('#is_popup_submit').val(1);
                }
                else
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
          
          /*var vls='';
          $(".box_big:checked").each(function ()
          {
            vls+=$(this).val()+',';
          });
          
          data.append('work_types',vls);*/
          
          var pre_arr=new Array('c','e','cii','ciii');
          
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
          
          
          var pre_arr=new Array('a','d','e','h','i','k','b','c');
          
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
          
          //data.append('status',$('input[name=status]:checked').val());
          
          //delete data.append('is_scaffolding_certification',$('input[name=is_scaffolding_certification]:checked').val());    
          
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
                  url: base_url+'electrical_permits/form_action',
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
                        window.location.href=base_url+'electrical_permits/form/id/'+$('#id').val();
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