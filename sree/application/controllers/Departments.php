<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departments extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','departments_model','Zones_model'));	

		
			
		$this->security_model->chk_is_admin();    
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}
	public function index() // list the item lists
	{
		
		$where='';
		
		$this->data['departments'] = $this->departments_model->get_details(array('fields'=>'d.name,d.id,d.status,d.short_code','conditions'=>'d.status!= "'.STATUS_DELETED.'"'.$where));
		
		$this->load->view('departments/lists',$this->data);
	}
	
	
	public function form($id='') // edit the item details based on item id
	{
		
		$this->data['zones'] = $this->Zones_model->get_details(array('conditions'=>'status= "'.STATUS_ACTIVE.'"'));
		
			if(!empty($id))
			{
				 $id = base64_decode($id);
				
				 $brands= $this->departments_model->get_details(array('id'=>$id,'fields'=>'d.*'));
				 
				 if($brands->num_rows()>0)
				 {
				 	$this->data['brand_details']=$brands->row_array();
				 }
					
			}
			else
			$this->data['brand_details']=array();
			
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('short_code', 'Short Code', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	
			if($this->form_validation->run() == TRUE)
			{
				
						$item_details = array(
												'name' => strip_tags($this->input->post('name')),	
												'short_code' => strip_tags($this->input->post('short_code')),									
												'modified'=>date('Y-m-d H:i:s'),									
											);			
					if(!empty($id))
					{											
						$this->db->where('id',$id);
						$this->db->update(DEPARTMENTS,$item_details); //update
					}
					else
						$this->db->insert(DEPARTMENTS,$item_details);
						
				$this->session->set_flashdata('message','Data has been updated successfully.'); 
				redirect('departments');
		}
			$this->data['menu']='departments';
			$this->load->view('departments/form',$this->data);
	}

	public function ajax_change_status()
	{
		$status=$this->input->post('status');
		
		$ids=$this->input->post('ids');
		
		$status=($this->input->post('status')) ? $this->input->post('status') : FALSE;
		
			foreach($ids as $id):
					
					$data=array('status'=>$status);
					
					$this->db->where('id',$id);
					
					$this->db->update(DEPARTMENTS,$data); // update
					
			endforeach;
			
		echo json_encode(array('success'=>DB_UPDATE));
			
		exit;
	}
	
    //Company users Listing Page
    public function users()
	{        
        $req=array(
          'select'=>'id,name,',
           'table'=>DEPARTMENTS,
            'where'=>array('status'=>STATUS_ACTIVE)
        );
        //Getting Active Companys List
        $qry=$this->public_model->fetch_data($req);
        if($qry){
            $this->data['departments']=$qry->result_array();            
        }
        //Checking ID in URL for Single Company Users Listing
        $c_id = array_search('department_id',$this->uri->segment_array());
        $id='';
		
		$where='status!= "'.STATUS_DELETED.'" AND (user_role !="SA" OR user_role IS NULL) ';
		
        if($c_id !==FALSE && $this->uri->segment($c_id+1))
        {
            $id = $this->uri->segment($c_id+1);  
			  
            $this->data['id']=$id;
			
			$where.=' AND department_id = "'.$id.'"';
        }  
		
		$this->data['users'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>$where,'table'=>USERS));    
		
		#echo $this->db->last_query(); exit;

		
        $this->load->view($this->data['controller'].'users',$this->data);	
    }
	
    //Form for Edit Company Users Details
    public function user_form(){      
	
		$this->data['user_isolations']=$this->data['zones_incharges']=array();
	
        $update = array_search('id',$this->uri->segment_array());
        $id='';
        if($update !==FALSE && $this->uri->segment($update+1))
        {
            $id = base64_decode($this->uri->segment($update+1));    
            $req=array(
              'select'  =>'id,department_id,first_name,mobile_number,is_isolator,status,email_address,pass_word,is_safety,permission,employee_id,is_hod,is_section_head',
              'table'    =>USERS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry){
                $this->data['user_info']=$qry->row_array();    
				
				
				$req=array(
				  'select'  =>'*',
				  'table'    =>USERISOLATION,
				  'where'=>array('user_id'=>$id)
				);
				$iso_qry=$this->public_model->fetch_data($req);
				
				#echo $this->db->last_query(); exit;
				
				 if($iso_qry)
				 {
				 	 $user_isolations=$iso_qry->result_array();    
					 
					 $this->data['user_isolations']=array_column($user_isolations,'isolation_id');
				 }

				 $where="user_id='".$id."'";
				 $zones_incharges = $this->public_model->get_data(array('select'=>'*','where_condition'=>$where,'table'=>ZONE_INCHARGERS)); 

				 if($zones_incharges->num_rows()>0){

					$zones_incharges=$zones_incharges->result_array();    
					 
					 $this->data['zones_incharges']=array_column($zones_incharges,'zone_id');

				 }

				        
            }   
        }
        $req=array(
          'select'=>'id,name',
           'table'=>DEPARTMENTS,
          'where'=>array('status'=>STATUS_ACTIVE)
        );
        $qry=$this->public_model->fetch_data($req);
        if($qry){
            $this->data['departments']=$qry->result_array();            
        }   
		
		$where="record_type = 'isolation_type' and status = '".STATUS_ACTIVE."'";
		$this->data['isolations'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>$where,'table'=>ISOLATION))->result_array(); 

		$where='status="'.STATUS_ACTIVE.'"';
		$this->data['zones'] = $this->public_model->get_data(array('select'=>'*','where_condition'=>$where,'table'=>ZONES))->result_array(); 

		

        $this->load->view($this->data['controller'].'user_form',$this->data);	
    }
    
    //Form action to add/update data inside a DB
	public function user_form_action(){
        
        if(!empty($_POST))
		{                
                //User data
                $user_data=array(
					'employee_id'=>$this->input->post('employee_id'),
                    'department_id'=>$this->input->post('department_id'),
                    'first_name'=>$this->input->post('first_name'),
                    'last_name'=> $this->input->post('last_name')=="" ? NULL : $this->input->post('last_name'),
                    'email_address'=>strtolower(str_replace(' ','',($this->input->post('email_address')))),
                    'pass_word'=>base64_encode($this->input->post('pass_word')),
                    'is_isolator'=>$this->input->post('is_isolator'),
					'mobile_number'=>$this->input->post('mobile_number'),
					'permission'=>$this->input->post('permission'),
					'is_hod'=>$this->input->post('is_hod'),
					'is_section_head'=>$this->input->post('is_section_head'),
					'user_role'=>'',
                    'created'=>date('Y-m-d H:i:s'),
                    'is_default_password_changed'=>'no' // swathi                    
                );                
            
				if($this->input->post('submit')=='insert')
				{
					//Insert New user
					$this->db->insert(USERS,$user_data);
					$user_id=$notes=$this->db->insert_id();            
					
					$this->session->set_flashdata('success','User has been created successfully');                        
					
				}
					
        //Updating the exisiting user    
				if($this->input->post('submit')=='update')
				{
					unset($user_data['created']);
					unset($user_data['is_default_password_changed']);
				   //Updating the company Data
					$user_data['modified']=date('Y-m-d H:i:s');
					$user_id=base64_decode($this->input->post('id'));
					$this->db->where('id',$user_id);
					$this->db->update(USERS,$user_data);
					$this->session->set_flashdata('success','User has been updated successfully');                        
				}   

				if($this->input->post('is_hod')==YES)
					$this->db->query("UPDATE dml_".USERS." SET is_hod='No' WHERE department_id='".$this->input->post('department_id')."' AND id!='".$user_id."'");
			
			if($this->input->post('isolations'))
			{
				$isolations=$this->input->post('isolations');
				
				if(!empty($isolations))
				$isolations=explode(',',$isolations);
				
				$count_isolations=count($isolations);
				
				$array_insert=array();
				
				$this->db->where('user_id',$user_id);
				
				$this->db->delete(USERISOLATION);
				
				if($count_isolations>0)
				{
					for($i=0;$i<$count_isolations;$i++)
					{
						
						if($isolations[$i]!='null')
						$array_insert[]=array('user_id'=>$user_id,'isolation_id'=>$isolations[$i]);	
					}
					
					if(count($array_insert)>0)
					$this->db->insert_batch(USERISOLATION,$array_insert);
				}
			}

			
			if($this->input->post('is_section_head_zones') && $this->input->post('is_section_head_zones')!='null')
			{
				$is_section_head_zones=$this->input->post('is_section_head_zones');
				
				if(!empty($is_section_head_zones))
				$is_section_head_zones=explode(',',$is_section_head_zones);
				
				$count_is_section_head_zones=count($is_section_head_zones);
				
				$array_insert=array();
				
				$this->db->where('user_id',$user_id);
				
				$this->db->delete(ZONE_INCHARGERS);
				
				if($count_is_section_head_zones>0)
				{
					for($i=0;$i<$count_is_section_head_zones;$i++)
					{
						$array_insert[]=array('user_id'=>$user_id,'zone_id'=>$is_section_head_zones[$i],'department_id'=>$this->input->post('department_id'),'modified'=>date('Y-m-d H:i'));	
					}
					
					$this->db->insert_batch(ZONE_INCHARGERS,$array_insert);
				}
			}
				
        }//POST Empty ends here
        
		echo 'true'; exit;
	}    

	public function ajax_check_hod()
	{
		$department_id=$this->input->post('department_id');

		$is_hod=$this->input->post('is_hod');

		$user_id=base64_decode($this->input->post('id'));

		$where='department_id="'.$department_id.'" AND is_hod="Yes"';

		$check_hod=$this->public_model->get_data(array('select'=>'first_name,id','where_condition'=>$where,'table'=>USERS));    

		$response_type=3;

		$response_msg='';

		if($check_hod->num_rows()>0)
		{
			$fet=$check_hod->row_array();

			$name=$fet['first_name'];

			$id=$fet['id'];

			if($is_hod==NO && $id==$user_id){
				$response_type=1;
				$response_msg='You already acting as a HOD to this department. Please update the role to another user';
			} else if($is_hod==YES && $id!=$user_id){
				$response_msg='Mr.'.$name.' is acting as a HOD to the selected department. Would you like to update the hod role to this user?';
				$response_type=2;
			}
		}

		echo json_encode(array('response_type'=>$response_type,'response_msg'=>$response_msg));

		exit;
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
	
	/*swathi - add new function for login as client*/
	public function log_as_user()
	{
		$log_user_id = $_REQUEST['log_user_id'];

		$req=array(
			'select'=>'i.id,i.department_id,i.first_name,i.last_name,i.email_address,i.pass_word,i.user_role,i.status,j.status as comp_status,j.name as department_name,is_default_password_changed,permission,i.is_isolator,j.short_code,i.employee_id,i.is_hod,i.is_section_head',
			'where'=>array('i.id'=>$log_user_id),
			'table1'=>USERS.' i',
			'table2'=>DEPARTMENTS.' j',
			'join_on'=>'i.department_id=j.id ',
			'join_type'=>'inner',
			'num_rows'=>false
		);
		$user_details_qry = $this->public_model->join_fetch_data($req); 

		$user_details = $user_details_qry->row_array();

		$admin_session=$this->session->userdata();
		
        $login_data = array_merge($admin_session,array(
						   'department_short_code'=>(isset($user_details['short_code'])) ? $user_details['short_code'] : '',
						   'employee_id'=>$user_details['employee_id'],
						   'user_id'=>$user_details['id'],
						   'first_name'=>$user_details['first_name'],
						   'user_role'  => ($user_details['user_role']=='') ? 'PA' : $user_details['user_role'],
						   'email_address' => $user_details['email_address'],
						   'department_id' => (isset($user_details['department_id'])) ? $user_details['department_id'] : '',
						   'department_name'=>(isset($user_details['department_name'])) ? $user_details['department_name'] : '',
                           'is_default_password_changed' => (isset($user_details['is_default_password_changed'])) ? $user_details['is_default_password_changed'] : '',
						   'is_logged_in' => TRUE,
						   'permission'=>$user_details['permission'],
						   'is_isolator'=>(isset($user_details['is_isolator'])) ? $user_details['is_isolator'] : '',
						   'is_hod'=>(isset($user_details['is_hod'])) ? $user_details['is_hod'] : '',
                           'is_section_head'=>(isset($user_details['is_section_head'])) ? $user_details['is_section_head'] : ''
						)); 
		
		$this->session->set_userdata($login_data);
		// echo '<pre>'; print_r($this->session->all_userdata());exit;
		echo json_encode(array('status'=>STATUS_ACTIVE));
			
		exit; 
	}
}
?>
