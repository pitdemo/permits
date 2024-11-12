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
		
		$where='status!= "'.STATUS_DELETED.'"  ';
        if($c_id !==FALSE && $this->uri->segment($c_id+1))
        {
            $id = $this->uri->segment($c_id+1);  
			  
            $this->data['id']=$id;
			
			$where.=' AND permit_id = "'.$id.'"';
        }  
		
		$this->data['users'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>$where,'table'=>PERMITS_CHECKLISTS));    
		
		#echo $this->db->last_query(); exit;
		
        $this->load->view($this->data['controller'].'permit_checklists',$this->data);	
    }

    public function permits() // list the item lists
	{		
		$this->data['data'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>'1=1','table'=>PERMITSTYPES))->result_array();   
		
		$this->load->view('checklists/permits',$this->data);
	}
	
	
	public function permit_form($id='') // edit the item details based on item id
	{
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
												'modified'=>date('Y-m-d H:i:s'),									
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
			$this->load->view('checklists/form',$this->data);
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
}
?>
