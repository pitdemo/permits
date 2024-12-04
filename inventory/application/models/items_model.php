<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : items_model
 * Project        : Accounting Software
 * Creation Date  : 02-06-2015
 * Author         : K.Panneer selvam
 * Description    : Items and Inventory
*********************************************************************************************/	
class Items_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
	public function get_active_item_lists() // get item active list records
	{
			$this->db->where('status',STATUS_ACTIVE);
			$this->db->order_by('id','desc');
			$qry = $this->db->get('items');
			if($qry->num_rows()>0)
				return $qry->result_array();
	}
	/*  public function get_inventory_details($id=NULL) //get sales details based on sales_person_id
		{
			$this->db->select('SUM(history_table.qty_in) as opening_stock');
 			$this->db->from('items items_table');
		    $this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
			$this->db->where('history_table.item_id',$id);
			//$this->db->where('history_table.date','min(history_table.date)');
			$this->db->group_by('history_table.date');
			$this->db->limit(1);
			$query = $this->db->get(); 
			//echo $this->db->last_query(); exit;
			return $query->result_array();
	}*/
public function get_inventory_details($id,$segment_array=NULL) // get all items list from 'history table'
	{
       
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
		
        $start_date="";
        $end_date="";
      
        if($date_from!==FALSE)
		{
			$start_date = $this->uri->segment($date_from+1);	
		}
        
         if($date_end!==FALSE)
		{
			$end_date = $this->uri->segment($date_end+1);	
		}
        
        
      if($start_date == "" && $end_date == '') 
	   {
		 $this->db->select('SUM(history_table.qty_in)  as qty_in,SUM(history_table.qty_out)  as qty_out, SUM(history_table.qty_in - history_table.qty_out) as balance,history_table.date as opening_date,history_table.id' );
 		$this->db->from('items items_table');
		$this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
		$this->db->where('history_table.item_id',$id);
		$this->db->group_by('history_table.date'); 
		$this->db->order_by('history_table.id', 'asc');
		   $this->db->limit(1);
	   }
    else  if($start_date != "" && $end_date !="") // search based on history date
		{
		 $this->db->select('SUM(history_table.qty_in)  as qty_in,SUM(history_table.qty_out)  as qty_out, SUM(history_table.qty_in - history_table.qty_out) as balance,history_table.date as opening_date,history_table.id' );
 		$this->db->from('items items_table');
		$this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
		$this->db->where('history_table.item_id',$id);
		$this->db->group_by('history_table.date'); 
		$this->db->order_by('history_table.id', 'desc');
		$this->db->where('date(history_table.date) <=', $start_date);
	 	   $this->db->limit(1,1);
		}
        $qry = $this->db->get();
		
		
     #echo $this->db->last_query(); 
       $result =  $qry->result_array();
	   $i = 0 ; 
	   $num = $qry->num_rows();
	//print_r($result);exit;
	   if($num > 0){
	 if($start_date == "" && $end_date == '') 
	   {
		     foreach($result as $row)
	   {
		return   $value = $row['qty_in'];
	   }
	   }
	  else  if($start_date != "" && $end_date !="") 
	  {
		   foreach($result as $row)
	   {
		if($row['qty_in'] !=  0)
		return   $value = $row['qty_in'];
		else 
			return   $value = $row['balance'];
	   }
	  }
	   }
	  else
	{
	   $this->db->select('SUM(history_table.qty_in)  as qty_in, SUM(history_table.qty_in - history_table.qty_out) as balance,history_table.date as opening_date,history_table.id' );
 		$this->db->from('items items_table');
		$this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
		$this->db->where('history_table.item_id',$id);
		$this->db->group_by('history_table.date'); 
		$this->db->order_by('history_table.id', 'asc');
			$this->db->where('date(history_table.date) >=', $start_date);
	 	 $this->db->limit(1);
		 $qry = $this->db->get();
		$result =  $qry->result_array();
		//  echo $this->db->last_query(); exit;
			foreach($result as $row)
	   {
		return   $value = $row['qty_in'];
	   }
	}
	   
	   exit;
		// No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
	
	
	public function get_inventory_date_details($id,$segment_array=NULL) // get all items list from 'history table'
	{
       
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
		
        $start_date="";
        $end_date="";
      
        if($date_from!==FALSE)
		{
			$start_date = $this->uri->segment($date_from+1);	
		}
        
         if($date_end!==FALSE)
		{
			$end_date = $this->uri->segment($date_end+1);	
		}
       if($start_date == "" && $end_date == '') 
	   {
         $this->db->select('SUM(history_table.qty_in)  as opening_stock, SUM(history_table.qty_in - history_table.qty_out) as balance,history_table.date as opening_date,history_table.id' );
 		$this->db->from('items items_table');
		$this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
		$this->db->where('history_table.item_id',$id);
		$this->db->group_by('history_table.date'); 
		$this->db->order_by('history_table.id', 'asc');
		   $this->db->limit(1);
	   }
    else  if($start_date != "" && $end_date !="") // search based on history date
		{
		//$this->db->where(array('date(history_table.date) >='   =>$start_date,'date(history_table.date) <='=>$end_date));
		 $this->db->select('SUM(history_table.qty_in)  as opening_stock, SUM(history_table.qty_in - history_table.qty_out) as balance,history_table.date as opening_date,history_table.id' );
 		$this->db->from('items items_table');
		$this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
		$this->db->where('history_table.item_id',$id);
		$this->db->group_by('history_table.date'); 
		$this->db->order_by('history_table.id', 'desc');
		$this->db->where('date(history_table.date) <=', $start_date);
	 	   $this->db->limit(1,1);
		}
		
		     $qry = $this->db->get();
   # echo $this->db->last_query();
		  //  $result =  $qry->result_array();
	  $num = $qry->num_rows();  

		    $result =  $qry->result_array();
		  $num = $qry->num_rows();
		  $i = 0;
	 if($num > 0)
	 {
	foreach($result as $row)
	   {
		return   $value = $row['opening_date'];
	   }
	   }
	else
	{
	   $this->db->select('SUM(history_table.qty_in)  as qty_in, SUM(history_table.qty_in - history_table.qty_out) as balance,history_table.date as opening_date,history_table.id' );
 		$this->db->from('items items_table');
		$this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
		$this->db->where('history_table.item_id',$id);
		$this->db->group_by('history_table.date'); 
		$this->db->order_by('history_table.id', 'asc');
			$this->db->where('date(history_table.date) >=', $start_date);
	 	 $this->db->limit(1);
		 $qry = $this->db->get();
		$result =  $qry->result_array();
		//  echo $this->db->last_query(); exit;
			foreach($result as $row)
	   {
		return   $value = $row['opening_date'];
	   }
	  
	}
//    echo $this->db->last_query(); exit;
       //return   $qry->result_array();
		   
	
		// No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
	
	public function get_active_itemhistory_lists() // get item active list records
	{
			 $this->db->select('items_table.id,items_table.item_code,items_table.item_name,items_table.item_type,history_table.date,items_table.stock,SUM(history_table.qty_in) as qty_in,SUM(history_table.qty_out) as qty_out');
 			$this->db->from('items items_table' );
		    $this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
			$this->db->group_by('history_table.item_id');
			$this->db->where('items_table.stock !=' , 0);
			$this->db->order_by('items_table.id','desc');
			$qry = $this->db->get();
			if($qry->num_rows()>0)
				return $qry->result_array();
	}
	public function get_item_details($item_id=NULL) // get single item details based on item id
	{
			$this->db->where('id',$item_id);
			$qry=$this->db->get('items');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	public function get_last_item_id() // get last item id from 'items' table
	{
		$this->db->select('*');
		$this->db->from('items');
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$qry = $this->db->get();
			if($qry->num_rows() > 0)
			{
					$result = $qry->row_array();
					return $result['item_code'];
			}
			else {
				return ITEM_CODE;
		}
	
	}
	public function ajax_get_items_list() // using datatable ajax to load item lists
		{
			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
             * Easy set variables
             */
            
            /* Array of database columns which should be read and sent back to DataTables. Use a space where
             * you want to insert a non-database field (for example a counter or static image)
            */
            $aColumns = array('item_code','item_name','item_type','stock','status','id'); // don't change the order
            
            /* Indexed column (used for fast and accurate table cardinality) */
            $sIndexColumn = "id";
            
            /* DB table to use */
            $sTable = "items";
            
            
            
            
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
                FROM   $sTable WHERE status != '".STATUS_DELETED."') as items_table
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
        public function get_item_purchase_history($item_id=NULL) // get item purchase details from 'purchase' table based on item id
        {
             $this->db->select('*');
             $this->db->from('purchases');
             $this->db->where('item_id',$item_id);
             $this->db->where('status !=',STATUS_DELETED);
             $this->db->order_by('id','desc');
             $qry = $this->db->get();
                return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
        }
        public function get_item_sales_history($item_id=NULL) // get item sales details from 'sales' table based on item id
        {
             $this->db->select('*');
             $this->db->from('sales');
             $this->db->where('item_id',$item_id);
             $this->db->where('status !=',STATUS_DELETED);
             $this->db->order_by('id','desc');
             $qry = $this->db->get();
                return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
        }
        public function get_item_manufacture_history($item_id=NULL) //get item manufacture history from 'manufacture_history' table based on item id
        {
            $this->db->select('m.item_id,m.manufacture_item_id,m.qty_in,m.qty_out,m.manf_date,i.item_name');
            $this->db->from('manufacture_history m');
            $this->db->join('items i','i.id=m.item_id','inner');
            $this->db->where('m.item_id',$item_id);
            $this->db->order_by('m.id','desc');
            $qry = $this->db->get();
                return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
        }
        public function get_item_history($item_id=NULL) // get item history from 'item_history' table
        {
             $this->db->select('*');
             $this->db->from('item_history');
             $this->db->where('item_id',$item_id);
             $this->db->order_by('id','asc');
             $qry = $this->db->get();
                return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
        }
	
		public function get_item_opening_stock($id,$segment_array=NULL) // get all items list from 'history table'
	{
        $today = date('Y-m-d'); //2016-04-07
		$last_thirty= date('Y-m-d', strtotime('-30 days', strtotime($today)));  //2016-03-08
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
		
        $start_date="";
        $end_date="";
		
		   if($date_from!==FALSE)
            {
               $start_date = $this->uri->segment($date_from+1);	
            }
				else
			{
				$start_date  = $last_thirty ;
			}

             if($date_end!==FALSE)
            {
                $end_date = $this->uri->segment($date_end+1);	
            }
				else
			{
				$end_date=  $today;
			}
            
  $where_condition='status != "items_table.deleted" AND ';
  	   $stocks=',(select ih.qty_in from item_history ih where ih.item_id=items_table.id  order by ih.id asc limit 1) as opening_stock';
       
	   if ($date_from !== FALSE )
		{
			$start_date = $this->uri->segment($date_from+1);
			$end_date = $this->uri->segment($date_end+1);
			$start_date = str_replace("-","/",$start_date);
			$end_date = str_replace("-","/",$end_date);
			$where_condition.= "(date(history_table.date) BETWEEN '".date("Y-m-d",strtotime($start_date))."' AND '".date("Y-m-d",strtotime($end_date))."') AND ";
			//$where_condition.= "(date(history_table.date) = '".date("Y-m-d",strtotime($start_date))."' ) AND ";
			$stocks=",(select (SUM(ih.qty_in) - SUM(ih.qty_out)) from item_history ih where ih.item_id=items_table.id AND date(ih.date)<'".date("Y-m-d",strtotime($start_date))."') as opening_stock";
		}
		else
		{
			$end_date = date('Y-m-d'); //2016-04-07
			$start_date= date('Y-m-d', strtotime('-30 days', strtotime($end_date)));  //2016-03-08
			
			$start_date = str_replace("-","/",$start_date);
			$end_date = str_replace("-","/",$end_date);
			$where_condition.= "(date(history_table.date) BETWEEN '".date("Y-m-d",strtotime($start_date))."' AND '".date("Y-m-d",strtotime($end_date))."') AND ";
			//$where_condition.= "(date(history_table.date) = '".date("Y-m-d",strtotime($start_date))."' ) AND ";
			$stocks=",(select (SUM(ih.qty_in) - SUM(ih.qty_out)) from item_history ih where ih.item_id=items_table.id AND date(ih.date)<'".date("Y-m-d",strtotime($start_date))."') as opening_stock";
		}
	   
   
			$this->db->select('SUM(history_table.qty_in) -  SUM(history_table.qty_out) as closing_stock,'.$stocks);
		   // $this->db->select('items_table.*,history_table.*,'.$stocks);
 			$this->db->from('items items_table' );
		    $this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
			$this->db->where('history_table.item_id' , $id);
			$this->db->where('items_table.stock !=' , 0);
			$this->db->order_by('history_table.date', 'asc');
			if($where_condition!='')
			{
				$where_condition = rtrim($where_condition,'AND ');
				$this->db->where($where_condition);
			} 
			$query = $this->db->get(); 
		//	echo $this->db->last_query(); exit;
		
        $ret = $query->row(); 
	
		 return $ret ;  // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
	
		public function get_item_history_stock($id,$segment_array=NULL) // get all items list from 'history table'
	{
        $today = date('Y-m-d'); //2016-04-07
		$last_thirty= date('Y-m-d', strtotime('-30 days', strtotime($today)));  //2016-03-08
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
		
        $start_date="";
        $end_date="";
		
		   if($date_from!==FALSE)
            {
               $start_date = $this->uri->segment($date_from+1);	
            }
				else
			{
				$start_date  = $last_thirty ;
			}

             if($date_end!==FALSE)
            {
                $end_date = $this->uri->segment($date_end+1);	
            }
				else
			{
				$end_date=  $today;
			}
            

	   
        $this->db->select('*');
 		$this->db->from('item_history');
		$this->db->where('item_id',$id);
		$this->db->order_by('date', 'asc');
	
        if($start_date != "" && $end_date !="") // search based on history date
		{
			$this->db->where(array('date(date) >='=>$start_date,'date(date) <='=>$end_date));
		   $this->db->order_by('date', 'asc');
		}
		else
		{
			$this->db->where(array('date(date) >='=>$start_date,'date(date) <='=>$end_date));
		   $this->db->order_by('date', 'asc');
		}
		
        $query = $this->db->get();
			
#	echo $this->db->last_query(); exit;
		//echo "<pre>";
		//print_r($qry->result_array()); exit;
         return $query->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	} 


public function get_inventory_lists($segment_array=NULL) // get all sales list from 'sales' table except status deleted
	{
        $item = array_search('item_id',$segment_array);
		$date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
		$chk_item_id="";
        $start_date="";
        $end_date="";
         if($item!==FALSE)
		{
			$chk_item_id = $this->uri->segment($item+1);
		}
		
        
		
        if($date_from!==FALSE)
		{
			$start_date = $this->uri->segment($date_from+1);	
		}
        
         if($date_end!==FALSE)
		{
			$end_date = $this->uri->segment($date_end+1);	
		}
        
 $stocks=",(select (SUM(ih.qty_in) - SUM(ih.qty_out)) from item_history ih where ih.item_id=items_table.id AND date(ih.date)<'".date("Y-m-d",strtotime($start_date))."') as opening_stock";       
 $closing_stocks = ",(((CASE WHEN SUM(history_table.qty_in) IS NULL THEN 0 ELSE SUM(history_table.qty_in) END) + (select IF((SUM(ih1.qty_in) - SUM(ih1.qty_out)) IS NULL,0,(SUM(ih1.qty_in) - SUM(ih1.qty_out))) from item_history ih1 where ih1.item_id=items_table.id AND date(ih1.date)<'".date("Y-m-d",strtotime($start_date))."'))-(CASE WHEN SUM(history_table.qty_out) IS NULL THEN 0 ELSE SUM(history_table.qty_out) END)) as closing_stock";    
  
  $this->db->select('items_table.id,items_table.item_code,items_table.item_name,items_table.item_type,history_table.date,min(history_table.date) as opening_date,max(history_table.date) as closing_date,history_table.qty_in,history_table.qty_out,items_table.stock,SUM(history_table.qty_in) as qty_in,SUM(history_table.qty_out) as qty_out,'.$stocks.','.$closing_stocks);
 			$this->db->from('items items_table' );
		    $this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
			
		$this->db->_protect_identifiers=false;
        
		if($item!==FALSE)
		{
			
			  $this->db->where('items_table.id IN ('.$chk_item_id.')');
           
		}
        
        
		
        if($start_date != "" && $end_date !="") // search based on purchase date
		{
			$this->db->where(array('date(history_table.date) >='=>$start_date,'date(history_table.date) <='=>$end_date));
		}
		// No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	
        $this->db->group_by('history_table.item_id');
			$this->db->where('items_table.stock !=' , 0);
			$this->db->order_by('closing_stock','desc');
			$qry = $this->db->get();
			if($qry->num_rows()>0)
		return $qry->result_array();



	}




	}