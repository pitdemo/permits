<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Dashboard.php
 * Project        : Formwork
 * Creation Date  : 12-14-2016
 * Author         : Anantha Kumar RJ
 * Description    : Manageing Dashbaord Datas 
*********************************************************************************************/	

class Remarks extends CI_Controller
 {

	function __construct()
	{
		parent::__construct(); 
        $this->load->model(array('security_model','jobs_model','public_model','jobs_isolations_model','avis_model'));
		//$this->security_model->chk_is_user();        
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}

    /**********************************************************************************************
     * Description    : Grab all counts data from Dashboard table based on by logged company user
    **********************************************************************************************/	

    public function index()
    {

        $segment_array=$this->uri->segment_array();

        $param_url=$this->public_model->get_params_url(array('start'=>5,'segment_array'=>$segment_array));	

        $plant_type=$this->session->userdata('plant_type');

        $plant_where_condition=" AND plant_type IN('".$plant_type."','".BOTH_PLANT."')";

        $this->data['allusers'] = $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id,user_role,employee_id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND user_role NOT IN ("SA")'.$plant_where_condition,'column'=>'first_name','dir'=>'asc'))->result_array();

        $update = array_search('id',$this->uri->segment_array());

        if($update !==FALSE && $this->uri->segment($update+1))
        {
            $id = $this->uri->segment($update+1);

            $req=array(
            'select'  =>'id,permit_no,is_loto',
            'table'    =>JOBS,
            'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);

            if($qry)
            {
                $records=$qry->row_array();
                
                $this->data['records']=$records;
            } 
        }

        

        $this->data['param_url']='/?mode='.$this->session->userdata('mode');

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

			$fields = 'a.*,j.permit_no';

			$qry = $this->avis_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>0,'length'=>1,'column'=>'a.id','dir'=>'asc'))->row_array();
			
			$this->data['records'] = $qry;

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

			$this->data['notes'] = $this->public_model->get_data(array('table'=>AVISREMARKS,'select'=>'*','where_condition'=>'avi_id = "'.$id.'"','column'=>'id','dir'=>'desc','limit'=>5))->result_array();
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
		
		$array_fields=array('isolated_name_approval_datetime','eq_tag','isolated_user_ids','closure_isolator_ids','isolated_name_closure_datetime');
		
		$skip_fields=array('id','submit_type','equipment_descriptions','equipment_tag_nos','isolated_tagno1','isolated_tagno2','isolated_tagno3','step1','notes','show_button');
		
		$print_out='';$arr=array();$fields='';$fields_values='';$update=''; $msg='';
		
		$short_dept=substr($this->session->userdata('department_name'),0,2);

		$is_send_sms=$show_button='';

		$status=(isset($_POST['status'])) ? $_POST['status'] : '';
		$permit_type=$this->input->post('permit_type');

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

					$print_out=1;	
					$_POST['approval_status']=WAITING_ISOLATORS_COMPLETION;	
					
				}

				
			}


			//Isolators Users Logged
			if(in_array($pre_approval_status,array(WAITING_ISOLATORS_COMPLETION)))
			{
				$eq_tag=$this->input->post('eq_tag');
				$clearance_department_dates=$this->input->post('isolated_name_approval_datetime');

				#echo 'Count '.count(array_filter($eq_tag)).' = '.count(array_filter($clearance_department_dates)); exit;

				if(count(array_filter($eq_tag)) == count(array_filter($clearance_department_dates)))
				{
					$_POST['approval_status'] = AWAITING_FINAL_SUBMIT;

					$msg = 'Isolation Approval are completed and sent final submit request to PA';
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
				$eq_tag=$this->input->post('eq_tag');

				$isolated_name_closure_datetimes=$this->input->post('isolated_name_closure_datetime');

				#echo 'Count '.count(array_filter($eq_tag)).' = '.count(array_filter($isolated_name_closure_datetimes)); exit;

				if(count(array_filter($eq_tag)) == count(array_filter($isolated_name_closure_datetimes)))
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
		
		$eq_tags=$this->input->post('eq_tag');

        $isolated_user_ids=$this->input->post('isolated_user_ids');

        $_POST['isolated_user_ids'] = array();

        foreach($eq_tags as $key => $tag):
            $_POST['isolated_user_ids'][$tag] = $isolated_user_ids[$tag];
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
				$array=array('user_id'=>$user_id,'avi_id'=>$id,'notes'=>$msg,'created'=>date('Y-m-d H:i'),'job_id'=>$job_id);
			
				$this->db->insert(AVIS_HISTORY,$array);
			}	
		}	
		
		$ret=array('status'=>true,'print_out'=>$print_out);
		                   
       # echo 'true'; 
		echo json_encode($ret);
		
		exit;
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

		
		$where_condition=' (a.acceptance_issuing_id = "'.$user_id.'" OR a.acceptance_performing_id = "'.$user_id.'" OR a.closure_performing_id = "'.$user_id.'" OR a.closure_issuing_id = "'.$user_id.'" OR a.closure_performing_again_id= "'.$user_id.'"  OR '.$qry2.') AND ';
		
		#echo $where_condition; exit;
		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		  }
		  
		 # $where_condition .= "j.approval_status NOT IN (4,6,10)";

		 // echo $where_condition; exit;

		 $fields='a.id,j.job_name,j.location,j.permit_no,a.eq_tag,a.approval_status,a.status,a.created,a.modified,a.acceptance_performing_id,a.acceptance_issuing_id,a.closure_performing_id,a.closure_issuing_id,a.closure_performing_again_id,a.isolated_user_ids,a.closure_performing_id,a.closure_issuing_id,a.closure_isolator_ids,a.closure_performing_again_id';
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->avis_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->avis_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		
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

				$eq_tag=json_decode($record['eq_tag'],true);

				$eq_tag=count($eq_tag);
				
				$redirect=base_url().'avis/form/id/'.$id.'/jobs/index/'.$param_url;
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$created=$record['created'];
				
				$status=$record['status'];
				
				$approval_status=$record['approval_status'];
				
				if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
				$color=$job_approval_status_color[$job_approval_status[$approval_status]];
				else
				$color='';
				
				$waiating_approval_by=$this->jobs_model->get_avis_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$permit_no.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$permit_no=$record['permit_no'];
				
				$modified=$record['modified'];

				$cl='';
				
						$json[$j]['id']='<a href="'.$redirect.'" style="color:'.$cl.'">#'.$id.'</a>';
						$json[$j]['permit_no']=$permit_no;
						$json[$j]['job_name']=$job_name;
						$json[$j]['no_of_isolators'] = $eq_tag;
						$json[$j]['location']=strtoupper($record['location']);
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

}
