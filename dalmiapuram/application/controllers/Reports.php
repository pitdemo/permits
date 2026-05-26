<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','zones_model'));	

		$this->load->helper(array('custom'));
			
		$this->security_model->chk_is_admin();    
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');

		$this->data['method']=$this->router->fetch_method();

	}
	public function index() // list the item lists
	{
		redirect('reports/day_wise');
	}

	public function jobs_report()
	{

		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'))->result_array();

		$req=array('select'=>'id,name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['departments'] = $qry->result_array();

		$req=array('select'=>'id,first_name as name','table'=>USERS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['users'] = $qry->result_array();

		$req=array('select'=>'id,name','table'=>CONTRACTORS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['contractors'] = $qry->result_array();        

		$params_url=$where=$department_id='';
	

		$params_url='';;

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
		  //Pass status from TAB 
          $user_role=array_search('user_role',$segment_array);	
		  
		  if($user_role !==FALSE && $this->uri->segment($user_role+1)!='')
          {
			 	$user_role=$this->uri->segment($user_role+1);        
				         
                $params_url='/user_role/'.$user_role;
		  }  
		  else
		  $user_role='all';
		  
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
          $department_id=array_search('department_id',$segment_array);	
		  
		  if($department_id !==FALSE && $this->uri->segment($department_id+1)!='')
          {
			 	$department_id=$this->uri->segment($department_id+1);        
				         
                $params_url.='/zone_id/'.$department_id;
		  }  
		   else
		   $department_id='';		

          $contractor_id=array_search('contractor_id',$segment_array);	
		  
		  if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1)!='')
          {
			 	$contractor_id=$this->uri->segment($contractor_id+1);        
				         
                $params_url.='/zone_id/'.$contractor_id;
		  }  
		   else
		   $contractor_id='';		

		  //Pass status from TAB 
          $approval_status=array_search('approval_status',$segment_array);	
		  
		  if($approval_status !==FALSE && $this->uri->segment($approval_status+1)!='')
          {
			 	$approval_status=$this->uri->segment($approval_status+1);        
				         
                $params_url.='/approval_status/'.$approval_status;
		  }  
		  else
		  $approval_status='';

		$flammables = array_search('flammables',$segment_array);
		
        if($flammables !==FALSE && $this->uri->segment($flammables+1))
        {
            $selected_flammables = $this->uri->segment($flammables+1);

            $params_url.='/flammables/'.$selected_flammables;
		}
		else
			$selected_flammables='';				
		   
		$is_peptalk = array_search('is_peptalk',$segment_array);
		
        if($is_peptalk !==FALSE && $this->uri->segment($is_peptalk+1))
        {
            $selected_is_peptalk = $this->uri->segment($is_peptalk+1);

            $params_url.='/is_peptalk/'.$selected_is_peptalk;
		}
		else
			$selected_is_peptalk='all';   

		$work_types = array_search('work_types',$segment_array);
		
        if($work_types !==FALSE && $this->uri->segment($work_types+1))
        {
            $selected_work_types = explode(',',$this->uri->segment($work_types+1));
		}
		else
			$selected_work_types = array();

		$this->data['filters']['filter_status']=$user_role;	
		
		$this->data['params_url']=$params_url;
		
		$this->data['filters'][$user_role.'zone_id']=$zone_id;
		
		$this->data['filters'][$user_role.'approval_status']=$approval_status;

		$this->data['filters'][$user_role.'department_id']=$department_id;

		$this->data['filters'][$user_role.'contractor_id']=$contractor_id;

		$this->data['filters'][$user_role.'flammables']=$selected_flammables;

		$this->data['filters'][$user_role.'is_peptalk']=$selected_is_peptalk;

		$this->data['filters'][$user_role.'work_types'] = $selected_work_types;

		$this->data['filters'][$user_role.'subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$this->data['filters'][$user_role.'subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));	

		$this->load->view('reports/jobs_report',$this->data);	
	}

	public function ajax_jobs_report_fetch_data()
	{
		$this->load->model(array('jobs_model'));	

		$job_approval_status=unserialize(JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);

		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	

		#echo 'Parasms '.$param_url;

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$where_condition='';

        $user_id = array_search('user_id',$this->uri->segment_array());

        if($user_id !==FALSE && $this->uri->segment($user_id+1))
        {
            $user_id = $this->uri->segment($user_id+1);

            if($user_id=='null')
            	$user_id='';
		}
		else
			$user_id='';


        $user_role = array_search('user_role',$this->uri->segment_array());

        if($user_role !==FALSE && $this->uri->segment($user_role+1) && $user_id!='')
        {
	            $user_role = $this->uri->segment($user_role+1);
				
				$arr = range('a', 'f');
				
				$qry='('; 
				
				$qry2='(';

				$user_id_reg_exp=str_replace(',','|',$user_id);

				$user_id_exp=explode(',',$user_id);

				for($i=0;$i<count($arr);$i++)
				{
					for($u=0;$u<count($user_id_exp);$u++)
					{
						$qry.=' j.issuing_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR ';
					
						$qry2.=' j.performing_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR ';
					}	
				}

				$qry=rtrim($qry,'OR ');				
				$qry.='))';
				$qry2=rtrim($qry2,'OR ');
				$qry2.='))';

				if($user_role=='IA')
				$where_condition.=' ((j.acceptance_issuing_id REGEXP "'.$user_id_reg_exp.'" OR j.cancellation_issuing_id REGEXP "'.$user_id_reg_exp.'") OR '.$qry.' AND ';
				else if($user_role=='PA')
				$where_condition.=' ((j.acceptance_performing_id REGEXP "'.$user_id_reg_exp.'" OR j.cancellation_performing_id REGEXP "'.$user_id_reg_exp.'") OR '.$qry2.' AND ';
				else
				{
					$where_condition.='((j.acceptance_performing_id REGEXP "'.$user_id_reg_exp.'" OR j.cancellation_performing_id REGEXP "'.$user_id_reg_exp.'" OR j.acceptance_issuing_id REGEXP "'.$user_id_reg_exp.'" OR j.cancellation_issuing_id REGEXP "'.$user_id_reg_exp.'") OR '.$qry.' AND ';
				}

		}
		
        $zone_id = array_search('zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id IN(".$zone_id.") AND ";
		}

        $contractor_id = array_search('contractor_id',$this->uri->segment_array());

        if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1))
        {
            $contractor_id = $this->uri->segment($contractor_id+1);
			
			$where_condition.=" j.contractor_id IN(".$contractor_id.") AND ";
		}	

        $department_id = array_search('department_id',$this->uri->segment_array());

        if($department_id !==FALSE && $this->uri->segment($department_id+1))
        {
            $department_id = $this->uri->segment($department_id+1);
			
			$where_condition.=" j.department_id IN(".$department_id.") AND ";
		}			
		
	    $approval_status=array_search('approval_status',$segment_array);	
		  
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1)!='')
	    {
		 	$approval_status=$this->uri->segment($approval_status+1);        
			         
			if($approval_status==11)
				$where_condition.=' j.is_rejected="'.YES.'" AND ';
			else		         
            	$where_condition.=" j.approval_status IN(".$approval_status.") AND ";
		}  
		
		$flammables = array_search('flammables',$segment_array);

		if($flammables !==FALSE && $this->uri->segment($flammables+1))
        {
            $selected_flammables = $this->uri->segment($flammables+1);
			
			if($selected_flammables==YES)
				$where_condition.='j.hazards_options LIKE "%Ignition of Flammables%" AND ';			
			else if($selected_flammables==NO)
				$where_condition.='j.hazards_options NOT LIKE "%Ignition of Flammables%" AND ';			
		}	

		$work_types = array_search('work_types',$segment_array);
		
        if($work_types !==FALSE && $this->uri->segment($work_types+1))
        {
            $selected_work_types = $this->uri->segment($work_types+1);
			
			if($selected_work_types!='null')
			$where_condition.='j.work_types LIKE "%'.$selected_work_types.'%" AND ';
		}

		$is_peptalk = array_search('is_peptalk',$segment_array);

        if($is_peptalk !==FALSE && $this->uri->segment($is_peptalk+1))
        {
            $is_peptalk = $this->uri->segment($is_peptalk+1);

            if($is_peptalk==YES)           
            	$where_condition.='j.other_inputs LIKE "%Peptalk%" AND j.other_inputs_text!="" AND ';
            else if($is_peptalk==NO)           
            	$where_condition.='j.other_inputs NOT LIKE "%Peptalk%" AND j.other_inputs_text="" AND ';
		}

		$approval_status=array_search('approval_status',$segment_array);	
		  
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1)!='')
	    {
		 	$approval_status=$this->uri->segment($approval_status+1);        
			         
            $where_condition.=" j.approval_status IN(".$approval_status.") AND ";
		}  
		
        $subscription_date_start = array_search('subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));
		
		#echo 'FF '.$approval_status;

		$where_condition.=' DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';			
		
		  //Getting in URL params
		$search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		if($search_value!='')
		{
			$where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		}
		 
		$where_condition=rtrim($where_condition,'AND ');  
		#$where_condition .= "j.approval_status NOT IN (4,6,10)";
		
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
							16=>'j.schedule_date',
							17=>'j.other_inputs_text',
							18=>'j.is_rejected'
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
				
				$redirect=base_url().'reports/job_info/id/'.$id.'/reports/job_info/'.$param_url;
				
				$job_name=($record['job_name']) ? wordwrap($record['job_name'],15,'<br />') : ' - - -';
				
				$job_name='<a href="'.$redirect.'" target="_blank">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
				$status=$record['status'];
				
				$approval_status=$record['approval_status'];

				$is_rejected=$record['is_rejected'];

				if($is_rejected==YES)
					$approval_status=11;

				$other_inputs_text=strtoupper($record['other_inputs_text']);
				
				$time_diff='- - -';

				$schedule_date=($record['schedule_date']!='') ? json_decode($record['schedule_date'],true) : array();

				if(count($schedule_date)>0)
				$get_extended_missed_dates=$this->public_model->get_extended_missed_dates($schedule_date);
				else
				$get_extended_missed_dates='- - -';	

				#echo '<pre>'; print_r(array_count_values($schedule_date)); exit;
				
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
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span> ";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$permit_no.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$permit_no=$record['permit_no'];
				
				$print='- - -';
				
				if($show_button=='hide')
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';				
				
				$modified=$record['modified'];

				$chk_box = "<center><input type='checkbox' data-permit-no='".$permit_no."'  name='chk_box[]' class='bulk_box' value='".$id."'><center>";

						$json[$j]['chk_box']=$chk_box;
				
						$json[$j]['id']='<a href="'.$redirect.'" target="_blank">'.$permit_no.'</a>';	
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
						$json[$j]['extended_missed_dates']=$get_extended_missed_dates;
						$json[$j]['other_inputs_text']=$other_inputs_text;
						$j++;
			}
		}

		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}
	
	public function job_info()
	{
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
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
		
		$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
		
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
						 $job_status_error_msg='<a href="'.base_url().'jobs_isolations/index/user_role/All/" target="_blank">'.(count($jobs_isoloations_ids)-$check_jobs_isolation_status_num).'</a> number of EIPs are not final submitted by IA';			
					  }
				  }
				  
				  $job_isolations_where=' OR (id IN('.$jobs_isoloations_id.'))';
			  }
				
				/*$msg=$user_name.' accessed job information';
				
				$array=array('notes'=>$msg,'created'=>date('Y-m-d H:i'),'user_id'=>$user_id,'job_id'=>$id);
				
				$this->db->insert(JOBSHISTORY,$array);*/
				
				$show_button=$records['show_button'];
				
				 if($show_button=='hide')
				 $readonly=true;				
				
            }   
        }
		else
		{			
			redirect('reports/jobs_report');
		}

		
/*		if(!in_array($department_id,array(EIP_CIVIL,EIP_TECHNICAL)))
		$where="department_id = '".$department_id."' ";
		else
		$where="department_id IN('".EIP_CIVIL."','".EIP_TECHNICAL."') ";	
		
	 	$where.=" AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";*/

	 	if(!in_array($department_id,array(EIP_CIVIL,EIP_TECHNICAL)))
		$dept.="'".$department_id."'";
		else
		$dept.="'".EIP_CIVIL."','".EIP_TECHNICAL."'";	

		$dept.=",'".EIP_PRODUCTION."'";
		
	 	$where=" department_id IN(".$dept.") AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
				//Getting Active Companys List
	   $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));
	
		#echo $this->db->last_query(); exit;
		if($qry->num_rows()>0)
		{
			$authorities=$qry->result_array();
		}

		$this->data['eips'] = $this->public_model->get_data(array('select'=>'id,section,status','where_condition'=>' (status = "'.STATUS_OPENED.'"  AND department_id = "'.$department_id.'" AND DATE(date_end)>=DATE(NOW())) '.$job_isolations_where,'table'=>JOBSISOLATION));
		#echo $this->db->last_query(); exit;status = "'.STATUS_OPENED.'"  AND AND DATE(date_end)>=DATE(NOW())

		$this->data['authorities']=$authorities;
		
		$this->data['user_id']=$this->session->userdata('user_id');
		
		$this->data['readonly']=$readonly;
		
		$this->data['job_status_error_msg']=$job_status_error_msg;
		
		$this->data['param_url']=$param_url;

		$this->load->view($this->data['controller'].'job_info',$this->data);

	}

	public function confined_permit_info()	//Whenever you change anything here, apply the samething in reports
	{ 	

		$this->load->model(array('confined_permits_model'));

		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>5,'segment_array'=>$segment_array));	
		
		$readonly='';

		if($param_url=='')
		$param_url=$this->data['controller'].'/index/';	
		
		$zone_id=$this->session->userdata('zone_id');
		
		$department_id=$this->session->userdata('department_id');
		
		$user_name=$this->session->userdata(ADMIN.'first_name');
		
		$user_id=$this->session->userdata(ADMIN.'user_id');
		
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
						  
						  $check_jobs_isolation_status_num=$check_jobs_isolation_status->num_rows();	
					  }
					  
					  $job_isolations_where=' OR (id IN('.$jobs_isoloations_id.'))';
				  }
				
				$msg=$user_name.' accessed job information';
				
				$array=array('notes'=>$msg,'created'=>date('Y-m-d H:i'),'user_id'=>$user_id,'job_id'=>$id);
				
				$this->db->insert(CONFINEDJOBSHISTORY,$array);
				
				$show_button=$records['show_button'];
				
				 if($show_button=='hide')
				 $readonly=true;

			   $where=" id = '".$department_id."'";
				//Getting Active Companys List
			   $qry=$this->public_model->get_data(array('select'=>'id,name','where_condition'=>$where,'table'=>DEPARTMENTS));		
				
			   $dept=$qry->row_array();

			   $this->data['department']['name'] = $dept['name'];
		
			   $this->data['department']['id'] = $dept['id'];			   
				
            }   
        }
		

				if($user_ids!='')
				$where="(department_id = '".$department_id."' OR ".$user_ids.")";
				else
				$where = "department_id = '".$department_id."'";


	 		   $where.=" AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
				//Getting Active Companys List
			   $qry=$this->public_model->get_data(array('select'=>'id,first_name,is_safety','where_condition'=>$where,'table'=>USERS));
			
				#echo $this->db->last_query(); exit;
				if($qry->num_rows()>0)
				{
					$authorities=$qry->result_array();
				}
		
				$this->data['eips'] = $this->public_model->get_data(array('select'=>'id,section,status','where_condition'=>' (status = "'.STATUS_OPENED.'"  AND department_id = "'.$department_id.'" AND DATE(date_end)>=DATE(NOW())) '.$job_isolations_where,'table'=>JOBSISOLATION));
				#echo $this->db->last_query(); exit;status = "'.STATUS_OPENED.'"  AND AND DATE(date_end)>=DATE(NOW())

				$safety_authorities = array();

 			   $where="is_safety = 'Yes'  AND status='".STATUS_ACTIVE."'";
				//Getting Active Companys List
			   $qry=$this->public_model->get_data(array('select'=>'id,first_name','where_condition'=>$where,'table'=>USERS));

			   #echo $this->db->last_query(); exit;
				if($qry->num_rows()>0)
				{
					$safety_authorities=$qry->result_array();
				}			

				$issuing_authorities = array();

				/*if(!in_array($department_id,array(EIP_CIVIL,EIP_TECHNICAL)))
				$where=" department_id IN('".EIP_PROCESS."','".EIP_POWER_PLANT."') ";
				else
				$where=" department_id IN('".EIP_CIVIL."','".EIP_TECHNICAL."','".EIP_PROCESS."','".EIP_POWER_PLANT."') ";			*/	

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
			
			$this->load->view($this->data['controller'].'confined_permit_info',$this->data);
	}

	public function confined_permits_report()
	{

		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'))->result_array();

		$req=array('select'=>'id,name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['departments'] = $qry->result_array();

		$req=array('select'=>'id,first_name as name','table'=>USERS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['users'] = $qry->result_array();

		$req=array('select'=>'id,name','table'=>CONTRACTORS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['contractors'] = $qry->result_array();        

		$params_url=$where=$department_id='';
	

		$params_url='';;

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
		  //Pass status from TAB 
          $user_role=array_search('user_role',$segment_array);	
		  
		  if($user_role !==FALSE && $this->uri->segment($user_role+1)!='')
          {
			 	$user_role=$this->uri->segment($user_role+1);        
				         
                $params_url='/user_role/'.$user_role;
		  }  
		  else
		  $user_role='all';
		  
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
          $department_id=array_search('department_id',$segment_array);	
		  
		  if($department_id !==FALSE && $this->uri->segment($department_id+1)!='')
          {
			 	$department_id=$this->uri->segment($department_id+1);        
				         
                $params_url.='/zone_id/'.$department_id;
		  }  
		   else
		   $department_id='';		

          $contractor_id=array_search('contractor_id',$segment_array);	
		  
		  if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1)!='')
          {
			 	$contractor_id=$this->uri->segment($contractor_id+1);        
				         
                $params_url.='/zone_id/'.$contractor_id;
		  }  
		   else
		   $contractor_id='';		

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

		$this->data['filters'][$user_role.'department_id']=$department_id;

		$this->data['filters'][$user_role.'contractor_id']=$contractor_id;

		$this->data['filters'][$user_role.'subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$this->data['filters'][$user_role.'subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));	

		$this->load->view('reports/confined_permits_report',$this->data);	
	}


	public function ajax_confined_permits_report_fetch_data() //swathi
	{		
		$this->load->model(array('confined_permits_model'));

		 $job_approval_status=unserialize(CONFINED_JOBAPPROVALS);
		 
		 $job_approval_status_color=unserialize(CONFINED_JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));

		$requestData= $_REQUEST;

		$search=$where_condition='';	

        $user_id = array_search('user_id',$this->uri->segment_array());

        if($user_id !==FALSE && $this->uri->segment($user_id+1))
        {
            $user_id = $this->uri->segment($user_id+1);

            if($user_id=='null')
            	$user_id='';
		}
		else
			$user_id='';


        $user_role = array_search('user_role',$this->uri->segment_array());

        if($user_role !==FALSE && $this->uri->segment($user_role+1) && $user_id!='')
        {
            $user_role = $this->uri->segment($user_role+1);

			$arr = range('a', 'f');
			
			$qry_pa='('; //{"a":"15","b":"","c":"","d":"","e":"","f":""} Need to change in reports controller
			
			$qry_ia='(';

			$qry_sa='(';

			$user_id_reg_exp=str_replace(',','|',$user_id);

			$user_id_exp=explode(',',$user_id);			

			for($i=0;$i<count($arr);$i++)
			{
				for($u=0;$u<count($user_id_exp);$u++)
				{
					$qry_ia.=' j.extended_issuing_from_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR j.extended_issuing_to_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR ';
					
					$qry_pa.=' j.extended_performing_from_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR j.extended_performing_to_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR ';

					$qry_sa.=' j.extended_safety_from_sign_id like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR j.extended_safety_to_sign_id like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR ';
				}	
			}

			$qry_ia = rtrim($qry_ia,'OR ');

			$qry_pa = rtrim($qry_pa,'OR ');

			$qry_sa = rtrim($qry_sa,'OR ');
						
			$qry_ia.='))';
			
			$qry_pa.='))';

			$qry_sa.='))';
		

			if($user_role=='PA')
			$where_condition .= 'j.acceptance_performing_id REGEXP "'.$user_id_reg_exp.'" OR '.$qry_pa.' AND ';
			else if($user_role=='IA')
			$where_condition .= '(j.acceptance_issuing_id REGEXP "'.$user_id_reg_exp.'" OR j.cancellation_issuing_id REGEXP "'.$user_id_reg_exp.'") OR  '.$qry_ia.' AND ';
			else if($user_role=='SAT')
			$where_condition .= '(j.acceptance_safety_sign_id REGEXP "'.$user_id_reg_exp.'")  OR '.$qry_sa.' AND ';
			else
			$where_condition .= '(j.acceptance_performing_id REGEXP "'.$user_id_reg_exp.'" OR j.cancellation_issuing_id REGEXP "'.$user_id_reg_exp.'" OR j.acceptance_issuing_id REGEXP "'.$user_id_reg_exp.'") OR '.$qry_pa.' OR '.$qry_ia.' OR '.$qry_sa.' AND ' ;

		}
		
        $zone_id = array_search('zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id IN(".$zone_id.") AND ";
		}

        $contractor_id = array_search('contractor_id',$this->uri->segment_array());

        if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1))
        {
            $contractor_id = $this->uri->segment($contractor_id+1);
			
			$where_condition.=" j.contractor_id IN(".$contractor_id.") AND ";
		}	

        $department_id = array_search('department_id',$this->uri->segment_array());

        if($department_id !==FALSE && $this->uri->segment($department_id+1))
        {
            $department_id = $this->uri->segment($department_id+1);
			
			$where_condition.=" j.department_id IN(".$department_id.") AND ";
		}			
		
	    $approval_status=array_search('approval_status',$segment_array);	
		  
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1)!='')
	    {
		 	$approval_status=$this->uri->segment($approval_status+1);        
			         
            $where_condition.=" j.approval_status IN(".$approval_status.") AND ";
		}  
		
        $subscription_date_start = array_search('subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));

		$where_condition.=' DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';			
		
		  //Getting in URL params
		$search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		if($search_value!='')
		{
			$where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		}
		 
		$where_condition=rtrim($where_condition,'AND ');  

		
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
							17=>'j.schedule_date'
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

				$redirect=base_url().'reports/confined_permit_info/id/'.$id.'/reports/confined_permits_report/';
				
				$job_name=($record['job_name']) ? wordwrap($record['job_name'],15,'<br />') : ' - - -';
				
				$job_name='<a href="'.$redirect.'" target="_blank">'.strtoupper($job_name).'</a>';
				
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

				$schedule_date=($record['schedule_date']!='') ? json_decode($record['schedule_date'],true) : array();

				#echo '<pre>'; print_r($schedule_date);

				if(count($schedule_date)>0)
				$get_extended_missed_dates=$this->public_model->get_extended_missed_dates($schedule_date);
				else
				$get_extended_missed_dates='- - -';		


				
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
				
				$chk_box = "<center><input type='checkbox' data-permit-no='".$permit_no."'  name='chk_box[]' class='bulk_box' value='".$id."'><center>";

						$json[$j]['chk_box']=$chk_box;
						$json[$j]['id']='<a href="'.$redirect.'" target="_blank">'.'#'.$permit_no.'</a>';
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
						$json[$j]['extended_missed_dates']=$get_extended_missed_dates;
						$j++;
			}
		}

		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}


	public function electrical_permits_report()
	{

		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'))->result_array();

		$req=array('select'=>'id,name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['departments'] = $qry->result_array();

		$req=array('select'=>'id,first_name as name','table'=>USERS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['users'] = $qry->result_array();

		$req=array('select'=>'id,name','table'=>CONTRACTORS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['contractors'] = $qry->result_array();        

		$params_url=$where=$department_id='';
	

		$params_url='';;

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
		  //Pass status from TAB 
          $user_role=array_search('user_role',$segment_array);	
		  
		  if($user_role !==FALSE && $this->uri->segment($user_role+1)!='')
          {
			 	$user_role=$this->uri->segment($user_role+1);        
				         
                $params_url='/user_role/'.$user_role;
		  }  
		  else
		  $user_role='all';
		  
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
          $department_id=array_search('department_id',$segment_array);	
		  
		  if($department_id !==FALSE && $this->uri->segment($department_id+1)!='')
          {
			 	$department_id=$this->uri->segment($department_id+1);        
				         
                $params_url.='/zone_id/'.$department_id;
		  }  
		   else
		   $department_id='';		

          $contractor_id=array_search('contractor_id',$segment_array);	
		  
		  if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1)!='')
          {
			 	$contractor_id=$this->uri->segment($contractor_id+1);        
				         
                $params_url.='/zone_id/'.$contractor_id;
		  }  
		   else
		   $contractor_id='';		

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

		$this->data['filters'][$user_role.'department_id']=$department_id;

		$this->data['filters'][$user_role.'contractor_id']=$contractor_id;

		$this->data['filters'][$user_role.'subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$this->data['filters'][$user_role.'subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));	

		$this->load->view('reports/electrical_permits_report',$this->data);	
	}

	public function ajax_electrical_permits_report_fetch_data()
	{

		$this->load->model(array('electrical_model'));

		$job_approval_status=unserialize(JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));

		$requestData= $_REQUEST;

		$search=$where_condition='';	

        $user_id = array_search('user_id',$this->uri->segment_array());

        if($user_id !==FALSE && $this->uri->segment($user_id+1))
        {
            $user_id = $this->uri->segment($user_id+1);

            if($user_id=='null')
            	$user_id='';
		}
		else
			$user_id='';


        $user_role = array_search('user_role',$this->uri->segment_array());

        if($user_role !==FALSE && $this->uri->segment($user_role+1) && $user_id!='')
        {
            $user_role = $this->uri->segment($user_role+1);

			$arr = range('a', 'f');
			
			$qry_pa='('; //{"a":"15","b":"","c":"","d":"","e":"","f":""} Need to change in reports controller
			
			$qry_ia='(';			

			$user_id_reg_exp=str_replace(',','|',$user_id);

			$user_id_exp=explode(',',$user_id);			

			for($i=0;$i<count($arr);$i++)
			{
				for($u=0;$u<count($user_id_exp);$u++)
				{
					$qry_ia.=' j.extended_issuing_from_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR j.extended_issuing_to_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR ';
					
					$qry_pa.=' j.extended_performing_from_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR j.extended_performing_to_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR ';					
				}	
			}

			$qry_ia = rtrim($qry_ia,'OR ');

			$qry_pa = rtrim($qry_pa,'OR ');
						
			$qry_ia.='))';
			
			$qry_pa.='))';		

			if($user_role=='PA')
			$where_condition .= 'j.acceptance_performing_id REGEXP "'.$user_id_reg_exp.'" OR '.$qry_pa.' AND ';
			else if($user_role=='IA')
			$where_condition .= '(j.acceptance_issuing_id REGEXP "'.$user_id_reg_exp.'" OR j.cancellation_issuing_id REGEXP "'.$user_id_reg_exp.'") OR  '.$qry_ia.' AND ';			
			else
			$where_condition .= '(j.acceptance_performing_id REGEXP "'.$user_id_reg_exp.'" OR j.cancellation_issuing_id REGEXP "'.$user_id_reg_exp.'" OR j.acceptance_issuing_id REGEXP "'.$user_id_reg_exp.'") OR '.$qry_pa.' OR '.$qry_ia.' AND ' ;

		}
		
        $zone_id = array_search('zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id IN(".$zone_id.") AND ";
		}

        $contractor_id = array_search('contractor_id',$this->uri->segment_array());

        if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1))
        {
            $contractor_id = $this->uri->segment($contractor_id+1);
			
			$where_condition.=" j.contractor_id IN(".$contractor_id.") AND ";
		}	

        $department_id = array_search('department_id',$this->uri->segment_array());

        if($department_id !==FALSE && $this->uri->segment($department_id+1))
        {
            $department_id = $this->uri->segment($department_id+1);
			
			$where_condition.=" j.department_id IN(".$department_id.") AND ";
		}			
		
	    $approval_status=array_search('approval_status',$segment_array);	
		  
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1)!='')
	    {
		 	$approval_status=$this->uri->segment($approval_status+1);        
			         
            $where_condition.=" j.approval_status IN(".$approval_status.") AND ";
		}  
		
        $subscription_date_start = array_search('subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));

		$where_condition.=' DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';			
		
		  //Getting in URL params
		$search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		if($search_value!='')
		{
			$where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		}
		 
		$where_condition=rtrim($where_condition,'AND ');  


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
							16=>'j.schedule_date'
						);
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->electrical_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->electrical_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
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
				
				$redirect='#';#base_url().$this->data['controller'].'form/id/'.$id.'/'.$this->data['controller'].'myjobs/'.$param_url;
				
				$job_name=($record['job_name']) ? wordwrap($record['job_name'],15,'<br />') : ' - - -';
				
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

				$schedule_date=($record['schedule_date']!='') ? json_decode($record['schedule_date'],true) : array();

				if(count($schedule_date)>0)
				$get_extended_missed_dates=$this->public_model->get_extended_missed_dates($schedule_date);
				else
				$get_extended_missed_dates='- - -';		

				
				$waiating_approval_by=$this->electrical_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$permit_no.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$permit_no=$record['permit_no'];
				
				$print='- - -';
				
				if($show_button=='hide')
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';				
				
				$modified=$record['modified'];

				$chk_box = "<center><input type='checkbox' data-permit-no='".$permit_no."'  name='chk_box[]' class='bulk_box' value='".$id."'><center>";

						$json[$j]['chk_box']=$chk_box;
				
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
						$json[$j]['extended_missed_dates']=$get_extended_missed_dates;
						$j++;
			}
		}

		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;

	}

	public function utpumps_permits_report()
	{

		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'))->result_array();

		$req=array('select'=>'id,name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['departments'] = $qry->result_array();

		$req=array('select'=>'id,first_name as name','table'=>USERS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['users'] = $qry->result_array();

		$req=array('select'=>'id,name','table'=>CONTRACTORS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['contractors'] = $qry->result_array();        

		$params_url=$where=$department_id='';
	

		$params_url='';;

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
		  //Pass status from TAB 
          $user_role=array_search('user_role',$segment_array);	
		  
		  if($user_role !==FALSE && $this->uri->segment($user_role+1)!='')
          {
			 	$user_role=$this->uri->segment($user_role+1);        
				         
                $params_url='/user_role/'.$user_role;
		  }  
		  else
		  $user_role='all';
		  
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
          $department_id=array_search('department_id',$segment_array);	
		  
		  if($department_id !==FALSE && $this->uri->segment($department_id+1)!='')
          {
			 	$department_id=$this->uri->segment($department_id+1);        
				         
                $params_url.='/zone_id/'.$department_id;
		  }  
		   else
		   $department_id='';		

          $contractor_id=array_search('contractor_id',$segment_array);	
		  
		  if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1)!='')
          {
			 	$contractor_id=$this->uri->segment($contractor_id+1);        
				         
                $params_url.='/zone_id/'.$contractor_id;
		  }  
		   else
		   $contractor_id='';		

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

		$this->data['filters'][$user_role.'department_id']=$department_id;

		$this->data['filters'][$user_role.'contractor_id']=$contractor_id;

		$this->data['filters'][$user_role.'subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$this->data['filters'][$user_role.'subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));	

		$this->load->view('reports/utpumps_permits_report',$this->data);	
	}

	public function ajax_utpumps_permits_report_fetch_data()
	{

		$this->load->model(array('utpumps_model'));

		$job_approval_status=unserialize(JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));

		$requestData= $_REQUEST;

		$search=$where_condition='';	

        $user_id = array_search('user_id',$this->uri->segment_array());

        if($user_id !==FALSE && $this->uri->segment($user_id+1))
        {
            $user_id = $this->uri->segment($user_id+1);

            if($user_id=='null')
            	$user_id='';
		}
		else
			$user_id='';


        $user_role = array_search('user_role',$this->uri->segment_array());

        if($user_role !==FALSE && $this->uri->segment($user_role+1) && $user_id!='')
        {
            $user_role = $this->uri->segment($user_role+1);

			$arr = range('a', 'f');
			
			$qry_pa='('; //{"a":"15","b":"","c":"","d":"","e":"","f":""} Need to change in reports controller
			
			$qry_ia='(';			

			$user_id_reg_exp=str_replace(',','|',$user_id);

			$user_id_exp=explode(',',$user_id);			

			for($i=0;$i<count($arr);$i++)
			{
				for($u=0;$u<count($user_id_exp);$u++)
				{
					$qry_ia.=' j.extended_issuing_from_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR j.extended_issuing_to_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR ';
					
					$qry_pa.=' j.extended_performing_from_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR j.extended_performing_to_authority like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR ';					
				}	
			}

			$qry_ia = rtrim($qry_ia,'OR ');

			$qry_pa = rtrim($qry_pa,'OR ');
						
			$qry_ia.='))';
			
			$qry_pa.='))';		

			if($user_role=='PA')
			$where_condition .= 'j.acceptance_performing_id REGEXP "'.$user_id_reg_exp.'" OR '.$qry_pa.' AND ';
			else if($user_role=='IA')
			$where_condition .= '(j.acceptance_issuing_id REGEXP "'.$user_id_reg_exp.'" OR j.cancellation_issuing_id REGEXP "'.$user_id_reg_exp.'") OR  '.$qry_ia.' AND ';			
			else
			$where_condition .= '(j.acceptance_performing_id REGEXP "'.$user_id_reg_exp.'" OR j.cancellation_issuing_id REGEXP "'.$user_id_reg_exp.'" OR j.acceptance_issuing_id REGEXP "'.$user_id_reg_exp.'") OR '.$qry_pa.' OR '.$qry_ia.' AND ' ;

		}
		
        $zone_id = array_search('zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id IN(".$zone_id.") AND ";
		}

        $contractor_id = array_search('contractor_id',$this->uri->segment_array());

        if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1))
        {
            $contractor_id = $this->uri->segment($contractor_id+1);
			
			$where_condition.=" j.contractor_id IN(".$contractor_id.") AND ";
		}	

        $department_id = array_search('department_id',$this->uri->segment_array());

        if($department_id !==FALSE && $this->uri->segment($department_id+1))
        {
            $department_id = $this->uri->segment($department_id+1);
			
			$where_condition.=" j.department_id IN(".$department_id.") AND ";
		}			
		
	    $approval_status=array_search('approval_status',$segment_array);	
		  
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1)!='')
	    {
		 	$approval_status=$this->uri->segment($approval_status+1);        
			         
            $where_condition.=" j.approval_status IN(".$approval_status.") AND ";
		}  
		
        $subscription_date_start = array_search('subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));

		$where_condition.=' DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';			
		
		  //Getting in URL params
		$search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		if($search_value!='')
		{
			$where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		}
		 
		$where_condition=rtrim($where_condition,'AND ');  


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
							16=>'j.schedule_date'
						);
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->utpumps_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->utpumps_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
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
				
				$redirect=base_url().'reports/utpumps_permits_info/id/'.$id.'/reports/utpumps_permits_report/';
				
				$job_name=($record['job_name']) ? wordwrap($record['job_name'],15,'<br />') : ' - - -';
				
				$job_name='<a href="'.$redirect.'"  target="_blank">'.strtoupper($job_name).'</a>';
				
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
				
				$waiating_approval_by=$this->utpumps_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$permit_no.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$permit_no=$record['permit_no'];
				
				$print='- - -';

				$schedule_date=($record['schedule_date']!='') ? json_decode($record['schedule_date'],true) : array();

				if(count($schedule_date)>0)
				$get_extended_missed_dates=$this->public_model->get_extended_missed_dates($schedule_date);
				else
				$get_extended_missed_dates='- - -';						
				
				if($show_button=='hide')
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';				
				
				$modified=$record['modified'];

				$chk_box = "<center><input type='checkbox' data-permit-no='".$permit_no."'  name='chk_box[]' class='bulk_box' value='".$id."'><center>";

				$json[$j]['chk_box']=$chk_box;
				
						$json[$j]['id']='<a href="'.$redirect.'"  target="_blank">'.$permit_no.'</a>';
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
						$json[$j]['extended_missed_dates']=$get_extended_missed_dates;
						$j++;
			}
		}

		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;

	}	
	

	public function utpumps_permits_info()
	{

		$this->load->helper(array('custom'));
		#echo '<pre>'; print_r($this->session->userdata); exit;
		
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>5,'segment_array'=>$segment_array));	

		if($param_url=='')
		$param_url=$this->data['controller'].'/myjobs/';

		$readonly='';
		
		$zone_id=$this->session->userdata(ADMIN.'zone_id');
		
		$department_id=$this->session->userdata(ADMIN.'department_id');
		
		$user_name=$this->session->userdata(ADMIN.'first_name');
		
		$user_id=$this->session->userdata(ADMIN.'user_id');
		
		$authorities=$job_isolations_where=$job_status_error_msg='';
		
		#echo $this->db->last_query(); exit;
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
		
		$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
		
		$this->data['isoloation_permit_no']='';
		
		$height_works_where='';

        $update = array_search('id',$this->uri->segment_array());
        $id='';
        $height_works_where=' AND status NOT IN("Cancellation","Completion") AND work_types LIKE "%height%"';
        if($update !==FALSE && $this->uri->segment($update+1))
        {      	

            $id = $this->uri->segment($update+1);

            $req=array(
              'select'  =>'*,TIMESTAMPDIFF(HOUR, modified, "'.date('Y-m-d H:i').'") as time_diff',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>UTPUMPSPERMITS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{

                $records=$qry->row_array();
				
				$this->data['records']=$records;
				
				$department_id = $records['department_id'];			

				$qry=$this->public_model->get_data(array('select'=>'id,name','where_condition'=>'id ="'.$department_id.'"','table'=>DEPARTMENTS));		
				
			    $dept=$qry->row_array();

			    $this->data['department']['name'] = $dept['name'];
		
			    $this->data['department']['id'] = $dept['id'];	

				
				$msg=$user_name.' accessed job information';
				
				$array=array('notes'=>$msg,'created'=>date('Y-m-d H:i'),'user_id'=>$user_id,'job_id'=>$id);
				
				$this->db->insert(UTPUMPSPERMITSHISTORY,$array);
				
				$show_button=$records['show_button'];
				
				 if($show_button=='hide')
				 $readonly=true;
				
				
            }   
        }
		else
		{
			redirect('reports/utpumps_permits_report');
		}
		
		$where="department_id = '".$department_id."' AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
		//Getting Active Companys List
	    $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role,is_safety','where_condition'=>$where,'table'=>USERS));
	
		#echo $this->db->last_query(); exit;
		if($qry->num_rows()>0)
		{
			$authorities=$qry->result_array();
		}

		$this->data['eips'] = $this->public_model->get_data(array('select'=>'id,section,status','where_condition'=>' (status = "'.STATUS_OPENED.'"  AND department_id = "'.$department_id.'" AND DATE(date_end)>=DATE(NOW())) '.$job_isolations_where,'table'=>JOBSISOLATION));
		#echo $this->db->last_query(); exit;status = "'.STATUS_OPENED.'"  AND AND DATE(date_end)>=DATE(NOW())

		$this->data['height_works'] = $this->public_model->get_data(array('select'=>'id,permit_no,location','where_condition'=>' show_button = "hide"  AND department_id = "'.$department_id.'"' .$height_works_where,'table'=>JOBS));
		
		$this->data['authorities']=$authorities;
		
		$this->data['user_id']=$this->session->userdata('user_id');
		
		$this->data['readonly']=$readonly;
		
		$this->data['job_status_error_msg']=$job_status_error_msg;
		
		$this->data['param_url']=$param_url;
		
		$this->load->view($this->data['controller'].'utpumps_permits_info',$this->data);

	}


	public function excavation_permits_report()
	{

		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'))->result_array();

		$req=array('select'=>'id,name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['departments'] = $qry->result_array();

		$req=array('select'=>'id,first_name as name','table'=>USERS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['users'] = $qry->result_array();

		$req=array('select'=>'id,name','table'=>CONTRACTORS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $this->data['contractors'] = $qry->result_array();        

		$params_url=$where=$department_id='';
	

		$params_url='';;

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
		  //Pass status from TAB 
          $user_role=array_search('user_role',$segment_array);	
		  
		  if($user_role !==FALSE && $this->uri->segment($user_role+1)!='')
          {
			 	$user_role=$this->uri->segment($user_role+1);        
				         
                $params_url='/user_role/'.$user_role;
		  }  
		  else
		  $user_role='all';
		  
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
          $department_id=array_search('department_id',$segment_array);	
		  
		  if($department_id !==FALSE && $this->uri->segment($department_id+1)!='')
          {
			 	$department_id=$this->uri->segment($department_id+1);        
				         
                $params_url.='/zone_id/'.$department_id;
		  }  
		   else
		   $department_id='';		

          $contractor_id=array_search('contractor_id',$segment_array);	
		  
		  if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1)!='')
          {
			 	$contractor_id=$this->uri->segment($contractor_id+1);        
				         
                $params_url.='/zone_id/'.$contractor_id;
		  }  
		   else
		   $contractor_id='';		

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

		$this->data['filters'][$user_role.'department_id']=$department_id;

		$this->data['filters'][$user_role.'contractor_id']=$contractor_id;

		$this->data['filters'][$user_role.'subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$this->data['filters'][$user_role.'subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));	

		$this->load->view('reports/excavation_permits_report',$this->data);	
	}

	public function ajax_excavation_permits_report_fetch_data()
	{

		$this->load->model(array('excavations_model'));

		$job_approval_status=unserialize(EXCAVATION_JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(EXCAVATION_JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));

		$requestData= $_REQUEST;

		$search=$where_condition='';	

        $user_id = array_search('user_id',$this->uri->segment_array());

        if($user_id !==FALSE && $this->uri->segment($user_id+1))
        {
            $user_id = $this->uri->segment($user_id+1);

            if($user_id=='null')
            	$user_id='';
		}
		else
			$user_id='';


        $user_role = array_search('user_role',$this->uri->segment_array());

        if($user_role !==FALSE && $this->uri->segment($user_role+1) && $user_id!='')
        {
            $user_role = $this->uri->segment($user_role+1);

			$user_id_reg_exp=str_replace(',','|',$user_id);

			$user_id_exp=explode(',',$user_id);	

			$ia=$pa=$dept='';

			if($user_role=='IA')
			$ia.=' j.acceptance_issuing_id REGEXP "'.$user_id_reg_exp.'" ';
			else if($user_role=='PA')
			$pa.=' j.acceptance_performing_id REGEXP "'.$user_id_reg_exp.'" ';
			else 
			{
				$arr = range('a', 'e');			
			
				for($i=0;$i<count($arr);$i++)
				{
					for($u=0;$u<count($user_id_exp);$u++)
					{
						$dept.=' j.dept_issuing_id like \'%"'.$arr[$i].'":"'.$user_id_exp[$u].'"%\' OR ';
					}	
				}		

				$dept=rtrim($dept,'OR ');
			}				

			if($user_role=='dept')
			$where_condition .=	'('.$dept.') AND ';
			else if($user_role=='IA')
			$where_condition .=	$ia.' AND ';
			else if($user_role=='PA')
			$where_condition .=$pa.' AND ';
			else
			{
				$where_condition.=' (j.acceptance_issuing_id REGEXP "'.$user_id_reg_exp.'" OR j.acceptance_performing_id REGEXP "'.$user_id_reg_exp.'" OR '.$dept.') AND ';
			}

		}
		
        $zone_id = array_search('zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id IN(".$zone_id.") AND ";
		}

        $contractor_id = array_search('contractor_id',$this->uri->segment_array());

        if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1))
        {
            $contractor_id = $this->uri->segment($contractor_id+1);
			
			$where_condition.=" j.contractor_id IN(".$contractor_id.") AND ";
		}	

        $department_id = array_search('department_id',$this->uri->segment_array());

        if($department_id !==FALSE && $this->uri->segment($department_id+1))
        {
            $department_id = $this->uri->segment($department_id+1);
			
			$where_condition.=" j.department_id IN(".$department_id.") AND ";
		}			
		
	    $approval_status=array_search('approval_status',$segment_array);	
		  
		if($approval_status !==FALSE && $this->uri->segment($approval_status+1)!='')
	    {
		 	$approval_status=$this->uri->segment($approval_status+1);        
			         
            $where_condition.=" j.approval_status IN(".$approval_status.") AND ";
		}  
		
        $subscription_date_start = array_search('subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));

		$where_condition.=' DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';			
		
		  //Getting in URL params
		$search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		if($search_value!='')
		{
			$where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR c.name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		}
		 
		$where_condition=rtrim($where_condition,'AND ');  


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
				
				$job_name='<a href="'.$redirect.'" target="_blank">'.strtoupper($job_name).'</a>';
				
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
				
				#$waiating_approval_by=$this->excavations_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'fields'=>$fields,'record'=>$record));
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$permit_no.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$permit_no=$record['permit_no'];
				
				$print='- - -';
				
				if($show_button=='hide')
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';				
				
				$modified=$record['modified'];

						$chk_box = "<center><input type='checkbox' data-permit-no='".$permit_no."'  name='chk_box[]' class='bulk_box' value='".$id."'><center>";

						$json[$j]['chk_box']=$chk_box;
				
						$json[$j]['id']='<a href="'.$redirect.'" target="_blank">'.$permit_no.'</a>';
						$json[$j]['job_name']=$job_name;
						$json[$j]['location']=strtoupper($record['location']);
						$json[$j]['name']=strtoupper($contractor_name);
						$json[$j]['approval_status']=$approval_status;#.' - '.$search;
						$json[$j]['created']=date(DATE_FORMAT,strtotime($created));
						$json[$j]['modified']=date(DATE_FORMAT.' H:i A',strtotime($modified));
						$json[$j]['status']=ucfirst($status);
						#$json[$j]['waiating_approval_by']=$waiating_approval_by;
						$json[$j]['action']=$print;
						$json[$j]['time_diff']=$time_diff;
						$j++;
			}
		}

		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;

	}		

	public function jobs_category_wise()
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

		$flammables = array_search('flammables',$segment_array);
		
        if($flammables !==FALSE && $this->uri->segment($flammables+1))
        {
            $selected_flammables = $this->uri->segment($flammables+1);
		}
		else
			$selected_flammables='';		

		$is_peptalk = array_search('is_peptalk',$segment_array);
		
        if($is_peptalk !==FALSE && $this->uri->segment($is_peptalk+1))
        {
            $is_peptalk = $this->uri->segment($is_peptalk+1);
		}
		else
			$is_peptalk='';		
		
		
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

		$this->data['is_peptalk']=$is_peptalk;
		
		$this->data['selected_zones']=$selected_zones;
		
		$this->data['selected_departments']=$selected_departments;

		$this->data['selected_flammables']=$selected_flammables;
		
		$this->load->view('reports/jobs_category_wise',$this->data);
	}
	
	public function ajax_search_jobs_category_wise()
	{
		$this->load->model(array('jobs_model'));
		#echo '<pre>'; print_r($this->input->post()); exit;
		
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
		
		$fields=array(0=>'DATE(j.created) as permit_created',1=>'COUNT(CASE WHEN j.work_types LIKE "%height_work%" THEN 1 END) as height_work',2=>'count(j.id) as no_of_permits',3=>'COUNT(CASE WHEN j.work_types LIKE "%general_work%" THEN 1 END) as general_work',4=>'COUNT(CASE WHEN j.work_types LIKE "%hot_work%" THEN 1 END) as hot_work');
		
		$where_condition='DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';
		
		$redirect_url='/';

		$departments = array_search('departments',$segment_array);
		
        if($departments !==FALSE && $this->uri->segment($departments+1))
        {
            $selected_departments = $this->uri->segment($departments+1);
			
			if($selected_departments!='null')
			{
				$where_condition.='j.department_id IN('.$selected_departments.') AND ';

				$redirect_url.='department_id/'.$selected_departments.'/';
			}
		}
			
		$zones = array_search('zones',$segment_array);
		
        if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $selected_zones = $this->uri->segment($zones+1);
			
			if($selected_zones!='null')
			{
				$where_condition.='j.zone_id IN('.$selected_zones.') AND ';

				$redirect_url.='zone_id/'.$selected_zones.'/';

			}	
		}

		$flammables = array_search('flammables',$segment_array);

		if($flammables !==FALSE && $this->uri->segment($flammables+1))
        {
            $selected_flammables = $this->uri->segment($flammables+1);
			
			if($selected_flammables==YES)
				$where_condition.='j.hazards_options LIKE "%Ignition of Flammables%" AND ';			
			else if($selected_flammables==NO)
				$where_condition.='j.hazards_options NOT LIKE "%Ignition of Flammables%" AND ';		

			if($selected_flammables!='')		
				$redirect_url.='flammables/'.$selected_flammables.'/';	
		}

		$is_peptalk = array_search('is_peptalk',$segment_array);

        if($is_peptalk !==FALSE && $this->uri->segment($is_peptalk+1))
        {
            $is_peptalk = $this->uri->segment($is_peptalk+1);

            if($is_peptalk==YES)           
            	$where_condition.='j.other_inputs LIKE "%Peptalk%" AND j.other_inputs_text!="" AND ';
            else if($is_peptalk==NO)           
            	$where_condition.='j.other_inputs NOT LIKE "%Peptalk%" AND j.other_inputs_text="" AND ';

            if(in_array($is_peptalk,array(NO,YES)))
            	$redirect_url.='is_peptalk/'.$is_peptalk.'/';
		}

		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (u.first_name like '%".$search_value."%' OR d.name like '%".$search_value."%') AND ";
		  }
		
		#echo $users_where_condition; exit;
		$where_condition=rtrim($where_condition,'AND ');
		
		$totalFiltered=$this->jobs_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true,'group_by'=>'DATE(j.created)'));
		
		$records=$this->jobs_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by,'group_by'=>'DATE(j.created)'))->result_array();

		#echo $this->db->last_query();
		
		$json=array();
		
		$j=0;
		
		if($totalFiltered>0)
		{
			foreach($records as $record)
			{
				$permit_created=date('d-m-Y',strtotime($record['permit_created']));
				
				$json[$j]['permit_created']='<a target="_blank" href="'.base_url().'reports/jobs_report/index/subscription_date_start/'.$permit_created.'/subscription_date_end/'.$permit_created.$redirect_url.'">'.$permit_created.'</a>';	
				
				$height_work=$record['height_work'];
				
				if($height_work>0)
				$height_work='<a target="_blank" href="'.base_url().'reports/jobs_report/index/subscription_date_start/'.$permit_created.'/subscription_date_end/'.$permit_created.$redirect_url.'work_types/height_work">'.$height_work.'</a>';	
				
				
				$json[$j]['height_work']=$height_work;
				
				$hot_work=$record['hot_work'];
				
				if($hot_work>0)
				$hot_work='<a target="_blank" href="'.base_url().'reports/jobs_report/index/subscription_date_start/'.$permit_created.'/subscription_date_end/'.$permit_created.$redirect_url.'work_types/hot_work">'.$hot_work.'</a>';	
				
				$json[$j]['hot_work']=$hot_work;
				
				$general_work = $record['general_work'];
				
				if($general_work>0)
				$general_work='<a target="_blank" href="'.base_url().'reports/jobs_report/index/subscription_date_start/'.$permit_created.'/subscription_date_end/'.$permit_created.$redirect_url.'/work_types/general_work">'.$general_work.'</a>';	
				
				$json[$j]['general_work']=$general_work;
				
				$no_of_permits = $record['no_of_permits'];
				
				if($no_of_permits>0)
				$no_of_permits='<a target="_blank" href="'.base_url().'reports/jobs_report/index/subscription_date_start/'.$permit_created.'/subscription_date_end/'.$permit_created.$redirect_url.'">'.$no_of_permits.'</a>';	
				
				
				$json[$j]['no_of_permits']=$no_of_permits;	
				
				$j++;
			}
		}
		
		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}
	
	public function date_wise()
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

		$zones = array_search('zones',$segment_array);
		
        if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $selected_zones = explode(',',$this->uri->segment($zones+1));
		}
		else
			$selected_zones=array();
        
        $req=array('select'=>'id,name','table'=>ZONES,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Companys List
        $qry=$this->public_model->get_data($req);
		
        $this->data['zones']=$qry->result_array();            

		$req=array('select'=>'id,name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $this->data['departments']=$this->public_model->get_data($req)->result_array();

		$req=array('select'=>'id,name','table'=>CONTRACTORS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $this->data['contractors']=$this->public_model->get_data($req)->result_array();        

		  //Pass status from TAB 
	      $department_id=array_search('department_id',$segment_array);	
		  
		  if($department_id !==FALSE && $this->uri->segment($department_id+1)!='')
	      {
			 	$department_id=explode(',',$this->uri->segment($department_id+1));  
		  }  
		   else
		   $department_id=array();	      

	      $contractor_id=array_search('contractor_id',$segment_array);	
		  
		  if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1)!='')
	      {
			 	$contractor_id=explode(',',$this->uri->segment($contractor_id+1)); 
		  }  
		   else
		   $contractor_id=array();			     

		$this->data['contractor_id']=$contractor_id;

		$this->data['department_id']=$department_id;

        $this->data['selected_zones']=$selected_zones;
		
		$this->data['subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$this->data['subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));
		
		$this->load->view('reports/date_wise',$this->data);
	}

	public function ajax_search_date_wise()
	{
		#echo '<pre>'; print_r($this->input->get()); exit;
		
		$segment_array=$this->uri->segment_array();
		
        $subscription_date_start = array_search('subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));

		$zones = array_search('zones',$segment_array);

		$where='DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'"';

 		if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $zones = $this->uri->segment($zones+1);

            if($zones!='null')
            $where.=' AND j.zone_id IN('.$zones.')';
		}		
		
		$order_by = $_REQUEST['sort'];
		
		$order = $_REQUEST['order'];
		
		$offset = $_REQUEST['offset'];
		
		$limit = $_REQUEST['limit'];

		$req=array('select'=>'id,name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>$order);
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $fet_departments=$qry->result_array();
		
		$permits=unserialize(PERMITS);

		$subscription_dates = array();

		foreach($permits as $table_name => $label)
		{
			$get_jobs_info=$this->public_model->join_fetch_data(array('select'=>'d.id as department_id,d.name as department_name,count(j.id) as no_of_permits,DATE_FORMAT(j.created,"%d-%m-%Y") as created','table1'=>DEPARTMENTS. ' d','table2'=>$table_name.' j','join_on'=>'j.department_id = d.id and d.status ="'.STATUS_ACTIVE.'"','where'=>$where,'join_type'=>'left','order_by'=>$order_by,'order'=>$order,'length'=>$limit,'start'=>$offset,'num_rows'=>false,'group_by'=>'DATE_FORMAT(j.created,"%d-%m-%Y")'));
			
			#echo $this->db->last_query(); exit;
			$nums=$get_jobs_info->num_rows();	

			${$table_name.'_records'}=$get_jobs_info->result_array();

			if($nums>0)
			{
				$subscription_date=array_column(${$table_name.'_records'},'created');

				$subscription_dates = array_merge($subscription_date,$subscription_dates);
			}
		}
		
		$subscription_dates = array_unique($subscription_dates);

		$subscription_dates = array_map(function($value)
		{
		    return strtotime($value);
		}, $subscription_dates);
		
		

		$json=array();
		
		$j=$t=0;	

		if($order_by=='asc')
		asort($subscription_dates);
		else
		rsort($subscription_dates);		

		$subscription_dates = array_map(function($value)
		{
		    return date('d-m-Y',$value);
		}, $subscription_dates);	

		#echo '<pre>'; print_r($subscription_dates); exit;

		if(count($subscription_dates)>0)
		{
			foreach($subscription_dates as $subscription_date)
			{			
				$total=0;

				$json[$j]['j.created'] = $subscription_date;


				foreach($permits as $table_name => $label)
				{	
					$records = ${$table_name.'_records'};

					$no_of_permits=current(array_filter($records, function($e) use($subscription_date) { if($e['created'] == $subscription_date) { return ($e !== NULL && $e !== FALSE && $e !== ''); } }))['no_of_permits'];

					
					$json[$j][$table_name]=($no_of_permits>0) ? '<a target="_blank" href="'.base_url().'reports/'.$table_name.'_report/subscription_date_start/'.$subscription_date.'/subscription_date_end/'.$subscription_date.'" >'.$no_of_permits.'</a>' : 0;

					$total  = $total + $no_of_permits;

					$json[$j][$table_name.'_total'] = $no_of_permits;
					
				}

				$json[$j]['total_permits'] = '<b>'.$total.'</b>';

				$json[$j]['sum_permits'] = $total;
					
				$j++;
			}


			$json[$j]['j.created']='<b>Total</b>';

			foreach($permits as $table_name => $label)
			{
				$ar = array_sum(array_column($json,$table_name.'_total'));

				$json[$j][$table_name]='<b>'.$ar.'</b>';	
			}

			$json[$j]['total_permits'] = '<b>'.array_sum(array_column($json,'sum_permits')).'</b>';

			#echo '<pre>'; print_r($json); exit;
		}		
			
		$json=json_encode($json);
										
		echo $json;
		
		exit;
	}

	public function department_wise()
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

		$zones = array_search('zones',$segment_array);
		
        if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $selected_zones = explode(',',$this->uri->segment($zones+1));
		}
		else
			$selected_zones=array();
        
        $req=array('select'=>'id,name','table'=>ZONES,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Companys List
        $qry=$this->public_model->get_data($req);
		
        $this->data['zones']=$qry->result_array();         

        $req=array('select'=>'id,name','table'=>ZONES,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Companys List
        $qry=$this->public_model->get_data($req);
		
        $this->data['zones']=$qry->result_array();            

		$req=array('select'=>'id,name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $this->data['departments']=$this->public_model->get_data($req)->result_array();

		$req=array('select'=>'id,name','table'=>CONTRACTORS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $this->data['contractors']=$this->public_model->get_data($req)->result_array();        

		  //Pass status from TAB 
	      $department_id=array_search('department_id',$segment_array);	
		  
		  if($department_id !==FALSE && $this->uri->segment($department_id+1)!='')
	      {
			 	$department_id=explode(',',$this->uri->segment($department_id+1));  
		  }  
		   else
		   $department_id=array();	      

	      $contractor_id=array_search('contractor_id',$segment_array);	
		  
		  if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1)!='')
	      {
			 	$contractor_id=explode(',',$this->uri->segment($contractor_id+1)); 
		  }  
		   else
		   $contractor_id=array();			     

		$this->data['contractor_id']=$contractor_id;

		$this->data['department_id']=$department_id;           

        $this->data['selected_zones']=$selected_zones;
		
		$this->data['subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$this->data['subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));
		
		$this->load->view('reports/department_wise',$this->data);
	}

	public function ajax_search_department_wise()
	{
		#echo '<pre>'; print_r($this->input->get()); exit;

		#$redirect_url=$this->get_segment_array(array('controller'=>$this->data['controller'],'method'=>$this->data['method'])); exit;

		$redirect_url='';
		
		$segment_array=$this->uri->segment_array();
		
        $subscription_date_start = array_search('subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));

		$where='DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'"';

		$zones = array_search('zones',$segment_array);

 		if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $zones = $this->uri->segment($zones+1);

            if($zones!='null')
            {
            	$where.=' AND j.zone_id IN('.$zones.')';

            	$redirect_url.='/zone_id/'.$zones;
            }		
		}		

		$contractor_id = array_search('contractor_id',$segment_array);
		
 		if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1))
        {
            $contractor_id = $this->uri->segment($contractor_id+1);

            if($contractor_id!='null')
            {
            	$where.=' AND j.contractor_id IN('.$contractor_id.')';

            	$redirect_url.='/contractor_id/'.$contractor_id;
            }		
		}		

		/*$department_id = array_search('department_id',$segment_array);
		
 		if($department_id !==FALSE && $this->uri->segment($department_id+1))
        {
            $department_id = $this->uri->segment($department_id+1);

            if($department_id!='null')
            {
            	$where.=' AND j.department_id IN('.$department_id.')';

            	$redirect_url.='/department_id/'.$department_id;
            }		
		}	*/	
		
		$order_by = $_REQUEST['sort'];
		
		$order = $_REQUEST['order'];
		
		$offset = $_REQUEST['offset'];
		
		$limit = $_REQUEST['limit'];			

		$req=array('select'=>'id,name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>$order);
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $fet_departments=$qry->result_array();
		
		$permits=unserialize(PERMITS);

		foreach($permits as $table_name => $label)
		{
			$get_jobs_info=$this->public_model->join_fetch_data(array('select'=>'d.id as department_id,d.name as department_name,count(j.id) as no_of_permits','table1'=>DEPARTMENTS. ' d','table2'=>$table_name.' j','join_on'=>'j.department_id = d.id and d.status ="'.STATUS_ACTIVE.'"','where'=>$where,'join_type'=>'left','order_by'=>$order_by,'order'=>$order,'length'=>$limit,'start'=>$offset,'num_rows'=>false,'group_by'=>'d.id'));
			#echo $this->db->last_query(); exit;
		
			${$table_name.'_records'}=$get_jobs_info->result_array();
		}

		$json=array();
		
		$j=$t=0;	

		foreach($fet_departments as $departments)
		{
			$department_name = $departments['name'];

			$json[$j]['department_name']=$department_name;

			$department_id = $departments['id'];

			$total=0;

			foreach($permits as $table_name => $label)
			{	
				$records = ${$table_name.'_records'};

				$key = array_search($department_id, array_column($records, 'department_id'));

				if(is_numeric($key))
				$no_of_permits=($records[$key]['no_of_permits']) ? $records[$key]['no_of_permits'] : 0;
				else
				$no_of_permits=0;	
				
				$json[$j][$table_name]=($no_of_permits>0) ? '<a target="_blank" href="'.base_url().'reports/'.$table_name.'_report/subscription_date_start/'.$subscription_date_start.'/subscription_date_end/'.$subscription_date_end.'/department_id/'.$department_id.'/'.$redirect_url.'"  title="View '.$label.' '.$department_name.' Department Report">'.$no_of_permits.'</a>' : 0;	

				$json[$j][$table_name.'_total'] = $no_of_permits;

				$total  = $total + $no_of_permits;
			}

			$json[$j]['total_permits'] = '<b>'.$total.'</b>';

			$json[$j]['sum_permits'] = $total;
				
			$j++;
		}		
			
		$json[$j]['department_name']='<b>Total</b>';

		foreach($permits as $table_name => $label)
		{
			$ar = array_sum(array_column($json,$table_name.'_total'));

			$json[$j][$table_name]='<b>'.$ar.'</b>';	
		}

		$json[$j]['total_permits'] = '<b>'.array_sum(array_column($json,'sum_permits')).'</b>';

		#echo '<pre>'; print_r($json); 

		$json=json_encode($json);
										
		echo $json;
		
		exit;
	}
	


	public function zone_wise()
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
		
		$this->data['subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$this->data['subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));
		
		$this->load->view('reports/zone_wise',$this->data);
	}
	
	public function ajax_search_zone_wise()
	{
		#echo '<pre>'; print_r($this->input->get()); exit;
		
		$subscription_date_starts = $this->input->get('subscription_date_start');
		$subscription_date_start=date('Y-m-d',strtotime(str_replace('/','-',$subscription_date_starts)));
		
		$subscription_date_ends= $this->input->get('subscription_date_end');
		$subscription_date_end = date('Y-m-d',strtotime(str_replace('/','-',$subscription_date_ends)));
		
		$order_by = $_REQUEST['sort'];
		
		$order = $_REQUEST['order'];
		
		$offset = $_REQUEST['offset'];
		
		$limit = $_REQUEST['limit'];
		
		$where='DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'"';
		
		$get_account_info=$this->public_model->join_fetch_data(array('select'=>'z.id as zone_id,z.name as zone_name,count(j.id) as no_of_permits','table1'=>ZONES. ' z','table2'=>JOBS.' j','join_on'=>'j.zone_id = z.id and z.status ="'.STATUS_ACTIVE.'"','where'=>$where,'join_type'=>'left','order_by'=>$order_by,'order'=>$order,'length'=>$limit,'start'=>$offset,'num_rows'=>false,'group_by'=>'z.id'));

		$json=array();
		
		$j=0;
		
		$totalFiltered = $get_account_info->num_rows();
		
		if($totalFiltered>0)
		{
			$records=$get_account_info->result_array();
			
			foreach($records as $record)
			{
				$zone_id = $record['zone_id'];
				
				$zone_name = $record['zone_name'];
				
				$json[$j]['zone_name']='<a target="_blank" href="'.base_url().'permits/lists/subscription_date_start/'.str_replace('/','-',$subscription_date_starts).'/subscription_date_end/'.str_replace('/','-',$subscription_date_ends).'/zones/'.$zone_id.'">'.$zone_name.'</a>';	
;	
				
				$no_of_permits = $record['no_of_permits'];
				
				if($no_of_permits>0)
				$no_of_permits='<a target="_blank" href="'.base_url().'permits/lists/subscription_date_start/'.str_replace('/','-',$subscription_date_starts).'/subscription_date_end/'.str_replace('/','-',$subscription_date_ends).'/zones/'.$zone_id.'">'.$no_of_permits.'</a>';	
				
				$json[$j]['no_of_permits']=$no_of_permits;	
				
				$j++;
			}
		}
		
		$json=json_encode($json);
							
		#$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $json;
		
		exit;
	}
	
	public function name_wise()
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
		
		$this->data['selected_zones']=$selected_zones;
		
		$this->data['selected_departments']=$selected_departments;
		
		$this->load->view('reports/name_wise',$this->data);
	}
	
	public function ajax_search_name_wise()
	{
		$this->load->model(array('jobs_model'));
		#echo '<pre>'; print_r($this->input->post()); exit;
		
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
		
		$fields=array(0=>'u.first_name',1=>'d.name as department_name',2=>'count(j.id) as no_of_permits');
		
		$where_condition='DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';
		

		$departments = array_search('departments',$segment_array);
		
        if($departments !==FALSE && $this->uri->segment($departments+1))
        {
            $selected_departments = $this->uri->segment($departments+1);
			
			if($selected_departments!='null')
			$where_condition.='j.department_id IN('.$selected_departments.') AND ';
		}
			
		$zones = array_search('zones',$segment_array);
		
        if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $selected_zones = $this->uri->segment($zones+1);
			
			if($selected_zones!='null')
			$where_condition.='j.zone_id IN('.$selected_zones.') AND ';
		}
		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (u.first_name like '%".$search_value."%' OR d.name like '%".$search_value."%') AND ";
		  }
		
		
		$user_id='u.id';
		
			$arr = range('a', 'f');
			
			$i_qry=$p_qry=''; //{"a":"15","b":"","c":"","d":"","e":"","f":""} Need to change in reports controller
				for($i=0;$i<count($arr);$i++)
				{
					$i_qry.='(issuing_authority like \'%"'.$arr[$i].'":'.$user_id.'%\') OR ';
					$p_qry.='(performing_authority like \'%"'.$arr[$i].'":'.$user_id.'%\') OR ';
				}
				$i_qry=rtrim($i_qry,'OR ');
				$p_qry=rtrim($p_qry,'OR ');
				
	$users_where_condition=' ((j.acceptance_issuing_id = '.$user_id.' OR j.cancellation_issuing_id = '.$user_id.') OR  (j.acceptance_performing_id = '.$user_id.' OR j.cancellation_performing_id = '.$user_id.')) OR ('.$i_qry.') OR ('.$p_qry.')';
		
			#echo $users_where_condition; exit;
			$where_condition=rtrim($where_condition,'AND ');
		
		$totalFiltered=$this->jobs_model->fetch_data(array('users_where_condition'=>$users_where_condition,'where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true,'users'=>true,'group_by'=>'u.id'));
		
		$records=$this->jobs_model->fetch_data(array('users_where_condition'=>$users_where_condition,'join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by,'users'=>true,'group_by'=>'u.id'))->result_array();

		#echo $this->db->last_query();
		
		$json=array();
		
		$j=0;
		
		if($totalFiltered>0)
		{
			foreach($records as $record)
			{
				
				$json[$j]['first_name']=$record['first_name'];	
				
				$json[$j]['department_name']=$record['department_name'];
				
				$json[$j]['no_of_permits']=$record['no_of_permits'];	
				
				$j++;
			}
		}
		
		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}
	
	public function open_permits()
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
		
		$this->data['selected_zones']=$selected_zones;
		
		$this->data['selected_departments']=$selected_departments;
		
		$this->load->view('reports/open_permits',$this->data);
	}
	
	public function ajax_search_open_permits()
	{
		$this->load->model(array('jobs_model'));
		#echo '<pre>'; print_r($this->input->post()); exit;
		
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
		
		$fields=array(0=>'DATE(j.created) as permit_created',1=>'SUM(CASE WHEN j.work_types LIKE "%height_work%" THEN 1 ELSE 0 END) as height_work',2=>'count(j.id) as no_of_permits',3=>'SUM(CASE WHEN j.work_types LIKE "%general_work%" THEN 1 ELSE 0 END) as general_work',4=>'SUM(CASE WHEN j.work_types LIKE "%hot_work%" THEN 1 ELSE 0 END) as hot_work');
		
		$where_condition='DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND j.approval_status NOT IN(4,6,9) AND ';
		

		$departments = array_search('departments',$segment_array);
		
        if($departments !==FALSE && $this->uri->segment($departments+1))
        {
            $selected_departments = $this->uri->segment($departments+1);
			
			if($selected_departments!='null')
			$where_condition.='j.department_id IN('.$selected_departments.') AND ';
		}
			
		$zones = array_search('zones',$segment_array);
		
        if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $selected_zones = $this->uri->segment($zones+1);
			
			if($selected_zones!='null')
			$where_condition.='j.zone_id IN('.$selected_zones.') AND ';
		}
		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (u.first_name like '%".$search_value."%' OR d.name like '%".$search_value."%') AND ";
		  }
		
		#echo $users_where_condition; exit;
		$where_condition=rtrim($where_condition,'AND ');
		
		$totalFiltered=$this->jobs_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true,'group_by'=>'DATE(j.created)'));
		
		$records=$this->jobs_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by,'group_by'=>'DATE(j.created)'))->result_array();

		#echo $this->db->last_query();
		
		$json=array();
		
		$j=0;
		
		$link='/permit_status/'.STATUS_OPENED;
		
		if($totalFiltered>0)
		{
			foreach($records as $record)
			{
				
				$permit_created=date('d-m-Y',strtotime($record['permit_created']));
				
				$json[$j]['permit_created']='<a target="_blank" href="'.base_url().'permits/lists/subscription_date_start/'.$permit_created.'/subscription_date_end/'.$permit_created.$link.'">'.$permit_created.'</a>';	
				
				$height_work=$record['height_work'];
				
				if($height_work>0)
				$height_work='<a target="_blank" href="'.base_url().'permits/lists/subscription_date_start/'.$permit_created.'/subscription_date_end/'.$permit_created.'/work_types/height_work'.$link.'">'.$height_work.'</a>';	
				
				
				$json[$j]['height_work']=$height_work;
				
				$hot_work=$record['hot_work'];
				
				if($hot_work>0)
				$hot_work='<a target="_blank" href="'.base_url().'permits/lists/subscription_date_start/'.$permit_created.'/subscription_date_end/'.$permit_created.'/work_types/hot_work'.$link.'">'.$hot_work.'</a>';	
				
				$json[$j]['hot_work']=$hot_work;
				
				$general_work = $record['general_work'];
				
				if($general_work>0)
				$general_work='<a target="_blank" href="'.base_url().'permits/lists/subscription_date_start/'.$permit_created.'/subscription_date_end/'.$permit_created.'/work_types/general_work'.$link.'">'.$general_work.'</a>';	
				
				$json[$j]['general_work']=$general_work;
				
				$no_of_permits = $record['no_of_permits'];
				
				if($no_of_permits>0)
				$no_of_permits='<a target="_blank" href="'.base_url().'permits/lists/subscription_date_start/'.$permit_created.'/subscription_date_end/'.$permit_created.$link.'">'.$no_of_permits.'</a>';	
				
				
				$json[$j]['no_of_permits']=$no_of_permits;	
				
				/*$json[$j]['permit_created']=date('d-m-Y',strtotime($record['permit_created']));	
				
				$json[$j]['height_work']=$record['height_work'];
				
				$json[$j]['hot_work']=$record['hot_work'];
				
				$json[$j]['general_work']=$record['general_work'];
				
				$json[$j]['no_of_permits']=$record['no_of_permits'];	*/
				
				$j++;
			}
		}
		
		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}
	
	public function permits_time_calc()
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
		
		$departments = array_search('departments',$segment_array);
		
        if($departments !==FALSE && $this->uri->segment($departments+1))
        {
            $selected_departments = $this->uri->segment($departments+1);
		}
		else
			$selected_departments='';
			
		$users = array_search('users',$segment_array);
		
        if($users !==FALSE && $this->uri->segment($users+1))
        {
            $selected_users = $this->uri->segment($users+1);
		}
		else
			$selected_users='';
			
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
			
        $permit_no = array_search('permit_no',$segment_array);

        if($permit_no !==FALSE && $this->uri->segment($permit_no+1))
        {
            $permit_no = $this->uri->segment($permit_no+1);
		}
		else
		$permit_no = '';
		
        $req=array('select'=>'id,first_name','table'=>USERS,'where_condition'=>array('status'=>STATUS_ACTIVE,'user_role'=>''),'column'=>'first_name','dir'=>'asc');
        $qry=$this->public_model->get_data($req);
		
        $this->data['users']=$qry->result_array();            
		
		
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
		
		$this->data['selected_users'] = $selected_users;
		
		$this->data['selected_work_types'] = $selected_work_types;
		
		$this->data['selected_zones']=$selected_zones;
		
		$this->data['selected_departments']=$selected_departments;
		
		$this->data['selected_permit_status']= $selected_permit_status;
		
		$this->data['permit_no'] = $permit_no;
		
		$this->load->view('reports/permits_time_calc',$this->data);
	}
	
	public function ajax_search_permits_time_calc()
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

		$users = array_search('users',$segment_array);
		
        if($users !==FALSE && $this->uri->segment($users+1))
        {
            $selected_users = $this->uri->segment($users+1);
			
			if($selected_users!='null')
			{
				
				$arr = range('a', 'f');
				
				$qry=''; //{"a":"15","b":"","c":"","d":"","e":"","f":""} Need to change in reports controller
					for($i=0;$i<count($arr);$i++)
					{
						$qry.=' (j.issuing_authority like \'%"'.$arr[$i].'":"'.$selected_users.'"%\') OR (j.performing_authority like \'%"'.$arr[$i].'":"'.$selected_users.'"%\') OR ';
					}
				$qry=rtrim($qry,'OR ');
				
				#$qry.=')';					
				$where_condition.=' ((j.acceptance_issuing_id = "'.$selected_users.'" OR j.cancellation_issuing_id = "'.$selected_users.'") OR (j.acceptance_performing_id = "'.$selected_users.'" OR j.cancellation_performing_id = "'.$selected_users.'") OR ('.$qry.')) AND ';
			}
		}


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
		
		$permit_status = array_search('permit_status',$segment_array);
		
        if($permit_status !==FALSE && $this->uri->segment($permit_status+1))
        {
            $selected_permit_status = $this->uri->segment($permit_status+1);
			
			if($selected_permit_status!='null')
			{
				$selected_permit_status = explode(',',$selected_permit_status);
					
				$selected_permit_status="'" . implode("','", $selected_permit_status) . "'";
				
				$where_condition.=' j.status IN('.$selected_permit_status.') AND ';
			}
		}
		
		
			
		$zones = array_search('zones',$segment_array);
		
        if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $selected_zones = $this->uri->segment($zones+1);
			
			if($selected_zones!='null')
			$where_condition.='j.zone_id IN('.$selected_zones.') AND ';
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
		  
		  $datetime=date('Y-m-d H:i');
		
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
							16=>'j.acceptance_performing_date',
							17=>'j.acceptance_issuing_date',
							18=>'(CASE WHEN j.acceptance_issuing_date!="" THEN CONCAT(MINUTE(TIMEDIFF(STR_TO_DATE(REPLACE(CASE WHEN j.acceptance_issuing_date!="" THEN j.acceptance_issuing_date ELSE "'.$datetime.'" END,\'-\',\'/\'), \'%d/%m/%Y %T\'),STR_TO_DATE(REPLACE(j.acceptance_performing_date,\'-\',\'/\'), \'%d/%m/%Y %T\'))),"mins") ELSE MINUTE(TIMEDIFF("'.$datetime.'",j.acceptance_performing_date)) END) as ia_time_diff',
							19=>'(CASE WHEN j.acceptance_issuing_date !="" THEN CONCAT(MINUTE(TIMEDIFF(j.final_status_date,STR_TO_DATE(REPLACE(j.acceptance_issuing_date,\'-\',\'/\'), \'%d/%m/%Y %T\'))),"mins") ELSE "Waiting IA Approval" END) as final_submit_diff'
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
				
				#echo $record['acceptance_performing_id'].' , '.$record['acceptance_issuing_id'];
				$users_in=array($record['acceptance_performing_id'],$record['acceptance_issuing_id']);
				
				$users=implode(',',$users_in);
				
				$users=$this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id,last_name','where_condition'=>'id IN('.$users.')'))->result_array();
				
				$auth_PA=$auth_IA='';
				
				#print_r($users);
				
				foreach($users as $user):
				
				$name=$user['first_name'].' '.$user['last_name'];
					
						if($user['id']==$record['acceptance_performing_id'])
						$auth_PA=$name;
						else if($user['id']==$record['acceptance_issuing_id'])
						$auth_IA=$name;
				
				endforeach;
				
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';	
				
				$acceptance_performing_date = $record['acceptance_performing_date'];
				
				$acceptance_issuing_date = $record['acceptance_issuing_date'];
				
				$ia_time_diff = $record['ia_time_diff'];	
				
				$final_submit_diff= $record['final_submit_diff'];		
						
						$json[$j]['final_submit_diff'] = $final_submit_diff;
						$json[$j]['ia_time_diff'] = $ia_time_diff;
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
						$json[$j]['acceptance_issuing_date']=$acceptance_issuing_date;
						$json[$j]['acceptance_performing_date']=$acceptance_performing_date;
						$j++;
			}
		}
				
		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}
	
	
	public function loto_time_calc()
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
		
		$departments = array_search('departments',$segment_array);
		
        if($departments !==FALSE && $this->uri->segment($departments+1))
        {
            $selected_departments = $this->uri->segment($departments+1);
		}
		else
			$selected_departments='';
			
		$users = array_search('users',$segment_array);
		
        if($users !==FALSE && $this->uri->segment($users+1))
        {
            $selected_users = $this->uri->segment($users+1);
		}
		else
			$selected_users='';
			
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
			
        $permit_no = array_search('permit_no',$segment_array);

        if($permit_no !==FALSE && $this->uri->segment($permit_no+1))
        {
            $permit_no = $this->uri->segment($permit_no+1);
		}
		else
		$permit_no = '';
		
        $req=array('select'=>'id,first_name','table'=>USERS,'where_condition'=>array('status'=>STATUS_ACTIVE,'user_role'=>''),'column'=>'first_name','dir'=>'asc');
        $qry=$this->public_model->get_data($req);
		
        $this->data['users']=$qry->result_array();            
		
		
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
		
		$this->data['selected_users'] = $selected_users;
		
		$this->data['selected_work_types'] = $selected_work_types;
		
		$this->data['selected_zones']=$selected_zones;
		
		$this->data['selected_departments']=$selected_departments;
		
		$this->data['selected_permit_status']= $selected_permit_status;
		
		$this->data['permit_no'] = $permit_no;
		
		$this->load->view('reports/loto_time_calc',$this->data);
	}
	
	public function ajax_search_loto_time_calc()
	{
		$this->load->model(array('jobs_isolations_model','jobs_model'));
		#echo '<pre>'; print_r($this->input->post()); exit;
		
		 $job_approval_status=unserialize(EIPAPPROVALS);
		 
		 $job_approval_status_color=unserialize(EIPAPPROVALS_COLOR);
		
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
		
		$where_condition='( (DATE(j.date_start) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'") OR (DATE(j.date_end) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'")) AND';		
		
		$users = array_search('users',$segment_array);
		
        if($users !==FALSE && $this->uri->segment($users+1))
        {
            $user_id = $this->uri->segment($users+1);
			
			if($user_id!='null')
			{

				$qry='('; //{"a":"15","b":"","c":"","d":"","e":"","f":""}
				
				for($i=1;$i<=10;$i++)
				{
					$qry.=' j.isolated_name like \'%"'.$i.'":"'.$user_id.'"%\' OR ';
					
					if($i<=3)
					$qry.=' j.temporary_re_iso like \'%"'.$i.'":"'.$user_id.'"%\' OR j.temporary_iso like \'%"'.$i.'":"'.$user_id.'"%\' OR ';
				}
				$qry=rtrim($qry,'OR ');
				
				$qry.=')';

				$eip_completed_departments=unserialize(EIP_COMPLETED_DEPARTMENTS);
				
				$qry.=' OR (';
				
				for($e=0;$e<count($eip_completed_departments);$e++)
				{
					$qry.=' (j.department_completion_users like \'%"'.$eip_completed_departments[$e].'":"'.$user_id.'"%\') OR ';
				}
				
				$qry=rtrim($qry,'OR ');
				
				$qry.=')';

				$ia_qry='(';
				
				$pa_qry='(';
				
				for($i=1;$i<=3;$i++)
				{
					$ia_qry.=' j.temporary_re_ia like \'%"'.$i.'":"'.$user_id.'"%\' OR j.temporary_ia like \'%"'.$i.'":"'.$user_id.'"%\'
					 OR ';
					$pa_qry.=' j.temporary_re_pa like \'%"'.$i.'":"'.$user_id.'"%\' OR j.temporary_pa like \'%"'.$i.'":"'.$user_id.'"%\' 
					OR ';
				}
				$ia_qry=rtrim($ia_qry,'OR ');
				$ia_qry.=')';
				$pa_qry=rtrim($pa_qry,'OR ');
				$pa_qry.=')';

				
				$where_condition.=' j.remarks_issuing_id = "'.$user_id.'" OR j.issuing_authority_id2 = "'.$user_id.'" OR 
				j.issuing_authority_id3 = "'.$user_id.'" OR '.$ia_qry.' OR ';
				
				$where_condition.=' j.remarks_performing_id = "'.$user_id.'") OR  '.$pa_qry.' OR ';
				
				$where_condition.=$qry.' OR ';
				
				$where_condition=' j.remarks_issuing_id = "'.$user_id.'" OR j.issuing_authority_id2 = "'.$user_id.'" OR 
				j.issuing_authority_id3 = "'.$user_id.'"  OR '.$ia_qry.' OR j.remarks_performing_id = "'.$user_id.'"  OR  '.$pa_qry.'  
				OR '.$qry.' AND ';
			}
		}
		
		#echo $where_condition; exit;

		$permit_status = array_search('permit_status',$segment_array);
		
        if($permit_status !==FALSE && $this->uri->segment($permit_status+1))
        {
            $selected_permit_status = $this->uri->segment($permit_status+1);
			
			if($selected_permit_status!='null')
			{
				$selected_permit_status = explode(',',$selected_permit_status);
					
				$selected_permit_status="'" . implode("','", $selected_permit_status) . "'";
				
				$where_condition.=' j.status IN('.$selected_permit_status.') AND ';
			}
		}


		$departments = array_search('departments',$segment_array);
		
        if($departments !==FALSE && $this->uri->segment($departments+1))
        {
            $selected_departments = $this->uri->segment($departments+1);
			
			if($selected_departments!='null')
			$where_condition.='j.department_id IN('.$selected_departments.') AND ';
		}
		
		$zones = array_search('zones',$segment_array);
		
        if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $selected_zones = $this->uri->segment($zones+1);
			
			if($selected_zones!='null')
			$where_condition.='j.zone_id IN('.$selected_zones.') AND ';
		}
		
		$permit_no = array_search('permit_no',$segment_array);
		
        if($permit_no !==FALSE && $this->uri->segment($permit_no+1))
        {
            $permit_no = $this->uri->segment($permit_no+1);
			
			if($permit_no!='null')
			$where_condition.='j.work_permit_nos LIKE "%'.$permit_no.'%" AND ';
		}

		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (j.area like '%".$search_value."%' OR j.section like '%".$search_value."%' OR j.equipment_descriptions like '%".$search_value."%' OR j.equipment_tag_nos like '%".$search_value."%') AND ";
		  }
		  
		  $datetime=date('Y-m-d H:i');
		  
		  
		$fields = array( 
							0 =>'j.id', 
							9=>'j.approval_status',
							10=>'j.remarks_performing_id',
							11=>'j.remarks_issuing_id',
							16=>'j.remarks_performing_date',
							17=>'j.remarks_issuing_date',
							18=>'(CASE WHEN j.remarks_issuing_date!="" THEN CONCAT(MINUTE(TIMEDIFF(STR_TO_DATE(REPLACE(CASE WHEN j.remarks_issuing_date!="" THEN j.remarks_issuing_date ELSE "'.$datetime.'" END,\'-\',\'/\'), \'%d/%m/%Y %T\'),STR_TO_DATE(REPLACE(j.remarks_performing_date,\'-\',\'/\'), \'%d/%m/%Y %T\'))),"mins") ELSE MINUTE(TIMEDIFF("'.$datetime.'",j.remarks_performing_date)) END) as ia_time_diff',
							19=>'(CASE WHEN j.issuing_authority_id2 !="" THEN CONCAT(MINUTE(TIMEDIFF(j.final_status_date,STR_TO_DATE(REPLACE(j.issuing_authority_id2_date,\'-\',\'/\'), \'%d/%m/%Y %T\'))),"mins") ELSE "Waiting IA Approval" END) as final_submit_diff',
							20=>'j.status'
						);
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->jobs_isolations_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->jobs_isolations_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		
		#echo $this->db->last_query();  exit;
		
		$json=array();
		
		if($totalFiltered>0)
		{
			$j=0;
			
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$redirect=base_url().'jobs_isolations/form/id/'.$id;
				
				$status=$record['status'];

				$approval_status=$record['approval_status'];
				
				if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
				$color=$job_approval_status_color[$job_approval_status[$approval_status]];
				else
				$color='';
				
				#echo $record['acceptance_performing_id'].' , '.$record['acceptance_issuing_id'];
				$users_in=array($record['remarks_performing_id'],$record['remarks_issuing_id']);
				
				$users=implode(',',$users_in);
				
				$users=$this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id,last_name','where_condition'=>'id IN('.$users.')'))->result_array();
				
				$auth_PA=$auth_IA='';
				
				#print_r($users);
				
				foreach($users as $user):
				
				$name=$user['first_name'].' '.$user['last_name'];
					
						if($user['id']==$record['remarks_performing_id'])
						$auth_PA=$name;
						else if($user['id']==$record['remarks_issuing_id'])
						$auth_IA=$name;
				
				endforeach;
				
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';	
				
				$remarks_performing_date = $record['remarks_performing_date'];
				
				$remarks_issuing_date = $record['remarks_issuing_date'];
				
				$ia_time_diff = $record['ia_time_diff'];	
				
				$final_submit_diff= $record['final_submit_diff'];		
						
						$json[$j]['id']='<a href="'.$redirect.'">'.'#'.$id.'</a>';
						$json[$j]['auth_PA']=strtoupper($auth_PA);
						$json[$j]['auth_IA']=strtoupper($auth_IA);
						$json[$j]['remarks_performing_date']=$remarks_performing_date;
						$json[$j]['remarks_issuing_date'] = $remarks_issuing_date;
						
						$json[$j]['ia_time_diff'] = $ia_time_diff;
						$json[$j]['final_submit_diff'] = $final_submit_diff;

						$json[$j]['status']=ucfirst($status);
						$j++;
			}
		}
				
		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}

	public function ajax_update_status()
	{

		$ids=$this->input->post('ids');

		$table_name=$this->input->post('table_name');

		$self_cancel_description=$this->input->post('self_cancel_description');
                       
        $id="'" . implode("','", $ids) . "'"; 

        $user_name=$this->session->userdata(ADMIN.'first_name');
		
		$user_id=$this->session->userdata(ADMIN.'user_id');

        if($table_name==JOBS)
        $approval_status=10;
    	else if($table_name==EXCAVATIONPERMITS)
    	$approval_status=6;	
        else if($table_name==CONFINEDPERMITS)
        $approval_status=13;
        else
        $approval_status=10;		
        	
        
        $array_values=array('status'=>'Cancellation','self_cancellation_description'=>$self_cancel_description,'modified'=>date('Y-m-d H:i:s'),'approval_status'=>$approval_status);   
                         
        $this->db->where('id IN ('.$id.')');

        $this->db->update($table_name,$array_values);     

        $msg='<b>Self Cancelled</b> by Superadmin';	

        $array=array();

        foreach($ids as $id)
        {
        	$array[]=array('user_id'=>$user_id,'job_id'=>$id,'notes'=>$msg,'created'=>date('Y-m-d H:i'));
		}	

		$this->db->insert_batch(JOBSHISTORY,$array);


	}
	
	function get_segment_array($array_args)
	{
	   extract($array_args);

	   $current_url=uri_string(); 

	   $base_url = $controller;

	   $return=str_replace($base_url,'',$current_url);

	   $base_url = $method;   

	   $return=str_replace($base_url,'',$return);

	   return $return;
	}

	
	
}
?>
