<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Excavations.php
 * Project        : Form Work
 * Creation Date  : 07-10-2018
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	


class Excavations extends CI_Controller {

	function __construct()
	{
		parent::__construct(); 
        $this->load->model(array('public_model','security_model','excavations_model','departments_model'));
        $system_current_date = $this->security_model->get_current_date_time();
		$this->security_model->chk_login();        
		$this->data=array('controller'=>$this->router->fetch_class().'/','system_current_date'=>$system_current_date);

	}


	public function index()
	{ 

		redirect($this->data['controller'].'myjobs');

		
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

	public function ajax_fetch_data()
	{
		 
		$job_approval_status=unserialize(EXCAVATION_JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(EXCAVATION_JOBAPPROVALS_COLOR);
	
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');
		
		$zone_id=$this->session->userdata('zone_id');
		
		$user_role=$this->session->userdata('user_role');
		
		$user_id=$this->session->userdata('user_id');
		
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

			$job_status=array(4,5,6);
	
			$job_status="'" . implode("','", $job_status) . "'";
		
			
			$where_condition.=" j.approval_status NOT IN(".$job_status.") AND ";

			$where_condition.=' ((j.acceptance_issuing_id = "'.$user_id.'") OR ';
			
			$where_condition.=' (j.acceptance_performing_id = "'.$user_id.'")  OR ';
			
			$arr = range('a', 'e');
			
			$qry_ia='(';			

			for($i=0;$i<count($arr);$i++)
			{
				$qry_ia.=' j.dept_issuing_id like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR ';
			}

			$where_condition.=rtrim($qry_ia,'OR ').')) AND ';
			
        
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
			  $where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		  }
		  
		
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
							12=>'j.dept_issuing_id',
							13=>'j.dept_approval_status',
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified'
						);
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->excavations_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->excavations_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		#echo $this->db->last_query();  exit;
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
				
				/*if($show_button=='hide') { $show_button='Final Submit'; 
				$redirect=base_url().'jobs/time_form/id/'.$id; }
				else { $show_button='Open';
				 }*/
				
				$redirect=base_url().$this->data['controller'].'form/id/'.$id.'/'.$this->data['controller'].'myjobs/'.$param_url;
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
				$status=$record['status'];
				
				$approval_status=$record['approval_status'];
				
				$time_diff='- - -';
				
				#if(!in_array($approval_status,$job_status))
				#$time_diff=(PERMIT_CLOSE_AFTER - $record['time_diff']).' hrs';
				
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
				
				$waiating_approval_by=$this->excavations_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$permit_no.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$permit_no=$record['permit_no'];
				
				$print='- - -';
				
				if($show_button=='hide')
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';				
				
				$modified=$record['modified'];
				
						$json[$j]['id']='<a href="'.$redirect.'">'.$permit_no.'</a>';
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

		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}	
	
	public function ajax_myjobs_fetch_data()
	{
		 
		$job_approval_status=unserialize(EXCAVATION_JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(EXCAVATION_JOBAPPROVALS_COLOR);
	
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');
		
		$zone_id=$this->session->userdata('zone_id');
		
		$user_role=$this->session->userdata('user_role');
		
		$user_id=$this->session->userdata('user_id');
		
		$where_condition='';

        $user_role = array_search('user_role',$this->uri->segment_array());

        if($user_role !==FALSE && $this->uri->segment($user_role+1))
        {
            $user_role = $this->uri->segment($user_role+1);
			

			if($user_role=='IA')
			$where_condition.=' (j.acceptance_issuing_id = "'.$user_id.'") AND ';
			else if($user_role=='PA')
			$where_condition.=' (j.acceptance_performing_id = "'.$user_id.'")  AND ';
			else
			{

				$arr = range('a', 'e');
				
				$qry_ia='(';			

				for($i=0;$i<count($arr);$i++)
				{
					$qry_ia.=' j.dept_issuing_id like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR ';
				}

				$where_condition=rtrim($qry_ia,'OR ').')';
			}
		}
		
        $zone_id = array_search('zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id ='".$zone_id."' AND ";
		}
		
          $approval_status=array_search('approval_status',$segment_array);	
		  
		  if($approval_status !==FALSE && $this->uri->segment($approval_status+1)!='')
          {
			 	$approval_status=$this->uri->segment($approval_status+1);        
				         
                $where_condition.=" j.approval_status ='".$approval_status."' AND ";
		  }  
		
		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		  }
		  
		
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
							12=>'j.dept_issuing_id',
							13=>'j.dept_approval_status',
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified'
						);
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->excavations_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->excavations_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		#echo $this->db->last_query();  exit;
		$json=array();
		
		$job_status=array(4,5,6);
		
		if($totalFiltered>0)
		{
			$j=0;
			
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];
				
				/*if($show_button=='hide') { $show_button='Final Submit'; 
				$redirect=base_url().'jobs/time_form/id/'.$id; }
				else { $show_button='Open';
				 }*/
				
				$redirect=base_url().$this->data['controller'].'form/id/'.$id.'/'.$this->data['controller'].'myjobs/'.$param_url;
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
				$status=$record['status'];
				
				$approval_status=$record['approval_status'];
				
				$time_diff='- - -';
				
				#if(!in_array($approval_status,$job_status))
				#$time_diff=(PERMIT_CLOSE_AFTER - $record['time_diff']).' hrs';
				
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
				
				$waiating_approval_by=$this->excavations_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$permit_no.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$permit_no=$record['permit_no'];
				
				$print='- - -';
				
				if($show_button=='hide')
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';				
				
				$modified=$record['modified'];
				
						$json[$j]['id']='<a href="'.$redirect.'">'.$permit_no.'</a>';
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

		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
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
		$approval_status='4';
		
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

	public function ajax_fetch_closeddata()
	{
		
		$job_approval_status=unserialize(EXCAVATION_JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(EXCAVATION_JOBAPPROVALS_COLOR);
		 
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
		}
		
/*		if(!in_array($department_id,array(EIP_ELECTRICAL,EIP_INSTRUMENTAL,EIP_TECHNICAL,EIP_MECHANICAL,EIP_SAFETY)))
		$where_condition=" j.department_id = '".$department_id."' AND ";
*/		
		$approval_status = array_search('approval_status',$this->uri->segment_array());
	
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1))
		{
			$approval_status = $this->uri->segment($approval_status+1);
			
			if($approval_status!='')
			{
				if($approval_status==6)
				$approval_status='6,5';
				else
				$approval_status=4;	

				$where_condition.=" j.approval_status IN(".$approval_status.") AND ";
			}
			else
			{
				$where_condition.=" j.approval_status IN(4,6,5) AND ";
			}
		}
		
        $zone_id = array_search('zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id ='".$zone_id."' AND ";
		}
		
        $subscription_date_start = array_search($approval_status.'subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search($approval_status.'subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));

		$where_condition.=' DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';		
		
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
							8=>'j.permit_no',
							9=>'j.approval_status',
							10=>'j.acceptance_performing_id',
							11=>'j.acceptance_issuing_id',		
							12=>'j.dept_issuing_id',
							13=>'j.dept_approval_status',											
							14=>'j.modified'
						);
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->excavations_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->excavations_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		
		#echo $this->db->last_query();  exit;
		
		$json=array();
		
		if($totalFiltered>0)
		{
			$j=0;
			
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				#$show_button=$record['show_button'];

				$redirect=base_url().$this->data['controller'].'form/id/'.$id.'/'.$this->data['controller'].'closed_permits/'.$param_url;
				
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
				$modified=$record['modified'];
				
				$status=$record['status'];

				$approval_status=$record['approval_status'];
				
				if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
				$color=$job_approval_status_color[$job_approval_status[$approval_status]];
				else
				$color='';
				
				#$waiating_approval_by=$this->excavations_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				
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
				
				
				
				
				

						$json[$j]['id']='<a href="'.$redirect.'">'.'#'.$permit_no.'</a>';
						$json[$j]['job_name']=$job_name;
						$json[$j]['auth_PA']=strtoupper($auth_PA);
						$json[$j]['auth_IA']=strtoupper($auth_IA);
						$json[$j]['location']=strtoupper($record['location']);
						$json[$j]['name']=strtoupper($contractor_name);
						$json[$j]['contact_no']=$contact_number;
						$json[$j]['created']=date(DATE_FORMAT,strtotime($created));
						$json[$j]['status']=ucfirst($status);
						$json[$j]['modified']=date(DATE_FORMAT.' H:i A',strtotime($modified));
						#$json[$j]['waiating_approval_by']=$waiating_approval_by;
						
						$j++;
			}
		}

		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}

	public function form()
	{ 

		#echo '<pre>'; print_r($this->session->userdata); exit;
	
		$this->load->helper(array('custom'));
	#echo '<pre>'; print_r($this->session->userdata); exit;
	
	$segment_array=$this->uri->segment_array();

	$param_url=$this->public_model->get_params_url(array('start'=>5,'segment_array'=>$segment_array));	

	#echo '<pre>'; print_r($param_url); exit;

	if($param_url=='')
	$param_url=$this->data['controller'].'/myjobs/';



	$readonly='';
	
	$zone_id=$this->session->userdata('zone_id');
	
	$department_id=$this->session->userdata('department_id');
	
	$user_name=$this->session->userdata('first_name');
	
	$user_id=$this->session->userdata('user_id');
	
	$authorities=$job_isolations_where=$job_status_error_msg='';
	
	#echo $this->db->last_query(); exit;
	$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
	
	$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
	
	$this->data['isoloation_permit_no']='';

        $update = array_search('id',$this->uri->segment_array());
        $id='';
       
        if($update !==FALSE && $this->uri->segment($update+1))
        {      	

            $id = $this->uri->segment($update+1);

            $req=array(
              'select'  =>'*,TIMESTAMPDIFF(HOUR, modified, "'.date('Y-m-d H:i').'") as time_diff',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>EXCAVATIONPERMITS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{
                $records=$qry->row_array();
				
				$this->data['records']=$records;
				
				$department_id = $records['department_id'];		

			    $where=" id = '".$department_id."'";
				//Getting Active Companys List
			    $qry=$this->public_model->get_data(array('select'=>'id,name','where_condition'=>$where,'table'=>DEPARTMENTS));		
				
			    $dept=$qry->row_array();

			    $this->data['department']['name'] = $dept['name'];
		
			    $this->data['department']['id'] = $dept['id'];				
								
				$show_button=$records['show_button'];
				
				if($show_button=='hide')
				$readonly=true;
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

        		redirect('excavations/myjobs');	
			}			
		}
		
		//department_id IN('".EIP_ELECTRICAL."','".EIP_INSTRUMENTAL."','".EIP_TECHNICAL."','".EIP_MECHANICAL."','".EIP_SAFETY."','".EIP_CIVIL."') AND 
	 	$where="user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
				//Getting Active Companys List
		$qry=$this->public_model->get_data(array('select'=>'id,first_name,is_safety,department_id','where_condition'=>$where,'table'=>USERS));
			
			
		$authorities=$qry->result_array();
				
		$this->data['authorities']=$authorities;
		
		$this->data['user_id']=$this->session->userdata('user_id');
		
		$this->data['readonly']=$readonly;
		
		$this->data['job_status_error_msg']=$job_status_error_msg;
		
		$this->data['param_url']=$param_url;
		
		$this->load->view($this->data['controller'].'form',$this->data);
	}	
	
	public function form_action()
	{
		#echo '<pre>';print_r($this->input->post()); exit;
		
		$user_name=$this->session->userdata('first_name');

		$_POST['last_updated_by']=$user_name;
		
		$user_id=$this->session->userdata('user_id');
		
		$approval_status=unserialize(EXCAVATION_JOBAPPROVALS);
		
		$array_fields=array('issuing_authority_approval_status','precautions','issuing_authority','dept_issuing_date','dept_issuing_id','m_depth','dept_approval_status','dept_remarks');
		
		$skip_fields=array('id','submit','is_popup_submit','isoloation_permit_no');
		
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
				
				#substr($this->session->userdata('department_name'),0,2).$fet['permit_no']
			
				$_POST['approval_status']=1;	//Waiting IA Acceptance
				
				$_POST['status']=STATUS_PENDING;

				$is_send_sms=YES;

				$sender=$_POST['acceptance_performing_id'];

				$receiver=implode($_POST['dept_issuing_id'],',').','.$_POST['acceptance_issuing_id'];

				$msg_type=PATOIA_WAITING_APPROVAL;	
		}	
		else
		{

			$job_id = $this->input->post('id');

			$job_qry=$this->public_model->get_data(array('select'=>'id,last_modified_id,last_updated_by','where_condition'=>'id ="'.$job_id.'"','table'=>EXCAVATIONPERMITS));

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


			if($_POST['acceptance_performing_id']!=$user_id)					
			{

				if($_POST['acceptance_issuing_id']==$user_id)	// For IA Approval
				{
					$_POST['approval_status']=4;
								
					$_POST['acceptance_issuing_date'] = $this->data['system_current_date'];

					$_POST['status']='Completion';

					$print_out=1;

					$msg='<b>'.$user_name.'(IA) approved this job</b>';

					$is_send_sms=YES;

					$msg_type=IATOPA_APPROVAL;

					$sender=$_POST['acceptance_issuing_id'];			

					$receiver=$_POST['acceptance_performing_id'];	
				}
				else
				{
					$range=range('a','e');

					$i=0;

					for($l=0;$l<count($range);$l++)			//Department Clearance
					{
						if($_POST['dept_issuing_id'][$range[$l]]==$user_id && $_POST['dept_approval_status'][$range[$l]]!='Yes')
						{
							$_POST['dept_issuing_date'][$range[$l]] = $this->data['system_current_date'];

							$_POST['dept_approval_status'][$range[$l]]='Yes';

							$msg='<b>'.$user_name.'(Dept Clearance) approved this job</b>';			

							$print_out=1;		

							$is_send_sms=YES;

							$msg_type=IATOPA_APPROVAL;

							$sender=$user_id;			

							$receiver=$_POST['acceptance_performing_id'];			
						}	

						if($_POST['dept_approval_status'][$range[$l]]=='Yes')
						$i++;
					}	

					if($i==count($range))		//If all department users are approved
					{
						$_POST['approval_status']=3;

						$msg.='Department clearance is completed. Waiting for IA approval</b>';

						$print_out=1;

						$is_send_sms=YES;

						$msg_type=DEPT_TO_PA;

						$sender=$user_id;			

						$receiver=$_POST['acceptance_performing_id'].','.$_POST['acceptance_issuing_id'];	
					}
				}
			}
			
		}
		


		$_POST['last_modified_id']=rand(time(),5);


		$self_cancellation_description = isset($_POST['self_cancellation_description'])  ? trim($_POST['self_cancellation_description']) : '';

		if(!empty($self_cancellation_description) && strtolower($status)!='cancellation')
		{
			$_POST['approval_status'] = 6;

			$_POST['status'] = 'Cancellation';

			$msg='<b>Self Cancelled</b> by PA';	

			$is_send_sms=YES;

			$msg_type=PATOIA_SELF_CANCELLED;

			$sender=$user_id;

			$receiver=implode($_POST['dept_issuing_id'],',').','.$_POST['acceptance_issuing_id'];
		}
		
		#echo '<br /> MSg : '.$msg.' - '.$show_button.' - '.$status.' - '.$user_id;
		
		#echo '<pre>'; print_r($_POST); exit;
		
		$inputs=$this->input->post();
		
		$id=($this->input->post('id')) ? $this->input->post('id') : '';
		
		if($id!='')
		{
			$permit_no=$_POST['permit_no'];

			unset($_POST['permit_no']);

			unset($_POST['department_id']);
		}
		else
			$_POST['permit_no']=$permit_no=$this->get_max_permit_id(array('department_id'=>$_POST['department_id']));

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
		
		$update.="modified = '".date('Y-m-d H:i')."'";
		
		$update=rtrim($update,',');
		
		$fields.='user_id,created,modified';
		
		$fields_values.='"'.$user_id.'","'.date('Y-m-d H:i').'","'.date('Y-m-d H:i').'"';
		
		$id=($this->input->post('id')) ? $this->input->post('id') : '';

		#echo $update; exit;
		
		if(!$id)
		{
			$ins="INSERT INTO ".$this->db->dbprefix.EXCAVATIONPERMITS." (".$fields.") VALUES (".$fields_values.")";
		
			$this->db->query($ins);
			
			$id=$this->db->insert_id();
			
			$msg='<b>Created by '.$user_name.' and sent request to IA</b>';
			
		}
		else
		{
			$up="UPDATE ".$this->db->dbprefix.EXCAVATIONPERMITS." SET ".$update." WHERE id='".$id."'";
			
			$this->db->query($up);
		}	

		if($msg=='')
		$msg=$user_name.' has updated his job information';
			
		$array=array('user_id'=>$user_id,'job_id'=>$id,'notes'=>$msg,'created'=>$this->data['system_current_date']);
			
		$this->db->insert(EXCAVATIONPERMITSHISTORY,$array);


		$_POST['permit_no']=$permit_no;

		$additional_text='. Job Desc : '.strtoupper($this->input->post('job_name'));
		
		if($is_send_sms!='')
		$this->public_model->send_sms(array('additional_text'=>$additional_text,'sender'=>$sender,'receiver'=>$receiver,'msg_type'=>$msg_type,'permit_type'=>'UTP Permit','permit_no'=>$_POST['permit_no']));

        $this->session->set_flashdata('success',DB_UPDATE);    		
		
		$ret=array('status'=>true,'print_out'=>$print_out);		                   
      
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
	
	public function ajax_show_jobs_history()
	{
		
		$id=$this->input->post('id');	
		
		$permit_no=$this->input->post('permit_no');	
		
		$department_id=$this->session->userdata('department_id');
		
		
			$where='job_id = "'.$id.'"';  
			
			$subscription_history=array(
                'select'  =>'sh.id,sh.notes,sh.created,u.first_name',
                'where'=>$where,
                'table1'=>EXCAVATIONPERMITSHISTORY.' sh',
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
	
	public function printout()
	{ 
	
	#echo '<pre>'; print_r($this->session->userdata); exit;
	
	$readonly='';
	
	$zone_id=$this->session->userdata('zone_id');
	
	$department_id=$this->session->userdata('department_id');
	
	$user_name=$this->session->userdata('first_name');
	
	$user_id=$this->session->userdata('user_id');
	
	$authorities=$job_isolations_where=$job_status_error_msg='';
	
	$this->data['department']['name'] = $this->session->userdata('department_name');
	
	$this->data['department']['id'] = $this->session->userdata('department_id');
	
	#echo $this->db->last_query(); exit;
	$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
	
	$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
	
        $id = $this->input->post('id');
		
        #$id=3;
		
		
        if($id!='')
        {
            $req=array(
              'select'  =>'*,TIMESTAMPDIFF(HOUR, modified, "'.date('Y-m-d H:i').'") as time_diff',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>EXCAVATIONPERMITS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{
                $records=$qry->row_array();
				
				$this->data['records']=$records;				

				$department_id = $records['department_id'];		

			    $where=" id = '".$department_id."'";
				//Getting Active Companys List
			    $qry=$this->public_model->get_data(array('select'=>'id,name','where_condition'=>$where,'table'=>DEPARTMENTS));		
				
			    $dept=$qry->row_array();

			    $this->data['department']['name'] = $dept['name'];
		
			    $this->data['department']['id'] = $dept['id'];					
				
				$msg=$user_name.' print job information';
				
				$array=array('notes'=>$msg,'created'=>date('Y-m-d H:i'),'user_id'=>$user_id,'job_id'=>$id);
				
				$this->db->insert(EXCAVATIONPERMITSHISTORY,$array);
				
				
            }   
        }

		//department_id IN('".EIP_ELECTRICAL."','".EIP_INSTRUMENTAL."','".EIP_TECHNICAL."','".EIP_MECHANICAL."','".EIP_SAFETY."','".EIP_CIVIL."') AND 
	 	$where="user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
				//Getting Active Companys List
		$qry=$this->public_model->get_data(array('select'=>'id,first_name,is_safety,department_id','where_condition'=>$where,'table'=>USERS));

		$authorities=$qry->result_array();

		$this->data['authorities'] = $authorities;			
			
		$this->data['user_id']=$this->session->userdata('user_id');
		
		$this->load->view($this->data['controller'].'printout',$this->data);
	}	

	public function get_max_permit_id($array_args)
	{
			extract($array_args);
		
			$qry=$this->db->query("SELECT MAX(permit_no_sec)+1 as permit_no FROM ".$this->db->dbprefix.EXCAVATIONPERMITS." order by id desc limit 1");
			
			#echo $this->db->last_query(); exit;
			$fet=$qry->row_array();	
			
			if($fet['permit_no']=='')
			$fet['permit_no']='1';
			
			return strtoupper('EX-'.substr($this->session->userdata('department_name'),0,2).$fet['permit_no']);
			
			#$this->data['permit_no']=strtoupper(substr($this->session->userdata('department_name'),0,2).$fet['permit_no']);
	}
	
}