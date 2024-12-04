<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**********************************************************************************************
 * Filename       : Setting
 * Project        : Accounting Software
 * Creation Date  : 28.05.2015
 * Author         : K.Panneer selvam
 * Description    : settings
*********************************************************************************************/	
class Setting extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('security_model')); // load model  	
		$this->security_model->chk_admin_login();
	}
	
	public function change_password()
	{
		
		$this->form_validation->set_rules('current_password','Current Password','trim|callback_chk_password|required');  
		$this->form_validation->set_rules('new_password','New Password','trim|required');  
		$this->form_validation->set_rules('retype_password','Confirm Password','trim|required|matches[new_password]'); 
		$this->form_validation->set_message('matches', 'Password should be same.');
		$this->form_validation->set_error_delimiters('<div class="error_msg">', '</div>');	 
		
		
	   if($this->form_validation->run())
		{ 
			$admin_id = $this->session->userdata('user_id');
			$this->db->where('adm_id',$admin_id);
			$this->db->update('admin',array('adm_password'=>$this->encrypt->encode($this->input->post('new_password'))));
			$this->session->set_flashdata('message','Password Successfully Changed');
			redirect('setting/change_password');
		}
		
		$this->data['menu'] = "";
		$this->load->view('change_password',$this->data);
	}
	
	function chk_password()
	{
		
		$old_password = $this->input->post('current_password'); 
		$chk_password = 0;
		$this->db->select('adm_id,adm_username,adm_email,adm_password')->from('admin');
		$this->db->where('adm_id',$this->session->userdata('user_id'));
		$admin_query = $this->db->get();
		$admin_detail = $admin_query->row_array();
		
		if($this->encrypt->decode($admin_detail['adm_password']) == $old_password)
		{
			$chk_password = 1;
		}
		
		
		if( $chk_password == 0 )
		{
			$this->form_validation->set_message('chk_password', "Old Password is not correct");
			return FALSE;
		}
		
		return TRUE;
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url(''));
	}
}