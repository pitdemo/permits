<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departments_model extends CI_Model
{

	public	function __construct()
	{
		parent::__construct();
	}
	
	public function get_details($array_args='') // get single item details based on item id
	{
		if(is_array($array_args))
		extract($array_args);
		
			$this->db->select($fields);
			
			if(!empty($id))
			$this->db->where('id',$id);
			
			if(!empty($conditions))
			$this->db->where($conditions);
			
			#$this->db->join(ZONES. ' z','z.id = d.zone_id','inner');
			
			$qry=$this->db->get(DEPARTMENTS. ' d');
			
			return $qry;
	}	
}

?>