<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**********************************************************************************************
 * Filename       : user_management.php
 * Project        : Accounting Software
 * Creation Date  : 26-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the Staff details
*********************************************************************************************/	
class User_management extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model','staff_model','notes_model'));	 // load the model files here
		$this->security_model->chk_admin_login(); // check if user is login or not
		
	}
	public function index() // show the staff list
	{
		$this->data['menu'] = 'user_management';
		$this->load->view('user_management/index',$this->data);
	}
    public function ajax_get_staff_list() // load bulk records to jquery data table using ajax
	{
         $lists = $this->staff_model->get_staff_lists();
         $staff_list = array();
            foreach($lists as $list)
            {
                $staff_list[$list['adm_id']]['adm_id'] = $list['adm_id'];
                $staff_list[$list['adm_id']]['adm_firstname'] = $list['adm_firstname'];
                $staff_list[$list['adm_id']]['adm_lastname'] = $list['adm_lastname'];
                $staff_list[$list['adm_id']]['adm_email'] = $list['adm_email'];
                $staff_list[$list['adm_id']]['phone_no'] = $list['phone_no'];
				 $staff_list[$list['adm_id']]['user_role'] = $list['user_role'];
                $staff_list[$list['adm_id']]['status'] = $list['status'];
            }
            $json = "";
                    foreach($staff_list as $row)
                    {
                       	$status_image	=	($row['status'] == STATUS_ACTIVE)?'active.png':'inactive.png';
                        $title			=	($row['status'] == STATUS_ACTIVE)?'Change&nbsp;Inactive':'Change&nbsp;Active';
                        $json .= '[
                            "'.$row['adm_id'].'",
                            "'.ucfirst($row['adm_firstname']).'",
							 "'.(ucfirst($row['adm_lastname']=='')?'---': ucfirst($row["adm_lastname"])).'",
							"'.(($row['adm_email']=='')?'---': $row["adm_email"]).'",
                            "'.$row['phone_no'].'",
							 "'.ucfirst($row['user_role']).'",
                            "<img style=\"cursor:pointer;\" onClick=\"change_status('.$row['adm_id'].',this);\" src=\"'.base_url().'assets/images/'.$status_image.'\" title=\"'.$title.'\">",
                            "<div class=\"btn-group\"><a href=\"'.base_url().'user_management/edit_staff/'.base64_encode($row['adm_id']).'\" class=\"btn btn-mini btn-info\" type=\"button\" title=\"Edit\"><i class=\"icon-edit bigger-120\"></i></a><button type=\"button\" style=\"cursor:pointer;\" onClick=\"delete_item('.$row['adm_id'].',this);\" class=\"btn btn-mini btn-danger\" title=\"Delete\"><i class=\"icon-trash bigger-120\"></i></button></div>"
                        ],';
                    }
					
        echo '{ 
                    "recordsTotal": '.count($staff_list).',
                "data":[ 
                        '.rtrim($json,",").']}';
            exit;
    }
	public function create_staff() // create new staff details
	{
		$this->data['menu'] = 'user_management';
		$this->form_validation->set_rules('s_id','Staff','trim');
		if($this->form_validation->run()==TRUE)
		{
           $this->staff_model->create_staff(); // call model function to insert all staff details
           $this->session->set_flashdata('message','Staff details has been inserted successfully.');
           redirect('user_management');
		}
		else
		$this->load->view('user_management/create_staff',$this->data);
	}

    public function edit_staff($staff_id) // edit the existing staff details
	{
			$staff_id = base64_decode($staff_id);
			$this->data['staff_details'] = $this->staff_model->get_staff_details($staff_id);
           

            // form validation
			$this->form_validation->set_rules('s_id','Staff','trim');
			if($this->form_validation->run() == TRUE)
			{
				$permissions = implode(',',$this->input->post('permissions'));
				$customer_details = array(
										'adm_firstname' => strip_tags($this->input->post('staff_firstname')),
										'adm_password' => $this->encrypt->encode($this->input->post('password')),
										'adm_email' =>($this->input->post('email_id')) ? $this->input->post('email_id')  : NULL,
										'phone_no' => $this->input->post('phone_no'),
										'user_role' => $this->input->post('user_role'),
										'permissions'=>($permissions) ? $permissions : NULL,
										'modified'=>date('Y-m-d H:i:s')									
									);			
				$this->db->where('adm_id',$staff_id);
				$this->db->update('admin',$customer_details); // update the staff details
                
                $notes = "The following staff id #".$staff_id." details has been modified by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                
				$this->session->set_flashdata('message','Staff details has been updated successfully.'); 
				redirect('user_management');
		}
			$this->data['menu']='user_management';
			$this->load->view('user_management/edit_staff',$this->data);
	}

    public function change_status() //change the staff status active or inactive
	{
			$status = 'inactive';
			$staff_id = $this->input->post('staff_id');		
			$item = $this->staff_model->get_staff_details($staff_id);
			if($item['status'] == 'inactive')
			{
				$status = 'active';
			}
			$this->db->where('adm_id',$staff_id);
			$this->db->update('admin',array( 'status' => $status ));
            
         $notes =  "The following staff id #".$staff_id." status(".$status.") has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
            $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
			echo $status;
	}
	
	public function delete_item() // delete the staff details
	{
			$staff_id = $this->input->post('staff_id');
			$this->db->where('adm_id',$staff_id);
			$this->db->update('admin',array('status'=>STATUS_DELETED));
        
            $notes =  "The following staff id #".$staff_id." status(deleted) has been changed by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
            $notes_arr = array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=> date('Y-m-d H:i:s')
            );
			$this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
	}
    public function ajax_check_username_exists_or_not() // using ajax to all check username is already exists or not in admin table
    {
        $username = $this->input->post('username');
        
        $this->db->where('adm_username',$username);
        $this->db->where('status !=',STATUS_DELETED);
        $qry = $this->db->get('admin');
        if($qry->num_rows() > 0)
         echo 'exists';
        else
         echo 'not exists';
    }
    public function ajax_check_email_exists_or_not() // using ajax to all check email id is already exists or not in admin table
    {
        $email = $this->input->post('email_id');
        $this->db->where('adm_email',$email);
        $this->db->where('status !=',STATUS_DELETED);
        $qry = $this->db->get('admin');
        if($qry->num_rows() > 0)
         echo 'exists';
        else
         echo 'not exists';
    }
	 public function check_email_exists_or_not() // using ajax to all check email id is already exists or not in admin table for edit staff details
    {
      $adm_id = $this->input->post('staff_id');
	  $email = $this->input->post('email_id');
      $this->db->where('adm_email',$email);
      $this->db->where('status !=',STATUS_DELETED);
	  $this->db->where('adm_id !=',$adm_id);
      $login = $this->db->get('admin');
	  if($login->num_rows() > 0)
      echo 'exists';
      else
      echo 'not exists';
    }
    
}
?>
