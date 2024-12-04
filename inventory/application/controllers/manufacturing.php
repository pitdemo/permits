<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : manufacturing.php
 * Project        : Accounting Software
 * Creation Date  : 26-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the manufacturing details
*********************************************************************************************/	
class Manufacturing extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model','items_model','notes_model','manufacturing_model'));		 // load model files
		$this->security_model->chk_admin_login(); //check user is login or not
	}
	/*public function index() // show the manufacturing lists
	{
		$url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
        $this->data['menu'] = 'manufacture';
        $this->load->view('manufacturing/index',$this->data);
	}*/
	
	public function index()
    {
       
	    redirect('manufacturing/lists');
    }
	public function lists() // manufacture lists
    {
         $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		$where = $this->get_search_query($this->uri->segment_array());
		$this->data['get'] = $where[0];
		$this->data['menu'] = 'manufacture';
		$this->data['items'] = $this->items_model->get_active_item_lists(); // get items lists from items table
        $this->load->view('manufacturing/index',$this->data);
    }
	
	 public function get_search_query($url)
	    {
		      $get = array(
					  
					  'chk_item_id'=>"",
					 'chk_status'=>"",
					
                    'chk_start_date'=>"",
                    'chk_end_date'=>""
              );
            $item = array_search('item_id',$this->uri->segment_array());
            $status = array_search('status',$this->uri->segment_array());
            $user_type = array_search('user_type',$this->uri->segment_array());
			$person = array_search('person',$this->uri->segment_array());
            $date_from = array_search('start',$this->uri->segment_array());
            $date_end = array_search('end',$this->uri->segment_array());
            if($item!==FALSE)
			{
				$get['chk_item_id'] = $this->uri->segment($item+1);	
			}

            if($status!==FALSE)
            {
                $get['chk_status'] = $this->uri->segment($status+1);	
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
    public function manufacturing_entry()
    {
         $this->data['menu'] = 'manufacture';
        $this->form_validation->set_rules('c_id','manufacture','trim');
		if($this->session->userdata('session_user_type')!='viewer')
		 {
		if($this->form_validation->run()==TRUE)
		{
				$manufacture_item = $this->input->post('manufacture_item');
				$manufacture_qty = $this->input->post('manufacture_qty');
				$manufacture_date = $this->input->post('manufacture_date');
				$material_items = $this->input->post('material_item'); // array value
				$material_qtys = $this->input->post('material_qty'); // array value
            
                //insert manufacturing details into manufactures_items & manufacture_material_items tables
            
                $manufacture_insert_details = array(
                        'item_id'=>$manufacture_item,
                        'qty'=>$manufacture_qty,
                        'manufacture_date'=>$manufacture_date,
                        'created'=>date('Y-m-d H:i:s')
                );
                
                $this->db->insert('manufactures_items',$manufacture_insert_details);
                $last_id = $this->db->insert_id();
			
				for($i=0;$i<count($material_items);$i++)
				{
                    $material_insert_details = array(
                        'item_id'=>$material_items[$i],
                        'qty'=>$material_qtys[$i],
                        'manufacture_item_id'=>$last_id,
                        'created'=>$manufacture_date
                    );
                     $this->db->insert('manufacture_material_items',$material_insert_details);
                    
				}
                
                 $notes = "The following ".$last_id." id manufacturing items details have been added manually by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                 $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
            
                $this->session->set_flashdata('message','Manufacturing details has been inserted successfully.');
                redirect('manufacturing');
		}
		$this->load->view('manufacturing/manufacturing_entry',$this->data);
		 }
    }
    public function ajax_get_active_items() // get active items from 'items' table using select2 dropdown remote ajax
    {

        $search_key=($this->input->get('q')) ? $this->input->get('q') : '';
        $this->db->select('id,item_code,item_name');

        $this->db->from('items');

        if($search_key)
        {
                $where_condition="(item_code like '".$search_key."%' OR item_name LIKE '%".$search_key."%') AND status ='".STATUS_ACTIVE."'";
        }

        $this->db->where($where_condition);

        $query=$this->db->get();

        $arr=array();

        foreach($query->result_array() as $item)
        {
            $arr[]=array(
                'internal'=>$item['item_code']."-".$item['item_name'],
                'id'=>$item['id']
                );
        }

        echo json_encode($arr,true);

        exit;
    }
    public function ajax_get_manufacture_list()
    {
         $lists = $this->manufacturing_model->get_manufacture_lists();
         $manufacture_list = array();
        foreach($lists as $list)
        {
            $item_details = $this->items_model->get_item_details($list['item_id']);
            
            $manufacture_list[$list['id']]['id'] = $list['id'];
            $manufacture_list[$list['id']]['item_name'] = $item_details['item_name'];
            $manufacture_list[$list['id']]['manufactrue_date'] = $list['manufacture_date'];
            $manufacture_list[$list['id']]['qty'] = $list['qty'];
        }
        
         $json = "";
            foreach($manufacture_list as $row)
            {
               $json .= '[
                    "'.ucfirst($row['item_name']).'",
                     "'.$row['qty'].'",
                    "'.date('d-m-Y',strtotime($row['manufactrue_date'])).'",
                   "<div class=\"btn-group\"><a href=\"javascript:void(0)\" onclick=\"get_material_items('.$row['id'].',this)\" class=\"btn btn-mini btn-info\" type=\"button\" title=\"View\"><i class=\"icon-eye-open bigger-120\"></i></a></div>"
                ],';
            }

        echo '{ 
                "recordsTotal": '.count($manufacture_list).',
            "data":[ 
                    '.rtrim($json,",").']}';
        exit;
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
	
	public function change_status() // change the manufacture details status based on manufacture id using ajax
	{
			
			$status = 'inactive';
			$manufacture_id = $this->input->post('manufacture_id');	
            $item = $this->manufacturing_model->get_manufacture_details($manufacture_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('id',$manufacture_id);
			$this->db->update('manufactures_items',array( 'status' => $status));
			
			$this->db->where('manufacture_item_id',$manufacture_id);
			$this->db->update('manufacture_material_items',array( 'status' => $status));
            
            $notes =  "The following manufactures_items id #".$manufacture_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
        
			echo $status;
	}
	
	public function datafetch()
	{
		$segment_array = $this->uri->segment_array();
		$requestData= $_REQUEST;
		$columns = array( 
							0 =>'manufacture_table.id', 
							1 => 'item_name',
							2=> 'qty',
							3=> 'manufacture_date',
							4=> 'created',
							5=> 'status',
							6=> 'action',
						);
					
		$segment_array = $this->uri->segment_array();
		$delete ='active';
					$where_condition='';

		/////////////DEFAULT SEARCH//////////////////////////////
		if( !empty($requestData['search']['value']))
		{  	
			$search_value = trim($requestData['search']['value']);
			$where_condition.= "(manufacture_table.id LIKE '%".$search_value."%' OR items_table.item_name LIKE '%".$search_value."%' OR manufacture_table.created LIKE '%".$search_value."%' OR manufacture_table.manufacture_date LIKE '%".$search_value."%' OR manufacture_table.status LIKE '%".$search_value."%' OR manufacture_table.qty LIKE '%".$search_value."%') AND ";
		}
		/////////////DEFAULT SEARCH//////////////////////////////
		/////////////SEARCH STATUS//////////////////////////////
		$status_keyword = array_search('status',$segment_array);
		if ($status_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($status_keyword+1);
			if($keyword!='')
			$delete= $keyword;
		}
		/////////////SEARCH STATUS//////////////////////////////
		/////////////SEARCH DATE//////////////////////////////
		$start = array_search("start",$segment_array);
		$end = array_search("end",$segment_array);
		if ($start !== FALSE && $end !== FALSE)
		{
			$start_date = $this->uri->segment($start+1);
			$end_date = $this->uri->segment($end+1);
			$start_date = str_replace("-","/",$start_date);
			$end_date = str_replace("-","/",$end_date);
			$where_condition.= "(date(manufacture_table.manufacture_date) BETWEEN '".date("Y-m-d",strtotime($start_date))."' AND '".date("Y-m-d",strtotime($end_date))."') AND ";
		}
		/////////////SEARCH DATE//////////////////////////////
		/////////////SEARCH ITEM//////////////////////////////
		$user_keyword = array_search('item_id',$segment_array);
		if ($user_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($user_keyword+1);
			if($keyword!='')
			$where_condition.="(manufacture_table.item_id IN (".$keyword.")) AND" ;
		} 
		/////////////SEARCH ITEM//////////////////////////////
				$where_condition.="(manufacture_table.status='".$delete."') ";
		/////////////////TOTAL RECORD COUNT////////////////
		$this->db->select('manufacture_table.id,manufacture_table.item_id,manufacture_table.status,manufacture_table.created,manufacture_table.qty,manufacture_table.manufacture_date,items_table.id AS  iid,items_table.item_name');
		$this->db->from('manufactures_items manufacture_table');
		$this->db->join('items items_table', 'items_table.id=manufacture_table.item_id', 'left');
		if($where_condition!='')
		{
			$where_condition = rtrim($where_condition,'AND ');
			$this->db->where($where_condition);
		} 
		$query = $this->db->get(); 
		$totalData = $query->num_rows();
		$totalFiltered = $totalData;
		/////////////////TOTAL RECORD COUNT////////////////
		
		///////////FILTER & FETCH LIMITED RECORD///////////	
		$this->db->select('manufacture_table.id,manufacture_table.item_id,manufacture_table.status,manufacture_table.created,manufacture_table.qty,manufacture_table.manufacture_date,items_table.id AS iid,items_table.item_name');
		$this->db->from('manufactures_items manufacture_table');
		$this->db->join('items items_table', 'items_table.id=manufacture_table.item_id', 'left');
		
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
		///////////SUM COLUMN BASED ON CONDITION///////////	
		
		$select = array("SUM(ROUND(REPLACE(manufacture_table.qty, ',', ''),2)) AS qtytotal");
		$this->db->select($select);		
		$this->db->from('manufactures_items manufacture_table');
		$this->db->join('items items_table', 'items_table.id=manufacture_table.item_id', 'left');

		if($where_condition!='')
		{
			$where_condition = rtrim($where_condition,'AND ');
			$this->db->where($where_condition);
		}
		$query = $this->db->get();
		$sum_value = $query->row_array();
		//print_r($sum_value);
		//$sum = number_format($sum_value['total'],2);
		$qty_sum = number_format($sum_value['qtytotal'],0);

		///////////SUM COLUMN BASED ON CONDITION///////////	
		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   
					"recordsTotal"    => intval( $totalData ), 
					"recordsFiltered" => intval( $totalFiltered ), 
					"data"            => $row,
					"total_qty"		  =>$qty_sum,
					);
		echo json_encode($json_data);  
	}
}
?>
    