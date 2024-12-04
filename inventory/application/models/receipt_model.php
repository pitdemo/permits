<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : receipt_model.pph
 * Project        : Accounting Software
 * Creation Date  : 9-07-2015
 * Author         : K.Panneer selvam
 * Description    : Manage receipt details
*********************************************************************************************/	
class Receipt_model extends CI_Model {

	public	function __construct()
	{
			parent::__construct();
	}
	public function get_receipt_details($receipt_id=NULL) //get receipt details based on receipt id
	{
			$this->db->where('id',$receipt_id);
			$qry=$this->db->get('receipts');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	public function get_receipt_lists($segment_array=NULL) // get all receipt list from 'receipts' table except status deleted
	{
        $status = array_search('status',$segment_array);
        $user_type = array_search('user_type',$segment_array);
		$person = array_search('person',$segment_array);
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
        $chk_status= "";
        $chk_usertype="";
		$chk_person="";
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
        
         if($person!==FALSE)
		{
			$chk_person = $this->uri->segment($person+1);	
		}
        
        $this->db->select('receipts.user_id,receipts.attachment,receipts.id,receipts.receipt_date,receipts.amount,receipts.remarks,receipts.user_type,receipts.status,receipts.created,receipts.modified');
        $this->db->from('receipts');
        
        if($chk_status !='') // manual search based on status
        {
            $this->db->where('receipts.status',$chk_status);
        }
        else
        {
            $this->db->where('receipts.status !=',STATUS_DELETED);
        }
        if($chk_usertype !='') // manual search based on user type (supplier or customer)
        {
            $this->db->where('receipts.user_type',strtolower($chk_usertype));
        }
        
        if($start_date != "" && $end_date !="") // search based on purchase date
		{
			$this->db->where(array('date(receipts.receipt_date) >='=>$start_date,'date(receipts.receipt_date) <='=>$end_date));
		}
		if($chk_person !='' && $chk_usertype=='customer' ) // manual search based on user type (sales person)
        {
        $this->db->join('customers as c','c.id=receipts.user_id','left');
		$where = 'c.sales_person_id IN ('.$chk_person.') ';
		 $this->db->where($where);
		
        }
		
		if($chk_person !='' && $chk_usertype=='supplier' )
        {
        
		 $this->db->join('suppliers as s','s.id=receipts.user_id','left');
		$where = 's.sales_person_id IN ('.$chk_person.') ';
		 $this->db->where($where);
		
        }
        $this->db->group_by('receipts.id'); 
        $this->db->order_by('receipts.id','desc');
	
        $qry = $this->db->get();
		//echo $this->db->last_query(); exit;
            return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
// New Changes

	public function get_transaction_details($customer_id="")
	{
		$last_char=substr($customer_id, -1);
		$last_id=substr($customer_id,0, -2);
		//echo $last_id;
		if($last_char=='s')
		{
			$this->db->select('suppliers.outstanding,sales.id,sales.sales_date,sales.amount,item_history.item_id,items.item_name,item_history.record_type');
		// $this->db->select('customers.id,customers.outstanding,sales.sales_date,sales.remarks,item_history.record_type');    
		$this->db->where('suppliers.id',$last_id);
		$this->db->from('suppliers');
		$this->db->join('sales','suppliers.id = sales.user_id AND sales.user_type ="supplier"','inner');
		$this->db->join('item_history', 'sales.user_id = item_history.relationship_id AND item_history.record_type="s"','inner');
		$this->db->join('items','items.id=sales.item_id','inner');
		$this->db->order_by("sales.sales_date","desc");
	    return $this->db->get();
		}
		if($last_char=='c')
		{
		$this->db->select('customers.outstanding,sales.id,sales.sales_date,sales.amount,item_history.item_id,items.item_name,item_history.record_type');
		$this->db->where('customers.id',$last_id);
		$this->db->from('customers');
		$this->db->join('sales','customers.id = sales.user_id AND sales.user_type ="customer"','inner');
		$this->db->join('item_history', 'sales.user_id = item_history.relationship_id AND item_history.record_type="s"','inner');
		$this->db->join('items','items.id=sales.item_id','inner');
		$this->db->order_by("sales.sales_date","desc");
    	return $this->db->get();
		}
		
	}
		 public function get_outstanding_details($customer_id="")
	{
		$last_char=substr($customer_id, -1);
		$last_id=substr($customer_id,0, -2);
		//echo $last_id;
		if($last_char=='s')
		{
			$this->db->select('suppliers.outstanding,sales.id,sales.sales_date,sales.amount,item_history.item_id,items.item_name,item_history.record_type');
		// $this->db->select('customers.id,customers.outstanding,sales.sales_date,sales.remarks,item_history.record_type');    
		$this->db->where('suppliers.id',$last_id);
		$this->db->from('suppliers');
		$this->db->join('sales','suppliers.id = sales.user_id AND sales.user_type ="supplier"','inner');
		$this->db->join('item_history', 'sales.user_id = item_history.relationship_id AND item_history.record_type="s"','inner');
		$this->db->join('items','items.id=sales.item_id','inner');
		$this->db->order_by("sales.sales_date","desc");
	    return $this->db->get();
		}
		if($last_char=='c')
		{
		$this->db->select('customers.outstanding,sales.id,sales.sales_date,sales.amount,item_history.item_id,items.item_name,item_history.record_type');
		$this->db->where('customers.id',$last_id);
		$this->db->from('customers');
		$this->db->join('sales','customers.id = sales.user_id AND sales.user_type ="customer"','inner');
		$this->db->join('item_history', 'sales.user_id = item_history.relationship_id AND item_history.record_type="s"','inner');
		$this->db->join('items','items.id=sales.item_id','inner');
		$this->db->order_by("sales.sales_date","desc");
    	return $this->db->get();
		}
		
	}
	    public function get_transactions_history_credit_debit($customer_id=NULL) //get customer transactions history from item_history table based on customer id
       {
       	$last_char=substr($customer_id, -1);
 		$last_id=substr($customer_id,0, -2);
 		if($last_char=='c')
		{
        $this->db->select('item_history_table.user_id as customer,item_history_table.id,item_history_table.date,item_history_table.qty_in,item_history_table.qty_out,item_history_table.item_id,item_history_table.user_id,item_history_table.user_type,item_history_table.record_type,item_history_table.amount as history_amount,item_history_table.relationship_id,sales_table.remarks as s_remarks,purchases_table.remarks as p_remarks,receipts_table.remarks as r_remarks,ledger_table.remarks as l_remarks');
        $this->db->from('item_history item_history_table'); 
		$this->db->join('sales sales_table', 'sales_table.id=item_history_table.relationship_id ', 'left');
		$this->db->join('purchases purchases_table', 'purchases_table.id=item_history_table.relationship_id ', 'left');
		$this->db->join('receipts receipts_table', 'receipts_table.id=item_history_table.relationship_id ', 'left');
		$this->db->join('ledger ledger_table', 'ledger_table.id=item_history_table.relationship_id ', 'left');
		$this->db->where('item_history_table.user_id',$last_id);
        $this->db->where('item_history_table.user_type','customer');
        $this->db->order_by('item_history_table.date','desc');       
		$qry = $this->db->get();
         return $qry->result_array();
     }
     if($last_char=='s')
		{
		$this->db->select('item_history_table.user_id as supplier,item_history_table.id,item_history_table.date,item_history_table.qty_in,item_history_table.qty_out,item_history_table.item_id,item_history_table.user_id,item_history_table.user_type,item_history_table.record_type,item_history_table.amount as history_amount,item_history_table.relationship_id,sales_table.remarks as s_remarks,purchases_table.remarks as p_remarks,receipts_table.remarks as r_remarks,ledger_table.remarks as l_remarks');
        $this->db->from('item_history item_history_table'); 
		$this->db->join('sales sales_table', 'sales_table.id=item_history_table.relationship_id ', 'left');
		$this->db->join('purchases purchases_table', 'purchases_table.id=item_history_table.relationship_id ', 'left');
		$this->db->join('receipts receipts_table', 'receipts_table.id=item_history_table.relationship_id ', 'left');
		$this->db->join('ledger ledger_table', 'ledger_table.id=item_history_table.relationship_id ', 'left');
		$this->db->where('item_history_table.user_id',$last_id);
        $this->db->where('item_history_table.user_type','supplier');
        $this->db->order_by('item_history_table.date','desc');       
		$qry = $this->db->get();
         return $qry->result_array();
		}
       }
       public function get_outstanding($customer_id)
       {
       	$last_char=substr($customer_id, -1);
 		$last_id=substr($customer_id,0, -2);
 		if($last_char=='s')
		{
			return $this->db->get_where('suppliers',array('id'=>$last_id))->row_array();
		}
		if($last_char=='c')
		{
			return $this->db->get_where('customers',array('id'=>$last_id))->row_array();
		}

       }
       /* fucntion for get receipt list for print - soudnarya */
       public function get_print_receipt_lists($segment_array = NULL)
       {
       	$start_date = array_search("start",$segment_array);
       	$end_date = array_search("end", $segment_array);
       	$user_type = array_search("user_type",$segment_array);
       	$person  = array_search("person",$segment_array);
       	$status = array_search("status", $segment_array);
       	$chk_usertype ="";
       	$chk_person ="";
       	$chk_start="";
       	$chk_end="";
       	$chk_status="";
       	if($user_type !== FALSE)
       	{
       		$chk_usertype = $this->uri->segment($user_type+1);
       	}
       	if($start_date !== FALSE)
       	{
       		$chk_start = $this->uri->segment($start_date+1);
       	}
       	if($end_date !== FALSE)
       	{
       		$chk_end = $this->uri->segment($end_date+1);
       	}
       	if($status !== FALSE)
       	{
       		$chk_status = $this->uri->segment($status+1);
       	}
       	if($person !== FALSE)
       	{
       		$chk_person = $this->uri->segment($person+1);
       	}

       	$this->db->select('receipts.id,receipts.user_id,receipts.attachment,receipts.amount,receipts.remarks,receipts.receipt_date,receipts.user_type,receipts.status,receipts.created,receipts.modified');
       	$this->db->from('receipts');
       	if($chk_start != "" && $chk_end != "")
       	{
       		$this->db->where(array("date(receipts.receipt_date) >="=>$chk_start,"date(receipts.receipt_date) <="=>$chk_end));
       	}
       	if($chk_usertype != "")
       	{
       		$this->db->where('receipts.user_type',strtolower($chk_usertype));
       	}
       	if($chk_status != "")
       	{
       		$this->db->where("receipts.status",$chk_status);
       	}
       	else
       	{
          $this->db->where('receipts.status !=',STATUS_DELETED);
       	}

       	if($chk_person !='' && $chk_usertype=='customer' ) // manual search based on user type (sales person)
        {
            $this->db->join('customers as c','c.id=receipts.user_id','left');
            $where = 'c.sales_person_id IN ('.$chk_person.') ';
            $this->db->where($where);
            
        }
            
        if($chk_person !='' && $chk_usertype=='supplier' )
        {     
             $this->db->join('suppliers as s','s.id=receipts.user_id','left');
             $where = 's.sales_person_id IN ('.$chk_person.') ';
             $this->db->where($where);  
        }

        $this->db->order_by("receipts.receipt_date","desc");
        $qry = $this->db->get();
        return $qry->result_array();





       }



}