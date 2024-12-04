<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : sales_report.php
 * Project        : Accounting Software
 * Creation Date  : 16-07-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the sales report
*********************************************************************************************/	
class Sales_report extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->model(array('security_model','sales_model','supplier_model','items_model','customer_model','notes_model','sales_report_model')); //load the model files here
		$this->security_model->chk_admin_login(); // check admin logged in or not
	}
    public function index()
    {
        redirect('sales_report/lists');
    }
	public function lists() // lists the sales report details
	{
	    $where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['menu'] = 'sales_report';
		$this->data['suppliers'] = $this->supplier_model->get_active_supplier_lists(); // get supplier lists from suppliers table
        $this->data['customers'] = $this->customer_model->get_active_customer_lists(); // get customer lists from customers table
        $this->data['items'] = $this->items_model->get_active_item_lists(); // get items lists from items table
		$this->load->view('sales_report/lists',$this->data);
	}
	public function get_search_query($url)
	{
		  $get = array(
				 'chk_item_id'=>"",
				'chk_start_date'=>"",
				'chk_end_date'=>""
		  );
		
		$item = array_search('item_id',$this->uri->segment_array());
		$date_from = array_search('start',$this->uri->segment_array());
		$date_end = array_search('end',$this->uri->segment_array());
		

		if($item!==FALSE)
		{
			$get['chk_item_id'] = $this->uri->segment($item+1);	
		}

		if($date_from!==FALSE)
		{
			$get['chk_start_date'] = $this->uri->segment($date_from+1);	
		}

		 if($date_end!==FALSE)
		{
			$get['chk_end_date'] = $this->uri->segment($date_end+1);	
		}
			return array($get);
	}
	public function ajax_get_sales_list() // load bulk records to jquery data table using ajax
	{
		 $segment_array = $this->uri->segment_array();
		 $lists = $this->sales_report_model->get_sales_lists($segment_array);
         $seg_url = array_search('item_id',$segment_array);
        
		 $sales_list = array();
	     foreach($lists as $list)
         {
            $item_details = $this->items_model->get_item_details($list['item_id']);
	        if($list['user_type']=='supplier')
		    {
				$supplier_details   = $this->supplier_model->get_supplier_details($list['user_id']);
				$sales_list[$list['id']]['user_name'] = $supplier_details['supplier_name'];
		    }
            else
            {
  			  $customer_details   = $this->customer_model->get_customer_details($list['user_id']);
			  $sales_list[$list['id']]['user_name'] = $customer_details['customer_name'];
			}
			$sales_list[$list['id']]['id'] = $list['id'];
			$sales_list[$list['id']]['item_name'] = $item_details['item_name'];
			$sales_list[$list['id']]['sales_date'] = $list['sales_date'];
			$sales_list[$list['id']]['qty'] = $list['qty'];
			$sales_list[$list['id']]['amount'] = $list['amount'];
        }
             
           $option = array_search('option_type',$segment_array); // print pdf option
           if($option!==FALSE)
		   {
				$option_type = $this->uri->segment($option+1);
				if($option_type=='pdf')
				{
					$this->data['sales_list'] = $sales_list;
					$html = $this->load->view('sales_report/print_to_pdf',$this->data,true);
					$pdf_filename  ='sales_report.pdf';
					$this->load->library('dompdf_lib');
					$this->dompdf_lib->convert_html_to_pdf($html, $pdf_filename, true);
				}
				else if($option_type=='csv')
				{
                    $csv_details = array();
                    foreach($sales_list as $list)
                    {
                        $csv_details[$list['id']]['item_name'] = $list['item_name'];
                        $csv_details[$list['id']]['sales_date'] = $list['sales_date'];
                        $csv_details[$list['id']]['qty'] = $list['qty'];
                        $csv_details[$list['id']]['amount'] = $list['amount'];
                    }
                    
                 	header("Content-Type: text/csv");
					header("Content-Disposition: attachment; filename=sales_report.csv");
					// Disable caching
					header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
					header("Pragma: no-cache"); // HTTP 1.0
					header("Expires: 0"); // Proxies
					$heading = array('Item Name','Sales Date','Quantity','Amount');
                    $this->outputCSV($csv_details,$heading);
					exit;
				}
            }
                    
            $json = "";
			foreach($sales_list as $row)
			{
				$json .= '[
					"'.ucfirst($row['item_name']).'",
                    "'.date('d-m-Y',strtotime($row['sales_date'])).'",
					"'.$row['qty'].'",
					"'.$row['amount'].'"
				],';
			}
		  if($seg_url!==FALSE)
		{
			echo '{ 
					"recordsTotal": '.count($sales_list).',
					"data":[ 
						'.rtrim($json,",").']
					}';
          }
        else
        {
            echo '{ 
					"recordsTotal": 0,
					"data":[]
					}';
        }
			exit;
	}
    public function outputCSV($data,$header) // export data using CSV
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