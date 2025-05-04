<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : jobd_model.php
 * Project        : Form Work
 * Creation Date  : 08-14-2016
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	

class Scaffoldings_model extends CI_Model
{
	public	function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('public_model'));
		
        $notes='';
	}
	
	
	//Commonly using to fetch data from datatable
	public function fetch_data($array_args)
	{	
		extract($array_args);	
		
		$this->db->select($fields);		
		
		$this->db->from(SCAFFOLDINGS.' s');		

		$this->db->join(JOBS.' j',' j.id = s.job_id ','inner');	

		$this->db->join(USERS.' aci','aci.id=s.acceptance_performing_id','inner');

		$this->db->join(USERS.' aii','aii.id=s.acceptance_issuing_id','inner');
		
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