<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : jobd_model.php
 * Project        : Form Work
 * Creation Date  : 08-14-2016
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	

class Avis_model extends CI_Model
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
			case 7:	
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
						$user_id_column=$record['acceptance_loto_pa_id'];
						break;
			case 15:
						$user_id_column=$record['acceptance_performing_id'];	
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
		
		$this->db->from(AVIS.' a');		

		$this->db->join(ZONES.' z',' z.id = a.zone_id ','inner');
		
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