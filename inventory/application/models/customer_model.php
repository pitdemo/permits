<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : customer_model.pph
 * Project        : Accounting Software
 * Creation Date  : 03-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage customer
*********************************************************************************************/	
class Customer_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
	
		
    public function get_sales_person_details($sales_person_id=NULL) //get sales details based on sales_person_id
		{
			$this->db->where('id',$sales_person_id);
			$qry=$this->db->get('sales_person_tbl');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	
	public function get_active_sales_person_lists()    //get sales person details based on sales_person_id
	{
			$this->db->where('status',STATUS_ACTIVE);
			$this->db->order_by('id','desc');
			$qry = $this->db->get('sales_person_tbl');
			if($qry->num_rows()>0)
				return $qry->result_array();
	}

 /*  public function get_active_sales_lists($details=NULL)
  {

    $sales_person_id=$details['chk_sales_id'];
    $item_id=$details['chk_item_id'];
    $this->db->select('sp.sales_person_name,i.item_name');  
    $this->db->from('sales sales_table');
    $this->db->join('sales_person_tbl sp','sp.id=sales_table.sales_person_id');
    $this->db->join('items i','i.id=sales_table.item_id');
    $this->db->where('sales_person_id', $sales_person_id);
    $this->db->where('item_id', $item_id);
    $this->db->where('sales_table.sales_person_id != "NULL" AND sales_table.status="active" AND sp.status="active" AND i.status="active"');

    $query = $this->db->get();

    return $query->row_array();

  }*/
   public function get_active_sales_lists($details=NULL)  // soundarya
  {
    
    $sales_person_id=$details['chk_sales_id'];
    $item_id=$details['chk_item_id'];
    $customer_id = $details['chk_customer_id'];
    $sales_date = $details['chk_sales_date'];
    //echo $sales_person_id;
    //echo $item_id;
    //echo $customer_id;
   // exit;
    $this->db->select('sp.sales_person_name,i.item_name,suppliers_table.supplier_name,customers_table.customer_name,sum(sales_table.qty) as qty');  
    $this->db->from('sales sales_table');
    $this->db->join('sales_person_tbl sp','sp.id=sales_table.sales_person_id');
    $this->db->join('items i','i.id=sales_table.item_id');
   /* $this->db->join('suppliers supplier','sales_table.user_id=supplier.id');
    $this->db->join('customers customer','sales_table.user_id=customer.id');*/
    $this->db->join('suppliers suppliers_table', 'suppliers_table.id=sales_table.user_id AND sales_table.user_type= "supplier" ','left');
    $this->db->join('customers customers_table', 'customers_table.id=sales_table.user_id AND sales_table.user_type= "customer" ','left');
    $this->db->where('sales_table.sales_person_id', $sales_person_id);
    $this->db->where('sales_table.item_id', $item_id);
    $this->db->where('sales_table.user_id',$customer_id);
    $this->db->where('DATE_FORMAT(sales_date,"%M-%Y")',$sales_date);
    $this->db->group_by('sales_table.user_id');
    $this->db->where('sales_table.sales_person_id != "NULL" AND sales_table.status="active" AND sp.status="active" AND i.status="active"');

    $query = $this->db->get();
    
    return $query->row_array();

  }

 /* public function get_ajax_active_sales_lists($details=NULL)
  {

    $sales_person_id=$details['chk_sales_id'];
    $item_id=$details['chk_item_id'];
    $start_date=$details['chk_start_date'];
    $end_date=$details['chk_end_date'];
    $sales_date = $details['chk_sales_date'];
    $this->db->select('suppliers_table.id,suppliers_table.supplier_name,customers_table.id,customers_table.customer_name,sales_table.sales_person_id,sales_table.qty,sales_table.sales_date,sales_table.sales_date,sales_table.status, sales_table.item_id,sp.sales_person_name,sp.id,i.id,i.item_name,sp.status,i.status');  
    $this->db->select('DATE_FORMAT ( sales_table.sales_date,"%M-%Y") as format_date',FALSE);
    $this->db->from('sales sales_table');
    $this->db->join('sales_person_tbl sp','sp.id=sales_table.sales_person_id');
    $this->db->join('items i','i.id=sales_table.item_id');
    $this->db->join('suppliers suppliers_table', 'suppliers_table.id=sales_table.user_id AND sales_table.user_type= "supplier" ', 'left');
    $this->db->join('customers customers_table', 'customers_table.id=sales_table.user_id AND sales_table.user_type= "customer" ', 'left');
    $this->db->where('sales_table.sales_person_id != "NULL"');
    $this->db->where('DATE_FORMAT(sales_table.sales_date,"%M-%Y")',$sales_date);
    $this->db->where('sales_table.sales_date >=',$start_date);
    $this->db->where('sales_table.sales_date <=',$end_date);
    $this->db->where('sales_table.sales_person_id', $sales_person_id);
    $this->db->where('sales_table.item_id', $item_id);

    $query = $this->db->get();
    
    return $query->result_array();

  }*/
   public function get_ajax_active_sales_lists($details=NULL)
  {

    $sales_person_id=$details['chk_sales_id'];
    $item_id=$details['chk_item_id'];
    $start_date=$details['chk_start_date'];
    $end_date=$details['chk_end_date'];
    $sales_date = $details['chk_sales_date'];
    $customer_id = $details['chk_customer_id'];
    $this->db->select('suppliers_table.id,suppliers_table.supplier_name,customers_table.id,customers_table.customer_name,sales_table.sales_person_id,sales_table.qty,sales_table.sales_date,sales_table.sales_date,sales_table.status, sales_table.item_id,sp.sales_person_name,sp.id,i.id,i.item_name,sp.status,i.status');  
    $this->db->select('DATE_FORMAT ( sales_table.sales_date,"%M-%Y") as format_date',FALSE);
    $this->db->from('sales sales_table');
    $this->db->join('sales_person_tbl sp','sp.id=sales_table.sales_person_id');
    $this->db->join('items i','i.id=sales_table.item_id');
    $this->db->join('suppliers suppliers_table', 'suppliers_table.id=sales_table.user_id AND sales_table.user_type= "supplier" ', 'left');
    $this->db->join('customers customers_table', 'customers_table.id=sales_table.user_id AND sales_table.user_type= "customer" ', 'left');
    $this->db->where('sales_table.sales_person_id != "NULL"');
    $this->db->where('DATE_FORMAT(sales_table.sales_date,"%M-%Y")',$sales_date);
    $this->db->where('sales_table.sales_date >=',$start_date);
    $this->db->where('sales_table.sales_date <=',$end_date);
    $this->db->where('sales_table.sales_person_id', $sales_person_id);
    $this->db->where('sales_table.item_id', $item_id);
    $this->db->where('sales_table.user_id', $customer_id );

    $query = $this->db->get();
    
    return $query->result_array();

  }

    public function get_ajax_active_customer_lists($details=NULL)
  {

    $sales_person_id=$details['chk_sales_id'];
    $item_id=$details['chk_item_id'];
    $start_date=$details['chk_start_date'];
    $end_date=$details['chk_end_date'];
    $this->db->select('suppliers_table.id,suppliers_table.supplier_name,customers_table.id,customers_table.customer_name,sales_table.sales_person_id,sales_table.qty,sales_table.sales_date,sales_table.sales_date,sales_table.status, sales_table.item_id,sp.sales_person_name,sp.id,i.id,i.item_name,sp.status,i.status');  
    $this->db->from('sales sales_table');
    $this->db->join('sales_person_tbl sp','sp.id=sales_table.sales_person_id');
    $this->db->join('items i','i.id=sales_table.item_id');
    $this->db->join('suppliers suppliers_table', 'suppliers_table.id=sales_table.user_id AND sales_table.user_type= "supplier" ', 'left');
    $this->db->join('customers customers_table', 'customers_table.id=sales_table.user_id AND sales_table.user_type= "customer" ', 'left');
    $this->db->where('sales_table.sales_person_id != "NULL"');
    $this->db->where('sales_table.sales_date >=',$start_date);
    $this->db->where('sales_table.sales_date <=',$end_date);
    $this->db->where('sales_table.sales_person_id', $sales_person_id);
    $this->db->where('sales_table.item_id', $item_id);
    $query = $this->db->get();
    return $query->result_array();

  }
public function get_customers_lists($segment_array=NULL) // get all sales list from 'sales' table except status deleted
	{
        $status = array_search('status',$segment_array);
        $user_type = array_search('user_type',$segment_array);
     
        $chk_status= "";
        $chk_usertype="";
    
		if($status!==FALSE)
		{
			$chk_status = $this->uri->segment($status+1);	
		}
        
        if($user_type!==FALSE)
		{
			$chk_usertype = $this->uri->segment($user_type+1);	
		}

        $this->db->select('*');
        $this->db->from('customers');
        
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
            $this->db->where('sales_person_id IN ('.$chk_usertype.')');
        }
        
    
        $this->db->order_by('id','desc');
        $qry = $this->db->get();
            return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
	
	 public function get_customer_history($customer_id=NULL,$segment_array=NULL) //get customer transactions history from item_history table based on customer id
       {
	    $day_type = array_search('day_type',$segment_array);
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
        $chk_daytype="";
		$start_date="";
        $end_date="";
		 if($day_type!==FALSE)
		{
			$chk_daytype = $this->uri->segment($day_type+1);	
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
        $this->db->from('item_history'); 
		 if($chk_daytype !='') // manual search based on user type (supplier or customer)
        {
			  if($chk_daytype !='custom')
			  {
			 $this->db->where('date BETWEEN DATE_SUB(NOW(), INTERVAL "'.$chk_daytype.'" DAY) AND NOW()');
			  }
        
				else   // search based on date
				{
					$this->db->where(array('date(date) >='=>$start_date,'date(date) <='=>$end_date));
				}
		}
		  $this->db->where('user_id',$customer_id);
          $this->db->where('user_type','customer');
          $this->db->order_by('date','desc');       
		   $qry = $this->db->get();
		   //echo $this->db->last_query();exit;
         return $qry->result_array();
		 
		 
			
       }
 public function get_customer_outstanding($customer_id=NULL) // get item history from 'item_history' table
        {
             $this->db->select('*');
             $this->db->from('item_history');
             $this->db->where('user_id',$customer_id);
			 $this->db->where('user_type','customer');
             $this->db->order_by('id','desc');
             $qry = $this->db->get();
                return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
        }
	
	public function get_active_customer_lists()
	{
			$this->db->where('status',STATUS_ACTIVE);
			$this->db->order_by('id','desc');
			$qry = $this->db->get('customers');
			if($qry->num_rows()>0)
				return $qry->result_array();
	}
	public function get_customer_details($customer_id=NULL)
	{
			$this->db->where('id',$customer_id);
			$qry=$this->db->get('customers');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
			public function ajax_get_customers_list()
		{
			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * Easy set variables
             */
            
            /* Array of database columns which should be read and sent back to DataTables. Use a space where
             * you want to insert a non-database field (for example a counter or static image)
            */
            $aColumns = array('id','customer_name','email_id','phone_no','status','id'); // don't change the order
            
            /* Indexed column (used for fast and accurate table cardinality) */
            $sIndexColumn = "id";
            
            /* DB table to use */
            $sTable = "customers";
            
            
            
            
            /* 
             * Paging
             */
            $sLimit = "";
            if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
            {
                $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
                    intval( $_GET['iDisplayLength'] );
            }
            
            
            /*
             * Ordering
             */
            $sOrder = "";
            if ( isset( $_GET['iSortCol_0'] ) )
            {
                $sOrder = "ORDER BY  ";
                for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
                {
                    if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
                    {
                        $sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
                            ($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
                    }
                }
                
                $sOrder = substr_replace( $sOrder, "", -2 );
                if ( $sOrder == "ORDER BY" )
                {
                    $sOrder = "";
                }
            }
            
            
            /* 
             * Filtering
             * NOTE this does not match the built-in DataTables filtering which does it
             * word by word on any field. It's possible to do here, but concerned about efficiency
             * on very large tables, and MySQL's regex functionality is very limited
             */
            $sWhere = "";
            if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
            {
                $sWhere = "WHERE (";
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
					
                    $sWhere .= "`".$aColumns[$i]."` LIKE '%".$this->db->escape_like_str( $_GET['sSearch'] )."%' OR ";
					
                }
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= ')';
            }
            
            /* Individual column filtering */
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
                {
                    if ( $sWhere == "" )
                    {
                        $sWhere = "WHERE ";
                    }
                    else
                    {
                        $sWhere .= " AND ";
                    }
                    $sWhere .= "`".$aColumns[$i]."` LIKE '%".$this->db->escape_like_str($_GET['sSearch_'.$i])."%' ";
                }
            }
			
						if($sWhere == "")
					{
							$sWhere .= "WHERE ( status != '".STATUS_DELETED."' ) ";
					}
					else
					{
            	$sWhere .= "AND ( status != '".STATUS_DELETED."' ) ";
					}
			
			$like_query = "";
			
            /*
             * SQL queries
             * Get data to display
             */
          $sQuery = "
                SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
                FROM   $sTable
                $sWhere
				ORDER BY id DESC
				$sLimit
                "; 
				//echo $sQuery; exit;
				//$rResult = $this->db->query($sQuery);
            $rResult = $this->db->query($sQuery);
            
            /* Data set length after filtering */
            $sQuery = "
                SELECT FOUND_ROWS()
            ";
            $rResultFilterTotal =  $this->db->query( $sQuery ) ;
            $aResultFilterTotal = $rResultFilterTotal->result_array();
			$iFilteredTotal = $aResultFilterTotal[0]['FOUND_ROWS()'];
            
            /* Total data set length */
            $sQuery = "
                SELECT COUNT(id) From ( select * 
                FROM   $sTable WHERE status != '".STATUS_DELETED."') as customer_table
            ";
			$rResultTotal =  $this->db->query($sQuery);
			$aResultTotal = $rResultTotal->result_array();
			$iTotal = $aResultTotal[0]['COUNT(id)'];
            
            
            /*
             * Output
             */
            $output = array(
                "sEcho" => intval($_GET['sEcho']),
                "iTotalRecords" => $iTotal,
                "iTotalDisplayRecords" => $iFilteredTotal,
                "aaData" => array()
            );
            
            foreach ( $rResult->result_array() as $aRow)
            {
                $row = array();
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    if($i==3)
                    {
                        if($aRow[ $aColumns[$i] ]==NULL)
                        {
                             $row[] = '---';
                        }
                        else
                        {
                            $row[] = $aRow[ $aColumns[$i] ];
                        }
                    }
                    else if($i==2)
                    {
                        if($aRow[ $aColumns[$i] ]==NULL)
                        {
                             $row[] = '---';
                        }
                        else
                        {
                            $row[] = $aRow[ $aColumns[$i] ];
                        }
                    }
                    else if ( $aColumns[$i] != ' ' )
                    {
                        /* General output */
                        $row[] = $aRow[ $aColumns[$i] ];
                    }
                }
                $output['aaData'][] = $row;
            }
								/*echo "<pre>";
            print_r($output); exit;*/
			
            echo json_encode( $output,true ); 
			
		}
	
		  public function get_customer_general_settings($customer_id=NULL) // get customer general details 
        {
             $this->db->select('*');
             $this->db->from('customers');
             $this->db->where('id',$customer_id);
             $this->db->order_by('id','desc');
             $qry = $this->db->get();
			 
                return $qry->result_array();
        }
		public function get_customer_payments($customer_id=NULL) // get customer payment details 
        {
			$this->db->select('*');
            $this->db->from('receipts');
            $this->db->where('user_id',$customer_id);
			$this->db->where('user_type','customer');
            $this->db->where('status',STATUS_ACTIVE);
            $this->db->order_by('receipt_date','desc');
			$qry = $this->db->get();
           	return $qry->result_array();
        }
     
	
	 
	   public function get_transactions_history($customer_id=NULL) //get customer transactions history from item_history table based on customer id
       {
            
			$this->db->select('item_history.user_id,item_history.date,item_history.qty_in,item_history.qty_out,item_history.item_id,item_history.user_id,item_history.user_type,item_history.record_type,item_history.amount as amount');
            $this->db->from('item_history');
            $this->db->where('user_id',$customer_id);
            $this->db->where('user_type','customer');
            $this->db->order_by('date','desc');
            $qry = $this->db->get();
			//echo $this->db->last_query(); exit;
            return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
       }
	    public function get_transactions_history_credit_debit($customer_id=NULL,$segment_array=NULL) //get customer transactions history from item_history table based on customer id
       {
        //print_r($segment_array);
        $record_type = array_search('record_type',$segment_array);
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
        $sales_person_id = array_search('sales_person_id',$segment_array); //soundarya
        $item_id = array_search('item_id',$segment_array); // soundarya
        //echo $item_id;
        //echo $sales_person_id;
        $chk_recordtype="";
        $start_date="";
        $end_date="";
        $ids = array();
        if($item_id !==FALSE&&$sales_person_id !==FALSE&&$customer_id !==FALSE) // spundarya
        {
            
            $get_sales_person_id = $this->uri->segment($sales_person_id+1); 
            $get_item_id = $this->uri->segment($item_id+1);
            $get_start_date = $this->uri->segment($date_from+1); 
            $get_end_date = $this->uri->segment($date_end+1);
            $get_relationship_ids = $this->db->select('id')->from('sales')->where('user_id',$customer_id)->where('item_id',$get_item_id)->where('sales_person_id',$get_sales_person_id)->where(array('sales_date >='=>$get_start_date,'sales_date <='=>$get_end_date))->where('status','active')->get();
            $get_relationship_id = $get_relationship_ids->result_array();
            
            foreach($get_relationship_id as $relation_ids)
            {
                $ids[] .= $relation_ids['id'];
            }
         //print_r($ids);
        }
        if($record_type!==FALSE)
		{
			$chk_recordtype = $this->uri->segment($record_type+1);	
		}
        
		
        if($date_from!==FALSE)
		{
			$start_date = $this->uri->segment($date_from+1);	
		}
        
         if($date_end!==FALSE)
		{
			$end_date = $this->uri->segment($date_end+1);	
		}
        if($sales_person_id!==FALSE) // added by soundarya
        {
          $sales_person_id = $this->uri->segment($sales_person_id+1); 
        }

        if($item_id!==FALSE) // added by soundarya
        {
          $item_id = $this->uri->segment($item_id+1); 
        }


       
        
        $this->db->select('item_history_table.user_id as customer,item_history_table.id,item_history_table.date,item_history_table.qty_in,item_history_table.qty_out,item_history_table.item_id,item_history_table.user_id,item_history_table.user_type,item_history_table.record_type,item_history_table.amount as history_amount,item_history_table.relationship_id,sales_table.remarks as s_remarks,purchases_table.remarks as p_remarks,receipts_table.remarks as r_remarks,ledger_table.remarks as l_remarks');
        $this->db->from('item_history item_history_table'); 
		$this->db->join('sales sales_table', 'sales_table.id=item_history_table.relationship_id ', 'left');
		$this->db->join('purchases purchases_table', 'purchases_table.id=item_history_table.relationship_id ', 'left');
		$this->db->join('receipts receipts_table', 'receipts_table.id=item_history_table.relationship_id ', 'left');
		$this->db->join('ledger ledger_table', 'ledger_table.id=item_history_table.relationship_id ', 'left');
		
		
        if($chk_recordtype !='') // manual search based on user type (supplier or customer)
        {
			//$this->db->where('item_history.record_type IN  ('.$chk_recordtype.')');
			$this->db->where_in('item_history_table.record_type',explode(",",$chk_recordtype));
        }
        if($start_date != "" && $end_date !="") // search based on purchase date
		{
			$this->db->where(array('date(item_history_table.date) >='=>$start_date,'date(item_history_table.date) <='=>$end_date));
		}

        if($item_id != "") // added by soundarya
        {
            $this->db->where("item_history_table.item_id",$item_id); //soundarya
        }
        if($sales_person_id != "") //soundarya
        {
           // echo "sales in";
           $this->db->where_in("item_history_table.relationship_id",$ids); //soundarya
        }
		$this->db->where('item_history_table.user_id',$customer_id);
        $this->db->where('item_history_table.user_type','customer');
        $this->db->order_by('item_history_table.date','desc');       
		$qry = $this->db->get();
			//echo $this->db->last_query(); exit;
        return $qry->result_array();
		 
		 
			
       }
}
