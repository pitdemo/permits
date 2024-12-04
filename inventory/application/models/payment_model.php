<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : Payment_model.php
 * Project        : Accounting Software
 * Creation Date  : 03-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage customer payment
*********************************************************************************************/	
class Payment_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
		
public function get_payment_lists($segment_array=NULL) // get all purchase list from 'purchases' table except status deleted
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
        $this->db->from('customer_payments');
        
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
			$this->db->where(array('date(payment_date) >='=>$start_date,'date(payment_date) <='=>$end_date));
		}
		
        
        $this->db->order_by('id','desc');
        $qry = $this->db->get();
            return $qry->result_array();
	}
	
	public function get_payment_details($payment_id=NULL) //get purchase details based on purchase id
	{
			$this->db->where('id',$payment_id);
			$qry=$this->db->get('customer_payments');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
			
		
}
?>