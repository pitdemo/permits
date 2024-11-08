<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Jobs_isolations_model.php
 * Project        : Form Work
 * Creation Date  : 08-14-2016
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	

class Jobs_isolations_model extends CI_Model
{
	public	function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('public_model'));
		
        $notes='';
	}

	public function check_job_relationship($isoloation_permit_nos,$relation_type)
	{
		$user_name=$this->session->userdata('first_name');
		
		$user_id=$this->session->userdata('user_id');

		$im_isoloation_permit_nos = implode(',',$isoloation_permit_nos);

		$qry=$this->public_model->get_data(array('select'=>'id,jobs_isoloations_id','where_condition'=>'jobs_isoloations_id IN('.$im_isoloation_permit_nos.')','table'=>JOBSISOLATIONRELATIONS));

		if($qry->num_rows()>0)
		{
			$qry_fet = $qry->result_array();

			$ex_relation = array_column($qry_fet,'jobs_isoloations_id');
		}
		else
			$ex_relation = array();	

		$array_insert = array();

		$array_insert_notes = array();

		foreach($isoloation_permit_nos as $isoloation_permit_no)
		{
			if(!in_array($isoloation_permit_no,$ex_relation))
			{
				$array_insert[]=array('id'=>$isoloation_permit_no,'approval_status'=>12);

				$array_insert_notes[]=array('jobisolation_id'=>$isoloation_permit_no,'created'=>date('Y-m-d H:i'),'user_id'=>$user_id,'notes'=>'Noassigned permits. Auto cancel by '.$user_name);
			}
		}

		if(count($array_insert)>0)
		{
			$this->db->insert_batch(JOBSISOLATIONHISTORY,$array_insert_notes);

			$this->db->update_batch(JOBSISOLATION,$array_insert,'id');
		}

		return;

	}

	public function get_waiting_approval_name($array_args)
	{
		extract($array_args);		
			
		$user_id_column = '';		

		switch((int)$approval_status)
		{
			case 1: 			
					$user_id_column=$record['remarks_issuing_id'];	
					break;
			case 3:
					$user_id_column=json_decode($record['isolated_name'],true);	

					$user_id_column = array_filter($user_id_column);

					$isolated_name_approval=json_decode($record['isolated_name_approval'],true);	
					
					$user_id='';
					
					$r=range(1,15);
					
					for($r=1;$r<=count($user_id_column);$r++)
					{	
						$select=($user_id_column[$r]!='') ? $user_id_column[$r].',' : '';

						$iso_approval=($isolated_name_approval[$r]!='') ? $isolated_name_approval[$r] : '';
						
						if($select!='' && $iso_approval=='')
						$user_id.=$select;					
					}
					
					if($user_id!='')
					$user_id_column=rtrim($user_id,',');					
					break;		
			case 4:		
					$user_id_column=$record['issuing_authority_id2'];	
					break;			
			case 5:
			case 6:
					$user_id_column=$record['performing_authority_id2'];
					if($user_id_column=='')	
					$user_id_column = $record['remarks_performing_id'];
					break;	
		}
		
		if($user_id_column!='')
		{	
			if(is_array($user_id_column))
				$user_id_column=implode(',', $user_id_column);
			#echo '<pre>'; print_r($user_id_column);

			$get_name=$this->public_model->get_data(array('select'=>'first_name','where_condition'=>'id IN('.$user_id_column.')','table'=>USERS))->result_array();

			$first_name=strtoupper(implode(',',array_column($get_name,'first_name')));
		}
		else
		$first_name='- - -';
		
		return $first_name;
		
	}

	public function get_isolation_users_closure($array_args)
	{
		extract($array_args);	
		
		$this->db->select('u.first_name as internal,u.id,u.department_id,isl.isolation_id');
		
		$this->db->from(USERS.' u');
		
		$this->db->join(ISOLATIONDEPARTMENTS.' isl','isl.department_id = u.department_id','inner');
		
		#$this->db->join(USERISOLATION.' ui','ui.user_id = u.id','inner');
		
		if(isset($isolation_type_id))
		$this->db->where('isl.isolation_id',$isolation_type_id);
		
		if(isset($where))
		$this->db->where($where);
		
		$this->db->where('u.is_isolator','Yes');
		
		$this->db->where('u.status',STATUS_ACTIVE);

		#$this->db->group_by('u.id');
		
		$get=$this->db->get();
		
		#echo $this->db->last_query();
		
		return $get;
	}
	
	public function get_isolation_users($array_args)
	{
		extract($array_args);	
		
		$this->db->select('u.first_name,u.id,u.department_id,isl.isolation_id');
		
		$this->db->from(USERS.' u');
		
		$this->db->join(ISOLATIONDEPARTMENTS.' isl','isl.department_id = u.department_id','inner');
		
		#$this->db->join(USERISOLATION.' ui','ui.user_id = u.id','inner');
		
		if(isset($isolation_type_id))
		$this->db->where('isl.isolation_id',$isolation_type_id);
		
		if(isset($where))
		$this->db->where($where);
		
		$this->db->where('u.is_isolator','Yes');
		
		$this->db->where('u.status',STATUS_ACTIVE);

		#$this->db->group_by('u.id');
		
		$get=$this->db->get();
		
		#echo $this->db->last_query();
		
		return $get;
	}
	
	//Commonly using to fetch data from datatable
	public function fetch_data($array_args)
	{
		//print_r($array_args);exit;
		
		$zone_id=$this->session->userdata('zone_id');
		
		extract($array_args);	
		
		$this->db->select($fields);		
		
		$this->db->from(JOBSISOLATION.' j');
		
		$this->db->join(DEPARTMENTS.' d',' d.id = j.department_id ','inner');

		$this->db->join(JOBSISOLATION_REISOLATIONS.' jr',' jr.jobs_isolations_id = j.id','inner');
		
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
		
		#echo $this->db->last_query();
		if($num_rows==true)
		return $get_query->num_rows();
		
		return $get_query;	
		
	}
	
}