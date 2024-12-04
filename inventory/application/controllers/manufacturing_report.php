<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : inventory
 * Project        : Accounting Software
 * Creation Date  : 28-10-2015
 * Author         : G.Uma Maheswari
 * Description    : Items and Inventory
*********************************************************************************************/	
class Manufacturing_report extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('security_model','items_model','supplier_model','customer_model','notes_model'));		
		$this->security_model->chk_admin_login();
	}
		public function index() // show the manufacturing lists
	{
	 
		$url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		$where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
		  $this->data['items'] = $this->items_model->get_active_itemhistory_lists(); // get items lists from items table
        $this->data['menu'] = 'manufacture_report';
        $this->load->view('manufacturing_report/index',$this->data);
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
		 public function ajax_get_manufacture_material_items() // get manufacture material items based on manufacture  id
    {
		 $manufacture_id = $this->input->post('manufacture_id');
        $results = $this->manufacturing_model->get_manufacture_material_items($manufacture_id);
		
		
        $manf_item_details = $this->manufacturing_model->get_manufacture_item_details($manufacture_id);
		//echo $this->db->last_query();
		//exit;
        echo '<table id="table_report2" class="table table-striped table-bordered table-hover" style="margin:0 auto"><tr><td align="left"><b>Item Name</b></td><td>&nbsp;'.ucfirst($manf_item_details['item_name']).'</td></tr><tr><td align="left"> <b>Quantity </b> </td><td>&nbsp;'.$manf_item_details['qty'].'</td></tr><tr><td align="left"><b>Manufacture Date</b></td><td>&nbsp;'.date('d-m-Y',strtotime($manf_item_details['manufacture_date'])).'</td></tr><tr><td align="left"><b>Created</b> </td><td>&nbsp;'.date('d-m-Y',strtotime($manf_item_details['created'])).'</td></tr></table>';
        echo "<table id='table_report3' class='table table-striped table-bordered table-hover' style='margin:0 auto'><caption><h3>Material Items</h3></caption><tr><th width='50%' align='left'>Item Name</th><th width='40%'>Quantity</th></tr>";
        foreach($results as $result)
        {
            echo "<tr><td align='left'>".ucfirst($result['item_name'])."</td><td>".$result['qty']."</td></tr>";
        }
        echo "</table>";
        exit;
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
		
		
	
public function datafetch()
		{
			
		$segment_array = $this->uri->segment_array();
		$requestData= $_REQUEST;
			$columns = array( 
								0 =>'id', 
								1 => 'item_code',
								2 => 'item_name',
								3 => 'qty_in',
								4 => 'qty_out',
								5 => 'manf_date',
								6 => 'action',
							
							);
			$where_condition='status != "items_table.deleted" AND ';
			/////////////DEFAULT SEARCH//////////////////////////////
			if( !empty($requestData['search']['value']))
			{  	
				$search_value = trim($requestData['search']['value']);
				$where_condition.= "(items_table.id LIKE '%".$search_value."%' OR items_table.item_code LIKE '%".$search_value."%' OR items_table.item_name LIKE '%".$search_value."%' OR items_table.item_type LIKE '%".$search_value."%'  OR items_table.stock LIKE '%".$search_value."%' OR history_table.manf_date LIKE '%".$search_value."%') AND ";
			}
			/////////////DEFAULT SEARCH//////////////////////////////
			/////////////SEARCH DATE//////////////////////////////
		$start = array_search("start",$segment_array);
		$end = array_search("end",$segment_array);
		if ($start !== FALSE )
		{
			$start_date = $this->uri->segment($start+1);
			$end_date = $this->uri->segment($end+1);
			$start_date = str_replace("-","/",$start_date);
			$end_date = str_replace("-","/",$end_date);
			$where_condition.= "(date(history_table.manf_date) BETWEEN '".date("Y-m-d",strtotime($start_date))."' AND '".date("Y-m-d",strtotime($end_date))."') AND ";
			//$where_condition.= "(date(history_table.date) = '".date("Y-m-d",strtotime($start_date))."' ) AND ";
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
 $this->db->select('items_table.id,items_table.item_code,items_table.item_name,history_table.manf_date,SUM(history_table.qty_in) as qty_in,SUM(history_table.qty_out) as qty_out');
 			$this->db->from('items items_table' );
		    $this->db->join('manufacture_history history_table', 'history_table.item_id=items_table.id');
			$this->db->group_by('history_table.item_id');
			if($where_condition!='')
			{
				$where_condition = rtrim($where_condition,'AND ');
				$this->db->where($where_condition);
			} 
			$query = $this->db->get(); 
		#	echo $this->db->last_query(); exit;
			$totalData = $query->num_rows();
			$totalFiltered = $totalData;
			/////////////////TOTAL RECORD COUNT////////////////
			
			///////////FILTER & FETCH LIMITED RECORD///////////	
			//
		 $this->db->select('items_table.id,items_table.item_code,items_table.item_name,history_table.manf_date,SUM(history_table.qty_in) as qty_in,SUM(history_table.qty_out) as qty_out');
 			$this->db->from('items items_table' );
		    $this->db->join('manufacture_history history_table', 'history_table.item_id=items_table.id');
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
			$row = $query->result_array();
			/*echo"<pre>";
			print_r($row);
			exit;*/
		$select = array("SUM(ROUND(REPLACE(history_table.qty_in, ',', ''),2)) AS qtyintotal,SUM(ROUND(REPLACE(history_table.qty_out, ',', ''),2)) AS qtyouttotal");
		$this->db->select($select);		
		$this->db->from('manufacture_history history_table');
		$this->db->join('items items_table', 'items_table.id=history_table.item_id', 'left');

		if($where_condition!='')
		{
			$where_condition = rtrim($where_condition,'AND ');
			$this->db->where($where_condition);
		}
		$query = $this->db->get();
		$sum_value = $query->row_array();
		//print_r($sum_value);
		//$sum = number_format($sum_value['total'],2);
		$qty_sum_in = number_format($sum_value['qtyintotal'],0);
		$qty_sum_out = number_format($sum_value['qtyouttotal'],0);
		///////////SUM COLUMN BASED ON CONDITION///////////	
		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   
					"recordsTotal"    => intval( $totalData ), 
					"recordsFiltered" => intval( $totalFiltered ), 
					"data"            => $row,
					"total_qty_in"		  =>$qty_sum_in,
					"total_qty_out"		  =>$qty_sum_out,
					);
		echo json_encode($json_data);  
	}
}
?>
