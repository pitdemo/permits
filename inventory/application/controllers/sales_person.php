<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : sales.php
 * Project        : Accounting Software
 * Creation Date  : 22-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the sales details
*********************************************************************************************/	
class Sales_person extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model','sales_model','supplier_model','items_model','customer_model','notes_model','sales_person_model'));		
		$this->security_model->chk_admin_login();
	}
    public function index()
    {
        redirect('sales_person/lists');
    }
	public function lists() // sales lists
    {
        $where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['menu'] = 'sales person';
		$this->load->view('sales_person/lists',$this->data);
    }
  
	public function create_sales_person() // create new sales person details
	{
		$this->data['menu'] = 'sales person';
		$this->form_validation->set_rules('c_id','Person','trim');
		 if($this->session->userdata('session_user_type')!='viewer')
		 {
		if($this->form_validation->run()==TRUE)
		{
				$sales_person_names = $this->input->post('sales_person_name');
				$phone_nos = $this->input->post('phone_no');
				
			    $ids = ''; // concatenate all the item id for stroed into notes table
				for($i=0;$i<count($sales_person_names);$i++)
				{
					 $insert_details = array(
					 							'sales_person_name'=>$sales_person_names[$i],
					 							'phone_no'=>($phone_nos[$i]) ? $phone_nos[$i] : NULL,
					 							'status'=>'active',
					 							'created'=>date('Y-m-d H:i:s')
										 );
							$this->db->insert('sales_person_tbl',$insert_details);  // insert into customers table
							$last_id = $this->db->insert_id();
                            $ids .="#".$last_id.",";
				}
                 $notes = "The following ".rtrim($ids,",")." Sales Persons have been added manually by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                 $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
				$this->session->set_flashdata('message','Sales Person details has been inserted successfully.');
				redirect('sales_person/lists');
		}
		$this->load->view('sales_person/create_sales_person',$this->data);
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
	public function change_status() // change the sales details status based on sales person id using ajax
	{
			$status = 'inactive';
			$sales_person_id = $this->input->post('sales_person_id');	
            $item = $this->sales_person_model->get_sales_person_details($sales_person_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('id',$sales_person_id);
			$this->db->update('sales_person_tbl',array( 'status' => $status));
       
            $notes =  "The following sales person id #".$sales_person_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
        
			echo $status;
	}
	public function delete_sales() // delete the purchases details based on purchase id using ajax
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
					 'chk_status'=>"",
					 'chk_usertype'=>"",
                    'chk_start_date'=>"",
                    'chk_end_date'=>""
              );
            
            $status = array_search('status',$this->uri->segment_array());
            $user_type = array_search('user_type',$this->uri->segment_array());
            $date_from = array_search('start',$this->uri->segment_array());
            $date_end = array_search('end',$this->uri->segment_array());
            
            if($status!==FALSE)
            {
                $get['chk_status'] = $this->uri->segment($status+1);	
            }

            if($user_type!==FALSE)
            {
                $get['chk_usertype'] = $this->uri->segment($user_type+1);	
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
		 public function ajax_get_sales_person_list() // load bulk records to jquery data table using ajax
		 {
             $segment_array = $this->uri->segment_array();
             $lists = $this->sales_person_model->get_sales_person_lists($segment_array);
			 $sales_person_list = array();
                foreach($lists as $list)
                {
					
					$sales_person_list[$list['id']]['id'] = $list['id'];
                    $sales_person_list[$list['id']]['sales_person_name'] = $list['sales_person_name'];
					$sales_person_list[$list['id']]['customer_count'] = $list['customer_count'];
					$sales_person_list[$list['id']]['supplier_count'] = $list['supplier_count'];
					 $sales_person_list[$list['id']]['phone_no'] = $list['phone_no'];
                    $sales_person_list[$list['id']]['created'] = $list['created'];
                    $sales_person_list[$list['id']]['status'] = $list['status'];
                }
					
            $option = array_search('option_type',$segment_array); // print pdf option
           if($option!==FALSE)
		   {
                $option_type = $this->uri->segment($option+1);
                if($option_type=='pdf')
                {
                    $this->data['sales_person_list'] = $sales_person_list;
                    $html = $this->load->view('sales_person/print_to_pdf',$this->data,true);
					$pdf_filename  ='sales_person_list.pdf';
					$this->load->library('dompdf_lib');
					$this->dompdf_lib->convert_html_to_pdf($html, $pdf_filename, true);
                }
                else if($option_type=='csv')
                {
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=sales_person_list.csv");
                    // Disable caching
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                    header("Pragma: no-cache"); // HTTP 1.0
                    header("Expires: 0"); // Proxies
                    $heading = array('Name','Created Date','Phone no','Status');
                    $this->outputCSV($sales_person_list,$heading);
                    exit;
                }
            }
                    
                $json = "";	
				
                        foreach($sales_person_list as $row)
                        {
						$created_date = date('Y-m-d',strtotime($row['created']));
						$today = date('Y-m-d'); //2015-10-20
						$last_six = date('Y-m-d', strtotime('-6 days', strtotime($today)));  
						
						$total_val_customer= 0;	
						$customer_details = $this->sales_person_model->get_customer_details($row['id']);
					   
                             if($row['customer_count']>0)
                            {
                               foreach($customer_details as $custmer)
							   {
								   $total_val_customer = $total_val_customer + $this->number_unformat($custmer['outstanding']);
							   }
                            }
							
							
							$total_val_supplier= 0;	
							 $supplier_details = $this->sales_person_model->get_supplier_details($row['id']);
							 
                            if($row['supplier_count']!=0)
                            {
                               foreach($supplier_details as $supplier)
							   {
								   $total_val_supplier = $total_val_supplier + $this->number_unformat($supplier['outstanding']);
							   }
                            }
							//exit;
                                    $status_image	=	($row['status'] == STATUS_ACTIVE)?'active.png':'inactive.png';
                                    $title			=	($row['status'] == STATUS_ACTIVE)?'Change&nbsp;Inactive':'Change&nbsp;Active';
                                if($this->session->userdata('session_user_type')=='admin' )
								{
										if($row['status'] == STATUS_ACTIVE)
										{
											  if($created_date > $last_six && $created_date <= $today)
											  {
												  $s = '<img style=\"cursor:pointer;\" onClick=\"change_status('.$row['id'].',this);\" src=\"'.base_url().'assets/images/active.png\" title=\"Active\">';
											  }
											  else
											  {
												  $s = '<img src=\"'.base_url().'assets/images/expired.png\" title=\"Date Expired\">';
											  }
										}
								
										if($row['status'] == STATUS_INACTIVE)
										{
											 $s = '<img src=\"'.base_url().'assets/images/inactive.png\" title=\"Inactive\">';
										}
								}
								 else if($this->session->userdata('session_user_type')=='super_admin')
								{
									if($row['status'] == STATUS_ACTIVE)
									{
										$s = '<img style=\"cursor:pointer;\" onClick=\"change_status('.$row['id'].',this);\" src=\"'.base_url().'assets/images/'.$status_image.'\" title=\"'.$title.'\">';
									}
									else
									{
										 $s = '<img src=\"'.base_url().'assets/images/'.$status_image.'\" title=\"'.$title.'\">';
									}
								}
								else
								{
									$s = '';
								}
                                    $json .= '[
                                        "'.ucfirst($row['sales_person_name']).'",
                                         "'.(($row['customer_count']==0)?$row['customer_count']:'<a href=\"'.base_url().'customers/lists/user_type/'.$row['id'].'\">'.$row['customer_count'].'</a>').'",
										"'.number_format($total_val_customer,2).'",
										 "'.(($row['supplier_count']==0)?$row['supplier_count']:'<a href=\"'.base_url().'suppliers/lists/user_type/'.$row['id'].'\">'.$row['supplier_count'].'</a>').'",
										"'.number_format($total_val_supplier,2).'",
                                         "'.(($row['phone_no']=='')?'---': $row["phone_no"]).'",
										"'.date('Y-m-d',strtotime($row['created'])).'",
                                        "'.$s.'"
                                    ],';
                        }
					
                echo '{ 
                            "recordsTotal": '.count($sales_person_list).',
                        "data":[ 
                                '.rtrim($json,",").']}';
                    exit;
		 	}
			
				public function number_unformat($number, $dec_point = '.', $thousands_sep = ',') {
          return (float)str_replace(array($thousands_sep, $dec_point),
                              array('', '.'),
                              $number);
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
