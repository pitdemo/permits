<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : sales_report_model.pph
 * Project        : Accounting Software
 * Creation Date  : 16-07-2015
 * Author         : K.Panneer selvam
 * Description    : Manage sales report details
*********************************************************************************************/	
class Sales_report_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
    public function get_sales_lists($segment_array=NULL) // get all sales list from 'sales' table except status deleted
	{
      $item = array_search('item_id',$segment_array);
        $date_from = array_search('start',$segment_array);
        $date_end = array_search('end',$segment_array);
        $chk_item_id="";
        $start_date="";
        $end_date="";
        
        $fields = '*';
        $where_condition=" status = '".STATUS_ACTIVE."' AND ";
		
        if($item!==FALSE)
		{
			$chk_item_id = $this->uri->segment($item+1);
            $where_condition.=" item_id IN (".$chk_item_id.") AND ";
            $fields = "id,user_id,item_id,sales_date,sum(qty) as qty,sum(REPLACE(amount,',','')) as amount,user_type,status,created";
		}
        
        if($date_from!==FALSE)
		{
			$start_date = $this->uri->segment($date_from+1);	
		}
        
         if($date_end!==FALSE)
		{
			$end_date = $this->uri->segment($date_end+1);	
		}
        
        if($start_date != "" && $end_date !="") // search based on purchase date
		{
            $where_condition.=" sales_date between '".$start_date."' AND '".$end_date."' group by item_id,sales_date";
        }
        
        $where_condition = rtrim($where_condition,' AND ');
        
        $qry = $this->db->query("SELECT ".$fields." from sales where ".$where_condition." order by id desc");
        
        return $qry->result_array(); // No need to check num_rows() > 0 because this function used for jquery datatable ajax remote data
	}
}
?>
