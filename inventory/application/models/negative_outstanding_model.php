<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : outstanding_model.php
 * Project        : Accounting Software
 * Creation Date  : 03-06-2015
 * Author         : G.Uma Maheswari
 * Description    : Negative Outstanding report
*********************************************************************************************/	
class Negative_outstanding_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
	
	   
	    public function get_customer_history($customer_id=NULL) // get item history from 'item_history' table
        {
             $this->db->select('*');
             $this->db->from('item_history');
             $this->db->where('user_id',$customer_id);
			 $this->db->where('user_type','customer');
             $this->db->order_by('id','desc');
             $qry = $this->db->get();
                return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
        }
		  public function get_supplier_history($supplier_id=NULL) // get item history from 'item_history' table
        {
             $this->db->select('*');
             $this->db->from('item_history');
             $this->db->where('user_id',$supplier_id);
			 $this->db->where('user_type','supplier');
             $this->db->order_by('id','desc');
             $qry = $this->db->get();
                return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
        }
		
		public function get_active_sales_person_customer_lists()    //get sales person details based on item history customers
	{
    $this->db->select('s_man.sales_person_name,s_man.id');
    $this->db->from('item_history i');
    $this->db->join('customers c','c.id = i.user_id');
    $this->db->join('sales_person_tbl s_man','s_man.id=c.sales_person_id');
	$this->db->where('s_man.status','active');
	$this->db->where('c.outstanding <', 0);
	$this->db->order_by('s_man.id','desc');
	$this->db->group_by('s_man.sales_person_name');
    $qry = $this->db->get();
			if($qry->num_rows()>0)
				return $qry->result_array();
		
	
	}
	
	public function get_active_sales_person_supplier_lists()    //get sales person details based on item history suppliers
	{
    $this->db->select('s_man.sales_person_name,s_man.id');
    $this->db->from('item_history i');
    $this->db->join('suppliers s','s.id = i.user_id');
    $this->db->join('sales_person_tbl s_man','s_man.id=s.sales_person_id');
	$this->db->where('s_man.status','active');
	$this->db->where('s.outstanding <', 0);
	$this->db->order_by('s_man.id','desc');
	$this->db->group_by('s_man.sales_person_name');
    $qry = $this->db->get();
			if($qry->num_rows()>0)
				return $qry->result_array();
		
	
	}
	
		public function get_customers_lists($segment_array=NULL) // get all sales list from 'sales' table except status deleted
	{
       	
		
			$user_type = array_search('user_type',$segment_array);
		 $person = array_search('person',$segment_array);
		  $person_supplier = array_search('person_supplier',$segment_array);
		   $sales_person_supplier = array_search('sales_person_supplier',$segment_array);
		   $sales_person_customer = array_search('sales_person_customer',$segment_array);
        $chk_usertype="";
		$chk_person="";
		$chk_person_supplier="";
		$chk_sales_person_supplier="";
		$chk_sales_person_customer="";
       
        if($user_type!==FALSE)
		{
			$chk_usertype = $this->uri->segment($user_type+1);	
		}
         if($sales_person_supplier!==FALSE)
		{
			$chk_sales_person_supplier = $this->uri->segment($sales_person_supplier+1);	
		}
		
		  if($sales_person_customer!==FALSE)
		{
			$chk_sales_person_customer = $this->uri->segment($sales_person_customer+1);	
		}
		
		 if($person_supplier!==FALSE)
		{
			$chk_person_supplier = $this->uri->segment($person_supplier+1);	
		}
         if($person!==FALSE)
		{
			$chk_person = $this->uri->segment($person+1);	
		}
        
		
	  if( $chk_usertype=='supplier' )
        {
        $this->db->select('i.user_id,s.supplier_name,s.id,i.date,i.record_type,s.outstanding,i.amount,i.user_type,s.sales_person_id');
        $this->db->from('item_history i');
       	 $this->db->join('suppliers s','s.id=i.user_id','inner');
		$this->db->where('user_type','supplier');
		$this->db->where('s.outstanding <', 0);
		$this->db->where('status !=','deleted');
		if(  $chk_person_supplier != '' )
		{
		$where = 's.id IN ('.$chk_person_supplier.') ';
		 $this->db->where($where);
		}
			if(  $chk_sales_person_supplier !='' )
		{
		$where = 's.sales_person_id IN ('.$chk_sales_person_supplier.') ';
		 $this->db->where($where);
		}
		
		
        $this->db->order_by('s.id','desc');
		}
	   
	  else
		{
		$this->db->select('i.user_id,c.customer_name,c.id,i.date,i.record_type,c.outstanding,i.amount,i.user_type,c.sales_person_id');
        $this->db->from('item_history i');
        $this->db->join('customers c','c.id=i.user_id','inner');
		$this->db->where('user_type','customer');
		$this->db->where('c.outstanding <', 0);
		$this->db->where('status !=','deleted');
		if( $chk_person != '' )
		{
		$where = 'c.id IN ('.$chk_person.') ';
		 $this->db->where($where);
		}
		
		if( $chk_sales_person_customer !='' )
		{
		$where = 'c.sales_person_id IN ('.$chk_sales_person_customer.') ';
		 $this->db->where($where);
		}
		
        $this->db->order_by('c.id','desc');
		}
		 $qry = $this->db->get();
		#echo $this->db->last_query();exit;
            return $qry->result_array();
 
  
	}
	
	public function get_supplier_details($supplier_id=NULL)   // get supplier general details 
	{
			$this->db->where('id',$supplier_id);
			$qry=$this->db->get('suppliers');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	
	
	public function get_active_customer_lists($sales_customer_id) //get active customer general details 
	{
		 
			$this->db->where('status',STATUS_ACTIVE);
			$this->db->where('sales_person_id IN ('.$sales_customer_id.') ');
			$this->db->where('status !=','deleted');
			$this->db->where('outstanding <', 0);
			$this->db->order_by('id','desc');
			$qry = $this->db->get('customers');
			if($qry->num_rows()>0)
				return $qry->result_array();
	}
	
	public function get_active_supplier_lists($sales_supplier_id) //get active customer general details 
	{
		 
			$this->db->where('status',STATUS_ACTIVE);
			$this->db->where('sales_person_id IN ('.$sales_supplier_id.') ');
			$this->db->where('status !=','deleted');
			$this->db->where('outstanding <', 0);
			$this->db->order_by('id','desc');
			$qry = $this->db->get('suppliers');
			if($qry->num_rows()>0)
				return $qry->result_array();
	}
	
	public function get_customer_details($customer_id=NULL)  // get customer general details 
	{
			$this->db->where('id',$customer_id);
			$qry=$this->db->get('customers');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
				public function get_active_customer_lists_all($segment_array=NULL) //get active customer general details 
	{
			$sales_person_customer = array_search('sales_person_customer',$segment_array);
			$chk_sales_person_customer="";
			  if($sales_person_customer!==FALSE)
			{
				$chk_sales_person_customer = $this->uri->segment($sales_person_customer+1);	
			}
			$this->db->where('status !=','deleted');
			$this->db->where('status',STATUS_ACTIVE);
			
			if( $chk_sales_person_customer !='' )
			{
			$where = 'sales_person_id IN ('.$chk_sales_person_customer.') ';
			$this->db->where('outstanding <', 0);
			 $this->db->where($where);
			}
		
			$this->db->order_by('id','desc');
			$qry = $this->db->get('customers');
			//echo $this->db->last_query(); exit;
			if($qry->num_rows()>0)
				return $qry->result_array();
	}
	
	public function get_active_supplier_lists_all($segment_array=NULL)    //get active supplier general details 
	{
			$sales_person_supplier = array_search('sales_person_supplier',$segment_array);
			$chk_sales_person_supplier="";
			if($sales_person_supplier!==FALSE)
			{
				$chk_sales_person_supplier = $this->uri->segment($sales_person_supplier+1);	
			}
			$this->db->where('status',STATUS_ACTIVE);
			$this->db->where('outstanding <', 0);
			$this->db->where('status !=','deleted');
			if(  $chk_sales_person_supplier !='' )
			{
			$where = 'sales_person_id IN ('.$chk_sales_person_supplier.') ';
			 $this->db->where($where);
			}
			$this->db->order_by('id','desc');
			$qry = $this->db->get('suppliers');
			if($qry->num_rows()>0)
				return $qry->result_array();
	}
	
	
	 public function get_outstanding_customer($customer_id=NULL) // get item history from 'item_history' table
        {
             $this->db->select('*');
             $this->db->from('item_history');
             $this->db->where('user_id',$customer_id);
			 //$this->db->where('user_type','customer');
             $this->db->order_by('id','asc');
             $qry = $this->db->get();
                return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
        }
		
}
