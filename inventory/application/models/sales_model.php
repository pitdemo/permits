<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : sales_model.pph
 * Project        : Accounting Software
 * Creation Date  : 22-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage sales details
*********************************************************************************************/	
class Sales_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
	public function get_payment_lists()
	{
			$this->db->where('status !=',STATUS_DELETED);
			$this->db->order_by('id','desc');
			$qry = $this->db->get('customer_payments');
			if($qry->num_rows()>0)
				return $qry->result_array();
	}
    public function get_sales_details($sales_id=NULL) //get sales details based on sales id
	{
			$this->db->where('id',$sales_id);
			$qry=$this->db->get('sales');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	public function get_sales_lists($segment_array=NULL) // get all sales list from 'sales' table except status deleted
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
        
        
        $this->db->select('sales.user_id,sales.id,sales.sales_date,sales.revert_stock,sales.item_id,sales.qty,sales.amount,sales.remarks,sales.user_type,sales.status,sales.created,sales.modified');
        $this->db->from('sales');
		
		
			
        
		if($item!==FALSE)
		{
			
			  $this->db->where('sales.item_id IN ('.$chk_item_id.')');
           
		}
        if($chk_status !='') // manual search based on status
        {
            $this->db->where('sales.status',$chk_status);
        }
        else
        {
            $this->db->where('sales.status !=',STATUS_DELETED);
        }
        if($chk_usertype !='') // manual search based on user type (supplier or customer)
        {
            $this->db->where('sales.user_type',strtolower($chk_usertype));
        }
        
		if($chk_person !='' && $chk_usertype=='customer' ) // manual search based on user type (sales person)
        {
        $this->db->join('customers as c','c.id=sales.user_id','left');
		$where = 'c.sales_person_id IN ('.$chk_person.') ';
		 $this->db->where($where);
		
        }
		
		if($chk_person !='' && $chk_usertype=='supplier' )
        {
        
		 $this->db->join('suppliers as s','s.id=sales.user_id','left');
		$where = 's.sales_person_id IN ('.$chk_person.') ';
		 $this->db->where($where);
		
        }
		
        if($start_date != "" && $end_date !="") // search based on purchase date
		{
			$this->db->where(array('date(sales.sales_date) >='=>$start_date,'date(sales.sales_date) <='=>$end_date));
		}
		$this->db->group_by('sales.id'); 
        $this->db->order_by('sales.id','desc');
        $qry = $this->db->get();
		#echo $this->db->last_query(); exit;
         return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
   public function get_payment_details($payment_id=NULL)
	{
			$this->db->where('id',$payment_id);
			$qry=$this->db->get('customer_payments');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
			public function ajax_get_payments_list()
		{
			
			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * Easy set variables
             */
            
            /* Array of database columns which should be read and sent back to DataTables. Use a space where
             * you want to insert a non-database field (for example a counter or static image)
            */
            $aColumns = array('customer_name','payment_date','amount','status','id'); // don't change the order
            
            /* Indexed column (used for fast and accurate table cardinality) */
            $sIndexColumn = "id";
            
            /* DB table to use */
            $sTable = "customer_payments";
            
            
            
            
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
        /*fucntion for print functionality - soundarya*/
        public function get_print_sales_lists($segment_array)
        {
           $item = array_search("item_id",$segment_array);
           $user_type = array_search("user_type",$segment_array);
           $person  = array_search("person",$segment_array);
           $start_date = array_search("start",$segment_array);
           $end_date = array_search("end", $segment_array);
           $status = array_search("status", $segment_array);
           $chk_item_id = "";
           $chk_usertype = "";
           $chk_person="";
           $chk_start = "";
           $chk_end="";
           $chk_status="";
           if($item !== FALSE)
           {
            $chk_item_id = $this->uri->segment($item+1);
           }
           if($user_type !== FALSE)
           {
            $chk_usertype = $this->uri->segment($user_type+1);
           }
           if($person !== FALSE)
           {
            $chk_person = $this->uri->segment($person+1);
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

           $this->db->select('sales.id,sales.user_id,sales.item_id,sales.sales_person_id,sales.sales_date,sales.qty,sales.amount,sales.remarks,sales.user_type,sales.revert_stock,sales.status,sales.created,sales.modified');
           $this->db->from('sales');

           if($chk_item_id != "")
           {
            $this->db->where('sales.item_id IN('.$chk_item_id.')');
           }
         
           if($chk_status != "")
           {
            $this->db->where("sales.status",$chk_status);
           }
           else
           {
           $this->db->where('sales.status !=',STATUS_DELETED);
           }

        
           if($chk_usertype !='') // manual search based on user type (supplier or customer)
           {
                $this->db->where('sales.user_type',strtolower($chk_usertype));
           }
           if($chk_start !="" && $chk_end !="") // manual search based  date 
           {
            $this->db->where(array('date(sales.sales_date) >='=>$chk_start,'date(sales.sales_date) <='=>$chk_end));
           }

           if($chk_person !='' && $chk_usertype=='customer' ) // manual search based on user type (sales person)
           {
            $this->db->join('customers as c','c.id=sales.user_id','left');
            $where = 'c.sales_person_id IN ('.$chk_person.') ';
            $this->db->where($where);
            
            }
            
            if($chk_person !='' && $chk_usertype=='supplier' )
            {
            
             $this->db->join('suppliers as s','s.id=sales.user_id','left');
             $where = 's.sales_person_id IN ('.$chk_person.') ';
             $this->db->where($where);
            
            }
            $this->db->order_by('sales.sales_date','desc');
            $qry = $this->db->get();
            //echo $this->db->last_query();
            return $qry->result_array(); 
           

        }
        
}