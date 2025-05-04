<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Dashboard.php
 * Project        : Formwork
 * Creation Date  : 12-14-2016
 * Author         : Anantha Kumar RJ
 * Description    : Manageing Dashbaord Datas 
*********************************************************************************************/	

class Scaffoldings extends CI_Controller
 {

	function __construct()
	{
		parent::__construct(); 
        $this->load->model(array('security_model','jobs_model','public_model','jobs_isolations_model','scaffoldings_model'));
		$this->security_model->chk_is_user();        
		$this->data=array('controller'=>$this->router->fetch_class().'/');
		$this->data['title']='Scaffoldings';
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

		if($param_url=='')
			$param_url=$segment_array[1];
		
		$this->data['param_url']=$param_url;

		$update = array_search('id',$this->uri->segment_array());

		$records=$all_users=$checklists=array();

		$this->data['title']='New Scaffolding';

		if($update !==FALSE && $this->uri->segment($update+1))
        {
            $id = $this->uri->segment($update+1);

			$where_condition='s.id="'.$id.'"';

			$fields='j.location,j.permit_no,aci.first_name,aii.first_name as issuer_name,s.*';

			$records=$this->scaffoldings_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>0,'length'=>1,'column'=>'s.id','dir'=>'asc'))->row_array();

			if(isset($records))
			{
				$plant_where_condition=' AND id IN('.$records['acceptance_performing_id'].','.$records['acceptance_issuing_id'].')';

				#$all_users = $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id,user_role,employee_id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND user_role NOT IN ("SA")'.$plant_where_condition,'column'=>'first_name','dir'=>'asc'))->result_array();

				$checklists=$this->public_model->get_data(array('table'=>SCAFFOLDINGS_CHECKLISTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'id','dir'=>'asc'))->result_array();

				$this->data['title']=$records['permit_no']. ' Info';
			}

			$this->data['notes'] = $this->public_model->get_data(array('table'=>SCAFFOLDINGS_NOTES,'select'=>'*','where_condition'=>'scaffolding_id = "'.$id.'"','column'=>'id','dir'=>'desc','limit'=>5))->result_array();
        }

		$this->data['checklists']=$checklists;
		
		$this->data['allusers']=$all_users; 

		$this->data['records']=$records;

		$this->load->view($this->data['controller'].'form',$this->data);
	}

	
	public function form_action()
	{

		#echo '<pre>'; 
        #print_r($this->input->post());   
       # exit; 

		$user_id=$this->session->userdata('user_id');
		
		$skip_fields=array('id','step1','notes','permit_no');

		$print_out='';
		
		$array_fields=array('load_duty','check_points');
		
		$fields='';
		
		$fields_values='';
		
		$update=''; 
		
		$msg='';
		

		$_POST['last_modified_id']=rand(time(),5);

		$id=($this->input->post('id')) ? $this->input->post('id') : '';			

		$job_id=$this->input->post('job_id');

		$permit_no=$this->input->post('permit_no');

		$approval_status=$this->input->post('approval_status');

		if($id=='')
		{
			$_POST['permit_no_sec']=$this->get_max_permit_id(array('job_id'=>$job_id));

			$_POST['scaffolding_id']=$permit_no.'-'.$_POST['permit_no_sec'];

			//Civil dept approval waiting
			$_POST['approval_status']=$approval_status=WAITING_CUSTODIAN_ACCPETANCE;

			$_POST['acceptance_performing_id']=$user_id;

			$_POST['acceptance_performing_date']=date('d-m-Y H:i');

			$_POST['created']=date('Y-m-d H:i');

		}

		

		$user_name=$this->session->userdata('first_name');

		$_POST['last_updated_by']=$user_name;

		$_POST['modified']=date('Y-m-d H:i');

		$inputs=$this->input->post();

	
		//Jobs Inputs 
		foreach($inputs as $field_name => $field_value)
		{
			if(!in_array($field_name,$skip_fields))
			{

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

				$fields.=$field_name.',';
				
				$fields_values.=$field_value.',';
				
				$update.=$field_name.'='.$field_value.',';
			}
		}
		if(!$id)
		{	 
		
			$fields=rtrim($fields,',');

			$fields_values=rtrim($fields_values,',');

			$ins="INSERT INTO ".$this->db->dbprefix.SCAFFOLDINGS." (".$fields.") VALUES (".$fields_values.")";
		
			$this->db->query($ins);

			$id=$this->db->insert_id();		
			
			$msg_type=SA_RESP_PERSONS_NEW;

			$this->session->set_flashdata('success','Scaffolding has been created successfully and sent notification to the responsible person.');    
			
		}
		else
		{

			$update=rtrim($update,',');

			$up="UPDATE ".$this->db->dbprefix.SCAFFOLDINGS." SET ".$update." WHERE id='".$id."'";
			
			$this->db->query($up);

			$msg_type=SA_RESP_PERSONS_UPDATE;

			$this->session->set_flashdata('success','Scaffolding has been updated successfully');  
		} 


		$notes = isset($_POST['notes'])  ? trim($_POST['notes']) : '';
		//Job Notes
		if($notes!='')
		{
			$notes = @addslashes($notes);

			$fields='scaffolding_id,approval_status,user_id,created,last_updated_by,notes';

			$fields_values='"'.$id.'","'.$approval_status.'","'.$user_id.'","'.date('Y-m-d H:i').'","'.$user_name.'","'.$notes.'"';
			
			$qry="INSERT INTO ".$this->db->dbprefix.SCAFFOLDINGS_NOTES." (".$fields.") VALUES (".$fields_values.")";

			$this->db->query($qry);
		}


		$push_notification_array=array();

		$msg_type='';

		switch($msg_type)
		{
			case SA_RESP_PERSONS_NEW:
				$receivers=$this->public_model->get_data(array('select'=>'first_name,id','where_condition'=>'ID IN ('.$u_ids.')','table'=>USERS))->result_array();	
				
				foreach($receivers as $receiver):
					$msg_type=sprintf($msg_type,$receiver['first_name'],$this->session->userdata('first_name'),$permit_no,$remarks_id);
					$push_notification_array[]=array('uid'=>$receiver['id'],'pid'=>$id,'title'=>'New Remarks Notification','body'=>$msg_type);
				endforeach;
				
				break;
			case SA_RESP_PERSONS_UPDATE:
				 
				$receivers=$this->public_model->get_data(array('select'=>'first_name,id','where_condition'=>'ID IN ('.$u_ids.')','table'=>USERS))->result_array();	

				foreach($receivers as $receiver):
					$msg_type=sprintf($msg_type,$receiver['first_name'],$this->session->userdata('first_name'),$permit_no);
					$push_notification_array[]=array('uid'=>$receiver['id'],'pid'=>$id,'title'=>'Remarks Notification','body'=>$msg_type);
				endforeach;

				break;
		}

		if(count($push_notification_array)>0)
		{
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => PUSH_NOTIFICATION_URL,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($push_notification_array), // Properly encode JSON
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json' // Inform the server that the payload is JSON
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);
		}

		$ret=array('status'=>true);

		echo json_encode($ret);
		
		exit;
	}

	public function get_max_permit_id($array_args)
	{
		extract($array_args);
		
			$qry=$this->db->query("SELECT MAX(permit_no_sec)+1 as permit_no FROM ".$this->db->dbprefix.SCAFFOLDINGS." WHERE job_id='".$job_id."'");
			
			#echo $this->db->last_query(); exit;
			$fet=$qry->row_array();	
			
			if($fet['permit_no']=='')
			$fet['permit_no']='1';

			return strtoupper($fet['permit_no']);
	}

 

	public function ajax_fetch_show_all_data()
	{
		 
		$mode=$this->session->userdata('mode');

		$job_approval_status=unserialize(SCAFFOLDINGS_APPROVALS);
		 
		$job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');
		
		$zone_id=$this->session->userdata('zone_id');
		
		$user_role=$this->session->userdata('user_role');
		
		$user_id=$this->session->userdata('user_id');	
		
		$mode=$this->session->userdata('mode');
		
		$where_condition='';
		
		#echo $where_condition; exit;
		
		$generate_conditions=$this->generate_where_condition();
		
		$where_condition.=$generate_conditions['where_condition'];

		 $fields='j.location,j.permit_no,s.approval_status,s.created,s.modified,s.id,s.job_id,aci.first_name,aii.first_name as issuer_name,s.scaffolding_id,s.meter,s.id';
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->scaffoldings_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->scaffoldings_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		
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

				$job_id=$record['job_id'];
				
				$scaffolding_id=$record['scaffolding_id'];
					
				$location=($record['location']) ? $record['location'] : ' - - -';	

				 
				$redirect=base_url().'scaffoldings/form/id/'.$id.'/?mode='.$mode;
				$location='<a href="'.$redirect.'">'.$location.'</a>';
			
				$created=$record['created'];
				$approval_status=$record['approval_status'];
				
				if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
				$color=$job_approval_status_color[$job_approval_status[$approval_status]];
				else
				$color='';

				$permit_no=$record['permit_no'];
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";	
				
				$modified=$record['modified']; 

				$responsible_persons=$record['issuer_name'];

				$meter=$record['meter'];

				$cl='';
				$redirect=base_url().'jobs/form/id/'.$job_id.'/?mode='.$mode;			
				$permit_no='<a href="'.$redirect.'">'.$permit_no.'</a>';
				$redirect=base_url().'scaffoldings/form/id/'.$id.'/?mode='.$mode;			
				$scaffolding_id='<a href="'.$redirect.'">'.$scaffolding_id.'</a>';

				$json[$j]['scaffolding_id']=$scaffolding_id;
				$json[$j]['permit_no']=$permit_no;
				$json[$j]['location']=$location;
				$json[$j]['created_by']=$record['first_name'];
				$json[$j]['id']='<a href="'.$redirect.'" style="color:'.$cl.'">#'.$location.'</a>';
				$json[$j]['approval_status']=$approval_status;#.' - '.$search;
				$json[$j]['created']=date(DATE_FORMAT.' H:i A',strtotime($created)); 
				$json[$j]['meter']=$meter;
				$json[$j]['responsible_persons']=$responsible_persons;
				
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
				$where_condition.=" aci.department_id IN(".$department_ids.") AND ";

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
		
		
		$where_condition.=' DATE(s.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';

		$where_condition=rtrim($where_condition,' AND ');

		return array('where_condition'=>$where_condition,'filters'=>$filters);
	}
}
