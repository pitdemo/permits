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
		$this->security_model->chk_is_user();        
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}

/**********************************************************************************************
 * Description    : Grab all counts data from Dashboard table based on by logged company user
**********************************************************************************************/	

	public function index()
	{ 
		
		redirect('jobs/myjobs');
		
		$company_id=$this->session->userdata('companies_id');
	
		
		$dashboard_counts=json_decode($this->public_model->dashboard_count());		
		#echo $this->db->last_query(); exit;
		
		#echo '<pre>'; print_r($dashboard_counts); exit;
		$this->data['status']=$dashboard_counts->status;
		
		$this->data['status_counts']=$dashboard_counts->status_counts;
		
		$this->data['eip_status']=$dashboard_counts->eip_status;
		
		$this->data['eip_status_counts']=$dashboard_counts->eip_status_counts;
		
		$this->load->view($this->data['controller'].'lists',$this->data);
	}
	
	public function view_all_messages()
	{
		$this->load->view($this->data['controller'].'view_all_messages',$this->data);
	}
	
	public function fetch_all_messages()
	{
		$access_modules = $this->session->userdata('user_access'); 
		
		$user_access = explode(',',$access_modules);
		
		$company_id=$this->session->userdata('companies_id');
		
		$segment_array=$this->uri->segment_array();

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$where_condition='companies_id="'.$company_id.'" AND ';
		  
		  //Getting in URL params
		  $request_search=(isset($_REQUEST['search'])) ? $_REQUEST['search'] : '';
		  if(trim($request_search)!='')
		  $search_value=$request_search;
		  
          /* Search Parameters */
		  //Using for reload datatable
		
		$where_condition=rtrim($where_condition,'AND ');
		
		if(!empty($search_value))
		{
			$search_value=urldecode($search_value);
			
			$where_condition.=" AND (message like '%".$search_value."%')";
		}
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$records=$this->public_model->fetch_message_data(array('table'=>MESSAGE,'select'=>'*','num_rows'=>false,'where_condition'=>$where_condition,'column'=>$sort_by,'dir'=>$order_by,'limit'=>$limit));
		
		$totalFiltered=$this->public_model->fetch_message_data(array('table'=>MESSAGE,'select'=>'*','where_condition'=>$where_condition,'num_rows'=>true));
		
		//$totalFiltered = $records->num_rows();
		
		$json=array();
		
		if($records->num_rows()>0)
		{
			$j=0;
			$records = $records->result_array();
			foreach($records as $record)
			{						
						if(in_array('accounts',$user_access)) 
							$json[$j]['message']=str_replace("BASE_URL",base_url(),$record['message']);
						else
							$json[$j]['message']=strip_tags($record['message']);
						$json[$j]['created']='<center>'.$record['created'].'</center>';
						$j++;
			}
		}

		$json=json_encode($json);
							
		$return='{"total":'.intval( $totalFiltered ).',"recordsFiltered":'.intval( $totalFiltered ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}
}
