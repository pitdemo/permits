<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : manufacturing_model.pph
 * Project        : Accounting Software
 * Creation Date  : 10-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage purchase details
*********************************************************************************************/	
class Manufacturing_model extends CI_Model {

	public	function __construct()
	{
			parent::__construct();
	}
	public function get_manufacture_lists() // get all manufacture list from 'manufactures_items' table
	{
        $this->db->select('*');
        $this->db->from('manufactures_items');
        $this->db->order_by('id','desc');
        $qry = $this->db->get();
            return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
    public function get_manufacture_material_items($manufacture_id=NULL) //get records from manufacture_material_items based on manufacture_id
    {
        $this->db->select('m.item_id,m.qty,i.item_name');
        $this->db->from('manufacture_material_items m');
        $this->db->join('items i','i.id=m.item_id','inner');
        $this->db->where('m.manufacture_item_id',$manufacture_id);
        $qry = $this->db->get();
        if($qry->num_rows() > 0)
            return $qry->result_array();
        
    }
    public function get_manufacture_item_details($manufacture_id=NULL)
    {
        $this->db->select('m.qty,m.manufacture_date,m.created,i.item_name');
        $this->db->from('manufactures_items m');
        $this->db->join('items i','i.id=m.item_id','inner');
        $this->db->where('m.id',$manufacture_id);
        $qry = $this->db->get();
        if($qry->num_rows() > 0)
            return $qry->row_array();
    }
	
	  public function get_manufacture_details($manufacture_id=NULL) //get manufacture_items details based on manufacture_id
	{
			$this->db->where('id',$manufacture_id);
			$qry=$this->db->get('manufactures_items');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
}