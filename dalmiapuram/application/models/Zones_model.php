<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zones_model extends CI_Model
{

	public	function __construct()
	{
		parent::__construct();
	}
	
	public function get_details($array_args='') // get single item details based on item id
	{
		if(is_array($array_args))
		extract($array_args);
		
			if(!empty($id))
			$this->db->where('id',$id);
			
			if(!empty($conditions))
			$this->db->where($conditions);
			
			$qry=$this->db->get(ZONES);
			
			return $qry;
	}	
}

?>