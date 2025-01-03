<?php 
error_reporting(0);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Eip_checklists extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		$this->load->model(array('public_model','security_model','departments_model','Zones_model','jobs_isolations_model'));	
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}
	public function index() // list the item lists
	{
		$this->security_model->chk_is_admin();    

		$c_id = array_search('zone_id',$this->uri->segment_array());
        $id='';
		
		$where='1=1';
        if($c_id !==FALSE && $this->uri->segment($c_id+1))
        {
            $id = $this->uri->segment($c_id+1);  
			  
            $this->data['id']=$id;
			
			$where.=' AND zone_id = "'.$id.'"';
        }  
		

		$this->data['zones'] = $this->Zones_model->get_details(array('conditions'=>'status!= "'.STATUS_DELETED.'"'))->result_array();

		$check_lists=$this->public_model->get_data(array('table'=>EIP_CHECKLISTS,'select'=>'equipment_name,id,equipment_number,status','column'=>'equipment_name','dir'=>'asc','where_condition'=>$where));

        $this->data['checklists']=$check_lists;
		
		$this->load->view($this->data['controller'].'lists',$this->data);
	}

	public function form($id='')
	{
		$this->security_model->chk_is_admin();    

		$this->data['zones'] = $this->Zones_model->get_details(array('conditions'=>'status!= "'.STATUS_DELETED.'"'))->result_array();	

		$this->data['brand_details']=array();

		if(!empty($id))
		{
			 $brands= $this->public_model->get_data(array('table'=>EIP_CHECKLISTS,'select'=>'equipment_name,id,equipment_number,status,zone_id','column'=>'equipment_name','dir'=>'asc','where_condition'=>$where="id ='".$id."'"));
			 if($brands->num_rows()>0)
			 	$this->data['brand_details']=$brands->row_array();
		}
			
		$this->form_validation->set_rules('equipment_name', 'Equipment Name', 'trim|required');
		$this->form_validation->set_rules('equipment_number', 'Equipment Number', 'trim|required');
		$this->form_validation->set_rules('zone_id', 'Zone id', 'trim|required');

		$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	

		if($this->form_validation->run() == TRUE)
		{
			$item_details = array(
										'equipment_name' => strip_tags($this->input->post('equipment_name')),		
										'zone_id' => strip_tags($this->input->post('zone_id')),		
										'equipment_number' => strip_tags($this->input->post('equipment_number')),										
										'modified'=>date('Y-m-d H:i:s'),									
									);			
			if(!empty($id))
			{											
				$this->db->where('id',$id);
				$this->db->update(EIP_CHECKLISTS,$item_details); //update
			}
			else
				$this->db->insert(EIP_CHECKLISTS,$item_details);
				
			$this->session->set_flashdata('message','Data has been updated successfully.'); 

			redirect($this->data['controller']);
		}

		$this->load->view($this->data['controller'].'form',$this->data);
	}


	    // Change status Active, Inactive and Deleted for Company Users
    public function ajax_update_status()
	{
		$this->security_model->chk_is_admin();    
		
        $response='';
        $status = $this->input->post('status');
        if(is_array($this->input->post('id'))){
            $i=0;
            foreach ( $this->input->post('id') as $value) {
                $ids[$i]=$value;
                $i++;
            }
            $this->db->where_in('id', $ids);
            $status = $this->input->post('status');
            $response='bulk';
        }
        else{
            $id=$this->input->post('id');
            $this->db->where('id',$id);   
            if($status=='active'){
                $response=STATUS_INACTIVE;
            }
            else if($status=='inactive'){
                $response=STATUS_ACTIVE;
            }
            else{
                $response=STATUS_DELETED;
            }
            $status = $response;
        }
        $this->db->set('status',$status);
        $this->db->update(EIP_CHECKLISTS);
		
		#echo $this->db->last_query(); 
        echo $response; exit;
    }

	public function ajax_get_eip_checklists()
	{

		#error_reporting(0);

		$departments=$this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();

		$user_id=$this->session->userdata('user_id');
		$session_department_id=$this->session->userdata('department_id');
		$session_is_isolator=$this->session->userdata('is_isolator');

		$isolations=$this->public_model->get_data(array('table'=>ISOLATION,'select'=>'name,id,record_type,isolation_type_id,status','where_condition'=>'1=1'));

		$isolations=$isolations->result_array();

		
		

		$zone_id=$this->input->post('zone_id');//121; //$this->input->post('zone_id'); //58
		$job_id = $this->input->post('job_id');

	


		$job_isolations=$this->public_model->get_data(array('table'=>JOBSISOLATION,'select'=>'*','where_condition'=>'job_id = "'.$job_id.'" AND zone_id = "'.$zone_id.'"'))->row_array();

		$acceptance_performing_id=$acceptance_issuing_id=$approval_status=$acceptance_issuing_approval=$acceptance_custodian_id=$eq_given_local='';
		$loto_closure_ids=$loto_closure_ids_dates=array();

		$acceptance_custodian_approval=NO;
		$d_id=$session_department_id;
		if($job_id>0) { 
			$jobs=$this->public_model->get_data(array('select'=>'id,acceptance_issuing_id,cancellation_issuing_id,approval_status,status,last_updated_by,last_modified_id,acceptance_performing_id,acceptance_issuing_approval,loto_closure_ids,loto_closure_ids_dates,acceptance_custodian_id,acceptance_custodian_approval,department_id','where_condition'=>'id ="'.$job_id.'"','table'=>JOBS))->row_array();

			$acceptance_performing_id=$jobs['acceptance_performing_id'];
			$acceptance_issuing_id=$jobs['acceptance_issuing_id'];
			$acceptance_custodian_id=$jobs['acceptance_custodian_id'];
			$approval_status=$jobs['approval_status'];
			$acceptance_custodian_approval=$jobs['acceptance_custodian_approval'];
			$acceptance_issuing_approval=$jobs['acceptance_issuing_approval'];
			$loto_closure_ids=(isset($jobs['loto_closure_ids']) && $jobs['loto_closure_ids']!='') ?  json_decode($jobs['loto_closure_ids'],true) : array();
			$loto_closure_ids_dates=(isset($jobs['loto_closure_ids_dates']) && $jobs['loto_closure_ids_dates']!='') ?  json_decode($jobs['loto_closure_ids_dates'],true) : array();
			$d_id=$jobs['department_id'];
		}

        $where_condition='isl.department_id IN('.$d_id.')';

		$isolation_users = $this->jobs_isolations_model->get_isolation_users(array('where'=>$where_condition))->result_array();

		$re_energy_isolations=0;
		$job_pre_isolations_array=$loto_logs_array=array();
		//Getting Lotos pre isolation
		if($job_id>0) //&& in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION)) && $session_is_isolator==YES
		{
			$job_pre_isolations=$this->public_model->join_fetch_data(array('select'=>'COUNT(ji.id) as  total_active,ji.jobs_lotos_id,j.eip_checklists_id','table1'=>LOTOISOLATIONSLOG.' ji','table2'=>LOTOISOLATIONS.' j','join_type'=>'inner','join_on'=>'ji.jobs_lotos_id=j.id','where'=>'ji.eip_checklists_id=j.eip_checklists_id AND ji.status="'.STATUS_ACTIVE.'"','num_rows'=>false,'group_by'=>'ji.jobs_lotos_id'));

			#echo $this->db->last_query();

			$job_pre_isolations_nums=$job_pre_isolations->num_rows();
			$job_pre_isolations_array=array_values($job_pre_isolations->result_array());
			//Get Loto Logs to the job
			$loto_logs=$this->public_model->get_data(array('table'=>LOTOISOLATIONSLOG,'select'=>'*','where_condition'=>'job_id = "'.$job_id.'"'));

			$loto_logs_num_rows=$loto_logs->num_rows();

			if($loto_logs_num_rows>0) {
			 $loto_logs_array=array_values($loto_logs->result_array());
			}

		}

		#echo '<pre>'; print_r($job_pre_isolations_array); print_r($loto_logs_array);

		$fetch=$this->public_model->get_data(array('table'=>EIP_CHECKLISTS,'select'=>'equipment_name,id,equipment_number','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND zone_id="'.$zone_id.'" AND equipment_number!=""','column'=>'equipment_name','dir'=>'asc'));
		
		$num_rows=$fetch->num_rows();



		$checklists=$fetch->result_array();

		//Adding default Others to all zones
		$others_array[]=array('id'=>'9999','equipment_name'=>'Others','equipment_number'=>'');

		$checklists=array_merge($checklists,$others_array);

		$num_rows=count($checklists);

		if($num_rows>5)
			$num_rows=5;

		$eq_given_locals=(isset($job_isolations['eq_given_local'])) ? json_decode($job_isolations['eq_given_local']) : array();


		$equipment_descriptions=(isset($job_isolations['equipment_descriptions'])) ? json_decode($job_isolations['equipment_descriptions']) : array();


		if(count((array)$eq_given_locals)>0)
			$num_rows=count((array)$eq_given_locals);

		#echo 'Final Result '.count((array)$eq_given_locals);


		$equipment_tag_nos=(isset($job_isolations['equipment_tag_nos'])) ? json_decode($job_isolations['equipment_tag_nos']) : array();

		$eq_names=(isset($job_isolations['equipment_descriptions_name']) && $job_isolations['equipment_descriptions_name']!='') ? json_decode($job_isolations['equipment_descriptions_name']) : array();

		$isolate_types=(isset($job_isolations['isolate_types'])) ? json_decode($job_isolations['isolate_types']) : array();

		$isolated_tagno1=(isset($job_isolations['isolated_tagno1'])) ? json_decode($job_isolations['isolated_tagno1']) : array();

		$isolated_tagno2=(isset($job_isolations['isolated_tagno2'])) ? json_decode($job_isolations['isolated_tagno2']) : array();

		$isolated_tagno3=(isset($job_isolations['isolated_tagno3'])) ? json_decode($job_isolations['isolated_tagno3']) : array();

		$re_energizeds=(isset($job_isolations['re_energized'])) ? json_decode($job_isolations['re_energized']) : array();

		$isolated_user_ids=(isset($job_isolations['isolated_user_ids'])) ? json_decode($job_isolations['isolated_user_ids']) : array();

		$isolated_user_ids=(isset($job_isolations['isolated_user_ids'])) ? json_decode($job_isolations['isolated_user_ids']) : array();

		$isolated_name_approval_datetimes = (isset($job_isolations['isolated_name_approval_datetime'])) ? json_decode($job_isolations['isolated_name_approval_datetime']) : array();

		$isolated_ia_names=(isset($job_isolations['isolated_ia_name'])) ? json_decode($job_isolations['isolated_ia_name']) : array();

		$remarks_issuing_approval=''; $filtered_array=array();

		$count=0;

		#echo '<pre>'; print_r($equipment_descriptions);

		if(isset($eq_given_locals))
			$count=count($eq_given_locals);

		$disable_all=$checkbox_disable=($remarks_issuing_approval=='Yes' || $count==0) ? "disabled='disabled'" : '';		

		$rows='<thead>
					<tr>
					<th colspan="4" align="center"><b>C) To be filled by Permit initiator and checked by issuer</b></th>
					<th colspan="3" align="center"><b>D) To be filled by authorized isolator who is carrying out isolations</b> '.(($acceptance_issuing_approval!=YES) ? '(<a href="javascript:void(0);" class="loto_add_more" style="color:red;">Add More</a>)' : '').'</th>
					</tr>
				</thead>
				<thead>
					<tr>
					<th style="text-align:center:" width="15%">Eq.Given in Local</th>
					<th style="text-align:center:" width="15%">Eq.Details</th>
					<th style="text-align:center:" width="20%">Equip Tag No</th>
					<th style="text-align:center:" width="15%">Type of Isolation</th>
					<th style="text-align:center:" width="15%" class="text-orange">PA Lock & ISO Lock No</th>					
					<th style="text-align:center:"  width="15%" >Name of the Isolator</th>
					<th style="text-align:center:"  width="15%" >Signature Date & Time</th>
					</tr>
				</thead>';
		
		$re_energized_val='';
		for($i=1;$i<=$num_rows;$i++)
		{
			$radio_yes_check=$radio_no_check=$type_isolation=$description_equipment=$isolated_tag1=$isolated_tag2=$isolated_tag3=$isolation_type_user_id=$isolated_name_approval_datetime=$isolated_ia_name=$eq_name='';

			$disabled_pa_inputs="disabled='disabled'";

			$disabled_iso_inputs=$disabled_iso_name_inputs="disabled='disabled'";

			$radio_check='';

			if($count>0)
			{

				$eq_given_local = (isset($eq_given_locals->$i)) ? $eq_given_locals->$i : '';

				$description_equipment=(isset($equipment_descriptions->$i)) ? $equipment_descriptions->$i : '';

				$eq_name=(isset($eq_names->$i)) ? $eq_names->$i : '';

				$type_isolation=(isset($isolate_types->$i)) ? $isolate_types->$i : '';
				
				$isolated_tag1=(isset($isolated_tagno1->$i)) ? $isolated_tagno1->$i : '';

				$isolated_tag2=(isset($isolated_tagno2->$i)) ? $isolated_tagno2->$i : '';

				$isolated_tag3=(isset($isolated_tagno3->$i)) ? $isolated_tagno3->$i : '';

				$re_energized_val=(isset($re_energizeds->$i)) ? $re_energizeds->$i : '';				

				$isolation_type_user_id=(isset($isolated_user_ids->$i)) ? explode(',',$isolated_user_ids->$i) : '';

				$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes->$i)) ? $isolated_name_approval_datetimes->$i : '';

				$isolated_ia_name=(isset($isolated_ia_names->$i)) ? $isolated_ia_names->$i : '';

				//PA OR Custodian
				if(in_array($user_id,array($acceptance_performing_id,$acceptance_issuing_id,$acceptance_custodian_id)) &&   in_array($approval_status,array(WAITING_CUSTODIAN_ACCPETANCE)) && $description_equipment!=''){
					$disabled_pa_inputs='';
				} 
				else if(in_array($user_id,array($acceptance_issuing_id)) &&   in_array($approval_status,array(WAITING_IA_ACCPETANCE)) && $eq_given_local!=''){
					$disabled_pa_inputs=$disabled_iso_name_inputs=$disabled_iso_inputs='disabled="disabled"';
					
				}
				else if(in_array($approval_status,array(WAITING_ISOLATORS_COMPLETION,APPROVED_ISOLATORS_COMPLETION))) {
					$disabled_pa_inputs=$disabled_iso_inputs=$disabled_iso_name_inputs='disabled="disabled"';

					if(in_array($user_id,$isolation_type_user_id) && $isolated_name_approval_datetime=='')
					{
						$isolated_name_approval_datetime = date('d-m-Y H:i');

						$disabled_iso_inputs='';
					} else 
					{
						//Assign Open Isolators
						/*
						if($session_is_isolator==YES && $isolated_name_approval_datetime=='')
						{
							$filtered_array = array_filter($isolation_users, function($val) use($session_department_id,$type_isolation,$user_id) {
							return ($val['department_id']==$session_department_id and $val['isolation_id']==$type_isolation and $val['id']==$user_id);
							});
							
							if(count($filtered_array)>0){

								$isolated_name_approval_datetime = date('d-m-Y H:i');

								$disabled_iso_inputs='';

								$disabled_iso_name_inputs='disabled=disabled';

								$isolation_type_user_id=$user_id;
							}
							
						}*/
					} 
				} else {
					$disabled_pa_inputs=$disabled_iso_inputs=$disabled_iso_name_inputs='disabled="disabled"';
				}
			} 
			
			$gen_checklist=$this->generate_checklists($checklists,$i,$description_equipment,$count,($description_equipment!='' && in_array($user_id,array($acceptance_performing_id,$acceptance_custodian_id)) && in_array($approval_status,array(WAITING_CUSTODIAN_ACCPETANCE)) ? '' : $disabled_pa_inputs));

			$generate_checklist=$gen_checklist['select'];

			$equipment_number=$gen_checklist['equipment_number'];

			if($description_equipment!=9999){
				$filtered = array_filter($isolations, function ($val) { return $val['status'] == STATUS_ACTIVE; });
			} else {
				$filtered=$isolations;
			}

			$generate_isolations=$this->generate_isolations($filtered,$i,$type_isolation,$disabled_pa_inputs);

			$remarks=(isset($equipment_remarks->$i)) ? $equipment_remarks->$i : '';

			$generate_isolation_users = $this->generate_isolation_type_users($isolation_users,$type_isolation,'',$isolation_type_user_id,$filtered_array);

			$generate_departments = $this->generate_departments($departments,$isolated_ia_name);

			$eq_given_in_local_options = $this->eq_given_in_local_options($eq_given_local,$i,($count==0 || (in_array($user_id,array($acceptance_performing_id,$acceptance_custodian_id)) && in_array($approval_status,array(WAITING_CUSTODIAN_ACCPETANCE))) ? '' : $disabled_pa_inputs)); 

			$radio_yes_check='';

			$readonly='readonly';
			$show_re_energized='none';
			$show_re_energized_checked='';
			$show_re_energized_disabled='disabled';

			$re_energized=$description_equipment;

			$show_log=$show_equipment_number='none';

			$input_date_value=(isset($loto_closure_ids_dates[3]) && $loto_closure_ids_dates[3]!='')  ? $loto_closure_ids_dates[3] : '';

			$input_isolator_closure_id=(isset($loto_closure_ids[3]) && $loto_closure_ids[3]!='')  ? $loto_closure_ids[3] : '';

			if($description_equipment==9999){
				if($acceptance_custodian_approval==NO)
				$readonly='';
			
				$equipment_number=(isset($equipment_tag_nos->$i)) ? $equipment_tag_nos->$i : ''; 
				$show_equipment_number='show';
				
				if($input_isolator_closure_id==$user_id && $session_is_isolator==YES && $input_date_value=='') {
				$show_re_energized='blank';
				$show_re_energized_disabled=''; }
			} else {
				
				//Check if the description is available or not in the exisitng loto
				if(count($job_pre_isolations_array)>0) 
				{ 
					if($description_equipment!='')
					$show_log='blank';

					$filtered = array_values(array_filter($job_pre_isolations_array, function ($val) use($description_equipment) { return $val['eip_checklists_id'] == $description_equipment && $val['total_active']==1; }));
					
					$show_re_energized_disabled='';

					if(count($filtered)>0 && count($loto_logs_array)>0)
					{
						$filtered=$filtered[0];

						$jobs_lotos_id=$filtered['jobs_lotos_id'];

						$filtered = array_values(array_filter($loto_logs_array, function ($val) use($jobs_lotos_id,$description_equipment) { return $val['eip_checklists_id'] == $description_equipment && $val['jobs_lotos_id']==$jobs_lotos_id; }));
						
						if(count($filtered)>0){

							$filtered=$filtered[0];

							$re_energized=$filtered['jobs_lotos_id'];

							if($input_isolator_closure_id==$user_id && $session_is_isolator==YES && $input_date_value=='')
							$show_re_energized='blank';
						}

					} else {

						$filtered = array_values(array_filter($loto_logs_array, function ($val) use($description_equipment) { return $val['eip_checklists_id'] == $description_equipment; }));

						if(count($filtered)>0){

							$filtered=$filtered[0];

							$re_energized=$filtered['jobs_lotos_id'];

						}

					}
					
				} else 
				{
						
				}
			}

			if($re_energized_val!='') {
				$show_re_energized='blank';
				$show_re_energized_checked='checked';
			}

			
			$rows.='<TR id="equip_row_id'.$i.'" data-row-id="'.$i.'">';

			$rows.='<td>'.$eq_given_in_local_options.'</td>';
			
			$rows.='<TD>'.$generate_checklist.'&nbsp;<input type="text" class="form-control equipment_descriptions_name equipment_descriptions_name'.$i.'" name="equipment_descriptions_name['.$i.']" id="equipment_descriptions_name['.$i.']"  '.$disabled_pa_inputs.' value="'.$eq_name.'" style="display:'.$show_equipment_number.';"/></TD><TD ><input   type="text" '.$readonly.' class="form-control equipment_tag_no equipment_tag_no'.$i.'" name="equipment_tag_nos['.$i.']" id="equipment_tag_no['.$i.']" value="'.$equipment_number.'"  /></td>';
			
			$rows.='<td>'.$generate_isolations.'</td>';
			
			$rows.='<TD ><input type="text" class="form-control isolated_pa_tagno isolated_tagno1'.$i.'" name="isolated_tagno1['.$i.']" id="isolated_tagno1['.$i.']" value="'.$isolated_tag1.'" '.$disabled_pa_inputs.'/>&nbsp;';
			
			$rows.='<input type="text" class="form-control isolated_ia_tagno isolated_tagno3'.$i.'" name="isolated_tagno3['.$i.']" id="isolated_tagno3['.$i.']" value="'.$isolated_tag3.'" '.$disabled_iso_inputs.'/>&nbsp;<label class="form-check" style="display:'.$show_re_energized.';">
                                <input class="form-check-input re_energized re_energized'.$i.'" type="checkbox" name="re_energized['.$i.']" class="re_energized'.$i.' re_energized" value="'.$re_energized.'" '.$show_re_energized_checked.' '.$show_re_energized_disabled.' data-id="'.$i.'">
                                <span class="form-check-label">Energised</span>
                              </label>';
			$rows.='</td>';
			
			//
			$rows.='<td><select name="isolated_user_ids['.$i.']" id="isolated_user_ids['.$i.']" class="form-control isolated_user_ids data-iso-name eq_select_iso  isolated_user_ids'.$i.'" data-attr="'.$i.'" '.$disabled_iso_name_inputs.'  multiple required>'.$generate_isolation_users.'</select>&nbsp;&nbsp;<label class="form-check" style="display:'.$show_log.';"><a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#modal-scrollable" data-loto-id="'.$re_energized.'" data-job-id="'.$job_id.'" data-id="'.$i.'" class="re_energized_log" style="color:red;text-decoration:underline;">
                    Tag Logs
                  </a></label></td>';
			
			$rows.='<td><input type="text" class="form-control isolated_name_approval_datetime isolated_name_approval_datetime'.$i.'" name="isolated_name_approval_datetime['.$i.']" id="isolated_name_approval_datetime['.$i.']" value="'.$isolated_name_approval_datetime.'" disabled style="font-size:11px;"/><div></div></td></tr>';
			
		}
		
	#	$rows.='</table>';
		

//$rows.='<script>$(document).ready(function() { $(".select2").select2({placeholder: "- - Select - - "});  });</script>';

		echo json_encode(array('rows'=>$rows,'zone_id'=>$zone_id,'num_rows'=>$num_rows)); exit;
	}

	public function ajax_get_lotos_logs()
	{
		$jobs_loto_id=$this->input->post('jobs_loto_id');

		$job_pre_isolations=$this->public_model->join_fetch_data(array('select'=>'j.permit_no,jll.created,jll.status,j.id','table1'=>LOTOISOLATIONSLOG.' jll','table2'=>JOBS.' j','join_type'=>'inner','join_on'=>'jll.job_id=j.id','where'=>'jll.jobs_lotos_id="'.$jobs_loto_id.'"','num_rows'=>false,'custom_order'=>'j.id desc'));

		$nums=$job_pre_isolations->num_rows();

		$response='<table class="table mb-0" border="1"><thead><tr><td>Permit No</td><td>Status</td><td>Created</td></tr>';

		if($nums>0){

			$fetch=$job_pre_isolations->result_array();

			foreach($fetch as $fet)
			{
				$response.='<tr>';
				$response.='<td><a href="'.base_url().'jobs/form/id/'.$fet['id'].'" target="_blank">'.$fet['permit_no'].'</a></d>';

				$response.='<td style="color:'.($fet['status']=='active' ? 'green' : 'red').'">'.ucfirst($fet['status']).'</td>';

				$response.='<td>'.date('d-m-Y H:i A',strtotime($fet['created'])).'</td>';

				$response.='</tr>';
			}
		} else {
				$response.='<tr><td colspan="3">No Logs Found</td></tr>';
		}

		echo json_encode(array('response'=>$response));
	}	
	
	public function eq_given_in_local_options($val='',$i,$disable)
	{
		$arr=array(YES,NO);

		$return='<select name="eq_given_local['.$i.']" id="eq_given_local['.$i.']" class="form-control eq_given_local data-iso-name  eq_given_local'.$i.'" data-attr="'.$i.'" data-id="'.$i.'" '.$disable.'><option value="" selected>- - Select - -</option>';

		foreach($arr as $key => $list):

			$sel = $list==$val ? 'selected' : '';

			$return.='<option value="'.$list.'" '.$sel.'>'.$list.'</option>';

		endforeach;

		$return.='</select>';

		return $return;

	}
	
	public function generate_checklists($checklists,$i,$selected_checklist='',$is_existing_selection,$disable)
	{
		$select='<select name="equipment_descriptions['.$i.']" '.$disable.' id="equipment_descriptions['.$i.']" class="form-control equipment_descriptions'.$i.' equip_desc equipment_descriptions equip_desc_dropdown eq_select2" data-id="'.$i.'"><option value="" selected="selected">- - Select - -</option>';

		$j=1;

		$eq_number='';

		foreach($checklists as $fet)
		{							  
			$id=$fet['id'];
			  
			$name=$fet['equipment_name'];

			$equipment_number=$fet['equipment_number'];
			  
			$chk='';
			 
			 if($is_existing_selection>0)
			 {
			 	if($selected_checklist==$id) $chk='selected';
			 }
			 else
			 { 
				 #if($j==$i) $chk='selected';
			 }	
			
			if($chk!='')
			$eq_number=$equipment_number;		

			$select.='<option value="'.$id.'" '.$chk.' data-eq-no="'.$equipment_number.'">'.$name.'</option>';

			$j++;

		 }

		 $select.='</select>';	

		 return array('select'=>$select,'equipment_number'=>$eq_number);;
	}

	public function generate_isolations($isolations,$i,$isolate_type='',$disable_all)
	{

		$select='<select name="isolate_types['.$i.']" '.$disable_all.' id="isolate_type['.$i.']" class="isolate_types form-control isolate_type'.$i.'" data-id="'.$i.'"><option value="" selected="selected">- - Select - -</option>';

		 foreach($isolations as $fet)
		 {
	 		  $record_type=$fet['record_type'];
											  
			  $id=$fet['id'];
			  
			  $name=$fet['name'];
			  
			  $chk='';
			  
			  if($record_type=='isolation_type')
			  {
					if($isolate_type==$id) $chk='selected';

	 				$select.='<option value="'.$id.'" '.$chk.'>'.$name.'</option>';
	 		  }	

		 }

		 $select.='</select>';	

		 return $select;
	}

	public function ajax_generate_isolations()
	{
		$equipment_descriptions_id=$this->input->post('equipment_descriptions_id');

		$permit_id=$this->input->post('permit_id');

		$where="record_type='isolation_type' ";

		if($equipment_descriptions_id!=9999)
		{
			$where.=" AND status='".STATUS_ACTIVE."'";
		}

		$isolations=$this->public_model->get_data(array('table'=>ISOLATION,'select'=>'name,id,record_type,isolation_type_id','where_condition'=>$where));

		$isolations=$isolations->result_array();
		
		$options='<option value="" selected="selected">- - Select - -</option>';

		foreach($isolations as $fet)
		{
			$record_type=$fet['record_type'];
											
			$id=$fet['id'];
			
			$name=$fet['name'];
			
			$chk='';
			
			if($record_type=='isolation_type')
			{
				$options.='<option value="'.$id.'" '.$chk.'>'.$name.'</option>';
			}	

		}	

		echo json_encode(array('options'=>$options));
	}

	public function generate_isolation_type_users($users,$isolate_type='',$disable_all,$isolation_type_user_id='',$filtered_array)
	{
		//$select = '<option value="" selected>Select</option>';

		#$isolation_type_user_id=explode(',',$isolation_type_user_id);

		 foreach($users as $fet)
		 {
	 		  $isolation_id=$fet['isolation_id'];
											  
			  $id=$fet['id'];
			  
			  $name=$fet['first_name'];
			  
			  $chk=''; $flag=1;
			  
			  if($isolation_id==$isolate_type)
			  {
					if(in_array($id,$isolation_type_user_id)) $chk='selected';

					if(count($filtered_array)>0)
					{	
						if(in_array($id,$isolation_type_user_id))
							$flag=1;
						else 
							$flag='';
					}

					if($flag==1)
					$select.='<option value="'.$id.'" '.$chk.'>'.$name.'</option>';
			  }

		 }

		 return $select;
	}

	public function ajax_get_generate_isolations()
	{  

		$select='<select name="isolate_types['.$i.']"  id="isolate_type['.$i.']" class="isolate_types form-control isolate_type'.$i.'" data-id="'.$i.'"><option value="" selected="selected">- - Select - -</option>';

		 foreach($isolations as $fet)
		 {
	 		  $record_type=$fet['record_type'];
											  
			  $id=$fet['id'];
			  
			  $name=$fet['name'];
			  
			  $chk='';
			  
			  if($record_type=='isolation_type')
			  {
					

	 				$select.='<option value="'.$id.'">'.$name.'</option>';
	 		  }	

		 }

		 $select.='</select>';	

		 return $select;
	}

	public function generate_departments($departments,$department_id='')
	{
		$select = '<option value="" selected>Select</option>';

		 foreach($departments as $fet)
		 { 						  
			  $id=$fet['id'];
			  
			  $name=$fet['name'];
			  
			  $chk='';
			  
			  if($department_id==$id) $chk='selected';

			  $select.='<option value="'.$id.'" '.$chk.'>'.$name.'</option>';
			  

		 }

		 return $select;
	}


	public function ajax_get_sop_wi()
	{
		$file_name=$this->input->post('file_name');

		$ret='<embed src="'.$file_name.'" frameborder="0" width="100%" height="800px"  class="show_image" id="show_image_emb">';

		echo json_encode(array('response'=>$ret));

		exit;
	}
}
?>
