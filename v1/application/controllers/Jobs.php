<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Dashboard.php
 * Project        : Formwork
 * Creation Date  : 12-14-2016
 * Author         : Anantha Kumar RJ
 * Description    : Manageing Dashbaord Datas 
*********************************************************************************************/	

class Jobs extends CI_Controller
 {

	function __construct()
	{
		parent::__construct(); 
        $this->load->model(array('security_model','jobs_model','public_model','jobs_isolations_model'));
		$this->security_model->chk_is_user();        
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}

/**********************************************************************************************
 * Description    : Grab all counts data from Dashboard table based on by logged company user
**********************************************************************************************/	

	public function index()
	{
		$segment_array=$this->uri->segment_array();
		
		$this->data['params_url']=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	
		
		$filters=$this->generate_where_condition();

		$this->data['filters']=$filters['filters'];

		$this->load->view($this->data['controller'].'index',$this->data);
	}

	public function open_permits()
	{
		$segment_array=$this->uri->segment_array();
		
		$this->data['params_url']=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	
		
		$filters=$this->generate_where_condition();
		$this->data['filters']=$filters['filters'];


		$this->load->view($this->data['controller'].'open_permits',$this->data);
	}

	public function closed_permits()
	{
		$segment_array=$this->uri->segment_array();
		
		$this->data['params_url']=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	
		
		$filters=$this->generate_where_condition();
		$this->data['filters']=$filters['filters'];


		$this->load->view($this->data['controller'].'closed_permits',$this->data);
	}

	public function form()
	{
		$segment_array=$this->uri->segment_array();
		$param_url=$this->public_model->get_params_url(array('start'=>5,'segment_array'=>$segment_array));	
		$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();

		$this->data['master_isolations_users']=$this->jobs_isolations_model->get_isolation_users(array())->result_array();

		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'));
		$this->data['permits'] = $this->public_model->get_data(array('table'=>PERMITSTYPES,'select'=>'name,id,department_id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();
		$this->data['clearance_departments'] = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND clearance = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();
		$this->data['allusers'] = $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id,user_role','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND user_role NOT IN ("SA")','column'=>'first_name','dir'=>'asc'))->result_array();
		$dept=$id='';
		$department_id=$this->session->userdata('department_id');		
		$this->data['department']['name'] = $this->session->userdata('department_name');		
		$this->data['department']['id'] = $this->session->userdata('department_id');
		$this->data['records']=array();
		$this->data['authorities'] = array();
		$this->data['job_isolations']=array();
		$this->data['notes']=array();
		$update = array_search('id',$this->uri->segment_array());
		if($update !==FALSE && $this->uri->segment($update+1))
        {
            $id = $this->uri->segment($update+1);
            $req=array(
              'select'  =>'*,TIMESTAMPDIFF(HOUR, modified, "'.date('Y-m-d H:i').'") as time_diff',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>JOBS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{
                $records=$qry->row_array();
				
				$this->data['records']=$records;
				
				$department_id = $records['department_id'];

				$department = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND id = "'.$department_id.'"','column'=>'name','dir'=>'asc'))->row_array();

				$this->data['department']['name'] = $department['name'];		
				

				$this->data['precautions']=$this->public_model->get_data(array('table'=>JOBSPRECAUTIONS,'select'=>'*','where_condition'=>'job_id = "'.$id.'"','column'=>'job_id','dir'=>'asc'))->row_array();

				$this->data['jobs_extends'] = $this->public_model->get_data(array('table'=>JOB_EXTENDS,'select'=>'*','where_condition'=>'job_id = "'.$id.'"','column'=>'id','dir'=>'asc'))->row_array();


				$this->data['job_isolations'] = $this->public_model->get_data(array('table'=>JOBSISOLATION,'select'=>'*','where_condition'=>'job_id = "'.$id.'"','column'=>'id','dir'=>'asc'))->row_array();

				$this->data['avis'] = $this->public_model->get_data(array('table'=>AVIS,'select'=>'COUNT(id) as total,status','where_condition'=>'id = "'.$id.'"','column'=>'id','dir'=>'asc','group_by'=>'status'))->result_array();
				 

				$this->data['notes'] = $this->public_model->get_data(array('table'=>JOBSREMARKS,'select'=>'*','where_condition'=>'job_id = "'.$id.'"','column'=>'id','dir'=>'desc','limit'=>5))->result_array();
            } 

			if(!in_array($department_id,array(EIP_CIVIL,EIP_TECHNICAL)))
			$dept.="'".$department_id."'";
			else
			$dept.="'".EIP_CIVIL."','".EIP_TECHNICAL."'";	

			$dept.=",'".EIP_PRODUCTION."','".EIP_PACKING_OPERATION."'";

			/*$where="department_id = '".$department_id."'";
			else
			$where="department_id IN('".EIP_CIVIL."','".EIP_TECHNICAL."','".EIP_CPP."') ";	*/
			
			$where=" department_id IN(".$dept.") AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";

					//Getting Active Companys List
			$qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS,'column'=>'first_name','dir'=>'asc'));
		
			#echo $this->db->last_query(); exit;
			if($qry->num_rows()>0)
			{
				$authorities=$qry->result_array();
			}

			
			
			$this->data['authorities'] = $authorities;
        }
		else
		{
			if($this->session->userdata('permission')==WRITE)
			{	
				$this->load->model(array('cron_job_model'));

				$where=' AND id ="'.$this->session->userdata('user_id').'"';

				#$this->cron_job_model->check_expired_permits(array('where'=>$where,'type'=>'single','user_id'=>$this->session->userdata('user_id')));

				$this->data['permit_no']=$this->get_max_permit_id(array('department_id'=>$department_id));
			}

			$id='';
		}

		$st='';

		if($id=='')
			$st=" AND status='".STATUS_ACTIVE."'";

		$sops = $this->public_model->get_data(array('select'=>'*','where_condition'=>'department_id = "'.$department_id.'" AND record_type="'.SOPS.'" '.$st,'table'=>SOPS));

		#echo $this->db->last_query(); exit;
		$this->data['sops_nums'] = $sops->num_rows();
		$this->data['sops']=$sops->result_array();

		$wis = $this->public_model->get_data(array('select'=>'*','where_condition'=>'department_id = "'.$department_id.'" AND record_type="'.WORK_INSTRUCTIONS.'"'.$st,'table'=>SOPS));
		$this->data['wis_nums']=$wis->num_rows();
		$this->data['wis']=$wis->result_array();

		$this->data['param_url']=$param_url;

		$this->load->view($this->data['controller'].'form',$this->data);
	}

	public function form_action()
	{	

		#echo '<pre>';print_r($this->input->post()); exit;

		#$this->close_jobs_loto_logs($this->input->post('id'),$this->input->post()); exit;
		
		$submit_type=$this->input->post('submit_type');

		$approval_status = $this->input->post('approval_status');

		//if($approval_status=='undefined')
		//$_POST['approval_status']=WAITING_IA_ACCPETANCE;

		$user_name=$this->session->userdata('first_name');

		$_POST['last_updated_by']=$user_name;
		
		$user_id=$this->session->userdata('user_id');
		
		//$approval_status=unserialize(JOBAPPROVALS);
		
		$array_fields=array('permit_type','checkpoints','precautions_mandatory','confined_space','electrical','excavations','hotworks','materials','scaffoldings','utp','workatheights','equipment_descriptions','equipment_descriptions_name','equipment_tag_nos','isolate_types','isolated_tagno1','isolated_tagno2','isolated_tagno3','isolated_user_ids','isolated_name_approval_datetime','clerance_department_user_id','clearance_department_remarks','clearance_department_dates','pa_equip_identified','issuer_ensured_items','pa_equip_identified','loto_closure_ids_dates','loto_closure_ids','schedule_from_dates','schedule_to_dates','ext_contractors','ext_no_of_workers','ext_performing_authorities','ext_issuing_authorities','ext_oxygen_readings','ext_gases_readings','ext_carbon_readings','ext_performing_authorities_dates','ext_issuing_authorities_dates','ext_reference_codes','other_inputs','re_energized');
		
		$skip_fields=array('id','submit_type','clearance_department_required','step1','notes','step3','step2','isolated_ia_name','jobs_extends_avail','allow_onchange_extends');

		$precautions_fields=array('precautions_mandatory_additional_info','precautions_hotworks_additional_info','precautions_material_additional_info','precautions_electrical_additional_info','precautions_excavations_additional_info','precautions_scaffolding_additional_info','precautions_utp_additional_info','precautions_confined_additional_info','precautions_workatheights_additional_info','precautions_mandatory','confined_space','electrical','excavations','hotworks','materials','scaffoldings','utp','workatheights','scaffolding_tag_no','scaffolding_inspector_name','oxygen_readings','gases_readings','carbon_readings');

		$loto_fields=array('equipment_descriptions','equipment_descriptions_name','equipment_tag_nos','isolate_types','isolated_tagno1','isolated_tagno2','isolated_tagno3','isolated_user_ids','isolated_name_approval_datetime','isolated_ia_name','acceptance_loto_issuing_id','acceptance_loto_issuing_date','issuer_ensured_items','pa_equip_identified','acceptance_loto_pa_id','acceptance_loto_pa_date','re_energized');

		$loto_history_fields=array('equipment_descriptions','equipment_descriptions_name','equipment_tag_nos','isolate_types','isolated_tagno1','isolated_tagno2','isolated_tagno3','isolated_user_ids','isolated_name_approval_datetime');

		$extends_fields=array('schedule_from_dates','schedule_to_dates','ext_contractors','ext_no_of_workers','ext_performing_authorities','ext_issuing_authorities','ext_oxygen_readings','ext_gases_readings','ext_carbon_readings','ext_performing_authorities_dates','ext_issuing_authorities_dates','ext_reference_codes');

		$isolator_tag_updates=0;
		
		$print_out='';
		
		$arr=array();
		
		$fields='';
		
		$fields_values='';
		
		$update=''; 
		
		$msg='';
		
		$short_dept=substr($this->session->userdata('department_name'),0,2);

		$is_send_sms=$show_button='';
		
		$_POST['is_rejected']=NO;

		$status=(isset($_POST['status'])) ? $_POST['status'] : '';
		$permit_type=$this->input->post('permit_type');
		
		$_POST['is_excavation']='No';
		$_POST['is_loto']='No';
		$_POST['is_loto_closure_approval_completed']='Yes';

		if(in_array(9,$permit_type))
			$_POST['is_excavation']='Yes';

		if(in_array(8,$permit_type))
		{
			$_POST['is_loto']='Yes';

			$_POST['is_loto_closure_approval_completed']='No';

		}
		if(!$this->input->post('id'))	//If new jobs create
		{
				$_POST['permit_no']=$this->get_max_permit_id(array('department_id'=>$_POST['department_id']));
				
				$_POST['acceptance_performing_date']=date('d-m-Y H:i');	
				
				$_POST['permit_no_sec']=preg_replace("/[^0-9,.]/", "", $_POST['permit_no']);				
						
				$_POST['approval_status']=WAITING_IA_ACCPETANCE;	//Waiting IA Acceptance
				
				$_POST['status']=STATUS_PENDING;

				$is_send_sms=YES;

				$sender=$_POST['acceptance_performing_id'];

				$receiver=$_POST['acceptance_issuing_id'];

				if($_POST['is_excavation']==YES){
					$_POST['location_time_to']=date($_POST['location_time_to'],strtotime('+30 days'));
				}

				$msg_type=PATOIA_WAITING_APPROVAL;	
		}	
		else
		{
			$show_button=''; //($_POST['show_button']) ? trim($_POST['show_button']) : '';

			$job_id = $this->input->post('id');

			$job_qry=$this->public_model->get_data(array('select'=>'id,acceptance_issuing_id,cancellation_issuing_id,approval_status,status,last_updated_by,last_modified_id,acceptance_performing_id,is_loto,is_loto_closure_approval_completed','where_condition'=>'id ="'.$job_id.'"','table'=>JOBS));

			$job_result = $job_qry->row_array();

			$db_modified=$job_result['last_modified_id'];

			$is_loto=$job_result['is_loto'];

			$is_loto_closure_approval_completed=$job_result['is_loto_closure_approval_completed'];

			$_POST['is_loto_closure_approval_completed']=$is_loto_closure_approval_completed;

			$modified=$this->input->post('last_modified_id');			
			
			$pre_approval_status=$job_result['approval_status'];

			if($approval_status=='undefined')
			$_POST['approval_status']=$pre_approval_status;

			if($db_modified!=$modified)		//Check if any update info recently
			{
				$this->session->set_flashdata('failure','Sorry, Just before <b>'.$job_result['last_updated_by'].'</b> has updated this permit info. Please check updated information');  

				$ret=array('status'=>false,'print_out'=>'');		                   
      
				echo json_encode($ret);

				exit;
			}


			
			if($job_result['approval_status'] == WAITING_IA_ACCPETANCE && $user_id != $job_result['acceptance_issuing_id'] && $user_id!=$job_result['acceptance_performing_id'])
			{
				$this->session->set_flashdata('failure','Issuing authority has been changed by PA!');    

				$ret=array('status'=>true,'print_out'=>'');
					
				echo json_encode($ret);
				
				exit;
			}

			$acceptance_issuing_id = $this->input->post('acceptance_issuing_id');
			$acceptance_performing_id = $this->input->post('acceptance_performing_id');

			//IA Logged & Approve/Cancelling PA Request
			if($user_id==$acceptance_issuing_id && $pre_approval_status==WAITING_IA_ACCPETANCE)
			{	
				$_POST['acceptance_issuing_approval']='No';
				
				$lbl='cancelled';

				$msg='<b>IA '.$user_name.' '.$lbl.' this job</b>';		

				if($approval_status==IA_APPROVED)
				{
					$_POST['acceptance_issuing_approval']='Yes';
						
					$_POST['acceptance_issuing_date']=date('Y-m-d H:i');

					$lbl='approved'; 

					$msg='<b>IA '.$user_name.' '.$lbl.' this job</b>';		
					
					//If Excavation is available then change the status manually
					if($_POST['is_excavation']=='Yes')
					{
						$_POST['approval_status']=WAITINGDEPTCLEARANCE;

						$msg='<b>IA '.$user_name.' '.$lbl.' this job and sent approval request to department clearance users</b>';		
					} else if($_POST['is_loto']=='Yes'){

						$_POST['approval_status']=WAITING_ISOLATORS_COMPLETION;

						$msg='<b>IA '.$user_name.' '.$lbl.' this job and sent approval request to isolators users</b>';		

						$isolator_tag_updates=1;
					}
					else {
						//$print_out=1;	
						$_POST['approval_status']=AWAITING_FINAL_SUBMIT;	
					}
				}

				
			}


			//Isolators Users Logged
			if(in_array($approval_status,array(WAITING_ISOLATORS_COMPLETION)))
			{
				$isolated_user_ids=$this->input->post('isolated_user_ids');
				$clearance_department_dates=$this->input->post('isolated_name_approval_datetime');
				$isolate_types=$this->input->post('isolate_types');

				#echo 'Count '.count(array_filter($isolated_user_ids)).' = '.count(array_filter($clearance_department_dates)).' = '.count(array_filter($isolate_types)); exit;

				if(count(array_filter($isolate_types)) == count(array_filter($clearance_department_dates)))
				{
					$_POST['approval_status'] = WAITING_LOTO_IA_COMPLETION;

					$msg = 'Isolation Approval are completed and sent approval request to IA';
				} 

				$isolator_tag_updates=1;
			}

			//Isolators IA Approve
			if(in_array($approval_status,array(WAITING_LOTO_IA_COMPLETION)))
			{
				$acceptance_loto_issuing_id = $this->input->post('acceptance_loto_issuing_id');

				if($user_id==$acceptance_loto_issuing_id)
				{
					$_POST['approval_status'] = WAITING_LOTO_PA_COMPLETION;

					$msg = 'Loto IA Approval completed and sent approval request to PA';
				} 
			}

			//Isolators PA Approve
			if(in_array($approval_status,array(WAITING_LOTO_PA_COMPLETION)))
			{
				$acceptance_loto_pa_id = $this->input->post('acceptance_loto_pa_id');

				if($user_id==$acceptance_loto_pa_id)
				{
					$_POST['approval_status'] = AWAITING_FINAL_SUBMIT;

					$_POST['acceptance_loto_pa_id']=$acceptance_performing_id;

					$msg = 'Loto PA Approval completed';
				} 
			}

			//Dept Clearance user logged
			if(in_array($approval_status,array(WAITINGDEPTCLEARANCE)))
			{
				$clerance_department_user_id=$this->input->post('clerance_department_user_id');
				$clearance_department_dates=$this->input->post('clearance_department_dates');

				//echo 'Count '.count(array_filter($clerance_department_user_id)).' = '.count(array_filter($clearance_department_dates)); exit;

				if(count(array_filter($clerance_department_user_id)) == count(array_filter($clearance_department_dates)))
				{
					$_POST['approval_status'] = AWAITING_FINAL_SUBMIT;

					$msg = 'Department clearance completed. Ready to final submit';
				}
			}
			
			//Final Submit PA
			//if($user_id==$acceptance_performing_id && in_array($pre_approval_status,array(IA_APPROVED,DEPTCLEARANCECOMPLETED,AWAITING_FINAL_SUBMIT,WAITING_LOTO_PA_COMPLETION)))
			if($user_id==$acceptance_performing_id && in_array($pre_approval_status,array(AWAITING_FINAL_SUBMIT)))
			{
				$_POST['status']=STATUS_OPENED;	
				
				$_POST['show_button']='hide';

				$_POST['approval_status']= WORK_IN_PROGRESS;
					
				$_POST['final_status_date']=date('Y-m-d H:i');
				
				$print_out=1;
				
				$this->session->set_flashdata('success','Final status has been completed!');    

				$msg='<b>PA moved his job to Open Permits</b>';
			}

			//PA Completion/Cancellation
			if(in_array(strtolower($approval_status),array(WAITING_IA_COMPLETION,APPROVED_IA_COMPLETION,WAITING_IA_CANCELLATION,APPROVED_IA_CANCELLATION)) || in_array(strtolower($pre_approval_status),array(WAITING_IA_COMPLETION,APPROVED_IA_COMPLETION,WAITING_IA_CANCELLATION,APPROVED_IA_CANCELLATION)))
			{	
				if($this->input->post('cancellation_performing_id')==$user_id)
				$_POST['cancellation_performing_date'] = date('d-m-Y H:i:s');

				#echo 'AA '.$is_loto_closure_approval_completed; exit;

				if($is_loto=='Yes' && $is_loto_closure_approval_completed=='No'){ // 
					$loto_closure_ids=$this->input->post('loto_closure_ids');
					$loto_closure_ids_dates=$this->input->post('loto_closure_ids_dates');

					#echo 'Count '.count(array_filter($loto_closure_ids)).' = '.count(array_filter($loto_closure_ids_dates)); exit;

					if(count(array_filter($loto_closure_ids)) == count(array_filter($loto_closure_ids_dates)))
					{
						$_POST['is_loto_closure_approval_completed'] = 'Yes';

						$msg = 'Loto clearance completed and sent approval request to IA';						
						
						$filt=$this->input->post('re_energized');

						if($this->input->post('re_energized') && count(array_filter($filt))>0)
						{ 
							$job_pre_isolations_nums=$this->close_jobs_loto($this->input->post('id'),$filt);

							if($job_pre_isolations_nums==0) { 
								$_POST['re_energized']='';
							}
						}

						$this->close_jobs_loto_logs($this->input->post('id'),$this->input->post());
					}
				}
				 

				if($is_loto_closure_approval_completed=='Yes')
				{
					$cancellation_performing_id=$this->input->post('cancellation_performing_id');
					$cancellation_issuing_id=$this->input->post('cancellation_issuing_id');
					$lbl='Completion';
					$print_out=0;

					if($approval_status==WAITING_IA_CANCELLATION || $approval_status==APPROVED_IA_CANCELLATION)
					$lbl='Cancellation';

					if($user_id==$cancellation_performing_id && in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION)))
					{
						$_POST['cancellation_performing_date'] = date('d-m-Y H:i:s');

						$msg='<b>Sent PA '.$lbl.' request to IA</b>';	
					}

					#echo 'AA '.$pre_approval_status.' = '.$approval_status.'='.WAITING_IA_COMPLETION;
					if($user_id==$cancellation_issuing_id && in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION)))
					{
						$_POST['cancellation_issuing_date']='';
						$st_flag=0;

						if($this->input->post('is_loto')==YES) {
							$user_id_column=$this->input->post('loto_closure_ids');
							$loto_closure_ids_dates=$this->input->post('loto_closure_ids_dates');
			
							#echo 'A '.count(array_filter($user_id_column)).' = '.count(array_filter($loto_closure_ids_dates));
			
							if(count($user_id_column)>0 || count($loto_closure_ids_dates)>0)
							{
								if(count(array_filter($user_id_column)) != count(array_filter($loto_closure_ids_dates)))
								{
									$st_flag=1;
								} 
							}
						}

						if($st_flag==0){						
								$_POST['approval_status']= $approval_status==WAITING_IA_COMPLETION ? APPROVED_IA_COMPLETION : APPROVED_IA_CANCELLATION;

								$_POST['status']=STATUS_CLOSED;

								$_POST['cancellation_issuing_date'] = date('d-m-Y H:i:s');

								$msg='<b>IA accepted PA '.$lbl.' request</b>';	
						}
					}
				}

			}

			//Extends
			if(in_array(strtolower($approval_status),array(CANCEL_IA_EXTENDED)))
			{
				$jobs_extends_avail=$this->input->post('jobs_extends_avail');

				$_POST['ext_reference_codes'][$jobs_extends_avail]='';
				
			}

			//Self Description by PA	
			if($approval_status==SELF_CANCEL)
			{
				$_POST['approval_status'] = SELF_CANCEL;

				$_POST['status'] = 'Cancellation';

				$_POST['show_button'] = 'hide';

				$is_send_sms=YES;

				$msg_type=PATOIA_SELF_CANCELLED;

				$sender=$user_id;

				$receiver=$_POST['acceptance_issuing_id'];	

				$msg='<b>Self Cancelled</b> by PA';	

				$print_out=0;

				$this->close_jobs_loto_logs($this->input->post('id'),$this->input->post());
			}
			
		}
		
		
		$_POST['is_draft']=NO;

		$_POST['draft_user_id']='';

		$_POST['last_modified_id']=rand(time(),5);

		$id=($this->input->post('id')) ? $this->input->post('id') : '';
		
		if($id!='')
		{
			$permit_no=$_POST['permit_no'];

			$skip_fields=array_merge($skip_fields,array('permit_no','department_id'));

			#print_r($skip_fields);

			unset($_POST['permit_no']);

			unset($_POST['department_id']);
		}
		else
			$_POST['permit_no']=$permit_no=$this->get_max_permit_id(array('department_id'=>$_POST['department_id']));	

		if(in_array(strtolower($approval_status),array(WAITING_IA_EXTENDED,APPROVE_IA_EXTENDED,CANCEL_IA_EXTENDED))){
			$_POST['cancellation_performing_name']='';
			$_POST['cancellation_performing_id']='';
			$_POST['cancellation_performing_date']='';
			$_POST['loto_closure_ids']='';
			$_POST['loto_closure_ids_dates']='';
		} else if(in_array($approval_status,array(WAITING_IA_COMPLETION,WAITING_IA_CANCELLATION))) {
			$_POST['cancellation_issuing_date']='';
			$_POST['cancellation_performing_date']=date('d-m-Y H:i:s');
			if($this->input->post('is_loto')==YES) {
				$user_id_column=$this->input->post('loto_closure_ids');
				$loto_closure_ids_dates=$this->input->post('loto_closure_ids_dates');

				//echo 'A '.count(array_filter($user_id_column)).' = '.count(array_filter($loto_closure_ids_dates));

				if(count($user_id_column)>0 || count($loto_closure_ids_dates)>0)
				{
					if(count(array_filter($user_id_column)) == count(array_filter($loto_closure_ids_dates)))
					{
						$_POST['cancellation_issuing_date']=date('d-m-Y H:i:s');
					} 
				}

			} else {
				$_POST['cancellation_issuing_date']=date('d-m-Y H:i:s');
			}
			
		}
		

		$inputs=$this->input->post();

		#echo '<br /> MSg '.$msg;

		#echo '<pre>'; print_r($_POST); exit;
		$job_name=$_POST['job_name'];
		//Jobs Inputs
		//for($r=1;$r<=9;$r++)
		//{
		//	$id='';

		//	$inputs['permit_no']=$this->get_max_permit_id(array('department_id'=>$_POST['department_id']));

		//	$inputs['job_name']=$job_name.' '.$r;

			$update=$fields=$fields_values='';

			foreach($inputs as $field_name => $field_value)
			{
				if(!in_array($field_name,$skip_fields) && !in_array($field_name,$precautions_fields) && !in_array($field_name,$loto_fields) && !in_array($field_name,$extends_fields))
				{
					$fields.=$field_name.',';
					
					if(in_array($field_name,$array_fields))
					{
						
						if(count($this->input->post($field_name))>0)
							$field_value="'".json_encode($this->input->post($field_name),JSON_FORCE_OBJECT)."'";
							else
							$field_value='';
					}
					else
					{
						$field_value="'".rtrim(@addslashes($field_value),',')."'";
					}
					
					$fields_values.=$field_value.',';
					
					$update.=$field_name.'='.$field_value.',';
				}
			}

			$update.="modified = '".date('Y-m-d H:i')."'";
			
			$update=rtrim($update,',');
			
			$fields.='user_id,created,modified';
		
		
			$fields_values.='"'.$user_id.'","'.date('Y-m-d H:i').'","'.date('Y-m-d H:i').'"';
		
			if(!$id)
			{

				$ins="INSERT INTO ".$this->db->dbprefix.JOBS." (".$fields.") VALUES (".$fields_values.")";
			
				$this->db->query($ins);
				
				$id=$this->db->insert_id();			

				$ins="INSERT INTO ".$this->db->dbprefix.JOBSPRECAUTIONSHISTORY." (user_id,job_id,created) VALUES ('".$user_id."','".$id."','".date('Y-m-d H:i')."')";
			
				$this->db->query($ins);
				
				$precautions_history_id=$this->db->insert_id();
				
				$msg='<b>Created by '.$user_name.' and sent request to IA</b>';		
				
				$this->session->set_flashdata('success','New Job has been created successfully');    
				
			}
			else
			{
				$up="UPDATE ".$this->db->dbprefix.JOBS." SET ".$update." WHERE id='".$id."'";
				
				$this->db->query($up);

				$pre = $this->public_model->get_data(array('table'=>JOBSPRECAUTIONSHISTORY,'select'=>'id','where_condition'=>'job_id = "'.$id.'"','column'=>'id','dir'=>'desc','limit'=>1))->row_array();

				$this->session->set_flashdata('success','Job info has been updated successfully');    

				$precautions_history_id= $pre['id'];
			}
		
			//Extends Inputs
			if(in_array(strtolower($approval_status),array(WAITING_IA_EXTENDED,APPROVE_IA_EXTENDED,CANCEL_IA_EXTENDED)))
			{
				$fields=$fields_values=$update='';

				$update='';

				$pre = $this->public_model->get_data(array('table'=>JOB_EXTENDS,'select'=>'id','where_condition'=>'job_id = "'.$id.'"','column'=>'id','dir'=>'desc','limit'=>1))->row_array();

				$ext_id= $pre['id'];

				foreach($inputs as $field_name => $field_value)
				{
					if(!in_array($field_name,$skip_fields) && in_array($field_name,$extends_fields))
					{
						$fields.=$field_name.',';
						
						if(in_array($field_name,$array_fields))
						{
							
							if(count($this->input->post($field_name))>0)
								$field_value="'".json_encode($this->input->post($field_name),JSON_FORCE_OBJECT)."'";
								else
								$field_value='';
						}
						else
						{
							$field_value="'".rtrim(@addslashes($field_value),',')."'";
						}
						
						$fields_values.=$field_value.',';
						
						$update.=$field_name.'='.$field_value.',';
					}
				}
				
				$update.="modified = '".date('Y-m-d H:i')."'";
				
				$update=rtrim($update,',');
				
				$fields.='job_id,user_id,created,modified';
		
				$fields_values.='"'.$id.'","'.$user_id.'","'.date('Y-m-d H:i').'","'.date('Y-m-d H:i').'"';
				
				if(isset($ext_id) && $ext_id>0)
				{
					$up="UPDATE ".$this->db->dbprefix.JOB_EXTENDS." SET ".$update." WHERE id='".$ext_id."'";
					
					$this->db->query($up);
				}
				else
				{
					$ins="INSERT INTO ".$this->db->dbprefix.JOB_EXTENDS." (".$fields.") VALUES (".$fields_values.")";
				
					$this->db->query($ins);
				}

			}
			$notes = isset($_POST['notes'])  ? trim($_POST['notes']) : '';
			//Job Notes
			
			if($notes!='')
			{
				$notes = @addslashes($notes);

				$fields='job_id,approval_status,user_id,created,last_updated_by,notes';

				$fields_values='"'.$id.'","'.$approval_status.'","'.$user_id.'","'.date('Y-m-d H:i').'","'.$user_name.'","'.$notes.'"';
				
				$qry="INSERT INTO ".$this->db->dbprefix.JOBSREMARKS." (".$fields.") VALUES (".$fields_values.")";

				$this->db->query($qry);
			}

			$_POST['permit_no']=$permit_no;

			#echo 'FF '.$_POST['permit_no'];
			
			$affectedRows = $this->db->affected_rows(); 

			//Loto Permits
			if(in_array(8,$permit_type))
			{

				$fields=$fields_values=$update='';

				$update='';

				//Precaution Inputs
				foreach($inputs as $field_name => $field_value)
				{
					if(in_array($field_name,$loto_fields))
					{	
						$fields.=$field_name.',';

						if(in_array($field_name,$array_fields))
						{
							if(count($this->input->post($field_name))>0)
							$field_value="'".json_encode($this->input->post($field_name))."'";
							else
							$field_value='';
						}
						else
						{	
							$field_value="'".rtrim(@addslashes($field_value),',')."'";
						}

						$fields_values.=$field_value.',';	

						$update.=$field_name.'='.$field_value.',';
					}	
				}
				
				$fields.='job_id,user_id,created,last_updated_by,zone_id';
				$fields_values.='"'.$id.'","'.$user_id.'","'.date('Y-m-d H:i').'","'.$user_name.'","'.$_POST['zone_id'].'"';

				$update.="modified = '".date('Y-m-d H:i')."',last_updated_by='".$user_name."',zone_id='".$_POST['zone_id']."'";
				$update=rtrim($update,',');

				$pre = $this->public_model->get_data(array('table'=>JOBSISOLATION,'select'=>'id','where_condition'=>'job_id = "'.$id.'"','column'=>'id','dir'=>'desc','limit'=>1))->row_array();
				$isolation_id= $pre['id'];

				if(isset($isolation_id) && $isolation_id>0)
				{
					$qry="UPDATE ".$this->db->dbprefix.JOBSISOLATION." SET ".$update." WHERE id='".$isolation_id."'";
				} else {
					$qry="INSERT INTO ".$this->db->dbprefix.JOBSISOLATION." (".$fields.") VALUES (".$fields_values.")";
				}
				$this->db->query($qry); 
			}
			
			if($affectedRows>0)
			{			
				$this->db->where('job_precautions_history_id',$precautions_history_id);
				
				$this->db->delete(JOBSPRECAUTIONS);

				$fields=$fields_values=$update='';

				//Precaution Inputs
				foreach($inputs as $field_name => $field_value)
				{
					if(in_array($field_name,$precautions_fields))
					{

						$fields.=$field_name.',';

						if(in_array($field_name,$array_fields))
						{
							if(count($this->input->post($field_name))>0)
							$field_value="'".json_encode($this->input->post($field_name))."'";
							else
							$field_value='';
						}
						else
						{	
							$field_value="'".rtrim(@addslashes($field_value),',')."'";
						}

						$fields_values.=$field_value.',';	
					}	
				}
				
				$fields.='job_id,job_precautions_history_id,user_id,created';
				
				$fields_values.='"'.$id.'","'.$precautions_history_id.'","'.$user_id.'","'.date('Y-m-d H:i').'"';

				$ins="INSERT INTO ".$this->db->dbprefix.JOBSPRECAUTIONS." (".$fields.") VALUES (".$fields_values.")";
				
				$this->db->query($ins);
				
				#$id=$this->db->insert_id();

				#echo 'FF '.$is_send_sms.' - '.$msg_type.' - '.$sender.' - '.$receiver; exit;

				$additional_text='. Job Desc : '.strtoupper($this->input->post('job_name'));

				if($is_send_sms!='' && $_POST['is_draft']==NO)
					$this->public_model->send_sms(array('sender'=>$sender,'receiver'=>$receiver,'msg_type'=>$msg_type,'permit_type'=>'General Work Permit','permit_no'=>$_POST['permit_no'],'additional_text'=>$additional_text));
				#echo 'Yes'; exit;
				
				/*if($msg=='')
				$msg=$user_name.' has updated his job information';*/

				if($_POST['is_draft']==YES)
					$msg=$msg.' Saved as Draft';

				
				if($msg!='')
				{
					$array=array('user_id'=>$user_id,'job_id'=>$id,'notes'=>$msg,'created'=>date('Y-m-d H:i'));
				
					$this->db->insert(JOBSHISTORY,$array);
				}	
			}	

			//When Isolator Approve the equipment 1st time
			if($isolator_tag_updates==1)
			{
				$this->jobs_lotos();
			}
		
	//} //Multi Permit Loop end
	
	$ret=array('status'=>true,'print_out'=>$print_out);
		                   
	# echo 'true'; 
	echo json_encode($ret);
	
	exit;
	}

	public function jobs_lotos()
	{

		$job_pre_isolations=$this->public_model->join_fetch_data(array('select'=>'ji.*,j.approval_status,j.id as job_id,j.permit_no','table1'=>JOBSISOLATION.' ji','table2'=>JOBS.' j','join_type'=>'inner','join_on'=>'ji.job_id=j.id','where'=>'j.approval_status IN("'.WAITING_ISOLATORS_COMPLETION.'","'.WAITING_LOTO_IA_COMPLETION.'") ','num_rows'=>false));

		#echo $this->db->last_query(); exit;
		//,"'.APPROVED_ISOLATORS_COMPLETION.'"

		#$job_pre_isolations = $this->public_model->get_data(array('select'=>'*','where_condition'=>'job_id = "'.$id.'"','table'=>JOBSISOLATION));

		$nums_job_pre_isolations=$job_pre_isolations->num_rows();

		if($nums_job_pre_isolations>0)
		{
			$job_isolations_lists=$job_pre_isolations->result_array();

			foreach($job_isolations_lists as $job_isolations)
			{
				$equipment_descriptions=(isset($job_isolations['equipment_descriptions'])) ? json_decode($job_isolations['equipment_descriptions'],true) : array();

				$isolated_tagno1=(isset($job_isolations['isolated_tagno1'])) ? json_decode($job_isolations['isolated_tagno1']) : array();

				$isolated_tagno2=(isset($job_isolations['isolated_tagno2'])) ? json_decode($job_isolations['isolated_tagno2']) : array();

				$isolated_tagno3=(isset($job_isolations['isolated_tagno3'])) ? json_decode($job_isolations['isolated_tagno3']) : array();

				$isolate_types=(isset($job_isolations['isolate_types'])) ? json_decode($job_isolations['isolate_types']) : array();

				$isolated_user_ids=(isset($job_isolations['isolated_user_ids'])) ? json_decode($job_isolations['isolated_user_ids']) : array();

				$isolated_name_approval_datetimes = (isset($job_isolations['isolated_name_approval_datetime'])) ? json_decode($job_isolations['isolated_name_approval_datetime'],true) : array();

				$job_id=$job_isolations['job_id'];

				foreach($equipment_descriptions as $key => $val){

					if($val!='' & $val!=9999){
						
						$eip_checklists_id=(isset($equipment_descriptions[$key])) ? $equipment_descriptions[$key] : '';

						$isolation_type_id=(isset($isolate_types->$key)) ? $isolate_types->$key : '';

						$isolated_user_id=(isset($isolated_user_ids->$key)) ? $isolated_user_ids->$key : '';

						$isolated_tagno_3=(isset($isolated_tagno3->$key)) ? $isolated_tagno3->$key : '';

						$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes[$key])) ? $isolated_name_approval_datetimes[$key] : '';

						if($isolated_name_approval_datetime!='')
						{
							$where="eip_checklists_id='".$eip_checklists_id."' AND 	isolation_type_id='".$isolation_type_id."' AND status='".STATUS_ACTIVE."'";

							$jobs_lotos = $this->public_model->get_data(array('select'=>'id','where_condition'=>$where,'table'=>LOTOISOLATIONS));
							
							$jobs_lotos_nums=$jobs_lotos->num_rows();

							if($jobs_lotos_nums==0)
							{
								$ins="INSERT INTO ".$this->db->dbprefix.LOTOISOLATIONS." (eip_checklists_id,isolated_tagno3,isolated_user_id,isolation_type_id,created) VALUES ('".$eip_checklists_id."','".$isolated_tagno_3."','".$isolated_user_id."','".$isolation_type_id."','".date('Y-m-d H:i')."')";

								$this->db->query($ins); 

								$jobs_lotos_id=$this->db->insert_id();

								$ins="INSERT INTO ".$this->db->dbprefix.LOTOISOLATIONSLOG." (jobs_lotos_id,eip_checklists_id,isolated_tagno3,isolated_user_id,isolation_type_id,created,job_id) VALUES ('".$jobs_lotos_id."','".$eip_checklists_id."','".$isolated_tagno_3."','".$isolated_user_id."','".$isolation_type_id."','".date('Y-m-d H:i')."','".$job_id."')";

								$this->db->query($ins);

							}
						}


					}

				}
			}

			$jobs_lotos = $this->public_model->get_data(array('select'=>'*','where_condition'=>'status="'.STATUS_ACTIVE.'"','table'=>LOTOISOLATIONS));

			$jobs_num_lotos=$jobs_lotos->num_rows();

			if($jobs_num_lotos>0)
			{
				$fetch_job_lotos=$jobs_lotos->result_array();

				$job_pre_isolations=$this->public_model->join_fetch_data(array('select'=>'ji.*,j.approval_status,j.id as job_id,j.permit_no','table1'=>JOBSISOLATION.' ji','table2'=>JOBS.' j','join_type'=>'inner','join_on'=>'ji.job_id=j.id','where'=>'j.approval_status IN("'.WAITING_ISOLATORS_COMPLETION.'") ','num_rows'=>false));

				$job_isolations_lists=$job_pre_isolations->result_array();
				
				foreach($job_isolations_lists as $job_isolations)
				{
					$permit_no=$job_isolations['permit_no'];
					$job_id=$job_isolations['job_id'];

					#echo '<br /> Permit No '.$permit_no.' = '.$job_id;

					$equipment_descriptions=(isset($job_isolations['equipment_descriptions'])) ? json_decode($job_isolations['equipment_descriptions'],true) : array();

					$isolated_tagno3=(isset($job_isolations['isolated_tagno3'])) ? json_decode($job_isolations['isolated_tagno3'],true) : array();

					$isolate_types=(isset($job_isolations['isolate_types'])) ? json_decode($job_isolations['isolate_types'],true) : array();

					$isolated_user_ids=(isset($job_isolations['isolated_user_ids'])) ? json_decode($job_isolations['isolated_user_ids'],true) : array();

					$isolated_name_approval_datetimes=(isset($job_isolations['isolated_name_approval_datetime'])) ? json_decode($job_isolations['isolated_name_approval_datetime'],true) : array();

					$update=0;
					
					foreach($equipment_descriptions as $key => $val)
					{
						$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes[$key])) ? $isolated_name_approval_datetimes[$key] : '';

						$isolation_type_id=(isset($isolate_types[$key])) ? $isolate_types[$key] : '';

						if($val!='' & $val!=9999 && $isolated_name_approval_datetime=='')
						{
							$filtered = array_values(array_filter($fetch_job_lotos, function ($filt) use($val,$isolation_type_id) { return $filt['eip_checklists_id'] == $val &&  $filt['isolation_type_id']==$isolation_type_id; }));

							if(count($filtered)>0)
							{
								$isolated_name_approval_datetimes[$key]=date('d-m-Y H:i');
								$isolated_tagno3[$key]=$isolated_tagno_3=$filtered[0]['isolated_tagno3'];
								$isolated_user_ids[$key]=$isolated_user_id=$filtered[0]['isolated_user_id'];
								$update=1;							

								$jobs_lotos_id=$filtered[0]['id'];
								$eip_checklists_id=$val;

								$ins="INSERT INTO ".$this->db->dbprefix.LOTOISOLATIONSLOG." (jobs_lotos_id,eip_checklists_id,isolated_tagno3,isolated_user_id,isolation_type_id,created,job_id) VALUES ('".$jobs_lotos_id."','".$eip_checklists_id."','".$isolated_tagno_3."','".$isolated_user_id."','".$isolation_type_id."','".date('Y-m-d H:i')."','".$job_id."')";
								$this->db->query($ins);
							}
						}
					}

					if($update==1)
					{
						$update="isolated_name_approval_datetime='".json_encode($isolated_name_approval_datetimes)."',isolated_tagno3='".json_encode($isolated_tagno3)."',isolated_user_ids='".json_encode($isolated_user_ids)."'";

						$qry="UPDATE ".$this->db->dbprefix.JOBSISOLATION." SET ".$update." WHERE job_id='".$job_id."'";
						$this->db->query($qry);

						if(count(array_filter($isolate_types)) == count(array_filter($isolated_name_approval_datetimes))) {
							#echo '<br /> Isolator Approval Completed ';
							$qry="UPDATE ".$this->db->dbprefix.JOBS." SET approval_status='".WAITING_LOTO_IA_COMPLETION."' WHERE id='".$job_id."'";
							$this->db->query($qry);
						}

						#echo '<br /> Update '.$update;

						#echo '<pre><br /> Job Id '.$permit_no.' - '.$job_id;

						#print_r($isolated_name_approval_datetimes);
					} else {
						#echo '<br /> No Updates Job Id '.$permit_no.' - '.$job_id;
					}


				}

			}


		} 
		
	}

	public function close_jobs_loto_logs($job_id,$post)
	{

		$user_id=$this->session->userdata('user_id');

		$user_name=$this->session->userdata('first_name');

		$equipment_descriptions=$post['equipment_descriptions'];

		$data=array('status'=>STATUS_CLOSED,'modified'=>date('Y-m-d H:i'));

		$whr=array('job_id'=>$job_id);

		$this->db->update(LOTOISOLATIONSLOG,$data,$whr);

		$where='al.job_id="'.$job_id.'" AND a.status NOT IN("'.STATUS_CLOSED.'","'.STATUS_CANCELLATION.'")';

		$avi_jobs=$this->public_model->join_fetch_data(array('select'=>'a.*,count(al.id) as total_equipments','table1'=>AVIS.' a','table2'=>AVISLOTOS.' al','join_type'=>'inner','join_on'=>'al.avis_id=a.id','where'=>$where,'num_rows'=>false,'group_by'=>'a.id'));

		#echo $this->db->last_query(); exit;

		if($avi_jobs->num_rows()>0)
		{
			$avis=$avi_jobs->result_array();

			foreach($avis as $avi_info):

				$avi_id=$avi_info['id'];

				$total_equipments=$avi_info['total_equipments'];
				$job_ids=json_decode($avi_info['jobs_id'],true);

				$approval_status=$avi_info['approval_status'];
				$status=$avi_info['status'];
				$final_status_date=$avi_info['final_status_date'];
				$acceptance_issuing_date=$avi_info['acceptance_issuing_date'];
				$acceptance_issuing_approval=$avi_info['acceptance_issuing_approval'];

				//EQ Isolators
				$isolated_user_ids=json_decode($avi_info['isolated_user_ids'],true);
				$isolated_name_approval_datetimes=json_decode($avi_info['isolated_name_approval_datetime'],true);
				$isolated_name_approval_types=json_decode($avi_info['isolated_name_approval_types'],true);

				$closure_isolator_ids=json_decode($avi_info['closure_isolator_ids'],true);
				$isolated_name_closure_datetimes=json_decode($avi_info['isolated_name_closure_datetime'],true);
				$isolated_name_closure_approval_types=json_decode($avi_info['isolated_name_closure_approval_types'],true);

				//Jobs Owners
				$jobs_performing_ids=json_decode($avi_info['jobs_performing_ids'],true);
				$jobs_performing_approval_datetimes=json_decode($avi_info['jobs_performing_approval_datetime'],true);
				$jobs_performing_approval_types=json_decode($avi_info['jobs_performing_approval_types'],true);

				//Job Closers
				$jobs_closer_performing_ids=json_decode($avi_info['jobs_closer_performing_ids'],true);
				$jobs_closer_performing_approval_datetimes=json_decode($avi_info['jobs_closer_performing_approval_datetime'],true);
				$jobs_closer_performing_approval_types=json_decode($avi_info['jobs_closer_performing_approval_types'],true);

				$closed_lotos=json_decode($avi_info['closed_lotos'],true);

				//Final PA & IA Closers
				$closure_performing_id=$avi_info['closure_performing_id'];
				$closure_performing_date=$avi_info['closure_performing_date'];

				$closure_issuing_id=$avi_info['closure_issuing_id'];
				$closure_issuing_date=$avi_info['closure_issuing_date'];

				$closure_performing_again_id=$avi_info['closure_performing_again_id'];
				$closure_performing_again_date=$avi_info['closure_performing_again_date'];
				
				#echo '<pre>'; print_r($jobs_performing_ids);
				foreach($equipment_descriptions as $eq_desc_id):

					//If the Equipment is present
					if(isset($jobs_performing_ids[$eq_desc_id]))
					{
						
						//Update datetime for job awaiting approvals
						if(isset($jobs_performing_approval_datetimes[$eq_desc_id][$job_id]) && $jobs_performing_approval_datetimes[$eq_desc_id][$job_id]=='') {					
							
							$jobs_performing_approval_datetimes[$eq_desc_id][$job_id]=date('d-m-Y H:i'); 
							$jobs_performing_approval_types[$eq_desc_id][$job_id]=$user_name;

							$jobs_closer_performing_ids[$eq_desc_id][$job_id]=$post['cancellation_performing_id'];
							$jobs_closer_performing_approval_datetimes[$eq_desc_id][$job_id]=date('d-m-Y H:i'); 
							$jobs_closer_performing_approval_types[$eq_desc_id][$job_id]=$user_name; 

							$closed_lotos[$eq_desc_id][$job_id]='1';
						}  //update datetime for job closer approvals						
						else if(isset($jobs_closer_performing_approval_datetimes[$eq_desc_id][$job_id]) && $jobs_closer_performing_approval_datetimes[$eq_desc_id][$job_id]==''){
							$jobs_closer_performing_ids[$eq_desc_id][$job_id]=$post['cancellation_performing_id'];
							$jobs_closer_performing_approval_datetimes[$eq_desc_id][$job_id]=date('d-m-Y H:i'); 
							$jobs_closer_performing_approval_types[$eq_desc_id][$job_id]=$user_name; 
							$closed_lotos[$eq_desc_id][$job_id]='1';
						}
						$closed_lotos[$eq_desc_id][$job_id]='1';
						//Isolators
						//If there is no isolator approvals
						if(isset($isolated_name_approval_datetimes[$eq_desc_id]) && $isolated_name_approval_datetimes[$eq_desc_id]=='') {
							
						} 
						
						#echo 'jobs_performing_approval_datetimes  '.count($jobs_performing_approval_datetimes[$eq_desc_id]).' = '. count(array_filter($jobs_performing_approval_datetimes[$eq_desc_id], 'strlen'));

						//If both job approvals are completed then we apply the isolators date time
						if(count($jobs_performing_approval_datetimes[$eq_desc_id]) == count(array_filter($jobs_performing_approval_datetimes[$eq_desc_id], 'strlen'))){

							$isolated_name_approval_datetimes[$eq_desc_id]=date('d-m-Y H:i');	
							$isolated_name_approval_types[$eq_desc_id]=$user_name; 

							$closure_isolator_ids[$eq_desc_id]=$this->session->userdata('user_id');
							$isolated_name_closure_datetimes[$eq_desc_id]=date('d-m-Y H:i');
							$isolated_name_closure_approval_types[$eq_desc_id]=$user_name; 

						}

						#echo 'isolated_name_approval_datetimes '.count($isolated_name_approval_datetimes).' = '. count(array_filter($isolated_name_closure_datetimes, 'strlen'));
						//If all isolators are approved
						//if(count(array_filter($isolated_name_approval_datetimes)) == count(array_filter($isolated_name_closure_datetimes))){
						
					} 
				endforeach;

				if(count($isolated_name_approval_datetimes) == count(array_filter($isolated_name_closure_datetimes, 'strlen'))){
					$closure_performing_id=$user_id;
					$closure_performing_date=date('d-m-Y H:i');

					$closure_issuing_id=$post['cancellation_issuing_id'];
					$closure_issuing_date=date('d-m-Y H:i');

					$closure_performing_again_id=$post['cancellation_performing_id'];
					$closure_performing_again_date=date('d-m-Y H:i');

					$approval_status=PERMIT_CLOSED;
					$status=STATUS_CLOSED;

					$final_status_date=$final_status_date=='' ? date('Y-m-d H:i') : $final_status_date;

					$acceptance_issuing_date=$acceptance_issuing_date=='' ? date('d-m-Y H:i') : $avi_info['acceptance_issuing_date'];

					$acceptance_issuing_approval=YES;

				}

				$arr=array('jobs_performing_approval_datetime','jobs_closer_performing_ids','jobs_closer_performing_approval_datetime','closure_isolator_ids','isolated_name_closure_datetime');
				
				$update="final_status_date='".$final_status_date."',acceptance_issuing_date='".$acceptance_issuing_date."',acceptance_issuing_approval='".$acceptance_issuing_approval."',status='".$status."',approval_status='".$approval_status."',jobs_performing_approval_datetime='".json_encode($jobs_performing_approval_datetimes,JSON_FORCE_OBJECT)."',jobs_closer_performing_ids='".json_encode($jobs_closer_performing_ids,JSON_FORCE_OBJECT)."',jobs_closer_performing_approval_datetime='".json_encode($jobs_closer_performing_approval_datetimes,JSON_FORCE_OBJECT)."',closure_isolator_ids='".json_encode($closure_isolator_ids,JSON_FORCE_OBJECT)."',isolated_name_closure_datetime='".json_encode($isolated_name_closure_datetimes,JSON_FORCE_OBJECT)."',isolated_name_approval_datetime='".json_encode($isolated_name_approval_datetimes,JSON_FORCE_OBJECT)."',closure_issuing_id='".$closure_issuing_id."',closure_issuing_date='".$closure_issuing_date."',closure_performing_again_date='".$closure_performing_again_date."',closed_lotos='".json_encode($closed_lotos,JSON_FORCE_OBJECT)."',closure_performing_again_id='".$closure_performing_again_id."',closure_performing_id='".$closure_performing_id."',closure_performing_date='".$closure_performing_date."',isolated_name_approval_types='".json_encode($isolated_name_approval_types,JSON_FORCE_OBJECT)."',jobs_performing_approval_types='".json_encode($jobs_performing_approval_types,JSON_FORCE_OBJECT)."',jobs_closer_performing_approval_types='".json_encode($jobs_closer_performing_approval_types,JSON_FORCE_OBJECT)."',isolated_name_closure_approval_types='".json_encode($isolated_name_closure_approval_types,JSON_FORCE_OBJECT)."'";

				#echo $update; exit;

				$up="UPDATE ".$this->db->dbprefix.AVIS." SET ".$update." WHERE id='".$avi_id."'";				
			
				$this->db->query($up);

			endforeach;

		}

		return;
	}

	public function close_jobs_loto($inputs,$pre_loto_ids)
	{
		$loto_ids=array_filter($pre_loto_ids);

		$loto_ids=implode(',',$loto_ids);

		$whr=' j.id IN('.$loto_ids.')';

		$job_pre_isolations=$this->public_model->join_fetch_data(array('select'=>'COUNT(ji.id) as  total_active,ji.jobs_lotos_id,j.eip_checklists_id','table1'=>LOTOISOLATIONSLOG.' ji','table2'=>LOTOISOLATIONS.' j','join_type'=>'inner','join_on'=>'ji.jobs_lotos_id=j.id','where'=>'ji.eip_checklists_id=j.eip_checklists_id AND ji.status="'.STATUS_ACTIVE.'" AND '.$whr,'num_rows'=>false,'group_by'=>'ji.jobs_lotos_id','having'=>'total_active=1'));

		#echo $this->db->last_query(); exit;

		$job_pre_isolations_nums=$job_pre_isolations->num_rows();

		if($job_pre_isolations_nums>0)
		{
			$job_pre_isolations_array=array_values($job_pre_isolations->result_array());

			$job_lotos_ids=array_column($job_pre_isolations_array,'jobs_lotos_id');

			if(count($job_lotos_ids)>0) {

				$job_lotos_ids=implode(',',$job_lotos_ids);

				$data=array('status'=>STATUS_CLOSED,'modified'=>date('Y-m-d H:i'));

				$whr=' id IN('.$job_lotos_ids.')';

				$this->db->update(LOTOISOLATIONS,$data,$whr);
			}

		}

		return $job_pre_isolations_nums;

	}

	public function ajax_get_lotos_jobs()
	{
		$loto_id=$this->input->post('jobs_loto_id');

		$i=$this->input->post('row_id');

		$avi_id=$this->input->post('id');

		$data_disabled=$this->input->post('data_disabled');

		if($avi_id=='')
		$data_disabled='';

		$user_id=$this->session->userdata('user_id');

		$users= $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id,user_role','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND user_role NOT IN ("SA")','column'=>'first_name','dir'=>'asc'))->result_array();

		$avi_info=$this->public_model->get_data(array('table'=>AVIS,'select'=>'jobs_id,	jobs_performing_ids,jobs_performing_approval_datetime,jobs_performing_approval_types,isolated_user_ids,acceptance_issuing_id,isolated_name_approval_datetime,approval_status,acceptance_performing_id,jobs_closer_performing_ids,jobs_closer_performing_approval_datetime,jobs_closer_performing_approval_types,closure_issuing_id,closed_lotos','where_condition'=>'id = "'.$avi_id.'"'))->row_array();
		$approval_status=$avi_info['approval_status'];

		$equipment_number=$this->input->post('equipment_number');

		$where='lil.jobs_lotos_id="'.$loto_id.'"';

		//When IA Approved the AVI
		if(isset($avi_info) && $approval_status>1){

			$avi_jobs_ids=json_decode($avi_info['jobs_id'],true);

			$avi_jobs_ids=implode(',',$avi_jobs_ids[$i]);

			$where.=' AND j.id IN('.$avi_jobs_ids.')';

		} else 
		$where.=' AND j.status IN("'.STATUS_OPENED.'")';


		$job_pre_isolations=$this->public_model->join_fetch_data_three_tables(array('select'=>'ji.equipment_descriptions_name,ji.isolated_tagno1,ji.isolated_tagno2,ji.isolated_user_ids,j.id as job_id,j.permit_no,j.acceptance_performing_id','table1'=>JOBSISOLATION.' ji','table2'=>JOBS.' j','table3'=>LOTOISOLATIONSLOG.' lil','join_type'=>'inner','join_on_tbl2'=>'ji.job_id=j.id','join_on_tbl3'=>'lil.job_id=j.id','where'=>$where,'num_rows'=>false,'group_by'=>'j.id'));

		#echo $this->db->last_query();

		$job_pre_isolations_nums=$job_pre_isolations->num_rows();

		$rows='<table class="table mb-0" border="0" id="isolation_jobs_table'.$loto_id.'">';

		$rows.='<thead>
					<tr>
					<th style="text-align:center:" width="10%">Permit No</th>		
					<th style="text-align:center:" width="10%" class="text-orange">PA Lock No</th>
					<th style="text-align:center:" width="10%" class="text-orange">PA Tag No</th>
					<th style="text-align:center:"  width="15%" >Name of the PA</th>
					<th style="text-align:center:"  width="15%" >Signature Date & Time</th>
					<th style="text-align:center:"  width="10%" >Closer Name of the PA</th>
					<th style="text-align:center:"  width="15%">Signature Date & Time</th>
					</tr>
				</thead>';

		if($job_pre_isolations_nums>0){

			$acceptance_issuing_id=(isset($avi_info['acceptance_issuing_id'])) ? $avi_info['acceptance_issuing_id'] : '';

			$closure_issuing_id=(isset($avi_info['closure_issuing_id'])) ? $avi_info['closure_issuing_id'] : '';			

			$avi_acceptance_performing_id=(isset($avi_info['acceptance_performing_id'])) ? $avi_info['acceptance_performing_id'] : $user_id;

			$jobs_ids=(isset($avi_info['jobs_id'])) ? json_decode($avi_info['jobs_id'],true) : array();

			$jobs_performing_ids=(isset($avi_info['jobs_performing_ids'])) ? json_decode($avi_info['jobs_performing_ids'],true) : array();
			$jobs_performing_approval_datetimes=(isset($avi_info['jobs_performing_approval_datetime'])) ? json_decode($avi_info['jobs_performing_approval_datetime'],true) : array();
			$jobs_performing_approval_types=(isset($avi_info['jobs_performing_approval_types'])) ? json_decode($avi_info['jobs_performing_approval_types'],true) : array();

			$jobs_closer_performing_ids=(isset($avi_info['jobs_closer_performing_ids'])) ? json_decode($avi_info['jobs_closer_performing_ids'],true) : array();
			$jobs_closer_performing_approval_datetimes=(isset($avi_info['jobs_closer_performing_approval_datetime'])) ? json_decode($avi_info['jobs_closer_performing_approval_datetime'],true) : array();
			$jobs_closer_performing_approval_types=(isset($avi_info['jobs_closer_performing_approval_types'])) ? json_decode($avi_info['jobs_closer_performing_approval_types'],true) : array();
			$closed_lotos=(isset($avi_info['closed_lotos'])) ? json_decode($avi_info['closed_lotos'],true) : array();

			$isolated_user_ids=(isset($avi_info['isolated_user_ids'])) ? json_decode($avi_info['isolated_user_ids'],true) : array();

			$isolated_name_approval_datetimes=(isset($avi_info['isolated_name_approval_datetime'])) ? json_decode($avi_info['isolated_name_approval_datetime'],true) : array();

			$approval_status=(isset($avi_info['approval_status'])) ? $avi_info['approval_status'] : '';

			$fetch_job_pre_isolations=$job_pre_isolations->result_array();

			$option_empty_selected='<option value="" selected>Select</option>';

			foreach($fetch_job_pre_isolations as $fetch_job_pre_isolation){

				$permit_no=$fetch_job_pre_isolation['permit_no'];

				$job_id=$fetch_job_pre_isolation['job_id'];

				#echo '<pre>'; print_r($jobs_performing_ids[$i]);

				$equipment_descriptions_names=json_decode($fetch_job_pre_isolation['equipment_descriptions_name'],true);

				$isolated_tagno1=json_decode($fetch_job_pre_isolation['isolated_tagno1'],true);

				$isolated_tagno2=json_decode($fetch_job_pre_isolation['isolated_tagno2'],true);

				$isolated_user_id=(isset($isolated_user_ids[$i]) && $isolated_user_ids[$i]!='') ? $isolated_user_ids[$i] : '';

				$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes[$i]) && $isolated_name_approval_datetimes[$i]!='') ? $isolated_name_approval_datetimes[$i] : '';

				$acceptance_performing_id=(isset($jobs_performing_ids[$i][$job_id]) && $jobs_performing_ids[$i][$job_id]!='') ? $jobs_performing_ids[$i][$job_id] : $fetch_job_pre_isolation['acceptance_performing_id'];

				$jobs_performing_approval_datetime=(isset($jobs_performing_approval_datetimes[$i][$job_id]) && $jobs_performing_approval_datetimes[$i][$job_id]!='') ? $jobs_performing_approval_datetimes[$i][$job_id] : '';


				$acceptance_closer_performing_id=(isset($jobs_closer_performing_ids[$i][$job_id]) && $jobs_closer_performing_ids[$i][$job_id]!='') ? $jobs_closer_performing_ids[$i][$job_id] : '';

				$jobs_closer_performing_approval_datetime=(isset($jobs_closer_performing_approval_datetimes[$i][$job_id]) && $jobs_closer_performing_approval_datetimes[$i][$job_id]!='') ? $jobs_closer_performing_approval_datetimes[$i][$job_id] : '';

				$closed_loto=(isset($closed_lotos[$i][$job_id]) && $closed_lotos[$i][$job_id]!='') ? $closed_lotos[$i][$job_id] : '';
				
				#echo '<pre>';print_r($jobs_closer_performing_approval_datetimes);

				if($acceptance_performing_id==$user_id  && $jobs_performing_approval_datetime=='' && $approval_status==WAITING_AVI_PA_APPROVALS)
				$jobs_performing_approval_datetime=date('d-m-Y H:i');

				if($acceptance_closer_performing_id==$user_id  && $jobs_closer_performing_approval_datetime=='' && $approval_status==WAITING_AVI_PA_CLOSING_APPROVALS)
					$jobs_closer_performing_approval_datetime=date('d-m-Y H:i');

				$key = array_search($equipment_number, $equipment_descriptions_names); 

				$disabled=$disabled_closure_isolated_inputs=$data_disabled;
				
				$disabled_closure_isolated_inputs='disabled';

				if(in_array($user_id,array($isolated_user_id,$acceptance_performing_id,$acceptance_issuing_id,$avi_acceptance_performing_id))){
					
					if($approval_status==WAITING_IA_ACCPETANCE && in_array($user_id,array($avi_acceptance_performing_id,$acceptance_issuing_id)))
					$disabled='';
					else if($jobs_performing_approval_datetime!='')
					$disabled='disabled';
				} 

				
				
				if(in_array($approval_status,array(WORK_IN_PROGRESS,WAITING_CLOSURE_IA_COMPLETION,WAITING_AVI_PA_CLOSING_APPROVALS)) && in_array($user_id,array($avi_acceptance_performing_id,$closure_issuing_id)))
				{
					if($jobs_closer_performing_approval_datetime==''){
						$disabled_closure_isolated_inputs='';
					}
					
				}

				$closed_loto_checkbox='';

				if($jobs_closer_performing_approval_datetime!=''){

					$closed_loto=$closed_loto==1 ? 'checked' : '';

					$dis='disabled';

					if($closed_loto!='checked')
					$dis='';

					$closed_loto_checkbox='<br/><input type="checkbox" class="form-check-input closed_lotos"  name="closed_lotos['.$i.']['.$job_id.']" id="closed_lotos['.$i.']['.$job_id.']" value="1" '.$closed_loto.' '.$dis.' required/> Locked';
				}


				$rows.='<tr>'; //<td>&nbsp;</td>
				
				$rows.='<td ><a href="'.base_url().'jobs/form/id/'.$job_id.'" target="_blank">'.$permit_no.'</a></td><td>'.$isolated_tagno1[$key].'<input type="hidden" name="jobs_id['.$i.'][]" id="jobs_id['.$i.'][]" value="'.$job_id.'" /></td><td>'.$isolated_tagno2[$key].'</td>';

				$generate_users = $this->generate_users($users,'',$acceptance_performing_id);

				$rows.='<td><select name="jobs_performing_ids['.$i.']['.$job_id.']" id="jobs_performing_ids['.$i.']['.$job_id.']" class="form-control jobs_performing_ids  jobs_performing_ids'.$i.$job_id.' data-iso-name jobs_performing_ids'.$i.'" data-attr="'.$i.'" '.($jobs_performing_approval_datetime!='' ? 'disabled' : $disabled).'  >'.$generate_users.'</select></td>';

				$jobs_performing_approval_type=(isset($jobs_performing_approval_types[$i][$job_id]) && $jobs_performing_approval_types[$i][$job_id]!='') ? '<span style="font-size:10px;"><br />Auto Approved by '.$jobs_performing_approval_types[$i][$job_id].'</span>' : '';

				$rows.='<td><input type="text" class="form-control jobs_performing_approval_datetime'.$i.'" name="jobs_performing_approval_datetime['.$i.']['.$job_id.']" id="jobs_performing_approval_datetime['.$i.']['.$job_id.']" value="'.$jobs_performing_approval_datetime.'"  disabled />'.$jobs_performing_approval_type.'</td>';

				$generate_users = $this->generate_users($users,'',$acceptance_closer_performing_id);

				$rows.='<td><select name="jobs_closer_performing_ids['.$i.']['.$job_id.']" id="jobs_closer_performing_ids['.$i.']['.$job_id.']" class="jobs_closer_performing_ids'.$i.$job_id.' form-control jobs_closer_performing_ids data-iso-name jobs_closer_performing_ids'.$i.'" data-attr="'.$i.'" '.$disabled_closure_isolated_inputs.'  required>'.$option_empty_selected.$generate_users.'</select>'.$closed_loto_checkbox.'</td>';

				$jobs_closer_performing_approval_type=(isset($jobs_closer_performing_approval_types[$i][$job_id]) && $jobs_closer_performing_approval_types[$i][$job_id]!='') ? '<span style="font-size:10px;"><br />Auto Approved by '.$jobs_closer_performing_approval_types[$i][$job_id].'</span>' : '';


				$rows.='<td><input type="text" class="form-control jobs_close_performing_approval_datetime'.$i.'" name="jobs_closer_performing_approval_datetime['.$i.']['.$job_id.']" id="jobs_closer_performing_approval_datetime['.$i.']['.$job_id.']" value="'.$jobs_closer_performing_approval_datetime.'"  disabled/>'.$jobs_closer_performing_approval_type.'</td>';

				$rows.='</tr>';
			}


		}

		$rows.='</table>';

		echo json_encode(array('rows'=>$rows,'loto_id'=>$loto_id,'num_rows'=>$job_pre_isolations_nums)); exit;
		
	}


	public function generate_users($users,$disable_all,$isolation_type_user_id='')
	{
		 foreach($users as $fet)
		 {
	 		  
			  $id=$fet['id'];
			  
			  $name=$fet['first_name'];
			  
			  $chk=''; 
			  
			  
			if($isolation_type_user_id==$id) $chk='selected';

			$select.='<option value="'.$id.'" '.$chk.'>'.$name.'</option>';
			 

		 }

		 return $select;
	}

	public function show_all()
	{

		$segment_array=$this->uri->segment_array();
		
		$this->data['params_url']=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	
		
		$filters=$this->generate_where_condition();

		

		$filters['filters']['department_ids']=$this->session->userdata('department_id');

		$this->data['filters']=$filters['filters'];
			
		$this->load->view($this->data['controller'].'show_all',$this->data);

	}

	public function ajax_fetch_show_all_data()
	{
		 
		$job_approval_status=unserialize(JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');

		$session_is_isolator=$this->session->userdata('is_isolator');
		
		$zone_id=$this->session->userdata('zone_id');
		
		$user_role=$this->session->userdata('user_role');
		
		$user_id=$this->session->userdata('user_id');

		$page_name = array_search('page_name',$segment_array);

        $page_name = $this->uri->segment($page_name+1);

		$clearance_departments = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND clearance = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();

		$where_condition=$qry='';
		$extend_where_condition=' (';
		//Extends
		for($i=1;$i<=6;$i++)
		{
			$qry.=' OR je.ext_performing_authorities like \'%"'.$i.'":"'.$user_id.'"%\' OR je.ext_issuing_authorities like \'%"'.$i.'":"'.$user_id.'"%\' ';
		}
		$qry = ltrim($qry,' OR ');
		$extend_where_condition.=$qry.') ';
		//Isolation LOTO

		$isolation_where_condition='('; 
		$qry='';
		for($i=1;$i<=EIP_MINES;$i++)
		{
			$qry.=' ji.isolated_user_ids like \'%"'.$i.'":"'.$user_id.'"%\' OR ';
		}
		$qry=rtrim($qry,'OR ');
		$isolation_where_condition.=$qry.') ';

		
		$dept_clearance_condition='(';
		$qry='';
		//Dept Clearance
		for($i=1;$i<=12;$i++)
		{
			$qry.=' j.clerance_department_user_id like \'%"'.$i.'":"'.$user_id.'"%\' OR ';
		}
		$qry = rtrim($qry,' OR ');
		$dept_clearance_condition.=$qry.') ';
		
		#echo $dept_clearance_condition; exit;
		switch($page_name)
		{
			//My Permits
			case 'index':
						$where_condition='j.status NOT IN("'.STATUS_CLOSED.'","'.STATUS_CANCELLATION.'") AND ';

						$where_condition.=' (j.acceptance_performing_id = "'.$user_id.'" OR j.acceptance_issuing_id= "'.$user_id.'" OR j.cancellation_performing_id= "'.$user_id.'"  OR j.cancellation_issuing_id= "'.$user_id.'" OR ji.acceptance_loto_issuing_id= "'.$user_id.'" OR ji.acceptance_loto_pa_id= "'.$user_id.'" OR '.$extend_where_condition.' OR '.$isolation_where_condition.' OR '.$dept_clearance_condition.') AND ';
						break;
			//Dept Permits
			case 'show_all':
						$where_condition='j.status NOT IN("'.STATUS_CLOSED.'","'.STATUS_CANCELLATION.'") AND j.department_id IN("'.$this->session->userdata('department_id').'") AND ';
						break;
			case 'open_permits':
						$where_condition='j.final_status_date!="" AND j.status IN("'.STATUS_OPENED.'") AND ';
						break;
			case 'closed_permits':
						$where_condition='j.status IN("'.STATUS_CLOSED.'","'.STATUS_CANCELLATION.'") AND ';
						break;
		}

		$generate_conditions=$this->generate_where_condition();
		
		$where_condition.=$generate_conditions['where_condition'];
		
		#echo $where_condition; exit;
		$fields = array( 
							0 =>'j.id', 
							1 =>'j.location',
							2=> 'j.job_name',
							3=> 'c.name',
							4=>'c.contact_no',
							5=>'j.created',
							6=>'j.status',
							8=>'j.approval_status',
							9=>'j.permit_no',
							10=>'j.show_button',
							11=>'j.acceptance_issuing_id',
							12=>'j.cancellation_issuing_id',
							//13=>'j.issuing_authority',
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified',
							16=>'j.is_rejected',
							17=>'j.is_draft',
							18=>'j.draft_user_id',
							19=>'j.is_excavation',
							20=>'j.is_loto',
							21=>'j.clerance_department_user_id',
							22=>'ji.isolated_user_ids',
							23=>'ji.acceptance_loto_issuing_id',
							24=>'ji.acceptance_loto_pa_id',
							25=>'j.acceptance_performing_id',
							26=>'j.loto_closure_ids',
							28=>'j.loto_closure_ids_dates',
							29=>'je.ext_issuing_authorities',
							30=>'j.permit_type',
							31=>'je.ext_reference_codes'
						);
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->jobs_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->jobs_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		
		#echo '<br /> Query : '.$this->db->last_query();  
		$json=array();
		
		$job_status=unserialize(JOB_STATUS);

		$j=0;
		
		if($totalFiltered>0)
		{	
			$permits=$this->public_model->get_data(array('table'=>PERMITSTYPES,'select'=>'name,id,department_id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];
				
				$redirect=base_url().'jobs/form/id/'.$id.'/jobs/index/'.$param_url;
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
				$status=$record['status'];
				
				$approval_status=$record['approval_status'];

				$is_rejected=$record['is_rejected'];

				$permit_types=$record['permit_type'];

				$permit_types=$this->jobs_model->get_permit_types_name($permits,$permit_types);

				if($is_rejected==YES)
					$approval_status=11;
				
				$time_diff='- - -';
				
				if(in_array($status,array(STATUS_PENDING,STATUS_OPENED)) && $record['is_excavation']==NO)
				{
					if($record['time_diff']>PERMIT_CLOSE_AFTER)					
					$record['time_diff'] = PERMIT_CLOSE_AFTER;
					
					$time_diff=(PERMIT_CLOSE_AFTER - $record['time_diff']).' hrs';
				}
				
				#$job_status=array_key_exists($approval_status,$job_approval_status);	
				
				if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
				$color=$job_approval_status_color[$job_approval_status[$approval_status]];
				else
				$color='';
				
				$waiating_approval_by=$this->jobs_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));

				if($record['is_loto']=='Yes' && preg_split('/<br[^>]*>/i', $waiating_approval_by)>0 && in_array($approval_status,array(5,7)))
					$approval_status=WAITING_LOTO_CLOSURE_CLEARANCE;
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$permit_no.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$permit_no=$record['permit_no'];
				
				$print='- - -';
				
				if($show_button=='hide')
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';				
				
				$modified=$record['modified'];

				$reference_codes=(isset($record['ext_reference_codes']) && $record['ext_reference_codes']!='') ? json_decode($record['ext_reference_codes'],true) : array();

				#print_r($reference_codes);

				#$reference_codes=array_filter($reference_codes);

				if(count($reference_codes)>0)
					$reference_codes=implode('<br />',$reference_codes);
				else	
					$reference_codes='- - -';

				$cl='';

				if($user_id==$record['draft_user_id'])
					$cl='red';
				
						$json[$j]['id']='<a href="'.$redirect.'" style="color:'.$cl.'">#'.$permit_no.'</a>';
						$json[$j]['job_name']=$job_name;
						$json[$j]['location']=strtoupper($record['location']);
						$json[$j]['name']=strtoupper($contractor_name);
						$json[$j]['approval_status']=$approval_status;#.' - '.$search;
						$json[$j]['created']=date(DATE_FORMAT.' H:i A',strtotime($created));
						$json[$j]['modified']=date(DATE_FORMAT.' H:i A',strtotime($modified));
						$json[$j]['status']=ucfirst($status);
						$json[$j]['waiating_approval_by']=$waiating_approval_by;
						$json[$j]['action']=$print;
						$json[$j]['time_diff']=$time_diff;
						$json[$j]['is_loto']=$record['is_loto'];
						$json[$j]['permit_types']=$permit_types;
						$json[$j]['reference_codes']=$reference_codes;
						$j++;
			}
		}

		$total_records=$totalFiltered;
		

		$json=json_encode($json);
							
		$return='{"total":'.intval( $total_records ).',"recordsFiltered":'.intval( $total_records ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}

	public function generate_where_condition()
	{
		
		$user_id=$this->session->userdata('user_id');
		
		$where_condition='';

		$filters=array();

		$segment_array=$this->uri->segment_array();

        $department_ids = array_search('department_ids',$this->uri->segment_array());

        if($department_ids !==FALSE && $this->uri->segment($department_ids+1))
        {
            $department_ids = $this->uri->segment($department_ids+1);
			
			if($department_ids!='') {
				$where_condition.=" j.department_id IN(".$department_ids.") AND ";

				$filters['department_ids']=$department_ids;
			}
		}	

		$zone_ids = array_search('zone_ids',$this->uri->segment_array());

        if($zone_ids !==FALSE && $this->uri->segment($zone_ids+1))
        {
            $zone_ids = $this->uri->segment($zone_ids+1);
			
			if($zone_ids!='') {
				$where_condition.=" j.zone_id IN(".$zone_ids.") AND ";

				$filters['zone_ids']=$zone_ids;
			}
		}

		$permit_types = array_search('permit_types',$this->uri->segment_array());

        if($permit_types !==FALSE && $this->uri->segment($permit_types+1))
        {
            $permit_types = $this->uri->segment($permit_types+1);
			
			if($permit_types!='') {

				$permit_type_where_condition=' (';
				//Extends
				for($i=0;$i<=11;$i++)
				{
					$permit_type_where_condition.=' j.permit_type LIKE \'%"'.$i.'":"'.$permit_types.'"%\' OR ';
				}

				$permit_type_where_condition = rtrim($permit_type_where_condition,' OR ');
				$permit_type_where_condition=$permit_type_where_condition.') ';


				$where_condition.=$permit_type_where_condition.' AND ';

				$filters['permit_types']=$permit_types;
			}
		}

		$status = array_search('status',$this->uri->segment_array());

        if($status !==FALSE && $this->uri->segment($status+1))
        {
            $status = $this->uri->segment($status+1);
			
			if($status!='') {
				$where_condition.=" j.approval_status IN(".$status.") AND ";
				$filters['status']=$status;
			}
		}

		$search_txt = array_search('search_txt',$this->uri->segment_array());

        if($search_txt !==FALSE && $this->uri->segment($search_txt+1))
        {
            $search_txt = trim($this->uri->segment($search_txt+1));
			
			if($search_txt!=''){
				$where_condition.=" (j.permit_no LIKE '%".$search_txt."%' OR j.job_name LIKE '%".$search_txt."%') AND ";
				$filters['search_txt']=$search_txt;
			}
		}	

		$subscription_date_start = array_search('subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);

		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));

		if($subscription_date_start=='' || $subscription_date_start=='1970-01-01'){
			$subscription_date_start=date('Y-m-d',strtotime("-30 days"));
		}
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));

		if($subscription_date_end=='' || $subscription_date_end=='1970-01-01'){
			$subscription_date_end=date('Y-m-d');
		}

		$filters['subscription_date_start']=$subscription_date_start;
		$filters['subscription_date_end']=$subscription_date_end;
		
		
		$where_condition.=' DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';

		$where_condition=rtrim($where_condition,' AND ');

		return array('where_condition'=>$where_condition,'filters'=>$filters);
	}

	public function printout()
	{ 
		error_reporting(0);
		$this->data['permits'] = $this->public_model->get_data(array('table'=>PERMITSTYPES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();
		$this->data['allusers'] = $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id,user_role','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND user_role NOT IN ("SA")','column'=>'first_name','dir'=>'asc'))->result_array();
		$this->data['clearance_departments'] = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND clearance = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();
		$this->data['departments']=$this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();
		
		$readonly='';
		
		$zone_id=$this->session->userdata('zone_id');
		
		$department_id=$this->session->userdata('department_id');
		
		$user_name=$this->session->userdata('first_name');
		
		$user_id=$this->session->userdata('user_id');

		if($user_id=='')
		{
			$user_id=$this->session->userdata(ADMIN.'user_id');

			$user_name=$this->session->userdata(ADMIN.'first_name');
		}
		
		$authorities=$job_isolations_where=$job_status_error_msg='';
		#echo $this->db->last_query(); exit;
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
		
		$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
		
		$this->data['isoloation_permit_no']='';
		
        $id = $this->input->post('id');

        if($id!='')
        {
            $req=array(
              'select'  =>'*,TIMESTAMPDIFF(HOUR, modified, "'.date('Y-m-d H:i').'") as time_diff',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>JOBS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{
                $records=$qry->row_array();

				$this->data['records']=$records;	
				$department_id = $records['department_id'];		
				$zone_id = $records['zone_id'];
				$req=array(
					'select'  =>'*',#,DATEDIFF(NOW(),modified) AS DiffDate
					'table'    =>JOBSPRECAUTIONS,
					'where'=>array('job_id'=>$id)
				  );
				  $qry=$this->public_model->fetch_data($req);
				
				  $records=$qry->row_array();

				  $this->data['precautions']=$records;				
				
				$msg=$user_name.' accessed job information and take Print out';
				
				$array=array('notes'=>$msg,'created'=>date('Y-m-d H:i'),'user_id'=>$user_id,'job_id'=>$id);
				
				$this->db->insert(JOBSHISTORY,$array);
				
				 $job_isolations=$this->public_model->get_data(array('table'=>JOBSISOLATION,'select'=>'*','where_condition'=>'job_id = "'.$id.'"'))->row_array();

				 $this->data['job_isolations']=$job_isolations;

				 $fetch=$this->public_model->get_data(array('table'=>EIP_CHECKLISTS,'select'=>'equipment_name,id,equipment_number','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND zone_id="'.$zone_id.'" AND equipment_number!=""','column'=>'equipment_name','dir'=>'asc'));
		
				 $num_rows=$fetch->num_rows();

				 $checklists=$fetch->result_array();

				 $this->data['checklists']=$checklists;

				 $isolations=$this->public_model->get_data(array('table'=>ISOLATION,'select'=>'name,id,record_type,isolation_type_id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
				 $isolations=$isolations->result_array();

				 $this->data['isolations']=$isolations;

				 $this->data['jobs_extends'] = $this->public_model->get_data(array('table'=>JOB_EXTENDS,'select'=>'*','where_condition'=>'job_id = "'.$id.'"','column'=>'id','dir'=>'asc'))->row_array();

            }   
        }
		
	 	$where=" user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
		//Getting Active Companys List
		$qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));

		if($qry->num_rows()>0)
		{
			$authorities=$qry->result_array();
		}

		
		
		$this->data['department'] = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND id="'.$department_id.'"','column'=>'name','dir'=>'asc'))->row_array();

		#echo $this->db->last_query(); exit;
		
		$this->data['authorities']=$authorities;
		
		$this->data['user_id']=$this->session->userdata('user_id');
		
		$this->data['readonly']=$readonly;
		
		$this->data['job_status_error_msg']=$job_status_error_msg;
		
		$this->load->view($this->data['controller'].'printout',$this->data);
	}

	public function printoutwpra()
	{ 
		error_reporting(0);
		$this->data['permits'] = $this->public_model->get_data(array('table'=>PERMITSTYPES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();
	
		
		$readonly='';
		
		$zone_id=$this->session->userdata('zone_id');
		
		$department_id=$this->session->userdata('department_id');
		
		$user_name=$this->session->userdata('first_name');
		
		$user_id=$this->session->userdata('user_id');

		if($user_id=='')
		{
			$user_id=$this->session->userdata(ADMIN.'user_id');

			$user_name=$this->session->userdata(ADMIN.'first_name');
		}
		
		$authorities=$job_isolations_where=$job_status_error_msg='';
		#echo $this->db->last_query(); exit;
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
		
		$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
		
		$this->data['isoloation_permit_no']='';
		
        $id = $this->input->post('id');

        if($id!='')
        {
            $req=array(
              'select'  =>'*,TIMESTAMPDIFF(HOUR, modified, "'.date('Y-m-d H:i').'") as time_diff',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>JOBS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{
                $records=$qry->row_array();

				$this->data['records']=$records;	
				$department_id = $records['department_id'];		
				$req=array(
					'select'  =>'*',#,DATEDIFF(NOW(),modified) AS DiffDate
					'table'    =>JOBSPRECAUTIONS,
					'where'=>array('job_id'=>$id)
				  );
				  $qry=$this->public_model->fetch_data($req);
				
				  $records=$qry->row_array();

				  $this->data['precautions']=$records;				
				
				$msg=$user_name.' accessed WPRA information and take Print out';
				
				$array=array('notes'=>$msg,'created'=>date('Y-m-d H:i'),'user_id'=>$user_id,'job_id'=>$id);
				
				$this->db->insert(JOBSHISTORY,$array);
				
				$show_button=$records['show_button'];
				
				 if($show_button=='hide')
				 $readonly=true;
				
				 $this->data['jobs_extends'] = $this->public_model->get_data(array('table'=>JOB_EXTENDS,'select'=>'schedule_to_dates,schedule_from_dates','where_condition'=>'job_id = "'.$id.'"','column'=>'id','dir'=>'asc'))->row_array();
				
            }   
        }
		
	 	$where=" user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
		//Getting Active Companys List
		$qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));

		if($qry->num_rows()>0)
		{
			$authorities=$qry->result_array();
		}

		
		
		$this->data['department'] = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND id="'.$department_id.'"','column'=>'name','dir'=>'asc'))->row_array();

		#echo $this->db->last_query(); exit;
		
		$this->data['authorities']=$authorities;
		
		$this->data['user_id']=$this->session->userdata('user_id');
		
		$this->data['readonly']=$readonly;
		
		$this->data['job_status_error_msg']=$job_status_error_msg;
		
		$this->load->view($this->data['controller'].'printoutwpra',$this->data);
	}

	public function index2()
	{ 
		
		redirect('jobs/myjobs');
		
		$company_id=$this->session->userdata('companies_id');
	
		
		$dashboard_counts=json_decode($this->public_model->dashboard_count());		
		#echo $this->db->last_query(); exit;
		
		#echo '<pre>'; print_r($dashboard_counts); exit;
		$this->data['status']=$dashboard_counts->status;
		
		$this->data['status_counts']=$dashboard_counts->status_counts;
		
		$this->data['eip_status']=$dashboard_counts->eip_status;
		
		$this->data['eip_status_counts']=$dashboard_counts->eip_status_counts;
		
		$this->load->view($this->data['controller'].'lists',$this->data);
	}
	
	public function view_all_messages()
	{
		$this->load->view($this->data['controller'].'view_all_messages',$this->data);
	}
	
	public function fetch_all_messages()
	{
		$access_modules = $this->session->userdata('user_access'); 
		
		$user_access = explode(',',$access_modules);
		
		$company_id=$this->session->userdata('companies_id');
		
		$segment_array=$this->uri->segment_array();

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$where_condition='companies_id="'.$company_id.'" AND ';
		  
		  //Getting in URL params
		  $request_search=(isset($_REQUEST['search'])) ? $_REQUEST['search'] : '';
		  if(trim($request_search)!='')
		  $search_value=$request_search;
		  
          /* Search Parameters */
		  //Using for reload datatable
		
		$where_condition=rtrim($where_condition,'AND ');
		
		if(!empty($search_value))
		{
			$search_value=urldecode($search_value);
			
			$where_condition.=" AND (message like '%".$search_value."%')";
		}
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$records=$this->public_model->fetch_message_data(array('table'=>MESSAGE,'select'=>'*','num_rows'=>false,'where_condition'=>$where_condition,'column'=>$sort_by,'dir'=>$order_by,'limit'=>$limit));
		
		$totalFiltered=$this->public_model->fetch_message_data(array('table'=>MESSAGE,'select'=>'*','where_condition'=>$where_condition,'num_rows'=>true));
		
		//$totalFiltered = $records->num_rows();
		
		$json=array();
		
		if($records->num_rows()>0)
		{
			$j=0;
			$records = $records->result_array();
			foreach($records as $record)
			{						
						if(in_array('accounts',$user_access)) 
							$json[$j]['message']=str_replace("BASE_URL",base_url(),$record['message']);
						else
							$json[$j]['message']=strip_tags($record['message']);
						$json[$j]['created']='<center>'.$record['created'].'</center>';
						$j++;
			}
		}

		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}

	public function get_max_permit_id($array_args)
	{
		extract($array_args);
		
			$qry=$this->db->query("SELECT MAX(permit_no_sec)+1 as permit_no FROM ".$this->db->dbprefix.JOBS." WHERE department_id='".$department_id."'");
			
			#echo $this->db->last_query(); exit;
			$fet=$qry->row_array();	
			
			if($fet['permit_no']=='')
			$fet['permit_no']='1';

		#echo '<pre>'; print_r($this->session->userdata); exit;

			if($this->session->userdata('department_name')=='Power Plant')
			$dept='PP';
			else if($this->session->userdata('department_id')==EIP_ELECTRICAL)	
			$dept='EI';
			else			
			$dept=substr($this->session->userdata('department_name'),0,2);
			
			return strtoupper($dept.$fet['permit_no']);
			
			#$this->data['permit_no']=strtoupper(substr($this->session->userdata('department_name'),0,2).$fet['permit_no']);
	}

	public function ajax_fetch_open_permits()
	{
		 
		$job_approval_status=unserialize(JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');
		
		$zone_id=$this->session->userdata('zone_id');
		
		$user_role=$this->session->userdata('user_role');
		
		$user_id=$this->session->userdata('user_id');

		$qry=$qry2='';

		$where_condition='j.final_status_date!="" AND j.status IN("'.STATUS_OPENED.'")';
		
		#$where_condition=' (j.acceptance_issuing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'" OR j.acceptance_performing_id = "'.$user_id.'" OR j.cancellation_performing_id = "'.$user_id.'") AND ';
		
		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		  }
		  
		 # $where_condition .= "j.approval_status NOT IN (4,6,10)";

		 // echo $where_condition; exit;
		
		  $fields = array( 
							0 =>'j.id', 
							1 =>'j.location',
							2=> 'j.job_name',
							3=> 'c.name',
							4=>'c.contact_no',
							5=>'j.created',
							6=>'j.status',
							8=>'j.approval_status',
							9=>'j.permit_no',
							10=>'j.show_button',
							11=>'j.acceptance_issuing_id',
							12=>'j.cancellation_issuing_id',
							//13=>'j.issuing_authority',
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified',
							16=>'j.is_rejected',
							17=>'j.is_draft',
							18=>'j.draft_user_id',
							19=>'j.loto_closure_ids',
							20=>'j.is_loto',
							21=>'j.loto_closure_ids_dates',
							22=>'je.ext_issuing_authorities'
						);
		
		$where_condition=rtrim($where_condition,'AND ');

		
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->jobs_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->jobs_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		
		//echo '<br /> Query : '.$this->db->last_query();  
		$json=array();
		
		$job_status=unserialize(JOB_STATUS);

		$j=0;
		
		if($totalFiltered>0)
		{	
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];
				
				$redirect=base_url().'jobs/form/id/'.$id.'/jobs/index/'.$param_url;
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
				$status=$record['status'];
				
				$approval_status=$record['approval_status'];

				$is_rejected=$record['is_rejected'];

				if($is_rejected==YES)
					$approval_status=11;
				
				$time_diff='- - -';
				
				if(!in_array($approval_status,$job_status))
				{
					if($record['time_diff']>PERMIT_CLOSE_AFTER)					
					$record['time_diff'] = PERMIT_CLOSE_AFTER;
					
					$time_diff=(PERMIT_CLOSE_AFTER - $record['time_diff']).' hrs';
				}
				
				
				
				#$job_status=array_key_exists($approval_status,$job_approval_status);	
				
				if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
				$color=$job_approval_status_color[$job_approval_status[$approval_status]];
				else
				$color='';
				
				$waiating_approval_by=$this->jobs_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));

				if($record['is_loto']=='Yes' && preg_split('/<br[^>]*>/i', $waiating_approval_by)>0 && in_array($approval_status,array(5,7)))
					$approval_status=WAITING_LOTO_CLOSURE_CLEARANCE;
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$permit_no.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$permit_no=$record['permit_no'];
				
				$print='- - -';
				
				if($show_button=='hide')
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';				
				
				$modified=$record['modified'];

				$cl='';

				if($user_id==$record['draft_user_id'])
					$cl='red';
				
						$json[$j]['id']='<a href="'.$redirect.'" style="color:'.$cl.'">#'.$permit_no.'</a>';
						$json[$j]['job_name']=$job_name;
						$json[$j]['location']=strtoupper($record['location']);
						$json[$j]['name']=strtoupper($contractor_name);
						$json[$j]['approval_status']=$approval_status;#.' - '.$search;
						$json[$j]['created']=date(DATE_FORMAT,strtotime($created));
						$json[$j]['modified']=date(DATE_FORMAT.' H:i A',strtotime($modified));
						$json[$j]['status']=ucfirst($status);
						$json[$j]['waiating_approval_by']=$waiating_approval_by;
						$json[$j]['action']=$print;
						$json[$j]['time_diff']=$time_diff;
						$j++;
			}
		}

		$total_records=$totalFiltered;
		

		$json=json_encode($json);
							
		$return='{"total":'.intval( $total_records ).',"recordsFiltered":'.intval( $total_records ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}

	public function ajax_fetch_closeddata()
	{
		
		 $job_approval_status=unserialize(JOBAPPROVALS);
		 
		 $job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');
		
		$zone_id=$this->session->userdata('zone_id');
		
		$where_condition='j.status IN("'.STATUS_CLOSED.'","'.STATUS_CANCELLATION.'")';

        $zone_id = array_search('zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id ='".$zone_id."' AND ";
		}

		
		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no like '%".$search_value."%') AND ";
		  }
		
		$fields = array( 
							0 =>'j.id', 
							1 =>'j.location',
							2=> 'j.job_name',
							3=> 'c.name',
							4=>'c.contact_no',
							5=>'j.created',
							6=>'j.status',
							7=>'j.show_button',
							8=>'j.permit_no',
							9=>'j.approval_status',
							10=>'j.acceptance_performing_id',
							11=>'j.acceptance_issuing_id',
							12=>'j.cancellation_issuing_id',
							14=>'j.modified',
							15=>'j.location_time_start',
							16=>'j.location_time_to',
							17=>'j.loto_closure_ids',
							18=>'j.is_loto',
							19=>'j.loto_closure_ids_dates',
							20=>'je.ext_issuing_authorities'
						);
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->jobs_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->jobs_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		
		#echo $this->db->last_query();  exit;
		
		$json=array();
		
		if($totalFiltered>0)
		{
			$j=0;
			
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];

				$redirect=base_url().'jobs/form/id/'.$id.'/jobs/closed_permits/'.$param_url;
				
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
				$modified=$record['modified'];
				
				$status=$record['status'];

				$location_time_start=date('d-m-Y H:i:A',strtotime($record['location_time_start']));
				$location_time_to=date('d-m-Y H:i:A',strtotime($record['location_time_to']));

				$json[$j]['id']='<a href="'.$redirect.'">'.'#'.$permit_no.'</a>';
				$json[$j]['job_name']=$job_name;
				$json[$j]['location']=strtoupper($record['location']);

				$json[$j]['location_time_start']=$location_time_start;
				$json[$j]['location_time_to']=$location_time_to;

				$json[$j]['created']=date(DATE_FORMAT,strtotime($created));
				$json[$j]['status']=ucfirst($status);
				$json[$j]['modified']=date(DATE_FORMAT.' H:i A',strtotime($modified));
				$j++;
			}
		}

		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}
}
