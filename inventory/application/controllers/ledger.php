<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : Ledger.php
 * Project        : Accounting Software
 * Creation Date  : 09-11-2015
 * Author         : G.Uma maheswari
 * Description    : Manage the  ledger details
*********************************************************************************************/	
class Ledger extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model','sales_model','supplier_model','items_model','customer_model','notes_model','ledger_model'));		
		$this->security_model->chk_admin_login();
	}
    public function index()
    {
       
	    redirect('ledger/lists');
    }
	public function lists() // ledger lists
    {
         $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		$where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
				$this->data['persons'] = $this->customer_model->get_active_sales_person_lists();
		 $this->data['items'] = $this->items_model->get_active_item_lists(); // get items lists from items table
		$this->data['menu'] = 'ledger';
		$this->load->view('ledger/lists',$this->data);
    }
    public function ledger_entry() // insert daily sales entry details 
	{
		
		$this->data['menu'] = 'ledger';
		$this->form_validation->set_rules('c_id','Ledger','trim');
		 if($this->session->userdata('session_user_type')!='viewer')
		 {
		if($this->form_validation->run()==TRUE)
		{
				$suppliers = $this->input->post('suppliers');
				$ledger_type  = $this->input->post('ledger_type');
				$ledger_date = $this->input->post('ledger_date');
				$amounts = $this->input->post('amounts');
				$remarks = $this->input->post('remarks');
				$ids = ''; // concatenate all the item id for stroed into notes table
			
				for($i=0;$i<count($suppliers);$i++)
				{
                    $user_id = substr($suppliers[$i], 0, -2);
                    $u_type = substr($suppliers[$i],-1);
                    $user_type = ($u_type=='s') ? 'supplier' : 'customer';
					
					 $ledger_details = array(
					 							'user_id'=>$user_id,
												'ledger_type'=>$ledger_type[$i],
					 							'ledger_date'=>$ledger_date[$i],
					 							'amount'=>$amounts[$i],
												'remarks'=>($remarks[$i]) ? $remarks[$i] : NULL,
                                                'user_type'=>$user_type,
					 							'status'=>STATUS_ACTIVE,
					 							'created'=>date('Y-m-d H:i:s')
										 );
										 
										
							$this->db->insert('ledger',$ledger_details);
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
						$this->session->set_flashdata('message','Ledger details has been inserted successfully.');
						redirect('ledger/lists');
		}
		$this->load->view('ledger/ledger_entry',$this->data);
		 }
	}
  
	public function change_status() // change the customer status active or inactive using ajax
	{
			$status = 'inactive';
			$ledger_id = $this->input->post('ledger_id');		
			$item = $this->ledger_model->get_ledger_details($ledger_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('id',$ledger_id);
			$this->db->update('ledger',array( 'status' => $status ));
            
            $notes =  "The following customer id #".$ledger_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			echo $status;
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
			
		
        public function get_search_query($url)
	    {
		      $get = array(
					   'chk_person'=>"",
					  'chk_ledger_type'=>"",
					 'chk_status'=>"",
					 'chk_usertype'=>"",
                    'chk_start_date'=>"",
                    'chk_end_date'=>""
              );
            $ledger_type= array_search('ledger_type',$this->uri->segment_array());
            $status = array_search('status',$this->uri->segment_array());
            $user_type = array_search('user_type',$this->uri->segment_array());
			$person = array_search('person',$this->uri->segment_array());
            $date_from = array_search('start',$this->uri->segment_array());
            $date_end = array_search('end',$this->uri->segment_array());
            if($ledger_type!==FALSE)
			{
				$get['chk_ledger_type'] = $this->uri->segment($ledger_type+1);	
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
		 public function ajax_get_ledger_list() // load bulk records to jquery data table using ajax
		 { 
             $segment_array = $this->uri->segment_array();
             $lists = $this->ledger_model->get_ledger_lists($segment_array);
             $ledger_list = array();
                foreach($lists as $list)
                {
                    if($list['user_type']=='supplier')
                    {
                      $supplier_details   = $this->supplier_model->get_supplier_details($list['user_id']);
                      $ledger_list[$list['id']]['user_name'] = $supplier_details['supplier_name'];
                    }
                    else
                    {
                     $customer_details   = $this->customer_model->get_customer_details($list['user_id']);
                      $ledger_list[$list['id']]['user_name'] = $customer_details['customer_name'];
                    }
                    $ledger_list[$list['id']]['id'] = $list['id'];
                    $ledger_list[$list['id']]['ledger_date'] = $list['ledger_date'];
                    $ledger_list[$list['id']]['amount'] = $list['amount'];
					$ledger_list[$list['id']]['remarks'] = preg_replace( "/\r|\n|\\|/", "", $list['remarks']);
                    $ledger_list[$list['id']]['user_type'] = $list['user_type'];
					$ledger_list[$list['id']]['ledger_type'] = $list['ledger_type'];
                    $ledger_list[$list['id']]['status'] = $list['status'];
					
					
                }
             
            $option = array_search('option_type',$segment_array); // print pdf option
           if($option!==FALSE)
		   {
                $option_type = $this->uri->segment($option+1);
                if($option_type=='pdf')
                {
                    $this->data['ledger_list'] = $ledger_list;
                    $html = $this->load->view('sales/print_to_pdf',$this->data,true);
					$pdf_filename  ='ledger_list.pdf';
					$this->load->library('dompdf_lib');
					$this->dompdf_lib->convert_html_to_pdf($html, $pdf_filename, true);
                }
                else if($option_type=='csv')
                {
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=ledger_list.csv");
                    // Disable caching
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                    header("Pragma: no-cache"); // HTTP 1.0
                    header("Expires: 0"); // Proxies
                    $heading = array('Name','Ledger Id','Ledger Date','Amount','Remarks','User Type','Ledger Type','Status');
                    $this->outputCSV($ledger_list,$heading);
                    exit;
                }
            }
                    
					
                $json = "";
                        foreach($ledger_list as $row)
                        {
							 if($row['user_type'] == 'supplier')
                                {
                                    $link = '<a href=\"'.base_url().'suppliers/transactions/'.base64_encode($row['id']).'\">' .$row['user_name']. '</a>';
									
										
                                }
                                else
                                {
                                     $link = 	'<a href=\"'.base_url().'customers/transactions/'.base64_encode($row['id']).'\">' .$row['user_name']. '</a>';
                                }
							
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
                                        "'.$link.'",
                                        "'.ucfirst($row['ledger_type']).'",
                                        "'.date('d-m-Y',strtotime($row['ledger_date'])).'",
                                        "'.$row['amount'].'",
										 "'.(($row['remarks']=='')?'---': $row["remarks"]).'",
                                        "'.$s.'"
                                    ],';
                        }
					
                echo '{ 
                        "recordsTotal": '.count($ledger_list).',
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
							0=>'ledger_table.id', 
							1=> 'supplier_name',
							2=> 'ledger_table.ledger_date',
							3=> 'ledger_table.amount',
							4=> 'ledger_table.ledger_type',
							5=> 'ledger_table.ledger_type',
							6=> 'ledger_table.created',
							7=> 'ledger_table.remarks',
							8=> 'ledger_table.status',
						);
					
		$delete ='active';
	    $where_condition='';
		$segment_array = $this->uri->segment_array();
		/////////////DEFAULT SEARCH//////////////////////////////
		if( !empty($requestData['search']['value']))
		{  	
			$search_value = trim($requestData['search']['value']);
			$where_condition.= "(suppliers_table.supplier_name LIKE '%".$search_value."%' OR customers_table.customer_name LIKE '%".$search_value."%' OR ledger_table.ledger_date LIKE '%".$search_value."%' OR ledger_table.amount LIKE '%".$search_value."%' OR ledger_table.remarks LIKE '%".$search_value."%' OR ledger_table.created LIKE '%".$search_value."%' OR ledger_table.ledger_type LIKE '%".$search_value."%' OR ledger_table.status LIKE '%".$search_value."%' OR ledger_table.user_type LIKE '%".$search_value."%') AND ";
		}
		/////////////DEFAULT SEARCH//////////////////////////////
		/////////////SEARCH STATUS//////////////////////////////
		$status_keyword = array_search('status',$segment_array);
		if ($status_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($status_keyword+1);
			if($keyword!='')
			$delete= $keyword;
//		$where_condition.="(purchases_table.status='".$keyword."') AND ";
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
			$where_condition.= "(date(ledger_table.ledger_date) BETWEEN '".date("Y-m-d",strtotime($start_date))."' AND '".date("Y-m-d",strtotime($end_date))."') AND ";
		}
		/////////////SEARCH DATE//////////////////////////////
		/////////////SEARCH USERTYPE//////////////////////////////
		$user_keyword = array_search('user_type',$segment_array);
		if ($user_keyword !== FALSE)
		{
			$keyword = $this->uri->segment($user_keyword+1);
			if($keyword!='')
			$where_condition.="(ledger_table.user_type='".$keyword."') AND ";
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
		
		
			$where_condition.="(ledger_table.status='".$delete."') ";
		/////////////SEARCH USERTYPE//////////////////////////////
		/////////////////TOTAL RECORD COUNT////////////////
		$this->db->select('ledger_table.id,ledger_table.user_id AS uid,ledger_table.amount,ledger_table.remarks,ledger_table.ledger_date,ledger_table.user_type,ledger_table.ledger_type,ledger_table.status,suppliers_table.id AS sid,suppliers_table.supplier_name,customers_table.id as cid,customers_table.customer_name,ledger_table.created');
		$this->db->from('ledger ledger_table');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=ledger_table.user_id AND ledger_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=ledger_table.user_id AND ledger_table.user_type= "customer" ', 'left');
		//$this->db->order_by('ledger_table.ledger_date', 'desc');

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
		$this->db->select('ledger_table.id,ledger_table.user_id AS uid,ledger_table.amount,ledger_table.remarks,ledger_table.ledger_date,ledger_table.user_type,ledger_table.ledger_type,ledger_table.status,suppliers_table.id AS sid,suppliers_table.supplier_name,customers_table.id as cid,customers_table.customer_name,ledger_table.created');
		$this->db->from('ledger ledger_table');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=ledger_table.user_id AND ledger_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=ledger_table.user_id AND ledger_table.user_type= "customer" ', 'left');
		//$this->db->order_by('ledger_table.ledger_date', 'desc');

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
		$select = array("SUM(ROUND(REPLACE(ledger_table.amount, ',', ''),2)) AS total");
		$this->db->select($select);
		$this->db->from('ledger ledger_table');
		$this->db->join('suppliers suppliers_table', 'suppliers_table.id=ledger_table.user_id AND ledger_table.user_type= "supplier" ', 'left');
		$this->db->join('customers customers_table', 'customers_table.id=ledger_table.user_id AND ledger_table.user_type= "customer" ', 'left');

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
					"total_amount"	  =>$sum
				
					);
		echo json_encode($json_data);  
	}  
}
?>
