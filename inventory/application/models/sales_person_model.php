<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : sales_model.pph
 * Project        : Accounting Software
 * Creation Date  : 22-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage sales details
*********************************************************************************************/	
class Sales_person_model extends CI_Model {

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
    public function get_sales_person_details($sales_person_id=NULL) //get sales details based on sales_person_id
		{
			$this->db->where('id',$sales_person_id);
			$qry=$this->db->get('sales_person_tbl');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	public function get_sales_person_lists($segment_array=NULL) // get all sales list from 'sales' table except status deleted
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
        $this->db->from('sales_person_tbl');
        
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
        
      
        $this->db->order_by('id','desc');
        $qry = $this->db->get();
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
		   public function get_customer_details($sales_person_id=NULL) //get customer details based on sales_person_id
		{
			$this->db->where('sales_person_id',$sales_person_id);
			$qry=$this->db->get('customers');
						//echo $this->db->last_query();exit;
						return $qry->result_array();

	}
	  public function get_supplier_details($sales_person_id=NULL) //get customer details based on sales_person_id
		{
			$this->db->where('sales_person_id',$sales_person_id);
			$qry=$this->db->get('suppliers');
			return $qry->result_array();
	}
}