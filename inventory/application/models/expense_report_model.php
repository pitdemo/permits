<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : expense_report_model.pph
 * Project        : Accounting Software
 * Creation Date  : 30-05-2018
 * Author         : B.D.Soundarya
 * Description    : Manage expense report details
*********************************************************************************************/	
class Expense_report_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
	/*Get expenses category report list*/
	public function get_expenses_report_list($segment_array=NULL)
	{
        //print_r($segment_array);exit;
        //$status = array_search("status",$segment_array);
        $date_from = array_search("start",$segment_array);
        $date_end = array_search("end",$segment_array);
        //$chk_status= "";
        $start_date="";
        $end_date="";
       /* if($status !== FALSE)
        {
        	$chk_status = $this->uri->segment($status+1);
        }*/
        if($date_from !== FALSE)
        {
        	$start_date = $this->uri->segment($date_from+1);
        }
        if($date_end !== FALSE)
        {
        	$end_date = $this->uri->segment($date_end+1);
        }
        $select = array("ec.*,SUM(ROUND(REPLACE(e.amount, ',', ''),2)) AS total");
        $this->db->select($select);
        $this->db->from('expenses_category ec');
        $this->db->join('expenses e','e.category_id=ec.id');
        /*if($chk_status != '')
        {
        	$this->db->where('ec.status',$chk_status);
        }
        else
        {*/
        	$this->db->where('ec.status !=',STATUS_DELETED);
        	$this->db->where('e.status !=',STATUS_DELETED);
        //}
        if($start_date != '' && $end_date != '')
        {
        	//$this->db->where(array('date(ec.created) >=' =>$start_date,'date(ec.created) <= '=>$end_date));
            $this->db->where(array('date(e.expense_date) >=' =>$start_date,'date(e.expense_date) <= '=>$end_date));
        }
        $this->db->group_by('e.category_id');
        $qry = $this->db->get();
        //echo $this->db->last_query();
        return $qry->result_array();
	}
}
?>