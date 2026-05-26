<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : electrical_model.php
 * Project        : Form Work
 * Creation Date  : 07-07-2018
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	

class Electrical_model extends CI_Model
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
			case 2:
					$user_id_column=$record['acceptance_issuing_id'];	
					break;
			case 3:
			case 4:				
			case 5:	
			case 6:	
					$user_id_column=$record['cancellation_issuing_id'];	
					break;
			case 7:
			case 8:
					$user_id_column=json_decode($record['issuing_authority']);	
					
					$user_id='';
					#echo '<pre>'; print_r($user_id_column);
						$r=array('a','b','c','d','e','f');
					#for($rr=0;$rr<count($r);$rr++)
					foreach($user_id_column as $key => $select)	
					{	
						#$select=(isset($user_id_column->$r[$rr])) ? $user_id_column->$r[$rr] : '';
						
						#echo '<br /> S : '.$select.' - '.$rr.' - '.$r[$rr];
						
						if($select!='')
						$user_id=$select;
					}
					
					if($user_id!='')
					$user_id_column=$user_id;
					
					break;		
		}
		
		#echo '<pre>'; print_r($user_id_column); exit;
		
		if($user_id_column!='')
		{	
			$get_name=$this->public_model->get_data(array('select'=>'first_name','where_condition'=>'id = '.$user_id_column,'table'=>USERS,'limit'=>1))->row_array();
			$first_name=strtoupper($get_name['first_name']);
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
		
		$this->db->from(ELECTRICALPERMITS.' j');
		
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