<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : jobd_model.php
 * Project        : Form Work
 * Creation Date  : 08-14-2016
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	

class Jobs_model extends CI_Model
{
	public	function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('public_model'));
		
        $notes='';
	}

	public function get_permit_types_name($permits,$permit_types)
	{
		$permit_type_names='';

		$permit_types=json_decode($permit_types,true);

		foreach($permits as $list){

			$permit_type_names.=(in_array($list['id'],$permit_types)) ? $list['name'].'<br />' : '';

		}
		$permit_type_names=rtrim($permit_type_names,'<br />');
		return $permit_type_names;
	}
	
	public function get_waiting_approval_name($array_args)
	{
		extract($array_args);	
		
				#$acceptance_issuing_id=$record['acceptance_issuing_id'];
				
				#$cancellation_issuing_id = $record['cancellation_issuing_id'];
				
				#$issuing_authority=$record['issuing_authority'];
		$user_id_column = '';
		switch($approval_status)
		{
			case 1: 
			case 2:
					$user_id_column=$record['acceptance_issuing_id'];	
					break;
			case 3:
			case 4:				
			case 5:	
			case 6:	
			case 7:	
					if($record['is_loto']=='Yes') {

						$user_id_column=json_decode($record['loto_closure_ids'],true);
						$loto_closure_ids_dates=json_decode($record['loto_closure_ids_dates'],true);

						//echo 'A '.count(array_filter($user_id_column)).' = '.count(array_filter($loto_closure_ids_dates));

						if(count(array_filter($user_id_column)) == count(array_filter($loto_closure_ids_dates)))
						{
							$user_id_column=$record['cancellation_issuing_id'];	
						} else
						$user_id_column=implode(',',array_filter($user_id_column));

					} else
					$user_id_column=$record['cancellation_issuing_id'];	

					break;
			case 9:
					$user_id_column=json_decode($record['clerance_department_user_id'],true);	

					$user_id_column=implode(',',array_filter($user_id_column));

					break;		
			case 11:
						$user_id_column=json_decode($record['isolated_user_ids'],true);	
	
						$user_id_column=implode(',',array_filter($user_id_column));
	
						break;		
			case 13:
						$user_id_column=$record['acceptance_loto_issuing_id'];	
						break;	
			case 14:
						$user_id_column=$record['acceptance_performing_id'];
						break;
			case 15:
						$user_id_column=$record['acceptance_performing_id'];	
						break;				
			case 21:
						$user_id_column=json_decode($record['loto_closure_ids'],true);	

						$user_id_column=implode(',',array_filter($user_id_column));

						break;		
			case 22:
						$user_id_column=json_decode($record['ext_issuing_authorities'],true);
						$user_id_column=implode(',',array_filter($user_id_column));
						break;	
		}
		
		#echo '<pre>'; print_r($user_id_column); exit;
		
		if($user_id_column!='')
		{	
			$get_name=$this->public_model->get_data(array('select'=>'first_name','where_condition'=>'id IN('.$user_id_column.')','table'=>USERS))->result_array();
			$first_name = array_column($get_name,'first_name');;

			

			$first_name=isset($get_name) ? strtoupper(implode('<br />',$first_name)) : '- - -';
		}
		else
		$first_name='- - -';
		
		return $first_name;
		
	}

	public function get_avis_waiting_approval_name($array_args)
	{
		extract($array_args);	
		
		$user_id_column = '';
		switch($approval_status)
		{
			case 1: 
			case 2:
					$user_id_column=$record['acceptance_issuing_id'];	
					break;
			case 3:
					$user_id_column=$record['acceptance_issuing_id'];	
					break;
			case 9:
					$user_id_column=json_decode($record['clerance_department_user_id'],true);	

					$user_id_column=implode(',',array_filter($user_id_column));

					break;		
			case 11:
						$user_id_column=json_decode($record['isolated_user_ids'],true);	
	
						$user_id_column=implode(',',array_filter($user_id_column));
	
						break;		
			case 13:
						$user_id_column=$record['acceptance_loto_issuing_id'];	
						break;	
			case 14:
						$user_id_column=$record['acceptance_performing_id'];
						break;
			case 15:	//Awaiting Final Submit
			case 16:	//Work In Progress
			case 19:	//Waiting to close
						$user_id_column=$record['acceptance_performing_id'];	
						break;		
			case 17:	//Waiting IA Closure
						$user_id_column=$record['closure_issuing_id'];	
						break;	
			case 18:     //Waiting to ISO Closures
						$user_id_column=json_decode($record['closure_isolator_ids'],true);	
						$user_id_column=implode(',',array_filter($user_id_column));
						break;	
		}
		
		#echo '<pre>'; print_r($user_id_column); exit;
		
		if($user_id_column!='')
		{	
			$get_name=$this->public_model->get_data(array('select'=>'first_name','where_condition'=>'id IN('.$user_id_column.')','table'=>USERS))->result_array();
			$first_name = array_column($get_name,'first_name');;

			

			$first_name=isset($get_name) ? strtoupper(implode('<br />',$first_name)) : '- - -';
		}
		else
		$first_name='- - -';
		
		return $first_name;
		
	}
    
	//Commonly using to fetch data from datatable
	public function fetch_data($array_args)
	{
		//print_r($array_args);exit;
		
		$zone_id=$this->session->userdata('zone_id');
		
		extract($array_args);	
		
		$this->db->select($fields);		
		
		$this->db->from(JOBS.' j');
		
		$this->db->join(DEPARTMENTS.' d',' d.id = j.department_id ','inner');
		
		$this->db->join(CONTRACTORS.' c',' c.id = j.contractor_id ','left');

		$this->db->join(JOBSISOLATION.' ji',' j.id = ji.job_id ','left');

		$this->db->join(JOB_EXTENDS.' je',' j.id = je.job_id ','left');
		
		if(isset($users_where_condition))
		$this->db->join(USERS.' u',$users_where_condition,'inner');
		
		$where=(isset($where)) ? $where : '';
		
		if(!empty($where))
		$this->db->where($where);
		
		if(isset($group_by))
		$this->db->group_by($group_by);  
		

		if($num_rows==false)
		{
			$this->db->order_by($column."   ".$dir);
			
			$this->db->limit($length,$start);
		}
		
		$get_query = $this->db->get();
		
		#echo $this->db->last_query(); exit;
		if($num_rows==true)
		return $get_query->num_rows();
		
		return $get_query;	
		
	}
	
}