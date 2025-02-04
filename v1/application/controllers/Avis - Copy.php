<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Dashboard.php
 * Project        : Formwork
 * Creation Date  : 12-14-2016
 * Author         : Anantha Kumar RJ
 * Description    : Manageing Dashbaord Datas 
*********************************************************************************************/	

class Avis extends CI_Controller
 {

	function __construct()
	{
		parent::__construct(); 
        $this->load->model(array('security_model','jobs_model','public_model','jobs_isolations_model','avis_model'));
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

	public function form()
	{
		$segment_array=$this->uri->segment_array();
		$param_url=$this->public_model->get_params_url(array('start'=>5,'segment_array'=>$segment_array));
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

			$where_condition='a.id="'.$id.'"';

			$fields = 'a.*';

			$qry = $this->avis_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>0,'length'=>1,'column'=>'a.id','dir'=>'asc'))->row_array();
			
			$this->data['records'] = $qry;

			$zone_id=$qry['zone_id'];
		
			$where=" user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";

					//Getting Active Companys List
			$qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS,'column'=>'first_name','dir'=>'asc'));
		
			#echo $this->db->last_query(); exit;
			if($qry->num_rows()>0)
			{
				$authorities=$qry->result_array();
			}
			$this->data['authorities'] = $authorities;

			$this->data['notes'] = $this->public_model->get_data(array('table'=>AVISREMARKS,'select'=>'*','where_condition'=>'avi_id = "'.$id.'"','column'=>'id','dir'=>'desc','limit'=>5))->result_array();

			$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'id,name','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND id="'.$zone_id.'"','column'=>'name','dir'=>'asc','limit'=>5));
        }
		else
		{
			if($this->session->userdata('permission')==WRITE)
			{	
				$this->load->model(array('cron_job_model'));

				$where=' AND id ="'.$this->session->userdata('user_id').'"';

				#$this->cron_job_model->check_expired_permits(array('where'=>$where,'type'=>'single'));
			}
		}

		$this->data['param_url']=$param_url;

		$this->load->view($this->data['controller'].'form',$this->data);
	}

	public function form_action()
	{

		#echo '<pre>';print_r($this->input->post()); exit;
		
		$submit_type=$this->input->post('submit_type');

        $job_id=$this->input->post('job_id');

		$approval_status = $this->input->post('approval_status');

		if($approval_status=='undefined')
		$_POST['approval_status']=WAITING_IA_ACCPETANCE;

		$user_name=$this->session->userdata('first_name');

		$_POST['last_updated_by']=$user_name;
		
		$user_id=$this->session->userdata('user_id');
		
		//$approval_status=unserialize(JOBAPPROVALS);
		
		$array_fields=array('isolated_name_approval_datetime','jobs_loto_ids','isolated_user_ids','closure_isolator_ids','isolated_name_closure_datetime','jobs_id','jobs_performing_ids','jobs_performing_approval_datetime');
		
		$skip_fields=array('id','submit_type','equipment_descriptions','equipment_tag_nos','isolated_tagno1','isolated_tagno2','isolated_tagno3','step1','notes','show_button','equipment_number_ids');
		
		$print_out='';$arr=array();$fields='';$fields_values='';$update=''; $msg='';
		
		$short_dept=substr($this->session->userdata('department_name'),0,2);

		$is_send_sms=$show_button='';

		$status=(isset($_POST['status'])) ? $_POST['status'] : '';
		$permit_type=$this->input->post('permit_type');
		$pre_approval_status=1;

		if(!$this->input->post('id'))	//If new jobs create
		{
				$_POST['acceptance_performing_date']=date('d-m-Y H:i');	

				$_POST['approval_status']=WAITING_IA_ACCPETANCE;	//Waiting IA Acceptance
				
				$_POST['status']=STATUS_PENDING;

                $msg=$user_name.' has initiated the AVI and sent IA request approval';
		}	
		else
		{
			$show_button=''; //($_POST['show_button']) ? trim($_POST['show_button']) : '';

			$job_id = $this->input->post('id');

			$job_qry=$this->public_model->get_data(array('select'=>'id,acceptance_issuing_id,closure_issuing_id,approval_status,status,last_updated_by,last_modified_id,acceptance_performing_id,closure_issuing_id','where_condition'=>'id ="'.$job_id.'"','table'=>AVIS));

			$job_result = $job_qry->row_array();

			$db_modified=$job_result['last_modified_id'];

			$modified=$this->input->post('last_modified_id');			
			
			$pre_approval_status=$job_result['approval_status'];

			if($db_modified!=$modified)		//Check if any update info recently
			{
				$this->session->set_flashdata('failure','Sorry, Just before <b>'.$job_result['last_updated_by'].'</b> has updated this permit info. Please check updated information');  

				$ret=array('status'=>false,'print_out'=>'');		                   
      
				#echo json_encode($ret);

				#exit;
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

					$msg='<b>IA '.$user_name.' '.$lbl.' this job and sent request approval to Isolator users</b>';		

					
					$_POST['approval_status']=WAITING_ISOLATORS_COMPLETION;	
					
				}

				
			}


			//Isolators Users Logged
			if(in_array($pre_approval_status,array(WAITING_ISOLATORS_COMPLETION)))
			{
				$jobs_loto_ids=$this->input->post('jobs_loto_ids');

				$clearance_department_dates=$this->input->post('isolated_name_approval_datetime');

				#echo 'Count '.count(array_filter($eq_tag)).' = '.count(array_filter($clearance_department_dates)); exit;

				if(count(array_filter($jobs_loto_ids)) == count(array_filter($clearance_department_dates)))
				{
					$_POST['approval_status'] = WAITING_AVI_PA_APPROVALS;

					$msg = 'Isolation Approval are completed and sent approval requests to PA';
				} 
			}

			//Jobs Owners Approvals
			if(in_array($pre_approval_status,array(WAITING_AVI_PA_APPROVALS)))
			{
				$jobs_loto_ids=$this->input->post('jobs_loto_ids');

				$jobs_performing_approval_datetimes=$this->input->post('jobs_performing_approval_datetime');

				$k=0;

				foreach($jobs_performing_approval_datetimes as $key => $jobs_performing_approval_datetime){

					$cnt=count($jobs_performing_approval_datetime);

					if($cnt>0 && count(array_filter($jobs_performing_approval_datetime, 'strlen'))!=$cnt)
					$k=1;

				}

				

				if($k==0)
				{
					$_POST['approval_status'] = AWAITING_FINAL_SUBMIT;

					$msg = 'PA Approval are completed and sent final submit request to AVI PA';
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

				$msg='<b>PA started the AVI</b>';
			}

			//After Final Submit
			if(in_array(strtolower($pre_approval_status),array(WORK_IN_PROGRESS)) && $user_id==$acceptance_performing_id)
			{
				$_POST['approval_status']= WAITING_CLOSURE_IA_COMPLETION;
				$_POST['closure_performing_date']=date('d-m-Y H:i');
				$msg='PA sent <b>closure approval</b> request to IA';
			}

			//Closure IA Completion
			if(in_array($pre_approval_status,array(WAITING_CLOSURE_IA_COMPLETION)) && $user_id==$job_result['closure_issuing_id'])
			{
				$_POST['closure_issuing_date'] = date('d-m-Y H:i');

				$_POST['approval_status'] = WAITING_CLOSURE_ISOLATORS_COMPLETION;

				$msg='<b>IA</b> approved the closure and sent request to Isolators';
			}

			//ReIsolators Users Logged
			if(in_array($pre_approval_status,array(WAITING_CLOSURE_ISOLATORS_COMPLETION)))
			{
				$jobs_loto_ids=$this->input->post('jobs_loto_ids');

				$isolated_name_closure_datetimes=$this->input->post('isolated_name_closure_datetime');

				#echo 'Count '.count(array_filter($jobs_loto_ids)).' = '.count(array_filter($isolated_name_closure_datetimes)); exit;

				if(count(array_filter($jobs_loto_ids)) == count(array_filter($isolated_name_closure_datetimes)))
				{
					$_POST['approval_status'] = WAITING_PA_CLOSURE;

					$msg = 'Closure Isolation Approval are completed and sent final closing request to PA';
				} 
			}

			//Close PA
			if(in_array($pre_approval_status,array(WAITING_PA_CLOSURE)) && $user_id==$acceptance_performing_id)
			{
				$_POST['closure_performing_again_date'] = date('d-m-Y H:i');

				$_POST['approval_status'] = PERMIT_CLOSED;

				$_POST['status'] = STATUS_CLOSED;

				$msg='All details are verified and closed by PA';
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
			}
			
		}

		#echo '<pre>'; print_r($_POST); exit;
		
		$jobs_loto_ids=$this->input->post('jobs_loto_ids');

        $isolated_user_ids=$this->input->post('isolated_user_ids');

        $_POST['isolated_user_ids'] = array();

        foreach($jobs_loto_ids as $key => $tag):
            $_POST['isolated_user_ids'][$key] = $isolated_user_ids[$key];
        endforeach;

		$_POST['last_modified_id']=rand(time(),5);

		$id=($this->input->post('id')) ? $this->input->post('id') : '';

		$inputs=$this->input->post();

		#echo '<br /> MSg '.$msg;

		#echo '<pre>'; print_r($_POST); exit;
		//Jobs Inputs
		foreach($inputs as $field_name => $field_value)
		{
			if(!in_array($field_name,$skip_fields))
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

			$ins="INSERT INTO ".$this->db->dbprefix.AVIS." (".$fields.") VALUES (".$fields_values.")";
		
			$this->db->query($ins);
			
			$id=$this->db->insert_id();		

            $affectedRows = $this->db->affected_rows();
			
			$msg='<b>Created by '.$user_name.' and sent request to IA</b>';		
			
			$this->session->set_flashdata('success','New AVI has been created successfully');    
			
		}
		else
		{
			$up="UPDATE ".$this->db->dbprefix.AVIS." SET ".$update." WHERE id='".$id."'";
			
			$this->db->query($up);

            $affectedRows = $this->db->affected_rows();

			$this->session->set_flashdata('success','AVI info has been updated successfully');    
		}

		$jobs_loto_ids=$this->input->post('jobs_loto_ids');

		#echo '<pre>'; print_r($_POST); exit;

		$array_batch_insert=array();

		if($pre_approval_status<=1){

			$this->db->where('avis_id',$id);
			$this->db->delete(AVISLOTOS);

			$equipment_number_ids=$this->input->post('equipment_number_ids');

			foreach($jobs_loto_ids as $key => $loto_id){
				$array_batch_insert[]=array('eip_checklists_id'=>$equipment_number_ids[$key],'avis_id'=>$id);
			}

			if(count($array_batch_insert)>0){
				$this->db->insert_batch(AVISLOTOS,$array_batch_insert);		
			}
		}
		
		$notes = isset($_POST['notes'])  ? trim($_POST['notes']) : '';
		//Job Notes
		
		if($notes!='')
		{
			$notes = @addslashes($notes);

			$fields='avi_id,approval_status,user_id,created,last_updated_by,notes';

			$fields_values='"'.$id.'","'.$approval_status.'","'.$user_id.'","'.date('Y-m-d H:i').'","'.$user_name.'","'.$notes.'"';
			
			$qry="INSERT INTO ".$this->db->dbprefix.AVISREMARKS." (".$fields.") VALUES (".$fields_values.")";

			$this->db->query($qry);
		}

		
		if($affectedRows>0)
		{	
			if($msg!='')
			{
				$array=array('user_id'=>$user_id,'avi_id'=>$id,'notes'=>$msg,'created'=>date('Y-m-d H:i'));
			
				$this->db->insert(AVIS_HISTORY,$array);
			}	
		}	
		
		$ret=array('status'=>true,'print_out'=>$print_out);
		                   
       # echo 'true'; 
		echo json_encode($ret);
		
		exit;
	}

	public function ajax_get_avi_eip_checklists()
	{

		#error_reporting(0);

		$user_id=$this->session->userdata('user_id');

		$zone_id = $this->input->post('zone_id');

		$id=$this->input->post('avi_id');


		//Fetch isolation users
		$isolations=$this->public_model->get_data(array('table'=>ISOLATION,'select'=>'name,id,record_type,isolation_type_id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));

		$isolations=$isolations->result_array();

		$isolation_users = $this->jobs_isolations_model->get_isolation_users(array())->result_array();


		$acceptance_performing_id=$acceptance_issuing_id=$approval_status='';
		$jobs_loto_ids=$isolated_user_ids=$closure_isolator_ids=$isolated_name_approval_datetimes=$isolated_name_closure_datetimes=array();

		$avi_info=$this->public_model->get_data(array('table'=>AVIS,'select'=>'*','where_condition'=>'id = "'.$id.'"'));

		if($avi_info->num_rows()>0){
			$avi_info=$avi_info->row_array();
		
			$acceptance_performing_id=$avi_info['acceptance_performing_id'];
			$acceptance_issuing_id=$avi_info['acceptance_issuing_id'];
			$approval_status=$avi_info['approval_status'];
			$jobs_loto_ids = (isset($avi_info['jobs_loto_ids'])) ? json_decode($avi_info['jobs_loto_ids'],true) : array();

			$isolated_user_ids=(isset($avi_info['isolated_user_ids'])) ? json_decode($avi_info['isolated_user_ids']) : array();
			$closure_isolator_ids=(isset($avi_info['closure_isolator_ids'])) ? json_decode($avi_info['closure_isolator_ids']) : array();
			
			$isolated_name_approval_datetimes = (isset($avi_info['isolated_name_approval_datetime'])) ? json_decode($avi_info['isolated_name_approval_datetime']) : array();
			$isolated_name_closure_datetimes = (isset($avi_info['isolated_name_closure_datetime'])) ? json_decode($avi_info['isolated_name_closure_datetime']) : array();
		}

		$where='j.zone_id="'.$zone_id.'" AND j.status="'.STATUS_OPENED.'" AND lil.status="'.STATUS_ACTIVE.'"';

		if($approval_status>1){
			$jobslotoids=implode(',',$jobs_loto_ids);

			$where='j.zone_id="'.$zone_id.'" AND lil.jobs_lotos_id IN('.$jobslotoids.')';
		}


		$job_isolations_logs=$this->public_model->join_fetch_data(array('select'=>'lil.jobs_lotos_id','table1'=>JOBS.' j','table2'=>LOTOISOLATIONSLOG.' lil','join_type'=>'inner','join_on'=>'lil.job_id=j.id','where'=>$where,'num_rows'=>false))->result_array();


		//Fetch all equipments based on to the zone Not using
		#$equipments_info=$this->public_model->get_data(array('table'=>EIP_CHECKLISTS,'select'=>'equipment_name,id,equipment_number','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND zone_id="'.$zone_id.'" AND equipment_number!=""','column'=>'equipment_name','dir'=>'asc'))->result_array();

		


		

		

		$job_pre_isolations=$this->public_model->join_fetch_data(array('select'=>'ec.equipment_name as equipment_number,li.isolated_tagno3,li.isolation_type_id,li.id AS loto_id,ec.id as equipment_number_id','table1'=>EIP_CHECKLISTS.' ec','table2'=>LOTOISOLATIONS.' li','join_type'=>'inner','join_on'=>'li.eip_checklists_id=ec.id','where'=>'ec.zone_id="'.$zone_id.'" AND ec.status="'.STATUS_ACTIVE.'" AND li.status="'.STATUS_ACTIVE.'"','num_rows'=>false));

		$num_rows=$job_pre_isolations->num_rows();

		$rows='
				<thead>
					<tr>
					<th style="text-align:center:" width="5%">Select</th>
					<th style="text-align:center:" width="10%">Equip Tag No</th>		
					<th style="text-align:center:" width="10%" class="text-orange">ISO Lock No</th>
					<th style="text-align:center:"  width="18%" >Name of the Isolator</th>
					<th style="text-align:center:"  width="10%" >Acceptance Signature Date & Time</th>
					<th style="text-align:center:"  width="18%" >Closer Name of the Isolator</th>
					<th style="text-align:center:" width="15%">Closure Date & Time</th>
					</tr>
				</thead>';
		
		if($num_rows>0){

			$job_isolations=$job_pre_isolations->result_array();

			$disabled_isolated_inputs=$disabled_closure_isolated_inputs=$generate_closure_isolation_users=$isolated_name_closure_datetime='';
			
			$i=1;

			foreach($job_isolations as $job_isolation)
			{
				$i=$job_isolation['equipment_number_id'];
				$equipment_number_id=$job_isolation['equipment_number_id'];


				$radio_yes_check=$radio_no_check=$type_isolation=$description_equipment=$isolated_tag1=$isolated_tag2=$isolated_tag3=$isolation_type_user_id=$equipment_tag_no=$isolated_name_approval_datetime=$isolated_ia_name=$isolated_name_closure_datetime=$generate_closure_isolation_users='';

				$data_disabled='disabled';

				$disabled_isolated_inputs=$disabled_closure_isolated_inputs="disabled='disabled'";		

				$jobs_loto_id=$job_isolation['loto_id'];

				//Filter if there any open permits to the equipment
				$filter = array_filter($job_isolations_logs, function ($var) use($jobs_loto_id) {
					return ($var['jobs_lotos_id'] == $jobs_loto_id);
				  });

				if(count($filter)>0)
				{
					$rows.='<tr id="jobs_loto_id'.$i.'">';

					$checked = (in_array($jobs_loto_id,$jobs_loto_ids)) ? 'checked' : '';

					$isolation_type_user_id=(isset($isolated_user_ids->$equipment_number_id)) ? $isolated_user_ids->$equipment_number_id : '';
					$closure_isolation_type_user_id=(isset($closure_isolator_ids->$equipment_number_id)) ? $closure_isolator_ids->$equipment_number_id : '';

					$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes->$i)) ? $isolated_name_approval_datetimes->$i : '';

					$isolated_name_closure_datetime=(isset($isolated_name_closure_datetimes->$i)) ? $isolated_name_closure_datetimes->$i : '';

					$type_isolation=$job_isolation['isolation_type_id'];

					if($checked!=''){

						if(in_array($user_id,array($acceptance_performing_id,$acceptance_issuing_id)) &&   $approval_status==WAITING_IA_ACCPETANCE && in_array($jobs_loto_id,$jobs_loto_ids)){
							$disabled_isolated_inputs=''; 
						} else if(in_array($approval_status,array(WAITING_ISOLATORS_COMPLETION)) && in_array($jobs_loto_id,$jobs_loto_ids)) {

							$disabled_isolated_inputs='disabled="disabled"';

							if($user_id==$isolation_type_user_id)
							{
								$data_disabled='';

								if($isolated_name_approval_datetime=='')
								$isolated_name_approval_datetime = date('d-m-Y H:i');
							}
						} 
						else if(in_array($approval_status,array(WAITING_AVI_PA_APPROVALS))){
							$disabled_isolated_inputs='disabled="disabled"';
						}
						else if(in_array($approval_status,array(WORK_IN_PROGRESS)) && in_array($jobs_loto_id,$jobs_loto_ids) && $user_id==$acceptance_performing_id) {
							$disabled_isolated_inputs='disabled="disabled"';
							$disabled_closure_isolated_inputs='';
						}else if(in_array($approval_status,array(WAITING_CLOSURE_ISOLATORS_COMPLETION)) && in_array($jobs_loto_id,$jobs_loto_ids)) {
							if($user_id==$closure_isolation_type_user_id && $isolated_name_closure_datetime=='')
							{
								$isolated_name_closure_datetime = date('d-m-Y H:i');
							}
						}
						
						$generate_closure_isolation_users = $this->generate_isolation_type_users($isolation_users,$type_isolation,'',$closure_isolation_type_user_id,array());
					
					}

					$equipment_number=$job_isolation['equipment_number'];

					
					$isolated_tag3=$job_isolation['isolated_tagno3'];

					$rows.='<td><input type="checkbox" class="form-check-input jobs_loto_ids" name="jobs_loto_ids['.$i.']" id="jobs_loto_ids['.$i.']" value="'.$jobs_loto_id.'" '.$checked.' data-disabled="'.$data_disabled.'" data-id="'.$i.'"/></td>';

					$rows.='<td><input type="hidden" readonly class="form-control" name="equipment_number_ids['.$i.']" id="equipment_number_ids['.$i.']" value="'.$equipment_number_id.'"  /><input type="hidden" readonly class="form-control equipment_tag_no equipment_tag_no'.$i.'" name="equipment_tag_nos['.$i.']" id="equipment_tag_no['.$i.']" value="'.$equipment_number.'"  />'.$equipment_number.'</td>';

					$rows.='<td><input type="hidden" class="form-control isolated_tagno3'.$i.'" name="isolated_tagno3['.$i.']" id="isolated_tagno3['.$i.']" value="'.$isolated_tag3.'" disabled/>'.$isolated_tag3.'</td>';
					

					$isolation_type_user_id=$checked=='' ? '' : $isolation_type_user_id;

					$generate_isolation_users = $this->generate_isolation_type_users($isolation_users,$type_isolation,'',$isolation_type_user_id,array());

					$rows.='<td><select name="isolated_user_ids['.$i.']" id="isolated_user_ids['.$i.']" class="form-control isolated_user_ids data-iso-name isolated_user_ids'.$i.'" data-attr="'.$i.'" '.$disabled_isolated_inputs.'>'.$generate_isolation_users.'</select></td>';

					$rows.='<td><input type="text" class="form-control isolated_name_approval_datetime'.$i.'" name="isolated_name_approval_datetime['.$i.']" id="isolated_name_approval_datetime['.$i.']" value="'.$isolated_name_approval_datetime.'"  disabled/></td>';

					$rows.='<td><select name="closure_isolator_ids['.$i.']" id="closure_isolator_ids['.$i.']" class="form-control closure_isolator_ids data-iso-name closure_isolator_ids'.$i.'" data-attr="'.$i.'" '.$disabled_closure_isolated_inputs.'  >'.$generate_closure_isolation_users.'</select></td>';
					
					$rows.='<td><input type="text" class="form-control isolated_name_closure_datetime'.$i.'" name="isolated_name_closure_datetime['.$i.']" id="isolated_name_closure_datetime['.$i.']" value="'.$isolated_name_closure_datetime.'"  disabled/></td>';

					//$i++;
				}

			}


		} else {
			$rows.='<thead><tr><td colspan="7"style="color:red;text-align:center;">No Records Found</td></tr></thead>';
		}
		
		

		echo json_encode(array('rows'=>$rows,'zone_id'=>$zone_id,'num_rows'=>$num_rows)); exit;
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

	public function show_all()
	{

		$zone_id=$this->session->userdata('zone_id');
		
		$user_role=$this->session->userdata('user_role');
		
		$user_id=$this->session->userdata('user_id');
		
		$params_url=$where=$department_id='';
		
		#echo $this->db->last_query(); exit;
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'))->result_array();
		
		$params_url='';;

		$segment_array=$this->uri->segment_array();
		
		  //Pass status from TAB 
	    $user_role=array_search('user_role',$segment_array);	
		  
		if($user_role !==FALSE && $this->uri->segment($user_role+1)!='')
	    {
			$user_role=$this->uri->segment($user_role+1);        
				         
	        $params_url='/user_role/'.$user_role;
		}  
		else
		$user_role='PA';
		  
		  //Pass status from TAB 
	    $zone_id=array_search('zone_id',$segment_array);	
		  
		if($zone_id !==FALSE && $this->uri->segment($zone_id+1)!='')
	    {
			$zone_id=$this->uri->segment($zone_id+1);        
				         
	        $params_url.='/zone_id/'.$zone_id;
		}  
		else
		$zone_id='';

		  //Pass status from TAB 
	    $approval_status=array_search('approval_status',$segment_array);	
		  
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1)!='')
       	{
			$approval_status=$this->uri->segment($approval_status+1);        
				         
            $params_url.='/approval_status/'.$approval_status;
		}  
		else
		$approval_status='';
		   
		$this->data['filters']['filter_status']=$user_role;	
		
		$this->data['params_url']=$params_url;
		
		$this->data['filters'][$user_role.'zone_id']=$zone_id;
		
		$this->data['filters'][$user_role.'approval_status']=$approval_status;

			
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
		
		$zone_id=$this->session->userdata('zone_id');
		
		$user_role=$this->session->userdata('user_role');
		
		$user_id=$this->session->userdata('user_id');
		
			
		$qry2='(';
			$qry2='('; 
			for($i=1;$i<=EIP_CHECKLIST_MAX_ROWS;$i++)
			{
				$qry2.=' (a.isolated_user_ids like \'%"'.$i.'":"'.$user_id.'"%\' OR a.closure_isolator_ids like \'%"'.$i.'":"'.$user_id.'"%\') OR ';
			}
			$qry2=rtrim($qry2,'OR ');
			
			$qry2.=')';
		
		$qry2='';

		
		$where_condition=' (a.acceptance_issuing_id = "'.$user_id.'" OR a.acceptance_performing_id = "'.$user_id.'" OR a.closure_performing_id = "'.$user_id.'" OR a.closure_issuing_id = "'.$user_id.'" OR a.closure_performing_again_id= "'.$user_id.'" OR a.isolated_user_ids LIKE "%'.$user_id.'%" OR a.jobs_performing_ids  LIKE "%'.$user_id.'%" OR a.closure_isolator_ids  LIKE "%'.$user_id.'%") AND ';
		
		$generate_conditions=$this->generate_where_condition();
		
		$where_condition.=$generate_conditions['where_condition'];

		 $fields='a.id,z.name as zone_name,a.jobs_loto_ids,a.approval_status,a.status,a.created,a.modified,a.acceptance_performing_id,a.acceptance_issuing_id,a.closure_performing_id,a.closure_issuing_id,a.closure_performing_again_id,a.isolated_user_ids,a.closure_performing_id,a.closure_issuing_id,a.closure_isolator_ids,a.closure_performing_again_id';
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->avis_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->avis_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		
		#echo '<br /> Query : '.$this->db->last_query();  
		$json=array();
		
		$job_status=unserialize(JOB_STATUS);

		$j=0;
		
		if($totalFiltered>0)
		{	
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$zone_name=$record['zone_name'];

				$jobs_loto_ids=json_decode($record['jobs_loto_ids'],true);

				$jobs_loto_ids=count($jobs_loto_ids);
				
				$redirect=base_url().'avis/form/id/'.$id.'/avis/index/'.$param_url;  
				
				$created=$record['created'];
				
				$status=$record['status'];
				
				$approval_status=$record['approval_status'];
				
				if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
				$color=$job_approval_status_color[$job_approval_status[$approval_status]];
				else
				$color='';
				
				$waiating_approval_by=$this->jobs_model->get_avis_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$zone_name.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$zone_name=$record['zone_name'];
				
				$modified=$record['modified'];

				$cl='';
				
						$json[$j]['id']='<a href="'.$redirect.'" style="color:'.$cl.'">#'.$id.'</a>';
						$json[$j]['zone_name']=$zone_name;
						$json[$j]['no_of_isolators'] = $jobs_loto_ids; 
						$json[$j]['approval_status']=$approval_status;#.' - '.$search;
						$json[$j]['created']=date(DATE_FORMAT.' H:i A',strtotime($created));
						$json[$j]['modified']=date(DATE_FORMAT.' H:i A',strtotime($modified));
						$json[$j]['status']=ucfirst($status);
						$json[$j]['waiating_approval_by']=$waiating_approval_by;
						
						$j++;
			}
		}

		$total_records=$totalFiltered;
		

		$json=json_encode($json);
							
		$return='{"total":'.intval( $total_records ).',"recordsFiltered":'.intval( $total_records ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}

	public function printout()
	{ 
		error_reporting(0);

		$readonly='';

		$department_id=$this->session->userdata('department_id');
		
		$user_name=$this->session->userdata('first_name');
		
		$user_id=$this->session->userdata('user_id');

		if($user_id=='')
		{
			$user_id=$this->session->userdata(ADMIN.'user_id');

			$user_name=$this->session->userdata(ADMIN.'first_name');
		}
		
		$authorities=$job_isolations_where=$job_status_error_msg='';

		$this->data['allusers'] = $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id,user_role','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND user_role NOT IN ("SA")','column'=>'first_name','dir'=>'asc'))->result_array();
		
        $id = $this->input->post('id');

        if($id!='')
        {
            $req=array(
              'select'  =>'*',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>AVIS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{
                $records=$qry->row_array();

				$this->data['avi_info']=$records;	

				$zone_id=$records['zone_id'];

				$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND id="'.$zone_id.'"'));

				$jobs_loto_ids=json_decode($records['jobs_loto_ids'],true);

				$jobs_loto_ids=implode(',',$jobs_loto_ids);

				$job_pre_isolations=$this->public_model->join_fetch_data(array('select'=>'ec.id,ec.equipment_name,ec.equipment_number,li.isolated_tagno3,li.id as jobs_loto_id','table1'=>LOTOISOLATIONS.' li','table2'=>EIP_CHECKLISTS.' ec','join_type'=>'inner','join_on'=>'li.eip_checklists_id=ec.id','where'=>'li.id IN('.$jobs_loto_ids.')','num_rows'=>false))->result_array();

				$this->data['job_isolations']=$job_pre_isolations;
            }   
        }
		
	 
		
		$this->load->view($this->data['controller'].'printout',$this->data);
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
				$where_condition.=" a.department_id IN(".$department_ids.") AND ";

				$filters['department_ids']=$department_ids;
			}
		}	

		$zone_ids = array_search('zone_ids',$this->uri->segment_array());

        if($zone_ids !==FALSE && $this->uri->segment($zone_ids+1))
        {
            $zone_ids = $this->uri->segment($zone_ids+1);
			
			if($zone_ids!='') {
				$where_condition.=" a.zone_id IN(".$zone_ids.") AND ";

				$filters['zone_ids']=$zone_ids;
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
		
		
		$where_condition.=' DATE(a.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';

		$where_condition=rtrim($where_condition,' AND ');

		return array('where_condition'=>$where_condition,'filters'=>$filters);
	}
}
