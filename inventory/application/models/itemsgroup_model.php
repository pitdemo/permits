<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : itemsgroup_model.pph
 * Project        : Accounting Software
 * Creation Date  : 28-12-2018
 * Author         : Soundarya
 * Description    : Items group
*********************************************************************************************/	
class Itemsgroup_model extends CI_Model {

	public	function __construct()
	{
			parent::__construct();
	}
	public function get_group_details($group_id=NULL) // Get group details based on group id
	{
		$this->db->where('id',$group_id);
			$qry=$this->db->get('items_group');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	public function get_items_details($items_id=NULL) // get active item list
	{
		$ids = explode(",",$items_id);
		$this->db->select('id,item_code,item_name,status');
		$this->db->from('items');
		$this->db->where_in('id',$ids);
		//$this->db->where('status !=',STATUS_DELETED);
		$this->db->where('status =',STATUS_ACTIVE);
		$qry = $this->db->get();
		if($qry->num_rows() > 0)
		 return $qry->result_array();

	}
	public function get_item_group_details($item_group_id=NULL)
	{
		$this->db->where('id',$item_group_id);
		$qry = $this->db->get('items_group');
		if($qry->num_rows() > 0)
			return $qry->row_array();
	}
	public function get_items_group_lists() //get active item group list
	{
		$qry = $this->db->get_where("items_group",array("status ="=>STATUS_ACTIVE));
		if($qry->num_rows() > 0)
		 return  $qry->result_array();
	}
	public function get_item_ids($items_group=NULL) // get items id based on selected item group id in item group dropdown
	{
		$items_group_ids = explode(",",$items_group);
		$this->db->select('items');
		$this->db->from('items_group');
		$this->db->where_in('id',$items_group_ids);
		$this->db->where('status =',STATUS_ACTIVE);
		$qry = $this->db->get();
		if($qry->num_rows() > 0)
		 return $qry->result_array();

	}

}
?>