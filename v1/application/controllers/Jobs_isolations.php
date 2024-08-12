<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Jobs.php
 * Project        : Form Work
 * Creation Date  : 08-14-2016
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	


class Jobs_isolations extends CI_Controller
 {

	function __construct()
	{
		parent::__construct(); 
        $this->load->model(array('public_model','security_model','jobs_model','departments_model','jobs_isolations_model'));
		$this->security_model->chk_login();        
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}


	public function index()
	{ 
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'))->result_array();

			#print_r($this->session->userdata); exit;
		$zone_id=$this->session->userdata('zone_id');
		
		$params_url=$where=$department_id='';
		
		$segment_array=$this->uri->segment_array();
		
		  //Pass status from TAB 
          $user_role=array_search('user_role',$segment_array);	
		  
		  if($user_role !==FALSE && $this->uri->segment($user_role+1)!='')
          {
			 	$user_role=$this->uri->segment($user_role+1);        
		  }  
		  else
		  $user_role='PA';
		  
		  
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
			$approval_status='PA';
			
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
		$subscription_date_end = date('Y-m-d',strtotime("+30 days"));
		
		
		#$this->data['filters'][$approval_status.'subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		#$this->data['filters'][$approval_status.'subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));
		  
			
          $zone_id=array_search($user_role.'zone_id',$segment_array);	
		  
		  if($zone_id !==FALSE && $this->uri->segment($zone_id+1)!='')
          {
			 	$zone_id=$this->uri->segment($zone_id+1);        
				         
                $params_url.='/zone_id/'.$zone_id;
		  }  
		   else
		   $zone_id='';
			
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
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'))->result_array();

			#print_r($this->session->userdata); exit;
		$zone_id=$this->session->userdata('zone_id');
		
		$params_url=$where=$department_id='';
		
		$segment_array=$this->uri->segment_array();
		
		  //Pass status from TAB 
          $user_role=array_search('user_role',$segment_array);	
		  
		  if($user_role !==FALSE && $this->uri->segment($user_role+1)!='')
          {
			 	$user_role=$this->uri->segment($user_role+1);        
		  }  
		  else
		  $user_role='All';
		  
		  
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
			$approval_status='PA';
			
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
			
          $zone_id=array_search($user_role.'zone_id',$segment_array);	
		  
		  if($zone_id !==FALSE && $this->uri->segment($zone_id+1)!='')
          {
			 	$zone_id=$this->uri->segment($zone_id+1);        
				         
                $params_url.='/zone_id/'.$zone_id;
		  }  
		   else
		   $zone_id='';
			
		$filters[$user_role.'zone_id']=$zone_id;
		  
		$filters[$user_role.'approval_status']=$params_url;
		
		$filters[$user_role.'subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$filters[$user_role.'subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));
		
		$filters['filter_status'] = $user_role;
			
		$this->data['filters']=$filters;	
	
		$this->load->view($this->data['controller'].'day_in_process',$this->data);
	}


	public function ajax_fetch_data()
		{
			
			$user_id=$this->session->userdata('user_id');
			
			 $job_approval_status=unserialize(EIPAPPROVALS);
			 
			 $job_approval_status_color=unserialize(EIPAPPROVALS_COLOR);
			 
			$segment_array=$this->uri->segment_array();
			
			$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));

			#echo '<br /> Params '.$param_url;

			$requestData= $_REQUEST;

			$search=$where_condition='';
			
			$department_id=$this->session->userdata('department_id');
			
			$depts=$department_id.','.EIP_OTHER_DEPARTMENT;
			
			$where_condition='';
			
			#$where_condition=" j.department_id IN(".$depts.") AND ";
			
			#echo $where_condition;
	        $user_role = array_search('user_role',$this->uri->segment_array());
			
				
				$qry='('; //{"a":"15","b":"","c":"","d":"","e":"","f":""}
					for($i=1;$i<=20;$i++)
					{
						$qry.=' (j.isolated_name like \'%"'.$i.'":"'.$user_id.'"%\') OR ';
						
						if($i<=3)
						$qry.=' (jr.temporary_re_iso like \'%"'.$i.'":"'.$user_id.'"%\' OR jr.temporary_iso like \'%"'.$i.'":"'.$user_id.'"%\') OR ';
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

					$iso_qry='(';
					
					for($i=1;$i<=3;$i++)
					{
						$ia_qry.=' (jr.temporary_re_ia like \'%"'.$i.'":"'.$user_id.'"%\' OR jr.temporary_ia like \'%"'.$i.'":"'.$user_id.'"%\')
						 OR ';
						$pa_qry.=' (jr.temporary_re_pa like \'%"'.$i.'":"'.$user_id.'"%\' OR jr.temporary_pa like \'%"'.$i.'":"'.$user_id.'"%\') 
						OR ';
						$iso_qry.=' (jr.temporary_iso like \'%"'.$i.'":"'.$user_id.'"%\' OR jr.temporary_re_iso like \'%"'.$i.'":"'.$user_id.'"%\')
						 OR ';

					}
					$ia_qry=rtrim($ia_qry,'OR ');
					$ia_qry.=')';
					$pa_qry=rtrim($pa_qry,'OR ');
					$pa_qry.=')';
					$iso_qry=rtrim($iso_qry,'OR ');
					$iso_qry.=')';



	        if($user_role !==FALSE && $this->uri->segment($user_role+1))
	        {
	            $user_role = $this->uri->segment($user_role+1);
				
				if($user_role=='IA')
				$where_condition.=' (j.remarks_issuing_id = "'.$user_id.'" OR j.issuing_authority_id2 = "'.$user_id.'" OR 
				j.issuing_authority_id3 = "'.$user_id.'") OR '.$ia_qry.' AND ';
				else if($user_role=='PA')
				$where_condition.=' (j.remarks_performing_id = "'.$user_id.'" OR j.performing_authority_id2 = "'.$user_id.'" OR j.performing_authority_id3 = "'.$user_id.'") OR  '.$pa_qry.' AND ';
				else if($user_role=='Isolation')
				$where_condition.=$qry.' OR '.$iso_qry.' AND ';
				else
				$where_condition=' (j.remarks_issuing_id = "'.$user_id.'" OR j.issuing_authority_id2 = "'.$user_id.'" OR 
				j.issuing_authority_id3 = "'.$user_id.'"  OR '.$ia_qry.') OR (j.remarks_performing_id = "'.$user_id.'"  OR j.performing_authority_id2 = "'.$user_id.'" OR j.performing_authority_id3 = "'.$user_id.'" OR '.$pa_qry.')  OR '.$iso_qry.' OR '.$qry;
			}
			
			
			
	        $subscription_date_start = array_search($user_role.'subscription_date_start',$segment_array);

	        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
			
			$subscription_date_end = array_search($user_role.'subscription_date_end',$segment_array);
			
			$subscription_date_end = $this->uri->segment($subscription_date_end+1);
			
			$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
			
			$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));
			
			$where_condition=rtrim($where_condition,'AND ');

			$where_condition='('.$where_condition.') AND ( (DATE(j.date_start) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'") OR (DATE(j.date_end) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'")) AND';		

	        $zone_id = array_search($user_role.'zone_id',$this->uri->segment_array());

	        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
	        {
	            $zone_id = $this->uri->segment($zone_id+1);
				
				$where_condition.=" j.zone_id ='".$zone_id."' AND ";
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

			 $show=array_search('show',$segment_array);	
			  
			  if($show !==FALSE && $this->uri->segment($show+1)!='')
	          {
				 	$show=$this->uri->segment($show+1);       

				 	if($show=='hide')
				 	$where_condition.=" j.approval_status NOT IN(11,12) AND "; 
			  }  	 

			 # echo $where_condition; exit;

			
			  //Getting in URL params
			  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
			  
			  if($search_value!='')
			  {
				  $where_condition.=" (j.eip_no LIKE '%".$search_value."%' OR  j.section like '%".$search_value."%' OR j.area like '%".$search_value."%' OR j.equipment_descriptions like '%".$search_value."%' ) AND ";
			  }
			
			#echo $where_condition; 
			$fields = array( 
								0 =>'j.id', 
								1 =>'j.section',
								2=> 'j.area',
								5=>'j.date_start',
								6=>'j.status',
								7=>'j.date_end',							
								9=>'j.approval_status',
								10=>'j.remarks_issuing_id',
								11=>'j.isolated_name',
								12=>'j.isolated_name_approval',
								13=>'j.issuing_authority_id2',
								14=>'j.performing_authority_id2',
								15=>'j.isolated_name_approval',						
								16=>'j.remarks_performing_id',
								17=>'jr.temporary_ia',
								18=>'jr.temporary_ia_signdates',
								19=>'jr.temporary_iso',
								20=>'jr.temporary_iso_signdates',
								21=>'j.eip_no'
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

				if($show!='hide')
					$param_url='/jobs_isolations/index/'.$param_url;
				else
					$param_url='/jobs_isolations/day_in_process/'.$param_url;

				#echo 'Redirect '.$redirect;
				
				foreach($records as $record)
				{
					
					$id=$record['id'];

					$redirect=base_url().'jobs_isolations/form/id/'.$id.$param_url;
					
					$section=($record['section']) ? $record['section'] : ' - - -';
					
					$section='<a href="'.$redirect.'">'.strtoupper($section).'</a>';
					
					$area=($record['area']) ? strtoupper($record['area']) : ' - - -';
					
					$date_start=date(DATE_FORMAT,strtotime($record['date_start']));
					
					$date_end=date(DATE_FORMAT,strtotime($record['date_end']));
					
					$status=$record['status'];

					$approval_status=$record['approval_status'];

					$eip_no=$record['eip_no'];

					#$waiating_approval_by=$this->jobs_isolations_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'record'=>$record));
					
					$waiating_approval_by='---';		

					#echo $approval_status.$id;

					if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
					$color=$job_approval_status_color[$job_approval_status[$approval_status]];
					else
					$color='';
					
					$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
					
					$approval_status='<a href="javascript:void(0);" data-id="'.$id.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
					
					$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';				

					
					$json[$j]['eip_no']='<a href="'.$redirect.'" data-isoloation_permit_no="'.$id.'" title="Energy Isolation Permit Form" >'.$eip_no.'</a>';
							$json[$j]['section']=$section;
							$json[$j]['area']=$area;
							$json[$j]['date_start']=$date_start;						
							$json[$j]['date_end']=$date_end;#.' - '.$search;
							$json[$j]['status']=ucfirst($status);
							$json[$j]['waiating_approval_by']=ucfirst($waiating_approval_by);						
							$json[$j]['approval_status']=$approval_status;
							$json[$j]['action']=$print;
							$j++;
				}
			}

			$json=json_encode($json);
								
			$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
			
			echo $return;
			
			exit;
		}

	public function ZOLDajax_fetch_data()
	{
		
		$user_id=$this->session->userdata('user_id');
		
		 $job_approval_status=unserialize(EIPAPPROVALS);
		 
		 $job_approval_status_color=unserialize(EIPAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));

		#echo '<br /> Params '.$param_url;

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');
		
		$depts=$department_id.','.EIP_OTHER_DEPARTMENT;
		
		$where_condition='';
		
		#$where_condition=" j.department_id IN(".$depts.") AND ";
		
		#echo $where_condition;
        $user_role = array_search('user_role',$this->uri->segment_array());
		
			
			$qry='('; //{"a":"15","b":"","c":"","d":"","e":"","f":""}
				for($i=1;$i<=10;$i++)
				{
					$qry.=' (j.isolated_name like \'%"'.$i.'":"'.$user_id.'"%\') OR ';
					
					if($i<=3)
					$qry.=' (j.temporary_re_iso like \'%"'.$i.'":"'.$user_id.'"%\' OR j.temporary_iso like \'%"'.$i.'":"'.$user_id.'"%\') OR ';
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

				$iso_qry='(';
				
				for($i=1;$i<=3;$i++)
				{
					$ia_qry.=' (j.temporary_re_ia like \'%"'.$i.'":"'.$user_id.'"%\' OR j.temporary_ia like \'%"'.$i.'":"'.$user_id.'"%\')
					 OR ';
					$pa_qry.=' (j.temporary_re_pa like \'%"'.$i.'":"'.$user_id.'"%\' OR j.temporary_pa like \'%"'.$i.'":"'.$user_id.'"%\') 
					OR ';
					$iso_qry.=' (j.temporary_iso like \'%"'.$i.'":"'.$user_id.'"%\' OR j.temporary_re_iso like \'%"'.$i.'":"'.$user_id.'"%\')
					 OR ';

				}
				$ia_qry=rtrim($ia_qry,'OR ');
				$ia_qry.=')';
				$pa_qry=rtrim($pa_qry,'OR ');
				$pa_qry.=')';
				$iso_qry=rtrim($iso_qry,'OR ');
				$iso_qry.=')';



        if($user_role !==FALSE && $this->uri->segment($user_role+1))
        {
            $user_role = $this->uri->segment($user_role+1);
			
			if($user_role=='IA')
			$where_condition.=' (j.remarks_issuing_id = "'.$user_id.'" OR j.issuing_authority_id2 = "'.$user_id.'" OR 
			j.issuing_authority_id3 = "'.$user_id.'") OR '.$ia_qry.' AND ';
			else if($user_role=='PA')
			$where_condition.=' (j.remarks_performing_id = "'.$user_id.'" OR j.performing_authority_id2 = "'.$user_id.'" OR j.performing_authority_id3 = "'.$user_id.'") OR  '.$pa_qry.' AND ';
			else if($user_role=='Isolation')
			$where_condition.=$qry.' OR '.$iso_qry.' AND ';
			else
			$where_condition=' (j.remarks_issuing_id = "'.$user_id.'" OR j.issuing_authority_id2 = "'.$user_id.'" OR 
			j.issuing_authority_id3 = "'.$user_id.'"  OR '.$ia_qry.') OR (j.remarks_performing_id = "'.$user_id.'"  OR j.performing_authority_id2 = "'.$user_id.'" OR j.performing_authority_id3 = "'.$user_id.'" OR '.$pa_qry.')  OR '.$iso_qry.' OR '.$qry;
		}
		
		
		
        $subscription_date_start = array_search($user_role.'subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search($user_role.'subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));
		
		$where_condition=rtrim($where_condition,'AND ');

		$where_condition='('.$where_condition.') AND ( (DATE(j.date_start) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'") OR (DATE(j.date_end) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'")) AND';		

        $zone_id = array_search($user_role.'zone_id',$this->uri->segment_array());

        if($zone_id !==FALSE && $this->uri->segment($zone_id+1))
        {
            $zone_id = $this->uri->segment($zone_id+1);
			
			$where_condition.=" j.zone_id ='".$zone_id."' AND ";
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

		 $show=array_search('show',$segment_array);	
		  
		  if($show !==FALSE && $this->uri->segment($show+1)!='')
          {
			 	$show=$this->uri->segment($show+1);       

			 	if($show=='hide')
			 	$where_condition.=" j.approval_status NOT IN(11,12) AND "; 
		  }  	 

		 # echo $where_condition; exit;

		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (j.eip_no LIKE '%".$search_value."%' OR  j.section like '%".$search_value."%' OR j.area like '%".$search_value."%' OR j.equipment_descriptions like '%".$search_value."%' ) AND ";
		  }
		
		#echo $where_condition; 
		$fields = array( 
							0 =>'j.id', 
							1 =>'j.section',
							2=> 'j.area',
							5=>'j.date_start',
							6=>'j.status',
							7=>'j.date_end',							
							9=>'j.approval_status',
							10=>'j.remarks_issuing_id',
							11=>'j.isolated_name',
							12=>'j.isolated_name_approval',
							13=>'j.issuing_authority_id2',
							14=>'j.performing_authority_id2',
							15=>'j.isolated_name_approval',						
							16=>'j.remarks_performing_id',
							17=>'j.temporary_ia',
							18=>'j.temporary_ia_signdates',
							19=>'j.temporary_iso',
							20=>'j.temporary_iso_signdates',
							21=>'j.eip_no'
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

			if($show!='hide')
				$param_url='/jobs_isolations/index/'.$param_url;
			else
				$param_url='/jobs_isolations/day_in_process/'.$param_url;

			#echo 'Redirect '.$redirect;
			
			foreach($records as $record)
			{
				
				$id=$record['id'];

				$redirect=base_url().'jobs_isolations/form/id/'.$id.$param_url;
				
				$section=($record['section']) ? $record['section'] : ' - - -';
				
				$section='<a href="'.$redirect.'">'.strtoupper($section).'</a>';
				
				$area=($record['area']) ? strtoupper($record['area']) : ' - - -';
				
				$date_start=date(DATE_FORMAT,strtotime($record['date_start']));
				
				$date_end=date(DATE_FORMAT,strtotime($record['date_end']));
				
				$status=$record['status'];

				$approval_status=$record['approval_status'];

				$eip_no=$record['eip_no'];

				#$waiating_approval_by=$this->jobs_isolations_model->get_waiting_approval_name(array('approval_status'=>$approval_status,'record'=>$record));
				
				$waiating_approval_by='---';		

				if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
				$color=$job_approval_status_color[$job_approval_status[$approval_status]];
				else
				$color='';
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$print='<a href="javascript:void(0);" data-id="'.$id.'" class="print_out"><img src="'.base_url().'assets/img/print.png" alt="Print Job" title="Print Job" /></a>';				

				
				$json[$j]['eip_no']='<a href="'.$redirect.'" data-isoloation_permit_no="'.$id.'" title="Energy Isolation Permit Form" >'.$eip_no.'</a>';
						$json[$j]['section']=$section;
						$json[$j]['area']=$area;
						$json[$j]['date_start']=$date_start;						
						$json[$j]['date_end']=$date_end;#.' - '.$search;
						$json[$j]['status']=ucfirst($status);
						$json[$j]['waiating_approval_by']=ucfirst($waiating_approval_by);						
						$json[$j]['approval_status']=$approval_status;
						$json[$j]['action']=$print;
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
			$where_condition.=' (j.acceptance_issuing_id = "'.$user_id.'" OR j.cancellation_issuing_id = "'.$user_id.'") AND ';
			else
			$where_condition.=' (j.acceptance_performing_id = "'.$user_id.'" OR j.cancellation_performing_id = "'.$user_id.'") AND ';
		}
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR j.contractor_name like '%".$search_value."%' ) AND ";
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
							10=>'j.show_button'
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
				
				if($show_button=='hide') { $show_button='Final Submit'; 
				$redirect=base_url().'jobs/time_form/id/'.$id; }
				else { $show_button='Open';
				 }
				
				$redirect=base_url().'jobs/form/id/'.$id;
				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';
				
				$job_name='<a href="'.$redirect.'">'.strtoupper($job_name).'</a>';
				
				$location=($record['location']) ? $record['location'] : ' - - -';
				
				$contractor_name=($record['name']) ? $record['name'] : ' - - -';
				
				$contact_number=($record['contact_no']) ? $record['contact_no'] : ' - - -';
				
				$created=$record['created'];
				
				$status=$record['status'];
				
				$approval_status=$record['approval_status'];
				
				#$job_status=array_key_exists($approval_status,$job_approval_status);	
				
				if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
				$color=$job_approval_status_color[$job_approval_status[$approval_status]];
				else
				$color='';
				
				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";
				
				$approval_status='<a href="javascript:void(0);" data-id="'.$id.'"  data-permit-no="'.$permit_no.'" class="show_matched_records" data-toggle="modal" data-target="#show_matched_records_modal">'.$approval_status.'</a>';				
				
				$permit_no=$record['permit_no'];
				
				
				
						$json[$j]['id']='<a href="'.$redirect.'">'.$permit_no.'</a>';
						$json[$j]['job_name']=$job_name;
						$json[$j]['location']=strtoupper($record['location']);
						$json[$j]['name']=strtoupper($contractor_name);
						$json[$j]['approval_status']=$approval_status;#.' - '.$search;
						$json[$j]['created']=date(DATE_FORMAT,strtotime($created));
						$json[$j]['status']=ucfirst($status);
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
		$zone_id=$this->session->userdata('zone_id');
		
		$department_id=$this->session->userdata('department_id');
		
		$this->data['logged_department_id']=$department_id;
		
		$user_id=$this->session->userdata('user_id');
		
		$authorities=$job_status_error_msg=$issuing_authorities=$department_isolators='';
		
		$this->data['records']='';
		
		$this->data['departments'] = $this->departments_model->get_details(array('fields'=>'d.name,d.id,d.status',
		'conditions'=>'d.status= "'.STATUS_ACTIVE.'"'));

		$this->data['isolations'] = $this->public_model->get_data(array('table'=>ISOLATION,'select'=>'isolation_type_id,name,id,record_type','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));	

		
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));	
		
		$this->data['isolaters'] = $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND is_isolator="Yes" and department_id="'.$department_id.'"'));	
		
		$this->data['opened_jobs']='';

		$this->data['job_descriptions'] = array();

		$dept_id_in="'".$department_id."'";
		
        $update = array_search('id',$this->uri->segment_array());
        $id='';
        if($update !==FALSE && $this->uri->segment($update+1))
        {
            $id = $this->uri->segment($update+1);
            $req=array(
              'select'  =>'*',
              'table'    =>JOBSISOLATION,
              'where'=>array('id'=>$id)
            );
            $job_isolation_qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($job_isolation_qry)
			{
                $records=$job_isolation_qry->row_array();


                $req=array(
	              'select'  =>'*',
	              'table'    =>JOBSISOLATION_REISOLATIONS,
	              'where'=>array('jobs_isolations_id'=>$id)
	            );

            	$job_isolation=$this->public_model->fetch_data($req);

            	$job_isolation_records=$job_isolation->row_array();

            	unset($job_isolation_records['id']);

            	$records=array_merge($records,$job_isolation_records);
				
				$this->data['records']=$records;
				
				$this->data['sl_no']=$records['eip_no'];

				$dept_id_in.=",'".$records['department_id']."'";

				#$this->data['job_descriptions'] = $this->public_model->join_fetch_data(array('table1'=>JOBS.' j','select'=>'j.job_name','where'=>'jir.jobs_isoloations_id = "'.$id.'"','table2'=>JOBSISOLATIONRELATIONS.' jir','join_on'=>'j.id = jir.job_id','join_type'=>'inner','order_by'=>'j.id','order'=>'desc','num_rows'=>false));	
				
					if(in_array($records['approval_status'],array(6,7,8,9,10,11)))
					{
						$isolated_isolate_types=json_decode($records['isolated_isolate_types']);
						
						#echo '<pre>'; print_r($isolated_isolate_types);
						
						$isolated_types=array();
						
						foreach($isolated_isolate_types as $isolated_isolate_type)
						{
							if(!empty($isolated_isolate_type) && !in_array($isolated_isolate_type,$isolated_types))
							$isolated_types=array_merge($isolated_types,array($isolated_isolate_type));
						}


						#$isolated_types=array_merge($isolated_types,array(EIP_POWER_PLANT));
						#echo '<pre>'; print_r($isolated_types); exit;
						$isolated_types = array_unique($isolated_types);
						
						if(count($isolated_types)>0)
						{
						   $dept_id="'" . implode("','", $isolated_types) . "'";						 
							
						   $where_dept = '(isl.isolation_id IN('.$dept_id.')';

						   $where_dept.=' OR u.department_id = "'.EIP_POWER_PLANT.'") ';
						    	
						   $qry_dept=$this->jobs_isolations_model->get_isolation_users(array('where'=>$where_dept));
							
							#echo '<pre> '.$this->db->last_query(); exit;
							if($qry_dept->num_rows()>0)
							{
								$department_isolators=$qry_dept->result_array();
								
								#echo '<pre>'; print_r($department_isolators); exit;
							}
						}
					}					

					$assigned_permits=$this->get_assigned_permits($id);
					
					$this->data['job_descriptions'] = $assigned_permits['job_descriptions'];
							
					$this->data['records']['work_permit_nos']=$assigned_permits['work_permit_nos'];

					$this->data['records']['work_permit_status']=$assigned_permits['permit_status'];
								

            }   
        }
		else
		redirect('jobs_isolations/');
		
		
	   $where="user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";

	   $dept_id_in.=",'".EIP_PRODUCTION."'";
	   
	 
	   $where.=' AND department_id IN('.$dept_id_in.')';
	  # $where.=' AND id = "'.$records['remarks_performing_id'].'"';
	   
		//Getting Active Companys List
	   $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));


	  # echo $this->db->last_query(); exit;
		if($qry->num_rows()>0)
		{
			$authorities=$qry->result_array();
		}
		
		
		$this->data['authorities']=$authorities;
		
		/*$department_id = $department_id.','.EIP_OTHER_DEPARTMENT.','.EIP_PRODUCTION;	//Mechanical & Instrumental
		
		if($job_isolation_qry)
		$department_id.=','.$records['department_id'];*/

		$department_id="'".EIP_PRODUCTION."','".EIP_PACKING_OPERATION."','".EIP_MINES."','".EIP_CIVIL."'";

		$where="(department_id IN(".$department_id.") ";

	    if(IA_USERS!='')
 		    $where.=' OR id IN('.IA_USERS.')';

		$where.=") AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";

		
	    #$where="department_id IN(".$department_id.") AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
		//Getting Active Companys List
	    $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role,department_id','where_condition'=>$where,'table'=>USERS,'column'=>'first_name','dir'=>'asc'));
		
	#echo $this->db->last_query(); exit;
		
		$issuing_authorities='';
		
		if($qry->num_rows()>0)
		{
			$issuing_authorities=$qry->result_array();
		}
		
		$this->data['issuing_authorities']=$issuing_authorities;
		
		$this->data['user_id']=$this->session->userdata('user_id');
		
		$this->data['job_status_error_msg']=$job_status_error_msg;
		
		#echo '<pre>'; print_r($department_isolators); exit;
		
		$this->data['department_isolators']=$department_isolators;
				
		$this->load->view($this->data['controller'].'form',$this->data);
	}
	
	public function ajax_show_energy_info()
	{
		
	$zone_id=$this->session->userdata('zone_id');
	
	$department_id=$this->session->userdata('department_id');
	
	$authorities='';
	
	$this->data['departments'] = $this->departments_model->get_details(array('fields'=>'d.name,d.id,d.status',
	'conditions'=>'d.status= "'.STATUS_ACTIVE.'"'));

	$dept_id_in="'".$department_id."'";
	
	$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));	
		
        $update = array_search('id',$this->uri->segment_array());
        $id='';
        if($update !==FALSE && $this->uri->segment($update+1))
        {
            $id = $this->uri->segment($update+1);
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
				
				$this->data['sl_no']=$records['eip_no'];

				$dept_id_in.=",'".$records['department_id']."'";
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

	   #$dept_id_in.=",'".EIP_PRODUCTION."'"; department_id IN (".$department_id.") AND 
		
	   $where="user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
		//Getting Active Companys List
	   $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));

	  # echo $this->db->last_query(); exit;

		if($qry->num_rows()>0)
		{
			$authorities=$qry->result_array();
		}
		
		$this->data['authorities']=$authorities;
		
		$this->data['user_id']=$this->session->userdata('user_id');

		$this->load->view($this->data['controller'].'energy',$this->data);     
		   
	}

	public function ajax_energy_form_action()
	{
		
		#echo '<pre>';print_r($this->input->post()); exit;
		
		$id=($this->input->post('id')) ? $this->input->post('id') : '';
		
		$user_name=$this->session->userdata('first_name');
		
		$user_id=$this->session->userdata('user_id');
		
		$eip_completed_departments=unserialize(EIP_COMPLETED_DEPARTMENTS);
		
		$msg=''; $j=0;  $print_out=''; $is_send_sms=$print_eip_no='';


		$_POST['last_updated_by']=$user_name;

		if(!$id)
		{
			$_POST['remarks_performing_date']=date('d-m-Y H:i');	
		
			$_POST['approval_status']=1;	//Waiting IA Acceptance
			
			$_POST['status']=STATUS_PENDING;		

			$is_send_sms=YES;

			$sender=$_POST['remarks_performing_id'];

			$receiver=$_POST['remarks_issuing_id'];

			$msg_type=PATOIA_WAITING_APPROVAL;		

			$approval_status=1;
		}
		else
		{

			$job_qry=$this->public_model->get_data(array('select'=>'id,modified,last_updated_by,eip_no','where_condition'=>'id ="'.$id.'"','table'=>JOBSISOLATION));

			$job_result = $job_qry->row_array();		

			$db_modified=strtotime($job_result['modified']);

			$modified=strtotime($this->input->post('modified'));

			$print_eip_no=$job_result['eip_no'];

			if($db_modified!=$modified)		//Check if any update info recently
			{
				$this->session->set_flashdata('failure','Sorry, Just before <b>'.$job_result['last_updated_by'].'</b> has updated this EIP info. Please check updated information');  

				$ret=array('status'=>false,'print_out'=>'');		                   
      
				echo json_encode($ret);

				exit;
			}


			$show_button=($_POST['show_button']) ? trim($_POST['show_button']) : '';
			
			$approval_status=($_POST['approval_status']) ? trim($_POST['approval_status']) : '';
			
			$remarks_performing_id=($_POST['remarks_performing_id']) ? trim($_POST['remarks_performing_id']) : '';

			#echo 'fFF '.$approval_status.' = '.$show_button; exit;
			
			if($show_button==2 && $approval_status==1) //IA approve his job Stage B
			{				
				$_POST['status']=STATUS_PENDING;		
				
				if($_POST['remarks_issuing_id']==$user_id)
				{
					$_POST['remarks_issuing_approval']='Yes';
					
					$_POST['remarks_issuing_date']=date('Y-m-d H:i');
					
					$_POST['approval_status']=2;	// IA Acceptance
					
					$msg='<b>IA '.$user_name.' approved this EIP (a) & (b) section </b>';

					$is_send_sms=YES;

					$receiver=$_POST['remarks_performing_id'];

					$sender=$_POST['remarks_issuing_id'];

					$msg_type=IATOPA_APPROVAL;
					
					unset($_POST['show_button']);
				}	
			}				
			else if($approval_status==2 || $approval_status==3) 	//Stage C
			{
				$c=0;

				$print_out=1;
				
				$total_isolated_equipment_descriptions=array_filter($this->input->post('isolated_equipment_descriptions'), function($value) { return $value !== ''; });


				$remove_empty_fieds=array('isolated_equipment_tag_nos','isolated_isolate_types','isolated_equipment_descriptions','isolated_tagno1','isolated_tagno2','isolated_name');
				#,'isolated_tagno3','isolated_name_approval','isolated_name','isolated_name_approval_datetime','isolated_ia_name'
				
					foreach($remove_empty_fieds as $fields):
						$iso=array_filter($_POST[$fields]);
						$_POST[$fields]=array_combine(range(1, count($iso)), $iso);
					endforeach;	

					#echo '<pre>';print_r($this->input->post()); exit;   
				
					$row_count=count($_POST['isolated_equipment_tag_nos']);
					#for($i=1;$i<=20;$i++)
					for($i=1;$i<=$row_count;$i++)
					{	
						$isolated_equipment_descriptions=(isset($_POST['isolated_equipment_descriptions'][$i])) ? trim($_POST['isolated_equipment_descriptions'][$i]) : '';
						$isolated_name_approval=(isset($_POST['isolated_name_approval'][$i])) ? trim($_POST['isolated_name_approval'][$i]) : '';						
						$isolated_tagno3=(isset($_POST['isolated_tagno3'][$i])) ? trim($_POST['isolated_tagno3'][$i]) : '';		
										
						#$isolated_tagno4=(isset($_POST['isolated_tagno4'][$i])) ? trim($_POST['isolated_tagno4'][$i]) : ' ';
						$isolated_tagno4='a';
						
						$isolated_name=(isset($_POST['isolated_name'][$i])) ? trim($_POST['isolated_name'][$i]) : '';						
						
						/*if(empty($isolated_equipment_descriptions))
						break;
						else
						{	*/
							if($isolated_name_approval=='' && $user_id==$remarks_performing_id)
							{
								$c++;
							}
							else 
							{
								if($isolated_name_approval=='' && $user_id==$isolated_name)
								{
									$msg='<b>Approved Isolation '.$i.' requests</b>';	
									
									$_POST['isolated_name_approval'][$i]='approved';

									$is_send_sms=YES;

									$sender=$user_id;

									$receiver=$_POST['remarks_performing_id'];

									$msg_type=EIP_ISO_TO_PA;
									
								}
								
								if($isolated_tagno3!='' && $isolated_tagno4!='')
								$c++;
								
								#$c++;
							}
						#}
					}
					
					$i=($i)-1;


					#echo 'FF '.$c.' = '.$i; exit;
					
					if($user_id==$remarks_performing_id && $c==$i)		//Stage 3 PA TO ISO
					{
						$_POST['approval_status']=3; //Waiting Isolation Acceptance
						  
						$msg='<b>Sent Isolation requests</b>';	

						$iso_names=implode(',',array_unique(array_filter($this->input->post('isolated_name'))));
						
						$is_send_sms=YES;

						$receiver=$iso_names;

						$sender=$_POST['remarks_performing_id'];

						$msg_type=EIP_PA_TO_ISO;

					}
					else if($c==$i)
					{
						 $sender=$user_id;

						 $receiver=$_POST['remarks_performing_id'];

						 $msg_type=EIP_ISO_TO_PA_COMPLETED;

						 $this->public_model->send_sms(array('sender'=>$sender,'receiver'=>$receiver,'msg_type'=>$msg_type,'permit_type'=>'EIP','permit_no'=>$print_eip_no));
						
						 $_POST['approval_status']=4;	
					}

					#echo '<br /> C '.$c.' = '.$i;
						
			}
			else if($approval_status==4 || $approval_status==5)		//Stage D
			{

				 if($_POST['remarks_performing_id']==$user_id && $_POST['issuing_authority_id2_date']=='')
				 {
							 
					 $_POST['issuing_authority_id2_approval']='No';	

					 $receiver=$_POST['issuing_authority_id2'];

					 $sender=$_POST['remarks_performing_id'];

					 $msg_type=PATOIA_WAITING_APPROVAL;

					 $this->public_model->send_sms(array('sender'=>$sender,'receiver'=>$receiver,'msg_type'=>$msg_type,'permit_type'=>'EIP','permit_no'=>$print_eip_no));
				}	 
				else if($_POST['issuing_authority_id2']==$user_id)	//IA
				{
					$_POST['approval_status']=5;	//Waiting PA Acceptance	
					
					$_POST['issuing_authority_id2_approval']='Yes';
					
					$_POST['performing_authority_id2_approval']='No';
					
					$_POST['issuing_authority_id2_date']=date('d-m-Y H:i');

					$is_send_sms=YES;

					$sender=$_POST['issuing_authority_id2'];

					$receiver=$_POST['remarks_performing_id'];

					$msg_type=IATOPA_APPROVAL;
					
					$msg='<b>'.$user_name.' sent PA Section (D) final submit request</b>';
				}
				#else if($_POST['issuing_authority_id2']==$user_id)	//IA
				else if($_POST['performing_authority_id2']==$user_id)	//IA
				{
					$_POST['approval_status']=6;	//IA Acceptance	
					
					$_POST['status']=STATUS_OPENED;
					
					$_POST['final_status_date']=date('Y-m-d H:i');
					
					$_POST['performing_authority_id2_approval']='Yes';
					
					$_POST['performing_authority_id2_date']=date('d-m-Y H:i');
					
					$msg='<b>'.$user_name.' accept Section (D) final submit request</b>';
					
					$print_out=1;
				}
			}
			else if($approval_status==6 || $approval_status==7)
			{

					$j=0; $l=0;

					#$temporary_tags_no=(isset($_POST['temporary_tag_nos'])) ? array_merge(array(0),array_values($_POST['temporary_tag_nos'])) : array();

					$temporary_tags_no=(isset($_POST['temporary_tag_nos'])) ? $_POST['temporary_tag_nos'] : array();

					/*$_POST['temporary_tag_nos']=$temporary_tags_no;

					$_POST['temporary_lock_nos']=(isset($_POST['temporary_lock_nos'])) ? array_merge(array(0),array_values($_POST['temporary_lock_nos'])) : array();

					$_POST['temporary_pa']=(isset($_POST['temporary_pa'])) ? array_merge(array(0),array_values($_POST['temporary_pa'])) : array();

					$_POST['temporary_pa_signdates']=(isset($_POST['temporary_pa_signdates'])) ? array_merge(array(0),array_values($_POST['temporary_pa_signdates'])) : array();
					
					$_POST['temporary_ia']=(isset($_POST['temporary_ia'])) ? array_merge(array(0),array_values($_POST['temporary_ia'])) : array();

					$_POST['temporary_ia_signdates']=(isset($_POST['temporary_ia_signdates'])) ? array_merge(array(0),array_values($_POST['temporary_ia_signdates'])) : array();

					$_POST['temporary_iso']=(isset($_POST['temporary_iso'])) ? array_merge(array(0),array_values($_POST['temporary_iso'])) : array();

					$_POST['temporary_iso_signdates']=(isset($_POST['temporary_iso_signdates'])) ? array_merge(array(0),array_values($_POST['temporary_iso_signdates'])) : array();


					$_POST['temporary_re_pa']=(isset($_POST['temporary_re_pa'])) ? array_merge(array(0),array_values($_POST['temporary_re_pa'])) : array();

					$_POST['temporary_re_pa_signdates']=(isset($_POST['temporary_re_pa_signdates'])) ? array_merge(array(0),array_values($_POST['temporary_re_pa_signdates'])) : array();

					$_POST['temporary_re_ia']=(isset($_POST['temporary_re_ia'])) ? array_merge(array(0),array_values($_POST['temporary_re_ia'])) : array();

					$_POST['temporary_re_ia_signdates']=(isset($_POST['temporary_re_ia_signdates'])) ? array_merge(array(0),array_values($_POST['temporary_re_ia_signdates'])) : array();

					$_POST['temporary_re_iso']=(isset($_POST['temporary_re_iso'])) ? array_merge(array(0),array_values($_POST['temporary_re_iso'])) : array();

					$_POST['temporary_re_iso_signdates']=(isset($_POST['temporary_re_iso_signdates'])) ? array_merge(array(0),array_values($_POST['temporary_re_iso_signdates'])) : array();*/

					#echo '<pre>'; print_r($temporary_tags_no); #print_r(array_filter(array_merge(array(0),array_values($temporary_tags_no))));  exit;

					#echo '<pre>'; print_r($_POST); exit;

					#for($i=1;$i<=3;$i++)
					foreach($temporary_tags_no as $i => $val)
					{	
						$temporary_tag_nos=(isset($_POST['temporary_tag_nos'][$i])) ? trim($_POST['temporary_tag_nos'][$i]) : '';
						
						$temporary_lock_nos=(isset($_POST['temporary_lock_nos'][$i])) ? trim($_POST['temporary_lock_nos'][$i]) : '';
						
						$temporary_pa=(isset($_POST['temporary_pa'][$i])) ? trim($_POST['temporary_pa'][$i]) : '';
						
						$temporary_ia=(isset($_POST['temporary_ia'][$i])) ? trim($_POST['temporary_ia'][$i]) : '';
						
						$temporary_ia_signdate=(isset($_POST['temporary_ia_signdates'][$i])) ? trim($_POST['temporary_ia_signdates'][$i]) : '';
						
						$temporary_iso=(isset($_POST['temporary_iso'][$i])) ? trim($_POST['temporary_iso'][$i]) : '';
						
						$temporary_iso_signdate=(isset($_POST['temporary_iso_signdates'][$i])) ? trim($_POST['temporary_iso_signdates'][$i]) : '';
						
						$temporary_re_ia_signdate=(isset($_POST['temporary_re_ia_signdates'][$i])) ? trim($_POST['temporary_re_ia_signdates'][$i]) : '';
						
						$temporary_re_iso_signdate=(isset($_POST['temporary_re_iso_signdates'][$i])) ? trim($_POST['temporary_re_iso_signdates'][$i]) : '';	

						if(!empty($temporary_tag_nos))
						{
							$j++;
							
							if($temporary_ia_signdate!='' && $temporary_iso_signdate!='' && $temporary_re_ia_signdate!='' && $temporary_re_iso_signdate!='')
							$l++;
						}
					}
					
					if($j>0)
					{	
						if($j==$l)
						$_POST['approval_status']=8;
						else
						$_POST['approval_status']=7;
						
					}
					else
					{
						#$msg='<b>'.$user_name.' submitted energization approval request</b>';
					}
			}
			
			#echo '<pre>'; print_r($_POST); exit;
			#echo '<br /> FF : '.$approval_status; exit;

			#echo 'FF '.$j.' = '.$approval_status;

			if($j==0 && in_array($approval_status,array(6,7,8,9,10,11)))
			{
				
				$is_close=0;
							 
						if($_POST['performing_authority_id3']==$user_id && (in_array($approval_status,array(8,6,9)))) //PA
						{
							$_POST['approval_status']=9;	//Waiting IA Acceptance	previously 7
							
							$_POST['issuing_authority_id3_approval']='No';
							
							$_POST['performing_authority_id3_date']=date('d-m-Y H:i');
							
							$msg='<b>'.$user_name.' sent IA Section (G) approval request</b>';

							$is_send_sms=YES;

							$sender=$user_id;

							$receiver=$_POST['issuing_authority_id3'];

							$msg_type=PATOIA_WAITING_APPROVAL;
							
							$is_close=1;
						}
						else if($_POST['issuing_authority_id3']==$user_id && ($approval_status==9 || $approval_status==7))	//IA
						{

							#echo 'Yes'; exit;
							$is_close=1;

							$_POST['approval_status']=10;	//IA Acceptance	
							
							$_POST['issuing_authority_id3_approval']='Yes';
							
							#$_POST['status']=STATUS_CLOSED;
							
							$_POST['issuing_authority_id3_date']=date('d-m-Y H:i');
							
							$msg='<b>'.$user_name.' accept Section (G) approval request</b>';

							$is_send_sms=YES;

							$sender=$user_id;

							$receiver=$_POST['performing_authority_id3'];

							$msg_type=IATOPA_APPROVAL;		
								
						}
						else if($approval_status>=10)
						{
							
							$is_close=1;
							
							$not_empty_dept=count(array_filter($_POST['department_completion_users']));
							
							$ee=0;
								
							for($e=0;$e<count($eip_completed_departments);$e++)
							{	
								#echo '<br /> A : '.$eip_completed_departments[$e];
								$dept_user = (isset($_POST['department_completion_users'][$eip_completed_departments[$e]])) ? $_POST['department_completion_users'][$eip_completed_departments[$e]] : '';
								
								$department_completion_users_approval_dates = (isset($_POST['department_completion_users_approval_dates'][$eip_completed_departments[$e]])) ? $_POST['department_completion_users_approval_dates'][$eip_completed_departments[$e]] : '';
								
								if($dept_user!='')
								{
									if($department_completion_users_approval_dates!='')
									$ee++;
								}
								
								#echo '<br /> A : '.$dept_user.' - '.$department_completion_users_approval_dates.' - '.$ee;
							}		
							
							if($not_empty_dept==$ee)
							{ 

								$_POST['status']=strtolower(STATUS_CLOSED);

								$_POST['approval_status']=11;

								$is_send_sms=YES;

								$sender=$user_id;

								$receiver=$_POST['performing_authority_id3'];

								$msg_type=EIP_DEPT_TO_PA;	
							}
							else
							$_POST['approval_status']=10;
								
							#echo '<br /> Filled : '.$ee.' - '.$not_empty_dept;
						}
						else { 
						$_POST['approval_status']=7;
						
						$_POST['issuing_authority_id3_approval']='No'; }

						
						#echo '<pre>'; print_r($_POST); exit;
					if($is_close==1)
					{
						$work_permit_nos_counts=explode(',',$_POST['work_permit_nos']);
					
						$permit_ids="'" . implode("','", array_unique($work_permit_nos_counts)) . "'";						

						$error_msg=$this->check_assigned_permits_status($id);

						if($error_msg!='')
						{
							$is_send_sms='';
							
							$this->session->set_flashdata('failure',$error_msg);     	
							
							$ret=array('id'=>$id,'print_out'=>'error','msg'=>$error_msg);
											   
							echo json_encode($ret); 
									 
							exit;
						}
						
					}
						
						
			}

			
		}


		#echo 'FF '.$approval_status; exit;

		if($approval_status<=1)
		{

			$equipment_radio=(isset($_POST['equipment_radio'])) ? count($_POST['equipment_radio']) : 0;

			if($equipment_radio==0)
			{
				$equipment_descriptions=array_filter($_POST['equipment_descriptions']);

				#print_r(array_combine(range(1, count($equipment_descriptions)), $equipment_descriptions));

				$_POST['equipment_descriptions']=array_combine(range(1, count($equipment_descriptions)), $equipment_descriptions);

				$equipment_tag_nos=array_filter($_POST['equipment_tag_nos']);

				$_POST['equipment_tag_nos']=array_combine(range(1, count($equipment_tag_nos)), $equipment_tag_nos);

				$isolate_types=array_filter($_POST['isolate_types']);

				$_POST['isolate_types']=array_combine(range(1, count($isolate_types)), $isolate_types);
				#echo '<pre>'; print_r(array_slice(array_keys($qq),1,null,true)); exit;
			}	
		}


		$_POST['is_checklist']=count(array_filter($_POST['isolate_types']));

		unset($_POST['modified']);
		#echo '<br /> Msg '.$msg;
		
		#echo '<pre>';print_r($this->input->post()); exit;   
		
		$inputs=$this->input->post();
	//'is_isoloation_drained_fully_options',
		$array_fields=array('isolated_name_approval_datetime','isolated_name_approval','equipment_descriptions','equipment_tag_nos','isolate_types','isolated_equipment_descriptions','isolated_equipment_tag_nos','isolated_isolate_types','isolated_tagno1','isolated_tagno2','isolated_tagno3','isolated_tagno4','isolated_name','temporary_tag_nos','temporary_lock_nos','temporary_pa','temporary_ia','temporary_iso','temporary_pa_signdates','temporary_ia_signdates',
		'temporary_iso_signdates','temporary_re_pa','temporary_re_ia','temporary_re_iso','temporary_re_pa_signdates','temporary_re_ia_signdates','temporary_re_iso_signdates','department_completion_users','department_completion_users_approval_dates','equipment_radio','equipment_remarks','isolated_ia_name','isolated_re_tagno1','isolated_re_tagno2','isolated_re_tagno3');

		$reisolation_fields=array('temporary_tag_nos','temporary_lock_nos','temporary_pa','temporary_ia','temporary_iso','temporary_pa_signdates','temporary_ia_signdates','temporary_iso_signdates','temporary_re_pa','temporary_re_ia','temporary_re_iso','temporary_re_pa_signdates','temporary_re_ia_signdates','temporary_re_iso_signdates','isolated_re_tagno1','isolated_re_tagno2','isolated_re_tagno3');
		
		$skip_fields=array('id','submit','is_popup_submit','show_button','total_rows');
		

		$skip_fields=array_merge($skip_fields,$reisolation_fields);
		
		$arr=array();
	
		$fields='';
		
		$fields_values='';
		
		$update='';
		
		foreach($inputs as $field_name => $field_value)
		{
			if(!in_array($field_name,$skip_fields))
			{
				$fields.=$field_name.',';
				
				if(in_array($field_name,$array_fields))
				{
					if(count($this->input->post($field_name))>0)
					$field_value="'".json_encode($this->input->post($field_name))."'";
				}
				else
				{
					if($field_name=='department_id')
					{
						 $field_value=explode('|',$field_value);
						 
						 $field_value=$field_value[0];	
					}
					
					if(in_array($field_name,array('date_start','date_end')))
					$field_value=date('Y-m-d',strtotime($field_value));
					
					//echo '<br /> field name : '.$field_name.'  - '.$field_value;
					
					#if(trim($field_value)!='')
					$field_value="'".rtrim(addslashes($field_value),',')."'";
				}
				
				$fields_values.=$field_value.',';
				
				$update.=$field_name.'='.$field_value.',';
			}
		}


		$reisolation_fields_values=$reisolation_fields_names=$reisolation_updates='';

		foreach($inputs as $field_name => $field_value)
		{
			if(in_array($field_name,$reisolation_fields))
			{
				$reisolation_fields_names.=$field_name.',';

				if(in_array($field_name,$array_fields))
				{
					if(count($this->input->post($field_name))>0)
					$field_value="'".json_encode($this->input->post($field_name))."'";
				}
				
				$reisolation_updates.=$field_name.'='.$field_value.',';

				$reisolation_fields_values.=$field_value.',';
			}
		}
		
		$update.="modified = '".date('Y-m-d H:i')."'";
		
		$update=rtrim($update,',');
		
		$fields.='user_id,created,modified';
		
		$fields_values.='"'.$this->session->userdata('user_id').'","'.date('Y-m-d H:i:s').'","'.date('Y-m-d H:i').'"';

		$eip_no='';
		
		if(!$id)
		{

			$eip_no=$print_eip_no=$this->public_model->get_max_eip_no();

			$eip_no_sec=substr($eip_no,2,strlen($eip_no));

			$fields=$fields.',eip_no,eip_no_sec';

			$fields_values=$fields_values.',"'.$eip_no.'","'.$eip_no_sec.'"';

			$ins="INSERT INTO ".$this->db->dbprefix.JOBSISOLATION." (".$fields.") VALUES (".$fields_values.")";
		
			$this->db->query($ins);
			
			$id=$this->db->insert_id();

			$reisolation_fields_names=$reisolation_fields_names.'jobs_isolations_id';

			$reisolation_fields_values=$reisolation_fields_values.'"'.$id.'"';

			$ins="INSERT INTO ".$this->db->dbprefix.JOBSISOLATION_REISOLATIONS." (".$reisolation_fields_names.") VALUES (".$reisolation_fields_values.")";
		
			$this->db->query($ins);
			
			$msg='<b>Created by '.$user_name.' and sent remarks request to IA</b>';
		}
		else
		{
			$up="UPDATE ".$this->db->dbprefix.JOBSISOLATION." SET ".$update." WHERE id='".$id."'";
			
			$this->db->query($up);

			$reisolation_updates=rtrim($reisolation_updates,',');
			if($reisolation_updates!='')
			{	
				$up="UPDATE ".$this->db->dbprefix.JOBSISOLATION_REISOLATIONS." SET ".$reisolation_updates." WHERE jobs_isolations_id='".$id."'";
				
				$this->db->query($up);
			}
			#$up="UPDATE ".$this->db->dbprefix.JOBSISOLATION_REISOLATIONS." SET ".$reisolation_updates." WHERE jobs_isolations_id='".$id."'";
			
			#$this->db->query($up);
		}
		
		$affectedRows = $this->db->affected_rows();
		
		if($affectedRows>0)
		{
			if($msg=='')
			$msg=$user_name.' has updated his job information';
			
			$array=array('user_id'=>$user_id,'jobisolation_id'=>$id,'notes'=>$msg,'created'=>date('Y-m-d H:i'));
			
			$this->db->insert(JOBSISOLATIONHISTORY,$array);
		}
		
		if($is_send_sms!='')
		$this->public_model->send_sms(array('sender'=>$sender,'receiver'=>$receiver,'msg_type'=>$msg_type,'permit_type'=>'EIP','permit_no'=>'EIP'.$print_eip_no));
		#echo $this->db->last_query();
		
        $this->session->set_flashdata('success',DB_UPDATE);     
		
		$ret=array('id'=>$id,'print_out'=>$print_out,'eip_no'=>$eip_no);
		                   
        echo json_encode($ret); 
		
		exit;
	}

	
	public function check_assigned_permits_status($id)
	{
		$error_msg='';

		$arr = array(JOBS,ELECTRICALPERMITS,CONFINEDPERMITS);	


		foreach($arr as $ar)
		{	

			$where = 'relation_type ="'.$ar.'" AND jobs_isoloations_id="'.$id.'"';

			$opened_jobs = $this->public_model->get_data(array('table'=>JOBSISOLATIONRELATIONS,'select'=>'job_id','where_condition'=>$where,'group_by'=>'job_id'));

			$relation_count = $opened_jobs->num_rows();
			
			if($relation_count>0)		
			{	
				$fet_permits = $opened_jobs->result_array();

				$permit_ids=implode(',',array_unique(array_column($fet_permits,'job_id'))).',';

				$permit_ids=rtrim($permit_ids,',');


				//Combined Permits // Electrical Permits
				if($ar!=CONFINEDPERMITS)
				$where="approval_status IN('4','6','9','10') AND id IN(".$permit_ids.")"; #'2','4','6','8',
				else
				$where="approval_status IN('13','6','8') AND id IN(".$permit_ids.")"; #'2','4','6','8',
				
				$opened_jobs = $this->public_model->get_data(array('table'=>$ar,'select'=>'id','where_condition'=>$where))->num_rows();
				
				$cc=($relation_count)-($opened_jobs);			

				if($opened_jobs!=($relation_count) && $cc>0)
				$error_msg.='Till '.($cc).' related <b>'.str_replace('_',' ',$ar).'</b> has not closed.<br />';		
			}

		}

		if($error_msg!='')
		$error_msg=rtrim($error_msg,'<br />');

		return $error_msg;
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
	
	
	
	public function removedform_action()
	{
		#echo '<pre>';print_r($this->input->post()); exit;
		
		$user_name=$this->session->userdata('first_name');
		
		$user_id=$this->session->userdata('user_id');
		
		$approval_status=unserialize(JOBAPPROVALS);
		
		$array_fields=array('precautions_options','hazards_options','precautions','hazards','issuing_authority','no_of_persons','performing_authority','schedule_from_time','schedule_to_time','schedule_date');
		
		$skip_fields=array('id','submit','is_popup_submit');
		
		
		$arr=array();
		
		$fields='';
		
		$fields_values='';
		
		$update=''; 
		
		$msg='';
		
		if(!$this->input->post('id'))	//If new jobs create
		{
				$_POST['acceptance_performing_date']=date('d-m-Y H:i');	
			
				$_POST['approval_status']=1;	//Waiting IA Acceptance
				
				$_POST['status']=STATUS_PENDING;
		}	
		else
		{
			$show_button=($_POST['show_button']) ? trim($_POST['show_button']) : '';
			
			if($show_button=='hide')	//After IA approve we got this When PA submit his job
			{		
				$_POST['status']=STATUS_OPENED;		
				
				$msg='<b>PA moved his job to Day End Process</b>';
			}
			else if($show_button=='approveIA') //IA approve his job
			{				
				$_POST['approval_status']=2;		
				
				$_POST['acceptance_issuing_approval']='Yes';
				
				$_POST['acceptance_issuing_date']=date('Y-m-d H:i');
				
				$msg='<b>IA '.$user_name.' approved this job</b>';
				
				unset($_POST['show_button']);
			}
			
			$status=(isset($_POST['status'])) ? $_POST['status'] : '';
			
			if($status!='' && $show_button!='hide')
			{
				unset($_POST['show_button']);
				
				
				if($user_id==$this->input->post('cancellation_performing_id'))
				{

						if(strtolower($status)=='cancellation')
						{
							$_POST['approval_status']=5;
						}
						else if(strtolower($status)=='completion')
						{
							$_POST['approval_status']=3;
						}
						
						$msg='<b>Sent '.$status.' request to IA</b>';	
				}
				else if($user_id==$this->input->post('cancellation_issuing_id'))
				{
						if(strtolower($status)=='cancellation')
						{
							$_POST['approval_status']=6;
						}
						else if(strtolower($status)=='completion')
						{
							$_POST['approval_status']=4;
						}
						
						$msg='<b>'.ucfirst($status).' accept by IA</b>';	
				}
				
			}
		}
		
		#echo '<br /> MSg : '.$msg.' - '.$show_button.' - '.$status.' - '.$user_id;
		
		#echo '<pre>'; print_r($_POST); exit;
		
		#echo '<pre>'; #print_r($_POST['precautions_options']); 
		#echo '<br /> Other Inputs : '.count($this->input->post('precautions_options'));
		
		#print_r($_POST['hazards_options']); exit;
		
		
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
					
					if($field_name=='precautions_options')
					{
						#echo '<br /> Values : '.$field_value; exit;	
					}
					
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
		
		$fields_values.='"'.$user_id.'","'.date('Y-m-d H:i:s').'","'.date('Y-m-d H:i').'"';
		
		$id=($this->input->post('id')) ? $this->input->post('id') : '';
		
		if(!$id)
		{
			$ins="INSERT INTO ".JOBS." (".$fields.") VALUES (".$fields_values.")";
		
			$this->db->query($ins);
			
			$id=$this->db->insert_id();
			
			$msg='<b>Created by '.$user_name.' and sent request to IA</b>';
			
		}
		else
		{
			$up="UPDATE ".JOBS." SET ".$update." WHERE id='".$id."'";
			
			$this->db->query($up);
		}
		
		#echo $this->db->last_query();
		$affectedRows = $this->db->affected_rows();
		
		if($affectedRows>0)
		{
			if($msg=='')
			$msg=$user_name.' has updated his job information';
			
			$array=array('user_id'=>$user_id,'job_id'=>$id,'notes'=>$msg,'created'=>date('Y-m-d H:i'));
			
			$this->db->insert(JOBSHISTORY,$array);
		}
		
		#echo $this->db->last_query();
		
        $this->session->set_flashdata('success',DB_UPDATE);                        
        echo 'true'; exit;
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
		
			$where='jobisolation_id = "'.$id.'"';  
			
			$subscription_history=array(
                'select'  =>'sh.id,sh.notes,sh.created,u.first_name',
                'where'=>$where,
                'table1'=>JOBSISOLATIONHISTORY.' sh',
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


	public function ajax_get_isolation_users()
	{

		#echo '<br /> Iso '; print_r($_POST);

		$isolation_type_id=$this->input->post('isolation_type_id');
		
		$department_id=$this->session->userdata('department_id');

		$i=$this->input->post('i');

		$where='isl.isolation_id="'.$isolation_type_id.'"';
		
		$get = $this->jobs_isolations_model->get_isolation_users(array('where'=>$where));
		
		$nums=$get->num_rows();

		//$opt='<select name="isolated_name['.$i.']" id="isolated_name['.$i.']" class="form-control isolated_name data-iso-name isolation_equipment_row'.$i.'" data-attr="'.$i.'"><option value="" selected>Select</option>';
		$opt='<option value="" selected>Select</option>';
		if($nums>0)
		{
			$fets=$get->result_array();
			
			
			
			foreach($fets as $fet)
			{
				$opt.='<option value="'.$fet['id'].'">'.$fet['first_name'].'</option>';
			}
		}

		//$opt.='</select>';
		$data=array('response'=>$opt);

		echo json_encode($data);		
	}
	
	
	public function ajax_get_isolation_descriptions()
	{
		$isolation_type_id=$this->input->post('isolation_type_id');
		
		$this->db->select('name,id');
		
		$this->db->from(ISOLATION);
		
		$this->db->where('isolation_type_id',$isolation_type_id);
		
		$get=$this->db->get();
		
		#echo $this->db->last_query();
		
		$nums=$get->num_rows();
		
		if($nums>0)
		{
			$fets=$get->result_array();
			
			$opt='<option value="">- - Select - -</option>';
			
			foreach($fets as $fet)
			{
				$opt.='<option value="'.$fet['id'].'">'.$fet['name'].'</option>';
			}
			
			$data=array('success'=>$opt);
			
		}
		else
		$data=array('failure'=>'');
		
		echo json_encode($data);		
	}	
	
	
	public function check_approval_status()
	{
		$isoloation_permit_no = $this->input->post('isoloation_permit_no');
		
		$isoloation_permit_no=explode(',',$isoloation_permit_no);
		
		$eip_id="'" . implode("','", array_unique($isoloation_permit_no)) . "'";
		
	}
	
	public function printout()
	{
		error_reporting(0);
		
		$zone_id=$this->session->userdata('zone_id');
		
		$department_id=$this->session->userdata('department_id');
		
		$this->data['logged_department_id']=$department_id;
		
		$user_id=$this->session->userdata('user_id');
		
		$authorities=$job_status_error_msg=$issuing_authorities=$department_isolators='';
		
		$this->data['records']='';
		
		$this->data['departments'] = $this->departments_model->get_details(array('fields'=>'d.name,d.id,d.status',
		'conditions'=>'d.status= "'.STATUS_ACTIVE.'"'));

		$this->data['isolations'] = $this->public_model->get_data(array('table'=>ISOLATION,'select'=>'isolation_type_id,name,id,record_type','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));	
	
		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));	
		
		$this->data['isolaters'] = $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND is_isolator="Yes" and department_id="'.$department_id.'"'));	
		
		$this->data['opened_jobs']='';
		
        $id=$this->input->post('id');

        $zones_fetch=array();
		
		#$id=28;
        if($id!='')
        {
            $req=array(
              'select'  =>'*',
              'table'    =>JOBSISOLATION,
              'where'=>array('id'=>$id)
            );
            $job_isolation_qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($job_isolation_qry)
			{
                $records=$job_isolation_qry->row_array();

                $req=array(
	              'select'  =>'*',
	              'table'    =>JOBSISOLATION_REISOLATIONS,
	              'where'=>array('jobs_isolations_id'=>$id)
	            );

            	$job_isolation=$this->public_model->fetch_data($req);

            	$job_isolation_records=$job_isolation->row_array();

            	unset($job_isolation_records['id']);

            	$records=array_merge($records,$job_isolation_records);
				
				$this->data['records']=$records;
				
				$this->data['sl_no']=$records['eip_no'];

				$zone_id=$records['zone_id'];

				$fetch=$this->public_model->get_data(array('table'=>EIP_CHECKLISTS,'select'=>'equipment_name,id,equipment_number','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND zone_id="'.$zone_id.'" AND equipment_number!=""','column'=>'equipment_name','dir'=>'asc'));
		
				$num_rows=$fetch->num_rows();

				if($num_rows>0)
					$zones_fetch=$fetch->result_array();
				
					if(in_array($records['approval_status'],array(6,8,9,10,11)))
					{
						$isolated_isolate_types=json_decode($records['isolated_isolate_types']);
						
						#echo '<pre>'; print_r($isolated_isolate_types); exit;	
						
						$isolated_types=array();
						
						foreach($isolated_isolate_types as $isolated_isolate_type)
						{
							if(!empty($isolated_isolate_type) && !in_array($isolated_isolate_type,$isolated_types))
							$isolated_types=array_merge($isolated_types,array($isolated_isolate_type));
						}
						
						$isolated_types = array_unique($isolated_types);
						
						if(count($isolated_types)>0)
						{
						   $dept_id="'" . implode("','", $isolated_types) . "'";
							
						   $where_dept = 'isl.isolation_id IN('.$dept_id.')';
						    	
						   $qry_dept=$this->jobs_isolations_model->get_isolation_users(array('where'=>$where_dept));
							
							#echo '<pre> '.$this->db->last_query(); 
							if($qry_dept->num_rows()>0)
							{
								$department_isolators=$qry_dept->result_array();
							}
						}
					}
					
				
					$assigned_permits=$this->get_assigned_permits($id);
					
					$this->data['records']['work_permit_job_name'] = $assigned_permits['job_names'];
							
					$this->data['records']['work_permit_nos'] = $assigned_permits['work_permit_nos'];

					$this->data['records']['work_permit_status'] = $assigned_permits['permit_status'];
            }   
        }
		
		
	   $where="user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
	   
	   if($id=='')
	   $where.=' AND department_id = "'.$department_id.'" ';
	   else
	   $where.=' AND department_id = "'.$records['department_id'].'" ';
	  # $where.=' AND id = "'.$records['remarks_performing_id'].'"';
	   
		//Getting Active Companys List
	   $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role','where_condition'=>$where,'table'=>USERS));

		if($qry->num_rows()>0)
		{
			$authorities=$qry->result_array();
		}
		
		
		$this->data['authorities']=$authorities;
		
		$department_id="'".EIP_PRODUCTION."','".EIP_PACKING_OPERATION."','".EIP_MINES."'";
		
	   # $where="department_id IN(".$department_id.") AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";


	    $where="(department_id IN(".$department_id.") ";

	    if(IA_USERS!='')
 		    $where.=' OR id IN('.IA_USERS.')';

		$where.=") AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";


		//Getting Active Companys List
	    $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role,department_id','where_condition'=>$where,'table'=>USERS,'column'=>'first_name','dir'=>'asc'));
		
		#echo $this->db->last_query(); exit;
		
		$issuing_authorities='';
		
		if($qry->num_rows()>0)
		{
			$issuing_authorities=$qry->result_array();
		}
		
		$this->data['issuing_authorities']=$issuing_authorities;
		
		$this->data['user_id']=$this->session->userdata('user_id');
		
		$this->data['job_status_error_msg']=$job_status_error_msg;

		$this->data['zones_fetch']=$zones_fetch;
		
		#echo '<pre>'; print_r($department_isolators); exit;
		
		$this->data['department_isolators']=$department_isolators;
		
		$this->load->view('jobs_isolations/printout',$this->data);
	}


	
	public function get_assigned_permits($id)
	{

		$arr = array(JOBS,ELECTRICALPERMITS,CONFINEDPERMITS);	

		$job_descriptions=$permit_status= array();

		$work_permit_nos=$job_names='';

		foreach($arr as $ar)
		{
			//Jobs Permit
			$permits = $this->public_model->join_fetch_data(array('table1'=>$ar.' j','select'=>'j.job_name,j.id,j.permit_no,j.approval_status,j.job_name','where'=>'jir.jobs_isoloations_id="'.$id.'" AND 
				relation_type="'.$ar.'"','table2'=>JOBSISOLATIONRELATIONS.' jir','join_on'=>'j.id=jir.job_id','join_type'=>'inner','num_rows'=>false));	

			#echo '<br /> A '.$this->db->last_query();

			$permit_nums=$permits->num_rows();				
				
			if($permit_nums>0)
			{
				$fet_permits=$permits->result_array();	

				$job_descriptions=array_merge($job_descriptions,$fet_permits);

				$work_permit_nos.=implode(',',array_unique(array_column($fet_permits,'permit_no'))).',';

				$job_names.=implode(',',array_unique(array_column($fet_permits,'job_name'))).',';

				$approval_status=array_column($fet_permits,'approval_status');

				$permit_nos=array_column($fet_permits,'permit_no');

				#echo '<pre>'; print_r($approval_status); print_r($permit_nos);

				$permit_stat = array_combine(array_map(function($el) use ($permit_nos) {
    				return $permit_nos[$el];
							}, array_keys($approval_status)), array_values($approval_status));

				

				$permit_status=array_merge($permit_status,$permit_stat);

			}	
		}	


		#echo '<pre>'; print_r($permit_status); exit;
		if($work_permit_nos!='')
		{
			$work_permit_nos=rtrim($work_permit_nos,',');

			$job_names=rtrim($job_names,',');
		}	

		return array('job_descriptions'=>$job_descriptions,'work_permit_nos'=>$work_permit_nos,'job_names'=>$job_names,'permit_status'=>$permit_status);

	}


	public function ajax_get_isolations()
	{
		//echo '<pre>'; print_r($this->input->post());

		$zone_id=$this->input->post('zone_id');

		$where='zone_id="'.$zone_id.'" AND status = "'.STATUS_OPENED.'" AND DATE(date_end)>=DATE(NOW())';

		$qry=$this->public_model->get_data(array('select'=>'id,section,status,eip_no','where_condition'=>$where,'table'=>JOBSISOLATION));

		$options='';

		if($qry->num_rows()>0)
		{
			$fetch=$qry->result_array();

			foreach($fetch as $fet)
			{
				$options.='<option value="'.$fet['id'].'">'.$fet['section'].'('.$fet['eip_no'].')</option>';
			}

		}

		echo json_encode(array('options'=>$options)); exit;
	}

}
