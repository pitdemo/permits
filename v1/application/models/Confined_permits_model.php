<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : confined_permits_model.php
 * Project        : Form Work
 * Creation Date  : 08-14-2016
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	

class Confined_permits_model extends CI_Model
{
	public	function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('public_model'));
		
        $notes='';
	}

	public function get_user_ids($records)
	{


				$user_ids=$records['acceptance_issuing_id'].',';

				$user_ids.=$records['acceptance_performing_id'].',';

				if($records['cancellation_performing_id']!='')
				$user_ids.=$records['acceptance_performing_id'].',';					
				
				if($records['cancellation_issuing_id']!='')
				$user_ids.=$records['cancellation_issuing_id'].',';					

				$extended_ranges = range('a', 'f');

				$extended_safety_to_sign_id=json_decode($records['extended_safety_to_sign_id']);

				$extended_safety_from_sign_id=json_decode($records['extended_safety_from_sign_id']);

				$extended_performing_from_authority=json_decode($records['extended_performing_from_authority']);

				$extended_performing_to_authority=json_decode($records['extended_performing_to_authority']);

				$extended_issuing_to_authority=json_decode($records['extended_issuing_to_authority']);

				$extended_issuing_from_authority=json_decode($records['extended_issuing_from_authority']);


				foreach($extended_ranges as $extended_range)
				{
					$ex=(isset($extended_safety_to_sign_id->$extended_range)) ? $extended_safety_to_sign_id->$extended_range : '';
					if($ex!='')
					$user_ids.=$ex.',';
					
					$ex=(isset($extended_safety_from_sign_id->$extended_range)) ? $extended_safety_from_sign_id->$extended_range : '';
					if($ex!='')
					$user_ids.=$ex.',';

					$ex=(isset($extended_performing_from_authority->$extended_range)) ? $extended_performing_from_authority->$extended_range : '';
					if($ex!='')
					$user_ids.=$ex.',';

					$ex=(isset($extended_performing_to_authority->$extended_range)) ? $extended_performing_to_authority->$extended_range : '';
					if($ex!='')
					$user_ids.=$ex.',';

					$ex=(isset($extended_issuing_to_authority->$extended_range)) ? $extended_issuing_to_authority->$extended_range : '';
					if($ex!='')
					$user_ids.=$ex.',';

					$ex=(isset($extended_issuing_from_authority->$extended_range)) ? $extended_issuing_from_authority->$extended_range : '';
					if($ex!='')
					$user_ids.=$ex.',';
				}

				if($user_ids!='')
				{
					$user_ids=rtrim($user_ids,',');

					$user_ids=explode(',',$user_ids);

					#echo '<pre>'; print_r($user_ids);

					$user_ids=array_unique($user_ids);

					$user_ids=implode(',',$user_ids);

					$user_ids='id IN('.$user_ids.')';
				}
		return $user_ids;		

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
					$user_id_column=$record['acceptance_safety_sign_id'];	
					break;
			case 3:
			case 4:				
					$user_id_column=$record['acceptance_issuing_id'];	
					break;			
			case 5:	
			case 6:	
			case 7:
			case 8:			
					$user_id_column=$record['cancellation_issuing_id'];	
					break;
			
					/*$user_id_column=json_decode($record['issuing_authority']);	
					
					$user_id='';
					#echo '<pre>'; print_r($user_id_column);
						$r=array('a','b','c','d','e','f');
					for($rr=0;$rr<count($r);$rr++)
					{	
						$select=(isset($user_id_column->$r[$rr])) ? $user_id_column->$r[$rr] : '';
						
						#echo '<br /> S : '.$select.' - '.$rr.' - '.$r[$rr];
						
						if($select!='')
						$user_id=$select;
					}
					
					if($user_id!='')
					$user_id_column=$user_id;
					
					break;		*/
		}
		
		#echo '<pre>'; print_r($user_id_column).' =33 '.$approval_status.' = = '.$record['permit_no']; #exit;
		
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
		
		$this->db->from(CONFINEDPERMITS.' j');
		
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