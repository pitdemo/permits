<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : expenses_report.php
 * Project        : Accounting Software
 * Creation Date  : 09-07-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the Expenses details
*********************************************************************************************/	
class Expenses_report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model','notes_model','expense_report_model'));		
		$this->security_model->chk_admin_login();
	}
	public function index() // Expenses lists
    {
        $where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['menu'] = 'expenses_report';
		//print_r($this->data);//exit;
		$this->load->view('expenses_report/lists',$this->data);
    }
    public function get_search_query($url)
	{
		      $get = array(
					 //'chk_status'=>"",
                    'chk_start_date'=>"",
                    'chk_end_date'=>""
              );
            
            //$status = array_search('status',$this->uri->segment_array());
            $date_from = array_search('start',$this->uri->segment_array());
            $date_end = array_search('end',$this->uri->segment_array());
            
            /*if($status!==FALSE)
            {
                $get['chk_status'] = $this->uri->segment($status+1);	
            }*/
            if($date_from!==FALSE)
            {
                $get['chk_start_date'] = $this->uri->segment($date_from+1);	
            }

             if($date_end!==FALSE)
            {
                $get['chk_end_date'] = $this->uri->segment($date_end+1);	
            }
            //print_r($get);
            return array($get);
     }
     /* Get expenses category report list */
     public function ajax_get_expenses_report_list()
     {
        $sdate="";
        $edate="";
     	$segment_array = $this->uri->segment_array();
        $start = array_search("start",$segment_array);
        $end = array_search("end",$segment_array);
        if($start != FALSE && $end != FALSE)
        {
            $sdate = $this->uri->segment($start+1);
            $edate = $this->uri->segment($end+1);
        }
     	$lists = $this->expense_report_model->get_expenses_report_list($segment_array);
     	$expenses_report_lists = array();
     	foreach($lists as $list)
     	{
     		$expenses_report_lists[$list['id']]['id'] = $list['id'];
     		$expenses_report_lists[$list['id']]['expense_category'] = $list['expense_category'];
     		$expenses_report_lists[$list['id']]['total'] = $list['total'];
     		$expenses_report_lists[$list['id']]['created'] = $list['created'];
            $expenses_report_lists[$list['id']]['status'] = $list['status'];
     	}
         $option = array_search('option_type',$segment_array); // print pdf option
         if($option !== FALSE)
         {
            $option_type = $this->uri->segment($option+1);
            if($option_type == 'csv')
            {
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=expenses_category_report.csv");
                    // Disable caching
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                    header("Pragma: no-cache"); // HTTP 1.0
                    header("Expires: 0"); // Proxies
                    $heading = array('Category Id','Category Name','Amount','Created','Status');
                    $this->outputCSV($expenses_report_lists,$heading);
                    exit;
            }
         }
     	/*print_r($expenses_report_lists);*/
     	$json = " ";
     	foreach($expenses_report_lists as $row)
     	{
     		
		    $total_amount_array[] = $row['total'];
            if($sdate !="" && $edate !="")
            {
     		$json .= '[
                    
     		        "'."<a href=".base_url()."expenses/index/category/".base64_encode($row['id'])."/start/".$sdate."/end/".$edate." target='_blank'>".ucfirst($row['expense_category'])."</a>".'",
     		        "'.number_format($row['total'],2).'",
     		        "'.date('d-m-Y',strtotime($row['created'])).'"                    
     		   ],';
            }
            else
            {
               $json .= '[
                    
                    "'."<a href=".base_url()."expenses/index/category/".base64_encode($row['id'])." target='_blank'>".ucfirst($row['expense_category'])."</a>".'",
                    "'.number_format($row['total'],2).'",
                    "'.date('d-m-Y',strtotime($row['created'])).'"                    
               ],'; 
            }
     	}
     	if(!empty($total_amount_array))
     	    $total = array_sum($total_amount_array);
        else
        	$total = 0;
	    $sum = number_format($total,2);
     	echo '{
     		     "total_amount":'.$total.',
                 "recordTotal" : '.count($expenses_report_lists).',
                 "data":[
                        '.rtrim($json,",").']

     	}';
     	exit;
     }
     public function outputCSV($data,$header)
     {
          $output = fopen("php://output", "w");
          fputcsv($output, $header);
          foreach ($data as $row) {
          fputcsv($output, $row); // here you can change delimiter/enclosure
          }
          fclose($output);


     }
}
?>