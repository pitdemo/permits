<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Permits extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','zones_model'));	
			
		$this->security_model->chk_is_admin();    
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}
	public function index() // list the item lists
	{
		redirect('permits/lists');
	}
	
	public function lists()
	{
		$segment_array=$this->uri->segment_array();
		
        $subscription_date_start = array_search('subscription_date_start',$segment_array);

        if($subscription_date_start !==FALSE && $this->uri->segment($subscription_date_start+1))
        {
            $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		}
		else
		$subscription_date_start = date('Y-m-d',strtotime("-30 days"));
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
        if($subscription_date_end !==FALSE && $this->uri->segment($subscription_date_end+1))
        {
            $subscription_date_end = $this->uri->segment($subscription_date_end+1);
		}
		else
		$subscription_date_end = date('Y-m-d');
		
        $permit_no = array_search('permit_no',$segment_array);

        if($permit_no !==FALSE && $this->uri->segment($permit_no+1))
        {
            $permit_no = $this->uri->segment($permit_no+1);
		}
		else
		$permit_no = '';
		
		
		$departments = array_search('departments',$segment_array);
		
        if($departments !==FALSE && $this->uri->segment($departments+1))
        {
            $selected_departments = $this->uri->segment($departments+1);
		}
		else
			$selected_departments='';
			
		$zones = array_search('zones',$segment_array);
		
        if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $selected_zones = $this->uri->segment($zones+1);
		}
		else
			$selected_zones='';
			
		$work_types = array_search('work_types',$segment_array);
		
        if($work_types !==FALSE && $this->uri->segment($work_types+1))
        {
            $selected_work_types = explode(',',$this->uri->segment($work_types+1));
		}
		else
			$selected_work_types = array();
			
		$permit_status = array_search('permit_status',$segment_array);
		
        if($permit_status !==FALSE && $this->uri->segment($permit_status+1))
        {
            $selected_permit_status = explode(',',$this->uri->segment($permit_status+1));
		}
		else
			$selected_permit_status = array();
			
		
        $req=array('select'=>'id,name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Companys List
        $qry=$this->public_model->get_data($req);
		
        $this->data['departments']=$qry->result_array();            

        $req=array('select'=>'id,name','table'=>ZONES,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Companys List
        $qry=$this->public_model->get_data($req);
		
        $this->data['zones']=$qry->result_array();            
		
		$this->data['subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$this->data['subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));
		
		$this->data['selected_work_types'] = $selected_work_types;
		
		$this->data['selected_permit_status']= $selected_permit_status;
		
		$this->data['selected_zones']=$selected_zones;
		
		$this->data['selected_departments']=$selected_departments;
		
		$this->data['permit_no'] = $permit_no;
		
		$this->load->view('permits/lists',$this->data);
	}
	
	public function ajax_search_permits()
	{
		$this->load->model(array('jobs_model'));
		#echo '<pre>'; print_r($this->input->post()); exit;
		
		 $job_approval_status=unserialize(JOBAPPROVALS);
		 
		 $job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);
		
		$job_status=unserialize(JOB_STATUS);	
		
		$segment_array=$this->uri->segment_array();
		
        $subscription_date_start = array_search('subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$where_condition='DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';

		$departments = array_search('departments',$segment_array);
		
        if($departments !==FALSE && $this->uri->segment($departments+1))
        {
            $selected_departments = $this->uri->segment($departments+1);
			
			if($selected_departments!='null')
			$where_condition.='j.department_id IN('.$selected_departments.') AND ';
		}
		
		$work_types = array_search('work_types',$segment_array);
		
        if($work_types !==FALSE && $this->uri->segment($work_types+1))
        {
            $selected_work_types = $this->uri->segment($work_types+1);
			
			if($selected_work_types!='null')
			$where_condition.='j.work_types LIKE "%'.$selected_work_types.'%" AND ';
		}
		
			
		$zones = array_search('zones',$segment_array);
		
        if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $selected_zones = $this->uri->segment($zones+1);
			
			if($selected_zones!='null')
			$where_condition.='j.zone_id IN('.$selected_zones.') AND ';
		}
		
		$permit_status = array_search('permit_status',$segment_array);
		
        if($permit_status !==FALSE && $this->uri->segment($permit_status+1))
        {
            $selected_permit_status = $this->uri->segment($permit_status+1);
			
			if($selected_permit_status!='null')
			{
				$selected_permit_status=explode(',',$selected_permit_status);
				
				if(count($selected_permit_status)!=2)
				{
					if($selected_permit_status[0]==STATUS_OPENED)
					$where_condition.='j.approval_status NOT IN(4,6,9) AND ';
					else
					$where_condition.='j.approval_status IN(4,6,9) AND ';
				}
			}
		}
		
		$permit_no = array_search('permit_no',$segment_array);
		
        if($permit_no !==FALSE && $this->uri->segment($permit_no+1))
        {
            $permit_no = $this->uri->segment($permit_no+1);
			
			if($permit_no!='null')
			$where_condition.='j.permit_no="'.$permit_no.'" AND ';
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
							13=>'j.issuing_authority',
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified'
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

				$redirect=base_url().'jobs/form/id/'.$id;
				
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
				$modified=$record['modified'];
				
				$status=$record['status'];

				$approval_status=$record['approval_status'];
				
				$time_diff='- - -';
				
				if(!in_array($approval_status,$job_status))
				{
					if($record['time_diff']>PERMIT_CLOSE_AFTER)					
					$record['time_diff'] = PERMIT_CLOSE_AFTER;
					
					$time_diff=(PERMIT_CLOSE_AFTER - $record['time_diff']).' hrs';
				}
				
				if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
				$color=$job_approval_status_color[$job_approval_status[$approval_status]];
				else
				$color='';
				
				$waiating_approval_by=$this->jobs_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$permit_no.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				
				$users_in=array($record['acceptance_performing_id'],$record['acceptance_issuing_id']);
				
				$users=implode(',',$users_in);
				
				$users=$this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id,last_name','where_condition'=>'id IN('.$users.')'))->result_array();
				
				$auth_PA=$auth_IA='';
				
				foreach($users as $user):
				
				$name=$user['first_name'].' '.$user['last_name'];
					
						if($user['id']==$users_in[0])
						$auth_PA=$name;
						else if($user['id']==$users_in[1])
						$auth_IA=$name;
				
				endforeach;
				
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';				
				
						$json[$j]['id']='<a href="'.$redirect.'">'.'#'.$permit_no.'</a>';
						$json[$j]['job_name']=$job_name;
						$json[$j]['auth_PA']=strtoupper($auth_PA);
						$json[$j]['auth_IA']=strtoupper($auth_IA);
						$json[$j]['location']=strtoupper($record['location']);
						$json[$j]['name']=strtoupper($contractor_name);
						$json[$j]['contact_no']=$contact_number;
						$json[$j]['created']=date(DATE_FORMAT,strtotime($created));
						$json[$j]['modified']=date(DATE_FORMAT.' H:i A',strtotime($modified));
						$json[$j]['status']=ucfirst($status);
						$json[$j]['approval_status']=$approval_status;#.' - '.$search;
						$json[$j]['waiating_approval_by']=$waiating_approval_by;
						$json[$j]['action']=$print;
						$json[$j]['time_diff']=$time_diff;
						$j++;
			}
		}
				
		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}
	

}
?>
