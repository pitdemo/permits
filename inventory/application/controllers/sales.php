<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : sales.php
 * Project        : Accounting Software
 * Creation Date  : 22-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the sales details
*********************************************************************************************/	
class Sales extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model','sales_model','supplier_model','items_model','customer_model','notes_model','itemsgroup_model'));		 // load items group model - soundarya
		$this->security_model->chk_admin_login();
	}
    public function index()
    {
    	
    	// /exit;
       
	    redirect('sales/lists');
    }
	public function lists() // sales lists
    {
    	
        $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		//echo $this->data['uri_data'];
		$where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['menu'] = 'sales';
		
		$this->data['persons'] = $this->customer_model->get_active_sales_person_lists();
		$this->data['items'] = $this->items_model->get_active_item_lists(); // get items lists from items table
		$get_items_group = $this->itemsgroup_model->get_items_group_lists(); // get item group lists from items group listing - soundarya
		//print_r($this->data['items_group']);exit; //display item group - get active items count > 0
		$this->data['items_group'] = array();
			$rows = array();
            foreach ($get_items_group  as $key=>$arr) {
             $group_details = $this->itemsgroup_model->get_group_details($arr['id']); // get records based on group id
             $items_details = $this->itemsgroup_model->get_items_details($group_details['items']);
          //echo count($items_details);
	         $rows = array_merge( $arr, array( "active_count_only" => count($items_details) ) );
	         array_push($this->data['items_group'],$rows); 
          }
          //print_r($this->data['items_group']);exit;
		$this->load->view('sales/lists',$this->data);
    }
    public function sales_entry() // insert daily sales entry details 
	{
		
		$this->data['menu'] = 'sales';
		$this->form_validation->set_rules('c_id','Sales','trim');
		if($this->session->userdata('session_user_type')!='viewer')
		{
		if($this->form_validation->run()==TRUE)
		{
				$suppliers  = $this->input->post('supplier');
				$items_code = $this->input->post('item_select');
				$sales_date = $this->input->post('sales_date');
				$qtys = $this->input->post('qtys');
				$amounts = $this->input->post('amounts');
				$remarks = $this->input->post('remarks');
				$ids = ''; // concatenate all the item id for stroed into notes table
			
				for($i=0;$i<count($suppliers);$i++)
				{
                    $user_id = substr($suppliers[$i], 0, -2);
                    $u_type = substr($suppliers[$i],-1);
                    $user_type = ($u_type=='s') ? 'supplier' : 'customer';
					
					/*sivaranjani*/
					$this->db->select('sales_person_id');
					$this->db->where('id',$user_id);
					if($user_type !='' && $user_type=='supplier')
					{
						$qry = $this->db->get('suppliers');
					}
					elseif($user_type!='' && $user_type=='customer')
					{
						$qry = $this->db->get('customers');
					}
					$sales_person_id = $qry->row_array();
					$sales_person_id = implode(" ",$sales_person_id);

					$sales_details = array(
					 							'user_id'=>$user_id,
					 							'sales_person_id'=>$sales_person_id,
					 							'item_id'=>$items_code[$i],
					 							'sales_date'=>$sales_date[$i],
					 							'qty'=>$qtys[$i],
					 							'amount'=>$amounts[$i],
												'remarks'=>($remarks[$i]) ? $remarks[$i] : NULL,
                                                'user_type'=>$user_type,
					 							'status'=>STATUS_ACTIVE,
					 							'created'=>date('Y-m-d H:i:s')
										 );

					$this->db->insert('sales',$sales_details);
                    $last_id = $this->db->insert_id();
                    $ids .="#".$last_id.",";
				}
                
                $notes = "The following ".rtrim($ids,",")." sales entry have been added manually by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );

                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
				$this->session->set_flashdata('message','Sales details has been inserted successfully.');
				redirect('sales/lists');
		}
		$this->load->view('sales/sales_entry',$this->data);
	}
	}
    public function edit_sales($sales_id) // edit the sales details based on sales id
	{
			$sales_id = base64_decode($sales_id);
            $this->data['sales_details'] = $this->sales_model->get_sales_details($sales_id);
            $this->form_validation->set_rules('user_id', 'supplier/customer name', 'trim|required');
			$this->form_validation->set_rules('item_id','Item code', 'trim|required');
			$this->form_validation->set_rules('sales_date','Sales date', 'trim|required');
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
                        'sales_date' => $this->input->post('sales_date'),
                        'qty' => $this->input->post('qty'),
                        'amount' => $this->input->post('amount'),
                        'user_type'=>$user_type,
                        'modified'=>date('Y-m-d H:i:s'),									
                    );			
				$this->db->where('id',$sales_id);
				$this->db->update('sales',$purchase_details);
                
                $notes = "The following sales id #".$sales_id." details has been modified by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
				$this->session->set_flashdata('message','Sales details has been updated successfully.'); 
				redirect('sales/lists');
		}
			$this->data['menu']='sales';
            $this->data['suppliers'] = $this->supplier_model->get_active_supplier_lists();
            $this->data['customers'] = $this->customer_model->get_active_customer_lists();
            $this->data['items'] = $this->items_model->get_active_item_lists();
			$this->load->view('sales/edit_sales',$this->data);
	}
	public function change_status() // change the sales details status based on sales id using ajax
	{
			$status = 'inactive';
			$sales_id = $this->input->post('sales_id');	
            $revert_back = $this->input->post('revert_back');	
            $item = $this->sales_model->get_sales_details($sales_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('id',$sales_id);
			$this->db->update('sales',array( 'status' => $status,'revert_stock'=>$revert_back));
            
            $notes =  "The following sales id #".$sales_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
        
			echo $status;
	}
	public function delete_sales() // delete the sales details based on purchase id using ajax
	{
			$sales_id = $this->input->post('sales_id');
			
			$this->db->where('id',$sales_id);
			$this->db->update('sales',array('status'=>'deleted'));
        
            $notes =  "The following sales id #".$sales_id." status(deleted) has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
			$this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			
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
					 'chk_item_group'=>"", // added item group element - soundarya
                    'chk_start_date'=>"",
                    'chk_end_date'=>"",
              );
            $item = array_search('item_id',$this->uri->segment_array());
            $status = array_search('status',$this->uri->segment_array());
            $user_type = array_search('user_type',$this->uri->segment_array());
			$person = array_search('person',$this->uri->segment_array());
			$item_group = array_search('item_group',$this->uri->segment_array());
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
            if($item_group!==FALSE)
            {
            	$get['chk_item_group'] = $this->uri->segment($item_group+1); //get item group value - soundarya
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
             $lists = $this->sales_model->get_sales_lists($segment_array);
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
					//$sales_list[$list['id']]['remarks'] = $list['remarks'];
					$sales_list[$list['id']]['remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['remarks']);
                    $sales_list[$list['id']]['user_type'] = $list['user_type'];
                    $sales_list[$list['id']]['status'] = $list['status'];
					
					
                }
                //echo "<pre>";
                //print_r($sales_list);exit;
             
            $option = array_search('option_type',$segment_array); // print pdf option
           if($option!==FALSE)
		   {
                $option_type = $this->uri->segment($option+1);
                if($option_type=='pdf')
                {
                    $this->data['sales_list'] = $sales_list;
                    $html = $this->load->view('sales/print_to_pdf',$this->data,true);
					$pdf_filename  ='sales_list.pdf';
					$this->load->library('dompdf_lib');
					$this->dompdf_lib->convert_html_to_pdf($html, $pdf_filename, true);
                }
                else if($option_type=='csv')
                {
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=sales_list.csv");
                    // Disable caching
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                    header("Pragma: no-cache"); // HTTP 1.0
                    header("Expires: 0"); // Proxies
                    $heading = array('Name','Sales Id','Item Name','Sales Date','Quantity','Amount','Remarks','User Type','Status');
                    $this->outputCSV($sales_list,$heading);
                    exit;
                }
            }
                    
					
                $json = "";
                        foreach($sales_list as $row)
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
                                        "'.date('d-m-Y',strtotime($row['sales_date'])).'",
                                        "'.$row['qty'].'",
                                        "'.$row['amount'].'",
										 "'.(($row['remarks']=='')?'---': $row["remarks"]).'",
                                        "'.$s.'"
                                    ],';
                        }
					
                echo '{ 
                        "recordsTotal": '.count($sales_list).',
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
	   
public function datafetch()
	{
		$segment_array = $this->uri->segment_array();
		$requestData= $_REQUEST;
		$columns = array( 
							0 =>'sales_table.id', 
							1 => 'supplier_name',
							2=> 'item_name',
							3=> 'sales_date',
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
		if( trim($requestData['search']['value']) != "" )//!empty(trim($requestData['search']['value']))
		{  	
			$search_value = trim($requestData['search']['value']);
			$where_condition.= "(suppliers_table.supplier_name LIKE '%".$search_value."%' OR customers_table.customer_name LIKE '%".$search_value."%' OR items_table.item_name LIKE '%".$search_value."%' OR sales_table.sales_date LIKE '%".$search_value."%' OR sales_table.qty LIKE '%".$search_value."%' OR sales_table.amount LIKE '%".$search_value."%' OR sales_table.remarks LIKE '%".$search_value."%' OR sales_table.status LIKE '%".$search_value."%' OR sales_table.user_type LIKE '%".$search_value."%') AND ";
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
			$where_condition.= "(date(sales_table.sales_date) BETWEEN '".date("Y-m-d",strtotime($start_date))."' AND '".date("Y-m-d",strtotime($end_date))."') AND ";
		}
		/////////////SEARCH DATE//////////////////////////////
		/////////////SEARCH USERTYPE//////////////////////////////
		$user_keyword = array_search('user_type',$segment_array);
		if ($user_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($user_keyword+1);
			if($keyword!='')
			$where_condition.="(sales_table.user_type='".$keyword."') AND ";
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
		//print_r($segment_array);
		$user_keyword = array_search('item_id',$segment_array);
		$itemgroup = array_search('item_group', $segment_array); // items group - soundarya
		//echo $item;
		$keyword='';
		$keyword1='';
		if ($user_keyword !== FALSE || $itemgroup !== FALSE)
		{
			//echo $itemgroup;
			if($user_keyword !== FALSE)
			$keyword = $this->uri->segment($user_keyword+1);
		    if($itemgroup !== FALSE)
			$keyword1 = $this->uri->segment($itemgroup+1);
			if($keyword!='' && $keyword1 =='')
			{
			$where_condition.="(items_table.id IN (".$keyword.")) AND" ;
		    }
		    
			if($keyword1!='' && $keyword =='')
			{
				$item_ids = $this->itemsgroup_model->get_item_ids($keyword1); 
				//print_r($item_ids);
				$ids = array();
				foreach ($item_ids as $items) {
					//print_r($items);
				    //  $ids[] .= $items['items'];
				    array_push($ids,$items['items']);// contain items id based on item group 
				}
				$value="";
				$key = array_keys($ids);
				$lastkey = end($key);
				foreach($ids as $key=>$id)
				{

					$value .= $id;
                    if($key != $lastkey) 
					$value .=",";
				}
				//echo $value;
				/*$get_active_item_details = $this->itemsgroup_model->get_items_details($value);
				$active_item_ids = array();
				foreach ($get_active_item_details as $key => $value) {
					# code...
					$active_item_ids[] = $value['id']; //get  active items id only

				}*/
                //$where_condition.="(items_table.id IN (".implode($active_item_ids).")) AND" ;

				$where_condition.="(items_table.id IN (".$value.")) AND" ;
				$where_condition.="(items_table.status='active') AND ";
				//print_r($active_item_ids);exit;
				//print_r($data['active_item_ids']);exit;
   			}
   			if($keyword !='' && $keyword1 !='')
   			{
   				//echo $keyword;
   				//echo $value;
   				//exit;
   				$item_ids = $this->itemsgroup_model->get_item_ids($keyword1); 
				//print_r($item_ids);
				$ids = array();
				foreach ($item_ids as $items) {
					//print_r($items);
				    //  $ids[] .= $items['items'];
				    array_push($ids,$items['items']);// contain items id based on item group 
				}
				$value="";
				
				$key = array_keys($ids);
				$lastkey = end($key);
				foreach($ids as $key=>$id)
				{

					$value .= $id;
                    if($key != $lastkey) 
					$value .=",";
				}
   				$where_condition.="(items_table.id IN (".$keyword.','.$value.")) AND" ;
                $where_condition.="(items_table.status='active') AND ";
   			}
		} 

		//$user_keyword = array_search('item_group', $segment_array); // items group - soundarya
		/*if($user_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($user_keyword+1);
			if($keyword !='')
			{
				$item_ids = $this->itemsgroup_model->get_item_ids($keyword); 
				//print_r($item_ids);
				$ids = array();
				foreach ($item_ids as $items) {
					//print_r($items);
				    //  $ids[] .= $items['items'];
				    array_push($ids,$items['items']);// contain items id based on item group 
				}
				$value="";
				$lastkey = end(array_keys($ids));
				foreach($ids as $key=>$id)
				{

					$value .= $id;
                    if($key != $lastkey) 
					$value .=",";
				}
				//echo $value;
				/*$get_active_item_details = $this->itemsgroup_model->get_items_details($value);
				$active_item_ids = array();
				foreach ($get_active_item_details as $key => $value) {
					# code...
					$active_item_ids[] = $value['id']; //get  active items id only

				}
                //$where_condition.="(items_table.id IN (".implode($active_item_ids).")) AND" ;

				$where_condition.="(items_table.id IN (".$value.")) AND" ;
				$where_condition.="(items_table.status='active') AND ";
				//print_r($active_item_ids);exit;
				//print_r($data['active_item_ids']);exit;
   			}
		}*/
		/////////////SEARCH ITEM//////////////////////////////
				$where_condition.="(sales_table.status='".$delete."') ";

		/////////////////TOTAL RECORD COUNT////////////////
		$this->db->select('sales_table.id,sales_table.user_id,sales_table.item_id,sales_table.created,sales_table.sales_date,sales_table.qty,sales_table.amount,sales_table.remarks,sales_table.user_type,sales_table.status,suppliers_table.id AS sid,suppliers_table.supplier_name,suppliers_table.sales_person_id,items_table.id AS iid,items_table.item_name,customers_table.id AS cid,customers_table.customer_name,customers_table.sales_person_id');
		$this->db->from('sales sales_table');
		$this->db->join('items items_table', 'items_table.id=sales_table.item_id', 'left');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=sales_table.user_id AND sales_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=sales_table.user_id AND sales_table.user_type= "customer" ', 'left');
	//	$this->db->order_by('sales_table.sales_date', 'desc');

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
		//$this->db->select('sales_table.id,sales_table.user_id,sales_table.item_id,sales_table.sales_date,sales_table.qty,sales_table.amount,sales_table.remarks,sales_table.user_type,sales_table.status,suppliers_table.id,suppliers_table.supplier_name,items_table.id,items_table.item_name');
		$this->db->select('sales_table.id,sales_table.user_id,sales_table.item_id,sales_table.created,sales_table.sales_date,sales_table.qty,sales_table.amount,sales_table.remarks,sales_table.user_type,sales_table.status,suppliers_table.id AS sid,suppliers_table.supplier_name,suppliers_table.sales_person_id,items_table.id AS iid,items_table.item_name,customers_table.id AS cid,customers_table.customer_name,customers_table.sales_person_id');
		$this->db->from('sales sales_table');
		$this->db->join('items items_table', 'items_table.id=sales_table.item_id', 'left');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=sales_table.user_id AND sales_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=sales_table.user_id AND sales_table.user_type= "customer" ', 'left');
	//$this->db->order_by('sales_table.sales_date', 'desc');
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
        //echo $this->db->last_query();exit;
		$query = $this->db->get();
		$row = $query->result_array();
		
		//////////////TOTAL OF ALL COLUMNS////////////////
/*		$test = $this->db->query("SELECT SUM(ROUND(REPLACE(amount, ',', ''),2)) AS total from sales WHERE status!='deleted' ")
						->row_array(); 
		$test2 = $this->db->query("SELECT SUM(ROUND(REPLACE(qty, ',', ''),2)) AS total2 from sales WHERE status!='deleted' ")
						->row_array(); 
						
		$this->data['total'] = number_format($test['total'],2);
		$this->data['qty'] = number_format($test2['total2'],0);
*/		//////////////TOTAL OF ALL COLUMNS////////////////


		///////////SUM COLUMN BASED ON CONDITION///////////	
		
		$select = array("SUM(ROUND(REPLACE(sales_table.amount, ',', ''),2)) AS total , SUM(ROUND(REPLACE(sales_table.qty, ',', ''),2)) AS qty_total");
		$this->db->select($select);
		$this->db->from('sales sales_table');
		$this->db->join('items items_table', 'items_table.id=sales_table.item_id', 'left');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=sales_table.user_id AND sales_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=sales_table.user_id AND sales_table.user_type= "customer" ', 'left');

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

	/*function for print functionality - soundarya*/
	public function print_ajax_get_sales_list()
	{
		     $segment_array = $this->uri->segment_array();
		     //print_r($segment_array);
		     $start = array_search("start",$segment_array);
		     $end = array_search("end",$segment_array);

		     //echo $start_date;
		     //echo $end_date;
		     
             $lists = $this->sales_model->get_print_sales_lists($segment_array);
            /* echo "<pre>";
             print_r($lists)*/
             if($start !== FALSE && $end !== FALSE)
		     {
		     	$start_date = $this->uri->segment($start+1);
		     	$end_date = $this->uri->segment($end+1);
		     	$this->data['start'] = $start_date;
		        $this->data['end'] = $end_date;
		     }
		     else
		     {
		     	//$get_max_min_list = $this->sales_model->get_print_sales_lists($segment_array,"empty_list");
		     	if(!empty($lists))
		     	{
		     	$this->data['start'] = $lists[count($lists) - 1]['sales_date']; //array first value
		        $this->data['end'] = $lists[0]['sales_date']; // array last value
		        }
               
		     }
		     /*echo $this->data['start'];
		     echo $this->data['end'];
		     echo count($lists);*/

             $sales_list = array();
                foreach($lists as $list)
                {
                    $item_details = $this->items_model->get_item_details($list['item_id']);
                    $sales_list[$list['id']]['id'] = $list['id'];
                    $sales_list[$list['id']]['sales_date'] = $list['sales_date'];
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
                    $sales_list[$list['id']]['item_name'] = $item_details['item_name'];
                    $sales_list[$list['id']]['qty'] = $list['qty'];
                    $val=str_replace(',','',$list['amount']);
                    //echo $val;
                    if($val > 0.00 && $list['qty'] > 0)
                    {
                    	//echo $val;
                     $rate_val = ($val/$list['qty']);
                     $sales_list[$list['id']]['rate'] = number_format($rate_val, 2);
                    }
                    else
                    {
                    $sales_list[$list['id']]['rate'] = 0;
                    }
                    $sales_list[$list['id']]['amount'] = $list['amount'];
					//$sales_list[$list['id']]['remarks'] = $list['remarks'];
					$sales_list[$list['id']]['remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['remarks']);				
					
                }
                 $this->data['sales_list'] = $sales_list;
                 $this->data['page_title'] = "Sales Reports";
                 //echo count($this->data['sales_list']);exit;
                 $html = $this->load->view('print/print_view',$this->data,true);
                 echo $html;
		
	} 
}
?>
