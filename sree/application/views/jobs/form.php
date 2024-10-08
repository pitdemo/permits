<?php 
error_reporting(0);
    $this->load->view('layouts/preload');

    $this->load->view('layouts/user_header');

    
    $ajax_paging_url=base_url().$this->data['controller'].'ajax_fetch_show_all_data/';
    $ajax_paging_params='page_name/'.$this->router->fetch_method().'/';

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

    $options.='<option value="'.$sop['id'].'" data-desc="'.$path.'" '.$sel.'>'.$desc.' '.$path.'</option>';

    endforeach;  

    if($selected_file_path!='') {
      $tx=base_url().'uploads/sops_wi/'.$selected_file_path;
      $selected_file_path='<a href="javascript:void(0);" class="show_image" title="View Description" data-src="'.$tx.'" data-bs-toggle="modal" data-bs-target="#modal-full-width">Show Desc</a>';
    }

    return array('dropdown'=>$options,'show_desc'=>$selected_file_path);

}
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
<div class="page-body" style="background-color:white;">
  <div class="container-xl">
      <div class="card-body">
          <br />
          <div class="row g-5">
                  <div class="col-sm-6 col-md-12">
                      <div class="mb-3">
                        <label class="form-label text-red">Permit Info - STEP 1 Inputs</label>                            
                      </div>
                  </div>
          </div> 

          <div class="row row-cards">
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label"><b>Permit No</b></label>
                    <div class="form-control-plaintext">EL01</div>
                  </div>
                </div> 
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label"><b>Department</b></label>
                    <div class="form-control-plaintext">Electrical</div>
                  </div>
                </div> 
                <div class="col-md-3">
                  <div class="mb-3">
                  <span class="form-check-label"><b>Permit for</b></span><br />
                          <label class="form-check form-check-inline">
                                  <input  type="radio" 
                                  name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'y'; ?>" <?php echo $disabled; ?> <?php echo $checkedy; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">Cement</span>
                          </label>
                          <label class="form-check form-check-inline">
                              <input  type="radio" 
                              name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'n'; ?>" <?php echo $disabled; ?> <?php echo $checkedn; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">Power</span>
                          </label>
                  </div>
                </div>

                <div class="col-sm-6 col-md-3">
                      <div class="mb-3">
                        <label class="form-label"><b>Select Zone</b></label>
                        <input type="hidden" name="zone_id" id="zone_id"  class="select2dropdown form-control" value="<?php echo $select_zone_id; ?>"  data-type="zones" data-account-text="<?php echo $zone_name; ?>" data-account-number="<?php echo $select_zone_id; ?>" data-width="300px"/> 
                      </div>
                </div>
               
          </div>  

          <div class="row g-5">
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
                <div class="col-sm-6 col-md-3">
                      <div class="mb-3">
                        <label class="form-label"><b>Start Date & Time</b></label>
                        <input type="text" class="form-control" name="location_time_start" id="location_time_start"  value="<?php echo (isset($records['location_time_start'])) ? $records['location_time_start'] : date('d-m-Y H:i'); ?>" readonly="readonly">
                      </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label"><b>End Date & Time</b></label>
                    <input type="text" class="form-control" name="location_time_to" id="location_time_to"  value="<?php echo (isset($records['location_time_to'])) ? $records['location_time_to'] : date('d-m-Y H:i',strtotime("+26 hours")); ?>" readonly="readonly">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3 mb-0">
                    <label class="form-label"><b>Work Description</b></label>
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
          </div> 

          <div class="row g-5">
                  <div class="col-sm-6 col-md-12">
                      <div class="mb-3">
                        <label class="form-label text-red">Choose Permit type</label>                            
                      </div>
                  </div>
          </div> 

          <div class="row g-5">
                <div class="col-md-12">
                    <div class="mb-3">                                   
                        <div>
                            <?php
                                $checked='';

                                foreach($permits as $list){

                                  $checked=(in_array($list['id'],$permit_types)) ? "checked='checked'" : '';

                                  $disabled='';

                                  if($list['department_id']!=$department_id && $list['department_id']>0) {
                                    $disabled='disabled';
                                  }
                                  
                                  # if($list['id']==1)
                                  # $disabled='disabled';
                            ?>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input permit_type" name="permit_type[]" type="radio" value="<?php echo $list['id']; ?>" <?php echo $checked; ?> <?php echo $disabled; ?>>
                            <span class="form-check-label"><?php echo $list['name']; ?><?php #echo $list['id']; ?></span>
                        </label>
                        <?php } ?>

                        </div>
                    </div>
                </div>
          </div> 

          <div class="col-xl-12 st_precautions_mandatory precautions" id="precautions1" style="display:<?php echo (in_array(4,$permit_types)) ? 'block' : 'none'; ?>">
               <?php $this->load->view('jobs/precautions/mandatory'); ?>
          </div>

          <div class="col-xl-12 precautions st_workatheights"  id="precautions4" style="display:<?php echo (in_array(4,$permit_types)) ? 'block' : 'none'; ?>">
                        <?php $this->load->view('jobs/precautions/work_at_height'); ?>
          </div> 

          <div class="col-xl-12 precautions st_confined_space"  id="precautions7" style="display:<?php echo (in_array(7,$permit_types)) ? 'block' : 'none'; ?>">
                        <?php $this->load->view('jobs/precautions/confined_space'); ?>
          </div>

          <div class="row row-cards"> 
                <div class="col-md-6">
                  <div class="mb-3">
                  <span class="form-check-label"><b>Isolation Require</b></span><br />
                          <label class="form-check form-check-inline">
                                  <input  type="radio" 
                                  name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'y'; ?>" <?php echo $disabled; ?> <?php echo $checkedy; ?>  class="form-check-input isolation_checkbox isolation_checkbox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">Yes</span>
                          </label>
                          <label class="form-check form-check-inline">
                              <input  type="radio" 
                              name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'n'; ?>" <?php echo $disabled; ?> <?php echo $checkedn; ?>  class="form-check-input isolation_checkbox isolation_checkbox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">No</span>
                          </label>
                          <label class="form-check form-check-inline">
                              <input  type="radio" 
                              name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'e'; ?>" <?php echo $disabled; ?> <?php echo $checkedn; ?>  class="form-check-input isolation_checkbox isolation_checkbox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">Existing</span>
                          </label>
                  </div>
                </div>
                    
                <div class="col-md-3 existing_isolation" style="display:none;">
                    <span class="form-check-label"><b>Select Existing Isolation</b></span><br />     
                    <select class="select2 form-control existing_isolation_dropdown">
                      <option value="" selected>Select</option>
                      <option value="1">LT01</option>
                      <option value="1">LT02</option>
                      <option value="1">LT03</option>
                    </select>
                </div>

          </div>      
          
          <div class="row g-5 loto_sections" style="display:none;padding-bottom:10px;">
                <div class="col-xl-12">
                   <div class="table-responsive">
                      <table class="table mb-0" border="1" id="isolation_table"><thead>
                                <tr>
                                <th colspan="4" align="center"><b>C) To be filled by Permit initiator and checked by issuer</b></th>
                                <th colspan="3" align="center"><b>D) To be filled by authorized isolator who is carrying out isolations</b></th>
                                </tr>
                              <thead>
                                <tr>
                                <th style="text-align:center:" width="15%">Eq.Details</th>
                                <th style="text-align:center:" width="20%">Equip Tag No</th>
                                <th style="text-align:center:" width="15%">Type of Isolation</th>
                                <th style="text-align:center:" width="15%">PA Lock &amp; Tag No</th>
                                <th style="text-align:center:" width="15%" class="text-orange">ISO Lock No</th>
                                <th style="text-align:center:" width="15%">Name of the Isolator</th>
                                <th style="text-align:center:" width="15%">Signature Date &amp; Time</th>
                                </tr>
                              </thead>

                              <tr id="equip_row_id1"><td><select name="equipment_descriptions[1]" id="equipment_descriptions[1]" class="form-control equipment_descriptions1 equip_desc equipment_descriptions equip_desc_dropdown" data-id="1"><option value="" selected="selected">- - Select - -</option><option value="125" data-eq-no="21N-AF1">Apron Feeder Main Drive</option><option value="124" data-eq-no="21N-CR1">Crusher Main Drive</option><option value="127" data-eq-no="21N-DR1">Scraper Chain Conveyor</option><option value="126" data-eq-no="21N-WR1">Wobbler Main Drive</option></select></td><td><input type="text" readonly="" class="form-control equipment_tag_no equipment_tag_no1" name="equipment_tag_nos[1]" id="equipment_tag_no[1]" value=""></td><td><select name="isolate_types[1]" disabled="disabled" id="isolate_type[1]" class="isolate_types form-control isolate_type1" data-id="1"><option value="" selected="selected">- - Select - -</option><option value="7">Electrical Energy</option><option value="8">Pnuematic Energy</option><option value="9">Thermal Energy</option><option value="10">Hydraulic Energy</option><option value="11">Mechanical Energy (Restor)</option><option value="12">Radioactive Energy</option><option value="13">Chemical Energy</option></select></td><td><input type="text" class="form-control isolated_tagno11" name="isolated_tagno1[1]" id="isolated_tagno1[1]" value="" disabled="disabled">&nbsp;<input type="text" class="form-control isolated_tagno21" name="isolated_tagno2[1]" id="isolated_tagno2[1]" value="" disabled="disabled"></td><td><input type="text" class="form-control isolated_tagno31" name="isolated_tagno3[1]" id="isolated_tagno3[1]" value="" disabled="disabled"></td><td><select name="isolated_user_ids[1]" id="isolated_user_ids[1]" class="form-control isolated_user_ids data-iso-name  isolated_user_ids1" data-attr="1" disabled="disabled"><option value="" selected="">Select</option></select></td><td><input type="text" class="form-control isolated_name_approval_datetime1" name="isolated_name_approval_datetime[1]" id="isolated_name_approval_datetime[1]" value="" disabled=""><div></div></td></tr>

                              <tr id="equip_row_id2"><td><select name="equipment_descriptions[2]" id="equipment_descriptions[2]" class="form-control equipment_descriptions2 equip_desc equipment_descriptions equip_desc_dropdown" data-id="2"><option value="" selected="selected">- - Select - -</option><option value="125" data-eq-no="21N-AF1">Apron Feeder Main Drive</option><option value="124" data-eq-no="21N-CR1">Crusher Main Drive</option><option value="127" data-eq-no="21N-DR1">Scraper Chain Conveyor</option><option value="126" data-eq-no="21N-WR1">Wobbler Main Drive</option></select></td><td><input type="text" readonly="" class="form-control equipment_tag_no equipment_tag_no2" name="equipment_tag_nos[2]" id="equipment_tag_no[2]" value=""></td><td><select name="isolate_types[2]" disabled="disabled" id="isolate_type[2]" class="isolate_types form-control isolate_type2" data-id="2"><option value="" selected="selected">- - Select - -</option><option value="7">Electrical Energy</option><option value="8">Pnuematic Energy</option><option value="9">Thermal Energy</option><option value="10">Hydraulic Energy</option><option value="11">Mechanical Energy (Restor)</option><option value="12">Radioactive Energy</option><option value="13">Chemical Energy</option></select></td><td><input type="text" class="form-control isolated_tagno12" name="isolated_tagno1[2]" id="isolated_tagno1[2]" value="" disabled="disabled">&nbsp;<input type="text" class="form-control isolated_tagno22" name="isolated_tagno2[2]" id="isolated_tagno2[2]" value="" disabled="disabled"></td><td><input type="text" class="form-control isolated_tagno32" name="isolated_tagno3[2]" id="isolated_tagno3[2]" value="" disabled="disabled"></td><td><select name="isolated_user_ids[2]" id="isolated_user_ids[2]" class="form-control isolated_user_ids data-iso-name  isolated_user_ids2" data-attr="2" disabled="disabled"><option value="" selected="">Select</option></select></td><td><input type="text" class="form-control isolated_name_approval_datetime2" name="isolated_name_approval_datetime[2]" id="isolated_name_approval_datetime[2]" value="" disabled=""><div></div></td></tr>
                      </table>
                      </div>
                </div>
          </div>

          

          <div class="row row-cards">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label"><b>SOP</b></label>
                    <div class="form-control-plaintext">
                    <?php
                        $other_inputs=(isset($records['other_inputs']) && $records['other_inputs']!='') ? json_decode($records['other_inputs'],true) : array();

                        $selected_sop=(isset($records['sop'])) ? $records['sop'] :  '';

                        if($sops_nums>0) {
                          $result = sops_wi_dropdown($sops,$selected_sop);
                        ?>
                         
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
                </div> 
                <div class="col-md-6">
                  <div class="mb-3">
                  <label class="form-check form-check-inline">
                  <input type="checkbox" <?php if(in_array('WI',$other_inputs)) { $disabled=''; ?> checked="checked" <?php } ?> name="other_inputs[]" class="other_inputs form-check-input wi" value="WI"  /><span class="form-check-label">Work instructions clearly explained to the all the members in the working Group</span></label>
                    <div class="form-control-plaintext">
                    <?php
                                  if($wis_nums>0) {
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
          </div>  

          <div class="row row-cards">
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label"><b>Initiator Name & Signature</b></label>
                    <div class="form-control-plaintext">Initiator Name <?php echo date('d-m-Y H:i A'); ?></div>
                  </div>
                </div> 
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label"><b>Co permitee</b></label>
                    <div class="form-control-plaintext">
                      <select class="select2 form-control">
                        <option value="" selected>Select</option>
                        <option value="1">Copermittee 1</option>
                        <option value="1">Copermittee 2</option>
                        <option value="1">Copermittee 3</option>
                      </select>
                    </div>
                  </div>
                </div> 
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label"><b>Custodian (Section Head/HOD)</b></label>
                    <div class="form-control-plaintext">
                      <select class="select2 form-control">
                        <option value="" selected>Select</option>
                        <option value="1">Custodian 1</option>
                        <option value="1">Custodian 2</option>
                        <option value="1">Custodian 3</option>
                      </select>
                    </div>
                  </div>
                </div> 
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label"><b>Issuer</b></label>
                    <div class="form-control-plaintext">
                      <select class="select2 form-control">
                        <option value="" selected>Select</option>
                        <option value="1">Issuer 1</option>
                        <option value="1">Issuer 2</option>
                        <option value="1">Issuer 3</option>
                      </select>
                    </div>
                  </div>
                </div>
          </div>  


          <div class="row g-5">

              <div class="col-xl-12" style="text-align:right;">
                  <button class="btn btn-success submit step3Submit" type="submit"  name="step3" id="final_submit"  data-next-step="e" data-current-step="e">Create</button>
              </div>

          </div>



          <div class="row g-5">
                  <div class="col-sm-6 col-md-12">
                      <div class="mb-3">
                        <label class="form-label text-red">STEP 2</label>                            
                      </div>
                  </div>
          </div> 


          <div class="row row-cards">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label"><b>Custodian Approval</b></label>
                    <div class="form-control-plaintext">Custodian: I have checked that all conditions are met to carry out the job safety. I have checked that all equipments have been identified by initiator as mentioned below. Please get isolated the equipment</div>
                  </div>
                </div> 
                
                <div class="col-md-3">
                  <div class="mb-3">
                  <span class="form-check-label"><b>Permit Approval</b></span><br />
                          <label class="form-check form-check-inline">
                                  <input  type="radio" 
                                  name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'y'; ?>" <?php echo $disabled; ?> <?php echo $checkedy; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">Approve</span>
                          </label>
                          <label class="form-check form-check-inline">
                              <input  type="radio" 
                              name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'n'; ?>" <?php echo $disabled; ?> <?php echo $checkedn; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">Reject</span>
                          </label>
                  </div>
                </div>

                <div class="col-sm-6 col-md-3">
                      <div class="mb-3">
                        <label class="form-label"><b>Notes (If any)</b></label>
                        <textarea rows="3" class="form-control" placeholder="Here can be your notes" name="notes" id="notes"></textarea>
                      </div>
                </div>
               
          </div> 

          <div class="row g-5">

              <div class="col-xl-12" style="text-align:right;">
                  <button class="btn btn-success submit step3Submit" type="submit"  name="step3" id="final_submit"  data-next-step="e" data-current-step="e">Submit Approval</button>
              </div>

          </div>
          
          <div class="row g-5">
                  <div class="col-sm-6 col-md-12">
                      <div class="mb-3">
                        <label class="form-label text-red">STEP 3 - If the LOTO is checked Yes/Existing by Initiator, then CCR person will be choose the responsible Isolator name in <b>D</b> and send approval request to Isolator.</label>        
                        <label class="form-label text-red">STEP 4 - When the Isolator is logged, they will fil to the LOCK No against to the tag no. Once, its done we'll create a new LOTO unique no.</label>                       
                      </div>
                  </div>
          </div> 
          
          <div class="row g-5">
                  <div class="col-sm-6 col-md-12">
                      <div class="mb-3">
                        <label class="form-label text-red">STEP 5 - Initiator only will be fill the below inputs. If they choose as "No" to the any one of the below inputs, then permit status is changed to "HOLD".</label>  
                      </div>
                  </div>
          </div> 

          <div class="row row-cards">
                <div class="col-md-2">
                  <div class="mb-2">
                  <span class="form-check-label"><b>Done Isolation</b></span><br />
                          <label class="form-check form-check-inline">
                                  <input  type="radio" 
                                  name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'y'; ?>" <?php echo $disabled; ?> <?php echo $checkedy; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">Yes</span>
                          </label>
                          <label class="form-check form-check-inline">
                              <input  type="radio" 
                              name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'n'; ?>" <?php echo $disabled; ?> <?php echo $checkedn; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">No</span>
                          </label>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4">
                      <div class="mb-3">
                        <label class="form-label"><b>Isolation Notes (If any)</b></label>
                        <textarea rows="3" class="form-control" placeholder="Here can be your notes" name="notes" id="notes"></textarea>
                      </div>
                </div>
                <div class="col-md-2">
                  <div class="mb-2">
                  <span class="form-check-label"><b>Key with me</b></span><br />
                          <label class="form-check form-check-inline">
                                  <input  type="radio" 
                                  name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'y'; ?>" <?php echo $disabled; ?> <?php echo $checkedy; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">Yes</span>
                          </label>
                          <label class="form-check form-check-inline">
                              <input  type="radio" 
                              name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'n'; ?>" <?php echo $disabled; ?> <?php echo $checkedn; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">No</span>
                          </label>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4">
                      <div class="mb-3">
                        <label class="form-label"><b>Key Notes (If any)</b></label>
                        <textarea rows="3" class="form-control" placeholder="Here can be your notes" name="notes" id="notes"></textarea>
                      </div>
                </div>

                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label"><b>Custodian (Section Head/HOD)</b></label>
                    <div class="form-control-plaintext">
                      <select class="select2 form-control">
                        <option value="" selected>Select</option>
                        <option value="1">Custodian 1</option>
                        <option value="1">Custodian 2</option>
                        <option value="1">Custodian 3</option>
                      </select>
                    </div>
                  </div>
                </div> 

                <div class="col-xl-12" style="text-align:right;">
                  <button class="btn btn-success submit step3Submit" type="submit"  name="step3" id="final_submit"  data-next-step="e" data-current-step="e">Submit</button>
              </div>
          </div> 

          <div class="row g-5">
                  <div class="col-sm-6 col-md-12">
                      <div class="mb-3">
                        <label class="form-label text-red">STEP 6 - CCR will confirm to the following check points.</label>  
                      </div>
                  </div>
          </div> 

          <div class="row row-cards">
                <div class="col-md-6">
                    <table class="table mb-0" border="1">
                        <tbody>
                                <tr>
                                      <th width="2%" colspan="2">Yes <span style="padding-left:25px;">No</span></th>
                                      <th width="9%">Check Points</th>
                                </tr>
                                <?php
                                $labels=array(1=>'Flow Isolated and their control valves blinded for operational isolation and Tagged',2=>'Equipment Electrically and Mechanically  Isolated and their control valves blinded for operational isolation and Tagged
',3=>'Equipment Depressurized , completely emptied and cooled');
                        foreach($labels as $key => $label):
                              $y_checked=$n_checked='';

                              if(isset($precautions_data) && count($precautions_data)>0)
                              {
                              $data = (isset($precautions_data[$key])) ? $precautions_data[$key] : '';

                              $y_checked = $data=='y' ? "checked='checked'" : '';
                              $n_checked = $data=='n' ? "checked='checked'" : '';
                              }
                              $disabled='';
                              if($key==6){
                                $y_checked="checked='checked'";
                                $disabled='disabled';
                             }

                        ?>
                        <tr>
                              <td colspan="2"> 
                              <label class="form-check form-check-inline">
                              <input class="form-check-input confined_space" type="radio" 
                                $disabled='disabled';
                                value="y" name="confined_space[<?php echo $key; ?>]" <?php echo $disabled; ?>  <?php echo $y_checked; ?>>
                              </label>
                              <label class="form-check form-check-inline">
                              <input class="form-check-input confined_space" type="radio" 
                              value="n" name="confined_space[<?php echo $key; ?>]" <?php echo $disabled; ?> <?php echo $n_checked; ?>>
                              </label>
                              </td>
                              <td> 
                              <?php echo $label; ?>
                              </td>
                        </tr>
                            <?php
                            $a++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6 col-md-4">
                      <div class="mb-3">
                        <label class="form-label"><b>Any other instruction or advise</b></label>
                        <textarea rows="3" class="form-control" placeholder="Here can be your notes" name="notes" id="notes"></textarea>
                      </div>
                </div>
                

                <div class="col-xl-12" style="text-align:right;">
                  <button class="btn btn-success submit step3Submit" type="submit"  name="step3" id="final_submit"  data-next-step="e" data-current-step="e">Submit</button>
              </div>
          </div> 

          <div class="row g-5">
                  <div class="col-sm-6 col-md-12">
                      <div class="mb-3">
                        <label class="form-label text-red">STEP 7 - Initiator will be confirm the below check point. In case, if the equipment is running then the permit status is changed to "HOLD" otherwise send the approval notification to CCR</label>  
                      </div>
                  </div>
          </div> 

          <div class="row row-cards">
                <div class="col-md-2">
                  <div class="mb-2">
                  <span class="form-check-label"><b>Is Equipment Running</b></span><br />
                          <label class="form-check form-check-inline">
                                  <input  type="radio" 
                                  name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'y'; ?>" <?php echo $disabled; ?> <?php echo $checkedy; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">Yes</span>
                          </label>
                          <label class="form-check form-check-inline">
                              <input  type="radio" 
                              name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'n'; ?>" <?php echo $disabled; ?> <?php echo $checkedn; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">No</span>
                          </label>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4">
                      <div class="mb-3">
                        <label class="form-label"><b>Notes (If any)</b></label>
                        <textarea rows="3" class="form-control" placeholder="Here can be your notes" name="notes" id="notes"></textarea>
                      </div>
                </div>
                <div class="col-md-3">
                  <div class="mb-3">
                    <label class="form-label"><b>Custodian (Section Head/HOD)</b></label>
                    <div class="form-control-plaintext">
                      <select class="select2 form-control">
                        <option value="" selected>Select</option>
                        <option value="1">Custodian 1</option>
                        <option value="1">Custodian 2</option>
                        <option value="1">Custodian 3</option>
                      </select>
                    </div>
                  </div>
                </div> 
                <div class="col-xl-12" style="text-align:right;">
                  <button class="btn btn-success submit step3Submit" type="submit"  name="step3" id="final_submit"  data-next-step="e" data-current-step="e">Submit</button>
              </div>
          </div> 

          <div class="row g-5">
                  <div class="col-sm-6 col-md-12">
                      <div class="mb-3">
                        <label class="form-label text-red">STEP 8 - CCR will be confirm the below check point and send approval to Issuer if they choosed as "Yes", otherwise the permit status is changed to "HOLD"</label>  
                      </div>
                  </div>
          </div> 

          <div class="row row-cards">
                <div class="col-md-2">
                  <div class="mb-2">
                  <span class="form-check-label"><b>Is Equipment removed</b></span><br />
                          <label class="form-check form-check-inline">
                                  <input  type="radio" 
                                  name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'y'; ?>" <?php echo $disabled; ?> <?php echo $checkedy; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">Yes</span>
                          </label>
                          <label class="form-check form-check-inline">
                              <input  type="radio" 
                              name="issuer_ensured_items[<?php echo $key; ?>]" value="<?php echo $key.'n'; ?>" <?php echo $disabled; ?> <?php echo $checkedn; ?>  class="form-check-input loto_ia_checkox loto_ia_checkox_input<?php echo $key; ?>" data-id="<?php echo $key; ?>"><span class="form-check-label">No</span>
                          </label>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4">
                      <div class="mb-3">
                        <label class="form-label"><b>Notes (If any)</b></label>
                        <textarea rows="3" class="form-control" placeholder="Here can be your notes" name="notes" id="notes"></textarea>
                      </div>
                </div>

                <div class="col-sm-6 col-md-4">
                      <div class="mb-3">
                        <label class="form-label"><b>Image Proof</b></label>
                        
                      </div>
                </div>

                <div class="col-xl-12" style="text-align:right;">
                  <button class="btn btn-success submit step3Submit" type="submit"  name="step3" id="final_submit"  data-next-step="e" data-current-step="e">Submit</button>
                </div>
          </div> 

          <div class="row g-5">
                  <div class="col-sm-6 col-md-12">
                      <div class="mb-3">
                        <label class="form-label text-red">STEP 9 - Extends/Close/Cancel the Permit</label>  
                      </div>
                  </div>
          </div> 

          <div class="row g-5">
                  <div class="col-md-6 col-xl-6">
                      <div class="mb-3">
                          <label class="form-label text-red">Permit Status</label>
                                                                                <label class="form-check form-check-inline">
                                    <input class="form-check-input job_status " type="radio" value="5" name="approval_status">Completion                                                  </label>
                                                                                <label class="form-check form-check-inline">
                                    <input class="form-check-input job_status " type="radio" value="7" name="approval_status">Cancellation                                                  </label>
                                                                                <label class="form-check form-check-inline">
                                    <input class="form-check-input job_status " type="radio" value="22" name="approval_status">Extends                                                  </label>
                                                                                <div class="mb-3 self_cancel">
                                <label class="form-label">Notes (If any)</label>
                                <textarea rows="3" class="form-control" placeholder="Here can be your notes" name="notes" id="notes"></textarea>
                              </div>    
                        </div>                             
                  </div>            
          </div>
          <div class="row g-5 extends" style="display:none;">
                            <div class="col-xl-12">
                                  <div class="mb-3">
                                  <label class="form-label text-red">Renewal of Permit to Work</label>                            
                                  </div>
                            <div class="table-responsive">
                                <table class="table mb-0" border="1">                                  
                                  <tbody>
                                    <?php
                                    $acceptance_issuing_date=(isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : '';
                                    $diff=$this->public_model->datetime_diff(array('start_date'=>date('Y-m-d H:i:s'),'end_date'=>$acceptance_issuing_date));

                                    

                                    $ext_columns=array('schedule_from_dates'=>'From Date','schedule_to_dates'=>'To Date','ext_performing_authorities'=>'PA','ext_performing_authorities_dates'=>'PA Signed Date','ext_issuing_authorities'=>'CCR','ext_issuing_authorities_dates'=>'CCR Signed Date','ext_oxygen_readings'=>'%  of  Oxygen level <br>19.5  to  23.5  %','ext_gases_readings'=>'Combustible gases<br> 0  %','ext_carbon_readings'=>'Carbon Monoxide<br>0-25  ppm','ext_reference_codes'=>'Reference Code');
                                    $c=1;

                                   


                                    $schedule_from_dates=(isset($jobs_extends['schedule_from_dates']) && $jobs_extends['schedule_from_dates']!='') ? json_decode($jobs_extends['schedule_from_dates'],true) : array();

                                    $schedule_to_dates=(isset($jobs_extends['schedule_to_dates']) && $jobs_extends['schedule_to_dates']!='') ? json_decode($jobs_extends['schedule_to_dates'],true) : array();

                                    $ext_contractors=(isset($jobs_extends['ext_contractors']) && $jobs_extends['ext_contractors']!='') ? json_decode($jobs_extends['ext_contractors'],true) : array();

                                    $ext_contractors=(isset($jobs_extends['ext_contractors']) && $jobs_extends['ext_contractors']!='') ? json_decode($jobs_extends['ext_contractors'],true) : array();

                                    $ext_contractors=(isset($jobs_extends['ext_contractors']) && $jobs_extends['ext_contractors']!='') ? json_decode($jobs_extends['ext_contractors'],true) : array();

                                    $ext_no_of_workers=(isset($jobs_extends['ext_no_of_workers']) && $jobs_extends['ext_no_of_workers']!='') ? json_decode($jobs_extends['ext_no_of_workers'],true) : array();

                                    $ext_performing_authorities=(isset($jobs_extends['ext_performing_authorities']) && $jobs_extends['ext_performing_authorities']!='') ? json_decode($jobs_extends['ext_performing_authorities'],true) : array();

                                    $ext_performing_authorities_dates=(isset($jobs_extends['ext_performing_authorities_dates']) && $jobs_extends['ext_performing_authorities_dates']!='') ? json_decode($jobs_extends['ext_performing_authorities_dates'],true) : array();

                                    $ext_issuing_authorities=(isset($jobs_extends['ext_issuing_authorities']) && $jobs_extends['ext_issuing_authorities']!='') ? json_decode($jobs_extends['ext_issuing_authorities'],true) : array();

                                    $ext_oxygen_readings=(isset($jobs_extends['ext_oxygen_readings']) && $jobs_extends['ext_oxygen_readings']!='') ? json_decode($jobs_extends['ext_oxygen_readings'],true) : array();

                                    $ext_gases_readings=(isset($jobs_extends['ext_gases_readings']) && $jobs_extends['ext_gases_readings']!='') ? json_decode($jobs_extends['ext_gases_readings'],true) : array();

                                    $ext_carbon_readings=(isset($jobs_extends['ext_carbon_readings']) && $jobs_extends['ext_carbon_readings']!='') ? json_decode($jobs_extends['ext_carbon_readings'],true) : array();

                                    $ext_column_values=array('schedule_from_dates'=>$schedule_from_dates,'schedule_to_dates'=>$schedule_to_dates,'ext_contractors'=>$ext_contractors,'ext_no_of_workers'=>$ext_no_of_workers,'ext_performing_authorities'=>$ext_performing_authorities,'ext_performing_authorities_dates'=>$ext_performing_authorities_dates,'ext_issuing_authorities'=>$ext_issuing_authorities,'ext_issuing_authorities_dates'=>$ext_issuing_authorities_dates,'ext_oxygen_readings'=>$ext_oxygen_readings,'ext_gases_readings'=>$ext_gases_readings,'ext_carbon_readings'=>$ext_carbon_readings,'	ext_cop'=>array(),'ext_reference_codes'=>$ext_reference_codes);

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
                                        for($c=1;$c<=6;$c++)
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
                                                case 'ext_no_of_workers':
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
         
                            <div class="loto_sections_completion"  data-id="8" style="display:none;">
                                <div class="row g-5 ">
                                      <div class="col-xl-12">
                                              <div class="row">
                                                  <div class="col-md-6 col-xl-12">
                                                      <div class="mb-3">
                                                      <label class="form-label text-red">Closure of permit to work</label>
                                                      </div>                                           
                                                  </div>
                                              </div>                            
                                      
                                      </div> 
                                </div> 
                                
                                <div class="table-responsive">
                                    <table class="table mb-0" border="1">
                                    <?php
                                    $arr = array(1=>'The job is completed, all men & material removed from site. <br />Safe to remove isolations as stated clause-A&C.',2=>'Please remove isolations as stated clause-A&C.',3=>'I have removed all isolation as listed clause-A&C and <br />all isolations as per clause-A&C are restored. Equipment ready to start');

                                    $arr_sub = array(1=>'Permit Initiator Name & Sign',2=>'Issuer Name & Sign',3=>'Isolator Name & Sign',4=>'Issuer Name & Sign',5=>'Permit Initiator Name & Sign');

                                    $arr_users=array(1=>'performing',2=>'loto_closure_issuing',3=>'loto_closure_isolators',4=>'loto_closure_issuing',5=>'performing');                                    

                                    $isolate_types = array_values(array_filter($isolate_types));

                                    $isolate_types=implode(',',$isolate_types);

                                    $input_department=(isset($records['department_id']) && $records['department_id']>0) ? $records['department_id'] : $department['id'];

                                    foreach($arr as $key => $label):
                                      $input_value=$input_value_text=$input_filter_value=$input_skip_value=$input_date_value=$prev_input_date_value='';

                                      $input_value=(isset($loto_closure_ids[$key]) && $loto_closure_ids[$key]!='')  ? $loto_closure_ids[$key] : '';

                                      if($input_value!=''){
                                        $input_value_text=get_authorities($input_value,$allusers);
                                      }

                                      $input_date_value=(isset($loto_closure_ids_dates[$key]) && $loto_closure_ids_dates[$key]!='')  ? $loto_closure_ids_dates[$key] : '';

                                      if($key>1)
                                      {
                                        $prev_input_date_value=(isset($loto_closure_ids_dates[$key-1]) && $loto_closure_ids_dates[$key-1]!='')  ? $loto_closure_ids_dates[$key-1] : '';
                                      }

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
                                                      $form3_button_name='Approve'; $final_submit=1;
                                                  }
                                                  break;
                                            case 3:
                                                    $input_department=$isolate_types;
                                                    $input_skip_value='';
                                                    if($user_id==$input_value && $input_date_value=='' && $prev_input_date_value!='')
                                                    {
                                                        $input_date_value=date('d-m-Y H:i');
                                                        $form3_button_name='Approve'; 
                                                        $final_submit=1;
                                                    }
                                                    break;
                                            case 4:
                                                  $input_skip_value=$user_id;
                                                  if($user_id==$input_value && $input_date_value=='' && $prev_input_date_value!='')
                                                  {
                                                      $input_date_value=date('d-m-Y H:i');
                                                      $form3_button_name='Approve'; 
                                                      $final_submit=1;
                                                  }
                                                  break;                                            
                                            case 5:
                                                    if($input_value=='')
                                                    {
                                                      $input_value=$user_id;
                                                      $input_value_text=$this->session->userdata('first_name');
                                                    } else if($user_id==$input_value && $input_date_value=='' && $prev_input_date_value!='')
                                                    {
                                                        $input_date_value=date('d-m-Y H:i');
                                                        $form3_button_name='Approve'; 
                                                        $final_submit=1;
                                                    }
                                                    break;
                                        }

                                        $validate_3_form.=",'loto_closure_ids[".$key."]':{required:function(element) {
                                          if($('.loto_sections_completion').is(':visible')==true) 
                                          return true; 
                                          else return false;
                                          }}";


                                        $readonly=($key==1) ? 'readonly' : '';
                                    ?>
                                      <tr>
                                                <td> <label class="form-label"><?php echo ($key).' '.$label; ?></label></td>
                                                <td><label class="form-label"><?php echo $arr_sub[$key]; ?></label>
                                                <div class="form-control-plaintext"> 
                                                <input type="hidden" name="loto_closure_ids[<?php echo $key; ?>]" id="loto_closure_ids[<?php echo $key; ?>]"  data-id="<?php echo $key; ?>" class="select2dropdown form-control  loto_sections_completion_inputs loto_sections_completion_input_id<?php echo $key; ?>" value="<?php echo $input_value; ?>"  data-type="<?php echo $arr_users[$key]; ?>" data-account-text="<?php echo $input_value_text; ?>" data-account-number="<?php echo $input_value; ?>" data-width="300px" data-filter-value="<?php echo $input_department; ?>" data-skip-users="<?php echo $input_skip_value; ?>" data-departments="<?php echo $input_department; ?>" <?php echo $readonly; ?> />
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

                            <div class="row g-5 completion" style="display:<?php echo (in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION,APPROVED_IA_CANCELLATION,APPROVED_IA_COMPLETION))) ? 'block' : 'none'; ?>;">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                  <div class="col-md-6 col-xl-3">
                                                      <div class="mb-3">
                                                          <label class="form-label text-red">PA Work <span class="status_txt"><?php echo (in_array($approval_status,array(5,6))) ? 'Completion' : 'Cancellation'; ?></span></label>
                                                          <div class="form-control-plaintext">Work <span class="status_txt"><?php echo (in_array($approval_status,array(5,6))) ? 'Completion' : 'Cancellation'; ?></span>, all persons are withdrawn and material removed from the area.</div>
                                                      </div>    
                                                                                
                                                  </div>
                                                  <div class="col-md-6 col-xl-3">
                                                      <div class="mb-3">
                                                          <label class="form-label text-red">Performing Authority</label>
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
                                                        <label class="form-label text-red">IA Work <span class="status_txt"><?php echo (in_array($approval_status,array(5,6))) ? 'Completion' : 'Cancellation'; ?></span></label>
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
                                                            <label class="form-label text-red">Issuing Authority</label>
                                                                  <div class="mb-3">
                                                                        <label class="form-label">Name of the Issuer</label>
                                                                        <input type="hidden" name="cancellation_issuing_id" id="cancellation_issuing_id"  class="select2dropdown form-control" value="<?php echo $cancellation_issuing_id; ?>"  data-type="issuing_id" data-account-text="<?php echo $cancellation_issuing_name; ?>" data-account-number="<?php echo $cancellation_issuing_id; ?>" data-width="300px" data-filter-value="<?php echo (isset($records['department_id'])) ? $records['department_id'] : $department['id']; ?>" data-skip-users="<?php echo $record_id=='' || $records['cancellation_performing_id']=='' ? $user_id : $acceptance_performance_id.','.$records['cancellation_performing_id']; ?>" />
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
                            

      </div>

      <div class="col-xl-12" style="text-align:right;">
                  <button class="btn btn-success submit step3Submit" type="submit"  name="step3" id="final_submit"  data-next-step="e" data-current-step="e">Submit</button>
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

    $(".isolation_checkbox").change(function()
    {
      var val=$(this).val();
       
      $('.loto_sections').hide();
      $('.existing_isolation').hide();

      if(val=='y'){
          $('.loto_sections').show();
      } else if(val=='e') {
          $('.existing_isolation').show();
      }


    });

    $(".existing_isolation_dropdown").change(function()
    {
        var val=$(this).val();
        $('.loto_sections').hide();
        
        if(val!=''){
            $('.loto_sections').show();
        } 
    });

    <?php
    if($show_button=='hide' || in_array($approval_status,array(SELF_CANCEL)))
    {
      ?>
        $('input,textarea,select').attr('disabled',true);
    <?php
    }
    if($final_submit==1) { 
    ?>
      $('#final_submit').removeAttr('disabled');
    <?php }
    if(in_array(8,$permit_types)) { ?>
       load_lotos();
    <?php } 
    if($permit_status_enable==1){
    ?>
      $('.job_status').removeAttr('disabled');
      $('#notes').removeAttr('disabled');
      $(".completion :input").removeAttr("disabled");
      $('.step3Submit').removeAttr('disabled');

      //If AVI is not closed 
      if($('.avi_message').length>0) {
        console.log('avi_message')
            $('.avi_message_class').prop('disabled',true);
      }

      if($('.loto_sections_completion').length>0){
         $('.loto_sections_completion :input').removeAttr('disabled');
      }

    <?php } 
      if($department_clearance==1 || $iso_clearance==1) { 
    ?>
      $('.submit').removeAttr('disabled');
    <?php
      }
      if($checkbox_clearance!='') {
        echo "$('.".$checkbox_clearance."').prop('disabled',false)";
      }
      if($extends_column>0){
          echo "check_extends(".$block_disable.");";
      }
    ?>
    //Need to remove this line
   //$('input,textarea,select').attr('disabled',false);

  function load_lotos()
  {
          var data = new FormData();  
          data.append('zone_id',$('#zone_id').val());

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
          },
          error: function(jqXHR, textStatus, errorThrown)
          {
            $('#isolation_table').html('Failure');	

            // is_checklist=data.num_rows; 	
          }
        });
  }
 
  $("#zone_id").change(function()
  {
      var val=$(this).val();
      var loto='';

      $(".permit_type:checked").each(function(index,value) {
        if($(this).val()==8)
            loto=1;
      });

      /*if(loto==1){
        $('.loto_sections').show();
        $('.loto_sections_div').show();
        $('.loto_sections_approval').show(); 

        load_lotos();
      } else{
        $('.loto_sections').hide();
        $('.loto_sections_div').hide();
        $('.loto_sections_approval').hide();
      }*/
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
          var pre_arr=new Array('schedule_from_dates','schedule_to_dates','ext_performing_authorities','ext_issuing_authorities','ext_no_of_workers','ext_oxygen_readings','ext_gases_readings','ext_carbon_readings');

          var extends_val_avail=0;

          var e=$('#jobs_extends_avail').val();

            for (i = 0; i < pre_arr.length; i++) 
            {
              var field_name=pre_arr[i]+''+e+'';

              console.log('Field Name ',field_name);

              console.log('Field Value ',$('.'+field_name).val());

              if($('.'+field_name).length>0 && $('.'+field_name).val()!='')
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
  $(".permit_type").change(function()
  {  
      $('#clearance_department_required').val(false);
      $('.clerance_department_id').attr('disabled',true);
      $('#checkpoints3').prop('checked',false);
      $('#checkpoints3').attr('disabled',true);
      $('#checkpoints4').prop('checked',false);
      $('#checkpoints4').attr('disabled',true);
      $('.precautions').hide();
      var loto=''; var clearance_departments='';
      var arr= []

      $(".permit_type:checked").each(function(index,value) {
        
            if(Number($(this).val())==9){
                clearance_departments=1;
            }

            if(Number($(this).val())==3){
                $('#checkpoints'+$(this).val()).removeAttr('disabled');
            }
            if(Number($(this).val())==4){
                $('#checkpoints'+$(this).val()).removeAttr('disabled');
            }

            if($(this).val()==8)
                loto=1;

            arr.push(Number($(this).val()))
            
            $('#precautions'+$(this).val()).show();
      });

     /* if(loto==1){
        $('.loto_sections').show();
        $('.loto_sections_div').show();
        
        $('.loto_sections_approval').show(); 
        load_lotos();
      } else{
        $('.loto_sections').hide();
        $('.loto_sections_div').hide();
        $('.loto_sections_approval').hide();
      }
        */

      if(clearance_departments==1){
        $('.clearance_departments').show();
        $('#clearance_department_required').val(true);
        $('.clerance_department_id').removeAttr('disabled');
      } else {
        $('.clearance_departments').hide();
      }

  });

  $(".clerance_department_id").change(function()
  {   
      $(".clerance_department_id").each(function(index,value) {
          if($(this).is(':checked')==true) {
            $('#clerance_department_user_id'+$(this).val()).removeAttr('disabled');
            $('.clearance_department_remarks'+$(this).val()).removeAttr('disabled');
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

        if(Number(next_step)==2){
          tab1_validation(next_step,current_step);
        } else if(Number(next_step)==3){
          console.log('Tabl2 Validation')
          tab2_validation(next_step,current_step);
        } else
        {
          tab3_validation(next_step,current_step);
        }
        
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
            zone_id : {required:<?php echo $flag; ?>},
            contractor_id : {required:<?php echo $flag; ?>},
            no_of_workers : { required:<?php echo $flag; ?>},
            "permit_type[]": { required: true, minlength: 1 },  
            "checkpoints[]": { required:<?php echo $flag; ?>,minlength:1},              
            job_name:{required:<?php echo $flag; ?>},
            location:{required:<?php echo $flag; ?>}
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
              $('#tab'+current_step).removeClass('active');
              $('.tab'+current_step).removeClass('active show');

              $('#tab'+next_step).addClass('active');
              $('.tab'+next_step).addClass('active show');
              
             //form_submit('submit');
              console.log('Form 1 Success')
              return false;
          }
    });
    

    if($('.loto_sections').is(':visible')==true)
    {
      var elem = $(".loto_sections input[type='text']");
      var count = elem.filter(function() {
        return !$(this).val();
      }).length;

      var tbllength= $('#isolation_table tbody').find('tr').length;
      
      console.log('Count ',count+' = '+elem.length)
      if (count == elem.length) {
        var name = 'equipment_descriptions[1]';
      //  $("input[name*='"+name+"']").rules("add", "required");   
          $('.equipment_descriptions1').rules("add", "required");   
      } else {

          var fieldsarr=new Array('equipment_tag_nos','isolate_type','isolated_tagno1','isolated_tagno2','isolated_tagno3','isolated_name'); //,'isolated_ia_name','isolated_user_ids'

          for(i=1;i<=tbllength;i++)
          {
              var val = $.trim($('.equipment_descriptions'+i).val());

              if(val!='')
              {                   
                      console.log('Desc Not empty ',val+' = '+i)
                    for (j = 0; j<fieldsarr.length; j++) 
                    {
                      var field_name=fieldsarr[j]+'['+i+']';

                      //var field_name=fieldsarr[j];

                       // console.log('field_namefield_name ',field_name)
                       $('.'+fieldsarr[j]+''+i).rules("add", "required");   
                       $("input[name*='"+field_name+"']").rules("add", "required");   
                      
                    }
                   
              }
          }

      }
      
      if($('.loto_sections_approval').is(':visible')==true)
          $("input[name*='acceptance_loto_issuing_id']").rules("add", "required"); 
        
          
     // $("input[name*='pa_equip_identified[]']").rules("add", { required: true,minlength:1});   

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
    
} 

function tab2_validation(next_step,current_step)
{
    $('input, select, textarea').each(function() {
        $(this).removeClass('error');
    });

    //$('#precautions4 input[type="radio"]').prop('required',true);

    var permit_type_array= []

    $(".permit_type:checked").each(function(index,value) {
      permit_type_array.push(Number($(this).val()))
    });
    
    $('#job_form2').removeData('validator'); 

    var clearance_department_id_flag= Boolean($('#clearance_department_required').val());

    $("#job_form2").validate({ 
          ignore: '.ignore',
          focusInvalid: true, 
          errorClass: 'error is-invalid',
          validClass: 'is-valid',
          debug:true,                
          highlight: function( element, errorClass, validClass )
          {     
              console.log('Error Field Name ',element.name)
              $(element).addClass(errorClass);
              
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

            console.log('Form 2 Success')
             
              $('#tab'+current_step).removeClass('active');
              $('.tab'+current_step).removeClass('active show');

              $('#tab'+next_step).addClass('active');
              $('.tab'+next_step).addClass('active show');
           
            
              return false;
            
          }
    });

    var pre_arr=new Array('precautions_mandatory','confined_space','electrical','excavations','hotworks','materials','scaffoldings','utp','workatheights','permit_type','checkpoints');

    for (i = 0; i < pre_arr.length; i++) 
    {
          var field_name=pre_arr[i];
          
          var alpha_vals='';


        //Appling Validating only to visible permit types
        if($('.st_'+field_name).is(':visible')==true)
        {
            $("."+field_name).each(function ()
            { 
                var name = $(this).attr('name')
                
                $("input[name*='"+name+"']").rules("add", "required");    
            });

            if(field_name=='confined_space'){
              $("input[name*='oxygen_readings']").rules("add", {"required":true,"range":[19.25,23.5]});  
              $("input[name*='gases_readings']").rules("add", {"required":true,"range":[0,5]});  
              $("input[name*='carbon_readings']").rules("add", {"required":true,"range":[0,25]});  
            }
        }
    }

    
}

function tab3_validation(next_step,current_step)
{
    $('input, select, textarea').each(function() {
        $(this).removeClass('error');
    });
    
    $('#job_form3').removeData('validator'); 

    var clearance_department_id_flag= Boolean($('#clearance_department_required').val());

    
    $("#job_form3").validate({ 
          ignore: '.ignore',
          focusInvalid: true, 
          errorClass: 'error is-invalid',
          validClass: 'is-valid',
          debug:true,
          rules: {      
            "acceptance_issuing_id": { required: true }    
            <?php echo $validate_3_form; ?>       
          },
          messages:
          {
            acceptance_issuing_id:{required:'Required' }
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
              console.log('Success');

              form_submit('submit');
            
              return false;
            
          }
    });

    if($('.job_status').length > 0)
    {
      $("input[name*='approval_status']").rules("add", "required");   
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

            console.log('FFFFFFFFFFFFFFFFFF ',"'"+field_name+"'");
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

  var pre_arr=new Array('precautions_mandatory','confined_space','electrical','excavations','hotworks','materials','scaffoldings','utp','workatheights','permit_type','checkpoints','loto_ia_checkox','pa_equip_identified','other_inputs');
  
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

      $("#job_form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled',true);   
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
</script>



  </body>
</html>

  