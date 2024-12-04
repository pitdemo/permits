<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : staff_model.pph
 * Project        : Accounting Software
 * Creation Date  : 29-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage Staff
*********************************************************************************************/	
class Staff_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
	
	public function create_staff() //insert user details into admin table
	{
        $staff_firstname = $this->input->post('staff_firstname');
        $staff_lastname = $this->input->post('staff_lastname');
        $user_name = $this->input->post('user_name');
        $password =$this->input->post('password');
		 $user_role =$this->input->post('user_role');
        $email_id = $this->input->post('email_id');
        $phone_no = $this->input->post('phone_no');
		$permissions = implode(',',$this->input->post('permissions'));
        $ids = ''; // concatenate all the staff id for stroed into notes table
		     $insert_details = array(
                            'adm_firstname'=>$staff_firstname,
                            'adm_lastname'=>$staff_lastname,
                            'adm_username'=>$user_name,
                            'adm_password'=> $this->encrypt->encode($password),
							'user_role'=>$user_role,
                            'adm_email'=>($email_id) ? $email_id : NULL,
                            'phone_no'=>$phone_no,
							'permissions'=>($permissions) ? $permissions : NULL,
                            'status'=>'active',
                            'created_date'=>date('Y-m-d H:i:s')
                        );
                $this->db->insert('admin',$insert_details);  // insert into Staff table
                $staff_id = $this->db->insert_id();
                $ids .="#".$staff_id.",";
				
                $this->load->model('notes_model');
        $notes = "The following ".rtrim($ids,",")." staff id details have been added manually by ".$this->session->userdata('session_username')." on ".date('Y-m-d H:i:s')." using ".$_SERVER['REMOTE_ADDR'];
                 $notes_arr = array(
                    'user_id'=>$this->session->userdata('user_id'),
                    'notes'=>$notes,
                    'created'=> date('Y-m-d H:i:s')
                );
                $this->notes_model->insert_notes($notes_arr); //insert log notes to track all the changes
        
	}
	public function get_staff_details($staff_id=NULL) // get staff details
	{
			$this->db->where('adm_id',$staff_id);
			$qry=$this->db->get('admin');
			if($qry->num_rows()>0)
				return $qry->row_array();
	}
	public function get_staff_lists() // get all staff list from 'admin' table except status deleted
	{
        $logged_user=$this->session->userdata('session_username');
		$user_role = unserialize(USER_ROLES); // USER_ROLES is defined in constants.php file
        $this->db->select('*');
        $this->db->from('admin');
		$this->db->where("adm_id !=", 1); // $user_role[1] is staff
		$this->db->where("adm_username !=",$logged_user); 
		$this->db->where('status !=', STATUS_DELETED);
        $this->db->order_by('adm_id','desc');
        $qry = $this->db->get();
            return $qry->result_array();
	}
	
}
?>