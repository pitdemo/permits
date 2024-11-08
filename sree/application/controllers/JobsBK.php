<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Jobs.php
 * Project        : Form Work
 * Creation Date  : 08-14-2016
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	


class Jobs extends CI_Controller {

	function __construct()
	{
		parent::__construct(); 

        $this->load->model(array('public_model','security_model','jobs_model','departments_model','jobs_isolations_model'));
        
        if(!in_array($this->router->fetch_method(),array('printout','ajax_show_jobs_history')))
		$this->security_model->chk_login();        
	
		$this->data=array('controller'=>$this->router->fetch_class().'/');

		
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
			
		$arr = range('a', 'f');
		
		$qry='('; 
			
		$qry2='(';

			for($i=0;$i<count($arr);$i++)
			{
				$qry.=' (j.issuing_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';
				
				$qry2.=' (j.performing_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';
			}

			$qry=rtrim($qry,'OR ');				
			$qry.='))';
			$qry2=rtrim($qry2,'OR ');
			$qry2.='))';

		
		$where_condition.=' (((j.acceptance_issuing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'") OR '.$qry.' OR ';
		
		$where_condition.=' ((j.acceptance_performing_id = "'.$user_id.'" OR j.cancellation_performing_id = "'.$user_id.'") OR '.$qry2.') AND ';
		
		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		  }
		  
		  $where_condition .= "j.approval_status NOT IN (4,6,10)";
		
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
							13=>'j.issuing_authority',
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified',
							16=>'j.is_rejected',
							17=>'j.is_draft',
							18=>'j.draft_user_id'
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
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];
				
				$redirect=base_url().'jobs/form/id/'.$id.'/jobs/show_all/'.$param_url;
				
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
		//Electrical Permits
		$this->load->model(array('electrical_model'));

		$where_condition='';

		$where_condition.=' (((j.acceptance_issuing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'") OR '.$qry.' OR ';
		
		$where_condition.=' ((j.acceptance_performing_id = "'.$user_id.'" OR j.cancellation_performing_id = "'.$user_id.'") OR '.$qry2.') AND ';

		if($search_value!='')
		{
			$where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		}

		unset($fields[16]);//Is Reject

		$where_condition .= "j.approval_status NOT IN (4,6,10)";

		$where_condition=rtrim($where_condition,'AND ');

		$totalFiltered=$this->electrical_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->electrical_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();		
		
		#echo '<br /> Query : '.$this->db->last_query();  

		$job_status=unserialize(JOB_STATUS);
		
		if($totalFiltered>0)
		{	
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];				
			
				$redirect=base_url().'electrical_permits/form/id/'.$id.'/jobs/show_all/'.$param_url;
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
				$status=$record['status'];
				
				$approval_status=$record['approval_status'];
				
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
				
				$waiating_approval_by=$this->electrical_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
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

		$total_records=$total_records+$totalFiltered;

		//Confined Permits
		$job_approval_status=unserialize(CONFINED_JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(CONFINED_JOBAPPROVALS_COLOR);

		$user_role='all';

		$where_condition='';

			$arr = range('a', 'f');
			
			$qry_pa=''; //{"a":"15","b":"","c":"","d":"","e":"","f":""} Need to change in reports controller
			
			$qry_ia='';

			$qry_sa='';

				for($i=0;$i<count($arr);$i++)
				{
					$qry_ia.=' j.extended_issuing_from_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_issuing_to_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR ';
					
					$qry_pa.=' j.extended_performing_from_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_performing_to_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR ';

					$qry_sa.=' j.extended_safety_from_sign_id like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR j.extended_safety_to_sign_id like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR ';
				}

				$qry_ia = rtrim($qry_ia,'OR ');

				$qry_pa = rtrim($qry_pa,'OR ');

				$qry_sa = rtrim($qry_sa,'OR ');
							
				#$qry_ia.=')';
				
				#$qry_pa.=')';

				#$qry_sa.=')';

		$where_condition .= '(j.acceptance_performing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'" OR j.acceptance_issuing_id = "'.$user_id.'" OR '.$qry_pa.' OR '.$qry_ia.' OR '.$qry_sa.') AND ' ;		

		$search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		if($search_value!='')
		{
			$where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no like '%".$search_value."%') AND ";
		}

		$where_condition.=" j.approval_status NOT IN(6,8,13)";

		$where_condition=rtrim($where_condition,'AND ');

		#echo $where_condition; exit;

		$this->load->model(array('confined_permits_model'));

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

		$totalFiltered=$this->confined_permits_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));

		$records=$this->confined_permits_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
	
		#echo '<br /> Query : '.$this->db->last_query();  


		$job_status=unserialize(JOB_STATUS);
		
		if($totalFiltered>0)
		{		
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];

				$redirect=base_url().'confined_permits/form/id/'.$id.'/jobs/show_all/'.$param_url;				
				
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

		$total_records=$total_records+$totalFiltered;

		//UTP
		$job_approval_status=unserialize(JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);

		$where_condition='';

		$where_condition.=' ((j.acceptance_issuing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'") OR ';
		
		$where_condition.=' (j.acceptance_performing_id = "'.$user_id.'" OR j.cancellation_performing_id = "'.$user_id.'"))  AND ';
		
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
							12=>'j.cancellation_issuing_id',	
							13=>'j.issuing_authority',						
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified'
						);

		
		$where_condition .= "j.approval_status NOT IN (4,6,10)";

		$where_condition=rtrim($where_condition,'AND ');

		$this->load->model(array('utpumps_model'));

		$totalFiltered=$this->utpumps_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->utpumps_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		#echo '<br /> Query : '.$this->db->last_query();  
		
		$job_status=unserialize(JOB_STATUS);
		
		if($totalFiltered>0)
		{				
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];	
				
				$redirect=base_url().'utpumps/form/id/'.$id.'/jobs/show_all/'.$param_url;
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
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
				
				$waiating_approval_by=$this->utpumps_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
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

		$total_records=$total_records+$totalFiltered;

		$where_condition='';

		$job_approval_status=unserialize(EXCAVATION_JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(EXCAVATION_JOBAPPROVALS_COLOR);

		
			$where_condition.=' (j.acceptance_issuing_id = "'.$user_id.'" OR ';
			
			$where_condition.=' j.acceptance_performing_id = "'.$user_id.'" OR  ';
			
			$arr = range('a', 'e');
			
			$qry_ia='j.approval_status NOT IN(4,6) AND (';			

			for($i=0;$i<count($arr);$i++)
			{
				$qry_ia.=' j.dept_issuing_id like \'%"'.$arr[$i].'":"'.$user_id.'"%\' OR ';
			}

			$where_condition=rtrim($qry_ia,'OR ').') AND ';
			
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

		 //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		  }

		$this->load->model(array('excavations_model'));

		$where_condition=rtrim($where_condition,'AND ');

		$totalFiltered=$this->excavations_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->excavations_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();

		#echo '<br /> Query : '.$this->db->last_query();  
	
		$job_status=array(4,5,6);
		
		if($totalFiltered>0)
		{				
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];				
				
				$redirect=base_url().'excavations/form/id/'.$id.'/jobs/show_all/'.$param_url;
				
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

		$total_records=$total_records+$totalFiltered;

		$json=json_encode($json);
							
		$return='{"total":'.intval( $total_records ).',"recordsFiltered":'.intval( $total_records ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}

	public function index()
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
          $approval_status=array_search('approval_status',$segment_array);	
		  
		  if($approval_status !==FALSE && $this->uri->segment($approval_status+1)!='')
          {
			 	$approval_status=$this->uri->segment($approval_status+1);        
				         
                $params_url.='/approval_status/'.$approval_status;
		  }  
		  else
		  $approval_status='';
		  

			$this->data['filters']['zone_id']=$zone_id;
			
			$this->data['filters']['approval_status']=$approval_status;

			$this->data['params_url']=$params_url;
			
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
	
	
	public function ajax_fetch_data()
	{
		
		 $job_approval_status=unserialize(JOBAPPROVALS);
		 
		 $job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');
		
		$zone_id=$this->session->userdata('zone_id');

		$user_id=$this->session->userdata('user_id');
		
		$where_condition='';

        $show_button = array_search('show_button',$this->uri->segment_array());

        if($show_button !==FALSE && $this->uri->segment($show_button+1))
        {
            $show_button = $this->uri->segment($show_button+1);
			
			if($show_button=='hide')
			$param_url='jobs/day_in_process/'.$param_url;
			else
			$param_url='jobs/index/'.$param_url;
		}
		
		if(!in_array($department_id,array(EIP_CIVIL,EIP_TECHNICAL)))
		$where_condition=" j.department_id = '".$department_id."' AND ";
		else
		$where_condition=" j.department_id IN('".EIP_CIVIL."','".EIP_TECHNICAL."') AND ";	
		
		$where_condition.=' j.show_button = "'.$show_button.'" AND '; 
		
			$job_status=unserialize(JOB_STATUS);
	
			$job_status="'" . implode("','", $job_status) . "'";
		
		if($show_button=='hide')
		$where_condition.=" j.approval_status NOT IN(".$job_status.") AND ";
		
		$approval_status = array_search('approval_status',$this->uri->segment_array());
	
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1))
		{
			$approval_status = $this->uri->segment($approval_status+1);
			
			if($approval_status!='')
			{
				if($approval_status==11)
				$where_condition.="j.is_rejected='".YES."' AND ";
				else	
				$where_condition.=" j.approval_status IN(".$approval_status.") AND ";
			}
		}
		
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
							13=>'j.issuing_authority',
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified',
							16=>'j.is_rejected',
							17=>'j.is_draft',
							18=>'j.draft_user_id'
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
		
		$job_status=unserialize(JOB_STATUS);
		
		if($totalFiltered>0)
		{
			$j=0;
			
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];
				
				$show_button=$record['show_button'];

				$redirect=base_url().'jobs/form/id/'.$id.'/'.$param_url;
				
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
				$modified=$record['modified'];
				
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
				
				$print='- - -';
				
				if($show_button=='hide')
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';		

				$cl='';

				if($user_id==$record['draft_user_id'])
					$cl='red';
				
						$json[$j]['id']='<a href="'.$redirect.'" style="color:'.$cl.'">#'.$permit_no.'</a>';		
				
						#$json[$j]['id']='<a href="'.$redirect.'">'.'#'.$permit_no.'</a>';
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
	
	
	public function ajax_myjobs_fetch_data()
	{
		 
		$job_approval_status=unserialize(JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);
		 
		# echo '<pre>'; print_r($job_approval_status_color);
		 
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
			
			$arr = range('a', 'f');
			
			$qry='('; //{"a":"15","b":"","c":"","d":"","e":"","f":""} Need to change in reports controller
			
			$qry2='(';
				for($i=0;$i<count($arr);$i++)
				{
					$qry.=' (j.issuing_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';
					
					$qry2.=' (j.performing_authority like \'%"'.$arr[$i].'":"'.$user_id.'"%\') OR ';
				}
				$qry=rtrim($qry,'OR ');				
				$qry.='))';
				$qry2=rtrim($qry2,'OR ');
				$qry2.='))';
			if($user_role=='IA')
			$where_condition.=' ((j.acceptance_issuing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'") OR '.$qry.' AND ';
			else
			$where_condition.=' ((j.acceptance_performing_id = "'.$user_id.'" OR j.cancellation_performing_id = "'.$user_id.'") OR '.$qry2.' AND ';
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
				
				if($approval_status==11)
					$where_condition.=" j.is_rejected='".YES."' AND ";
				else	         
                	$where_condition.=" j.approval_status ='".$approval_status."' AND ";
		  }  
		
		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		  }
		  
		  $where_condition .= "j.approval_status NOT IN (4,6,10)";
		
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
							13=>'j.issuing_authority',
							14=>'TIMESTAMPDIFF(HOUR, j.modified, "'.date('Y-m-d H:i').'") as time_diff',
							15=>'j.modified',
							16=>'j.is_rejected',
							17=>'j.is_draft',
							18=>'j.draft_user_id'
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
				
				$redirect=base_url().'jobs/form/id/'.$id.'/jobs/myjobs/'.$param_url;
				
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
				
				
						#$json[$j]['id']='<a href="'.$redirect.'">'.$permit_no.'</a>';
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
	

	public function form()
	{ 
		//If you change please apply the changes in reports controller
	
		#echo '<pre>'; print_r($this->session->userdata); exit;
	
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>5,'segment_array'=>$segment_array));	
		
		$readonly='';
		
		$zone_id=$this->session->userdata('zone_id');
		
		$department_id=$this->session->userdata('department_id');
		
		$user_name=$this->session->userdata('first_name');
		
		$user_id=$this->session->userdata('user_id');
		
		$authorities=$job_isolations_where=$job_status_error_msg='';
		
		$this->data['department']['name'] = $this->session->userdata('department_name');
		
		$this->data['department']['id'] = $this->session->userdata('department_id');
		
		#echo $this->db->last_query(); exit;
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'));
		
		$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();
		
		$this->data['isoloation_permit_no']='';				
	
        $update = array_search('id',$this->uri->segment_array());
        $id=$dept='';
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

				$dept="'".$department_id."',";
				
				$isolation_relations=$this->public_model->join_fetch_data(array('select'=>'i.approval_status,ir.jobs_isoloations_id','table1'=>JOBSISOLATION.' i','table2'=>JOBSISOLATIONRELATIONS.' ir','join_on'=>'ir.jobs_isoloations_id=i.id','join_type'=>'inner','where'=>'ir.job_id = "'.$id.'" AND relation_type="'.JOBS.'"','num_rows'=>false));
				
				$this->data['isoloation_permit_no']=$isolation_relations;
				
			  if($isolation_relations->num_rows()>0)
			  {
				  $fets_permits=$isolation_relations->result_array();
					  
				  $jobs_isoloations_ids=array_column($fets_permits,'jobs_isoloations_id');
				  
				  #echo '<pre>'; print_r($jobs_isoloations_ids); exit;
				  
				  $jobs_isoloations_id="'" . implode("','", $jobs_isoloations_ids) . "'";
				  
				
				  
				  if($records['approval_status']==1 && $records['acceptance_issuing_id']==$user_id)
				  {
					  $req=array('select'=>'id','table'=>JOBSISOLATION,'where_condition'=>"id IN(".$jobs_isoloations_id.") AND approval_status>=6");
					  
					  $check_jobs_isolation_status=$this->public_model->get_data($req);
					  
					  #echo $this->db->last_query(); exit;
					  
					  $check_jobs_isolation_status_num=$check_jobs_isolation_status->num_rows();
					  
					 # echo 'SS '.count($jobs_isoloations_ids).' != '.$check_jobs_isolation_status_num; exit;
					  
					  if(count($jobs_isoloations_ids)!=$check_jobs_isolation_status_num)
					  {
						 $job_status_error_msg='<a href="'.base_url().'jobs_isolations/index/user_role/All/" target="_blank">'.(count($jobs_isoloations_ids)-$check_jobs_isolation_status_num).'</a> number of EIPs are not final submitted by PA';			
					  }
				  }
				  
				  $job_isolations_where=' OR (id IN('.$jobs_isoloations_id.'))';
			  }		
				
				
				$show_button=$records['show_button'];
				
				 if($show_button=='hide')
				 $readonly=true;
				
				if($records['is_draft']==YES)
				{
					$job_status_error_msg='Please note this job is in draft mode. Last updated by '.$records['last_updated_by'];
				}
				
            }   

            $this->data['eips'] = $this->public_model->get_data(array('select'=>'id,section,status,eip_no','where_condition'=>' (status = "'.STATUS_OPENED.'"  AND zone_id = "'.$records['zone_id'].'" AND DATE(date_end)>=DATE(NOW())) '.$job_isolations_where,'table'=>JOBSISOLATION));
		#echo $this->db->last_query(); exit;status = "'.STATUS_OPENED.'"  AND AND DATE(date_end)>=DATE(NOW())
        }
		else
		{	
			if($this->session->userdata('permission')==WRITE)
			{	
				$this->load->model(array('cron_job_model'));

				$where=' AND id ="'.$this->session->userdata('user_id').'"';

				#$this->cron_job_model->check_expired_permits(array('where'=>$where,'type'=>'single'));

				$this->data['permit_no']=$this->get_max_permit_id(array('department_id'=>$department_id));
			}
			else
			{
				$this->session->set_flashdata('failure',PERMISSION_MSG);

        		redirect('jobs/show_all');
			}
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

		$st='';

		if($id=='')
			$st=" AND status='".STATUS_ACTIVE."'";

		$this->data['sops'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>'department_id = "'.$department_id.'" AND record_type="'.SOPS.'" '.$st,'table'=>SOPS));

		$this->data['wis'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>'department_id = "'.$department_id.'" AND record_type="'.WORK_INSTRUCTIONS.'"'.$st,'table'=>SOPS));

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
	
	$this->data['departments'] = $this->departments_model->get_details(array('fields'=>'d.name,d.id,d.status','conditions'=>'d.status= "'.STATUS_ACTIVE.'"'));
	
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
				
				$permits = $this->public_model->join_fetch_data(array('table1'=>JOBS.' j','select'=>'j.id,j.permit_no','where'=>'jir.jobs_isoloations_id="'.$id.'"','table2'=>JOBSISOLATIONRELATIONS.' jir','join_on'=>'j.id=jir.job_id','join_type'=>'inner','num_rows'=>false));	
				if($permits->num_rows()>0)
				{
					$fet_permits=$permits->result_array();	
					
					$this->data['records']['work_permit_nos']=implode(',',array_column($fet_permits,'permit_no'));
				}
            }   
        }
		else
		{			
			$this->data['sl_no']=$this->public_model->get_max_eip_no();
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
		
		$department_id="'".EIP_PRODUCTION."','".EIP_PACKING_OPERATION."','".EIP_MINES."','".EIP_CIVIL."'";
		
	    $where="(department_id IN(".$department_id.") ";

	    if(IA_USERS!='')
 		    $where.=' OR id IN('.IA_USERS.')';

		$where.=") AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
		//Getting Active Companys List
	    $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role,department_id','where_condition'=>$where,'table'=>USERS,'column'=>'first_name','dir'=>'asc'));
		
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
              'table'    =>JOBS,
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
		#echo '<pre>';print_r($this->input->post()); exit;

		
		$submit_type=$this->input->post('submit_type');

		$user_name=$this->session->userdata('first_name');

		$_POST['last_updated_by']=$user_name;
		
		$user_id=$this->session->userdata('user_id');
		
		$approval_status=unserialize(JOBAPPROVALS);
		
		$array_fields=array('precautions_text','issuing_authority_approval_status','precautions_options','hazards_options','precautions','hazards','issuing_authority','no_of_persons','performing_authority','schedule_from_time','schedule_to_time','schedule_date','reference_code','extended_contractors_id','extended_others_contractors_id','hot_work_checklists','height_work_checklists','completion_checklist','extended_scaffolding_certification_no','extend_issuing_authority_name_of_ia');
		
		$skip_fields=array('id','submit','is_popup_submit','isoloation_permit_no','modified','submit_type');
		
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

		if(!$this->input->post('id'))	//If new jobs create
		{
				$_POST['permit_no']=$this->get_max_permit_id(array('department_id'=>$_POST['department_id']));
				
				$_POST['acceptance_performing_date']=date('d-m-Y H:i');	
				
				$_POST['permit_no_sec']=preg_replace("/[^0-9,.]/", "", $_POST['permit_no']);				
						
				$_POST['approval_status']=1;	//Waiting IA Acceptance
				
				$_POST['status']=STATUS_PENDING;

				$is_send_sms=YES;

				$sender=$_POST['acceptance_performing_id'];

				$receiver=$_POST['acceptance_issuing_id'];

				$msg_type=PATOIA_WAITING_APPROVAL;				
		}	
		else
		{
			$show_button=($_POST['show_button']) ? trim($_POST['show_button']) : '';

			$job_id = $this->input->post('id');

			$job_qry=$this->public_model->get_data(array('select'=>'id,acceptance_issuing_id,cancellation_issuing_id,approval_status,status,last_updated_by,last_modified_id','where_condition'=>'id ="'.$job_id.'"','table'=>JOBS));

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


			if($show_button!='reject')
			{
				if($show_button=='hide')	//After IA approve we got this When PA submit his job
				{		
					$_POST['status']=STATUS_OPENED;		
					
					$_POST['final_status_date']=date('Y-m-d H:i');
					
					$print_out=1;
					
					$msg='<b>PA moved his job to Day End Process</b>';
				}
				else if($show_button=='approveIA') //IA approve his job
				{				
					
					if($job_result['approval_status'] == 1 && $user_id != $job_result['acceptance_issuing_id'])
					{
						$this->session->set_flashdata('failure','Issuing authority changed!');    

						$ret=array('status'=>true,'print_out'=>'');
						  
						echo json_encode($ret);
						
						exit;
					}

					if($submit_type!='draft')
					{	
						$_POST['approval_status']=2;		
						
						$_POST['acceptance_issuing_approval']='Yes';
						
						$_POST['acceptance_issuing_date']=date('Y-m-d H:i');					

						$msg='<b>IA '.$user_name.' approved this job</b>';		

						$print_out=1;		
					}
						
					$is_send_sms=YES;

					$msg_type=IATOPA_APPROVAL;

					$sender=$_POST['acceptance_issuing_id'];			

					$receiver=$_POST['acceptance_performing_id'];				

					unset($_POST['show_button']);
				}
				
				
				
				if($status!='' && !in_array($show_button,array('hide','reject')))
				{
					unset($_POST['show_button']);
					
					if(in_array(strtolower($status),array('cancellation','completion')))
					{
						if($user_id==$this->input->post('cancellation_performing_id'))
						{
								if(strtolower($status)=='cancellation')
								{
									$_POST['approval_status']=5;
									
									$_POST['cancellation_performing_date'] = date('d-m-Y H:i:s');

									$is_send_sms=YES;

									$msg_type=PATOIA_WAITING_CANCEL_REQUEST;

									$sender=$user_id;

									$receiver=$_POST['cancellation_issuing_id'];
								}
								else if(strtolower($status)=='completion')
								{
									$_POST['approval_status']=3;
									
									$_POST['cancellation_performing_date'] = date('d-m-Y H:i:s');

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
									if($submit_type!='draft')
									{
										$_POST['approval_status']=6;
										
										$_POST['cancellation_issuing_date'] = date('d-m-Y H:i:s');
									}	
									$is_send_sms=YES;

									$msg_type=IATOPA_CANCEL_APPROVAL;

									$sender=$user_id;

									$receiver=$_POST['cancellation_performing_id'];									
								}
								else if(strtolower($status)=='completion')
								{
									if($submit_type!='draft')
									{
										$_POST['approval_status']=4;
										
										$_POST['cancellation_issuing_date'] = date('d-m-Y H:i:s');
									}
										
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
							$issuing_authority_approval_status=$_POST['issuing_authority_approval_status'][$range[$l]];
							
							$schedule_date=$_POST['schedule_date'][$range[$l]];	
							
							$performing_authority=$_POST['performing_authority'][$range[$l]];	
							
							$issuing_authority=$_POST['issuing_authority'][$range[$l]];
							
							if($user_id==$performing_authority)
							{
								if($schedule_date!='' && $issuing_authority_approval_status=='' && $submit_type!='draft')
								{
									$_POST['issuing_authority_approval_status'][$range[$l]]='Waiting';
									
									$_POST['approval_status']=7;
									
									$msg='<b>'.ucfirst($status).' request sent to IA</b>';	

									$is_send_sms=YES;

									$msg_type=PATOIA_WAITING_EXTEND_APPROVAL;

									$sender=$user_id;

									$receiver=$issuing_authority;		
									
									break;
								}
							}
							else if($user_id==$issuing_authority)
							{
								#echo '<br /> SC '.$schedule_date.' - '.$issuing_authority_approval_status.' = '.$range[$l];
								if($schedule_date!='' && $issuing_authority_approval_status=='Waiting'  && $submit_type!='draft')
								{

									#echo 'Yessss';
									$_POST['issuing_authority_approval_status'][$range[$l]]='Approved';
									
									$_POST['approval_status']=8;
									
									$msg='<b>'.ucfirst($status).' approval sent to PA</b>';	

									$is_send_sms=YES;

									$msg_type=IATOPA_ACCEPT_EXTEND_APPROVAL;

									$sender=$user_id;

									$receiver=$performing_authority;										
									
									break;
								}
							}
							
							
						}

						#echo '<pre>'; print_r($_POST); exit;
						
					}
					
				}
			}
			else
			{
				$_POST['is_rejected']=YES;

				unset($_POST['show_button']);

				$msg='IA has <b>rejected</b> PA request';
			}	
		}
		
		$_POST['is_draft']=NO;

		$_POST['draft_user_id']='';

		if($submit_type=='draft')
		{
			$_POST['is_draft']=YES;

			$_POST['draft_user_id']=$user_id;
		}

		#echo $msg_type; exit;
		$self_cancellation_description = isset($_POST['self_cancellation_description'])  ? trim($_POST['self_cancellation_description']) : '';

		if(!empty($self_cancellation_description) && strtolower($status)!='cancellation' && $show_button!='reject' && $_POST['is_draft']==NO)
		{
			$_POST['approval_status'] = 10;

			$_POST['status'] = 'Cancellation';

			$is_send_sms=YES;

			$msg_type=PATOIA_SELF_CANCELLED;

			$sender=$user_id;

			$receiver=$_POST['acceptance_issuing_id'];	

			$msg='<b>Self Cancelled</b> by PA';	
		}


		$_POST['last_modified_id']=rand(time(),5);

		if(in_array(strtolower($status),array('cancellation','completion','')) && $show_button=='reject')
		{
			if(strtolower($status)=='cancellation')
				$_POST['cancellation_issuing_date']='';				

			if(in_array(strtolower($status),array('','completion')))
				$_POST['cancellation_issuing_date']='';
		}		

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

		

		$inputs=$this->input->post();

		#echo '<pre>'; print_r($_POST); #exit;
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

		

		#echo '<br /> Update '.$update; exit;
		
		$update.="modified = '".date('Y-m-d H:i')."'";
		
		$update=rtrim($update,',');
		
		$fields.='user_id,created,modified';
		
		$fields_values.='"'.$user_id.'","'.date('Y-m-d H:i').'","'.date('Y-m-d H:i').'"';
		
		if(!$id)
		{

			$ins="INSERT INTO ".$this->db->dbprefix.JOBS." (".$fields.") VALUES (".$fields_values.")";
		
			$this->db->query($ins);
			
			$id=$this->db->insert_id();
			
			$msg='<b>Created by '.$user_name.' and sent request to IA</b>';			
			
		}
		else
		{
			$up="UPDATE ".$this->db->dbprefix.JOBS." SET ".$update." WHERE id='".$id."'";
			
			$this->db->query($up);
		}

		$_POST['permit_no']=$permit_no;

		#echo 'FF '.$_POST['permit_no'];
		
		$affectedRows = $this->db->affected_rows();
		
		if($affectedRows>0)
		{
			$this->db->where('job_id',$id);

			$this->db->where('relation_type',JOBS);
			
			$this->db->delete(JOBSISOLATIONRELATIONS);
			
			if(in_array($this->input->post('is_isoloation_permit'),array('Existing','Yes','yes_existing')))
			{
				$isoloation_permit_nos=explode(',',$_POST['isoloation_permit_no']);			
				
				$job_qry=$this->public_model->get_data(array('select'=>'approval_status','where_condition'=>'id ="'.$id.'"','table'=>JOBS));

				$job_result = $job_qry->row_array();
				
				$approval_status = $job_result['approval_status'];	

				if(!in_array($approval_status,array(10,6)))	
				{
					$array_insert=array();

					$array_insert_history = array();
					
					for($i=0;$i<count($isoloation_permit_nos);$i++)
					{
						$array_insert[]=array('job_id'=>$id,'jobs_isoloations_id'=>$isoloation_permit_nos[$i],'created'=>date('Y-m-d H:i'),'relation_type'=>JOBS);

						$array_insert_history[]=array('jobisolation_id'=>$isoloation_permit_nos[$i],'created'=>date('Y-m-d H:i'),'user_id'=>$user_id,'notes'=>'Related to '.$_POST['permit_no'].' by '.$user_name);
					}				
					
					if(count($array_insert)>0)
					{
						$this->db->insert_batch(JOBSISOLATIONRELATIONS,$array_insert);

						$this->db->insert_batch(JOBSISOLATIONHISTORY,$array_insert_history);
					}	
				}
				else
				{
					$this->jobs_isolations_model->check_job_relationship($isoloation_permit_nos,JOBS);
				}

			}


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
	
	public function ajax_show_jobs_history()
	{
		
		$id=$this->input->post('id');	
		
		$permit_no=$this->input->post('permit_no');	
		
		$department_id=$this->session->userdata('department_id');
		
		$return=array();
		
			$where='job_id = "'.$id.'"';  
			
			$subscription_history=array(
                'select'  =>'sh.id,sh.notes,sh.created,u.first_name',
                'where'=>$where,
                'table1'=>JOBSHISTORY.' sh',
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
				
				

				if($records['sop']!='')
				{
					$so=$this->public_model->get_data(array('select'=>'*','where_condition'=>'id = "'.$records['sop'].'"','table'=>SOPS))->row_array();

					
						$records['sop']=$so['sl_no'];

				}	

				if($records['work_instruction']!='')
				{
					$so=$this->public_model->get_data(array('select'=>'*','where_condition'=>'id = "'.$records['work_instruction'].'"','table'=>SOPS))->row_array();

					$records['work_instruction']=$so['sl_no'];
					
				}	
						
				$this->data['records']=$records;				
					
				$isolation_relations=$this->public_model->join_fetch_data(array('select'=>'i.approval_status,ir.jobs_isoloations_id','table1'=>JOBSISOLATION.' i','table2'=>JOBSISOLATIONRELATIONS.' ir','join_on'=>'ir.jobs_isoloations_id=i.id','join_type'=>'inner','where'=>'ir.job_id = "'.$id.'" AND relation_type="'.JOBS.'"','num_rows'=>false));
				
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
				
				$msg=$user_name.' accessed job information and take Print out';
				
				$array=array('notes'=>$msg,'created'=>date('Y-m-d H:i'),'user_id'=>$user_id,'job_id'=>$id);
				
				$this->db->insert(JOBSHISTORY,$array);
				
				$show_button=$records['show_button'];
				
				 if($show_button=='hide')
				 $readonly=true;
				
				
            }   
        }
		
	 	$where=" user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
				//Getting Active Companys List
			   $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));
		
				if($qry->num_rows()>0)
				{
					$authorities=$qry->result_array();
				}
		
			$this->data['eips'] = $this->public_model->get_data(array('select'=>'id,section,status,eip_no','where_condition'=>' (status = "'.STATUS_OPENED.'"  AND department_id = "'.$department_id.'" AND DATE(date_end)>=DATE(NOW())) '.$job_isolations_where,'table'=>JOBSISOLATION));
		
		$this->data['sops'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>'department_id = "'.$department_id.'" AND record_type="'.SOPS.'"','table'=>SOPS));

		$this->data['wis'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>'department_id = "'.$department_id.'" AND record_type="'.WORK_INSTRUCTIONS.'"','table'=>SOPS));

		$this->data['authorities']=$authorities;
		
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
		
		 $job_approval_status=unserialize(JOBAPPROVALS);
		 
		 $job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);
		 
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
		
		if(!in_array($department_id,array(EIP_CIVIL,EIP_TECHNICAL)))
		$where_condition=" j.department_id = '".$department_id."' AND ";
		else
		$where_condition=" j.department_id IN('".EIP_CIVIL."','".EIP_TECHNICAL."') AND ";	
		
		$approval_status = array_search('approval_status',$this->uri->segment_array());
	
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1))
		{
			$approval_status = $this->uri->segment($approval_status+1);
			
			if($approval_status!='' && $approval_status!='All')
			{
				if($approval_status==11)
					$where_condition.="j.is_rejected='".YES."' AND ";
				else	
					$where_condition.=" j.approval_status IN('".$approval_status."') AND ";
			}
			else
			{
				$where_condition.=" j.approval_status IN(4,6,9,10) AND ";
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
							7=>'j.show_button',
							8=>'j.permit_no',
							9=>'j.approval_status',
							10=>'j.acceptance_performing_id',
							11=>'j.acceptance_issuing_id',
							12=>'j.cancellation_issuing_id',
							13=>'j.issuing_authority',
							14=>'j.modified'
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

				$approval_status=$record['approval_status'];
				
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
						$json[$j]['status']=ucfirst($status);
						$json[$j]['modified']=date(DATE_FORMAT.' H:i A',strtotime($modified));
						$json[$j]['waiating_approval_by']=$waiating_approval_by;
						$json[$j]['action']=$print;
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

	// get jobs count for issuing authority
	public function ajax_fetch_jobs_count()
	{


		echo json_encode(array('waiting_jobs_count'=>$waiting_jobs_count=0,'waiting_jobs_list'=>$waiting_jobs_list=0,'approved_jobs_count'=>$approved_jobs_count=0,'approved_jobs_list'=>$approved_jobs_list=0));

		$issuing_authority_id = $this->session->userdata('user_id');

		// waiting jobs
		$waiting_jobs_count = 0; $waiting_jobs_list = array();

		$this->db->select('j.id as job_id,j.job_name,j.approval_status');

		$this->db->from(JOBS.' j');

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

		$this->db->from(JOBS.' j');

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
			$this->db->update_batch(JOBS,$update_data,'id');
			
		echo json_encode(array('waiting_jobs_count'=>$waiting_jobs_count,'waiting_jobs_list'=>$waiting_jobs_list,'approved_jobs_count'=>$approved_jobs_count,'approved_jobs_list'=>$approved_jobs_list));
	}
	
}