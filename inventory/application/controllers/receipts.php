<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : receipts.php
 * Project        : Accounting Software
 * Creation Date  : 8-07-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the receipts details
*********************************************************************************************/	
class Receipts extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model','customer_model','items_model','notes_model','receipt_model','supplier_model'));	 // load the model files here
		$this->security_model->chk_admin_login(); // check if user is login or not
	}

	public function index() // show the receipts list
    {
       
	    redirect('receipts/lists');
    }
	public function lists() // sales lists
    {
        $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		
		$where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['menu'] = 'receipts';
		$this->data['persons'] = $this->customer_model->get_active_sales_person_lists();
		$this->load->view('receipts/lists',$this->data);
    }
    public function receipts_entry() // this function used to load receipt entry form and stored into 'receipts' table
    {
        $this->data['menu'] = 'receipts';
        $this->form_validation->set_rules('r_id','Receipts','trim');
		if($this->session->userdata('session_user_type')!='viewer')
		 {
        if($this->form_validation->run()==TRUE) // if form validation is true and insert all the details into receipts table
        {
            $this->load->library('upload');
            $config['upload_path'] ='./uploads';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            $suppliers = $this->input->post('suppliers');
            $receipt_date = $this->input->post('receipt_date');
            $amounts = $this->input->post('amounts');
			$remarks = $this->input->post('remarks');
            $ids = ''; // concatenate all the receipt id for stroed into notes table
            
            for($i=0;$i<count($suppliers);$i++)
            {
                $attachment_name='';
                if($_FILES['attachments']['name'][$i] !='')
                {
                   if(move_uploaded_file($_FILES['attachments']['tmp_name'][$i],'./uploads/receipts/'.$_FILES['attachments']['name'][$i]))
                   {
                       $attachment_name = $_FILES['attachments']['name'][$i];
                   }
                }
                $user_id = substr($suppliers[$i], 0, -2);
                $u_type = substr($suppliers[$i],-1);
                $user_type = ($u_type=='s') ? 'supplier' : 'customer';
                $receipt_details = array(
                                'user_id'=>$user_id,
                                'receipt_date'=>$receipt_date[$i],
                                'amount'=>$amounts[$i],
								'remarks'=>($remarks[$i]) ? $remarks[$i] : NULL,
                                'attachment'=> ($attachment_name) ? $attachment_name : NULL,
                                'user_type'=>$user_type,
                                'status'=>STATUS_ACTIVE,
                                'created'=>date('Y-m-d H:i:s')
                         );
                $this->db->insert('receipts',$receipt_details);
                $last_id = $this->db->insert_id();
                $ids .="#".$last_id.",";
            }
           
             $notes = "The following ".rtrim($ids,",")." receipts id entry have been added manually by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
             $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
            $this->session->set_flashdata('message','Receipts details has been inserted successfully.');
            redirect('receipts');
            
        }
        $this->load->view('receipts/receipts_entry',$this->data);
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
    public function ajax_get_receipt_list() // load bulk records to jquery data table using ajax
     {
         $segment_array = $this->uri->segment_array();
         $lists = $this->receipt_model->get_receipt_lists($segment_array);
         $receipt_list = array();
            foreach($lists as $list)
            {
                if($list['user_type']=='supplier')
                {
                  $supplier_details   = $this->supplier_model->get_supplier_details($list['user_id']);
                  $receipt_list[$list['id']]['user_name'] = $supplier_details['supplier_name'];
                }
                else
                {
                 $customer_details   = $this->customer_model->get_customer_details($list['user_id']);
                  $receipt_list[$list['id']]['user_name'] = $customer_details['customer_name'];
                }
                $receipt_list[$list['id']]['id'] = $list['id'];
                $receipt_list[$list['id']]['receipt_date'] = $list['receipt_date'];
                $receipt_list[$list['id']]['amount'] = $list['amount'];
			    // $receipt_list[$list['id']]['remarks'] = $list['remarks'];
				$receipt_list[$list['id']]['remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['remarks']);
                $receipt_list[$list['id']]['user_type'] = $list['user_type'];
                $receipt_list[$list['id']]['attachment'] = $list['attachment'];
                $receipt_list[$list['id']]['status'] = $list['status'];
            }
            $json = "";
                    foreach($receipt_list as $row)
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
                                    "'.$row['amount'].'",
                                    "<a href=\"'.base_url().'receipts/download/'.$row['attachment'].'\">'.$row['attachment'].'</a>",
                                    "'.ucfirst($row['user_type']).'",
                                    "'.date('d-m-Y',strtotime($row['receipt_date'])).'",
									"'.(($row['remarks']=='')?'---': $row["remarks"]).'",
                                   "'.$s.'"
                                ],';
                    }

            echo '{ 
                        "recordsTotal": '.count($receipt_list).',
                    "data":[ 
                            '.rtrim($json,",").']}';
                exit;
        }
    public function get_search_query($url)
    {
      $get = array(
	   'chk_person'=>"",
             'chk_status'=>"",
             'chk_usertype'=>"",
            'chk_start_date'=>"",
            'chk_end_date'=>""
      );

        $status = array_search('status',$this->uri->segment_array());
        $user_type = array_search('user_type',$this->uri->segment_array());
			$person = array_search('person',$this->uri->segment_array());
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
		   if($person!==FALSE)
            {
                $get['chk_person'] = $this->uri->segment($person+1);	
            }

            return array($get);
    }
    public function edit_receipt($receipt_id) // edit the receipt details based on receipt id
	{
			$receipt_id = base64_decode($receipt_id);
            $this->data['receipt_details'] = $this->receipt_model->get_receipt_details($receipt_id);
            $this->form_validation->set_rules('user_id', 'supplier/customer name', 'trim|required');
			$this->form_validation->set_rules('receipt_date','Receipt date', 'trim|required');
			$this->form_validation->set_rules('attachment','Attachment', 'trim|callback_check_attachment');
            $this->form_validation->set_rules('amount','Amount', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
                if(!empty($_FILES['attachment']['name']))
                {
                    $config['upload_path'] ='./uploads/receipts/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('attachment'))
                    {
                        echo $this->upload->display_errors();
                        return false;
                    }
                    else
                    {
                            $file_data =$this->upload->data('attachment');
                            $attachment_name =$file_data['file_name'];
                    }
                    
                    $update_attachment = array(
                        'attachment'=>$attachment_name
                    );
                    
                    $this->db->where('id',$receipt_id);
                    $this->db->update('receipts',$update_attachment);
                }
                
                //end
                $user_id = substr($this->input->post('user_id'), 0, -2); // substring to get customer id or supplier id
                $u_type = substr($this->input->post('user_id'),-1); // get last character from the string (s or c)
                $user_type = ($u_type=='s') ? 'supplier' : 'customer';
                $receipt_details = array(
                        'user_id' =>$user_id,
                        'receipt_date' => $this->input->post('receipt_date'),
                        'amount' => $this->input->post('amount'),
                        'user_type'=>$user_type,
                        'modified'=>date('Y-m-d H:i:s'),									
                    );			
				$this->db->where('id',$receipt_id);
				$this->db->update('receipts',$receipt_details);
                
                 $notes = "The following receipt id #".$receipt_id." details has been modified by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                
				$this->session->set_flashdata('message','Receipt details has been updated successfully.'); 
				redirect('receipts');
		}
			$this->data['menu']='receipts';
            $this->data['suppliers'] = $this->supplier_model->get_active_supplier_lists();
            $this->data['customers'] = $this->customer_model->get_active_customer_lists();
          	$this->load->view('receipts/edit_receipt',$this->data);
	}
    public function change_status() // change the receipts details status based on receipt id using ajax
	{
			$status = 'inactive';
			$receipt_id = $this->input->post('receipt_id');		
			$item = $this->receipt_model->get_receipt_details($receipt_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('id',$receipt_id);
			$this->db->update('receipts',array( 'status' => $status ));
            $notes =  "The following receipt id #".$receipt_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			echo $status;
	}
	public function delete_receipt() // delete the receipt details based on receipt id using ajax
	{
			$receipt_id = $this->input->post('receipt_id');
			
			$this->db->where('id',$receipt_id);
			$this->db->update('receipts',array('status'=>'deleted'));
            
            $notes =  "The following receipt id #".$receipt_id." status(deleted) has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
			$this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			
	}
    public function check_attachment() // callback validation for check the attachment extension
    {
        $ext_array = array('.jpg','.jpeg','.png','.gif');
        if(!empty($_FILES['attachment']['name']))
        {
            $ext = strtolower(strrchr($_FILES['attachment']['name'],"."));
            if(in_array($ext,$ext_array))
            {
                return true;
            }
            else
            {
                $this->form_validation->set_message('check_attachment','Attachment allowed only jpg | jpeg | png | gif file');
                return false;
            }
        }
    }
    public function download($file) // download the receipt attachment files
    {
     $file_name = UPLODPATH . 'uploads/receipts/'.$file;
     $mime = 'application/force-download';
     header('Pragma: public');   
     header('Expires: 0');  
     header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
     header('Cache-Control: private',false);
     header('Content-Type: '.$mime);
     header('Content-Disposition: attachment; filename="'.basename(substr($file,strpos($file,'_')+1,strlen($file))).'"');
     header('Content-Transfer-Encoding: binary');
     header('Connection: close');
     readfile($file_name);    
     exit();
    }   
	public function datafetch()
	{
		$segment_array = $this->uri->segment_array();
		$requestData= $_REQUEST;
		$columns = array( 
							0 =>'receipts_table.id', 
							1 => 'supplier_name',
							2=> 'amount',
							3=> 'attachment',
							4=> 'user_type',
							5=> 'receipt_date',
							6=> 'remarks',
							7=> 'remarks',
							8=> 'status',
						);
					
		$segment_array = $this->uri->segment_array();
		$delete ='active';
					$where_condition='';
		/////////////DEFAULT SEARCH//////////////////////////////
		if( !empty($requestData['search']['value']))
		{  	
			$search_value = trim($requestData['search']['value']);
			$where_condition.= "(suppliers_table.supplier_name LIKE '%".$search_value."%' OR customers_table.customer_name LIKE '%".$search_value."%' OR receipts_table.receipt_date LIKE '%".$search_value."%' OR receipts_table.attachment LIKE '%".$search_value."%' OR receipts_table.amount LIKE '%".$search_value."%' OR receipts_table.remarks LIKE '%".$search_value."%' OR receipts_table.status LIKE '%".$search_value."%' OR receipts_table.user_type LIKE '%".$search_value."%') AND ";
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
			$where_condition.= "(date(receipts_table.receipt_date) BETWEEN '".date("Y-m-d",strtotime($start_date))."' AND '".date("Y-m-d",strtotime($end_date))."') AND ";
		}
		/////////////SEARCH DATE//////////////////////////////
		/////////////SEARCH USERTYPE//////////////////////////////
		$user_keyword = array_search('user_type',$segment_array);
		if ($user_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($user_keyword+1);
			if($keyword!='')
			$where_condition.="(receipts_table.user_type='".$keyword."') AND ";
		} 
		/////////////SEARCH USERTYPE//////////////////////////////
		/////////////SEARCH USERTYPE//////////////////////////////
		$user_keyword = array_search('person',$segment_array);
		if ($user_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($user_keyword+1);
			if($keyword!='')
			$where_condition.="(customers_table.sales_person_id IN (".$keyword.") OR suppliers_table.id IN (".$keyword.") ) AND" ;
		} 
		/////////////SEARCH USERTYPE//////////////////////////////
	$where_condition.="(receipts_table.status='".$delete."') ";
		/////////////////TOTAL RECORD COUNT////////////////
		$this->db->select('receipts_table.id,receipts_table.user_id,receipts_table.attachment,receipts_table.created,receipts_table.amount,receipts_table.remarks,receipts_table.receipt_date,receipts_table.user_type,receipts_table.status,suppliers_table.id,suppliers_table.supplier_name,customers_table.id as cid,customers_table.customer_name');
		$this->db->from('receipts receipts_table');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=receipts_table.user_id AND receipts_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=receipts_table.user_id AND receipts_table.user_type= "customer" ', 'left');

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
		$this->db->select('receipts_table.id,receipts_table.user_id AS uid,receipts_table.attachment,receipts_table.amount,receipts_table.created,receipts_table.remarks,receipts_table.receipt_date,receipts_table.user_type,receipts_table.status,suppliers_table.id AS sid,suppliers_table.supplier_name,customers_table.id as cid,customers_table.customer_name');
		$this->db->from('receipts receipts_table');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=receipts_table.user_id AND receipts_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=receipts_table.user_id AND receipts_table.user_type= "customer" ', 'left');

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
		$select = array("SUM(ROUND(REPLACE(receipts_table.amount, ',', ''),2)) AS total");
		$this->db->select($select);
		$this->db->from('receipts receipts_table');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=receipts_table.user_id AND receipts_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=receipts_table.user_id AND receipts_table.user_type= "customer" ', 'left');

		if($where_condition!='')
		{
			$where_condition = rtrim($where_condition,'AND ');
			$this->db->where($where_condition);
		}
		$query = $this->db->get();
		$sum_value = $query->row_array();
		$sum = number_format($sum_value['total'],2);
		///////////SUM COLUMN BASED ON CONDITION///////////	

		//$sum=100;
		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   
					"recordsTotal"    => intval( $totalData ), 
					"recordsFiltered" => intval( $totalFiltered ), 
					"data"            => $row,
					"total_amount"	  =>$sum,
					);
		echo json_encode($json_data);  
	}  


    // New changes

    public function transactions($customer_id) // get the particular customer transaction details(sales and purchase)
    {

        $this->data['customer_details']=$this->receipt_model->get_transaction_details($customer_id);
        $this->data['customer_id']=$customer_id;
         if( $this->input->is_ajax_request() ){
            $resp = $this->ajax_get_customer_transactions_history($customer_id, 'ajax');
            if($resp>0){
               echo $resp; exit;  
            }
            else{
                
            echo 'false'; exit;
            }
         }else{

            $this->load->view('receipts/transactions',$this->data);
            
         }
    } 
  public function ajax_get_customer_transactions_history($customer_id= NULL, $req='normal') // get customer transaction history both sales and purchase
           {
               $lists = $this->receipt_model->get_transaction_details($customer_id);
              //echo $this->db->last_query();exit;
               $amount='';
               $transaction_list = array();
               $temp=$amt=0;
                          $output=$lists->num_rows();
                          if ($output>0) {
                              $output=$lists->result_array();
                          }
                          $t_outstanding=$output[0]['outstanding'];
                          // echo $t_outstanding; exit;
                 $results = $lists->result_array()   ;      
                  foreach($results as $list)
                  {
                      $temp=$temp+str_replace(',', '', $list['amount']);
                      //echo $temp;exit;
                      if($t_outstanding >= $temp)
                      {
                      $amt = $amt + str_replace(',', '', $list['amount']);
                        $json[] = [
                              $list['item_name'],
                              $list['sales_date'],
                              $list['amount'],
                              'Sales'
                          ];
                  }
                      else
                      {
                           $bal = money_format('%!i',$t_outstanding - $amt) ;

                          $json[] = [
                              "<b>".$list['item_name']."</b>",
                              "<b>".$list['sales_date']."</b>",
                              "<b>".$bal."</b>",
                              '<b>Sales</b>'
                          ];
                          break;
                      }

                  }
                          $flag = 0;
                          if ($output[0]['outstanding']>0)
                          {
                              $rt_outstanding=$output[0]['outstanding'];
                              
                              $flag = $rt_outstanding;
                          }
                            if($req=='ajax')
                            {
                              return $flag;
                            }
                                  
              echo '{ 
                      "recordsTotal": '.count($results).',
                      "data": '.json_encode($json).
                      '}';
          
          
                      exit;
              }
public function out_transactions($customer_id) // get the particular customer transaction details(sales and purchase)
    {

        $this->data['customer_details']=$this->receipt_model->get_outstanding($customer_id);
        // echo "<pre>"; print_r($this->data['customer_details']); exit;
        $this->data['customer_id']=$customer_id;
         if( $this->input->is_ajax_request() ){
            $resp = $this->ajax_get_customer_outstanding_history($customer_id, 'ajax');
            if($resp>0){
               echo $resp; exit;  
            }
            else{
                
            echo 'false'; exit;
            }
         }else{

            $this->load->view('receipts/outstanding',$this->data);
            
         }
    } 
public function ajax_get_customer_outstanding_history($customer_id=NULL,$req='normal') // get customer transaction history both sales and purchase
         {
             $lists = $this->receipt_model->get_transactions_history_credit_debit($customer_id);
             $amount='';
             $transaction_list = array();
                foreach($lists as $list)
                {
                    
                    $transaction_list[$list['id']]['id'] = $list['id'];
                    $transaction_list[$list['id']]['r_remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['r_remarks']);
                    $transaction_list[$list['id']]['s_remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['s_remarks']);
                    $transaction_list[$list['id']]['l_remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['l_remarks']);
                    $transaction_list[$list['id']]['p_remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['p_remarks']);
                    $transaction_list[$list['id']]['date'] = $list['date'];
                    $transaction_list[$list['id']]['qty_out'] = $list['qty_out'];
                    $item_details = $this->items_model->get_item_details($list['item_id']);
                    $transaction_list[$list['id']]['item_name'] = $item_details['item_name'];
                    $transaction_list[$list['id']]['history_amount'] = $list['history_amount'];
                    $transaction_list[$list['id']]['record_type'] = $list['record_type'];
                }
                $json = "";
                        foreach($transaction_list as $row)
                        {
                      $amount_debit=$amount_credit='';
                        switch($row['record_type'])
                        {
                            case 'P':
                                $record_type='Purchase';
                                $amount_credit = $row['history_amount'];
                                $remarks =  $row['p_remarks'];
                                break;
                            case 'S':
                                $record_type='Sales';
                                $amount_debit = $row['history_amount'];
                                $remarks =  $row['s_remarks'];
                                break;
                            case 'M':
                                $record_type='Manufacture';
                                break;
                            case 'PR':
                                $record_type='<b>Purchase Return</b>';
                                $amount_debit = $row['history_amount'];
                                $remarks =  $row['p_remarks'];
                                break;
                            case 'SR':
                                $record_type='<b>Sales Return</b>';
                                $amount_credit = $row['history_amount'];
                                $remarks =  $row['s_remarks'];
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
                  $qty_out=($row['qty_out']) ? $row['qty_out'] : '-';
                            $json .= '[
                                "'.ucfirst($row['item_name']).'",
                                "'.date('d-m-Y',strtotime($row['date'])).'",
                                "'.(($qty_out==0)?'0': $qty_out).'",
                                 "'.(($amount_credit==0)?'0': $amount_credit).'",
                                  "'.(($amount_debit==0)?'0': $amount_debit).'",
                                  "'.(($remarks=='')?'---': $remarks).'",
                                "'.$record_type.'"
                            ],';
                        }
            echo '{ 
                    "recordsTotal": '.count($transaction_list).',
                    "data":[ 
                        '.rtrim($json,",").']
                    }';
        
        
                    exit;
        }
      /*function for print fucnitonality - soundarya*/
      public function print_ajax_receipt_list()
      {
        $segment_array = $this->uri->segment_array();
        $start = array_search("start",$segment_array);
        $end = array_search("end",$segment_array);
        $lists = $this->receipt_model->get_print_receipt_lists($segment_array);
        if($start !== FALSE && $end !== FALSE)
        {
                $start_date = $this->uri->segment($start+1);
                $end_date = $this->uri->segment($end+1);
                $this->data['start'] = $start_date;
                $this->data['end'] = $end_date;
        }
        else
        {
            if(!empty($lists))
            {
                $this->data['start'] = $lists[count($lists) - 1]['receipt_date']; //array first value
                $this->data['end'] = $lists[0]['receipt_date']; // array last value
            }
               
        }
        $receipt_list =array();
        foreach($lists as $list)
         {
            $receipt_list[$list['id']]['receipt_date'] = $list['receipt_date'];
            if($list['user_type'] == "supplier")
            {
                $supplier_details   = $this->supplier_model->get_supplier_details($list['user_id']);
                $receipt_list[$list['id']]['user_name'] = $supplier_details['supplier_name'];
            }
            else
            {
                $customer_details = $this->customer_model->get_customer_details($list['user_id']);
                $receipt_list[$list['id']]['user_name'] = $customer_details['customer_name'];
            }
            $receipt_list[$list['id']]['amount'] = $list['amount'];
            $receipt_list[$list['id']]['remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['remarks']);             
        }
            $this->data['receipts_list'] = $receipt_list;
            $this->data['page_title'] = "Receipts Reports";
            //echo count($this->data['receipts_list']);exit;
           // $html = $this->load->view("receipts/receipt_print_view",$this->data);
            $html = $this->load->view("print/print_view",$this->data);
            echo $html;
         
      }
}
?>