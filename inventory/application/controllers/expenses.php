<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : expenses.php
 * Project        : Accounting Software
 * Creation Date  : 09-07-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the Expenses details
*********************************************************************************************/	
class Expenses extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model','notes_model','expense_model'));		
		$this->security_model->chk_admin_login();
	}
	public function index() // Expenses lists
    {
        $where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
		$this->data['menu'] = 'expenses';
		$this->load->view('expenses/lists',$this->data);
    }
	
	public function category_list() // Category lists
    {
      	$this->data['menu'] = 'expenses';
		$this->load->view('expenses/category_list',$this->data);
    }
	
	public function ajax_get_expense_category() // load bulk records to jquery data table using ajax
		{
			$this->data['categories'] = $this->expense_model->ajax_get_category_list();
		}
	 public function expenses_category() // insert expenses_category details 
	{
		$this->data['menu'] = 'expenses';
		$this->form_validation->set_rules('c_id','Expenses','trim');
		if($this->form_validation->run()==TRUE)
		{
				$expense_categories = $this->input->post('expense_category');
			     $ids = ''; // concatenate all the item id for stroed into notes table
				for($i=0;$i<count($expense_categories);$i++)
				{
					 $category_details = array(
                                    'expense_category'=>$expense_categories[$i],
                                    'created'=>date('Y-m-d H:i:s')
										 );
							$this->db->insert('expenses_category',$category_details); // insert into expenses_category table
                             $last_id = $this->db->insert_id();
                            $ids .="#".$last_id.",";
				}
                 $notes = "The following ".rtrim($ids,",")." category have been added manually by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                 $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
						$this->session->set_flashdata('message','Expenses category details has been inserted successfully.');
						redirect('expenses/category_list');
		}
		$this->load->view('expenses/create_expense_category',$this->data);
	}
    public function expenses_entry() // insert daily expenses entry details 
	{
		$this->data['menu'] = 'expenses';
		$this->form_validation->set_rules('e_id','Expenses','trim');
		if($this->form_validation->run()==TRUE)
		{
				$categories = $this->input->post('categories');
				$expense_date = $this->input->post('expense_date');
				$description = $this->input->post('description');
				$amounts = $this->input->post('amounts');
				
			     $ids = ''; // concatenate all the expense id for stroed into notes table
				for($i=0;$i<count($categories);$i++)
				{
                    $category_id = substr($categories[$i], 0, -2);
					$expense_details = array(
                                    'category_id'=>$category_id,
                                    'expense_date'=>$expense_date[$i],
									'description'=>$description[$i],
                                    'amount'=>$amounts[$i],
                                    'status'=>STATUS_ACTIVE,
                                    'created'=>date('Y-m-d H:i:s')
								);
							$this->db->insert('expenses',$expense_details);
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
            
            $this->session->set_flashdata('message','Expenses details has been inserted successfully.');
			redirect('expenses');
		}
		$this->load->view('expenses/expenses_entry',$this->data);
	}
   
   
   	public function edit_expenses($expense_id) // edit the expense details based on expense id
	{
			$expense_id = base64_decode($expense_id);
            $this->data['expense_details'] = $this->expense_model->get_expense_details($expense_id);
            $this->form_validation->set_rules('category_id', 'category name', 'trim|required');
			$this->form_validation->set_rules('expense_date','Expense date', 'trim|required');
			$this->form_validation->set_rules('description','description', 'trim|required');
            $this->form_validation->set_rules('amount','Amount', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
                $category_id = substr($this->input->post('category_id'), 0, -2); // substring to get category id
              
                $expense_details = array(
                        'category_id' =>$category_id,
                        'expense_date' => $this->input->post('expense_date'),
						'description' => $this->input->post('description'),
                        'amount' => $this->input->post('amount'),
                        'modified'=>date('Y-m-d H:i:s'),									
                    );			
				$this->db->where('id',$expense_id);
				$this->db->update('expenses',$expense_details);
                
                $notes = "The following expense id #".$expense_id." details has been modified by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                
				$this->session->set_flashdata('message','Expense details has been updated successfully.'); 
				redirect('expenses');
		}
			$this->data['menu']='expenses';
            $this->data['categories'] = $this->expense_model->get_active_category_lists();
			$this->load->view('expenses/edit_expense',$this->data);
	}
	
	
		public function change_status() //change the expense status active or inactive
	{
			$status = 'inactive';
			$expense_id = $this->input->post('expense_id');		
			$item = $this->expense_model->get_expense_details($expense_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('id',$expense_id);
			$this->db->update('expenses',array( 'status' => $status ));
            
         $notes =  "The following expense id #".$expense_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			echo $status;
	}
	
	public function delete_item() // delete the expense details
	{
			$expense_id = $this->input->post('expense_id');
			$this->db->where('id',$expense_id);
			$this->db->update('expenses',array('status'=>STATUS_DELETED));
        
            $notes =  "The following expense id #".$expense_id." status(deleted) has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
			$this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
	}
    public function ajax_get_active_expenses_category() // get active expenses_category from 'expenses_category' table using select2 dropdown remote ajax
		{
	
			$search_key=($this->input->get('q')) ? $this->input->get('q') : '';
			$this->db->select('id,expense_category');
			
			$this->db->from('expenses_category');
		
			if($search_key)
			{
					$where_condition="(expense_category LIKE '%".$search_key."%') AND status ='".STATUS_ACTIVE."'";
			}
			
			$this->db->where($where_condition);
			
			$query=$this->db->get();
            
            
            //end
			
			$arr=array();
			
			foreach($query->result_array() as $item) // expenses list
			{
				$arr[]=array(
					'internal'=>$item['expense_category'],
					'id'=>$item['id'].'-s'
					);
			}
            
           
			echo json_encode($arr,true);
			
			exit;
			}
			
			
        public function get_search_query($url)
	    {
		      $get = array(
					 'chk_status'=>"",
                    'chk_start_date'=>"",
                    'chk_end_date'=>""
              );
            
            $status = array_search('status',$this->uri->segment_array());
            $date_from = array_search('start',$this->uri->segment_array());
            $date_end = array_search('end',$this->uri->segment_array());
            
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
		 public function ajax_get_expenses_list() // load bulk records to jquery data table using ajax
		 {
			 $segment_array = $this->uri->segment_array();
             $lists = $this->expense_model->get_expenses_lists($segment_array);
             $expenses_list = array();
                foreach($lists as $list)
                {
                    $category_details = $this->expense_model->get_category_details($list['category_id']);
                    $expenses_list[$list['id']]['id'] = $list['id'];
                    $expenses_list[$list['id']]['expense_category'] = $category_details['expense_category'];
                    $expenses_list[$list['id']]['expense_date'] = $list['expense_date'];
                    $expenses_list[$list['id']]['amount'] = $list['amount'];
					$expenses_list[$list['id']]['created'] = $list['created'];
					$expenses_list[$list['id']]['description'] = preg_replace( "/\r|\n|\\|/", "", $list['description']);
                    $expenses_list[$list['id']]['status'] = $list['status'];
                }
             
            $option = array_search('option_type',$segment_array); // print pdf option
           if($option!==FALSE)
		   {
                $option_type = $this->uri->segment($option+1);
                if($option_type=='pdf')
                {
                    $this->data['expenses_list'] = $expenses_list;
                    $html = $this->load->view('expenses/print_to_pdf',$this->data,true);
					$pdf_filename  ='expenses_report.pdf';
					$this->load->library('dompdf_lib');
					$this->dompdf_lib->convert_html_to_pdf($html, $pdf_filename, true);
                }
                else if($option_type=='csv')
                {
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=expenses_report.csv");
                    // Disable caching
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                    header("Pragma: no-cache"); // HTTP 1.0
                    header("Expires: 0"); // Proxies
                    $heading = array('Category Id','Category Name','Expenses Date','Amount','Description','Status');
                    $this->outputCSV($expenses_list,$heading);
                    exit;
                }
            }
                    
                $json = "";
                //print_r($expenses_list);
                        foreach($expenses_list as $row)
                        {
                        	//echo $row['amount'];exit;
                        $val =  str_replace(',','',$row['amount']);
                        //echo $val;exit;
					    $total_amount_array[] = ROUND($val,2);
						//print_r($total_amount_array);
						$created_date = date('Y-m-d',strtotime($row['created']));
						$today = date('Y-m-d'); //2015-10-20
						$last_six = date('Y-m-d', strtotime('-6 days', strtotime($today)));  
						
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
                          
                            "'.ucfirst($row['expense_category']).'",
							"'.date('d-m-Y',strtotime($row['expense_date'])).'",
							"'.$row['amount'].'",
							"'.str_replace('"', '\"', $row['description']).'",
							"'.date('d-m-Y',strtotime($row['created'])).'",
							 "'.$s.'",
                            "<div class=\"btn-group\"><a href=\"'.base_url().'expenses/edit_expenses/'.base64_encode($row['id']).'\" class=\"btn btn-mini btn-info\" type=\"button\" title=\"Edit\"><i class=\"icon-edit bigger-120\"></i></a><button type=\"button\" style=\"cursor:pointer;\" onClick=\"delete_item('.$row['id'].',this);\" class=\"btn btn-mini btn-danger\" title=\"Delete\"><i class=\"icon-trash bigger-120\"></i></button></div>"
                        ],';
                    }
                    //print_r($total_amount_array);
					//$total = array_sum($total_amount_array);
					if(!empty($total_amount_array))
			     	    $total = array_sum($total_amount_array);
			        else
			        	$total = 0;
					$sum = number_format($total,2);
                echo '{  "total_amount": '.$total.',
                            "recordsTotal": '.count($expenses_list).',
                        "data":[ 
                                '.rtrim($json,",").']
                        
                      }';
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
	   	public function edit_category($category_id) // edit the existing category details
	{
			$category_id = base64_decode($category_id);
			$this->data['category_details'] = $this->expense_model->get_category_details($category_id);
			            // form validation
			$this->form_validation->set_rules('category_name', 'Category name', 'trim|required');
			
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
				$category_details = array(
										'expense_category' => strip_tags($this->input->post('category_name')),
										'modified'=>date('Y-m-d H:i:s'),									
									);			
				$this->db->where('id',$category_id);
				$this->db->update('expenses_category',$category_details); // update the category_details                
                $notes = "The following category id #".$category_id." details has been modified by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                
				$this->session->set_flashdata('message','Category details has been updated successfully.'); 
				redirect('expenses/category_list');
		   }
			$this->data['menu']='expenses';
			$this->load->view('expenses/edit_category',$this->data);
	}
	public function change_status_category() // change the cAtegory status active or inactive using ajax
	{
			
			$status = 'inactive';
			$category_id = $this->input->post('category_id');
			$item = $this->expense_model->get_category_details($category_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('id',$category_id);
			$this->db->update('expenses_category',array( 'status' => $status ));
            
            $notes =  "The following category id #".$category_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			echo $status;
	}
	public function delete_item_category() // delete the category details
	{
			$category_id = $this->input->post('category_id');
			
			$this->db->where('id',$category_id);
			$this->db->update('expenses_category',array('status'=>'deleted'));
            $notes =  "The following category id #".$category_id." status(deleted) has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
			$this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			
	}

	 /*function for print fucnitonality - soundarya*/
      public function print_ajax_expenses_list()
      {
        $segment_array = $this->uri->segment_array();
        $start = array_search("start",$segment_array);
        $end = array_search("end",$segment_array);
        $lists = $this->expense_model->get_print_expenses_lists($segment_array);
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
                $this->data['start'] = $lists[count($lists) - 1]['expense_date']; //array first value
                $this->data['end'] = $lists[0]['expense_date']; // array last value
            }
               
        }
        $expense_list =array();
        foreach($lists as $list)
         {
            $expense_list[$list['id']]['expense_date'] = $list['expense_date'];
            $expense_category_details = $this->expense_model->get_expense_category_details($list['category_id']);
            $expense_list[$list['id']]['expense_category_name'] = $expense_category_details['expense_category'];
            $expense_list[$list['id']]['amount'] = $list['amount'];
            $expense_list[$list['id']]['description'] = preg_replace( "/\r|\n|\\|/", "", $list['description']);             
        }
            $this->data['expenses_list'] = $expense_list;
            $this->data['page_title'] = "Expense Reports";
            //echo count($this->data['receipts_list']);exit;
           // $html = $this->load->view("receipts/receipt_print_view",$this->data);
            $html = $this->load->view("print/print_view",$this->data);
            echo $html;
         
      }


}
?>
