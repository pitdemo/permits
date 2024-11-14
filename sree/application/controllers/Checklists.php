<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checklists extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','departments_model','Zones_model'));	
			
		$this->security_model->chk_is_admin();    
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}

    public function index()
    {
        redirect('permits');        
    }
    public function permit_checklists()
	{        
        $req=array(
          'select'=>'id,name',
           'table'=>PERMITSTYPES,
            'where'=>array('status'=>STATUS_ACTIVE)
        );
        //Getting Active Companys List
        $qry=$this->public_model->fetch_data($req);
        if($qry){
            $this->data['departments']=$qry->result_array();            
        }
        //Checking ID in URL for Single Company Users Listing
        $c_id = array_search('permit_id',$this->uri->segment_array());
        $id='';
		
		$where='pc.status!= "'.STATUS_DELETED.'"  ';
        if($c_id !==FALSE && $this->uri->segment($c_id+1))
        {
            $id = $this->uri->segment($c_id+1);  
			  
            $this->data['id']=$id;
			
			$where.=' AND pc.permit_id = "'.$id.'"';
        }  
		
		#$this->data['users'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>$where,'table'=>PERMITS_CHECKLISTS));    

		$this->data['users']=$this->public_model->join_fetch_data(array('select'=>'pc.*,pt.name as permit_name','table1'=>PERMITS_CHECKLISTS.' pc','table2'=>PERMITSTYPES.' pt','join_type'=>'inner','join_on'=>'pt.id=pc.permit_id','where'=>$where,'num_rows'=>false));

		
		#echo $this->db->last_query(); exit;
		
        $this->load->view($this->data['controller'].'permit_checklists',$this->data);	
    }

    public function permits() // list the item lists
	{		
		$this->data['ppes']= $this->public_model->get_data(array('select'=>'*','where_condition'=>'1=1','table'=>PPE))->result_array(); 

		$this->data['data'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>'1=1','table'=>PERMITSTYPES))->result_array();   
		
		$this->load->view('checklists/permits',$this->data);
	}

	public function ppe() // list the item lists
	{		
		$this->data['data'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>'1=1','table'=>PPE))->result_array();   
		
		$this->load->view('checklists/ppe',$this->data);
	}

	public function ppe_form($id='') // edit the item details based on item id
	{
			if(!empty($id))
			{
				 $id = base64_decode($id);
				
				 $brands= $this->public_model->get_data(array('select'=>'*','where_condition'=>'id="'.$id.'"','table'=>PPE)); 
				 
				 if($brands->num_rows()>0)
				 {
				 	$this->data['brand_details']=$brands->row_array();
				 }
					
			}
			else
			$this->data['brand_details']=array();
			
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
				
						$item_details = array(
												'name' => strip_tags($this->input->post('name')),	
												'modified' => date('Y-m-d H:i')
											);			
					if(!empty($id))
					{											
						$this->db->where('id',$id);
						$this->db->update(PPE,$item_details); //update
					}
					else
						$this->db->insert(PPE,$item_details);
						
				$this->session->set_flashdata('message','Data has been updated successfully.'); 
				redirect('checklists/ppe');
			}
			$this->data['menu']='checklists';

			$this->load->view('checklists/ppe_form',$this->data);
	}

	public function ajax_update_ppe_status()
	{
		$status=$this->input->post('status');
		
		$ids=$this->input->post('ids');
		
		$status=($this->input->post('status')) ? $this->input->post('status') : FALSE;
		
			foreach($ids as $id):
					
					$data=array('status'=>$status);
					
					$this->db->where('id',$id);
					
					$this->db->update(PPE,$data); // update
					
			endforeach;
			
		echo json_encode(array('success'=>DB_UPDATE));
			
		exit;
	} 
	
	
	public function permit_form($id='') // edit the item details based on item id
	{
		$this->data['ppes']= $this->public_model->get_data(array('select'=>'*','where_condition'=>'status="'.STATUS_ACTIVE.'"','table'=>PPE))->result_array(); 

			if(!empty($id))
			{
				 $id = base64_decode($id);
				
				 $brands= $this->public_model->get_data(array('select'=>'*','where_condition'=>'id="'.$id.'"','table'=>PERMITSTYPES)); 
				 
				 if($brands->num_rows()>0)
				 {
				 	$this->data['brand_details']=$brands->row_array();
				 }
					
			}
			else
			$this->data['brand_details']=array();
			
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
					$item_details = array(
												'name' => strip_tags($this->input->post('name')),	
												'objectives' => strip_tags($this->input->post('objectives')),
												'ppes'=>count($this->input->post('ppes'))>0 ? json_encode($this->input->post('ppes'),JSON_FORCE_OBJECT) : ''
											);			
					if(!empty($id))
					{											
						$this->db->where('id',$id);
						$this->db->update(PERMITSTYPES,$item_details); //update
					}
					else
						$this->db->insert(PERMITSTYPES,$item_details);
						
				$this->session->set_flashdata('message','Data has been updated successfully.'); 
				redirect('checklists/permits');
			}
			$this->data['menu']='checklists';

			$this->load->view('checklists/permit_form',$this->data);
	}

	public function ajax_change_status()
	{
		$status=$this->input->post('status');
		
		$ids=$this->input->post('ids');
		
		$status=($this->input->post('status')) ? $this->input->post('status') : FALSE;
		
			foreach($ids as $id):
					
					$data=array('status'=>$status);
					
					$this->db->where('id',$id);
					
					$this->db->update(PERMITSTYPES,$data); // update
					
			endforeach;
			
		echo json_encode(array('success'=>DB_UPDATE));
			
		exit;
	} 

    public function ajax_update_permit_checklists_status()
	{
		$status=$this->input->post('status');
		
		$ids=$this->input->post('id');
		
		$status=($this->input->post('status')) ? $this->input->post('status') : FALSE;
		
			foreach($ids as $id):
					
					$data=array('status'=>$status);
					
					$this->db->where('id',$id);
					
					$this->db->update(PERMITS_CHECKLISTS,$data); // update
					
			endforeach;
			
		echo json_encode(array('success'=>DB_UPDATE));
			
		exit;
	} 

	public function permit_checklists_form($id='')
	{

		$req=array(
			'select'=>'id,name',
			 'table'=>PERMITSTYPES,
			  'where'=>array('status'=>STATUS_ACTIVE)
		  );
		  //Getting Active Companys List
		  $qry=$this->public_model->fetch_data($req);
		  if($qry){
			  $this->data['departments']=$qry->result_array();            
		  }

		  $update = array_search('id',$this->uri->segment_array());
		  
		  if($update !==FALSE && $this->uri->segment($update+1))
		  {
			  	 $id = $this->uri->segment($update+1);    
				 $where='id = "'.$id.'"';
				
				 $this->data['info'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>$where,'table'=>PERMITS_CHECKLISTS))->row_array();
			}
			else
			$this->data['info']=array();

		    $this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('permit_id', 'Permit type', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
				
					$item_details = array(
											'name' => strip_tags($this->input->post('name')),	
											'permit_id'=>$this->input->post('permit_id'),
											'additional_inputs'=>$this->input->post('additional_inputs'),
											'input_infos'=>json_encode($this->input->post('input_infos'),JSON_FORCE_OBJECT),
											'modified'=>date('Y-m-d H:i:s'),									
										);			
					if(!empty($id))
					{											
						$this->db->where('id',$id);
						$this->db->update(PERMITS_CHECKLISTS,$item_details); //update
					}
					else
						$this->db->insert(PERMITS_CHECKLISTS,$item_details);
						
				$this->session->set_flashdata('message','Data has been updated successfully.'); 
				redirect('checklists/permit_checklists/permit_id/'.$this->input->post('permit_id'));
			}

		$this->load->view($this->data['controller'].'permit_checklists_form',$this->data);	
	}
}
?>
