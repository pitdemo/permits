<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : purchase_model.pph
 * Project        : Accounting Software
 * Creation Date  : 10-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage purchase details
*********************************************************************************************/	
class Purchase_model extends CI_Model {

	public	function __construct()
	{
			parent::__construct();
	}
	public function get_purchase_details($purchase_id=NULL) //get purchase details based on purchase id
	{
			$this->db->where('id',$purchase_id);
			$qry=$this->db->get('purchases');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
public function get_purchase_lists($segment_array=NULL) // get all purchases list from 'purchases' table except status deleted
	{
        $item = array_search('item_id',$segment_array);
		$status = array_search('status',$segment_array);
        $user_type = array_search('user_type',$segment_array);
		$person = array_search('person',$segment_array);
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
		$chk_item_id="";
        $chk_status= "";
        $chk_usertype="";
		$chk_person="";
        $start_date="";
        $end_date="";
         if($item!==FALSE)
		{
			$chk_item_id = $this->uri->segment($item+1);
		}
		if($status!==FALSE)
		{
			$chk_status = $this->uri->segment($status+1);	
		}
        
        if($user_type!==FALSE)
		{
			$chk_usertype = $this->uri->segment($user_type+1);	
		}
        
		 if($person!==FALSE)
		{
			$chk_person = $this->uri->segment($person+1);	
		}
        
		
        if($date_from!==FALSE)
		{
			$start_date = $this->uri->segment($date_from+1);	
		}
        
         if($date_end!==FALSE)
		{
			$end_date = $this->uri->segment($date_end+1);	
		}
        
        
        $this->db->select('purchases.user_id,purchases.id,purchases.purchase_date,purchases.item_id,purchases.qty,purchases.amount,purchases.remarks,purchases.user_type,purchases.status,purchases.created,purchases.modified');
        $this->db->from('purchases');
		
		
			
        
		if($item!==FALSE)
		{
			
			  $this->db->where('purchases.item_id IN ('.$chk_item_id.')');
           
		}
        if($chk_status !='') // manual search based on status
        {
            $this->db->where('purchases.status',$chk_status);
        }
        else
        {
            $this->db->where('purchases.status !=',STATUS_DELETED);
        }
        if($chk_usertype !='') // manual search based on user type (supplier or customer)
        {
            $this->db->where('purchases.user_type',strtolower($chk_usertype));
        }
        
		if($chk_person !='' && $chk_usertype=='customer' ) // manual search based on user type (sales person)
        {
        $this->db->join('customers as c','c.id=purchases.user_id','left');
		$where = 'c.sales_person_id IN ('.$chk_person.') ';
		 $this->db->where($where);
		
        }
		
		if($chk_person !='' && $chk_usertype=='supplier' )
        {
        
		 $this->db->join('suppliers as s','s.id=purchases.user_id','left');
		$where = 's.sales_person_id IN ('.$chk_person.') ';
		 $this->db->where($where);
		
        }
		
        if($start_date != "" && $end_date !="") // search based on purchase date
		{
			$this->db->where(array('date(purchases.purchase_date) >='=>$start_date,'date(purchases.purchase_date) <='=>$end_date));
		}
		$this->db->group_by('purchases.id'); 
        $this->db->order_by('purchases.id','desc');
        $qry = $this->db->get();
		#echo $this->db->last_query(); exit;
         return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
}