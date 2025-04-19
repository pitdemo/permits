<div class="row g-5 extends" style="display:<?php echo (in_array($approval_status,array(WAITING_IA_EXTENDED)) || $jobs_extends_avail>0) ? 'block' : 'none'; ?>;">
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

      

      $ext_columns=array('schedule_from_dates'=>'From Date','schedule_to_dates'=>'To Date','ext_performing_authorities'=>'PA','ext_performing_authorities_dates'=>'PA Signed Date','ext_issuing_authorities'=>'IA','ext_issuing_authorities_dates'=>'IA Signed Date','ext_oxygen_readings'=>'%  of  Oxygen level <br>19.5  to  23.5  %','ext_gases_readings'=>'Combustible gases<br> 0  %','ext_carbon_readings'=>'Carbon Monoxide<br>0-25  ppm','ext_reference_codes'=>'Reference Code');
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
if($records['is_loto']==YES && $final_status_date!='') { ?>
<div class="loto_sections_completion"  data-id="8" style="display:<?php echo (in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION,APPROVED_IA_CANCELLATION,APPROVED_IA_COMPLETION))) ? 'block' : 'none'; ?>;">
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
                        $form1_button_name='Approve'; $final_submit=1;
                    }
                    break;
              case 3:
                      $input_department=$isolate_types;
                      $input_skip_value='';
                      if($user_id==$input_value && $input_date_value=='' && $prev_input_date_value!='')
                      {
                          $input_date_value=date('d-m-Y H:i');
                          $form1_button_name='Approve'; 
                          $final_submit=1;
                      }
                      break;
              case 4:
                    $input_skip_value=$user_id;
                    if($user_id==$input_value && $input_date_value=='' && $prev_input_date_value!='')
                    {
                        $input_date_value=date('d-m-Y H:i');
                        $form1_button_name='Approve'; 
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
                          $form1_button_name='Approve'; 
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
<?php } 

  if($final_status_date!='')
  {

  ?>
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
  <div class="row g-5"><div class="col-xl-12">&nbsp;</div></div>
  <?php
  }
  ?>