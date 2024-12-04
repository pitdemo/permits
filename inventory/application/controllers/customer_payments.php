<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : Customer_payments.php
 * Project        : Accounting Software
 * Creation Date  : 15-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the payment details
*********************************************************************************************/	
class Customer_payments extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model','payment_model','supplier_model','customer_model','notes_model'));		 // load model files
		$this->security_model->chk_admin_login(); //check user is login or not
	}
	
	public function index() // show the customer payment lists
	{
       $where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['menu'] = 'customer_payments';
		$this->load->view('customer_payment/index',$this->data);
	}
	
	 public function get_search_query($url) // get value from uri segment to manual search
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
		public function edit_payment($payment_id) // edit the payment details based on payment id
	{
			$payment_id = base64_decode($payment_id);
            $this->data['payment_details'] = $this->payment_model->get_payment_details($payment_id);
            $this->form_validation->set_rules('user_id', 'supplier/customer name', 'trim|required');
			$this->form_validation->set_rules('payment_date','Payment date', 'trim|required');
            $this->form_validation->set_rules('amount','Amount', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
                $user_id = substr($this->input->post('user_id'), 0, -2); // substring to get customer id or supplier id
                $u_type = substr($this->input->post('user_id'),-1); // get last character from the string (s or c)
                $user_type = ($u_type=='s') ? 'supplier' : 'customer';
                $payment_details = array(
                        'user_id' =>$user_id,
                        'payment_date' => $this->input->post('payment_date'),
                        'amount' => $this->input->post('amount'),
                        'user_type'=>$user_type,
                        'modified'=>date('Y-m-d H:i:s'),									
                    );			
				$this->db->where('id',$payment_id);
				$this->db->update('customer_payments',$payment_details);
                
                $notes = "The following payment id #".$payment_id." details has been modified by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                
				$this->session->set_flashdata('message','Payment details has been updated successfully.'); 
				redirect('customer_payments');
		}
			$this->data['menu']='customer_payments';
            $this->data['suppliers'] = $this->supplier_model->get_active_supplier_lists();
            $this->data['customers'] = $this->customer_model->get_active_customer_lists();
			$this->load->view('customer_payment/edit_payment',$this->data);
	}
	public function change_status()
	{
			$status = 'inactive';
			$payment_id = $this->input->post('id');		
			$item = $this->payment_model->get_payment_details($payment_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('id',$payment_id);
			$this->db->update('customer_payments',array( 'status' => $status ));
            
            $notes =  "The following payment id #".$payment_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
        
			echo $status;
	}
			
		 public function ajax_get_payment_list() // load bulk records to jquery data table using ajax
		 {
             $segment_array = $this->uri->segment_array();
             $lists = $this->payment_model->get_payment_lists($segment_array);
             $payments_list = array();
                foreach($lists as $list)
                {
                    if($list['user_type']=='supplier')
                    {
                      $supplier_details   = $this->supplier_model->get_supplier_details($list['user_id']);
                      $payments_list[$list['id']]['user_name'] = $supplier_details['supplier_name'];
                    }
                    else
                    {
                     $customer_details   = $this->customer_model->get_customer_details($list['user_id']);
                      $payments_list[$list['id']]['user_name'] = $customer_details['customer_name'];
                    }
                    $payments_list[$list['id']]['id'] = $list['id'];
                    $payments_list[$list['id']]['payment_date'] = $list['payment_date'];
                    $payments_list[$list['id']]['amount'] = $list['amount'];
                    $payments_list[$list['id']]['user_type'] = $list['user_type'];
                    $payments_list[$list['id']]['status'] = $list['status'];
                }
             
            $option = array_search('option_type',$segment_array); // print pdf option
           if($option!==FALSE)
		   {
                $option_type = $this->uri->segment($option+1);
                if($option_type=='pdf')
                {
                    $this->data['payments_list'] = $payments_list;
                    $html = $this->load->view('customer_payment/print_to_pdf',$this->data,true);
					$pdf_filename  ='payment_report.pdf';
					$this->load->library('dompdf_lib');
					$this->dompdf_lib->convert_html_to_pdf($html, $pdf_filename, true);
                }
                else if($option_type=='csv')
                {
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=payment_report.csv");
                    // Disable caching
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                    header("Pragma: no-cache"); // HTTP 1.0
                    header("Expires: 0"); // Proxies
                    $heading = array('Name','Payment ID','Payment Date','Amount','User Type','Status');
                    $this->outputCSV($payments_list,$heading);
                    exit;
                }
            }
                    
                $json = "";
                        foreach($payments_list as $row)
                        {
                                    $status_image	=	($row['status'] == STATUS_ACTIVE)?'active.png':'inactive.png';
                                    $title			=	($row['status'] == STATUS_ACTIVE)?'Change&nbsp;Inactive':'Change&nbsp;Active';
                                    $json .= '[
                                        "'.ucfirst($row['user_name']).'",
                                       
                                        "'.date('d-m-Y',strtotime($row['payment_date'])).'",
                                      
                                        "'.$row['amount'].'",
                                        "<img style=\"cursor:pointer;\" onClick=\"change_status('.$row['id'].',this);\" src=\"'.base_url().'assets/images/'.$status_image.'\" title=\"'.$title.'\">",
                                        "<div class=\"btn-group\"><a href=\"'.base_url().'customer_payments/edit_payment/'.base64_encode($row['id']).'\" class=\"btn btn-mini btn-info\" type=\"button\" title=\"Edit\"><i class=\"icon-edit bigger-120\"></i></a></div>"
                                    ],';
                        }
					
                echo '{ 
                            "recordsTotal": '.count($payments_list).',
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
	
	
	public function customer_navigation()
	{
		
		$this->data['menu'] = 'customer_payments';	
		$this->data['active_tab'] = 'general_settings';
		$this->load->view('customer_payment/customer_navigation',$this->data);
	}
	public function payment_entry() // insert daily payment_entry details 
	{
		$this->data['menu'] = 'customer_payments';
		$this->form_validation->set_rules('c_id','Customer','trim');
		if($this->form_validation->run()==TRUE)
		{
				$customers = $this->input->post('customers');
				$payment_date = $this->input->post('payment_date');
				$amounts = $this->input->post('amounts');
				
			     $ids = ''; // concatenate all the item id for stroed into notes table
				for($i=0;$i<count($customers);$i++)
				{
                    $user_id = substr($customers[$i], 0, -2);
                    $u_type = substr($customers[$i],-1);
                    $user_type = ($u_type=='s') ? 'supplier' : 'customer';
					 $payment_details = array(
                                    'user_id'=>$user_id,
                                    'payment_date'=>$payment_date[$i],
                                    'amount'=>$amounts[$i],
                                    'user_type'=>$user_type,
                                    'status'=>STATUS_ACTIVE,
                                    'created'=>date('Y-m-d H:i:s')
								);
							$this->db->insert('customer_payments',$payment_details);
                            $payment_id = $this->db->insert_id();
                            $ids .="#".$payment_id.",";
				}
            
                $notes = "The following ".rtrim($ids,",")." ids payment details have been added manually by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
            
            $this->session->set_flashdata('message','Customer payment has been inserted successfully.');
			redirect('customer_payments');
		}
		$this->load->view('customer_payment/payment_entry',$this->data);
	}
	

		public function ajax_get_active_customers() // get active suppliers from 'suppliers' table using select2 dropdown remote ajax
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
			
			
			
		
}
?>
