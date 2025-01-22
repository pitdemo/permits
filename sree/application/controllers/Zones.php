<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zones extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','zones_model'));	
			
		$this->security_model->chk_is_admin();    
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}
	public function index() // list the item lists
	{
		$this->data['zones'] = $this->zones_model->get_details(array('conditions'=>'status!= "'.STATUS_DELETED.'"'));
       
		$this->load->view('zones/lists',$this->data);
	}
	
	
	public function form($id='') // edit the item details based on item id
	{
			if(!empty($id))
			{
				 $id = base64_decode($id);
				
				 $brands= $this->zones_model->get_details(array('id'=>$id));
				 
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
                                                'plant_type'=>$this->input->post('plant_type')								
											);			
					if(!empty($id))
					{											
						$this->db->where('id',$id);
						$this->db->update(ZONES,$item_details); //update
					}
					else
						$this->db->insert(ZONES,$item_details);
						
				$this->session->set_flashdata('message','Data has been updated successfully.'); 
				redirect('zones');
		}
			$this->load->view('zones/form',$this->data);
	}

	public function ajax_change_status()
	{
		$status=$this->input->post('status');
		
		$ids=$this->input->post('ids');
		
		$status=($this->input->post('status')) ? $this->input->post('status') : FALSE;
		
			foreach($ids as $id):
					
					$data=array('status'=>$status);
					
					$this->db->where('id',$id);
					
					$this->db->update(ZONES,$data); // update
					
			endforeach;
			
		echo json_encode(array('success'=>DB_UPDATE));
			
		exit;
	}
	
    //Company users Listing Page
    public function users()
	{        
        $req=array(
          'select'=>'id,name,',
           'table'=>ZONES,
            'where'=>array('status'=>STATUS_ACTIVE)
        );
        //Getting Active Companys List
        $qry=$this->public_model->fetch_data($req);
        if($qry){
            $this->data['zones']=$qry->result_array();            
        }
        //Checking ID in URL for Single Company Users Listing
        $c_id = array_search('department_id',$this->uri->segment_array());
        $id='';
		
		$where='status!= "'.STATUS_DELETED.'" AND user_role !="SA" ';
        if($c_id !==FALSE && $this->uri->segment($c_id+1))
        {
            $id = $this->uri->segment($c_id+1);  
			  
            $this->data['id']=$id;
			
			$where.=' AND department_id = "'.$id.'"';
        }  
		
		$this->data['users'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>$where,'table'=>USERS));      

        $this->load->view($this->data['controller'].'users',$this->data);	
    }
	
    //Form for Edit Company Users Details
    public function user_form(){      
	
        $update = array_search('id',$this->uri->segment_array());
        $id='';
        if($update !==FALSE && $this->uri->segment($update+1))
        {
            $id = base64_decode($this->uri->segment($update+1));    
            $req=array(
              'select'  =>'id,department_id,first_name,last_name,user_role,status,email_address,pass_word',
              'table'    =>USERS,
              'where'=>array('user_role !='=>'SA','id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry){
                $this->data['user_info']=$qry->row_array();            
            }   
        }
        $req=array(
          'select'=>'id,name',
           'table'=>ZONES,
          'where'=>array('status'=>STATUS_ACTIVE)
        );
        $qry=$this->public_model->fetch_data($req);
        if($qry){
            $this->data['zones']=$qry->result_array();            
        }   
        $this->load->view($this->data['controller'].'user_form',$this->data);	
    }
    
    //Form action to add/update data inside a DB
	public function user_form_action(){
        
        if(!empty($_POST)){                
                //User data
                $user_data=array(
                    'department_id'=>$this->input->post('department_id'),
                    'first_name'=>$this->input->post('first_name'),
                    'last_name'=> $this->input->post('last_name')=="" ? NULL : $this->input->post('last_name'),
                    'email_address'=>$this->input->post('email_address'),
                    'pass_word'=>$this->encrypt->encode($this->input->post('pass_word')),
                    'user_role'=>$this->input->post('user_role'),
                    'created'=>date('Y-m-d H:i:s')              
                );                
            
        if($this->input->post('submit')=='insert')
		{
               //Insert New user
                $this->db->insert(USERS,$user_data);
                $department_id=$notes=$this->db->insert_id();            
                $req=array(
                     'from'=>'support@gmail.com',
                    'to'=>$this->input->post('email_address'),
                    'first_name'=>$this->input->post('first_name'),
                    'email_address'=>$this->input->post('email_address'),
                    'pass_word'=>$this->input->post('pass_word'),
                    'subject'=>'Welcome to '.$this->lang->line('site_name')
                );
                $req['mail_content']=$this->load->view("email_templates/user_created", $req, TRUE);
                //Company created Notification Mail sending
                #$res=$this->public_model->send_email($req);
                if($res){
                    $this->session->set_flashdata('success',DB_ADD);                        
                    echo 'true'; exit;                    
                }
                $this->session->set_flashdata('failure',MAIL_PROB);                        
                echo 'true!';
            }
            
        //Updating the exisiting user    
        if($this->input->post('submit')=='update'){
               //Updating the company Data
                $user_data['modified']=date('Y-m-d H:i:s');
                $id=base64_decode($this->input->post('id'));
                $this->db->where('id',$id);
                $this->db->update(USERS,$user_data);
                $this->session->set_flashdata('success',DB_UPDATE);                        
                echo 'true'; exit;
            }                        
        }//POST Empty ends here
        
	}    

    // Change status Active, Inactive and Deleted for Company Users
    public function ajax_update_users()
	{
        $response='';
        $status = $this->input->post('status');
        if(is_array($this->input->post('id'))){
            $i=0;
            foreach ( $this->input->post('id') as $value) {
                $ids[$i]=$value;
                $i++;
            }
            $this->db->where_in('id', $ids);
            $status = $this->input->post('status');
            $response='bulk';
        }
        else{
            $id=$this->input->post('id');
            $this->db->where('id',$id);   
            if($status=='active'){
                $response=STATUS_INACTIVE;
            }
            else if($status=='inactive'){
                $response=STATUS_ACTIVE;
            }
            else{
                $response=STATUS_DELETED;
            }
            $status = $response;
        }
        $this->db->set('status',$status);
        $this->db->update(USERS);
		
		#echo $this->db->last_query(); 
        echo $response; exit;
    }
	
	
}
?>
