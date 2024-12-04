<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : sales_model.pph
 * Project        : Accounting Software
 * Creation Date  : 22-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage sales details
*********************************************************************************************/	
class Ledger_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
	
    public function get_ledger_details($ledger_id=NULL) //get sales details based on sales id
	{
			$this->db->where('id',$ledger_id);
			$qry=$this->db->get('ledger');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	public function get_ledger_lists($segment_array=NULL) // get all sales list from 'sales' table except status deleted
	{
        $status = array_search('status',$segment_array);
        $user_type = array_search('user_type',$segment_array);
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
        $chk_status= "";
        $chk_usertype="";
        $start_date="";
        $end_date="";
		if($status!==FALSE)
		{
			$chk_status = $this->uri->segment($status+1);	
		}
        
        if($user_type!==FALSE)
		{
			$chk_usertype = $this->uri->segment($user_type+1);	
		}
        
        if($date_from!==FALSE)
		{
			$start_date = $this->uri->segment($date_from+1);	
		}
        
         if($date_end!==FALSE)
		{
			$end_date = $this->uri->segment($date_end+1);	
		}
        
        
        $this->db->select('*');
        $this->db->from('ledger');
        
        if($chk_status !='') // manual search based on status
        {
            $this->db->where('status',$chk_status);
        }
        else
        {
            $this->db->where('status !=',STATUS_DELETED);
        }
        if($chk_usertype !='') // manual search based on user type (supplier or customer)
        {
            $this->db->where('user_type',strtolower($chk_usertype));
        }
        
        if($start_date != "" && $end_date !="") // search based on purchase date
		{
			$this->db->where(array('date(ledger_date) >='=>$start_date,'date(ledger_date) <='=>$end_date));
		}
        $this->db->order_by('id','desc');
        $qry = $this->db->get();
            return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
	
}