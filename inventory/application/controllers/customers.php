<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : customers.php
 * Project        : Accounting Software
 * Creation Date  : 3-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the customer details
*********************************************************************************************/	
class Customers extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model','customer_model','items_model','notes_model','outstanding_model'));	 // load the model files here
		$this->security_model->chk_admin_login(); // check if user is login or not
	}
	 public function index()
    {
        
        redirect('customers/lists');
        
    }
	public function lists() // sales lists
    {
       $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		
	    $where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['menu'] = 'customers';
		$this->data['persons'] = $this->customer_model->get_active_sales_person_lists();
		$this->load->view('customers/lists',$this->data);
    }
	
	 public function get_search_query($url)
	    {
		      $get = array(
					 'chk_status'=>"",
					 'chk_usertype'=>""
					 
                   
              );
            
            $status = array_search('status',$this->uri->segment_array());
            $user_type = array_search('user_type',$this->uri->segment_array());
           // $date_from = array_search('start',$this->uri->segment_array());
          //  $date_end = array_search('end',$this->uri->segment_array());
            
            if($status!==FALSE)
            {
                $get['chk_status'] = $this->uri->segment($status+1);	
            }

            if($user_type!==FALSE)
            {
                $get['chk_usertype'] = $this->uri->segment($user_type+1);	
            }

           /* if($date_from!==FALSE)
            {
                $get['chk_start_date'] = $this->uri->segment($date_from+1);	
            }

             if($date_end!==FALSE)
            {
                $get['chk_end_date'] = $this->uri->segment($date_end+1);	
            }*/
            
                return array($get);
        }
	
	 public function ajax_get_active_salesperson() // get active expenses_category from 'expenses_category' table using select2 dropdown remote ajax
		{
	
			$search_key=($this->input->get('q')) ? $this->input->get('q') : '';
			$this->db->select('id,sales_person_name');
			
			$this->db->from('sales_person_tbl');
		
			if($search_key)
			{
					$where_condition="(sales_person_name LIKE '%".$search_key."%') AND status ='".STATUS_ACTIVE."'";
			}
			
			$this->db->where($where_condition);
			
			$query=$this->db->get();
            
            
            //end
			
			$arr=array();
			
			foreach($query->result_array() as $item) // expenses list
			{
				$arr[]=array(
					'internal'=>$item['sales_person_name'],
					'id'=>$item['id'].'-s'
					);
			}
            
           
			echo json_encode($arr,true);
			
			exit;
			}
			
	 public function create_customer() // insert daily expenses entry details 
	{
		//echo $this->session->userdata('session_user_type');exit;
		$this->data['menu'] = 'customers';
		$this->form_validation->set_rules('e_id','Customer','trim');
		  if($this->session->userdata('session_user_type')!='viewer')
		 {
		if($this->form_validation->run()==TRUE)
		{
				$persons = $this->input->post('persons');
				$customer_name = $this->input->post('customers');
				$email_ids = $this->input->post('email_ids');
				$address = $this->input->post('cus_add');
				$phone_nos = $this->input->post('phone_no');
				
			     $ids = ''; // concatenate all the expense id for stroed into notes table
				for($i=0;$i<count($persons);$i++)
				{
                    $sales_person_id = substr($persons[$i], 0, -2);
					$customer_details = array(
                                    'sales_person_id'=>$sales_person_id,
									 'customer_name'=>$customer_name[$i],
                                    'email_id'=>$email_ids[$i],
									//'address'=>$address[$i],
									'address'=>($address[$i]) ? $address[$i] : NULL,
                                    'phone_no'=>$phone_nos[$i],
                                    'status'=>STATUS_ACTIVE,
                                    'created'=>date('Y-m-d H:i:s')
								);
							$this->db->insert('customers',$customer_details);
                            $expense_id = $this->db->insert_id();
                            $ids .="#".$expense_id.",";
				}
            
                $notes = "The following ".rtrim($ids,",")." ids expense details have been added manually by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
            
            $this->session->set_flashdata('message','customer details has been inserted successfully.');
			redirect('customers/lists');
		}
		$this->load->view('customers/create_customer',$this->data);
		 }
	}
   
	 public function customer_general_settings($customer_id) // get the particular customer personal details
	{
	$this->data['customer_details'] = $this->customer_model->get_customer_details(base64_decode($customer_id));
	    $this->data['customer_id']=$customer_id;
		$this->data['menu'] = 'customers';	
		$this->data['active_tab'] = 'general_settings';
		$this->load->view('customers/customer_general_settings',$this->data);
	}  
	
	 public function payments($customer_id) // get the particular customer payment details
	{
		$this->data['customer_id']=$customer_id;
		$this->data['customer_details'] = $this->customer_model->get_customer_details(base64_decode($customer_id));
		$this->data['menu'] = 'customers';	
		$this->data['active_tab'] = 'payments';
		$this->load->view('customers/payments',$this->data);
	} 
	public function transactions($customer_id) // get the particular customer transaction details(sales and purchase)
	{
		 $where = $this->get_search_query_transaction($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['customer_id']=$customer_id;
	    $this->data['customer_details'] = $this->customer_model->get_customer_details(base64_decode($customer_id));
		$this->data['menu'] = 'customers';	
		$this->data['active_tab'] = 'transactions';
 		$this->load->view('customers/transactions',$this->data);
	} 
	public function get_search_query_graph($url)
	    {
		      $get = array(
					'chk_daytype'=>"",
                    'chk_start_date'=>"",
                    'chk_end_date'=>""
              );
            $day_type = array_search('day_type',$this->uri->segment_array());
            $date_from = array_search('start',$this->uri->segment_array());
            $date_end = array_search('end',$this->uri->segment_array());
            if($day_type!==FALSE)
            {
                $get['chk_daytype'] = $this->uri->segment($day_type+1);	
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
	public function graph($customer_id) // get the particular customer transaction details(sales and purchase)
	{
		 $where = $this->get_search_query_graph($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['customer_id']=$customer_id;
	    $this->data['customer_details'] = $this->customer_model->get_customer_details(base64_decode($customer_id));
		$this->data['menu'] = 'customers';	
		$this->data['active_tab'] = 'graph';
 		$this->load->view('customers/graph_customer',$this->data);
	} 
	
		public function number_unformat($number, $dec_point = '.', $thousands_sep = ',') {
          return (float)str_replace(array($thousands_sep, $dec_point),
                              array('', '.'),
                              $number);
           }
		public function ajax_get_customer_graph($customer_id) // get the particular customer transaction details(sales and purchase)
	{
		 $segment_array = $this->uri->segment_array();
		$this->data['customer_id']=$customer_id;
		$value = $this->customer_model->get_customer_history(base64_decode($customer_id),$segment_array);
		//print_r($value);exit;
				if ($value == NULL) {
		echo json_encode('No record found');
		} else
		{
		 
		$category = array();
		$category['name'] = 'Date';
		
		$series1 = array();
		$series1['name'] = 'Sales';
		
		$series2 = array();
		$series2['name'] = 'Purchase';
		
		$series3 = array();
		$series3['name'] = 'Profit';
		
		 $graph_list = array();
                foreach($value as $list)
                {
                    $graph_list[$list['id']]['id'] = $list['id'];
                    $graph_list[$list['id']]['date'] = $list['date'];
                    $graph_list[$list['id']]['amount'] = $list['amount'];
                    $graph_list[$list['id']]['record_type'] = $list['record_type'];
                }
		
		
	foreach($graph_list as $row) {
			
			$purchase=$sales=$profit=0;
			 switch($row['record_type'])
            {
                case 'S':
                    $record_type='Sales';
					$sales = $sales + $this->number_unformat($row['amount'],2);
                    break;
			    case 'P':
                    $record_type='Purchase';
					$purchase = $purchase + $this->number_unformat($row['amount'],2);
                    break;
			 
            }
			
			
		 $profit = $sales - $purchase;
		// print_r($sales);exit;
			$category['data'][] = $row['date'];
			$series1['data'][] = $sales;
			$series2['data'][] = $purchase;
			$series3['data'][] = $profit;   
			
			$result = array();
		array_push($result,$category);
		array_push($result,$series1);
		array_push($result,$series2);
		array_push($result,$series3);
			
		}
		
		print json_encode($result, JSON_NUMERIC_CHECK);
		 
		}
	
	} 
	
	 public function get_search_query_transaction($url)
	    {
		      $get = array(
					'chk_recordtype'=>"",
                    'chk_start_date'=>"",
                    'chk_end_date'=>""
              );
            $record_type = array_search('record_type',$this->uri->segment_array());
            $date_from = array_search('start',$this->uri->segment_array());
            $date_end = array_search('end',$this->uri->segment_array());
            if($record_type!==FALSE)
            {
                $get['chk_recordtype'] = $this->uri->segment($record_type+1);	
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
	public function edit_customer($customer_id) // edit the existing customer details
	{
			$customer_id = base64_decode($customer_id);
			$this->data['customer_details'] = $this->customer_model->get_customer_details($customer_id);
            // form validation
			 $this->form_validation->set_rules('sales_person_id', 'sales_person name', 'trim|required');
			$this->form_validation->set_rules('customer_name', 'Customer name', 'trim|required');
			$this->form_validation->set_rules('email_id','Email', 'trim|valid_email');
			$this->form_validation->set_rules('phone_no','Phone no', 'trim|integer|max_length[10]');
			$this->form_validation->set_rules('address','address', 'trim');
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
				 $sales_person_id = substr($this->input->post('sales_person_id'), 0, -2); // substring to get category id
				$customer_details = array(
										'sales_person_id' =>$sales_person_id,
										'customer_name' => strip_tags($this->input->post('customer_name')),
										'email_id' => ($this->input->post('email_id')) ? $this->input->post('email_id')  : NULL,
										'phone_no' => ($this->input->post('phone_no')) ? $this->input->post('phone_no')  : NULL,
										'address' => ($this->input->post('address')) ? nl2br($this->input->post('address'))  : NULL,
										'modified'=>date('Y-m-d H:i:s'),									
									);			
				$this->db->where('id',$customer_id);
				$this->db->update('customers',$customer_details); // update the customer details
                
                $notes = "The following customer id #".$customer_id." details has been modified by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                
				$this->session->set_flashdata('message','Customer details has been updated successfully.'); 
				redirect('customers/lists');
		   }
			$this->data['menu']='customers';
			$this->data['sales_persons'] = $this->customer_model->get_active_sales_person_lists();
			$this->load->view('customers/edit_customer',$this->data);
	}
	public function change_status() // change the customer status active or inactive using ajax
	{
			$status = 'inactive';
			$customer_id = $this->input->post('customer_id');		
			$item = $this->customer_model->get_customer_details($customer_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('id',$customer_id);
			$this->db->update('customers',array( 'status' => $status ));
            
            $notes =  "The following customer id #".$customer_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			echo $status;
	}
	public function delete_item() // delete the customer details
	{
			$customer_id = $this->input->post('customer_id');
			
			$this->db->where('id',$customer_id);
			$this->db->update('customers',array('status'=>'deleted'));
            $notes =  "The following customer id #".$customer_id." status(deleted) has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
			$this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			
	}
	public function bulk_insert() // bulk import customer details using .csv file
	{
			$this->data['menu'] = 'customers';
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
								if(count($csv_array[0])==4)
                                {
								foreach ($csv_array as $row)
								{
										$customer_details = array(
										'customer_name'=>($row['CUSTOMER NAME']) ? $row['CUSTOMER NAME'] : '' ,
										'email_id'=>($row['EMAIL ID']) ? $row['EMAIL ID'] : NULL,
										'phone_no'=>($row['PHONE NO']) ? $row['PHONE NO'] :NULL,
										'address'=>($row['ADDRESS']) ? nl2br($row['ADDRESS']) : NULL,
										'status'=>STATUS_ACTIVE,
										'created'=>date('Y-m-d H:i:s')
																	);
										$this->db->insert('customers',$customer_details);
       	 	                      }
                            $notes =  "The csv file ".$file_data['file_name']." have been imported by ".$this->session->userdata('session_username')." in the customer module on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                             $notes_arr = array(
                                'user_id'=>$this->session->userdata('user_id'),
                                'notes'=>$notes,
                                'created'=> date('Y-m-d H:i:s')
                             );
                            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
  						    $this->session->set_flashdata('message','Customer details has been inserted successfully.');
							redirect('customers');
					}
					else{
							$this->session->set_flashdata('error_message','File column names should not match. Please check the CSV file');
							redirect('customers');
						}
					}
				}
			}
		$this->load->view('customers/bulk_insert',$this->data);
	}
		public function check_attachment() // callback validation for check the attachment extension
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
		public function ajax_get_customers() // load bulk records to jquery data table using ajax
		{
			$this->data['customers'] = $this->customer_model->ajax_get_customers_list();
		}
		 public function ajax_get_customers_list() // load bulk records to jquery data table using ajax
		 {
             $segment_array = $this->uri->segment_array();
            $lists = $this->customer_model->get_customers_lists($segment_array);
			$seg_url = array_search('user_type',$segment_array);
             $sales_list = array();
                foreach($lists as $list)
                {
                     $person_details = $this->customer_model->get_sales_person_details($list['sales_person_id']);
					$sales_list[$list['id']]['id'] = $list['id'];
                    $sales_list[$list['id']]['customer_name'] = $list['customer_name'];
					 $sales_list[$list['id']]['sales_person_name'] = $person_details['sales_person_name'];
                   //  $sales_list[$list['id']]['email_id'] = $list['email_id'];
                    $sales_list[$list['id']]['phone_no'] = $list['phone_no'];
                  //  $sales_list[$list['id']]['address'] = $list['address'];
				   // $sales_list[$list['id']]['address'] = preg_replace( "/\r|\n|\\|/", "", $list['address']);
					$sales_list[$list['id']]['outstanding'] = $list['outstanding'];
                    $sales_list[$list['id']]['status'] = $list['status'];
                }
             
            $option = array_search('option_type',$segment_array); // print pdf option
           if($option!==FALSE)
		   {
                $option_type = $this->uri->segment($option+1);
                if($option_type=='pdf')
                {
                    $this->data['sales_list'] = $sales_list;
                    $html = $this->load->view('sales/print_to_pdf',$this->data,true);
					$pdf_filename  ='sales_report.pdf';
					$this->load->library('dompdf_lib');
					$this->dompdf_lib->convert_html_to_pdf($html, $pdf_filename, true);
                }
                else if($option_type=='csv')
                {
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=customer_report.csv");
                    // Disable caching
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                    header("Pragma: no-cache"); // HTTP 1.0
                    header("Expires: 0"); // Proxies
                    $heading = array('Customer ID','Name','Sales Person','Contact No','Outstanding','Status');
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
                                         "'.$row['id'].'",
										 "<a href=\"'.base_url().'customers/transactions/'.base64_encode($row['id']).'\">'.(ucfirst($row['customer_name']=='')?'---': ucfirst($row["customer_name"])).'</a>",
										 "'.(($row['sales_person_name']=='')?'---': $row["sales_person_name"]).'",
                                      	"<a href=\"'.base_url().'customers/outstanding_report/'.base64_encode($row['id']).'\">'.(($row['outstanding']==0)?'0': number_format($row["outstanding"],2)).'</a>",

                                      "'.(($row['phone_no']=='')?'---': $row["phone_no"]).'",
									  
                                 "<img style=\"cursor:pointer;\" onClick=\"change_status('.$row['id'].',this);\" src=\"'.base_url().'assets/images/'.$status_image.'\" title=\"'.$title.'\">",
                            "<div class=\"btn-group\"><a href=\"'.base_url().'customers/edit_customer/'.base64_encode($row['id']).'\" class=\"btn btn-mini btn-info\" type=\"button\" title=\"Edit\"><i class=\"icon-edit bigger-120\"></i></a><button type=\"button\" style=\"cursor:pointer;\" onClick=\"delete_item('.$row['id'].',this);\" class=\"btn btn-mini btn-danger\" title=\"Delete\"><i class=\"icon-trash bigger-120\"></i></button></div>"
                        ],';
                    }
					
                echo '{ 
                            "recordsTotal": '.count($sales_list).',
                        "data":[ 
                                '.rtrim($json,",").']}';
                    exit;
		 	}
		 public function ajax_get_customer_settings($customer_id)  // get customer based on details
        {
			$customer_id = base64_decode($customer_id);
		    $lists = $this->customer_model->get_customer_general_settings($customer_id);
		
           $json = "";
                        foreach($lists as $row)
                        {
                            $json .= '[
                               "'.$row['id'].'",
                               "'.ucfirst($row['customer_name']).'",
                                "'.(($row['email_id']=='')?'---': $row["email_id"]).'",
                                 "'.(($row['phone_no']=='')?'---': $row["phone_no"]).'",
								  "'.(($row['address']=='')?'---': $row["address"]).'"
                            ],';
                        }
					
                echo '{ 
                            "recordsTotal": '.count($lists).',
                        "data":[ 
                                '.rtrim($json,",").']}';
                    exit;
        }
     
	 public function ajax_get_customer_payment_details($customer_id)  // get customers payment details based on customer id
    {
        $customer_id = base64_decode($customer_id);
        $lists = $this->customer_model->get_customer_payments($customer_id);
        $payments_list = array();
            foreach($lists as $list)
            {
                $customer_details   = $this->customer_model->get_customer_details($list['user_id']);
                $payments_list[$list['id']]['receipt_date'] = $list['receipt_date'];
                $payments_list[$list['id']]['amount'] = $list['amount'];
                $payments_list[$list['id']]['attachment'] = $list['attachment'];
            }
            $json = "";
                    foreach($payments_list as $row)
                    {
                       $json .= '[
                                    "'.date('d-m-Y',strtotime($row['receipt_date'])).'",
                                    "'.$row['amount'].'",
                                     "<a href=\"'.base_url().'receipts/download/'.$row['attachment'].'\">'.$row['attachment'].'</a>"
                        ],';
                    }

            echo '{ 
                        "recordsTotal": '.count($payments_list).',
                    "data":[ 
                            '.rtrim($json,",").']}';
                exit;
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
public function ajax_get_customer_transactions_history($customer_id=NULL) // get customer transaction history both sales and purchase
		 {
             $segment_array = $this->uri->segment_array();
             $customer_id = base64_decode($customer_id);
			 $lists = $this->customer_model->get_transactions_history_credit_debit($customer_id,$segment_array);
			 $amount='';
             $transaction_list = array();
                foreach($lists as $list)
                {
                    
                    $transaction_list[$list['id']]['id'] = $list['id'];
					$transaction_list[$list['id']]['r_remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['r_remarks']);
					$transaction_list[$list['id']]['s_remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['s_remarks']);
					$transaction_list[$list['id']]['l_remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['l_remarks']);
					$transaction_list[$list['id']]['p_remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['p_remarks']);
					$transaction_list[$list['id']]['item_id'] = $list['item_id'];
                    $transaction_list[$list['id']]['date'] = $list['date'];
                    $transaction_list[$list['id']]['qty_in'] = $list['qty_in'];
					$transaction_list[$list['id']]['qty_out'] = $list['qty_out'];
					$item_details = $this->items_model->get_item_details($list['item_id']);
					$transaction_list[$list['id']]['item_name'] = $item_details['item_name'];
                    $transaction_list[$list['id']]['history_amount'] = $list['history_amount'];
                    $transaction_list[$list['id']]['record_type'] = $list['record_type'];
                }
             $option = array_search('option_type',$segment_array); // print pdf option
           if($option!==FALSE)
		   {
                $option_type = $this->uri->segment($option+1);
                if($option_type=='pdf')
                {
                    $this->data['transaction_list'] = $transaction_list;
                    $html = $this->load->view('transaction/print_to_pdf',$this->data,true);
					$pdf_filename  ='sales_report.pdf';
					$this->load->library('dompdf_lib');
					$this->dompdf_lib->convert_html_to_pdf($html, $pdf_filename, true);
                }
                else if($option_type=='csv')
                {
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=sales_report.csv");
                    // Disable caching
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                    header("Pragma: no-cache"); // HTTP 1.0
                    header("Expires: 0"); // Proxies
                    $heading = array('Item Name','Date','Quantity','Amount','Record Type');
                    $this->outputCSV($transaction_list,$heading);
                    exit;
                }
            }
		
                $json = "";
                        foreach($transaction_list as $row)
                        {
                      $amount_debit=$amount_credit='';
                       $qty='';
						switch($row['record_type'])
						{
							case 'P':
								$record_type='Purchase';
								$amount_credit = $row['history_amount'];
								$remarks =  $row['p_remarks'];
								$qty = ($row['qty_in']) ? $row['qty_in'] : '-';
								break;
							case 'S':
								$record_type='Sales';
								$amount_debit = $row['history_amount'];
								$remarks =  $row['s_remarks'];
								$qty = ($row['qty_out']) ? $row['qty_out'] : '-';
								break;
							case 'M':
								$record_type='Manufacture';
								break;
							case 'PR':
								$record_type='<b>Purchase Return</b>';
								$amount_debit = $row['history_amount'];
								$remarks =  $row['p_remarks'];
								$qty = ($row['qty_out']) ? $row['qty_out'] : '-';
								break;
							case 'SR':
								$record_type='<b>Sales Return</b>';
								$amount_credit = $row['history_amount'];
								$remarks =  $row['s_remarks'];
								$qty = ($row['qty_in']) ? $row['qty_in'] : '-';
								break;
						   case 'R':
								$record_type='<b>Payment</b>';
								$amount_credit = $row['history_amount'];
								$remarks =  $row['r_remarks'];
								break;
						   case 'RR':
								$record_type='<b>Payment Return</b>';
								$amount_debit = $row['history_amount'];
								$remarks =  $row['r_remarks'];
								break;
						 case 'LD':
								$record_type='<b>Debit</b>';
								$amount_debit = $row['history_amount'];
								$remarks =  $row['l_remarks'];
								break;
						 case 'LC':
								$record_type='<b>Credit</b>';
								$amount_credit = $row['history_amount'];
								$remarks =  $row['l_remarks'];
								break;
						 case 'LDR':
								$record_type='<b>Debit Return</b>';
								$amount_credit = $row['history_amount'];
								$remarks =  $row['l_remarks'];
								break;
						 case 'LCR':
								$record_type='<b>Credit Return</b>';
								$amount_debit = $row['history_amount'];
								$remarks =  $row['l_remarks'];
								break;
				  }
                            $qty_in=($row['qty_in']) ? $row['qty_in'] : '-';
                            $qty_out=($row['qty_out']) ? $row['qty_out'] : '-';
                            $json .= '[
                                "'.ucfirst($row['item_name']).'",
                                "'.date('d-m-Y',strtotime($row['date'])).'",
                                 "'.(($qty==0)?'0': $qty).'",
								 "'.(($amount_credit==0)?'0': $amount_credit).'",
								  "'.(($amount_debit==0)?'0': $amount_debit).'",
								  "'.(($remarks=='')?'---': str_replace('"', '\"', $remarks)).'",
                                "'.$record_type.'"
                            ],';
                        }
					
                  $record = array_search('record_type',$segment_array); // print pdf option
					//echo $json;exit;			
								
		
			echo '{ 
					"recordsTotal": '.count($transaction_list).',
					"data":[ 
						'.rtrim($json,",").']
					}';
        
        
                    exit;
		 	}
  
	public function get_search_query_outstanding($url)
	    {
		      $get = array(
					'chk_recordtype'=>"",
                    'chk_start_date'=>"",
                    'chk_end_date'=>""
              );
            $record_type = array_search('record_type',$this->uri->segment_array());
            $date_from = array_search('start',$this->uri->segment_array());
            $date_end = array_search('end',$this->uri->segment_array());
            if($record_type!==FALSE)
            {
                $get['chk_recordtype'] = $this->uri->segment($record_type+1);	
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
	public function outstanding_report($customer_id) // get the particular customer transaction details(sales and purchase)
	{
		 $where = $this->get_search_query_outstanding($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['customer_id']=$customer_id;
	    $this->data['customer_details'] = $this->customer_model->get_customer_details(base64_decode($customer_id)); 
		$outstanding = $this->data['customer_details']['outstanding'];
		$lists = $this->outstanding_model->get_customer_history(base64_decode($customer_id));
		$this->data['menu'] = 'customers';
		$this->data['active_tab'] = 'outstanding';
		$sales_lastthiry=$sales_thirytosixty=$sales=$sales_return=$sales_sixtytoninety=$sales_ninetytoonetwenty=$sales_aboveonetwenty=0;
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
							case 'PR':
								$record_type='<b>Purchase Return</b>';
								break;
							case 'SR':
								$record_type='<b>Sales Return</b>';
								break;
						   case 'R':
								$record_type='<b>Payment</b>';
								break;
						   case 'RR':
								$record_type='<b>Payment Return</b>';
								break;
						case 'LC':
								$record_type='<b>Credit</b>';
								break;
						case 'LCR':
								$record_type='<b>Credit Return</b>';
								break;
						case 'LD':
								$record_type='<b>Debit</b>';
								break;
						case 'LDR':
								$record_type='<b>Debit Return</b>';
								break;
				  }
                           
						
						 $today = date('Y-m-d'); //2015-10-20
			             $lastthiryday = date('Y-m-d', strtotime('-30 days', strtotime($today)));  //2015-09-20
						 $thirytosixty = date('Y-m-d', strtotime('-60 days', strtotime($today)));  // 2015-08-21
						 $sixtytoninety = date('Y-m-d', strtotime('-90 days', strtotime($today)));  // 2015-07-22
						 $ninetytoonetwenty = date('Y-m-d', strtotime('-120 days', strtotime($today)));  // 2015-06-22  
							 
							
						
							if ($row['date'] > $lastthiryday && $row['date'] <= $today)
							{
							    if($row['record_type']=='S' || $row['record_type']=='LD')
                                    $sales_lastthiry= $sales_lastthiry + $this->number_unformat($row['amount']); //add amount for sales
								else if($row['record_type']=='SR'  || $row['record_type']=='LDR')
                                    $sales_lastthiry= $sales_lastthiry - $this->number_unformat($row['amount']); //decrese amount for sales return
							}
							
						    if (($row['date'] > $thirytosixty) && ($row['date'] <= $lastthiryday))
							{
								if($row['record_type']=='S' || $row['record_type']=='LD')
                                    $sales_thirytosixty= $sales_thirytosixty + $this->number_unformat($row['amount']); //add amount for sales
								else if($row['record_type']=='SR'  || $row['record_type']=='LDR')
                                    $sales_thirytosixty= $sales_thirytosixty - $this->number_unformat($row['amount']); //decrese amount for sales return
							}
							 
							 if (($row['date'] > $sixtytoninety) && ($row['date'] <= $thirytosixty))
							{
								if($row['record_type']=='S' || $row['record_type']=='LD')
                                    $sales_sixtytoninety= $sales_sixtytoninety + $this->number_unformat($row['amount']); //add amount for sales
								else if($row['record_type']=='SR'  || $row['record_type']=='LDR')
                                    $sales_sixtytoninety= $sales_sixtytoninety - $this->number_unformat($row['amount']); //decrese amount for sales return
							}
							 if (($row['date'] > $ninetytoonetwenty) && ($row['date'] <= $sixtytoninety))

							{
								if($row['record_type']=='S' || $row['record_type']=='LD')
                                    $sales_ninetytoonetwenty= $sales_ninetytoonetwenty + $this->number_unformat($row['amount']); //add amount for sales
								else if($row['record_type']=='SR'  || $row['record_type']=='LDR')
                                    $sales_ninetytoonetwenty= $sales_ninetytoonetwenty - $this->number_unformat($row['amount']); //decrese amount for sales return
							}
							if (($row['date'] <= $ninetytoonetwenty) )

							{
								
								if($row['record_type']=='S' || $row['record_type']=='LD')
                                    $sales_aboveonetwenty= $sales_aboveonetwenty + $this->number_unformat($row['amount']); //add amount for sales
							else if($row['record_type']=='SR'  || $row['record_type']=='LDR')
                                    $sales_aboveonetwenty= $sales_aboveonetwenty - $this->number_unformat($row['amount']); //decrese amount for sales return
							}
							
						}
					       
							 if( $outstanding != 0)
							  {
							  if($sales_lastthiry ==  $outstanding)
							  {
								 $sales_lastthiry = $sales_lastthiry ;
								 $sales_thirytosixty = 0;
								
							  }
							 else if($sales_lastthiry >  $outstanding && $sales_lastthiry != 0)
							  {
								$sales_lastthiry =  $outstanding;
								
							  }
							  
		  					}
		  
		  // sales_thirytosixty
		  if(($sales_lastthiry + $sales_thirytosixty) ==   $outstanding)
	 	  {
			 $sales_thirytosixty = $sales_thirytosixty;
			 $sales_sixtytoninety = 0;
		  }
		  
		  else if(( ($sales_lastthiry + $sales_thirytosixty) <  $outstanding) && $sales_thirytosixty != 0)
		  {
      		   $sales_thirytosixty =$sales_thirytosixty;
			  // $sales_thirytosixty =  $outstanding - ($sales_lastthiry + $sales_thirytosixty) ;
		  }
		  
		  else if( ($sales_lastthiry + $sales_thirytosixty) >  $outstanding)
		  {
			 $sales_thirytosixty =  $outstanding -($sales_lastthiry) ;
			
		  }
		  
		  
		   
		  //sales_sixtytoninety
		 if(($sales_lastthiry + $sales_thirytosixty + $sales_sixtytoninety) ==  $outstanding)
	 	  {
			 
			 $sales_sixtytoninety = $sales_sixtytoninety;
			 $sales_ninetytoonetwenty = 0;
		  }
		  
		  else if( (( $sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety) <  $outstanding) && $sales_sixtytoninety != 0)
		  {
			  #$sales_sixtytoninety1 =  $outstanding - ($sales_lastthiry + $sales_thirytosixty +$sales_sixtytoninety) ;
			  $sales_sixtytoninety = $sales_sixtytoninety;
		  }
		  
		  else if( ($sales_lastthiry + $sales_thirytosixty +$sales_sixtytoninety) >  $outstanding)
		  {
			 $sales_sixtytoninety=  $outstanding -($sales_lastthiry + $sales_thirytosixty) ;
			 
		  } 
		  
		  //sales_ninetytoonetwenty
			if(($sales_lastthiry + $sales_thirytosixty + $sales_sixtytoninety + $sales_ninetytoonetwenty) ==   $outstanding)
			  {
				 $sales_ninetytoonetwenty = $sales_ninetytoonetwenty;
				 $sales_aboveonetwenty=0;
			  }
		  
			 else if(( ($sales_lastthiry + $sales_thirytosixty + $sales_sixtytoninety +$sales_ninetytoonetwenty) <  $outstanding) && $sales_ninetytoonetwenty != 0)
			  {
				
				$sales_ninetytoonetwenty = $sales_ninetytoonetwenty;
		       # $sales_aboveonetwenty =  $outstanding -($sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety+$sales_ninetytoonetwenty) ;

			  }
			  
			  else if( ($sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety +$sales_ninetytoonetwenty) >  $outstanding)
			  {
				
				 $sales_ninetytoonetwenty=  $outstanding -($sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety ) ;
				 
			  }
			  
			  
			   //sales_aboveonetwenty
			if(($sales_lastthiry + $sales_thirytosixty + $sales_sixtytoninety + $sales_ninetytoonetwenty + $sales_aboveonetwenty) ==   $outstanding)
			  {
				 $sales_aboveonetwenty = $sales_aboveonetwenty;
			  }
		  
			 else if(( ($sales_lastthiry + $sales_thirytosixty + $sales_sixtytoninety +$sales_ninetytoonetwenty + $sales_aboveonetwenty) <  $outstanding) && $sales_aboveonetwenty != 0)
			  {
				$sales_aboveonetwenty = $sales_aboveonetwenty;
				
			  }
			  
			  else if( ($sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety +$sales_ninetytoonetwenty + $sales_aboveonetwenty) >  $outstanding)
			  {
				
				 $sales_aboveonetwenty =  $outstanding - ($sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety +$sales_ninetytoonetwenty) ;
				
				 
			  }
							 
							 $this->data['sales_lastthiry']=$sales_lastthiry;
							 $this->data['sales_thirytosixty']=$sales_thirytosixty;
							 $this->data['sales_sixtytoninety']=$sales_sixtytoninety;
							 $this->data['sales_ninetytoonetwenty']=$sales_ninetytoonetwenty;
							 $this->data['sales_aboveonetwenty']=$sales_aboveonetwenty;
							
								
 		$this->load->view('customers/outstanding',$this->data);
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
							0 =>'customers_table.id', 
							1 => 'customers_table.customer_name',
							2 => 'sales_table.sales_person_name',
							3 => 'customers_table.created',
							4 => 'customers_table.outstanding',
							5 => 'customers_table.phone_no',
							6 => 'customers_table.status',
							7 => 'action',
						);
					
			$delete ='active';
					$where_condition='';
		$segment_array = $this->uri->segment_array();
		/////////////DEFAULT SEARCH//////////////////////////////
		if( !empty($requestData['search']['value']))
		{  
			$search_value = trim($requestData['search']['value']);
			$where_condition.= "(customers_table.id LIKE '%".$search_value."%' OR customers_table.customer_name LIKE '%".$search_value."%' OR sales_table.sales_person_name LIKE '%".$search_value."%' OR customers_table.outstanding LIKE '%".$search_value."%' OR customers_table.phone_no LIKE '%".$search_value."%' OR customers_table.created LIKE '%".$search_value."%' OR customers_table.status LIKE '%".$search_value."%' ) AND ";
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
		/////////////SEARCH USERTYPE//////////////////////////////
		$user_keyword = array_search('user_type',$segment_array);
		if ($user_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($user_keyword+1);
			if($keyword!='')
			$where_condition.="(sales_table.id IN (".$keyword.")) AND" ;
		} 
		/////////////SEARCH USERTYPE//////////////////////////////
		$where_condition.="(customers_table.status='".$delete."') ";
		/////////////////TOTAL RECORD COUNT////////////////
		$this->db->select('customers_table.id, 
							customers_table.customer_name,
							customers_table.sales_person_id,
							sales_table.id  AS tid,
							sales_table.sales_person_name,
							customers_table.outstanding,
							customers_table.email_id,
							customers_table.phone_no,
							customers_table.created,
							customers_table.address,
							customers_table.status');
		$this->db->from('customers customers_table');
		$this->db->join('sales_person_tbl sales_table', 'sales_table.id=customers_table.sales_person_id', 'left');
		//$this->db->join('suppliers suppliers_table', 'suppliers_table.id=purchases_table.user_id', 'left');
		
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
		$this->db->select('customers_table.id, 
							customers_table.customer_name,
							customers_table.sales_person_id,
							sales_table.id AS tid,
							sales_table.sales_person_name,
							customers_table.outstanding,
							customers_table.email_id,
							customers_table.created,
							customers_table.phone_no,
							customers_table.address,
							customers_table.status');
		$this->db->from('customers customers_table');
		$this->db->join('sales_person_tbl sales_table', 'sales_table.id=customers_table.sales_person_id', 'left');
		
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
