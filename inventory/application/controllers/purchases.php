<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : purchases.php
 * Project        : Accounting Software
 * Creation Date  : 9-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the purchase details
*********************************************************************************************/	
class Purchases extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model','purchase_model','supplier_model','items_model','customer_model','notes_model'));		 // load model files
		$this->security_model->chk_admin_login(); //check user is login or not
	}
		 public function index()
    {
       
	    redirect('purchases/lists');
    }
	public function lists() // purchases lists
    {
        $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		
		$where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['menu'] = 'purchase';
		
			$this->data['persons'] = $this->customer_model->get_active_sales_person_lists();
		 $this->data['items'] = $this->items_model->get_active_item_lists(); // get items lists from items table
		$this->load->view('purchases/list',$this->data);
    }
	public function purchase_entry() // insert daily purchase entry details 
	{
		$this->data['menu'] = 'purchase';
		$this->form_validation->set_rules('c_id','Purchase','trim');
		 if($this->session->userdata('session_user_type')!='viewer')
		 {
		if($this->form_validation->run()==TRUE)
		{
				$suppliers = $this->input->post('supplier');
				$items_code = $this->input->post('item_select');
				$purchase_date = $this->input->post('purchase_date');
				$qtys = $this->input->post('qtys');
				$amounts = $this->input->post('amounts');
				$remarks = $this->input->post('remarks');
				$ids = ''; // concatenate all the item id for stroed into notes table
			
				for($i=0;$i<count($suppliers);$i++)
				{
                    $user_id = substr($suppliers[$i], 0, -2);
                    $u_type = substr($suppliers[$i],-1);
                    $user_type = ($u_type=='s') ? 'supplier' : 'customer';
					 $purchase_details = array(
					 							'user_id'=>$user_id,
					 							'item_id'=>$items_code[$i],
					 							'purchase_date'=>$purchase_date[$i],
					 							'qty'=>$qtys[$i],
					 							'amount'=>$amounts[$i],
												'remarks'=>($remarks[$i]) ? $remarks[$i] : NULL,
                                                'user_type'=>$user_type,
					 							'status'=>STATUS_ACTIVE,
					 							'created'=>date('Y-m-d H:i:s')
										 );
							$this->db->insert('purchases',$purchase_details);
                     $last_id = $this->db->insert_id();
                    $ids .="#".$last_id.",";
				}
                 $notes = "The following ".rtrim($ids,",")." Purchase entry have been added manually by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                 $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
            
						$this->session->set_flashdata('message','Purchase details has been inserted successfully.');
						redirect('purchases');
		}
		$this->load->view('purchases/purchase_entry',$this->data);
		 }
	}
	public function edit_purchase($purchase_id) // edit the purchase details based on purchase id
	{
			$purchase_id = base64_decode($purchase_id);
            $this->data['purchase_details'] = $this->purchase_model->get_purchase_details($purchase_id);
            $this->form_validation->set_rules('user_id', 'supplier/customer name', 'trim|required');
			$this->form_validation->set_rules('item_id','Item code', 'trim|required');
			$this->form_validation->set_rules('purchase_date','Purchase date', 'trim|required');
			$this->form_validation->set_rules('qty','Quantity', 'trim|required|integer');
            $this->form_validation->set_rules('amount','Amount', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
                $user_id = substr($this->input->post('user_id'), 0, -2); // substring to get customer id or supplier id
                $u_type = substr($this->input->post('user_id'),-1); // get last character from the string (s or c)
                $user_type = ($u_type=='s') ? 'supplier' : 'customer';
                $purchase_details = array(
                        'user_id' =>$user_id,
                        'item_id' => $this->input->post('item_id'),
                        'purchase_date' => $this->input->post('purchase_date'),
                        'qty' => $this->input->post('qty'),
                        'amount' => $this->input->post('amount'),
                        'user_type'=>$user_type,
                        'modified'=>date('Y-m-d H:i:s'),									
                    );			
				$this->db->where('id',$purchase_id);
				$this->db->update('purchases',$purchase_details);
                
                 $notes = "The following purchase id #".$purchase_id." details has been modified by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                
				$this->session->set_flashdata('message','Purchase details has been updated successfully.'); 
				redirect('purchases');
		}
			$this->data['menu']='purchase';
            $this->data['suppliers'] = $this->supplier_model->get_active_supplier_lists();
            $this->data['customers'] = $this->customer_model->get_active_customer_lists();
            $this->data['items'] = $this->items_model->get_active_item_lists();
			$this->load->view('purchases/edit_purchase',$this->data);
	}
	public function change_status() // change the purchases details status based on purchase id using ajax
	{
			$status = 'inactive';
			$purchase_id = $this->input->post('purchase_id');		
			$item = $this->purchase_model->get_purchase_details($purchase_id);
            
            $item_stock_details = $this->items_model->get_item_details($item['item_id']);
  
                if($item['status'] == 'inactive')
               {
                    $status = 'active';
                    $this->db->set('stock', 'stock+'.$item['qty'].'', FALSE);
                    $this->db->where('id', $item['item_id']);
                    $this->db->update('items'); 
                    $this->db->where('id',$purchase_id);
                $this->db->update('purchases',array( 'status' => $status ));
                $notes =  "The following purchase id #".$purchase_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                echo $status;
               }
               else
               {
                   if($item['qty'] > $item_stock_details['stock'])
                   {
                        echo "insufficient";
                   }
                   else
                   {
                    $this->db->set('stock', 'stock-'.$item['qty'].'', FALSE);
                    $this->db->where('id', $item['item_id']);
                    $this->db->update('items'); 
                    $this->db->where('id',$purchase_id);
                $this->db->update('purchases',array( 'status' => $status ));
                $notes =  "The following purchase id #".$purchase_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                echo $status;
                   }
               }
                
	}
	public function delete_purchase() // delete the purchases details based on purchase id using ajax
	{
			$purchase_id = $this->input->post('purchase_id');
			
			$this->db->where('id',$purchase_id);
			$this->db->update('purchases',array('status'=>'deleted'));
            
            $notes =  "The following purchase id #".$purchase_id." status(deleted) has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
			$this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			
	}
	public function check_attachment() // callback method to check upload file extension
	{
			$ext_array = array('.doc','.docx');
			if(!empty($_FILES['file_upload']['name']))
			{
				$ext = strtolower(strrchr($_FILES['file_upload']['name'],"."));
				if(in_array($ext,$ext_array))
				{
					return true;
				}
				else
				{
					$this->form_validation->set_message('check_attachment','Import only .doc or .docx file');
					return false;
				}
			}
			{
				$this->form_validation->set_message('check_attachment','Required');
				return false;
			}
	}
		public function ajax_get_active_suppliers() // get active suppliers from 'suppliers' table using select2 dropdown remote ajax
		{
	
			$search_key=($this->input->get('q')) ? $this->input->get('q') : '';
			$this->db->select('id,supplier_name');
			
			$this->db->from('suppliers');
		
			if($search_key)
			{
					$where_condition="(supplier_name LIKE '%".$search_key."%') AND status ='".STATUS_ACTIVE."'";
			}
			
			$this->db->where($where_condition);
			
			$query=$this->db->get();
            
            // get customer list
            $this->db->select('id,customer_name');
			
			$this->db->from('customers');
		
			if($search_key)
			{
					$where_condition="(customer_name LIKE '%".$search_key."%') AND status ='".STATUS_ACTIVE."'";
			}
			
			$this->db->where($where_condition);
			
			$query1=$this->db->get();
            //end
			
			$arr=array();
			
			foreach($query->result_array() as $item) // supplier list
			{
				$arr[]=array(
					'internal'=>$item['supplier_name'],
					'id'=>$item['id'].'-s'
					);
			}
            
            foreach($query1->result_array() as $item) // customer list
			{
				$arr[]=array(
					'internal'=>$item['customer_name'],
					'id'=>$item['id'].'-c'
					);
			}
	
			echo json_encode($arr,true);
			
			exit;
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
        public function get_search_query($url)
	   {
		      $get = array(
					   'chk_person'=>"",
					  'chk_item_id'=>"",
					 'chk_status'=>"",
					 'chk_usertype'=>"",
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

            if($user_type!==FALSE)
            {
                $get['chk_usertype'] = $this->uri->segment($user_type+1);	
            }
			   if($person!==FALSE)
            {
                $get['chk_person'] = $this->uri->segment($person+1);	
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
		 public function ajax_get_purchase_list() // load bulk records to jquery data table using ajax
		 {
             $segment_array = $this->uri->segment_array();
             $lists = $this->purchase_model->get_purchase_lists($segment_array);
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
					//$purchases_list[$list['id']]['remarks'] = $list['remarks'];
					$purchases_list[$list['id']]['remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['remarks']);
                    $purchases_list[$list['id']]['user_type'] = $list['user_type'];
                    $purchases_list[$list['id']]['status'] = $list['status'];
                }
             
            $option = array_search('option_type',$segment_array); // print pdf option
           if($option!==FALSE)
		   {
                $option_type = $this->uri->segment($option+1);
                if($option_type=='pdf')
                {
                    $this->data['purchases_list'] = $purchases_list;
					//print_r(purchases_list);exit;
                    $html = $this->load->view('purchases/print_to_pdf',$this->data,true);
					$pdf_filename  ='purchase_report.pdf';
					$this->load->library('dompdf_lib');
					$this->dompdf_lib->convert_html_to_pdf($html, $pdf_filename, true);
                }
                else if($option_type=='csv')
                {
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=purchase_report.csv");
                    // Disable caching
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                    header("Pragma: no-cache"); // HTTP 1.0
                    header("Expires: 0"); // Proxies
                    $heading = array('Name','Purchase Id','Item Name','Purchase Date','Quantity','Amount','Remarks','User Type','Status');
                    $this->outputCSV($purchases_list,$heading);
                    exit;
                }
            }
                    
                $json = "";
                        foreach($purchases_list as $row)
                        {
                                    $status_image	=	($row['status'] == STATUS_ACTIVE)?'active.png':'inactive.png';
                                    $title			=	($row['status'] == STATUS_ACTIVE)?'Change&nbsp;Inactive':'Change&nbsp;Active';
                                if($row['status'] == STATUS_ACTIVE)
                                {
                                    $s = '<img style=\"cursor:pointer;\" onClick=\"change_status('.$row['id'].',this);\" src=\"'.base_url().'assets/images/'.$status_image.'\" title=\"'.$title.'\">';
                                }
                                else
                                {
                                     $s = '<img src=\"'.base_url().'assets/images/'.$status_image.'\" title=\"'.$title.'\">';
                                }
                                    $json .= '[
                                        "'.ucfirst($row['user_name']).'",
                                        "'.ucfirst($row['item_name']).'",
                                        "'.date('d-m-Y',strtotime($row['purchase_date'])).'",
                                        "'.$row['qty'].'",
                                        "'.$row['amount'].'",
										 "'.(($row['remarks']=='')?'---': $row["remarks"]).'",
                                        "'.$s.'"
                                    ],';
                        }
					
                echo '{ 
                            "recordsTotal": '.count($purchases_list).',
                        "data":[ 
                                '.rtrim($json,",").']}';
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
public function datafetch()
	{
		$segment_array = $this->uri->segment_array();
		$requestData= $_REQUEST;
		$columns = array( 
							0 =>'purchases_table.id', 
							1 => 'supplier_name',
							2=> 'item_name',
							3=> 'purchase_date',
							4=> 'qty',
							5=> 'amount',
							6=> 'created',
							7=> 'remarks',
							8=> 'status',
							9=> 'user_type',
						);
					
		$segment_array = $this->uri->segment_array();
		$delete ='active';
					$where_condition='';
		/////////////DEFAULT SEARCH//////////////////////////////
		if( !empty($requestData['search']['value']))
		{  	
			$search_value = trim($requestData['search']['value']);
			$where_condition.= "(suppliers_table.supplier_name LIKE '%".$search_value."%' OR customers_table.customer_name LIKE '%".$search_value."%' OR items_table.item_name LIKE '%".$search_value."%' OR purchases_table.purchase_date LIKE '%".$search_value."%' OR purchases_table.qty LIKE '%".$search_value."%' OR purchases_table.amount LIKE '%".$search_value."%' OR purchases_table.remarks LIKE '%".$search_value."%' OR purchases_table.status LIKE '%".$search_value."%' OR purchases_table.user_type LIKE '%".$search_value."%') AND ";
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
			$where_condition.= "(date(purchases_table.purchase_date) BETWEEN '".date("Y-m-d",strtotime($start_date))."' AND '".date("Y-m-d",strtotime($end_date))."') AND ";
		}
		/////////////SEARCH DATE//////////////////////////////
		/////////////SEARCH USERTYPE//////////////////////////////
		$user_keyword = array_search('user_type',$segment_array);
		if ($user_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($user_keyword+1);
			if($keyword!='')
			$where_condition.="(purchases_table.user_type='".$keyword."') AND ";
		} 
		/////////////SEARCH USERTYPE//////////////////////////////
		/////////////SEARCH PERSON//////////////////////////////
		$user_keyword = array_search('person',$segment_array);
		if ($user_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($user_keyword+1);
			if($keyword!='')
			$where_condition.="(customers_table.sales_person_id IN (".$keyword.") OR suppliers_table.sales_person_id IN (".$keyword.") ) AND" ;
		} 
		/////////////SEARCH PERSON//////////////////////////////
		/////////////SEARCH ITEM//////////////////////////////
		$user_keyword = array_search('item_id',$segment_array);
		if ($user_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($user_keyword+1);
			if($keyword!='')
			$where_condition.="(items_table.id IN (".$keyword.")) AND" ;
		} 
		/////////////SEARCH ITEM//////////////////////////////
		$where_condition.="(purchases_table.status='".$delete."') ";
		/////////////////TOTAL RECORD COUNT////////////////
		$this->db->select('purchases_table.id,purchases_table.user_id,purchases_table.item_id,purchases_table.created,purchases_table.purchase_date,purchases_table.qty,purchases_table.amount,purchases_table.remarks,purchases_table.user_type,purchases_table.status,suppliers_table.id,suppliers_table.supplier_name,items_table.id,items_table.item_name,customers_table.id AS cid,customers_table.customer_name');
		$this->db->from('purchases purchases_table');
		$this->db->join('items items_table', 'items_table.id=purchases_table.item_id', 'left');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=purchases_table.user_id AND purchases_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=purchases_table.user_id AND purchases_table.user_type= "customer" ', 'left');
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
		$this->db->select('purchases_table.id ,purchases_table.user_id,purchases_table.item_id,purchases_table.purchase_date,purchases_table.created,purchases_table.qty,purchases_table.amount,purchases_table.remarks,purchases_table.user_type,purchases_table.status,suppliers_table.id AS sup_id,suppliers_table.supplier_name,items_table.id AS item_id,items_table.item_name,customers_table.id AS cid,customers_table.customer_name');
		$this->db->from('purchases purchases_table');
		$this->db->join('items items_table', 'items_table.id=purchases_table.item_id', 'left');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=purchases_table.user_id AND purchases_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=purchases_table.user_id AND purchases_table.user_type= "customer" ', 'left');
		
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

		///////////SUM COLUMN BASED ON CONDITION///////////	
		$select = array("SUM(ROUND(REPLACE(purchases_table.amount, ',', ''),2)) AS total , SUM(ROUND(REPLACE(purchases_table.qty, ',', ''),2)) AS qty_total");
		$this->db->select($select);
		$this->db->from('purchases purchases_table');
		$this->db->join('items items_table', 'items_table.id=purchases_table.item_id', 'left');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=purchases_table.user_id AND purchases_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=purchases_table.user_id AND purchases_table.user_type= "customer" ', 'left');

		if($where_condition!='')
		{
			$where_condition = rtrim($where_condition,'AND ');
			$this->db->where($where_condition);
		}
		$query = $this->db->get();
		$sum_value = $query->row_array();
		$sum = number_format($sum_value['total'],2);
		$qty_sum = number_format($sum_value['qty_total'],0);
		///////////SUM COLUMN BASED ON CONDITION///////////	
		
		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   
					"recordsTotal"    => intval( $totalData ), 
					"recordsFiltered" => intval( $totalFiltered ), 
					"data"            => $row,
					"total_amount"	  =>$sum,
					"total_qty"		  =>$qty_sum,
					);
		echo json_encode($json_data);  
	}  
}
?>