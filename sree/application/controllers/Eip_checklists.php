<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eip_checklists extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

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

		$isolations=$this->public_model->get_data(array('table'=>ISOLATION,'select'=>'name,id,record_type,isolation_type_id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));

		$isolations=$isolations->result_array();

		$isolation_users = $this->jobs_isolations_model->get_isolation_users(array())->result_array();

		$zone_id=$this->input->post('zone_id');//121; //$this->input->post('zone_id'); //58
		$job_id = $this->input->post('job_id');

		$job_isolations=$this->public_model->get_data(array('table'=>JOBSISOLATION,'select'=>'*','where_condition'=>'job_id = "'.$job_id.'" AND zone_id = "'.$zone_id.'"'))->row_array();

		$jobs=$this->public_model->get_data(array('select'=>'id,acceptance_issuing_id,cancellation_issuing_id,approval_status,status,last_updated_by,last_modified_id,acceptance_performing_id','where_condition'=>'id ="'.$job_id.'"','table'=>JOBS))->row_array();

		$acceptance_performing_id=$jobs['acceptance_performing_id'];
		$acceptance_issuing_id=$jobs['acceptance_issuing_id'];
		$approval_status=$jobs['approval_status'];


		$fetch=$this->public_model->get_data(array('table'=>EIP_CHECKLISTS,'select'=>'equipment_name,id,equipment_number','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND zone_id="'.$zone_id.'" AND equipment_number!=""','column'=>'equipment_name','dir'=>'asc'));
		
		$num_rows=$fetch->num_rows();

		$checklists=$fetch->result_array();

		$equipment_descriptions=(isset($job_isolations['equipment_descriptions'])) ? json_decode($job_isolations['equipment_descriptions']) : array();

		$equipment_tag_nos=(isset($job_isolations['equipment_tag_nos'])) ? json_decode($job_isolations['equipment_tag_nos']) : array();

		$isolate_types=(isset($job_isolations['isolate_types'])) ? json_decode($job_isolations['isolate_types']) : array();

		$isolated_tagno1=(isset($job_isolations['isolated_tagno1'])) ? json_decode($job_isolations['isolated_tagno1']) : array();

		$isolated_tagno2=(isset($job_isolations['isolated_tagno2'])) ? json_decode($job_isolations['isolated_tagno2']) : array();

		$isolated_tagno3=(isset($job_isolations['isolated_tagno3'])) ? json_decode($job_isolations['isolated_tagno3']) : array();

		$isolated_user_ids=(isset($job_isolations['isolated_user_ids'])) ? json_decode($job_isolations['isolated_user_ids']) : array();

		$isolated_user_ids=(isset($job_isolations['isolated_user_ids'])) ? json_decode($job_isolations['isolated_user_ids']) : array();

		$isolated_name_approval_datetimes = (isset($job_isolations['isolated_name_approval_datetime'])) ? json_decode($job_isolations['isolated_name_approval_datetime']) : array();

		$isolated_ia_names=(isset($job_isolations['isolated_ia_name'])) ? json_decode($job_isolations['isolated_ia_name']) : array();

		$remarks_issuing_approval=''; $filtered_array=array();

		$count=0;

		#echo '<pre>'; print_r($equipment_descriptions);

		if(isset($equipment_descriptions))
			$count=count($equipment_descriptions);

		#echo '<pre>'; print_r($equipment_descriptions);

		#echo '<br /> count '.$count;

		$disable_all=$checkbox_disable=($remarks_issuing_approval=='Yes' || $count==0) ? "disabled='disabled'" : '';

		$rows='<thead>
					<tr>
					<th colspan="4" align="center"><b>C) To be filled by Permit initiator and checked by issuer</b></th>
					<th colspan="3" align="center"><b>D) To be filled by authorized isolator who is carrying out isolations</b></th>
					</tr>
				</thead>
				<thead>
					<tr>
					<th style="text-align:center:" width="15%">Eq.Details</th>
					<th style="text-align:center:" width="20%">Equip Tag No</th>
					<th style="text-align:center:" width="15%">Type of Isolation</th>
					<th style="text-align:center:" width="15%" >PA Lock & Tag No</th>
					<th style="text-align:center:" width="15%" class="text-orange">ISO Lock No</th>
					<th style="text-align:center:"  width="15%" >Name of the Isolator</th>
					<th style="text-align:center:"  width="15%" >Signature Date & Time</th>
					</tr>
				</thead>';
		
		if($num_rows>0)
		{
			for($i=1;$i<=$num_rows;$i++)
			{
				$radio_yes_check=$radio_no_check=$type_isolation=$description_equipment=$isolated_tag1=$isolated_tag2=$isolated_tag3=$isolation_type_user_id=$isolated_name_approval_datetime=$isolated_ia_name='';

				$disabled_pa_inputs="disabled='disabled'";

				$disabled_iso_inputs=$disabled_iso_name_inputs="disabled='disabled'";

				$radio_check='';

				if($count>0)
				{
					$description_equipment=(isset($equipment_descriptions->$i)) ? $equipment_descriptions->$i : '';

					$type_isolation=(isset($isolate_types->$i)) ? $isolate_types->$i : '';
					
					$isolated_tag1=(isset($isolated_tagno1->$i)) ? $isolated_tagno1->$i : '';

					$isolated_tag2=(isset($isolated_tagno2->$i)) ? $isolated_tagno2->$i : '';

					$isolated_tag3=(isset($isolated_tagno3->$i)) ? $isolated_tagno3->$i : '';

				    $isolation_type_user_id=(isset($isolated_user_ids->$i)) ? $isolated_user_ids->$i : '';

					$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes->$i)) ? $isolated_name_approval_datetimes->$i : '';

					$isolated_ia_name=(isset($isolated_ia_names->$i)) ? $isolated_ia_names->$i : '';

					if(in_array($user_id,array($acceptance_performing_id,$acceptance_issuing_id)) &&   $approval_status==WAITING_IA_ACCPETANCE && $description_equipment!=''){
						$disabled_pa_inputs=$disabled_iso_name_inputs='';
					} else if(in_array($approval_status,array(WAITING_ISOLATORS_COMPLETION,APPROVED_ISOLATORS_COMPLETION))) {
						$disabled_pa_inputs=$disabled_iso_inputs=$disabled_iso_name_inputs='disabled="disabled"';
						if($user_id==$isolation_type_user_id && $isolated_name_approval_datetime=='')
						{
							$isolated_name_approval_datetime = date('d-m-Y H:i');

							$disabled_iso_inputs=$disabled_iso_name_inputs='';
						} else 
						{
							if($session_is_isolator=='Yes' && $isolated_name_approval_datetime=='')
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
								
							}
						}
					}
				} 

				$gen_checklist=$this->generate_checklists($checklists,$i,$description_equipment,$count,($count==0 ||in_array($user_id,array($acceptance_performing_id,$acceptance_issuing_id)) &&   $approval_status==WAITING_IA_ACCPETANCE) ? '' : $disabled_pa_inputs);

				$generate_checklist=$gen_checklist['select'];

				$equipment_number=$gen_checklist['equipment_number'];

				$generate_isolations=$this->generate_isolations($isolations,$i,$type_isolation,$disabled_pa_inputs);

				$remarks=(isset($equipment_remarks->$i)) ? $equipment_remarks->$i : '';

				$generate_isolation_users = $this->generate_isolation_type_users($isolation_users,$type_isolation,'',$isolation_type_user_id,$filtered_array);

				$generate_departments = $this->generate_departments($departments,$isolated_ia_name);

				$radio_yes_check='';

				$rows.='<TR id="equip_row_id'.$i.'"><TD>'.$generate_checklist.'</TD><TD ><input   type="text" readonly class="form-control equipment_tag_no equipment_tag_no'.$i.'" name="equipment_tag_nos['.$i.']" id="equipment_tag_no['.$i.']" value="'.$equipment_number.'"  /></td>';
				
				$rows.='<td>'.$generate_isolations.'</td>';
				
				$rows.='<TD ><input type="text" class="form-control isolated_tagno1'.$i.'" name="isolated_tagno1['.$i.']" id="isolated_tagno1['.$i.']" value="'.$isolated_tag1.'" '.$disabled_pa_inputs.'/>&nbsp;<input type="text" class="form-control isolated_tagno2'.$i.'" name="isolated_tagno2['.$i.']" id="isolated_tagno2['.$i.']" value="'.$isolated_tag2.'" '.$disabled_pa_inputs.'/></td>';
				
				$rows.='<td><input type="text" class="form-control isolated_tagno3'.$i.'" name="isolated_tagno3['.$i.']" id="isolated_tagno3['.$i.']" value="'.$isolated_tag3.'" '.$disabled_iso_inputs.'/></td>';
				
				
				$rows.='<td><select name="isolated_user_ids['.$i.']" id="isolated_user_ids['.$i.']" class="form-control isolated_user_ids data-iso-name  isolated_user_ids'.$i.'" data-attr="'.$i.'" '.$disabled_iso_name_inputs.'>'.$generate_isolation_users.'</select></td>';
				
				$rows.='<td><input type="text" class="form-control isolated_name_approval_datetime'.$i.'" name="isolated_name_approval_datetime['.$i.']" id="isolated_name_approval_datetime['.$i.']" value="'.$isolated_name_approval_datetime.'" disabled/><div></div></td></tr>';
			}

		}
		else
		{
			$disabled="disabled='disabled'";

			$radio_check=''; $remarks='';

			for($i=1;$i<=EIP_CHECKLIST_MAX_ROWS;$i++)
			{

				$disabled_pa_inputs="disabled='disabled'";

				$disabled_iso_inputs=$disabled_iso_name_inputs="disabled='disabled'";


				$radio_yes_check=$radio_no_check=$type_isolation=$description_equipment=$isolated_tag1=$isolated_tag2=$isolated_tag3=$isolation_type_user_id=$equipment_tag_no=$isolated_name_approval_datetime=$isolated_ia_name='';

				if($count>0)
				{
					$description_equipment=(isset($equipment_descriptions->$i)) ? $equipment_descriptions->$i : '';

					$equipment_tag_no=(isset($equipment_tag_nos->$i)) ? $equipment_tag_nos->$i : '';

					$type_isolation=(isset($isolate_types->$i)) ? $isolate_types->$i : '';
					
					$isolated_tag1=(isset($isolated_tagno1->$i)) ? $isolated_tagno1->$i : '';

					$isolated_tag2=(isset($isolated_tagno2->$i)) ? $isolated_tagno2->$i : '';

					$isolated_tag3=(isset($isolated_tagno3->$i)) ? $isolated_tagno3->$i : '';

				    $isolation_type_user_id=(isset($isolated_user_ids->$i)) ? $isolated_user_ids->$i : '';

					$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes->$i)) ? $isolated_name_approval_datetimes->$i : '';

					$isolated_ia_name=(isset($isolated_ia_names->$i)) ? $isolated_ia_names->$i : '';

					if(in_array($user_id,array($acceptance_performing_id,$acceptance_issuing_id)) &&   $approval_status==WAITING_IA_ACCPETANCE && $type_isolation!=''){
						$disabled_pa_inputs=$disabled_iso_name_inputs='';
					} else if(in_array($approval_status,array(WAITING_ISOLATORS_COMPLETION,APPROVED_ISOLATORS_COMPLETION))) {
						$disabled_pa_inputs=$disabled_iso_inputs='disabled="disabled"';
						if($user_id==$isolation_type_user_id && $isolated_name_approval_datetime=='')
						{
							$isolated_name_approval_datetime = date('d-m-Y H:i');

							$disabled_iso_inputs='';
						}else 
						{
							if($session_is_isolator=='Yes' && $isolated_name_approval_datetime=='')
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
								
							}
						}
					}
				} else
				{
					$disabled_pa_inputs='';
				}

				
				$generate_isolations=$this->generate_isolations($isolations,$i,$type_isolation,$disabled_pa_inputs);

				$generate_isolation_users = $this->generate_isolation_type_users($isolation_users,$type_isolation,'',$isolation_type_user_id,$filtered_array);
				
				$tt=($count==0 || in_array($user_id,array($acceptance_performing_id,$acceptance_issuing_id)) &&   $approval_status==WAITING_IA_ACCPETANCE) ? '' : "disabled='disabled'";

				$generate_departments = $this->generate_departments($departments,$isolated_ia_name);

				 $rows.='<TR id="equip_row_id'.$i.'"><TD><input   type="text"   name="equipment_descriptions['.$i.']"  id="equipment_descriptions['.$i.']" class="form-control equipment_descriptions equipment_descriptions'.$i.' equip_desc_text" data-id="'.$i.'" value="'.$description_equipment.'" '.$tt.'  /></TD>';
				 
				 $rows.='<TD ><input   type="text"  class="form-control equipment_tag_no equipment_tag_no'.$i.'" name="equipment_tag_nos['.$i.']" id="equipment_tag_no['.$i.']"  value="'.$equipment_tag_no.'" '.$disabled_pa_inputs.' /></td>';
				 
				 $rows.='<TD  >'.$generate_isolations.'</td>';
				
				$rows.='<TD ><input type="text" class="form-control isolated_tagno1'.$i.'" name="isolated_tagno1['.$i.']" id="isolated_tagno1['.$i.']" value="'.$isolated_tag1.'" '.$disabled_pa_inputs.' />&nbsp;<input type="text" class="form-control isolated_tagno2'.$i.'" name="isolated_tagno2['.$i.']" id="isolated_tagno2['.$i.']" value="'.$isolated_tag2.'" '.$disabled_pa_inputs.' /></td>';
				
				$rows.='<td><input type="text" class="form-control isolated_tagno3'.$i.'" name="isolated_tagno3['.$i.']" id="isolated_tagno3['.$i.']" value="'.$isolated_tag3.'" '.$disabled_iso_inputs.'/></td>';
				
				
				$rows.='<td><select name="isolated_user_ids['.$i.']" id="isolated_user_ids['.$i.']" class="form-control isolated_user_ids data-iso-name  isolated_user_ids'.$i.'" data-attr="'.$i.'" '.$disabled_pa_inputs.'  >'.$generate_isolation_users.'</select></td>';
				
				$rows.='<td><input type="text" class="form-control isolated_name_approval_datetime'.$i.'" name="isolated_name_approval_datetime['.$i.']" id="isolated_name_approval_datetime['.$i.']" value="'.$isolated_name_approval_datetime.'"  disabled/><div></div></td></tr>';
			}	
		}
		

		echo json_encode(array('rows'=>$rows,'zone_id'=>$zone_id,'num_rows'=>$num_rows)); exit;
	}

	public function ajax_get_avi_eip_checklists()
	{

		#error_reporting(0);

		$user_id=$this->session->userdata('user_id');

		$isolations=$this->public_model->get_data(array('table'=>ISOLATION,'select'=>'name,id,record_type,isolation_type_id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));

		$isolations=$isolations->result_array();

		$isolation_users = $this->jobs_isolations_model->get_isolation_users(array())->result_array();

		$job_id = $this->input->post('job_id');

		$id=$this->input->post('avi_id');

		$avi_info=$this->public_model->get_data(array('table'=>AVIS,'select'=>'*','where_condition'=>'job_id = "'.$job_id.'" AND id = "'.$id.'"'))->row_array();

		$jobs=$this->public_model->get_data(array('select'=>'id,acceptance_issuing_id,cancellation_issuing_id,approval_status,status,last_updated_by,last_modified_id,acceptance_performing_id,zone_id,job_name,location','where_condition'=>'id ="'.$job_id.'"','table'=>JOBS))->row_array();

		$zone_info=$this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND id="'.$jobs['zone_id'].'"','column'=>'name','dir'=>'asc'))->row_array();;

		$job_info='<div class="col-md-4">
                                <div class="mb-3 mb-0">
                                  <label class="form-label">Work Description</label>
                                  <div class="form-control-plaintext">'.strtoupper($jobs['job_name']).'</div>
                                </div>
                              </div><div class="col-md-4">
                                <div class="mb-3 mb-0">
                                  <label class="form-label">Location</label>
                                  <div class="form-control-plaintext">'.strtoupper($jobs['location']).'</div>
                                </div>
                              </div><div class="col-md-4">
                                <div class="mb-3 mb-0">
                                  <label class="form-label">Zone</label>
                                  <div class="form-control-plaintext">'.strtoupper($zone_info['name']).'</div>
                                </div>
                              </div>';


		#echo $this->db->last_query();

		$zone_id=$jobs['zone_id'];


		$job_isolations=$this->public_model->get_data(array('table'=>JOBSISOLATION,'select'=>'*','where_condition'=>'job_id = "'.$job_id.'" AND zone_id = "'.$zone_id.'"'))->row_array();

		#echo $this->db->last_query();

		$acceptance_performing_id=$avi_info['acceptance_performing_id'];
		$acceptance_issuing_id=$avi_info['acceptance_issuing_id'];
		$approval_status=$avi_info['approval_status'];


		$fetch=$this->public_model->get_data(array('table'=>EIP_CHECKLISTS,'select'=>'equipment_name,id,equipment_number','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND zone_id="'.$zone_id.'" AND equipment_number!=""','column'=>'equipment_name','dir'=>'asc'));
		
		$num_rows=$fetch->num_rows();

		$checklists=$fetch->result_array();

		$equipment_descriptions=(isset($job_isolations['equipment_descriptions'])) ? json_decode($job_isolations['equipment_descriptions']) : array();

		$equipment_descriptions_count=(isset($job_isolations['equipment_descriptions'])) ? json_decode($job_isolations['equipment_descriptions'],true) : array();

		$equipment_tag_nos=(isset($job_isolations['equipment_tag_nos'])) ? json_decode($job_isolations['equipment_tag_nos']) : array();

		$isolate_types=(isset($job_isolations['isolate_types'])) ? json_decode($job_isolations['isolate_types']) : array();

		$isolated_tagno1=(isset($job_isolations['isolated_tagno1'])) ? json_decode($job_isolations['isolated_tagno1']) : array();

		$isolated_tagno2=(isset($job_isolations['isolated_tagno2'])) ? json_decode($job_isolations['isolated_tagno2']) : array();

		$isolated_tagno3=(isset($job_isolations['isolated_tagno3'])) ? json_decode($job_isolations['isolated_tagno3']) : array();

		$isolated_user_ids=(isset($avi_info['isolated_user_ids'])) ? json_decode($avi_info['isolated_user_ids']) : array();

		$closure_isolator_ids=(isset($avi_info['closure_isolator_ids'])) ? json_decode($avi_info['closure_isolator_ids']) : array();

		

		$isolated_name_approval_datetimes = (isset($avi_info['isolated_name_approval_datetime'])) ? json_decode($avi_info['isolated_name_approval_datetime']) : array();

		$isolated_name_closure_datetimes = (isset($avi_info['isolated_name_closure_datetime'])) ? json_decode($avi_info['isolated_name_closure_datetime']) : array();
	
		$isolated_ia_names=(isset($job_isolations['isolated_ia_name'])) ? json_decode($job_isolations['isolated_ia_name']) : array();

		$eq_tags = (isset($avi_info['eq_tag'])) ? json_decode($avi_info['eq_tag'],true) : array();

		$remarks_issuing_approval='';

		$count=0;

		#echo '<pre>'; print_r($isolated_name_approval_datetimes);

		if(isset($equipment_descriptions_count))
			$count=count($equipment_descriptions_count);

		#echo '<pre>'; print_r($equipment_descriptions);

		#echo '<br /> count '.$count;

		$disable_all=$checkbox_disable=($remarks_issuing_approval=='Yes' || $count==0) ? "disabled='disabled'" : '';

		$rows='
				<thead>
					<tr>
					<th style="text-align:center:" width="5%">Select</th>
					<th style="text-align:center:" width="15%">Equip Tag No</th>					
					<th style="text-align:center:" width="10%" >PA Lock & Tag No</th>
					<th style="text-align:center:" width="10%" class="text-orange">ISO Lock No</th>
					<th style="text-align:center:"  width="15%" >Name of the Isolator</th>
					<th style="text-align:center:"  width="15%" >Acceptance Signature <br />Date & Time</th>
					<th style="text-align:center:"  width="15%" >Closer Name of the Isolator</th>
					<th style="text-align:center:" width="15%">Closure <br />Date & Time</th>
					</tr>
				</thead>';
		
		if($num_rows>0)
		{
			for($i=1;$i<=$num_rows;$i++)
			{
				$disabled_isolated_inputs=$disabled_closure_isolated_inputs="disabled='disabled'";			

				$checked='';

				$radio_yes_check=$radio_no_check=$type_isolation=$description_equipment=$isolated_tag1=$isolated_tag2=$isolated_tag3=$isolation_type_user_id=$equipment_tag_no=$isolated_name_approval_datetime=$isolated_ia_name=$isolated_name_closure_datetime=$generate_closure_isolation_users='';

				if($count>0)
				{
					$description_equipment=(isset($equipment_descriptions->$i)) ? $equipment_descriptions->$i : '';

					$type_isolation=(isset($isolate_types->$i)) ? $isolate_types->$i : '';
					
					$isolated_tag1=(isset($isolated_tagno1->$i)) ? $isolated_tagno1->$i : '';

					$isolated_tag2=(isset($isolated_tagno2->$i)) ? $isolated_tagno2->$i : '';

					$isolated_tag3=(isset($isolated_tagno3->$i)) ? $isolated_tagno3->$i : '';

				    $isolation_type_user_id=(isset($isolated_user_ids->$i)) ? $isolated_user_ids->$i : '';

					$closure_isolation_type_user_id=(isset($closure_isolator_ids->$i)) ? $closure_isolator_ids->$i : '';
					
					$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes->$i)) ? $isolated_name_approval_datetimes->$i : '';

					$isolated_name_closure_datetime=(isset($isolated_name_closure_datetimes->$i)) ? $isolated_name_closure_datetimes->$i : '';

					$isolated_ia_name=(isset($isolated_ia_names->$i)) ? $isolated_ia_names->$i : '';				
				} 

				
				
				if($description_equipment!='')
				{
					$checked = (in_array($i,$eq_tags)) ? 'checked' : '';

					if(in_array($user_id,array($acceptance_performing_id,$acceptance_issuing_id)) &&   $approval_status==WAITING_IA_ACCPETANCE && in_array($i,$eq_tags)){
						$disabled_isolated_inputs=''; 
					} else if(in_array($approval_status,array(WAITING_ISOLATORS_COMPLETION)) && in_array($i,$eq_tags)) {
						
						if($user_id==$isolation_type_user_id && $isolated_name_approval_datetime=='')
						{
							$isolated_name_approval_datetime = date('d-m-Y H:i');
						}
					} else if(in_array($approval_status,array(WORK_IN_PROGRESS)) && in_array($i,$eq_tags) && $user_id==$acceptance_performing_id) {
						$disabled_isolated_inputs='disabled="disabled"';
						$disabled_closure_isolated_inputs='';
					}else if(in_array($approval_status,array(WAITING_CLOSURE_ISOLATORS_COMPLETION)) && in_array($i,$eq_tags)) {
						if($user_id==$closure_isolation_type_user_id && $isolated_name_closure_datetime=='')
						{
							$isolated_name_closure_datetime = date('d-m-Y H:i');
						}
					}

					
					$isolation_type_user_id=$checked=='' ? '' : $isolation_type_user_id;

					$gen_checklist=$this->generate_checklists($checklists,$i,$description_equipment,$count,'');

					$generate_checklist=$gen_checklist['select'];

					$equipment_number=$gen_checklist['equipment_number'];

					$generate_isolations=$this->generate_isolations($isolations,$i,$type_isolation,'');

					$generate_isolation_users = $this->generate_isolation_type_users($isolation_users,$type_isolation,'',$isolation_type_user_id,array());

					if($checked!='')
					{
						$generate_closure_isolation_users = $this->generate_isolation_type_users($isolation_users,$type_isolation,'',$closure_isolation_type_user_id,array());
					}
					$rows.='<TR id="equip_row_id'.$i.'"><td><input type="checkbox" class="form-check-input equipment_tag_nos" name="eq_tag[]" id="eq_tag[]" value="'.$i.'" '.$checked.'/></td>';
					
					
					$rows.='<TD ><input   type="text" readonly class="form-control equipment_tag_no equipment_tag_no'.$i.'" name="equipment_tag_nos['.$i.']" id="equipment_tag_no['.$i.']" value="'.$equipment_number.'"  /></td>';
					
					$rows.='<TD ><input type="text" class="form-control isolated_tagno1'.$i.'" name="isolated_tagno1['.$i.']" id="isolated_tagno1['.$i.']" value="'.$isolated_tag1.'" disabled/>&nbsp;<input type="text" class="form-control isolated_tagno2'.$i.'" name="isolated_tagno2['.$i.']" id="isolated_tagno2['.$i.']" value="'.$isolated_tag2.'" disabled/></td>';
					
					$rows.='<td><input type="text" class="form-control isolated_tagno3'.$i.'" name="isolated_tagno3['.$i.']" id="isolated_tagno3['.$i.']" value="'.$isolated_tag3.'" disabled/></td>';
					
					
					$rows.='<td><select name="isolated_user_ids['.$i.']" id="isolated_user_ids['.$i.']" class="form-control isolated_user_ids data-iso-name isolated_user_ids'.$i.' isolated_user_ids'.$i.'" data-attr="'.$i.'" '.$disabled_isolated_inputs.'>'.$generate_isolation_users.'</select></td>';

					$rows.='<td><input type="text" class="form-control isolated_name_approval_datetime'.$i.'" name="isolated_name_approval_datetime['.$i.']" id="isolated_name_approval_datetime['.$i.']" value="'.$isolated_name_approval_datetime.'"  disabled/></td>';

					$rows.='<td><select name="closure_isolator_ids['.$i.']" id="closure_isolator_ids['.$i.']" class="form-control closure_isolator_ids data-iso-name closure_isolator_ids'.$i.'" data-attr="'.$i.'" '.$disabled_closure_isolated_inputs.'  >'.$generate_closure_isolation_users.'</select></td>';
					
					$rows.='<td><input type="text" class="form-control isolated_name_closure_datetime'.$i.'" name="isolated_name_closure_datetime['.$i.']" id="isolated_name_closure_datetime['.$i.']" value="'.$isolated_name_closure_datetime.'"  disabled/></td>';
				}
			}

		}
		else
		{
			$disabled="disabled='disabled'";

			$radio_check=''; $remarks=''; 

			for($i=1;$i<=EIP_CHECKLIST_MAX_ROWS;$i++)
			{

				$disabled_isolated_inputs=$disabled_closure_isolated_inputs="disabled='disabled'";

				$checked='';

				$radio_yes_check=$radio_no_check=$type_isolation=$description_equipment=$isolated_tag1=$isolated_tag2=$isolated_tag3=$isolation_type_user_id=$equipment_tag_no=$isolated_name_approval_datetime=$isolated_ia_name=$isolated_name_closure_datetime=$generate_closure_isolation_users='';

				if($count>0)
				{
					$description_equipment=(isset($equipment_descriptions->$i)) ? $equipment_descriptions->$i : '';

					$equipment_tag_no=(isset($equipment_tag_nos->$i)) ? $equipment_tag_nos->$i : '';

					$type_isolation=(isset($isolate_types->$i)) ? $isolate_types->$i : '';
					
					$isolated_tag1=(isset($isolated_tagno1->$i)) ? $isolated_tagno1->$i : '';

					$isolated_tag2=(isset($isolated_tagno2->$i)) ? $isolated_tagno2->$i : '';

					$isolated_tag3=(isset($isolated_tagno3->$i)) ? $isolated_tagno3->$i : '';

				    $isolation_type_user_id=(isset($isolated_user_ids->$i)) ? $isolated_user_ids->$i : '';

					$closure_isolation_type_user_id=(isset($closure_isolator_ids->$i)) ? $closure_isolator_ids->$i : '';
					
					
					$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes->$i)) ? $isolated_name_approval_datetimes->$i : '';

					$isolated_name_closure_datetime=(isset($isolated_name_closure_datetimes->$i)) ? $isolated_name_closure_datetimes->$i : '';

					$isolated_ia_name=(isset($isolated_ia_names->$i)) ? $isolated_ia_names->$i : '';
				} 
				

				if($description_equipment!='')
				{
					$checked = (in_array($i,$eq_tags)) ? 'checked' : '';

					if(in_array($user_id,array($acceptance_performing_id,$acceptance_issuing_id)) &&   $approval_status==WAITING_IA_ACCPETANCE && in_array($i,$eq_tags)){
						$disabled_isolated_inputs='';
					} else if(in_array($approval_status,array(WAITING_ISOLATORS_COMPLETION)) && in_array($i,$eq_tags)) {
						
						if($user_id==$isolation_type_user_id && $isolated_name_approval_datetime=='')
						{
							$isolated_name_approval_datetime = date('d-m-Y H:i');
						}
					} else if(in_array($approval_status,array(WORK_IN_PROGRESS)) && in_array($i,$eq_tags) && $user_id==$acceptance_performing_id) {
						$disabled_isolated_inputs='disabled="disabled"';
						$disabled_closure_isolated_inputs='';
					}else if(in_array($approval_status,array(WAITING_CLOSURE_ISOLATORS_COMPLETION)) && in_array($i,$eq_tags)) {
						if($user_id==$closure_isolation_type_user_id && $isolated_name_closure_datetime=='')
						{
							$isolated_name_closure_datetime = date('d-m-Y H:i');
						}
					}

					$isolation_type_user_id=$checked=='' ? '' : $isolation_type_user_id;

					$generate_isolation_users = $this->generate_isolation_type_users($isolation_users,$type_isolation,'',$isolation_type_user_id,array());


					if($checked!='')
					{
						$generate_closure_isolation_users = $this->generate_isolation_type_users($isolation_users,$type_isolation,'',$closure_isolation_type_user_id,array());
					}

					$rows.='<TR id="equip_row_id'.$i.'"><td><input type="checkbox" class="form-check-input equipment_tag_nos" name="eq_tag[]" id="eq_tag[]" value="'.$i.'" '.$checked.'/></td>';
					
					#$rows.='<TD><input   type="text"   name="equipment_descriptions['.$i.']"  id="equipment_descriptions['.$i.']" class="form-control equipment_descriptions equipment_descriptions'.$i.' equip_desc_text" data-id="'.$i.'" value="'.$description_equipment.'" '.$disabled_pa_inputs.'  /></TD>';
					
					$rows.='<TD ><input   type="text"  class="form-control equipment_tag_no equipment_tag_no'.$i.'" name="equipment_tag_nos['.$i.']" id="equipment_tag_no['.$i.']"  value="'.$equipment_tag_no.'" disabled /></td>'; 
				
					$rows.='<TD ><input type="text" class="form-control isolated_tagno1'.$i.'" name="isolated_tagno1['.$i.']" id="isolated_tagno1['.$i.']" value="'.$isolated_tag1.'" disabled />&nbsp;<input type="text" class="form-control isolated_tagno2'.$i.'" name="isolated_tagno2['.$i.']" id="isolated_tagno2['.$i.']" value="'.$isolated_tag2.'" disabled /></td>';
					
					$rows.='<td><input type="text" class="form-control isolated_tagno3'.$i.'" name="isolated_tagno3['.$i.']" id="isolated_tagno3['.$i.']" value="'.$isolated_tag3.'" disabled /></td>';
					
					
					$rows.='<td><select name="isolated_user_ids['.$i.']" id="isolated_user_ids['.$i.']" class="form-control isolated_user_ids data-iso-name isolated_user_ids'.$i.'" data-attr="'.$i.'" '.$disabled_isolated_inputs.'  >'.$generate_isolation_users.'</select></td>';
					
					$rows.='<td><input type="text" class="form-control isolated_name_approval_datetime'.$i.'" name="isolated_name_approval_datetime['.$i.']" id="isolated_name_approval_datetime['.$i.']" value="'.$isolated_name_approval_datetime.'"  disabled/></td>';

					$rows.='<td><select name="closure_isolator_ids['.$i.']" id="closure_isolator_ids['.$i.']" class="form-control closure_isolator_ids data-iso-name closure_isolator_ids'.$i.'" data-attr="'.$i.'" '.$disabled_closure_isolated_inputs.'  >'.$generate_closure_isolation_users.'</select></td>';
					
					$rows.='<td><input type="text" class="form-control isolated_name_closure_datetime'.$i.'" name="isolated_name_closure_datetime['.$i.']" id="isolated_name_closure_datetime['.$i.']" value="'.$isolated_name_closure_datetime.'"  disabled/></td>';
					
					$rows.='</tr>';
				}
			}	
		}
		

		echo json_encode(array('rows'=>$rows,'zone_id'=>$zone_id,'num_rows'=>$num_rows,'job_info'=>$job_info)); exit;
	}
	
	
	
	public function generate_checklists($checklists,$i,$selected_checklist='',$is_existing_selection,$disable)
	{
		$select='<select name="equipment_descriptions['.$i.']" '.$disable.' id="equipment_descriptions['.$i.']" class="form-control equipment_descriptions'.$i.' equip_desc equipment_descriptions equip_desc_dropdown" data-id="'.$i.'"><option value="" selected="selected">- - Select - -</option>';

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

	public function generate_isolation_type_users($users,$isolate_type='',$disable_all,$isolation_type_user_id='',$filtered_array)
	{
		$select = '<option value="" selected>Select</option>';

		 foreach($users as $fet)
		 {
	 		  $isolation_id=$fet['isolation_id'];
											  
			  $id=$fet['id'];
			  
			  $name=$fet['first_name'];
			  
			  $chk=''; $flag=1;
			  
			  if($isolation_id==$isolate_type)
			  {
					if($isolation_type_user_id==$id) $chk='selected';

					if(count($filtered_array)>0)
					{	
						if($isolation_type_user_id==$id)
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
