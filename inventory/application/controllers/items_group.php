<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : items_group
 * Project        : Accounting Software
 * Creation Date  : 27-12-2018
 * Author         : B.D.Soundarya
 * Description    : Items Group
*********************************************************************************************/	
class Items_group extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('security_model','items_model','itemsgroup_model','notes_model'));		
		$this->security_model->chk_admin_login();
	}
	public function index() // list the itemgroup lists
	{
		$url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
		$this->data['menu'] = 'items_group';
		$this->load->view('items_group/lists',$this->data);
	}
	public function datafetch()
	{
			$requestData= $_REQUEST;
			$columns = array( 
								0 =>'id', 
								1 => 'item_group_name',
								2 => 'items',
								3 => 'created',
								4 => 'status',
								5 => 'action',
							);
			$where_condition='status != "deleted" AND ';
			/////////////DEFAULT SEARCH//////////////////////////////
			if( !empty($requestData['search']['value']))
			{  	
				$search_value = trim($requestData['search']['value']);
				$where_condition.= "(id LIKE '%".$search_value."%' OR item_group_name LIKE '%".$search_value."%' OR created LIKE '%".$search_value."%') AND ";
			}
			/////////////DEFAULT SEARCH//////////////////////////////
			
		
			/////////////////TOTAL RECORD COUNT////////////////
			$this->db->select('id,item_group_name,items,items_count,status,created');
			$this->db->from('items_group');
		
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
			$this->db->select('id,item_group_name,items,items_count,status,created');
			$this->db->from('items_group');
			
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
			$tmp = array();
			$rows = array();
            foreach ($row as $key=>$arr) {
             $group_details = $this->itemsgroup_model->get_group_details($arr['id']); // get records based on group id
             $items_details = $this->itemsgroup_model->get_items_details($group_details['items']);
          //echo count($items_details);
	         $rows = array_merge( $arr, array( "active_count_only" => count($items_details) ) );
	         array_push($tmp,$rows); 
          }
		$json_data = array(
						"draw"            => intval( $requestData['draw'] ),   
						"recordsTotal"    => intval( $totalData ), 
						"recordsFiltered" => intval( $totalFiltered ), 
						"data"            => $tmp,
						);
	  echo json_encode($json_data);  
		
	}
	public function create_items_group() //create new item group
	{

		$this->data['menu'] = 'items_group';
		//$where = $this->get_search_query($this->uri->segment_array());
        //$this->data['get'] = $where[0];
		$this->data['items'] = $this->items_model->get_active_item_lists(); // get items lists from items table
		$this->form_validation->set_rules('item_group_name','Item Group','trim');
		if($this->form_validation->run()==TRUE)
		{
			$item_group_name = $this->input->post('item_group_name');
			$items = implode(",",$this->input->post('item_id'));
			$items_count = count($this->input->post('item_id'));
			$data = array(
				'item_group_name' => $item_group_name,
				'items' => $items,
				'items_count' => $items_count,
				'status'=>'active',
                'created'=>date('Y-m-d H:i:s')
			);
			$this->db->insert('items_group',$data);
			$item_group_id = $this->db->insert_id();
			$notes = "The following #".$item_group_id." items group have been added manually by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			$this->session->set_flashdata('message',"Items Group has been created successfully.");
			redirect('items_group');
		}
		$this->load->view('items_group/create_items_group',$this->data);

	}
    public function ajax_check_itemgroup_exists_or_not() // check for group name already exist or not
    {

    	$group_name = $this->input->post('name');
    	$id = $this->input->post('id');
    	$this->db->where('item_group_name',$group_name);
    	$this->db->where('status !=',STATUS_DELETED);
        if(isset($id) && !empty($id))
        {
        	$this->db->where('id !=',$id);
        }
    	$qry = $this->db->get('items_group');
    	if($qry->num_rows() > 0 )
    	{
    		echo 'exists';
    	}
    	else
    	{
    		echo 'not exists';
    	}

    }
     public function ajax_get_items_details() // get Items details based on group id for popup
     {
        $group_id = $this->input->post('group_id');
        $group_details = $this->itemsgroup_model->get_group_details($group_id); // get records based on group id
        $items_details = $this->itemsgroup_model->get_items_details($group_details['items']);
        //print_r($items_details);exit;
        //echo $group_id;exit;
        if(!empty($items_details))
        {
           echo "<table id='table_report3' class='table table-striped table-bordered table-hover' style='margin:0 auto'><tr><th width='50%' align='left'>Item Code</th><th width='50%'>Item Name</th></tr>";
            foreach($items_details as $result)
            {
            echo "<tr><td align='left'>".$result['item_code']."</td><td>".ucfirst($result['item_name'])."</td></tr>";
            }
            echo "</table>";
        }
    }
    public function change_status() // change the status active or inactive using ajax
	{
			$status = 'inactive';
			$item_group_id = $this->input->post('item_group_id');		
			$item = $this->itemsgroup_model->get_item_group_details($item_group_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('id',$item_group_id);
			$this->db->update('items_group',array( 'status' => $status ));
            
            $notes =  "The following item group id #".$item_group_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
        
			echo $status;
	}
	public function delete_item() // delete the itemgroup details using ajax
	{
			$item_group_id = $this->input->post('item_group_id');
			
			$this->db->where('id',$item_group_id);
			$this->db->update('items_group',array('status'=>'deleted'));
            
            $notes =  "The following item group id #".$item_group_id." status(deleted) has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
			$this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
	}
	public function edit_item($item_group_id) // edit the item details based on item id
	{
		    $this->data['menu']='items_group';
			$item_group_id = base64_decode($item_group_id);
			$this->data['item_details'] = $this->itemsgroup_model->get_item_group_details($item_group_id);
			$this->data['items'] = $this->items_model->get_active_item_lists();
	        //$items_id = explode(",",$this->data['item_details']['items']);
	        $get_not_deletd_items_details = $this->itemsgroup_model->get_items_details($this->data['item_details']['items']);
	        $ids = array();
	        if(!empty($get_not_deletd_items_details))
	        {
	        	foreach ($get_not_deletd_items_details as $items) {
                   $ids[] .= $items['id']; 	        	
	        	# code...
	        }
              $this->data['items_ids'] = $ids;
	        }
	        else
	        {
	        	$this->data['items_ids'] = array();
	        }
			$this->form_validation->set_rules('item_group_name','Item Group','trim');
			//$this->form_validation->set_rules('item_type','Item type', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
                $items = implode(",", $this->input->post('item_id'));
                $items_count = count($this->input->post('item_id'));
				$data = array(
										'item_group_name' => $this->input->post('item_group_name'),
										'items' => $items,
										'items_count' => $items_count,
										'modified'=>date('Y-m-d H:i:s'),									
									);			
				$this->db->where('id',$item_group_id);
				$this->db->update('items_group',$data); //update
				$this->session->set_flashdata('message','Item Group details has been updated successfully.');
                
                $notes = "The following item group id #".$item_group_id." details has been modified by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                
				redirect('items_group');
		   }
			
			$this->load->view('items_group/edit_items_group',$this->data);
	}

}
?>