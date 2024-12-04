<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Dashboard.php
 * Project        : Formwork
 * Creation Date  : 12-14-2016
 * Author         : Anantha Kumar RJ
 * Description    : Manageing Dashbaord Datas 
*********************************************************************************************/	

class Dashboard extends CI_Controller
 {

	function __construct()
	{
		parent::__construct(); 

        $this->load->model(array('security_model','jobs_model','public_model','jobs_isolations_model'));
		
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}

/**********************************************************************************************
 * Description    : Grab all counts data from Dashboard table based on by logged company user
**********************************************************************************************/	

	public function index()
	{
		$this->load->view($this->data['controller'].'index');
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

		$where_condition=$qry='';
		
		$where_condition='j.status NOT IN("'.STATUS_CLOSED.'","'.STATUS_CANCELLATION.'") AND j.is_dashboard="'.YES.'"';

		
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
							30=>'pt.name as permit_types',
							31=>'je.ext_reference_codes',
							32=>'j.acceptance_custodian_id'
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

				$permit_types=$record['permit_types'];

				

				if($is_rejected==YES)
					$approval_status=11;
				
				$time_diff='- - -';
				
				if(in_array($status,array(STATUS_PENDING,STATUS_OPENED)))
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

				if($record['is_loto']==YES && preg_split('/<br[^>]*>/i', $waiating_approval_by)>0 && in_array($approval_status,array(5,7)))
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
				
						$json[$j]['id']='#'.$permit_no;
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

	
}
