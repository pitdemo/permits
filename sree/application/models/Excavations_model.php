<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Excavations_model.php
 * Project        : Form Work
 * Creation Date  : 07-10-2018
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	

class Excavations_model extends CI_Model
{
	public	function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('public_model'));
		
        $notes='';
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
					
					$user_id_column=json_decode($record['dept_issuing_id'],true);	

					$dept_approval_status=json_decode($record['dept_approval_status'],true);	

					#print_r($user_id_column); print_r($dept_approval_status); exit;
					
					$user_id='';
					#echo '<pre>'; print_r($user_id_column);
					$r=range('a','e');
					#for($rr=0;$rr<count($r);$rr++)
					foreach($user_id_column as $key => $select)
					{	
						#$select=(isset($user_id_column->$r[$rr])) ? $user_id_column->$r[$rr] : '';
						
						if($select!='' && $dept_approval_status[$key]!='Yes')
						$user_id.=$select.',';
					}
					
					$user_id = rtrim($user_id,',');

					if($user_id!='')
					$user_id_column=$user_id;					
					break;	
			case 3:			
					$user_id_column=$record['acceptance_issuing_id'];	
					break;			
		}
		
		#echo '<pre>'; print_r($user_id_column); exit;
		
		if($user_id_column!='')
		{	
			$get_name=$this->public_model->get_data(array('select'=>'first_name','where_condition'=>'id IN('.$user_id_column.')','table'=>USERS))->result_array();

			$first_name=strtoupper(implode(',',array_column($get_name,'first_name')));
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
		
		$this->db->from(EXCAVATIONPERMITS.' j');
		
		$this->db->join(DEPARTMENTS.' d',' d.id = j.department_id ','inner');
		
		$this->db->join(CONTRACTORS.' c',' c.id = j.contractor_id ','left');
		
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
		
		#echo $this->db->last_query();
		if($num_rows==true)
		return $get_query->num_rows();
		
		return $get_query;	
		
	}
	
}