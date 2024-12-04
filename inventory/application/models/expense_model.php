<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : expense_model.pph
 * Project        : Accounting Software
 * Creation Date  : 22-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage expense details
*********************************************************************************************/	
class Expense_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
	
  	public function get_expense_details($expense_id=NULL) // get expense details
	{
			$this->db->where('id',$expense_id);
			$qry=$this->db->get('expenses');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	public function get_category_details($category_id=NULL) // get single category details based on category_id
	{
			$this->db->where('id',$category_id);
			$qry=$this->db->get('expenses_category');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	public function get_expenses_lists($segment_array=NULL) // get all expenses list from 'expenses' table except status deleted
	{
	    $status = array_search('status',$segment_array);
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
        $category = array_search('category',$segment_array); // added for display category id based report - soundarya
        $chk_status= "";
        $start_date="";
        $end_date="";
        $category_id="";  // added for display category id based report - soundarya
		if($status!==FALSE)
		{
			$chk_status = $this->uri->segment($status+1);	
		}
        if($date_from!==FALSE)
		{
			$start_date = $this->uri->segment($date_from+1);	
		}
        
         if($date_end!==FALSE)
		{
			$end_date = $this->uri->segment($date_end+1);	
		}
        if($category !== FALSE)   // added for display category id based report - soundarya
        {
            $category_id = base64_decode($this->uri->segment($category+1)); 
        }
        
        $this->db->select('*');
        $this->db->from('expenses');
        
        if($chk_status !='') // manual search based on status
        {
            $this->db->where('status',$chk_status);
        }
        else
        {
            $this->db->where('status !=',STATUS_DELETED);
        }

        if($start_date != "" && $end_date !="") // search based on expense date
		{
			$this->db->where(array('date(expense_date) >='=>$start_date,'date(expense_date) <='=>$end_date));
		}
        if($category_id != "")   // added for display category id based report - soundarya
        {
            $this->db->where('category_id',$category_id);
        }
        $this->db->order_by('id','desc');
        $qry = $this->db->get();
        return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
	
		public function get_active_category_lists()
	{
			$this->db->where('status',STATUS_ACTIVE);
			$this->db->order_by('id','desc');
			$qry = $this->db->get('expenses_category');
			if($qry->num_rows()>0)
				return $qry->result_array();
	}
			public function ajax_get_category_list()
		{
			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * Easy set variables
             */
            
            /* Array of database columns which should be read and sent back to DataTables. Use a space where
             * you want to insert a non-database field (for example a counter or static image)
            */
            $aColumns = array('id','expense_category','created','status','id'); // don't change the order
            
            /* Indexed column (used for fast and accurate table cardinality) */
            $sIndexColumn = "id";
            
            /* DB table to use */
            $sTable = "expenses_category";
            
            
            
            
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
        /* fucntion for get receipt list for print - soudnarya */
       public function get_print_expenses_lists($segment_array = NULL)
       {
        $start_date = array_search("start",$segment_array);
        $end_date = array_search("end", $segment_array);
        $status = array_search("status", $segment_array);
        $chk_start="";
        $chk_end="";
        $chk_status="";
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
        $this->db->select('*');
        $this->db->from('expenses');
        if($chk_start != "" && $chk_end != "")
        {
            $this->db->where(array("date(expense_date) >="=>$chk_start,"date(expense_date) <="=>$chk_end));
        }
        if($chk_status != "")
        {
            $this->db->where("status",$chk_status);
        }
        else
        {
          $this->db->where('status !=',STATUS_DELETED);
        }

        $this->db->order_by("id","desc");
        $qry = $this->db->get();
        return $qry->result_array();


       }
       /*get expense category name - soundarya*/
       public function get_expense_category_details($id)
       {
        $this->db->where('id',$id);
        $qry = $this->db->get('expenses_category');
        if($qry->num_rows() > 0)
        {
            return $qry->row_array();
        }

       }

}