<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : inventory
 * Project        : Accounting Software
 * Creation Date  : 28-10-2015
 * Author         : G.Uma Maheswari
 * Description    : Items and Inventory
*********************************************************************************************/	
class Inventory extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('security_model','items_model','supplier_model','customer_model','notes_model'));		
		$this->security_model->chk_admin_login();
	}
	public function index()
    {
       
	    redirect('inventory/lists');
    }
	public function lists() // list the item lists
	{
		$url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		$where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
        $this->data['items'] = $this->items_model->get_active_itemhistory_lists(); // get items lists from items table
		$this->data['menu'] = 'inventory_report';
		$this->load->view('inventory/lists',$this->data);
	}
	
	
	public function lists_new() // list the item lists
	{
		$url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		$where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
        $this->data['items'] = $this->items_model->get_active_itemhistory_lists(); // get items lists from items table
		$this->data['menu'] = 'inventory_report';
		$this->load->view('inventory/lists',$this->data);
	}
	
		public function date_wise($id) // list the item lists
	{
		echo base64_decode($id); exit;
	}
	
   public function get_search_query($url)
	    {
				$get = array(
					  
					 'chk_item_id'=>"",
                    'chk_start_date'=>"",
                    'chk_end_date'=>""
              );
            $today = date('Y-m-d'); //2016-04-07
			$last_thirty= date('Y-m-d', strtotime('-30 days', strtotime($today)));  //2016-03-08
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
				else
			{
				$get['chk_start_date'] = $last_thirty ;
			}

             if($date_end!==FALSE)
            {
                $get['chk_end_date'] = $this->uri->segment($date_end+1);	
            }
				else
			{
				$get['chk_end_date'] =  $today;
			}
            
                return array($get);
        }  
		 public function get_search_query_datewise($url)
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
		
		public function date($id) // get the particular customer transaction details(sales and purchase)
	{
		$url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		$where = $this->get_search_query_datewise($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$segment_array = $this->uri->segment_array();
		$value = $this->items_model->get_inventory_date_details($id,$segment_array);
		//print_r($value);
		  $json = "";
             
                      echo rtrim($value);
                  
                    exit;
	}  
	
	public function stock($id) // get the particular customer transaction details(sales and purchase)
	{
		$url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		$where = $this->get_search_query_datewise($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$segment_array = $this->uri->segment_array();
		$value = $this->items_model->get_inventory_details($id,$segment_array);
		//print_r($value);
		  $json = "";
                                   echo rtrim($value);
                  
                    exit;
	}  
public function datafetch()
		{
			
		$segment_array = $this->uri->segment_array();
		$requestData= $_REQUEST;
			$columns = array( 
								0 =>'id', 
								1 => 'item_code',
								2 => 'item_name',
								3 => 'opening_date',
								4 => 'opening_stock',
								5 => 'qty_in',
								6 => 'qty_out',
								7 => 'closing_date',
								8 => 'closing_stock'
							
							);
			$where_condition='status != "items_table.deleted" AND ';
			/////////////DEFAULT SEARCH//////////////////////////////
			if( !empty($requestData['search']['value']))
			{  	
				$search_value = trim($requestData['search']['value']);
				$where_condition.= "(items_table.id LIKE '%".$search_value."%' OR items_table.item_code LIKE '%".$search_value."%' OR items_table.item_name LIKE '%".$search_value."%' OR items_table.item_type LIKE '%".$search_value."%' OR items_table.stock LIKE '%".$search_value."%' OR items_table.stock LIKE '%".$search_value."%' OR history_table.date LIKE '%".$search_value."%') AND ";
			}
			/////////////DEFAULT SEARCH//////////////////////////////
			/////////////SEARCH DATE//////////////////////////////
		$start = array_search("start",$segment_array);
		$end = array_search("end",$segment_array);
		$stocks=',(select ih.qty_in from item_history ih where ih.item_id=items_table.id  order by ih.id asc limit 1) as opening_stock';
		//$stocks=',items_table.stock as opening_stock';
		
		if ($start !== FALSE )
		{
			$start_date = $this->uri->segment($start+1);
			$end_date = $this->uri->segment($end+1);
			$start_date = str_replace("-","/",$start_date);
			$end_date = str_replace("-","/",$end_date);
			$where_condition.= "(date(history_table.date) BETWEEN '".date("Y-m-d",strtotime($start_date))."' AND '".date("Y-m-d",strtotime($end_date))."') AND ";
			//$where_condition.= "(date(history_table.date) = '".date("Y-m-d",strtotime($start_date))."' ) AND ";
			$stocks=",(select (SUM(ih.qty_in) - SUM(ih.qty_out)) from item_history ih where ih.item_id=items_table.id AND date(ih.date)<'".date("Y-m-d",strtotime($start_date))."') as opening_stock";

		  	//$closing_stocks = ",( (select (SUM(ih.qty_in) - SUM(ih.qty_out)) from item_history ih where ih.item_id=items_table.id AND date(ih.date)<'".date("Y-m-d",strtotime($start_date))."') + SUM(history_table.qty_in) )- SUM(history_table.qty_out) as closing_stock";

            $closing_stocks = ",(((CASE WHEN SUM(history_table.qty_in) IS NULL THEN 0 ELSE SUM(history_table.qty_in) END) + (select IF((SUM(ih1.qty_in) - SUM(ih1.qty_out)) IS NULL,0,(SUM(ih1.qty_in) - SUM(ih1.qty_out))) from item_history ih1 where ih1.item_id=items_table.id AND date(ih1.date)<'".date("Y-m-d",strtotime($start_date))."'))-(CASE WHEN SUM(history_table.qty_out) IS NULL THEN 0 ELSE SUM(history_table.qty_out) END)) as closing_stock";
           
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

		    // $closing_stocks = ",( (select (SUM(ih.qty_in) - SUM(ih.qty_out)) from item_history ih where ih.item_id=items_table.id AND date(ih.date)<'".date("Y-m-d",strtotime($start_date))."') + SUM(history_table.qty_in) )- SUM(history_table.qty_out) as closing_stock";
		
            $closing_stocks = ",(((CASE WHEN SUM(history_table.qty_in) IS NULL THEN 0 ELSE SUM(history_table.qty_in) END) + (select IF((SUM(ih1.qty_in) - SUM(ih1.qty_out)) IS NULL,0,(SUM(ih1.qty_in) - SUM(ih1.qty_out))) from item_history ih1 where ih1.item_id=items_table.id AND date(ih1.date)<'".date("Y-m-d",strtotime($start_date))."'))-(CASE WHEN SUM(history_table.qty_out) IS NULL THEN 0 ELSE SUM(history_table.qty_out) END)) as closing_stock";


		}
		
		/////////////SEARCH DATE//////////////////////////////
		/////////////SEARCH ITEMWISE//////////////////////////////
		$user_keyword = array_search('item_id',$segment_array);
		if ($user_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($user_keyword+1);
			if($keyword!='')
			$where_condition.="(items_table.id IN (".$keyword."))  AND" ;
		} 
		/////////////SEARCH ITEMWISE//////////////////////////////
			/////////////////TOTAL RECORD COUNT////////////////
 			$this->db->select('items_table.id');
 			$this->db->from('items items_table' );
		    $this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
			$this->db->where('items_table.stock !=' , 0);
			//$this->db->order_by('max(history_table.date)', 'desc');
			$this->db->group_by('history_table.item_id');
			if($where_condition!='')
			{
				$where_condition = rtrim($where_condition,'AND ');
				$this->db->where($where_condition);
			} 

			$this->db->_protect_identifiers=false;
			
			$query = $this->db->get(); 
			//echo $this->db->last_query(); exit;
			$totalData = $query->num_rows();
			$totalFiltered = $totalData;
			/////////////////TOTAL RECORD COUNT////////////////
			
			///////////FILTER & FETCH LIMITED RECORD///////////	
			//
			// $this->db->select('items_table.id,items_table.item_code,items_table.item_name,min(history_table.date) as opening_date,SUM(history_table.qty_in) as qty_in,SUM(history_table.qty_out) as qty_out,max(history_table.date) as closing_date,SUM(history_table.qty_in) -  SUM(history_table.qty_out) as closing_stock,'.$stocks);
			
            $this->db->select('items_table.id,items_table.item_code,items_table.item_name,min(history_table.date) as opening_date,SUM(history_table.qty_in) as qty_in,SUM(history_table.qty_out) as qty_out,max(history_table.date) as closing_date,'.$stocks.','.$closing_stocks);
            $this->db->from('items items_table' );
		    $this->db->join('item_history history_table', 'history_table.item_id=items_table.id');
			$this->db->where('items_table.stock !=' , 0);
			//$this->db->order_by('max(history_table.date)', 'desc');
			$this->db->group_by('history_table.item_id');
			
			if($where_condition!='')
			{
				$where_condition = rtrim($where_condition,'AND ');
				$this->db->where($where_condition);
			}
			$this->db->order_by($columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']);
		
			////////SETTING LIMIT/////////////////
			if($requestData['start'] < 0)
			{
				$this->db->limit($requestData['length']);
			}
			else
			{
				$this->db->limit($requestData['length'],$requestData['start']);
			}
			////////SETTING LIMIT/////////////////
			
		
			$query = $this->db->get();
			
			#echo $this->db->last_query(); 
			$row = $query->result_array();
			#echo"<pre>";print_r($row);	exit;
			$json_data = array(
						"draw"            => intval( $requestData['draw'] ),   
						"recordsTotal"    => intval( $totalData ), 
						"recordsFiltered" => intval( $totalFiltered ), 
						"data"            => $row,
						);
			echo json_encode($json_data);  
		
		}


// Export csv document

		public function ajax_get_inventory_list() // load bulk records to jquery data table using ajax
		 { 
             $segment_array = $this->uri->segment_array();
             $lists = $this->items_model->get_inventory_lists($segment_array);
             // print_r($lists);exit;
             $inventory_list = array();
                foreach($lists as $list)
                {
                    $item_details = $this->items_model->get_item_details($list['id']);
                    if($list['opening_stock']=='')
                    {
                    	$list['opening_stock'] = '0';
                    }
                    
                    $inventory_list[$list['id']]['id'] = $list['item_code'];
                    $inventory_list[$list['id']]['item_name'] = $list['item_name'];
                    $inventory_list[$list['id']]['opening_date'] = $list['opening_date'];
                    $inventory_list[$list['id']]['opening_stock'] = $list['opening_stock'];
                    $inventory_list[$list['id']]['qty_in'] = $list['qty_in'];
                    $inventory_list[$list['id']]['qty_out'] = $list['qty_out'];
                    $inventory_list[$list['id']]['closing_date'] = $list['closing_date'];
                    $inventory_list[$list['id']]['closing_stock'] = $list['closing_stock'];
    		
					
                }
             
            $option = array_search('option_type',$segment_array); // print pdf option
           if($option!==FALSE)
		   {
                $option_type = $this->uri->segment($option+1);
    
                if($option_type=='csv')
                {
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=inventory_list.csv");
                    // Disable caching
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                    header("Pragma: no-cache"); // HTTP 1.0
                    header("Expires: 0"); // Proxies
                    $heading = array('Item Code','Item Name','Opening Date','Opening Stock','Quantity In','Quantity Out','Closing Date','Closing Stock');
                    $this->outputCSV($inventory_list,$heading);
                    exit;
                }
            }
                    
					
                $json = "";
                        foreach($inventory_list as $row)
                        {
                               
                                    $json .= '[
                                        "'.$row['item_code'].'",
                                        "'.ucfirst($row['item_name']).'",
                                        "'.$row['opening_date'].'",
                                        "'.$row['opening_stock'].'",
                                        "'.$row['qty_in'].'",
                                        "'.$row['qty_out'].'",
                                        "'.$row['closing_date'].'",
                                        "'.$row['closing_stock'].'"
										
                                    ],';
                        }
					
                echo '{ 
                        "recordsTotal": '.count($inventory_list).',
                        "data":[ 
                                '.rtrim($json,",").']}';
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
