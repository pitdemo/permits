<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Confined Permits.php
 * Project        : Form Work
 * Creation Date  : 21-07-2018
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	


class Confined_permits extends CI_Controller {

	function __construct()
	{
		parent::__construct(); 

        $this->load->model(array('public_model','security_model','confined_permits_model','departments_model'));

        $system_current_date = $this->security_model->get_current_date_time();

		if($this->router->fetch_method()!='printout')
		$this->security_model->chk_login(); 

		$this->data=array('controller'=>$this->router->fetch_class().'/','system_current_date'=>$system_current_date);
	}


	public function index() //swathi
	{ 
		#print_r($this->session->userdata); exit;
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'))->result_array();
		
		$segment_array=$this->uri->segment_array();
		
		$params_url=$where=$approval_status='';

          $zone_id=array_search('zone_id',$segment_array);	
		  
		  if($zone_id !==FALSE && $this->uri->segment($zone_id+1)!='')
          {
			 	$zone_id=$this->uri->segment($zone_id+1);        
				         
                $params_url.='/zone_id/'.$zone_id;
		  }  
		   else
		   $zone_id='';

		//Pass status from TAB 
          $user_role=array_search('user_role',$segment_array);	
		  
		  if($user_role !==FALSE && $this->uri->segment($user_role+1)!='')
          {
			 	$user_role=$this->uri->segment($user_role+1);        
		  }  
		  else
		  $user_role='PA';

		$subscription_date_start = array_search($user_role.'subscription_date_start',$segment_array);

        if($subscription_date_start !==FALSE && $this->uri->segment($subscription_date_start+1))
        {
            $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		}
		else
		$subscription_date_start = date('Y-m-d',strtotime("-30 days"));
		
		$subscription_date_end = array_search($user_role.'subscription_date_end',$segment_array);
		
        if($subscription_date_end !==FALSE && $this->uri->segment($subscription_date_end+1))
        {
            $subscription_date_end = $this->uri->segment($subscription_date_end+1);
		}
		else
		$subscription_date_end = date('Y-m-d');

		  //Pass status from TAB 
          $approval_status=array_search('approval_status',$segment_array);	
		  
		  if($approval_status !==FALSE && $this->uri->segment($approval_status+1)!='')
          {
			 	$approval_status=$this->uri->segment($approval_status+1);        
				         
                $params_url.='/approval_status/'.$approval_status;
		  }  
		  else
		  $approval_status='';
			
			$filters[$user_role.'zone_id']=$zone_id;
		  
			$filters[$user_role.'approval_status']=$params_url;
		
			$filters[$user_role.'subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
			$filters[$user_role.'subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));
		
			$filters['filter_status'] = $user_role;

			$this->data['filters']=$filters;

			$this->load->view($this->data['controller'].'lists',$this->data);
	}

	public function day_in_process()
	{ 
			#print_r($this->session->userdata); exit;
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'))->result_array();

		$segment_array=$this->uri->segment_array();
		$params_url=$where=$department_id='';
		
		$approval_status = array_search('approval_status',$this->uri->segment_array());
	
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1))
		{
			$approval_status = $this->uri->segment($approval_status+1);
			
			if($approval_status!='')
			{
				$params_url="approval_status/".$approval_status;
			}
		}
		
          $zone_id=array_search('zone_id',$segment_array);	
		  
		  if($zone_id !==FALSE && $this->uri->segment($zone_id+1)!='')
          {
			 	$zone_id=$this->uri->segment($zone_id+1);        
				         
                $params_url.='/zone_id/'.$zone_id;
		  }  
		   else
		   $zone_id='';
			
			$this->data['filters']['zone_id']=$zone_id;
			
			$this->data['filters']['approval_status']=$approval_status;

			$this->data['params_url']=$params_url;
		
		
		$this->load->view($this->data['controller'].'day_in_process',$this->data);
	}
	
	public function myjobs()
	{ 
		#print_r($this->session->userdata); exit;
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
		
		$this->load->view($this->data['controller'].'myjobs',$this->data);
	}
	
	
	public function ajax_fetch_data() //swathi
	{
		$user_id=$this->session->userdata('user_id');

		$job_approval_status=unserialize(CONFINED_JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(CONFINED_JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');
		
		$zone_id=$this->session->userdata('zone_id');
		
		$where_condition='';

		$show_button = array_search('show_button',$this->uri->segment_array());

        if($show_button !==FALSE && $this->uri->segment($show_button+1))
        {
            $show_button = $this->uri->segment($show_button+1);
			
			if($show_button=='hide')
			$param_url=$this->data['controller'].'/day_in_process/'.$param_url;
			else
			$param_url=$this->data['controller'].'/index/'.$param_url;
		}
	
		
		$job_status=unserialize(CONFINED_JOB_STATUS);
	
		$job_status="'" . implode("','", $job_status) . "'";
		
		if($show_button=='hide')
		{
			$where_condition.=" j.approval_status NOT IN(".$job_status.") AND ";

			/*if(!in_array($department_id,array(EIP_CIVIL,EIP_TECHNICAL)))
			$where_condition.=" j.department_id IN('".EIP_PROCESS."','".EIP_POWER_PLANT."','".$department_id."') ";
			else
			$where_condition.=" j.department_id IN('".EIP_CIVIL."','".EIP_TECHNICAL."','".EIP_PROCESS."','".EIP_POWER_PLANT."') ";		
*/
		}


		$approval_status = array_search('approval_status',$this->uri->segment_array());
	
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1))
		{
			$approval_status = $this->uri->segment($approval_status+1);
			
			if($approval_status!='')
			{
				$where_condition.=" j.approval_status IN(".$approval_status.") AND ";
			}
		}
		
        $zone_id = array_search('zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id ='".$zone_id."' AND ";
		}

        $user_role = array_search('user_role',$this->uri->segment_array());

		if($user_role !==FALSE && $this->uri->segment($user_role+1))
        {
            $user_role = $this->uri->segment($user_role+1);

			$arr = range('a', 'f');
			
			$qry_pa='('; //{"a":"15","b":"","c":"","d":"","e":"","f":""} Need to change in reports controller
			
			$qry_ia='(';

			$qry_sa='(';

				for($i=0;$i<count($arr);$i++)
				{
					$qry_ia.=' (j.extended_issuing_from_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_issuing_to_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';
					
					$qry_pa.=' (j.extended_performing_from_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_performing_to_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';

					$qry_sa.=' (j.extended_safety_from_sign_id like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_safety_to_sign_id like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';
				}

				$qry_ia = rtrim($qry_ia,'OR ');

				$qry_pa = rtrim($qry_pa,'OR ');

				$qry_sa = rtrim($qry_sa,'OR ');
							
				$qry_ia.=')';
				
				$qry_pa.=')';

				$qry_sa.=')';
			

			if($user_role=='PA')
			$where_condition .= 'j.acceptance_performing_id = "'.$user_id.'" OR '.$qry_pa.' AND ';
			else if($user_role=='IA')
			$where_condition .= '(j.acceptance_issuing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'") OR  '.$qry_ia.' AND ';
			else if($user_role=='SAT')
			$where_condition .= '(j.acceptance_safety_sign_id = "'.$user_id.'")  OR '.$qry_sa.' AND ';
			else
			$where_condition .= '(j.acceptance_performing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'" OR j.acceptance_issuing_id = "'.$user_id.'") OR '.$qry_pa.' OR '.$qry_ia.' OR '.$qry_sa.' AND ' ;


		}

			

		$subscription_date_start = array_search($user_role.'subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
     	
		
		$subscription_date_end = array_search($user_role.'subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));
		
		$where_condition=rtrim($where_condition,'AND ');		

	  	//Getting in URL params
	 	$search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
	  
	  	if($search_value!='')
	  	{
		  $where_condition.=" AND (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no like '%".$search_value."%') AND ";
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
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified',
							16=>'j.acceptance_safety_sign_id',
							17=>'j.is_draft',
							18=>'j.draft_user_id'
						);
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->confined_permits_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		#echo $this->db->last_query();  exit;

		$records=$this->confined_permits_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		
		$json=array();
		
		$job_status=unserialize(JOB_STATUS);
		
		if($totalFiltered>0)
		{
			$j=0;
			
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];

				$redirect=base_url().'confined_permits/form/id/'.$id.'/confined_permits/index/'.$param_url;
				
				
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
				
				$waiating_approval_by=$this->confined_permits_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				
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
				
				$print='- - -';
				
				if($show_button=='hide')
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';		

				$cl='';

				if($user_id==$record['draft_user_id'])
					$cl='red';		
				
						$json[$j]['id']='<a href="'.$redirect.'" style="color:'.$cl.'">'.'#'.$permit_no.'</a>';	
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
	
	public function ajax_myjobs_fetch_data() //swathi
	{
		$user_id=$this->session->userdata('user_id');

		 $job_approval_status=unserialize(CONFINED_JOBAPPROVALS);
		 
		 $job_approval_status_color=unserialize(CONFINED_JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');
		
		$zone_id=$this->session->userdata('zone_id');
		
		$where_condition='';

		   $show_button = array_search('show_button',$this->uri->segment_array());

        if($show_button !==FALSE && $this->uri->segment($show_button+1))
        {
            $show_button = $this->uri->segment($show_button+1);
			
			if($show_button=='hide')
			$param_url=$this->data['controller'].'/day_in_process/'.$param_url;
			else
			$param_url=$this->data['controller'].'/index/'.$param_url;
		}
		
		
		#$where_condition .=" j.department_id = '".$department_id."' AND ";
		
		// $where_condition.=' j.show_button = "'.$show_button.'" AND '; 
		
			$job_status=unserialize(CONFINED_JOB_STATUS);
	
			$job_status="'" . implode("','", $job_status) . "'";
		
		if($show_button=='hide')
		$where_condition.=" j.approval_status NOT IN(".$job_status.") AND ";
		
		$approval_status = array_search('approval_status',$this->uri->segment_array());
	
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1))
		{
			$approval_status = $this->uri->segment($approval_status+1);
			
			if($approval_status!='')
			{
				$where_condition.=" j.approval_status IN(".$approval_status.") AND ";
			}
		}
		
        $zone_id = array_search('zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id ='".$zone_id."' AND ";
		}

        $user_role = array_search('user_role',$this->uri->segment_array());

		if($user_role !==FALSE && $this->uri->segment($user_role+1))
        {
            $user_role = $this->uri->segment($user_role+1);

			$arr = range('a', 'f');
			
			$qry_pa='('; //{"a":"15","b":"","c":"","d":"","e":"","f":""} Need to change in reports controller
			
			$qry_ia='(';

			$qry_sa='(';

				for($i=0;$i<count($arr);$i++)
				{
					$qry_ia.=' (j.extended_issuing_from_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_issuing_to_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';
					
					$qry_pa.=' (j.extended_performing_from_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_performing_to_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';

					$qry_sa.=' (j.extended_safety_from_sign_id like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_safety_to_sign_id like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';
				}

				$qry_ia = rtrim($qry_ia,'OR ');

				$qry_pa = rtrim($qry_pa,'OR ');

				$qry_sa = rtrim($qry_sa,'OR ');
							
				$qry_ia.=')';
				
				$qry_pa.=')';

				$qry_sa.=')';
			

			if($user_role=='PA')
			$where_condition .= 'j.acceptance_performing_id = "'.$user_id.'" OR '.$qry_pa.' AND ';
			else if($user_role=='IA')
			$where_condition .= '(j.acceptance_issuing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'") OR  '.$qry_ia.' AND ';
			else if($user_role=='SAT')
			$where_condition .= '(j.acceptance_safety_sign_id = "'.$user_id.'")  OR '.$qry_sa.' AND ';
			else
			$where_condition .= '(j.acceptance_performing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'" OR j.acceptance_issuing_id = "'.$user_id.'") OR '.$qry_pa.' OR '.$qry_ia.' OR '.$qry_sa.' AND ' ;


		}

		$subscription_date_start = array_search($user_role.'subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
     	
		
		$subscription_date_end = array_search($user_role.'subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));
		
		$where_condition=rtrim($where_condition,'AND ');

		#echo $where_condition;

		// $where_condition='('.$where_condition.') AND ( (DATE(j.location_time_start) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'") OR (DATE(j.location_time_to) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'")) AND';		


		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" AND (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no like '%".$search_value."%') AND ";
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
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified',
							16=>'j.acceptance_safety_sign_id',
							17=>'j.is_draft',
							18=>'j.draft_user_id'
						);
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->confined_permits_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		#echo $this->db->last_query();  exit;

		$records=$this->confined_permits_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		


		$json=array();
		
		$job_status=unserialize(JOB_STATUS);
		
		if($totalFiltered>0)
		{
			$j=0;
			
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];

				$redirect=base_url().'confined_permits/form/id/'.$id.'/confined_permits/index/'.$param_url;
				
				
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
				
				$waiating_approval_by=$this->confined_permits_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				
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
				
				$print='- - -';
				
				if($show_button=='hide')
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';		

				$cl='';

				if($user_id==$record['draft_user_id'])
					$cl='red';		
				
						$json[$j]['id']='<a href="'.$redirect.'" style="color:'.$cl.'">'.'#'.$permit_no.'</a>';
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

	public function form()	//Whenever you change anything here, apply the samething in reports
	{ 
	

		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>5,'segment_array'=>$segment_array));	
		
		$readonly='';

		if($param_url=='')
		$param_url=$this->data['controller'].'/index/';	
		
		$zone_id=$this->session->userdata('zone_id');
		
		$department_id=$this->session->userdata('department_id');
		
		$user_name=$this->session->userdata('first_name');
		
		$user_id=$this->session->userdata('user_id');
		
		$authorities=$job_isolations_where=$job_status_error_msg='';
		
		#echo $this->db->last_query(); exit;
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
		
		$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
		
		$this->data['isoloation_permit_no']='';


		$user_ids='';
			
	
        $update = array_search('id',$this->uri->segment_array());
        $id='';
        if($update !==FALSE && $this->uri->segment($update+1))      
        {
           $id = $this->uri->segment($update+1);
            $req=array(
              'select'  =>'*,TIMESTAMPDIFF(HOUR, modified, "'.date('Y-m-d H:i').'") as time_diff',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>CONFINEDPERMITS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{
                $records=$qry->row_array();

                #echo '<pre>'; print_r($records); exit;
				
				$this->data['records']=$records;

			    $user_ids=$this->confined_permits_model->get_user_ids($records);

				$department_id = $records['department_id'];
				
				#$this->data['isoloation_permit_no'] = $this->public_model->get_data(array('table'=>CONFINEDPERMITSISOLATIONRELATIONS,'select'=>'CONFINEDPERMITS_isoloations_id','where_condition'=>'job_id = "'.$id.'"'));
				
				$isolation_relations=$this->public_model->join_fetch_data(array('select'=>'i.approval_status,ir.jobs_isoloations_id','table1'=>JOBSISOLATION.' i','table2'=>JOBSISOLATIONRELATIONS.' ir','join_on'=>'ir.jobs_isoloations_id=i.id','join_type'=>'inner','where'=>'ir.job_id = "'.$id.'" AND relation_type="'.CONFINEDPERMITS.'"','num_rows'=>false));
				
				$this->data['isoloation_permit_no']=$isolation_relations;
				
				  if($isolation_relations->num_rows()>0)
				  {
					  $fets_permits=$isolation_relations->result_array();
						  
					  $jobs_isoloations_ids=array_column($fets_permits,'jobs_isoloations_id');				  
					
					  $jobs_isoloations_id="'" . implode("','", $jobs_isoloations_ids) . "'";
					  
					  if($records['approval_status']==1 && in_array($user_id,array($records['acceptance_safety_sign_id'],$records['acceptance_issuing_id']))) #$records['acceptance_issuing_id']==$user_id)
					  {
						  $req=array('select'=>'id','table'=>JOBSISOLATION,'where_condition'=>"id IN(".$jobs_isoloations_id.") AND approval_status>=6");
						  
						  $check_jobs_isolation_status=$this->public_model->get_data($req);
						  
						  #echo $this->db->last_query(); exit;
						  
						  $check_jobs_isolation_status_num=$check_jobs_isolation_status->num_rows();
						  
						 # echo 'SS '.count($jobs_isoloations_ids).' != '.$check_jobs_isolation_status_num; exit;
						  
						  if(count($jobs_isoloations_ids)!=$check_jobs_isolation_status_num)
						  {
							 $job_status_error_msg='<a href="'.base_url().'jobs_isolations/index/user_role/All/" target="_blank">'.(count($jobs_isoloations_ids)-$check_jobs_isolation_status_num).'</a> number of EIPs are not final submitted by IA';			
						  }
					  }
					  
					  $job_isolations_where=' OR (id IN('.$jobs_isoloations_id.'))';
				  }
				
				$msg=$user_name.' accessed job information';
				
				$array=array('notes'=>$msg,'created'=>date('Y-m-d H:i'),'user_id'=>$user_id,'job_id'=>$id);
				
				$this->db->insert(CONFINEDJOBSHISTORY,$array);
				
				$show_button=$records['show_button'];
				
				 if($show_button=='hide')
				 $readonly=true;

				if($records['is_draft']==YES)
				{
					$job_status_error_msg='Please note this job is in draft mode. Last updated by '.$records['last_updated_by'];
				}

			   $where=" id = '".$department_id."'";
				//Getting Active Companys List
			   $qry=$this->public_model->get_data(array('select'=>'id,name','where_condition'=>$where,'table'=>DEPARTMENTS));		
				
			   $dept=$qry->row_array();

			   $this->data['department']['name'] = $dept['name'];
		
			   $this->data['department']['id'] = $dept['id'];			   
				
            }   
        }
		else
		{

			if($this->session->userdata('permission')==WRITE)
			{
				$this->load->model(array('cron_job_model'));

				$where=' AND id ="'.$this->session->userdata('user_id').'"';

				$this->cron_job_model->check_expired_permits(array('where'=>$where,'type'=>'single'));
				
				$this->data['permit_no']=$this->get_max_permit_id(array('department_id'=>$department_id));

				$this->data['department']['name'] = $this->session->userdata('department_name');
		
				$this->data['department']['id'] = $this->session->userdata('department_id');
			}
			else
			{
				$this->session->set_flashdata('failure',PERMISSION_MSG);

        		redirect('confined_permits/index');				
			}	
		}

				if($user_ids!='')
				$where="(department_id = '".$department_id."' OR ".$user_ids.")";
				else
				$where = "department_id = '".$department_id."'";


	 		   $where.=" AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
				//Getting Active Companys List
			   $qry=$this->public_model->get_data(array('select'=>'id,first_name,is_safety','where_condition'=>$where,'table'=>USERS,'column'=>'first_name','dir'=>'asc'));
			
				#echo $this->db->last_query(); exit;
				if($qry->num_rows()>0)
				{
					$authorities=$qry->result_array();
				}
		
				$this->data['eips'] = $this->public_model->get_data(array('select'=>'id,section,status,eip_no','where_condition'=>' (status = "'.STATUS_OPENED.'"  AND department_id = "'.$department_id.'" AND DATE(date_end)>=DATE(NOW())) '.$job_isolations_where,'table'=>JOBSISOLATION));
				#echo $this->db->last_query(); exit;status = "'.STATUS_OPENED.'"  AND AND DATE(date_end)>=DATE(NOW())

				$safety_authorities = array();

 			   $where="is_safety = 'Yes'  AND status='".STATUS_ACTIVE."'";
				//Getting Active Companys List
			   $qry=$this->public_model->get_data(array('select'=>'id,first_name','where_condition'=>$where,'table'=>USERS,'column'=>'first_name','dir'=>'asc'));

			   #echo $this->db->last_query(); exit;
				if($qry->num_rows()>0)
				{
					$safety_authorities=$qry->result_array();
				}			

				$issuing_authorities = array();

				/*if(!in_array($department_id,array(EIP_CIVIL,EIP_TECHNICAL)))
				$where=" department_id IN('".EIP_PROCESS."','".EIP_POWER_PLANT."') ";
				else
				$where=" department_id IN('".EIP_CIVIL."','".EIP_TECHNICAL."','".EIP_PROCESS."','".EIP_POWER_PLANT."') ";				*/

				


				$where="(department_id IN(".EIP_PRODUCTION.",".EIP_PACKING_OPERATION.")";

				if(IA_USERS!='')
 			     $where.=' OR id IN('.IA_USERS.'))';

				

 			    $where.="  AND status='".STATUS_ACTIVE."'";			   

				//Getting Active Companys List
			    $qry=$this->public_model->get_data(array('select'=>'id,first_name','where_condition'=>$where,'table'=>USERS,'column'=>'first_name','dir'=>'asc'));

			    #echo $this->db->last_query(); exit;
				if($qry->num_rows()>0)
				{
					$issuing_authorities=$qry->result_array();
				}		

			$this->data['issuing_authorities']=$issuing_authorities;						
			$this->data['safety_authorities']=$safety_authorities;		

			$this->data['authorities']=$authorities;
			
			$this->data['user_id']=$this->session->userdata('user_id');
			
			$this->data['readonly']=$readonly;
			
			$this->data['job_status_error_msg']=$job_status_error_msg;
			
			$this->data['param_url']=$param_url;
			
			$this->load->view($this->data['controller'].'form',$this->data);
	}
	

	
	public function ajax_show_energy_info()
	{
		
	$zone_id=$this->session->userdata('zone_id');
	
	$department_id=$this->session->userdata('department_id');
	
	$user_id=$this->session->userdata('user_id');
	
	$authorities='';
	
	$this->data['records']='';

	$this->data['job_descriptions'] = array();
	
	$this->data['departments'] = $this->departments_model->get_details(array('fields'=>'d.name,d.id,d.status',
	'conditions'=>'d.status= "'.STATUS_ACTIVE.'"'));
	
	$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));	
		
        $update = array_search('id',$this->uri->segment_array());
		
		  if($update !==FALSE && $this->uri->segment($update+1)!='')
          {
			 	$update=$this->uri->segment($update+1);        
				
				if($update=='undefined')
				$update='';
		  }
		  else
		  $update='';
		  
		  #echo 'SS '.$update;
		
        $id='';
        if(!empty($update))
        {
            $id =$update;
            $req=array(
              'select'  =>'*',
              'table'    =>JOBSISOLATION,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{
                $records=$qry->row_array();
				
				$this->data['records']=$records;
				
				$this->data['sl_no']=$records['id'];
				
				$permits = $this->public_model->join_fetch_data(array('table1'=>CONFINEDPERMITS.' j','select'=>'j.id,j.permit_no','where'=>'jir.jobs_isoloations_id="'.$id.'"','table2'=>CONFINEDISOLATIONRELATIONS.' jir','join_on'=>'j.id=jir.job_id','join_type'=>'inner','num_rows'=>false));	
				if($permits->num_rows()>0)
				{
					$fet_permits=$permits->result_array();	
					
					$this->data['records']['work_permit_nos']=implode(',',array_column($fet_permits,'permit_no'));
				}
            }   
        }
		else
		{
			$qry=$this->db->query("SELECT max(id)+1 as sl_no FROM ".JOBSISOLATION);
			
			$fet=$qry->row_array();	
			
			if(!$fet['sl_no'])
			$fet['sl_no']=1;
			
			$this->data['sl_no']=$fet['sl_no'];
		}
		
	   $where="department_id = '".$department_id."' AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
		//Getting Active Companys List
	   $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));

		if($qry->num_rows()>0)
		{
			$authorities=$qry->result_array();
		}
		
		$this->data['authorities']=$authorities;
		
		$this->data['isolaters'] = $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND is_isolator="Yes" and department_id="'.$department_id.'"'));	
		
		$this->data['isolations'] = $this->public_model->get_data(array('table'=>ISOLATION,'select'=>'name,id,record_type,
		isolation_type_id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));	
		
		$department_id = $department_id.','.EIP_OTHER_DEPARTMENT;	//Mechanical & Instrumental
		
	    $where="department_id IN(".$department_id.") AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
		//Getting Active Companys List
	    $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));
		
		#echo $this->db->last_query();
		
		$issuing_authorities='';
		
		if($qry->num_rows()>0)
		{
			$issuing_authorities=$qry->result_array();
		}
		
		$this->data['issuing_authorities']=$issuing_authorities;
		
		$this->data['user_id']=$this->session->userdata('user_id');

		$this->load->view($this->data['controller'].'energy',$this->data);     
		   
	}

	public function time_form()
	{ 
	
	$authorities='';
	
	$zone_id=$this->session->userdata('zone_id');
	
	$this->data['departments'] = $this->departments_model->get_details(array('fields'=>'d.name,d.id,d.status',
	'conditions'=>'d.status= "'.STATUS_ACTIVE.'"'));

	$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
	
	$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
	
	
	
	
        $update = array_search('id',$this->uri->segment_array());
        $id='';
        if($update !==FALSE && $this->uri->segment($update+1))
        {
            $id = $this->uri->segment($update+1);
            $req=array(
              'select'  =>'*',
              'table'    =>CONFINEDPERMITS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{
                $records=$qry->row_array();
				
				$this->data['records']=$records;
				
				$department_id=$records['department_id'];
				
			   $where="department_id = '".$department_id."' AND user_role IN ('IA','PA') AND status='".STATUS_ACTIVE."'";
				//Getting Active Companys List
			   $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));
		
				if($qry->num_rows()>0)
				{
					$authorities=$qry->result_array();
				}
				
				
            }   
        }
		
		$this->data['authorities']=$authorities;
		
		$this->load->view($this->data['controller'].'time_form',$this->data);
	}
	
	
	
	public function form_action()
	{
	//	echo '<pre>';print_r($this->input->post());exit;		

		$submit_type=$this->input->post('submit_type'); 
		
		$user_name=$this->session->userdata('first_name');
		
		$user_id=$this->session->userdata('user_id');
		
		$approval_status=unserialize(CONFINED_JOBAPPROVALS);
		
		$array_fields=array('precautions_text','issuing_authority_approval_status','precautions_options','hazards_options','precautions','hazards','schedule_date','schedule_to_time','schedule_from_time','watch_other_person_names','watch_person_to_time','watch_person_from_time','extended_from_oxygen_reading','extended_to_oxygen_reading','extended_from_gases_reading','extended_to_gases_reading','extended_from_carbon_reading','extended_to_carbon_reading','extended_reference_code_from','extended_reference_code_to','watch_other_person_from_names','watch_other_person_to_names','extended_performing_to_authority','extended_performing_from_authority','extended_safety_to_sign_id','extended_safety_from_sign_id','extended_issuing_to_authority','extended_issuing_from_authority','extended_time_period','extended_issuing_from_approval_status','extended_issuing_to_approval_status','extended_safety_from_approval_status','extended_safety_to_approval_status','extend_issuing_authority_name_of_from_ia','extend_issuing_authority_name_of_to_ia');
		
		$skip_fields=array('id','submit','is_popup_submit','isoloation_permit_no','submit_type');
		
		$print_out='';
		
		$arr=array();
		
		$fields='';
		
		$fields_values='';
		
		$update=''; 
		
		$msg='';
		
		$short_dept=substr($this->session->userdata('department_name'),0,2);
		
		$is_send_sms='';

		if(!$this->input->post('id'))	//If new jobs create
		{
				$_POST['permit_no']=$this->get_max_permit_id(array('department_id'=>$_POST['department_id']));
				
				$_POST['acceptance_performing_date']=$this->data['system_current_date'];	
				
				$_POST['permit_no_sec']=preg_replace("/[^0-9,.]/", "", $_POST['permit_no']);

				$_POST['approval_status']=1;	//Waiting IA Acceptance
				
				$_POST['status']=STATUS_PENDING;

				$is_send_sms=YES;

				$sender=$_POST['acceptance_performing_id'];

				$receiver=$_POST['acceptance_safety_sign_id'];

				$msg_type=PATOIA_WAITING_APPROVAL;	
		}	
		else
		{
			$show_button=($_POST['show_button']) ? trim($_POST['show_button']) : '';

			$job_id = $this->input->post('id');

			$job_qry=$this->public_model->get_data(array('select'=>'id,acceptance_safety_sign_id,cancellation_issuing_id,approval_status,status,last_modified_id,last_updated_by','where_condition'=>'id ="'.$job_id.'"','table'=>CONFINEDPERMITS));

			$job_result = $job_qry->row_array();

			$db_modified=$job_result['last_modified_id'];

			$modified=$this->input->post('last_modified_id');

			if($db_modified!=$modified)		//Check if any update info recently
			{
				$this->session->set_flashdata('failure','Sorry, Just before <b>'.$job_result['last_updated_by'].'</b> has updated this permit info. Please check updated information');  

				$ret=array('status'=>false,'print_out'=>'');		                   
      
				echo json_encode($ret);

				exit;
			}
			
			if($show_button=='hide')	//After IA approve we got this When PA submit his job
			{		
				$_POST['status']=STATUS_OPENED;		
				
				$_POST['final_status_date']=$this->data['system_current_date'];
				
				$print_out=1;
				
				$msg='<b>PA moved his job to Day End Process</b>';
			}
			else if($show_button=='approveSA') //Safety approve his job
			{
				if($job_result['approval_status'] == 1 && $user_id != $job_result['acceptance_safety_sign_id'])
				{
					// echo $user_id.' Invalid issuing authority';

					$this->session->set_flashdata('failure','Safety authority changed!');    

					$ret=array('status'=>true,'print_out'=>'');
					  
					echo json_encode($ret);
					
					exit;
				}

				if($submit_type!='draft')
				{
					$_POST['approval_status']=3;		
				
					$_POST['acceptance_safety_approval']='Yes';
				
					$_POST['acceptance_safety_date']=$this->data['system_current_date'];
				
					$msg='<b>'.$user_name.'(SA) approved and updated reading to this job</b>';
				}
				else
					unset($_POST['acceptance_safety_date']);

				unset($_POST['show_button']);

				$is_send_sms=YES;

				$sender=$_POST['acceptance_safety_sign_id'];

				$receiver=$_POST['acceptance_issuing_id'];
				
				$msg_type=IATOPA_APPROVAL;	

				
			}			
			else if($show_button=='approveIA') //IA approve his job
			{


				$job_id = $this->input->post('id');

				$job_qry=$this->public_model->get_data(array('select'=>'id,acceptance_issuing_id,cancellation_issuing_id,approval_status,status','where_condition'=>'id ="'.$job_id.'"','table'=>CONFINEDPERMITS));

				$job_result = $job_qry->row_array();
			
				if($job_result['approval_status'] == 1 && $user_id != $job_result['acceptance_issuing_id'])
				{
					// echo $user_id.' Invalid issuing authority';

					$this->session->set_flashdata('failure','Issuing authority changed!');    

					$ret=array('status'=>true,'print_out'=>'');
					  
					echo json_encode($ret);
					
					exit;
				}

				if($submit_type!='draft')
				{

					$_POST['approval_status']=4;		
					
					$_POST['acceptance_issuing_approval']='Yes';
					
					$_POST['acceptance_issuing_date']=$this->data['system_current_date'];
					
					$msg='<b>'.$user_name.'(IA) approved this job</b>';

				}
				else
					unset($_POST['acceptance_issuing_date']);

				unset($_POST['show_button']);

				$is_send_sms=YES;

				$sender=$_POST['acceptance_issuing_id'];

				$receiver=$_POST['acceptance_performing_id'];
				
				$msg_type=IATOPA_APPROVAL;	

				$print_out=1;
			}
			
			$status=(isset($_POST['status'])) ? $_POST['status'] : '';
			
			
			#echo '<br /> SS : '.$status.' - '.$show_button; #exit;
			if($status!='' && $show_button!='hide')
			{
				unset($_POST['show_button']);
				
				if(in_array(strtolower($status),array('cancellation','completion')))
				{
					if($user_id==$this->input->post('cancellation_performing_id'))
					{
							if(strtolower($status)=='cancellation')
							{
								$_POST['approval_status']=7;
								
								$_POST['cancellation_performing_date'] = $this->data['system_current_date'];

								$is_send_sms=YES;

								$msg_type=PATOIA_WAITING_CANCEL_REQUEST;

								$sender=$user_id;

								$receiver=$_POST['cancellation_issuing_id'];
							}
							else if(strtolower($status)=='completion')
							{
								$_POST['approval_status']=5;
								
								$_POST['cancellation_performing_date'] = $this->data['system_current_date'];

								$is_send_sms=YES;

								$msg_type=PATOIA_WAITING_COMPLETION_REQUEST;

								$sender=$user_id;

								$receiver=$_POST['cancellation_issuing_id'];
							}
							$msg='<b>Sent '.$status.' request to IA</b>';	 
					}
					else if($user_id==$this->input->post('cancellation_issuing_id'))
					{
							if(strtolower($status)=='cancellation')
							{
								$_POST['approval_status']=8;
								
								$_POST['cancellation_issuing_date'] = $this->data['system_current_date'];

								$is_send_sms=YES;

								$msg_type=IATOPA_CANCEL_APPROVAL;

								$sender=$user_id;

								$receiver=$_POST['cancellation_performing_id'];	
							}
							else if(strtolower($status)=='completion')
							{
								$_POST['approval_status']=6;
								
								$_POST['cancellation_issuing_date'] = $this->data['system_current_date'];

								$is_send_sms=YES;

								$msg_type=IATOPA_COMPLETION_APPROVAL;

								$sender=$user_id;

								$receiver=$_POST['cancellation_performing_id'];	
							}
							$msg='<b>'.ucfirst($status).' accept by IA</b>';	
					}
				}
				else if(strtolower($status)=='extended')
				{
					$range=range('a','f');
					
					for($l=0;$l<count($range);$l++)
					{
							$extended_time_period = $_POST['extended_time_period'][$range[$l]];		

							
							#echo '<br /> Ext '.$extended_time_period; 		
						#$issuing_authority_approval_status=$_POST['issuing_authority_approval_status'][$range[$l]];
						
							$schedule_date=$_POST['schedule_date'][$range[$l]];	

							if($schedule_date!='')
							{	
								
								$performing_authority=$_POST['extended_performing_'.$extended_time_period.'_authority'][$range[$l]];	
								
								$issuing_authority=$_POST['extended_issuing_'.$extended_time_period.'_authority'][$range[$l]];

								$issuing_authority_approval_status=$_POST['extended_issuing_'.$extended_time_period.'_approval_status'][$range[$l]];						

								$safety_authority=$_POST['extended_safety_'.$extended_time_period.'_sign_id'][$range[$l]];

								$safety_authority_approval_status=$_POST['extended_safety_'.$extended_time_period.'_approval_status'][$range[$l]];						
	
								#echo '<br /> A '.$safety_authority_approval_status.' = '.$issuing_authority_approval_status;
								if($user_id==$performing_authority)
								{
									$b='';
									if($safety_authority_approval_status=='')
									{
										$_POST['extended_safety_'.$extended_time_period.'_approval_status'][$range[$l]]='Waiting';
										
										$_POST['approval_status']=9;
										
										$msg='<b>'.ucfirst($status).' request sent to SA</b>';	

										$is_send_sms=YES;

										$msg_type=PATOIA_WAITING_EXTEND_APPROVAL;

										$sender=$user_id;

										$receiver=$safety_authority;	
										
										$b=1;
									}							
									else if($issuing_authority_approval_status=='')
									{
										$_POST['extended_issuing_'.$extended_time_period.'_approval_status'][$range[$l]]='';
										
										#$_POST['approval_status']=11;
										
										$msg='<b>'.ucfirst($status).' request sent to IA</b>';	

										$is_send_sms=YES;

										$msg_type=PATOIA_WAITING_EXTEND_APPROVAL;

										$sender=$user_id;

										$receiver=$issuing_authority;	
										
										$b=1;
									}

									if($b==1)
									break;
								}
								else if($user_id==$safety_authority || $user_id==$issuing_authority) 
								{

									if($schedule_date!='' && $safety_authority_approval_status=='Waiting')
									{										
										$_POST['extended_safety_'.$extended_time_period.'_approval_status'][$range[$l]]='Approved';

										$_POST['extended_issuing_'.$extended_time_period.'_approval_status'][$range[$l]]='Waiting';
										
										$_POST['approval_status']=10;
										
										$msg='<b>'.ucfirst($status).' approval accept by SA and sent request to IA</b>';	

										$is_send_sms=YES;

										$msg_type=IATOPA_ACCEPT_EXTEND_APPROVAL;

										$sender=$user_id;

										$receiver=$performing_authority;	
										
										break;
									}

									if($schedule_date!='' && $issuing_authority_approval_status=='Waiting')
									{
										$_POST['extended_issuing_'.$extended_time_period.'_approval_status'][$range[$l]]='Approved';
										
										$_POST['approval_status']=12;
										
										$msg='<b>'.ucfirst($status).' approval accepted by IA</b>';	
										
										$_POST['extended_reference_code_'.$extended_time_period][$range[$l]]=substr(time(),0,6);

										$is_send_sms=YES;

										$msg_type=IATOPA_ACCEPT_EXTEND_APPROVAL;

										$sender=$user_id;

										$receiver=$performing_authority;	
										
										break;
										
									}									
								}						
								else if($user_id==$issuing_authority)
								{

									if($schedule_date!='' && $issuing_authority_approval_status=='Waiting' && $safety_authority_approval_status==APPROVED)
									{
										$_POST['extended_issuing_'.$extended_time_period.'_approval_status'][$range[$l]]='Approved';
										
										$_POST['approval_status']=12;
										
										$msg='<b>'.ucfirst($status).' approval sent to PA</b>';	

										$_POST['extended_reference_code_'.$extended_time_period][$range[$l]]=substr(time(),0,6);

										$is_send_sms=YES;

										$msg_type=IATOPA_ACCEPT_EXTEND_APPROVAL;

										$sender=$user_id;

										$receiver=$performing_authority;
										
										break;
									}
								}

							}
					
					}
					
				}
				
			}
		}
		
		$_POST['is_draft']=NO;

		$_POST['draft_user_id']='';

		if($submit_type=='draft')
		{
			$_POST['is_draft']=YES;

			$_POST['draft_user_id']=$user_id;
		}

		$self_cancellation_description = isset($_POST['self_cancellation_description'])  ? trim($_POST['self_cancellation_description']) : '';

		if(!empty($self_cancellation_description) && strtolower($status)!='cancellation' && $_POST['is_draft']==NO)
		{
			$_POST['approval_status'] = 13;

			$_POST['status'] = 'Cancellation';

			$msg='<b>Self Cancelled</b> by PA';	

			$is_send_sms=YES;

			$msg_type=PATOIA_SELF_CANCELLED;

			$sender=$user_id;

			$receiver=$_POST['acceptance_issuing_id'];	
		}
		
		$_POST['last_updated_by']=$user_name;

		$_POST['last_modified_id']=rand(time(),5);
		

		$id=($this->input->post('id')) ? $this->input->post('id') : '';
		
		if($id!='')
		{
			$permit_no=$_POST['permit_no'];

			$skip_fields=array_merge($skip_fields,array('permit_no','department_id'));

			unset($_POST['permit_no']);

			unset($_POST['department_id']);
		}
		else
			$_POST['permit_no']=$permit_no=$this->get_max_permit_id(array('department_id'=>$_POST['department_id']));

		


		#echo '<pre>'; print_r($_POST); exit;
		$inputs=$this->input->post();
		
		foreach($inputs as $field_name => $field_value)
		{
			if(!in_array($field_name,$skip_fields))
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

		#echo '<pre>'; print_r($_POST); exit;

		#echo $update; exit;
		
		$update.="modified = '".date('Y-m-d H:i:s')."'";
		
		$update=rtrim($update,',');
		
		$fields.='user_id,created,modified';
		
		$fields_values.='"'.$user_id.'","'.date('Y-m-d H:i:s').'","'.date('Y-m-d H:i:s').'"';
		
		$id=($this->input->post('id')) ? $this->input->post('id') : '';
		
		if(!$id)
		{
			$ins="INSERT INTO ".$this->db->dbprefix.CONFINEDPERMITS." (".$fields.") VALUES (".$fields_values.")";
		
			$this->db->query($ins);
			
			$id=$this->db->insert_id();
			
			$msg='<b>Created by '.$user_name.' and sent request to SA</b>';
			
		}
		else
		{
			$up="UPDATE ".$this->db->dbprefix.CONFINEDPERMITS." SET ".$update." WHERE id='".$id."'";
			
			$this->db->query($up);
		}

		$_POST['permit_no']=$permit_no;


		
		#echo $this->db->last_query();
		$affectedRows = $this->db->affected_rows();
		
		if($affectedRows>0)
		{
			$this->db->where('job_id',$id);

			$this->db->where('relation_type',CONFINEDPERMITS);
			
			$this->db->delete(JOBSISOLATIONRELATIONS);
			
			if(in_array($this->input->post('is_isoloation_permit'),array('Existing','Yes','yes_existing')))
			{
				$isoloation_permit_nos=explode(',',$_POST['isoloation_permit_no']);
				
				$job_qry=$this->public_model->get_data(array('select'=>'approval_status','where_condition'=>'id ="'.$id.'"','table'=>CONFINEDPERMITS));

				$job_result = $job_qry->row_array();
				
				$approval_status = $job_result['approval_status'];
							
				if(!in_array($approval_status,array(8,13)))	
				{
				
					$array_insert=array();

					$array_insert_history = array();				
						
					for($i=0;$i<count($isoloation_permit_nos);$i++)
					{
						$array_insert[]=array('job_id'=>$id,'jobs_isoloations_id'=>$isoloation_permit_nos[$i],'created'=>$this->data['system_current_date'],'relation_type'=>CONFINEDPERMITS);

						$array_insert_history[]=array('jobisolation_id'=>$isoloation_permit_nos[$i],'created'=>$this->data['system_current_date'],'user_id'=>$user_id,'notes'=>'Related to '.$_POST['permit_no'].' by '.$user_name);
					}
					
					
					if(count($array_insert)>0)
					{
						$this->db->insert_batch(JOBSISOLATIONRELATIONS,$array_insert);

						$this->db->insert_batch(JOBSISOLATIONHISTORY,$array_insert_history);
					}
				}		
				else
				{
					$this->jobs_isolations_model->check_job_relationship($isoloation_permit_nos,CONFINEDPERMITS);
				}
				
			}

			#echo 'FF '.$is_send_sms.' - '.$msg_type.' - '.$sender.' - '.$receiver; exit;

			$additional_text='. Job Desc : '.strtoupper($this->input->post('job_name'));
			
			if($is_send_sms!=''  && $_POST['is_draft']==NO)
			$this->public_model->send_sms(array('additional_text'=>$additional_text,'sender'=>$sender,'receiver'=>$receiver,'msg_type'=>$msg_type,'permit_type'=>'Confined Work Permit','permit_no'=>$_POST['permit_no']));

			#echo 'Yes'; exit;
			
			if($msg=='')
			$msg=$user_name.' has updated his job information';

			if($_POST['is_draft']==YES)
				$msg=$msg.' Saved as Draft';
			
			$array=array('user_id'=>$user_id,'job_id'=>$id,'notes'=>$msg,'created'=>$this->data['system_current_date']);
			
			$this->db->insert(CONFINEDJOBSHISTORY,$array);
		}
		
		#echo $this->db->last_query();
		
        $this->session->set_flashdata('success',DB_UPDATE);    
		
		#$print_out=1;
		
		$ret=array('status'=>true,'print_out'=>$print_out);
		                   
        #echo 'true'; 
		echo json_encode($ret);
		
		exit;
	}
	

	
	public function ajax_fetch_department_users()
	{
		$this->load->model(array('departments_model'));
		
		$department_id=$this->input->post('department_id');
		
		$ia=$pa='<option value="">- - Select - -</option>';
		
       $where="department_id = '".$department_id."' AND user_role IN ('IA','PA') AND status='".STATUS_ACTIVE."'";
        //Getting Active Companys List
       $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));

		if($qry->num_rows()>0)
		{
			$fets=$qry->result_array();
			
			
			foreach($fets as $fet)
			{
				$role=$fet['user_role'];
				
				$id=$fet['id'];
				
				$first_name=$fet['first_name'];
				
				if($role=='IA')
				$ia.='<option value="'.$id.'">'.$first_name.'</option>';
				
				if($role=='PA')
				$pa.='<option value="'.$id.'">'.$first_name.'</option>';
				
			}
		}
		
		echo json_encode(array('ia'=>$ia,'pa'=>$pa));
	}
	
	/**********************************************************************************************
	 * Description    :  Fetch & Show Matched jobs history records in Popup
	**********************************************************************************************/	
	

	public function printout()
	{ 
		error_reporting(0);
	#echo '<pre>'; print_r($this->session->userdata); exit;
	
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
	
	$this->data['department']['name'] = $this->session->userdata('department_name');
	
	$this->data['department']['id'] = $this->session->userdata('department_id');
	
	#echo $this->db->last_query(); exit;
	$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
	
	$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
	
	$this->data['isoloation_permit_no']='';
	
        $id = $this->input->post('id');
		
		$user_ids='';
		#$id=5;
		
        if($id!='')
        {
            $req=array(
              'select'  =>'*,TIMESTAMPDIFF(HOUR, modified, "'.date('Y-m-d H:i').'") as time_diff',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>CONFINEDPERMITS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{
                $records=$qry->row_array();
				
				$this->data['records']=$records;			

					$isolation_relations=$this->public_model->join_fetch_data(array('select'=>'i.approval_status,ir.jobs_isoloations_id','table1'=>JOBSISOLATION.' i','table2'=>JOBSISOLATIONRELATIONS.' ir','join_on'=>'ir.jobs_isoloations_id=i.id','join_type'=>'inner','where'=>'ir.job_id = "'.$id.'" AND relation_type="'.CONFINEDPERMITS.'"','num_rows'=>false));
				
					  $this->data['isoloation_permit_no']=$isolation_relations;
				
					  if($isolation_relations->num_rows()>0)
					  {
						  $fets_permits=$isolation_relations->result_array();
							  
						  $jobs_isoloations_ids=array_column($fets_permits,'jobs_isoloations_id');
						  
						  #echo '<pre>'; print_r($jobs_isoloations_ids); exit;
						  
						  $jobs_isoloations_ids="'" . implode("','", $jobs_isoloations_ids) . "'";
						  
						  if($records['approval_status']==1 && $records['acceptance_issuing_id']==$user_id)
						  {
							  $req=array('select'=>'id','table'=>JOBSISOLATION,'where_condition'=>"id IN(".$jobs_isoloations_ids.") AND approval_status>=6");
							  
							  $check_jobs_isolation_status=$this->public_model->get_data($req);
							  
							  #echo $this->db->last_query();
							  
							  $check_jobs_isolation_status_num=$check_jobs_isolation_status->num_rows();
							  
							  #echo 'SS '.count($jobs_isoloations_ids).' != '.$check_jobs_isolation_status_num; exit;
							  
							  if(count($jobs_isoloations_ids)!=$check_jobs_isolation_status_num)
							  {
								 $job_status_error_msg='<a href="'.base_url().'jobs_isolations/index/user_role/All/" target="_blank">'.(count($jobs_isoloations_ids)-$check_jobs_isolation_status_num).'</a> number of EIPs are not final submitted by IA';			
							  }
						  }
						  
						  $job_isolations_where=' OR (id IN('.$jobs_isoloations_ids.'))';
					  }

				
				$user_ids = $this->confined_permits_model->get_user_ids($records);

				$msg=$user_name.' print job information';
				
				$array=array('notes'=>$msg,'created'=>date('Y-m-d H:i'),'user_id'=>$user_id,'job_id'=>$id);
				
				$this->db->insert(CONFINEDJOBSHISTORY,$array);
				
				$show_button=$records['show_button'];
				
				 if($show_button=='hide')
				 $readonly=true;			
				
            }   
        }

			$this->data['eips'] = $this->public_model->get_data(array('select'=>'id,section,status,eip_no','where_condition'=>' (status = "'.STATUS_OPENED.'"  AND DATE(date_end)>=DATE(NOW())) '.$job_isolations_where,'table'=>JOBSISOLATION));

			#echo $this->db->last_query(); exit;
				/*if($user_ids!='')
				$where="(department_id = '".$department_id."' OR ".$user_ids.")";
				else
				$where = "department_id = '".$department_id."'";*/

				$where="department_id IN('".$department_id."','".EIP_PACKING_OPERATION."') ";

				if($user_ids!='')
					$where.=" OR ".$user_ids;

		
			   $where.=" AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
				//Getting Active Companys List
			   $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));
		
				if($qry->num_rows()>0)
				{
					$authorities=$qry->result_array();
				}	

		$this->data['authorities']=$authorities;
		
			$safety_authorities = array();

 			   $where="is_safety = 'Yes' AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
				//Getting Active Companys List
			   $qry=$this->public_model->get_data(array('select'=>'id,first_name','where_condition'=>$where,'table'=>USERS));

				if($qry->num_rows()>0)
				{
					$safety_authorities=$qry->result_array();
				}			
		$this->data['safety_authorities']=$safety_authorities;		

		$this->data['user_id']=$this->session->userdata('user_id');
		
		$this->data['readonly']=$readonly;
		
		$this->data['job_status_error_msg']=$job_status_error_msg;
		
		$this->load->view($this->data['controller'].'printout',$this->data);
	}
	

	public function closed_permits()
	{ 
			#print_r($this->session->userdata); exit;
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'))->result_array();

		$segment_array=$this->uri->segment_array();		
		
		$params_url=$where=$department_id='';
		
		$approval_status = array_search('approval_status',$this->uri->segment_array());
	
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1))
		{
			$approval_status = $this->uri->segment($approval_status+1);
			
			if($approval_status!='')
			{
				$params_url="approval_status/".$approval_status;
			}
		}
		else
		$approval_status=6;
		
        $subscription_date_start = array_search($approval_status.'subscription_date_start',$segment_array);

        if($subscription_date_start !==FALSE && $this->uri->segment($subscription_date_start+1))
        {
            $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		}
		else
		$subscription_date_start = date('Y-m-d',strtotime("-30 days"));
		
		$subscription_date_end = array_search($approval_status.'subscription_date_end',$segment_array);
		
        if($subscription_date_end !==FALSE && $this->uri->segment($subscription_date_end+1))
        {
            $subscription_date_end = $this->uri->segment($subscription_date_end+1);
		}
		else
		$subscription_date_end = date('Y-m-d');
		
		
		$this->data['filters'][$approval_status.'subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$this->data['filters'][$approval_status.'subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));
		
		
          $zone_id=array_search('zone_id',$segment_array);	
		  
		  if($zone_id !==FALSE && $this->uri->segment($zone_id+1)!='')
          {
			 	$zone_id=$this->uri->segment($zone_id+1);        
				         
                $params_url.='/zone_id/'.$zone_id;
		  }  
		   else
		   $zone_id='';
			
			$this->data['filters'][$approval_status.'zone_id']=$zone_id;
			
			$this->data['filters']['filter_status']=$approval_status;	
			
			$this->data['params_url']=$params_url;
		
		$this->load->view($this->data['controller'].'closed_permits',$this->data);
	}

	

	public function ajax_fetch_closeddata() //swathi
	{
		$user_id=$this->session->userdata('user_id');

		 $job_approval_status=unserialize(CONFINED_JOBAPPROVALS);
		 
		 $job_approval_status_color=unserialize(CONFINED_JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');
		
		$zone_id=$this->session->userdata('zone_id');
		
		$where_condition='';

		   $show_button = array_search('show_button',$this->uri->segment_array());

        if($show_button !==FALSE && $this->uri->segment($show_button+1))
        {
            $show_button = $this->uri->segment($show_button+1);
			
			if($show_button=='hide')
			$param_url=$this->data['controller'].'/day_in_process/'.$param_url;
			else
			$param_url=$this->data['controller'].'/index/'.$param_url;
		}
	
			$job_status=unserialize(CONFINED_JOB_STATUS);
	
			$job_status="'" . implode("','", $job_status) . "'";
		
		if($show_button=='hide')
		$where_condition.=" j.approval_status NOT IN(".$job_status.") AND ";
		
		$approval_status = array_search('approval_status',$this->uri->segment_array());
	
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1))
		{
			$approval_status = $this->uri->segment($approval_status+1);
			
			if($approval_status!='')
			{
				$where_condition.=" j.approval_status IN(".$approval_status.") AND ";
			}
		}
		
        $zone_id = array_search('zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id ='".$zone_id."' AND ";
		}

        $user_role = array_search('user_role',$this->uri->segment_array());

		if($user_role !==FALSE && $this->uri->segment($user_role+1))
        {
            $user_role = $this->uri->segment($user_role+1);

			$arr = range('a', 'f');
			
			$qry_pa='('; //{"a":"15","b":"","c":"","d":"","e":"","f":""} Need to change in reports controller
			
			$qry_ia='(';

			$qry_sa='(';

				for($i=0;$i<count($arr);$i++)
				{
					$qry_ia.=' (j.extended_issuing_from_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_issuing_to_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';
					
					$qry_pa.=' (j.extended_performing_from_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_performing_to_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';

					$qry_sa.=' (j.extended_safety_from_sign_id like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_safety_to_sign_id like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';
				}

				$qry_ia = rtrim($qry_ia,'OR ');

				$qry_pa = rtrim($qry_pa,'OR ');

				$qry_sa = rtrim($qry_sa,'OR ');
							
				$qry_ia.=')';
				
				$qry_pa.=')';

				$qry_sa.=')';
			

			if($user_role=='PA')
			$where_condition .= 'j.acceptance_performing_id = "'.$user_id.'" OR '.$qry_pa.' AND ';
			else if($user_role=='IA')
			$where_condition .= '(j.acceptance_issuing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'") OR  '.$qry_ia.' AND ';
			else if($user_role=='SAT')
			$where_condition .= '(j.acceptance_safety_sign_id = "'.$user_id.'")  OR '.$qry_sa.' AND ';
			else
			$where_condition .= '(j.acceptance_performing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'" OR j.acceptance_issuing_id = "'.$user_id.'") OR '.$qry_pa.' OR '.$qry_ia.' OR '.$qry_sa.' AND ' ;


		}

		$subscription_date_start = array_search($user_role.'subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
     	
		
		$subscription_date_end = array_search($user_role.'subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));

		$where_condition.=' DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';		
		
		$where_condition=rtrim($where_condition,'AND ');

		
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
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified',
							16=>'j.acceptance_safety_sign_id'
						);
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->confined_permits_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		#echo $this->db->last_query();  exit;

		$records=$this->confined_permits_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		


		$json=array();
		
		$job_status=unserialize(JOB_STATUS);
		
		if($totalFiltered>0)
		{
			$j=0;
			
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];

				$redirect=base_url().'confined_permits/form/id/'.$id.'/confined_permits/closed_permits/'.$param_url;
				
				
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
				
				$waiating_approval_by=$this->confined_permits_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				
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
				
				$print='- - -';
				
				if($show_button=='hide')
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
		

	public function get_max_permit_id($array_args)
	{
		extract($array_args);
		
			$qry=$this->db->query("SELECT MAX(permit_no_sec)+1 as permit_no FROM ".$this->db->dbprefix.CONFINEDPERMITS." WHERE department_id='".$department_id."'");
			
			#echo $this->db->last_query(); exit;
			$fet=$qry->row_array();	
			
			if($fet['permit_no']=='')
			$fet['permit_no']='1';
			
			if($this->session->userdata('department_name')=='Power Plant')
			$dept='PP';
			else if($this->session->userdata('department_id')==EIP_ELECTRICAL)
			$dept='EI';
			else					
			$dept=substr($this->session->userdata('department_name'),0,2);
						
			return strtoupper('CP-'.$dept.$fet['permit_no']);
			
			#$this->data['permit_no']=strtoupper(substr($this->session->userdata('department_name'),0,2).$fet['permit_no']);
	}

	// get jobs count for issuing authority
	public function ajax_fetch_jobs_count()
	{
		$issuing_authority_id = $this->session->userdata('user_id');

		// waiting jobs
		$waiting_jobs_count = 0; $waiting_jobs_list = array();

		$this->db->select('j.id as job_id,j.job_name,j.approval_status');

		$this->db->from(CONFINEDPERMITS.' j');

		$this->db->join(DEPARTMENTS.' d','d.id = j.department_id','inner');

		$this->db->where('(j.acceptance_issuing_id = "'.$issuing_authority_id.'" OR j.cancellation_issuing_id = "'.$issuing_authority_id.'")');
		
		$this->db->where_in('j.approval_status',array('1','3','5','7'));

		$this->db->order_by('j.id','desc');

		$waiting_jobs_qry = $this->db->get();

		// echo $this->db->last_query(); 
		// echo '<pre>'; print_r($waiting_jobs_qry->result_array());
		// exit;
		if($waiting_jobs_qry->num_rows() > 0)
		{
			$waiting_jobs_result_array = $waiting_jobs_qry->result_array();

			$waiting_jobs_count = $waiting_jobs_qry->num_rows();

			foreach ($waiting_jobs_result_array as $waiting_jobs_result) 
			{
				$waiting_jobs_list[$waiting_jobs_result['job_id']] = strtoupper($waiting_jobs_result['job_name']);
			}
		}	

		// Approved jobs
		$approved_jobs_count = 0; $approved_jobs_list = array();

		$this->db->select('j.id as job_id,j.job_name,j.approval_status,j.read_status');

		$this->db->from(CONFINEDPERMITS.' j');

		$this->db->join(DEPARTMENTS.' d','d.id = j.department_id','inner');

		$this->db->where('(j.acceptance_performing_id = "'.$issuing_authority_id.'" OR j.cancellation_performing_id = "'.$issuing_authority_id.'")');
		
		$this->db->where('j.read_status','0');

		$this->db->where_in('j.approval_status',array('2','4','6','8'));

		$this->db->order_by('j.id','desc');

		$approved_jobs_qry = $this->db->get();

		// echo $this->db->last_query(); 
		// echo '<pre>'; print_r($approved_jobs_qry->result_array());
		// exit;

		$update_data = array();
		if($approved_jobs_qry->num_rows() > 0)
		{
			$approved_jobs_result_array = $approved_jobs_qry->result_array();

			$approved_jobs_count = $approved_jobs_qry->num_rows();

			foreach ($approved_jobs_result_array as $approved_jobs_result) 
			{
				$approved_jobs_list[$approved_jobs_result['job_id']] = strtoupper($approved_jobs_result['job_name']);
				
				$update_data[] = array('id'=>$approved_jobs_result['job_id'],'read_status'=>'1','modified'=>date('Y-m-d H:i'));
			}
		}

			if(count($update_data) > 0)
			$this->db->update_batch(CONFINEDPERMITS,$update_data,'id');
			
		echo json_encode(array('waiting_jobs_count'=>$waiting_jobs_count,'waiting_jobs_list'=>$waiting_jobs_list,'approved_jobs_count'=>$approved_jobs_count,'approved_jobs_list'=>$approved_jobs_list));
	}

	/**********************************************************************************************
	 * Description    :  Fetch & Show Matched jobs history records in Popup
	**********************************************************************************************/	
	
	public function ajax_show_jobs_history()
	{
		
		$id=$this->input->post('id');	
		
		$permit_no=$this->input->post('permit_no');	
		
		$department_id=$this->session->userdata('department_id');
		
		
			$where='job_id = "'.$id.'"';  
			
			$subscription_history=array(
                'select'  =>'sh.id,sh.notes,sh.created,u.first_name',
                'where'=>$where,
                'table1'=>CONFINEDJOBSHISTORY.' sh',
                'table2'=>USERS.' u',
				'join_on'=>'sh.user_id=u.id',
                'join_type'=>'inner',
                'num_rows'=>false,
				'order_by'=>'sh.id',
				'order'=>'desc',
				'length'=>25,
				'start'=>0
            );
			
            $subs_history_qry=$this->public_model->join_fetch_data($subscription_history);
			
			$datas=$subs_history_qry->result_array();
			
				$rows=' <b>Permit Logged History</b><table class="table  custom-table table-striped">
							  <thead>
								  <tr>
                                 	  <th width="150px" class="bg-img-none">Date</th>
									  <th width="250px">Time</th>
                                      <th width="250px">Notes</th>
									  <th width="150px">Updated By</th>
								  </tr>
							  </thead><tbody>';   
					$j=0;
					foreach($datas as $record)
					{
						$created=date(DATE_FORMAT,strtotime($record['created']));
						
						$time=date('H:i A',strtotime($record['created']));
						
						$notes=$record['notes'];
						
						$updated=$record['first_name'];
						
						$rows.='<tr ><td>'.$created.'</td><td>'.$time.'</td><td>'.$notes.'</td><td>'.$updated.'</td></tr>';
						#<td>'.ucfirst($record_type).'</td>
						
						$message=DB_UPDATE;
						
						$return=array('success'=>true,'message'=>$message);
						
						$j++;
					}


		if($rows!='')
		$rows.='</table>';
		else
		$rows='<p  style="text-align:center;color:red;">No Records Found</p>';
		
		echo json_encode(array_merge($return,array('response'=>$rows,'fund_account_information'=>'Permit '.$permit_no.' logged history')));
		
		
		exit;		
	}

	public function get_system_time()
	{

		echo json_encode(array('response'=>date('d-m-Y H:i')));

		exit;
	}
}