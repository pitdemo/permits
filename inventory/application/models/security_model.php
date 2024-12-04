<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : security_model
 * Project	      : Accounting Software
 * Creation Date  : 28.05.2015
 * Author         : K.Panneer Selvam
 * Description    : 
*********************************************************************************************/	
class Security_model extends  CI_Model {
	
	/**
	 * Constructor
	 */	
	function __construct()
	{
		parent::__construct();
		
	}
	public function chk_admin_login()
	{
		if(!$this->session->userdata('user_id') && !$this->session->userdata('appname')=='accounting')
		{
			echo '<script type="text/javascript">window.top.location.href="'.base_url().'";</script>';
			return false;
		}
		else
		return TRUE;
	}

	public function get_admin_details()
	{
		$this->db->select('*')->from('eol_admin');
		$admin_query = $this->db->get();
		if($admin_query->num_rows() != 0)
		{
			return $admin_query->row_array();
		}
		else
		{
			return false;
		}
	}
	public function admin_logo()
	{
		$this->db->select('adm_logo')->from('img_admin');
		$logo_query = $this->db->get();
		if($logo_query->num_rows() != 0)
		{
			$admin = $logo_query->row_array();
			//define('ADMIN_LOGO','assets/images/'.$admin['adm_logo']);
		}
	}
	public function check_session()
	{
		if($this->session->userdata('user_id'))
		{
			redirect('items');
		}
		else
		{
			return true;
		}
		
	}


//send_forget_email_message
	function send_forget_email_message($username)
	{
		$get_row=$this->db->query("select * from admin where adm_username = '".$username."'");
		
		$get_row_value=$get_row->row_array();
		
		$staff_data['first_name'] = $get_row_value['adm_firstname'];
		$staff_data['username'] = $get_row_value['adm_username'];
		$staff_data['email_id'] = $get_row_value['adm_email'];
		//$staff_data['password'] = $this->encrypt->decode($get_row_value['adm_password']);
		$staff_data['id'] =  base64_encode($get_row_value['adm_id']);
		$email_body =$this->load->view('send_forget_password', $staff_data, true);
	    $email_subject = 'Accounting Software Forget Password';
		 
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		//// mail to user ///////////
		$this->email->from('mahendra@galaxyweblinks.com');
		$this->email->to('mahendra@galaxyweblinks.com');
		$this->email->subject($email_subject);
		$this->email->message($email_body);
		//print_r($email_body);exit;
		$this->email->send();
		return true;
	}
	
	//Check Login by using Email 
	function chk_login($username)
	{
		$this->db->select('*')->from('admin');
		$this->db->where('adm_username',$username);
		//$this->db->where('status !=','2');
		$query = $this->db->get();
		//echo $this->db->last_query(); exit;
		return $query->row_array();
	}
}
?>