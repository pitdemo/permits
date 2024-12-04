<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : items
 * Project        : Accounting Software
 * Creation Date  : 28-05-2015
 * Author         : K.Panneer selvam
 * Description    : Items and Inventory
*********************************************************************************************/	
class Items extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('security_model','items_model','supplier_model','customer_model','notes_model'));		
		$this->security_model->chk_admin_login();
	}
	public function index() // list the item lists
	{
		$url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		$this->data['menu'] = 'items';
		$this->load->view('items/index',$this->data);
	}
	public function create_item() // create new item details
	{
		$this->data['menu'] = 'items';
		$this->data['item_code'] = $this->items_model->get_last_item_id()+1;
		$this->form_validation->set_rules('last_item_code','Item code','trim');
		if($this->form_validation->run()==TRUE)
		{
				$item_names = $this->input->post('itemname');
				$item_types = $this->input->post('itemtype');
			    $ids = ''; // concatenate all the item id for stroed into notes table
				for($i=0;$i<count($item_names);$i++)
				{
					 $insert_details = array(
					 							'item_name'=>$item_names[$i],
					 							'item_type'=>$item_types[$i],
					 							'status'=>'active',
					 							'created'=>date('Y-m-d H:i:s')
										 );
							$this->db->insert('items',$insert_details);  // insert the item details
							$item_id = $this->db->insert_id();
							
							$update_item_code = array('item_code'=>($item_id+ITEM_CODE));
							
							$this->db->where('id',$item_id);
							$this->db->update('items',$update_item_code); // update the item code after item has been inserted(based on last insert id)
							$ids .="#".$item_id.",";
				}
            
                $notes = "The following ".rtrim($ids,",")." items have been added manually by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
            
                $this->session->set_flashdata('message','Item details has been inserted successfully.');
                redirect('items');
		}
		$this->load->view('items/create_item',$this->data);
	}
	public function edit_item($item_id) // edit the item details based on item id
	{
			$item_id = base64_decode($item_id);
			$this->data['item_details'] = $this->items_model->get_item_details($item_id);
			$this->form_validation->set_rules('item_name', 'Item name', 'trim|required');
			$this->form_validation->set_rules('item_type','Item type', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
				$item_details = array(
										'item_name' => strip_tags($this->input->post('item_name')),
										'item_type' => strip_tags($this->input->post('item_type')),	
										'modified'=>date('Y-m-d H:i:s'),									
									);			
				$this->db->where('id',$item_id);
				$this->db->update('items',$item_details); //update
				$this->session->set_flashdata('message','Item details has been updated successfully.');
                
                $notes = "The following item id #".$item_id." details has been modified by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                
				redirect('items');
		   }
			$this->data['menu']='items';
			$this->load->view('items/edit_item',$this->data);
	}
	public function change_status() // change the status active or inactive using ajax
	{
			$status = 'inactive';
			$item_id = $this->input->post('item_id');		
			$item = $this->items_model->get_item_details($item_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('id',$item_id);
			$this->db->update('items',array( 'status' => $status ));
            
            $notes =  "The following item id #".$item_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
        
			echo $status;
	}
	public function delete_item() // delete the item details using ajax
	{
			$item_id = $this->input->post('item_id');
			
			$this->db->where('id',$item_id);
			$this->db->update('items',array('status'=>'deleted'));
            
            $notes =  "The following item id #".$item_id." status(deleted) has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
			$this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
	}
	public function bulk_insert() // bulk import item details using csv file
	{
			$this->data['menu'] = 'items';
			$this->form_validation->set_rules('file_upload','File Upload','trim|callback_check_attachment');
			if($this->form_validation->run()==true) // code to  upload the .csv file
			{
				$config['upload_path'] ='./uploads/items/';
				$config['allowed_types'] = '*';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('file_upload'))
				{
					echo $this->upload->display_errors();
					return false;
				}
				else
				{
						$file_data =$this->upload->data('file_upload');
						$file_path =  './uploads/items/'.$file_data['file_name'];
						$this->load->library('csvimport'); // load the csvimport library(Path : application/libraries/csvimport.php)
						if ($this->csvimport->get_array($file_path))
						{
								$csv_array = $this->csvimport->get_array($file_path);
								if(count($csv_array[0])==2)
                                {
								    foreach ($csv_array as $row)
								    {
										$insert_details = array(
										'item_name'=>$row['ITEM NAME'],
										'item_type'=>$row['ITEM TYPE'],
										'status'=>'active',
										'created'=>date('Y-m-d H:i:s')
																	);
										$this->db->insert('items',$insert_details);
										$item_id = $this->db->insert_id();
										$update_item_code = array('item_code'=>($item_id+ITEM_CODE));
										$this->db->where('id',$item_id);
										$this->db->update('items',$update_item_code);
                                    }
                            
                             $notes =  "The csv file ".$file_data['file_name']." have been imported by ".$this->session->userdata('session_username')." in the items module on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                             $notes_arr = array(
                                'user_id'=>$this->session->userdata('user_id'),
                                'notes'=>$notes,
                                'created'=> date('Y-m-d H:i:s')
                             );
                            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                                    
  						    $this->session->set_flashdata('message','Item details has been inserted successfully.');
							redirect('items');
					           }
                            else{
								$this->session->set_flashdata('error_message','File column names should not match. Please check the CSV file');
							redirect('items');
						}
					}
					
				}
			}
		$this->load->view('items/bulk_insert',$this->data);
	}
		public function check_attachment() // callback to check attachment extension
		{
			$ext_array = array('.csv');
			if(!empty($_FILES['file_upload']['name']))
			{
				$ext = strtolower(strrchr($_FILES['file_upload']['name'],"."));
				if(in_array($ext,$ext_array))
				{
					return true;
				}
				else
				{
					$this->form_validation->set_message('check_attachment','Import only .csv file');
					return false;
				}
			}
			{
				$this->form_validation->set_message('check_attachment','Required');
				return false;
			}
		}
		public function ajax_get_items() // load bulk records to jquery data table using ajax
		{
			$this->data['items'] = $this->items_model->ajax_get_items_list();
		}
        public function item_history($item_id) //show the item purchase and sales history
        {
            $item_id = base64_decode($item_id);
            $this->data['item_id'] = $item_id;
            $this->data['menu']='items';
			 $lists = $this->items_model->get_item_history($item_id);
			 
            $total_val=$total_bal=$purchase=$sales=0;
                        foreach($lists as $row)
                        {
                            switch($row['record_type'])
                            {
                                case 'P':
                                    $record_type='Purchase';
                                    break;
                                case 'S':
                                    $record_type='Sales';
                                    break;
                                case 'M':
                                    $record_type='Manufacture';
                                    break;
									   case 'SR':
                                    $record_type='<b>Sales Return</b>';
                                    break;
                                case 'PR':
                                    $record_type='<b>Purchase Return</b>';
                                    break;
                             
                            }
			 
                                if($row['record_type']=='P')
                                    $purchase =$purchase + $this->number_unformat($row['amount']); //add amount for purchase
								else if($row['record_type']=='PR')
                                    $purchase =$purchase - $this->number_unformat($row['amount']); //decrease mount for purchase return
									
                              
									
							 if($row['record_type']=='SR')
                                    $sales= $sales - $this->number_unformat($row['amount']); //decrese amount for sales return
									 else if($row['record_type']=='S')
								
                                    $sales= $sales + $this->number_unformat($row['amount']); //add amount for sales
                               
                          
							$total_bal = $sales - $purchase;
							
						}
						
                            $this->data['sales']=$sales;
							$this->data['purchase']= $purchase;
							$this->data['profit']=   $total_bal;
            $this->load->view('items/item_history',$this->data);
        }
		
		public function number_unformat($number, $dec_point = '.', $thousands_sep = ',') {
          return (float)str_replace(array($thousands_sep, $dec_point),
                              array('', '.'),
                              $number);
           }
        public function ajax_get_item_purchase_history($item_id)  // get item purchase history based on item id         
        {
            $lists = $this->items_model->get_item_purchase_history($item_id);
            $purchases_list = array();
            foreach($lists as $list)
            {
                $item_details = $this->items_model->get_item_details($list['item_id']);

                if($list['user_type']=='supplier')
                {
                  $supplier_details   = $this->supplier_model->get_supplier_details($list['user_id']);
                  $purchases_list[$list['id']]['user_name'] = $supplier_details['supplier_name'];
                }
                else
                {
                 $customer_details   = $this->customer_model->get_customer_details($list['user_id']);
                  $purchases_list[$list['id']]['user_name'] = $customer_details['customer_name'];
                }
                $purchases_list[$list['id']]['id'] = $list['id'];
                $purchases_list[$list['id']]['item_name'] = $item_details['item_name'];
                $purchases_list[$list['id']]['purchase_date'] = $list['purchase_date'];
                $purchases_list[$list['id']]['qty'] = $list['qty'];
                $purchases_list[$list['id']]['amount'] = $list['amount'];
                $purchases_list[$list['id']]['user_type'] = $list['user_type'];
                $purchases_list[$list['id']]['status'] = $list['status'];
                $purchases_list[$list['id']]['created'] = $list['created'];
            }
            $json = "";
                        foreach($purchases_list as $row)
                        {
                            $json .= '[
                                "'.ucfirst($row['user_name']).'",
                                "'.$row['purchase_date'].'",
                                "'.$row['qty'].'",
                                "'.$row['amount'].'",
                                "'.ucfirst($row['user_type']).'",
                                "'.$row['created'].'"
                            ],';
                        }
					
                echo '{ 
                            "recordsTotal": '.count($purchases_list).',
                        "data":[ 
                                '.rtrim($json,",").']}';
                    exit;
        }
        public function ajax_get_item_sales_history($item_id)  // get item sales history based on item id         
        {
        
            $lists = $this->items_model->get_item_sales_history($item_id);
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
                $sales_list[$list['id']]['user_type'] = $list['user_type'];
                $sales_list[$list['id']]['revert_stock'] = ($list['revert_stock']=='1') ? 'Active' : 'Cancelled';
                $sales_list[$list['id']]['status'] = $list['status'];
                $sales_list[$list['id']]['created'] = $list['created'];
            }
            			$json = "";
                        foreach($sales_list as $row)
                        {
                            $json .= '[
                                "'.ucfirst($row['user_name']).'",
                                "'.date('d-m-Y',strtotime($row['sales_date'])).'",
                                "'.$row['qty'].'",
                                "'.$row['amount'].'",
                                "'.ucfirst($row['user_type']).'",
                                "'.date('d-m-Y',strtotime($row['created'])).'",
                                "'.$row['revert_stock'].'"
                            ],';
                        }
					
                echo '{ 
                            "recordsTotal": '.count($sales_list).',
                        "data":[ 
                                '.rtrim($json,",").']}';
                    exit;
        }
			 public function ajax_get_item_history_stock($item_id) //get all item history from item_history table
        {
             $segment_array = $this->uri->segment_array();
			 $lists = $this->items_model->get_item_history_stock(base64_decode($item_id),$segment_array);
			  $stock= $this->items_model->get_item_opening_stock(base64_decode($item_id),$segment_array);	
			$opening_stock = $stock->opening_stock; 
		//echo "<pre>";
//		print_r($lists);exit;
             $json = "";
          	 
	$total_val=$opening_stock ; 
		 		 	$total_bal='';
                        foreach($lists as $row)
                        {
                            switch($row['record_type'])
                            {
                                case 'P':
                                    $record_type='Purchase';
                                    break;
                                case 'S':
                                    $record_type='Sales';
                                    break;
                                case 'M':
                                    $record_type='Manufacture';
                                    break;
									case 'SR':
                                    $record_type='<b>Sales Return</b>';
                                    break;
                                case 'PR':
                                    $record_type='<b>Purchase Return</b>';
                                    break;
                                
                            }
							
                            
                            if($row['qty_in']>0)
                            {
                                if($row['record_type']=='P')
                                    $total_val=$total_val+$row['qty_in']; //add item qty for purchase
                                else if($row['record_type']=='PR')
                                    $total_val=$total_val-$row['qty_in']; //add item qty for purchase return
                                else
                                    $total_val=$total_val+$row['qty_in']; //add item qty for sales return
                            }
                            else
                            {
                                $total_val= $total_val-$row['qty_out'] ; // minus item qty for sales
                            }
                           
						
							//$total_val = $total_val - $opening_stock;
                            $qty_in=($row['qty_in']) ? $row['qty_in'] : '-';
                            $qty_out=($row['qty_out']) ? $row['qty_out'] : '-';
                            $json .= '[
							
							   "'.$row['id'].'",
                                "'.$row['date'].'",
                                "'.$qty_in.'",
                                "'.$qty_out.'",
                                "'.$record_type.'",
                                "'.$total_val.'"
                            ],';
							
                        }
						
                echo '{ 
                            "recordsTotal": '.count($lists).',
                        "data":[ 
                                '.rtrim($json,",").']}';
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
		
		
		public function item_history_stock($item_id) //show the item purchase and sales history
        {
		$url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		$where = $this->get_search_query_datewise($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$segment_array = $this->uri->segment_array();
            $item_id = base64_decode($item_id);
            $this->data['item_id'] = $item_id;
            $this->data['menu']='items';
			 $lists = $this->items_model->get_item_history_stock( $item_id,$segment_array);
		     $stock = $this->items_model->get_item_opening_stock($item_id,$segment_array);	
		     $closing_stock =  $stock->closing_stock; 
			$opening_stock =  $stock->opening_stock;
            $total_val=$total_bal=$purchase=$sales=0;
                        foreach($lists as $row)
                        {
                            switch($row['record_type'])
                            {
                                case 'P':
                                    $record_type='Purchase';
                                    break;
                                case 'S':
                                    $record_type='Sales';
                                    break;
                                case 'M':
                                    $record_type='Manufacture';
                                    break;
									 case 'SR':
                                    $record_type='<b>Sales Return</b>';
                                    break;
                                case 'PR':
                                    $record_type='<b>Purchase Return</b>';
                                    break;
                               
                            }
			 
                                if($row['record_type']=='P')
                                    $purchase =$purchase + $this->number_unformat($row['amount']); //add amount for purchase
								else if($row['record_type']=='PR')
                                    $purchase =$purchase - $this->number_unformat($row['amount']); //decrease mount for purchase return
								
							 if($row['record_type']=='SR')
                                    $sales= $sales - $this->number_unformat($row['amount']); //decrese amount for sales return
                               
									
                             else   if($row['record_type']=='S')
								
                                    $sales= $sales + $this->number_unformat($row['amount']); //add amount for sales
									
								
                          
							$total_bal = $sales - $purchase;
							
						}
						    $this->data['closing_stock']=$closing_stock;
						    $this->data['opening_stock']=$opening_stock;
                            $this->data['sales']=$sales;
							$this->data['purchase']= $purchase;
							$this->data['profit']=   $total_bal;
            $this->load->view('items/item_history_stock',$this->data);
        }
		
		
        public function ajax_get_items_history($item_id) //get all item history from item_history table
        {
             $lists = $this->items_model->get_item_history($item_id);
             $json = "";
             $total_val=$total_bal=0;
             
                        foreach($lists as $row)
                        {
                            switch($row['record_type'])
                            {
                                case 'P':
                                    $record_type='Purchase';
                                    break;
                                case 'S':
                                    $record_type='Sales';
                                    break;
                                case 'M':
                                    $record_type='Manufacture';
                                    break;
								  case 'SR':
                                    $record_type='<b>Sales Return</b>';
                                    break;
                                case 'PR':
                                    $record_type='<b>Purchase Return</b>';
                                    break;
                              
                            }
                            
                            if($row['qty_in']>0)
                            {
                                if($row['record_type']=='P')
                                    $total_val=$total_val+$row['qty_in']; //add item qty for purchase
                                else if($row['record_type']=='PR')
                                    $total_val=$total_val-$row['qty_in']; //add item qty for purchase return
                                else
                                    $total_val=$total_val+$row['qty_in']; //add item qty for sales return
                            }
                            else
                            {
                                $total_val=$total_val-$row['qty_out']; // minus item qty for sales
                            }
                           
							
							
                            $qty_in=($row['qty_in']) ? $row['qty_in'] : '-';
                            $qty_out=($row['qty_out']) ? $row['qty_out'] : '-';
                            
                            $json .= '[
                                "'.$row['date'].'",
                                "'.$qty_in.'",
                                "'.$qty_out.'",
                                "'.$record_type.'",
                                "'.$total_val.'"
                            ],';
							
							
                        }
					
                echo '{ 
                            "recordsTotal": '.count($lists).',
                        "data":[ 
                                '.rtrim($json,",").']}';
                    exit;
        }
        public function ajax_get_manufacture_list($item_id)
        {
            $lists = $this->items_model->get_item_manufacture_history($item_id);
            $json = "";
                        foreach($lists as $row)
                        {
                            $json .= '[
                                "'.ucfirst($row['item_name']).'",
                                "'.$row['qty_in'].'",
                                "'.$row['qty_out'].'",
                                "'.date('d-m-Y',strtotime($row['manf_date'])).'",
                                 "<div class=\"btn-group\"><a href=\"javascript:void(0)\" onclick=\"get_material_items('.$row['manufacture_item_id'].',this)\" class=\"btn btn-mini btn-info\" type=\"button\" title=\"View\"><i class=\"icon-eye-open bigger-120\"></i></a></div>"
                            ],';
                        }
					
                echo '{ 
                            "recordsTotal": '.count($lists).',
                        "data":[ 
                                '.rtrim($json,",").']}';
                    exit;
        }
        public function get_item_stock_details() // using ajax to check item stock details
        {
            $total_val = '['.rtrim($this->input->post('total_val'),",").']';
            
            $records = json_decode($total_val);
            
            $unique = array(); 
            
            $insufficient_item_names = '';  // concatenate insufficient quantity item name in the variable
            
            foreach( $records as $res ) //sort unique items with their quantity // check item each item 
            {
                if(isset($unique[$res->item_id]))
                {
                    $unique[$res->item_id] = $unique[$res->item_id] + $res->qty; //add item user required quantity
                }
                else
                {
                     $unique[$res->item_id] = $res->qty;
                }
            }
            
            foreach( $unique as $key=>$value ) // check each item stock details in 'items' table
            {
                $item_details = $this->items_model->get_item_details($key); // $key is item id & $value is user required quantity
                if( $value > $item_details['stock'] ) //check user required qty is greater than item stock 
                {
                    $insufficient_item_names .= ucfirst(strtolower($item_details['item_name'])).",";
                }
            }
            echo rtrim($insufficient_item_names,",");
        }
public function datafetch()
		{
			$requestData= $_REQUEST;
			$columns = array( 
								0 =>'id', 
								1 => 'item_code',
								2 => 'item_name',
								3 => 'created',
								4 => 'item_type',
								5 => 'stock',
								6 => 'status',
								7 => 'action',
							);
			$where_condition='status != "deleted" AND ';
			/////////////DEFAULT SEARCH//////////////////////////////
			if( !empty($requestData['search']['value']))
			{  	
				$search_value = trim($requestData['search']['value']);
				$where_condition.= "(id LIKE '%".$search_value."%' OR item_code LIKE '%".$search_value."%' OR item_name LIKE '%".$search_value."%'  OR created LIKE '%".$search_value."%'  OR item_type LIKE '%".$search_value."%' OR stock LIKE '%".$search_value."%' ) AND ";
			}
			/////////////DEFAULT SEARCH//////////////////////////////
			
		
			/////////////////TOTAL RECORD COUNT////////////////
			$this->db->select('id,item_code,item_name,item_type,stock,status,created');
			$this->db->from('items');
		
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
			//$this->db->select('purchases_table.id,purchases_table.user_id,purchases_table.item_id,purchases_table.purchase_date,purchases_table.qty,purchases_table.amount,purchases_table.remarks,purchases_table.user_type,purchases_table.status,suppliers_table.id,suppliers_table.supplier_name,items_table.id,items_table.item_name');
			$this->db->select('id,item_code,item_name,item_type,stock,status,created');
			$this->db->from('items');
			
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
			$json_data = array(
						"draw"            => intval( $requestData['draw'] ),   
						"recordsTotal"    => intval( $totalData ), 
						"recordsFiltered" => intval( $totalFiltered ), 
						"data"            => $row,
						);
			echo json_encode($json_data);  
		
		}
}
?>
