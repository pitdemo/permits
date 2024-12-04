<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**********************************************************************************************
 * Filename       : login
 * Project        : Accounting Software
 * Creation Date  : 28.05.2015
 * Author         : K.Panneer selvam
 * Description    : login process
*********************************************************************************************/	
class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','session','encrypt','email','pagination')); 
		$this->load->model(array('security_model','notes_model')); // load modle files here
	}
	public function index() // this function used to load login form and check user login details(username and password)
	{
		$this->security_model->check_session(); // check session and redirect the url if session exist
		$this->form_validation->set_rules('username','Username','trim|required');
		$this->form_validation->set_rules('password','Password','trim|required|callback_chk_password');
		$this->form_validation->set_error_delimiters('<div class="error_msg">', '</div>');	
		if($this->form_validation->run())
		{
			$this->db->select('adm_id,adm_email,adm_firstname,adm_lastname,adm_username,adm_password,user_role,status,permissions')->from('admin')->where(array('adm_username' => $this->input->post('username')));
			$login = $this->db->get();

		#	echo $this->db->last_query(); exit;
			if($login->num_rows() == 1)
			{
				$login_details = $login->row_array();

				#echo 'AA '.$this->encrypt->decode($login_details['adm_password']).' == '.$this->input->post('password'); exit;
			    
			  	if($this->encrypt->decode($login_details['adm_password']) == $this->input->post('password'))
				{
					if($login_details['status']==STATUS_ACTIVE)
					{
					
					$this->db->where('adm_id',$login_details['adm_id']);
					$this->db->update('admin',array('last_login' => date('Y-m-d h:i:s')));
                    
                    // set session
					$session_variables = array(
                                      'user_id' => $login_details['adm_id'],
                                      'session_fstname' => $login_details['adm_firstname'],
                                      'session_lstname' => $login_details['adm_lastname'],
                                      'session_username' => $login_details['adm_username'],
                                      'session_email' => $login_details['adm_email'],
                                      'session_user_type' => $login_details['user_role'],
									  'session_permissions' =>$login_details['permissions'],
									  'appname'=>'accounting'
									 
				            );	
								
										 			  
					$this->session->set_userdata($session_variables);
					//print_r($this->session->userdata('session_permissions'));exit;
                    $notes = $this->session->userdata('session_username')." "."has successfully logged  on ".date('Y-m-d H:i:s')." "."using ".$_SERVER['REMOTE_ADDR'];
                    $notes_arr = array(
                        'user_id'=>$this->session->userdata('user_id'),
                        'notes'=>$notes,
                        'created'=> date('Y-m-d H:i:s')
                    );
                    $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
                    
					redirect('items'); // if user details are correct and redirect to item module
				 }
				 else
				 {
					 $this->session->set_flashdata('error','Your Account has been deactivated/deleted, Please Contact Your Admin.');
					redirect(base_url(''));
					exit;
				 }
				 
				}
			}
			
			
			else
			{
				$this->session->set_flashdata('error','Please enter correct Username/Password.');
				redirect(base_url(''));
				exit;
			}
	
		}
		$this->load->view('login');
	}
	public function chk_password() // callback function to check password details valid or not
	{				
		$this->db->select('adm_id,adm_email,adm_firstname,adm_password')->from('admin')->where(array('adm_username' => $this->input->post('username')));
		$login = $this->db->get();
		if($login->num_rows() == 1)
		{
			$login_details = $login->row_array();

			#echo '### '.$this->encrypt->decode('LaLByYKS9FPwPAPXuXLUufI2mYW7Sp+VFx2gegV4MxGlZgs/SDdFDil0a67xGCN9m1vDUfmgoEAuydZbYdO2sA==').' == '.$this->input->post('password'); exit;
		  	if($this->encrypt->decode($login_details['adm_password']) == $this->input->post('password'))
		  	{
				return true;
			}
			else
			{
				$this->form_validation->set_message('chk_password', "Please enter correct password");
		 		return false;
			}
		}
	}
	
	//forget password
	function forget_password()
	{
		$this->form_validation->set_rules('email_id', 'Username', 'trim|required|callback_forget_email_check');	
		 
		$this->form_validation->set_error_delimiters('<div class="error_msg">', '</div>');	
		
		if($this->form_validation->run() == TRUE)
		{
			
			$username=$this->input->post('email_id');
			if($this->security_model->send_forget_email_message($username))
			{
				
				redirect('login/forget_password_send');
			}
		}
		$this->load->view('forget_password');
	}
	
	//Email checking for server side validation for regitering
	public function forget_email_check()
	{
	    $username = $this->input->post('email_id');
		
		$chk_login = $this->security_model->chk_login($username);
		//print_r($chk_login);exit;
		
		if( count($chk_login) == 0 )
		{
			$this->form_validation->set_message('forget_email_check', "Username does not exists");
			
			return FALSE;
		}
		elseif($chk_login['status']== 'delete' )
		{
			$this->form_validation->set_message('forget_email_check', "Your account has been deleted");
			
			return FALSE;
		}
		elseif($chk_login['status']== 'inactive' )
		{
			$this->form_validation->set_message('forget_email_check', "Your account has been inactive");
			
			return FALSE;
		}
		
		return TRUE;
	}
	
	function forget_password_send()
	{
		$this->load->view('forget_password_send');	
	}
	
	//reset password
	function reset_password($id)
	{
		
	{
		$base_64 = base64_decode($id);
		$id = rtrim($base_64, '=');
		$this->form_validation->set_rules('new_password','New Password','trim|required');  
		$this->form_validation->set_rules('retype_password','Confirm Password','trim|required|matches[new_password]'); 
		$this->form_validation->set_message('matches', 'Password should be same.');
		$this->form_validation->set_error_delimiters('<div class="error_msg">', '</div>');	 
		
		
	   if($this->form_validation->run())
		{ 
			$this->db->where('adm_id',$id);
			$this->db->update('admin',array('adm_password'=>$this->encrypt->encode($this->input->post('new_password'))));
			$this->session->set_flashdata('message','Password has been changed successfully');
			redirect("login");
		}
		
		$this->load->view('reset_password');
	}
	}
}