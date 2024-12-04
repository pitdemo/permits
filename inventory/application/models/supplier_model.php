<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : supplier_model.pph
 * Project        : Accounting Software
 * Creation Date  : 05-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage supplier
*********************************************************************************************/	
class Supplier_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
	public function get_active_supplier_lists()    //get active supplier general details 
	{
			$this->db->where('status',STATUS_ACTIVE);
			$this->db->order_by('id','desc');
			$qry = $this->db->get('suppliers');
			if($qry->num_rows()>0)
				return $qry->result_array();
	}
	 public function get_sales_person_details($sales_person_id=NULL) //get sales person details based on sales_person_id
		{
			$this->db->where('id',$sales_person_id);
			$qry=$this->db->get('sales_person_tbl');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	
	public function get_active_sales_person_lists()   // get active sales person general details 
	{
			$this->db->where('status',STATUS_ACTIVE);
			$this->db->order_by('id','desc');
			$qry = $this->db->get('sales_person_tbl');
			if($qry->num_rows()>0)
				return $qry->result_array();
	}
	public function get_supplier_details($supplier_id=NULL)   // get supplier general details 
	{
			$this->db->where('id',$supplier_id);
			$qry=$this->db->get('suppliers');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
			
	 public function get_supplier_history($supplier_id=NULL,$segment_array=NULL) //get supplier transactions history from item_history table based on supplier_id
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
		  $this->db->where('user_id',$supplier_id);
          $this->db->where('user_type','supplier');
          $this->db->order_by('date','desc');       
		   $qry = $this->db->get();
		   //echo $this->db->last_query();exit;
         return $qry->result_array();
		 
		 
			
       }		
			
    public function get_suppliers_lists($segment_array=NULL) // get all suppliers list from 'suppliers' table except status deleted
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
        $this->db->from('suppliers');
        
        if($chk_status !='') // manual search based on status
        {
            $this->db->where('status',$chk_status);
        }
        else
        {
            $this->db->where('status !=',STATUS_DELETED);
        }
        if($chk_usertype !='') // manual search based on user type (sales person)
        {
            $this->db->where('sales_person_id IN ('.$chk_usertype.')');
        }
        
    
        $this->db->order_by('id','desc');
        $qry = $this->db->get();
        return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
	
			
			
			
			public function ajax_get_supplier_list()
		{
			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * Easy set variables
             */
            
            /* Array of database columns which should be read and sent back to DataTables. Use a space where
             * you want to insert a non-database field (for example a counter or static image)
            */
            $aColumns = array('id','supplier_name','outstanding','phone_no','status','id'); // don't change the order
            
            /* Indexed column (used for fast and accurate table cardinality) */
            $sIndexColumn = "id";
            
            /* DB table to use */
            $sTable = "suppliers";
            
            
            
            
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
                FROM   $sTable WHERE status != '".STATUS_DELETED."') as supplier_table
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
                    if ( $aColumns[$i] != ' ' )
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
		 public function get_supplier_general_settings($supplier_id=NULL) // get supplier general details 
        {
             $this->db->select('*');
             $this->db->from('suppliers');
             $this->db->where('id',$supplier_id);
             $this->db->order_by('id','desc');
             $qry = $this->db->get();
			 
                return $qry->result_array();
        }
		public function get_supplier_payments($supplier_id=NULL) // get supplier payment details 
        {
			$this->db->select('*');
            $this->db->from('receipts');
            $this->db->where('user_id',$supplier_id);
			$this->db->where('user_type','supplier');
            $this->db->where('status',STATUS_ACTIVE);
            $this->db->order_by('receipt_date','desc');
			$qry = $this->db->get();
           	return $qry->result_array();
        }
       public function get_transactions_history($supplier_id=NULL) //get supplier transactions history from item_history table based on supplier id
       {
            $this->db->select('*');
             $this->db->from('item_history');
             $this->db->where('user_id',$supplier_id);
            $this->db->where('user_type','supplier');
             $this->db->order_by('date','desc');
             $qry = $this->db->get();
                return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
       }
	       public function get_transactions_history_credit_debit($supplier_id=NULL,$segment_array=NULL) //get customer transactions history from item_history table based on customer id
       {
        $record_type = array_search('record_type',$segment_array);
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
        $sales_person_id = array_search('sales_person_id',$segment_array); //soundarya
        $item_id = array_search('item_id',$segment_array); // soundarya
        $chk_recordtype="";
        $start_date="";
        $end_date="";
        $ids = array();
        if($item_id !==FALSE&&$sales_person_id !==FALSE&&$supplier_id !==FALSE) // spundarya
        {
            
            $get_sales_person_id = $this->uri->segment($sales_person_id+1); 
            $get_item_id = $this->uri->segment($item_id+1);
            $get_start_date = $this->uri->segment($date_from+1); 
            $get_end_date = $this->uri->segment($date_end+1);
            $get_relationship_ids = $this->db->select('id')->from('sales')->where('user_id',$supplier_id)->where('item_id',$get_item_id)->where('sales_person_id',$get_sales_person_id)->where(array('sales_date >='=>$get_start_date,'sales_date <='=>$get_end_date))->where('status','active')->get();
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
        
      $this->db->select('item_history_table.user_id as supplier,item_history_table.id,item_history_table.date,item_history_table.qty_in,item_history_table.qty_out,item_history_table.item_id,item_history_table.user_id,item_history_table.user_type,item_history_table.record_type,item_history_table.amount as history_amount,item_history_table.relationship_id,sales_table.remarks as s_remarks,purchases_table.remarks as p_remarks,receipts_table.remarks as r_remarks,ledger_table.remarks as l_remarks');
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
		  $this->db->where('item_history_table.user_id',$supplier_id);
      $this->db->where('item_history_table.user_type','supplier');
      $this->db->order_by('item_history_table.date','desc');       
		  $qry = $this->db->get();
			//echo $this->db->last_query(); exit;
      return $qry->result_array();
		 
		 
		 
			
       }
}
?>